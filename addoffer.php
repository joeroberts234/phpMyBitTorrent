<?php
/*
*----------------------------phpMyBitTorrent V 2.0.5---------------------------*
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
*------              ©2011 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, Dec 20, 2009 1:05 AM   ------------------------*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
$startpagetime = microtime();
require_once("common.php");
if (!$user->user)header('Location: '.$siteurl.'/login.php');
require_once("include/torrent_functions.php");
if($pivate_mode AND !$user-user)header('Location: '.$siteurl.'/login.php');
require_once("language/mailtexts.php");
$offerid = request_var('id', '');
$userid = $user->id;
$template = & new Template();
set_site_var(_btoffer);
$template->assign_vars(array(
        'S_FORWARD'            => 'offers.php',
));
if(!checkaccess("offers")){
$template->assign_vars(array(
        'S_ERROR'            => true,
));
$template->assign_vars(array(
        'TITTLE_M'            => _btaccdenied,
));
$template->assign_vars(array(
        'MESSAGE'            => "<p>".str_replace("**page**","Offers",_btnoautherized)."</p>",
));
echo $template->fetch('message_body.html');
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
}
$res_offer = "SELECT * FROM ".$db_prefix."_offervotes WHERE offerid=$offerid and userid=$userid;";
$res = $db->sql_query($res_offer);
$arr = $db->sql_fetchrow($res);
$db->sql_freeresult($res_offer);
$voted = $arr;
if ($voted) {
$template->assign_vars(array(
        'S_ERROR'            => true,
));
$template->assign_vars(array(
        'TITTLE_M'            => _bt_nocheat,
));
$template->assign_vars(array(
        'MESSAGE'            => "<p>"._bt_Offer_voted."</p>",
));
echo $template->fetch('message_body.html');
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
}
else {
$sql = "UPDATE ".$db_prefix."_offers SET `votes` = `votes` + 1 WHERE id=$offerid;";
$db->sql_query($sql);
$sql = "INSERT INTO ".$db_prefix."_offervotes (offerid, userid) VALUES($offerid, $userid);";
$db->sql_query($sql);
$template->assign_vars(array(
        'S_SUCCESS'            => true,
));
$template->assign_vars(array(
        'TITTLE_M'            => _bt_off_vote_th,
));
$template->assign_vars(array(
        'MESSAGE'            => "<p>"._bt_off_take_vote."</p>",
));
echo $template->fetch('message_body.html');
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
}
//////////////Test Messasge///////////////////
$res1 = "SELECT ".$db_prefix."_offers.votes, ".$db_prefix."_offers.name FROM ".$db_prefix."_offers WHERE `id` = $offerid;";
$res = $db->sql_query($res1);
$arr = $db->sql_fetchrow($res);
$db->sql_freeresult($res1);
$torrent = $arr['name'];
$zvote = $arr['votes'];

if ( $zvote > 3) {
$res_user = "SELECT userid FROM ".$db_prefix."_offers WHERE id = $offerid;";
$res_id = $db->sql_query($res_user);
$pn_msg = _bt_off_canupload;
while($row = $db->sql_fetchrow($res_id)) {

                $sql = "INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('0','".$row['userid']."','".$db->sql_escape(_bt_offer_up)."','".$db->sql_escape(_bt_off_canupload)."',NOW());";

                $db->sql_query($sql) or btsqlerror($sql);
                $mid2 = $db->sql_nextid();
                include_once("language/mailtexts.php");
                $notify_mail = new eMail();
                $notify_mail->add($email);
                $notify_mail->sender = $admin_email;
                $notify_mail->subject = $newpmemailsub[$language];
                $search = Array("**user**","**sender**","**sitename**","**siteurl**","**mid2**");
                $replace = Array($name,$user->name,$sitename,$siteurl,$mid2);
                $notify_mail->body = str_replace($search,$replace,$newpmemailbody[$language]);
                $notify_mail->send();

}
}
?>
