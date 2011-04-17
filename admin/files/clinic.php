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

if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

@ini_set("upload_max_filesize",$max_torrent_size);
@set_time_limit(300);
@ini_set("memory_limit","64M");


OpenTable("TorrentClinic&trade;");
echo "<p>"._admclinicintro."</p>";
echo "<p>&nbsp;</p>";
echo "<form action=\"admin.php\" method=\"POST\" enctype=\"multipart/form-data\">\n";
echo "<input type=\"hidden\" name=\"op\" value=\"clinic\" />\n";
echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".$max_torrent_size."\" />\n";
echo "<p>"._btupfile."  <input type=\"file\" name=\"filex\" size=\"60\" /></p>\n";
echo "<p><input type=\"checkbox\" name=\"showxml\" value=\"true\" />"._admclinicshowxml;
if (!$autoscrape) echo "<br />\n<input type=\"checkbox\" name=\"scrape\" value=\"true\" />"._admclinicforcescrape;
echo "</p>\n";
echo "<input type=\"submit\" name=\"postback\" value=\""._btfsend."\">\n";
echo "</form>";
CloseTable();

if (isset($postback)) {
        OpenTable(_admclinicdiag);
        do { //trick to use break as exit

                //Load XML Bencoder Library
                require_once("include/bdecoder.php");
                require_once("include/bencoder.php");

                //Read Torrent Info
                if (!isset($_FILES["filex"])) {
                        echo "<p>"._btmissingdata."</p>\n";
                        break;
                }
                $f = $_FILES["filex"];
                $fname = unesc($f["name"]);
                $tmpname = $f["tmp_name"];

                if (empty($fname)) {
                        echo "<p>"._btemptyfname."</p>\n";
                        break;
                }

                if (!is_filename($fname)) {
                        echo "<p>"._btinvalidfname."</p>";
                        break;
                }
                if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches)) {
                        echo "<p>"._btfnamenotorrent."</p>\n";
                        break;
                }

                if (!is_uploaded_file($tmpname)) {
                        echo "<p>"._bterrnofileupload."</p>\n";
                        break;
                }
                if (!filesize($tmpname)) {
                        echo "<p>"._btemptyfile."</p>\n";
                        break;
                }
                $pagetorrent = "";
                $fp = @fopen($tmpname,"rb");
                while (!feof($fp)) $pagetorrent .= @fread($fp,1000);

                @fclose($fp);

                //In this area Warnings may appear without harming the page look
                echo "<p>"._admclinicdecoding."</p>";
                echo "<div style=\"overflow: auto; border: 0px; white-space: nowrap; width: 100%; margin: 0px; padding: 2px; height: 60px;\">";
                $torrent = BDecode($pagetorrent);
                echo "</div>\n";
                unset($pagetorrent);
                if (!torrent) {
                        echo "<p>"._admclinicdecodeerror."</p>";
                        break;
                }
                if (isset($showxml) AND $showxml == "true") {
                        echo "<p>"._admclinicxmlstruct."</p>\n";
                        echo "<div type=\"text/xml\" style=\"overflow: auto; border: 1px; white-space: nowrap; width: 100%; margin: 0px; padding: 2px; height: 300px;\"><p>";
                        echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($torrent->dump_mem(true,"UTF-8")));
                        echo "</p></div>\n";
                        echo "<p>&nbsp;</p>\n";
                }

                echo "<p>&nbsp;</p>\n";

                #Checking against basic dictionaries
                echo "<p>";

                //Checking against default tracker
                echo "<b>"._admclinickchkannounce."</b>";

                if (!entry_exists($torrent,"announce(String)")) {
                        echo _admclinicchkannounceerror;
                        echo "</p>";
                        break;
                }
                $announce = entry_read($torrent,"announce(String)");
                $annregexp_http = "/(http[s]?+):\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
                $annregexp_dht = "/^dht:\/\/[0-9a-f]*.dht\/announce$/i";
                echo $announce;
                if (!preg_match($annregexp_http,$announce) AND !preg_match($annregexp_dht,$announce)) {
                        echo " <b>"._admclinicinvalidannounce."</b>";
                        echo "</p>\n";
                        break;
                }

                echo "<br />";
                unset($annregexp_dht);

                echo "<b>"._admclinickchkinfo."</b>";
                //Checking against Info dictionary
                if (!entry_exists($torrent,"info(Dictionary)")) {
                        echo _admclinicchkinfoerror;
                        echo "</p>\n";
                        break;
                }
                echo _admclinicchkinfook;
                echo "<br />\n";

                //Checking against single or multi-file
                echo "<b>"._admclinicchkmulti."</b>";
                if (entry_exists($torrent,"info/length(Integer)") AND entry_exists($torrent,"info/name(String)")) {
                        //Single file
                        echo _admclinicchkmultis;
                        $length = entry_read($torrent,"info/length(Integer)");
                        $name = entry_read($torrent,"info/name(String)");
                        echo "<br />\n";

                        echo _admclinicchkfile." ".htmlspecialchars($name)." (".mksize($length).")";
                        unset($length, $name);
                        echo "<br />\n";
                } elseif(entry_exists($torrent,"info/files(List)")) {
                        //Multiple files
                        echo _admclinicchkmultim;
                        echo "</p>\n";

                        $accum = 0;

                        $files = entry_read($torrent,"info/files(List)");

                        echo "<div style=\"overflow: auto; border: 1px; white-space: nowrap; width: 100%; margin: 0px; padding: 2px; height: 200px;\"><p>";
                        foreach ($files as $file) {
                                $length = $file->get_elements_by_tagname("length");
                                $size = $length[0]->get_content();


                                if (!is_numeric($size) OR $length[0]->get_attribute("type") != "Integer") {
                                        echo _admchkinvalidfsize;
                                        echo "</br />\n";
                                        continue;
                                }
                                $accum += $size;

                                $path = $file->get_elements_by_tagname("path");

                                if ($path[0]->get_attribute("type") != "List") {
                                        echo _admchkinvalidfilepath;
                                        echo "</br />\n";
                                        continue;
                                }

                                $fpath = Array();
                                foreach ($path[0]->child_nodes() as $child) {
                                        array_push($fpath,$child->get_content());
                                }


                                echo htmlspecialchars(implode("/",$fpath))." (".mksize($size).")<br />\n";
                        }
                        echo "</p></div>\n";
                        echo "<b>"._admclinickchktotsize."</b> ".mksize($accum)."<br />";

                        unset($files, $children, $child, $length, $size, $path, $fpath, $accum);
                } else {
                        echo _admclinicchkmultif;
                        echo "</p>\n";
                        break;
                }

                //Checking against piece length
                echo "<b>"._admclinicchkplen."</b>";
                if (!entry_exists($torrent,"info/piece length(Integer)")) {
                        echo _admclinicchkplenmissing;
                        echo "</p>\n";
                        break;
                }
                $piece_length = entry_read($torrent,"info/piece length(Integer)");
                echo $piece_length;
                echo "<br />";
                unset($piece_length);

                //Checking against pieces integrity
                echo "<b>"._admclinicchkpieces."</b>";
                if (!entry_exists($torrent,"info/pieces(String)")) {
                        echo _admclinicchkpiecesmissing;
                        echo "</p>\n";
                        break;
                }
                $pieces = entry_read($torrent,"info/pieces(String)");
                if (strlen($pieces) % 20 == 0) echo _admclinicchkpiecesok;
                else echo _admclinicchkpiecesfail;
                unset($pieces);

                //The Torrent is valid till now
                echo "<br />\n<br />\n";
                echo "<b>"._admclinicchkbasic."</b>";
                echo "</p>\n";
                echo "<p>&nbsp;</p>\n";
                echo "<p><b>"._admclinicchkadvanced."</b></p>\n";

                //DHT Support
                echo "<p><b>"._admclinicdht."</b>";
                if (entry_exists($torrent,"azureus_properties/dht_backup_enable(Integer)")) echo _admclinicsupported;
                else echo _admclinicnotsupported;
                echo "</p>\n";

                //Multiple Trackers
                echo "<p><b>"._admclinicannouncelist."</b>";
                if (entry_exists($torrent,"announce-list(List)")) echo _admclinicsupported;
                else echo _admclinicnotsupported;
                echo "</p>\n";

                if (($autoscrape OR isset($scrape)) AND preg_match($annregexp_http,$announce) AND !strstr($announce,$announce_url) ) do {
                        @set_time_limit(180);
                        echo "<p><b>"._admclinicscraping."</b>".$announce."</b><p>\n";
                        echo "<p>&nbsp;</p>\n\n";
                        $scrape_url = str_replace("announce","scrape",$announce);
                        $info = entry_get($torrent,"info");
                        $info_hash = sha1(Benc($info));
                        unset($info);
                        $scrape_url .= ((strpos($scrape_url,"?")) ? "&" : "?")."info_hash=".urlencode(pack("H*",$info_hash));

                        if (!$fp = fopen($scrape_url,"rb")) { //Warnings are shown
                                echo "<p>"._admtrkcannotopen."</p>\n";
                                break;
                        }

                        $page = "";
                        while (!@feof($fp)) $page .= @fread($fp,1000);
                        @fclose($fp);
                        $scrape = Bdecode($page,"Scrape");
                        unset($page);


                        if (isset($showxml) AND $showxml == "true") {
                                echo "<p>"._admclinicxmlstruct."</p>\n";
                                echo "<div type=\"text/xml\" style=\"overflow: auto; border: 1px; white-space: nowrap; width: 100%; margin: 0px; padding: 2px; height: 150px;\"><p>";
                                echo str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8")));
                                echo "</p></div>\n";
                                echo "<p>&nbsp;</p>\n";
                        }

                        if (!entry_exists($scrape,"files/".$info_hash."(Dictionary)","Scrape")) {
                                echo "<p>"._admclinicscrapefail."</p>";
                        } else {
                                $seeders = entry_read($scrape,"files/".$info_hash."/complete(Integer)","Scrape");
                                $leechers = entry_read($scrape,"files/".$info_hash."/incomplete(Integer)","Scrape");
                                $completed = entry_read($scrape,"files/".$info_hash."/downloaded(Integer)","Scrape");

                                echo "<p><b>"._btseeders."</b>: ".$seeders." - <b>"._btleechers."</b>: ".$leechers." - <b>"._btsnatch."</b>: ".$completed."</p>\n";
                        }
                        unset($scrape);


                } while (false);

        } while (false);
        unset($torrent);
        CloseTable();
}
?>