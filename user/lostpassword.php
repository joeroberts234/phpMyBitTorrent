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

if (!eregi("user.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

if (is_user($btuser)) bterror("");

OpenTable(_btlostpassword);

if (!isset($postback)) {
        //When button is NOT clicked yet
        echo "<form action=\"user.php?op=lostpassword\" method=\"POST\">\n";
        echo "<p>"._btlostpasswordintro."</p>\n";
        echo "<table border=\"0\">\n";
        echo "<tr><td><p>"._btusername."</p></td><td><p><input type=\"text\" name=\"username\" size=\"20\"></p></td></tr>\n";
        echo "<tr><td><p>"._btpasswd."</p></td><td><p><input type=\"password\" name=\"npasswd\" size=\"20\"></p></td></tr>\n";
        echo "<tr><td><p>"._btpasswd2."</p></td><td><p><input type=\"password\" name=\"cpasswd\" size=\"20\"></p></td></tr>\n";
        echo "</table>\n";
        if ($gfx_check) {
                $rnd_code = strtoupper(RandomAlpha(5));
                echo "<table><tr><td>"._btgfxcode."</td><td><img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\"></td></tr>";
                echo "<tr><td>&nbsp;</td><td><input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\"></td></tr></table>";
                echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\">\n";
        }
        echo "<p><input type=\"submit\" name=\"postback\" value=\""._btsubmit."\"><input type=\"reset\" value=\""._btreset."\"></p></form>";
        echo "</form>\n";
} else {
        //After clicking
        $errmsg = Array();
        if (!isset($username) OR $username == "")
                $errmsg[] = _bterrusernamenotset;
        if (!isset($npasswd) OR $npasswd == "")
                $errmsg[] = _bterrpasswordnotset;
        if (count($errmsg) == 0) {
                $sql = "SELECT id, email FROM ".$db_prefix."_users WHERE username ='".escape($username)."';";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) == 0)
                        $errmsg[] = _bterrusernotexists;
                else
                        list ($uid, $email_to) = $db->sql_fetchrow($res);
                $db->sql_freeresult($res);
                if (strlen($npasswd) < 5)
                        $errmsg[] = _bttooshortpass;
                if ($npasswd != $cpasswd)
                        $errmsg[] = _btpasswnotsame;
                if ($gfx_check == "true" AND $gfxcheck != md5(strtoupper($gfxcode)))
                        $errmsg[] = _bterrcode;
        }
        if (count($errmsg) != 0) bterror($errmsg,_btsignuperror);

        $act_key = RandomAlpha(32);
        $sql = "UPDATE ".$db_prefix."_users SET newpasswd = '".md5($npasswd)."', act_key = '".$act_key."' WHERE username ='".escape($username)."';";

        $db->sql_query($sql) or btsqlerror($sql);

        $replace_markers = Array("**sitename**","**siteurl**","**user**","**userid**","**pass**","**code**");
        $replace_data = Array ($sitename,$siteurl,$username,$uid,$npasswd,md5($act_key));

        include("language/mailtexts.php");
        $confirm_mail = New eMail;
        $confirm_mail->sender = $admin_email;
        $confirm_mail->subject = $lostpasswordemailsub[$language];
        $confirm_mail->body = str_replace($replace_markers,$replace_data,$lostpasswordemailtext[$language]);
        $confirm_mail->Add($email_to);
        $confirm_mail->Send();

        echo "<p>"._btlostpasswordcheckmail."</p>\n";
}

CloseTable();
?>