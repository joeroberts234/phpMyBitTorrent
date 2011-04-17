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

if (eregi("usercp.php",$_SERVER["PHP_SELF"])) die("You cannot access this file directly.");


function imgdescr($file,$link,$descr) {
        global $theme, $forumbase;
        return "<a href=\"".$link."\"><img title=\"".$descr."\" alt=\"".$descr."\" border=\"0\" src=\"themes/".$theme."/pics/menu/".$file."\" onmouseover=\"javascript:descriptor('".addslashes($descr)."');\" onmouseout=\"javascript:descriptor('&nbsp;')\" /></a>";
}

if ($user->user) {
        OpenTable(_btmenu);
        if (is_dir("themes/$theme/pics/menu")) {
                $pm_img = ($has_newpm) ? "newpm.png" : "pm.png";
                echo "<p align=\"center\">\n";
                echo imgdescr("home.png","index.php",_btindex);
                echo imgdescr("upload.png","upload.php",_btupload);
                echo imgdescr("mytorrents.png","mytorrents.php",_btpersonal);
                echo "<span id=\"nopm_notif\">".imgdescr($pm_img,"pm.php",_btpm)."</span>"; #Private messages are not available... yet
                echo "<br />";
		echo imgdescr("profile.png","user.php?op=profile&id=".$user->id."",_btuserprofile);
                echo imgdescr("members.png","memberslist.php",_btmemlist);
                echo imgdescr("logout.png","user.php?op=logout",_btlogout);
				echo imgdescr("forum.png","phpBB.php?page=index", "Forum");
                echo "<br />";
                echo imgdescr("arcade.png","games.php",_btgames);
                echo imgdescr("requests.png","viewrequests.php",_btviewrqst);
                echo imgdescr("faq.png","faq.php",_btfaqs);
                echo imgdescr("offers.png","offers.php",_bttorofferd);
                echo "<br />";
                if ($user->admin) echo imgdescr("admin.png","admin.php",_btadmin);
                echo "</p>\n";
                echo "<p align=\"center\" id=\"descriptor\">&nbsp;</p>";
        } else {
                echo "<p><a href=\"index.php\">"._btindex."</a><br />\n";
                echo "<a href=\"upload.php\">"._bttorrentupload."</a><br />\n";
                echo "<a href=\"mytorrents.php\">"._btpersonal.htmlspecialchars($user->name)."</a><br />\n";                
                echo "<a href=\"pm.php\">"._btpm."</a><br />\n";
                if (file_exists("include/irc.ini")) echo "<a href=\"chat.php\">"._btircchat."</a><br />\n";
                if ($user->admin) echo "<a href=\"admin.php\">"._btadmin."</a><br />\n";
                echo "<a href=\"user.php?op=logout\">"._btlogout."</a></p>\n";
        }
        echo "<p>&nbsp;</p>";
        $sql = "SELECT seedbonus, avatar, uploaded,  downloaded, invites, uploaded/downloaded AS ratio FROM ".$db_prefix."_users WHERE id = '".$user->id."';";
        $res = $db->sql_query($sql);
        list ($seedbonus, $avatar, $uploaded, $downloaded, $invites, $ratio) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<p>".pic("pic_uploaded.gif").mksize($uploaded)."<br>";
        echo pic("pic_downloaded.gif").mksize($downloaded)."<br>";
        echo pic("pic_ratio.gif");
        echo "&nbsp;";
        if ($downloaded == 0)
                echo "&infin;";
        elseif ($ratio < 0.1)
                echo "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.2)
                echo "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.3)
                echo "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.4)
                echo "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.5)
                echo "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.6)
                echo "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.7)
                echo "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.8)
                echo "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.9)
                echo "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 1)
                echo "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
        else
                echo "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
        echo "<br />\n";
        #Numer of seeding Torrents
        $sql = "SELECT P.torrent AS id, T.name as name FROM ".$db_prefix."_peers P, ".$db_prefix."_torrents T WHERE P.uid = '".$user->id."' AND P.seeder = 'yes' AND T.id = P.torrent;";
        $res = $db->sql_query($sql);
        $cnt = $db->sql_numrows($res);
        $torrents = Array();
        while ($tor = $db->sql_fetchrow($res)) {
                $torrents[] = htmlspecialchars((strlen($tor["name"]) > 33) ? substr($tor["name"],0,30)."..." : $tor["name"]);
        }
        if ($cnt > 0) help(pic("upload.gif"),"<p>".implode($torrents,"<br />")."</p>",_btyoureseeding);
        else echo pic("upload.gif",null,_btyoureseeding);
        echo $cnt;
        $db->sql_freeresult($sql);
        unset($sql, $res, $torrents, $tor, $cnt);
        #Number of downloading Torrents
        echo "<br />\n";
        $sql = "SELECT P.torrent AS id, T.name as name FROM ".$db_prefix."_peers P, ".$db_prefix."_torrents T WHERE P.uid = '".$user->id."' AND P.seeder = 'no' AND T.id = P.torrent;";
        $res = $db->sql_query($sql);
        $cnt = $db->sql_numrows($res);
        $torrents = Array();
        while ($tor = $db->sql_fetchrow($res)) {
                $torrents[] = htmlspecialchars((strlen($tor["name"]) > 33) ? substr($tor["name"],0,30)."..." : $tor["name"]);
        }
        if ($cnt > 0) help(pic("download.gif"),"<p>".implode($torrents,"<br />")."</p>",_btyoureleeching);
        else echo pic("download.gif",null,_btyoureleeching);
        echo $cnt;
        $db->sql_freeresult($sql);
        unset($sql, $res, $torrents, $tor, $cnt);
        echo "</p>";
        echo "<br />\n";
		echo "<br />\n";
		echo "<p align=\"center\"><b>"._btwelcomebk."</b></p>\n";
		echo "<p align=\"center\"><b>".$user->name."</b></p>\n";		
		echo "<b><img  src=\"avatars/".$avatar."\" alt=\"".$user->name."\"></b><br />";
		echo "<br />\n";
		print("<p>Seeding Bonus: <a href='mybonus.php'>".$seedbonus."</a></p>");

        CloseTable();
} else {
        OpenTable(_btumenu, '144');
        if (is_dir("themes/$theme/pics/menu")) {
                echo "<p align=\"center\">\n";
                echo imgdescr("home.png","index.php",_btindex);
                if ($upload_level == "all") echo imgdescr("upload.png","upload.php",_btupload);
                if (file_exists("include/irc.ini")) echo imgdescr("chat.png","chat.php",_btircchat);
                echo "</p>\n";
                echo "<p align=\"center\" id=\"descriptor\">&nbsp;</p>";
        } else {
                echo "<p><a href=\"index.php\">"._btindex."</a><br />\n";
                if ($upload_level == "all") echo "<a href=\"upload.php\">"._bttorrentupload."</a><br />\n";
                if (file_exists("include/irc.ini")) echo "<a href=\"chat.php\">"._btircchat."</a><br />\n";
                echo "</p>";
        }
        echo "<HR SIZE=1 NOSHADE>";
        echo "<p align=\"center\"><b>"._btlogin."</b></p>\n";
        echo "<p>&nbsp;</p>\n";
        echo "<form method=\"POST\" action=\"user.php\"><input type=\"hidden\" name=\"op\" value=\"login\" />\n";	
	    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\"><tr><td align=\"center\"><p>"._btusername."</p></td>\n</tr><tr><td align=\"center\"><input type=\"text\" name=\"username\" size=\"10\"></td></tr><tr><td align=\"center\"><p>"._btpassword."</p></td></tr><tr><td align=\"center\"><input type=\"password\" name=\"password\" size=\"10\"></td></tr><tr><td align=\"center\"><p>"._btremember."</p></td></tr><tr><td align=\"center\"><input type=\"checkbox\" name=\"remember\" value=\"yes\"></td></tr>";
        if ($gfx_check) {
                $rnd_code = strtoupper(RandomAlpha(5));
                echo "<p align=\"center\">"._btsecuritycode."<br><img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\" alt=\"Security Code\"><br>\n<input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\">";
                echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\">\n\n";
        }
        echo "<tr><td><p align=\"center\"><input type=\"submit\" value=\""._btlogin."\"></p></td></tr></table></form>";
        echo "<p><a href=\"user.php?op=register\">"._btsignup."</a><br />\n\n";
        echo "<a href=\"user.php?op=lostpassword\">"._btlostpassword."</a></p>\n\n";
        CloseTable();
}
?>