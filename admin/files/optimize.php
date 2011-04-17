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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

OpenTable(_admoptimizedb);

echo "<table border=1 align=\"center\">\n";
echo "<thead><tr><th><p align=center>"._admtable."</p></th><th><p align=center>"._btdim."</p></th><th><p align=center>"._admstatus."</p></th><th><p align=center>"._admspacesaved."</p></th></tr></thead>\n";
echo "<tbody>\n";

$tot_data = 0;
$tot_idx = 0;
$tot_all = 0;
$local_query = "SHOW TABLE STATUS LIKE '".$db_prefix."_%';";
$result = $db->sql_query($local_query) or btsqlerror($local_query);
if ($db->sql_numrows($result) > 0) {
        while ($row = $db->sql_fetchrow($result)) {
                $tot_data = $row["Data_length"];
                $tot_idx  = $row["Index_length"];
                $total = $tot_data + $tot_idx;
                $gain= $row["Data_free"];
                $local_query = "REPAIR TABLE ".$row[0];
                $db->sql_query($local_query) or btsqlerror($local_query);
                $local_query = "OPTIMIZE TABLE ".$row[0];
                $resultat  = $db->sql_query($local_query) or btsqlerror($local_query);
                if ($gain == 0) {
                        echo "<tr><td><p>".htmlspecialchars($row[0])."</p></td><td><p>".mksize($total)."<p></td><td><p>"._admaoptimized."</p></td><td><p>0 B</p></td></tr>";
                } else {
                        echo "<tr><td><p><b>".htmlspecialchars($row[0])."</b></p></td><td><p><b>".mksize($total)."</b></p></td><td><p><b>"._admoptimized."</b></p></td><td><p><b>".mksize($gain)."</b></p></td></tr>";
                }
                $db->sql_freeresult($resultat);
        }
}
$db->sql_freeresult($result);
echo "</tbody>\n";
echo "</table>\n";
CloseTable();

$db->sql_query("UPDATE ".$db_prefix."_torrents SET seeders = 0, leechers = 0, tot_peer = 0, speed = 0 WHERE tracker IS NULL;");

$sql = "DELETE FROM ".$db_prefix."_peers WHERE UNIX_TIMESTAMP(last_action) < UNIX_TIMESTAMP(NOW()) - ".intval($announce_interval).";";
$res = $db->sql_query($sql) or btsqlerror($sql);

$sql = "SELECT count(*) as tot, torrent, seeder, (SUM(download_speed)+SUM(upload_speed))/2 as speed FROM ".$db_prefix."_peers GROUP BY torrent, seeder;";
$res = $db->sql_query($sql) or btsqlerror($sql);
while($row = $db->sql_fetchrow($res)) {
        if ($row["seeder"]=="yes") $sql = "UPDATE ".$db_prefix."_torrents SET seeders= '".$row["tot"]."', speed = speed + '".intval($row["speed"])."' WHERE id='".$row["torrent"]."'; ";
        else $sql = "UPDATE ".$db_prefix."_torrents SET leechers='".$row["tot"]."', speed = speed + '".intval($row["speed"])."' WHERE id='".$row["torrent"]."'; ";
        $db->sql_query($sql);
}

$db->sql_query("UPDATE ".$db_prefix."_torrents SET tot_peer = seeders + leechers;");
$db->sql_query("UPDATE ".$db_prefix."_snatched SET seeder = 'no';");
$sql = "SELECT uid, torrent FROM ".$db_prefix."_peers WHERE seeder = 'yes';";
$res = $db->sql_query($sql) or btsqlerror($sql);
while($row = $db->sql_fetchrow($res)) {
$db->sql_query("UPDATE ".$db_prefix."_snatched SET seeder = 'yes' WHERE userid = '".$row["uid"]."' AND torrentid = '".$row["torrent"]."';");
}

?>
