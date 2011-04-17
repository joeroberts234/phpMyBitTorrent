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
include ("header.php");
global $db, $db_prefix;

  $action = $_GET["action"];
  $pollid = $_GET["pollid"];
  $returnto = $_GET["returnto"];

  if ($action == "delete")
  {
   	$sure = $_GET["sure"];
   	if (!$sure)
    	bterror("Do you really want to delete a poll? Click\n" .
    		"<a href=?action=delete&pollid=$pollid&returnto=$returnto&sure=1>here</a> if you are sure.","Delete poll");

		$db->sql_query( "DELETE FROM ".$db_prefix."_pollanswers WHERE pollid = $pollid") or sqlerr();
		$db->sql_query( "DELETE FROM ".$db_prefix."_polls WHERE id = $pollid") or sqlerr();
		if ($returnto == "main")
			header("Location: $siteurl");
		else
			header("Location: $siteurl/polls.php?deleted=1");
		die;
  }
  $rows = $db->sql_query("SELECT COUNT(*) FROM ".$db_prefix."_polls") or sqlerr();
  $row = $db->sql_fetchrow($rows);
  $pollcount = $row[0];
  if ($pollcount == 0)
  	bterror("There are no polls!","Error");
  $polls = $db->sql_query("SELECT * FROM ".$db_prefix."_polls ORDER BY id DESC") or sqlerr();
    function srt($a,$b)
    {
      if ($a[0] > $b[0]) return -1;
      if ($a[0] < $b[0]) return 1;
      return 0;
    }

  while ($poll = $db->sql_fetchrow( $polls))
  {
    $o = array($poll["option0"], $poll["option1"], $poll["option2"], $poll["option3"], $poll["option4"],
    $poll["option5"], $poll["option6"], $poll["option7"], $poll["option8"], $poll["option9"]);

    print("<p><table border=0 cellspacing=0 cellpadding=10 align=center><tr><td align=center>\n");

    print("<p class=sub>");
    $added = gmdate("Y-m-d",strtotime($poll['added'])) . " GMT (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($poll["added"]))) . " ago)";

    print("$added");

    if (is_btadmin($btuser))
    {
    	print(" - [<a href=makepoll.php?action=edit&pollid=$poll[id]><b>Edit</b></a>]\n");
			print(" - [<a href=?action=delete&pollid=$poll[id]><b>Delete</b></a>]\n");
		}

		print("<a name=$poll[id]>");

		print("</p>\n");

    print("<table  class=main border=1 cellspacing=2 cellpadding=2><tr><td class=text>\n");

    print("<p align=center><b>" . $poll["question"] . "</b></p>");

    $pollanswers = $db->sql_query("SELECT selection FROM ".$db_prefix."_pollanswers WHERE pollid=" . $poll["id"] . " AND  selection < 20") or sqlerr();

    $tvotes = $db->sql_numrows($pollanswers);

    $vs = array(); // count for each option ([0]..[19])
    $os = array(); // votes and options: array(array(123, "Option 1"), array(45, "Option 2"))

    // Count votes
    while ($pollanswer = $db->sql_fetchrow($pollanswers))
      $vs[$pollanswer[0]] += 1;

    reset($o);
    for ($i = 0; $i < count($o); ++$i)
      if ($o[$i])
        $os[$i] = array($vs[$i], $o[$i]);

    // now os is an array like this:
    if ($poll["sort"] == "yes")
    	usort($os, srt);

    print("<table  class=main border=1 cellspacing=2 cellpadding=2>\n");
    $i = 0;
    while ($a = $os[$i])
    {
	  	if ($tvotes > 0)
	  		$p = round($a[0] / $tvotes * 100);
	  	else
				$p = 0;
      if ($i % 2)
        $c = " class=embedded";
      print("<tr><td$c>" . $a[1] . "&nbsp;&nbsp;</td><td$c>" .
        "<img src=images/bar.gif height=9 width=" . ($p * 2) . "> $p%</td></tr>\n");
      ++$i;
    }
    print("</table>\n");
	$tvotes = number_format($tvotes);
    print("<p align=center>Votes: $tvotes</p>\n");
    print("</td></tr></table>\n");

    print("</td></tr></table></p>\n");

  }
include ("footer.php");
?>
