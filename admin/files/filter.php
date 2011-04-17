<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
switch ($op) {

        case "addfilter": {

                $errors = Array();

                if (!isset($keyword)) $errors[] = _admmissingkeyword;

                if (!isset($whatfor)) $errors[] = _admmissingreason;

                if (count($errors) > 0) {

                        bterror($errors,_admaddkeyword,false);

                        break;

                }

                $keyword = strtolower(escape($keyword));

                $whatfor = escape(trim($whatfor));

                if (!preg_match("/^[\w]{5,50}$/",$keyword)) $errors[] = _admkeywordillegalformat;

                if (strlen($whatfor) > 255) $errors[] = _admreasonillegalformat;

                if (count($errors) > 0) {

                        bterror($errors,_admaddkeyword,false);

                        break;

                }

                $sql = "INSERT INTO ".$db_prefix."_filter (keyword, reason) VALUES ('".$keyword."','".htmlspecialchars($whatfor)."');";

                $db->sql_query($sql) or btsqlerror($sql);

                break;

        }

        case "editfilter": {

                if (isset($id) AND is_numeric($id)) {

                        if (isset($keyword) AND isset($whatfor)) {

                                $sql = "UPDATE ".$db_prefix."_filter SET keyword = '".strtolower(escape($keyword))."', reason = '".htmlspecialchars(escape(trim($whatfor)))."' WHERE id = '".$id."'";

                                $db->sql_query($sql) or btsqlerror($sql);

                        } else {

                                $sql = "SELECT * FROM ".$db_prefix."_filter WHERE id = '".$id."';";

                                if (!$res_edit = $db->sql_query($sql)) btsqlerror($sql);

                                if ($db->sql_numrows($res_edit) == 1) break;

                        }

                }

                $op = "";

                break;

        }

        case "delfilter": {

                $sql = "DELETE FROM ".$db_prefix."_filter WHERE id = '".intval($id)."'";

                $db->sql_query($sql) or btsqlerror($sql);

                break;

        }

}



OpenTable(_admfilter);

echo "<p>"._admfilterintro."</p>\n";

echo "<p>&nbsp</p>\n";



$sql = "SELECT * FROM ".$db_prefix."_filter ORDER BY id ASC;";



$res = $db->sql_query($sql);

if ($db->sql_numrows($res) < 1) {

        echo "<p><b>"._admnofilterkey."</b></p>\n";

} else {

        echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";

        echo "<thead>\n";



        echo "<th><p align=\"center\">"._btactions."</p></th>\n";

        echo "<th><p align=\"center\">"._admkeyword."</p></th>\n";

        echo "<th><p align=\"center\">"._admkeywordreason."</p></th>\n";



        echo "</thead>";



        echo "<tbody>\n";



        while ($row = $db->sql_fetchrow($res)) {

                echo "<tr>";

                echo "<td><p align=\"center\">".pic("edit.gif","admin.php?op=editfilter&id=".$row["id"])."\n".pic("drop.gif","admin.php?op=delfilter&id=".$row["id"])."</p></td>\n";

                echo "<td><p align=\"center\">".$row["keyword"]."</p></td>\n";

                echo "<td><p align=\"center\">".htmlspecialchars($row["reason"])."</p></td>\n";

                echo "</tr>";

        }



        echo "</tbody>";

        echo "</table>\n";

}



$db->sql_freeresult($res);

CloseTable();



OpenTable(_admaddkeyword);

echo "<form method=\"POST\" action=\"admin.php\"enctype=\"multipart/form-data\">\n\n";



if ($op != "editfilter") echo "<input type=\"hidden\" name=\"op\" value=\"addfilter\">\n";

else {

        echo "<input type=\"hidden\" name=\"op\" value=\"editfilter\" />\n";

        echo "<input type=\"hidden\" name=\"id\" value=\"".intval($id)."\" />\n";

        $row = $db->sql_fetchrow($res_edit);

        $db->sql_freeresult($res_edit);

}



echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";

echo "<tr>\n";

echo "<td><p>"._admkeyword."</p></td>\n";

if ($op != "editfilter") 
{
echo "<td><input type=\"text\" name=\"keyword\" size=\"20\" /></td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td><p>"._admkeywordreason."</p></td>\n";
echo "<td><input type=\"text\" name=\"whatfor\" size=\"20\" /></td>\n";
echo "</tr>\n";

echo "</table>\n";
}else{
echo "<td><input type=\"text\" name=\"keyword\" size=\"50\" value =\"".$row["keyword"]."\" /></td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td><p>"._admkeywordreason."</p></td>\n";
echo "<td><input type=\"text\" name=\"whatfor\" size=\"50\" value=\"".$row["reason"]."\" /></td>\n";
echo "</tr>\n";

echo "</table>\n";

}
echo "<p><input type=\"submit\" value=\""._btsend."\" /></p>\n";

echo "</form>\n";

CloseTable();

?>