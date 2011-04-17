<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta4-----------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*----------         Developed By Emad Hossam (aka emadness)          ----------*
*-------------               http://www.fulldls.com               -------------*
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
*------              �2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
if (!eregi("frame.php",$_SERVER["PHP_SELF"])) die("You can't include this file");

require_once("include/config.php");

function error($string) {
        OpenErrTable("Error");
        if (is_array($error)) {
                echo _btalertmsg;
                echo "<UL>";
                foreach ($error as $msg) {
                        echo "<LI>".$msg."</LI>";
                }
                echo "</UL>";
        } else {
                 echo "<p class=\"errortext\">".$error."</p>";
        }
        echo "<p class=\"errortext\">"._btgoback."</p>";
        CloseErrTable();
        die();
}

if (isset($btlanguage) AND is_readable("language/".$btlanguage.".php")) $language = $btlanguage;
if (isset($bttheme) AND is_readable("themes/".$bttheme."/main.php")) $theme = $bttheme;


if (is_readable("language/$language.php"))
        include_once("language/$language.php");
else
        include_once("language/english.php");

if (is_readable("themes/$theme/main.php")) {
        require_once("themes/$theme/main.php");
} else {
        die("You should not see this...");
}

echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
echo "<html>\n";
echo "<head>\n";
echo "<title>$sitename</title>\n";

if (is_readable("themes/$theme/style.css")) {
        echo "<LINK REL=\"StyleSheet\" HREF=\"themes/$theme/style.css\" TYPE=\"text/css\">\n\n\n";
}
overlib_init();
echo "</head>\n";
echo "<body>\n";
echo "<div id=\"overDiv\" style=\"position:absolute; visibility:hidden; z-index:1000;\"></div>";

switch ($op) {
        case "filelist": {
                if (!isset($id) OR !is_numeric($id) OR $id < 1) error(_bterridnotset);
                $password = urldecode($password);
                $sql = "SELECT password FROM ".$db_prefix."_torrents WHERE id = '".$id."' AND (password IS NULL OR password = '".$password."') LIMIT 1;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1) die(); //Password is wrong or not set
                $db->sql_freeresult($res);

                $sql = "SELECT A.id as id, A.seeders, A.banned, A.leechers, A.info_hash, A.filename, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, A.numratings, A.name, IF(A.numratings < '$minvotes', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, A.save_as, A.descr, A.visible, A.size, A.added, A.views, A.downloaded, A.completed, A.type, A.numfiles, A.owner, A.ownertype, A.complaints, A.evidence, A.tracker, B.name AS cat_name, IF(C.name IS NULL, C.username, C.name) as ownername, A.tracker_update, IF(A.tracker_update>(sysdate()-INTERVAL 15 MINUTE), 0, 1) as can_tracker_update FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id WHERE A.id = '".$id."';";
                $res = $db->sql_query($sql) or btsqlerror($sql);
                $torrent = $db->sql_fetchrow($res);


                if (can_download($btuser,$torrent)) {
                        $can_access = true;
                } else{
                        $can_access = false;
                }

                if(!$fres = $db->sql_query("SELECT * FROM ".$db_prefix."_files WHERE torrent = '".$torrent["id"]."' ORDER BY id")) btsqlerror("SELECT * FROM ".$db_prefix."_files WHERE torrent = '".$id."' ORDER BY id");
                echo "<table class=\"filelist\" width=\"100%\" border=\"0\">\n<thead><tr><td><p></p></td><td align=\"center\"><p><b>"._btname."</b></p></td><td align=\"center\"><p><b>"._btsize."</b></p></td><td align=\"center\"><p><b>"._btmagnetlink."</b></p></td><td align=\"center\"><p><b>"._bted2klink."</b></p></td></tr>\n</thead>\n<tbody>";
                while ($frow = $db->sql_fetchrow($fres)) {
                        echo "<tr>";
                        //File extension lookup
                        preg_match('/^(?P<name>.*)\\.(?P<ext>[A-Za-z0-9]+)$/', $frow["filename"], $filename);
                        $ext = strtolower($filename["ext"]);
                        $name = $filename["name"];
                        if (!file_exists("file_icons/".$ext.".png")) $ext = "unknown";
                        echo "<td align\"right\"><p><img src=\"file_icons/".$ext.".png\" alt=\"Icon\"></p></td>";
                        echo "<td align=\"left\"><p>";
                        echo htmlspecialchars(str_replace(Array(".","_"),Array(" "," "),stripslashes($name))).".".$filename["ext"];
                        echo "</p></td>";
                        echo "<td align=\"center\"><p>" . mksize($frow["size"]) . "</p></td>";
                        if($frow["magnet"] != "" AND $can_access) echo "<td align=\"center\"><p><a href=\"".stripslashes($frow["magnet"])."\">".pic("magnet_active.gif","",_btmagnetlinkdownload)."</a></p></td>";
                        else echo "<td align=\"center\">".pic("magnet_inactive.gif","",_btnomagnet)."</td>";
                        if($frow["ed2k"] != "" AND $can_access) echo "<td align=\"center\"><p><a href='".str_replace("'","",$frow["ed2k"])."'>".pic("ed2k_active.gif","",_bted2klinkdownload)."</a></p></td>";
                        else echo "<td align=\"center\"><p>".pic("ed2k_inactive.gif","",_btnoed2k)."</p></td>";
                        echo "</tr>\n";
                }
                echo "</tbody>\n</table>\n";
                $db->sql_freeresult($fres);
                break;
        }
        case "commentlist": {
                if (!isset($id) OR !is_numeric($id) OR $id < 1) error(_bterridnotset);
                $password = urldecode($password);
                $sql = "SELECT password FROM ".$db_prefix."_torrents WHERE id = '".$id."' AND (password IS NULL OR password = '".$password."') LIMIT 1;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1) die(); //Password is wrong or not set
                $db->sql_freeresult($res);
                $sql = "SELECT C.*, U.id as uid, U.username, U.name, IF(U.name IS NULL, U.username, U.name) as user_name, U.avatar as user_avatar FROM ".$db_prefix."_comments C LEFT JOIN ".$db_prefix."_users U ON C.user = U.id WHERE C.torrent ='".$id."' ORDER BY added ASC;";
                $res = $db->sql_query($sql) or btsqlerror($sql);
                if ($db->sql_numrows($res) < 1) {
                        echo "<h3 align=\"center\" class=\"title\">"._btnocommentsyet."</h3>";
                } else while ($comment = $db->sql_fetchrow($res)) {
                        echo "<a name=\"comm".$comment["id"]."\"></a><table width=\"100%\" class=\"main\">";
                        echo "<thead>\n<tr><td class=\"colhead\">";
                        $search = Array("**user**","**uid**","**time**");
                        $replace = Array(htmlspecialchars($comment["user_name"]),$comment["uid"],formatTimestamp($comment["added"]));
                        echo str_replace($search,$replace,_btcommheader);
                        echo "</td>\n</tr>\n</thead>\n";
                        echo "<tbody>\n<tr><td>";
                        echo "<table width=\"100%\">\n</tr>\n<td width=\"100\">";
                        echo gen_avatar($comment["uid"]);
                        echo "</td>\n<td>";
						$body = stripslashes(format_comment($comment["text"]));
                        parse_smiles($body);
                        if ($user->admin OR $user->id == $comment["user"]) echo "<div align=\"right\"><a href=\"comment.php?op=delete&id=".$id."&cid=".$comment["id"]."\" target=\"_top\">".pic("drop.gif")."</a></div>";
                        echo "<div align=\"justify\">".$body."</div>";
                        echo "</td>\n</tr>\n</table>\n";
                        echo "</td>\n</tr>\n</tbody>\n";
                        echo "</table>";
                }
                break;
        }
        case "peerlist": {
                if (!isset($id) OR !is_numeric($id) OR $id < 1) error(_bterridnotset);
                $password = urldecode($password);
                $sql = "SELECT password FROM ".$db_prefix."_torrents WHERE id = '".$id."' AND (password IS NULL OR password = '".$password."') LIMIT 1;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1) die(); //Password is wrong or not set
                $db->sql_freeresult($res);
                $i = 0;
                $tropen = false;
                $sql = "SELECT P.id AS pid, P.peer_id AS peer_id, P.downloaded AS downloaded, P.uploaded AS uploaded, P.download_speed AS download_speed, P.upload_speed AS upload_speed, P.ip AS ip, P.real_ip AS real_ip, P.to_go AS to_go, P.seeder AS seeder, UNIX_TIMESTAMP(P.started) AS started_ts, UNIX_TIMESTAMP(P.last_action) AS last_action_ts, P.connectable AS connectable, P.client AS client, P.version AS clientversion, U.id AS uid, U.username AS username, U.name AS name, U.avatar AS avatar, U.level AS level, T.size AS torrent_size FROM ".$db_prefix."_peers P LEFT JOIN ".$db_prefix."_users U ON U.id = P.uid LEFT JOIN ".$db_prefix."_torrents T ON T.id = P.torrent WHERE P.torrent = '".$id."' ORDER BY P.seeder ASC;";
                $res = $db->sql_query($sql) or print_r($db->sql_error());
                if ($db->sql_numrows($res) < 1) break;

                echo "<meta http-equiv=\"refresh\" content=\"360;url=frame.php?op=peerlist&id=".$id."&password=".urlencode($password)."\" />\n";
                echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"peertable\">\n";
                while ($row = $db->sql_fetchrow($res)) {
                        if (!$tropen) {
                                echo "<tr style=\"height:150px\">\n";
                                $tropen = true;
                        }
                        #This box contains all data of the single user
                        echo "<td width=\"20%\">\n";
                        echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";


                        echo "<tr>\n<td style=\"vertical-align:bottom\">";
                        #This table contains peer attributes
                        echo "<div align=\"center\">";
                        echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:90px;\">";
                        echo "<tr>";

                        #Column not yet assigned
                        echo "<td width=\"20%\">";
                        echo "<p align=\"center\">";
						$perc = sprintf("%.2f%%", (1 - ($row["to_go"] / $row["torrent_size"])) * 100);
                        $s = _btuploadedbts.": ".mksize($row["uploaded"])."<br />";
                        $s .= _btdownloadedbts.": ".mksize($row["downloaded"])."<br />";
                        $s .= _btpercent.": ".sprintf("%.2f%%", (1 - ($row["to_go"] / $row["torrent_size"])) * 100)."<br />";
                        ##RATIO START
                        $s .= _btratio.": ";
                        if ($row["downloaded"])
                                $s .= number_format($row["uploaded"]/$row["downloaded"],2);
                        else
                                if ($e["uploaded"])
                                        $s .= number_format($row["uploaded"]/$row["torrent_size"],2);
                                else
                                        $s .= "---";
                        $s .= "<br />";
                        $s .= _btuploadspeed. ": ". mksize($row["upload_speed"])."/s<br />";
                        if ($row["seeder"] == "no") {
                                if ($row["download_speed"]) {
                                        $edt_m = ($row["to_go"] / $row["download_speed"])/60; //to minutes
                                        $edt = ($edt_m % 60)."m"; //minutes
                                        $edt_h = floor($edt_m / 60);
                                        if ($edt_h>0) $edt = $edt_h."h ".$edt;
                                } else {
                                        $edt = "&infin;";
                                }
                                $s .= _btdownloadspeed.": ". mksize($row["download_speed"])."/s<br />";
                                $s .= _btedt." ".$edt;
                        }
                        ##RATIO END
                        echo help(pic("help.gif"),$s,_bttransfer);
                        echo "</p>\n";
                        echo "</td>\n";

                        #Seeder or Leecher
                        echo "<td width=\"20%\">";
                        echo "<p align=\"center\">";
                        if ($row["seeder"] == "yes") echo pic("upload.gif","",_btseeder);
                        else echo pic("download.gif","",_btleecher);
                        echo "</p>\n";
                        echo "</td>\n";

                        #Client Information
                        echo "<td width=\"20%\">";
                        echo "<p align=\"center\">";
                        $client = $row["client"]." ".$row["clientversion"];
                        if ($row["client"] != "" AND is_readable("client_icons/".$row["client"].".gif")) echo "<img src=\"client_icons/".htmlspecialchars($row["client"]).".gif\" alt=\"".$client."\" title=\"".$client."\" />";
                        else echo "<img src=\"client_icons/Unknown.gif\" alt=\"".$client."\" title=\"".$client."\" />";
                        echo "</p>\n";
                        echo "</td>\n";

                        #Active or passive
                        echo "<td width=\"20%\">";
                        echo "<p align=\"center\">";
                        if ($row["connectable"] == "yes") echo pic("icon_active.gif","",constant("_btalt_icon_active.gif"));
                        else echo pic("icon_passive.gif","",constant("_btalt_icon_passive.gif"));
                        echo "</p>";
                        echo "</td>\n";

                        #Time information
                        echo "<td width=\"20%\">";
                        echo "<p align=\"center\">";
                        $s = _btconnected.": ".mkprettytime(time()-$row["started_ts"]);
                        $s .= "<br />";
                        $s .= _btidle.": ".mkprettytime(time()-$row["last_action_ts"]);
                        help(pic("clock.gif"),$s,_dtimeconnected);
                        echo "</p>";
                        echo"</td>\n";

                        echo "</tr>\n";
                        echo "</table>\n";
                        echo "</div>";
                        #End of peer attributes

                        echo "</td>\n";
                        echo "</tr>\n";

                        #User name and avatar with profile link
                        echo "<tr>\n";
                        echo "<td style=\"height:120px\"><p align=\"center\">";
                        if (!$user->admin) $ip = preg_replace('/\.\d+$/', ".xxx", long2ip($row["ip"]));
                        else $ip = long2ip($row["ip"]);
                        if ($row["uid"] != 0) {
                                $usertxt = "<a href=\"user.php?op=profile&id=".$row["uid"]."\" target=\"_top\">";
                                $usertxt .= gen_avatar($row["uid"]). "<br />";
                                if ($row["name"] != "") $usertxt .= $row["name"];
                                else $usertxt .= $row["username"];

                                if ($row["level"] == "admin") $usertxt .= pic("icon_admin.gif");
                                elseif ($row["level"] == "premium") $usertxt .= pic("icon_premium.gif");

                                $usertxt .= "</a>";
                        } else {
                                $usertxt = gen_avatar($row["uid"]);
                                $usertxt.= "<br />".$ip;
                        }
$usertxt.="<center><font size='1'><br><table class=main border=0 width=100><tr><td style='padding: 0px; background-image: url(images/loadbarbg.gif); background-repeat: repeat-x'>";
$pic = "loadbargreen.gif";
$width = round(1 * $perc);
$usertxt.="<img height=15 width=$width src=\"images/$pic\" alt='$donatein%'><br><font size='1'color=\"white\"><center>$perc</center></font></td></tr></table>";
                        echo $usertxt;
                        echo "</p></td>";
                        echo "</tr>\n";
                        #End of user name, avatar & link


                        echo "</table>\n";
                        echo "</td>\n";
                        #End of user box

                        $i++;
                        if ($i == 4) {
                                $i = 0;
                                echo "</tr>\n";
                                $tropen = false;
                        }
                }
                if ($tropen) {
                        for (; $i<4 ;$i++) echo "<td width=\"20%\"></td>\n";
                        echo "</tr>\n";
                }
                echo "</table>\n";

                $db->sql_freeresult($res);
                break;
        }
        case "shout": {
                if (!$user->user OR strlen($text) < 1) continue;
                if ($text != "") {
                        $sql = "INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES ('".$user->id."', '".addslashes(strip_tags($text))."', NOW());";
                        $db->sql_query($sql);
                }
        }
        case "shoutbox": {
                echo "<meta http-equiv=\"refresh\" content=\"30;url=frame.php?op=shoutbox\" />\n";
                echo "<script type=\"text/javascript\" language=\"JavaScript\">\n"
                ."var intervalID\n".
                "function scrolldown(){\n"
                ."        window.scroll(0, 3000);\n"
                ."}\n"
                ."intervalID = setTimeout('scrolldown()', 100);\n"
                ."</script>\n";
                $sql = "SELECT S.*, U.id as uid, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id ORDER BY posted ASC;";
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
                if ($db->sql_numrows($shoutres) > 0) {
                        while ($shout = $db->sql_fetchrow($shoutres)) {
                                $text = htmlspecialchars($shout["text"]);
                                parse_smiles($text);
                                echo "<p>";
                                //Header
                                echo "<b><a href=\"user.php?op=profile&id=".$shout["uid"]."\" target=\"_top\">".htmlspecialchars($shout["user_name"])."</a></b>:<br />";
                                //Text
                                echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr width=\"100%\">\n";
                        }
                        echo "<a name=\"end\"></a>";
                } else {
                        echo "<p align=\"center\">"._btnoshouts."</p>\n";
                }
                $db->sql_freeresult($shoutres);
        }
}

echo "</body>\n
</html>";
ob_end_flush();
die();
?>
