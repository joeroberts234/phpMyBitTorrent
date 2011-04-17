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
        global $db, $db_prefix;
if(!checkaccess("offers")){
OpenErrTable(_btaccdenied);
echo "<p>"._bt_voteoffer_noaccess."</p>";
CloseErrTable();
die();
}
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



/////////////////////Test if offers is enabled////////////////////////////
$sql = "SELECT * FROM ".$db_prefix."_offres_config";
$res = $db->sql_query($sql);
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];
if ($arr_config["enable"]!='true')bterror(_bt_offers_closed,_btsorry);
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
OpenTable(_bt_offers_offers);
if ($user->user)  {
print("<p align=center><a href=offer.php>"._bt_offers_make."</a>");
?>
<br>
<?php
print(_bt_offers_ok);
}
$categ = (int)$_GET["category"];
$offerorid = (int)$_GET["offerorid"];
$sort = $_GET["sort"];
$filter = $_GET["filter"];
if ($sort == "votes")
$sort = " order by hits desc ";
else if ($sort == "name")
$sort = " order by name ";
else
$sort = " order by added desc ";
if ($offerorid <> NULL)
{
if (($categ <> NULL) && ($categ <> 0))
$categ = "WHERE ".$db_prefix."_offers.category = " . $categ . " AND ".$db_prefix."_offers.userid = " . $offerorid;
else
$categ = "WHERE ".$db_prefix."_offers.userid = " . $offerorid;
}
else if ($categ == 0)
$categ = '';
else
$categ = "WHERE ".$db_prefix."_offers.category = " . $categ;
$res = $db->sql_query("SELECT count(".$db_prefix."_offers.id) FROM ".$db_prefix."_offers inner join ".$db_prefix."_categories on ".$db_prefix."_offers.category = ".$db_prefix."_categories.id inner join ".$db_prefix."_users on ".$db_prefix."_offers.userid = ".$db_prefix."_users.id  $categ $filter");
$row = $db->sql_fetchrow($res);
$count = $row[0];
$perpage = 10;
list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] ."?" . "category=" . $_GET["category"] . "&sort=" . $_GET["sort"] . "&" );
echo $pagertop;
$res = $db->sql_query("SELECT ".$db_prefix."_users.downloaded, ".$db_prefix."_users.uploaded, ".$db_prefix."_users.username, ".$db_prefix."_offers.id, ".$db_prefix."_offers.userid, ".$db_prefix."_offers.name, ".$db_prefix."_offers.added, ".$db_prefix."_offers.votes, ".$db_prefix."_categories.name as cat FROM ".$db_prefix."_offers inner join ".$db_prefix."_categories on ".$db_prefix."_offers.category = ".$db_prefix."_categories.id inner join ".$db_prefix."_users on ".$db_prefix."_offers.userid = ".$db_prefix."_users.id  $categ $filter $search $sort $limit");
$num = $db->sql_numrows($res);
print("<form method=get action=offers.php>");
?>
<select name="category">
<option value="0"><?=_bt_offers_showall?></option>
<?php
$cats = catlist();
$catdropdown = "";
foreach ($cats as $cat) {
$catdropdown .= "<option value=\"" . $cat["id"] . "\"";
$catdropdown .= ">" . htmlspecialchars($cat["name"]) . "</option>\n";
}
?>
<?php echo $catdropdown ?>
</select>
<?php
print("<input type=submit align=center value=Change style='height: 22px'>");
print("</form><br />");
print("<table border=1 width=100% cellspacing=0 cellpadding=0 class=\"ttable_headinner\">\n");
print("<tr><td class=ttable_head align=center>"._bt_offers_category."</td><td class=ttable_head align=left><a href=". $_SERVER[PHP_SELF] ."?category=" . $_GET[category] . "&filter=" . $_GET[filter] . "&sort=name>"._bt_offers_torrentname."</a></td><td class=ttable_head align=center width=150><a href=" . $_SERVER[PHP_SELF] ."?category=" . $_GET[category] . "&filter=" . $_GET[filter] . "&sort=added>"._bt_offers_date."</a></td><td class=ttable_head align=center>"._bt_offers_uploader."</td><td class=ttable_head align=center><a href=" . $_SERVER[PHP_SELF] ."?category=" . $_GET[category] . "&filter=" . $_GET[filter] . "&sort=comments>"._bt_offers_comments."</a></td><td class=ttable_head align=center>"._bt_offers_votes."</td><td class=ttable_head align=center>Vote</td><td class=ttable_head align=center>"._bt_offers_pm."</td></tr>\n");
for ($i = 0; $i < $num; ++$i)
{
$arr = $db->sql_fetchrow($res);
                if ($arr["downloaded"] == 0) $ratio = "&infin;";
                else {
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
if ($arr["votes"] == 0) $zvote = "$arr[votes]"; else $zvote = "<b><a href=offervotes.php?id=$arr[id]>$arr[votes]</a></b>";
 $url = "offedit.php?id=$arr[id]";
if (isset($_GET["returnto"])) {
$addthis = "&amp;returnto=" . urlencode($_GET["returnto"]);
$url .= $addthis;
$keepget .= $addthis;
}
$editlink = "a href=\"$url\" class=\"sublink\"";
if (!$user->admin) {
$zedit = "";
} else {
$zedit = " &nbsp;&nbsp;&nbsp;&nbsp;<$editlink><b>"._bt_offers_edit."</b></a>";
}
$addedby = "<td style='padding: 0px' align=center ><a href=user.php?op=profile&id=$arr[userid]><b>$arr[username] ($ratio)</b></a></td>";
/////////////////////////Partie Commentaires//////////////////////
$rez = $db->sql_query("SELECT comments FROM ".$db_prefix."_offers WHERE id=$arr[id]");
$comm = $db->sql_fetchrow($rez)or btsqlerror($rez);
if ($comm[comments] == 0)
$comment = "0";
else
$comment = "<a href=offdetails.php?id=$arr[id]#startcomments><b>$comm[comments]</b></a>";
/////////////////////////Fin partie Commentaires///////////////////
$crez = $db->sql_query("select name as cat_name, image as cat_pic from ".$db_prefix."_categories where name='$arr[cat]'");
$crow = $db->sql_fetchrow($crez);
print("<tr><td align=center class=ttable_col1 style='padding: 0px'>");
     if (isset($crow["cat_name"])) {
             if (isset($crow["cat_pic"]) && $crow["cat_pic"] != "")
             print("<img border=\"0\" src=\"cat_pics/" . $crow["cat_pic"] . "\" alt=\"" . $crow["cat_name"] . "\" title=\"" . $crow["cat_name"] . "\" />");
         else
             print($crow["cat_name"]);
         print("</a>");
     }
     else
         print("-");
     print("</td>\n");
print("<td align=left class=ttable_col2><a href=offdetails.php?id=$arr[id]><b>$arr[name]</b></a>$zedit</td>" .
"<td align=center class=ttable_col1>$arr[added]</td>$addedby<td align=center class=ttable_col2>$comment</td><td align=center class=ttable_col1>$zvote  </td><td align=center class=ttable_col2><a href=addoffer.php?id=$arr[id]>Voter</td><td align=center class=ttable_col1><a href=pm.php?op=send&to=$arr[userid]><img src=themes/".$theme."/pics/pm_write.png width=32 height=32 border=0></a></td></tr>\n");
}
print("</table>\n");
echo $pagerbottom;
CloseTable();
include("footer.php");
?>