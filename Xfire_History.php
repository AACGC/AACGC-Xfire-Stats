<?php

/*
#######################################
#     AACGC Xfire Stats               #                
#     by M@CH!N3                      #
#     http://www.AACGC.com            #
#######################################
*/


//-----------------------------------#Main Page Config#------------------------------------------------------
require_once("../../class2.php");
require_once(HEADERF);
if (e_QUERY) {
        $tmp = explode('.', e_QUERY);
        $action = $tmp[0];
        $sub_action = $tmp[1];
        $id = $tmp[2];
        unset($tmp);
}
include_lan(e_PLUGIN."aacgc_xfirestats/languages/".e_LANGUAGE.".php");

//-----------------------------------------------------------------------------------------------------------
$text .= "<center>[ <a href='".e_PLUGIN."aacgc_xfirestats/Xfire_List.php'>".XF_14."</a> ]<br>";

$sql ->db_Select("user_extended", "*", "user_extended_id='".intval($sub_action)."'");
$row = $sql->db_Fetch();
$sql2 = new db;
$sql2 ->db_Select("user", "*", "user_id='".intval($row['user_extended_id'])."'");
$row2 = $sql2->db_Fetch();

$xfireusername = "".$row['user_xfire']."";
$siteusername = "".$row2['user_name']."";
//-----------------------

error_reporting( E_ERROR );

$username = "".$xfireusername."";

include "xfireparser.class.php";
$x = new xfire_data;
$x->SetUsername( $username );

$profile = $x->GetProfile();
$live = $x->GetLive();
$gametime = $x->GetGamedata();
$rig = $x->GetGamerig();

//-----------------------

$text .= "<script src='sorttable.js' type='text/javascript'></script>";


$text .= "<table style='width:95%' class='indent'>";

$text .= "<tr>";

$text .= "<td style='width:25%' class='forumheader3' rowspan=8><center><img src='".$profile['avatar']."' alt='Avatar'></img> <br> ".$siteusername."'s (".$xfireusername.") <br> ".XF_01."</center></td>";

$text .= "<td style='width:15%' class='forumheader3'>".XF_02.":</td>
          <td style='width:60%' class='forumheader3'>".$profile['status']."</td>";

$text .= "</tr>";

$text .= "<tr>
          <td class='forumheader3'>".XF_03.":</td>
          <td class='forumheader3'>".$profile['joindate']."</td>
          </tr>";

$text .= "<tr>
          <td class='forumheader3'>".XF_04.":</td>
          <td class='forumheader3'>".$profile['nickname']."</td>
          </tr>";

$text .= "<tr>
          <td class='forumheader3'>".XF_05.":</td>
          <td class='forumheader3'><img src='http://media.xfire.com/images/flags/".$profile['country'].".gif' alt='".$profile['country']."' /></td>
          </tr>";


$text .= "<tr>
          <td class='forumheader3'>".XF_06.":</td>
          <td class='forumheader3'>".$profile['age']."</td>
          </tr>";

$text .= "<tr>
          <td class='forumheader3'>".XF_07.":</td>
          <td class='forumheader3'>".$profile['gaming_style']."</td>
          </tr>";

if ($profile['gender'] == "m")
{$gen = "".XF_08."";}
if ($profile['gender'] == "f")
{$gen = "".XF_09."";}

$text .= "<tr>
          <td class='forumheader3'>".XF_10.":</td>
          <td class='forumheader3'>".$gen."</td>
          </tr>";


$text .= "<tr>
          <td class='forumheader3'>".XF_11.":</td>
          <td class='forumheader3'>".$profile['friends_count']."</td>
          </tr>";

$text .= "</table><br>";

//-------------------------------------------------------------------------------------------------------
/*
$text .= "<div style='width:100%; height:500px; overflow:auto'><table style='width:95%' class='indent'>";

$text .= "<tr><td class='forumheader3' colspan=3><center>Gaming History</center></td></tr>";

$text .= "<tr>
          <td style='width:50%' class='forumheader3'>Game</td>
          <td style='width:25%' class='forumheader3'>Last 7 Days</td>
          <td style='width:25%' class='forumheader3'>All Time</td>
          </tr>";

$xgame = 1;

//foreach($gametime as $k => $v){

foreach($gametime as $v){

$text .= "<tr>
          <td style='text-align:left' class='indent'><img src='http://xfireimg.com/xfire/xf/images/icons/".$v['shortname'].".gif' alt='' height='20' />".$v['longname']."</td>";


$weektime = $v["weektime"];
$rweekhrs = round( $v["weektime"] / 3600 );
$totalw += $weektime;
if( $weektime == 0 )
{$week = "-";}
elseif( $rweekhrs < 1 )
{$week = "Less Than 1 Hour";}
else
{$week = "".$rweekhrs." hours";}

$text .= "<td style='text-align:left' class='indent'>".$week."</td>";


$alltime = $v["alltime"];
$allhrs = round( $v["alltime"] / 3600 );
$totala += $alltime;
if( $alltime == 0 )
{$totalgametime = "-";}
elseif( $allhrs < 1 )
{$totalgametime = "Less Than 1 hour";}
else
{$totalgametime = "".$allhrs." hours";}

$text .= "<td style='text-align:left' class='indent'>".$totalgametime."</td>";



$text .= "</tr>";}

$text .= "</table></div><br>";


$text .= "<table style='width:95%' class=''>";

$totalwhrs = round( $totalw / 3600 );
if( $totalw == 0 )
{$overallweek = "-";}
elseif( $totalwhrs < 1 )
{$overallweek = "Less Than 1 hour";}
else
{$overallweek = "".$totalwhrs." hours";}

$totalahrs = round( $totala / 3600 );
if( $totala == 0 )
{$overall = "-";}
elseif( $totalahrs < 1 )
{$overall = "Less Than 1 hour";}
else
{$overall = "".$totalahrs." hours";}


$text .= "<tr>
          <td style='width:50%' class='forumheader3'><b>Overall Hours:</b></td>
          <td style='width:25%' class='forumheader3'>".$overallweek."</td>
          <td style='width:25%' class='forumheader3'>".$overall."</td>
          </tr>";

$text .= "</table><br><br>";
*/
//-----------------------------------------------------------------------------------------------------------
$text .= "<table style='width:95%' class='indent'>";

$text .= "<tr>
          <td style='width:100%' class='forumheader3' colspan=2><center>".XF_12."</td>
          </tr>";

foreach( $rig as $rigk => $rigv ) { 

$text .= "<tr>
          <td style='width:25%' class='forumheader3'><b>".$rigk.":</b></td>
          <td style='width:75%; text-align:left' class='indent'>".$rigv."</td>
          </tr>";}

$text .= "</table></center>";
//-----------------------------------------------------------------------------------------------------------
$ns -> tablerender("".XF_13."", $text);
require_once(FOOTERF);

?>