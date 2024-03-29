<?php

/*
#######################################
#     e107 website system plguin      #
#     AACGC Xfire Stats               #    
#     by M@CH!N3                      #
#     http://www.AACGC.com            #
#######################################
*/

define( "XFIREXML_KEEPTIME", 15 ); // how long to keep downloaded data before grabbing a new copy.
define( "XFIREXML_USERAGENT", "Xfire-PHP (Mozilla/5.0 compatible" ); // the "browser" we are downloading from

class xfire_data {

	var $user; // stores the currently used nickname
	var $compatibility; // compatibility mode
	var $type; // holds what type of feed is being parsed
	var $read_xml; // xml parser object
	var $xml_storage = array(); // stored data
	var $data = array(); // CXS backwards compatibility
	
	function SetUsername( $user )
	{
		$this->username = $user;
	}

	function SetCompatibilityMode( $compat )
	{
		$this->compatibility = $compat;
	}


	function GetProfile( ) // profile
	{
		return $this->ParseFeed( "profile" );
	}
	
	function GetFriends( ) // friends
	{
		return $this->ParseFeed( "friends" );
	}
	
	function GetLive( ) // live
	{
		return $this->ParseFeed( "live" );
	}

	function GetGamedata( ) // gameplay
	{
		return $this->ParseFeed( "gameplay" );
	}
	
	function GetServers( ) // servers
	{
		return $this->ParseFeed( "servers" );
	}

	function GetScreenshots( ) // screenshots
	{
		return $this->ParseFeed( "screenshots" );
	}
	
	function GetGamerig( ) // gamerig
	{
		return $this->ParseFeed( "gamerig" );
	}
	
	// CXS backwards compatibility
	function xfire_data( $username )
	{
		$this->username = $username;
		$this->compatibility = true;
		$this->load();
	}
	
	function load( )
	{
		$opt = array();
		$opt["profile"] = array_merge( $this->GetLive(), $this->GetProfile() );
		$opt["games"] = $this->GetGamedata();
		$opt["servers"] = $this->GetServers();
		
		if( $this->compatibility == true ) // use old array indexes
		{
			$opt["profile"]["rname"] = $opt["profile"]["realname"];
			$opt["profile"]["regsince"] = $opt["profile"]["joindate"];
			$opt["profile"]["about"] = $opt["profile"]["bio"];
			
			unset( $opt["profile"]["realname"] );
			unset( $opt["profile"]["joindate"] );
			unset( $opt["profile"]["bio"] );
			
			foreach( $opt["games"] as $k => $v )
			{
				$opt["games"][ $k ][ "name" ] = $opt["games"][ $k ][ "longname" ];
				$opt["games"][ $k ][ "icon" ] = $opt["games"][ $k ][ "shortname" ];
				
				unset( $opt["games"][ $k ][ "longname" ] );
				unset( $opt["games"][ $k ][ "shortname" ] );
			}
			
			$this->data = $opt;
			return;
		}

		return $opt;
	}
	
	// the code below is writting by Madwormer (Jason Reading) for CXS
	// IT IS DESIGNED TO BE USED WITH COMPATIBILITY MODE
    function parseData($type){
		
		if( $this->compatibility == false )
		{
			echo "<span style=\"color: #FF0000\">Cannot call parseData without compatibility mode</span>";
			return;
		}
		
		switch ($type)
		{
			case 'alltime':
				// Obtain a list of columns
				foreach ($this->data['games'] as $key => $row)
				{
					$nm[$key] = $row['name'];
					$tw[$key] = $row['thisweek'];
					$at[$key] = $row['alltime'];
					$ic[$key] = $row['icon'];		
				}
				// Sort the data with volume descending, edition ascending
				// Add $data as the last parameter, to sort by the common key
				array_multisort($at, SORT_DESC, $this->data['games']);
				return $this->data['games'][0];
			break;
			case 'thisweek':
				// Obtain a list of columns
				foreach ($this->data['games'] as $key => $row)
				{
					$nm[$key] = $row['name'];
					$tw[$key] = $row['thisweek'];
					$at[$key] = $row['alltime'];
					$ic[$key] = $row['icon'];
				}
				// Sort the data with volume descending, edition ascending
				// Add $data as the last parameter, to sort by the common key
				array_multisort($tw, SORT_DESC, $this->data['games']);
				return $this->data['games'][0];
			break;
		}
	} 
	
	
	// the functions below should be left alone, unless you know exactly what you're doing
	// these are used to download data and parse it into a usable format
	function XML_StartTag( $parser, $tag, $params )
	{	
		if( $tag == "XFIRE" ) { return; }
		
		switch( $this->type )
		{
			case "screenshots":
			case "servers":
			case "friends":
			
				if( $tag != "SCREENSHOTS" && $tag != "SERVER" && $tag != "FRIEND" )
				{
					$this->xml_storage[ $this->username ][ $this->type ][ "current_tag" ] = strtolower( $tag );
					
					if( $params )
					{
						$no = $this->xml_storage[ $this->username ][ $this->type ][ "no" ];
						$ctag = $this->xml_storage[ $this->username ][ $this->type ][ "current_tag" ];
						
						foreach( $params as $k => $v )
						{
							$this->xml_storage[ $this->username ][ $this->type ][ $no ][ $ctag . "_" . strtolower( $k ) ] = $v;
						}
					}
				}
				break;
				
			case "gameplay":
				if( $tag == "GAME" )
				{
					$this->xml_storage[ $this->username ][ $this->type ][ "current_gid" ] = $params[ "ID" ];
				}
				else
				{
					$this->xml_storage[ $this->username ][ $this->type ][ "current_tag" ] = strtolower( $tag );
				}
				break;			
			
			case "profile":
			case "gamerig":
			case "live":
			default: // will be for profile
				$this->xml_storage[ $this->username ][ $this->type ][ "current_tag" ] = strtolower( $tag );
		}
	}
	
	function XML_EndTag( $parser, $tag )
	{
		switch( $this->type )
		{
			case "screenshots":
			case "servers":
			case "friends":
			
				if( $tag == "SCREENSHOT" || $tag == "SERVER" || $tag == "FRIEND" )
				{
					$this->xml_storage[ $this->username ][ $this->type ][ "no" ] = $this->xml_storage[ $this->username ][ $this->type ][ "no" ]+1;
				}
				break;
				
			default: // nothing
		}	
	}
	
	function XML_CharData( $parser, $data )
	{
		$data = str_replace( array( "\t", "\n" ), "", $data );
		if( ( empty( $data ) || $data == "" || strlen( $data ) < 1 ) && !is_numeric( $data ) ) { return; }

		switch( $this->type )
		{
			case "screenshots":
			case "servers":
			case "friends":
				$no = $this->xml_storage[ $this->username ][ $this->type ][ "no" ];
				$ctag = $this->xml_storage[ $this->username ][ $this->type ][ "current_tag" ];
				$this->xml_storage[ $this->username ][ $this->type ][ $no ][ $ctag ] .= $data;
				break;
				
			case "gameplay":
				$gid = $this->xml_storage[ $this->username ][ $this->type ][ "current_gid" ];
				$ctag = $this->xml_storage[ $this->username ][ $this->type ][ "current_tag" ];
				$this->xml_storage[ $this->username ][ $this->type ][ $gid ][ $ctag ] .= $data;
				break;
			
			case "profile":
			case "gamerig":
			case "live":
			default: // will be for profile
				$this->xml_storage[ $this->username ][ $this->type ][ $this->xml_storage[ $this->username ][ $this->type ][ "current_tag" ] ] .= $data;
		}	
	}
	
	function DownloadFeed( $type )
	{
		$fp = curl_init(); // we use curl for this
		$download_url = "http://www.xfire.com/xml/" . $this->username . "/". $type . "/"; // construct the download url
		
		curl_setopt( $fp, CURLOPT_URL, $download_url ); // set the url
		curl_setopt( $fp, CURLOPT_HEADER, 0 ); // do not include the header in the downloaded content
		curl_setopt( $fp, CURLOPT_RETURNTRANSFER, true ); // yes....
		curl_setopt( $fp, CURLOPT_USERAGENT, XFIREXML_USERAGENT ); // we need this so we don't get firewalled

		$xml = curl_exec( $fp ); // get what we need
		curl_close( $fp ); // close the handle

		
		if( $h = fopen( "".e_PLUGIN."aacgc_xfirestats/xfire_cache/".$this->username."_".$type.".xml", "w" ) ) // can we write?
		{

			fwrite( $h, $xml ); // yes we can
			fclose( $h );

		}
		else
		{
			die( "Unable to create file handle. Make sure the file is writable." ); // no we can't
		}
	
	}
	
	function ParseFeed( $type )
	{
		if( empty( $this->xml_storage[ $this->username ][ $type ] ) )
		{
			// we're using XML Caching
			$timenow = date( "U" ); // time now

			if( file_exists( "".e_PLUGIN."aacgc_xfirestats/xfire_cache/" . $this->username . "_" . $type . ".xml" ) == true ) // check file exists.
			{
				if( $timenow > ( filemtime( "xfire_cache/" . $this->username . "_" . $type . ".xml" ) + ( XFIREXML_KEEPTIME * 60 ) ) ) // new download x minutes
				{
					$this->DownloadFeed( $type ); // we need to download
				}
			}
			else
			{
				$this->DownloadFeed( $type ); // yeah we really need to download
			}	
			
			$this->type = $type;
			
			$this->xml_storage[ $this->username ][ $this->type ][ "no" ] = 0;
			$this->read_xml = xml_parser_create();
			xml_set_object( $this->read_xml, $this );
			xml_set_element_handler( $this->read_xml, "XML_StartTag", "XML_EndTag" );
			xml_set_character_data_handler( $this->read_xml, "XML_CharData" ); 
			xml_parse( $this->read_xml, file_get_contents( "".e_PLUGIN."aacgc_xfirestats/xfire_cache/" . $this->username . "_" . $type . ".xml" ) );
			xml_parser_free( $this->read_xml ); 
		}
		
		unset( $this->xml_storage[ $this->username ][ $this->type ][ "no" ] );
		unset( $this->xml_storage[ $this->username ][ $this->type ][ "current_tag" ] );
		unset( $this->xml_storage[ $this->username ][ $this->type ][ "current_gid" ] );
		return $this->xml_storage[ $this->username ][ $this->type ];
	}
	
	
}

// LEGACY FUNCTIONS BELOW, FOR USE WITH OLD SCRIPTS (WITH MINOR CHANGES)

function xfire_getmain( $username )
{
	global $x;
	
	if( !$x )
	{
		$x = new xfire_data;
	}
	
	$x->SetUsername( $username );
	$x->SetCompatibilityMode( false );
	return $x->load();
}


function xfire_getfriends( $username )
{
	global $x;
	
	if( !$x )
	{
		$x = new xfire_data;
	}
	
	$x->SetUsername( $username );
	$x->SetCompatibilityMode( false );
	return $x->GetFriends();
}

function xfire_getscreens( $username )
{
	global $x;
	
	if( !$x )
	{
		$x = new xfire_data;
	}
	
	$x->SetUsername( $username );
	$x->SetCompatibilityMode( false );
	return $x->GetScreenshots();
}

?>