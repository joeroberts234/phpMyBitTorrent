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
* @version $Id: edit_signature.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
        if (!isset($signature) OR $signature == "") $signature = "";
        processinput("signature",$signature);
                $sql = "UPDATE ".$db_prefix."_users SET ";
                for ($i = 0; $i < count($sqlfields); $i++) $sql .= $sqlfields[$i] ." = ".$sqlvalues[$i].", ";
                $sql .= "act_key = ".(($admin_mode) ? "act_key" : "'".RandomAlpha(32)."'")." WHERE id = '".$uid."';"; //useless but needed to terminate SQL without a comma
                //echo $sql;
                //die();
                if (!$db->sql_query($sql)) btsqlerror($sql);
                if (!$admin_mode) userlogin($uname,$btuser); //SQL is executed, cookie is invalid and getusername() function returns nothing, so it must be called earlier

                                $template->assign_vars(array(
										'S_REFRESH'				=> true,
										'META' 				  	=> '<meta http-equiv="refresh" content="5;url=' . $siteurl . '/user.php?op=editprofile' . ((!$admin_mode) ? '' : "&amp;id=" .$uid  ) . '&amp;action=profile&amp;mode=signature" />',
										'S_ERROR_HEADER'		=>_admtrklastupdate,
                                        'S_ERROR_MESS'			=> PROFILE_UPDATED,
                                ));
				//trigger_error($message);
                echo $template->fetch('error.html');
				die();
?>