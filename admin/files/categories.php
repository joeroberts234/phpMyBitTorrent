<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
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
//if (!defined('IN_PMBT')) die ("You can't access this file directly");
/*
REBUILDSORTINDEX FUNCTION

REBUILDS THE SORT INDEX FOR TORRENT CATEGORIES
ALL TORRENTS ARE "SPACED" BY 10 IN ORDER TO ALLOW MORE CATEGORIES BETWEEN EXISTING ONES

INPUT/OUTPUT PARAMETERS: NONE
*/
function RebuildSortIndex() {
        global $db, $db_prefix;
        $sql = "SELECT id FROM ".$db_prefix."_categories ORDER BY parent_id, sort_index, id ASC;";
        $res = $db->sql_query($sql);
        $sort = 10;
        while (list ($id) = $db->sql_fetchrow($res)) {
                $sql = "UPDATE ".$db_prefix."_categories SET sort_index = '".$sort."' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sort += 10;
        }
        $db->sql_freeresult($res);
        return;
}
#add new icon
if ($do == "takenew"){
$ct = $_FILES["catcon"];
                $nfname = unesc($ct["name"]);
                if ($nfname != "") {
                        if (!is_filename($nfname)) $errmsg[] = _adminvalidcatfname;
                        if (!preg_match('/^(.+)\.(gif|jpg|jpeg|png)$/si', $nfname)) $errmsg[] = _adminvalidcatfname;
                        if (!is_uploaded_file($ct["tmp_name"])) $errmsg[] = _admerrnocatupload;
                        if ($ct["size"] <= 0) $errmsg[] = _btemptyfile;
                                $imageinfo = getimagesize($ct["tmp_name"]);
                                $width = $imageinfo[0];
                                $height = $imageinfo[1];
                                if ($width > 48 OR $height > 48) $errmsg[] = _admcattoobig;
						
                }
                if (count($errmsg) > 0) bterror($errmsg,_bteditfailed);


                $nfopath = $torrent_dir."/".$id.".nfo";

                if (!empty($nfname)) {
                        @unlink($nfopath);
                        move_uploaded_file($ct["tmp_name"],"cat_pics/".$nfname);
                }
				}
#CATEGORY IMAGE SCRIPT
echo "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
echo "function ChangeThumb(pic) {\n";
echo "        if (pic != 'none') document.images.Thumb.src = 'cat_pics/'+pic\n";
echo "        else document.images.Thumb.src = 'avatars/blank.gif';\n";
echo "}\n";
echo "</script>\n";

switch($op) {
        case "addcategory": {
                if (!isset($sub_name) OR empty($sub_name) OR !isset($sub_image) OR empty($sub_image)) break;
                if ($sub_position == -1) {
                        $sql = "SELECT MAX(sort_index) FROM ".$db_prefix."_categories;";
                        $res = $db->sql_query($sql);
                        list ($sort) = $db->sql_fetchrow($res);
                        $db->sql_freeresult($res);
                } else $sort = intval($sub_position);
                $sort++;
		        $sql_edit1 = "SELECT tabletype FROM ".$db_prefix."_categories  ORDER BY tabletype DESC LIMIT 1;";
                $res_edit1 = $db->sql_query($sql_edit1);
                $row1 = $db->sql_fetchrow($res_edit1);
                $db->sql_freeresult($res_edit1);
				if(!is_numeric($sub_parent))$sub_parent = "-1";
				if(!isset($sub_parent) or $sub_parent == '')$sub_parent = "-1";
				if($sub_parent == "-1")$sub_tabletype = ($row1['tabletype']+1);
				else
				$sub_tabletype = "1";
                $sql = "INSERT INTO ".$db_prefix."_categories (name, sort_index, image, parent_id, tabletype) VALUES ('".addslashes($sub_name)."', '".$sort."', '".addslashes(html_entity_decode($sub_image))."', '".$sub_parent."', '".$sub_tabletype."');";
                $db->sql_query($sql) or btsqlerror($sql);
                $op = "";
                RebuildSortIndex();
                break;
        }
        case "editcategory": {
		        $sql_edit1 = "SELECT tabletype FROM ".$db_prefix."_categories  ORDER BY tabletype DESC LIMIT 1;";
                $res_edit1 = $db->sql_query($sql_edit1);
                $row1 = $db->sql_fetchrow($res_edit1);
                $db->sql_freeresult($res_edit1);
                if (!isset($id) OR intval($id) < 1) break;
                if (isset($sub_name) AND isset($sub_image)) {
				if(!is_numeric($sub_parent))$sub_parent = "-1";
				if(!isset($sub_parent) or $sub_parent == '')$sub_parent = "-1";
				if($sub_parent == "-1")$sub_tabletype = $id;
				else
				$sub_tabletype = "1";
                        $sql = "UPDATE ".$db_prefix."_categories SET name = '".addslashes($sub_name)."', image = '".addslashes(html_entity_decode($sub_image))."', parent_id = '".$sub_parent."', tabletype = '".$sub_tabletype."' WHERE id = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        $op = "";
                }
                break;
        }
        case "delcategory": {
                if (!isset($id) OR intval($id) < 1) break;
                $sql = "DELETE FROM ".$db_prefix."_categories WHERE id = '".intval($id)."';";
                $db->sql_query($sql) or btsqlerror($sql);
                break;
        }
        case "sortindexrebuild": {
                RebuildSortIndex();
                break;
        }
}

OpenTable(_admcategories);
echo "<p>"._admcategoriesintro."</p>";
echo "<p>&nbsp</p>\n";

$sql = "SELECT * FROM ".$db_prefix."_categories ORDER BY sort_index ASC;";
$res = $db->sql_query($sql);
if ($db->sql_numrows($res) < 1) {
        echo "<p><b>"._admnocategories."</b></p>\n";
} else {
        echo "<table width=\"50%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "<thead>\n";

        echo "<th><p align=\"center\">ID</p></th>\n";
        echo "<th><p align=\"center\">"._btactions."</p></th>\n";
        echo "<th><p align=\"center\">"._admcatname."</p></th>\n";
        echo "<th><p align=\"center\">"._admcatimage."</p></th>\n";
        echo "<th><p align=\"center\">Parent</p></th>\n";

        echo "</thead>";

        echo "<tbody>\n";

        while ($row = $db->sql_fetchrow($res)) {
                echo "<tr>";
                echo "<td><p align=\"center\" style=\"vertical-align:medium\">".$row["id"]."</p></td>\n";
                echo "<td><p align=\"center\">".pic("edit.gif","admin.php?op=editcategory&id=".$row["id"])."\n".pic("drop.gif","admin.php?op=delcategory&id=".$row["id"])."</p></td>\n";
                echo "<td><p align=\"center\" style=\"vertical-align:medium\">".$row["name"]."</p></td>\n";
                echo "<td><p align=\"center\"><img src=\"cat_pics/".$row["image"]."\" alt=\"".$row["name"]."\" /></p></td>\n";
                echo "<td><p align=\"center\" style=\"vertical-align:medium\">".(($row["parent_id"] == "-1")? "Main" : $row["parent_id"])."</p></td>\n";
                echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>\n";
}
$db->sql_freeresult($res);
CloseTable();

OpenTable(_admaddcategory);
echo "<form method=\"POST\" action=\"admin.php\">\n";
if ($op != "editcategory") echo "<input type=\"hidden\" name=\"op\" value=\"addcategory\">\n";
else {
        echo "<input type=\"hidden\" name=\"op\" value=\"editcategory\" />\n";
        echo "<input type=\"hidden\" name=\"id\" value=\"".intval($id)."\" />\n";
        $sql_edit = "SELECT * FROM ".$db_prefix."_categories WHERE id = '".intval($id)."';";
        $res_edit = $db->sql_query($sql_edit);
        $row = $db->sql_fetchrow($res_edit);
        $db->sql_freeresult($res_edit);
}

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "<tr>\n";
echo "<td><p>"._admcatname."</p></td>\n";
if ($op != "editcategory") echo "<td><input type=\"text\" name=\"sub_name\" size=\"20\" /></td>\n";
else echo "<td><input type=\"text\" name=\"sub_name\" size=\"20\" value =\"".$row["name"]."\" /></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td><p>Parent id <br />set to -1 or leave Blank for main</p></td>\n";
echo "<td><input type=\"text\" name=\"sub_parent\" size=\"20\" value =\"".(($op == "editcategory")? $row["parent_id"] : '')."\" /></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td><p>"._admcatimage."</p></td>\n";
echo "<td>";
echo "<img src=\"avatars/blank.gif\" name=\"Thumb\" />";
echo "<br />\n";
echo "<select name=\"sub_image\" onChange=\"ChangeThumb(this.options[this.selectedIndex].value);\" onKeyUp=\"ChangeThumb(this.options[this.selectedIndex].value);\">\n";
echo "<option value=\"none\">"._admchoose."</option>\n";
$dhandle = opendir("./cat_pics/");
while ($file = readdir($dhandle)) {
        if (is_dir("./cat_pics/".$file) OR !eregi("\.(gif|jpg|png)$",$file)) continue;
        echo "<option value=\"".htmlentities($file)."\" ";
        if ($op == "editcategory" AND $row["image"] == $file) echo "selected";
        echo">".htmlentities($file)."</option>\n";
}
closedir($dhandle);

echo "</select></td>\n";
echo "</tr>\n";

if ($op != "editsmile") {
        echo "<tr>";
        echo "<td><p>"._admposition."</p></td>";
        echo "<td><select name=\"sub_position\">\n";
        echo "<option value=\"-1\">"._admatend."</option>\n";
        echo "<option value=\"0\">"._admatbegin."</option>\n";
        $sql = "SELECT name, sort_index FROM ".$db_prefix."_categories ORDER BY sort_index ASC;";
        $res_position = $db->sql_query($sql);
        while ($row_position = $db->sql_fetchrow($res_position)) {
                echo "<option value=\"".$row_position["sort_index"]."\">"._admafter." ".$row_position["name"]."</option>\n";
        }
        $db->sql_freeresult($res_position);
        echo "</select></td>";
        echo "</tr>\n";
}

echo "</table>\n";
echo "<p><input type=\"submit\" value=\""._btsend."\" /></p>\n";
echo "</form>\n";
CloseTable();
OpenTable(_admnewcategory);
echo "<p>"._admiconintro."</p>";
echo "<p>&nbsp</p>\n";
echo "<form method=\"POST\" action=\"admin.php?op=categories\"enctype=\"multipart/form-data\">\n\n";
echo "<input type=\"hidden\" name=\"do\" value=\"takenew\" />\n";
echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "<td>";
echo "<tr><td><p>"._admupcat."</p></td><td><p><input type=\"file\" name=\"catcon\"  /></p>\n</td></tr>\n";
echo "</table>\n";
echo "<p><input type=\"submit\" value=\""._btsend."\" /></p>\n";
echo "</form>\n";
CloseTable();
?>