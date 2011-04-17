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
include("header.php");
global $db, $db_prefix;




OpenTable("Score Stats");
if (!is_user($btuser)) loginrequired("user");


?>
<table width=100% border=1 cellspacing=0 cellpadding=10><tr><td class=text>
<div align=center><CENTER><I>Stats from all Games Played</CENTER>
<?php
 $ID=0;
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores GROUP BY user");
 while($populate = $db->sql_fetchrow($result))
 {
$ID++;
if(!isset($gamesplayed[$ID]))
{
 $gamesplayed[$ID]=0;
}
if(!isset($totalscore[$ID]))
{
 $totalscore[$ID]=0;
}
if(!isset($megascore[$ID]))
{
 $megascore[$ID]=0;
}
if(!isset($losspoints[$ID]))
{
 $losspoints[$ID]=0;
}
if(!isset($averagerank[$ID]))
{
 $averagerank[$ID]=0;
}
if(!isset($player[$populate["user"]]))
{
 $player[$populate["user"]]=$ID;
}
if(!isset($IDofuser[$ID]))
{
 $IDofuser[$ID]=$populate["user"];
}
 }
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores ORDER BY score DESC");
 while($scores = $db->sql_fetchrow($result))
 {
   $ranking = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_flashscores WHERE game = ".$scores["game"]." AND score > ".$scores["score"]."") OR DIE(MySQL_ERROR());
if($rankrow = $db->sql_fetchrow($ranking))
{
 $rank = $rankrow[0]+1;
}else{
 $rank = 1;
}
   $losspoints[$player[$scores["user"]]]+=$rank;
if($rank<6)
{
 $totalscore[$player[$scores["user"]]]+=(10-(($rank-1)*2));
}
$megascore[$player[$scores["user"]]]+=$scores["score"];
 }
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores GROUP BY user");
 while($scores = $db->sql_fetchrow($result))
 {
         $result2 = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_flashscores WHERE user = ".$scores["user"]."");
   if($gamesamount = $db->sql_fetchrow($result2))
   {
  $amountofgames = $gamesamount[0];
   }
 $gamesplayed[$player[$scores["user"]]]=$amountofgames;
 }
arsort ($totalscore);
reset ($totalscore);
print("<TABLE><TR><TD COLSPAN=2><B><CENTER>Rank Based Scores</CENTER></B></TD></TR>");
while (list ($userID, $score) = each ($totalscore)) {
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id = '".$IDofuser[$userID]."'")or bterr(result);
 if($userX = $db->sql_fetchrow($result))
 {
 $username = $userX["username"];
 }else{
 $username = "Unknown?!";
 }
if($score>0)
{
 if($IDofuser[$userID]==$user->id)
 {
  echo "<TR style=\"background-color: #BBBBBB\"><TD>$username</TD><TD>$score</TD></TR>";
  }else{
  echo "<TR><TD>$username</TD><TD>$score</TD></TR>";
  }
}
}
print("</TABLE><P>");
arsort ($gamesplayed);
reset ($gamesplayed);
print("<TABLE><TR><TD COLSPAN=2><B><CENTER>Number of games played</CENTER></B></TD></TR>");
while (list ($userID, $games) = each ($gamesplayed)) {
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id = '".$IDofuser[$userID]."'");
 if($userX = $db->sql_fetchrow($result))
 {
 $username = $userX["username"];
 }else{
 $username = "Unknown?!";
 }
if($games>0)
{
 if($IDofuser[$userID]==$user->id)
 {
  echo "<TR style=\"background-color: #BBBBBB\"><TD>$username</TD><TD>$games</TD></TR>";
 }else{
  echo "<TR><TD>$username</TD><TD>$games</TD></TR>";
  }
}
}
print("</TABLE><P>");
arsort ($megascore);
reset ($megascore);
print("<TABLE><TR><TD COLSPAN=2><B><CENTER>Total Score</CENTER></B></TD></TR>");
while (list ($userID, $score) = each ($megascore)) {
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id = '".$IDofuser[$userID]."'");
 if($userX = $db->sql_fetchrow($result))
 {
 $username = $userX["username"];
 }else{
 $username = "Unknown?!";
 }
if($score>0)
{
 if($IDofuser[$userID]==$user->id)
 {
  echo "<TR style=\"background-color: #BBBBBB\"><TD>$username</TD><TD>$score</TD></TR>";
  }else{
  echo "<TR><TD>$username</TD><TD>$score</TD></TR>";
  }
}
}
print("</TABLE><P>");
asort ($losspoints);
reset ($losspoints);
print("<TABLE><TR><TD COLSPAN=2><B><CENTER>Loose points</CENTER></B></TD></TR>");
while (list ($userID, $score) = each ($losspoints)) {
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id = '".$IDofuser[$userID]."'");
 if($userX = $db->sql_fetchrow($result))
 {
 $username = $userX["username"];
 }else{
 $username = "Unknown?!";
 }
if($score>0)
{
 if($IDofuser[$userID]==$user->id)
 {
  echo "<TR style=\"background-color: #BBBBBB\"><TD>$username</TD><TD>$score</TD></TR>";
  }else{
  echo "<TR><TD>$username</TD><TD>$score</TD></TR>";
  }
}
}
print("</TABLE><P>");
 $ID=0;
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores GROUP BY user");
 while($populate = $db->sql_fetchrow($result))
 {
$ID++;
$averagerank[$ID]=$losspoints[$ID]/$gamesplayed[$ID];
 }
asort ($averagerank);
reset ($averagerank);
print("<TABLE><TR><TD COLSPAN=2><B><CENTER>Average Rate</CENTER></B></TD></TR>");
while (list ($userID, $score) = each ($averagerank)) {
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id = '".$IDofuser[$userID]."'");
 if($userX = $db->sql_fetchrow($result))
 {
 $username = $userX["username"];
 }else{
 $username = "Unknown?!";
 }
if($score>0)
{
 if($IDofuser[$userID]==$user->id)
 {
  echo "<TR style=\"background-color: #BBBBBB\"><TD>$username</TD><TD>$score</TD></TR>";
  }else{
  echo "<TR><TD>$username</TD><TD>$score</TD></TR>";
  }
}
}
print("</TABLE><P>");
?>
</td></tr>
</table>
</form>
<br/>
<center><a href=arcade.php><h2>Return to Games Choice</h2></a></center>
</div>

<?php
CloseTable();
include ("footer.php");
?>
