<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
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

if (eregi("donations_block.php",$_SERVER["PHP_SELF"])) die("You cannot access this file directly.");
if ($donations){
global $donatein, $donateasked, $nodonate;
OpenTable(_btdonations);
$perc = round(100 * $donatein/$donateasked);
echo "<p class=\"donation\" align=\"center\" ><br>"._btdonationsprogress."</p>\n
<table class=main border=0 width=144px>
<tr>
<td style='padding: 0px; background-image: url(images/loadbarbg.gif); background-repeat: repeat-x'>";
$width = round(1.5 * $perc);
  if ($perc<= 1) {$pic = "".$nodonate.".gif"; $width = "100";}
  elseif ($perc<= 40) $pic = "loadbarred.gif";
   elseif ($perc<= 70) $pic = "loadbaryellow.gif";
    else $pic = "loadbargreen.gif";

echo "<img height=15 width=$width src=\"images/$pic\" alt='$donatein)%'>
<br>
<p class=\"donation\" align=\"center\" >$perc%</p>
</td>
</tr>
</table>";
echo "<p class=\"donation\"> "._btdonationsgoal." 
<font color=\"red\">$" . $donateasked . "</font><br>
 "._btdonationscollected." 
 <font color=\"green\">$" . $donatein . "</font>
 </p>
<br>";
print "<br>

<B><font color=red>&raquo;</font></B>
<a href=\"donate.php\">DONATE</a><br>";
CloseTable();
}
?>