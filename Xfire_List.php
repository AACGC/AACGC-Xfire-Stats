<?php

/*
#######################################
#     AACGC Xfire Stats               #                
#     by M@CH!N3                      #
#     http://www.AACGC.com            #
#######################################
*/


require_once("../../class2.php");
require_once(HEADERF);

if ($pref['xf_enable_gold'] == "1"){$gold_obj = new gold();}

//---------------------------------------------------------------------------------


$title .= "".$pref['xf_pagetitle'].""; 

//--------------# Multipage Script #---------------------------
if ($pref['xf_rendperpage'] != '') 
{$rowsPerPage = $pref['xf_rendperpage'];} 
else 
{$rowsPerPage = "";}

if(isset($_GET['rowspp']))
{$rowsPerPage = intval($_GET['rowspp']);}

$pageNum = 1;
if(isset($_GET['page']))
{$pageNum = intval($_GET['page']);}

$offset = ($pageNum - 1) * $rowsPerPage;


$query = @mysql_query("SELECT user_xfire FROM ".MPREFIX."user_extended WHERE user_xfire!='' ");
$numrows = mysql_num_rows($query);

if(isset($_POST['page'])) 
{$rowsPerPage = intval($_POST['page']);}

$maxPage = ceil($numrows/$rowsPerPage);
$self = $_SERVER['PHP_SELF'];
$nav  = '';

for($page = 1; $page <= $maxPage; $page++) {
if ($page == $pageNum) 
{$nav .= " $page ";} 
else 
{$nav .= " <a href=\"$self?page=".$page."&rowspp=".$rowsPerPage."\">$page</a> ";}}

if ($pageNum > 1) 
{$page  = $pageNum - 1;
$prev  = " <a href=\"$self?page=$page&rowspp=$rowsPerPage\">Previous</a> ";} 
else 
{$prev  = "";}

if ($pageNum < $maxPage) 
{$page = $pageNum + 1;
$next = " <a href=\"$self?page=$page&rowspp=$rowsPerPage\">Next Page</a> ";} 
else 
{$next = "";}

//---------------------------------------------------------------

if ($pref['xf_rendperpage'] == "") 
{$limit = "";} 
else 
{$limit = "LIMIT ".$offset.", ".$rowsPerPage."";}


        $sql ->db_Select("user_extended", "*", "ORDER BY user_extended_id ASC $limit","");
        while($row = $sql->db_Fetch()){
        $sql2 ->db_Select("user", "*", "user_id = '".intval($row['user_extended_id'])."'");
        $row2 = $sql2->db_Fetch();


        if ($row['user_xfire'] == ""){$text .= "";}         
        else{

        if ($pref['xf_enable_gold'] == "1"){
        $username = "<font color='#00FF00'>".$gold_obj->show_orb($row2['user_id'])."</font>";}
        else
        {$username = "".$row2['user_name']."";}
        if ($pref['xf_enable_avatar'] == "1"){
        if ($row2['user_image'] == "")
        {$avatar = "";}
        else
        {$useravatar = $row2[user_image];
        require_once(e_HANDLER."avatar_handler.php");
        $useravatar = avatar($useravatar);
        $avatar = "<img src='".$useravatar."' width=".$pref['xf_avatar_size']."px></img>";}}


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




$text .= "<br><center><table style='width:450px' class='indent'>";

if ($pref['xf_enable_username'] == "1"){
$text .= "
<tr>
<td class='forumheader3'><center>".$avatar." ".$username."</center></td>
</tr>";}

$text .= "
<tr>   
<td class='indent'><center>
".$xfireskin."
</center></td>
</tr>";

$text .= "</table></center><br>";}}






//----#AACGC Plugin Copyright&reg; - DO NOT REMOVE BELOW THIS LINE! - #-------+
require(e_PLUGIN . 'aacgc_xfirestats/plugin.php');
$copyright .= "<br><br><br><br><br><br><br>
<a href='http://www.aacgc.com' target='_blank'>
<font color='808080' size='1'>".$eplug_name." V".$eplug_version."  &reg;</font>
</a>";
//------------------------------------------------------------------------+




$ns -> tablerender($title, $text."<br><br>".$prev.$nav.$next.$copyright);



//----------------------------------------------------------------------------------

require_once(FOOTERF);


