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
*------              2008 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
include("header.php");
$go = $_POST['add'];
if ($go)
    {
        $name = htmlspecialchars(addslashes($_POST['name']));
        $url = htmlspecialchars(addslashes($_POST['url']));
        $image = htmlspecialchars(addslashes($_POST['image']));
        $email = htmlspecialchars(addslashes($_POST['email']));

       mysql_query("INSERT INTO `torrent_affiliates` (`name`,`banner`,`url`,`email`,`active`) VALUES ('$name','$image','$url','$email','0');") or die("Insert Query Failed");

        echo "Your affiliate request has been submitted, but must be approved before it will show up on this site. You will recieve an email once you are accepted.";
    }
else
    {

        echo "<form action='' method='post'>
        Your Name: <input type='text' name='name' /><br />
        Your Email: <input type='text' name='email' /><br />
        Site URL: <input type='text' name='url' /><br />
        Affiliate Image: <input type='text' name='image' /><br />
        <input type='submit' name='add' value='Apply' />";
    }
include("footer.php");
?>
