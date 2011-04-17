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

include("header.php");
global $db, $db_prefix, $btback1;
function pager($rpp, $count, $href, $opts = array()) {
    $pages = ceil($count / $rpp);

    if (!$opts["lastpagedefault"])
        $pagedefault = 0;
    else {
        $pagedefault = floor(($count - 1) / $rpp);
        if ($pagedefault < 0)
            $pagedefault = 0;
    }

    if (isset($_GET["page"])) {
        $page = 0 + $_GET["page"];
        if ($page < 0)
            $page = $pagedefault;
    }
    else
        $page = $pagedefault;

    $pager = "";

    $mp = $pages - 1;
    $as = "<b>&lt;&lt;&nbsp;Prev</b>";
    if ($page >= 1) {
        $pager .= "<a href=\"{$href}page=" . ($page - 1) . "\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;
    $pager .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $as = "<b>Next&nbsp;&gt;&gt;</b>";
    if ($page < $mp && $mp >= 0) {
        $pager .= "<a href=\"{$href}page=" . ($page + 1) . "\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;

    if ($count) {
        $pagerarr = array();
        $dotted = 0;
        $dotspace = 3;
        $dotend = $pages - $dotspace;
        $curdotend = $page - $dotspace;
        $curdotstart = $page + $dotspace;
        for ($i = 0; $i < $pages; $i++) {
            if (($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)) {
                if (!$dotted)
                    $pagerarr[] = "...";
                $dotted = 1;
                continue;
            }
            $dotted = 0;
            $start = $i * $rpp + 1;
            $end = $start + $rpp - 1;
            if ($end > $count)
                $end = $count;
            $text = "$start&nbsp;-&nbsp;$end";
            if ($i != $page)
                $pagerarr[] = "<a href=\"{$href}page=$i\"><b>$text</b></a>";
            else
                $pagerarr[] = "<b>$text</b>";
        }
        $pagerstr = join(" | ", $pagerarr);
        $pagertop = "<p align=\"center\">$pager<br />$pagerstr</p>\n";
        $pagerbottom = "<p align=\"center\">$pagerstr<br />$pager</p>\n";
    }
    else {
        $pagertop = "<p align=\"center\">$pager</p>\n";
        $pagerbottom = $pagertop;
    }

    $start = $page * $rpp;

    return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");
}


if ($user->admin)
$edit = 1;

$res2 = $db->sql_query("select count(*) from ".$db_prefix."_casino") or die(mysql_error());
$row2 = $db->sql_fetchrow($res2);
$count = $row2[0];


$perpage = 10;

list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] ."?" );

$res = $db->sql_query("select torrent_users.id as userid,torrent_users.username, torrent_users.downloaded,torrent_users.uploaded,".$db_prefix."_casino.win,".$db_prefix."_casino.lost,".$db_prefix."_casino.deposit from ".$db_prefix."_casino inner join torrent_users on ".$db_prefix."_casino.userid = torrent_users.id  ORDER BY (".$db_prefix."_casino.win - ".$db_prefix."_casino.lost) DESC $limit") or sqlerr();



OpenTable("Casino Players Record");

if ($db->sql_numrows($res) == 0)
print("<p align=center><b>No players</b></p>\n");
else
{
print("<p align=center><b><b>Casino Results</b></b></p>\n");
print("<p align=center><a href=casino.php>Back</a></p>\n");
echo $pagertop;
print("<center><table border=1 cellspacing=0 cellpadding=2>\n");


if($edit==0)
print("<tr><td class=colhead>Username</td><td class=colhead align=left>Uploaded</td><td class=colhead align=left>Downloaded</td><td class=colhead align=left>Ratio</td><td class=colhead align=left>Deposit on P2P</td><td class=colhead align=left>Won</td><td class=colhead align=left>Lost</td><td class=colhead align=left>Tries</td><td class=colhead align=left>Total</td>\n");
else
print("<tr><td class=colhead>Username</td><td class=colhead align=left>Uploaded</td><td class=colhead align=left>Downloaded</td><td class=colhead align=left>Ratio</td><td class=colhead align=left>Deposit on P2P</td><td class=colhead align=left>Won</td><td class=colhead align=left>Lost</td><td class=colhead align=left>Tries</td><td class=colhead align=left>Total</td><td class=colhead align=left>edit user</td>\n");


while ($arr = $db->sql_fetchrow($res))
{
$rez = $db->sql_query("select * from ".$db_prefix."_casino where userid=$arr[userid]");
$arz = $db->sql_fetchrow($rez);
if ($arr["downloaded"] > 0)
{
     $ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
        if ($downloaded == 0)
                $ratio = "&infin;";
        elseif ($ratio < 0.1)
                $ratio = "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.2)
                $ratio = "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.3)
                $ratio = "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.4)
                $ratio = "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.5)
                $ratio = "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.6)
                $ratio = "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.7)
                $ratio = "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.8)
                $ratio = "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.9)
                $ratio = "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 1)
                $ratio = "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
        else
                $ratio = "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
  }
  else
     if ($arr["uploaded"] > 0)
       $ratio = "&infin;";
else
$ratio = "---";
$uploaded =mksize($arr["uploaded"]);
$downloaded = mksize($arr["downloaded"]);
if ($user->id == $arr[userid]) 
$bg = "bgcolor=#".$btback1.""; 
else 
$bg = "bgcolor=#".$btback2."";

$all = $arz[win]-$arz[lost];
if($all < 0)
{
$all = $all * -1;
$minus = "-";
}

if($edit==0)
print("<tr><td $bg><b>$arr[username]</b></td><td align=left $bg>$uploaded</td><td align=left $bg>$downloaded</td><td align=left $bg>$ratio</td><td align=center $bg>".mksize($arz[deposit])."</td><td align=left $bg>".mksize($arz[win])."</td><td align=left $bg>".mksize($arz[lost])."</td><td align=left $bg>$arz[trys]</td><td align=left $bg> $minus".mksize($all)."</td></tr>\n");
else
print("<tr><td $bg><b>$arr[username]</b></td><td align=left $bg>$uploaded</td><td align=left $bg>$downloaded</td><td align=left $bg>$ratio</td><td align=center $bg>".mksize($arz[deposit])."</td><td align=left $bg>".mksize($arz[win])."</td><td align=left $bg>".mksize($arz[lost])."</td><td align=left $bg>$arz[trys]</td><td align=left $bg> $minus".mksize($all)."</td><td align=left $bg><form name=edit-player method=post action=casino_player_edit.php><input type=hidden name=player value=$arr[userid]> <input class=btn type=submit value=edit ></form></td></tr>\n");

}
print("</table>\n");
}

echo "<br><br>";
echo $pagerbottom;
CloseTable();
include ("footer.php");

?>
