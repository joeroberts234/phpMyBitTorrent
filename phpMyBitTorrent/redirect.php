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
include('header.php');
  $url = '';
while(list($key, $value) = each($HTTP_GET_VARS)) 

{ 

	echo "$key = $value(br)"; 

}
  while (list($var,$val) = each($HTTP_GET_VARS))
    $url .= "&$var=$val";
$i = strpos($url, "&url=");
if ($i !== false)
	$url = substr($url, $i + 5);
	$title = getMetaTitle($url);
	OpenTable(_bt_redirect);
  print("<meta http-equiv=refresh content='3;url=$url'>\n");
  print("<table border=0 width=100% height=100%><tr><td><h3 align=center>"._btdspytorrentupdate1."<br />\n");
  print("$title</h3></td></tr></table>\n");
    CloseTable();
  include('footer.php');
?>