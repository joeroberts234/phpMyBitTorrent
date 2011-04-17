<?php
/*
*---------------------------phpMyBitTorrent V 2.0.5----------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*----------------   Thursday, February 25, 2010 3:51 PM   ---------------------*
*/
if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
if(file_exists('./admin/language/addon/smilie_'.$user->ulanguage.'.php'))include'./admin/language/addon/smilie_'.$user->ulanguage.'.php';
else
include'./admin/language/addon/smilie_english.php';
function RebuildSortIndex() {
        global $db, $db_prefix;
        $sql = "SELECT id FROM ".$db_prefix."_smiles ORDER BY sort_index ASC;";
        $res = $db->sql_query($sql);
        $sort = 10;
        while (list ($id) = $db->sql_fetchrow($res)) {
                $sql = "UPDATE ".$db_prefix."_smiles SET sort_index = '".$sort."' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sort += 10;
        }
        $db->sql_freeresult($res);
        return;
}
switch($op) {
        case "addsmile": {
                if (!isset($sub_name) OR empty($sub_name) OR !isset($sub_image) OR empty($sub_image)OR !isset($sub_alt) OR empty($sub_alt)) break;
                if ($sub_position == -1) {
                        $sql = "SELECT MAX(sort_index) FROM ".$db_prefix."_smiles;";
                        $res = $db->sql_query($sql);
                        list ($sort) = $db->sql_fetchrow($res);
                        $db->sql_freeresult($res);
                } else $sort = intval($sub_position);
                $sort++;
                $sql = "INSERT INTO ".$db_prefix."_smiles (code, sort_index, file, alt) VALUES ('".addslashes($sub_name)."', '".$sort."', '".addslashes(html_entity_decode($sub_image))."', '".addslashes($sub_alt)."');";
                $db->sql_query($sql) or btsqlerror($sql);
                $op = "";
                RebuildSortIndex();
                break;
        }
        case "editsmile": {
                if (!isset($id) OR intval($id) < 1) break;
                if (isset($sub_name) AND isset($sub_image)) {
                        $sql = "UPDATE ".$db_prefix."_smiles SET code = '".addslashes($sub_name)."', file = '".addslashes(html_entity_decode($sub_image))."' WHERE id = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        $op = "";
                }
                break;
        }
        case "delsmile": {
                if (!isset($id) OR intval($id) < 1) break;
                $sql = "DELETE FROM ".$db_prefix."_smiles WHERE id = '".intval($id)."';";
                $db->sql_query($sql) or btsqlerror($sql);
                break;
		}
}
#CATEGORY IMAGE SCRIPT
echo "<a name=\"smilies\"></a>";
echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
echo "function ChangeThumb(pic) {\n";
echo "        if (pic != 'none') document.images.Thumb.src = 'smiles/'+pic\n";
echo "        else document.images.Thumb.src = 'avatars/blank.gif';\n";
echo "}\n";
echo "</script>\n";
OpenTable(_admsmilies);
echo "<p>"._admsmiliesintro."</p>";
echo "<p>&nbsp</p>\n";
$sql = "SELECT * FROM ".$db_prefix."_smiles;";
$res = $db->sql_query($sql);
if ($db->sql_numrows($res) < 1) {
        echo "<p><b>"._admnosmilies."</b></p>\n";
} else {
        echo "<table width=\"50%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "<thead>\n";

        echo "<th><p align=\"center\">"._btactions."</p></th>\n";
        echo "<th><p align=\"center\">"._admcode."</p></th>\n";
        echo "<th><p align=\"center\">"._admcodeimage."</p></th>\n";
        echo "<th><p align=\"center\">"._admsmiliealt."</p></th>\n";

        echo "</thead>";

        echo "<tbody>\n";
        while ($row = $db->sql_fetchrow($res)) {
                echo "<tr>";
                echo "<td><p align=\"center\">".pic("edit.gif","admin.php?op=editsmile&id=".$row["id"]."#smiliesedit")."\n".pic("drop.gif","admin.php?op=delsmile&id=".$row["id"]."#smilies")."</p></td>\n";
                echo "<td><p align=\"center\" style=\"vertical-align:medium\">".$row["code"]."</p></td>\n";
                echo "<td><p align=\"center\"><img src=\"smiles/".$row["file"]."\" alt=\"".$row["alt"]."\" /></p></td>\n";
                echo "<td><p align=\"center\" style=\"vertical-align:medium\">".$row["alt"]."</p></td>\n";
                echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>\n";
}
$db->sql_freeresult($res);
CloseTable();
echo "<a name=\"smiliesedit\"></a>";
OpenTable(_admaddsmilies);
echo "<form method=\"POST\" action=\"admin.php#smilies\">\n";
if ($op != "editsmile") echo "<input type=\"hidden\" name=\"op\" value=\"addsmile\">\n";
else {
        echo "<input type=\"hidden\" name=\"op\" value=\"editsmile\" />\n";
        echo "<input type=\"hidden\" name=\"id\" value=\"".intval($id)."\" />\n";
        $sql_edit = "SELECT * FROM ".$db_prefix."_smiles WHERE id = '".intval($id)."';";
        $res_edit = $db->sql_query($sql_edit);
        $row = $db->sql_fetchrow($res_edit);
        $db->sql_freeresult($res_edit);
}

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "<tr>\n";
echo "<td><p>"._admsmilecode."</p></td>\n";
if ($op != "editsmile") echo "<td><input type=\"text\" name=\"sub_name\" size=\"20\" /></td>\n";
else echo "<td><input type=\"text\" name=\"sub_name\" size=\"20\" value =\"".$row["code"]."\" /></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td><p>"._admsmileimage."</p></td>\n";
echo "<td>";
echo "<img src=\"avatars/blank.gif\" name=\"Thumb\" />";
echo "<br />\n";
echo "<select name=\"sub_image\" onChange=\"ChangeThumb(this.options[this.selectedIndex].value);\" onKeyUp=\"ChangeThumb(this.options[this.selectedIndex].value);\">\n";
echo "<option value=\"none\">"._admchoose."</option>\n";
$dhandle = opendir("./smiles/");
while ($file = readdir($dhandle)) {
        if (is_dir("./smiles/".$file) OR !eregi("\.(gif|jpg|png)$",$file)) continue;
        echo "<option value=\"".htmlentities($file)."\" ";
        if ($op == "editsmile" AND $row["file"] == $file) echo "selected";
        echo">".htmlentities($file)."</option>\n";
}
closedir($dhandle);

echo "</select></td>\n";
echo "</tr>\n";

        echo "<tr>";
        echo "<td><p>Alternat Name</p></td>";
if ($op == "editsmile")echo "<td><input type=\"text\" name=\"sub_alt\" size=\"20\" value =\"".$row["alt"]."\" /></td>\n";
else
echo "<td><input type=\"text\" name=\"sub_alt\" size=\"20\" value =\"\" /></td>\n";
        echo "</tr>\n";
if ($op != "editsmile") {
        echo "<tr>";
        echo "<td><p>"._admposition."</p></td>";
        echo "<td><select name=\"sub_position\">\n";
        echo "<option value=\"-1\">"._admatend."</option>\n";
        echo "<option value=\"0\">"._admatbegin."</option>\n";
        $sql = "SELECT code, sort_index FROM ".$db_prefix."_smiles ORDER BY sort_index ASC;";
        $res_position = $db->sql_query($sql);
        while ($row_position = $db->sql_fetchrow($res_position)) {
                echo "<option value=\"".$row_position["sort_index"]."\">"._admafter." ".$row_position["code"]."</option>\n";
        }
        $db->sql_freeresult($res_position);
        echo "</select></td>";
        echo "</tr>\n";
}

echo "</table>\n";
echo "<p><input type=\"submit\" value=\""._btsend."\" /></p>\n";
echo "</form>\n";
CloseTable();
?>