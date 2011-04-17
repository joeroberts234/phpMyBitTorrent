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
echo "<p>You do not have Permissions to Access Offers at this time</p>";
CloseErrTable();
die();
}
include'include/textarea.php';
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_offers WHERE id = $id");
$row = $db->sql_fetchrow($res);
if (getuserid($btuser) != $row["userid"]){
if (!$user->admin) 
stderr("You're not the owner!", "You're not the owner! How did that happen?");
}
OpenTable(" Edit Offers");
if (!$row)
die();
print("<h1>Release Edit \"" . $row["name"] . "\"</h1><br>\n");
$where = "WHERE userid = " . getuserid($btuser) . "";
$res2 = $db->sql_query("SELECT * FROM ".$db_prefix."_offers $where") ;
$num2 = $db->sql_numrows($res2);
echo'<div align=Center>';
echo'<form action="takeoffer.php" name="Form" method="post">';
echo'<br>';
echo'<br>';
echo'<table border="1" cellspacing="0" cellpadding="10">';
echo "<tr><td><p>"._btname."</p></td><td><p><input type=\"text\" name=\"requesttitle\" size=\"80\" value=\"" . htmlspecialchars($row["name"]) . "\" /></p>\n</td>\n</tr>\n";

echo "<tr><td><p>"._btaddcomment;
                if (!$allow_html) echo "<br>"._btnohtml."</p></td><td><p><textarea name=\"msg\" rows=\"20\" cols=\"90\">".$row["descr"]."</textarea></p>\n</td></tr>\n";
                else {
                        echo "</td><td>";
echo $textarea->quick_bbcode('Form','msg');
echo $textarea->input('msg', 'center', "2", "10", "80",$row["descr"]);
echo "</table></td></tr>\n";
						}
                $s = "<select name=\"torrent_category\">\n";
                $cats = catlist();
                foreach ($cats as $catrow) {
                        $s .= "<option value=\"".$catrow["id"]."\" ";
                        if ($catrow["name"] == $row["cat_name"]) $s .= "selected";
                        $s .= ">" . htmlspecialchars($catrow["name"]) . "</option>\n";
                }
                $s .= "</select>\n";

echo "<tr><td><p>"._bttype."</p></td><td><p>". $s ."</p></td></tr>\n";
print("$s<br>\n");

print("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");
print("<tr><td align=center><input type=submit value=\""._btfsend."\" style='height: 22px'>\n");
print("</form>\n");
print("</table>\n");
CloseTable();
include("footer.php");
die;
?>
