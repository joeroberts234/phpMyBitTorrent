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

if (!defined('IN_PMBT')) die ("You can't access this file directly");

OpenTable(_btsyndicate);
echo "<ul>\n";
echo "<li>".pic("rss.gif",$siteurl."/backend.php?op=last","RSS")."</li>\n";
echo "<li>".pic("bloglines.gif","http://www.bloglines.com/sub/".urlencode($siteurl."/backend.php?op=last"),"Bloglines")."</li>\n";
echo "<li>".pic("mymsn.gif","http://my.msn.com/addtomymsn.armx?id=rss&amp;ut=".urlencode($siteurl."/backend.php?op=last")."&amp;ru=".urlencode($siteurl),"My MSN")."</li>\n";
echo "<li>".pic("myyahoo.gif","http://add.my.yahoo.com/rss?url=".urlencode($siteurl."/backend.php?op=last"),"My Yahoo!")."</li>\n";
echo "<li>".pic("newsgator.gif","http://www.newsgator.com/ngs/subscriber/subext.aspx?url=".urlencode($siteurl."/backend.php?op=last"),"Newsgator")."</li>\n";
echo "<li>".pic("googlereader.gif","http://www.google.com/ig/add?feedurl=".urlencode($siteurl."/backend.php?op=last"),"Google Reader")."</li>\n";
echo "</ul>\n";
CloseTable();

?>