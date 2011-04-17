<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta3-----------------------*
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

if (eregi("class.email.php", $_SERVER['PHP_SELF'])) die ("You can't access this file directly...");



class eMail {

        var $sender;

        var $recipient = Array();

        var $subject;

        var $body;



        function eMail() {

                global $admin_email, $sitename;

                $this->sender = $admin_email;

        }



        function Send() {
                global $admin_email, $sitename, $siteurl,$cookiedomain;
ini_set("SMTP","smtp.".$admin_email);
ini_set('sendmail_from', $admin_email); 
                //if (!isset($this->recipient,$this->subject,$this->body)) return false;
                foreach ($this->recipient as $rec) {
				$image = "<img src=\"http://p2p-evolution.com/themes/eVo_blue/pics/evoblue-1.jpg\">";
                $message = "<html><body><center>".$image."</center><br><table><tr><td>" . nl2br($this->body) . "</td></tr></table></body></html>";
                $headers = 'From: '.$admin_email . "\r\n".
                'Reply-To: ' .$admin_email . "\r\n".
                'MIME-Version: 1.0' . "\r\n".
                'Content-type: text/html; ' . "\r\n".
                'X-Mailer: PHP/' . phpversion();
                        mail($rec,$this->subject,$message,$headers,"-f ".$admin_email."");

                }

                return true;

        }

        function Add($email) {

                if (is_email($email)) $this->recipient[] = $email;

        }

}



class MailingList {

                var $mails = Array();

                function Insert($mail) {

                        $this->mails[] = $mail;

                }

                function Sendmail() {

                        if (count($this->mails) <1 ) return;

                        foreach ($this->mails as $mail) {

                                $mail->Send();

                        }

                }



}

?>