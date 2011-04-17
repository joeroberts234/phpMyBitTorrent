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
        global $db, $db_prefix;
?>
<script type="text/javascript" language="JavaScript">
function marklist(id, name, state)
{
    var parent = document.getElementById(id);
    if (!parent)
    {
        eval('parent = document.' + id);
    }

    if (!parent)
    {
        return;
    }

    var rb = parent.getElementsByTagName('input');
    
    for (var r = 0; r < rb.length; r++)
    {    
        if (rb[r].name.substr(0, name.length) == name)
        {
            rb[r].checked = state;
        }
    }
}

</script>
<?php
if(!isset($_GET["sort"]))$_GET["sort"] = false;
if(!isset($_GET["type"]))$_GET["type"] = false;
$sort =  $_GET["sort"];
$type =  $_GET["type"];
if (isset($sort))$sort1= "&sort=".$sort."&type=".$type;
else
$sort1="";
if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
$from = ($page - 1) * $torrent_per_page;

$totsql = "SELECT COUNT(id) FROM ".$db_prefix."_torrents ;";
$totres = $db->sql_query($totsql);
list ($tot) = $db->sql_fetchrow($totres);
$db->sql_freeresult($totres);

$pages = ceil($tot / 20);

if($page < $pages) {
        $next = "<b><a href=\"admin.php?op=torrent&page=".($page+1).$sort1."\">".pic('arrow-right.png','','Next Page')."</a></b>";
} else {
        $next = pic('arrow-right.png','','Next Page');

}
if ($page > 1) {
        $prev = "<b><a href=\"admin.php?op=torrent&page=".($page-1).$sort1."\">".pic('arrow-left.png','','Previous Page')."</a></b>";
} else {
        $prev = pic('arrow-left.png','','Previous Page');
}
$pager = "<a href=\"admin.php?op=torrent&".$sort1."\">".(($page == 1) ? "<b>1</b>" : "1")."</a>&nbsp;";

if (($page - 15) > 1) $pager .= "...";

for ($i = max(2,$page - 15); $i < min($pages, $page + 15); $i++) {
        $pager .= "<a href=\"admin.php?op=torrent&page=".$i.$sort1."\">".(($i == $page) ? "<b>".$i."</b>" : $i)."</a>&nbsp;";
}
$count_get = 0;
if (($page + 15) < $pages) $pager .= "...";
$pager .= "<a href=\"admin.php?op=torrent&page=".$pages.$sort1."\">".(($page == $pages) ? "<b>".$pages."</b>" : $pages)."</a>";
foreach ($_GET as $get_name => $get_value) {
if ($get_name != "sort" && $get_name != "type") {
if ($count_get > 0) {
$oldlink = $oldlink . "&" . $get_name . "=" . $get_value;
} else {
$oldlink = ((isset($oldlink))? $oldlink : '') . $get_name . "=" . $get_value;
}
$count_get++;
}}

if ($count_get > 0) {
$oldlink = "?" . $oldlink . "&";
}else{
$oldlink = "?";
}
if ($_GET['sort'] == "1") {
if ($_GET['type'] == "desc") {
$link1 = "asc";
} else {
$link1 = "desc";
}
}
if ($_GET['sort'] == "2") {
if ($_GET['type'] == "desc") {
$link2 = "asc";
} else {
$link2 = "desc";
}
}

if ($_GET['sort'] == "3") {
if ($_GET['type'] == "desc") {
$link3 = "asc";
} else {
$link3 = "desc";
}
}

if ($_GET['sort'] == "4") {
if ($_GET['type'] == "desc") {
$link4 = "asc";
} else {
$link4 = "desc";
}
}

if ($_GET['sort'] == "5") {
if ($_GET['type'] == "desc") {
$link5 = "asc";
} else {
$link5 = "desc";
}
}

if ($_GET['sort'] == "6") {
if ($_GET['type'] == "desc") {
$link6 = "asc";
} else {
$link6 = "desc";
}
}

if ($_GET['sort'] == "7") {
if ($_GET['type'] == "desc") {
$link7 = "asc";
} else {
$link7 = "desc";
}
}

if ($_GET['sort'] == "8") {
if ($_GET['type'] == "desc") {
$link8 = "asc";
} else {
$link8 = "desc";
}
}

if ($_GET['sort'] == "9") {
if ($_GET['type'] == "desc") {
$link9 = "asc";
} else {
$link9 = "desc";
}
}

if (!isset($link1) OR $link1 == "") { $link1 = "asc"; } // for torrent name
if (!isset($link2) OR $link2 == "") { $link2 = "desc"; }
if (!isset($link3) OR $link3 == "") { $link3 = "desc"; }
if (!isset($link4) OR $link4 == "") { $link4 = "desc"; }
if (!isset($link5) OR $link5 == "") { $link5 = "desc"; }
if (!isset($link6) OR $link6 == "") { $link6 = "desc"; }
if (!isset($link7) OR $link7 == "") { $link7 = "desc"; }
if (!isset($link8) OR $link8 == "") { $link8 = "desc"; }
if (!isset($link9) OR $link9 == "") { $link9 = "desc"; }
$orderby = " ORDER BY evidence DESC ";//
if ($sort == 1) $orderby = " ORDER BY name $type  ";//

if ($sort == 2){
$orderby = " ORDER BY tracker $type  ";//
}
if ($sort == 3){
$orderby = " ORDER BY owner $type  ";//
}
if ($sort == 4){
$orderby = " ORDER BY category $type  ";//
}
if ($sort == 5){
$orderby = " ORDER BY size $type  ";
}
if ($sort == 6){
$orderby = " ORDER BY times_completed $type  ";
}
if ($sort == 7){
$orderby = " ORDER BY seeders $type  ";//
}
if ($sort == 8){
$orderby = " ORDER BY leechers $type  ";//
}
        echo "<form method=\"POST\" id=\"viewfolder\" name=\"torrents\" action=\"edit.php\">\n";
        echo "<input type=\"hidden\" name=\"op\" value=\"admin_delete\" />\n";
        echo "<input type=\"hidden\" name=\"return\" value=\"admin.php\" />\n";

echo "<table align=center cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bgcolor =\"#ffffff\" bordercolor=\"#D6D9DB\" width=\"100%\" border=\"1\">";
echo "<tr>";
echo "<td class=alt3 align=center><p><a href=\"admin.php".$oldlink."sort=1&amp;op=torrent&type=$link1\" title=\"Sort by "._btname." ".$link1."\">"._btname."</a></p></td>";
echo "<td class=alt3 align=center><p><a href=\"admin.php".$oldlink."sort=2&amp;op=torrent&type=$link2\" title=\"Sort by Tracker ".$link1."\">Tracker</a></p></td>";
echo "<td class=alt3 align=center><p>Visible</p></td>";
echo "<td class=alt3 align=center><p>Banned</p></td>";
echo "<td class=alt3 align=center><p>Link</p></td>";
echo "<td class=alt3 align=center><p><a href=\"admin.php".$oldlink."sort=7&amp;op=torrent&type=$link7\" title=\"Sort by "._btseeders." ".$link7."\">"._btseeders."</a></p></td>";
echo "<td class=alt3 align=center><p><a href=\"admin.php".$oldlink."sort=8&amp;op=torrent&type=$link8\" title=\"Sort by "._btleechers." ".$link8."\">"._btleechers."</a></p></td>";
echo "<td class=alt3 align=center><p>External</p></td>";
echo "<td class=alt3 align=center><p><a href=\"admin.php".$oldlink."sort=3&amp;op=torrent&type=$link3\" title=\"Sort by Owner ".$link3."\">Owner</a></p></td>";
echo "<td class=alt3 align=center><p>Edit/Ban</p></td>";
echo "<td class=alt3 align=center><p>Last Viewed</p></td>";
echo "<td class=alt3 align=center><p>Delete?</p></td>";
echo "</tr>";
$uc=0;
$rqq = "SELECT * FROM ".$db_prefix."_torrents " . $orderby . " LIMIT ".$from.", ".$torrent_per_page.";";
$resqq = $db->sql_query($rqq) or btsqlerror($rqq);
while ($row = $db->sql_fetchrow($resqq))
{
$num2 = $db->sql_numrows($resqq);
if ($num2 > 1)
{
$uc++;
}
if($uc%2 == 0)
$utc = $btback1;
else
$utc = $btback2;
$i++;
extract ($row);
$sqlo = "SELECT username FROM ".$db_prefix."_users WHERE id = ".$row['owner'].";";
$reso = $db->sql_query($sqlo);
while (list($name) = $db->sql_fetchrow($reso)){
$owner = $name;
}
if($row['tracker'] == '')$external = "NO";
else
$external = "YES";
$id = Array();
   echo "<tr bgcolor=\"#$utc\" onMouseOver=\"this.bgColor='$btback3';\" onMouseOut=\"this.bgColor='#$utc';\">
   <td align=center><a href=\"details.php?id=".$row["id"]."\"  title=\"".$row["name"]."\">".((strlen($row["name"]) <= 31) ? $row["name"] : substr($row["name"],0,30)."...")."</a></td>
   <td align=center>".(($row["tracker"] == '') ? ' Local' : ((strlen($row["tracker"]) <= 31) ? $row["tracker"] : substr($row["tracker"],0,30)."..."))."</td>
   <td align=center>$row[visible]</td>
   <td align=center>$row[banned]</td>
   <td align=center>".(($row["type"]=="link") ? "YES" : "NO")."</td>
   <td align=center>$row[seeders]</td>
   <td align=center>$row[leechers]</td>
   <td align=center>$external</td>
   <td align=center>".$owner."</td>
   <td align=center>".pic("edit.gif","edit.php?id=".$row["id"],_btalt_edit).pic("ban.png","edit.php?op=ban&amp;id=".$row["id"],_btban)."</td>
   <td align=center>".get_formatted_timediff(sql_timestamp_to_unix_timestamp($row["last_action"]))."</td>
   <td align=center><input type=\"checkbox\" name=\"torrent_id[]\" value=\"".$row["id"]."\" /></td></tr>\n";
}

    echo "</table>\n";
        echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "<tr>\n";
        echo "<td colspan=\"5\" align=\"right\">";
        echo "<input type=button name=\"CheckAll\"   value=\"Check All\" onClick=\"marklist('viewfolder', 'torrent', true); return false;\">";
        echo "<input type=button name=\"UnCheckAll\" value=\"Uncheck All\" onClick=\"marklist('viewfolder', 'torrent', false); return false;\">";
        echo pic("drop.gif","javascript:document.forms['torrents'].submit()",_btalt_drop);
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</form>\n";
        echo "<table border=\"0\" width=\"100%\"><tr><td align=\"left\"><p>".$prev."</p></td><td align=\"center\"><p>".(($pages > 1) ? $pager : "")."</p></td><td align=\"right\"><p>".$next."</p></td></tr></table>";

?>
