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
*------                    Hacked For phpMyBitTorrent                   -------*
*----------------                 By joeroberts                   -------------*
*------------------------------------------------------------------------------*
*/
if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
include'include/textarea.php';
?>
<script type="text/javascript" src="bbcode.js"></script>
<?php

$cfgquery = "SELECT * FROM ".$db_prefix."_paypal;";
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

if ($do == "saveadmon_paypal") {
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();

        //Process Request

        //Then I accurately check each parameter before inserting it in SQL statement
        //Some parameters that must be numeric have to be checked with an if clause because intval() function truncates to max integer
        if (is_url($sub_siteurl)) { array_push($params,"siteurl"); array_push($values,esc_magic($sub_siteurl)); }
		if (is_email($sub_paypal_email)) { array_push($params,"paypal_email"); array_push($values,esc_magic($sub_paypal_email)); }
		if (!isset($sub_donation_block) OR $sub_donation_block != "true") $sub_donation_block = "false"; array_push($params,"donation_block"); array_push($values,$sub_donation_block);
		if (is_numeric($sub_sitecost)) { array_push($params,"sitecost"); array_push($values,$sub_sitecost); }
		if (is_numeric($sub_reseaved_donations)) { array_push($params,"reseaved_donations"); array_push($values,$sub_reseaved_donations); }
		array_push($params,"donatepage"); array_push($values,esc_magic($sub_donatepage));
        if (in_array($sub_nodonate,Array("EU","UK","US"))) { array_push($params,"nodonate"); array_push($values,$sub_nodonate); }

        //Now I save the settings
        //but first I test the insertion against SQL errors, or I lose everything in case of error
        $sql = "INSERT INTO ".$db_prefix."_paypal (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_paypal;");
        $db->sql_query($sql);
		$pmbt_cache->remove_file("sql_".md5("paypal").".php");

        //echo "INSERT INTO ".$db_prefix."_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        //Finally, I redirect the user to configuration page
        header("Location: admin.php?op=admin_paypal&saved=1");
        die();
}
if (isset($saved)) {
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}
OpenTable(_admconfigttl);

echo "<form name=\"formdata\" method=\"POST\" action=\"admin.php?op=admin_paypal&do=saveadmon_paypal\">\n";
echo "<table width=\"100%\">\n";

drawRow("siteurl","text");
drawRow("paypal_email","text");
drawrow("donation_block","checkbox");
drawRow("sitecost","text");
drawRow("reseaved_donations","text");
drawRow("donatepage","textarea");
drawRow("nodonate","select",Array("EU"=>_admpnodonateopt1, "UK"=>_admpnodonateopt2, "US" => _admpnodonateopt3));

echo "</table>\n\n";
echo "<p><input type=\"submit\" value=\""._admsavebtn."\" /><input type=\"reset\" value=\""._admresetbtn."\" /></p>\n";
echo "</form>\n";

CloseTable();
?>