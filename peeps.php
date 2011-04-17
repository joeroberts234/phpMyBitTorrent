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
*------              ©2008 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   SAT, FEB 21, 2009 18:12 PM   ---------------------*
*/
include("header.php");
global $db, $db_prefix;
/*--------- DATABASE CONNECTION INFO---------*/

$hostname="localhost";
$mysql_login="root";
$mysql_password="ferarri1975";
$database="phpMyBitTorrent";

// connect to the database server
if (!($db = mysql_pconnect($hostname, $mysql_login , $mysql_password))){
  die("Can't connect to database server.");
}else{
  // select a database
    if (!(mysql_select_db("$database",$db))){
      die("Can't connect to database.");
    }
}
$problem = trim($_POST["problem"]);
$answer = trim($_POST["answer"]);
$id = $_POST["id"];
$addedbyid = $_POST["addedbyid"];
$title = trim($_POST["Problem Title"]);
$action = $_GET["action"];
$solve = $_GET["solve"];

if (($problem != "") && ($title != "")){
requier_once ("helpdesk.php");
$dt = sqlesc(get_date_time());
$db->sql_query("INSERT INTO ".$db_prefix."_helpdesk` (`title`, `problem`,) VALUES  (".$title.", ".$problem.")") or sqlerr();
//mysql_query("INSERT INTO ".$db_prefix."_helpdesk (added) VALUES ($dt)") or sqlerr();
stdmsg("Help desk", "Message sent! Await for reply.");
end_main_frame();
stdfoot();
exit;
}
?>
