<?php
/*
*-----------------------------phpMyBitTorrent V 2.0.5--------------------------*
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
$startpagetime = microtime();
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("include/config.php"); //if config file has not been loaded yet
include'include/class.template.php';
require_once("include/actions.php");
if($pivate_mode AND !$user->user){
header("Location: ".$siteurl."/login.php");
die();
}
$template = & new Template();
set_site_var('Index');
$player = $user->id;
$act			= request_var('act', '');
if(isset($act) AND $act=="Arcade")
{
  if($gname == "asteroids")
  {
 $game = 1;
 $level = 1;
 $score = $_POST['score'];
  }
  if($gname == "breakout")
  {
 $game = 2;
 $level = 1;
 $score = $_POST['gscore'];
  }
  if($gname == "hexxagon")
  {
 $game = 3;
 $level = 1;
 $score = $_POST['gscore'];
  }
  if($gname == "invaders")
  {
 $game = 4;
 $level = 1;
 $score = $_POST['score'];
  }
  if($gname == "moonlander")
  {
 $game = 5;
 $level = 1;
 $score = $_POST['gscore'];
  }
  if($gname == "pacman")
  {
 $game = 6;
 $level = 1;
 $score = $_POST['gscore'];
  }
  if($gname == "psol")
  {
 $game = 7;
 $level = 1;
 $score = $_POST['gscore'];
  }
  if($gname == "simon")
  {
 $game = 8;
 $level = 1;
 $score = $_POST['gscore'];
  }
  if($gname == "snake")
  {
 $game = 9;
 if($_POST['levelName'] == "LEVEL: SLUG")
 {
   $level = 1;
 }
 if($_POST['levelName'] == "LEVEL: WORM")
 {
   $level = 2;
 }
 if($_POST['levelName'] == "LEVEL: PYTHON")
 {
   $level = 3;
 }
 $score = $_POST['score'];
  }
  if($gname == "tetris")
  {
 $game = 10;
 $level = $_POST['level'];
 $score = $_POST['gscore'];
  }
$db->sql_query("INSERT INTO `".$db_prefix."_flashscores` ( `ID` , `game` , `user` , `level` , `score`, `date`) VALUES ( '', '".$game."', '".$player."', '".$level."', '".$score."', '" . get_date_time() . "');") OR DIE(MySQL_ERROR());
$urlc="flashscores.php";
 print("<html><head><meta http-equiv=refresh content='0;url=$urlc'></head></html>\n");
 die;
}
// ---- Set Shoutbox ---//
$shoutannounce = format_comment($shout_config['announce_ment'], false, true);
parse_smiles($shoutannounce);
$template->assign_vars(array(
        'SHOUT_WELCOME'            => $shoutannounce,
		'S_SHOUTBOX_AJAX'		   => false,
));
	$ucs = 0;
	$i = 0;
     $utc2 = $btback1;
     $utc3 = "even";
                $sql = "SELECT S.*, U.id as uid, U.can_do as can_do, U.donator AS donator, U.warned as warned, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id WHERE S.id_to = '0' OR S.id_to = '".$user->id."' OR (S.user = '".$user->id."' AND S.id_to  >'0')  ORDER BY  posted DESC LIMIT ".$shout_config['shouts_to_show']."";
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
                $num2s = $db->sql_numrows($shoutres);
                if ($num2s > 0) {
                        while ($shout = $db->sql_fetchrow($shoutres)) {
						if ($num2s > 1)
						{
						  $ucs++;
						}
						  if($ucs%2 == 0)
						{
						  $utc3 = "od";
						  $utc2 = $btback1;
						}
						else
						{
						  $utc3 = "even";
						  $utc2 = $btback2;
						}
						$i++;
						$caneditshout = $candeleteshout = false;
						if ($user->moderator) $caneditshout = $candeleteshout = true;
						if ($user->id == $shout['uid'] AND $shout_config['canedit_on'] =="yes") $caneditshout = true;
						if ($user->id == $shout['uid'] AND $shout_config['candelete_on'] =="yes") $candeleteshout = true;
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								$showusername = true;
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                if(preg_match("/\/notice (.*)/",$text,$m)){
								$text = preg_replace('/\/notice/','',$text);
								$showusername = false;
								}
                                if(preg_match("/\/me (.*)/",$text,$m)){
								$text = "<b><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></b> ".preg_replace('/\/me/','',$text);
								$showusername = false;
								}
                $template->assign_block_vars('shout_var', array(
                   'SHOUTID'      => $shout["id"],
                   'QUOTE'      => '[quote]'.addslashes($shout["text"]).'[/quote]',
                   'SHOUT'      => $text,
                   'SHOW_USER'  => $showusername,
                   'TIME'       => $shout_time,
                   'UID'        => $shout['uid'],
                   'U_NAME'     => htmlspecialchars($shout["user_name"]),
                   'U_PRVATE_S' => (!$shout['id_to'] =='0') ? _btprivates : '' ,
                   'U_DONER'    => ($shout['donator'] == 'true') ? true : false,
                   'U_WARNED'   => ($shout["warned"] == "1") ? '<img src="images/warning.gif" title="warned" alt="warned" />' : '',
                   'U_COLOR'    => getusercolor($shout["can_do"]),
                   'BACKG'      => $utc2,
                   'CLASS'      => $utc3,
                   'CLASS_CH'   => $btback2,
                   'CAN_ED'     => $caneditshout,
                   'CAN_DEL'    => $candeleteshout,
                   'CAN_QU'    => $shout_config['candelete_on']
                	));
                     }
                } else {
                }
$birthday_list = '';
$now = getdate(time() - date('Z'));
$sql = "SELECT * FROM ".$db_prefix."_users WHERE ban = '0' AND birthday LIKE '" . $now['mday']."-". $now['mon']."-" . "%'";
	$result = $db->sql_query($sql) or btsqlerror($sql);
	while ($row = $db->sql_fetchrow($result))
	{
		if($row["donator"] == 'true')$donator = true;
		else
		$donator = false;
$img = '';
                if ($row["level"] == "premium") $img .= pic("icon_premium.gif",'','premium');
                elseif ($row["level"] == "moderator") $img .= pic("icon_moderator.gif",'','moderator');
                elseif ($row["level"] == "admin") $img .= pic("icon_admin.gif",'','admin');
				if($donator) $img .= '<img src="images/donator.gif" height="16" width="16" title="donator" alt="donator" />';
		        if($row["warned"] == "1") $img .= '<img src="images/warning.gif" title="warned" alt="warned" />';
		
		$name = ($row['name'] == '' ? $row['username'] : $row['name']);
		$birthday_list .= (($birthday_list != '') ? ', ' : '') ."<a href=\"user.php?op=profile&amp;id=".$row["id"]."\"><font color=\"".getusercolor($row["can_do"])."\">{$name}</font></a>{$img}";
		if ($age = (int) substr($row['birthday'], -4))
		{		
			$birthday_list .= ' (' . ($now['year'] - $age) . ')';
		}
    }
	$db->sql_freeresult($result);
	if($birthday_list!= '')
$birthday_list = _bt_happy_bd.$birthday_list;
else 
$birthday_list = _bt_no_happy_bd;
$template->assign_vars(array(
        'BIRTHDAY_LIST'            => $birthday_list,
));
include ("torrents-needseed.php");
foreach($need_seed as $val){
if(is_array($val))$template->assign_block_vars('need_seeded',$val);
}
include'blocks/newestmember_block.php';
foreach($new_users as $val){
if(is_array($val))$template->assign_block_vars('new_user',$val);
}
pmbt_include_templ('blocks/whos_online.php', 'users_online');
pmbt_include_templ('blocks/users_today.php', 'user_today');
pmbt_include_templ('blocks/video_clips.php', 'vidoe_clip');
pmbt_include_templ('blocks/poll.php', 'poll');
pmbt_include_templ('blocks/recent_posts.php', 'recent_posts');
pmbt_include_templ('blocks/search_block.php', 'cats_var');
$template->assign_vars(array(
        'S_GENTIME'            => abs(round(microtime()-$startpagetime,2)),
));
echo $template->fetch('index_body.html');
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