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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
include'include/textarea.php';
?>
<script type="text/javascript" src="bbcode.js"></script>
<?php

$cfgquery = "SELECT * FROM ".$db_prefix."_shout_config;";
$cgfres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
$db->sql_freeresult($cfgres);
echo "<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
function drawRow($param, $type, $options = NULL) {
        global $cfgrow, $textarea;
        echo "<tr>";
        echo "<td width=\"16\">";
        help(pic("help.gif"),constant("_admp".$param."explain"),constant("_admp".$param));
        echo "</td>\n";
        echo "<td>".constant("_admp".$param)."</td>\n";
        echo "<td align=\"right\">";
        if ($type == "text") {
                echo "<input type=\"text\" name=\"sub_".$param."\" value=\"".$cfgrow[$param]."\" size=\"40\">";
        } elseif ($type == "select") {
                echo "<select name=\"sub_".$param."\">\n";
                foreach ($options as $key=>$val) {
                        echo "<option ";
                        if ($cfgrow[$param] == $key) echo "selected";
                        echo " value=\"".$key."\">".$val."</option>\n";
                }
                echo "</select>";
        } elseif ($type == "checkbox") {
                echo "<input type=\"checkbox\" name=\"sub_".$param."\" value=\"true\" ";
                if ($cfgrow[$param] == "true") echo "checked";
                echo ">";
        } elseif ($type == "textarea") {
                echo $textarea->quick_bbcode('formdata',"sub_".$param);
                echo $textarea->input("sub_".$param,'center','2','10','60',$cfgrow[$param]);
				echo "</table>\n";
                echo "</p>";


        }
        echo "</td>\n";
        echo "</tr>\n";
}

function esc_magic($x) {
        if (!get_magic_quotes_gpc()) return escape($x);
        else return $x;
}
if ($do == "saveshout") {
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();
        array_push($params,"announce_ment"); array_push($values,esc_magic($sub_announce_ment));
        array_push($params,"shoutnewuser"); array_push($values,$sub_shoutnewuser);
        array_push($params,"shout_new_torrent"); array_push($values,$sub_shout_new_torrent);
        array_push($params,"shout_new_porn"); array_push($values,$sub_shout_new_porn);
        array_push($params,"turn_on"); array_push($values,$sub_turn_on);
        array_push($params,"refresh_time"); array_push($values,intval($sub_refresh_time));
        array_push($params,"shouts_to_show"); array_push($values,intval($sub_shouts_to_show));
        if ($sub_bbcode_on != "yes") $sub_bbcode_on = "no"; array_push($params,"bbcode_on"); array_push($values,$sub_bbcode_on);
        if ($sub_allow_url != "yes") $sub_allow_url = "no"; array_push($params,"allow_url"); array_push($values,$sub_allow_url);
        array_push($params,"autodelete_time"); array_push($values,intval($sub_autodelete_time));
        if ($sub_canedit_on != "yes") $sub_canedit_on = "no"; array_push($params,"canedit_on"); array_push($values,$sub_canedit_on);
        if ($sub_candelete_on != "yes") $sub_candelete_on = "no"; array_push($params,"candelete_on"); array_push($values,$candelete_on);

        //Now I save the settings
        //but first I test the insertion against SQL errors, or I lose everything in case of error
        $sql = "INSERT INTO ".$db_prefix."_shout_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_shout_config;");
        $db->sql_query($sql);

        //echo "INSERT INTO ".$db_prefix."_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        //Finally, I redirect the user to configuration page
        header("Location: admin.php?op=shoutbox&saved=1#shoutbox");
        die();
}
if (isset($saved)) {
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}
OpenTable("Shout Box");

echo "<form method=\"POST\" action=\"admin.php?op=shoutbox&do=saveshout\">\n";
echo "<table width=\"100%\">\n";
define("_admpannounce_ment","Shout Box Announcement ");
define("_admpannounce_mentexplain","A Text that stays at the top of shout box");
define("_admpturn_on","Turn on Shoutbox ");
define("_admpturn_onexplain","Inable or Disable shoutbox");
define("_admprefresh_time","Shoutbox refresh rate ");
define("_admprefresh_timeexplain","This is the time shoutbox refreshes");
define("_admpbbcode_on","Allow the use of BBcode in shouts ");
define("_admpbbcode_onexplain","Inable users to use the bbcodes in Ther shouts");
define("_admpautodelete_time","Auto Delete ");
define("_admpautodelete_timeexplain","This is How long you want shouts to Apear");
define("_admpcanedit_on","Can edit Shouts ");
define("_admpcanedit_onexplain","Allow Users to edit there shouts");
define("_admpcandelete_on","Can Delete Shouts ");
define("_admpcandelete_onexplain","Allow Users to delete there shouts");
define("_admpshouts_to_show","Shouts To Show ");
define("_admpshouts_to_showexplain","How Many Shouts You Want To Display");
define("_admpallow_url","Allow Links In Shouts ");
define("_admpallow_urlexplain","Allow Users to Use Links In Shouts");
define("_admpshoutnewuser","Announce New Users ");
define("_admpshoutnewuserexplain","Automaticly Shout A Welcome For New Users");
define("_admpshout_new_torrent","Announce New Torrents ");
define("_admpshout_new_torrentexplain","Automaticly Shout New Uploaded Torrents");
define("_admpshout_new_porn","Announce New Porn Torrents ");
define("_admpshout_new_pornexplain","Automaticly Shout New Uploaded Porn Torrents This Dose Not Over Ride If Announce New Torents Is Off");

drawRow("announce_ment","text");
drawRow("shoutnewuser","select",Array("yes"=>_btmodrulesyes, "no"=>_btmodrulesno));
drawRow("shout_new_torrent","select",Array("yes"=>_btmodrulesyes, "no"=>_btmodrulesno));
drawRow("shout_new_porn","select",Array("yes"=>_btmodrulesyes, "no"=>_btmodrulesno));
drawRow("turn_on","select",Array("yes"=>_btmodrulesyes, "no"=>_btmodrulesno));
drawRow("refresh_time","text");
drawRow("shouts_to_show","text");
drawRow("bbcode_on","select",Array("yes"=>_btmodrulesyes, "no"=>_btmodrulesno));
drawRow("allow_url","select",Array("yes"=>_btmodrulesyes, "no"=>_btmodrulesno));
drawRow("autodelete_time","text");
drawRow("canedit_on","select",Array("yes"=>_btmodrulesyes, "no"=>_btmodrulesno));
drawRow("candelete_on","select",Array("yes"=>_btmodrulesyes, "no"=>_btmodrulesno));
echo "</table>\n\n";
echo "<p><input type=\"submit\" value=\""._admsavebtn."\" /><input type=\"reset\" value=\""._admresetbtn."\" /></p>\n";
echo "</form>\n";

CloseTable();
?>