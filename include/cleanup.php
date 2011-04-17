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
define('PMBT_DEBUG',false);
if(defined('PMBT_DEBUG'))error_reporting(E_ALL);
else
error_reporting(0);

if (eregi("cleanup.php", $_SERVER['SCRIPT_NAME'])) die("You can't access this file directly");

if (isset($autoscrape) AND $autoscrape) require_once("include/bdecoder.php");
if (!function_exists('gmtime')) {
function gmtime()
{
    return strtotime(get_date_time());
}
}
if (!function_exists('get_date_time')) {
function get_date_time($timestamp = 0)
{
  if ($timestamp)
    return date("Y-m-d H:i:s", $timestamp);
  else
    return gmdate("Y-m-d H:i:s");
}
}

/*Auto Prommote system By joeroberts
To Use call to function in clean up You Must use a new call for each level you want to Promote
autopromote(10,2,1.1,"Power User","user");
autpromote(
$upload = user with upload equle or greater then
$bite = Type of byte Meg Gig Tera
$ratio = user with ratio equle or better then
$new_level = New level to promote to
$old_level = select from user in this level 
)
*/
function autopromote($upload, $bite="1", $ratio, $new_level, $old_level){
	   global $db, $db_prefix;
$mb = 1024*1024;
$gb = 1024*1024*1024;
$tb = 1024*1024*1024*1024;
if ($bite == '1')
    $upload = $mb*$upload;
elseif ($bite == '2')
    $upload = $gb*$upload;
elseif ($bite == '3')
    $upload = $tb*$upload;
else return;
	$res1 ="SELECT id FROM ".$db_prefix."_users WHERE  can_do = '".$old_level."' AND active = 1 AND uploaded >= $upload AND uploaded / downloaded >= $ratio AND warned = '0'" ;
$res =$db->sql_query($res1)or btsqlerror($res1);
	$prouser = array();
       while ($arr = $db->sql_fetchrow($res))
       {
		$prouser[] = $arr['id'];
}
$db->sql_freeresult($res);
if(count($prouser) > 0)
  $db->sql_query("UPDATE ".$db_prefix."_users SET  can_do ='".$new_level."' WHERE id IN ( '".implode("','",$prouser)."')") or btsqlerror("UPDATE ".$db_prefix."_users SET  can_do ='".$level."' WHERE id IN ( '".implode("','",$prouser)."')"); 
}
/*Auto Demotion system By joeroberts
To Use call to function in clean up You Must use a new call for each level you want to demote
autodemote(1.0, "user", "Power User");
autodemote(
$ratio = user with ratio less then
$new_level New Level for user
$old_level Level From sich to demote from
)
*/
function autodemote($ratio, $new_level, $old_level){
	   global $db, $db_prefix;
	$res1 ="SELECT id FROM ".$db_prefix."_users WHERE  can_do = '".$old_level."' AND active = 1 AND uploaded / downloaded < $ratio AND warned = '0'" ;
$res =$db->sql_query($res1)or btsqlerror($res1);
	$prouser = array();
       while ($arr = $db->sql_fetchrow($res))
       {
		$prouser[] = $arr['id'];
}
$db->sql_freeresult($res);
if(count($prouser) > 0)
  $db->sql_query("UPDATE ".$db_prefix."_users SET  can_do ='".$new_level."' WHERE id IN ( '".implode("','",$prouser)."')") or btsqlerror("UPDATE ".$db_prefix."_users SET  can_do ='".$level."' WHERE id IN ( '".implode("','",$prouser)."')"); 
}
function autoinvites($length, $minlimit, $maxlimit, $minratio, $invites)
       {
	   global $db, $db_prefix;
	$minlimit = 1024*1024*1024*$minlimit;
	$maxlimit = 1024*1024*1024*$maxlimit;
	$res = $db->sql_query("SELECT id, invites FROM ".$db_prefix."_users WHERE  active = 1 AND downloaded >= $minlimit AND downloaded < $maxlimit AND uploaded / downloaded >= $minratio AND warned = '0' AND invites < 10 AND UNIX_TIMESTAMP(invitedate) < UNIX_TIMESTAMP(NOW()) - $length*86400") ;
if ($db->sql_numrows($res) > 0)
    {
        while ($arr = $db->sql_fetchrow($res))
        {
if ($arr['invites'] == 9)
$invites = 1;
elseif ($arr[invites] == 8 && $invites == 3)
$invites = 2;
  $db->sql_query("UPDATE ".$db_prefix."_users SET invites = invites + ".$invites.", invitedate = NOW() WHERE id='".$arr['id']."'") ; 
 }
}
}
function getscrapedata($url) {
        if (!$fp = fopen($url,"rb")) return false; //Warnings are shown
        $page = "";
        while (!feof($fp)) $page .= @fread($fp,10000);
        @fclose($fp);

        ////echo $page;

        $scrape = BDecode($page,"Scrape");
        unset($page);

        if (!$scrape) return false;

        return $scrape;
}
if (!function_exists('ResolveTracker')) {
function ResolveTracker($url, &$resp) {
        $server = parse_url($url);

        if (!isset($server["port"])) $server["port"] = 80;

        $out  = "GET ".$server["path"]." HTTP/1.1\r\n";
        $out .= "Host: ".$server['host']."\r\n";
        $out .= "User-Agent: Azureus 2.4.0.2\r\n";
        $out .= "Connection: Close\r\n\r\n";

        $fp = @fsockopen($server["host"],$server["port"],$errno,$errstr,1.0);
        if (!$fp) {
                //echo "Debug: Il tracker non risponde";
                return false;
        }

        fwrite($fp,$out);
        $resp = fgets($fp,512);
        fclose($fp);
        //echo $resp;
        if(!ereg("HTTP/1\.[01] 20[0-3] OK",$resp)) return false;
        return true;
}
}

function multiscrape() {
        //echo "Debug: entro in multiscrape\n";
        global $db, $db_prefix, $time_tracker_update;
        $sql = "SELECT url, support, id FROM ".$db_prefix."_trackers WHERE UNIX_TIMESTAMP(updated) < UNIX_TIMESTAMP(NOW()) - (".intval($time_tracker_update).") AND status = 'active' ORDER BY updated ASC LIMIT 1;";
        $trkres = $db->sql_query($sql);
        if (!$trkrow = $db->sql_fetchrow($trkres)) {
                //echo "Debug: Non ho un tracker attivo\n";
                $db->sql_freeresult($trkres);
                //Trying to contact a dead tracker after thrice the interval
                $sql = "SELECT url, support, id FROM ".$db_prefix."_trackers WHERE UNIX_TIMESTAMP(updated) < UNIX_TIMESTAMP(NOW()) - (3 * ".intval($time_tracker_update).") AND status = 'offline' ORDER BY RAND() LIMIT 1;";
                $trkres = $db->sql_query($sql);
                if (!$trkrow = $db->sql_fetchrow($trkres)) return;
        }
		//print_r($trkrow);
        $db->sql_freeresult($trkres);
        $announce = $trkrow["url"];
        $support = $trkrow["support"];
		$id = $trkrow['id'];

        $sql = "SELECT info_hash FROM ".$db_prefix."_torrents WHERE tracker = '".$announce."';";
        $hashres = $db->sql_query($sql);

        if ($db->sql_numrows($hashres) < 1) {
                $db->sql_query("DELETE FROM ".$db_prefix."_trackers WHERE url = '".$announce."';");
                return;
        }

        $infohashes = Array();
        while ($row_hash = $db->sql_fetchrow($hashres)) {
                $infohashes[] = $row_hash["info_hash"];
        }
        unset($row_hash, $sql);
        $db->sql_freeresult($hashres);

        //echo "Debug: ho scelto un tracker: ".$announce."\n";
        $scrapeurl = str_replace("announce","scrape",$announce);
        /*
        0TH ATTEMPT: CHECK FOR TRACKER ONLINE
        1ST ATTEMPT: SELECTIVE SCRAPE
        2ND ATTEMPT: GLOBAL SCRAPE
        3RD ATTEMPT: SINGLE SCRAPE
        */
        if (!ResolveTracker($scrapeurl, $resp)) {
                //echo "Debug: Impossibile collegarsi al tracker\n";
                if ($resp) //echo $resp;
                $sql = "UPDATE ".$db_prefix."_trackers SET status = 'dead' WHERE url = '".addslashes($announce)."';";
                $db->sql_query($sql);
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = 0, leechers = 0, tot_peer = 0 WHERE tracker = '". addslashes($announce) . "';";
                $db->sql_query($sql);
                return;
        }

        //echo "Debug: il tracker è pronto\n";

        if ($support == "selective") {
                //echo "Debug: Tento il selettivo\n";
                /*
                TRIES SELECTIVE SCRAPE.
                IF WORKS SAVES DATA AND TERMINATES BLOCK (WITH BREAK)
                ELSE TRIES GLOBAL SCRAPE (WHICH IS A *STANDARD*)
                */
                $url = $scrapeurl.((strpos($scrapeurl,"?")) ? "&" : "?")."info_hash=".urlencode($infohashes[0]);
                for ($i = 1; $i < count($infohashes); $i++) {
                        $url .= "&info_hash=".urlencode($infohashes[$i]);

                }
                $scrape = getscrapedata($url);
                $scrape_valid = false;

                //Checking if returned scrape is valid scrape data
                if ($scrape) {
                        if (!entry_exists($scrape,"failure reason(String)","Scrape") AND entry_exists($scrape,"files(Dictionary)","Scrape")) {
                                $scrape_valid = true;
                        }
                }

                if (!$scrape_valid) {
                        $support = "global";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'global' WHERE id = '".$id."';");
                }
        }

        if ($support == "global" AND count($infohashes) > 1) {
                //echo "Debug: Tento il globale\n";
                $scrape_valid = false;
                $scrape = getscrapedata($scrapeurl);
                if ($scrape) {
                        if (!entry_exists($scrape,"failure reason(String)","Scrape") AND entry_exists($scrape,"files(Dictionary)","Scrape")) {
                                $scrape_valid = true;
                        }
                }
                if (!$scrape_valid) {
                        $support = "single";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'single' WHERE id = '".$id."';");
                }
        }

        if ($support == "single" OR count($infohashes) == 1) {
                //echo "Debug: Tento il singolo\n";

                /*
                SINGLE SCRAPE CREATES A FAKE GLOBAL SCRAPE QUERYING THE TRACKER MULTIPLE TIMES
                THE FAKE SCRAPE IS USED TO MAKE THE NEXT PART OF THE CODE BELIEVE WE DID A SINGLE JOB
                THIS METHOD IS USED ON LARGE TRACKERS AND HAS ONE INCONVENIENT: WITH MANY TORRENTS
                YOUR SERVER COULD GET BANNED FOR HAMMERING
                */

                $scrape = domxml_new_doc("1.0");
                $root = $scrape->create_element("Scrape");
                $root->set_attribute("type","Dictionary");
                $files = $scrape->create_element("files");
                $files->set_attribute("type","Dictionary");

                foreach ($infohashes as $hash) {
                        $scr = getscrapedata ($scrapeurl.((strpos($scrapeurl,"?")) ? "&" : "?")."info_hash=".urlencode($hash));
                        $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
						$hash_hex = 'a'.$hash_hex;

                        if (entry_exists($scr,"files/".$hash_hex."(Dictionary)","Scrape")) {
                                #Create the XML node for fake global scrape
                                $item = $scrape->create_element($hash_hex);
                                $item->set_attribute("type","Dictionary");

                                $complete = $scrape->create_element("complete");
                                $complete->set_attribute("type","Integer");
                                $child = $scrape->create_text_node(entry_read($scr,"files/".$hash_hex."/complete(Integer)","Scrape"));
                                $complete->append_child($child);

                                $incomplete = $scrape->create_element("incomplete");
                                $incomplete->set_attribute("type","Integer");
                                $child = $scrape->create_text_node(entry_read($scr,"files/".$hash_hex."/incomplete(Integer)","Scrape"));
                                $incomplete->append_child($child);

                                $downloaded = $scrape->create_element("downloaded");
                                $downloaded->set_attribute("type","Integer");
                                $child = $scrape->create_text_node(entry_read($scr,"files/".$hash_hex."/downloaded(Integer)","Scrape"));
                                $downloaded->append_child($child);

                                $item->append_child($complete);
                                $item->append_child($incomplete);
                                $item->append_child($downloaded);

                                $files->append_child($item);
                        }
                        unset($scr);

                        ob_flush();
                        sleep(2);
                }

                $root->append_child($files);
                $scrape->append_child($root);

        }

        //echo "Debug: Ho fatto lo scrape\n";
        foreach ($infohashes as $hash) {
                $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
				$hash_hex = 'a'.$hash_hex;
                if (!entry_exists($scrape,"files/".$hash_hex."(Dictionary)","Scrape")) {
                        $seed = $leech = $completed = 0;
                } else {

                        $seed = entry_read($scrape,"files/".$hash_hex."/complete(Integer)","Scrape");
                        $leech = entry_read($scrape,"files/".$hash_hex."/incomplete(Integer)","Scrape");
                        $completed = entry_read($scrape,"files/".$hash_hex."/downloaded(Integer)","Scrape");
                        $name = ((entry_exists($scrape,"files/".$hash_hex."/name(String)","Scrape")) ? entry_read($scrape,"files/".$hash_hex."/name(String)","Scrape") : "");
                }
                if (($seed + $leech) > 0) $visible = "yes";
                else $visible = "no";
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = ". $seed .", leechers = ".$leech.", tot_peer = ". ($seed + $leech) .", completed = ". $completed .", visible = '".$visible."', last_action = NOW() WHERE info_hash = '".addslashes($hash)."';";
                $db->sql_query($sql);
        }
        unset($scrape);
        $db->sql_query("UPDATE ".$db_prefix."_trackers SET updated = NOW(), status = 'active' WHERE id = '".$id."';");

        //echo "Debug: Scrape completato\n";

}

function cleanup() {
        global $db, $db_prefix, $admin_email, $btuser, $autoscrape,$most_users_online , $dead_torrent_interval, $announce_interval, $down_limit, $autodel_users, $sitename, $autodel_users_time, $inactwarning_time, $siteurl,$forumbase, $forumshare,$phpEx, $config, $phpbb_root_path, $forumpx, $shout_config;
		//most users online
		$sql = "SELECT COUNT(id)as num_users  FROM ".$db_prefix."_online_users";
		$sql_count = $db->sql_query($sql);
		$numbero = (int) $db->sql_fetchfield('num_users');
		$db->sql_freeresult($sql_count);
		if($most_users_online < $numbero)
		{
		$db->sql_query("UPDATE ".$db_prefix."_config SET `most_on_line` = '".$numbero."', `when_most` = NOW()");
		}
//clean up donations
    $sql = "SELECT COUNT(DISTINCT username) as name 
	FROM ".$db_prefix."_users 
	WHERE donator = 'true'";
	$res = $db->sql_query($sql);		
	$doners = (int) $db->sql_fetchfield('name');
	$db->sql_freeresult($res);
   if ($doners > 0) {
    $sql2 = "SELECT  id, dondate, donator_tell 
	FROM ".$db_prefix."_users 
	WHERE donator = 'true'
	AND UNIX_TIMESTAMP(donator_tell) > UNIX_TIMESTAMP(NOW())";
	$res2 = $db->sql_query($sql2);		
    while ($arr = $db->sql_fetchrow($res2)) {
	$donatedate = $arr['dondate'];
	$doner_tell = $arr['donator_tell'];
	$uid = $arr['id'];
	   if(get_date_time(gmtime()) >= $doner_tell){
	   $db->sql_query("UPDATE ".$db_prefix."_users SET `dondate`= '0000-00-00 00:00:00', `donator_tell`='0000-00-00 00:00:00', `donator`= 'false', `dongift`=0 WHERE `id` = ".$uid.";");
	   }
	}
  }
  unset($sql,$res,$arr,$uid,$donatedate,$doner_tell);
  //Cleean Hit and Runners
$hnr_sql = "SELECT `hnr_system`, `seedtime`, `time_before_warn`, `maxhitrun`, `warnlength` FROM `".$db_prefix."_hit_n_run` ";
        $hnr_sql1=$db->sql_query($hnr_sql);
        $rowhnr = $db->sql_fetchrow($hnr_sql1);
        $db->sql_freeresult($hnr_sql);
		$hnr_system = $rowhnr['hnr_system'];
		$warnlength = $rowhnr['warnlength'];
		$maxhitrun = $rowhnr['maxhitrun'];
		$seedtime = $rowhnr['seedtime']*60;
		$time_before_warn = ($rowhnr['time_before_warn']*60);
		$warnlength = ($rowhnr['warnlength']*60*60*24);
		$timedelay = time()-($announce_interval+$time_before_warn);
if($hnr_system == 'true')
{
// Message users who have hit and run
$dohr = false;
  $sqlc = "SELECT COUNT(s.id)as hrcount  FROM ".$db_prefix."_snatched AS s INNER JOIN ".$db_prefix."_torrents AS t ON s.torrentid = t.id WHERE s.userid <> t.owner AND `completedat` > '0000-00-00 00:00:00' AND `completedat` > '2009-12-01 17:53:50' AND `seeding_time` > '0' AND `seeding_time` < '".$seedtime."' AND s.`downloaded` > s.`uploaded` AND `seeder` = 'no'  AND s.last_action < '".get_date_time(gmtime() - ($announce_interval+$time_before_warn))."' AND hitrunwarn = 'no'";
  $resc = $db->sql_query($sqlc)or btsqlerror($sqlc);
    while ($arrc = $db->sql_fetchrow($resc)) {
	$dohr = true;
}  
  $sql = "SELECT s.id, userid, torrentid, t.name FROM ".$db_prefix."_snatched AS s INNER JOIN ".$db_prefix."_torrents AS t ON s.torrentid = t.id WHERE s.userid <> t.owner AND `completedat` > '0000-00-00 00:00:00' AND `completedat` > '2009-01-27 17:53:50' AND `seeding_time` > '0' AND `seeding_time` < '".$seedtime."' AND s.`downloaded` > s.`uploaded` AND `seeder` = 'no'  AND s.last_action < '".get_date_time(gmtime() - ($announce_interval+$time_before_warn))."' AND hitrunwarn = 'no'";
  $res = $db->sql_query($sql)or btsqlerror($sql);
  if ($dohr) {
    $ids = $userids = $hitrun = array();
    while ($arr = $db->sql_fetchrow($res)) {
	if(hitrun($arr['userid'])){
      $ids[] = $arr["id"];
      $userids[] = $arr["userid"];
	  if(!isset($hitrun[$arr["userid"]]))$hitrun[$arr["userid"]] = 0;
      $hitrun[$arr["userid"]]++;
	  if(!isset($torrents[$arr["userid"]]))$torrents[$arr["userid"]] = '';
      $torrents[$arr["userid"]] .= "\n[b][url=".$siteurl."/details.php?id=$arr[torrentid]]".addslashes($arr['name'])."[/url][/b]";
    }
	}
    $userids = array_unique($userids);
    foreach($userids as $userid) {
	$hnrtorrents = $torrents[$userid];
	$hnrtot = $hitrun[$userid];
	$hnrcount = ($hitrun[$userid] == 1 ? "" : "s");
	$these = ($hitrun[$userid] == 1 ? "this" : "these");
	$is = ($hitrun[$userid] == 1 ? "is" : "are");
          $msg = str_replace(array("{hnrtot}","{hnrcount}","{these}","{is}","{hnrtorrents}"),array($hnrtot,$hnrcount,$these,$hnrtorrents),_BT_HNR_NOTICE_PM); 
      $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sent, sender, recipient, subject, text) VALUES (NOW(), 0, $userid, 'Hit and Run', '$msg')") ;
    }
    if(sizeof($ids) != 0)$db->sql_query("UPDATE ".$db_prefix."_snatched SET hitrunwarn = 'pending' WHERE id IN (".implode(", ", $ids).")") or sqlerr();
  }
  // Process hit and runs of users that have not returned
  $sql = "SELECT id, userid FROM ".$db_prefix."_snatched WHERE hitrunwarn = 'pending' AND last_action < '".get_date_time(gmtime() - ($announce_interval+$time_before_warn))."'";
  $res = $db->sql_query($sql);
  if ($db->sql_numrows($res) > 0) {
    $ids = $userids = array();
    while ($arr = $db->sql_fetchrow($res)) {
      $ids[] = $arr["id"];
      $userids[] = $arr["userid"];
	  if(!isset($hitrun[$arr["userid"]]))$hitrun[$arr["userid"]] = 0;
      $hitrun[$arr["userid"]]++;
    }
    $userids = array_unique($userids);
    foreach($userids as $userid)
      $db->sql_query("UPDATE ".$db_prefix."_users SET hitruns = hitruns + $hitrun[$userid], hitrun = '".get_date_time()."' WHERE id = $userid");
    $db->sql_query("UPDATE ".$db_prefix."_snatched SET hitrunwarn = 'yes', hitrun = '".get_date_time()."' WHERE id IN (".implode(", ", $ids).")");
  }
// Warn repeating hit and runners
  $sql = "SELECT id FROM ".$db_prefix."_users WHERE hitruns > $maxhitrun AND hitrun < '".get_date_time(gmtime() - ($announce_interval+$time_before_warn))."' AND warned = '0'";
  $res = $db->sql_query($sql);
  if ($db->sql_numrows($res) > 0) {
    $userids = array();
    $modcomment = addslashes(_btmod_HNR_mesage_a);
    $msg = _bt_HNR_WARN_PM;
    while ($arr = $db->sql_fetchrow($res)) {
      $userids[] = $arr["id"];
      $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sent, sender, recipient, subject, text) VALUES (NOW(), 0, $arr[id], 'Hit and Run', '$msg')");
    }
    $db->sql_query("UPDATE ".$db_prefix."_users SET warned = '1', warn_kapta='" . strtotime(gmdate("Y-m-d H:i:s", time())) . "', warn_hossz = warn_hossz + '".$warnlength."', modcomment = CONCAT('$modcomment', modcomment), hitruns = 0, HNR_W = HNR_W + '1' WHERE id IN (".implode(", ", $userids).")");
  }  
  $sql = "SELECT id, userid FROM ".$db_prefix."_snatched WHERE seeder = 'yes' AND 	hitrunwarn = 'yes'";
  $res = $db->sql_query($sql);
  if ($db->sql_numrows($res) > 0) {
    $ids = $userids = array();
    $msg = addslashes(_bt_hnrremoved);
    $modcomment = _btmod_HNR_mesage_b;
    while ($arr = $db->sql_fetchrow($res)) {
      $ids[] = $arr["id"];
      $userids[] = $arr["userid"];
      $userids[] = $arr["id"];
      $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sent, sender, recipient, subject, text) VALUES (NOW(), 0, ".$arr["userid"].", 'Hit and Run', '$msg')");
}
	//$warnlength = 604800;
    $db->sql_query("UPDATE ".$db_prefix."_users SET warned = '0', warn_kapta='" . strtotime(gmdate("Y-m-d H:i:s", time())) . "', warn_hossz = warn_hossz - '".$warnlength."', modcomment = CONCAT('$modcomment', modcomment), hitruns = 0, HNR_W = HNR_W - '1' WHERE id IN (".implode(", ", $userids).")");
    $db->sql_query("UPDATE ".$db_prefix."_snatched SET hitrun ='0000-00-00 00:00:00', hitrunwarn = 'no' WHERE id IN (".implode(", ", $ids).")");
}
}
    $db->sql_query("DELETE FROM ".$db_prefix."_users WHERE active = 0 AND UNIX_TIMESTAMP(regdate) < UNIX_TIMESTAMP(NOW()) - 86400;");
	# Delete PMs that have been removed by both Sender and Recipient
	$db->sql_query(	"DELETE FROM ".$db_prefix."_private_messages WHERE sender = '0' AND recipient_del = 'true';");
	$db->sql_query(	"DELETE FROM ".$db_prefix."_private_messages WHERE sender_del = 'true' AND recipient_del = 'true';");
	$db->sql_query(	"DELETE FROM ".$db_prefix."_private_messages WHERE recipient = '0';");
	$db->sql_query(	"DELETE FROM ".$db_prefix."_private_messages WHERE save = 'false' AND UNIX_TIMESTAMP(sent) < UNIX_TIMESTAMP(NOW()) - 2592000;");
    #clean snatch list
   $db->sql_query("UPDATE ".$db_prefix."_snatched SET seeder = 'no' WHERE seeder = 'yes' AND last_action < ".get_date_time(gmtime() - $announce_interval).";");


        #Reset Statistics. Run where there is a dead peer
        $sql = "DELETE FROM ".$db_prefix."_peers WHERE UNIX_TIMESTAMP(last_action) < UNIX_TIMESTAMP(NOW()) - ".($announce_interval+60).";"; //One minute of tolerance
        $res = $db->sql_query($sql);
        if ($db->sql_affectedrows($res) > 0) {
                $db->sql_query("UPDATE ".$db_prefix."_torrents SET seeders = 0, leechers = 0, tot_peer = 0, speed = 0 WHERE tracker IS NULL OR backup_tracker = 'true';");

                $sql = "SELECT COUNT(*) AS tot, torrent, seeder, SUM(upload_speed) AS speed FROM ".$db_prefix."_peers GROUP BY torrent, seeder;";
                $res = $db->sql_query($sql);
                while($row = $db->sql_fetchrow($res)) {
                        if ($row["seeder"] == "yes") $sql = "UPDATE ".$db_prefix."_torrents SET seeders = '".$row["tot"]."', speed = speed + '".$row["speed"]."' WHERE id='".$row["torrent"]."';";
                        else $sql = "UPDATE ".$db_prefix."_torrents SET leechers = '".$row["tot"]."', speed = speed + '".$row["speed"]."' WHERE id='".$row["torrent"]."';";
                        $db->sql_query($sql);
                }

                $db->sql_query("UPDATE ".$db_prefix."_torrents SET tot_peer = seeders + leechers;");
        }
        $db->sql_query("UPDATE ".$db_prefix."_torrents SET evidence = 0 WHERE evidence = 1 AND UNIX_TIMESTAMP(added) < UNIX_TIMESTAMP(NOW()) - 14*84600;");
        $db->sql_query("UPDATE ".$db_prefix."_torrents SET visible = 'no' WHERE type != 'link' AND tot_peer <= '".$down_limit."' AND UNIX_TIMESTAMP(last_action) < UNIX_TIMESTAMP(NOW()) - ".intval($dead_torrent_interval)." AND evidence != 1 AND (TRACKER IS NULL OR ".intval($autoscrape).");");
        $db->sql_query("UPDATE ".$db_prefix."_torrents SET visible = 'yes' WHERE tot_peer > '".$down_limit."';");
        $db->sql_query("DELETE FROM ".$db_prefix."_online_users WHERE UNIX_TIMESTAMP(last_action) < UNIX_TIMESTAMP(NOW()) - 300;");

#prune users
if ($autodel_users)	
{
$userwarninactivesub = Array();
$userwarninactivesub['english'] = "".$sitename." Warning";
$userwarninactivesub['german'] = "".$sitename." Achtung";
$userwarninactivesub['spanish'] = "Advertencia ".$sitename."";
$userwarninactivesub['brazilian'] = "".$sitename." adverte";
$userwarninactivesub['portuguese'] = "".$sitename." adverte";

$userwarninactivetext = Array();

$warntexten1 = "Hi,
we would like to warn you that you have not been active on **siteurl** for more than **inactwarning_time** days,
if you do not want to have your account deleted please login to it.
";
if ($autodel_users_time != 0)
{
$warntexten2 = "You have **autodel_users_time** days to log in from now. 
Otherwise we will delete your account permanently.";
}
else $warntexten2 = "";
$warntexten3 = "
Thanks **sitename** Admin
**siteurl**";
$userwarninactivetext['english'] = "".$warntexten1.$warntexten2.$warntexten3."";


$warntextger1 = "Wir möchten darauf hinweisen , dass du auf **siteurl** seit mehr als **inactwarning_time** Tagen nicht mehr aktiv warst, 
wenn Du nicht willst, dass dein Account gelöscht wird, logge dich bitte ein. 
";
if ($autodel_users_time != 0)
{
$warntextger2 = "Du hast ab jetzt **autodel_users_time** Tage Zeit um dich auf **sitename** einzuloggen.
Ansonsten werden wir deinen Account permanent löschen.";
}
else $warntextger2 = "";
$warntextger3 = "
Danke**sitename**Admin.
**siteurl**";

$userwarninactivetext['german'] = "".$warntextger1.$warntextger2.$warntextger3."";

$warntextspa1 = "Hola, 
Queriamos decirte que no visitaste nuestra pagina **siteurl** por mas de **inactwarning_time** dias.
Si no quieres que tu Cuenta sea borrada, por favor logueate. 
";
if ($autodel_users_time != 0)
{
$warntextspa2 = "Tienes **autodel_users_time** dias para loguearte nuevamente apartir de hoy.
De otra manera borraremos tu cuenta de forma permanente.";
}
else $warntextspa2 = "";
$warntextspa3 = "
Gracias. Los **sitename** administradores
**siteurl**";

$userwarninactivetext['spanish'] = "".$warntextspa1.$warntextspa2.$warntextspa3."";

$warntextbra1 = "Oi,
Nós gostaríamos de avisa-lo que voce nao tem estado ativo no **siteurl** por mais de **inactwarning_time** dias.
Se voce nao quer ter sua conta excluída, por favor conecte-se. 
";
if ($autodel_users_time != 0)
{
$warntextbra2 = "Voce tem **autodel_users_time** dias a partir de hoje para fazer isso.
Caso contrário nós iremos apagar sua conta permanentemente.";
}
else $warntextbra2 = "";
$warntextbra3 = "
Obrigado **sitename** Administrador
**siteurl**";
$userwarninactivetext['brazilian'] = "".$warntextbra1.$warntextbra2.$warntextbra3."";

$warntextpor1 = "Oi,
Nós gostaríamos de avisa-lo que voce nao tem estado ativo no **siteurl** por mais de **inactwarning_time** dias.
Se voce nao quer ter sua conta excluída, por favor conecte-se. 
";
if ($autodel_users_time != 0)
{
$warntextpor2 = "Voce tem **autodel_users_time** dias a partir de hoje para fazer isso.
Caso contrário nós iremos apagar sua conta permanentemente.";
}
else $warntextpor2 = "";
$warntextpor3 = "
Obrigado **sitename** Administrador
**siteurl**";

$userwarninactivetext['portuguese'] = "".$warntextpor1.$warntextpor2.$warntextpor3."";

$sql = "SELECT id, email, inactwarning, lastlogin, language, ban FROM ".$db_prefix."_users WHERE ban != 1 AND inactwarning != 1 AND lastlogin != '0000-00-00 00:00:00' AND (UNIX_TIMESTAMP(lastlogin) < UNIX_TIMESTAMP(NOW()) - ".$inactwarning_time.") ;";
$res = $db->sql_query($sql);
while ($get_info = $db->sql_fetchrow($res))
{
$replace_markers = Array("**sitename**","**siteurl**","**inactwarning_time**","**autodel_users_time**");
$replace_data = Array ("".$sitename."","".$siteurl."","".($inactwarning_time/86400)."","".($autodel_users_time/86400)."");
if ($get_info['language'] == "") $get_info['language'] = "english";
$warn_mail = new eMail;
$warn_mail->sender = $admin_email;
$warn_mail->subject = $userwarninactivesub[$get_info['language']];
$warn_mail->body = str_replace($replace_markers,$replace_data,$userwarninactivetext[$get_info['language']]);
$warn_mail->Add($get_info['email']);
$warn_mail->Send();
$up_warn = "UPDATE ".$db_prefix."_users SET inactwarning = 1, inactive_warn_time = NOW() WHERE  id = ".$get_info['id'].";";
$db->sql_query($up_warn);
}
}
$db->sql_query("UPDATE ".$db_prefix."_users SET inactwarning = 0, inactive_warn_time = '0000-00-00 00:00:00' WHERE inactwarning = 1 AND UNIX_TIMESTAMP(lastlogin) > UNIX_TIMESTAMP(NOW()) - (".$inactwarning_time.");");
        #Clean Shoutbox
		if($shout_config['autodelet'] == 'yes')
        $db->sql_query("DELETE FROM ".$db_prefix."_shouts WHERE UNIX_TIMESTAMP(posted) < UNIX_TIMESTAMP(NOW()) - (" . $shout_config['autodelete_time'] . ");");
#lottery
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_lottery_config") ;
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];

if ($arr_config['enable'] == 1)
{
if (gmdate("Y-m-d H:i:s", time()) > $arr_config['end_date'])
{
if ($arr_config["ticket_amount_type"] == GB)
$arr_config['ticket_amount'] = 1024 * 1024 * 1024 * $arr_config['ticket_amount'];
else if ($arr_config["ticket_amount_type"] == MB)
$arr_config['ticket_amount'] = 1024 * 1024 * $arr_config['ticket_amount'];
$size = $arr_config['ticket_amount'];

if ($arr_config["ticket_amount_type"] == GB)
$arr_config['prize_fund'] = 1024 * 1024 * 1024 * $arr_config['prize_fund'];
else if ($arr_config["ticket_amount_type"] == MB)
$arr_config['prize_fund'] = 1024 * 1024 * $arr_config['prize_fund'];
$prize_fund = $arr_config['prize_fund'];

$total = $db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_tickets"));
if ($arr_config["use_prize_fund"])
{
$pot = $prize_fund / $arr_config['total_winners'];
$res = $db->sql_query("SELECT user FROM ".$db_prefix."_tickets ORDER BY RAND() LIMIT $arr_config[total_winners]") ;
$who_won = array();
$msg = "Congratulations, You have won: <b>".mksize($pot)."</b>.<br /><br />This has been added to your upload amount<br /><br />Thanks for playing Lottery.";
while ($arr = $db->sql_fetchrow($res))
{
$res2 = $db->sql_query("SELECT modcomment FROM ".$db_prefix."_users WHERE id = $arr[user]") ;
$arr2 = $db->sql_fetchrow($res2);
$modcomment = $arr2['modcomment'];
$modcom = "User won the lottery: " . mksize($pot) . " at " . gmdate("Y-m-d H:i:s", time()) . "\n" . $modcomment;
$db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = uploaded + $pot, modcomment = '".$modcom."' WHERE id = $arr[user]") ;
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('1', '".$arr['user']."', 'LOTTERY', '".$msg."', NOW())") ;
$who_won[] = $arr['user'];
}
}
else
{
$pot = $total * $size / $arr_config['total_winners'];
$res = $db->sql_query("SELECT user FROM ".$db_prefix."_tickets ORDER BY RAND() LIMIT $arr_config[total_winners]") ;
$who_won = array();
$msg = "Congratulations, You have won: <b>".mksize($pot)."</b>.<br /><br />This has been added to your upload amount<br /><br />Thanks for playing Lottery.";
while ($arr = $db->sql_fetchrow($res))
{
$res2 = $db->sql_query("SELECT modcomment FROM ".$db_prefix."_users WHERE id = $arr[user]") ;
$arr2 = $db->sql_fetchrow($res2);
$modcomment = $arr2['modcomment'];
$modcom = "User won the lottery: " . mksize($pot) . " at " . gmdate("Y-m-d H:i:s", time()) . "\n" . $modcomment;
$db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = uploaded + $pot, modcomment = '".$modcom."' WHERE id = $arr[user]") ;
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('1', '".$arr['user']."', 'LOTTERY', '".$msg."', NOW())") ;
$who_won[] = $arr['user'];
}
}
$who_won = implode("|", $who_won);
$who_won_date = gmdate("Y-m-d H:i:s", time());
$who_won_prize = $pot;
$db->sql_query("TRUNCATE TABLE ".$db_prefix."_tickets") ;
if ($who_won != '')
{
$db->sql_query("UPDATE ".$db_prefix."_lottery_config SET value = '$who_won' WHERE name = 'lottery_winners'") ;
$db->sql_query("UPDATE ".$db_prefix."_lottery_config SET value = '$who_won_prize' WHERE name = 'lottery_winners_amount'") ;
$db->sql_query("UPDATE ".$db_prefix."_lottery_config SET value = '$who_won_date' WHERE name = 'lottery_winners_time'") ;
}
$db->sql_query("UPDATE ".$db_prefix."_lottery_config SET value = '0' WHERE name = 'enable'") ;
}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                    TRYS CASINO                                                                   //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	   $db->sql_query("UPDATE ".$db_prefix."_casino SET trys='0' WHERE UNIX_TIMESTAMP(date) < UNIX_TIMESTAMP(NOW()) - 300 AND trys >= '0' AND enableplay = 'yes'");
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                    TRYS CASINO                                                                //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                    REQUETES                                                        //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $hours = 720; // Hours to keep no filled requests 720=30days, 30*24=720
    $res = $db->sql_query("SELECT id FROM ".$db_prefix."_requests WHERE UNIX_TIMESTAMP(added) < UNIX_TIMESTAMP(NOW()) - $hours*3600") ;
    while ($arr = $db->sql_fetchrow($res))
    {
$db->sql_query("DELETE FROM ".$db_prefix."_requests WHERE id='".$arr['id']."';") ;
$db->sql_query("DELETE FROM ".$db_prefix."_addedrequests WHERE id='".$arr['id']."';") ;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                       REQUETES                                                      //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                      OFFER UPLOAD                                                        //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $hours = 360; // Hours to keep offers 360=15days, 15*24=360
	$jours = ($hours/24);
    $res = $db->sql_query("SELECT id, name, userid FROM ".$db_prefix."_offers WHERE UNIX_TIMESTAMP(added) < UNIX_TIMESTAMP(NOW()) - $hours*3600");
    while ($arr = $db->sql_fetchrow($res))
    {
     $db->sql_query("DELETE FROM ".$db_prefix."_offers WHERE id='".$arr['id']."';") ;
     $db->sql_query("DELETE FROM ".$db_prefix."_offervotes WHERE offerid='".$arr['id']."';") ;
	 $db->sql_query("UPDATE ".$db_prefix."_users SET seedbonus = seedbonus - '10.0' WHERE id = '".$arr['id']."';") ;
  	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                     OFFER UPLOAD                                                     //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//die();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                            FLASHSCORES                                                           //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $hours = 720; // Hours to keep MPS 720=30 days, 720/24=30
        $db->sql_query("DELETE FROM ".$db_prefix."_flashscores WHERE date < '".get_date_time(gmtime() - $hours)."'");
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                          FLASHSCORES                                                         //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//SET INVITE AMOUNTS ACCORDING TO RATIO/GIGS ETC
autoinvites(10,1,4,.90,1);
autoinvites(10,4,7,.95,2);
autoinvites(10,7,10,1.00,3);
autoinvites(10,10,100000,1.05,4);
autopromote(10,2,1.1,"Power_User","user");
autodemote(1.0, "user", "Power_User");
//END INVITES
//Update External Torrents
if ($autoscrape) multiscrape();
autoclean();
if ($autodel_users)
{
    $sql = "SELECT id FROM ".$db_prefix."_users WHERE inactwarning = 1 AND UNIX_TIMESTAMP(inactive_warn_time) < UNIX_TIMESTAMP(NOW()) - ".intval($autodel_users_time).";";
    $res = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($res))
    {
     removedinactive($row['id']);
    }
}
$db->sql_freeresult($res);
$db->sql_close();
}
if(defined('PMBT_DEBUG'))cleanup();
else
register_shutdown_function("cleanup");
?>