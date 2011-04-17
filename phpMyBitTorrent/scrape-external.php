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
define("_admtrackers","External Trackers");
define("_admtrackerurl","Announce URL");
define("_admtrkstatus","Status");
define("_admtrkstatusactive","Active");
define("_admtrkstatusdead","Offline");
define("_admtrklastupdate","Updated");
define("_admtrkscraping","Updating");
define("_admtrkassociatedtorrents","Torrents");
define("_admtrkscraping","Updating Tracker...");
define("_admtrkcannotopen","Cannot contact URL Address. Tracker will be set as Offline");
define("_admtrkrawdata","Tracker reached. Here is the encoded response");
define("_admtrkinvalidbencode","Cannot decode Tracker response. Invalid encoding");
define("_admtrkdata","Decoding completed. Here is all the Scrape data obtained");
define("_admtrksummarystr","Found <b>**seed**</b> seeders, <b>**leechers**</b> leechers, <b>**completed**</b> completed downloads for Torrent **name** Info Hash **hash**.");

function getscrapedata($url) {
        if (!$fp = fopen($url,"rb")) return false; //Warnings are shown
        $page = "";
        while (!feof($fp)) $page .= @fread($fp,10000);
        @fclose($fp);

        echo "<p>"._admtrkrawdata."</p>\n";
        #echo "<div style=\"overflow: auto; border: 1px; white-space: nowrap; margin: 0px; padding: 2px; width: 100%; height: 100px;\"><p>".htmlspecialchars($page)."</p></div>\n";

        $scrape = BDecode($page,"Scrape");
        unset($page);

        if (!$scrape) {
                echo "<p>"._admtrkinvalidbencode."</p>\n";
                return false;
        }

        return $scrape;
}

function ResolveTracker($url, &$resp) {
if (preg_match("/thepiratebay.org/i", $url))$url=str_replace('a.tracker.','',$url);
if (preg_match("/thepiratebay.org/i", $url))$url=str_replace('eztv.tracker.','',$url);
if (preg_match("/thepiratebay.org/i", $url))$url=str_replace('tpb.tracker.','',$url);
if (preg_match("/thepiratebay.org/i", $url))$url=str_replace('vtv.tracker.','',$url);
if (preg_match("/thepiratebay.org/i", $url))$url=str_replace('tv.tracker.','',$url);
if (preg_match("/thepiratebay.org/i", $url))$url=str_replace('vip.tracker.','',$url);
if (preg_match("/thepiratebay.org/i", $url))$url=str_replace('open.tracker.','',$url);
if (preg_match("/thepiratebay.org/i", $url))$url=str_replace('tracker.','',$url);
if (preg_match("/denis.stalker.h3q.com/i", $url))return true;
if (preg_match("/tpb.tracker.prq.to/i", $url))$url=str_replace('tpb.tracker.','',$url);
if (preg_match("/tv.tracker.prq.to/i", $url))$url=str_replace('tv.tracker.','',$url);
if (preg_match("/tracker.prq.to/i", $url))$url=str_replace('tracker.','',$url);
if (preg_match("/tracker.guiks.net/i", $url))$url=str_replace('tracker.','',$url);
if (preg_match("/freeexchange.ru/i", $url))$url=str_replace('http://scrape.freeexchange.ru:2710/scrape','http://tracker.freeexchange.ru',$url);
        $server = parse_url($url);
		//die($server['host']);

        if (!$server["port"]) $server["port"] = 80;
        $out  = "GET / HTTP/1.1\r\n";
        $out .= "Host: ".$server['host'].":".$server["port"]."\r\n";
        $out .= "Connection: Close\r\n\r\n";

        $fp = @fsockopen($server["host"],'',$errno,$errstr,1.0);
        $fp2 = @fsockopen($server["host"],'80',$errno,$errstr,1.0);
		$fp3 = @fsockopen($server["host"],$server["port"],$errno,$errstr,1.0);
        if (!$fp) $fp = $fp2;
        if (!$fp) $fp = $fp3;
        if (!$fp) {
                echo $url ."123Debug: Il tracker non risponde";
               return false;
        }

        fwrite($fp,$out);
        $resp = fgets($fp,512);
        fclose($fp);
        echo $resp;
        if(ereg("HTTP/1\.[01] 30[0-3] Found",$resp)) return true;
        if(ereg("HTTP/1\.[01] 20[0-3] OK",$resp)) return true;
       return false;
}

$id2 =  $_GET["id"];
$url2 =  $_GET["tracker"];
$back=$_GET["back"];
$home = $_GET["return"];
$mystring = preg_replace('/back.*$/', '', $_SERVER['QUERY_STRING']);
if($back != '')$back = str_replace($mystring."back=", '', $_SERVER['QUERY_STRING']);
$mystring2 = preg_replace('/return.*$/', '', $_SERVER['QUERY_STRING']);
if(!$home == '')$home = str_replace($mystring2."return=", '', $_SERVER['QUERY_STRING']);
include("header.php");
require_once("include/functions.php");
if (!$user->user) loginrequired("user");
#if ($op == "scrapenow" AND isset($id) AND is_numeric($id)){
        OpenTable("scraping");
        do { //I can use break to exit

        @set_time_limit(180);
        @ini_set("memory_limit","64M");
        require_once("include/bdecoder.php");

        $sql = "SELECT url, support FROM ".$db_prefix."_trackers WHERE url = '".$url2."' LIMIT 1;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($res) < 1) {
                $db->sql_freeresult($res);
                break;
        }
        list ($annurl,$support) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);


        echo "<p>"._admtrkscraping."<br />";
        echo "<b>".$annurl."</b><p>\n";
        echo "<p>&nbsp;</p>\n\n";

        $sql = "SELECT info_hash FROM ".$db_prefix."_torrents WHERE id = '".$id2."';";
        $hashres = $db->sql_query($sql);

 /*       if ($db->sql_numrows($hashres) < 1) {
                $db->sql_query("DELETE FROM ".$db_prefix."_trackers WHERE url = '".$annurl."';");
                die("ERROR");
        }*/
        $infohashes = Array();
        $scrapearray = Array();
        while ($row_hash = $db->sql_fetchrow($hashres)) {
                $infohashes[] = $row_hash["info_hash"];
                $scrapearray[] = Array("info_hash" => $row_hash["info_hash"], "seeders" => 0, "leechers" => 0, "completed" => 0);
        }
        unset($row_hash, $sql);
        $db->sql_freeresult($hashres);

        $scrapeurl = str_replace("announce","scrape",$annurl);

        /*
        0TH ATTEMPT: CHECK FOR TRACKER ONLINE
        1ST ATTEMPT: SELECTIVE SCRAPE
        2ND ATTEMPT: GLOBAL SCRAPE
        3RD ATTEMPT: SINGLE SCRAPE
        
        
*/
        if ($support == "selective") {
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

                if ($scrape_valid) {
                        echo "<p>"._admtrkdata."</p>\n";
                       # echo "<div style=\"overflow: auto; border: 1px; white-space: nowrap; margin: 0px; padding: 2px; width: 100%; height: 300px;\">";
                       # echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8")));
                        echo "</div>\n";
                        echo "<p>&nbsp;</p>\n";
                } else {
                        $support = "global";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'global' WHERE id = '".$id2."';");
                }
        }

        if ($support == "global" AND count($infohashes) > 1) {
                $scrape_valid = false;
                $scrape = getscrapedata($scrapeurl);
                if ($scrape) {
                        if (!entry_exists($scrape,"failure reason(String)","Scrape") AND entry_exists($scrape,"files(Dictionary)","Scrape")) {
                                $scrape_valid = true;
                        }
                }
                if ($scrape_valid) {
                        echo "<p>"._admtrkdata."</p>\n";
                      #  echo "<div style=\"overflow: auto; border: 1px; white-space: nowrap; margin: 0px; padding: 2px; width: 100%; height: 300px;\">";
                       # echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8")));
                        echo "</div>\n";
                        echo "<p>&nbsp;</p>\n";
                } else {
                        $support = "single";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'single' WHERE id = '".$id2."';");
                }
        }

        if ($support == "single" OR count($infohashes) == 1) {
                $rewrite_engine = false; //We'll send output buffer to client
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
                echo "<div class=\"hide\">";
                foreach ($infohashes as $hash) {
                        $scr = getscrapedata ($scrapeurl.((strpos($scrapeurl,"?")) ? "&" : "?")."info_hash=".urlencode($hash));
                        $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
						$hash_hex = "a".$hash_hex;

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

#                        ob_flush();
                        sleep(2);
                }

                $root->append_child($files);
                $scrape->append_child($root);
                echo "</div>";
        }

        foreach ($infohashes as $hash) {
                $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
						$hash_hex = "a".$hash_hex;
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
				
                echo "<p>".str_replace(Array("**seed**","**leechers**","**completed**","**name**","**hash**"),Array($seed,$leech,$completed,htmlspecialchars($name),$hash_hex),_admtrksummarystr)."</p>";
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = ". $seed .", leechers = ".$leech.", tot_peer = ". ($seed + $leech) .", completed = ". $completed .", visible = '".$visible."', tracker_update = NOW(), last_action = NOW() WHERE info_hash = '".addslashes($hash)."';";
                $db->sql_query($sql) or btsqlerror($sql);
        }
        unset($scrape);
        $db->sql_query("UPDATE ".$db_prefix."_trackers SET updated = NOW(), status = 'active' WHERE id = '".$id2."';");


        } while (false);
		
        CloseTable();
		if ($back==""){header ("Refresh: 5; url=".$home."");
		}else{header("Refresh: 5; url=details.php?id=".$id2);
		}
include("footer.php");
?>
