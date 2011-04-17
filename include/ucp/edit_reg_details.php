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
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: edit_reg_details.php 1 2010-12-08 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
        //Check for new Password
        if (isset($newpasswd) AND $newpasswd != "") {
				//Make sure newpasswd and newpasswdconf match If not thow a error
                if ($newpasswd != $newpasswdconf) $errors[] = _btpasswnotsame;
                else {
                        $sqlfields[] = "password";
                        $sqlvalues[] = "'".md5($newpasswd)."'";
                }
        }
		//Process New user name
        if (!isset($name) OR $name == "") $name = "NULL";
        processinput("name",htmlspecialchars($name));
		//Process New user email
		if($emaileditecf && $new_email != $userrow["email"])
		{
                if ($new_email != $email_confirm){
				 $errors[] = _btemailnotsame;
				 }else{
		echo $new_email;
		include_once'language/mailtexts.php';
		include_once'include/class.email.php';
		$mail_key = RandomAlpha(32);
        $replace_markers = Array("**uid**","**mail_key**");
        $replace_data = Array($userrow['id'],$mail_key);
		processinput("newemail",$new_email);
		processinput("mail_key",$mail_key);
		//Send out new email comfermation
		$confirm_mail = new eMail();
		$confirm_mail->Add($new_email);
		$confirm_mail->sender = $admin_email;
		$confirm_mail->subject = $usermailconfirmmailsub[$language];
		$confirm_mail->body = str_replace($replace_markers,$replace_data,$userconfirmmailtext[$language]);
		$confirm_mail->Send();
				}
		}
        if (count($errors) > 0){
                $msg = "<p>"._btalertmsg."</p>\n";
                $msg .= "<ul>\n";
                foreach ($errors as $msge) {
                        $msg .= "<li><p>".$msge."</p></li>\n";
                }
                $msg .= "</ul>\n";

		              set_site_var('- '._btuserprofile.' - '._bterror);
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          =>_btedituserprofile,
                                        'S_ERROR_MESS'            => $msg,
                                ));
             echo $template->fetch('error.html');
             @include_once("include/cleanup.php");
             ob_end_flush();
             die();
			 //bterror($errors,_btedituserprofile,false);
			 }
                $sql = "UPDATE ".$db_prefix."_users SET ";
                for ($i = 0; $i < count($sqlfields); $i++) $sql .= $sqlfields[$i] ." = ".$sqlvalues[$i].", ";
                $sql .= "act_key = ".(($admin_mode) ? "act_key" : "'".RandomAlpha(32)."'")." WHERE id = '".$uid."';"; //useless but needed to terminate SQL without a comma
                //echo $sql;
                //die();
                if (!$db->sql_query($sql)) btsqlerror($sql);
                if (!$admin_mode) userlogin($uname,$btuser); //SQL is executed, cookie is invalid and getusername() function returns nothing, so it must be called earlier
?>