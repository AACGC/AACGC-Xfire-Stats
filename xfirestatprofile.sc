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


//----------------------------------------------------------------

$sql->db_Select("user_extended", "*", "WHERE user_extended_id='".intval($SUSER_ID)."'", "");
$row = $sql->db_Fetch();

if ($pref['xf_skin'] == "Xfire Default"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/bg/type/0/".$row['user_xfire'].".png' width='440' height='111' /></a>";}

if ($pref['xf_skin'] == "Sci-fi"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/sf/type/0/".$row['user_xfire'].".png' width='440' height='111' /></a>";}

if ($pref['xf_skin'] == "Shadow"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/sh/type/0/".$row['user_xfire'].".png' width='440' height='111' /></a>";}

if ($pref['xf_skin'] == "Combat"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/co/type/0/".$row['user_xfire'].".png' width='440' height='111' /></a>";}

if ($pref['xf_skin'] == "Fantasy"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/os/type/0/".$row['user_xfire'].".png' width='440' height='111' /></a>";}


if ($row['user_xfire'] == ""){}         

else

{$xfireprofile = "<tr><td class='forumheader3' colspan='2'>".$xfireskin."</td></tr>";}}


return "".$xfireprofile."";

}
