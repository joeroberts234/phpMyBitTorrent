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
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/



if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");
if(!checkaccess("see_member_list")){
OpenErrTable(_btaccdenied);
echo "<p>"._btnoautherized_ml."</p>";
CloseErrTable();
die();
}
if($mode == "group")
{
$sqlev = "SELECT group_desc, level FROM ".$db_prefix."_levels WHERE ".((isset($group))? "level = '".$group : "name = '".$g)."'";
$reslev = $db->sql_query($sqlev);
       $rowlev = $db->sql_fetchrow($reslev);
OpenTable(_btmemberlist_gp);
echo "<table><tr> ";
echo "	<td class=\"row1\" width=\"20%\"><b class=\"genmed\">"._btmemberlist_gp_gn."</b></td>";
echo "	<td class=\"row2\"><b class=\"gen\" style=\"color: rgb(170, 0, 0);\">$g</b></td>";
echo "</tr>";
echo "<tr> ";
echo "	<td class=\"row1\" width=\"20%\"><b class=\"genmed\">"._btmemberlist_gp_gd."</b></td>";
echo "	<td class=\"row2\"><span class=\"gen\"></span><p class=\"forumdesc\">".$rowlev['group_desc']."</p></td>";
echo "</tr></table>";
CloseTable();
$sql = "SELECT * FROM ".$db_prefix."_users WHERE can_do = '".$rowlev['level']."';";
$res = $db->sql_query($sql) OR btsqlerror($sql);
//if ($db->sql_numrows($res) < 1) bterror(_btusernoexist,_btuserprofile);
OpenTable(_btmemberlist);
echo"<table><tr>";
echo"	<th nowrap=\"nowrap\">#</th>";
echo"	<th align=\"left\" width=\"25%\" nowrap=\"nowrap\"><a href=\"memberslist.php?g=$g&amp;mode=group&amp;sk=a&amp;sd=a\">"._btusername."</a></th>";
echo"	<th width=\"15%\" nowrap=\"nowrap\"><a href=\"memberslist.php?g=$g&amp;mode=group&amp;sk=c&amp;sd=d\">"._bt_voteoffer_joined."</a></th>";
echo"	<th width=\"15%\" nowrap=\"nowrap\">"._bt_flash_rank."</th>";

echo"	<th width=\"11%\" nowrap=\"nowrap\">"._btcontacts."</th>";
echo"	<th width=\"11%\" nowrap=\"nowrap\">"._btemailaddress."</th>";
echo"	</tr>";
echo"			<tr>";
echo"				<td class=\"row3\" colspan=\"8\"><b class=\"gensmall\">"._btmemberlist_gp_mems."</b></td>";

echo"			</tr>";

while($userrow = $db->sql_fetchrow($res)){
echo"		<tr class=\"row2\">";
echo"		<td class=\"gen row\" align=\"center\">&nbsp;".$userrow['id']."&nbsp;</td>";
echo"		<td class=\"genmed row\" align=\"left\"><a href=\"user.php?op=profile&id=".$userrow['id']."\"><font color=\"".getusercolor($userrow["can_do"])."\">".$userrow['username']."</font></a></td>";
echo"		<td class=\"genmed row\" align=\"center\" nowrap=\"nowrap\">&nbsp;".$userrow['regdate']."&nbsp;</td>";
echo"		<td class=\"gen row\" align=\"center\">".$userrow['level']."</td>";

echo"		<td class=\"gen row\" align=\"center\">&nbsp;<a href=\"pm.php?op=send&to=".$userrow['id']."\"><img src=\"/themes/".$theme."/pics/pm_write.png\" alt=\"Send private message\" title=\"Send private message\" border=\"0\"></a>";
if (!empty($userrow["aim"])) echo pic("button_aim.gif","aim:goim?screenname=".$userrow["aim"],$userrow["aim"]);
if (!empty($userrow["icq"])) echo pic("button_icq.gif","http://www.icq.com/whitepages/wwp.php?to=".$userrow["icq"]);
if (!empty($userrow["jabber"])) echo pic("button_jabber.gif",null,$userrow["jabber"]);
if (!empty($userrow["msn"])) echo pic("button_msn.gif","http://members.msn.com/".$userrow["msn"],$userrow["msn"]);
if (!empty($userrow["skype"])) echo pic("button_skype.gif","skype:".$userrow["skype"]."?chat",$userrow["skype"]);
if (!empty($userrow["yahoo"])) echo pic("button_yahoo.gif","http://edit.yahoo.com/config/send_webmesg?.target=".$userrow["yahoo"],$userrow["yahoo"]);
echo "</td>";
echo"		<td class=\"gen row\" align=\"center\">&nbsp;".(($userrow['accept_mail'] == 'yes')? "<a href=\"".$userrow['email']."\"><img src=\"./themes/".$theme."/pics/icon_mail.gif\" alt=\"E-mail\" title=\"E-mail\" border=\"0\"></a>":'')."&nbsp;</td>";
echo"</tr>";
}
echo"			</tr></table>";


CloseTable();
}else{
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

OpenTable(Members);
echo "<p>".members."</p>\n";
echo "<p>&nbsp;</p>";

echo "<form action=\"memberslist.php\" method=\"GET\">\n";
echo "<input type=\"hidden\" name=\"op\" value=\"user\" />";
echo "<p><input type=\"text\" name=\"usearch\" value=\"".$usearch."\" /> <input type=\"submit\" value=\"".Searchusers."\" />";
echo "</form>\n";

echo "<p>&nbsp;</p>\n";
echo "<p>&nbsp;</p>\n";

if (!empty($usearch)) {
$usearch = strtolower($usearch);
        $sql = "SELECT id, username, email, level, ban, banreason, uploaded, downloaded, lastip, lasthost, lastlogin, warned, can_do, inactwarning  FROM ".$db_prefix."_users WHERE clean_username LIKE '%".addslashes($usearch)."%' ORDER BY username ASC;";
        $tot = 1;
        $res = $db->sql_query($sql);
} else {
        $totsql = "SELECT COUNT(id) FROM ".$db_prefix."_users;";
        $sql = "SELECT id, username, email, level, ban, banreason, uploaded, downloaded, lastip, lasthost, lastlogin, warned, can_do, inactwarning FROM ".$db_prefix."_users ORDER BY username ASC LIMIT ".$from.",50;";

        $totres = $db->sql_query($totsql);
        list ($tot) = $db->sql_fetchrow($totres);
        $db->sql_freeresult($totres);
}
?><?php
$res = $db->sql_query($sql);
$pages = ceil($tot / 50);
$pageplus = $page + 1;
$pagemin = $page - 1;
$i = 1;
echo "<table width=\"100%\" border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\n";
while ($row = $db->sql_fetchrow($res)) {
if ($row["lastlogin"] == "0000-00-00 00:00:00")
  $lastseen = "last Login: never";
else
{
  $lastseen = "last Login: ".get_formatted_timediff(sql_timestamp_to_unix_timestamp($row["lastlogin"]))." "._btago."" ;
}
        $info = pic("pic_uploaded.gif")." ".mksize($row["uploaded"])."<br />".
        pic("pic_downloaded.gif")." ".mksize($row["downloaded"])."<br />".
        $lastseen;

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
        echo "<tr>";
        echo "<td onmouseover=\"javascript:expand(".$i.");\"><p><font color=\"".getusercolor($row["can_do"])."\">".htmlspecialchars($row["username"])."</font>";
        switch ($row["level"]) {
                case "premium": {
                        echo pic("icon_premium.gif");
                        break;
                }
                case "moderator": {
                        echo pic("icon_moderator.gif");
                        break;
                }
                case "admin": {
                        echo pic("icon_admin.gif");
                        break;
                }
        }
		
        if ($row["ban"]) echo pic("banned.png")."   ".$row['banreason'];
		If ($row['inactwarning'] == 1)echo ((file_exists("themes/".$theme."/pics/person_inactive.png"))? pic("person_inactive.png","","Inactive") : "<img src=\"images/person_inactive.png\" alt=\"Inactive\" title=\"Inactive\" border=\"0\">");
        echo "</p></td>";
        echo "<td><p>";
        help(pic("help.gif"),$info,_btuserdetails);
        echo pic("pic_ratio.gif").$ratio;
        echo"</p></td>";
        echo "</tr>\n";

        echo "<tr class=\"hide\" id=\"userpanel_".$i."\"><td nowrap nobr><p align=\"center\">";
		echo pic("profile.png","user.php?op=profile&id=".$row["id"],"Profile");
        echo pic("menu/pm.png","pm.php?op=send&to=".$row["id"],"Send message");
        echo "</p></td></tr>\n";

        $i++;
}
echo "</table>";

$pager = "<a href=\"memberslist.php\">".(($page == 1) ? "<b>1</b>" : "1")."</a>&nbsp;";

if (($page - 15) > 1) $pager .= "...";

for ($i = max(2,$page - 15); $i < min($pages, $page + 15); $i++) {
        $pager .= "<a href=\"memberslist.php?page=".$i."\">".(($i == $page) ? "<b>".$i."</b>" : $i)."</a>&nbsp;";
}

if (($page + 15) < $pages) $pager .= "...";
$pager .= "<a href=\"memberslist.php?page=".$pages."\">".(($page == $pages) ? "<b>".$pages."</b>" : $pages)."</a>";

if ($pages >1) echo "<div align=\"center\">".$pager."</div>";
$db->sql_freeresult($res);
CloseTable();
}
include("footer.php");
?>