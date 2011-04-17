<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*----------         Developed By Emad Hossam (aka emadness)          ----------*
*-------------               http://www.fulldls.com               -------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*------------------------ Mod By Nightcrawler ---------------------------------*
*------------------------------------------------------------------------------*
*/
include("header.php");
global $db_prefix;

$iduser=$_GET["iduser"];

$sql="SELECT * FROM ".$db_prefix."_users WHERE id ='$iduser';";
$res = $db->sql_query($sql)or btsqlerror($sql);
$rowuser=$db->sql_fetchrow($res);



(isset($_POST["username"]) && !empty($_POST["username"])) ? $username = mysql_real_escape_string($_POST["username"]) : $username = "";
(isset($_POST["bonus"]) && !empty($_POST["bonus"]) && is_numeric($_POST["bonus"])) ? $bonus = $_POST["bonus"] : $bonus = 0;
(isset($_POST["why"]) && !empty($_POST["why"])) ? $why = mysql_real_escape_string($_POST["why"]) : $why = "";

if(!$user->user || $user->id==0)loginrequired("user", true);
if($username=="")bterror("Error"," You didn't enter a name!");
if($why=="")bterror("Error"," You didn't enter a Reason!");
if ($bonus <=0)bterror("Error"," Not a positive value");
if($bonus > $user->seedbonus)bterror("Error"," You can't transfer more points than you have!");
if($user->name==$username)bterror("Error"," You can't transfer points to yourself!");

$res1 = "SELECT id FROM ".$db_prefix."_users WHERE username = '".$username."'";
$query = $db->sql_query($res1)or btsqlerror($res1);
$res2 = $db->sql_fetchrow($query);
$kapo2 = $res2["id"];
$kuldo = $user->id;
if (!$kapo2)bterror("Error"," Woops, can't find anyone with That name. $username");
$db->sql_query("UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + $bonus WHERE id = '$kapo2'") or sqlerr(__FILE__, __LINE__);
$db->sql_query("UPDATE ".$db_prefix."_users SET seedbonus = seedbonus - $bonus WHERE id = '$kuldo'") or sqlerr(__FILE__, __LINE__);

if ($_POST["anonym"] != 'anonym') {
//pm subject here
$targy = addslashes("Bonus points received");
//pm message text here
$msg = addslashes("User ".$user->name." left something for you: $bonus bonus point. \nHeres a message from them:\n $why");
@$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('0','".$kapo2."','".$targy."','".$msg."',NOW())");
}else{
$targy = addslashes("Bonus points received");
$msg = addslashes("An anonymous user left this for you: $bonus bonus points.");
@$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('0','".$kapo2."','".$targy."','".$msg."',NOW())");
}
OpenSuccTable("Bonus Transfered!");
echo("<center><h3>Job Done Bonus points Successfully sent to $username</h3></center>");
CloseSuccTable();
include'footer.php';
?>