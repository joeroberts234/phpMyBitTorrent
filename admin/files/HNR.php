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
ALTER TABLE `torrent_hit_n_run` ADD `demote_hnr_users` ENUM( 'true', 'false' ) NOT NULL DEFAULT 'false' AFTER `hnr_system` ,
ADD `ban_hnr_users` ENUM( 'true', 'false' ) NOT NULL DEFAULT 'false' AFTER `demote_hnr_users` ,
ADD `demote_time` INT( 10 ) NOT NULL DEFAULT '0' AFTER `ban_hnr_users` ,
ADD `demote_hnr_users_to` VARCHAR( 225 ) NOT NULL DEFAULT 'user',
ADD `after_high_hnr` INT( 10 ) NOT NULL DEFAULT '0' AFTER `demote_time` ,
ADD `ban_time` INT( 10 ) NOT NULL DEFAULT '0' AFTER `after_high_hnr` */
$cfgquery = "SELECT * FROM ".$db_prefix."_hit_n_run;";
$cgfres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
$db->sql_freeresult($cfgres);
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
		if($param =='demote_hnr_users_to'){
		echo selectaccess($cfgrow[$param]);
		}
		else
		{
                echo "<select name=\"sub_".$param."\">\n";
                foreach ($options as $key=>$val) {
                        echo "<option ";
                        if ($cfgrow[$param] == $key) echo "selected";
                        echo " value=\"".$key."\">".$val."</option>\n";
                }
                echo "</select>";
		}
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
if ($do == "savehnr") {
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();
        if (!isset($sub_hnr_system) OR $sub_hnr_system != "true") $sub_hnr_system = "false"; array_push($params,"hnr_system"); array_push($values,$sub_hnr_system);
        if (is_numeric($sub_seedtime)) { array_push($params,"seedtime"); array_push($values,$sub_seedtime); }
        if (is_numeric($sub_time_before_warn)) { array_push($params,"time_before_warn"); array_push($values,$sub_time_before_warn); }
        if (is_numeric($sub_maxhitrun)) { array_push($params,"maxhitrun"); array_push($values,$sub_maxhitrun); }
        if (is_numeric($sub_warnlength)) { array_push($params,"warnlength"); array_push($values,$sub_warnlength); }
        $sql = "INSERT INTO ".$db_prefix."_hit_n_run (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_hit_n_run;");
        $db->sql_query($sql);

        //echo "INSERT INTO ".$db_prefix."_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        //Finally, I redirect the user to configuration page
        header("Location: admin.php?op=HNR&saved=1#HNR");
        die();
}
if (isset($saved)) {
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}
OpenTable("Hit and Runners");

echo "<form name=\"formdata\" method=\"POST\" action=\"admin.php#HNR\">\n";
echo"<input type=hidden name=op value=HNR>";
echo"<input type=hidden name=do value=savehnr>";
echo "<table width=\"100%\">\n";
drawRow("hnr_system","checkbox");
drawRow("seedtime","text");
drawRow("time_before_warn","text");
drawRow("maxhitrun","text");
drawRow("warnlength","text");
drawRow("ban_hnr_users","checkbox");
drawRow("demote_hnr_users","checkbox");
drawRow("demote_hnr_users_to","select");
drawRow("after_high_hnr","text");
drawRow("ban_time","text");
echo "</table>\n\n";
echo "<p><input type=\"submit\" value=\""._admsavebtn."\" /><input type=\"reset\" value=\""._admresetbtn."\" /></p>\n";
echo "</form>\n";

CloseTable();
?>