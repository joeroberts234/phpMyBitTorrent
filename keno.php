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
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
	$xmg_title = "Xavier's PHP scripts - Keno Game";
	$xmg_keywords = "cgi, perl, cgi scripts, remotely hosted, PHP, perl scripts, URL, home, advertising, promotion, web hosting, web software";
	$xmg_description = "Free PHP scripts for your homepage";
	$xmg_category = "xmg_php";
	$xmg_pageid = "64";

include("header.php");
OpenTable("KENO");
?>
<!-- START TEXT -->

<CENTER>
	<P>
<?PHP
//
// Copyright 2001 Xavier Media Group
// http://www.xaviermedia.com/php/
//
// If you need help or have suggestions, please visit
// http://forum.xaviermedia.com/ or
// http://www.xaviermedia.com/php/keno.phtml
//

$keno_numbers = array (
	"0" => "",
	"1" => "",
	"2" => "",
	"3" => "",
	"4" => "",
	"5" => "",
	"6" => "",
	"7" => "",
	"8" => "",
	"9" => "",
	"10" => "",
	"11" => "",
	"12" => "",
	"13" => "",
	"14" => "",
	"15" => "",
	"16" => "",
	"17" => "",
	"18" => "",
	"19" => "",
	"20" => "");
$player_numbers = array (
	"0" => "$n1",
	"1" => "$n2",
	"2" => "$n3",
	"3" => "$n4",
	"4" => "$n5",
	"5" => "$n6",
	"6" => "$n7",
	"7" => "$n8",
	"8" => "$n9",
	"9" => "$n10",
	"10" => "$n11",
	"11" => "$n12",
	"12" => "$n13",
	"13" => "$n14",
	"14" => "$n15",
	"15" => "$n16",
	"16" => "$n17",
	"17" => "$n18",
	"18" => "$n19",
	"19" => "$n20");

if ($action == "play")
{
	$i = 0;
	while ($i < 20)
	{
		$temp = rand(1,80);
		if (!in_array($temp,$keno_numbers))
		{
			$keno_numbers[$i] = $temp;
			$i++;
		}
	} 
	sort($keno_numbers);
	sort($player_numbers);
}
$i = 0;
$points = 0;
while ($i < 20)
{
	if (in_array($keno_numbers[$i],$player_numbers))
		$points++;
	$i++;
}
echo "<A NAME=keno></A><script type=\"text/javascript\">\n";
echo "<!--\n";
echo "function selectkeno(v)\n";
echo "{\n";
echo "	document.kenoform.n20.value = document.kenoform.n19.value\n";
echo "	document.kenoform.n19.value = document.kenoform.n18.value\n";
echo "	document.kenoform.n18.value = document.kenoform.n17.value\n";
echo "	document.kenoform.n17.value = document.kenoform.n16.value\n";
echo "	document.kenoform.n16.value = document.kenoform.n15.value\n";
echo "	document.kenoform.n15.value = document.kenoform.n14.value\n";
echo "	document.kenoform.n14.value = document.kenoform.n13.value\n";
echo "	document.kenoform.n13.value = document.kenoform.n12.value\n";
echo "	document.kenoform.n12.value = document.kenoform.n11.value\n";
echo "	document.kenoform.n11.value = document.kenoform.n10.value\n";
echo "	document.kenoform.n10.value = document.kenoform.n9.value\n";
echo "	document.kenoform.n9.value = document.kenoform.n8.value\n";
echo "	document.kenoform.n8.value = document.kenoform.n7.value\n";
echo "	document.kenoform.n7.value = document.kenoform.n6.value\n";
echo "	document.kenoform.n6.value = document.kenoform.n5.value\n";
echo "	document.kenoform.n5.value = document.kenoform.n4.value\n";
echo "	document.kenoform.n4.value = document.kenoform.n3.value\n";
echo "	document.kenoform.n3.value = document.kenoform.n2.value\n";
echo "	document.kenoform.n2.value = document.kenoform.n1.value\n";
echo "	document.kenoform.n1.value = v\n";
echo "}\n";
echo "//-->\n";
echo "</script>\n";
echo "<TABLE>";
$i = 0;
$n = 1;
while ($i < 8)
{
	if ($i % 2 == 1)
		echo "  <TR BGCOLOR=\"#C1C2F5\">";
	else
		echo "  <TR>";

	$j = 0;
	while ($j < 10)
	{

		if (in_array($n, $keno_numbers))
			echo "<TD BGCOLOR=\"#ECBCBC\" ALIGN=center>";
		else
			echo "<TD ALIGN=center>";
		echo "<FONT FACE=\"verdana, arial, helvetica\" SIZE=2>";
		if (in_array ($n, $player_numbers))
			echo "<B> &nbsp; <A HREF=\"#keno\" onClick=\"selectkeno($n)\"><FONT COLOR=black>$n</FONT></A> &nbsp; </B>";
		else
			echo " &nbsp; <A HREF=\"#keno\" onClick=\"selectkeno($n)\"><FONT COLOR=black>$n</FONT></A> &nbsp; ";
		echo "</FONT></TD>";
		$j++;
		$n++;
	}
	$i++;
}
echo "</TABLE>";

if ($action == "play")
{
	$again = " again!";
	echo "<B>The winning numbers are:</B><BR>";
	$w = 0;
	while ($w < 21)
	{
		echo " &nbsp; $keno_numbers[$w]";
		$w++;
		if ($w == 10)
			echo "<BR>";
	}

	echo "<BR><B>and you selected:</B><BR>";
	$w = 0;
	while ($w < 21)
	{
		echo " &nbsp; $player_numbers[$w]";
		$w++;
		if ($w == 10)
			echo "<BR>";
	}
	echo "<BR><B>You have $points winning numbers!</B>";
}

echo "<FORM METHOD=post ACTION=\"$PHP_SELF?page=keno&". time(). "#keno\" NAME=kenoform>Select 20 numbers between 1 and 80:<BR>";
echo "<INPUT TYPE=hidden NAME=action VALUE=\"play\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n1 VALUE=\"$player_numbers[0]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n2 VALUE=\"$player_numbers[1]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n3 VALUE=\"$player_numbers[2]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n4 VALUE=\"$player_numbers[3]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n5 VALUE=\"$player_numbers[4]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n6 VALUE=\"$player_numbers[5]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n7 VALUE=\"$player_numbers[6]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n8 VALUE=\"$player_numbers[7]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n9 VALUE=\"$player_numbers[8]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n10 VALUE=\"$player_numbers[9]\"><BR>";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n11 VALUE=\"$player_numbers[10]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n12 VALUE=\"$player_numbers[11]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n13 VALUE=\"$player_numbers[12]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n14 VALUE=\"$player_numbers[13]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n15 VALUE=\"$player_numbers[14]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n16 VALUE=\"$player_numbers[15]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n17 VALUE=\"$player_numbers[16]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n18 VALUE=\"$player_numbers[17]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n19 VALUE=\"$player_numbers[18]\"> ";
echo "<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=n20 VALUE=\"$player_numbers[19]\"><BR>";
echo "<INPUT TYPE=submit VALUE=\"Play KENO$again\"></FORM>";
echo "<FONT FACE=\"verdana, arial, helvetica\" SIZE=1><A HREF=\"http://www.xaviermedia.com/php/keno.phtml\">A script from Xavier Media</A></FONT>";
?>
</P>
</CENTER>




<!-- END TEXT -->
<?php
CloseTable();
include("footer.php");
?>
