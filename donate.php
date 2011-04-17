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
*------                    Hacked For phpMyBitTorrent                   -------*
*----------------                 By joeroberts                   -------------*
*------------------------------------------------------------------------------*
*/
include("header.php");
if($nodonate == "US")$type = "$";
else
$type = "&pound;";
OpenTable(_btdonations);
echo "<br><b>"._btdonationsgoal." </b><font color=\"red\">$type $donateasked </font><br><b> "._btdonationscollected." </b><font color=\"green\">$type $donatein </font></center><br>";
echo "<br><br><br>";
echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<P ALIGN="left"><font size="2"><b>Choose You Donation Gift.<br>You will get one day of each for every .33 cents you donate<br></b>
<input type="radio" name="custom" value="1" checked>Free Leech<br>
<input type="radio" name="custom" value="2" >No Hit And Run Warnings<br>
<br><br>then click on donate button<br><br></font></p>
<input type="hidden" name="business" value="nobody@p2p-evolution.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="p2p-Evolution">
<input type="hidden" name="item_number" value="'.$user->id.'">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="payer_id" value="'.$user->id.'">
<input type="hidden" name="no_shipping" value="'.$user->id.'">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>';
CloseTable();
include("footer.php");
?>