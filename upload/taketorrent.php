<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta3-----------------------*
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

if (!eregi("upload.php", $_SERVER['PHP_SELF'])) die ("You can't access this file directly...");

@ini_set("upload_max_filesize",$max_torrent_size);
@set_time_limit(60);
@ini_set("memory_limit","64M");


require_once("include/bdecoder.php");
require_once("include/bencoder.php");

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
  $b32_alpha = "";
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
  $b32_rfc3548 = "";
  for ($i = 0; $i < strlen($b32_alpha); $i++) {
    $b32_rfc3548 .= $b32_alpha_to_rfc3548_chars[$b32_alpha[$i]];
  }
  return $b32_rfc3548;
}

$torrent_edited = false;

$errmsg = Array();

if (!isset($_FILES["filex"]))
        $errmsg[] = _btmissingdata;


$category = intval($torrent_category);
if ($category < 1) bterror(_btnoselected,_btuploaderror);

$cats = catlist();
$in_cat = false;
while ($cat = each($cats) AND !$in_cat) {
        if ($category == $cat[1]["id"]) $in_cat = true;
}

if (!$in_cat) $errmsg[] = _btillegalcat;
if(strlen($imdb_info) > 1)$imdb = $imdb_info;
else
$imdb = '';

$f = $_FILES["filex"];
$fname = unesc($f["name"]);

if (empty($fname))
        $errmsg[] = _btemptyfname;
if (!is_filename($fname))
        $errmsg[] = _btinvalidfname;
if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches))
        $errmsg[] = _btfnamenotorrent;

$nf = $_FILES["nfox"];
$nfname = unesc($nf["name"]);
if ($nfname != "") {
        if (!is_filename($nfname))
                $errmsg[] = _btinvalidnfofname;
        if (!preg_match('/^(.+)\.nfo$/si', $nfname))
                $errmsg[] = _btfnamenonfo;
        if (!is_uploaded_file($nf["tmp_name"]))
                $errmsg[] = _bterrnonfoupload;
        if ($nf["size"] <= 0)
                $errmsg[] = _btemptyfile."1";
}

#Return Error
if (count($errmsg) > 0)
        bterror($errmsg,_btupload);

$shortfname = $torrentname = $matches[1];
if (!empty($namex))
        $torrentname = unesc($namex);

$tmpname = $f["tmp_name"];

if (!is_uploaded_file($tmpname))
        $errmsg[] = _bterrnofileupload;
if (!filesize($tmpname))
        $errmsg[] = _btemptyfile."2";

#Return Error
if (count($errmsg) > 0)
        bterror($errmsg,_btuploaderror);


$uploader_host = gethostbyaddr($_SERVER["REMOTE_ADDR"]); //uploader's hostname

#File read
$pagetorrent = "";
$fp = @fopen($tmpname,"rb");
while (!@feof($fp)) {
        $pagetorrent .= @fread($fp,1000);
}
@fclose($fp);
//Decode
$torrent = Bdecode($pagetorrent);
unset($pagetorrent);
if (!entry_exists($torrent,"info(Dictionary)")) bterror("test1".$torrent."",_btuploaderror,false);
if (!entry_exists($torrent,"announce(String)")) bterror("test2".$torrent."",_btuploaderror);
$info = entry_get($torrent,"info");
$announce = entry_read($torrent,"announce(String)");


#Checking against DHT
$dht = "no";
if (entry_exists($torrent,"azureus_properties/dht_backup_enable(Integer)")) {
        if (entry_read($torrent,"azureus_properties/dht_backup_enable(Integer)") != 0) $dht = "yes";
}

$info_intact = true;

if (isset($adv_opts) AND $adv_opts == 1 OR $addprivate) {
        if (!isset($dht_support)) $dht_support = 0;
        if (!isset($private_torrent)) $private_torrent = 0;

        //If DHT Support is forced we must disable Private Flag
        $root = $torrent->first_child();
        if ($dht_support == 1) {

                $private_torrent = 2;
                if ($dht == "no") {
                        if (entry_exists($torrent,"azureus_properties")) {
                                $az_props = entry_get($torrent,"azureus_properties");
                        } else {
                                $az_props = $torrent->create_element("azureus_properties");
                                $az_props->set_attribute("type","Dictionary");
                        }
                        if (entry_exists($torrent,"dht_backup_enable")) {
                                $dht_back = $torrent->create_element("dht_backup_enable");
                                $az_props->remove_child($dht_back);
                        }
                        $dht_back = $torrent->create_element("dht_backup_enable");
                        $dht_back->set_attributes("type","Integer");
                        $enable = $torrent->create_text_node("1");
                        $dht_back->append_child($enable);
                        $az_props->append_child($dht_back);
                        foreach ($root->child_nodes() as $child) {
                                if ($child->node_name() > "azureus_properties") break;
                        }
                        $root->insert_before($az_props,$child);
                }
        } elseif ($dht_support == 2) {
                if ($dht == "yes") {
                        $aznode = entry_get($torrent,"azureus_properties");
                        $dhtnode = entry_get($torrent,"azureus_properties/dht_backup_enable");
                        $aznode->remove_child($dhtnode);
                        if (!$aznode->has_child_nodes()) $root->remove_child($aznode);

                }
        }
        unset($root);

        $priv_exists = entry_exists($torrent,"info/private(Integer)");
        $priv_enabled = ($priv_exists AND entry_read($torrent,"info/private(Integer)") == 1);

        if ($private_torrent == 1 OR $addprivate) {
		if($announce == $announce_url){
                //Force enabling Private Torrent
                if (!$priv_enabled ) {
                        $info_intact = false;
                        if ($priv_exists) {
                                $private = entry_get($torrent,"info/private");
                                $info->remove_child($private);
                        }
                        $private = $torrent->create_element("private");
                        $private->set_attribute("type","Integer");
                        $enable = $torrent->create_text_node("1");
                        $private->append_child($enable);
                        foreach ($info->child_nodes() as $child) {
                                if ($child->node_name() > "private") break;
                        }
                        $info->append_child($private);
                }
			}
        } elseif ($private_torrent == 2) {
                if ($priv_exists) {
                        $info_intact = false;
                        $private = entry_get($torrent,"info/private");
                        $info->remove_child($private);
                }
        }
}


#Name, piece length and pieces

if (!entry_exists($torrent,"info/piece length(Integer)")) bterror("test3",_btuploaderror);
if (!entry_exists($torrent,"info/pieces(String)")) bterror("test4",_btuploaderror);
$dname = (entry_exists($torrent,"info/name(String)")) ? $dname = entry_read($torrent,"info/name(String)") : "";
$plen = entry_read($torrent,"info/piece length(Integer)");
$pieces = entry_read($torrent,"info/pieces(String)");

if (strlen($pieces) % 20 != 0)
        bterror(_btinvpieces,_btuploaderror);
unset($pieces);

$tcomment = (entry_exists($torrent,"comment(String)")) ? entry_read($torrent,"comment(String)") : "";

#Parsing Torrent Description
if ($tcomment == "" AND (!isset($descr) OR empty($descr))) bterror(_btdescrrequired,_btuploaderror);
if (get_magic_quotes_gpc()) $descr = stripslashes($descr);
if ($descr == "") $descr = parsedescr($tcomment);
if ($allow_html) {
        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $descr)) //HTML contains Javascript EVENTS. Must refuse
                bterror(_btinvalidhtml,_btuploaderror);
        if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $descr)) //HTML contains Javascript or VBScript calls. Must refuse
                bterror(_btinvalidhtml,_btuploaderror);
}
parse_html($descr);
$descr = addslashes($descr);


#Parsing Announce
$annregexp_http = "/(http[s]?+):\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
$annregexp_dht = "/^dht:\/\/[0-9a-f]*.dht\/announce$/i";
$annregexp_udp = "/udp:\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
if (!$announce == $announce_url){
//die('external torrents not allowed');
}
if ($announce == $announce_url) {
        if ($stealthmode) bterror(str_replace("**name**",$sitename,_bttrackerdisabled),_btuploaderror);
        $announce = "";
} elseif (preg_match($annregexp_http, $announce)) {
        $sql = "SELECT id FROM ".$db_prefix."_trackers WHERE url = '".addslashes($announce)."' AND status = 'blacklisted' LIMIT 1;";
        $res = $db->sql_query($sql);
        if ($db->sql_numrows($res) > 0) bterror(str_replace("**trk**",$announce,_bttrackerblacklisted),_btuploaderror);
        $db->sql_freeresult($res);
} elseif (preg_match($annregexp_dht,$announce)) {
        $dht = "yes";
} else {
        bterror(_btinvannounce."<b>".$announce."</b>",_btuploaderror);
}
//UDP trackers or trackers inside the TOR/I2P networks are not supported *yet*



#Parsing Multiple Announce
$trackers = "NULL";
$backup_tracker = "false";
if (entry_exists($torrent,"announce-list(List)")) {
die('backup trackers not allowed');
        $trackers = Array();
        $to_check = Array();
        $announce_list = entry_read($torrent,"announce-list(List)");
        foreach ($announce_list as $group) {
                $trackers_in_group = Array();
                foreach ($group->child_nodes() as $tracker_node) {
                        $tracker = $tracker_node->get_content();
                        if (!preg_match($annregexp_http,$tracker) AND !preg_match($annregexp_udp,$tracker)) bterror(_btinvannounce."<b>".$tracker."</b>",_btuploaderror);
                        //If the main tracker is NOT this one, but this one APPEARS within the Announce list then we're running backup tracker
                        if ($tracker == $announce_url AND $announce != "")
						{
						 $backup_tracker = "true";
						 $announce = "";
                        }
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
                bterror(str_replace("**trk**",$blacklisted_trackers,_bttrackerblacklisted),_btuploaderror);
        }
        $db->sql_freeresult($res);
        unset($sql, $to_check,$announce_list, $res);
        for ($i = 0; $i < count($trackers); $i++) $trackers[$i] = implode("\n",$trackers[$i]);
        $trackers = "'".addslashes(implode("\n\n",$trackers))."'";
}


#Parsing password
$torrentpass = $password; //Keep for URL Redirect
if ($password != "" AND $announce == "") {
        if (!get_magic_quotes_gpc()) $password = addslashes($password);
        $password = "'".$password."'";
} else $password = "NULL";


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
        if (!isset($flist))
                bterror(_btmissinglength,_btuploaderror);
        if (!count($flist))
                bterror(_btnofilesintorrent,_btuplaoderror);
        #$totallen = 0;
        foreach ($flist as $fn) {
                $ffe = "";
                $magnet_link = "";
                $ed2k_link = "";
                $children = $fn->child_nodes();
                $file = Array();
                foreach ($children as $child) {
                        $file[$child->tagname] = $child;
                }

                if (!array_key_exists("length",$file) OR !array_key_exists("path",$file)) bterror("test5",_btuploaderror);

                $ll = $file["length"]->get_content();

                $path = Array();
                foreach ($file["path"]->child_nodes() as $p) array_push($path,$p->get_content());
                $ffe = implode("/",$path);
                if (empty($ffe)) bterror(_btfilenamerror,_btuploaderror);

                if (array_key_exists("sha1",$file)) {
                        $magnet_link = "magnet:?xt=urn:sha1:".addslashes(hex_to_base32($file["sha1"]->get_content()))."&dn=".urlencode($path[count($path)-1]);
                }
                if (array_key_exists("ed2k",$file)) {
                        $ed2k_link = "ed2k://|file|".urlencode($path[count($path)-1])."|".$ll."|".strtoupper(str_pad($file["ed2k"]->get_content(),32,0))."|/";
                }
                unset($p, $path);

                $filelist[] = Array($ffe, $ll, $magnet_link, $ed2k_link);
                $totallen += $ll;
        }
        $type = "multi";
}

#Info Hash. The most important value
$infohash_hex = sha1(Benc($info));
$infohash = pack("H*", $infohash_hex);
unset($info);

#eXeem Alternate Link
if (isset($exeem) AND $exeem != "" AND $info_intact) {
        if (!eregi("^exeem://[\\d]{1,2}/".$infohash_hex."/", $exeem)) bterror(_btinvalidexeem,_btuploaderror);
} else {
        $exeem = "";
}

#Torrent Owner
$owner = $user->id;
$ownertype = ($owner == 0) ? 0 : intval($ownertype);
if ($ownertype == 2) $owner = 0;
if (isset($evidence) AND $user->moderator) $evidence = 1;
else $evidence = 0;

#Checking against the SAME Torrent
if (isset($jump_check) AND $jump_check == 1) {
$sql = "SELECT id FROM ".$db_prefix."_torrents WHERE info_hash = '".addslashes($infohash)."';";
$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) > 0) {
        list ($id) = $db->sql_fetchrow($res);
        bterror(str_replace("#id#",$id,_bttorrentpresent),_btuploaderror);
}
$db->sql_freeresult($res);
}

if (!is_premium($btuser)) {
        $sql = "SELECT count(id) as num, sum(size) as tot_size FROM ".$db_prefix."_torrents where added > sysdate() - 1000000 AND owner = '".$user->id."'";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        list ($torrents, $uploaded_size) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);

        #Checking against minimumupload size
        if ($totallen < $minupload_size_file)
                bterror(_bttorrenttoosmall1.mksize($minupload_size_file)._bttorrenttoosmall2.mksize($totallen)."</b>.",_btuploaderror);

        #Checking against Max num upload on 24h time
        if ($maxupload_day_num > 0 AND $maxupload_day_num <= $torrents)
                bterror(str_replace("**maxupload**",$maxupload_day_num,_btmaxuploadexceeded),_btuploaderror);

        #Max size share upload on 24h
        if ($maxupload_day_share > 0 AND $maxupload_day_share < $uploaded_size+$totallen) {
                $search = Array("**maxupload**","**rownum**","**totsize**");
                $replace = Array($maxupload_day_share,$torrents,mksize($uploaded_size));
                bterror(str_replace($search,$replace,_btnumfileexceeded),_btuploaderror);
        }
}

#Filename must be at least 4 chars
$materia = trim($fname);
$pos = strrpos($materia, '.');
if (!$pos===false)
        $materia = substr($materia, 0, $pos);
$search = array ("'[^\w]'",                 // Remove not letter
        "'([\r\n])[\s]+'"                 // Remove Blank space
);
$replace = array (
        " ",
        "\\1"
);
$materia = preg_replace ($search, $replace, $materia);
$materia = explode(" ", $materia);

$sql_filter = "";
foreach($materia as $x) {
        $x = trim($x);
        if(strlen($x) > 2){
                $sql_filter .= " OR keyword LIKE '".$x."'";
        }
}
$errmsg = "";
$sql_filter = "SELECT * FROM ".$db_prefix."_filter WHERE 1=0 ".$sql_filter.";";
$res = $db->sql_query($sql_filter) or btsqlerror($sql_filter);
if ($db->sql_numrows($res) > 0) {
                $errmsg = "<p align=\"center\">"._btillegalword."</p></br>";
              
                while ($row = $db->sql_fetchrow($res)){
                        $errmsg.= "<p align=\"center\">".htmlspecialchars($row["reason"])."</p></br>";
                }
              
                $errmsg.= "<p align=\"center\">"._btillegalwordinfo."</p>";
                bterror($errmsg,_btuploaderror);
}
$db->sql_freeresult($res);

#Checking against SIMILAR files
if (isset($jump_check) AND $jump_check == 1) {
        $materia=trim($fname);
        $pos = strrpos($materia, '.');
        if (!$pos===false)
                $materia = substr($materia, 0, $pos);
        $search = array (
                 "'[^a-zA-Z]'",                 // Remove not lecter
                 "'([\r\n])[\s]+'"                 // Remove Blank space
        );
        $replace = array (
                 " ",
                 "\\1"
        );

        $materia = preg_replace ($search, $replace, $materia);
        $materia = explode(" ", $materia);

        $sql = "";
        $sql_filter = "";
        foreach($materia as $x){
                $x = trim($x);
                if(strlen($x)>=5){
                        $sql .= " OR filename LIKE '".str_replace("\'","\\\'",$x)."'";
                }
        }
        foreach ($filelist as $file) {
                $sql .= " OR size = '".$file[1]."'";
        }


        $sql = "SELECT torrent, filename, size FROM ".$db_prefix."_files WHERE 1=0 ".$sql;
        $res = $db->sql_query($sql) or bterror($sql);

        $errmsg = "";
        if ($db->sql_numrows($res) > 0){
                $errmsg = _btsearchdupl;
                $errmsg .= "<ul>\n";
                while ($row = $db->sql_fetchrow($res)){
                        $errmsg.= "<li><p><a href='details.php?id=".$row["torrent"]."&hit=1'>".$row["filename"]."</a> (".mksize($row["size"]).")</p></li>\n";
                }
                $errmsg .= "</ul>\n";
                $errmsg .= _btduplinfo;
                bterror($errmsg,_btuploaderror);
        }
}


#$searchtext = "".$shortfname." ". $dname." ". $descr." ".implode(" ",$filelist);

$searchtext = "".$shortfname." ". $dname." ". $descr." ";
foreach($filelist as $subarray) {
$searchtext.=implode(" ",$subarray);
}
//if($announce != "")die("external torrents not allowed");
#Parsing external tracker sources
global $force_upload; //Used to force upload even if Torrent has 0 peers or the tracker does not respond
$seeders = $leechers = $tot_peer = 0;
if($autoscrape AND $announce != "") {
//die("external torrents not allowed");
        $tmp_tracker = str_replace("announce", "scrape", $announce).((strpos($scrape_url,"?")) ? "&" : "?")."info_hash=".urlencode($infohash);
        #echo $tmp_tracker;
        if ($fp = @fopen($tmp_tracker, "rb")) {
                stream_set_timeout($fp, 10);
                $page = "";
                while (!feof($fp)) {
                        $page .= @fread($fp,1000000);
                }
                @fclose($fp);
				echo '<br>';
				#echo $page;
				
                $scrape = Bdecode($page,"Scrape");
                unset($page);
                //echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8")));
                #Debug 2
                //echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8")));
                #Check data
                if (!entry_exists($scrape,"files(dictionary)","Scrape")) {
                        bterror(_bttrackerdata,_btscrapeerror);
                } elseif (!entry_exists($scrape,"files/a".$infohash_hex."(Dictionary)","Scrape")) {
                        bterror(_bttorrentnotregistered,_btscrapeerror,false);
                } else {
                        #Check seeder
                        $seeders = entry_read($scrape,"files/a".$infohash_hex."/complete(Integer)","Scrape");
						if ($seeders <= 0 AND $force_upload) bterror(_btnoseedersontracker,_btnoseedersontracker,false);
                        if ($seeders <= 0 AND !$force_upload) bterror(_btnoseedersontracker,_btscrapeerror);
                        $leechers = entry_read($scrape,"files/a".$infohash_hex."/incomplete(Integer)","Scrape");
                        $completed = entry_read($scrape,"files/a".$infohash_hex."/downloaded(Integer)","Scrape");
                }
                unset($scrape);
                $visible = ($tot_peer > 0) ? "yes" : "no";				
        } elseif (!$force_upload) {
                bterror(_bttrackernotresponding.$announce,_btscrapeerror);
        }
} else {
                $completed = 0;
                $visible = ($announce != "") ? "yes" : "no";
}
if(!isset($build)) $build = "no";
if(isset($post_img) && $post_img != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $post_img, $match))
		{
			 bterror($errors,'The URL you specified For Poster is invalid.');
		}
		if (empty($match[2]))
		{
			 bterror($errors,'The URL you specified is not a (gif|jpg|jpeg|png).');
		}
}
else
$post_img = "NULL";
if(isset($screan1) && $screan1 != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $post_img, $match))
		{
			 bterror($errors,'The URL you specified For Screenshot1 is invalid.');
		}
		if (empty($match[2]))
		{
			 bterror($errors,'The URL you specified is not a (gif|jpg|jpeg|png).');
		}
}
else
$screan1 = "NULL";
if(isset($screan2) && $screan2 != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $post_img, $match))
		{
			 bterror($errors,'The URL you specified For Screenshot2 is invalid.');
		}
		if (empty($match[2]))
		{
			 bterror($errors,'The URL you specified is not a (gif|jpg|jpeg|png).');
		}
}
else
$screan2 = "NULL";
if(isset($screan3) && $screan3 != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $post_img, $match))
		{
			 bterror($errors,'The URL you specified For Screenshot3 is invalid.');
		}
		if (empty($match[2]))
		{
			 bterror($errors,'The URL you specified is not a (gif|jpg|jpeg|png).');
		}
}
else
$screan3 = "NULL";
if(isset($screan4) && $screan4 != ''){
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $post_img, $match))
		{
			 bterror($errors,'The URL you specified For Screenshot4 is invalid.');
		}
		if (empty($match[2]))
		{
			 bterror($errors,'The URL you specified is not a (gif|jpg|jpeg|png).');
		}
}
else
$screan4 = "NULL";
#Preparing SQL
$torrentfields = Array();
$torrentvalues = Array();

$torrentfields[] = "info_hash";
$torrentvalues[] = "'".addslashes($infohash)."'";

$torrentfields[] = "name";
$torrentvalues[] = "'".addslashes($torrentname)."'";

$torrentfields[] = "filename";
$torrentvalues[] = "'".addslashes($dname)."'";

$torrentfields[] = "save_as";
$torrentvalues[] = "'".addslashes($shortfname)."'";

$torrentfields[] = "md5sum";
$torrentvalues[] = "'".md5_file($tmpname)."'";

$torrentfields[] = "search_text";
$torrentvalues[] = "'".addslashes($searchtext)."'";

$torrentfields[] = "descr";
$torrentvalues[] = "'".$descr."'";

// Poster Modd
$torrentfields[] = "post_img";
$torrentvalues[] = "'".addslashes($post_img)."'";

//ScreenShot Modd
$torrentfields[] = "screan1";
$torrentvalues[] = "'".addslashes($screan1)."'";

$torrentfields[] = "screan2";
$torrentvalues[] = "'".addslashes($screan2)."'";

$torrentfields[] = "screan3";
$torrentvalues[] = "'".addslashes($screan3)."'";

$torrentfields[] = "screan4";
$torrentvalues[] = "'".addslashes($screan4)."'";

//End mods
$torrentfields[] = "size";
$torrentvalues[] = "'".$totallen."'";

$torrentfields[] = "ratiobuild";
$torrentvalues[] = "'".$build."'";

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
if (isset($exeem) AND $exeem != "") $torrentvalues[] = "'".$exeem."'";
else $torrentvalues[] = "NULL";

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
$torrentvalues[] = $password;

$torrentfields[] = "visible";
$torrentvalues[] = "'".$visible."'";

$torrentfields[] = "evidence";
$torrentvalues[] = "'".intval($evidence)."'";

$torrentfields[] = "owner";
$torrentvalues[] = "'".intval($owner)."'";

$torrentfields[] = "ownertype";
$torrentvalues[] = "'".intval($ownertype)."'";

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

if(strlen($imdb) > 1){
$torrentfields[] = "imdb";
$torrentvalues[] = "'".$imdb."'";
}


$torrentsql = "INSERT INTO ".$db_prefix."_torrents (".implode(", ",$torrentfields).") VALUES (".implode(", ",$torrentvalues).");";

$db->sql_query($torrentsql) or btsqlerror($torrentsql);
$id = $db->sql_nextid();
if ($id == 0) bterror("Torrent ID Error",_btuploaderror);

if ($announce != ""){ 
$db->sql_query("INSERT INTO ".$db_prefix."_trackers (url, updated) VALUES ('".addslashes($announce)."', NOW());");
}
$db->sql_query("DELETE FROM ".$db_prefix."_files WHERE torrent = '".$id."'") or btsqlerror("DELETE FROM ".$db_prefix."_files WHERE torrent = '$id'");
foreach ($filelist as $file) {
        list ($fname, $fsize, $magnet, $ed2k) = $file;
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

$fp = fopen($torrentpath,"wb");
fwrite($fp,Bencode($torrent));
fclose($fp);
@unlink($tmpname);

$nfopath = "$torrent_dir/".$id.".nfo";
if (file_exists($nfopath)) unlink($nfopath);
if (!empty($nfname)) move_uploaded_file($nf["tmp_name"],$nfopath);
$url = "details.php?id=".$id."&upcomplete=1";
if ($password != "NULL") { //Password is included in SQL Statement
        $url .= "&password=".$torrentpass;
}
if (!$info_intact) { //If Info Hash changed the user MUST re-download the Torrent to use it
        $url .= "&upload_notice=1";
}
echo "<meta http-equiv=\"refresh\" content=\"6;url=".$url."\">";

OpenTable(_btupload);
                        $bon = "SELECT active, upload FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $upload_point) = $db->sql_fetchrow($bonset);
                        $db->sql_freeresult($bonset);
if($active=='true')
{
$do="UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$upload_point."' WHERE id= ".$user->id."" ;
$db->sql_query($do) or btsqlerror($do);
}
global $allow_posting;//Are we allowed to post new topics
if($allow_posting)newtopic($torrentname, htmlspecialchars($descr), $owner); 
$search = Array("**id**","**name**");
$replace = Array($id,$torrentname);
echo "<p>".str_replace("**url**",$url,_btuploadcomplete)."</p>\n";
$mesg = str_replace($search,$replace,_btuplshout);
if(isset($shout)){
$sql = "INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES ('".$user->id."', '".$mesg."', NOW());";
                        $db->sql_query($sql);
}
if ($seeders <= 0 AND $force_upload){
	echo  "<p>"._btdeadtorrent."</p>\n";
}


if (isset($commnotify)){
        $sql = "INSERT INTO ".$db_prefix."_comments_notify (torrent, user) VALUES ('".$id."', ".$user->id.")";
        $db->sql_query($sql) or btsqlerror($sql);
        echo "<p>&nbsp;</p>";
        echo  "<p>"._btaddnotifycomment."</p>\n";
}
if (isset($seednotify) AND $announce == "") {
        $sql = "INSERT INTO ".$db_prefix."_seeder_notify (torrent, user) VALUES ('".$id."', ".$user->id.")";
        $db->sql_query($sql) or btsqlerror($sql);
        echo "<p>&nbsp;</p>";
        echo "<p>"._btaddnotifyseeder."</p>\n";
}
CloseTable();
?>
