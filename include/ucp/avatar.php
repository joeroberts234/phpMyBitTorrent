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
* @version $Id: edit_profile_info.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
$galery = '';
$galery .= "<option value=\"none\">"._btchooseavatar."</option>";
$galery .= "<option value=\"blank.gif\">"._btnone."</option>";
$dhandle = opendir("./".$avgal."/");
while ($file = readdir($dhandle)) {
        if (is_dir("./".$avgal."/".$file) OR $file == "blank.gif" OR !eregi("\.(gif|jpg|png)$",$file)) continue;
        $galery .= "<option value=\"".$file."\">".$file."</option>";
}
$template->assign_vars(array(
        'CP_UAVATAR'            => gen_avatar($userrow["id"]),
		'ALLOW_AVATAR_UPLOAD'   => $avuploadon,
		'ALLOW_AVATAR_LINK'     => $avremoteon,
		'ALLOW_AVATAR_GALORY'   => $avgalon,
		'ALLOW_AVATAR'          => $avon,
		'AVATAR_MAXHT'          => $avmaxht,
		'AVATAR_MAXWT'          => $avmaxwt,
		'AVATAR_MAXSZ'          => mksize($avmaxwt),
		'AVATAR_MAXSZ_SEL'      => $galery,
));

?>