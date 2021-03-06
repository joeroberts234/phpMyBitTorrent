<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*------              �2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

if (!defined('IN_PMBT')) die ("You can't access this file directly");

function getscrapedata($url) {
        if (!$fp = fopen($url,"rb")) return false; //Warnings are shown
        $page = "";
        while (!feof($fp)) $page .= @fread($fp,10000);
        @fclose($fp);

        echo "<p>"._admtrkrawdata."</p>\n";
        echo "<div style=\"overflow: auto; border: 1px; white-space: nowrap; margin: 0px; padding: 2px; width: 100%; height: 100px;\"><p>".htmlspecialchars($page)."</p></div>\n";

        $scrape = BDecode($page,"Scrape");
        unset($page);

        if (!$scrape) {
                echo "<p>"._admtrkinvalidbencode."</p>\n";
                return false;
        }

        return $scrape;
}

function ResolveTracker($url, &$resp) {
        $server = parse_url($url);

        if (!$server["port"]) $server["port"] = 80;

        $out  = "GET ".$server["path"]." HTTP/1.1\r\n";
        $out .= "Host: ".$server['host']."\r\n";
        $out .= "User-Agent: Azureus 2.4.0.2\r\n";
        $out .= "Connection: Close\r\n\r\n";

        $fp = @fsockopen($server["host"],$server["port"],$errno,$errstr,1.0);
        if (!$fp) return false;

        fwrite($fp,$out);
        $resp = fgets($fp,512);
        fclose($fp);
        //echo $resp;
        if(!ereg("HTTP/1\.[01] 20[0-3] OK",$resp)) return false;
        return true;
}


if ($op == "bantracker" AND isset($id) AND is_numeric($id) AND isset($action)) do {
        $sql = "SELECT url FROM ".$db_prefix."_trackers WHERE id = ".$id." LIMIT 1;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($res) < 1) {
                $db->sql_freeresult($res);
                break;
        }
        list ($annurl) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);

        if ($action == "ban") {
                $sql = "UPDATE ".$db_prefix."_trackers SET status = 'blacklisted' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "UPDATE ".$db_prefix."_torrents SET banned = 'yes' WHERE tracker = '".$annurl."';";
                $db->sql_query($sql) or btsqlerror($sql);
        } elseif ($action == "unban") {
                $sql = "UPDATE ".$db_prefix."_trackers SET status = 'active' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "UPDATE ".$db_prefix."_torrents SET banned = 'no' WHERE tracker = '".$annurl."';";
                $db->sql_query($sql) or btsqlerror($sql);
        }
} while (false);
if ($op == "bannewtracker") {
        $annregexp = "/(http[s]?+):\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/";
        if (!preg_match($annregexp, $announce) OR $announce == $announce_url) bterror(_btinvannounce."<b>".$announce. "</b>",_admbannewtracker,false);
        else {
                $sql = "INSERT INTO ".$db_prefix."_trackers (url , status , updated) VALUES ('".addslashes($announce)."', 'blacklisted', NOW( ));";
                $db->sql_query($sql);
        }
}

OpenTable(_admtrackers);
echo "<p>"._admtrackerintro."</p>\n";
echo "<p>&nbsp;</p>\n";

$sql = "SELECT id, url, status, UNIX_TIMESTAMP(updated) AS updated FROM ".$db_prefix."_trackers;";

$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) < 1) {
        echo "<p><b>"._admnotrackers."</b></p>";
} else {
        echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "<thead>\n";
        echo "<tr><td><p><b>"._admtrackerurl."</b></p></td><td><p><b>"._admtrkstatus."</b></p></td><td><p><b>"._admtrklastupdate."</b></p></td><td><p><b>"._admtrkassociatedtorrents."<b></p></td><td><p><b>"._btactions."</b></p></td></tr>";
        echo "</thead>\n";

        echo "<tbody>\n";
        while ($tracker = $db->sql_fetchrow($res)) {
                $torrentsql = "SELECT COUNT(id) FROM ".$db_prefix."_torrents WHERE tracker = '".$tracker["url"]."';";
                $torrentres = $db->sql_query($torrentsql) or btsqlerror($torrentsql);
                list ($torrents) = $db->sql_fetchrow($torrentres);
                $db->sql_freeresult($torrentres);

                $act = "ban";
                $alt = _admtrkblacklist;
                $ban = "lock.gif";
                if ($tracker["status"] == "active") $trkstatus = _admtrkstatusactive;
                elseif($tracker["status"] == "dead") $trkstatus = _admtrkstatusdead;
                else {
                        $trkstatus = _admtrkstatusblack;
                        $act = "unban";
                        $alt = _admtrkblacklist;
                        $ban = "unlock.gif";
                }
                echo "<tr><td><p>".$tracker["url"]."</p></td><td><p>".(($op == "scrapenow" AND isset($id) AND $id == $tracker["id"])? "" : $trkstatus)."</p></td><td><p>".(($op == "scrapenow" AND isset($id) AND $id == $tracker["id"]) ? "<b>"._admtrkscraping."</b>" : mkprettytime(time()-$tracker["updated"]))."<p></td><td><p>".$torrents." <a href=\"modcp.php?op=listtorrents&id=".$tracker["id"]."\">"._admtrkviewtorrents."</a></p></td><td><p>".adminpic("refresh.png","modcp.php?op=scrapenow&id=".$tracker["id"],_admtrkforcescrape).adminpic($ban,"modcp.php?op=bantracker&id=".$tracker["id"]."&action=".$act,$alt)."</p></td></tr>\n";
        }
        echo "</tbody>\n";
        echo "</table>\n";
}
$db->sql_freeresult($res);
echo "<p>&nbsp;</p>\n";
CloseTable();


if ($op == "listtorrents" AND isset($id) AND is_numeric($id)) {
        $sql = "SELECT ".$db_prefix."_torrents.*, IF(".$db_prefix."_torrents.numratings < '$minvotes', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, ".$db_prefix."_categories.name AS cat_name, ".$db_prefix."_categories.image AS cat_pic, U.username, IF(U.name IS NULL, U.username, U.name) as user_name, U.level as user_level FROM ".$db_prefix."_torrents LEFT JOIN ".$db_prefix."_categories ON category = ".$db_prefix."_categories.id LEFT JOIN ".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id LEFT JOIN ".$db_prefix."_trackers ON ".$db_prefix."_torrents.tracker = ".$db_prefix."_trackers.url WHERE ".$db_prefix."_trackers.id = '".$id."' ORDER BY ".$db_prefix."_torrents.evidence DESC, ".$db_prefix."_torrents.added DESC;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        torrenttable($res);
        $db->sql_freeresult($res);
}

if ($op == "scrapenow" AND isset($id) AND is_numeric($id)){
        OpenTable(_admtrkscraping);
        do { //I can use break to exit

        @set_time_limit(180);
        @ini_set("memory_limit","64M");
        require_once("include/bdecoder.php");

        $sql = "SELECT url, support FROM ".$db_prefix."_trackers WHERE id = ".$id." LIMIT 1;";
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

        $sql = "SELECT info_hash FROM ".$db_prefix."_torrents WHERE tracker = '".$annurl."';";
        $hashres = $db->sql_query($sql);

        if ($db->sql_numrows($hashres) < 1) {
                $db->sql_query("DELETE FROM ".$db_prefix."_trackers WHERE url = '".$annurl."';");
                die("ERROR");
        }
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
        if (!ResolveTracker($scrapeurl, $resp)) {
                echo "<p>"._admtrkcannotopen;
                if ($resp) echo" (".htmlspecialchars($resp).")";
                echo "</p>\n";
                $sql = "UPDATE ".$db_prefix."_trackers SET status = 'dead' WHERE url = '".$annurl."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = 0, leechers = 0, tot_peer = 0 WHERE tracker = '". $annurl . "';";
                $db->sql_query($sql) or btsqlerror($sql);
                break;
        }

        if ($support == "selective") {
                /*
                TRIES SELECTIVE SCRAPE.
                IF WORKS SAVES DATA AND TERMINATES BLOCK (WITH BREAK)
                ELSE TRIES GLOBAL SCRAPE (WHICH IS A *STANDARD*)
                */
                $url = $scrapeurl.((strpos($scrape_url,"?")) ? "&" : "?")."info_hash=".urlencode($infohashes[0]);
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
                        echo "<div style=\"overflow: auto; border: 1px; white-space: nowrap; margin: 0px; padding: 2px; width: 100%; height: 300px;\">";
                        echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8")));
                        echo "</div>\n";
                        echo "<p>&nbsp;</p>\n";
                } else {
                        $support = "global";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'global' WHERE id = '".$id."';");
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
                        echo "<div style=\"overflow: auto; border: 1px; white-space: nowrap; margin: 0px; padding: 2px; width: 100%; height: 300px;\">";
                        echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8")));
                        echo "</div>\n";
                        echo "<p>&nbsp;</p>\n";
                } else {
                        $support = "single";
                        $db->sql_query("UPDATE ".$db_prefix."_trackers SET support = 'single' WHERE id = '".$id."';");
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
                        $scr = getscrapedata ($scrapeurl.((strpos($scrape_url,"?")) ? "&" : "?")."info_hash=".urlencode($hash));
                        echo "<p>"._admtrkdata."</p>\n";
                        echo "<div style=\"overflow: auto; border: 1px; white-space: nowrap; margin: 0px; padding: 2px; width: 100%; height: 300px;\">";
                        echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scr->dump_mem(true,"UTF-8")));
                        echo "</div>\n";
                        echo "<p>&nbsp;</p>\n";
                        $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));

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
                echo "</div>";
        }

        foreach ($infohashes as $hash) {
                $hash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($hash,20));
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
                $sql = "UPDATE ".$db_prefix."_torrents SET seeders = ". $seed .", leechers = ".$leech.", tot_peer = ". ($seed + $leech) .", completed = ". $completed .", visible = '".$visible."', last_action = NOW() WHERE info_hash = '".addslashes($hash)."';";
                $db->sql_query($sql) or btsqlerror($sql);
        }
        unset($scrape);
        $db->sql_query("UPDATE ".$db_prefix."_trackers SET updated = NOW(), status = 'active' WHERE id = '".$id."';");


        } while (false);
        CloseTable();
}

OpenTable(_admbannewtracker);
echo "<p>"._admbannewtrackerintro."</p>\n";
echo "<p>&nbsp;</p>\n";
echo "<form action=\"modcp.php\" method=\"POST\">\n";
echo "<input type=\"hidden\" name=\"op\" value=\"bannewtracker\" />\n";
echo "<table width=\"50%\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "<tr><td><p>"._admtrackerurl."</p></td><td><input type=\"text\" name=\"announce\" /></td></tr>\n";
echo "</table>\n";
echo "<p><input type=\"submit\" value=\""._btsend."\" /></p>";
echo "</form>\n";
CloseTable();
?>