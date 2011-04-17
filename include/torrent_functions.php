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
function generate_torrentpager($link, $page, $pages, $cat = false, $sort1 = '', $sort2 = '', $extra = ''){
global $template;
           $template->assign_vars(array(
		   'TOTTAL_PAGES'.$extra  =>  $pages,
		   'CURENT_PAGE'.$extra  =>  $page,
		   ));

				if($page < $pages AND $cat) {
           $template->assign_vars(array(
		   'NEXT_PAGE'.$extra  =>  ($page+1)."&cat=".$cat.$sort1,
		   ));
                } elseif($page < $pages ) {
           $template->assign_vars(array(
		   'NEXT_PAGE'.$extra  =>  ($page+1).$sort1,
		   ));
						
                }else{
           $template->assign_vars(array(
		   'NEXT_PAGE'.$extra  =>  false,
		   ));
				}
				if($page > 1 AND $cat) {
           $template->assign_vars(array(
		   'PREV_PAGE'.$extra  =>  "page=".($page-1)."&cat=".$cat.$sort1,
		   ));
                } elseif($page > 1) {
           $template->assign_vars(array(
		   'PREV_PAGE'.$extra  =>  ($page-1).$sort1,
		   ));
						
                }else{
           $template->assign_vars(array(
		   'PREV_PAGE'.$extra  =>  false,
		   ));
				}
                if($cat){
                $pager = "<a href=\"" . $link . "".$cat.$sort1."\">".(($page == 1) ? "<strong>1</strong>" : "1")."</a><span class=\"page-sep\">, </span>";

                if (($page - 5) > 1) $pager .= "...";

                for ($i = max(2,$page - 5); $i < min($pages, $page + 5); $i++) {
                        $pager .= "<a href=\"" . $link . "".$i."&cat=".$cat.$sort1."\">".(($i == $page) ? "<strong>".$i."</strong>" : $i)."</a><span class=\"page-sep\">, </span>";
                }
                if (($page + 5) < $pages) $pager .= "...";
                $pager .= "<a href=\"" . $link . "".$pages."&cat=".$cat.$sort1."\">".(($page == $pages) ? "<strong>".$pages."</strong>" : $pages)."</a>";
           $template->assign_vars(array(
		   'GENERATED_PAGES'.$extra  =>  "<span>".(($pages > 1) ? $pager : "")."</span>",
		   ));
				}else {
                $pager = "<a href=\"" . $link . "".$sort2."\">".(($page == 1) ? "<strong>1</strong>" : "1")."</a><span class=\"page-sep\">, </span>";

                if (($page - 5) > 1) $pager .= "...";

                for ($i = max(2,$page - 5); $i < min($pages, $page + 5); $i++) {
                        $pager .= "<a href=\"" . $link . "".$i.$sort1."\">".(($i == $page) ? "<strong>".$i."</strong>" : $i)."</a><span class=\"page-sep\">, </span>";
                }
                if (($page + 5) < $pages) $pager .= "...";
                $pager .= "<a href=\"" . $link . "".$pages.$sort1."\">".(($page == $pages) ? "<strong>".$pages."</strong>" : $pages)."</a>";
           $template->assign_vars(array(
		   'GENERATED_PAGES'.$extra  =>  "<span>".(($pages > 1) ? $pager : "")."</span>",
		   ));
				}
}
function get_tor_vars($res, $variant = "index", $user = "", $block = "", $extra = '') {
        global $db, $template, $name, $search, $user, $download_level, $torrent_global_privacy, $onlysearch, $db_prefix, $autoscrape, $theme, $btback1, $btback2, $btback3, $free_dl,$page, $prev, $pages, $pager, $next;
        while ($row = $db->sql_fetchrow($res))
		{       #Category
                if (isset($row["cat_name"])) {
                        if (isset($row["cat_pic"]) AND $row["cat_pic"] != "" AND is_readable("themes/".$theme."/pics/cat_pics/".$row["cat_pic"]))
                                $catigory = "<img border=\"0\" src=\"themes/" . $theme . "/pics/cat_pics/". $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" >";
                                elseif (isset($row["cat_pic"]) AND $row["cat_pic"] != "" AND is_readable("cat_pics/".$row["cat_pic"]))
                                $catigory =  "<img border=\"0\" src=\"cat_pics/" . $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" >";
                        else
                                $catigory =  $row["cat_name"];
                } else $catigory =  "-";
				#ShortName
                $dispname = htmlspecialchars($row["name"]);
                $dispname = str_replace("_", " ", $dispname);
                $dispname = str_replace(".", " ", $dispname);
                //Permission Administration
				$auth_link = '';
                if ($torrent_global_privacy AND $user->user AND $row["type"] != "link") {
                        if ($row["owner"] == $user->id) {
                                $pic = "auth_none.gif";
                                $authsql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row["id"]."' AND status = 'pending';";
                                $authres = $db->sql_query($authsql) or btsqlerror($authsql);
                                if ($db->sql_numrows($authres) > 0) $pic = "auth_pending.gif";
                                $auth_link = pic($pic,"mytorrents.php?op=displaytorrent&id=".$row["id"]);
                        } elseif (!can_download($user,$row)) {
                                $authres = $db->sql_query("SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row["id"]."' AND slave = '".$user->id."' LIMIT 1;");
                                if ($db->sql_numrows($authres) == 0) $auth_link = pic("lock_request.gif","details.php?op=authorization&id=".$row["id"],_btalt_lock_request);
                                else $auth_link = pic("lock.gif",null,_btalt_lock);
                        }
                }
				#Rating
                if (!isset($row["rating"]))
                        $rating = "---";
                else {
                        $rating = round($row["rating"] * 2) / 2;
                        $rating = ratingpic($row["rating"]);
                        if (!isset($rating))
                                $rating = "---";
                }
				#Snatched
                $totsql = "SELECT count(`torrentid`)as `snatch` FROM `torrent_snatched` WHERE `torrentid` = '".$row["id"]."'";
                $totres = $db->sql_query($totsql);
                $sncount = $db->sql_fetchrow($totres);
				#Peer speed
				$speed_leech = "--";
				$edt = "--";
                if ($row["type"] != "link" AND $row["tracker"] == "") {
                        if ($row["leechers"] > 0 AND $row["speed"] > 0) {
                                $ro = $row["seeders"]/$row["leechers"];
                                $speed_leech = ($ro == 0) ? round($row["speed"]/$row["leechers"]) : min($row["speed"],round($row["speed"]*$ro));
                                $edt_m = ($row["size"] / $speed_leech)/60; //to minutes
                                $edt = ($edt_m % 60)."m"; //minutes
                                $edt_h = floor($edt_m / 60);
                                if ($edt_h>0) $edt = $edt_h."h ".$edt;
                                $speed_leech = mksize($speed_leech)."/s";
                        } else {
                                $speed_leech = "--";
                                $edt = "--";
                        }
                }

		if ($row["tracker"] != "") {
			if ($user->user){
				if (time()- sql_timestamp_to_unix_timestamp($row["tracker_update"])> 1800) {
				$refreshable = true;
				}else{
				$refreshable = false;
				}
			}elseif ($user->moderator){
				$refreshable = true;
			}else{
				$refreshable = false;
               		}
		}
$can_edit=true;
$can_delete=true;
$can_ban = false;
if ($row['owner'] == $user->id AND !checkaccess("edit_own_torrents"))
{
$can_edit=false;
} 
if ($row['owner'] == $user->id AND !checkaccess("delete_own_torrents"))
{
$can_delete=false;
} 
if ($row['owner'] != $user->id AND !checkaccess("delete_others_torrents"))
{
$can_delete=false;
} 
if ($row['owner'] != $user->id AND !checkaccess("can_edit_others_torrents"))
{
$can_edit=false;
} 
if (checkaccess("bann_torrents"))$can_ban = true;
           $template->assign_block_vars('torrent_var'.$extra, array(
		   'ID'          => $row["id"],
		   'CAN_EDIT'    => ($can_edit) ? true : false,
		   'CAN_DEL'     => ($can_delete) ? true : false,
		   'CAN_BAN'     => ($can_ban) ? true : false,
		   'CAT_ID'      => $row["category"],
		   'CATEGORY'    => $catigory,
		   'REFRESH_T'   => $refreshable,
		   'FREE_DL'     => ($row["ratiobuild"] == "yes" || $free_dl) ? true : false,
		   'NUKED'       => ($row["nuked"] == "yes") ? true : false,
		   'EVIDENCE'    => ($row["evidence"] != 0) ? true :false,
		   'BANNED'      => ($row["banned"] == "yes") ?  true : false,
		   'LINK'        => ($row["type"]=="link") ? true : false,
		   'TRACKER_URL' => $row["tracker"],
		   'LOCAL_T'     => ($row["tracker"] != "" AND $row["tracker"] != "dht:") ? false : true,
		   'DHT_INABLED' => ($row["dht"] == "yes") ? true : false,
		   'SHORTNAME'   => ((strlen($dispname) <= 21) ? search_word($dispname, $search): search_word(substr($dispname,0,20)."...", $search)),
		   'FULL_NAME'   => $dispname,
		   'HIT_COUNT'   => ($row["owner"] != $user->id) ? true: false,
		   'CAN_DOWN_LOAD' => ((checkaccess("download")) AND $row["type"] != "link") ? true : false,
		   'PEERS_UPDATE'  => (($row["tracker"] != "") AND (time()- sql_timestamp_to_unix_timestamp($row["tracker_update"])> 1800)) ? true : false,
		   'LAST_TIME_SCR' => get_formatted_timediff(sql_timestamp_to_unix_timestamp($row["tracker_update"])),
		   'AUTH_LINK'     => $auth_link,
		   'NEED_AUTH'     => ($torrent_global_privacy AND $user->user AND $row["type"] != "link") ? true : false,
		   'MULTY_FILES'   => ($row["type"] == "single" OR $row["numfiles"] <= 1) ? false : true,
		   'NUM_FILE'      => $row["numfiles"],
		   'NUM_COMENTS'   => $row["comments"],
		   'RATEING_PIC'   => $rating,
		   'DATE_ADDED'    => $row['added'],
		   'TIMES_SNATHED' => $sncount['snatch'],
		   'DOWNLOAD_SP'   => mksize($row["speed"]),
		   'DOWNLOAD_SIZE' => mksize($row["size"]),
		   'SEEDERS'       => $row["seeders"],
		   'LEECHERS'      => $row["leechers"],
		   'TOTAL_SPEED'   => $speed_leech,
		   'EST_DL_SPD'    => $edt,
		   'ANONUMUS_UPLO' => (isset($row["username"]) AND $row["ownertype"]==0) ? false : true,
		   'UPLOADERS_NAM' => ($row['owner'] == 0) ? _btunknown : username_is($row['owner']),
		   'UPLODER_ID'    => $row['owner'],
		   'UPLDER_COLOR'  => getusercolor(getlevel_name($row['owner'])),
           ));
}
return;
}
?>