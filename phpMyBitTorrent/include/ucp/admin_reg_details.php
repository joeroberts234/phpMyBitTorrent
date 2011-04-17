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
$hiden = array(
'take_edit'				=> '1',
'action'				=> 'profile',
'op'				=> 'editprofile',
'mode'				=> 'admin_reg_details',
);

        $adminlevel = "<select name=\"level\">";
        $adminlevel .= "<option ".(($userrow["level"] == "user") ? "selected " :'' )."value=\"user\">"._btclassuser."</option>";
        $adminlevel .= "<option ".(($userrow["level"] == "premium") ? "selected " :'' )."value=\"premium\">"._btclasspremium."</option>";
        $adminlevel .= "<option ".(($userrow["level"] == "moderator") ? "selected " :'' )."value=\"moderator\">"._btclassmoderator."</option>";
        $adminlevel .= "<option ".(($userrow["level"] == "admin") ? "selected " :'' )."value=\"admin\">"._btclassadmin."</option>";
        $adminlevel .= "</select>";
$template->assign_vars(array(
		'S_HIDDEN_FIELDS'		=> build_hidden_fields($hiden),
        'CP_MOD_COMENTS'        => $userrow["modcomment"],
		'U_SEEDBOX_IP'          => long2ip($userrow["seedbox"]),
		'U_IS_WARNED'           => ($userrow["warned"]) ? true : false,
		'U_WARNED_TELL'         => ($userrow["warned"]) ? gmdate("Y-m-d H:i:s",($userrow["warn_kapta"]+$userrow["warn_hossz"])) : '',
		'U_ACTIVATED_ACC'       => ($userrow["active"] == "1") ? true : false,
		'U_SITE_HELPER'         => ($userrow['helper'] == 'true') ? true : false,
		'U_FORUM_BANNED'        => ($userrow['forumbanned'] == 'yes') ? true : false,
		'U_SITE_HELP_WITH'      => $userrow["help_able"],
        'CP_TRUEUPLOADED'       => $userrow["uploaded"],
        'CP_TRUEDOWNLOADED'     => $userrow["downloaded"],
        'CP_INVITES'            => $userrow["invites"],
        'CP_SEED_POINTS'        => $userrow["seedbonus"],
        'CP_UUPLOADED'          => mksize($userrow["uploaded"]),
        'CP_UDOWNLOADED'        => mksize($userrow["downloaded"]),
        'CP_URATIO'             => get_u_ratio($userrow["uploaded"], $userrow["downloaded"]),
        'CP_UCOLOR'             => getusercolor($userrow["can_do"]),
		'CP_DISABLED'			=> ($userrow["disabled"] == 'true') ? true : false,
        'CP_DISABLED_REASON'	=> $userrow["disabled_reason"],
        'CP_UCANSHOUT'          => ($userrow["can_shout"] == 'true') ? true : false,
        'CP_UCAN_DO'            => $userrow["can_do"],
        'CP_UGROUP'             => getlevel($userrow["can_do"]),
		'S_GROUP_OPTIONS'	    => selectaccess($al= $userrow["can_do"]),
		'S_SHOW_ACTIVITY'		=> true,
		'A_GROUP'               => selectaccess($userrow["can_do"]),
		'A_LEVEL'               => $adminlevel,
));
?>