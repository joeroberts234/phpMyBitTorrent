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
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: edit_personal.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
        if (isset($accept_mail) AND $accept_mail == "true") {
                $sqlfields[] = "accept_mail";
                $sqlvalues[] = "'yes'";
        } else {
                $sqlfields[] = "accept_mail";
                $sqlvalues[] = "'no'";
        }
        if (isset($mass_mail) AND $mass_mail == "yes") {
                $sqlfields[] = "mass_mail";
                $sqlvalues[] = "'yes'";
        } else {
                $sqlfields[] = "mass_mail";
                $sqlvalues[] = "'no'";
        }
        if (isset($pm_notify) AND $pm_popup == "true") {
                $sqlfields[] = "pm_popup";
                $sqlvalues[] = "'true'";
        } else {
                $sqlfields[] = "pm_popup";
                $sqlvalues[] = "'false'";
        }
        if (isset($pm_notify) AND $pm_notify == "true") {
                $sqlfields[] = "pm_notify";
                $sqlvalues[] = "'true'";
        } else {
                $sqlfields[] = "pm_notify";
                $sqlvalues[] = "'false'";
        }
        if (isset($Show_online) AND $Show_online == "true") {
                $sqlfields[] = "Show_online";
                $sqlvalues[] = "'true'";
        } else {
                $sqlfields[] = "Show_online";
                $sqlvalues[] = "'false'";
        }
        if (($userrow["passkey"] == "" AND isset($use_passkey) AND $use_passkey == "true") OR (isset($use_passkey) AND $use_passkey == "true" AND isset($passkey_reset) AND $passkey_reset == "true")OR(isset($passkey_reset) AND $passkey_reset == "true" AND $force_passkey)) {
                //Generate new Passkey
                do {
                        $passkey = RandomAlpha(32);
                        //Check whether passkey already exists
                        $sql = "SELECT passkey FROM ".$db_prefix."_users WHERE passkey = '".$passkey."';";
                        $res = $db->sql_query($sql);
                        $cnt = $db->sql_numrows($sql);
                        $db->sql_freeresult($res);
                } while ($cnt > 0);
                processinput("passkey",$passkey);

        } elseif((!isset($use_passkey) OR $use_passkey != "true") AND $userrow["passkey"] != "") {
                //Remove Passkey
                $passkey = "NULL";
                if(!$force_passkey)processinput("passkey",$passkey);
        }
        if ($customlang == "0" OR !is_readable("language/".$customlang.".php")) $customlang = "NULL";
        processinput("language",$customlang);

        if ($customtheme == "0" OR $customtheme == "CVS" OR !is_dir("themes/".$customtheme)) $customtheme = "NULL";
        processinput("theme",$customtheme);
		if (!isset($offset) OR $offset =="") $offset = '0';
		processload("tzoffset",$offset);
        if (!isset($user_torrent_per_page) OR $user_torrent_per_page == "") $user_torrent_per_page = "NULL";
        processload("torrent_per_page",$user_torrent_per_page);
?>