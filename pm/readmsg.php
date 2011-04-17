<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
if (!eregi("pm.php",$_SERVER["PHP_SELF"])) die ("You cannot access this file directly");

if (!isset($mid) OR !is_numeric($mid)) bterror(_btinvalidpm,_btmessage);

if ($mode == "inbox") {
		$sql = "SELECT P.*, IF (U.name IS NULL, U.username, U.name) AS sender_name, U.avatar AS avatar, IF (M.slave IS NULL, 0, 1) AS bookmark, IF (B.slave IS NULL, 0, 1) AS blacklist FROM ".$db_prefix."_private_messages P LEFT JOIN ".$db_prefix."_users U ON P.sender = U.id LEFT JOIN ".$db_prefix."_private_messages_bookmarks M ON M.slave = P.sender AND M.master = P.recipient LEFT JOIN ".$db_prefix."_private_messages_blacklist B ON B.slave = P.sender AND B.master = P.recipient WHERE P.recipient = '".$user->id."' AND P.id = '".$mid."';";

		$res = $db->sql_query($sql);
		$row = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
	
		#if (!$row) bterror(_btpmnoexists,_btmessage);
		OpenTable(_btmessage);	
		echo "<table style=\"width: 100%; border: 1px solid #CDCDCF; border-collapse: collapse;\" cellspacing=\"5\" cellpadding=\"5\">\n";
		echo "<tr class=\"brightrow\"><td>";
		echo "<p>"._btpmfrom."</p></td><td width=\"70%\">";
		echo "<div style=\"width:100px; text-align: center;\">";
		echo gen_avatar($row["sender"]);
		if($row["sender"] == 0)echo "<br>System</div></td>";
		if($row["sender"] !=0)echo "<br><a href=\"user.php?op=profile&id=".$row["sender"]."\">".$row["sender_name"]."</a></div></td>";
		echo "<td>Friend or Foe<br>";
		if (!intval($row["bookmark"])) echo pic("pm_bookmark.png","pm.php?op=bookmark&id=".$row["sender"],_btpmbookmarkuser);
		if (intval($row["bookmark"])) echo pic("pm_rmbookmark.png","pm.php?op=removebookmark&id=".$row["sender"],_btpmunbookmarkuser);
		if (!intval($row["blacklist"])) echo pic("pm_blacklist.png","pm.php?op=blacklist&id=".$row["sender"],_btpmblacklistuser);
		if (intval($row["blacklist"])) echo pic("pm_rmblacklist.png","pm.php?op=removeblacklist&id=".$row["sender"],_btpmunblacklistuser);
		echo "</td></tr>\n";
		echo "<tr class=\"darkrow\"><td><p>"._btpmsub."</p></td><td><p>".stripslashes(htmlspecialchars($row["subject"]))."</p></td><td></td></tr>\n";
		$replytext = format_comment($row["text"]);
		parse_smiles($replytext);
		echo "<tr><td><p>"._btpmtext."</p></td><td style=\"padding-top: 20px;\">".stripslashes($replytext)."</td><td></td></tr>\n";
		echo "</table>";
		echo "<br>";
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		echo "<tr>\n";
		echo "<td><p align=\"left\">".pic("pm_reply.png","pm.php?op=send&replyto=".$mid,_btpmreply)."</p></td>\n";
		echo "<td><p align=\"right\">".pic("pm_delete.png","pm.php?op=inbox_del&mid=".$row["id"],_btpmdelete)."</p></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		CloseTable();

		$sql = "UPDATE ".$db_prefix."_private_messages SET is_read = 'true' WHERE recipient = '".$user->id."' AND id = '".$mid."';";
		$db->sql_query($sql) or btsqlerror($sql);
	}

if ($mode == "outbox") {
		$sql = "SELECT P.*, IF (U.name IS NULL, U.username, U.name) AS recipient_name, U.avatar AS avatar FROM ".$db_prefix."_private_messages P LEFT JOIN ".$db_prefix."_users U ON P.recipient = U.id LEFT JOIN ".$db_prefix."_private_messages_bookmarks M ON M.slave = P.recipient AND M.master = P.sender LEFT JOIN ".$db_prefix."_private_messages_blacklist B ON B.slave = P.recipient AND B.master = P.sender WHERE P.sender = '".$user->id."' AND P.id = '".$mid."';";

		$res = $db->sql_query($sql);
		$row = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);

		#if (!$row) bterror(_btpmnoexists,_btmessage);
		OpenTable(_btmessage);

		echo "<table style=\"width: 100%; border: 1px solid #CDCDCF; border-collapse: collapse;\" cellspacing=\"5\" cellpadding=\"5\">\n";
		echo "<tr class=\"brightrow\"><td>";
		echo "<p>"._btpmto."</p></td><td width=\"70%\">";
		echo "<div style=\"width:100px; text-align: center;\">";
		echo gen_avatar($row["recipient"]);
		echo "<br><a href=\"user.php?op=profile&id=".$row["recipient"]."\">".$row["recipient_name"]."</a></div></td>";
		echo "<td>Friend or Foe<br>";
		if (!intval($row["bookmark"])) echo pic("pm_bookmark.png","pm.php?op=bookmark&id=".$row["recipient"],_btpmbookmarkuser);
		if (intval($row["bookmark"])) echo pic("pm_rmbookmark.png","pm.php?op=removebookmark&id=".$row["recipient"],_btpmunbookmarkuser);
		if (!intval($row["blacklist"])) echo pic("pm_blacklist.png","pm.php?op=blacklist&id=".$row["recipient"],_btpmblacklistuser);
		if (intval($row["blacklist"])) echo pic("pm_rmblacklist.png","pm.php?op=removeblacklist&id=".$row["recipient"],_btpmunblacklistuser);
		echo "</td></tr>\n";
		echo "<tr class=\"darkrow\"><td><p>"._btpmsub."</p></td><td><p>".stripslashes(htmlspecialchars($row["subject"]))."</p></td><td></td></tr>\n";
		$replytext = format_comment($row["text"]);
		parse_smiles($replytext);
		echo "<tr><td><p>"._btpmtext."</p></td><td>".stripslashes($replytext)."</td><td></td></tr>\n";
		echo "</table>";
		echo "<br>";
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		echo "<tr>\n";
		echo "<td><p align=\"left\">".pic("pm_reply.png","pm.php?op=send&replyto=".$mid,_btpmreply)."</p></td>\n";
		echo "<td><p align=\"right\">".pic("pm_delete.png","pm.php?op=outbox_del&mid=".$row["id"],_btpmdelete)."</p></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		CloseTable();
	}

?>
