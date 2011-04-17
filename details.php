<?php
/*
*------------------------------phpMyBitTorrent V 2.0.4-------------------------*
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
*------              ©2009 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);

define("AUTH_PENDING",0);
define("AUTH_GRANTED",1);
define("AUTH_DENIED",2);
define("AUTH_NONE",3);

function getauthstatus($torrent) {
        global $user, $db, $db_prefix;
        if ($torrent["owner"] != 0) {
                $sql = "SELECT * FROM ".$db_prefix."_privacy_global WHERE master = '".$torrent["owner"]."' AND slave = '".$user->id."' LIMIT 1;";
                $res = $db->sql_query($sql);
                if ($row = $db->sql_fetchrow($res)) {
                        if ($row["status"] == "whitelist") return AUTH_GRANTED;
                        elseif ($row["status"] == "blacklistlist") return AUTH_DENIED;
                }
                $sql = "SELECT * FROM ".$db_prefix."_privacy_file WHERE torrent = '".$torrent["id"]."' AND slave = '".$user->id."' LIMIT 1;";
                $res = $db->sql_query($sql) or btsqlerror($sql);
                if ($row = $db->sql_fetchrow($res)) {
                        if ($row["status"] == "granted") return AUTH_GRANTED;
                        elseif ($row["status"] == "denied") return AUTH_DENIED;
                        return AUTH_PENDING;
                } else return AUTH_NONE;
        } else return AUTH_NONE;
}

function hex_to_base32($hex) {
  $b32_alpha_to_rfc3548_chars = array(
    '0' => 'A',
    '1' => 'B',
    '2' => 'C',
    '3' => 'D',
    '4' => 'E',
    '5' => 'F',
    '6' => 'G',
    '7' => 'H',
    '8' => 'I',
    '9' => 'J',
    'a' => 'K',
    'b' => 'L',
    'c' => 'M',
    'd' => 'N',
    'e' => 'O',
    'f' => 'P',
    'g' => 'Q',
    'h' => 'R',
    'i' => 'S',
    'j' => 'T',
    'k' => 'U',
    'l' => 'V',
    'm' => 'W',
    'n' => 'X',
    'o' => 'Y',
    'p' => 'Z',
    'q' => '2',
    'r' => '3',
    's' => '4',
    't' => '5',
    'u' => '6',
    'v' => '7'
  );
  for ($pos = 0; $pos < strlen($hex); $pos += 10) {
    $hs = substr($hex,$pos,10);
    $b32_alpha_part = base_convert($hs,16,32);
    $expected_b32_len = strlen($hs) * 0.8;
    $actual_b32_len = strlen($b32_alpha_part);
    $b32_padding_needed = $expected_b32_len - $actual_b32_len;
    for ($i = $b32_padding_needed; $i > 0; $i--) {
      $b32_alpha_part = '0' . $b32_alpha_part;
    }
    $b32_alpha .= $b32_alpha_part;
  }
  for ($i = 0; $i < strlen($b32_alpha); $i++) {
    $b32_rfc3548 .= $b32_alpha_to_rfc3548_chars[$b32_alpha[$i]];
  }
  return $b32_rfc3548;
}
//to get magnet link hash use $newhash = hex_to_base32($hash);

include("header.php");
?>
<script type="text/javascript" src="bbcode.js"></script>
<?php
if (!isset($id) OR !is_numeric($id)) bterror(_bterridnotset);
if (!isset($password)) $password = "";
else $password = urldecode($password);

$sql = "SELECT A.id as id, A.exeem, A.seeders, A.leechers, A.tot_peer, A.speed, A.info_hash, A.filename, A.banned, A.nuked, A.nukereason, A.password, A.imdb, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, A.numratings, A.name, IF(A.numratings < '".$minvotes."', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, A.save_as, A.descr, A.visible, A.size, A.plen, A.added, A.views, A.downloaded, A.completed, A.type, A.private, A.min_ratio, A.numfiles, A.owner, A.ownertype, A.complaints, A.evidence, A.tracker, A.tracker_list, A.dht as dht, A.md5sum as md5sum, A.uploader_host as user_host, B.name AS cat_name, IF(C.name IS NULL, C.username, C.name) as ownername, A.tracker_update, COUNT(S.status) as auths FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id LEFT JOIN ".$db_prefix."_privacy_file S ON S.torrent = A.id AND S.status = 'pending' WHERE A.id = '".$id."' GROUP BY A.id LIMIT 1;";
$res = $db->sql_query($sql) or btsqlerror($sql);
$torrent = $db->sql_fetchrow($res);
$db->sql_freeresult($res);

//If password is set, and user is not premium or owner, and if provided password is wrong, then give error
if ($torrent["password"] != "" AND !$user->premium AND $password != $torrent["password"] AND (!$user->user OR $user->id != $torrent["owner"])) {
        //Query user for Password
        OpenTable(_btpassword);
        echo "<form action=\"details.php\" method=\"GET\">\n";
        echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\" />";
        echo "<p align=\"center\">"._btpasswordquery."</p>";
        echo "<p align=\"center\">"._btpassword." <input type=\"password\" name=\"password\" value=\"\" /> <input type=\"submit\" value=\""._btsend."\" /></p>";

        if ($password != "") { //Means that password is wrong
                echo "<p>&nbsp</p>";
                echo "<p align=\"center\">"._btpasswordwrong."</p>";
        }
        echo "</form>\n";
        CloseTable();
        include("footer.php");
        die();
}
/*
A smart user would try to call upcomplete=1 to show the password link.
Password must be provided even after upload to show the link!!!
It is done automatically by the upload script
*/
if (($torrent["password"] == "" OR $password == $torrent["password"]) AND isset($upcomplete)) {
        OpenTable2(_btupload);
        echo "<p align=\"center\">"._btdsuccessfully."</p>\n";
        echo "<p align=\"center\">"._btdsuccessfully2."</p>\n";

        if ($torrent["password"] != "") {
                echo "<p>&nbsp</p>";
                $link = $siteurl."/details.php?id=".$id."&amp;password=".urlencode($torrent["password"]);
                echo "<p align=\"center\">".str_replace("**pass**",htmlspecialchars($torrent["password"]),_btuploadedpassexplain)."<br />";
                echo str_replace("**url**",$link,_btuploadedpassexplain2)."</p>";
        }
        CloseTable2();
}
if (isset($upload_notice)) {
        OpenTable2(_btinfohash);
        echo "<p>"._btinfohashnotice."</p>";
        CloseTable2();
}

if ($user->user and isset($op)) {
        switch ($op) {
                case "seeder": {
                        if ($torrent["tracker"] != "") break;
                        if ($trig == "on") {
                                $db->sql_query("INSERT INTO ".$db_prefix."_seeder_notify (torrent, user) VALUES ('".$id."','".$user->id."');");
                        } elseif ($trig == "off") {
                                $db->sql_query("DELETE FROM ".$db_prefix."_seeder_notify WHERE torrent = '".$id."' AND user = '".$user->id."';");
                        }

                        break;
                }
                case "comment": {
                        if ($trig == "on" AND $user->user) {
                                $db->sql_query("INSERT INTO ".$db_prefix."_comments_notify (torrent, user) VALUES ('".$id."','".$user->id."');");
                        } elseif ($trig == "off" AND $user->user) {
                                $db->sql_query("DELETE FROM ".$db_prefix."_comments_notify WHERE torrent = '".$id."' AND user = '".$user->id."';");
                        }
                        break;
                }
                case "authorization": {
                        if (!$torrent_global_privacy) break;
                        if ($torrent["ownertype"] == 2 OR $torrent["owner"] == $user->id OR $torrent["tracker"] != "") break;
                        if ($torrent["ownertype"] != 2) {
                                $sql = "SELECT status FROM ".$db_prefix."_privacy_global WHERE master = '".$torrent["owner"]."' AND slave = '".$user->id."' LIMIT 1;";
                                $res = $db->sql_query($sql) or btsqlerror($sql);
                                if ($db->sql_numrows($res) == 1) {
                                        $db->sql_freeresult($res);
                                        break;
                                }
                        }
                        if (!$db->sql_query("INSERT INTO ".$db_prefix."_privacy_file (master, slave, torrent) VALUES (".$torrent["owner"].", ".$user->id.",".$id.");")) break;
                        include("language/mailtexts.php");
                        $owner_res = $db->sql_query("SELECT username, email FROM ".$db_prefix."_users WHERE id = '".$torrent["owner"]."' LIMIT 1");
                        list ($master_name, $email_to) = $db->sql_fetchrow($owner_res);
                        $db->sql_freeresult($owner_res);
                        $request_mail = New eMail();
                        $search = Array("**sitename**","**siteurl**","**master**","**slave**","**id**","**name**");
                        $replace = Array($sitename,$siteurl,$master_name,$user->name,$torrent["id"],$torrent["name"]);
                        $request_mail->subject = str_replace("**sitename**",$sitename,$authreqmailsub[$language]);
                        $request_mail->sender = $admin_email;
                        $request_mail->Add($email_to);
                        $request_mail->body = str_replace($search,$replace,$authreqmailtext[$language]);
                        $request_mail->Send();
                        break;
                }
        }
}


$db->sql_query("UPDATE ".$db_prefix."_seeder_notify SET status = 'active' WHERE torrent = '".$id."' AND user = '".$user->id."';");
$db->sql_query("UPDATE ".$db_prefix."_comments_notify SET status = 'active' WHERE torrent = '".$id."' AND user = '".$user->id."';");

if (!$torrent OR ($torrent["banned"] == "yes" AND !$user->moderator))
        bterror(_btnotorrent);
if (isset($hit)) {
        $sqlupdate = "UPDATE ".$db_prefix."_torrents SET views = views + 1 WHERE id = '".$id."';";
        $db->sql_query($sqlupdate) or btsqlerror($sqlupdate);
}
if (can_download($user,$torrent)) {
        $can_access = true;
} else {
        $can_access = false;
}
$infohash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($torrent["info_hash"],20));
echo"<center><input title=\""._btview_details."\" class=\"button\" name=\"view details\" type=\"submit\" value=\"" . _btinfo . " \" onclick=\"sndReq('op=view_details_page&torrent=" . $id . "', 'DT')\">\n";
//if($user->admin)echo"<form method=\"GET\" action=\"hitruns.php\"><input type=\"hidden\" name=\"torrentid\" value=\"" . $id . "\"><input class=\"button\" type=\"submit\" name=\"Hitrun\" value=\"Hitrun\"></form>\n";
if (is_readable("torrent/".$id.".nfo")) echo"<input class=\"button\" title=\""._btnfo_view."\"type=\"submit\" value=\""._btnfo."\" onclick=\"sndReq('op=view_nfo_page&torrent=" . $id . "&amp;owner=" . $torrent['owner'] . "&amp;complaints=" . $torrent['complaints'] . "&amp;torrentrating=" . $torrent["rating"] . "&amp;torrentnumratings=" . $torrent["numratings"] . "', 'DT')\">\n";
echo"<input class=\"button\" type=\"submit\" title=\""._btview_btrate."\" value=\"" . _btrate . " \" onclick=\"sndReq('op=view_rate_page&torrent=" . $id . "&amp;owner=" . $torrent['owner'] . "&amp;complaints=" . $torrent['complaints'] . "&amp;torrentrating=" . $torrent["rating"] . "&amp;torrentnumratings=" . $torrent["numratings"] . "', 'DT')\">\n";
echo"<input class=\"button\" type=\"submit\" title=\""._btview_filelist."\" value=\"" . _btfilelist . " \" onclick=\"sndReq('op=view_files_page&torrent=" . $id . "&amp;files=" . urlencode($torrent["password"]) . "&amp;pass=" . $torrent["password"] . "', 'DT')\">\n";
if ($torrent["tracker"] == "" AND $torrent["type"] != "link" AND $user->user) echo"<input class=\"button\" type=\"submit\" title=\""._btview_source."\" value=\"" . _btsource . " \" onclick=\"sndReq('op=view_peers_page&torrent=" . $id . "&amp;tracker=" . $torrent["tracker"] . "&amp;type=" . $torrent["type"] ."&amp;pass=" . urlencode($torrent["password"]) . "', 'DT')\">\n";
if (($torrent["imdb"] != "")AND(strpos($torrent["imdb"], imdb))AND(strpos($torrent["imdb"], title))) echo"<input class=\"button\" title=\""._btview_imdb."\" type=\"submit\" value=\""._btimdb." \" onclick=\"sndReq('op=get_imdb&torrent=" . $id . "&amp;tracker=" . $torrent["tracker"] . "&amp;type=" . $torrent["type"] ."&amp;pass=" . urlencode($torrent["password"]) . "', 'DT')\">\n";
echo"<input class=\"button\" title=\""._btview_comments."\" type=\"submit\" value=\"" . _btcomments . " \" onclick=\"sndReq('op=view_coments_page&amp;torrent=" . $id . "&amp;password=".urlencode($torrent["password"])."', 'DT')\"></center>\n";

#Peers
if ($torrent["type"] != "link") {
        if ($torrent["tracker"] == "") $width = "20%";
        else $width = "33%";
        echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">\n";
        echo "<tr>";
        echo "<td style=\"width:".$width."\"><p>".pic("seeders.png","",_btseeders).$torrent["seeders"]."</p></td>";
        echo "<td style=\"width:".$width."\"><p>".pic("leechers.png","",_btleechers).$torrent["leechers"]."</p></td>";
        echo "<td style=\"width:".$width."\"><p>".pic("peers.gif","",_bttotsorc).$torrent["tot_peer"]."</p></td>";
        if ($torrent["tracker"] == "") {
                $complsql = "SELECT SUM(T.size-P.to_go)/(COUNT(P.id)*T.size) as complete FROM ".$db_prefix."_torrents T, ".$db_prefix."_peers P WHERE T.id = '".$id."' AND P.torrent = '".$id."';";
                $complres = $db->sql_query($complsql) or bterror($complsql);
                list ($completepercent) = $db->sql_fetchrow($complres);
                $db->sql_freeresult($complres);
                echo "<td style=\"width:".$width."\"><p>".pic("completion.gif","",_btcompletion).sprintf("%.2f%%", $completepercent * 100)."</p></td>";
                if ($torrent["leechers"] > 0 AND $torrent["speed"] > 0) {
                        $ro = $torrent["seeders"]/$torrent["leechers"];
                        $speed_leech = ($ro == 0) ? round($torrent["speed"]/$torrent["leechers"]) : min($torrent["speed"],round($torrent["speed"]*$ro));
                        $edt_m = ($torrent["size"] / $speed_leech)/60; //to minutes
                        $edt = ($edt_m % 60)."m"; //minutes
                        $edt_h = floor($edt_m / 60);
                        if ($edt_h>0) $edt = $edt_h."h ".$edt;
                        $speed_leech = mksize($speed_leech)."/s";
                } else {
                        $speed_leech = "--";
                        $edt = "--";
                }
                echo "<td style=\"width:".$width."\"><p>".pic("clock.gif","",_btedt).$edt." (".mksize($torrent["speed"])."/s)</p></td>";
        }
        echo "</tr>\n";
        echo "</table>\n";
}
echo"<span id=DT><noscript><iframe src=\"".$siteurl."/ajax.php?op=view_details_page&amp;torrent=".$torrent["id"]."\" marginwidth=\"0\" marginheight=\"0\"  width=\"100%\" align=\"middle\" height=\"100%\"></iframe></noscript></span>";
if ($user->user AND $torrent["type"] != "link") {
        $s = "<a name=\"notify\"></a>\n";
        OpenTable(_btnotifications);
        #Seeder Notification
        if ($torrent["tracker"] == "") {
                $sql = "SELECT * FROM ".$db_prefix."_seeder_notify WHERE torrent = '".$torrent["id"]."' AND user = '".$user->id."';";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) == 1) {
                        $s .= "<p>".str_replace("**id**",$torrent["id"],_btnotnotifyemail1s)."</p>";
                } else {
                        $s .= "<p>".str_replace("**id**",$torrent["id"],_btnotifyemail1s)."</p>";
                }
        $db->sql_freeresult($res);
        }

        #Comment notification
        $sql = "SELECT * FROM ".$db_prefix."_comments_notify WHERE torrent = '".$torrent["id"]."' AND user = '".$user->id."';";
        $res = $db->sql_query($sql);
        if ($db->sql_numrows($res) == 1) {
                        $s .= "<p>".str_replace("**id**",$torrent["id"],_btnotnotifyemailcom)."</p>";
        } else {
                        $s .= "<p>".str_replace("**id**",$torrent["id"],_btnotifyemailcom)."</p>";
        }
        $db->sql_freeresult($res);

        echo $s;
        CloseTable();
}
if($_GET['comm'] == ':thankyou:' OR $_GET['comm'] == 'startcomments'){
echo"<script type=\"text/javascript\">
<!--
	// Main PMBT Javascript Initialization
	sndReq('op=view_coments_page&torrent=" . $torrent["id"] . "&password=".urlencode($torrent["password"])."', 'DT');
//-->
</script>";
}else{
echo"<script type=\"text/javascript\">
<!--
	// Main PMBT Javascript Initialization
	sndReq('op=view_details_page&torrent=" . $torrent["id"] . "', 'DT');
//-->
</script>";
}
include("footer.php");
?>