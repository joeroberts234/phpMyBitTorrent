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
/////////////////////Test if offers is enabled////////////////////////////
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_requist_config");
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];
if (!isset($arr_config["enable"]) || !$arr_config["enable"])bterror(_btrequest_closed,_btsorry);
$access_level = $arr_config["class_allowed"];
switch ($access_level) {
        case "user": {
                if (!$user->user) loginrequired("user");
                break;
        }
        case "premium": {
                if (!$user->premium) loginrequired("premium");
                break;
        }
        case "moderator": {
                if (!$user->moderator) loginrequired("moderator");
                break;
        }
        case "admin": {
                if (!$user->admin) loginrequired("admin");
                break;
        }
}
//////////////////////////////////////////////////////////////////////////
OpenTable(_btrequest);
global $db, $db_prefix;
function pager($rpp, $count, $href, $opts = array()) {
    $pages = ceil($count / $rpp);

    if (!isset($opts["lastpagedefault"]) OR !$opts["lastpagedefault"])
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
    $as = "<b>&lt;&lt;&nbsp;"._btsnatch_prev."</b>";
    if ($page >= 1) {
        $pager .= "<a href=\"{$href}page=" . ($page - 1) . "\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;
    $pager .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $as = "<b>"._btsnatch_next."&nbsp;&gt;&gt;</b>";
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
?>
<style>
.table_head {
font-family: 'Verdana';
border:1px solid #777777;
color: #FFFFFF;
font-size: 7pt;
background: #27323b;
}
.table_col2 {
font-family: 'Verdana';
border:1px solid #777777;
font-size: 8pt;
background: #27323b;
}
.table_col1 {
font-family: 'Verdana';
border:1px solid #777777;
font-size: 8pt;
background: #27323b;
}
.table_table {
/*width:100%;*/
border: #777777;
border-style: border-style;
border-width: 1px
border-collapse:collapse;

}
</style>
<?php
print("<a href=requests.php>"._btrequest_add."</a> | <a href=viewrequests.php?requestorid=".getuserid($btuser).">"._btrequest_view."</a>");



$categ = ((isset($_GET["category"]))? $_GET["category"] : '');
$requestorid = ((isset($_GET["requestorid"]))?$_GET["requestorid"]  : '');
$sort = ((isset($_GET["sort"]))? $_GET["sort"] : '');
$search = ((isset($_GET["search"]))? $_GET["search"] : '');
$filter = ((isset($_GET["filter"]))? $_GET["filter"] : '');

$search = " AND ".$db_prefix."_requests.request like '%$search%' ";


if ($sort == "votes")
$sort = " order by hits desc ";
else if ($sort == "request")
$sort = " order by request ";
else
$sort = " order by added desc ";


if ($filter == "true")
$filter = " AND ".$db_prefix."_requests.filledby = 0 ";
else
$filter = "";


if ($requestorid <> NULL)
{
if (($categ <> NULL) && ($categ <> 0))
 $categ = "WHERE ".$db_prefix."_requests.cat = " . $categ . " AND ".$db_prefix."_requests.userid = " . $requestorid;
else
 $categ = "WHERE ".$db_prefix."_requests.userid = " . $requestorid;
}

else if ($categ == 0)
$categ = '';
else
$categ = "WHERE ".$db_prefix."_requests.cat = " . $categ;

/*
if ($categ == 0)
$categ = 'WHERE requests.cat > 0 ';
else
$categ = "WHERE requests.cat = " . $categ;
*/


$res = $db->sql_query("SELECT count(".$db_prefix."_requests.id) FROM ".$db_prefix."_requests inner join ".$db_prefix."_categories on ".$db_prefix."_requests.cat = ".$db_prefix."_categories.id inner join ".$db_prefix."_users on ".$db_prefix."_requests.userid = ".$db_prefix."_users.id  $categ $filter $search") or btsqlerror($res);
$row = $db->sql_fetchrow($res);
$count = $row[0];

$perpage = 50;

list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] ."?" . "category=" . ((isset($_GET["category"])) ? $_GET["category"] : '') . "&sort=" . ((isset($_GET["sort"]))?  $_GET["sort"] : ''). "&" );

$res = $db->sql_query("SELECT ".$db_prefix."_users.downloaded, ".$db_prefix."_users.uploaded, ".$db_prefix."_users.username, ".$db_prefix."_users.accept_mail, ".$db_prefix."_requests.filled, ".$db_prefix."_requests.filledby, ".$db_prefix."_requests.id, ".$db_prefix."_requests.userid, ".$db_prefix."_requests.request, ".$db_prefix."_requests.added, ".$db_prefix."_requests.hits, ".$db_prefix."_categories.name as cat FROM ".$db_prefix."_requests inner join ".$db_prefix."_categories on ".$db_prefix."_requests.cat = ".$db_prefix."_categories.id inner join ".$db_prefix."_users on ".$db_prefix."_requests.userid = ".$db_prefix."_users.id  $categ $filter $search $sort $limit") or btsqlerror($res);
$num = $db->sql_numrows($res);

print("<br><br><CENTER><form method=get action=viewrequests.php>");
print(""._btrequest_search."<input type=text size=30 name=search>");
print("<input type=submit align=center value= "._btrequest_search."  style='height: 22px'>\n");
print("</form></CENTER><br>");

echo $pagertop;

echo "<Table border=0 width=100% cellspacing=0 cellpadding=0><TR><TD width=50% align=left valign=bottom>";

print("<p>"._btrequest_sort."<a href=" . $_SERVER['PHP_SELF'] . "?category=" . ((!isset($_GET['category'])) ? '' : $_GET['category']) . "&filter=" . ((!isset($_GET['filter']))  ? '' : $_GET['filter']). "&sort=votes>" . _btrequest_votes . "</a>, <a href=". $_SERVER['PHP_SELF'] ."?category=" . ((!isset($_GET['category'])) ? '' : $_GET['category']) . "&filter=" . ((!isset($_GET['filter']))  ? '' : $_GET['filter']). "&sort=request>"._btrequest_name."</a>, or <a href=" . $_SERVER['PHP_SELF'] ."?category=" . ((!isset($_GET['category'])) ? '' : $_GET['category']) . "&filter=" . ((!isset($_GET['filter']))  ? '' : $_GET['filter']). "&sort=added>" . _btrequest_added . "</a>.</p>");

print("<form method=get action=viewrequests.php>");
print '</td><td width=100% align=right valign=bottom>';
echo " <select name=\"category\">";
echo "<option value=\"0\">"._btalltypes."</option>";
foreach (catlist() as $category) {
        echo "<option value=\"".$category["id"]."\" ";
        echo " >".$category["name"]."</option>";
}
echo "</select>";

print("<input type=submit align=center value= "._btrequest_display." style='height: 22px'>\n");
print("</form></td></tr></table>");

print("<form method=post action=takedelreq.php>");
print("<table border=1 width=100% cellspacing=0 cellpadding=3 class=table_table>\n");
print("<tr><td class=table_head align=left>"._btrequest."</td><td class=table_head align=center>"._btrequest_type."</td><td class=table_head align=center width=150>"._btrequest_date."</td><td class=table_head align=center> "._btrequest_addedby."</td><td class=table_head align=center>"._btrequest_filled."</td><td class=table_head align=center>"._btrequest_filledby."</td><td class=table_head align=center>" . _btrequest_votes . "</td><td class=table_head align=center>" ._btrequest_delete . "</td></tr>\n");
for ($i = 0; $i < $num; ++$i)
{



 $arr = $db->sql_fetchrow($res);

$privacylevel = $arr["accept_mail"];
        if ($arr["downloaded"] == 0)
                $ratio = "&infin;";
				else{
		$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 2);

        if ($ratio < 0.1)
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


$res2 = $db->sql_query("SELECT username from ".$db_prefix."_users where id=" . $arr['filledby'])or btsqlerror($res2);
$arr2 = $db->sql_fetchrow($res2);  
if ($arr2['username'])
$filledby = $arr2['username'];
else
$filledby = " ";     

if ($privacylevel == "no"){
		if  ($user->admin){
			$addedby = "<td class=table_col2 align=center><a href=user.php?op=profile&username=".$arr['username']."><b>".$arr['username']." ($ratio)</b></a></td>";
		}else{
			$addedby = "<td class=table_col2 align=center><a href=user.php?op=profile&username=$arr[username]><b>$arr[username] (----)</b></a></td>";
		}
}else{
		$addedby = "<td class=table_col2 align=center><a href=user.php?op=profile&username=$arr[username]><b>$arr[username] ($ratio)</b></a></td>";
}

$filled = $arr['filled'];
if ($filled){
$filled = "<a href=$filled><font color=green><b>"._btyes."</b></font></a>";
$filledbydata = "<a href=user.php?op=profile&username=$arr[username]><b>$arr2[username]</b></a>";
}
else{
$filled = "<a href=reqdetails.php?id=$arr[id]><font color=red><b>"._btno."</b></font></a>";
$filledbydata  = "<i>nobody</i>";
}
$sql = $db->sql_query("SELECT image from ".$db_prefix."_categories where name='" . $arr['cat'] . "'")or btsqlerror($sql);
$crow = $db->sql_fetchrow($sql);  

            $catpic ="<img border=\"0\" src=\"cat_pics/" . $crow["image"] . "\" alt=\"" . $arr['cat'] . "\" title=\"" . $arr['cat'] . "\" />";

print("<tr><td class=table_col1 align=left><a href=reqdetails.php?id=$arr[id]><b>$arr[request]</b></a></td>" .
"<td class=table_col2 align=center>$catpic</td><td align=center class=table_col1>$arr[added]</td>$addedby<td class=table_col2>$filled</td><td class=table_col1>$filledbydata</td><td class=table_col2><a href=votesview.php?requestid=".$arr['id']."><b>$arr[hits]</b></a></td>");

if (($user->id == $arr['userid']) || $user->moderator){
 print("<td class=table_col1><input type=\"checkbox\" name=\"delreq[]\" value=\"" . $arr['id'] . "\" /></td>");
} else {
 print("<td class=table_col1>&nbsp;</td>");
}
print("</tr>\n");

}

print("</table>\n");

print("<p align=right><input type=submit value="._btrequest_dodel."></p>");
print("</form>");

echo $pagerbottom;

CloseTable();

include ("footer.php")

?>