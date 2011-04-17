<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta4-----------------------*
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
@error_reporting(E_ALL & ~(E_NOTICE | E_USER_NOTICE)); //We don't get stupid messages
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);

require_once("include/config_lite.php");
$debug = false; //Enable to get mailed the full response. Useful if you don't have Ethereal

if (
    preg_match("/Mozilla/i", $agent) || 
    preg_match("/Opera/i", $agent) || 
    preg_match("/Links/i", $agent) || 
    preg_match("/Lynx/i", $agent) || 
    isset($_SERVER['HTTP_COOKIE']) || 
    isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) || 
    isset($_SERVER['HTTP_ACCEPT_CHARSET'])
    )
 {
        die("<html><head><title>Error!</title></head><body><h3>Sorry, but this file is not suitable for browsers.</h3></body></html>");
}

if ($stealthmode) die();
function gmtime()
{
    return strtotime(get_date_time());
}

function get_date_time($timestamp = 0)
{
  if ($timestamp)
    return date("Y-m-d H:i:s", $timestamp);
  else
    return gmdate("Y-m-d H:i:s");
}

function benc_str($s) {
   return strlen($s) . ":$s";
}

function validip($ip)
{
	if (!empty($ip) && $ip == long2ip(ip2long($ip)))
	{
		// reserved IANA IPv4 addresses
		// http://www.iana.org/assignments/ipv4-address-space
		$reserved_ips = array (
				array('0.0.0.0','2.255.255.255'),
				array('10.0.0.0','10.255.255.255'),
				array('127.0.0.0','127.255.255.255'),
				array('169.254.0.0','169.254.255.255'),
				array('172.16.0.0','172.31.255.255'),
				array('192.0.2.0','192.0.2.255'),
				array('192.168.0.0','192.168.255.255'),
				array('255.255.255.0','255.255.255.255')
		);

		foreach ($reserved_ips as $r)
		{
				$min = ip2long($r[0]);
				$max = ip2long($r[1]);
				if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
		}
		return true;
	}
	else return false;
}

// Patched function to detect REAL IP address if it's valid
function getip() {
   if (isset($_SERVER)) {
     if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && validip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && validip($_SERVER['HTTP_CLIENT_IP'])) {
       $ip = $_SERVER['HTTP_CLIENT_IP'];
     } else {
       $ip = $_SERVER['REMOTE_ADDR'];
     }
   } else {
     if (getenv('HTTP_X_FORWARDED_FOR') && validip(getenv('HTTP_X_FORWARDED_FOR'))) {
       $ip = getenv('HTTP_X_FORWARDED_FOR');
     } elseif (getenv('HTTP_CLIENT_IP') && validip(getenv('HTTP_CLIENT_IP'))) {
       $ip = getenv('HTTP_CLIENT_IP');
     } else {
       $ip = getenv('REMOTE_ADDR');
     }
   }

   return $ip;
 }
function sqlesc($x) {
return "'".mysql_real_escape_string($x)."'";
}
function hash_where($name, $hash) {
        $shhash = preg_replace('/ *$/s', "", $hash);
return "($name = " . sqlesc($hash) . " OR $name = " . sqlesc($shhash) . ")";
}

function unesc_magic($x) {
        return (get_magic_quotes_gpc()) ? stripslashes($x) : $x;
}

function is_email($email) {
        return preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\\-+)|([A-Za-z0-9]+\\.+)|([A-Za-z0-9]+\\++))*[A-Za-z0-9]+@((\\w+\\-+)|(\\w+\\.))*\\w{1,63}\\.[a-zA-Z]{2,6}$/",$email);
}

function err($msg)
{
   benc_resp(array("failure reason" => array('type' => "string", 'value' => $msg)));
   exit();
}
function benc_resp($d)
{
   benc_resp_raw(benc(array('type' => "dictionary", 'value' => $d)));
}
function benc_int($i) {
return "i" . $i . "e";
}
function benc_list($a) {
$s = "l";
foreach ($a as $e) {
$s .= benc($e);
}
$s .= "e";
return $s;
}
function benc($obj) {
if (!is_array($obj) || !isset($obj["type"]) || !isset($obj["value"]))
return;
$c = $obj["value"];
switch ($obj["type"]) {
      case "string":
         return benc_str($c);
      case "integer":
         return benc_int($c);
      case "list":
         return benc_list($c);
      case "dictionary":
         return benc_dict($c);
      default:
         return;
   }
}
function benc_dict($d) {
   $s = "d";
   $keys = array_keys($d);
   sort($keys);
   foreach ($keys as $k) {
      $v = $d[$k];
      $s .= benc_str($k);
      $s .= benc($v);
   }
   $s .= "e";
   return $s;
}

function hash_pad($hash) {
        return str_pad($hash, 20);
}
function benc_resp_raw($x){
header("Content-Type: text/plain");
header("Pragma: no-cache");
print($x);
}
$dt = strtotime(gmdate("Y-m-d H:i:s", time())) - 180;//OFFSET
$dt = gmdate("Y-m-d H:i:s", $dt);

function GetUserAgent($pid) {
        $strAgent = "Unknown";
        $strversion = "";
        $http = false;


        if ($pid[0] == "-" AND $pid[7] == "-") { //Azureus Convention
                $ltrs = $pid[1].$pid[2];
                $strversion = sprintf("%s.%s.%s.%s", $pid[3], $pid[4], $pid[5], $pid[6]);
                if ($ltrs == "AZ") { $strAgent = "Azureus"; $http = true;}
                elseif ($ltrs == "UT") { $strAgent = "&micro;Torrent"; $http = true;}
                elseif ($ltrs == "MT") $strAgent = "MoonlightTorrent";
                elseif ($ltrs == "LT") $strAgent = "libtorrent";
                elseif ($ltrs == "BX") $strAgent = "Bittorrent X";
                elseif ($ltrs == "TS") $strAgent = "Torrentstorm";
                elseif ($ltrs == "SS") $strAgent = "Swarmscope";
                elseif ($ltrs == "XT") $strAgent = "XanTorrent";
                elseif ($ltrs == "BB") $strAgent = "BitBuddy";
                elseif ($ltrs == "TN") $strAgent = "TorrentDOTnet";
				elseif ($ltrs == "BC") $strAgent = "BitComet";
                //else; Unknown client using this naming.
        } elseif ($pid[4] == '-' AND $pid[5] == '-' AND $pid[6] == '-' AND $pid[7] == '-' ) {
                $strversion = sprintf(" %i%i%i", $pid[1] - '0', $pid[2] - '0', $pid[3] - '0' );
                if ($pid[0] == 'A') $strAgent = "ABC";
                elseif ($pid[0] == 'S') $strAgent = "Shadow";
                elseif ($pid[0] == 'T') $strAgent = "BitTornado";
                elseif ($pid[0] == 'U') $strAgent = "UPnP NAT BT";
                //else; Unknown client using this naming.
        }
        return Array($strAgent, $strversion, $http);
}
//GET DETAILS OF PEERS ANNOUNCE
$req = "info_hash:peer_id:!ip:port:uploaded:downloaded:left:!event:!key:!compact:!no_peer_id:!passkey";
if (strpos($passkey, "?"))
{
  $tmp = substr($passkey , strpos($passkey , "?"));
  $passkey  = substr($passkey , 0,strpos($passkey , "?"));
  $tmpname = substr($tmp, 1, strpos($tmp, "=")-1);
  $tmpvalue = substr($tmp, strpos($tmp, "=")+1);
  $$tmpname = $tmpvalue;
}
foreach (explode(":", $req) as $x) {
        if ($x[0] == "!") {
                $x = substr($x, 1);
                $opt = true;
        }
        else
                $opt = false;
        if (!isset($$x)) {
                if (!$opt) err("missing key");
                else $xx = "";
                continue;
        }
        $$x = unesc_magic($$x);
}

foreach (array("info_hash","peer_id") as $x) {
        if (strlen($$x) != 20)
                err("invalid $x (" . strlen($$x) . " - " . urlencode($$x) . ")");
}
$port = 0 + $port;
$downloaded = 0 + $downloaded;
$uploaded = 0 + $uploaded;
$left = 0 + $left;
$real_ip = getip();
if (!isset($ip) OR !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip))
        $ip = $real_ip;
		if($ip == "0.0.0.0")err("Bad Ip report");
else $ip = sprintf("%u",ip2long($ip));




$sql = "SELECT reason FROM ".$db_prefix."_bans WHERE ipstart <= '".$ip."' AND ipend >= '".$ip."' LIMIT 1;";
$ban_res = $db->sql_query($sql) or err("SQL Error: ".$sql);
if ($db->sql_numrows($ban_res) > 0) {
        list ($reason) = $db->sql_fetchrow($ban_res);
        err("You are banned from this tracker. Reason: ".$reason);
}
$db->sql_freeresult($ban_res);
if ($force_passkey AND $passkey == "") err("Only users with Passkey are allowed to use our tracker.");

if ($passkey != "") {
        //Passkey authentication comes first
        $sql_where = "passkey = '".urldecode($passkey)."' ";
} elseif (array_key_exists("PHP_AUTH_USER",$_SERVER) AND array_key_exists("PHP_AUTH_PW",$_SERVER)) {
        //HTTP authentication has yeld over IP authentication
        $sql_where = "username = '".addslashes($_SERVER["PHP_AUTH_USER"])."' AND password = '".md5($_SERVER["PHP_AUTH_PW"])."'";
} else {
        $sql_where = "lastip = '".$ip."'";
}
$user_sql = "SELECT id, level, uploaded, downloaded, ban, banreason, can_do, dongift FROM ".$db_prefix."_users WHERE ".$sql_where." OR seedbox = '".$ip."' ORDER BY lastlogin DESC LIMIT 1;";
if (!$userres = $db->sql_query($user_sql)) err("SQL Error: ".mysql_error());
if ($userrow = $db->sql_fetchrow($userres)) {
        $uid = $userrow["id"];
		$usergift = $userrow['dongift'];
        $ulevel = $userrow["level"];
} else {
        if ($passkey != "") err("Invalid Passkey. It may have been renewed.");
        $uid = 0;
        $ulevel = "user";
}
$db->sql_freeresult($userres);
//if $ip
                        $sql = "SELECT client, reason FROM ".$db_prefix."_client_ban";
                        $res = $db->sql_query($sql);
                        while ($banedclient = $db->sql_fetchrow($res)){
                        if (strpos($peer_id,$banedclient['client'])) err($banedclient['reason']);
						}
                        $db->sql_freeresult($res);
/* CLIENT INFORMATION */

if($userrow['ban'] == 1)err('You are banned on this site for '.$userrow['banreason']);
if($userrow['can_do'] == 'SHIT HEAD')err('Your level dose not allow you to access downloads');

/* CLIENT INFORMATION */
list ($client, $clientversion, $http_auth) = GetUserAgent($peer_id);
if ($client == "Unknown") $client = "NULL";
else $client = "'".$client."'";

/* SHOULD GIVE HTTP ERROR ONLY IF CLIENT IS KNOWN TO SUPPORT HTTP AUTHENTICATION */
if ($announce_level == "user" AND $uid == 0) {
        //If client supports HTTP Authentication, we perform that
        if ($http_auth) {
                header("WWW-Authenticate: Basic realm=\"".$sitename."\"");
                header('HTTP/1.0 401 Unauthorized');
        }
        err("Only registered users are allowed to use our tracker");
}

$port = intval($port);
if (!is_numeric($downloaded)) err("Downloaded size must be numeric");
if (!is_numeric($uploaded)) err("Uploaded size must be numeric");
if (!is_numeric($left)) err("Left size must be numeric");

$rsize = 50;
foreach(array("num want", "numwant", "num_want") as $k) {
        if (isset($$k) AND $$k<50) {
                $rsize = intval($$k);
                break;
        }
}

if (!$port OR $port > 0xffff)
        err("Invalid port");

if (!isset($event))
        $event = "";
//if($uid == 5)err($event);
$seeder = ($left == 0 OR $event == "completed") ? "yes" : "no";
if($seeder == 'no' AND $userrow['can_do'] == 'SHIT HEAD')err('Your level dose not allow you to access downloads');
$sql_select = "SELECT id, name, added, seeders, leechers , completed, category, ratiobuild, size,  UNIX_TIMESTAMP(added) AS ts FROM ".$db_prefix."_torrents WHERE banned = 'no' AND " . hash_where("info_hash", $info_hash)." LIMIT 1;";
$res = $db->sql_query($sql_select) or err("SQL Error = ".mysql_error());

if ($db->sql_numrows($res) < 1) err("Torrent not registered with this tracker.");
$torrent = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
$torrentadded = $torrent["added"];
$tadded = $torrent["ts"];
$torrentid = $torrent["id"];
$torrentname = $torrent["name"];
$seeders = $torrent["seeders"];
$leechers = $torrent["leechers"];
$completed = $torrent["completed"];
$ratiobuild = $torrent["ratiobuild"];
$torrentcategory = $torrent["category"];

   if ($wait_time){
      if ($left > 0 && $userrow["level"] == "user")
         {
            $gigs = $userrow["uploaded"] / (1024*1024*1024);
            $elapsed = floor((strtotime(gmdate("Y-m-d H:i:s")) - $tadded) / 3600);
            if ($userrow['downloaded'] == 0) $ratio = 0;
            else
            $ratio = (($userrow["downloaded"] > 0) ? ($userrow["uploaded"] / $userrow["downloaded"]) : 1);
            if ($ratio == 0 && $gigs == 0) $wait = 24+4;
            elseif ($ratio < $RATIOA || $gigs < $GIGSA) $wait = $WAITA+4;
            elseif ($ratio < $RATIOB || $gigs < $GIGSB) $wait = $WAITB+4;
            elseif ($ratio < $RATIOC || $gigs < $GIGSC) $wait = $WAITC+4;
            elseif ($ratio < $RATIOD || $gigs < $GIGSD) $wait = $WAITD+4;
            else $wait = 0;
         if ($wait)
         if ($elapsed < $wait)
            err("Not authorized Most Wait(" . ($wait - $elapsed) . "h) - READ THE FAQ! $siteurl/faq.php#69");
         }
   }
unset($sql_select, $res, $torrent);

if(isset($compact) AND $compact !=1){
$resp = "d" . benc_str("interval") . "i" . $announce_interval . "e". benc_str("complete") . "i" . $seeders . "e" . benc_str("incomplete") . "i" . $leechers . "e" . benc_str("downloaded") . "i" . $completed . "e" . benc_str("private") . 'i1e' . benc_str("peers") . "le" . benc_str("min interval") . "i" . $announce_interval_min . "e";
//unset($announce_interval, $announce_interval_min);
$seedwhere = "";
if (!empty($announce_text)) $resp .= "15:warning message". strlen($announce_text) .":". $announce_text;
}else{
$resp = "d" . benc_str("interval") . "i" . $announce_interval . "e". benc_str("complete") . "i" . $seeders . "e" . benc_str("incomplete") . "i" . $leechers . "e" . benc_str("downloaded") . "i" . $completed . "e"  . benc_str("min interval") . "i" . $announce_interval_min . "e";
}

if ($event != "stopped") {
        $sql_select = "SELECT seeder, peer_id, unique_id, ip, port FROM ".$db_prefix."_peers WHERE torrent = '".$torrentid."' ".$seedwhere." ORDER BY RAND() LIMIT ".$rsize.";";
        $res = $db->sql_query($sql_select) or err("SQL Error = ".$sql_select);
        unset($seedwhere, $rsize);

                $resp .= benc_str("peers")."l";
                while ($row = $db->sql_fetchrow($res)) {
				//err($peer_id);
                        if ($row["peer_id"] === $peer_id) {
                                continue;
                        }
   $resp .= "d" .
      benc_str("ip") . benc_str(long2ip($row["ip"])) .
      benc_str("peer id") . benc_str(stripslashes($row["peer_id"])) .
      benc_str("port") . "i" . $row["port"] . "e" .
      "e";
                }
        } else {
                $peers = "";
                while ($row = $db->sql_fetchrow($res)) {
                        $peers .= pack("Nn", sprintf("%d",$row["ip"]), $row["port"]);
                }

                $resp .= "5:peers" . strlen($peers).":".$peers;

        $db->sql_freeresult($res);
        //unset($sql_select, $res);
}
$resp .= "ee";

                unset($row, $sql_select, $res);


$where = "torrent = '".$torrentid."' AND " . hash_where("peer_id", $peer_id);
$selfwhere = $where;
unset($self);
$sql_select = "SELECT P.seeder, P.peer_id, P.unique_id, P.uid, P.ip, P.real_ip, P.port, P.uploaded, P.downloaded, P.upload_speed, UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(P.last_action) as seconds, U.level FROM ".$db_prefix."_peers P LEFT JOIN ".$db_prefix."_users U ON P.uid = U.id WHERE ".$selfwhere.";";
if (!$res = $db->sql_query($sql_select)) err("Error ".$sql_select);
$self = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
$selfupload = 0+$self['uploaded'];
$selfdownloaded = 0+$self['downloaded'];
$selfrealip = $self['real_ip'];
unset($sql, $res);
$updateset = Array();
//err($event);
// EVENT TEST
if ($event == "stopped") {
      //UPDATE SNATCHED You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ' downloaded = downloaded + , ip = '3472370094', port = 37527, agent= '', last_ac' at line 1	updating...	6	0	19	

        $sql="UPDATE ".$db_prefix."_snatched SET seeder = 'no', connectable='no' WHERE torrent = $torrentid AND userid = ".$uid.";";
      $db->sql_query($sql) or err("SQL Error = ".$sql);
      unset($sql);
        $sql_delete = "DELETE FROM ".$db_prefix."_peers WHERE torrent = '".$torrentid."' AND ".$where.";";
        $db->sql_query($sql_delete) or err("SQL Error: ".$sql_delete);
        if ($db->sql_affectedrows() > 0) {
       $hitrun = (($torrentadded > get_date_time(gmtime() - 10800) && ($downloaded / 2) > $uploaded) ? "IF(hitrun = '0000-00-00 00:00:00', '".get_date_time()."', hitrun)" : "hitrun");
       //$db->sql_query("UPDATE ".$db_prefix."_snatched SET  ip = '".$ip."', port = $port, agent= '".$agent.$clientversion."', last_action = '".get_date_time()."', hitrun = $hitrun WHERE torrentid = $torrentid AND userid = $uid") or err(mysql_error());		
                if ($self["seeder"] == "yes")
                        $updateset[] = "seeders = seeders - 1";
                else
                        $updateset[] = "leechers = leechers - 1";

                $updateset[] = "tot_peer = tot_peer - 1";
                $updateset[] = "speed = speed - '".$self["upload_speed"]."'";
        }
        unset($sql_delete);
} elseif ($event == "completed") {
      $sql="UPDATE ".$db_prefix."_snatched SET  finished  = 'yes', completedat = NOW() WHERE torrent = $torrentid AND userid = ".$uid.";";
$db->sql_query($sql);
unset($sql);
        if ($uid != 0) {
                $sql = "INSERT INTO ".$db_prefix."_download_completed ( user , torrent , completed ) VALUES ('".$uid."', '".$torrentid."', NOW());";
                $db->sql_query($sql);
                unset($sql);
        }
        require_once("include/class.email.php");
        require_once("language/mailtexts.php");
        $sql_trigger = "SELECT U.email FROM ".$db_prefix."_users U, ".$db_prefix."_seeder_notify S WHERE S.torrent = '".$torrentid."' AND S.user = U.id AND S.status = 'active';";
        $res_trigger = $db->sql_query($sql_trigger) or err("Error SQL = ".$sql_trigger);
        $notify_mail = New eMail();
        $notify_mail->sender = $admin_email;
        $search = Array("**name**","**sitename**","**siteurl**","**torrenturl**","**unwatchurl**");
        $replace = Array($torrentname,$sitename,$siteurl,$siteurl."/details.php&id=".$torrentid,$siteurl."/details.php&id=".$torrentid."&op=seeder&trig=off");
        $notify_mail->subject = str_replace("**sitename**",$sitename,$seedermailsub[$language]);
        $notify_mail->body = str_replace($search,$replace,$seedermailtext[$language]);
        while ($row_trigger = $db->sql_fetchrow($res_trigger)) {
                $notify_mail->Add($row_trigger["email"]);
        }
        $notify_mail->Send();
        $db->sql_freeresult($res_trigger);
        unset($res_trigger, $sql_trigger);

        $sql_update = "UPDATE ".$db_prefix."_seeder_notify SET status = 'stopped' WHERE torrent = '".$torrentid."';";
        $db->sql_query($sql_update) or err("SQL Error: ".$sql_update);
        unset($sql_update);
        $updateset[] = "completed = completed + 1";
        $updateset[] = "seeders = seeders + 1";
        $updateset[] = "leechers = leechers - 1";
}

/* IF NOT SEEDER OR PREMIUM, CHECK AGAINST REQUIREMENTS */
if ($announce_level == "user" AND $ulevel == "user" AND $seeder == "no" AND $event != "stopped") {
        $torrentsql = "SELECT * FROM ".$db_prefix."_torrents WHERE id = '".$torrentid."' LIMIT 1;";
        $torrentres = $db->sql_query($torrentsql);
        $torrent = $db->sql_fetchrow($torrentres);
        $db->sql_freeresult($torrentres);
        unset($torrentsql, $torrentres);

        $ratiosql = "SELECT uploaded, downloaded FROM ".$db_prefix."_users WHERE id = '".$uid."' LIMIT 1;";
        $ratiores = $db->sql_query($ratiosql) or err("SQL Error: ".$ratiosql);
        list ($useruploaded, $userdownloaded) = $db->sql_fetchrow($ratiores);

        if ($global_min_ratio > 0 AND $userdownloaded > 0) {
                if (number_format($useruploaded/$userdownloaded,2) < $global_min_ratio) err("You need a ratio of at least ".$global_min_ratio." to proceed with download. Seed more files to let your ratio raise!");
        }

        $check_seed = true; // false = trigger found
        $check_leech = true;// false = trigger found

        #Global Privacy Check
        if ($torrent_global_privacy AND $torrent["ownertype"] != 2 AND $torrent["private"] == "true") {
                $authorized = false;
                $found = false;

                $globalauthqry = "SELECT status FROM ".$db_prefix."_privacy_global WHERE master = '".$torrent["owner"]."' AND slave = '".$uid."' LIMIT 1;";
                $globalauthres = $db->sql_query($globalauthqry) or err("SQL Error: ".$globalauthsql);
                unset($globalauthqry);
                if ($db->sql_numrows($globalauthres) == 1) {
                        list ($globalauthstatus) = $db->sql_fetchrow($globalauthres);

                        $found = true;
                        if ($globalauthstatus = "whitelist") $authorized = true;
                        unset($globalauthstatus, $globalauthres);
                } else {
                        $torrentauthsql = "SELECT status FROM ".$db_prefix."__privacy_file WHERE master = '".$torrent["owner"]."' AND torrent = '".$torrentid."' LIMIT 1;";
                        $torrentauthres = $db->sql_query($torrentauthsql) or err("SQL Error: ".$torrentauthsql);
                        if ($db->sql_numrows($torrentauthres) == 1) {
                                list ($torrentauthstatus) = $db->sql_fetchrow($torrentauthres);
                                $found = true;
                                if ($torrentauthstatus == "granted") $authorized = true;
                                unset($torrentauthstatus);
                        }
                        $db->sql_freeresult($torrentauthres);
                        unset($torrentauthsql, $torrentauthres);
                }
                $db->sql_freeresult($globalauthres);
                if (!$found) { //If we are not sure that the user is denied from downloading
                        $min_ratio = number_format($torrent["min_ratio"], 2);
                        if ($min_ratio > 0) {
                                if ($userdownloaded == 0) $authorized = true;
                                elseif (number_format($useruploaded/$userdownloaded) > $min_ratio) $authorized = true;
                                unset($useruploaded, $userdownloaded);
                        }
                }
                unset($found);

                if (!$authorized) err("You are not authorized to download this Torrent. Check your requirements on the Tracker page");
        }
        unset($authorized, $torrent);

        $sql_trigger = "SELECT count(A.seeder) AS tot_seeder_files, A.seeder AS seed, SUM(B.size) AS tot_size, U.level as level FROM ".$db_prefix."_peers A LEFT JOIN ".$db_prefix."_users U ON U.id = '".$uid."', ".$db_prefix."_torrents B WHERE A.uid = '".$uid."' AND A.torrent = B.id GROUP BY ip, seed order by seed";
        $res_trigger = $db->sql_query($sql_trigger) or err("SQL Error: $sql_trigger");
        unset($sql_trigger);
        $row_trigger = $db->sql_fetchrow($res_trigger);

        if ($min_share_seed > 0) {
                if ($row_trigger["seed"] == "no" OR $row_trigger["tot_size"] < $min_share_seed) $check_seed = false;
        }


        if (!$check_seed OR !$check_leech) err("You can't download so much. Wait for your uploads to reach minimum limit and try again");
        $db->sql_freeresult($res_trigger);
        unset($row_trigger);
}

unset($row_trigger);
if ($self) { //Peer is already connected
        //if ($event != "completed" AND $self["seconds"] != 0 AND $self["seconds"]+5 < $announce_interval_min) err("You cannot hammer this tracker. Wait ". intval($announce_interval_min - $self["seconds"]) ." seconds and try again.");
        if ($self["seconds"] != 0){
                $upload_speed = round(($uploaded - $self["uploaded"]) / $self["seconds"]);
                $download_speed = round(($downloaded - $self["downloaded"]) / $self["seconds"] );
                $updateset[] = "speed = speed - '".$self["upload_speed"]."' + '".$upload_speed."'";
        } else {
                $upload_speed = 0;
                $download_speed = 0;
        }
//SNATCH UPDATE
   $res=mysql_query("SELECT uploaded, downloaded, seeding_time FROM ".$db_prefix."_snatched WHERE torrent = $torrentid AND userid = $uid")or err("HELP4");
      $row = mysql_fetch_array($res);
      $sockres = @fsockopen($real_ip, $port, $errno, $errstr, 1.5);
      if($event != "stopped")
      $seeder2 = $seeder;
      else
      {
      $seeder2 = "no";
      }
     if (!$sockres)
      $connectable = "no";
     else
    {
      $connectable = "yes";
      @fclose($sockres);
   }
   $seed_overal = $row['seeding_time'] + $announce_interval_min;
   if($seeder2 == "yes")$seed_for = ", seeding_time = '".$seed_overal."'";
   else
   $seed_for='';
   //if($uid == '5')err("Error ".$seed_for);
      $downloaded2=$downloaded - $self["downloaded"];
      $uploaded2=$uploaded - $self["uploaded"];
      $usna = "UPDATE ".$db_prefix."_snatched SET uploaded = uploaded+$uploaded2, downloaded = downloaded+$downloaded2, port = '".$port."', seeder = '".$seeder."', connectable = '$connectable'".$seed_for.", agent= " . $client . ", ip = '".$ip."', to_go = '".$left."',speedup='".$upload_speed."',speeddown='".$download_speed."', last_action = '".get_date_time()."', warned = 'no', hnr_warning = 'no' WHERE torrent = $torrentid AND userid = ".$uid."";
	  if (!$db->sql_query($usna))err("Error ".$usna);
      //unset($event);
//END SNATCH UPDATE

        $sql_update = "UPDATE ".$db_prefix."_peers SET ip = '".$ip."', real_ip = '".$real_ip."', connectable = '".$connectable."', port = '".$port."', uploaded = '".$uploaded."', downloaded = '".$downloaded."', to_go = '".$left."', last_action = NOW(), seeder = '".$seeder."', download_speed='".$download_speed."', upload_speed='".$upload_speed."' WHERE torrent = '".$torrentid."' AND ".$where.";";
        unset($download_speed, $upload_speed, $where);
        if (!$db->sql_query($sql_update)) err("Error ".$sql_update);
        unset($sql_update);

} else {
        $connectable = "yes";
        if ($autoscrape) {
                $sockres = @fsockopen($real_ip, $port, $errno, $errstr, 1.5);
                if (!$sockres) $connectable = "no";
                @fclose($sockres);
                unset($sockres,$errno,$errstr);
        }
               //SNATCHED MOD
         $res = mysql_query("SELECT torrent, userid FROM ".$db_prefix."_snatched WHERE torrent = $torrentid AND userid = $uid")or err("HELP2");
           $check = mysql_fetch_assoc($res);
         if (!$check AND $seeder == "yes")mysql_query("INSERT INTO ".$db_prefix."_snatched (torrent, torrentid, userid, ip, port, startdat, last_action, agent, torrent_name, torrent_category, finished, completedat) VALUES ($torrentid, $torrentid, $uid, '".$ip."', $port, '".get_date_time()."', '".get_date_time()."', '" . addslashes($agent) .$clientversion. "' , '" . addslashes($torrentname) . "', $torrentcategory, 'yes', NOW())")or err(mysql_error());
         if (!$check AND $seeder != "yes")mysql_query("INSERT INTO ".$db_prefix."_snatched (torrent, torrentid, userid, ip, port, startdat, last_action, agent, torrent_name, torrent_category) VALUES ($torrentid, $torrentid, $uid, '".$ip."', $port, '".get_date_time()."', '".get_date_time()."', '" . addslashes($agent) .$clientversion. "' , '" . addslashes($torrentname) . "', $torrentcategory)")or err(mysql_error());
           //END SNATCHED

        $sql_insert = "INSERT INTO ".$db_prefix."_peers (connectable, torrent, peer_id, ip, port, uploaded, downloaded, to_go, started, last_action, seeder, real_ip, client, version, user_agent, unique_id, uid) VALUES ('".$connectable."', '".$torrentid."', '".addslashes($peer_id). "', '".$ip."', '".$port."', '".$uploaded."', '".$downloaded."', '".$left."', NOW(), NOW(), '".$seeder."', '".$real_ip."', ".$client.", '".$clientversion."', '".$_SERVER["HTTP_USER_AGENT"]."', '".$key."', '".$uid."')";
        if ($db->sql_query($sql_insert)) {
  $hitrun = "IF(hitrun > '".get_date_time(gmtime() - 5400)."', '0000-00-00 00:00:00', hitrun)";
  $hitrunwarn = "IF(hitrun > '".get_date_time(gmtime() - 5400)."', 'no', hitrunwarn)";
  $snh_up = "UPDATE ".$db_prefix."_snatched SET ip = ".$ip.", port = $port, agent = ".addslashes($agent).$clientversion.", last_action = '".get_date_time()."', hitrun = $hitrun, seeder = '".$seeder."', hitrunwarn = $hitrunwarn WHERE torrentid = $torrentid AND userid = $uid";
  $snh_in = "INSERT INTO ".$db_prefix."_snatched (torrentid, userid, port, start_date, agent,ip,peer_id) VALUES ($torrentid, $uid, $port, '".get_date_time()."', '" . addslashes($agent) .$clientversion. "','" . $ip . "','" . $peer_id . "')";
  if(!$db->sql_query($snh_up))$db->sql_query($snh_in);
                if ($seeder == "yes")
                        $updateset[] = "seeders = seeders + 1";
                else
                        $updateset[] = "leechers = leechers + 1";
                $updateset[] = "tot_peer = tot_peer + 1";
        } else err("SQL Error = $sql_insert");
        unset($sql_insert);
}
$clientused = str_replace("'","",$client) . " " . $clientversion;
        unset($connectable, $ip, $port, $left, $real_ip, $client, $clientversion, $key);

$updateset[] = "visible = 'yes'";
if ($seeder == "yes") {
        $updateset[] = "last_action = NOW()";
}
unset($seeder);

if (count($updateset)) {
        $sql_update = "UPDATE ".$db_prefix."_torrents SET " . implode(",", $updateset) . " WHERE id = '".$torrentid."';";
        $db->sql_query($sql_update) or err("Error SQL = ".$sql_update);
        unset($updateset,$sql_update);
}
unset($torrentid);
$setdownload = 0;
$setupload = 0;
if($usergift == 1)$ratiobuild = 'yes';
		$setupload = $uploaded-$selfupload;
		$setdownload = $downloaded-$selfdownloaded;
if ($free_dl OR $ratiobuild == "yes" )$setdownload = 0;
//Update user ratio
if ($uid != 0 AND !($event =="started")) {
        $sql = "UPDATE ".$db_prefix."_users SET uploaded = uploaded + ".$setupload.", downloaded = downloaded + ".$setdownload." WHERE id=".$uid." LIMIT 1;";
        $db->sql_query($sql) or err("SQL Error: ".$sql);
}
unset($uploaded ,$downloaded, $self, $uid, $sql);
function bt_pm_out($sender, $recipient, $subject, $text){
        global $db, $db_prefix;
		//if(!isset($sender, $recipient, $subject, $text)){
		//}
                $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('".$sender."','".$recipient."','".$db->sql_escape(stripslashes($subject))."', '".$db->sql_escape(stripslashes($text))."',NOW());");
}
//bt_pm_out('0','1',"Announce Debug",$_SERVER["REQUEST_URI"]."\n\n\n".$resp);


if ($debug) {
        $email = New eMail();
        $email->Add($admin_email);
        $email->subject = "Announce Debug";
        $email->body = $_SERVER["REQUEST_URI"]."\n\n\n".$resp;
        $email->Send();
}
benc_resp_raw($resp);
$db->sql_close();
die();
?>
