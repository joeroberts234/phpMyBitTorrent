<?php
/*
*----------------------------phpMyBitTorrent V 2.0.5---------------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*/
$cfgquery = "SELECT * FROM ".$db_prefix."_avatar_config;";
$cfgres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
$db->sql_freeresult($cfgres);
if(isset($do) && $do == "save")
{
        $errors = array();
        $sqlfields = array();
        $sqlvalues = array();
		
		       if($config['allow_avatar'] != ""){
			   $sqlfields[] = (($config['allow_avatar'] == 0)? "false" : "true");
			   $sqlvalues[] = "enable_avatars";
			   }
			   else
			   $errors[] = "1";
			   
			   if($config['allow_avatar_local'] != ""){
			   $sqlfields[] = (($config['allow_avatar_local'] == 0)? "false" : "true");
			   $sqlvalues[] = "enable_gallery_avatars";
			   }
			   else
			   $errors[] = "2";
			   
			   if($config['allow_avatar_remote'] != ""){
			   $sqlfields[] = (($config['allow_avatar_remote'] == 0)? "false" : "true");
			   $sqlvalues[] = "enable_remote_avatars";
			   }
			   else
			   $errors[] = "3";
			   
			   if($config['allow_avatar_upload'] != ""){
			   $sqlfields[] = (($config['allow_avatar_upload'] == 0)? "false" : "true");
			   $sqlvalues[] = "enable_avatar_uploading";
			   }
			   else
			   $errors[] = "4";
			   
			   if($config['allow_avatar_remote_upload'] != ""){
			   $sqlfields[] = (($config['allow_avatar_remote_upload'] == 0)? "false" : "true");
			   $sqlvalues[] = "enable_remote_avatar_uploading";
			   }
			   else
			   $errors[] = "5";
			   
			   if(isset($config['avatar_filesize']) AND is_numeric($config['avatar_filesize'])){
			   $sqlfields[] = $config['avatar_filesize'];
			   $sqlvalues[] = "maximum_avatar_file_size";
			   }
			   else
			   $errors[] = "6";
			   
			   if(isset($config['avatar_min_width']) AND is_numeric($config['avatar_min_width'])){
			   $sqlfields[] = $config['avatar_min_width'];
			   $sqlvalues[] = "minimum_avatar_dimensions_wt";
			   }
			   else
			   $errors[] = "7";
			   
			   
			   if(isset($config['avatar_min_height']) AND is_numeric($config['avatar_min_height'])){
			   $sqlfields[] = $config['avatar_min_height'];
			   $sqlvalues[] = "minimum_avatar_dimensions_ht";
			   }
			   else
			   $errors[] = "9";
			   
			   if(isset($config['avatar_max_width']) AND is_numeric($config['avatar_max_width'])){
			   $sqlfields[] = $config['avatar_max_width'];
			   $sqlvalues[] = "maximum_avatar_dimensions_wt";
			   }
			   else
			   $errors[] = "10";
			   
			   if(isset($config['avatar_max_height']) AND is_numeric($config['avatar_max_height'])){
			   $sqlfields[] = $config['avatar_max_height'];
			   $sqlvalues[] = "maximum_avatar_dimensions_ht";
			   }
			   else
			   $errors[] = "11";

if(!isset($config['avatar_path']) OR $config['avatar_path'] == "" OR !is_dir($config['avatar_path']))
{
$errors[] = "No such Dir {$config[avatar_path]}";
}
elseif(!is_writable($config['avatar_path'])){
$errors[] = "Dir {$config[avatar_path]} is not writable";
}else{
			   $sqlfields[] = $config['avatar_path'];
			   $sqlvalues[] = "avatar_storage_path";
}
if(!isset($config['avatar_gallery_path']) OR $config['avatar_gallery_path'] == "" OR !is_dir($config['avatar_gallery_path']))
{
$errors[] = "No such Dir {$config[avatar_gallery_path]}";
}
elseif(!is_readable($config['avatar_gallery_path'])){
$errors[] = "Dir {$config[avatar_gallery_path]} is not writable";
}else{
			   $sqlfields[] = $config['avatar_gallery_path'];
			   $sqlvalues[] = "avatar_gallery_path";
}
        if (count($errors) > 0)
		{
		bterror($errors,"Avatar settings not saved",false);
		}
		else
		{
        $sql = "INSERT INTO ".$db_prefix."_avatar_config (".implode(", ",$sqlvalues).") VALUES ('".implode("', '",$sqlfields)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_avatar_config;");
        $db->sql_query($sql);
		$pmbt_cache->remove_file("sql_".md5("avatar").".php");
        header("Location: admin.php?op=avatar&saved=1#avatar");
        die();
		}

}
if (isset($saved)) {
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}

OpenTable("Avatar settings");
            echo "<div id=\"main_avatar\"style=\"color:#000000;\">\n";
            echo "<a name=\"maincontent\"></a>\n";
OpenMessTable("Avatar settings");
            echo "<p>Avatars are generally small, unique images a user can associate with themselves. Depending on the style they are usually displayed below the username when viewing topics. Here you can determine how users can define their avatars. Please note that in order to upload avatars you need to have created the directory you name below and ensure it can be written to by the web server. Please also note that file size limits are only imposed on uploaded avatars, they do not apply to remotely linked images.</p>\n";
CloseMessTable();
            echo "<form id=\"acp_board\" method=\"post\" action=\"./admin.php?op=avatar#avatar\">\n";
			echo "<input type=\"hidden\" name=\"do\" value=\"save\" />\n";
            echo "<fieldset style=\"margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; \">\n";
			echo "<legend style=\"padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: .9em;font-weight: bold;color: #115098;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;\">Avatar settings</legend>\n";
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar\">Enable avatars:</label><br><span>Allow general usage of avatars;<br>If you disable avatars in general or avatars of a certain mode, the disabled avatars will no longer be shown on the board, but users will still be able to download their own avatars in the User Control Panel.</span></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"allow_avatar\" name=\"config[allow_avatar]\" value=\"1\" ".(($cfgrow['enable_avatars'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[allow_avatar]\" value=\"0\" ".(($cfgrow['enable_avatars'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
			echo "<hr></dl>\n";
    		echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar_local\">Enable gallery avatars:</label></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"allow_avatar_local\" name=\"config[allow_avatar_local]\" value=\"1\" ".(($cfgrow['enable_gallery_avatars'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[allow_avatar_local]\" value=\"0\" ".(($cfgrow['enable_gallery_avatars'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
		    echo "<hr></dl>\n";
 		    echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar_remote\">Enable remote avatars:</label><br><span>Avatars linked to from another website.</span></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"allow_avatar_remote\" name=\"config[allow_avatar_remote]\" value=\"1\" ".(($cfgrow['enable_remote_avatars'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[allow_avatar_remote]\" value=\"0\" ".(($cfgrow['enable_remote_avatars'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
		    echo "<hr></dl>\n";
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar_upload\">Enable avatar uploading:</label></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"allow_avatar_upload\" name=\"config[allow_avatar_upload]\" value=\"1\" ".(($cfgrow['enable_avatar_uploading'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[allow_avatar_upload]\" value=\"0\" ".(($cfgrow['enable_avatar_uploading'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
		    echo "<hr></dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dl>\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar_remote_upload\">Enable remote avatar uploading:</label><br><span>Allow uploading of avatars from another website.</span></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"allow_avatar_remote_upload\" name=\"config[allow_avatar_remote_upload]\" value=\"1\" ".(($cfgrow['enable_remote_avatar_uploading'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[allow_avatar_remote_upload]\" value=\"0\" ".(($cfgrow['enable_remote_avatar_uploading'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
		    echo "<hr></dl>\n";
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"avatar_filesize\">Maximum avatar file size:</label><br><span>For uploaded avatar files.</span></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"avatar_filesize\" size=\"4\" maxlength=\"10\" name=\"config[avatar_filesize]\" value=\"".$cfgrow['maximum_avatar_file_size']."\" type=\"text\"> Bytes</dd>\n";
		    echo "<hr></dl>\n";
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"avatar_min\">Minimum avatar dimensions:</label><br><span>Width x Height in pixels.</span></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"avatar_min\" size=\"3\" maxlength=\"4\" name=\"config[avatar_min_width]\" value=\"".$cfgrow['minimum_avatar_dimensions_wt']."\" type=\"text\"> x <input size=\"3\" maxlength=\"4\" name=\"config[avatar_min_height]\" value=\"".$cfgrow['minimum_avatar_dimensions_ht']."\" type=\"text\"> px</dd>\n";
		    echo "<hr></dl>\n";
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"avatar_max\">Maximum avatar dimensions:</label><br><span>Width x Height in pixels.</span></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"avatar_max\" size=\"3\" maxlength=\"4\" name=\"config[avatar_max_width]\" value=\"".$cfgrow['maximum_avatar_dimensions_wt']."\" type=\"text\"> x <input size=\"3\" maxlength=\"4\" name=\"config[avatar_max_height]\" value=\"".$cfgrow['maximum_avatar_dimensions_ht']."\" type=\"text\"> px</dd>\n";
		    echo "<hr></dl>\n";
	        echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"avatar_path\">Avatar storage path:</label><br><span>Path under your Tracker root directory, e.g. <samp>avatar/users</samp>.</span></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"avatar_path\" size=\"20\" maxlength=\"255\" name=\"config[avatar_path]\" value=\"".$cfgrow['avatar_storage_path']."\" type=\"text\"></dd>\n";
		    echo "<hr></dl>\n";
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"avatar_gallery_path\">Avatar gallery path:</label><br><span>Path under your Tracker root directory for pre-loaded images, e.g. <samp>avatar</samp>.</span></dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"avatar_gallery_path\" size=\"20\" maxlength=\"255\" name=\"config[avatar_gallery_path]\" value=\"".$cfgrow['avatar_gallery_path']."\" type=\"text\"></dd>\n";
		    echo "<hr></dl>\n";
		    echo "<p class=\"submit-buttons\">\n";
		    echo "<input class=\"button1\" id=\"submit\" name=\"submit\" value=\"Submit\" type=\"submit\">&nbsp;\n";
		    echo "<input class=\"button2\" id=\"reset\" name=\"reset\" value=\"Reset\" type=\"reset\">\n";
	        echo "</p>\n";
            echo "</fieldset>\n";
            echo "</form>\n";
            echo "</div>\n";
CloseTable();
?>