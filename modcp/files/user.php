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

if (!defined('IN_PMBT')) die ("You can't access this file directly");

if (!isset($page) OR $page < 1) $page = 1;
$from = ($page - 1) * 50;

echo <<<EOF
<script type="text/javascript" language="JavaScript">
var expanded = 0;
function expand(id) {
        if (expanded == id) return;
        var obj;
        var obj2;
        obj = document.getElementById("userpanel_"+id);
        obj.className = 'show';
        if (expanded != 0) {
                obj2 = document.getElementById("userpanel_"+expanded);
                obj2.className = 'hide';
        }
        expanded = id;
}
</script>
EOF;

if (!isset($usearch)) $usearch = "";
if(!isset($mod))$mod = false;
echo "<a name=\"user\"></a>";
OpenTable(_admuser);

echo "<p>"._admuserintro."</p>\n";
echo "<p>&nbsp;</p>";

echo "<table cellpadding=\"3\" width=\"100%\"><tr><td width=\"30%\">";

echo "<form action=\"modcp.php\" method=\"GET\">\n";
echo "<input type=\"hidden\" name=\"op\" value=\"user\" />";
echo "<input type=\"text\" name=\"usearch\" value=\"".$usearch."\" /> <input type=\"submit\" value=\""._admusersearchbtn."\" />";
echo "</form>\n";

echo "</td><td>";

echo "<form action=\"modcp.php\" method=\"GET\">\n";
echo "<input type=\"hidden\" name=\"op\" value=\"user\" />";
echo "<input type=\"text\" name=\"umailsearch\" value=\"".$umailsearch."\" /> <input type=\"submit\" value=\""._admusermailsearchbtn."\" />";
echo "</form>\n";

echo "</td></tr>";

echo "<tr><td>";


echo "<form action=\"modcp.php\" method=\"GET\">\n";
echo "<input type=\"hidden\" name=\"op\" value=\"user\" />";
echo "<input type=\"text\" name=\"uipsearch\" value=\"".$uipsearch."\" /> <input type=\"submit\" value=\""._admuseripsearchbtn."\" />";
echo "</form>\n";

echo "</td><td>";

echo "<form action=\"modcp.php\" method=\"GET\">\n";
echo "<input type=\"hidden\" name=\"op\" value=\"user\" />";
echo "<input type=\"text\" name=\"uhostsearch\" value=\"".$uhostsearch."\" /> <input type=\"submit\" value=\""._admuserhostsearchbtn."\" />";
echo "</form>\n";

echo "</td></tr></table>";

echo "<p>&nbsp;</p>\n";
echo "<p>&nbsp;</p>\n";

if (!empty($usearch)) {
        $sql = "SELECT id, username, email, level, ban, uploaded, downloaded, regdate, lastip, lasthost, lastlogin FROM ".$db_prefix."_users WHERE username LIKE '%".addslashes($usearch)."%' ORDER BY username ASC;";
        $tot = 1;
        $res = $db->sql_query($sql);
}elseif (!empty($umailsearch)) {
        $sql = "SELECT id, username, email, level, ban, uploaded, downloaded, regdate, lastip, lasthost, lastlogin FROM ".$db_prefix."_users WHERE email LIKE '%".addslashes($umailsearch)."%' ORDER BY username ASC;";
        $tot = 1;
        $res = $db->sql_query($sql);
}elseif (!empty($uipsearch)) {
        $sql = "SELECT id, username, email, level, ban, uploaded, downloaded, regdate, lastip, lasthost, lastlogin FROM ".$db_prefix."_users WHERE lastip = ".sprintf("%u",ip2long($uipsearch))." ORDER BY username ASC;";
        $tot = 1;
        $res = $db->sql_query($sql);

}elseif (!empty($uhostsearch)) {
        $sql = "SELECT id, username, email, level, ban, uploaded, downloaded, regdate, lastip, lasthost, lastlogin FROM ".$db_prefix."_users WHERE lasthost LIKE '%".addslashes($uhostsearch)."%' ORDER BY username ASC;";
        $tot = 1;
        $res = $db->sql_query($sql);

} else {
        $totsql = "SELECT COUNT(id) FROM ".$db_prefix."_users;";
        $sql = "SELECT id, username, email, level, ban, uploaded, downloaded, regdate, lastip, lasthost, lastlogin FROM ".$db_prefix."_users ORDER BY lastlogin DESC LIMIT ".$from.",50;";

        $totres = $db->sql_query($totsql);
        list ($tot) = $db->sql_fetchrow($totres);
        $db->sql_freeresult($totres);
}

$res = $db->sql_query($sql);
$pages = ceil($tot / 50);
$pageplus = $page + 1;
$pagemin = $page - 1;

$i = 1;
echo "<table width=\"100%\" border=\"1\" cellpadding=\"3\" cellspacing=\"0\">\n";
echo "<thead>\n<tr><th style=\"border:0;\" align=\"center\" width=\"30%\"><p>"._admuserusername."</p></th><th style=\"border:0;\" align=\"center\" width=\"20%\"><p>"._admuseremail."</p></th><th style=\"border:0;\" align=\"center\" width=\"20%\"><p>"._admuserregistered."</p></th>";
while ($row = $db->sql_fetchrow($res)) {
        $info = pic("pic_uploaded.gif")." ".mksize($row["uploaded"])."<br />".
        pic("pic_downloaded.gif")." ".mksize($row["downloaded"])."<br />".
        _admuserlastlogin.": ".get_formatted_timediff(sql_timestamp_to_unix_timestamp($row["lastlogin"]))." "._btago."<br />".
        _admuserlastip.": ".long2ip($row["lastip"])." [".$row["lasthost"]."]";

        if ($row["uploaded"] == 0 AND $row["downloaded"] == 0) $ratio = "---";
        elseif ($row["downloaded"] == 0) $ratio = "&infin;";
        else {
                $ratio = $row["uploaded"]/$row["downloaded"];

                if ($ratio < 0.1) $ratio = "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.2) $ratio = "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.3) $ratio = "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.4) $ratio = "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.5) $ratio = "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.6) $ratio = "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.7) $ratio = "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.8) $ratio = "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.9) $ratio = "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 1)   $ratio = "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
                else $ratio = "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
        }
        //Start writing row
	if ($row["level"] == "user") $userclass = "";
	if ($row["level"] == "premium") $userclass = "premium";
        elseif ($row["level"] == "moderator") $userclass = "mod";
        elseif ($row["level"] == "admin") $userclass = "admin";
        echo "<tr>";
        echo "<td style=\"border-bottom:0; border-left:0;\" onmouseover=\"javascript:expand(".$i.");\"><p><span class='".$userclass."'>".htmlspecialchars($row["username"])."</span>";
        
	
        
	if ($row["ban"]) echo adminpic("banned.gif");
        
	echo "</p></td>";
	echo "<td style=\"text-align: center; border-bottom:0; border-left:0;\" onmouseover=\"javascript:expand(".$i.");\"><p>".htmlspecialchars($row["email"]);
	echo "</p></td>";
	echo "<td style=\"text-align: center; border-bottom:0; border-left:0;\"><p>".htmlspecialchars($row["regdate"]);
	echo "</p></td>";
	echo "<td style=\"text-align: center; border-bottom:0; border-left:0; border-right:0;\"><p>";
        help(pic("help.gif"),$info,_btinfo);
        echo pic("pic_ratio.gif").$ratio;
        echo"</p></td>";
        echo "</tr>\n";

        echo "<tr class=\"hide\" id=\"userpanel_".$i."\"><td style=\"text-align: center; border-bottom:0; border-left:0;\" nowrap nobr><p align=\"center\">";
        echo adminpic("user_profile.png","user.php?op=profile&id=".$row["id"],_admuserviewprofile);
        echo adminpic("user_edit.png","user.php?op=editprofile&id=".$row["id"],_admusereditprofile);
        echo adminpic("user_delete.png","user.php?op=delete&id=".$row["id"],_admuserdelete);
        if (!$row["ban"]) echo adminpic("user_ban.png","modcp.php?op=addban&username=".urlencode($row["username"])."&returnto=user&page=".$page,_admuserban);
        else echo adminpic("user_unban.png","modcp.php?op=delban&uid=".$row["id"]."&returnto=user&page=".$page,_admuserunban);
        echo "</p></td></tr>\n";

        $i++;
}
echo "</table>";

$pager = "<a href=\"modcp.php?op=user\">".(($page == 1) ? "<b>1</b>" : "1")."</a>&nbsp;";

if (($page - 15) > 1) $pager .= "...";

for ($i = max(2,$page - 15); $i < min($pages, $page + 15); $i++) {
        $pager .= "<a href=\"modcp.php?op=user&page=".$i."\">".(($i == $page) ? "<b>".$i."</b>" : $i)."</a>&nbsp;";
}

if (($page + 15) < $pages) $pager .= "...";
$pager .= "<a href=\"modcp.php?op=user&page=".$pages."\">".(($page == $pages) ? "<b>".$pages."</b>" : $pages)."</a>";

if ($pages >1) echo "<div align=\"center\">".$pager."</div>";
$db->sql_freeresult($res);

echo"<span class=\"admin\">"._btclassadmin."</span>, <span class=\"moderator\">"._btclassmoderator."</span>, <span class=\"premium\">"._btclasspremium."</span>, <span class=\"user\">"._btclassuser." </span>";

CloseTable();
?>