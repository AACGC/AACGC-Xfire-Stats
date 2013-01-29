if ($pref['xfirestats_enable_profiles'] == "1"){

global $sql,$sql2,$user; 

$suser = "";
$USER_ID = "";


$url = $_SERVER["REQUEST_URI"];
$suser = explode(".", $url);
	if ($suser[1] == 'php?id') {
	$suser = $suser[2];}

$SUSER_ID = $suser;

if (USER){


$sql ->db_Select("user_extended", "*", "WHERE user_extended_id='".intval($SUSER_ID)."'", "");
$row = $sql->db_Fetch();

$xfireusername = "".$row['user_xfire']."";

error_reporting( E_ERROR );

$username = "".$xfireusername."";

include "xfireparser.class.php";
$x = new xfire_data;
$x->SetUsername( $username );
$rig = $x->GetGamerig();

//--------------------------------------------------------------

$xfiregrig .= "<script src='sorttable.js' type='text/javascript'></script>";

$xfiregrig .= "<tr>
          <td style='width:100%' class='forumheader3' colspan=2><center>".$siteusername."'s Gaming Rig</center></td>
          </tr>";

foreach( $rig as $rigk => $rigv ) { 

$xfiregrig .= "<tr>
          <td style='width:25%' class='forumheader3'><b>".$rigk.":</b></td>
          <td style='width:75%' class='indent'>".$rigv."</td>
          </tr>";}

return "".$xfiregrig."";

}}