<?php
/*
*------------------------------phpMyBitTorrent V 2.0.5-------------------------* 
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 14, 2010 9:05 PM   ------------------------*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
$startpagetime = microtime();
require_once("common.php");
require_once("include/torrent_functions.php");
if($pivate_mode AND !$user->user AND !preg_match("/user.php/",$_SERVER["PHP_SELF"])){
header("Location: ".$siteurl."/login.php");
die();
 }
if ($user->moderator)$catmain = '1';
$template = & new Template();
set_site_var('Browse');
require_once('actb.php');
pmbt_include_templ('blocks/search_block.php', 'cats_var');
$sort											= request_var('sort', '');
$type											= request_var('type', '');
$orderby = " ORDER BY ".$db_prefix."_torrents.evidence DESC, ";//
if ($sort == 1) $orderby = " ORDER BY ".$db_prefix."_torrents.name $type,  ";//

if ($sort == 2){
$orderby = " ORDER BY ".$db_prefix."_torrents.numfiles $type,  ";//
}
if ($sort == 3){
$orderby = " ORDER BY ".$db_prefix."_torrents.comments $type,  ";//
}
if ($sort == 4){
$orderby = " ORDER BY ".$db_prefix."_torrents.category $type,  ";//
}
if ($sort == 5){
$orderby = " ORDER BY ".$db_prefix."_torrents.size $type,  ";
}
if ($sort == 6){
$orderby = " ORDER BY ".$db_prefix."_torrents.times_completed $type,  ";
}
if ($sort == 7){
$orderby = " ORDER BY ".$db_prefix."_torrents.seeders $type,  ";//
}
if ($sort == 8){
$orderby = " ORDER BY ".$db_prefix."_torrents.leechers $type,  ";//
}
        if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
        if (!isset($cat)) $cat = "";
        if (intval($cat) > 0) $catwhere = " AND ".$db_prefix."_torrents.category = ".intval($cat);
        else $catwhere = "";
        $passwhere = " AND ".$db_prefix."_torrents.password IS NULL ";
        $viswhere = "visible = 'yes' AND banned = 'no'";
        if ($user->moderator) $viswhere = "";
        if ($user->premium) $passwhere = "";

        $from = ($page - 1) * $torrent_per_page;

        $totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_torrents WHERE ".$catmain.$viswhere.$catwhere.$passwhere.";";
        $sql = "SELECT ".$db_prefix."_torrents.*, IF(".$db_prefix."_torrents.numratings < '".$minvotes."', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, ".$db_prefix."_categories.name AS cat_name, ".$db_prefix."_categories.image AS cat_pic, U.username, IF(U.name IS NULL, U.username, U.name) as user_name, U.level as user_level, U.can_do as can_do FROM ".$db_prefix."_torrents LEFT JOIN ".$db_prefix."_categories ON category = ".$db_prefix."_categories.id LEFT JOIN ".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id WHERE ".$catmain.$viswhere.$catwhere.$passwhere.$orderby.$db_prefix."_torrents.added DESC LIMIT ".$from.",".$torrent_per_page.";";

        $res = $db->sql_query($sql) or btsqlerror($sql);
        $totres = $db->sql_query($totsql);

if (isset($sort))
{
$sort1= "&sort=".$sort."&type=".$type;
$sort2= "?sort=".$sort."&type=".$type;
}
else
{
$sort1="";
$sort2="";
}
        list ($tot) = $db->sql_fetchrow($totres);
        $db->sql_freeresult($totres);
        if ($db->sql_numrows($res) > 0) {
                $template->assign_vars(array(
                        'S_TORRENTS'            => true,
                ));
                $pages = ceil($tot / $torrent_per_page);
                generate_torrentpager('torrents.php?page=', $page, $pages, $cat , $sort1 , $sort2 );
                get_tor_vars($res);
        }
		else
		{
		                $template->assign_vars(array(
                        'S_TORRENTS'            => false,
                ));
		}
$template->assign_vars(array(
        'S_GENTIME'            => abs(round(microtime()-$startpagetime,2)),
		'HIT_COUNT'            => ($user->admin) ? false : true,
));
echo $template->fetch('torrents_body.html');
if ($user->user) {
        //Update online user list
        $pagename = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
        $sqlupdate = "UPDATE ".$db_prefix."_online_users SET page = '".addslashes($pagename)."', last_action = NOW() WHERE id = ".$user->id.";";
        $sqlinsert = "INSERT INTO ".$db_prefix."_online_users VALUES ('".$user->id."','".addslashes($pagename)."', NOW(), NOW())";
        $res = $db->sql_query($sqlupdate);
        if (!$db->sql_affectedrows($res)) $db->sql_query($sqlinsert);
$ip = getip();
        $sql = "UPDATE ".$db_prefix."_users SET lastip = '".sprintf("%u",ip2long($ip))."', lasthost = '".gethostbyaddr($ip)."', lastpage = '".addslashes(str_replace("/", '',$_SERVER['REQUEST_URI']))."', lastlogin = NOW() WHERE id = '".$user->id."';";
        $db->sql_query($sql);
}
@include_once("include/cleanup.php");
ob_end_flush();
die();
?>