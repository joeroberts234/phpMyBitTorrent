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
        global $db, $db_prefix;
if(!checkaccess("offers")){
OpenErrTable(_btaccdenied);
echo "<p>"._bt_voteoffer_noaccess."</p>";
CloseErrTable();
die();
}
include'include/textarea.php';
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";

/////////////////////Test if offers is enabled////////////////////////////
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_offres_config");
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];
if ($arr_config["enable"]!='true')bterror(_bt_offers_closed,_btsorry);
$access_level = $arr_config["class_allowed"];
switch ($access_level) {
        case "user": {
                if (!$user->user) loginrequired("user");
                break;
        }
        case "premium": {
                if (!$user->premium) loginrequired("premium");
                break;
        }
        case "moderator": {
                if (!$user->moderator) loginrequired("moderator");
                break;
        }
        case "admin": {
                if (!$user->admin) loginrequired("admin");
                break;
        }
}
//////////////////////////////////////////////////////////////////////////
OpenTable(_bt_offers_make);
echo'<div align=Center>';
echo'<form action="takeoffer.php" name="Form" method="post">';
echo'<br>';
echo'<br>';
echo'<table border="1" cellspacing="0" cellpadding="10">';
echo "<tr><td><p>"._btname."</p></td><td><p><input type=\"text\" name=\"name\" size=\"80\" /></p>\n</td>\n</tr>\n";

echo "<tr><td><p>"._btdescription;
                if (!$allow_html) echo "<br>"._btnohtml."</p></td><td><p><textarea name=\"msg\" rows=\"20\" cols=\"90\"></textarea></p>\n</td></tr>\n";
                else {
                        echo "</td><td>";
echo $textarea->quick_bbcode('Form','msg');
echo $textarea->input('msg');
echo "</table></td></tr>\n";
						}
$s = "<select name=\"type\"><option value=\"0\">("._btchooseone.")</option>\n";
$cats = genrelist2();
foreach ($cats as $cat)
{
 $s .= "<optgroup label=\"" . htmlspecialchars($cat["name"]) . "\">";
 $subcats = $cat[subcategory];

 if (count($subcats) > 0)
 {
 foreach ($subcats as $subcat)
 {
 $s .= "<option value=\"" . $subcat["id"] . "\">" . htmlspecialchars($subcat["name"]) . "</option>\n";

 }
 }
 $s .= "</optgroup>\n";

}  
$s .= "</select>\n";

echo "<tr><td><p>"._bttype."</p></td><td><p>". $s ."</p></td></tr>\n";

echo'<tr><td align="center" colspan="2"><input type="submit" class=btn value='._btfsend.'></td></tr>';
echo'</table></form><br/>';
echo"<a href=offers.php><b>"._bt_offers_seeall."</b></a>";
CloseTable();
include("footer.php");
?>