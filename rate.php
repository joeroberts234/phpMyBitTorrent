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

if (!eregi("rate.php",$_SERVER["PHP_SELF"])) die("You can't include this file");
include("header.php");

if (!$user->user) loginrequired("user");
if (!isset($id) OR empty($id) OR intval($id) < 1) bterror(_bterridnotset,_btratefailed);
$id = intval($id);

switch ($op) {
        case "star": {
                #Star Rating
                $rating = intval($rating);

                if ($rating <= 0 || $rating > 5)
                        bterror(_btinvalidrating,_btratefailed);

                $res = $db->sql_query("SELECT owner FROM ".$db_prefix."_torrents WHERE id = '".$id."'") or btsqlerror("SELECT owner FROM ".$db_prefix."_torrents WHERE id = '".$id."'");
                if (!$row = $db->sql_fetchrow($res))
                        bterror(_btidnotorrent,_btratefailed);
                $db->sql_freeresult($res);
                if (($row["owner"] == $user->id))
                        bterror(_btnovoteowntorrent,_btratefailed);
                $sql = "SELECT * FROM ".$db_prefix."_ratings WHERE torrent = '".$id."' AND user = '".$user->id."' LIMIT 1;";
                $res = $db->sql_query($sql) or btsqlerror($sql);

                if ($db->sql_numrows($res) > 0 ) bterror(_btcantvotetwice,_btratefailed);
                $db->sql_freeresult($res);
                $sql = "INSERT INTO ".$db_prefix."_ratings (torrent, user, rating, added) VALUES ('$id', '" . $user->id . "', '$rating', NOW())";
                $db->sql_query($sql) or btsqlerror($sql);

                $sql = "UPDATE ".$db_prefix."_torrents SET numratings = numratings + 1, ratingsum = ratingsum + '$rating' WHERE id = '$id'";
                $db->sql_query($sql) or btsqlerror($sql);

                echo "<meta http-equiv=\"refresh\" content=\"3;url=details.php?id=".$id."\">";
                OpenTable(_btrate);
                echo "<p>".str_replace("**id**",$id,_btvotedone)."</p>";
                CloseTable();
                break;
        }
        case "complaint": {
                if (!$torrent_complaints) die();
                #Complaint Rating
                $complaint = intval($complaint);
                $sqlcheck = "SELECT * FROM ".$db_prefix."_complaints WHERE torrent = '".$id."' AND user = '".$user->id."';";

                if ($db->sql_numrows($db->sql_query($sqlcheck)) != 0 ) //Have you voted yet?
                        bterror(_btcomplcantvotetwice,_btratefailed);

                $addsql = "INSERT INTO ".$db_prefix."_complaints (user, torrent, datetime, host, score) VALUES (".$user->id.",".intval($id).",NOW(),'".gethostbyaddr($_SERVER["REMOTE_ADDR"])."',".$complaint.");";
                $db->sql_query($addsql) or btsqlerror($sql);

                $countsql = "SELECT COUNT(score) as score FROM ".$db_prefix."_complaints WHERE torrent = '".$id."' AND score = 0 UNION SELECT COUNT(score) as score FROM ".$db_prefix."_complaints WHERE torrent = '".$id."' AND score <> 0;";
                $complqry = $db->sql_query($countsql);
                $rowcompl = $db->sql_fetchrowset($complqry);
                $scorerepl = Array("**p**","**n**");
                $positive = intval($rowcompl["0"]["score"]);
                $negative = intval($rowcompl["1"]["score"]);

                $score = Array($positive,$negative);
                $updqry = "UPDATE ".$db_prefix."_torrents SET complaints = '".$positive.",".$negative."' WHERE id = '".$id."';";
                $db->sql_query($updqry) or btsqlerror($updqry);
                OpenTable();
                echo "<P>".str_replace($scorerepl,$score,_btcomplatthemoment)."</P>";
                echo "<p>"._btcomplsuccess."</p>";
                if (($negative >= 20) AND ($negative >= (($negative+$positive)/100))) {
                        $banquery = "UPDATE ".$db_prefix."_torrents SET banned = 'yes' WHERE id = ".intval($id).";";
                        $log = fopen($torrent_dir."/".intval($id)."ban.log","w");
                        $btcomplaints = getcomplaints();
                        $scoresql = "SELECT A.torrent, A.user as user, A.host as host, A.datetime as time, A.score, B.username as username FROM ".$db_prefix."_complaints A LEFT JOIN ".$prefix."_users B ON A.user=B.user_id WHERE A.torrent = ".intval($id).";";
                        $scorequery = $db->sql_query($scoresql);
                        if (!$scorequery) bterror($scoresql);
                        while ($row = $db->sql_fetchrow($scorequery)) {
                                fputs($log,"At ".formatTimeStamp($row["datetime"]).", user ".$row["username"]." from ".$row["host"]." gave this Torrent the following rating: ".$scorarray[$row["score"]]."\n");
                        }
                        fclose($log);
                        $delsql = "DELETE FROM ".$db_prefix."_complaints WHERE torrent = ".intval($id).";";
                        $db->sql_query($delsql) or btsqlerror($delsql);
                        $db->sql_query($banquery) or btsqlerror($banquery);
                        echo "<br>";
                        echo "<p>"._btcomplisnowbanned."</p>";
                }
                $returl = "details.php?id=".$id;
                echo "<meta http-equiv=\"refresh\" content=\"3;url=".$returl."\">";
                echo "<p>"._btcomplainttaken."</p>";
                CloseTable();
                break;
        }
}

include("footer.php");
?>
