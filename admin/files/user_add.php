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
*-----------------   Sunday, September 27, 2008 8:37 PM   ---------------------*
*/
$saved = NULL;
if($op =="take_user_add"){
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
        if (strlen($password) < 5)
                $errmsg[] = _bttooshortpass;
        if ($password != $cpassword)
                $errmsg[] = _btpasswnotsame;
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
				$passkeyrow = '';
				$passkey = '';
				}
$act_key = RandomAlpha(32);
$sql = "INSERT INTO ".$db_prefix."_users (username, clean_username, email, password, act_key, uploaded, regdate" . $passkeyrow . ", active) VALUES ('".addslashes($username)."', '".addslashes(strtolower($username))."', '".addslashes($email)."', '".md5($password)."', '".$act_key."', '".$give_sign_up_credit."', NOW() " . $passkey .", 1);";
$db->sql_query($sql) or btsqlerror($sql);
$saved = true;
}
if (isset($saved)) {
        OpenTable2();
        echo "<h3>".$username." Added</h3>";
        CloseTable2();
}
OpenTable("Create New User");
    echo "<h1>"._btsignup."</h1>";
    echo "<br />";
    echo "<form action=\"admin.php\" method=\"POST\">\n";
	echo "<input type=\"hidden\" name=\"op\" value=\"take_user_add\" />\n";
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    echo "<tr><td class='rowhead'>"._btusername."</td><td><input type='text' name='username' size='40' /></td></tr>";
    echo "<tr><td class='rowhead'>"._btpasswd."</td><td><input type='password' name='password' size='40' /></td></tr>";
    echo "<tr><td class='rowhead'>"._btpasswd2."</td><td><input type='password' name='cpassword' size='40' /></td></tr>";
    echo "<tr><td class='rowhead'>"._btemailaddress."</td><td><input type='text' name='email' size='40' /></td></tr>";
    echo "<tr><td colspan='2' align='center'><input type='submit' value='"._btsubmit."' class='btn' /></td></tr>";
    echo "</table>";
    echo "</form>";
CloseTable();
?>