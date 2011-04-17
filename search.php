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

#VARIABLE PARSING
if (!isset($search)) $search = "";
$cat = (isset($cat)) ? intval($cat) : 0;
$orderby = (isset($orderby)) ? intval($orderby) : -1;
if (!isset($ordertype) OR $ordertype != "ASC") $ordertype = "DESC";
//$from = ($page - 1) * $torrent_per_page;
if(!isset($dead))$dead = false;
//if(empty($search)) bterror(_btmisssearchkey,_btsearch);

if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
$from = ($page - 1) * $torrent_per_page;
$cats2 = genrelist2();
$wherecatina = array();
$catmain = '1';
$catmid = false;
foreach($cats2 as $cat3){
if(isset($_GET["cats".$cat3['id']])){
foreach($_GET["cats".$cat3['id']] as $v){
array_push($wherecatina,$v);
}
if(!$catmid) $catmain = "";
if($catmid) $catmain .= "', '";
$catmain .= implode("', '",$_GET["cats".$cat3['id']]);
$catmid = true;
}
}
include('actb.php');
OpenTable(pic("icon_mini_search.gif")._btsearch);
echo "<script type=\"text/javascript\" src=\"".$siteurl."/browse.js\"></script>  ";
echo "<form method=\"get\" action=\"search.php\">";
echo "<br>\n";
echo categories_table($cats2,$wherecatina);
echo "<table align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
echo "<tr><td></td><td><input id=\"actb_textbox\" type=\"text\" name=\"search\" value=\"".str_replace("+","",$search)."\" size=\"25\"> ";
echo "<td>";
echo "<SCRIPT type=\"text/javascript\" language=\"JavaScript\">";
echo "actb(document.getElementById(\"actb_textbox\"),customarray);";
echo "</SCRIPT>";
echo "</td>";

echo "<td><input type=\"submit\" value=\""._btgo."\"";

echo "</td></tr></table>";

echo "<table align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\"><tr><td><p>"._btresfor."</p></td><td> <select name=\"orderby\">\n";
$orders = Array(_btinsdate,_btseeders,_btleechers,_bttotsorc,_btdownloaded,_btvote,_btname,_btdim,_btnfile,);
$i = 0;
foreach ($orders as $order) {
        echo "<option value=\"".$i."\" ";
        if ($orderby == $i) echo "selected";
        echo ">".$order."</option>\n";
        $i++;
}
echo "</select></td>\n";



echo "<td><select name=\"ordertype\">".
    "<option value=\"DESC\" ";
    if ($ordertype == "DESC") echo "selected";
    echo " >"._btdesc."</option>".
    "<option value=\"ASC\" ";
    if ($ordertype == "ASC") echo "selected";
    echo " >"._btord."</option>".
    "</select></td>";

echo "<td><p><input type=\"checkbox\" name=\"dead\" ";
if ($dead == "ok") echo "checked";
echo " value=\"ok\">"._btitm."";

echo "</td></tr></table>";
echo "</form>";
if($dead == "ok")
$rssdead = "&dead=ok";
else
$rssdead = "";
echo "<table align=\"right\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\"><tr><td>";
//RDF Button
help(pic("rss.gif","backend.php?op=search&search=".urlencode($search)."&cat=".$cat.$rssdead."&orderby=".$orderby."&ordertype=".$ordertype,null),_btcustomsearchexplain,_btcustomsearch);
echo "<td class=\"smallish\">"._btsearchfeed."</td></tr></table>";
CloseTable();
if(empty($search)) include'footer.php';
$search = unesc($search);


$banwhere = "banned = 'no' AND";
$passwhere = " password IS NULL AND";
if ($user->moderator) $banwhere = "";
if ($user->premium) $passwhere = "";

$totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_torrents WHERE ".$banwhere.$passwhere." ";
$sql = "SELECT ".$db_prefix."_torrents.*, IF(".$db_prefix."_torrents.numratings < '$minvotes', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, ".$db_prefix."_categories.name AS cat_name, ".$db_prefix."_categories.image AS cat_pic, U.username,IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_torrents LEFT JOIN ".$db_prefix."_categories ON category = ".$db_prefix."_categories.id LEFT JOIN ".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id WHERE banned = 'no' ";
if (!empty($search)) {
$search1 = str_replace(" ",".",$search);
$search2 = str_replace(" ","-",$search);
$search3 = str_replace(" ","_",$search);
        $totsql .= ' (search_text LIKE "%'.addslashes(unesc($search)).'%" 
		OR search_text LIKE "%'.addslashes(unesc($search1)).'%" 
		OR search_text LIKE "%'.addslashes(unesc($search2)).'%" 
		OR search_text LIKE "%'.addslashes(unesc($search3)).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.addslashes(unesc($search)).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.addslashes(unesc($search1)).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.addslashes(unesc($search2)).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.addslashes(unesc($search3)).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.addslashes(unesc($search)).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.addslashes(unesc($search1)).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.addslashes(unesc($search2)).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.addslashes(unesc($search3)).'%" 
		OR '.$db_prefix.'_torrents.torrent_descr LIKE "%'.addslashes(unesc($search)).'%" 
		OR '.$db_prefix.'_torrents.torrent_descr LIKE "%'.addslashes(unesc($search1)).'%" 
		OR '.$db_prefix.'_torrents.torrent_descr LIKE "%'.addslashes(unesc($search2)).'%" 
		OR '.$db_prefix.'_torrents.torrent_descr LIKE "%'.addslashes(unesc($search3)).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.addslashes(unesc($search)).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.addslashes(unesc($search1)).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.addslashes(unesc($search2)).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.addslashes(unesc($search3)).'%") 
		';
        $sql .= ' AND (search_text LIKE "%'.addslashes(unesc($search)).'%" 
		OR search_text LIKE "%'.addslashes(unesc($search1)).'%" 
		OR search_text LIKE "%'.addslashes(unesc($search2)).'%" 
		OR search_text LIKE "%'.addslashes(unesc($search3)).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.addslashes(unesc($search)).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.addslashes(unesc($search1)).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.addslashes(unesc($search2)).'%" 
		OR '.$db_prefix.'_torrents.name LIKE "%'.addslashes(unesc($search3)).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.addslashes(unesc($search)).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.addslashes(unesc($search1)).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.addslashes(unesc($search2)).'%" 
		OR '.$db_prefix.'_torrents.descr LIKE "%'.addslashes(unesc($search3)).'%" 
		OR '.$db_prefix.'_torrents.torrent_descr LIKE "%'.addslashes(unesc($search)).'%" 
		OR '.$db_prefix.'_torrents.torrent_descr LIKE "%'.addslashes(unesc($search1)).'%" 
		OR '.$db_prefix.'_torrents.torrent_descr LIKE "%'.addslashes(unesc($search2)).'%" 
		OR '.$db_prefix.'_torrents.torrent_descr LIKE "%'.addslashes(unesc($search3)).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.addslashes(unesc($search)).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.addslashes(unesc($search1)).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.addslashes(unesc($search2)).'%" 
		OR '.$db_prefix.'_torrents.filename LIKE "%'.addslashes(unesc($search3)).'%") 
		';
}

if ($dead != "ok") {
        $sql .= "AND visible = 'yes' ";
        $totsql .= "AND visible = 'yes' ";
}
if ($cat > 0){
        $sql .= "AND ".$db_prefix."_torrents.category = '".$cat."' ";
        $totsql .= "AND ".$db_prefix."_torrents.category = '".$cat."' ";
}
if($catmid){
$sql .= "AND ".$db_prefix."_torrents.category IN ('".$catmain."') ";
$totsql .= "AND ".$db_prefix."_torrents.category IN ('".$catmain."') ";
}

switch ($orderby) {
        case 0: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.added ".$ordertype;
                break;
        }
	case 1: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.seeders ".$ordertype;
                break;
        }
        case 2: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.leechers ".$ordertype;
                break;
        }
        case 3: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.tot_peer ".$ordertype;
                break;
        }
	case 4: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.downloaded ".$ordertype;
                break;
        }
        
        case 5: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.ratingsum ".$ordertype;
                break;
        }
	case 6: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.name ".$ordertype;
                break;
        }
        case 7: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.size ".$ordertype;
                break;
        }
        case 8: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.numfiles ".$ordertype;

                break;
        }
        default: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.id ".$ordertype;
        }
}

$sql .= " LIMIT ".intval($from).", ".intval($torrent_per_page).";";

$res = $db->sql_query($sql) or btsqlerror($sql);
$totres = $db->sql_query($totsql)or btsqlerror($totsql);

        list ($tot) = $db->sql_fetchrow($totres);
        $db->sql_freeresult($totres);

$pages = ceil($tot / $torrent_per_page);
        if ($db->sql_numrows($res) > 0) {

$pageplus = $page + 1;
$pagemin = $page - 1;

if($page < $pages) {
        $next = "<B><a href=\"search.php?";
        if (intval($cat) > 0) $next .= "cat=".intval($cat)."&";
        $next .= "search=".urlencode($search)."&";
        if ($dead == "ok") $next .= "dead=ok&";
        $next .= "orderby=".$orderby."&";
        $next .= "ordertype=".$ordertype."&";
        $next .= "page=$pageplus\">&gt;&gt;&gt;&gt;</a></B>";
} else {
        $next = "&gt;&gt;&gt;&gt;";
}
if($page > 1) {
        $prev = "<B><a href=\"search.php?";
        if (intval($cat) > 0) $prev .= "cat=".intval($cat)."&";
        $prev .= "search=".urlencode($search)."&";
        if ($dead == "ok") $prev .= "dead=ok&";
        $prev .= "orderby=".$orderby."&";
        $prev .= "ordertype=".$ordertype."&";
        $prev .= "page=$pagemin\">&lt;&lt;&lt;&lt;</a></B>";
} else {
        $prev = "&lt;&lt;&lt;&lt;";
}
if($pages >1 ){
        $pager .= "<a href=\"search.php?";
        if (intval($cat) > 0) $pager .= "cat=".intval($cat);
        $pager .= "search=".$search."&";
        if ($dead == "ok") $pager .= "dead=ok&";
        $pager .= "orderby=".$orderby."&";
        $pager .= "ordertype=".$ordertype;
        $pager .= "\">".(($page == 1) ? "<b>1</b>" : "1")."</a>&nbsp;";

                if (($page - 15) > 1) $pager .= "...";

                for ($i = max(2,$page - 15); $i < min($pages, $page + 15); $i++) {
        $pager .= "<a href=\"search.php?";
        if (intval($cat) > 0) $pager .= "cat=".intval($cat);
        $pager .= "search=".$search."&";
        if ($dead == "ok") $pager .= "dead=ok&";
        $pager .= "orderby=".$orderby."&";
        $pager .= "ordertype=".$ordertype."&";
        $pager .= "page=".$i."\">".(($i == $page) ? "<b>".$i."</b>" : $i)."</a>&nbsp;";
}
                if (($page + 15) < $pages) $pager .= "...";

        $pager .= "<a href=\"search.php?";
        if (intval($cat) > 0) $pager .= "cat=".intval($cat);
        $pager .= "search=".$search."&";
        if ($dead == "ok") $pager .= "dead=ok&";
        $pager .= "orderby=".$orderby."&";
        $pager .= "ordertype=".$ordertype."&";
        $pager .= "page=".$pages."\">".(($page == $pages) ? "<b>".$pages."</b>" : $pages)."</a>&nbsp;";
}
torrenttable($res);
$db->sql_freeresult($res);
echo "<table border=\"0\" width=\"100%\"><tr><td align=\"left\"><p>".$prev."</p></td><td align=\"center\"><p>".$pager."</p></td><td align=\"right\"><p>".$next."</p></td></tr></table>";
        } else {
                OpenTable2();
                echo "<h3>"._btnotorrents."</h3>";
                CloseTable2();
        }


include("footer.php");
?>