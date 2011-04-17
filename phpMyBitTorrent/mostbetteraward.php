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
header("Content-type: image/gif");
require_once("include/config_lite.php");
global $db, $db_prefix;
 $result = mysql_query("SELECT * FROM ".$db_prefix."_flashscores GROUP BY user;");
 while($populate = mysql_fetch_array($result))
 {
if(!isset($totalscore[$populate["user"]]))
{
 $totalscore[$populate["user"]]=0;
}
 }

 $maxscore=0;
 $maxscoreuser=0;
 $result = mysql_query("SELECT * FROM ".$db_prefix."_flashscores GROUP BY user")or die(mysql_error());
 while($check = mysql_fetch_array($result))
 {
 if($totalscore[$check["user"]]>$maxscore)
 {
   $maxscore=$totalscore[$check["user"]];
   $maxscoreuser=$check["user"];
 }
}
 $result = mysql_query("SELECT * FROM ".$db_prefix."_users WHERE id = ".$maxscoreuser."")or die(mysql_error());
 if($user3 = mysql_fetch_array($result))
 {
 $usernamescore = $user3["username"];
 }else{
 $usernamescore = "Unknown?!";
 }
	 $im    = imagecreate(100,100);
    $white = imagecolorallocate($im, 255, 255, 255);
    $grey = imagecolorallocate($im, 128, 128, 128);
    $red = imagecolorallocate($im, 255, 0, 0);
    $orange = imagecolorallocate($im, 255, 128, 0);
    $yellow = imagecolorallocate($im, 255, 255, 0);
    $greenish = imagecolorallocate($im, 128, 255, 0);
    $green = imagecolorallocate($im, 0, 255, 0);
    $greenblue = imagecolorallocate($im, 0, 255, 128);
    $lightblue = imagecolorallocate($im, 0, 255, 255);
    $blueish = imagecolorallocate($im, 0, 128, 255);
    $blue = imagecolorallocate($im, 0, 0, 255);
    $black = imagecolorallocate($im, 0, 0, 0);
	 $bg    = imagecreatefromgif("$siteurl/mostpoints.gif");
	 imagecopy ( $im, $bg, 0, 0, 0, 0, imagesx($bg), imagesy($bg));
    imagestring($im, 3, 10, 80, $usernamescore, $black);
imagecolortransparent ( $im , $white);
imagepng($im);
   imagedestroy($im);

  
  
?>
