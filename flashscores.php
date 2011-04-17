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
$viewing = $user->id;
$sql = ("SELECT * FROM ".$db_prefix."_casino_config") ;
$res = $db->sql_query($sql) or btsqlerror($sql);
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];
if (!$arr_config["enable"])bterror("ARCADE is Closed, try later...","Sorry");
//////////////////////////////////////////////////////////////////////////
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
$query ="select * from ".$db_prefix."_casino where userid = '".$viewing."';";
$result = $db->sql_query($query) or die (mysql_error());
if($db->sql_affectedrows()!=1)
{
 $db->sql_query("INSERT INTO ".$db_prefix."_casino (userid, win, lost, trys, date) VALUES(" .$viewing. ",0,0,0, NOW())") or mysql_error();
 //bterror("This is the first time you try to play at the Casino please refresh the site","Hi ".$user->name);
 $result = $db->sql_query($query); ///query another time to get the new user, if the bterror is uncomment
}
$row = $db->sql_fetchrow($result);
$user_enableplay = $row["enableplay"];

if($user_enableplay=="no")
 bterror("Sorry ".getusername($btuser)."you're banned from casino."); 
OpenTable("HighScores");
?>
<div align=center>
<table width=60% border=1 cellspacing=0 cellpadding=10><tr><td class=text>
<div align=center><B>HighScores Ranking</B>
<P>
<A HREF=flashscores2.php>Go to HighScores Stats</a><P>
<?php
for($gameID=1;$gameID<11;$gameID++)
{
if($gameID==1)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=3 bgcolor=#0099FF><center><B>Asteroids</B></center></TD></TR>");
print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Score</TD></TR>");
}
if($gameID==2)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=3 bgcolor=#0099FF><center><B>Breakout</B></center></TD></TR>");
print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Score</TD></TR>");
}
if($gameID==3)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=3 bgcolor=#0099FF><center><B>Hexxagon</B></center></TD></TR>");
print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Score</TD></TR>");
}
if($gameID==4)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=3 bgcolor=#0099FF><center><B>Invaders</B></center></TD></TR>");
print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Score</TD></TR>");
}
if($gameID==5)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=3 bgcolor=#0099FF><center><B>Moonlander</B></center></TD></TR>");
print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Score</TD></TR>");
}
if($gameID==6)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=3 bgcolor=#0099FF><center><B>Pacman</B></center></TD></TR>");
print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Score</TD></TR>");
}
if($gameID==7)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=3 bgcolor=#0099FF><center><B>Solitaire</B></center></TD></TR>");
print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Score</TD></TR>");
}
if($gameID==8)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=3 bgcolor=#0099FF><center><B>Simon</B></center></TD></TR>");
print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Score</TD></TR>");
}
if($gameID==9)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=4 bgcolor=#0099FF><center><B>Snake</B></center></TD></TR>");
  print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Niveau</TD><TD>Score</TD></TR>");
}
if($gameID==10)
{
  print("<TABLE WIDTH=100% border=1><TR><TD COLSPAN=4 bgcolor=#0099FF><center><B>Tetris</B></center></TD></TR>");
  print("<TR><TD>Rank</TD><TD WIDTH=75% align=center>Name</TD><TD>Niveau</TD><TD>Score</TD></TR>");
}
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores GROUP BY user;");
 while($populate = $db->sql_fetchrow($result))
 {
if(!isset($totalscore[$populate["user"]]))
{
 $totalscore[$populate["user"]]=0;
}
 }
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." ORDER BY score DESC;")or die(mysql_error());
 while($scores = $db->sql_fetchrow($result))
 {
   $ranking = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." AND score > ".$scores["score"].";") or die(mysql_error());
if($rankrow = $db->sql_fetchrow($ranking))
{
 $rank = $rankrow[0]+1;
}else{
 $rank = 1;
}
if($rank<6)
{
$totalscore[$scores["user"]]+=(10-(($rank-1)*2));
}
 }
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." ORDER BY score DESC LIMIT 5")or die(mysql_error());
 while($scores = $db->sql_fetchrow($result))
 {
  $userresult = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id = ".$scores["user"]."")or die(mysql_error());
$user = $db->sql_fetchrow($userresult);
$username = $user["username"];
   $ranking = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." AND score > ".$scores["score"]."") or die(mysql_error());
if($rankrow = $db->sql_fetchrow($ranking))
{
 $rank = $rankrow[0]+1;
}else{
 $rank = 1;
}
if($gameID < 9)
{
  if($scores["user"]==$viewing)
  {
    print("<TR bgcolor= #BBBBBB><TD>".$rank."</TD><TD WIDTH=75%>".$username."</TD><TD><div style=\"text-align:right;width:100%;\">".$scores["score"]."</div></TD></TR>");
  }else{
    print("<TR><TD>".$rank."</TD><TD>".$username."</TD><TD><div style=\"text-align:right;width:100%;\">".$scores["score"]."</div></TD></TR>");
  }
}else{
  if($scores["user"]==$viewing)
  {
    print("<TR bgcolor= #BBBBBB><TD>".$rank."</TD><TD WIDTH=75%>".$username."</TD><TD>".$scores["level"]."</TD><TD><div style=\"text-align:right;width:100%;\">".$scores["score"]."</div></TD></TR>");
  }else{
    print("<TR><TD>".$rank."</TD><TD>".$username."</TD><TD>".$scores["level"]."</TD><TD><div style=\"text-align:right;width:100%;\">".$scores["score"]."</div></TD></TR>");
  }
}
 }
 $yourresult = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." AND user = '".$viewing."' ORDER BY score DESC LIMIT 1") or die(mysql_error());
 if($yourscore = $db->sql_fetchrow($yourresult))
 {
$yourhighscore = $yourscore["score"];
$yourlevel = $yourscore["level"];
   $yourranking = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_flashscores WHERE game = ".$gameID." AND score > ".$yourhighscore."") or die(mysql_error());
if($ranking = $db->sql_fetchrow($yourranking))
{
 $yourrank = $ranking[0]+1;
}else{
 $yourrank = 1;
}
if($yourrank>5)
{
if($gameID < 9)
{
    print("<TR style=\"background-color: #BBBBBB\"><TD>".$yourrank."</TD><TD WIDTH=75% align=center>".getusername($btuser)."</TD><TD><div style=\"text-align:right;width:100%;\">".$yourhighscore."</div></TD></TR>");
}else{
    print("<TR style=\"background-color: #BBBBBB\"><TD>".$yourrank."</TD><TD WIDTH=75% align=center>".getusername($btuser)."</TD><TD>".$yourlevel."</TD><TD><div style=\"text-align:right;width:100%;\">".$yourhighscore."</div></TD></TR>");
}
}
 }
 print("</TABLE><P>");
}
 $maxplayed = 0;
 $userplayed = 0;
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores GROUP BY user")or die(mysql_error());
 while($flashuser = $db->sql_fetchrow($result))
 {
   $totalresult = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_flashscores WHERE user = '".$flashuser["user"]."'")or die(mysql_error());
   if($totaluser = $db->sql_fetchrow($totalresult))
   {
  if($totaluser[0]>$maxplayed)
  {
 $userplayed = $flashuser["user"];
 $maxplayed = $totaluser[0];
  }
}
 }
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id = ".$userplayed."")or die(mysql_error());
 if($user = $db->sql_fetchrow($result))
 {
 $username = $user["username"];
 }else{
 $username = "Unknown?!";
 }
   $yourtotalresult = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_flashscores WHERE user = '".$viewing."';")or die(mysql_error());
   if($yourtotal = $db->sql_fetchrow($yourtotalresult))
   {
  $yourtotalgames = $yourtotal[0];
}else{
     $yourtotalgames = 0;
}

 $maxscore=0;
 $maxscoreuser=0;
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_flashscores GROUP BY user")or die(mysql_error());
 while($check = $db->sql_fetchrow($result))
 {
 if($totalscore[$check["user"]]>$maxscore)
 {
   $maxscore=$totalscore[$check["user"]];
   $maxscoreuser=$check["user"];
 }
}
 $result = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE id = ".$maxscoreuser."")or die(mysql_error());
 if($user3 = $db->sql_fetchrow($result))
 {
 $usernamescore = $user3["username"];
 }else{
 $usernamescore = "Unknown?!";
 }
$yourscore=$totalscore[$viewing];
?>
You Have Played <?php echo $yourtotalgames?> Games!<P>
Your Total Score are <?php echo $yourscore?>!<P>
<TABLE>
<TR><TD><B><CENTER>Most Bored Award</CENTER></B></TD><TD><B><CENTER>Highest Score Award</CENTER></B></TD></TR>
<TR><TD><CENTER><IMG SRC=mostboredaward.php></CENTER></TD>
<TD><CENTER><IMG SRC=mostbetteraward.php></CENTER></TD>
<TR><TD><CENTER>Most Bored award goes to: <B><?php echo $username;?></B><BR/>With <?php echo $maxplayed;?> games played!<BR/><B>Congratulations!</B></CENTER></TD>
<TD><CENTER>The highest score award goes to:<B><?php echo $usernamescore;?></B><BR/>With a score of <?php echo $maxscore;?>!<BR/><B>Congratulations!</B/></CENTER></TD></TR>
</table>
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
