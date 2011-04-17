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


$errmsg = Array();
if (!isset($username) OR $username == "")
        $errmsg[] = _bterrusernamenotset;
if (!isset($password) OR $password == "")
        $errmsg[] = _bterrpasswordnotset;
if (!isset($email) OR $email == "")
        $errmsg[] = _bterremailnotset;
if (count($errmsg) == 0) {
        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".addslashes($username)."';")) != 0)
                $errmsg[] = _bterruserexists;
        if (!is_email($email))
                $errmsg[] = _btfakemail;
        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE email ='".addslashes($email)."';")) != 0)
                $errmsg[] = _bterremailexists;
        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE lastip = '".sprintf("%u",ip2long(getip()))."';")) != 0)
                $errmsg[] = "Duplicate Ip In use";
        if (strlen($password) < 5)
                $errmsg[] = _bttooshortpass;
        if ($password != $cpassword)
                $errmsg[] = _btpasswnotsame;
        if ($disclaimer_check AND $disclaimer != "yes")
                $errmsg[] = _btdisclerror;
        if ($gfx_check == "true" AND $gfxcheck != md5(strtoupper($gfxcode)))
                $errmsg[] = _bterrcode;
}
if (count($errmsg) != 0) bterror($errmsg,_btsignuperror);
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
if($conferm_email)$sql = "INSERT INTO ".$db_prefix."_users (username, clean_username, email, password, act_key, uploaded, regdate" . $passkeyrow . ") VALUES ('".addslashes($username)."', '".addslashes(strtolower($username))."', '".addslashes($email)."', '".md5($password)."', '".$act_key."', '".$give_sign_up_credit."', NOW() " . $passkey .");";
else
$sql = "INSERT INTO ".$db_prefix."_users (username, clean_username, email, password, act_key, uploaded, regdate" . $passkeyrow . ", active) VALUES ('".addslashes($username)."', '".strtolower($username)."', '".addslashes($email)."', '".md5($password)."', '".$act_key."', '".$give_sign_up_credit."', NOW()" . $passkey .", 1);";
$db->sql_query($sql) or btsqlerror($sql);
OpenTable(_btsignup);

if($conferm_email) 
{
$replace_markers = Array("**sitename**","**siteurl**","**username**","**password**","**key**");
$replace_data = Array ($sitename,$siteurl,$username,$password,md5($act_key));

$confirm_mail = New eMail();
$confirm_mail->sender = $admin_email;
$confirm_mail->subject = $userregconfirmmailsub[$language];
$confirm_mail->body = str_replace($replace_markers,$replace_data,$userregconfirmmailtext[$language]);
$confirm_mail->Add($email);
$confirm_mail->Send();
echo "<p>"._btregcomplete.spellmail($admin_email)."</p>";
}else{
                echo "<p>"._btactcomplete."</p>";
				$sql = "INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES ('1', '/notice :welcome: our newest Member ".escape($username)."', NOW());";
                $db->sql_query($sql);
}
CloseTable();

?>