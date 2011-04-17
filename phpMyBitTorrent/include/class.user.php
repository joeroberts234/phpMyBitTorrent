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
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/

if (eregi("class.user.php",$_SERVER["PHP_SELF"])) die("You can't access this file directly");

class User {
        var $id;
        var $name;
        var $level;
        var $group;
		var $ulanguage;
        var $user;
        var $premium;
        var $moderator;
        var $admin;
        var $theme;
        var $act_key;
        var $email;
        var $passkey;
        var $session_id;
		var $can_shout;
		var $user_torrent_per_page;

        function User($user) {
                global $db, $db_prefix, $localhost_autologin, $language,$_COOKIE;
		    if ($_SERVER["REMOTE_ADDR"] == "127.0.0.1" AND $localhost_autologin) {
                        $uid = 1;
                        $sql = "SELECT * FROM ".$db_prefix."_users WHERE id = '1'";
                        $result = $db->sql_query($sql);
                        if ($row = $db->sql_fetchrow($result)) {
                                $this->id = $row["id"];
                                $this->name = $row["username"];
                                $this->level = $row["level"];
                                $this->theme = $row["theme"];
                                $this->email = $row["email"];
                                $this->passkey = $row["passkey"];
                                $this->act_key = $row["act_key"];
                                $this->admin = true;
                                $this->moderator = true;
                                $this->premium = true;
                                $this->user = true;
                                return;
                        } else die ("FATAL ERROR! NO ADMINISTRATOR SET. THIS SHOULD NEVER HAPPEN");
                        return;
                }
                $user = cookie_decode($user);
                $uid = intval($user[0]);
                $username = addslashes($user[1]);
                $pwd = $user[2];
                $act_key = $user[3];

                if ($uid != "" AND $pwd != "") {
                        $sql ="SELECT * FROM ".$db_prefix."_users WHERE id = '".$uid."' AND username = '".$username."' AND password = '".addslashes($pwd)."' AND act_key = '".addslashes($act_key)."';";
                        $result = $db->sql_query($sql);
                        if($row = $db->sql_fetchrow($result)) {
                                $this->id = $row["id"];
                                $this->name = $row["username"];
                                $this->nick = $row["name"];
                                $this->level = $row["level"];
                                $this->theme = $row["theme"];
								if(isset($_COOKIE["bttestperm"]) AND $row["level"]== "admin")$this->group = $_COOKIE["bttestperm"];
								else
                                $this->group = $row["can_do"];
                                $this->email = $row["email"];
								if (file_exists("./language/".$row["language"].".php"))
                                $this->ulanguage = $row["language"];
								else
                                $this->ulanguage = 'english';
                                $this->passkey = $row["passkey"];
								$this->act_key = $row["act_key"];
								$this->uploaded = $row["uploaded"];
								$this->downloaded = $row["downloaded"];
								$this->modcomment = $row["modcomment"];
								$this->invites = $row["invites"];
								$this->invitees = $row["invitees"];
								$this->seedbonus = $row["seedbonus"];
								$this->can_shout = $row["can_shout"];
                                $this->lastlogin = $row["lastlogin"];
								$this->session_id = session_id();
                                $this->forumbanned = (($row["forumbanned"]== 'yes')? true : false);
								$this->user_torrent_per_page = $row["torrent_per_page"];
								
                                if ($row["level"] == "admin") {
                                        $this->admin = true;
                                        $this->moderator = true;
                                        $this->premium = true;
                                        $this->user = true;
                                } elseif ($row["level"] == "moderator") {
                                        $this->admin = false;
                                        $this->moderator = true;
                                        $this->premium = true;
                                        $this->user = true;
                                } elseif ($row["level"] == "premium") {
                                        $this->admin = false;
                                        $this->moderator = false;
                                        $this->premium = true;
                                        $this->user = true;
                                } else {
                                        $this->admin = false;
                                        $this->moderator = false;
                                        $this->premium = false;
                                        $this->user = true;
                                }
                                return;
                        }
                }
                $this->id = 0;
                $this->name = "Anonymous";
                $this->level = "guest";
                $this->group = "guest";
                $this->admin = false;
                $this->premium = false;
                $this->user = false;
                $this->email = "anonymous@phpmybittorrent";
                $this->act_key = "";
                $this->passkey = "";
				$this->invites = "";
				$this->user_torrent_per_page = "10";
                global $theme;
                $this->theme = $theme;
        }
}
?>