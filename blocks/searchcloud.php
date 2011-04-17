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
if (eregi("searchcloud.php",$_SERVER["PHP_SELF"])) die("You can't access this file directly");

$bubble =""; 
$i = 1;
                        $sql ="SELECT text, hit FROM ".$db_prefix."_search_text ORDER BY RAND() LIMIT 20 ;";
                        $result = $db->sql_query($sql);
                        while($row = $db->sql_fetchrow($result)){
					    $hit = $row['hit']/10;
					    if($hit>=5) $hit = "5";
					    $text = str_replace(' ','+',$row["text"]);
						$bubble .= "<a title=\"".$text."\" href=\"search.php?search=".$text."&amp;dead=ok\"><font size=\"".$hit."\" color=\"0000FF\"><b>".$row["text"]."</b></font></a>,   ";
						$i++;
						}
$bubble .="";
$i++;
OpenTable(_btsearchcloud);
help(pic("help.gif"),_btsearchcloudexplain,_btsearchcloud);
echo '<div class="search_cloud"><p class="search_cloud">'.$bubble.'</p></div>';
CloseTable();
?>