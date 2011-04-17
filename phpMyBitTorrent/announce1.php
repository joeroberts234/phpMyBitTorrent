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

require_once("include/config_lite.php");
$debug = false; //Enable to get mailed the full response. Useful if you don't have Ethereal

if (eregi("(Mozilla|Opera|Lynx|Netscape|Links|curl)",$HTTP_SERVER_VARS["HTTP_USER_AGENT"])) {
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

function ip_first($ips) {
  if (($pos = strpos($ips, ',')) != false) {
    return substr($ips, 0, $pos);
  } else {
    return $ips;
  }
}

function ip_valid($ips) {
  if (isset($ips)) {
    $ip    = ip_first($ips);
    $ipnum = ip2long($ip);
    if ($ipnum !== -1 && $ipnum !== false && (long2ip($ipnum) === $ip)) { // PHP 4 and PHP 5
      if (($ipnum < 167772160   || $ipnum >   184549375) && // Not in 10.0.0.0/8
          ($ipnum < -1408237568 || $ipnum > -1407188993) && // Not in 172.16.0.0/12
          ($ipnum < -1062731776 || $ipnum > -1062666241))   // Not in 192.168.0.0/16
        return true;
    }
  }
  return false;
}

function getip() {
  $check = array('HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
                 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED',
                 'HTTP_VIA', 'HTTP_X_COMING_FROM', 'HTTP_COMING_FROM');

  foreach ($check as $c) {
    if (ip_valid(&$_SERVER[$c])) {
      return ip_first($_SERVER[$c]);
    }
  }

  return $_SERVER['REMOTE_ADDR'];
}
function hash_where($name, $hash) {
        $shhash = preg_replace('/ *$/s', "", $hash);
        return "($name = '" . addslashes($hash) . "' OR $name = '" . addslashes($shhash) . "' OR $name = '".addslashes(urldecode($hash))."')";
}

function unesc_magic($x) {
        return (get_magic_quotes_gpc()) ? stripslashes($x) : $x;
}

function is_email($email) {
        return preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\\-+)|([A-Za-z0-9]+\\.+)|([A-Za-z0-9]+\\++))*[A-Za-z0-9]+@((\\w+\\-+)|(\\w+\\.))*\\w{1,63}\\.[a-zA-Z]{2,6}$/",$email);
}

function err($msg)
{
   benc_resp(array("failure reason" => array(type => "string", value => $msg)));
   exit();
}
function benc_resp($d)
{
   benc_resp_raw(benc(array(type => "dictionary", value => $d)));
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
