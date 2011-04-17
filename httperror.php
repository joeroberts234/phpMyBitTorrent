<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
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
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");

switch ($errid) {
        case 400: {
                header("HTTP/1.0 400 Bad request");
                bterror(str_replace("**email**",spellmail($admin_email),_http400errtxt),_http400errttl);
                break;
        }
        case 401: {
                header("HTTP/1.0 401 Access Denied");
                bterror(str_replace("**email**",spellmail($admin_mail),_http401errtxt),_http401errttl);
                break;
        }
        case 403: {
                header("HTTP/1.0 403 Forbidden");
                bterror(str_replace("**email**",spellmail($admin_mail),_http403errtxt),_http403errttl);
                break;
        }
        case 404: {
                header("HTTP/1.0 404 Access Denied");
                bterror(str_replace("**email**",spellmail($admin_mail),_http404errtxt),_http404errttl);
                break;
        }
        case 500: {
                header("HTTP/1.0 500 Internal Server Error");
                bterror(str_replace("**email**",spellmail($admin_mail),_http500errtxt),_http500errttl);
                break;
        }

}

include("footer.php");
?>