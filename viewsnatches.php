<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
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
global $db, $db_prefix;
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

OpenTable("Snatch Detailles");
$sql = ("select count(".$db_prefix."_snatched.id) from ".$db_prefix."_snatched inner join ".$db_prefix."_users on ".$db_prefix."_snatched.userid = ".$db_prefix."_users.id inner join ".$db_prefix."_torrents on ".$db_prefix."_snatched.torrentid = ".$db_prefix."_torrents.id WHERE  ".$db_prefix."_snatched.torrentid =" . $_GET[id]) or die(mysql_error());
$res3 = $db->sql_query($sql) or btsqlerror($sql);
$row = $db->sql_fetchrow($res3);
$db->sql_freeresult($res);

$count = $row[0];
$perpage = $torrent_per_page;
list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] . "?id=" . $_GET[id] . "&" );

$sql = ("select name from ".$db_prefix."_torrents where id = $_GET[id]")or die(mysql_error());
$res3 = $db->sql_query($sql) or btsqlerror($sql);
$arr3 = $db->sql_fetchrow($res3);
$db->sql_freeresult($res);


echo"<p><a href=details.php?id=$_GET[id]><b>$arr3[name]</b></a></p>";

print("<p align=center>"._btsnatch_fin_order."</p>");

echo $pagertop;

print("<table border=1 cellspacing=0 cellpadding=1 align=center>\n");
if ($user->admin)
print("<tr><td class=table_head align=center>"._btIP."</td><td class=table_head align=center>port</td><td class=table_head align=center>"._btusername."</td><td class=table_head align=center>"._btadded."</td><td class=table_head align=center>"._btdownloadedbts."</td><td class=table_head align=center>Ratio</td><td class=table_head align=center>"._btsnatch_seed_sp."</td><td class=table_head align=center>"._btsnatch_leech_sp."</td><td class=table_head align=center>"._btsnatch_time_cmpl."</td><td class=table_head align=center>"._btsnatch_last_action."</td><td class=table_head align=center>"._btsnatch_time_seeding."</td><td class=table_head align=center>"._btsnatch_cmpl."</td><td class=table_head align=center>"._btsnatch_pmu."</td><td class=table_head align=center>"._btsnatch_here."</td></tr>");
else
print("<tr><td class=table_head align=center>"._btusername."</td><td class=table_head align=center>"._btadded."</td><td class=table_head align=center>"._btdownloadedbts."</td><td class=table_head align=center>"._btratio."</td><td class=table_head align=center>"._btsnatch_seed_sp."</td><td class=table_head align=center>"._btsnatch_leech_sp."</td><td class=table_head align=center>"._btsnatch_time_cmpl."</td><td class=table_head align=center>"._btsnatch_last_action."</td><td class=table_head align=center>"._btsnatch_time_seeding."</td><td class=table_head align=center>"._btsnatch_cmpl."</td><td class=table_head align=center>"._btsnatch_pmu."</td><td class=table_head align=center>"._btsnatch_here."</td></tr>");

$res = $db->sql_query("select ".$db_prefix."_users.id, ".$db_prefix."_users.username,  ".$db_prefix."_users.uploaded, ".$db_prefix."_users.downloaded, ".$db_prefix."_snatched.seeding_time, ".$db_prefix."_snatched.completedat, ".$db_prefix."_snatched.last_action, ".$db_prefix."_snatched.ip, ".$db_prefix."_snatched.seeder, ".$db_prefix."_snatched.userid from ".$db_prefix."_snatched inner join ".$db_prefix."_users on ".$db_prefix."_snatched.userid = ".$db_prefix."_users.id inner join ".$db_prefix."_torrents on ".$db_prefix."_snatched.torrentid = ".$db_prefix."_torrents.id where  ".$db_prefix."_snatched.torrentid =" . $_GET[id] . "  ORDER BY ".$db_prefix."_snatched.id desc $limit")or print(mysql_error());
$res2 = $db->sql_query("select  ".$db_prefix."_users.lastlogin, ".$db_prefix."_snatched.uploaded, ".$db_prefix."_snatched.seeding_time, ".$db_prefix."_snatched.downloaded, ".$db_prefix."_snatched.speedup, ".$db_prefix."_snatched.port, ".$db_prefix."_snatched.ip, ".$db_prefix."_snatched.speeddown, ".$db_prefix."_snatched.userid from ".$db_prefix."_snatched inner join ".$db_prefix."_users on ".$db_prefix."_snatched.userid = ".$db_prefix."_users.id inner join ".$db_prefix."_torrents on ".$db_prefix."_snatched.torrentid = ".$db_prefix."_torrents.id WHERE  ".$db_prefix."_snatched.torrentid =" . $_GET[id] . "  ORDER BY ".$db_prefix."_snatched.id desc $limit")or print(mysql_error());
while ($arr = $db->sql_fetchrow($res))
{
$arr2 = $db->sql_fetchrow($res2);
//start Global
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
$uploaded =mksize($arr["uploaded"]);
$downloaded = mksize($arr["downloaded"]);
$uid = $arr[username];
//start torrent
if ($arr2["downloaded"] > 0)
{
$ratio2 = number_format($arr2["uploaded"] / $arr2["downloaded"], 3);
        if ($downloaded == 0)
                $ratio2 = "&infin;";
        elseif ($ratio2 < 0.1)
                $ratio2 = "<font color=\"#ff0000\">" . number_format($ratio2, 2) . "</font>";
        elseif ($ratio2 < 0.2)
                $ratio2 = "<font color=\"#ee0000\">" . number_format($ratio2, 2) . "</font>";
        elseif ($ratio2 < 0.3)
                $ratio2 = "<font color=\"#dd0000\">" . number_format($ratio2, 2) . "</font>";
        elseif ($ratio2 < 0.4)
                $ratio2 = "<font color=\"#cc0000\">" . number_format($ratio2, 2) . "</font>";
        elseif ($ratio2 < 0.5)
                $ratio2 = "<font color=\"#bb0000\">" . number_format($ratio2, 2) . "</font>";
        elseif ($ratio2 < 0.6)
                $ratio2 = "<font color=\"#aa0000\">" . number_format($ratio2, 2) . "</font>";
        elseif ($ratio2 < 0.7)
                $ratio2 = "<font color=\"#990000\">" . number_format($ratio2, 2) . "</font>";
        elseif ($ratio2 < 0.8)
                $ratio2 = "<font color=\"#880000\">" . number_format($ratio2, 2) . "</font>";
        elseif ($ratio2 < 0.9)
                $ratio2 = "<font color=\"#770000\">" . number_format($ratio2, 2) . "</font>";
        elseif ($ratio2 < 1)
                $ratio2 = "<font color=\"#660000\">" . number_format($ratio2, 2) . "</font>";
        else
                $ratio2 = "<font color=\"#00FF00\">".  number_format($ratio2, 2) . "</font>";
}
$uploaded2 = mksize($arr2["uploaded"]);
$downloaded2 = mksize($arr2["downloaded"]);
//en
if ($user->id == $arr["id"])
$highlight = "bgcolor=#$btback1"; 
else 
$highlight = "bgcolor=#$btback2";
$sql =("SELECT last_action FROM ".$db_prefix."_online_users WHERE id = '".$arr[userid]."'") or die(mysql_error());
$res99 = $db->sql_query($sql) or btsqlerror($sql);
$arr99 = $db->sql_fetchrow($res99);
$db->sql_freeresult($res99);

$sql =("SELECT  warned FROM ".$db_prefix."_users WHERE id = $arr[id]") or die(mysql_error());
$res77 = $db->sql_query($sql) or btsqlerror($sql);
$arr77 = $db->sql_fetchrow($res77);
$db->sql_freeresult($res77);

	$dons ="";
	
if ($arr77["warned"] == "yes") {
		$warn = "<img src=\"images/warned.gif\" alt=\"Warned\">";
	}
	else
	$warn =""; 	
if ($arr["seeder"] == 'yes') {
$seed = "<b><font color=green>Yes</font>";
}
else {
$seed = "<font color=red>No</font></b>";
} 
if ($user->admin)
echo("<td $highlight align=center >".long2ip($arr2[ip])."</td><td $highlight align=center >".$arr2[port]."</td><td $highlight align=center class=table_col1><a href=user.php?op=profile&id=$arr[userid]><b>$uid</b></a>$dons $warn</td><td $highlight align=left class=table_col2>$uploaded Global<br>$uploaded2 Torrent</td><td $highlight align=left class=table_col1>$downloaded Global<br>$downloaded2 Torrent</td><td $highlight align=left class=table_col2>$ratio Global<br>$ratio2 Torrent</td><td $highlight align=center class=table_col1>".mksize($arr2[speedup])."</td><td $highlight align=center class=table_col1>".mksize($arr2[speeddown])."</td><td $highlight align=center class=table_col1>$arr[completedat]</td><td $highlight align=center class=table_col2>$arr[last_action]</td><td $highlight align=center class=table_col1>".get_formatted_timediff(sql_timestamp_to_unix_timestamp($arr['completedat']),sql_timestamp_to_unix_timestamp($arr['completedat'])+$arr['seeding_time'])."</td><td $highlight align=center class=table_col1>$seed</td>
<td $highlight align=center class=table_col2><a href=pm.php?op=send&to=$arr[id]><img src=themes/".$theme."/pics/pm_write.png width=32 height=32 border=0></a></td><td $highlight align=center class=table_col2>".(sql_timestamp_to_unix_timestamp($arr2["lastlogin"]) > (time()-300) ? "<img src=images/button_online.gif border=0 alt=\"Online\">" : "<img src=images/button_offline.gif border=0 alt=\"Offline\">" )."</td>"."
</tr>\n");

else
echo("<td $highlight align=center ><a href=user.php?op=profile&id=$arr[userid]><b>$uid</b></a>$dons $warn</td><td $highlight align=left class=table_col2>$uploaded Global<br>$uploaded2 Torrent</td><td $highlight align=left class=table_col1>$downloaded Global<br>$downloaded2 Torrent</td><td $highlight align=left class=table_col2>$ratio Global<br>$ratio2 Torrent</td><td $highlight align=center class=table_col1>".mksize($arr2[speedup])."</td><td $highlight align=center class=table_col1>".mksize($arr2[speeddown])."</td><td $highlight align=center class=table_col1>$arr[completedat]</td><td $highlight align=center class=table_col2>$arr[last_action]</td><td $highlight align=center class=table_col1>".get_formatted_timediff(sql_timestamp_to_unix_timestamp($arr['completedat']),sql_timestamp_to_unix_timestamp($arr['completedat'])+$arr['seeding_time'])."</td><td $highlight align=center class=table_col1>$seed</td>
<td $highlight align=center class=table_col2><a href=pm.php?op=send&to=$arr[id]><img src=themes/".$theme."/pics/pm_write.png width=32 height=32 border=0></a></td></td><td $highlight align=center class=table_col2>".(sql_timestamp_to_unix_timestamp($arr2["lastlogin"]) > (time()-300) ? "<img src=images/button_online.gif border=0 alt=\"Online\">" : "<img src=images/button_offline.gif border=0 alt=\"Offline\">" )."</td>"."
</tr>\n");
}
print("</table>\n");

echo $pagerbottom;
CloseTable();
include("footer.php");
?>
