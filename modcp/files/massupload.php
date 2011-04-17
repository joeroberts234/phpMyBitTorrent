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

if (!defined('IN_PMBT')) die ("You can't access this file directly");

/*
if (!function_exists("memory_get_usage")) {
   function memory_get_usage() {
       if (substr(PHP_OS,0,3) == "WIN") {
               $output = array();
               exec("tasklist /FI \"PID eq " . getmypid() . "\" /FO LIST", $output );
               $ret = preg_replace ( "/[\D]/", "", $output[5] ) * 1024;
               return $ret;
       } else {
           $pid = getmypid();
           exec("ps -eo%mem,rss,pid | grep $pid", $output);
           $output = explode("  ", $output[0]);
           //rss is given in 1024 byte units
           return $output[1] * 1024;
       }
   }
}
*/
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

function ResolveTracker($url, &$resp) {
        $server = parse_url($url);

        if (!$server["port"]) $server["port"] = 80;

        $out  = "HEAD ".$server["path"]." HTTP/1.1\r\n";
        $out .= "Host: ".$server['host']."\r\n";
        $out .= "User-Agent: Azureus 2.5.0.0\r\n";
        $out .= "Connection: Close\r\n\r\n";

        $fp = @fsockopen($server["host"],$server["port"],$errno,$errstr,1.0);
        if (!$fp) return false;

        fwrite($fp,$out);
        $resp = fgets($fp);
        fclose($fp);
        //echo $resp;
        if(!eregi("^HTTP\\/1\\.[0-1] 20[0-3] OK",$resp)) return false;
        return true;
}

$annregexp_http = "/(http[s]?+):\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
$annregexp_dht = "/^dht:\/\/[0-9a-f]*.dht\/announce$/i";
$annregexp_udp = "/udp:\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
define("ANNOUNCE_NONE",0);
define("ANNOUNCE_HTTP",1);
define("ANNOUNCE_DHT",2);

echo <<<EOF
<script type="text/javascript" language="JavaScript">
var expanded = 0;
function expand(id) {
        if (expanded == id) return;
        var block;
        var block2;
        document.getElementById("torrent_"+id).className = 'show';
        block = document.getElementById("block_"+id);
        if (block) {
                block.className = 'show';
                document.getElementById("torrent2_"+id).className = 'show';
        }

        if (expanded != 0) {
                document.getElementById("torrent_"+expanded).className = 'hide';
                block2 = document.getElementById("block_"+expanded);
                if (block2) {
                        block2.className = 'hide';
                        document.getElementById("torrent2_"+expanded).className = 'hide';
                }
        }
        expanded = id;
}
</script>
EOF;

OpenTable(_admmassupload);
echo "<p>"._admmassuploadintro."</p>";
echo "<p>&nbsp;</p>";

switch ($op) {
        case "massupload": {
                /*
                INTRO SCREEN: USER IS ASKED TO SCAN THE DIRECTORY AND MAY CHOOSE
                TO AUTOMATICALLY DELETE DUPLICATED TORRENTS.
                USER MAY ALSO SET A LIMIT TO SCANNED TORRENTS TO PREVENT PHP
                ERRORS DUE TO EXCESSIVE TIMEOUT OR MEMORY USAGE
                */

                if (!is_dir("massupload")) bterror(_admmassdirnoexist,_admmassupload);

                echo "<form action=\"modcp.php\" method=\"POST\">\n";
                echo "<input type=\"hidden\" name=\"op\" value=\"scantorrents\" />\n";
                echo "<p><b>"._admmassoptions."</b><br />\n";
                echo _admmassmaxtorrents." <input type=\"text\" name=\"maxtorrents\" value=\"0\" size=\"4\" /> - 0 = &infin;<br />\n";
                echo _admmassautodel. "<input type=\"checkbox\" name=\"autodel\" value=\"true\" checked /></p>\n";
                echo "<p><input id=\"sub\" type=\"submit\" value=\""._admmassscan."\" onclick=\"document.getElementById('sub').disabled='true'\" /></p>\n";
                echo "</form>\n";
                break;
        }
        case "scantorrents": {
                require_once("include/bencoder.php");
                require_once("include/bdecoder.php");
                @ini_set("memory_limit","128M");
                @ini_set("max_execution_time","600");
                /*
                DIRECTORY SCANNING: THE PROGRAM SCANS THE DIRECTORY TO SEARCH
                FOR NEW TORRENTS. THOSE THAT ARE ALREADY IN THE DATABASE ARE
                IGNORED/DELETED, THEN INFO ARE DISPLAYED
                */
                if (!isset($maxtorrents)) $maxtorrents = 0;
                $maxtorrents = intval($maxtorrents);
                $autodel = (isset($autodel) AND $autodel == "true") ? true : false;
                $cantdel = false;

                if (!is_dir("massupload")) bterror(_admmassdirnoexist,_admmassupload);
                $dir = opendir("massupload");

                $infohashes = Array();

                echo "<form action=\"modcp.php\" method=\"POST\">\n";
                echo "<input type=\"hidden\" name=\"op\" value=\"takemassupload\" />\n";
                if ($autodel) echo "<input type=\"hidden\" name=\"autodel\" value=\"true\" />\n";
                echo "<p>&nbsp;</p>\n";
                echo "<hr />\n";

                for ($i = 1; $file = readdir($dir) AND !($maxtorrents > 0 AND $i > $maxtorrents);) {
                        if (!eregi("\.torrent$",$file)) continue;
                        $ignored = false;
                        echo "<p><b>".htmlspecialchars($file)."</b></p>";

                        $torrent = BDecode(file_get_contents("massupload/".$file));

                        if (!$torrent) {
                                echo "<p class=\"denied\">"._admclinicdecodeerror."</p>\n";
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }


                        $info = entry_get($torrent,"info");
                        $info_hash = sha1(Benc($info));
                        unset($info);

                        //Check if duplicate
                        $sql = "SELECT id FROM ".$db_prefix."_torrents WHERE info_hash = '".pack("H*",$info_hash)."';";
                        $res = $db->sql_query($sql);

                        if ($db->sql_numrows($res)) { //Torrent is already present
                                list ($id) = $db->sql_fetchrow($res);
                                echo "<p class=\"denied\"><a href=\"details.php?id=".$id."\">"._admmasspresent."</a></p>\n";
                                $db->sql_freeresult($res);
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }
                        $db->sql_freeresult($res);
                        if (in_array($info_hash,$infohashes)) { //Torrent has been already processed
                                echo "<p class=\"denied\">"._admmassalreadyprocessed."</p>\n";
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }
                        $infohashes[] = $info_hash;

                        //Get advanced info
                        echo "<p>"._btinfohash.": ".$info_hash."</p>\n";
                        echo "<div align=\"right\"><p>".pic("help.gif","javascript:expand('".$i."');",_btinfo)."</p></div>\n";

                        echo "<p class=\"hide\" id=\"torrent_".$i."\">";
                        /*
                        HIDDEN AREA: USED TO DISPLAY TORRENT DETAILED INFO ON
                        REQUEST. USER CLICKS ON INFO BUTTON AND DATA IS SHOWN
                        */

                        //Check announce
                        $announce = entry_read($torrent,"announce(String)");
                        $ann_type = ANNOUNCE_NONE;
                        if (preg_match($annregexp_http,$announce)) $ann_type = ANNOUNCE_HTTP;
                        elseif (preg_match($annregexp_dht,$announce)) $ann_type = ANNOUNCE_DHT;
                        if ($ann_type == ANNOUNCE_NONE) {
                                echo "</p>\n";
                                echo "<p class=\"denied\"><b>"._admclinicinvalidannounce."</b></p>";
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }
                        echo "<b>"._bttracker."</b>: ".$announce."<br />";

                        //Check file and size
                        if (entry_exists($torrent,"info/length(Integer)") AND entry_exists($torrent,"info/name(String)")) {
                                //Single file
                                $length = entry_read($torrent,"info/length(Integer)");
                                $name = entry_read($torrent,"info/name(String)");

                                echo "<b>"._admclinicchkfile."</b> ".htmlspecialchars($name)." (".mksize($length).")";
                                unset($length, $name);
                                echo "<br />\n";
                        } elseif(entry_exists($torrent,"info/files(List)")) {
                                //Multiple files
                                echo "<b>"._admclinicchkmultim."</b></p>";

                                $accum = 0;

                                $files = entry_read($torrent,"info/files(List)");

                                echo "<blockquote class=\"hide\" id=\"block_".$i."\"><p>";
                                foreach ($files as $f) {
                                        $length = $f->get_elements_by_tagname("length");
                                        $size = $length[0]->get_content();

                                        if (!is_numeric($size) OR $length[0]->get_attribute("type") != "Integer") {
                                                echo "</p>\n";
                                                echo "<p class=\"denied\">"._admchkinvalidfsize."</p>\n";
                                                unset($torrent);
                                                echo "<hr />\n";
                                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                                continue 2;
                                        }
                                        $accum += $size;

                                        $path = $f->get_elements_by_tagname("path");

                                        if ($path[0]->get_attribute("type") != "List") {
                                                echo _admchkinvalidfilepath;
                                                echo "</br />\n";
                                                continue 2;
                                        }

                                        $fpath = Array();
                                        foreach ($path[0]->child_nodes() as $child) {
                                                array_push($fpath,$child->get_content());
                                        }


                                        echo htmlspecialchars(implode("/",$fpath))." (".mksize($size).")<br />\n";
                                }
                                echo "</p></blockquote>\n";
                                echo "<p class=\"hide\" id=\"torrent2_".$i."\">";
                                echo "<b>"._admclinickchktotsize."</b> ".mksize($accum)."<br />\n";

                                unset($files, $children, $child, $length, $size, $path, $fpath, $accum, $f);
                        } else {
                                echo "</p>\n";
                                echo "<p class=\"denied\">"._admclinicchkmultif."</p>\n";
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }

                        //DHT Support
                        echo "<b>"._admclinicdht."</b>";
                        if (entry_exists($torrent,"azureus_properties/dht_backup_enable(Integer)")) echo _admclinicsupported;
                        else echo _admclinicnotsupported;
                        echo "<br />\n";

                        //Multiple Trackers
                        echo "<b>"._admclinicannouncelist."</b>";
                        if (entry_exists($torrent,"announce-list(List)")) echo _admclinicsupported;
                        else echo _admclinicnotsupported;
                        echo "<br />\n";

                        /*END OF HIDDEN AREA*/
                        echo "</p>\n";

                        echo "<p><input type=\"checkbox\" name=\"upload_".base64_encode($file)."\" value=\"true\" checked />"._btupload."</p>\n";
                        unset($torrent);
                        echo "<hr />\n";

                        $i++;
                }

                closedir($dir);

                if ($cantdel) {
                        echo "<p>&nbsp;</p>\n";
                        echo "<p class=\"denied\">"._admmasscantdelete."</p>\n";
                }

                echo "<p>&nbsp;</p>\n";
                $s = "<select name=\"torrent_category\"><option value=\"0\">("._btchooseone.")</option>\n";
                $cats = catlist();
                foreach ($cats as $row) $s .= "<option value=\"" . $row["id"] . "\">" . htmlspecialchars($row["name"]) . "</option>\n";
                $s .= "</select>\n";
                echo "<p><b>"._btalertcat."</b> ". $s ."</p>\n";
                echo "<p><input type=\"checkbox\" name=\"scrapelater\" value=\"true\" />"._admmassscrapelater."</p>";
                echo "<p><input type=\"checkbox\" checked name=\"anonupload\" value=\"true\" />"._admmassanonupload."</p>";
                echo "<p>&nbsp;</p>";
                echo "<p><input type=\"submit\" value=\""._btsend."\" /></p>\n";
                echo "</form>\n";

                break;
        }
        case "takemassupload": {
                require_once("include/bdecoder.php");
                require_once("include/bencoder.php");
                @ini_set("memory_limit","128M");
                @ini_set("max_execution_time","600");
                /*
                TORRENTS ARE NOW BEING PROCESSED
                */
                $category = intval($torrent_category);
                if ($category < 1) bterror(_btnoselected,_btuploaderror);
                $scrapelater = (isset($scrapelater) AND $scrapelater == "true") ? true : false;
                $cats = catlist();
                $in_cat = false;
                while ($cat = each($cats) AND !$in_cat) {
                        if ($category == $cat[1]["id"]) $in_cat = true;
                }
                if (!$in_cat) bterror(_btillegalcat,_admmassupload);

                $uploader_host = gethostbyaddr($_SERVER["REMOTE_ADDR"]); //uploader's hostname
                $owner = (isset($anonupload) AND $anonupload == "true") ? 0 : $user->id;
                $ownertype = ($owner != 0) ? 0 : 2;

                $cantdel = false;

                if (!is_dir("massupload")) bterror(_admmassdirnoexist,_btuploaderror);
                $dir = opendir("massupload");

                echo "<p>&nbsp;</p>\n";
                echo "<hr />\n";

                while ($file = readdir($dir)) {
                        //Start transaction
                        $db->sql_query("",END_TRANSACTION);
                        $db->sql_query("",BEGIN_TRANSACTION);

                        if (!preg_match('/^(.+)\.torrent$/si', $file, $matches)) continue;
                        $shortfname = $torrentname = $matches[1];
                        $htmlfile = base64_encode($file);

                        if (!isset($_POST["upload_".$htmlfile]) OR $_POST["upload_".$htmlfile] != "true") continue;

                        echo "<p><b>".htmlspecialchars($file)."</b></p>";

                        $torrent = BDecode(file_get_contents("massupload/".$file));

                        if (!$torrent) {
                                echo "<p class=\"denied\">"._admclinicdecodeerror."</p>\n";
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }

                        if (!entry_exists($torrent,"info(Dictionary)")) {
                                bterror(_btmissingdata,_btuploaderror,false);
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }
                        if (!entry_exists($torrent,"announce(String)")) {
                                bterror(_btmissingdata,_btuploaderror,false);
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }
                        $info = entry_read($torrent,"info(Dictionary)");
                        $announce = entry_read($torrent,"announce(String)");


                        #Checking against DHT
                        $dht = "no";
                        if (entry_exists($torrent,"azureus_properties/dht_backup_enable(Integer)")) {
                                if (entry_read($torrent,"azureus_properties/dht_backup_enable(Integer)") != 0) $dht = "yes";
                        }

                        if (!entry_exists($torrent,"info/piece length(Integer)")) {
                                bterror(_btmissingdata,_btuploaderror,false);
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }
                        if (!entry_exists($torrent,"info/pieces(String)")) {
                                bterror(_btmissingdata,_btuploaderror,false);
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }
                        $dname = (entry_exists($torrent,"info/name(String)")) ? $dname = entry_read($torrent,"info/name(String)") : "";
                        $plen = entry_read($torrent,"info/piece length(Integer)");
                        $pieces = entry_read($torrent,"info/pieces(String)");

                        if (strlen($pieces) % 20 != 0) {
                                bterror(_btinvpieces,_btuploaderror,false);
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }

                        $tcomment = (entry_exists($torrent,"comment(String)")) ? entry_read($torrent,"comment(String)") : "";

                        #Parsing Torrent Description
                        if (get_magic_quotes_gpc()) $descr = stripslashes($descr);
                        $descr = htmlspecialchars(parsedescr($tcomment));
                        $descr = addslashes($descr);

                        #Parsing Announce
                        if ($announce == $announce_url) {
                                if ($stealthmode) {
                                        bterror(str_replace("**name**",$sitename,_bttrackerdisabled),_btuploaderror,false);
                                        unset($torrent);
                                        echo "<hr />\n";
                                        if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                        continue;
                                }
                                $announce = "";
                        } elseif (preg_match($annregexp_http, $announce)) {
                                $sql = "SELECT id FROM ".$db_prefix."_trackers WHERE url = '".addslashes($announce)."' AND status = 'blacklisted' LIMIT 1;";
                                $res = $db->sql_query($sql);
                                if ($db->sql_numrows($res) > 0) {
                                        bterror(str_replace("**trk**",$announce,_bttrackerblacklisted),_btuploaderror,false);
                                        unset($torrent);
                                        $db->sql_freeresult($res);
                                        echo "<hr />\n";
                                        if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                        continue;
                                }
                                $db->sql_freeresult($res);
                        } elseif (preg_match($annregexp_dht,$announce)) {
                                $dht = "yes";
                        } else {
                                bterror(_btinvannounce."<b>".$announce."</b>",_btuploaderror,false);
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }
                        //UDP trackers or trackers inside the TOR/I2P networks are not supported *yet*

                        #Parsing Multiple Announce
                        $trackers = "NULL";
                        $backup_tracker = "false";
                        if (entry_exists($torrent,"announce-list(List)")) {
                                $trackers = Array();
                                $to_check = Array();
                                $announce_list = entry_read($torrent,"announce-list(List)");
                                foreach ($announce_list as $group) {
                                        $trackers_in_group = Array();
                                        foreach ($group->child_nodes() as $tracker_node) {
                                                $tracker = $tracker_node->get_content();
                                                if (!preg_match($annregexp_http,$tracker) AND !preg_match($annregexp_udp,$tracker)) {
                                                        bterror(_btinvannounce."<b>".$tracker."</b>",_btuploaderror,false);
                                                        unset($torrent);
                                                        echo "<hr />\n";
                                                        if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                                        continue 3;
                                                }
                                                //If the main tracker is NOT this one, but this one APPEARS within the Announce list then we're running backup tracker
                                                if ($tracker["value"] == $announce_url AND $announce != "") $backup_tracker = "true";
                                                array_push($trackers_in_group,$tracker);
                                                array_push($to_check,"'".$tracker."'");
                                                unset($tracker, $tracker_node);
                                        }
                                        array_push($trackers,$trackers_in_group);
                                        unset($trackers_in_group, $group);

                                }
                                $sql = "SELECT url FROM ".$db_prefix."_trackers WHERE url IN (".implode(", ",$to_check).") AND status = 'blacklisted';";
                                $res = $db->sql_query($sql) or btsqlerror($sql);
                                if ($db->sql_numrows($res) > 0) {
                                        $blacklisted_trackers = $db->sql_fetchrowset($res);
                                        $blacklisted_trackers = implode(",",$blacklisted_trackers);
                                        bterror(str_replace("**trk**",$blacklisted_trackers,_bttrackerblacklisted),_btuploaderror,false);
                                        unset($torrent);
                                        echo "<hr />\n";
                                        if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                        continue;
                                }
                                $db->sql_freeresult($res);
                                unset($sql, $to_check,$announce_list, $res);
                                for ($i = 0; $i < count($trackers); $i++) $trackers[$i] = implode("\n",$trackers[$i]);
                                $trackers = "'".addslashes(implode("\n\n",$trackers))."'";
                        }

                        #Parsing files
                        $filelist = Array();
                        if (entry_exists($torrent,"info/length(Integer)")) {
                                //Single file
                                $totallen = entry_read($torrent,"info/length(Integer)");

                                if (entry_exists($torrent,"info/sha1(String)")) {
                                        $sha1code = entry_read($torrent, "info/sha1(String)");
                                        $magnet_link = "magnet:?xt=urn:sha1:".addslashes(hex_to_base32($sha1code))."&dn=".urlencode($dname);
                                } else {
                                        $magnet_link = "";
                                }
                                if (entry_exists($torrent,"info/ed2k(String)")) {
                                        $ed2k = entry_read($torrent, "info/ed2k(String)");
                                        $ed2k_link = "ed2k://|file|".urlencode($dname)."|".$totallen."|".strtoupper(str_pad($ed2k,32,"0"))."|/";
                                } else {
                                        $ed2k_link = "";
                                }
                                $filelist[] = Array($dname, $totallen, $magnet_link, $ed2k_link);
                                $type = "single";
                        } else {
                                //Multiple files
                                $flist = entry_read($torrent, "info/files(List)");
                                if (!isset($flist)) {
                                        bterror(_btmissinglength,_btuploaderror,false);
                                        unset($torrent);
                                        echo "<hr />\n";
                                        if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                        continue;
                                }
                                if (!count($flist)) {
                                        bterror(_btnofilesintorrent,_btuplaoderror,false);
                                        unset($torrent);
                                        echo "<hr />\n";
                                        if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                        continue;
                                }
                                $totallen = 0;
                                foreach ($flist as $fn) {
                                        $ffe = "";
                                        $magnet_link = "";
                                        $ed2k_link = "";

                                        $children = $fn->child_nodes();
                                        $f = Array();
                                        foreach ($children as $child) {
                                                $f[$child->tagname] = $child;
                                        }

                                        if (!array_key_exists("length",$f) OR !array_key_exists("path",$f)) {
                                                bterror(_btmissingdata,_btuploaderror,false);
                                                unset($torrent);
                                                echo "<hr />\n";
                                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                                continue 2;
                                        }

                                        $ll = $f["length"]->get_content();

                                        $path = Array();
                                        foreach ($f["path"]->child_nodes() as $p) array_push($path,$p->get_content());
                                        $ffe = implode("/",$path);
                                        if (empty($ffe)) {
                                                bterror(_btfilenamerror,_btuploaderror,false);
                                                unset($torrent);
                                                echo "<hr />\n";
                                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                                continue 2;
                                        }

                                        if (array_key_exists("sha1",$f)) {
                                                $magnet_link = "magnet:?xt=urn:sha1:".addslashes(hex_to_base32($f["sha1"]->get_content()))."&dn=".urlencode($path[count($path)-1]);
                                        }
                                        if (array_key_exists("ed2k",$f)) {
                                                $ed2k_link = "ed2k://|file|".urlencode($path[count($path)-1])."|".$ll."|".strtoupper(str_pad($f["ed2k"]->get_content(),32,0))."|/";
                                        }
                                        unset($p, $path);

                                        $filelist[] = Array($ffe, $ll, $magnet_link, $ed2k_link);
                                        $totallen += $ll;
                                }
                                $type = "multi";
                        }

                        #Info Hash. The most important value
                        $info = entry_get($torrent,"info");
                        $infohash_hex = @sha1(Benc($info));
                        $infohash = pack("H*", $infohash_hex);
                        unset($info);
                        unset($torrent);

                        #Checking against the SAME Torrent
                        $sql = "SELECT id FROM ".$db_prefix."_torrents WHERE info_hash = '".addslashes($infohash)."';";
                        $res = $db->sql_query($sql) or btsqlerror($sql);
                        if ($db->sql_numrows($res) > 0) {
                                list ($id) = $db->sql_fetchrow($res);
                                bterror(str_replace("#id#",$id,_bttorrentpresent),_btuploaderror,false);
                                $db->sql_freeresult($res);
                                unset($torrent);
                                echo "<hr />\n";
                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                continue;
                        }
                        $db->sql_freeresult($res);

                        #Parsing keywords
                        preg_match_all('/([\\w]{6,}+)/', $descr, $search_descr);
                        preg_match_all('/([\\w]{6,}+)/', $dname, $search_name);

                        $searchtext = $shortfname." ".implode(" ",$search_descr[0])." ".implode(" ",$search_name[0]);

                        $force_upload = false; //Used to force upload even if Torrent has 0 peers or the tracker does not respond
                        $seeders = $leechers = $tot_peer = 0;


                        if ($autoscrape AND $announce != "" AND !$scrapelater) {
                                $scrape_url = str_replace("announce", "scrape", $announce);
                                $tmp_tracker = $scrape_url.((strpos($scrape_url,"?")) ? "&" : "?")."info_hash=".urlencode($infohash);
                                //echo $tmp_tracker;
                                if (!ResolveTracker($scrape_url, $resp)) {
                                        $err = $scrape_url."<br />"._admtrkcannotopen;
                                        if ($resp) $err .= " (".htmlspecialchars(addslashes($resp)).")";
                                        bterror($err,_btuploaderror,false);
                                        echo "<hr />\n";
                                        if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                        continue;
                                        break;
                                }

                                if ($fp = fopen($tmp_tracker, "rb")) {
                                        $page = "";
                                        stream_set_timeout($fp, 10);
                                        while (!feof($fp)) {
                                                $page .= @fread($fp,1000000);
                                        }
                                        @fclose($fp);
                                        $scrape = Bdecode($page,"Scrape");
                                        unset($page);
                                        #Debug 2
                                        //echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8")));
                                        #Check data
                                        if (!entry_exists($scrape,"files(dictionary)","Scrape")) {
                                                bterror(_bttrackerdata,_btscrapeerror,false);
                                                echo "<hr />\n";
                                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                                continue;
                                                break;
                                        } elseif (!entry_exists($scrape,"files/".$infohash_hex."(Dictionary)","Scrape")) {
                                                bterror(_bttorrentnotregistered,_btscrapeerror,false);
                                                echo "<hr />\n";
                                                if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                                continue;
                                                break;
                                        } else {
                                                #Check seeder
                                                $seeders = entry_read($scrape,"files/".$infohash_hex."/complete(Integer)","Scrape");
                                                if ($seeders <= 0 AND !$force_upload) {
                                                        bterror(_btnoseedersontracker,_btscrapeerror,false);
                                                        echo "<hr />\n";
                                                        if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                                        continue;
                                                        break;
                                                }
                                                $leechers = entry_read($scrape,"files/".$infohash_hex."/incomplete(Integer)","Scrape");
                                                $completed = entry_read($scrape,"files/".$infohash_hex."/downloaded(Integer)","Scrape");
                                        }
                                        unset($scrape);
                                        $visible = ($tot_peer > 0) ? "yes" : "no";
                                } elseif (!$force_upload) {
                                        bterror(_bttrackernotresponding.$announce,_btscrapeerror,false);
                                        echo "<hr />\n";
                                        if ($autodel) if (!@unlink("massupload/".$file)) $cantdel = true;
                                        continue;
                                        break;
                                }
                        } else {
                                $completed = 0;
                                $visible = ($announce != "") ? "yes" : "no";
                        }

                        #Preparing SQL
                        $torrentfields = Array();
                        $torrentvalues = Array();

                        $torrentfields[] = "info_hash";
                        $torrentvalues[] = "'".addslashes($infohash)."'";

                        $torrentfields[] = "name";
                        $torrentvalues[] = "'".addslashes($file)."'";

                        $torrentfields[] = "filename";
                        $torrentvalues[] = "'".addslashes($dname)."'";

                        $torrentfields[] = "save_as";
                        $torrentvalues[] = "'".addslashes($shortfname)."'";

                        $torrentfields[] = "md5sum";
                        $torrentvalues[] = "'".md5_file("massupload/".$file)."'";

                        $torrentfields[] = "search_text";
                        $torrentvalues[] = "'".addslashes($searchtext)."'";

                        $torrentfields[] = "descr";
                        $torrentvalues[] = "'".$descr."'";

                        $torrentfields[] = "size";
                        $torrentvalues[] = "'".$totallen."'";

                        $torrentfields[] = "plen";
                        $torrentvalues[] = "'".$plen."'";

                        $torrentfields[] = "category";
                        $torrentvalues[] = "'".intval($category)."'";

                        $torrentfields[] = "type";
                        $torrentvalues[] = "'".$type."'";

                        $torrentfields[] = "numfiles";
                        $torrentvalues[] = "'".count($filelist)."'";

                        $torrentfields[] = "added";
                        $torrentvalues[] = "NOW()";

                        $torrentfields[] = "exeem";
                        $torrentvalues[] = "NULL";

                        $torrentfields[] = "dht";
                        $torrentvalues[] = "'".$dht."'";

                        $torrentfields[] = "backup_tracker";
                        $torrentvalues[] = "'".$backup_tracker."'";

                        $torrentfields[] = "views";
                        $torrentvalues[] = "'0'";

                        $torrentfields[] = "downloaded";
                        $torrentvalues[] = "'0'";

                        $torrentfields[] = "completed";
                        $torrentvalues[] = "'".$completed."'";

                        $torrentfields[] = "banned";
                        $torrentvalues[] = "'no'";

                        $torrentfields[] = "password";
                        $torrentvalues[] = "NULL";

                        $torrentfields[] = "visible";
                        $torrentvalues[] = "'".$visible."'";

                        $torrentfields[] = "evidence";
                        $torrentvalues[] = "'".intval($evidence)."'";

                        $torrentfields[] = "owner";
                        $torrentvalues[] = "'".$owner."'";

                        $torrentfields[] = "ownertype";
                        $torrentvalues[] = "'".$ownertype."'";

                        $torrentfields[] = "uploader_host";
                        $torrentvalues[] = "'".$uploader_host."'";

                        $torrentfields[] = "numratings";
                        $torrentvalues[] = "'0'";

                        $torrentfields[] = "ratingsum";
                        $torrentvalues[] = "'0'";

                        $torrentfields[] = "seeders";
                        $torrentvalues[] = "'".intval($seeders)."'";

                        $torrentfields[] = "leechers";
                        $torrentvalues[] = "'".intval($leechers)."'";

                        $torrentfields[] = "tot_peer";
                        $torrentvalues[] = "'".intval($seeders+$leechers)."'";

                        $torrentfields[] = "speed";
                        $torrentvalues[] = "'0'";

                        $torrentfields[] = "comments";
                        $torrentvalues[] = "'0'";

                        $torrentfields[] = "complaints";
                        $torrentvalues[] = "'0,0'";

                        $torrentfields[] = "tracker";
                        if ($announce == "") $torrentvalues[] = "NULL";
                        else $torrentvalues[] = "'".$announce."'";

                        $torrentfields[] = "tracker_list";
                        $torrentvalues[] = $trackers;

                        $torrentfields[] = "tracker_update";
                        $torrentvalues[] = "NOW()";

                        $torrentfields[] = "last_action";
                        $torrentvalues[] = "NOW()";


                        $torrentsql = "INSERT INTO ".$db_prefix."_torrents (".implode(", ",$torrentfields).") VALUES (".implode(", ",$torrentvalues).");";

                        $db->sql_query($torrentsql) or btsqlerror($torrentsql);
                        $id = $db->sql_nextid();
                        if ($id == 0) bterror("Torrent ID Error",_btuploaderror);

                        if ($announce != "") $db->sql_query("INSERT INTO ".$db_prefix."_trackers (url, updated) VALUES ('".addslashes($announce)."', NOW());");

                        $db->sql_query("DELETE FROM ".$db_prefix."_files WHERE torrent = '".$id."'") or btsqlerror("DELETE FROM ".$db_prefix."_files WHERE torrent = '$id'");
                        foreach ($filelist as $f) {
                                list ($fname, $fsize, $magnet, $ed2k) = $f;
                                $fields = "(torrent, filename, size";
                                $values = "('".$id."', '".str_replace("'","\'",$fname)."', '".$fsize."'";
                                if ($magnet != "") {
                                        $fields.= ", magnet";
                                        $values.= ", '".addslashes($magnet)."'";
                                }
                                if ($ed2k != "") {
                                        $fields.= ", ed2k";
                                        $values.= ", '".addslashes($ed2k)."'";
                                }
                                $fields.= ")";
                                $values.= ")";
                                $filesql = "INSERT INTO ".$db_prefix."_files ".$fields." VALUES ".$values.";";
                                if (!$db->sql_query($filesql)) { //Rollback
                                        $db->sql_query("DELETE FROM ".$db_prefix."_torrents WHERE id = '".$id."' LIMIT 1;");
                                        $db->sql_query("DELETE FROM ".$db_prefix."_files WHERE torrent = '".$id."';");
                                        btsqlerror($filesql);
                                }
                        }

                        $torrentpath = $torrent_dir."/".$id.".torrent";
                        if (file_exists($torrentpath)) unlink($torrentpath);
                        copy("massupload/".$file,$torrentpath);
                        if (!@unlink("massupload/".$file)) $cantdel = true;

                        $db->sql_query("",END_TRANSACTION);
                        echo "<p class=\"granted\">"._admmassuploaded."</p>\n";
                        echo "<hr />\n";
                }

                closedir($dir);

                if ($cantdel) {
                        echo "<p>&nbsp;</p>\n";
                        echo "<p class=\"denied\">"._admmasscantdeleteuploaded."</p>\n";
                }

                break;
        }
}

CloseTable();
?>