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
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*/
@set_time_limit(20);
@ini_set("memory_limit","64M");
include('header.php');
require_once("include/bdecoder.php");
require_once("include/bencoder.php");
$sql = "SELECT * FROM torrents ORDER BY `id`;";
$res = $db->sql_query($sql);
while($row = $db->sql_fetchrow($res)){
$pagetorrent = "";
$fp = @fopen("http://place2bscene.co.uk/uploads/".$row['id'].".torrent","rb");
if(!$fp)continue;
while (!@feof($fp)) {
        $pagetorrent .= @fread($fp,1000);
}
@fclose($fp);
unset($fp);
echo $row['id']."<br />";
$md5file="http://place2bscene.co.uk/uploads/".$row['id'].".torrent";
//echo $row['id'];
//die;
//Decode
$info ='';
$infohash = '';
$torrent = Bdecode($pagetorrent);
$info = entry_get($torrent,"info");
$infohash_hex = sha1(Benc($info));
$infohash = pack("H*", $infohash_hex);
unset($info);
$dht = "no";
if (entry_exists($torrent,"azureus_properties/dht_backup_enable(Integer)")) {
        if (entry_read($torrent,"azureus_properties/dht_backup_enable(Integer)") != 0) $dht = "yes";
}
$announce = entry_read($torrent,"announce(String)");
$announce_url = "http://place2bscene.co.uk/announce.php";
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
                        if (!preg_match($annregexp_http,$tracker) AND !preg_match($annregexp_udp,$tracker)) bterror(_btinvannounce."<b>".$tracker."</b>",_btuploaderror);
                        //If the main tracker is NOT this one, but this one APPEARS within the Announce list then we're running backup tracker
                        if ($tracker["value"] == $announce_url AND $announce != "") $backup_tracker = "true";
                        array_push($trackers_in_group,$tracker);
                        array_push($to_check,"'".$tracker."'");
                        unset($tracker, $tracker_node);
                }
                array_push($trackers,$trackers_in_group);
                unset($trackers_in_group, $group);

        }
        unset($sql, $to_check,$announce_list, $res2);
        for ($i = 0; $i < count($trackers); $i++) $trackers[$i] = implode("\n",$trackers[$i]);
        $trackers = "'".addslashes(implode("\n\n",$trackers))."'";
}
#Checking against the SAME Torrent
$jump_check = false;
if ($jump_check ) {
$sql = "SELECT id FROM ".$db_prefix."_torrents WHERE info_hash = '".addslashes($infohash)."';";
$res2 = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res2) > 0) {
continue;
}
$db->sql_freeresult($res2);
}
$password = "NULL";
$searchtext = "".$row['filename']." ". $row['filename']." ". $row['descr']." ";
#Preparing SQL
$torrentfields = Array();
$torrentvalues = Array();

$torrentfields[] = "id";
$torrentvalues[] = "'".$row['id']."'";

$torrentfields[] = "info_hash";
$torrentvalues[] = "'".addslashes($infohash)."'";

$torrentfields[] = "name";
$torrentvalues[] = "'".$row['name']."'";

$torrentfields[] = "filename";
$torrentvalues[] = "'".$row['filename']."'";

$torrentfields[] = "save_as";
$torrentvalues[] = "'".$row['save_as']."'";

$torrentfields[] = "md5sum";
$torrentvalues[] = "'".md5_file($md5file)."'";

$torrentfields[] = "search_text";
$torrentvalues[] = "'".addslashes($row['filename'])."'";

$torrentfields[] = "descr";
$torrentvalues[] = "'".addslashes($row['descr'])."'";

$torrentfields[] = "added";
$torrentvalues[] = "'".$row['added']."'";

$torrentfields[] = "size";
$torrentvalues[] = "'".$row['size']."'";

$torrentfields[] = "ratiobuild";
$torrentvalues[] = "'".$row['free']."'";

$torrentfields[] = "plen";
$torrentvalues[] = "'".entry_read($torrent,"info/piece length(Integer)")."'";

$torrentfields[] = "category";
$torrentvalues[] = "'".$row['free']."'";

$torrentfields[] = "type";
$torrentvalues[] = "'".$row['type']."'";

$torrentfields[] = "numfiles";
$torrentvalues[] = "'".$row['numfiles']."'";

$torrentfields[] = "exeem";
$torrentvalues[] = "NULL";

$torrentfields[] = "dht";
$torrentvalues[] = "'".$dht."'";

$torrentfields[] = "backup_tracker";
$torrentvalues[] = "'".$backup_tracker."'";

$torrentfields[] = "views";
$torrentvalues[] = "'".$row['views']."'";

$torrentfields[] = "downloaded";
$torrentvalues[] = "'".$row['hits']."'";

$torrentfields[] = "completed";
$torrentvalues[] = "'".$row['times_completed']."'";

$torrentfields[] = "banned";
$torrentvalues[] = "'".$row['banned']."'";

$torrentfields[] = "password";
$torrentvalues[] = $password;

$torrentfields[] = "visible";
$torrentvalues[] = "'".$row['visible']."'";

$torrentfields[] = "evidence";
$torrentvalues[] = "'0'";

$torrentfields[] = "owner";
$torrentvalues[] = "'".$row['owner']."'";

$torrentfields[] = "ownertype";
$torrentvalues[] = "'0'";

$torrentfields[] = "uploader_host";
$torrentvalues[] = "'0'";

$torrentfields[] = "numratings";
$torrentvalues[] = "'0'";

$torrentfields[] = "ratingsum";
$torrentvalues[] = "'0'";

$torrentfields[] = "seeders";
$torrentvalues[] = "'".$row['seeders']."'";

$torrentfields[] = "leechers";
$torrentvalues[] = "'".$row['leechers']."'";

$torrentfields[] = "tot_peer";
$torrentvalues[] = "'".intval($row['seeders']+$row['leechers'])."'";

$torrentfields[] = "speed";
$torrentvalues[] = "'0'";

$torrentfields[] = "comments";
$torrentvalues[] = "'".$row['comments']."'";

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

$torrentfields[] = "imdb";
$torrentvalues[] = "'".$row['imdb']."'";

$torrentsql = "INSERT INTO test_torrents (".implode(", ",$torrentfields).") VALUES (".implode(", ",$torrentvalues).");";
$db->sql_query($torrentsql) or btsqlerror($torrentsql);
echo "Torrent ".$row['name']." added<br />";
/*$sqlc = "SELECT * FROM `cooments` WHERE `torrent`='".$row['id']."';";
$resc = $db->sql_query($sqlc);
while($rowc = $db->sql_fetchrow($resc)){
                        $sql = "INSERT INTO ".$db_prefix."_comments (user, torrent, added, text) VALUES ('".$rowc['user']."', '".$row['id']."', '".$row['added']."', '" . $row['text'] . "');";
                        $db->sql_query($sql) or btsqlerror($sql);
}
$db->sql_freeresult($resc);
*/

}
$db->sql_freeresult($res);

?>