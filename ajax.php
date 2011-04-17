<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
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
*-------------------   Saturday, JUN 27, 2009 1:05 AM   -----------------------*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("include/config.php");
if ($use_rsa) require_once("include/rsalib.php");
require_once("include/class.user.php");
if ($use_rsa) $rsa = New RSA($rsa_modulo, $rsa_public, $rsa_private);
$user = @new User($_COOKIE["btuser"]);

define("AUTH_PENDING",0);
define("AUTH_GRANTED",1);
define("AUTH_DENIED",2);
define("AUTH_NONE",3);
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
function str_links($text){
$text = preg_replace(
    array("/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^<>\s]+)/i","/\[url=((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i","/\[url\]((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\[\/url\]/i"),
    array("\\1","\\3",""), $text);

}
function error($string) {
        OpenErrTable("Error");
        if (is_array($string)) {
                echo _btalertmsg;
                echo "<UL>";
                foreach ($string as $msg) {
                        echo "<LI>".$msg."</LI>";
                }
                echo "</UL>";
        } else {
                 echo "<p class=\"errortext\">".$string."</p>";
        }
        echo "<p class=\"errortext\">"._btgoback."</p>";
        CloseErrTable();
        ob_end_flush();
$db->sql_close();
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
if (is_banned($user, $reason)) {
echo "<meta http-equiv=\"refresh\" content=\"0;url=ban.php?reson=".urlencode($reason)."\">";        die();
}
if ($user->user AND(
     $op =="private__chat" ||
	 $op =="getactive" ||
	 $op =="activeusers" ||
	 $op =="more_smiles" ||
	 $op =="view_shout" ||
	 $op =="take_edit_shout_cancel" ||
	 $op =="take_shout" ||
	 $op =="edit_shout" ||
	 $op =="take_delete_shout")) {
        //Update online user list
        $pagename = 'index.php';
        $sqlupdate = "UPDATE ".$db_prefix."_online_users SET last_action = NOW() WHERE id = ".$user->id.";";
        $sqlinsert = "INSERT INTO ".$db_prefix."_online_users VALUES ('".$user->id."','".addslashes($pagename)."', NOW(), NOW())";
        $res = $db->sql_query($sqlupdate);
        if (!$db->sql_affectedrows($res)) $db->sql_query($sqlinsert);
}



switch ($op) {
        case "check_username": {
		if (!$user->user) loginrequired("user",true);
		if( !isset( $_GET['username'] ) || empty( $_GET['username'] ) ){
		error("No username specified!");
		}
		// check for that username
		$sql = "SELECT COUNT(`id`) FROM `".$db_prefix."_users` WHERE `username` = '".$_GET['username']."'";
		$res = $db->sql_query($sql);
		$num = $db_sql_fetchfield( $res, 0, 0 );
		if( $num != 0 ){
		print("Username taken!");
		}
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'getactive':{
$usql = "SELECT id FROM ".$db_prefix."_online_users WHERE page='index.php' AND UNIX_TIMESTAMP(NOW()-last_action) < 600";
$ures = $db->sql_query($usql)or print(mysql_error());
$utot = $db->sql_numrows($ures);
print($utot);
				ob_end_flush();
$db->sql_close();
die();

		}
		case 'private__chat':{
$shoutannounce = format_comment($shout_config['announce_ment'], false, true);
parse_smiles($shoutannounce);
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">".$shoutannounce."</p></div>";
$utc2 = $btback1;
//$db->sql_query("ALTER TABLE `torrent_shouts` ADD `id_to` INT( 10 ) NOT NULL DEFAULT '0';";
                $sql = "SELECT S.*, U.id as uid, U.can_do as can_do, U.donator AS donator, U.warned as warned, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id WHERE S.id_to ='".$to."' AND S.user = '".$user->id."' OR S.user='".$to."' AND S.id_to ='".$user->id."' ORDER BY posted DESC LIMIT ".$shout_config['shouts_to_show'].";";
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
$num2s = $db->sql_numrows($shoutres);
                if ($num2s > 0) {
                        while ($shout = $db->sql_fetchrow($shoutres)) {
						$donator ='';
						if($shout['donator'] == 'true')$donator ='<img src="images/donator.gif" height="16" width="16" title="donator" alt="donator" />';

if ($num2s > 1)
{
$ucs++;
}
if($ucs%2 == 0)
{
$utc3 = "od";
$utc2 = $btback1;
}
else
{
$utc3 = "even";
$utc2 = $btback2;
}
$i++;
$caneditshout = false;
$candeleteshout = false;
if ($user->moderator) $caneditshout = true;
if ($user->moderator) $candeleteshout = true;
if ($user->id == $shout['uid'] AND $shout_config['canedit_on'] =="yes") $caneditshout = true;
if ($user->id == $shout['uid'] AND $shout_config['candelete_on'] =="yes") $candeleteshout = true;
                                echo "<p>";
								$warn = "";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								if($shout["warned"] == "1") $warn = '<img src="images/warning.gif" alt="warned" />';
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                if(preg_match("/\/notice (.*)/",$text,$m)){
								$text = preg_replace('/\/notice/','',$text);
								}elseif(preg_match("/\/me (.*)/",$text,$m)){
								$text = preg_replace('/\/me/','',$text);
								echo"<b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>:";
								}else{
								echo ($candeleteshout ? "<a ondblclick=\"if(confirm('Delete Shout?')==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",_btalt_edit) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "").($shout_config['bbcode_on'] =="yes" ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>] <b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.": ";
                                }
                                echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div></p>\n";
                        }
                } else {
                        echo "<p align=\"center\">"._btnoshouts."</p>\n";
                }
                $db->sql_freeresult($shoutres);
		ob_end_flush();
$db->sql_close();
die();
		}
		case 'activeusers':{
$sql = "SELECT O.id AS id, O.page AS page, UNIX_TIMESTAMP(O.logged_in) AS logged_in, IF(U.name IS NULL, U.username, U.name) as name, U.warned AS warned, U.can_do as can_do, U.level AS level, U.Show_online AS Show_online, U.uploaded as uploaded, U.downloaded AS downloaded FROM ".$db_prefix."_online_users O LEFT JOIN ".$db_prefix."_users U ON O.id = U.id WHERE  O.page='index.php' AND UNIX_TIMESTAMP(NOW()-last_action) < 600 AND U.Show_online = true;";
$res = $db->sql_query($sql);
$tot = $db->sql_numrows($res);
$i = 1;
$simple = "\n<p>";
$advanced = "<table border=\"1\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
$advanced .= "<thead><tr><td><p align=\"center\"><b>"._btusername."</b></p></td><td><p align=\"center\"><b>"._btratio."</b></p></td><td><p align=\"center\"><b>"._btpagename."</b></p></td><td><p align=\"center\"><b>"._btloggedinfor."</b></p></td></tr></thead>\n<tbody>\n";
if ($db->sql_numrows($res) == 0) $simple .= _btnouseronline;
else {
        while ($row = $db->sql_fetchrow($res)) {

                $simple .= "<a href=\"user.php?op=profile&id=".$row["id"]."\"><font color=\"".getusercolor($row["can_do"])."\">";
                $simple .= htmlspecialchars($row["name"])."</font></a>";
                if ($row["level"] == "premium") $simple .= pic("icon_premium.gif",'','Premium');
                elseif ($row["level"] == "uploader") $simple .= pic("icon_uploader.gif",'','Uploader');
                elseif ($row["level"] == "moderator") $simple .= pic("icon_moderator.gif",'','Moderator');
                elseif ($row["level"] == "admin") $simple .= pic("icon_admin.gif",'','Admin');
		        if($row["warned"] == "1") $simple .= '<img src="images/warning.gif" alt="warned" />';
                if ($i < $tot) $simple .= ", ";
                $i++;

                $advanced .= "<tr>";
                $advanced .= "<td><p><a href=\"user.php?op=profile&id=".$row["id"]."\"><font color=\"".getusercolor($row["can_do"])."\">";
                $advanced .= htmlspecialchars($row["name"])."</font></a>";
                if ($row["level"] == "premium") $advanced .= pic("icon_premium.gif",'','holder');
                elseif ($row["level"] == "moderator") $advanced .= pic("icon_moderator.gif",'','holder');
                elseif ($row["level"] == "admin") $advanced .= pic("icon_admin.gif",'','holder');
		        if($row["warned"] == "1") $advanced .= '<img src="images/warning.gif" alt="warned" />';
                $advanced .= "</p></td>";

                if ($row["uploaded"] == 0 AND $row["downloaded"] == 0) $ratio = "---";
                elseif ($row["downloaded"] == 0) $ratio = "&infin;";
                else {
                        $ratio = $row["uploaded"]/$row["downloaded"];

                        if ($ratio < 0.1) $ratio = "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
                        elseif ($ratio < 0.2) $ratio = "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
                        elseif ($ratio < 0.3) $ratio = "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
                        elseif ($ratio < 0.4) $ratio = "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
                        elseif ($ratio < 0.5) $ratio = "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
                        elseif ($ratio < 0.6) $ratio = "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
                        elseif ($ratio < 0.7) $ratio = "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
                        elseif ($ratio < 0.8) $ratio = "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
                        elseif ($ratio < 0.9) $ratio = "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
                        elseif ($ratio < 1)   $ratio = "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
                        else $ratio = "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
                }
                $advanced .= "<td><p>".$ratio."</p></td>";
                $advanced .= "<td><p>";
                if (defined("_btpage_".$row["page"])) $advanced .= constant("_btpage_".$row["page"]);
                $advanced .= "</p></td>";
                $advanced .= "<td><p>".mkprettytime(time()-$row["logged_in"])."</p></td>";
                $advanced .= "</tr>\n";	
        }
	$simple .="<br><br><p>Legend: Admin <img src=\"themes/".$theme."/pics/icon_admin.gif\" alt=\"holder\">, Moderator<img src=\"themes/".$theme."/pics/icon_moderator.gif\" alt=\"holder\">, Premium<img src=\"themes/".$theme."/pics/icon_premium.gif\" alt=\"holder\"> </p><div style='font-size: 8pt;' align=\"center\"><a href=\"javascript:advanced();\">"._btadvancedmode."</a></div>";
        $simple .= "";
}
$advanced .= "</tbody></table>\n";
$db->sql_freeresult($res);

//Simple mode
echo "<div id=\"users_simple\" class=\"show\">";
echo $simple;
echo "</div>";

//Advanced mode
echo "<div id=\"users_advanced\" class=\"hide\">";
echo $advanced;
echo "<br><p>Legend: Admin <img src=\"themes/".$theme."/pics/icon_admin.gif\" alt=\"holder\">, Moderator<img src=\"themes/".$theme."/pics/icon_moderator.gif\" alt=\"holder\">, Premium<img src=\"themes/".$theme."/pics/icon_premium.gif\" alt=\"holder\"> </p><div style='font-size: 8pt;' align=\"center\"><a href=\"javascript:simple();\">"._btsimplemode."</a></div>";
echo "</div>";
		ob_end_flush();
$db->sql_close();
die();
		}
		case 'edit_torrent_descr':{
		// check for valid ID
		if( !isset( $_GET['torrent'] ) || !is_numeric( $_GET['torrent'] ) ){
		error("Invalid torrent!" );
		}
		// get the torrent description
		$sql = "SELECT `descr`, `owner` FROM `".$db_prefix."_torrents` WHERE `id` = '".$_GET['torrent']."'";
		$res = $db->sql_query($sql);
		$descr = $db->sql_fetchrow( $res );
		// make sure user is owner of torrent
        if (!$descr['owner'] = $user->id OR !$user->moderator){
		error("Invalid permissions!");
		}
		print( "<textarea enctype=\"multipart/form-data\" rows=\"10\" cols=\"80\" style=\"border:0px\" onblur=\"if(confirm('Save changes to torrent description?')==true){sndReq('op=save_torrent_descr&torrent=".$_GET['torrent']."&descr='+escape(this.value), 'descrTD".$_GET['torrent']."')}\">".$descr['descr']."</textarea>" );
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'more_smiles':{
		if (!$user->user) loginrequired("user",true);
		        $sql = "SELECT * FROM ".$db_prefix."_smiles GROUP BY file ORDER BY id ASC;";
        $smile_res = $db->sql_query($sql);
        if ($db->sql_numrows($smile_res) > 0) {
                $smile_rows = $db->sql_fetchrowset($smile_res);
                echo "<p>";
                foreach ($smile_rows as $smile) {
                        echo " <img src=\"smiles/".$smile["file"]."\" onclick=\"comment_smile('".$smile["code"]."',Shoutform.text);\" border=\"0\" alt=\"".$smile["alt"]."\">\n";
                }
				echo "</p>";
        }
        $db->sql_freeresult($smile_res);

		ob_end_flush();
$db->sql_close();
die();

		}
		case 'view_shout':{
		if (!$user->user) loginrequired("user",true);
				if($user->can_shout == 'false'){
		echo "YouR shout rights have been banned";
		ob_end_flush();
$db->sql_close();
die();
}
$shoutannounce = format_comment($shout_config['announce_ment'], false, true);
parse_smiles($shoutannounce);
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">".$shoutannounce."</p></div>";

		if(isset($shotuser)){
		$privateonly = "WHERE S.id_to ='".$shotuser."' AND S.user = '".$user->id."' OR  S.id_to ='".$user->id."' AND S.user = '".$shotuser."'";
		}else{
		$privateonly = '';
		}
$utc2 = $btback1;
                $sql = "SELECT S.*, U.id as uid, U.can_do as can_do, U.donator AS donator, U.warned as warned, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id ".$privateonly." ORDER BY posted DESC LIMIT ".$shout_config['shouts_to_show'].";";
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
$num2s = $db->sql_numrows($shoutres);
                if ($num2s > 0) {
                        while ($shout = $db->sql_fetchrow($shoutres)) {
						$donator ='';
						if($shout['donator'] == 'true')$donator ='<img src="images/donator.gif" height="16" width="16" title="donator" alt="donator" />';

//$num2s = $db->sql_numrows($shoutres);
if ($num2s > 1)
{
$ucs++;
}
if($ucs%2 == 0)
{
$utc3 = "od";
$utc2 = $btback1;
}
else
{
$utc3 = "even";
$utc2 = $btback2;
}
$i++;
$caneditshout = false;
$candeleteshout = false;
if ($user->moderator) $caneditshout = true;
if ($user->moderator) $candeleteshout = true;
if ($user->id == $shout['uid'] AND $shout_config['canedit_on'] =="yes") $caneditshout = true;
if ($user->id == $shout['uid'] AND $shout_config['candelete_on'] =="yes") $candeleteshout = true;
if ($shout['id_to']!=0){
if ($user->id == $shout['id_to'] OR $user->id == $shout['uid']){
                                echo "<p>";
								$warn = "";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								if($shout["warned"] == "1") $warn = '<img src="images/warning.gif" alt="warned" />';
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                if(preg_match("/\/notice (.*)/",$text,$m)){
								$text = preg_replace('/\/notice/','',$text);
								}elseif(preg_match("/\/me (.*)/",$text,$m)){
								$text = preg_replace('/\/me/','',$text);
								echo _btprivates."<b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.":";
								}else{
                                echo ($candeleteshout ? "<a ondblclick=\"if(confirm('Delete Shout?')==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",_btalt_edit) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "").($shout_config['bbcode_on'] =="yes" ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>]"._btprivates." <b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.": ";
                                }
                                echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div>\n";
								}
								}
								if ($shout['id_to']==0){
                                echo "<p>";
								$warn = "";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								if($shout["warned"] == "1") $warn = '<img src="images/warning.gif" alt="warned" />';
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                if(preg_match("/\/notice (.*)/",$text,$m)){
								$text = preg_replace('/\/notice/','',$text);
								}elseif(preg_match("/\/me (.*)/",$text,$m)){
								$text = preg_replace('/\/me/','',$text);
								echo"<b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>:";
								}else{
								echo ($candeleteshout ? "<a ondblclick=\"if(confirm('Delete Shout?')==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",_btalt_edit) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "").($shout_config['bbcode_on'] =="yes" ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>] <b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.": ";
                                }
                                echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div>\n";
								}
                        }
                } else {
                        echo "<p align=\"center\">"._btnoshouts."</p>\n";
                }
                $db->sql_freeresult($shoutres);
ob_end_flush();
$db->sql_close();
die();

		}
		case 'edit_shout':{
		//echo $_GET['shout'];
		// check for valid ID
		if( !isset( $_GET['shout'] ) || !is_numeric( $_GET['shout'] ) ){
		error("Invalid torrent!" );
		}
		// get the torrent description
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$_GET['shout']."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout = $db->sql_fetchrow( $res );
		// make sure user is owner of torrent edit_others_shouts
        if ($shout['user'] != $user->id AND !checkaccess("edit_others_shouts")){
		error("Invalid permissions!");
		}
		print( "<form mane=\"shoutedit\" id=\"shoutedit\"><textarea name=\"textedit\" id=\"textedit\" enctype=\"multipart/form-data\" rows=\"1\" cols=\"80\" style=\"border:1px\" >".$shout['text']."</textarea><input type=\"button\" onclick=\"sndReq('op=take_edit_shout&shout=".$_GET['shout']."&shout_text='+escape(textedit.value), 'shoutTD')\" value=\""._btshoutnow."\" /><input type=\"button\" onclick=\"sndReq('op=take_edit_shout_cancel', 'shoutTD')\" value=\"Cancel\" /></form>" );
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'edit_archive_shout':{
		// check for valid ID
		if( !isset( $_GET['shout'] ) || !is_numeric( $_GET['shout'] ) ){
		error("Invalid torrent!" );
		}
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$_GET['shout']."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout = $db->sql_fetchrow( $res );
        if ($shout['user'] != $user->id AND !checkaccess("edit_others_shouts")){
		error("Invalid permissions!");
		}
		print( "<form mane=\"shoutedit\" id=\"shoutedit\"><textarea name=\"textedit\" id=\"textedit\" enctype=\"multipart/form-data\" rows=\"1\"  style=\"border:1px\" >".$shout['text']."</textarea><br /><input type=\"button\" onclick=\"sndReq('op=take_edit_archive_shout&shout=".$_GET['shout']."&shout_text='+escape(textedit.value), 'shout_shell_".$_GET['shout']."')\" value=\""._btshoutnow."\" /><input type=\"button\" onclick=\"sndReq('op=take_edit_shout_cancel', 'shout_archive_edit_".$_GET['shout']."')\" value=\"Cancel\" /></form>" );
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'take_delete_shout':{
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$_GET['shout']."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout = $db->sql_fetchrow( $res );
        if ($shout['user'] != $user->id AND !checkaccess("edit_others_shouts")){
		error("Invalid permissions!");
		}

		$db->sql_query("DELETE FROM `".$db_prefix."_shouts` WHERE `".$db_prefix."_shouts`.`id`='".$_GET['shout']."' LIMIT 1");
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'take_delete_archive_shout':{
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$_GET['shout']."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout = $db->sql_fetchrow( $res );
        if ($shout['user'] != $user->id AND !checkaccess("edit_others_shouts")){
		error("Invalid permissions!");
		}

		$db->sql_query("DELETE FROM `".$db_prefix."_shouts` WHERE `".$db_prefix."_shouts`.`id`='".$_GET['shout']."' LIMIT 1");
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'take_edit_shout_cancel':{
echo "";
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'take_edit_shout':{
		 $shout = str_replace("op=take_edit_shout&shout=".$_GET['shout']."&shout_text=","",$_SERVER['QUERY_STRING']);
		 $shout = str_replace(array("/amp2/","/amp3/"),array("&","#"),$shout);
		 $shout = urldecode($shout);
		 $shout = addslashes($shout);
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$_GET['shout']."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout2 = $db->sql_fetchrow( $res );
        if ($shout2['user'] != $user->id AND !checkaccess("edit_others_shouts")){
		error("Invalid permissions!");
		}
		$upd_sql = "UPDATE `".$db_prefix."_shouts` SET `text` = '".$shout."' WHERE `id` = '".$_GET['shout']."'";
		$db->sql_query($upd_sql) or btsqlerror($upd_sql);
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'take_edit_archive_shout':{
		 $shout = str_replace("op=take_edit_archive_shout&shout=".$_GET['shout']."&shout_text=","",$_SERVER['QUERY_STRING']);
		 $shout = str_replace("/amp2/","&",$shout);
		 $shout = urldecode($shout);
								$shout3 = format_comment($shout, false, true);
                                parse_smiles($shout3);
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$_GET['shout']."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout2 = $db->sql_fetchrow( $res );
        if ($shout2['user'] != $user->id AND !checkaccess("edit_others_shouts")){
		error("Invalid permissions!");
		}
		$upd_sql = "UPDATE `".$db_prefix."_shouts` SET `text` = '".$shout."' WHERE `id` = '".$_GET['shout']."'";
		$db->sql_query($upd_sql) or btsqlerror($upd_sql);
echo"	<td class=\"alt1\" id=\"shout_shell_".$_GET['shout']."\" width=\"1%\" align=\"left\">

		<div id=\"shout_".$_GET['shout']."\">
		".$shout3."
		</div>
		<div id=\"shout_archive_edit_".$_GET['shout']."\">
		</div>

	</td>
";
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'take_shout':{
		if($user->can_shout == 'false'){
		echo "YouR shout rights have been banned";
		ob_end_flush();
$db->sql_close();
die();
}
		if (!$user->user) loginrequired("user",true);
		 if (strlen($_GET['text']) < 1) continue;
		 		 //print($_SERVER['QUERY_STRING']);
				 if(isset($sendto)){
				 $resend = "sendto=".$sendto."&";
				 $sendtable = ", id_to";
				 $sendtorow = ", '".$sendto."'";
				 }
				 else
				 {
				 $resend = '';
				 $sendtable = '';
				 $sendtorow = '';
				 }
				 
				 
		 $shout = str_replace("op=take_shout&".$resend."text=","",$_SERVER['QUERY_STRING']);
		 $shout = str_replace("/amp2/","&",$shout);
		// die($shout);
		$shout = urldecode($shout);
if ($shout == "/empty" && $user->admin) {
//$db->sql_query("TRUNCATE TABLE ".$db_prefix."_shouts");
$shout = '/notice The modshout has been truncated by '.$user->name;
#die('The modshout has been truncated');
}
if ($shout == "/prune" && $user->admin) {
$db->sql_query("TRUNCATE TABLE ".$db_prefix."_shouts");
$shout = '/notice The modshout has been truncated by '.$user->name;
#die('The modshout has been truncated');
}
if ($shout == "/pruneshout" && $user->admin) {
$db->sql_query("TRUNCATE TABLE ".$db_prefix."_shouts");
$shout = '/notice The modshout has been truncated by '.$user->name;
#die('The modshout has been truncated');
}
if(preg_match("/\/deletenotice/",$shout,$matches) && $user->admin) {
    $db->sql_query("DELETE FROM ".$db_prefix."_shouts WHERE text LIKE '%/notice%'");
}
if(preg_match("/\/unwarn (.*)/",$shout,$m) && $user->admin) {
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".escape($m[1])."' OR name = '".escape($m[1])."' OR clean_username = '".escape(strtolower($m[1]))."';");
if (!$res) echo "No Such user found";
$row = $db->sql_fetchrow($res);
if($row[id]==0 || $row[id] == "")echo "No Such user found";
if($row[id] == $user->id)
{
echo "You can not unWarn your self";
}
else{
     $modcomment = "[ " . gmdate("Y-m-d H:i:s", time()) . " - WARN deleted by " . getusername($user) . " ]\n" . $row['modcomment'];
     $added3 = gmdate("Y-m-d H:i:s", time());
     $msg3 = "Your WARNNING was deleted by " . $user->name . "!";
     $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('". $user->id ."', '".$row[id]."', 'WARNNING',  '" . $msg3 . "', NOW())") or btsqlerror();
	 $db->sql_query("UPDATE ".$db_prefix."_users SET  modcomment='".$modcomment."', warned='0', warn_kapta='0', warn_hossz='0' WHERE id='".$row[id]."'") or die(mysql_error()); 
$shout = "/notice $m[1]'s warnning has been removed";
}
}
if(preg_match("/\/warn (.*)/",$shout,$m) && $user->admin) {
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".escape($m[1])."' OR name = '".escape($m[1])."' OR clean_username = '".escape(strtolower($m[1]))."';");
if (!$res) echo "No Such user found";
$row = $db->sql_fetchrow($res);
if($row[id]==0 || $row[id] == "")echo "No Such user found";
if($row[id] == $user->id)
{
echo "You can not Warn your self";
}
if($row[level] == 'admin')
{
echo "This level is expempt You Ars";
}else{
     $weeks = "unlimited time";
	 $warnlength = -1;
     $added2 = (gmdate("Y-m-d H:i:s", time()));
     $modcomment =  "" . gmdate("Y-m-d H:i:s", time()) . " - WARNed for " . $weeks . "  by " . getusername($user) . " - Reason: Shoutbox Warned " . $row['modcomment']."";
     $msg2 = ("You have been WARNNED by " . getusername($user) . " for  " . $weeks . "  with reason: Shoutbox Warned.");
     $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('". $user->id ."', '".$row[id]."', 'WARNNING',  '" . $msg2 . "', NOW())") or die(mysql_error());
	 $db->sql_query("UPDATE ".$db_prefix."_users SET  modcomment='".$modcomment."', warned='1', warn_kapta='" . strtotime(gmdate("Y-m-d H:i:s", time())) . "', warn_hossz='".$warnlength."' WHERE id= '".$row[id]."'") or die(mysql_error());
$shout = "/notice $m[1] has been Warned!!";
}
}
if(preg_match("/\/ban (.*) : (.*)/",$shout,$m) && $user->admin) {
//die($m[1] ." and ".$m[2]);
if($m[2] == "" || !isset($m[2]))die("no reason given");
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".escape($m[1])."' OR name = '".escape($m[1])."' OR clean_username = '".escape(strtolower($m[1]))."';");
if (!$res) echo "No Such user found";
$row = $db->sql_fetchrow($res);
if($row[id]==0 || $row[id] == "")echo "No Such user found";
if($row[id] == $user->id)
{
echo "You can not Ban your self";
}else{
                        $sql = "UPDATE ".$db_prefix."_users SET ban = 1, banreason = '".strip_tags($m[2])."' WHERE username = '".$row['username']." AND id NOT IN (1,2,3,4,5)';";
                        $db->sql_query($sql) or btsqlerror($sql);
						if($forumshare)forum_ban ($$row['username'], strip_tags($reason_user)); 
echo "banned ".$m[1]." test";
$shout = "";
}
}
if(preg_match("/\/unban (.*)/",$shout,$m) && $user->admin) {
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".escape($m[1])."' OR name = '".escape($m[1])."' OR clean_username = '".escape(strtolower($m[1]))."';");
if (!$res) echo "No Such user found";
$row = $db->sql_fetchrow($res);
if($row[id]==0 || $row[id] == "")echo "No Such user found";
if($row[id] == $user->id)
{
echo "You can not Warn your self";
}else{
                        $db->sql_query("UPDATE ".$db_prefix."_users SET ban = 0, banreason = NULL WHERE id = '".$row['id']."';");
						if($forumshare)forum_unban ($row['id']); 
echo "unbanned ".$m[1]." test";
$shout = "";
}
}
if(preg_match("/\/banshout (.*)/",$shout,$m) && $user->admin) {
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".escape($m[1])."' OR name = '".escape($m[1])."' OR clean_username = '".escape(strtolower($m[1]))."';");
if (!$res) echo "No Such user found";
$row = $db->sql_fetchrow($res);
if($row[id]==0 || $row[id] == "")echo "No Such user found";
if($row[id] == $user->id)
{
echo "You can not Warn your self";
}else{
                $sql = "UPDATE ".$db_prefix."_users SET can_shout = 'false' WHERE id = '".$row['id']."';";
                if (!$db->sql_query($sql)) btsqlerror($sql);
}
}
if(preg_match("/\/unbanshout (.*)/",$shout,$m) && $user->admin) {
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".escape($m[1])."' OR name = '".escape($m[1])."' OR clean_username = '".escape(strtolower($m[1]))."';");
if (!$res) echo "No Such user found";
$row = $db->sql_fetchrow($res);
if($row[id]==0 || $row[id] == "")echo "No Such user found";
if($row[id] == $user->id)
{
echo "You can not Warn your self";
}else{
                $sql = "UPDATE ".$db_prefix."_users SET can_shout = 'true' WHERE id = '".$row['id']."';";
                if (!$db->sql_query($sql)) btsqlerror($sql);
$shout = "/notice $m[1] has been Warned!!";
}
}
if(preg_match("/\/slapuser (.*)/",$shout,$m)) {
$shout = "/me Slaps $m[1] ";
}
if(preg_match("/\/pmuser (.*);(.*)/",$shout,$m)) {
if(!is_numeric($m[1])) $m[1] = getuser($m[1]);
echo "pm to userid{$m[1]} saying $m[2]";
     $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('". $user->id ."', '".$m[1]."', 'Quick Pm From shouts',  '" . escape($m[2]) . "', NOW())") or die(mysql_error());
$shout = '';
}
$shout = preg_replace("/\/warn (.*)/","",$shout);
$shout = preg_replace("/\/empty/",'',$shout);
$shout = preg_replace("/\/ban (.*)/",'',$shout);
$shout = preg_replace("/\/unban (.*)/",'',$shout);
$shout = preg_replace("/\/warn (.*)/",'',$shout);
$shout = preg_replace("/\/unwarn (.*)/",'',$shout);
//$shout = preg_replace("/\/help/",'',$shout);
$shout = preg_replace("/\/prune/",'',$shout);
$shout = preg_replace("/\/pruneshout/",'',$shout);
$shout = preg_replace("/\/deletenotice/",'',$shout);
if ($shout == '/help') {
//die("help set");
    $shout = "[quote]";
    if($user->admin){
    $shout .= "If you want to make an notice - use the /notice command.
	If you want to empty shouts - use the /empty command 
	If you want to warn or unwarn a user - use the /warn (user) and /unwarn (user) commands 
	If you want to ban(disable) or unban(enable) a user - use the /ban (user) and /unban (user) commands 
	To delete all notices from the shout, use /deletenotice command
	If you want to slap a user /slapuser user name
	If you want to send a quick Private Message /pmuser (user name or id);(message)
	If you want to speak at 3rd person, use the /me (message)command.";
}else{
$shout .= "As an user, you have the folowing commands:
If you want to view this message in the shout, use the /help command
If you want to slap a user /slapuser user name
If you want to send a quick Private Message /pmuser (user name or id);(message)
If you want to speak at 3rd person, use the /me command.";
}
$shout .= "[/quote]";
echo format_comment($shout, false, true);//die($shout);
//ob_end_flush();
//$db->sql_close();
//die();
$shout = "";

}
if(!$user->admin)
$shout = preg_replace("/\/notice/",'',$shout); 
				if($shout_config['allow_url'] == "no")$shout = str_links($shout);
                if ($shout != "") {
                        $sql = "INSERT INTO ".$db_prefix."_shouts (user, text, posted".$sendtable.") VALUES ('".$user->id."', '".addslashes(strip_tags(urldecode($shout)))."', NOW()".$sendtorow.");";
                        $db->sql_query($sql)or btsqlerror($sql);
                }
$shoutannounce = format_comment($shout_config['announce_ment'], false, true);
parse_smiles($shoutannounce);
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">".$shoutannounce."</p></div>";
                if(!isset($sendto))$sql = "SELECT S.*, U.id as uid, U.can_do as can_do, U.donator AS donator, U.warned as warned, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id ORDER BY posted DESC LIMIT ".$shout_config['shouts_to_show'].";";
				else
				$sql = "SELECT S.*, U.id as uid, U.can_do as can_do, U.donator AS donator, U.warned as warned, U.warned as warned, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id WHERE S.id_to ='".$sendto."' AND S.user = '".$user->id."' OR S.id_to ='".$user->id."' AND S.user = '".$sendto."' ORDER BY posted DESC LIMIT ".$shout_config['shouts_to_show'].";";
				
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
$num2s = $db->sql_numrows($shoutres);
                if ($num2s > 0) {
                        while ($shout = $db->sql_fetchrow($shoutres)) {
						$donator ='';
						if($shout['donator'] == 'true')$donator ='<img src="images/donator.gif" height="16" width="16" title="donator" alt="donator" />';
if ($num2s > 1)
{
$ucs++;
}
if($ucs%2 == 0)
{
$utc3 = "od";
$utc2 = $btback1;
}
else
{
$utc3 = "even";
$utc2 = $btback2;
}
$i++;
$caneditshout = false;
$candeleteshout = false;
if ($user->moderator) $caneditshout = true;
if ($user->moderator) $candeleteshout = true;
if ($user->id == $shout['uid'] AND $shout_config['canedit_on'] =="yes") $caneditshout = true;
if ($user->id == $shout['uid'] AND $shout_config['candelete_on'] =="yes") $candeleteshout = true;
if ($shout['id_to']!=0){
if ($user->id == $shout['id_to'] OR $user->id == $shout['uid']){
                                echo "<p>";
								$warn = "";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								if(preg_match("/\/staffmesage (.*)/",$text,$m) AND $user->moderator){
								}
								if($shout["warned"] == "1") $warn = '<img src="images/warning.gif" alt="warned" />';
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                if(preg_match("/\/notice (.*)/",$text,$m)){
								$text = preg_replace('/\/notice/','',$text);
								}elseif(preg_match("/\/me (.*)/",$text,$m)){
								$text = preg_replace('/\/me/','',$text);
								echo _btprivates."<b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.":";
								}else{
                                echo ($candeleteshout ? "<a ondblclick=\"if(confirm('Delete Shout?')==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",_btalt_edit) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "").($shout_config['bbcode_on'] =="yes" ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>][PM] <b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.": ";
                                }
								echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div>\n";
								}
								}
								if ($shout['id_to']==0){
                                echo "<p>";
								$warn = "";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								if($shout["warned"] == "1") $warn = '<img src="images/warning.gif" alt="warned" />';
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                if(preg_match("/\/notice (.*)/",$text,$m)){
								$text = preg_replace('/\/notice/','',$text);
								}elseif(preg_match("/\/me (.*)/",$text,$m)){
								$text = preg_replace('/\/me/','',$text);
								echo"<b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.":";
								}else{
								echo ($candeleteshout ? "<a ondblclick=\"if(confirm('Delete Shout?')==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",_btalt_edit) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "").($shout_config['bbcode_on'] =="yes" ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>] <b><span class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.": ";
                                }
								echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div>\n";
								}
                        }
                } else {
                        echo "<p align=\"center\">"._btnoshouts."</p>\n";
                }
                $db->sql_freeresult($shoutres);
ob_end_flush();
$db->sql_close();
die();

		}
		case 'save_torrent_descr':{
		// check for valid ID
		if( !isset( $_GET['torrent'] ) || !is_numeric( $_GET['torrent'] ) ){
		error("Invalid torrent!" );
		}
		// get the torrent description
		$sql = "SELECT `owner` FROM `".$db_prefix."_torrents` WHERE `id` = '".$_GET['torrent']."'";
		$res = $db->sql_query($sql);
		$descr = $db->sql_fetchrow( $res );
		// make sure user is owner of torrent
        if (!$descr['owner'] = $user->id OR !$user->moderator){
		error("Invalid permissions!");
		}
		$descr = addslashes($_GET['descr']);
		$upd_sql = "UPDATE `".$db_prefix."_torrents` SET `descr` = '".$descr."' WHERE `id` = '".$_GET['torrent']."'";
		$db->sql_query($upd_sql) or btsqlerror($upd_sql);
		print( nl2br( stripslashes( $_GET['descr'] ) ) );
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'change_banned_torrent':{
		if( !isset( $_GET['torrent'] ) || !is_numeric( $_GET['torrent'] ) ){
		error("Invalid torrent!" );
		}
		// check is mod or higher
		if(!checkaccess("bann_torrents")){
		error("Invalid permissions!" );
		}
		// create the select
		print( "<select onchange=\"if(confirm('Save banned state?')==true){sndReq('op=save_banned_torrent&torrent=".$_GET['torrent']."&banned='+this.selectedIndex, 'bannedChange')}\">
		<option value=\"\" selected=\"selected\">Banned?</option>
		<option value=\"1\">Yes</option>
		<option value=\"0\">No</option>
		</select>
		");
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'save_banned_torrent':{
		//check valid torrent
		if( !isset( $_GET['torrent'] ) || !is_numeric( $_GET['torrent'] ) ){
		error("Invalid torrent!" );
		}
		// check is mod or higher
		if(!checkaccess("bann_torrents")){
		error("Invalid permissions!" );
		}
		// convert $_GET['banned'] to 'yes' or 'no'
		switch( $_GET['banned'] ){
		case 1 : $state = 'yes'; break;
		case 2 : $state = 'no'; break;
		default : $state = 'no'; break;
		}
		// do the SQL
		$sql = "UPDATE `".$db_prefix."_torrents` SET `banned` = '".$state."' WHERE `id` = '".$_GET['id']."' LIMIT 1";
		$db->sql_query($sql) or btsqlerror($sql);
		// print the outcome
		print( $state );
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'change_type_torrent':{
		//check valid torrent
		if( !isset( $_GET['torrent'] ) || !is_numeric( $_GET['torrent'] ) ){
		print( "Invalid torrent!" );
		ob_end_flush();
$db->sql_close();
die();

		}
		// check is mod or higher
		if(!$user->moderator){
		error("Invalid permissions!" );
		ob_end_flush();
$db->sql_close();
die();

		}
		// create the select
		print("<select onchange=\"if(confirm('Save type change?')==true){sndReq('op=save_type_torrent&torrent=".$_GET['torrent']."&type='+this.options[this.selectedIndex].value, 'catTD')}\">");
		$cats = catlist();
		print("<option value=\"\">(choose one)</option>\n");
		foreach ($cats as $row){
		print("<option value=\"".$row["id"]."\">".htmlspecialchars($row["name"])."</option>\n");
		}
		print("</select>\n");
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'save_type_torrent':{
		//check valid torrent
		if( !isset( $_GET['torrent'] ) || !is_numeric( $_GET['torrent'] ) ){
		error("Invalid torrent!" );
		ob_end_flush();
$db->sql_close();
die();

		}
		// check is mod or higher
		if(!$user->moderator){
		error("Invalid permissions!" );
		ob_end_flush();
$db->sql_close();
die();

		}
		// do the SQL
		$sql = "UPDATE `".$db_prefix."_torrents` SET `category` = '".$_GET['type']."' WHERE `id` = '".$_GET['torrent']."' LIMIT 1";
		$db->sql_query($sql) or btsqlerror($sql);
		// get the category in text form
		$res = "SELECT `name` FROM `".$db_prefix."_categories` WHERE `id` = '".$_GET['type']."'";
		$cats_res = $db->sql_query($res);
		$cat = $db->sql_fetchrow( $cats_res);
		// print the outcome
		print( $cat['name'] );
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'edit_torrent_comment':{
		//check valid comment
		if( !isset( $_GET['comment'] ) || !is_numeric( $_GET['comment'] ) || !is_valid_id($_GET['comment']) ){
		error("Invalid comment!" );
		ob_end_flush();
$db->sql_close();
die();

		}
		// get comment details
		$sql = "SELECT `user`, `text` FROM `".$db_prefix."_comments` WHERE `id` = '".$_GET['comment']."' LIMIT 1";
		$res = $db->sql_query($sql);
		$details = $db->sql_fetchrow( $res );
		// check owner
		if(!$user->moderator || $user->id != $details['user'] ){
		error("Invalid permissions!");
		ob_end_flush();
$db->sql_close();
die();

		}
		print("<textarea rows=\"8\" cols=\"25\" onblur=\"if(confirm('Save changes?')==true){sndReq('op=save_torrent_comment&comment=".$_GET['comment']."&text='+escape(this.value), 'comment_".$_GET['comment']."')}\">".$details['text']."</textarea>");
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'save_torrent_comment':{
		//check valid comment
		if( !isset( $_GET['comment'] ) || !is_numeric( $_GET['comment'] ) || !is_valid_id($_GET['comment']) ){
		error("Invalid comment!" );
		ob_end_flush();
$db->sql_close();
die();

		}
		// get comment details
		$sql = "SELECT `user` FROM `".$db_prefix."_comments` WHERE `id` = '".$_GET['comment']."' LIMIT 1";
		$res = $db->sql_query($sql);
		$details = $db->sql_fetchrow( $res );
		// check owner
		if(!$user->moderator || $user->id != $details['user'] ){
		error("Invalid permissions!");
		ob_end_flush();
$db->sql_close();
die();

		}
		// make sure not blank
		if( !isset( $_GET['text'] ) || empty( $_GET['text'] ) ){
		error("Body can not be empty!");
		ob_end_flush();
$db->sql_close();
die();

		}
		// save changes
		$editedat = get_date_time();
		$db->sql_query("UPDATE `".$db_prefix."_comments` SET `text` = '".$_GET['text']."' WHERE `id` = '".$_GET['comment']."' LIMIT 1");
		// print out the comment
		print( nl2br( stripslashes( $_GET['text'] ) ) );
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'delete_torrent_comment':{
		$postid = $_GET["postid"];
		if (!$user->moderator || !is_valid_id($postid)){
		error("Invalid operation!" );
		die;
		}
		//------- Delete comment
		$db->sql_query("DELETE FROM `".$db_prefix."_comments` WHERE id=$postid");
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'close_view_details':{
		echo "<span id=ID" . $_GET['torrent'] . "><p onclick=\"sndReq('op=view_details&torrent=" . $_GET['torrent'] . "', 'ID" . $_GET['torrent'] . "')\">".pic("plus.gif","",_btddetails)."</p></span>";
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'close_view_details_page':{
		echo "";
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'view_peers_page':{
		if(!$user->user)error("your not allowed to view peers with out being loged in");
		if ($_GET["tracker"] == "" AND $_GET["type"] != "link" AND $user->user) {
        OpenTable(_btsource);
                if (!isset($_GET['torrent']) OR !is_numeric($_GET['torrent']) OR $_GET['torrent'] < 1) error(_bterridnotset);
                $password = urldecode($password);
                $sql = "SELECT password FROM ".$db_prefix."_torrents WHERE id = '".$_GET['torrent']."' AND (password IS NULL OR password = '".$_GET["pass"]."') LIMIT 1;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1) die(); //Password is wrong or not set
                $db->sql_freeresult($res);
                $i = 0;
                $tropen = false;
                $sql = "SELECT P.id AS pid, P.peer_id AS peer_id, P.downloaded AS downloaded, P.uploaded AS uploaded, P.download_speed AS download_speed, P.upload_speed AS upload_speed, P.ip AS ip, P.real_ip AS real_ip, P.to_go AS to_go, P.seeder AS seeder, UNIX_TIMESTAMP(P.started) AS started_ts, UNIX_TIMESTAMP(P.last_action) AS last_action_ts, P.connectable AS connectable, P.client AS client, P.version AS clientversion, U.id AS uid, U.username AS username, U.name AS name, U.avatar AS avatar, U.can_do as can_do, U.level AS level, T.size AS torrent_size FROM ".$db_prefix."_peers P LEFT JOIN ".$db_prefix."_users U ON U.id = P.uid LEFT JOIN ".$db_prefix."_torrents T ON T.id = P.torrent WHERE P.torrent = '".$_GET['torrent']."' ORDER BY P.seeder ASC;";
                $res = $db->sql_query($sql) or print_r($db->sql_error());
                if ($db->sql_numrows($res) < 1) break;

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
                        echo help(pic("help.gif","",null),$s,_bttransfer);
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
                                if ($row["name"] != "") $usertxt .= "<font color=\"".getusercolor($row["can_do"])."\">".$row["name"]."</font>";
                                else $usertxt .= "<font color=\"".getusercolor($row["can_do"])."\">".$row["username"]."</font>";

                                if ($row["level"] == "admin") $usertxt .= pic("icon_admin.gif");
                                elseif ($row["level"] == "premium") $usertxt .= pic("icon_premium.gif");

                                $usertxt .= "</a>";
                        } else {
                                $usertxt = gen_avatar("0");
                                $usertxt.= "<br />".$ip;
                        }
                        $usertxt.="<table class=main border=0 width=100><tr><td style='padding: 0px; background-image: url(images/loadbarbg.gif); background-repeat: repeat-x'>";
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
        CloseTable();
}
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'view_files_page':{
		if ($_GET["numfiles"] <= 2) $height = 150;
		elseif ($_GET["numfiles"] <= 2) $height = 300;
		else $height = 450;
		$id = $_GET['torrent'];
		$password= $_GET["pass"];
		
		OpenTable(_btfilelist);
		//echo "<iframe src=\"frame.php?op=filelist&amp;id=".$_GET['torrent']."&amp;password=".$_GET["pass"]."\" width=\"100%\" height=\"".$height."\" align=\"middle\" scrolling=auto marginwidth=\"0\" marginheight=\"0\"></iframe>\n";
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
                echo "<table class=\"filelist\" align=\"middle\">\n<thead><tr><td width=\"4%\"><p></p></td><td width=\"24%\" align=\"center\"><p><b>"._btname."</b></p></td><td width=\"24%\" align=\"center\"><p><b>"._btsize."</b></p></td><td width=\"24%\" align=\"center\"><p><b>"._btmagnetlink."</b></p></td><td width=\"24%\" align=\"center\"><p><b>"._bted2klink."</b></p></td></tr>\n</thead>\n<tbody>";
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
		CloseTable();
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'view_rate_page':{
		OpenTable(_btrate);
		echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"3\" width=\"100%\">";

		#Star Rating
		$s = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><p>";
		if (!isset($_GET["torrentrating"])) {
        if ($minvotes > 1) {
                $s .= str_replace("__minvotes__", $minvotes, _btminvotes);
                if ($_GET['torrentnumratings'])
                        $s .= _btonly . $_GET['torrentnumratings'];
                else
                        $s .= _btnone;
                $s .= ")";
        } else
                $s .= _btnovotes;
		} else {
        $rpic = ratingpic($_GET["torrentrating"]);
        $s .= $rpic. "(" . $_GET["torrentrating"] . " ". _btoo5 . " ". $_GET['torrentnumratings'] . " " .  _btvotestot.")";
        $s .= "</p></td></tr><tr><td><p>";

		}
		$s .= " ";
		$ratings = array(
        5 => _btvot5,
        4 => _btvot4,
        3 => _btvot3,
        2 => _btvot2,
        1 => _btvot1
		);
		if ($_GET["owner"] != $user->id AND ($user->user)) {
        $xres = $db->sql_query("SELECT rating, added FROM ".$db_prefix."_ratings WHERE torrent = '".$_GET['torrent']."' AND user = '" . $user->id."'") or btsqlerror("SELECT rating, added FROM ".$db_prefix."_ratings WHERE torrent = '".$_GET['torrent']."' AND user = '" . $user->id."'");
        if ($xrow = $db->sql_fetchrow($xres))
                $s .= "("._btyourate." <b>\"" . $xrow["rating"] . " - ".$ratings[$xrow["rating"]]. "\"</b> ". formatTimeStamp($xrow["added"]) . ")";
        else {
                $s .= "<form method=\"post\" action=\"rate.php?op=star\"><input type=\"hidden\" name=\"id\" value=\"".$_GET['torrent']."\" />\n";
                $s .= "<select name=\"rating\">\n";
                $s .= "<option value=\"0\">("._btaddrating.")</option>\n";
                foreach ($ratings as $k => $v) {
                        $s .= "<option value=\"$k\">$k - $v</option>\n";
                }
                $s .= "</select>\n";
                $s .= "<input type=\"submit\" value=\""._btvotenow."\" />";
                $s .= "</form>\n";
        }
        $db->sql_freeresult($xres);
		} elseif ($_GET["owner"] == $user->id AND ($user->user)) {
               $s .= "("._btnovoteowntorrent.")";
		} else {
                $s .= _btlogintorate;
		}


		$s .= "</p></td></tr></table>";
		echo "<tr><td><p>"._btrating."</p></td><td>".$s."</td></tr>";

		#Complaints
		if ($torrent_complaints) {
        #Separator
        echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

        $complaintsql ="SELECT score FROM ".$db_prefix."_complaints WHERE torrent ='".$_GET['torrent']."' AND user = '".$user->id."';";
        $complaintres = $db->sql_query($complaintsql) or btsqlerror($complaintsql);
        $scorerepl = Array("**p**","**n**");
        $complaints = explode(",",$_GET["complaints"]);
        $btcomplaints = getcomplaints();
        if ($db->sql_numrows($complaintres) != 0) {
                list ($score) = $db->sql_fetchrow($complaintres);
                $complaint_form = "<p>"._btcomplyouvoted."<b>".$btcomplaints[$score]."</b></p>";
                $complaint_form.= "<p>".str_replace($scorerepl,$complaints,_btcomplatthemoment);
                $complaint_form.= _btcomplexplain."</p>\n";
        } else {
                if ($_GET["owner"] != $user->id AND $user->user) {
                        $complaint_form = "<form action=\"rate.php?op=complaint\" method=\"POST\"><INPUT type=\"hidden\" name=\"id\" value=\"".$_GET['torrent']."\">\n";
                        $complaint_form.= "<p>"._btcomplaintform;
                        $complaint_form.= _btcomplisay;
                        $complaint_form.= "<select name=\"complaint\">";
                        foreach ($btcomplaints as $k => $val) $complaint_form.= "<option value=\"".$k."\">".$val."</option>";
                        $complaint_form.= "</select><input type=\"submit\" value=\""._btsend."\"></p>\n</form>\n<br />\n";
                }
                $complaint_form.= "<p>".str_replace($scorerepl,$complaints,_btcomplatthemoment);
                $complaint_form.= _btcomplexplain."</p>";
        }
        echo "<tr><td valign=\"top\"><p>"._btcomplaints."</p></td><td>".$complaint_form."</td></tr>";
}

echo "</table>";
CloseTable();
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'view_coments_page':{
		if(isset($_GET["amp;torrent"]))$_GET["torrent"] = $_GET["amp;torrent"];
		if(isset($_GET["amp;password"]))$_GET["password"] = $_GET["amp;password"];
OpenTable(_btcomments);
if ($user->user) echo "<p align=center><a class=index href=takethankyou.php?id=".$_GET['torrent']."> <img src=./smiles/thankyou.gif border = 0></a><br> <h2><center>Add a Quick Thankyou to the uploader!!!</center></h2></p>";
#Read Comments
$id = $_GET['torrent'];
$password = $_GET["password"];
                if (!isset($id) OR !is_numeric($id) OR $id < 1) error(_bterridnotset);
                $password = urldecode($password);
                $sql = "SELECT password FROM ".$db_prefix."_torrents WHERE id = '".$id."' AND (password IS NULL OR password = '".$password."') LIMIT 1;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1) die(); //Password is wrong or not set
                $db->sql_freeresult($res);
                $sql = "SELECT C.*, U.id as uid, U.can_do as can_do, U.username, U.name, IF(U.name IS NULL, U.username, U.name) as user_name, U.avatar as user_avatar FROM ".$db_prefix."_comments C LEFT JOIN ".$db_prefix."_users U ON C.user = U.id WHERE C.torrent ='".$id."' ORDER BY added ASC;";
                $res = $db->sql_query($sql) or btsqlerror($sql);
                if ($db->sql_numrows($res) < 1) {
                        echo "<h3 align=\"center\" class=\"title\">"._btnocommentsyet."</h3>";
                } else while ($comment = $db->sql_fetchrow($res)) {
                        echo "<a name=\"comm".$comment["id"]."\"></a><table width=\"100%\" class=\"main\">";
                        echo "<thead>\n<tr><td class=\"colhead\">";
                        $search = Array("**user**","**uid**","**time**");
                        $replace = Array("<font color=\"".getusercolor($comment["can_do"])."\">".htmlspecialchars($comment["user_name"])."</font>",$comment["uid"],formatTimestamp($comment["added"]));
                        echo str_replace($search,$replace,_btcommheader);
                        echo "</td>\n</tr>\n</thead>\n";
                        echo "<tbody>\n<tr><td>";
                        echo "<table width=\"100%\">\n</tr>\n<td width=\"100\">";
                        echo gen_avatar($comment["uid"]);
                        echo "</td>\n<td>";
						$body = stripslashes(format_comment($comment["text"]));
                        parse_smiles($body);
                        if ($user->admin OR $user->id == $comment["user"]) echo "<div align=\"right\"><a href=\"comment.php?op=delete&id=".$id."&cid=".$comment["id"]."\" target=\"_top\">".pic("drop.gif")."</a><a href=\"comment.php?op=edit_coment&id=".$id."&cid=".$comment["id"]."\" target=\"_top\">".pic("edit.gif")."</a></div>";
                        echo "<div align=\"justify\">".$body."</div>";
                        echo "</td>\n</tr>\n</table>\n";
                        echo "</td>\n</tr>\n</tbody>\n";
                        echo "</table>";
						}
#Post comment form, if user is logged in
if ($user->user) {


        echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"3\" width=\"100%\">\n";
        echo "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";
	echo "<tr><td><p>"._btaddcomment."</p></td><td>";
        echo "<form name=\"torrentComment\" method=\"POST\" action=\"comment.php\">";
        echo "<p><textarea rows=\"7\" cols=\"40\" name=\"comment\"></textarea><br>";

        #Smiles
        $sql = "SELECT * FROM ".$db_prefix."_smiles GROUP BY file ORDER BY id ASC LIMIT 14;";
        $smile_res = $db->sql_query($sql);
        if ($db->sql_numrows($smile_res) > 0) {
                $smile_rows = $db->sql_fetchrowset($smile_res);


                foreach ($smile_rows as $smile) {
                        echo "<a onclick=\"comment_smile('".$smile["code"]."',torrentComment.comment);\"><img src=\"smiles/".$smile["file"]."\" border=\"0\" alt=\"".$smile["alt"]."\"></a>\n";
                }
        }
        $db->sql_freeresult($smile_res);
        echo "</p>";
        echo "<p><input type=\"submit\" value=\""._btsend."\"></p>";
        echo "<input type=\"hidden\" name=\"id\" value=\"".$_GET['torrent']."\"><input type=\"hidden\" name=\"op\" value=\"add\">";
        echo "</form>";
        echo "</td></tr>";
        echo "</table>";
}
CloseTable();
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'view_details_page':{
		if(isset($_GET["amp;torrent"]))$_GET['torrent'] = $_GET["amp;torrent"];
		echo"<span id=CL" . $_GET['torrent'] . ">";
		OpenTable(_btinfo);
		$sql = "SELECT A.id as id,A.post_img,A.screan1,A.screan2,A.screan3,A.screan4, A.exeem, A.seeders, A.leechers, A.tot_peer, A.speed, A.info_hash, A.filename, A.banned, A.nuked, A.nukereason, A.password, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, A.numratings, A.name, IF(A.numratings < '".$minvotes."', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, A.save_as, A.descr, A.visible, A.size, A.plen, A.added, A.views, A.downloaded, A.completed, A.type, A.private, A.min_ratio, A.numfiles, A.owner, A.ownertype, A.complaints, A.evidence, A.tracker, A.tracker_list, A.dht as dht, A.md5sum as md5sum, A.uploader_host as user_host, B.name AS cat_name, IF(C.name IS NULL, C.username, C.name) as ownername, A.tracker_update, COUNT(S.status) as auths FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id LEFT JOIN ".$db_prefix."_privacy_file S ON S.torrent = A.id AND S.status = 'pending' WHERE A.id = '".$_GET['torrent']."' GROUP BY A.id LIMIT 1;";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$torrent = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
		if (can_download($user,$torrent)) {
        $can_access = true;
		} else {
        $can_access = false;
		}
$infohash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($torrent["info_hash"],20));
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
        ob_end_flush();
$db->sql_close();
die();

}
if ($torrent["type"] != "link") {
        if ($torrent["tracker"] == "") $width = "20%";
        else $width = "33%";
        if ($torrent["tracker"] == "") {
                $complsql = "SELECT SUM(T.size-P.to_go)/(COUNT(P.id)*T.size) as complete FROM ".$db_prefix."_torrents T, ".$db_prefix."_peers P WHERE T.id = '".$_GET['torrent']."' AND P.torrent = '".$_GET['torrent']."';";
                $complres = $db->sql_query($complsql) or bterror($complsql);
                list ($completepercent) = $db->sql_fetchrow($complres);
                $db->sql_freeresult($complres);
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
        }
}
#Torrent Name
echo "<table class=\"details\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "<tr><td class=\"torrentname\" align=\"center\">".htmlspecialchars(str_replace(Array(".","_"),Array(" "," "),stripslashes($torrent["name"])))."</td>";
echo "</tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "</table>\n";
echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" class=\"details\">\n";
#Actions
$flag = getauthstatus($torrent);
echo "<tr><td><p>"._btactions."</p></td><td><p>";
if ($torrent["filename"] != "" AND $torrent["type"] != "link") {
        $passlink = "";
        if ($torrent["password"] != "") $passlink = "&amp;password=".urlencode($torrent["password"]);
        if ($can_access) {
                echo pic("download.gif","download.php?id=".$_GET['torrent'].$passlink,_btalt_download);
                if ($user->passkey != "")
                        help(pic("export.gif","download.php?id=".$_GET['torrent'].$passlink."&amp;export=1"),_btexportexplain,_btexport);
        } elseif ($user->user AND $torrent_global_privacy AND $torrent["owner"] != $user->id AND $torrent["ownertype"] != 2) {
                if ($flag == AUTH_NONE) echo pic("lock_request.gif","details.php?op=authorization&amp;id=".$_GET['torrent'].$passlink,_btalt_lock_request);
                else echo pic("lock.gif",null,_btalt_lock);
        } elseif ($download_level = "user") {
                help(pic("download.gif","",null),_btregistereddownload);
        } elseif ($download_level = "premium") {
                help(pic("download.gif","",null),_btpremiumdownload);
        }
}
if ($torrent["exeem"] != "" AND $can_access) echo pic("exeem.gif",$torrent["exeem"],_btalt_exeem);

if ($torrent["dht"] == "yes") {
        echo pic("magnet.gif","magnet:?xt=urn:btih:".hex_to_base32($infohash_hex),_btalt_magnet);
}
if (($torrent["owner"] == $user->id AND checkaccess("edit_own_torrents")) OR checkaccess("can_edit_others_torrents")) echo pic("edit.gif","edit.php?id=".$torrent["id"],_btalt_edit).pic("drop.gif","edit.php?op=delete&amp;id=".$torrent["id"],_btalt_drop);
	#Ban button
		if (checkaccess("bann_torrents") AND $torrent["banned"] != "yes"){
			echo pic("ban.png","edit.php?op=ban&amp;id=".$torrent["id"],_btban);
		}
	#Scrape button
		if ($user->moderator AND $torrent["tracker"] != ""){
			 echo pic("refresh.png","scrape-external.php?id=".$torrent["id"]."&amp;tracker=".$torrent["tracker"]."&amp;back=yes",_btalt_scrape);
               	}

if ($torrent["owner"] == $user->id AND $torrent_global_privacy AND $torrent["tracker"] == "") {
        if ($torrent["auths"] > 0) echo pic("auth_pending.gif","mytorrents.php?op=displaytorrent&amp;id=".$torrent["id"],_btalt_auth_pending);
        else echo pic("auth_none.gif","mytorrents.php?op=displaytorrent&amp;id=".$torrent["id"],_btalt_auth_none);
}
echo "</p></td></tr>\n";

#Download As
#if ($torrent["save_as"] != "") {
#        echo "<tr><td><p>"._btdownloadas."</p></td><td><p>".$torrent["save_as"];
#        if ($torrent["md5sum"] != "") echo "<br />md5sum: ".$torrent["md5sum"];
#        echo "</p></td></tr>\n";
#}

#Download Authorization
if ($torrent_global_privacy AND $user->user AND !$user->premium AND $torrent_global_privacy AND $download_level=="user" AND $torrent["owner"] != $user->id AND $torrent["private"] == "true" AND $torrent["owner"] != 0) {
        echo "<tr><td><p>"._btauthstatus."</p></td>";
        switch ($flag) {
                case AUTH_PENDING: {
                        echo "<td><p class=\"pending\">"._btdwauthpending."</p></td>";
                        break;
                }
                case AUTH_GRANTED: {
                        echo "<td><p class =\"granted\">"._btdwauthgranted."</p></td>";
                        break;
                }
                case AUTH_DENIED: {
                        echo "<td><p class =\"denied\">"._btdwauthdenied."<p></td>";
                        break;
                }
                case AUTH_NONE: {
                        echo "<td><p class =\"pending\">"._btdwauthnorequest."<p></td>";
                        break;
                }
        }
        echo "</tr>\n";
}
#Poster
if($torrent["post_img"] !=''){
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "<tr><td><p>"._bt_poster."</p></td><td><img src=\"".$torrent["post_img"]."\" border=\"0\"></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
}
#Size
echo "<tr><td><p>"._btdim."</p></td><td><p>".mksize($torrent["size"])."</p></td></tr>\n";
#Pieces
#Date added
echo "<tr><td><p>"._btrequest_added."</p></td><td><p>".formatTimeStamp($torrent["added"])."</p></td></tr>\n";
#if ($torrent["type"] != "link") echo "<tr><td><p>"._btpieces."</p></td><td><p>".str_replace(Array("**n**","**l**"),Array(intval(($torrent["size"]/$torrent["plen"])),mksize($torrent["plen"])),_btpiecesstring)."</p></td></tr>\n";
#Minimum Ratio
if ($torrent["private"] == "true" AND $torrent["min_ratio"] > "0.00" AND ($user->moderator OR $torrent["owner"] == $user->id))
        echo "<tr><td><p>"._btminratio."</p></td><td><p>".number_format($torrent["min_ratio"],2)."</p></td></tr>\n";
#Separator
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

#Description
$descript = format_comment($torrent["descr"],false,true);
parse_smiles($descript);
#Description
if (!empty($torrent["descr"])) {//Sometimes massive upload Torrents do not have description
        echo "<tr><td><p>"._btdescription."</p></td><td id=\"descrTD".$torrent['id']."\">".($user->admin ? "<a ondblclick=\"sndReq('op=edit_torrent_descr&torrent=".$torrent['id']."', 'descrTD".$torrent['id']."')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "");
        if ($descript != strip_tags($descript)) //Means it is written in HTML
                echo $descript;
        else
                echo "<p>".str_replace("\n","<br>",$descript)."</p>";
        echo "</td></tr>\n";
}
#Sceenshot
if($torrent["screan1"] !=''){
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "<tr><td><p>"._bt_screensa."</p></td><td><a href=\"".stripslashes($torrent["screan1"])."\" title=\"Click For Full Size\"><img src=\"".stripslashes($torrent["screan1"])."\" width=\"300\" border=\"0\"><br>Click Here For Full Size</a></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
}
if($torrent["screan2"] !=''){
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "<tr><td><p>"._bt_screensb."</p></td><td><a href=\"".stripslashes($torrent["screan2"])."\" title=\"Click For Full Size\"><img src=\"".stripslashes($torrent["screan2"])."\" width=\"300\" border=\"0\"><br>Click Here For Full Size</a></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
}
if($torrent["screan3"] !=''){
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "<tr><td><p>"._bt_screensc."</p></td><td><a href=\"".stripslashes($torrent["screan3"])."\" title=\"Click For Full Size\"><img src=\"".stripslashes($torrent["screan3"])."\" width=\"300\" border=\"0\"><br>Click Here For Full Size</a></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
}
if($torrent["screan4"] !=''){
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "<tr><td><p>"._bt_screensd."</p></td><td><a href=\"".stripslashes($torrent["screan4"])."\" title=\"Click For Full Size\"><img src=\"".stripslashes($torrent["screan4"])."\" width=\"300\" border=\"0\"><br>Click Here For Full Size</a></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td><HR SIZE=1 NOSHADE></td></tr>\n";
}


#Info Hash & Tracker
if ($torrent["type"] != "link") {
        #Separator
        echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

        echo "<tr><td><p>";
        help(pic("help.gif"),_btinfohashhelp,_btinfohash);
        echo _btinfohash."</p></td>";
        echo "<td><p>".$infohash_hex."</p></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
        ##Single Tracker
        echo "<tr><td><p>"._bttracker."</p></td><td><p>";
        if ($torrent["tracker"] == "") {
                echo $siteurl;
        } else {
                echo "<a href=\"".preg_replace('/announce.*$/', '', $torrent["tracker"])."\">".$torrent["tracker"]."</a>";
        }
        echo "</p></td></tr>\n";
        if ($torrent["tracker_list"] != "") {
                echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
		echo "<tr><td><p>"._bttrackers."</p></td><td>\n";
                $trackers = explode("\n\n",$torrent["tracker_list"]);
                for ($i = 0; $i < count($trackers); $i++) {
                        $trackers[$i] = explode("\n",$trackers[$i]);

                        echo "<p>".str_replace("*",$i,_bttrackergroup)."\n";
                        echo "<ul>\n";
                        for ($j = 0; $j < count($trackers[$i]); $j++) {
                                echo "<li>";
								$pos = strpos($trackers[$i][$j], $announce_url);
                                if ($pos !== false) echo "<p>".$siteurl."</p>\n";
                                else echo "<p><a href=\"".preg_replace('/announce.*$/', '', $trackers[$i][$j])."\">".$trackers[$i][$j]."</a></p>";
                                echo "</li>\n";
                        }
                        echo "</ul>\n";
                        echo "<br />\n";

                }
                unset($trackers);
                echo "</td></tr>\n";
        }

}

#Separator
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";


#Category
echo "<tr><td><p>"._bttype."</p></td><td id=\"catTD\"><p ondblclick=\"sndReq('op=change_type_torrent&torrent=".$torrent["id"]."', 'catTD')\">".$torrent["cat_name"]."</p></td></tr>\n";

#File number
echo "<tr><td><p>"._btnfile."</p></td><td><p>".$torrent["numfiles"]."</p></td></tr>\n";

#Uploaded by
echo "<tr><td><p>"._btuppedby."</p></td><td><p>";
switch ($torrent["ownertype"]) {
        case 0: {
                echo "<a href=\"user.php?op=profile&amp;id=".$torrent["owner"]."\"><font color=\"".getusercolor(getlevel_name($torrent["owner"]))."\">".htmlspecialchars($torrent["ownername"])."</font></a>";
                if ($user->admin) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[".htmlspecialchars($torrent["user_host"])."]";
                break;
        }
        case 1: {
                if ($user->moderator) echo "<a href=\"user.php?op=profile&amp;id=".$torrent["owner"]."\"><font color=\"".getusercolor(getlevel_name($torrent["owner"]))."\">".htmlspecialchars($torrent["ownername"])."</font></a>";
                else echo "<i>"._btunknown."</i>";
                if ($user->admin) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[".htmlspecialchars($torrent["user_host"])."]";
        }
        case 2: {
                if ($user->admin) echo "[".htmlspecialchars($torrent["user_host"])."]";
                else echo "<i>"._btunknown."</i>";
        }
}
echo "</p></td></tr>\n";

#Last Seed
if($torrent["type"]!="link" AND $torrent["tracker"] == ""){
        echo "<tr><td><p>"._btlastseeder."</p></td><td><p>".mkprettytime($torrent["lastseed"]) ." "._btago."</p></td></tr>\n";
#Separator
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
#snatched
if ($user->user) echo "<tr><td><p>View Snatched: </font></p></td><td><p><a href=\"viewsnatches.php?id=" . $_GET['torrent'] . "\"><font ><h3>[View!]</h3></font></a>";
				  
}
print("<tr><td><p>Nuked</p></td><td><p>".$torrent["nuked"]."</p></td></tr>\n");
if ($torrent["nuked"] == "yes")print("<tr><td><p>Nuked Reason</td><td><p>".$torrent["nukereason"]."</p></td></tr>\n");
if ($torrent["nuked"] == "unnuked")print("<tr><td><p>Unnuked Reason</td><td><p>".$torrent["nukereason"]."</p></td></tr>\n");
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
#reseed
if ($user->user)echo "<tr><td><p>REQUIST A RESEED:</p></td><td><p><a href=\"re-seed.php?id=" . $_GET['torrent'] . "\"><font ><h3>[RESEED NOW!]</h3></font></a>";

#Separator
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";


#Views
echo "<tr><td><p>"._btview."</p></td><td><p>".$torrent["views"]."</p></td></tr>\n";

#Downloads
echo "<tr><td><p>"._btdownloaded."</p></td><td><p>".$torrent["downloaded"]."</p></td></tr>\n";

#Completed
echo "<tr><td><p>"._btsnatch."</p></td><td><p>".$torrent["completed"]."</p></td></tr>\n";

if ($user->user AND $torrent["password"] != "" AND ($user->id == $torrent["owner"] OR $user->premium)) {
        #Separator
        echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

        echo "<tr><td><p>"._btpassword."</p></td><td><p>".htmlspecialchars($torrent["password"])."</p></td></tr>\n";
        echo "<tr><td><p>"._btdirectlink."</p></td><td><p>".$siteurl."/details.php?id=".$_GET['torrent']."&amp;password=".urlencode($password)."</p></td></tr>\n";
}

$sql = "SELECT C.user AS id, IF(U.name IS NULL, U.username, U.name) AS username, U.level FROM torrent_download_completed C, torrent_users U WHERE C.user = U.id AND C.torrent = '".$_GET['torrent']."';";
$comres = $db->sql_query($sql);

if ($db->sql_numrows($comres) > 0) {
        #Separator
        echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

        $lst = Array();
        while ($comrow = $db->sql_fetchrow($comres)) {
                $img = ($comrow["level"] != "user") ? pic("icon_".$comrow["level"].".gif") : "";
                $lst[] = "<a href=\"user.php?op=profile&amp;id=".$comrow["id"]."\">".$comrow["username"].$img."</a>";
        }

        echo "<tr><td><p>"._btcompletedby."</p></td><td><p>".implode(", ",$lst)."</p></td></tr>\n";
}

$db->sql_freeresult($comres);
echo "</table>";
CloseTable();
echo"</span>";
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'view_nfo_page':{
        $nfo = "";
        $nf = fopen("torrent/".$_GET['torrent'].".nfo","rb");
        while (!feof($nf)) $nfo .= fread($nf,100);
        fclose($nf);
        OpenTable("NFO");
        echo "<p class=\"nfo\">".nl2br(str_replace(" ","&nbsp;",htmlentities($nfo)))."</p>";
        CloseTable();
        unset($nfo);
		ob_end_flush();
$db->sql_close();
die();
		}
		case 'view_details':{

		echo"<span id=CL" . $_GET['torrent'] . "><span id=ID2" . $_GET['torrent'] . "><p onclick=\"sndReq('op=close_view_details&torrent=" . $_GET['torrent'] . "', 'CL" . $_GET['torrent'] . "')\">".pic("minus.gif","",_btddetails)."</p></span>";
		$sql = "SELECT A.id as id, A.exeem, A.seeders, A.leechers, A.tot_peer, A.speed, A.info_hash, A.filename, A.banned, A.nuked, A.nukereason, A.password, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, A.numratings, A.name, IF(A.numratings < '".$minvotes."', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, A.save_as, A.descr, A.visible, A.size, A.plen, A.added, A.views, A.downloaded, A.completed, A.type, A.private, A.min_ratio, A.numfiles, A.owner, A.ownertype, A.complaints, A.evidence, A.tracker, A.tracker_list, A.dht as dht, A.md5sum as md5sum, A.uploader_host as user_host, B.name AS cat_name, IF(C.name IS NULL, C.username, C.name) as ownername, A.tracker_update, COUNT(S.status) as auths FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id LEFT JOIN ".$db_prefix."_privacy_file S ON S.torrent = A.id AND S.status = 'pending' WHERE A.id = '".$_GET['torrent']."' GROUP BY A.id LIMIT 1;";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$torrent = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
		if (can_download($user,$torrent)) {
        $can_access = true;
		} else {
        $can_access = false;
		}
$infohash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($torrent["info_hash"],20));
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
        break;
}
        if ($torrent["tracker"] == "") $width = "20%";
        else $width = "33%";
        if ($torrent["tracker"] == "") {
                $complsql = "SELECT SUM(T.size-P.to_go)/(COUNT(P.id)*T.size) as complete FROM ".$db_prefix."_torrents T, ".$db_prefix."_peers P WHERE T.id = '".$_GET['torrent']."' AND P.torrent = '".$_GET['torrent']."';";
                $complres = $db->sql_query($complsql) or bterror($complsql);
                list ($completepercent) = $db->sql_fetchrow($complres);
                $db->sql_freeresult($complres);
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
        }
#Torrent Name
echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"details\">\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "<tr><td class=\"torrentname\" align=\"center\">".htmlspecialchars(str_replace(Array(".","_"),Array(" "," "),stripslashes($torrent["name"])))."</td>";
echo "</tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "</table>\n";
echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" class=\"details\">\n";
#Actions
$flag = getauthstatus($torrent);
echo "<tr><td><p>"._btactions."</p></td><td><p>";
if ($torrent["filename"] != "" AND $torrent["type"] != "link") {
        $passlink = "";
        if ($torrent["password"] != "") $passlink = "&amp;password=".urlencode($torrent["password"]);
        if ($can_access) {
                echo pic("download.gif","download.php?id=".$_GET['torrent'].$passlink,_btalt_download);
                if ($user->passkey != "")
                        help(pic("export.gif","download.php?id=".$_GET['torrent'].$passlink."&amp;export=1"),_btexportexplain,_btexport);
        } elseif ($user->user AND $torrent_global_privacy AND $torrent["owner"] != $user->id AND $torrent["ownertype"] != 2) {
                if ($flag == AUTH_NONE) echo pic("lock_request.gif","details.php?op=authorization&amp;id=".$_GET['torrent'].$passlink,_btalt_lock_request);
                else echo pic("lock.gif",null,_btalt_lock);
        } elseif ($download_level = "user") {
                help(pic("download.gif","",null),_btregistereddownload);
        } elseif ($download_level = "premium") {
                help(pic("download.gif","",null),_btpremiumdownload);
        }
}
if ($torrent["exeem"] != "" AND $can_access) echo pic("exeem.gif",$torrent["exeem"],_btalt_exeem);

if ($torrent["dht"] == "yes") {
        echo pic("magnet.gif","magnet:?xt=urn:btih:".hex_to_base32($infohash_hex),_btalt_magnet);
}
if (($torrent["owner"] == $user->id AND checkaccess("edit_own_torrents")) OR checkaccess("can_edit_others_torrents")) echo pic("edit.gif","edit.php?id=".$torrent["id"],_btalt_edit).pic("drop.gif","edit.php?op=delete&amp;id=".$torrent["id"],_btalt_drop);
	#Ban button
		if (checkaccess("bann_torrents") AND $row["banned"] != "yes"){
			echo pic("ban.png","edit.php?op=ban&amp;id=".$torrent["id"],_btban);
		}
	#Scrape button
		if ($user->moderator AND $torrent["tracker"] != ""){
			 echo pic("refresh.png","scrape-external.php?id=".$torrent["id"]."&amp;tracker=".$torrent["tracker"]."&amp;back=yes",_btalt_scrape);
               	}

if ($torrent["owner"] == $user->id AND $torrent_global_privacy AND $torrent["tracker"] == "") {
        if ($torrent["auths"] > 0) echo pic("auth_pending.gif","mytorrents.php?op=displaytorrent&amp;id=".$torrent["id"],_btalt_auth_pending);
        else echo pic("auth_none.gif","mytorrents.php?op=displaytorrent&amp;id=".$torrent["id"],_btalt_auth_none);
}
echo "</p></td></tr>\n";

#Download As
#if ($torrent["save_as"] != "") {
#        echo "<tr><td><p>"._btdownloadas."</p></td><td><p>".$torrent["save_as"];
#        if ($torrent["md5sum"] != "") echo "<br />md5sum: ".$torrent["md5sum"];
#        echo "</p></td></tr>\n";
#}

#Download Authorization
if ($torrent_global_privacy AND $user->user AND !$user->premium AND $torrent_global_privacy AND $download_level=="user" AND $torrent["owner"] != $user->id AND $torrent["private"] == "true" AND $torrent["owner"] != 0) {
        echo "<tr><td><p>"._btauthstatus."</p></td>";
        switch ($flag) {
                case AUTH_PENDING: {
                        echo "<td><p class=\"pending\">"._btdwauthpending."</p></td>";
                        break;
                }
                case AUTH_GRANTED: {
                        echo "<td><p class =\"granted\">"._btdwauthgranted."</p></td>";
                        break;
                }
                case AUTH_DENIED: {
                        echo "<td><p class =\"denied\">"._btdwauthdenied."<p></td>";
                        break;
                }
                case AUTH_NONE: {
                        echo "<td><p class =\"pending\">"._btdwauthnorequest."<p></td>";
                        break;
                }
        }
        echo "</tr>\n";
}

#Size
echo "<tr><td><p>"._btdim."</p></td><td><p>".mksize($torrent["size"])."</p></td></tr>\n";
#Pieces
#if ($torrent["type"] != "link") echo "<tr><td><p>"._btpieces."</p></td><td><p>".str_replace(Array("**n**","**l**"),Array(intval(($torrent["size"]/$torrent["plen"])),mksize($torrent["plen"])),_btpiecesstring)."</p></td></tr>\n";
#Date added
echo "<tr><td><p>"._btrequest_added."</p></td><td><p>".formatTimeStamp($torrent["added"])."</p></td></tr>\n";
#Minimum Ratio
if ($torrent["private"] == "true" AND $torrent["min_ratio"] > "0.00" AND ($user->moderator OR $torrent["owner"] == $user->id))
        echo "<tr><td><p>"._btminratio."</p></td><td><p>".number_format($torrent["min_ratio"],2)."</p></td></tr>\n";
#Separator
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
$descript = format_comment($torrent["descr"],false,true);
parse_smiles($descript);
#Description
if (!empty($torrent["descr"])) {//Sometimes massive upload Torrents do not have description
        echo "<tr><td><p>"._btdescription."</p></td><td id=\"descrTD".$torrent['id']."\">".($user->admin ? "<a ondblclick=\"sndReq('op=edit_torrent_descr&torrent=".$torrent['id']."', 'descrTD".$torrent['id']."')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "");
        if ($descript != strip_tags($descript)) //Means it is written in HTML
                echo $descript;
        else
                echo "<p>".str_replace("\n","<br>",$descript)."</p>";
        echo "</td></tr>\n";
}


#Info Hash & Tracker
if ($torrent["type"] != "link") {
        #Separator
        echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

        echo "<tr><td><p>";
        help(pic("help.gif"),_btinfohashhelp,_btinfohash);
        echo _btinfohash."</p></td>";
        echo "<td><p>".$infohash_hex."</p></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
        ##Single Tracker
        echo "<tr><td><p>"._bttracker."</p></td><td><p>";
        if ($torrent["tracker"] == "") {
                echo $siteurl;
        } else {
                echo "<a href=\"".preg_replace('/announce.*$/', '', $torrent["tracker"])."\">".$torrent["tracker"]."</a>";
        }
        echo "</p></td></tr>\n";
        if ($torrent["tracker_list"] != "") {
                echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
		echo "<tr><td><p>"._bttrackers."</p></td><td>\n";
                $trackers = explode("\n\n",$torrent["tracker_list"]);
                for ($i = 0; $i < count($trackers); $i++) {
                        $trackers[$i] = explode("\n",$trackers[$i]);

                        echo "<p>".str_replace("*",$i,_bttrackergroup)."\n";
                        echo "<ul>\n";
                        for ($j = 0; $j < count($trackers[$i]); $j++) {
                                echo "<li>";
								$pos = strpos($trackers[$i][$j], $announce_url);
                                if ($pos !== false) echo "<p>".$siteurl."</p>\n";
                                else echo "<p><a href=\"".preg_replace('/announce.*$/', '', $trackers[$i][$j])."\">".$trackers[$i][$j]."</a></p>";
                                echo "</li>\n";
                        }
                        echo "</ul>\n";
                        echo "<br />\n";

                }
                unset($trackers);
                echo "</td></tr>\n";
        }

}

#Separator
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";


#Category
echo "<tr><td><p>"._bttype."</p></td><td id=\"catTD\"><p ondblclick=\"sndReq('op=change_type_torrent&torrent=".$_GET['torrent']."', 'catTD')\">".$torrent["cat_name"]."</p></td></tr>\n";

#File number
echo "<tr><td><p>"._btnfile."</p></td><td><p>".$torrent["numfiles"]."</p></td></tr>\n";

#Uploaded by
echo "<tr><td><p>"._btuppedby."</p></td><td><p>";
switch ($torrent["ownertype"]) {
        case 0: {
                echo "<a href=\"user.php?op=profile&amp;id=".$torrent["owner"]."\"><font color=\"".getusercolor(getlevel_name($torrent["owner"]))."\">".htmlspecialchars($torrent["ownername"])."</font></a>";
                if ($user->admin) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[".htmlspecialchars($torrent["user_host"])."]";
                break;
        }
        case 1: {
                if ($user->moderator) echo "<a href=\"user.php?op=profile&amp;id=".$torrent["owner"]."\"><font color=\"".getusercolor(getlevel_name($torrent["owner"]))."\">".htmlspecialchars($torrent["ownername"])."</font></a>";
                else echo "<i>"._btunknown."</i>";
                if ($user->admin) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[".htmlspecialchars($torrent["user_host"])."]";
        }
        case 2: {
                if ($user->admin) echo "[".htmlspecialchars($torrent["user_host"])."]";
                else echo "<i>"._btunknown."</i>";
        }
}
echo "</p></td></tr>\n";

#Last Seed
if($torrent["type"]!="link" AND $torrent["tracker"] == ""){
        echo "<tr><td><p>"._btlastseeder."</p></td><td><p>".mkprettytime($torrent["lastseed"]) ." "._btago."</p></td></tr>\n";
#Separator
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
#snatched
if ($user->user) echo "<tr><td><p>View Snatched: </font></p></td><td><p><a href=\"viewsnatches.php?id=" . $_GET['torrent'] . "\"><font ><h3>[View!]</h3></font></a>";
				  
}
print("<tr><td><p>Nuked</p></td><td><p>".$torrent["nuked"]."</p></td></tr>\n");
if ($torrent["nuked"] == "yes")print("<tr><td><p>Nuked Reason</td><td><p>".$torrent["nukereason"]."</p></td></tr>\n");
if ($torrent["nuked"] == "unnuked")print("<tr><td><p>Unnuked Reason</td><td><p>".$torrent["nukereason"]."</p></td></tr>\n");
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
#reseed
if ($user->user)echo "<tr><td><p>REQUIST A RESEED:</p></td><td><p><a href=\"re-seed.php?id=" . $_GET['torrent'] . "\"><font ><h3>[RESEED NOW!]</h3></font></a>";

#Separator
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";


#Views
echo "<tr><td><p>"._btview."</p></td><td><p>".$torrent["views"]."</p></td></tr>\n";

#Downloads
echo "<tr><td><p>"._btdownloaded."</p></td><td><p>".$torrent["downloaded"]."</p></td></tr>\n";

#Completed
echo "<tr><td><p>"._btsnatch."</p></td><td><p>".$torrent["completed"]."</p></td></tr>\n";

if ($user->user AND $torrent["password"] != "" AND ($user->id == $torrent["owner"] OR $user->premium)) {
        #Separator
        echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

        echo "<tr><td><p>"._btpassword."</p></td><td><p>".htmlspecialchars($torrent["password"])."</p></td></tr>\n";
        echo "<tr><td><p>"._btdirectlink."</p></td><td><p>".$siteurl."/details.php?id=".$_GET['torrent']."&amp;password=".urlencode($password)."</p></td></tr>\n";
}

$sql = "SELECT C.user AS id, IF(U.name IS NULL, U.username, U.name) AS username, U.level FROM torrent_download_completed C, torrent_users U WHERE C.user = U.id AND C.torrent = '".$_GET['torrent']."';";
$comres = $db->sql_query($sql);

if ($db->sql_numrows($comres) > 0) {
        #Separator
        echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

        $lst = Array();
        while ($comrow = $db->sql_fetchrow($comres)) {
                $img = ($comrow["level"] != "user") ? pic("icon_".$comrow["level"].".gif") : "";
                $lst[] = "<a href=\"user.php?op=profile&amp;id=".$comrow["id"]."\">".$comrow["username"].$img."</a>";
        }

        echo "<tr><td><p>"._btcompletedby."</p></td><td><p>".implode(", ",$lst)."</p></td></tr>\n";
}

$db->sql_freeresult($comres);
echo "</table></span>";
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'archivedeleteshout':{
		$sql = "SELECT `text`, `user` FROM `".$db_prefix."_shouts` WHERE `id` = '".$_GET['shout']."'";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$shout = $db->sql_fetchrow( $res );
		// make sure user is owner of torrent
        if ($shout['user'] != $user->id AND !$user->moderator){
		error("Invalid permissions!");
		}

		$db->sql_query("DELETE FROM `".$db_prefix."_shouts` WHERE `".$db_prefix."_shouts`.`id`='".$_GET['shout']."' LIMIT 1");
		echo "";
		ob_end_flush();
$db->sql_close();
die();

		}
		case 'get_imdb':{
        require ("imdb/imdb.class.php");
        $sql = "SELECT A.id as id, A.exeem, A.seeders, A.leechers, A.tot_peer, A.speed, A.info_hash, A.filename, A.banned, A.nuked, A.nukereason, A.password, A.imdb, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, A.numratings, A.name, IF(A.numratings < '".$minvotes."', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, A.save_as, A.descr, A.visible, A.size, A.plen, A.added, A.views, A.downloaded, A.completed, A.type, A.private, A.min_ratio, A.numfiles, A.owner, A.ownertype, A.complaints, A.evidence, A.tracker, A.tracker_list, A.dht as dht, A.md5sum as md5sum, A.uploader_host as user_host, B.name AS cat_name, IF(C.name IS NULL, C.username, C.name) as ownername, A.tracker_update, COUNT(S.status) as auths FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id LEFT JOIN ".$db_prefix."_privacy_file S ON S.torrent = A.id AND S.status = 'pending' WHERE A.id = '".$_GET['torrent']."' GROUP BY A.id LIMIT 1;";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$torrent = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
		if (can_download($user,$torrent)) {
        $can_access = true;
		} else {
        $can_access = false;
		}
        OpenTable('IMDB INFO');
				echo "<script type=\"text/javascript\" src=\"imdb/swfobject.js\"></script>";
				

          //auto imdb mod
                $thenumbers = ltrim(strrchr($torrent["imdb"],'tt'),'tt');
                $thenumbers = ereg_replace("[^A-Za-z0-9]", "", $thenumbers);
                $movie = new imdb ($thenumbers);
				//print_r($movie);
                $movieid = $thenumbers;
                $movie->setid ($movieid);
                $country = $movie->country ();
                $director = $movie->director();
                $write = $movie->writing();
                $produce = $movie->producer();
                $cast = $movie->cast();
                $plot = $movie->plot ();
                $compose = $movie->composer();
                $gen = $movie->genres();
				$trailers = $movie->trailers();
                $mvlang = $movie->language();
                $mvrating = $movie->rating();                
                if (($photo_url = $movie->photo_localurl() ) != FALSE) {
                $smallth = '<img src="'.$photo_url.'">';
                }
                $autodata = "<strong><HR SIZE=1 NOSHADE><br />\n";
                $autodata .= "<font color=\"darkred\" size=\"3\">Information:</font><br />\n";
                $autodata .= "<HR SIZE=1 NOSHADE></strong><br />\n";
				$autodata .= "<strong><font color=\"DarkRed\"> Title: </font></strong>".$movie->title ()."<br />\n";
                $autodata .= "<strong><font color=\"DarkRed\"> Also known as: </font></strong><br>";

                foreach ( $movie->alsoknow() as $ak){
                $autodata .= "".$ak["title"]."".$ak["year"]."".$ak["country"]." ".(($ak["comment"])? "(".$ak["comment"].") " : '') . ", <br>";
                }
                $autodata .= "<br />\n<strong><font color=\"DarkRed\"> Year: </font></strong>".$movie->year ()."<br />\n";
                $autodata .= "<strong><font color=\"DarkRed\"> Runtime: </font></strong>".$movie->runtime ()." mins<br />\n";
                $autodata .= "<strong><font color=\"DarkRed\"> Votes: </font></strong>".$movie->votes ()."<br />\n";
                $autodata .= "<strong><font color=\"DarkRed\"> Rating: </font></strong>".$movie->rating ()."<br />\n";
                $autodata .= "<strong><font color=\"DarkRed\"> Language: </font></strong>".$movie->language ()."<br />\n";
                $autodata .= "<strong><font color=\"DarkRed\"> Country: </font></strong>";
                    
                for ($i = 0; $i + 1 < count ($country); $i++) {
                $autodata .="$country[$i], ";
                }
                $autodata .= "$country[$i]";
                $autodata .= "<br />\n<strong><font color=\"DarkRed\"> All Genres: </font></strong>";
                for ($i = 0; $i + 1 < count($gen); $i++) {
                $autodata .= "$gen[$i], ";
                }
                $autodata .= "$gen[$i]";
                $autodata .= "<br />\n<strong><font color=\"DarkRed\"> Tagline: </font></strong>".$movie->tagline ()."<br />\n";
                $autodata .= "<strong><font color=\"DarkRed\"> Director: </font></strong>";

                for ($i = 0; $i < count ($director); $i++) {
                $autodata .= "<a target=\"_blank\" href=\"http://us.imdb.com/Name?".$director[$i]["imdb"]."\">".$director[$i]["name"]."</a> ";
                }
          
                $autodata .= "<br />\n<strong><font color=\"DarkRed\"> Writing By: </font></strong>";
                for ($i = 0; $i < count ($write); $i++) {
                $autodata .= "<a target=\"_blank\" href=\"http://us.imdb.com/Name?".$write[$i]["imdb"]."\">".$write[$i]["name"]."</a> ";
               }
          
               $autodata .= "<br />\n<strong><font color=\"DarkRed\"> Produced By: </font></strong>";
               for ($i = 0; $i < count ($produce); $i++) {
               $autodata .= "<a target=\"_blank\" href=\"http://us.imdb.com/Name?".$produce[$i]["imdb"]." \">".$produce[$i]["name"]."</a> ";
              }
              
               $autodata .= "<br />\n<strong><font color=\"DarkRed\"> Music: </font></strong>";          
               for ($i = 0; $i < count($compose); $i++) {
               $autodata .= "<a target=\"_blank\" href=\"http://us.imdb.com/Name?".$compose[$i]["imdb"]." \">".$compose[$i]["name"]."</a> ";    
               }

               $autodata .= "<br /><br />\n\n<strong><HR SIZE=1 NOSHADE><br />\n";
               $autodata .= "<font color=\"darkred\" size=\"3\"> Description:</font><br />\n";
               $autodata .= "<HR SIZE=1 NOSHADE></strong>";
               for ($i = 0; $i < count ($plot); $i++) {
               $autodata .= "<br />\n<font color=\"DarkRed\"></font> ";
               $autodata .= $plot[1][$i] ;
               }      
       
               $autodata .= "<br /><br />\n\n<strong><HR SIZE=1 NOSHADE><br />\n";
               $autodata .= "<font color=\"darkred\" size=\"3\"> Cast:</font><br />\n";
               $autodata .= "<HR SIZE=1 NOSHADE></strong><br />\n";

               for ($i = 0; $i < count ($cast); $i++) {
               if ($i > 9) {
                break;
               }
               $autodata .= "<font color=\"DarkRed\"></font><a target=\"_blank\" href=\"http://us.imdb.com/Name?".$cast[$i]["imdb"]."\">".$cast[$i]["name"]."</a> " . " as <strong><font color=\"DarkRed\">".$cast[$i]["role"]." </font></strong><br />\n";
                
                }
               $autodata .= "<br /><br />\n\n<strong><HR SIZE=1 NOSHADE><br />\n";
                $autodata .= "<font color=\"darkred\" size=\"3\">Comments:</font><br />\n";
                $autodata .= "<HR SIZE=1 NOSHADE></strong><br />\n";
				$autodata .= "".$movie->comment ()."<br />\n";
if (!empty($trailers)) {
$autodata .= "<strong><HR SIZE=1 NOSHADE><br />\n";
$autodata .= "<font color=\"darkred\" size=\"3\"> Trailers:</font><br />\n";
$autodata .= "<strong><HR SIZE=1 NOSHADE><br />\n";

    for ($i=0;$i<count($trailers);++$i) {
    if ($i > 14) {
        break;
    }
      $autodata .= "<a target=\"_blank\" href='".$trailers[$i]."'>".$trailers[$i]."</a><br />\n";
    }
    }
                print("<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\"><div><tr><td class=\"heading\" valign=\"top\" align=\"right\">$smallth</td><td valign=\"top\" align=left>$autodata</td></tr></div></table>\n");

               CloseTable();
			 ob_end_flush();
            $db->sql_close();
         die();
	    }
		case 'member_search':{
		if( !isset( $_GET['search'] ) || empty( $_GET['search'] ) ){
		error("Empty queries not allowed!");
		ob_end_flush();
$db->sql_close();
die();

		}
		$search = trim($_GET['search']);
		$class = '';
		if ( isset( $_GET['search'] ) && !empty( $_GET['search'] ) ){
		$query = "username LIKE ('%$search%') AND active='1'";
		if ($search){
		$q = "search=" . htmlspecialchars($search);
		}
		} else{
		$letter = trim($_GET["letter"]);
		if (strlen($letter) > 1){
		die;
		}
		if ($letter == "" || strpos("abcdefghijklmnopqrstuvwxyz", $letter) === false){
		$letter = "a";
		}
		$query = "username LIKE '$letter%' AND active='1'";
		$q = "letter=$letter";
		}
		if ($class){
		$query .= " AND level=$class";
		$q .= ($q ? "&amp;" : "") . "level=$class";
		}
		print("<p>\n");
		for ($i = 97; $i < 123; ++$i){
		$l = chr($i);
		$L = chr($i - 32);
		if ($l == $letter){
		print("<b>$L</b>\n");
		} else{
		print("<a href=?letter=$l><b>$L</b></a>\n");
		}
		}
		print("</p>\n");
		$page = $_GET['page'];
		$perpage = 100;
		$res = mysql_query("SELECT COUNT(*) FROM ".$db_prefix."_users WHERE $query") or sqlerr();
		$arr = mysql_fetch_row($res);
		$pages = floor($arr[0] / $perpage);
		if ($pages * $perpage < $arr[0]){
		++$pages;
		}
		if ($page < 1){
		$page = 1;
		} else{
		if ($page > $pages){
		$page = $pages;
		}
		}
		for ($i = 1; $i <= $pages; ++$i){
		if ($i == $page){
		$pagemenu .= "<b>$i</b>\n";
		} else{
		$pagemenu .= "<a href=?$q&page=$i><b>$i</b></a>\n";
		}
		}
		if ($page == 1){
		$browsemenu .= "<b>&lt;&lt; Prev</b>";
		} else{
		$browsemenu .= "<a href=?$q&page=" . ($page - 1) . "><b>&lt;&lt; Prev</b></a>";
		}
		$browsemenu .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ($page == $pages){
		$browsemenu .= "<b>Next &gt;&gt;</b>";
		} else{
		$browsemenu .= "<a href=?$q&page=" . ($page + 1) . "><b>Next &gt;&gt;</b></a>";
		}
		print("<p>$browsemenu<br>$pagemenu</p>");
		$offset = ($page * $perpage) - $perpage;
		$res = mysql_query("SELECT * FROM ".$db_prefix."_users WHERE $query ORDER BY username LIMIT $offset,$perpage") or sqlerr();
		$num = mysql_num_rows($res);
		print("<table border=1 cellspacing=0 cellpadding=5>\n");
		print("<tr><td class=colhead align=left>User name</td><td class=colhead>Registered</td><td class=colhead>Last access</td><td class=colhead align=left>Level</td></tr>\n");
		for ($i = 0; $i < $num; ++$i){
		$arr = mysql_fetch_assoc($res);
		if ($arr['added'] == '0000-00-00 00:00:00'){
		$arr['added'] = '-';
		}
		if ($arr['last_access'] == '0000-00-00 00:00:00'){
		$arr['last_access'] = '-';
		}
		print("<tr><td align=left><a href=user.php?op=profile&id=$arr[id]><b>$arr[username]</b></a></td>" .
		"<td>$arr[regdate]</td><td>$arr[lastlogin]</td>".
		"<td align=left>" . $arr["level"] . "</td></tr>\n");
		}
		print("</table>\n");
		ob_end_flush();
$db->sql_close();
die();

		}
}

ob_end_flush();
$db->sql_close();
die();
?>