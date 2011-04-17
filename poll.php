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
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $choice = $_POST["choice"];
  if ($btuser && $choice != "" && $choice < 256 && $choice == floor($choice))
  {
    $res = $db->sql_query("SELECT * FROM ".$db_prefix."_polls ORDER BY added DESC LIMIT 1") or sqlerr();
    $arr = $db->sql_fetchrow($res) or die("No poll");
    $pollid = $arr["id"];
  	$userid = "".getuserid($btuser)."";
    $res = $db->sql_query("SELECT * FROM ".$db_prefix."_pollanswers WHERE pollid=$pollid && userid=$userid") or sqlerr();
    $arr = $db->sql_fetchrow($res);
    if ($arr) die("Dupe vote");
    $db->sql_query("INSERT INTO ".$db_prefix."_pollanswers VALUES(0, $pollid, $userid, $choice)") or sqlerr();
    if ($db->sql_affectedrows() != 1)
      bterror("An error occured. Your vote has not been counted.","Error");
    header("Location: $siteurl/");
    die;
  }
}
if ($user->user){
OpenTable('Polls');
  // Get current poll
  $res = $db->sql_query("SELECT * FROM ".$db_prefix."_polls ORDER BY added DESC LIMIT 1");
  if($pollok=($db->sql_numrows($res)))
  {
  	$arr = $db->sql_fetchrow($res);
  	$pollid = $arr["id"];
  	$userid = "".getuserid($btuser)."";
  	$question = $arr["question"];
  	$o = array($arr["option0"], 
	(!isset($arr["option1"])) ? "" : $arr["option1"], 
	(!isset($arr["option2"])) ? "" : $arr["option2"], 
	(!isset($arr["option3"])) ? "" : $arr["option3"], 
	(!isset($arr["option4"])) ? "" : $arr["option4"],
    (!isset($arr["option5"])) ? "" : $arr["option5"], 
	(!isset($arr["option6"])) ? "" : $arr["option6"], 
	(!isset($arr["option7"])) ? "" : $arr["option7"], 
	(!isset($arr["option8"])) ? "" : $arr["option8"], 
	(!isset($arr["option9"])) ? "" : $arr["option9"],
    (!isset($arr["option10"])) ? "" : $arr["option10"], 
	(!isset($arr["option11"])) ? "" : $arr["option11"], 
	(!isset($arr["option12"])) ? "" : $arr["option12"], 
	(!isset($arr["option13"])) ? "" : $arr["option13"], 
	(!isset($arr["option14"])) ? "" : $arr["option14"],
    (!isset($arr["option15"])) ? "" : $arr["option15"], 
	(!isset($arr["option16"])) ? "" : $arr["option16"], 
	(!isset($arr["option17"])) ? "" : $arr["option17"], 
	(!isset($arr["option18"])) ? "" : $arr["option18"], 
	(!isset($arr["option19"])) ? "" : $arr["option19"]
	);

  // Check if user has already voted
  	$res = $db->sql_query("SELECT * FROM ".$db_prefix."_pollanswers WHERE pollid=$pollid AND userid=$userid") or sqlerr();
  	$arr2 = $db->sql_fetchrow($res);
  }


if ($user->admin)
  {
  	print("<div align=right><font class=small>");
		print("Moderator Options - [<a class=altlink href=makepoll.php?returnto=main><b>New</b></a>]\n");
		if($pollok) {
  		print(" - [<a class=altlink href=makepoll.php?action=edit&pollid=$arr[id]&returnto=main><b>Edit</b></a>]\n");
			print(" - [<a class=altlink href=polls.php?action=delete&pollid=$arr[id]&returnto=main><b>Delete</b></a>]");
		}
		print("</font></div>");
	}
	print("\n");
	if($pollok) {
    print("<table class='poll'  width='100%' border=1 cellspacing=2 cellpadding=2 align=center><tr class='poll'><td class='poll'>\n");
  	print("<p class='poll' align=center><b>$question</b></p>\n");
  	$voted = $arr2;
  	if ($voted)
  	{
    	// display results
    	if (isset($arr["selection"]))
      	$uservote = $arr["selection"];
    	else
      	$uservote = -1;
			// we reserve 255 for blank vote.
    	$res = $db->sql_query("SELECT selection FROM ".$db_prefix."_pollanswers WHERE pollid=$pollid AND selection < 20") or sqlerr();

    	$tvotes = $db->sql_numrows($res);

    	$vs = array(); // array of
    	$os = array();

    	// Count votes
    	while ($arr2 = $db->sql_fetchrow($res))
      	$vs[$arr2[0]] += 1;

    	reset($o);
    	for ($i = 0; $i < count($o); ++$i)
      	if ($o[$i])
        	$os[$i] = array($vs[$i], $o[$i]);

    	function srt($a,$b)
    	{
      	if ($a[0] > $b[0]) return -1;
      	if ($a[0] < $b[0]) return 1;
      	return 0;
    	}

    	// now os is an array like this: array(array(123, "Option 1"), array(45, "Option 2"))
    	if ($arr["sort"] == "yes")
    		usort($os, srt);

    	print("<table class='poll'   border=1 cellspacing=2 cellpadding=2>\n");
    	$i = 0;
    	while ($a = $os[$i])
    	{
      	if ($i == $uservote)
        	$a[1] .= "&nbsp;*";
      	if ($tvotes == 0)
      		$p = 0;
      	else
      		$p = round($a[0] / $tvotes * 100);
      	if ($i % 2)
        	$c = "";
      	else
        	$c = "";
      	print("<tr class='poll'><td width=1% ><nobr>" . $a[1] . "&nbsp;&nbsp;</nobr></td><td width=99% >" .
        	"<img src=$siteurl/images/bar_left.gif><img src=$siteurl/images/bar.gif height=9 width=" . ($p * 2) .
        	"><img src=$siteurl/images/bar_right.gif> $p%</td></tr>\n");
      	++$i;
    	}
    	print("</table>\n");
			$tvotes = number_format($tvotes);
    	print("<p class='poll' align=center>Votes: $tvotes<br />\n");
		print("[<a class=altlink href=polloverview.php><b>View Results</b></a>]</p>\n");
        print("</table>");
  	}
  	else
  	{
    	print("<form method=post action=index.php><p class='poll'>\n");
    	$i = 0;
    	while ($a = $o[$i])
    	{
      	print("<input type=radio name=choice value=$i>&nbsp;&nbsp;&nbsp;$a<br>\n");
      	++$i;
    	}
    	print("<br></p>");
    	print("<div align=center><input type=submit value='Vote' class=btn><br>[<a href=polls.php><b>View Results</b></a>]</div></form></td></tr></table>");
  	}
   

}else{
    echo "You must log in to vote and view the poll";
}
CloseTable();
}
?>