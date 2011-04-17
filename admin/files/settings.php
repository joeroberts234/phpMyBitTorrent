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
$cfgquery = "SELECT * FROM ".$db_prefix."_config;";
$cfgres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
$db->sql_freeresult($cfgres);
echo "<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
function drawRow2($param, $type, $options = NULL, $type2 = NULL, $options2 = NULL, $type3 = NULL, $options3 = NULL) {
        global $cfgrow, $textarea;
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\">
			<label style=\"cursor: pointer; font-size: 0.85em; padding: 0 5px 0 0;\" for=\"allow_avatar\">".constant("_admp".$param).":</label>
			<br>
			<br>
			<span style=\"padding: 0 5px 0 0;\">".constant("_admp".$param."explain")."</span>
			</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\">";
        if ($type == "text") {
                echo "<input id=\"sub_".$param."\" size=\"40\"  name=\"sub_".$param."\" value=\"".$cfgrow[$param]."\" type=\"text\">";
        } elseif ($type == "select") {
                echo "<select name=\"sub_".$param."\">\n";
                foreach ($options as $key=>$val) {
                        echo "<option ";
                        if ($cfgrow[$param] == $key) echo "selected";
                        echo " value=\"".$key."\">".$val."</option>\n";
                }
                echo "</select>";
        } elseif ($type == "checkbox") {
                echo "<label><input id=\"sub_".$param."\" class=\"checkbox\" type=\"checkbox\" name=\"sub_".$param."\" value=\"true\" ";
                if ($cfgrow[$param] == "true") echo "checked";
                echo "></label>";
        } elseif ($type == "textarea") {
                echo $textarea->quick_bbcode('formdata',"sub_".$param);
                echo $textarea->input("sub_".$param,'center','2','10','48',$cfgrow[$param]);
				echo "</table>\n";
                echo "</p>";


        }
			echo "</dd>\n";
			echo "<hr></dl>\n";
}
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

if ($op == "savesettings") {
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();

        //Process Request

        //Then I accurately check each parameter before inserting it in SQL statement
        //Some parameters that must be numeric have to be checked with an if clause because intval() function truncates to max integer
        array_push($params,"sitename"); array_push($values,esc_magic($sub_sitename));
        if ($sub_siteurl) { array_push($params,"siteurl"); array_push($values,esc_magic($sub_siteurl)); }
        array_push($params,"cookiedomain"); array_push($values,$sub_cookiedomain);
        if (preg_match('/^\/.*/', $sub_cookiepath)) { array_push($params,"cookiepath"); array_push($values,esc_magic($sub_cookiepath)); }
        if (is_email($sub_admin_email)) { array_push($params,"admin_email"); array_push($values,esc_magic($sub_admin_email)); }
        if (file_exists("language/".$sub_language.".php")) { array_push($params,"language"); array_push($values,$sub_language); }
        if (is_dir("themes/".$sub_theme)) { array_push($params,"theme"); array_push($values,$sub_theme); }
        array_push($params,"welcome_message"); array_push($values,esc_magic($sub_welcome_message));
        array_push($params,"announce_text"); array_push($values,esc_magic($sub_announce_text));
        if ($sub_allow_html != "true") $sub_allow_html = "false"; array_push($params,"allow_html"); array_push($values,$sub_allow_html);
        if ($sub_rewrite_engine != "true") $sub_rewrite_engine = "false"; array_push($params,"rewrite_engine"); array_push($values,$sub_rewrite_engine);
        array_push($params,"torrent_prefix"); array_push($values,$sub_torrent_prefix);
        array_push($params,"torrent_per_page"); array_push($values,intval($sub_torrent_per_page));
        if (!isset($sub_onlysearch) OR $sub_onlysearch != "true") $sub_onlysearch = "false"; array_push($params,"onlysearch"); array_push($values,$sub_onlysearch);
        array_push($params,"max_torrent_size"); array_push($values,intval($sub_max_torrent_size));
        array_push($params,"announce_interval"); array_push($values,intval($sub_announce_interval));
        array_push($params,"announce_interval_min"); if($sub_announce_interval_min > $sub_announce_interval) array_push($values,intval($sub_announce_interval)); else array_push($values,intval($sub_announce_interval_min));
        array_push($params,"dead_torrent_interval"); array_push($values,intval($sub_dead_torrent_interval));
        array_push($params,"minvotes"); array_push($values,intval($sub_minvotes));
        array_push($params,"time_tracker_update"); array_push($values,intval($sub_time_tracker_update));
        if (is_numeric($sub_give_sign_up_credit)) {array_push($params,"give_sign_up_credit"); array_push($values,$sub_give_sign_up_credit); }
        array_push($params,"best_limit"); array_push($values,intval($sub_best_limit));
        array_push($params,"down_limit"); array_push($values,intval($sub_down_limit));
        if (!isset($sub_torrent_complaints) OR $sub_torrent_complaints != "true") $sub_torrent_complaints = "false"; array_push($params,"torrent_complaints"); array_push($values,$sub_torrent_complaints);
        if (!isset($sub_torrent_global_privacy) OR $sub_torrent_global_privacy != "true") $sub_torrent_global_privacy = "false"; array_push($params,"torrent_global_privacy"); array_push($values,$sub_torrent_global_privacy);
        if (!isset($sub_disclaimer_check) OR $sub_disclaimer_check != "true") $sub_disclaimer_check = "false"; array_push($params,"disclaimer_check"); array_push($values,$sub_disclaimer_check);
        if (!isset($sub_gfx_check) OR $sub_gfx_check != "true") $sub_gfx_check = "false"; array_push($params,"gfx_check"); array_push($values,$sub_gfx_check);
        if (in_array($sub_upload_level,Array("all","user","premium"))) { array_push($params,"upload_level"); array_push($values,$sub_upload_level); }
        if (in_array($sub_download_level,Array("all","user","premium"))) { array_push($params,"download_level"); array_push($values,$sub_download_level); }
        if (!isset($sub_pivate_mode) OR $sub_pivate_mode != "true") $sub_pivate_mode = "false"; array_push($params,"pivate_mode"); array_push($values,$sub_pivate_mode);
        if (!isset($sub_force_passkey) OR $sub_force_passkey != "true") $sub_force_passkey = "false"; array_push($params,"force_passkey"); array_push($values,$sub_force_passkey);
        if ($sub_announce_level != "all") $sub_announce_level = "user"; array_push($params,"announce_level"); array_push($values,$sub_announce_level);
        array_push($params,"max_num_file"); array_push($values,intval($sub_max_num_file));
        if (is_numeric($sub_max_share_size)) { array_push($params,"max_share_size"); array_push($values,$sub_max_share_size); }
        if (is_numeric($sub_min_size_seed)) { array_push($params,"min_size_seed"); array_push($values,$sub_min_size_seed); }
        if (is_numeric($sub_min_share_seed)) { array_push($params,"min_share_seed"); array_push($values,$sub_min_share_seed); }
        array_push($params,"global_min_ratio"); array_push($values,number_format($sub_global_min_ratio,2));
        if (!isset($sub_autoscrape) OR $sub_autoscrape != "true") $sub_autoscrape = "false"; array_push($params,"autoscrape"); array_push($values,$sub_autoscrape);
        if (is_numeric($sub_min_num_seed_e)) { array_push($params,"min_num_seed_e"); array_push($values,$sub_min_num_seed_e); }
        if (is_numeric($sub_min_size_seed_e)) { array_push($params,"min_size_seed_e"); array_push($values,$sub_min_size_seed_e); }
        if (is_numeric($sub_minupload_file_size)) {array_push($params,"minupload_file_size"); array_push($values,$sub_minupload_file_size); }
        if (!isset($sub_allow_multy_tracker) OR $sub_allow_multy_tracker != "true") $sub_allow_multy_tracker = "false"; array_push($params,"allow_multy_tracker"); array_push($values,$sub_allow_multy_tracker);
        if (!isset($sub_allow_backup_tracker) OR $sub_allow_backup_tracker != "true") $sub_allow_backup_tracker = "false"; array_push($params,"allow_backup_tracker"); array_push($values,$sub_allow_backup_tracker);
        if (!isset($sub_allow_external) OR $sub_allow_external != "true") $sub_allow_external = "false"; array_push($params,"allow_external"); array_push($values,$sub_allow_external);
        if (!isset($sub_stealthmode) OR $sub_stealthmode != "true") $sub_stealthmode = "false"; array_push($params,"stealthmode"); array_push($values,$sub_stealthmode);
        if (!isset($sub_upload_dead) OR $sub_upload_dead != "true") $sub_upload_dead = "false"; array_push($params,"upload_dead"); array_push($values,$sub_upload_dead);
        if (!isset($sub_invites_open) OR $sub_invites_open != "true") $sub_invites_open = "false"; array_push($params,"invites_open"); array_push($values,$sub_invites_open);
        if (!isset($sub_invite_only) OR $sub_invite_only != "true") $sub_invite_only = "false"; array_push($params,"invite_only"); array_push($values,$sub_invite_only);
        if (is_numeric($sub_max_members)) {array_push($params,"max_members"); array_push($values,$sub_max_members); }
        if (is_numeric($sub_auto_clean)) {array_push($params,"auto_clean"); array_push($values,$sub_auto_clean); }
        if (!isset($sub_free_dl) OR $sub_free_dl != "true") $sub_free_dl = "false"; array_push($params,"free_dl"); array_push($values,$sub_free_dl);
        if (!isset($sub_addprivate) OR $sub_addprivate != "true") $sub_addprivate = "false"; array_push($params,"addprivate"); array_push($values,$sub_addprivate);
        if (is_numeric($sub_GIGSA)) {array_push($params,"GIGSA"); array_push($values,$sub_GIGSA); }
        if (is_numeric($sub_RATIOA)) {array_push($params,"RATIOA"); array_push($values,$sub_RATIOA); }
        if (is_numeric($sub_WAITA)) {array_push($params,"WAITA"); array_push($values,$sub_WAITA); }
        if (is_numeric($sub_GIGSB)) {array_push($params,"GIGSB"); array_push($values,$sub_GIGSB); }
        if (is_numeric($sub_RATIOB)) {array_push($params,"RATIOB"); array_push($values,$sub_RATIOB); }
        if (is_numeric($sub_WAITB)) {array_push($params,"WAITB"); array_push($values,$sub_WAITB); }
        if (is_numeric($sub_GIGSC)) {array_push($params,"GIGSC"); array_push($values,$sub_GIGSC); }
        if (is_numeric($sub_RATIOC)) {array_push($params,"RATIOC"); array_push($values,$sub_RATIOC); }
        if (is_numeric($sub_WAITC)) {array_push($params,"WAITC"); array_push($values,$sub_WAITC); }
        if (is_numeric($sub_GIGSD)) {array_push($params,"GIGSD"); array_push($values,$sub_GIGSD); }
        if (is_numeric($sub_RATIOD)) {array_push($params,"RATIOD"); array_push($values,$sub_RATIOD); }
        if (is_numeric($sub_WAITD)) {array_push($params,"WAITD"); array_push($values,$sub_WAITD); }
        array_push($params,"version"); array_push($values,$version);
        array_push($params,"most_on_line"); array_push($values,$most_users_online);
        array_push($params,"when_most"); array_push($values,$most_users_online_when);

        //Now I save the settings
        //but first I test the insertion against SQL errors, or I lose everything in case of error
        $sql = "INSERT INTO ".$db_prefix."_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_config;");
        $db->sql_query($sql);
		$pmbt_cache->remove_file("sql_".md5("config").".php");

        //echo "INSERT INTO ".$db_prefix."_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        //Finally, I redirect the user to configuration page
        header("Location: admin.php?op=settings&saved=1");
        die();
}
if (isset($saved)) {
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}
OpenTable(_admconfigttl);

echo "<form name=\"formdata\"method=\"POST\" action=\"admin.php?op=savesettings\">\n";
echo "<table width=\"100%\">\n";
echo "<tr><td width=\"100%\">&nbsp;</td></tr>";
echo "</table>";
            echo "<div id=\"main\">\n";
            echo "<fieldset style=\"margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; \">\n";
			echo "<legend style=\"padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: 2em;font-weight: bold;color: #115098;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;\">Site Settings</legend>\n";
drawRow2("sitename","text");
drawRow2("siteurl","text");
drawRow2("cookiedomain","text");
drawRow2("cookiepath","text");
drawRow2("admin_email","text");
//Language handling
{
        $languages = Array();
        $langdir = "language";
        $langhandle = opendir($langdir);
        while ($langfile = readdir($langhandle)) {
                if (eregi("\.php$",$langfile) AND strtolower($langfile) != "mailtexts.php")
                        $languages[str_replace(".php","",$langfile)] = ucwords(str_replace(".php","",$langfile));
        }
        closedir($langhandle);
        unset($langdir,$langfile);
}
drawRow2("language","select",$languages);
unset($languages);
//Theme handling
{
        $themes = Array();
        $thememaindir = "themes";
        $themehandle = opendir($thememaindir);
        while ($themedir = readdir($themehandle)) {
                if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
                        $themes[$themedir] = $themedir;
        }
        closedir($themehandle);
        unset($thememaindir,$themedir);
}
drawRow2("theme","select",$themes);
unset($themes);
drawRow2("welcome_message","textarea");
drawRow2("rewrite_engine","checkbox");
drawRow2("torrent_per_page","text");
drawRow2("pivate_mode","checkbox");
drawRow2("disclaimer_check","checkbox");
drawRow2("gfx_check","checkbox");
drawRow2("invites_open","checkbox");
drawRow2("invite_only","checkbox");
drawRow2("max_members","text");
drawRow2("auto_clean","text");
            echo "</fieldset>\n";
            echo "</div>\n";
            echo "<div id=\"main\">\n";
            echo "<fieldset style=\"margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; \">\n";
			echo "<legend style=\"padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: 2em;font-weight: bold;color: #115098;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;\">Tracking Settings</legend>\n";
drawRow2("announce_text","text");
drawRow2("allow_html","checkbox");
drawRow2("torrent_prefix","text");
drawRow2("onlysearch","checkbox");
drawRow2("time_tracker_update","text");
drawRow2("announce_level","select",Array("all"=>_admpannounce_levelopt1, "user"=>_admpannounce_levelopt2));
            echo "</fieldset>\n";
            echo "</div>\n";
            echo "<div id=\"main\">\n";
            echo "<fieldset style=\"margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; \">\n";
			echo "<legend style=\"padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: 2em;font-weight: bold;color: #115098;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;\">User Settings</legend>\n";
drawRow2("give_sign_up_credit","text");
drawRow2("conferm_email","checkbox");
drawRow2("force_passkey","checkbox");
drawRow2("global_min_ratio","text");
drawRow2("min_num_seed_e","text");
drawRow2("min_size_seed_e","text");
drawRow2("minupload_file_size","text");
drawRow2("free_dl","checkbox");
drawRow2("wait_time","checkbox");
drawRow2("GIGSA","text");
drawRow2("RATIOA","text");
drawRow2("WAITA","text");
drawRow2("GIGSB","text");
drawRow2("RATIOB","text");
drawRow2("WAITB","text");
drawRow2("GIGSC","text");
drawRow2("RATIOC","text");
drawRow2("WAITC","text");
drawRow2("GIGSD","text");
drawRow2("RATIOD","text");
drawRow2("WAITD","text");
            echo "</fieldset>\n";
            echo "</div>\n";
            echo "<div id=\"main\">\n";
            echo "<fieldset style=\"margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; \">\n";
			echo "<legend style=\"padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: 2em;font-weight: bold;color: #115098;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;\">Upload Settings</legend>\n";
drawRow2("allow_multy_tracker","checkbox");
drawRow2("max_torrent_size","text");
drawRow2("announce_interval","text");
drawRow2("announce_interval_min","text");
drawRow2("dead_torrent_interval","text");
drawRow2("minvotes","text");
drawRow2("best_limit","text");
drawRow2("down_limit","text");
drawRow2("torrent_complaints","checkbox");
drawRow2("torrent_global_privacy","checkbox");
drawRow2("upload_level","select",Array("all"=>_admpupload_levelopt1, "user"=>_admpupload_levelopt2, "premium"=>_admpupload_levelopt3));
drawRow2("download_level","select",Array("all"=>_admpdownload_levelopt1, "user"=>_admpdownload_levelopt2, "premium" => _admpdownload_levelopt3));
drawRow2("max_num_file","text");
drawRow2("max_share_size","text");
drawRow2("addprivate","checkbox");
            echo "</fieldset>\n";
            echo "</div>\n";
            echo "<div id=\"main\">\n";
            echo "<fieldset style=\"margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; \">\n";
			echo "<legend style=\"padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: 2em;font-weight: bold;color: #115098;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;\">External Torrent Settings</legend>\n";
drawRow2("allow_external","checkbox");
drawRow2("autoscrape","checkbox");
drawRow2("upload_dead","checkbox");
drawRow2("allow_backup_tracker","checkbox");
drawRow2("stealthmode","checkbox");

            echo "</fieldset>\n";
            echo "</div>\n";
echo "<p><input type=\"submit\" value=\""._admsavebtn."\" /><input type=\"reset\" value=\""._admresetbtn."\" /></p>\n";
echo "</form>\n";

CloseTable();
?>