<?php 
/* 
*------------------------------phpMyBitTorrent V 2.0.4-------------------------* 
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
*------              2009 phpMyBitTorrent Development Team              ------* 
*-----------               http://phpmybittorrent.com               -----------* 
*------------------------------------------------------------------------------* 
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------* 
*/ 
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (!function_exists("sha1")) require_once("include/sha1lib.php");
if (!ini_get('display_errors')) {
    ini_set('display_errors', 1);
}
require_once("include/errors.php");
$old_error_handler = set_error_handler("myErrorHandler");
require_once("include/config.php"); //if config file has not been loaded yet
if (!eregi("download.php",$_SERVER['PHP_SELF']))include_once ("./include/forum_settings.php");
if (!eregi("download.php",$_SERVER['PHP_SELF']))include_once ("./include/functions_phpBB3.php"); 
include_once'include/class.template.php';
require_once("include/actions.php");
require_once("include/user.functions.php");
?>