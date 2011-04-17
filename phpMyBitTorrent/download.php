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

require_once("include/config_lite.php");
if ($use_rsa) require_once("include/rsalib.php");
require_once("include/functions.php");
require_once("include/class.user.php");
if ($use_rsa) $rsa = new RSA($rsa_modulo, $rsa_public, $rsa_private);


$user = @new User($_COOKIE["btuser"]);
$announce_url = $siteurl."/announce.php";

if (isset($btlanguage) AND is_readable("language/".$btlanguage.".php")) $language = $btlanguage;
if (isset($bttheme) AND is_readable("themes/".$bttheme."/main.php")) $theme = $bttheme;

if (is_readable("language/".$language.".php"))
        require_once("language/".$language.".php");
else
        require_once("language/english.php");
if (file_exists("./themes/".$theme."/main.php")) {
        require_once("./themes/".$theme."/main.php");
} elseif (file_exists("./themes/pmbt/main.php")) {
        $theme = "pmbt";
        require_once("./themes/pmbt/main.php");
} else {
        die("Cannot run without theme! Reinstall phpMyBitTorrent NOW!!");
}
if(!checkaccess("download")){
OpenErrTable(_btaccdenied);
echo _btnoautherizeddownload;
CloseErrTable();
die();
}


function str_replcae_tracker($mystring)
{
global $user, $announce_url, $export;
if(!$mystring == $announce_url)$announce_url2 = str_replace("pirate.com","pirates.com",$announce_url);
else
$announce_url2 = $announce_url;
$query_char = (strpos($announce_url2,"?")) ? "&" : "?";
if ($user->passkey != "" AND !$export)$passkey = $query_char."passkey=".urlencode($user->passkey);
else
$passkey = "";
$trackerannounce = $announce_url2.$passkey;
                       $pos = strpos($mystring, $announce_url2);
                       if ($pos === false)$new_ann = $mystring;
                       else
                       $new_ann = $trackerannounce;
    				   return $new_ann;
}
function replace_content( &$node, $new_content )
{
    $dom = &$node->owner_document();
    $kids = &$node->child_nodes();
    foreach ( $kids as $kid )
        if ( $kid->node_type() == XML_TEXT_NODE )
            $node->remove_child ($kid);
    $node->set_content($new_content);
}
if (!isset($id) OR !is_numeric($id)) bterror(_bterridnotset);

$sql = "SELECT id, filename, name, owner, banned, password, ownertype, private, min_ratio, backup_tracker, tracker FROM ".$db_prefix."_torrents WHERE id = '".$id."' LIMIT 1;";
$res = $db->sql_query($sql);
$row = $db->sql_fetchrow($res);
if (!$row) { //Torrent not present
        header("HTTP/1.0 404 Not found");
themeheader();
        bterror(_btnotorrent,_btdownload);
}

$row_id_torrent = $row["id"];
$row_filename = $row["filename"];
$row_name = $row["name"];
$row_owner = $row["owner"];
$row_banned = $row["banned"];
$row_password = $row["password"];
$row_backup_tracker = $row["backup_tracker"];
$row_tracker = $row["tracker"];
$row_owner_type = $row["ownertype"];
$row_private = $row["private"];
$row_min_ratio = number_format($row["min_ratio"],2);

$id_user = $user->id;
$name_user = $user->name;
if ($row_banned == "yes" AND !$user->moderator) { //Stealth for Banned Torrent if not admin
        header("HTTP/1.0 404 Not found");
themeheader();
        bterror(_btnotorrent,_btdownload);
}

if ($download_level == "user" AND !$user->user) {
themeheader();
        loginrequired("user");
        include("footer.php");
        die();
}
if ($download_level == "premium" AND !$user->premium) {
themeheader();
        loginrequired("premium");
        include("footer.php");
        die();
}

if (!$user->premium AND $row_password != "" AND $password != $row_password AND ($row_owner != $id_user OR $id_user == 0)) {
        header("Location: details.php?id=".$row_id_torrent);
        die();
}


$errmsg = Array();

if (!$user->premium AND $row_owner != $id_user AND $row_tracker == "") {
        #Global Tracker Rules first

        ##Number of seeds
        $seednsql = "SELECT COUNT(id) as seeded FROM ".$db_prefix."_peers WHERE ip = '".$_SERVER["REMOTE_ADDR"]."' AND seeder = 'yes';";
        $seednres = $db->sql_query($seednsql) or btsqlerror($seednsql);
        list ($seeded) = $db->sql_fetchrow($seednres);
        if ($min_num_seed_e > 0 AND $seeded < $min_num_seed_e) $errmsg[] = str_replace("**min**",$min_num_seed_e,_btminseedrule);

        ##Seed Size
        $seedsizesql = "SELECT SUM(size) as size FROM ".$db_prefix."_torrents, ".$db_prefix."_peers WHERE ".$db_prefix."_peers.torrent = ".$db_prefix."_torrents.id AND (".$db_prefix."_peers.real_ip = '".ip2long($_SERVER["REMOTE_ADDR"])."' OR ".$db_prefix."_peers.uid = '".$id_user."') AND ".$db_prefix."_peers.seeder = 'yes';";
        $seedsizeres = $db->sql_query($seedsizesql) or btsqlerror($seedsizesql);
        list ($seedsize) = $db->sql_fetchrow($seedizeres);
        if ($min_size_seed_e > 0 AND $seedsize < $min_num_seed_e) $errmsg[] = str_replace("**min**",mksize($min_size_seed_e),_btminseedsizerule);

        #Private Torrent check
        if ($download_level == "user" AND $torrent_global_privacy AND $row_owner_type != 2 AND count($errors) == 0 AND $row_private == "true") {
                $ratio_authorized = false; //ratio authorization success

                if ($row_min_ratio > 0) {
                        $ratiosql = "SELECT uploaded, downloaded FROM ".$db_prefix."_users WHERE id = '".$id_user."' LIMIT 1;";
                        $ratiores = $db->sql_query($sql) or btsqlerror($ratiosql);
                        list ($uploaded, $downloaded) = $db->sql_fetchrow($ratiores);
                        if ($downloaded == 0) $ratio_authorized = true;
                        elseif (number_format($uploaded/$downloaded) >= $row_min_ratio) $ratio_authorized = true;
                }

                $sql_privacy = "SELECT status FROM ".$db_prefix."_privacy_global WHERE master = '".$row_owner."' AND slave = '".$id_user."' LIMIT 1;";
                $sql_privacy_file = "SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row_id_torrent."' AND slave = '".$id_user."' LIMIT 1;";

                $privacy_res = $db->sql_query($sql_privacy);
                $file_res = $db->sql_query($sql_privacy_file);
                #Checking against blacklist
                if ($db->sql_numrows($privacy_res) == 1) { //Global authorization set, but dunno which
                        list ($status) = $db->sql_fetchrow($privacy_res);
                        if ($status == "blacklist") $errmsg[] = _bterrblacklist; //The user is completely blacklistes
                        //Else the user is granted to access and needs nothing more
                } elseif ($db->sql_numrows($file_res) == 1) { //File autorization requested, but with unknown response
                        list ($status) = $db->sql_fetchrow($file_res);
                        if ($status == "pending") $errmsg[] = _bterrorprivate; //Owner has not responded yet
                        elseif ($status == "denied") $errmsg[] = _btrefused; //Owner denied download
                } elseif (!$ratio_authorized) { //User has not requested Download Authorization and his ratio is not compliant. Error and authorization request.
                        $sql = "INSERT INTO ".$db_prefix."_privacy_file (master, slave, torrent) VALUES (".$row_owner.", ".$id_user.",".$row_id_torrent.");";
						require_once("include/class.email.php");
                        $db->sql_query($sql) or btsqlerror($sql);
                        $owner_sql = "SELECT username, language, email FROM ".$db_prefix."_users WHERE id = '".$row_owner."' LIMIT 1;";
                        $owner_res = $db->sql_query($owner_sql) or btsqlerror($owner_sql);
                        list ($master_name, $master_language, $email_to) = $db->sql_fetchrow($owner_res);
                        $db->sql_freeresult($owner_res);
                        include("language/mailtexts.php");
                        if (empty($master_language) OR !file_exists("language/".$master_language.".php")) $lang_email = $language;
                        else $lang_email = $master_language;
                        $request_mail = New eMail();
                        $search = Array("**sitename**","**siteurl**","**master**","**slave**","**id**","**name**");
                        $replace = Array($sitename,$siteurl,$master_name,getusername($btuser),$row_id_torrent,$row_name);
                        $request_mail->subject = str_replace("**sitename**",$sitename,$authreqmailsub[$lang_email]);
                        $request_mail->sender = $admin_email;
                        $request_mail->Add($email_to);
                        $request_mail->body = str_replace($search,$replace,$authreqmailtext[$lang_email]);
                        $request_mail->Send();

                        $errmsg[] = _btreqsent; //Page will return error
                }
                $db->sql_freeresult($privacy_res);
                $db->sql_freeresult($file_res);
        }
}
if (count($errmsg) > 0) {
themeheader();
        bterror($errmsg,_btdownload);
}
$fn = "$torrent_dir/".$row_id_torrent.".torrent";
if (!is_file($fn) OR !is_readable($fn)) {
        header("HTTP/1.0 500 Internal Server Error");
themeheader();
        bterror(_bttorrentunavailable);
}
if (!isset($export) OR $export == 0) $export = false;
else $export = true;
if ($tableopen)die('error');
if ($torrent_prefix != "") $row_filename = $torrent_prefix." - ".$row_filename;
$row_filename .= ".torrent";
#Finally, everything is correct and download is ready!!!
header("Content-Type: application/x-bittorrent");
header("Cache-control: private");
header("Content-Disposition: attachment; filename=\"".$row_filename."\"");

        @require_once("include/bencoder.php");
        @require_once("include/bdecoder.php");
        $query_char = (strpos($announce_url,"?")) ? "&" : "?";
        //Patch Torrent
        $page = @file_get_contents($fn);
        $torrent = BDecode($page);
        unset($page);
        $neannounce = entry_read($torrent,"announce(String)");
        $new_ann = str_replcae_tracker($neannounce);
        $root = &$torrent->first_child();
        $anns = &$root->get_elements_by_tagname("announce");
        $ann = &$anns[0];
        $ann->remove_child($ann->first_child());
        $ann->set_content($new_ann);
		//Patch Backup
		if(entry_exists($torrent,"announce-list(List)","Torrent"))
		{
        $anns = &$root->get_elements_by_tagname("announce-list");
        $ann = &$anns[0];
        $uploaded = $torrent->create_element("Item");
        $uploaded->set_attribute("type","List");
        $uploaded = $ann->append_child($uploaded);
        $trackers = Array();
        $to_check = Array();
        $announce_list = entry_read($torrent,"announce-list(List)");
        foreach ($announce_list as $group) {
                $trackers_in_group = Array();
                foreach ($group->child_nodes() as $tracker_node) {
                        $tracker = $tracker_node->get_content();
						replace_content( $tracker_node, str_replcae_tracker($tracker) );
                }

        }
		}
        $page = Bencode($torrent);
        unset($torrent, $root, $anns, $ann);

        #Writing to output
        echo $page;

        unset($page);


if ($row_owner != $id_user) $db->sql_query("UPDATE ".$db_prefix."_torrents SET downloaded = downloaded + 1 WHERE id = '".$row_id_torrent."';");

if (!$db->persistency) $db->sql_close();
die();
?>
