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
include("header.php");
global $db, $db_prefix;
if(isset($resolution))
{
if ($resolution =='half'){
$game_rez = "width=\"200\" height=\"250\"";
}
if ($resolution =='threeq'){
$game_rez = "width=\"300\" height=\"375\"";
}
if ($resolution =='none'){
$game_rez = "width=\"400\" height=\"500\"";
}
if ($resolution =='plus25'){
$game_rez = "width=\"500\" height=\"625\"";
}
if ($resolution =='plus50'){
$game_rez = "width=\"600\" height=\"750\"";
}
if ($resolution =='times2'){
$game_rez = "width=\"800\" height=\"1000\"";
}
}else{
$game_rez = "width=\"680\" height=\"430\"";
}

$res = "SELECT * FROM ".$db_prefix."_casino_config;";
$res_arcade = $db->sql_query($res);
$arr = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
while ($arr = $db->sql_fetchrow($res_arcade))
$arr_config[$arr['name']] = $arr['value'];
if (!$arr_config["enable"])bterror("<p><h3>"._bt_flash_closed."</h3></p>",_btsorry);
///////////////////////////////////////////////////////////////////
$access_level = $arr_config["class_allowed"];
switch ($access_level) {
        case "user": {
                if (!$user->user) loginrequired("user");
                break;
        }
        case "premium": {
                if (!$user->premium) loginrequired("premium");
                break;
        }
        case "moderator": {
                if (!$user->moderator) loginrequired("moderator");
                break;
        }
        case "admin": {
                if (!$user->admin) loginrequired("admin");
                break;
        }
}
$query ="select * from ".$db_prefix."_casino where userid = '".$user->id."';";
$result = $db->sql_query($query) or die (mysql_error());
if($db->sql_affectedrows()!=1)
{
 $db->sql_query("INSERT INTO ".$db_prefix."_casino (userid, win, lost, trys, date) VALUES(" .$viewing. ",0,0,0, NOW())") or mysql_error();
 //bterror("This is the first time you try to play at the Casino please refresh the site","Hi ".$user->name);
 $result = $db->sql_query($query); ///query another time to get the new user, if the bterror is uncomment
}
$row = $db->sql_fetchrow($result);
$user_enableplay = $row["enableplay"];

if($user_enableplay=="no")bterror(_btcasino_ban,btclassbanned); 
OpenTable($_GET["gamename"]);
echo"<div align=center>\n";
echo"<table  border=1 cellspacing=0 cellpadding=0><tr><td class=text>\n";
echo"<div align=center>\n";
echo"<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0\" ".$game_rez." >\n";
echo"<param name=movie value=\"flash/".$_GET["gameURI"]."\">\n";
echo"<param name=quality value=high>\n";
echo"<embed src=\"flash/".$_GET["gameURI"]."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" ".$game_rez.">\n";
echo"</embed>\n";
echo"</object>\n";
if(isset($_GET["gameid"]))
{
$gameID=$_GET["gameid"];
if($gameID==1)
{
print("<table  border=1><tr><td colspan=3><center><B>"._bt_flash_game_ast."</B></center></td></tr>");
}
if($gameID==2)
{
print("<table border=1><tr><td colspan=3><center><B>"._bt_flash_game_bre."</B></center></td></tr>");
}
if($gameID==3)
{
  print("<table border=1><tr><td colspan=3><center><B>"._bt_flash_game_hex."</B></center></td></tr>");
}
if($gameID==4)
{
  print("<table border=1><tr><td colspan=3><center><B>"._bt_flash_game_inv."</B></center></td></tr>");
}
if($gameID==5)
{
  print("<table border=1><tr><td colspan=3><center><B>"._bt_flash_game_moo."</B></center></td></tr>");
}
if($gameID==6)
{
  print("<table border=1><tr><td colspan=3><center><B>"._bt_flash_game_pac."</B></center></td></tr>");
}
if($gameID==7)
{
  print("<table border=1><tr><td colspan=3><center><B>"._bt_flash_game_sol."</B></center></td></tr>");
}
if($gameID==8)
{
  print("<table border=1><tr><td colspan=3><center><B>"._bt_flash_game_sim."</B></center></td></tr>");
}
if($gameID==9)
{
  print("<table border=1><tr><td colspan=4><center><B>"._bt_flash_game_sna."</B></center></td></tr>");
}
if($gameID==10)
{
  print("<table border=1><tr><td colspan=4><center><B>"._bt_flash_game_tet."</B></center></td></tr>");
}
  print("<tr><td>"._bt_flash_rank."</td><td width=75%>"._bt_flash_name."</td><td>"._bt_flash_level."</td></tr>");
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." ORDER BY score DESC LIMIT 10;");
 while($scores = $db->sql_fetchrow($result))
 {
$userresult = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id = ".$scores["user"].";");
$user = $db->sql_fetchrow($userresult);
$username = $user["username"];
$ranking = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." AND score > ".$scores["score"].";");
if($rankrow = $db->sql_fetchrow($ranking))
{
$rank = $rankrow[0]+1;
}else{
 $rank = 1;
}
if($gameID < 9)
{
  if($scores["user"]== $user->id)
  {
 print("<tr style=\"background-color: #BBBBBB\"><td>".$rank."</td><td width=75%>".$username."</td><td><div style=\"text-align:right;width:100%;\">".$scores["score"]."</div></td></tr>");
  }else{
 print("<tr><td>".$rank."</td><td>".$username."</td><td><div style=\"text-align:right;width:100%;\">".$scores["score"]."</div></td></tr>");
  }
}else{
  if($scores["user"]== $user->id)
  {
 print("<tr style=\"background-color: #BBBBBB\"><td>".$rank."</td><td width=75%>".$username."</td><td>".$scores["level"]."</td><td><div style=\"text-align:right;width:100%;\">".$scores["score"]."</div></td></tr>");
  }else{
 print("<tr><td>".$rank."</td><td>".$username."</td><td>".$scores["level"]."</td><td><div style=\"text-align:right;width:100%;\">".$scores["score"]."</div></td></tr>");
  }
}
 }
 $yourresult = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." AND user = '".$user->id."' ORDER BY score DESC LIMIT 1;");
 if($yourscore = $db->sql_fetchrow($yourresult))
 {
$yourhighscore = $yourscore["score"];
$yourlevel = $yourscore["level"];
$yourranking = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." AND score > ".$yourhighscore.";");
if($ranking = $db->sql_fetchrow($yourranking))
{
 $yourrank = $ranking[0]+1;
}else{
 $yourrank = 1;
}
if($yourrank>10)
{
if($gameID < 9)
{
 print("<tr style=\"background-color: #BBBBBB\"><TD>".$yourrank."</td><td width=75%>".$user->name."</td><td><div style=\"text-align:right;width:100%;\">".$yourhighscore."</div></td></tr>");
}else{
 print("<tr style=\"background-color: #BBBBBB\"><TD>".$yourrank."</td><td width=75%>".$user->name."</td><td>".$yourlevel."</td><td><div style=\"text-align:right;width:100%;\">".$yourhighscore."</div></td></tr>");
}
}
 }
 print("</table></P>");
}else{
  print("<table border=1><tr><td><center><B>".$_GET["gamename"]."</B></center></td></tr>");
print("<tr><td>Unable to Save HighScores for this Game!</td></tr>");
print("</table>");
}
echo"</table>";
echo"<table><tr><td><form style=\"margin-bottom:0;\" action=\"./flash.php\" method=\"get\">
					<input name=\"gameURI\" type=\"hidden\" value=\"".$_GET["gameURI"]."\" />
					<input name=\"gamename\" type=\"hidden\" value=\"".$_GET["gamename"]."\" />
					<input name=\"gameid\" type=\"hidden\" value=\"".$_GET["gameid"]."\" />
					<span class=\"gensmall\"><b>"._bt_flash_set_rez."</b><br /><select name='resolution' onchange='this.form.submit();'>
										<option selected=\"selected\">"._btplmselect."</option>
										<option  value='half'>200 x 250</option>
										<option  value='threeq'>300 x 375</option>
										<option  value='none'>400 x 500</option>
										<option  value='plus25'>500 x 625</option>
										<option  value='plus50'>600 x 750</option>
										<option  value='times2'>800 x 1000</option></select></span>
				</form></td></tr></table>";
CloseTable();

include ("footer.php");
?>
