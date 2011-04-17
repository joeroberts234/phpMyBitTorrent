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
if (!eregi("takeinvite.php",$_SERVER["PHP_SELF"])) die ("You cannot include this file");
include("header.php");
global $db, $db_prefix, $force_passkey, $give_sign_up_credit;
function validemail($email) {
    return preg_match('/^[\w.-]+@([\w.-]+\.)+[a-z]{2,6}$/is', $email);
}

function mksecret($len = 20) {
    $ret = "";
    for ($i = 0; $i < $len; $i++)
        $ret .= chr(mt_rand(0, 255));
    return $ret;
}
$sql=("SELECT COUNT(*) FROM ".$db_prefix."_users")or sql_error();
$res = $db->sql_query($sql) or btsqlerror($sql);
$arr = $db->sql_fetchrow($res);
if ($arr[0] >= $invites1)bterror("Sorry, The current user account limit (" . number_format($invites1) . ") has been reached. Inactive accounts are pruned all the time, please check back again later...","Limmet reached");
if($user->invites == 0)bterror("Sorry, No invites!");
$mess= unesc($_POST["mess"]);
if (!$mess) bterror("You must enter a message!");
if (!mkglobal("email"))die();
if (!validemail($email))bterror("That doesn't look like a valid email address.");

// check if email addy is already in use
$a = ($db->sql_numrows($db->sql_query("select count(*) from ".$db_prefix."_users where email='$email'"))) or die(mysql_error());
if ($a[0] != 0)bterror(_bterremailexists);
$secret = mksecret();
$editsecret = mksecret();
$username = rand();
if($force_passkey){
                do {
                        $passkey = ", '".RandomAlpha(32)."'";
                        //Check whether passkey already exists
                        $sql = "SELECT passkey FROM ".$db_prefix."_users WHERE passkey = '".$passkey."';";
                        $res = $db->sql_query($sql);
                        $cnt = $db->sql_numrows($sql);
                        $db->sql_freeresult($res);
                } while ($cnt > 0);
				$passkeyrow = ', passkey';
				}else{
				$passkeyrow = NULL;
				$passkey = NULL;
				}
$act_key = RandomAlpha(32);
$ret = $db->sql_query("INSERT INTO ".$db_prefix."_users (username, password, email, active, act_key, invited_by, uploaded, regdate" . $passkeyrow . ") VALUES ('" .$username. "', '". $secret ."', '" .$email ."', '0', '".$act_key."', '". $user->id ."', '".$give_sign_up_credit."', NOW() " . $passkey .")")or die(mysql_error());
$id = $db->sql_nextid();
$id2 = $user->id;
$invites = $user->invites -1;
$invitees = $user->invitees;
$invitees2 = "$id $invitees";
 $db->sql_query("UPDATE ".$db_prefix."_users SET invites='$invites', invitees='$invitees2' WHERE id = $id2");
$username = $user->name;

$psecret = md5($secret);

$message = ($html ? strip_tags($mess) : $mess);

$body = <<<EOD
You have been invited to $sitename by $username. They have
specified this address ($email) as your email. If you do not know this person, please ignore this email. Please do not reply.

Message:
-------------------------------------------------------------------------------
$message
-------------------------------------------------------------------------------

This is a private site and you must agree to the rules before you can enter:

$siteurl/rules.php

$siteurl/faq.php


To confirm your invitation, you have to follow this link:

$siteurl/confirminvite.php?id=$id&secret=$psecret

After you do this, you will be able to use your new account. If you fail to
do this, your account will be deleted within a few days. We urge you to read
the RULES and FAQ before you start using $sitename.
EOD;
mail($email, "$sitename user registration confirmation", $body, "From: $sitename <$sitename>");

header("Refresh: 0; url=user.php?op=profile&id=".$user->id."&type=invite&email=" . urlencode($email));



?>