<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*/
if (eregi ("configdata.php" , $_SERVER["PHP_SELF"])) die ("You can't access this file directly");
/* ---------------------------------
Database Configuration
You have to configure your database
connection here. Here is a quick
explanation:

db_type: your database type
    Possible options:
    MySQL
    MySQL4
    Postgres
    MSSQL
    Oracle
    MSAccess
    MSSQL-ODBC
    DB2
db_host: host where database runs
db_port: not used
db_user: database user name
db_password: database password
db_name: database name on server
db_prefix: prefix for tables
persistency: connection persistency
--------------------------------- */
$db_type = "MySQL";
$db_host = "localhost";
$db_user = "root";
$db_pass = "ferarri1975";
$db_name = "phpmybittorrent";
$db_prefix = "torrent"; //Without "_"
$db_persistency = true;

/* ---------------------------------
RSA Engine configuration
Make sure you ran rsa_keygen BEFORE
configuring RSA. You NEED a VALID
key pair to enable RSA.
You can copy&paste rsa_keygen output
--------------------------------- */
$use_rsa = true;
$rsa_modulo = 43012633;
$rsa_public = 5171;
$rsa_private = 35257531;

/*----------------------------------
Torrent Upload Directory
You can change the default setting,
but remember that it MUST be writable
by httpd/IUSR_MACHINE user
----------------------------------*/
$torrent_dir = "torrent";
?>