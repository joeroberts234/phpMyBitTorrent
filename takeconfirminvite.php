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
if (!eregi("takeconfirminvite.php",$_SERVER["PHP_SELF"])) die ("You cannot include this file");
include("header.php");
global $db, $db_prefix, $forumpx;

function hash_pad($hash) {
    return str_pad($hash, 20);
}

$md5 = $secret;
                $errmsg = Array();
$id = 0 + $id;
if (!isset($id) OR $id == "")$errmsg[] = _bterrusernamenotset;
if (count($errmsg) == 0) {
$sql = ("SELECT COUNT(*) FROM ".$db_prefix."_users");
$res = $db->sql_query($sql) or btsqlerror($sql);
$arr = $db->sql_fetchrow($res);
if ($arr[0] >= $invites1)
$errmsg[] = "Sorry, user limit reached. Please try again later.";
$sql = ("SELECT password, active FROM ".$db_prefix."_users WHERE id = $id");
$res = $db->sql_query($sql) or btsqlerror($sql);
$row = $db->sql_fetchrow($res);
if (!$row)$errmsg[] = _bterrusernotexists;
if ($row["active"] != "0")$errmsg[] = _btuseralreadyactive;
$sec = hash_pad($row["password"]);
if ($md5 != md5($sec))$errmsg[] = _btsignup_password_mismatch;
}
if (count($errmsg) != 0) bterror($errmsg,_btacterror);
if (empty($wantusername) || empty($wantpassword))
bterror(_btsignup_blank_fields);
if (!mkglobal("wantusername:wantpassword:passagain"))
die();


function validusername($username)
{
if ($username == "")
return false;

// The following characters are allowed in user names
$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ";

for ($i = 0; $i < strlen($username); ++$i)
if (strpos($allowedchars, $username[$i]) === false)
return false;

return true;
}

if (strlen($wantusername) > 45)
bterror(_btsignup_toolong.$wantusername);

if ($wantpassword != $passagain)
bterror(_btsignup_wrong_pass);

if (strlen($wantpassword) < 6)
bterror(_btsignup_tooshort);
if (strlen($wantpassword) > 40)
barkmsg(_btsignup_pass_toolong);
if ($wantpassword == $wantusername)
bterror(_btsignup_pass_name);
if (!validusername($wantusername))
bterror(_btsignup_invalid_username);
// make sure user agrees to everything...
if ($rulesverify != "yes" || $faqverify != "yes" || $ageverify != "yes")
bterror(_btsignup_not_qualified,_btsignup_signup_fail);
$wantpasshash = md5($wantpassword);
$db->sql_query("UPDATE ".$db_prefix."_users SET username='$wantusername', clean_username = '".addslashes(strtolower($wantusername))."', password='$wantpasshash', active='1'WHERE id=$id")or sql_error();
if($forumshare)forumadd($wantusername);
OpenTable(_btsignup);
echo "<p>"._btactcomplete."</p>";
CloseTable();
include('footer.php');
?>