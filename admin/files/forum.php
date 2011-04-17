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
*---------                  This Mod is For phpBB3                  -----------*
*------                    Hacked For phpMyBitTorrent                   -------*
*----------------                 By joeroberts                   -------------*
*------------------------------------------------------------------------------*
*/

if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
define("_admpcookie_time","Cookie Time");
define("_admpcookie_timeexplain","The Cookie Time You Used When You Installed The New Forum (the tracker time is 8640000 If you set this lower then members well have to login to forum them selfs at times)");
define("_admpcookie_name","Cookie Name");
define("_admpcookie_nameexplain","The Cookie Name You Used When You Installed The New Forum");
define("_admpcookie_domain","Forum Domain");
define("_admpcookie_domainexplain","The Domain Name You Used When You Installed The New Forum");
define("_admpcookie_path","Forum Cookie Path");
define("_admpcookie_pathexplain","The Cookie Path You Used When You Installed The New Forum( Like '/')");
define("_admpprefix","Forum Data Base Prefix");
define("_admpprefixexplain","The Prefix You Used When You Installed The New Forum( phpbb, phpbb2, phpbb3)");
define("_admpbase_folder","Base Folder Your Forum Is in");
define("_admpbase_folderexplain","Show the location of your forum with out the web address");
define("_admpforum_share","Turn on Forum Share");
define("_admpforum_shareexplain","This is if you want to share the tracker members with the forum");
define("_admpauto_post","Turn on Auto Posting");
define("_admpauto_postexplain","Turn On And Off Automatic Posting of newly uploaded torrents");
define("_admpauto_post_forum","Post New Toppic In ");
define("_admpauto_post_forumexplain","This is where you want the new post to be added");
include'include/textarea.php';
?>
<script type="text/javascript" src="bbcode.js"></script>
<?php


$cfgquery = "SELECT * FROM ".$db_prefix."_admin_forum;";
$cgfres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cgfres);
$db->sql_freeresult($cgfres);

function drawRow($param, $type, $options = NULL) {
        global $cfgrow;
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

if ($do == "saveadmon_foruml") {
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();

        //Process Request

        //Then I accurately check each parameter before inserting it in SQL statement
        //Some parameters that must be numeric have to be checked with an if clause because intval() function truncates to max integer
        array_push($params,"prefix"); array_push($values,$sub_prefix);
		array_push($params,"cookie_name"); array_push($values,$sub_cookie_name);
		array_push($params,"cookie_domain"); array_push($values,$sub_cookie_domain);
		array_push($params,"cookie_path"); array_push($values,$sub_cookie_path);
		array_push($params,"cookie_time"); array_push($values,$sub_cookie_time);
		array_push($params,"base_folder"); array_push($values,$sub_base_folder);
		if (!isset($sub_forum_share) OR $sub_forum_share != "true") $sub_forum_share = "false"; array_push($params,"forum_share"); array_push($values,$sub_forum_share);
		if (!isset($sub_auto_post) OR $sub_auto_post != "true") $sub_auto_post = "false"; array_push($params,"auto_post"); array_push($values,$sub_auto_post);
		array_push($params,"auto_post_forum"); array_push($values,$sub_auto_post_forum);

        //Now I save the settings
        //but first I test the insertion against SQL errors, or I lose everything in case of error
        $sql = "INSERT INTO ".$db_prefix."_admin_forum (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_admin_forum;");
        $db->sql_query($sql);

        //Finally, I redirect the user to configuration page
        header("Location: admin.php?op=forum&saved=1");
        die();
}
if (isset($saved)) {
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}
OpenTable("Forum Integration");

echo "<form method=\"POST\" action=\"admin.php?op=forum&do=saveadmon_foruml\">\n";
echo "<table width=\"100%\">\n";

drawRow("prefix","text");
drawRow("cookie_name","text");
drawRow("cookie_domain","text");
drawRow("cookie_path","text");
drawRow("cookie_time","text");
drawRow("base_folder","text");
drawrow("forum_share","checkbox");
drawrow("auto_post","checkbox");
drawrow("auto_post_forum","text");

echo "</table>\n\n";
echo "<p><input type=\"submit\" value=\""._admsavebtn."\" /><input type=\"reset\" value=\""._admresetbtn."\" /></p>\n";
echo "</form>\n";

CloseTable();
?>