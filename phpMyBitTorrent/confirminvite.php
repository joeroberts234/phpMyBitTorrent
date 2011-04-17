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
if (!eregi("confirminvite.php",$_SERVER["PHP_SELF"])) die ("You cannot include this file");
include("header.php");
global $db, $db_prefix;

function hash_pad($hash) {
    return str_pad($hash, 20);
}

$md5 = $secret;

if (!$id OR !is_numeric($id))
bterror(_bterridnotset,_btsorry);

        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE lastip = '".sprintf("%u",ip2long(getip()))."';")) != 0)
                bterror(_btdupip,_btsorry);

$sql = ("SELECT COUNT(*) FROM ".$db_prefix."_users");
$res = $db->sql_query($sql) or btsqlerror($sql);
$arr = $db->sql_fetchrow($res);

if ($arr[0] >= $invites1)
bterror(str_replace("**count**",$invites,_btusercount),_btsorry);

$sql = "SELECT password, active FROM ".$db_prefix."_users WHERE id = '".$db->sql_escape($id)."'";
$res = $db->sql_query($sql) or btsqlerror($sql);
$row = $db->sql_fetchrow($res);

if (!$row)
bterror(_bterrusernotexists,_btsorry);

if ($row["active"] != '0') {
OpenTable(_btsignup);
echo "<p>"._btuseralreadyactive."</p>";
CloseTable();
include('footer.php');
}

$sec = hash_pad($row["password"]);
if ($md5 != md5($sec))
bterror(_bterrinvalidactkey,_btsorry);
//die(md5($sec).'<br>'. $md5);

$secret = $row["password"];
$psecret = md5($row["password"]);

OpenTable(_btconinvite);

echo "<p>"._btcookies."</p>\n";
echo "<p>\n";
echo "<form method=\"post\" action=\"takeconfirminvite.php?id=$id&secret=$psecret\">\n";
echo "<CENTER><table border=\"0\" cellspacing=0 cellpadding=\"3\" width=90%>\n";
echo "<tr><td align=\"right\" class=\"heading\">"._btusername.":</td><td align=left><input type=\"text\" size=\"40\" name=\"wantusername\" /></td></tr>\n";
echo "<tr><td align=\"right\" class=\"heading\">"._btpasswd.":</td><td align=left><input type=\"password\" size=\"40\" name=\"wantpassword\" /></td></tr>\n";
echo "<tr><td align=\"right\" class=\"heading\">"._btpasswd2.":</td><td align=left><input type=\"password\" size=\"40\" name=\"passagain\" /></td></tr>\n";

echo "</td></tr>\n";
echo "<tr><td align=\"right\" class=\"heading\"></td><td align=left><input type=checkbox name=rulesverify value=yes>"._btreadrules."<br>\n";
echo "<input type=checkbox name=faqverify value=yes>"._btreadfaqs."<br>\n";
echo "<input type=checkbox name=ageverify value=yes>"._btofage."</td></tr>\n";
echo "<tr><td colspan=\"2\" align=\"center\"><input type=submit value=\""._btsubmit."\" style='height: 25px'></td></tr>\n";
echo "</table></CENTER>\n";
echo "</form>\n";
CloseTable();
include("footer.php");
?>