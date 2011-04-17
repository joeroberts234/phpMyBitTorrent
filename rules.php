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

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");
if($user->admin){
print("<br><table width=100% border=0 cellspacing=0 cellpadding=10>");
print("<tr><td align=center><a href=modrules.php?act=newsect>"._btrulesadd."</a></td></tr></table>\n");
}
$sql_rule = "select * from ".$db_prefix."_rules order by level;";
$res = $db->sql_query($sql_rule);
$db->sql_freeresult($sql_rule);

while ($arr = $db->sql_fetchrow($res)){
$rule = format_comment($arr["text"]);
parse_smiles($rule);
	if ($arr["public"]=="yes")
		{
		OpenTable($arr["title"]);
	print("<form method=post action=modrules.php?act=edit&id=".$arr["id"]."><table width=95% border=0 cellspacing=0 cellpadding=>");
	print("<tr><td width=100%>");
	echo "<tr><td><hr /></td><td></td></tr>\n";
	//echo ("".$arr["title"]."");
	echo "<p>".str_replace("\n","<br>",$rule)."</p>";
	if($user->admin)print("</td></tr><tr><td><input type=hidden value=".$arr["id"]." name=id><input type=submit value='"._btalt_edit."'></td></tr></table></form>");
		CloseTable();
		}
	if ($arr["public"]=="no")
		{

    if($user->user  && $arr["level"]=="user")
		{
		OpenTable($arr["title"]);
	print("<form method=post action=modrules.php?act=edit&id=".$arr["id"]."><table width=95% border=0 cellspacing=0 cellpadding=>");
	print("<tr><td width=100%>");
	echo "<tr><td><hr /></td><td></td></tr>\n";
	//echo ("".$arr["title"]."");
	echo "<p>".str_replace("\n","<br>",$rule)."</p>";
	if($user->admin)print("</td></tr><tr><td><input type=hidden value=".$arr["id"]." name=id><input type=submit value='"._btalt_edit."'></td></tr></table></form>");
		CloseTable();
		}
    if($user->premium && $arr["level"]=="premium")
		{
		OpenTable($arr["title"]);
	print("<form method=post action=modrules.php?act=edit&id=".$arr["id"]."><table width=95% border=0 cellspacing=0 cellpadding=>");
	print("<tr><td width=100%>");
	echo "<tr><td><hr /></td><td></td></tr>\n";
	//echo ("".$arr["title"]."");
	echo "<p>".str_replace("\n","<br>",$rule)."</p>";
	if($user->admin)print("</td></tr><tr><td><input type=hidden value=".$arr["id"]." name=id><input type=submit value='"._btalt_edit."'></td></tr></table></form>");
		CloseTable();
		}
    if($user->moderator && $arr["level"]=="moderator")
		{
		OpenTable($arr["title"]);
	print("<form method=post action=modrules.php?act=edit&id=".$arr["id"]."><table width=95% border=0 cellspacing=0 cellpadding=>");
	print("<tr><td width=100%>");
	echo "<tr><td><hr /></td><td></td></tr>\n";
	echo ("".$arr["title"]."");
	echo "<p>".str_replace("\n","<br>",$rule)."</p>";
	if($user->admin)print("</td></tr><tr><td><input type=hidden value=".$arr["id"]." name=id><input type=submit value='"._btalt_edit."'></td></tr></table></form>");
		CloseTable();
		}
    if($user->admin && $arr["level"]=="admin")
		{
		OpenTable($arr["title"]);
	print("<form method=post action=modrules.php?act=edit&id=".$arr["id"]."><table width=95% border=0 cellspacing=0 cellpadding=>");
	print("<tr><td width=100%>");
	echo "<tr><td><hr /></td><td></td></tr>\n";
	//echo ("".$arr["title"]."");
	echo "<p>".str_replace("\n","<br>",$rule)."</p>";
	if($user->admin)print("</td></tr><tr><td><input type=hidden value=".$arr["id"]." name=id><input type=submit value='"._btalt_edit."'></td></tr></table></form>");
		CloseTable();
		}
		}
}


include("footer.php");

?>