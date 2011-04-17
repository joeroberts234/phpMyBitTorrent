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

if (eregi("shoutbox.php",$_SERVER["PHP_SELF"])) die("You can't access this file directly");
include("header.php");
if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
$from = ($page - 1) * 10;

$lookfor = "";
if($search[phrase] == "")
{
$searchword ="";
$searchwordpage = "";
}else{
$searchword = " AND text LIKE ('%".addslashes(searchfield($search[phrase]))."%')";
$searchwordpage = "&amp;search[phrase]=".$search[phrase];
}
$uidsearch = "";
$uidsearchpage = "";
if(!$search[username] == "")
{
        $sql = "SELECT id FROM ".$db_prefix."_users WHERE clean_username LIKE '%".addslashes($search[username])."%';";
        $res = $db->sql_query($sql);
		$useridaray = array();
		while ($useid=$db->sql_fetchrow($res)) {
		
		$useridaray[] = $useid[id];
		
		}
        $db->sql_freeresult($res);
		//print_r($useridaray);
		$uidsearch ="AND user IN ( '".implode("','",$useridaray)."')";
		$uidsearchpage = "&amp;search[username]=".$search[username];

}
if(!$search['time'] == "") 
{
$searchtime = "UNIX_TIMESTAMP(posted) > UNIX_TIMESTAMP(NOW()) - (".$search['time']." * 60 * 60)";
$searchtimepage = "&amp;search[time]=".$search['time'];
}else{
$searchtime = "";
$searchtimepage = "";
}
//echo $searchtime;
if($search['sort'] == "")$sort = "DESC";
elseif($search['sort'] == "new")$sort = "DESC";
elseif($search['sort'] == "old")$sort = " ASC";
if(isset($search))
{
 $lookforpage = $searchtimepage.$searchwordpage.$uidsearchpage;
 $lookfor = "WHERE ".$searchtime.$searchword.$uidsearch;
  $lookforcount = $searchtime.$searchword.$uidsearch." AND ";


 }
?>
<form method="post" action="shoutboxarchive.php">
<input type="hidden" name="do" value="archive" />
<input type="hidden" name="search" value="1" />

<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">

<tr>
	<td width="70%" align='left' valign='top'>
		<table class="tborder" cellpadding="6" cellspacing="0" border="0" width="100%" align="center">
		<tr>
			<td class="tcat" align="left">
				Shoutbox Archive
			</td>
		</tr>
<?php
$utc2 = $btback1;
                $totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_shouts WHERE ".$lookforcount."(id_to = '0' OR id_to = '".$user->id."');";
				        $totres = $db->sql_query($totsql)or btsqlerror($totsql);;
				        list ($tot) = $db->sql_fetchrow($totres);
                        $db->sql_freeresult($totres);
$pages = ceil($tot / 10);
$pageplus = $page + 1;
$pagemin = $page - 1;
//$i = 0;
$pager = "<td class=\"alt1\"><a rel=\"nofollow\" class=\"smallfont\"  href=\"shoutboxarchive.php?page=1".$lookforpage."\">".(($page == 1) ? "<strong>1</strong>" : "1")."</a></td>&nbsp;\n";
if (($page - 5) > 1) $pager .= "<td class=\"alt1\">...</td>&nbsp;\n";

for ($i = max(2,$page - 5); $i < min($pages, $page + 5); $i++) {
        $pager .= "<td class=\"alt1\"><a rel=\"nofollow\" class=\"smallfont\" href=\"shoutboxarchive.php?page=".$i.$lookforpage."\">".(($i == $page) ? "<strong>".$i."</strong>" : $i)."</a></td>&nbsp;\n";
}

if (($page + 5) < $pages) $pager .= "<td class=\"alt1\">...</td>&nbsp;\n";
$pager .= "<td class=\"alt1\"><a rel=\"nofollow\" class=\"smallfont\" href=\"shoutboxarchive.php?page=".$pages.$lookforpage."\">".(($page == $pages) ? "<strong>".$pages."</strong>" : $pages)."</a></td>\n";
                $totsql1 = "SELECT COUNT(*) as tot1 FROM ".$db_prefix."_shouts WHERE UNIX_TIMESTAMP(posted) > UNIX_TIMESTAMP(NOW()) - 86400;";
				        $totres1 = $db->sql_query($totsql1);
				        list ($tot1) = $db->sql_fetchrow($totres1);
                        $db->sql_freeresult($totres1);
                $totsql2 = "SELECT COUNT(*) as tot2 FROM ".$db_prefix."_shouts WHERE user = '".$user->id."';";
				        $totres2 = $db->sql_query($totsql2);
				        list ($tot2) = $db->sql_fetchrow($totres2);
                        $db->sql_freeresult($totres2);
               $sql = "SELECT S.*, U.id as uid, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id ".$lookfor." ORDER BY posted ".$sort." LIMIT ".$from.",10;";
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
$num2s = $db->sql_numrows($shoutres);
                if ($num2s > 0) {
                        while ($shout = $db->sql_fetchrow($shoutres)) {

if ($num2s > 1)
{
$ucs++;
}
if($ucs%2 == 0)
$utc2 = $btback1;
else
$utc2 = $btback2;
$i++;
						$caneditshout = false;
if ($user->admin) $caneditshout = true;
if ($user->id == $shout['uid']) $caneditshout = true;
$shoutdelete = "";
$shoutedit = "";
if($caneditshout)
{
$shoutdelete = "<span onclick=\"if(confirm('Delete Shout?')==true) sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shout_row_".$shout['id']."')\">Delete</span>";
$shoutedit = "<span ondblclick=\"sndReq('op=edit_archive_shout&shout=".$shout['id']."', 'shout_archive_edit_".$shout['id']."')\">Edit</span>";
}
if ($shout['id_to']!=0){
if ($user->id == $shout['id_to'] OR $user->id == $shout['uid']){
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
		
?>
		<!-- BEGIN TEMPLATE: inferno_shoutbox_archive_shout -->

<tbody id="shout_row_<?=$shout['id']?>">
<tr>
	<td class="thead" align="left">
		<span style='float:right'><?=$shout_time?></span>
		<a href="user.php?op=profile&id=<?=$shout["uid"]?>"><span class="<?=$shout["level"]?>"><?=htmlspecialchars($shout["user_name"])?></span></a> (<?=$shoutedit?> &middot; <?=$shoutdelete?>) 
	</td>

</tr>
<tr>
	<td class="alt1" width="1%" align="left" id="shout_shell_<?=$shout['id']?>">

		<div id="shout_<?=$shout['id']?>">
		
			[PM]<?=$text?>
		
		</div>
		</div>
		<div id="shout_archive_edit_<?=$shout['id']?>">
		</div>

	</td>
</tr>
</tbody>
<?php
								}
								}
								if ($shout['id_to']==0){
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
?>
		<!-- BEGIN TEMPLATE: inferno_shoutbox_archive_shout -->

<tbody id="shout_row_<?=$shout['id']?>">
<tr>
	<td class="thead" align="left">
		<span style='float:right'><?=$shout_time?></span>
		<a href="user.php?op=profile&id=<?=$shout["uid"]?>"><span class="<?=$shout["level"]?>"><?=htmlspecialchars($shout["user_name"])?></span></a> (<?=$shoutedit?> &middot; <?=$shoutdelete?>) 
	</td>

</tr>
<tr>
	<td class="alt1" width="1%" align="left" id="shout_shell_<?=$shout['id']?>">

		<div id="shout_<?=$shout['id']?>">
		
			<?=$text?>
		
		</div>
		<div id="shout_archive_edit_<?=$shout['id']?>">
		</div>

	</td>
</tr>
</tbody>
<?php
								}
								
								
                        }
                } else {
                        echo "<p align=\"center\">"._btnoshouts."</p>\n";
                }
                $db->sql_freeresult($shoutres);
				if($searchtime == "")$search['time'] = 10;

?>

<!-- END TEMPLATE: inferno_shoutbox_archive_shout -->
		</table>

	</td>
	<td>&nbsp;&nbsp;</td>
	<td width='30%' align='right' valign='top'>
		<table class="tborder" cellpadding="6" cellspacing="0" border="0" width="100%" align="center">
		<thead>
		<tr>
			<td class="tcat" align="left" colspan="2">
				<a style="float:right" href="#top" onclick="return toggle_collapse('infernoshout_stats')"><img id="collapseimg_infernoshout_stats" src="http://bvlist.com/images/styles/versionj/buttons/collapse_tcat.gif" alt="" border="0" /></a>
				Statistics
			</td>

		</tr>
		</thead>
		<tbody id="collapseobj_infernoshout_stats" style="">
		<tr>
			<td class="alt1" align="left">
				<b>Total shouts posted:</b>
			</td>
			<td class="alt2" width="1%" align="left">

				<?php echo $tot; ?>
			</td>
		</tr>
		<tr>
			<td class="alt1" align="left">
				<b>Shouts in past 24 hours:</b>
			</td>
			<td class="alt2" width="1%" align="left">
				<?php echo $tot1; ?>		
			</td>

		</tr>
		<tr>
			<td class="alt1" align="left">
				<b>Your shouts:</b>
			</td>
			<td class="alt2" width="1%" align="left">
				<?php echo $tot2; ?>
			</td>
		</tr>

		</tbody>
		
		<tr>
			<td class="thead" align="left" colspan="2">
				<a style="float:right" href="#top" onclick="return toggle_collapse('infernoshout_stats_search')"><img id="collapseimg_infernoshout_stats_search" src="http://bvlist.com/images/styles/versionj/buttons/collapse_thead.gif" alt="" border="0" /></a>
				Search Shouts
			</td>
		</tr>
		<tbody id="collapseobj_infernoshout_stats_search" style="">
		<tr>

			<td class="alt1" align="left" colspan="2" valign="middle" style="white-space: nowrap;">
				<fieldset class="fieldset">
					<legend>Search Terms</legend>

					<table cellpadding="0" cellspacing="4" border="0" width="100%">
					<tr>
						<td style="white-space: nowrap;"><b>Shout Contains:</b></td>
						<td><input type="text" name="search[phrase]" value="<?=$search[phrase]?>" size="25" class="bginput" /></td>

					</tr>
					<tr>
						<td style="white-space: nowrap;"><b>Username Contains:</b></td>
						<td><input type="text" name="search[username]" value="<?=$search[username]?>" size="25" class="bginput" /></td>
					</tr>
					<tr>
						<td style="white-space: nowrap;"><b>Within Past <em>X</em> Hours:</b></td>

						<td><input type="text" name="search[time]" value="<?=$search['time']?>" size="2" class="bginput" /></td>
					</tr>
					<tr>
						<td style="white-space: nowrap;"><b>Sort Results By:</b></td>
						<td>
							<span style="float: right"><input type="submit" class="button" value="Search" /></span>
							<select class="bginput" name="search[sort]">
								<option value="new">Newest First</option>

								<option value="old">Oldest First</option>
							</select>
						</td>
					</tr>
					</table>
				</fieldset>
			</td>
		</tr>

		</tbody>
		
		<tr>
			<td class="thead" align="left" colspan="2">
				<a style="float:right" href="#top" onclick="return toggle_collapse('infernoshout_stats_top10')"><img id="collapseimg_infernoshout_stats_top10" src="http://bvlist.com/images/styles/versionj/buttons/collapse_thead.gif" alt="" border="0" /></a>
				Top 15 Shouters
			</td>
		</tr>
		<tbody id="collapseobj_infernoshout_stats_top10" style="">
<?php

                $topsql = "SELECT S.user, COUNT(S.text) as topshout, U.id as uid, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id GROUP BY user ORDER BY topshout DESC LIMIT 15;";
				        $topres = $db->sql_query($topsql);
						$topshout = 0;
						    while ($topshouter = $db->sql_fetchrow($topres)){
							++$topshout;

?>
		<!-- BEGIN TEMPLATE: inferno_shoutbox_archive_topshouter -->

<tr>
	<td class="alt1" align="left">
		<a href="user.php?op=profile&id=<?=$topshouter["uid"]?>"><span class="<?=$topshouter["level"]?>"><?php echo $topshouter[user_name]; ?></span></a>
	</td>
	<td class="alt2" width="1%" align="left">
		<?php echo $topshouter[topshout]; ?>
	</td>
</tr>
<?php
}
$db->sql_freeresult($topres);
?>
<!-- END TEMPLATE: inferno_shoutbox_archive_topshouter --><!-- BEGIN TEMPLATE: inferno_shoutbox_archive_topshouter -->
		</tbody>

		</table>
	</td>
</tr>
</table>
</form>
<!-- BEGIN TEMPLATE: pagenav -->
<div class="pagenav" align="right">
<table class="tborder" border="0" cellpadding="3" cellspacing="0">
<tbody><tr>
	<td class="vbmenu_control" style="font-weight: normal;">Page <?=$page?> of <?=$pages?></td>
<?php
if($page > 1){
?>
	<td class="alt1"><a rel="prev" class="smallfont" href="shoutboxarchive.php?page=<?=$page-1?>" title="Prev Page - Results 1 to 10 of 1,966">&lt;</a></td>
<?php
}
?>

<?=$pager?>
<!-- END TEMPLATE: pagenav_pagelinkrel -->
<?php
if($pages > 1 AND $page != $pages){
?>
	<td class="alt1"><a rel="next" class="smallfont" href="shoutboxarchive.php?page=<?=$page+1?>" title="Next Page - Results 11 to 20 of 1,957">&gt;</a></td>
	<td class="alt1" nowrap="nowrap"><a rel="nofollow" class="smallfont" href="shoutboxarchive.php?page=<?=$pages?>" title="Last Page - Results 1,951 to 1,957 of 1,957">Last <strong>>></strong></a></td>
<?php
}
?>
	<td style="cursor: pointer;" id="pagenav.127" class="vbmenu_control" title=""> <img alt="" title="" src="http://bvlist.com/images/styles/versionj/misc/menu_open.gif" border="0"></td>

</tr>
</tbody></table>
</div>
<!-- END TEMPLATE: pagenav -->

<?php
include ("footer.php");
?>