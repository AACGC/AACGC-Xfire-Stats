<?php


/*
#######################################
#     e107 website system plguin      #
#     AACGC Xfire Stats               #    
#     by M@CH!N3                      #
#     http://www.AACGC.com            #
#######################################
*/



require_once("../../class2.php");
if (!defined('e107_INIT'))
{exit;}
if (!getperms("P"))
{header("location:" . e_HTTP . "index.php");
exit;}
require_once(e_ADMIN . "auth.php");
if (!defined('ADMIN_WIDTH'))
{define(ADMIN_WIDTH, "width:100%;");}

include_lan(e_PLUGIN."aacgc_xfirestats/languages/".e_LANGUAGE.".php");

if (e_QUERY == "update")
{
 
    $pref['xf_pagetitle'] = $_POST['xf_pagetitle'];
    $pref['xfmenu_height'] = $_POST['xfmenu_height'];
    $pref['xfmenu_speed'] = $_POST['xfmenu_speed'];
    $pref['xfmenu_mouseoverspeed'] = $_POST['xfmenu_mouseoverspeed'];
    $pref['xfmenu_mouseoutspeed'] = $_POST['xfmenu_mouseoutspeed'];
    $pref['xf_avatar_size'] = $_POST['xf_avatar_size'];
    $pref['xf_skin'] = $_POST['xf_skin'];
    $pref['xf_rendperpage'] = $_POST['xf_rendperpage'];


if (isset($_POST['xfirestats_enable_forums'])) 
{$pref['xfirestats_enable_forums'] = 1;}
else
{$pref['xfirestats_enable_forums'] = 0;}

if (isset($_POST['xfirestats_enable_profiles'])) 
{$pref['xfirestats_enable_profiles'] = 1;}
else
{$pref['xfirestats_enable_profiles'] = 0;}

if (isset($_POST['xf_enable_gold'])) 
{$pref['xf_enable_gold'] = 1;}
else
{$pref['xf_enable_gold'] = 0;}

if (isset($_POST['xf_enable_avatar'])) 
{$pref['xf_enable_avatar'] = 1;}
else
{$pref['xf_enable_avatar'] = 0;}

if (isset($_POST['xf_enable_username'])) 
{$pref['xf_enable_username'] = 1;}
else
{$pref['xf_enable_username'] = 0;}



    save_prefs();
    $led_msgtext = "".AXF_22."";
}

$admin_title = "AACGC Xfire Stats (".AXF_21.")";
//--------------------------------------------------------------------


$text .= "
<form method='post' action='" . e_SELF . "?update' id='confnwb'>
	<table style='" . ADMIN_WIDTH . "' class='fborder'>


		<tr>
			<td colspan='3' class='fcaption'><b>".AXF_04.":</b></td>
		</tr>
              <tr>
		        <td style='width:30%' class='forumheader3'>".AXF_05.":</td>
		        <td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='10' name='xf_rendperpage' value='" . $tp->toFORM($pref['xf_rendperpage']) . "' /></td>
	        </tr>


                <tr>
		        <td style='width:30%' class='forumheader3'>".AXF_06.":</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='50' name='xf_pagetitle' value='" . $tp->toFORM($pref['xf_pagetitle']) . "' /></td>
	        </tr>
                <tr>
		        <td style='width:30%' class='forumheader3'>".AXF_07.":</td>
		        <td colspan=2 class='forumheader3'>".($pref['xf_enable_username'] == 1 ? "<input type='checkbox' name='xf_enable_username' value='1' checked='checked' />" : "<input type='checkbox' name='xf_enable_username' value='0' />")."</td>
	        </tr>
                <tr>
		        <td style='width:30%' class='forumheader3'>".AXF_08."</td>
		        <td colspan=2 class='forumheader3'>".($pref['xf_enable_gold'] == 1 ? "<input type='checkbox' name='xf_enable_gold' value='1' checked='checked' />" : "<input type='checkbox' name='xf_enable_gold' value='0' />")."</td>
	        </tr>
                <tr>
		        <td style='width:30%' class='forumheader3'>".AXF_09.":</td>
		        <td colspan=2 class='forumheader3'>".($pref['xf_enable_avatar'] == 1 ? "<input type='checkbox' name='xf_enable_avatar' value='1' checked='checked' />" : "<input type='checkbox' name='xf_enable_avatar' value='0' />")."</td>
	        </tr>
		<tr>
			<td style='width:30%' class='forumheader3'>".AXF_10.":</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='10' name='xf_avatar_size' value='" . $tp->toFORM($pref['xf_avatar_size']) . "' />px  (pixles)</td>
		</tr>
                <tr>
		        <td style='width:30%' class='forumheader3'>".AXF_11.":</td>
		        <td colspan=2 class='forumheader3'>".($pref['xfirestats_enable_forums'] == 1 ? "<input type='checkbox' name='xfirestats_enable_forums' value='1' checked='checked' />" : "<input type='checkbox' name='xfirestats_enable_forums' value='0' />")."</td>
	        </tr>
                <tr>
		        <td style='width:30%' class='forumheader3'>".AXF_12.":</td>
		        <td colspan=2 class='forumheader3'>".($pref['xfirestats_enable_profiles'] == 1 ? "<input type='checkbox' name='xfirestats_enable_profiles' value='1' checked='checked' />" : "<input type='checkbox' name='xfirestats_enable_profiles' value='0' />")."</td>
	        </tr>




		<tr>
			<td colspan='3' class='fcaption'><b>".AXF_13.":</b></td>
		</tr>
		<tr>
			<td style='width:30%' class='forumheader3'>".AXF_14.":</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='10' name='xfmenu_height' value='" . $tp->toFORM($pref['xfmenu_height']) . "' />px</td>
		</tr>
		<tr>
			<td style='width:30%' class='forumheader3'>".AXF_15.":</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='10' name='xfmenu_speed' value='" . $tp->toFORM($pref['xfmenu_speed']) . "' />  ".AXF_23."</td>
		</tr>
		<tr>
			<td style='width:30%' class='forumheader3'>".AXF_16.":</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='10' name='xfmenu_mouseoverspeed' value='" . $tp->toFORM($pref['xfmenu_mouseoverspeed']) . "' />  ".AXF_24."</td>
		</tr>
		<tr>
			<td style='width:30%' class='forumheader3'>".AXF_17.":</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='10' name='xfmenu_mouseoutspeed' value='" . $tp->toFORM($pref['xfmenu_mouseoutspeed']) . "' />  ".AXF_25."</td>
		</tr>







		<tr>
			<td colspan='3' class='fcaption'><b>".AXF_18.":</b></td>
		</tr>
		<tr>
			<td style='width:30%' class='forumheader3'>".AXF_19.":</td>
                        <td style='width:' class=''>
                        <select name='xf_skin' size='1' class='tbox' style='width:50%'>
                        <option name='xf_skin' value='".$pref['xf_skin']."'> ".$pref['xf_skin']."</option>
                        <option name='xf_skin' value='Xfire Default'>Xfire Default</option>
                        <option name='xf_skin' value='Sci-fi'>Sci-fi</option>
                        <option name='xf_skin' value='Shadow'>Shadow</option>
                        <option name='xf_skin' value='Combat'>Combat</option>
                        <option name='xf_skin' value='Fantasy'>Fantasy</option>
                        </td>
		<tr>








                <tr>
			<td colspan='3' class='fcaption' style='text-align: left;'><input type='submit' name='update' value='".AXF_20."' class='button' /></td>
		</tr>





</table>
</form>";



$ns->tablerender($admin_title, $text);
require_once(e_ADMIN . "footer.php");
?>
