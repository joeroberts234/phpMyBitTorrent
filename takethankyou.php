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

$res = $db->sql_query("SELECT id FROM ".$db_prefix."_torrents WHERE id = $id");
$row = $db->sql_fetchrow($res);
if (!$row)
die();

$ras = $db->sql_query("select tid from ".$db_prefix."_thanks WHERE torid='$id' AND uid ='" .$user->id . "' ");
$raw = $db->sql_fetchrow($ras);
if ($raw)

bterror(_btthanked,_btsorry);

$text = ":thankyou:";

$db->sql_query("INSERT INTO ".$db_prefix."_thanks (uid, torid, thank_date) VALUES ('" .$user->id . "',$id, NOW())");
 $db->sql_query("INSERT INTO ".$db_prefix."_comments (user, torrent, added, text) VALUES ('" .$user->id . "', '".$id."', NOW(), '" . $text . "')");
                        $bon = "SELECT active, comment FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $comment) = $db->sql_fetchrow($bonset);
                        $db->sql_freeresult($bonset);
if($active=='true' AND $user->id !=0)
{
$do="UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$comment."' WHERE id= ".$user->id."" ;
$db->sql_query($do) or btsqlerror($do);
}



$db->sql_query("UPDATE ".$db_prefix."_torrents SET comments = comments + 1, thanks = thanks + 1 WHERE id = $id");
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

header("Refresh: 0; url=details.php?id=$id&comm=$text");

include("footer.php");

?>