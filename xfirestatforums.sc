if ($pref['xfirestats_enable_forums'] == "1"){

global $post_info, $sql;

$postowner  = $post_info['user_id'];



$sql->db_Select("user_extended", "*", "WHERE user_extended_id='".intval($postowner)."' LIMIT 0,1", "");
$row = $sql->db_Fetch();

if ($pref['xf_skin'] == "Xfire Default"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/bg/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}

if ($pref['xf_skin'] == "Sci-fi"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/sf/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}

if ($pref['xf_skin'] == "Shadow"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/sh/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}

if ($pref['xf_skin'] == "Combat"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/co/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}

if ($pref['xf_skin'] == "Fantasy"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/os/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}

if ($row['user_xfire'] == ""){}         

else

{$xfireforumms = "<br>".$xfireskin."<br>";}}


return "".$xfireforumms."";


