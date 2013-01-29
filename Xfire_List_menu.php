<?php

/*
#######################################
#     e107 website system plguin      #
#     AACGC Xfire Stats               #    
#     by M@CH!N3                      #
#     http://www.AACGC.com            #
#######################################
*/

if ($pref['xf_enable_gold'] == "1"){$gold_obj = new gold();}

//-------------------------Menu Title--------------------------------+

$xfmenu_title .= "Member's Xfire Menu";

//-------------------------------------------------------------------+


//-------------------------Menu News & Info Section-------------------+

$xfmenu_text .= "

<script type=\"text/javascript\">
function xfmenuup(){xfmenu.direction = \"up\";}
function xfmenudown(){xfmenu.direction = \"down\";}
function xfmenustop(){xfmenu.stop();}
function xfmenustart(){xfmenu.start();}
</script>

<marquee height='".$pref['xfmenu_height']."px' id='xfmenu' scrollamount='".$pref['xfmenu_speed']."' onMouseover='this.scrollAmount=".$pref['xfmenu_mouseoverspeed']."' onMouseout='this.scrollAmount=".$pref['xfmenu_mouseoutspeed']."' direction='up' loop='true'>
<table style='width:100%' class=''>";




        $sql ->db_Select("user_extended", "*", "ORDER BY user_extended_id DESC","");
        while($row = $sql ->db_Fetch()){
        $sql2 = new db;
        $sql2 ->db_Select("user", "*", "user_id='".intval($row['user_extended_id'])."'");
        $row2 = $sql2->db_Fetch();

        if ($pref['xf_enable_gold'] == "1"){
        $username = "".$gold_obj->show_orb($row2['user_id'])."";}
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
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/bg/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}

if ($pref['xf_skin'] == "Sci-fi"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/sf/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}

if ($pref['xf_skin'] == "Shadow"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/sh/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}

if ($pref['xf_skin'] == "Combat"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/co/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}

if ($pref['xf_skin'] == "Fantasy"){
$xfireskin = "<a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'><img src='http://miniprofile.xfire.com/bg/os/type/3/".$row['user_xfire'].".png' width='149' height='29' /></a>";}


if ($row['user_xfire'] == ""){
$xfmenu_text .= "";}         

else

{


/*
if ($pref['xf_enable_username'] == "1"){
$xfmenu_text .= "<td class='forumheader3'>".$avatar." <a href='".e_PLUGIN."aacgc_xfirestats/Xfire_History.php?det.".$row['user_extended_id']."'>".$username."</a></td>";}
*/

$xfmenu_text .= "<tr><td class='indent' style='width:0%'><center>".$xfireskin."</center></td></tr>";}}



$xfmenu_text .= "</table></marquee>
<br><br>
<table style='width:100%' class=''><tr><td>
<center>
<input class=\"button\" value=\"Start\" onClick=\"xfmenustart();\" type=\"button\">
<input class=\"button\" value=\"Stop\" onClick=\"xfmenustop();\" type=\"button\">
<input class=\"button\" value=\"Up\" onClick=\"xfmenuup();\" type=\"button\">
<input class=\"button\" value=\"Down\" onClick=\"xfmenudown();\" type=\"button\">
</center>
</td></tr></table>
<br>
";




$ns -> tablerender($xfmenu_title, $xfmenu_text);


?>