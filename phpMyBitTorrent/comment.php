<?php
/*
*------------------------------phpMyBitTorrent V 2.0.4-------------------------*
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
*------              ©2009 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
$startpagetime = microtime();
require_once("common.php");
require_once("include/torrent_functions.php");
if($pivate_mode AND !$user-user)header('Location: '.$siteurl.'/login.php');
require_once("language/mailtexts.php");
if (!$user->user)header('Location: '.$siteurl.'/login.php');
				$edit = false;
$template = & new Template();
set_site_var(_btrequestdetails_comments);
$id = intval($id);
$template->assign_vars(array(
        'T_ID'            => $id,
));

$cid = intval($cid);
$template->assign_vars(array(
        'T_CID'            => $cid,
));
$template->assign_vars(array(
        'S_FORWARD'            => "details.php?id=" . $id . "&comm=startcomments",
));
switch ($op) {
                case "add": {
                        if (!get_magic_quotes_gpc()) $comment = addslashes($comment);
                        $sql = "INSERT INTO ".$db_prefix."_comments (user, torrent, added, text) VALUES ('" .$user->id . "', '".$id."', NOW(), '" . $comment . "');";
                        $db->sql_query($sql) or btsqlerror($sql);

                        $newid = $db->sql_nextid();

                        $db->sql_query("UPDATE ".$db_prefix."_torrents SET comments = comments + 1 WHERE id = '".intval($id)."'") or btsqlerror("UPDATE ".$db_prefix."_torrents SET comments = comments + 1 WHERE id = '$id'");
                        $bon = "SELECT active, comment FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $comment) = $db->sql_fetchrow($bonset);
                        $db->sql_freeresult($bonset);
if($active=='true' AND $user->id !=0)
{
$do="UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$comment."' WHERE id= ".$user->id."" ;
$db->sql_query($do) or btsqlerror($do);
}
                        

                        global $language, $langlevel, $admin_mail;
                        //Send notify
                        $sql = "SELECT name, email FROM ".$db_prefix."_users U, ".$db_prefix."_comments_notify C WHERE C.user = U.id AND C.status = 'active' AND C.torrent = '".$id."' AND U.id != '".$user->id."' ;";
                        $res = $db->sql_query($sql) or btsqlerror($sql);
        				$tor = "SELECT * FROM ".$db_prefix."_torrents WHERE id = '".intval($id)."' ;";
        				$nott = $db->sql_query($tor)or btsqlerror($tor);
	        			$tortn = $db->sql_fetchrow($nott);
	        			$db->sql_freeresult($nott);


                        $sqlupldate = "UPDATE ".$db_prefix."_comments_notify SET status = 'stopped' WHERE ".$db_prefix."_comments_notify.torrent = '".$id."' ;";
                        $db->sql_query($sqlupldate);

                        $notify_mail = new eMail();
                        while($row = $db->sql_fetchrow($res)) $notify_mail->Add($row["email"]);
                        $notify_mail->sender = $admin_email;
                        $notify_mail->subject = $commnotifysub[$language];
						$search = Array("**sitename**","**siteurl**","**torrenturl**","**unwatchurl**","**name**");
                        $replace = Array($sitename,$siteurl,$siteurl."/details.php?id=".$id,$siteurl."/details.php?id=".$id."&op=comment&trig=off",$tortn["name"]);
                        $notify_mail->body = str_replace($search,$replace,$commnotifytext[$language]);
                        $notify_mail->Send();
$template->assign_vars(array(
        'S_SUCCESS'            => true,
        'TITTLE_M'             => _btcommentsfortorrent,
        'MESSAGE'              => "<p>".str_replace("**id**", $id,_btcommentinserted)."</p>",
));
                        break;
                }
                case "delete": {
                        $sql = "SELECT user FROM ".$db_prefix."_comments WHERE id = '".$cid."' LIMIT 1;";
                        $res = $db->sql_query($sql) or bterror($sql);
                        list ($owner) = $db->sql_fetchrow($res);
                        $db->sql_freeresult($res);
                        if ($owner != $user->id AND !$user->moderator) {
                                bterror(_btnotyourcomment,_btcomments);
                        } else {
                                $sql = "DELETE FROM ".$db_prefix."_comments WHERE id = '".$cid."';";
                                $db->sql_query($sql) or btsqlerror($sql);
                                $squpdate = "UPDATE ".$db_prefix."_torrents SET comments = comments - 1 WHERE id = '".$id."'";
                                $db->sql_query($squpdate) or btsqlerror($squpdate);
                        $bon = "SELECT active, comment FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $comment) = $db->sql_fetchrow($bonset);
                        $db->sql_freeresult($bonset);
if($active=='true' AND $user->id !=0)
{
						$do="UPDATE ".$db_prefix."_users SET seedbonus = seedbonus - '".$comment."' WHERE id= ".$owner."" ;
                        $db->sql_query($do) or btsqlerror($do);
}
$template->assign_vars(array(
        'S_SUCCESS'            => true,
        'TITTLE_M'             => _btcommentsfortorrent,
        'MESSAGE'              => "<p>".str_replace("**id**", $id,_btcommentdeleted)."</p>",
));
                        }
                        break;
                }
                case "edit_coment": {
                $take											= request_var('take', '');
                $sql = "SELECT * FROM `".$db_prefix."_comments` WHERE `id`='" . $cid ."';";
                $res = $db->sql_query($sql) or btsqlerror($sql);
				$row = $db->sql_fetchrow($res);
                $sql = "SELECT name FROM `".$db_prefix."_torrents` WHERE `id`='" . $id ."';";
                $res2 = $db->sql_query($sql) or btsqlerror($sql);
				$row2 = $db->sql_fetchrow($res2);
                    $template->assign_vars(array(
			        'C_ID'          => $cid,
			        'T_ID'          => $id,
			        'T_NAME'          => $row2['name'],
			        'TEXT'            => $row['text'],
                    'S_FORWARD'       => "details.php?id=" . $id . "&comm=startcomments",
			        'S_ERROR'            => false,
			        'S_SUCCESS'            => true,
			        'TITTLE_M'             => _btcommentsfortorrent,
			        'MESSAGE'              => "<p>".str_replace("**id**", $id,_btcommentdeleted)."</p>",
					));
				if(!$take ==1)$edit = true;
                        break;
				}
}
$template->assign_vars(array(
        'S_GENTIME'            => abs(round(microtime()-$startpagetime,2)),
));
if(!$edit)echo $template->fetch('message_body.html');
else
echo $template->fetch('edit_body.html');
if ($user->user) {
        //Update online user list
        $pagename = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
        $sqlupdate = "UPDATE ".$db_prefix."_online_users SET page = '".addslashes($pagename)."', last_action = NOW() WHERE id = ".$user->id.";";
        $sqlinsert = "INSERT INTO ".$db_prefix."_online_users VALUES ('".$user->id."','".addslashes($pagename)."', NOW(), NOW())";
        $res = $db->sql_query($sqlupdate);
        if (!$db->sql_affectedrows($res)) $db->sql_query($sqlinsert);
}
@include_once("include/cleanup.php");
ob_end_flush();
die();
?>