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
*------              ©2009 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/

$on_index = true;
if(isset($template))$on_index = false;
global $db_prefix;
$sql = ("SELECT id, name, downloaded, completed, seeders, leechers, added FROM ".$db_prefix."_torrents WHERE leechers > 0 AND seeders = 0 ORDER BY leechers DESC LIMIT 10");
$res = $db->sql_query($sql) or btsqlerror($sql);
$need_seed = array();
if ($db->sql_numrows($res) > 0)
	{
if(!$on_index){
	$template->assign_vars(array(
	'IS_NEED_SEEDS' => true,
	));
	}
	$i=0;
if($on_index)OpenTable(_btneedseed);
if($on_index)	print("<center><table  style=\"width: 100%;\" class=table_table border=2 cellspacing=0 cellpadding=0 >\n");
if($on_index)	print ("<CENTER><B>"._btifyhhelpthem."</B></CENTER>\n");
if($on_index)	print("<tr><td class=colhead>"._bttorrent."</td><td class=colhead>"._btleechers."</td><td class=colhead>"._btdownloaded."</td><td class=colhead>"._btsnatch."</td><td class=colhead>"._btadded."</td></tr>\n");
		while ($arr = $db->sql_fetchrow($res))
			{
			$torrname = htmlspecialchars($arr['name']);
			$torrname = str_replace(array('-','_'),array(' ',' '),$torrname);
				if (strlen($torrname) > 55)
				$torrname = substr($torrname, 0, 55) . "...";
if(!$on_index){
$need_seed[] = array_push($need_seed,array(
'SEED_NAME_SHORT' => $torrname,
'SEED_ID' => $arr['id'],
'SEED_NAME' => htmlspecialchars(stripslashes($arr['name'])),
'SEED_LEECH' => number_format($arr['leechers']),
'SEED_DOWN' => number_format($arr['downloaded']),
'SEED_ADDED' => $arr['added'],
'SEED_COMPL' => number_format($arr['completed'])));
}
$i++;
if($on_index)			print("<tr><td class=table_col1  align=left><a href=\"details.php?id=".$arr['id']."&hit=1\" alt=\"".$arr['name']."\" 	title=\"".$arr['name']."\">".((strlen($arr['name']) <= 30) ? $arr['name']: substr($arr['name'],0,27)."...")."</a></td><td  class=table_col1><font color=red> ".number_format($arr['leechers'])." </td><td  class=table_col1>  ".$arr['downloaded']."  </td><td  class=table_col1>  ".$arr['completed']."  </td><td  class=table_col1>  ".$arr['added']."  </td></tr>\n");
			}
if($on_index)		print("</table></center>\n");


if($on_index)CloseTable();
}
else
{
if(!$on_index){
	$template->assign_vars(array(
	'IS_NEED_SEEDS' => false
	));
	}
/*if($on_index)OpenTable(_btneedseed);
if($on_index)echo"<p><center><h3>"._btntnseeded."</h3></center></p>";
if($on_index)CloseTable();*/
}
?>