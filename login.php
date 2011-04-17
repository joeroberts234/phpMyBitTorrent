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

$startpagetime = microtime();
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("include/config.php"); //if config file has not been loaded yet
include'include/class.template.php';
$template = & new Template();
set_site_var('Index');
if($op == 'login')
{
                if (!isset($username) OR $username == "" OR !isset($password) OR $password == "") {
                        bterror(_btusrpwdnotset,_btlogin); //missing data
                } elseif ($gfx_check AND (!isset($gfxcode) OR $gfxcode == "" OR $gfxcheck != md5(strtoupper($gfxcode)))) {
                        bterror(_bterrcode,_btlogin);
                } else {
                        $result = $db->sql_query("SELECT active FROM ".$db_prefix."_users WHERE clean_username = '".addslashes(strtolower($username))."' AND password = '".md5($password)."'");
                        if ($db->sql_numrows($result) == 1) {
                                list ($active) = $db->sql_fetchrow($result);
                                if ($active == 1) {
								$ip = getip();
        $sql = "UPDATE ".$db_prefix."_users SET lastip = '".sprintf("%u",ip2long($ip))."', lasthost = '".gethostbyaddr($ip)."', lastlogin = NOW() WHERE clean_username = '".addslashes(strtolower($username))."';";
        $db->sql_query($sql);

								if (isset($remember) AND $remember == "yes"){
								 $db->sql_query("UPDATE ".$db_prefix."_users SET rem = 'yes' WHERE clean_username = '".addslashes(strtolower($username))."';");
								 }
                                        ob_end_clean();
                                        unset($btuser);
                                        userlogin($username, $btuser);
										if(!$return)header("Location: ".$siteurl."/user.php?op=loginconfirm");
										else
										header("Location: ".$return);
                                        die();
                                }
                                else {
                                        //user not active
                                $template->assign_vars(array(
                                        'S_ERROR'            => true,
                                        'S_ERROR_MESS'            => _btuserinactive,
                                ));
                                }
                        } else {
                                //bad data
						        logerror('User login failed for '.$username, 'Failed Login');
                                $template->assign_vars(array(
                                        'S_ERROR'            => true,
                                        'S_ERROR_MESS'            => _btuserpasswrong,
                                ));
                        }
                }
}
                               if(preg_match('/'.str_replace('/','\/',$siteurl).'/', $_SERVER["HTTP_REFERER"], $result)) $template->assign_vars(array(
                                        'S_RETURN_PAGE'            => $_SERVER["HTTP_REFERER"],
                                ));

echo $template->fetch('login.html');
?>
