<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta4-----------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
include("header.php");
function begin_frame($caption = "-", $align = "justify"){

print("<br /><table cellpadding=0 cellspacing=0 border=0 width=95% align=center>\n"
		."\t<tr>\n"
		."\t\t<TD class=frame_top_left></TD>\n"
		."\t\t<TD class=frame_top align=center><b>$caption</b></TD>\n"
		."\t\t<TD class=frame_top_right></TD>\n"
		."\t</tr>\n"
		."\t<tr>\n"
		."\t\t<TD class=frame_middle_left><span class=space></span></TD>\n"
		."\t\t<TD class=frame_middle width=100% align=$align valign=top><br>");
}

//ATTACH FRAME
function attach_frame($padding = 0) {
    print("\n");
}

//END FRAME
function end_frame() {
print("\t\t</td>\n"
		."\t\t<td class=frame_middle_right><span class=space></span></TD></td>\n"
		."\t</tr>\n"
		."\t<tr>\n"
		."\t\t<td class=frame_bottom_left><span class=space></span></TD></td>\n"
		."\t\t<td class=frame_bottom></TD></td>\n"
		."\t\t<td class=frame_bottom_right><span class=space></span></TD></td>\n"
		."\t</tr>\n"
		."</table>");
}

function stderr($heading = "", $text, $sort = "") {
  OpenTable("$sort: $heading"); 
  begin_frame("<font color=red>$sort: $heading</font>", center);
  echo $text;
  end_frame();
  CloseTable();
  die;
}

define (UC_USER, user);
define (UC_VIP, premium);
define (UC_MODERATOR, moderator);
define (UC_ADMINISTRATOR, admin);

function get_user_class()
{
  global $CURUSER;
  return $CURUSER["class"];
}

function get_user_class_name($class)
{
  switch ($class)
  {
    case UC_USER: return "user";

    case UC_VIP: return "premium";

    case UC_MODERATOR: return "moderator";

    case UC_ADMINISTRATOR: return "admin";

    }
  return "";
}

if (!$user->admin) 
stderr("Sorry", "Access denied.");
if ($_POST['offres'] == 'config'){
$res = mysql_query("SELECT * FROM offres_config") or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res)) {
$name = $arr['name'];
if ($name != 'class_allowed')
$new_data = $_POST[$name];
else
$new_data = implode("|", $_POST['class_allowed']);
mysql_query("UPDATE offres_config SET value = '$new_data' WHERE name = '$name'") or sqlerr(__FILE__, __LINE__);
}
stderr("Settings Updated", "See You...<br /><br /><a href=offres_config.php>Back</a>");
}
Opentable("-");
begin_frame("Addons Setting:");
?>
<form action="offres_config.php" method=post>
<?php
print("<table width=\"100%\">\n");
$res = mysql_query("SELECT * FROM offres_config") or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res))
$arr_config[$arr['name']] = $arr['value'];
if (!$arr_config["enable"])
if ($arr_config["enable"]){
print("Offers are currently enabled, so this configuration page is closed.<br /><br />Classes allowed in offers, are: ");
$class = explode("|", $arr_config['class_allowed']);
$classes_playing = '';
for ($x = 0; $x < count($class); $x++) {
$classes_playing = (!$classes_playing) ? get_user_class_name($class[$x]) : ', ' . get_user_class_name($class[$x]);
print($classes_playing);
}
die;
}
$enable_yes = ($arr_config['enable'] == 1) ? 'checked="checked"' : '';
$enable_no  = ($arr_config['enable'] == 0) ? 'checked="checked"' : '';
///////////////////////Enable/Desable Casino/////////////////////////
print("<tr><td width=50% class=\"tableb\" align=left>Torrent Offers Actived?</td><td class=\"tableb\" align=left>Yes <input class=\"tableb\" type=radio name=enable value=\"1\" $enable_yes /> No <input class=\"tableb\" type=radio name=enable value=\"0\" $enable_no /></td></tr>");
/////////////////////////////////////////////////////////////////////

print("<tr><td width=50% class=\"tableb\" align=left>Allowed Classes</td><td class=\"tableb\" align=left><ul class=\"checklist\">");
$maxclass = UC_ADMINISTRATOR + 1;
for ($i = 0; $i < $maxclass; $i++){
$class_allowed  = array_map('trim', @explode('|', $arr_config["class_allowed"]));
if (in_array($i, $class_allowed)){
if ($c = get_user_class_name($i))
print("<li><label for=\"$i\"><input id=\"$i\" name=\"class_allowed[]\" type=\"checkbox\" checked=\"checked\" value=\"$i\" />$c</label></li>\n");
}
else{
if ($c = get_user_class_name($i))
print("<li><label for=\"$i\"><input id=\"$i\" name=\"class_allowed[]\" type=\"checkbox\" value=\"$i\" />$c</label></li>\n");
}}
if ($user->admin)  {
?>
<tr>
<td class="tableb" colspan="4" align="center">
<input type="hidden" name="offres" value="config"><input type="submit" name="submit" value="Apply">
</td>
</tr>
</table>
</form>
<?php
}
end_frame();
//end_frame();
CloseTable();
die;
?>
