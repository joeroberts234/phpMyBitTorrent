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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
require_once("common.php");
$template = & new Template();
if(!$user->user){
header("Location: ".$siteurl."/login.php");
die();
 }
$mode											= request_var('mode', '');
$action											= request_var('action', '');
$take_edit										= request_var('take_edit', '');
$admin_mode = false;
if (isset($id)) {
		if($user->id != $id && (!checkaccess('edit_user')) && (getlevel($uid) == "owner" && $user->group != "owner")){
              set_site_var('- '._btuserprofile.' - '._bterror);
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          =>_btaccdenied,
                                        'S_ERROR_MESS'            => _btuser_edit,
                                ));
             echo $template->fetch('error.html');
             @include_once("include/cleanup.php");
             ob_end_flush();
             die();
}
        else {
                $uid = intval($id);
                $admin_mode = true;
        }
} else $uid = $user->id;

                                $template->assign_vars(array(
                                        'S_MOD_MODE'            => $admin_mode,
                                        'PMBT_LINK_BACK'            => ($admin_mode)? $siteurl.'/user.php?op=editprofile&amp;'.'id=' . $uid . '&amp;' : $siteurl.'/user.php?op=editprofile&amp;',
		                                'T_TEMPLATE_PATH'=> $siteurl . "/themes/" . $theme . "/templates",
                                ));
$sql_profile = "SELECT U.* , count(F.id)AS forumposts, COUNT(DISTINCT B.topic_id)AS book FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_forum_posts F ON U.id = F.userid LEFT JOIN ".$db_prefix."_bookmarks B ON U.id = B.user_id  where U.id ='".$uid."' LIMIT 1;";
$res_profile = $db->sql_query($sql_profile);
$userrow = $db->sql_fetchrow($res_profile);
$db->sql_freeresult($res_profile);
if ($admin_mode) $uname = $userrow["username"];
else $uname = $user->name;
$off_set = tz_select($default = '',$userrow);
$countries = "<option value=0>----</option>\n";
$countries .= cnt_select($countries , $userrow );
set_site_var(_btuserprofile.' - '.$userrow["username"]);
$template->assign_vars(array(
        'ACTION'                => (isset($action)) ? $action : '',
        'MODE'                  => $mode,
));
$user->lang['ATTACHMENT_DELETED'];
if($take_edit){
        $errors = Array();
        $sqlfields = Array();
        $sqlvalues = Array();
                switch($mode) {
				               case "subscribed":{
						                        include 'include/ucp/edit_subscribed.php';
							                    break;
							                    }
				               case "bookmarks":{
						                        include 'include/ucp/edit_bookmarks.php';
							                    break;
							                    }
				               case "drafts":{
						                      include 'include/ucp/edit_drafts.php';
							                  break;
							                  }
				               case "attachments":{
							                      break;
							                      }
				               case "profile_info":{
							                       include 'include/ucp/edit_profile_info.php';
							                       break;
							                       }
				               case "signature":{
							                     include 'include/ucp/edit_signature.php';
							                     break;
							                     }
				               case "avatar":{
							                 include 'include/ucp/edit_avatar.php';
							                 break;
							                 }
				               case "admin_reg_details":{
							                 include 'include/ucp/edit_admin_reg_details.php';
							                            break;
							                            }
				               case "reg_details":{
							                 include 'include/ucp/edit_reg_details.php';
							                      break;
							                      }
				               case "personal":{
							                   include 'include/ucp/edit_personal.php';
							                   break;
							                   }
				               case "friends":{
							                  include 'include/ucp/edit_friends.php';
							                  break;
							                  }
				               case "foes":{
							               include 'include/ucp/edit_foes.php';
							               break;
							               }
							  }
              }

switch($mode) {
			   case "front":{
       				         include 'include/ucp/ucp_front.php';
						     break;
						     }
			   case "subscribed":{
       				         include 'include/ucp/subscribed.php';
						     break;
						     }
				case "bookmarks":{
						      include 'include/ucp/bookmarks.php';
							  break;
							  }
			   case "drafts":{
       				         include 'include/ucp/drafts.php';
						     break;
						     }
			   case "attachments":{
       				         include 'include/ucp/attachments.php';
						     break;
						     }
			   case "profile_info":{
       				         include 'include/ucp/profile_info.php';
						     break;
						     }
			   case "signature":{
       				         include 'include/ucp/signature.php';
						     break;
						     }
			   case "avatar":{
       				         include 'include/ucp/avatar.php';
						     break;
						     }
			   case "reg_details":{
       				         include 'include/ucp/reg_details.php';
						     break;
						     }
			   case "admin_reg_details":{
							 include 'include/ucp/admin_reg_details.php';
							 break;
							 }
			   case "personal":{
       				         include 'include/ucp/personal.php';
						     break;
						     }
			   case "friends":{
       				         include 'include/ucp/friends.php';
						     break;
						     }
			   case "foes":{
       				         include 'include/ucp/foes.php';
						     break;
						     }
				default:{
				        include 'include/ucp/ucp_front.php';
						break;
					}
			  }
$user_friends = '';
        $sql = "SELECT B.slave, U.username, IF (U.name IS NULL, U.username, U.name) as name, U.can_do as can_do, U.lastlogin as laslogin, U.Show_online as show_online FROM ".$db_prefix."_private_messages_bookmarks B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$userrow["id"]."' ORDER BY name ASC;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($n = $db->sql_numrows($res)) {
                for ($i = 1; list($uid, $username, $user_name, $can_do, $laslogin, $show_online) = $db->sql_fetchrow($res); $i++) {
                        $user_friends .= "<option value=\"" . $uid ."\">" . $user_name . "</option>";
		$which = (time() - 300 < sql_timestamp_to_unix_timestamp($laslogin) && ($show_online == 'true' || $user->admin)) ? 'online' : 'offline';

		$template->assign_block_vars("friends_{$which}", array(
			'USER_ID'		=> $uid,
			'USER_COLOUR'	=> getusercolor($can_do),
			'USERNAME'		=> $username,
			'USERNAME_FULL'	=> $user_name)
		);
                }
        }
        $db->sql_freeresult($res);
$template->assign_var('S_IN_UCP', true);

$template->assign_vars(array(
		'UCP'				   => _btuserprofile,
        'S_GENTIME'            => abs(round(microtime()-$startpagetime,2)),
));
echo $template->fetch('ucp_edit_profile.html');
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
include_once("include/cleanup.php");
ob_end_flush();
die();
?>