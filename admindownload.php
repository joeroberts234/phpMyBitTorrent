<?php
/*
*----------------------------phpMyBitTorrent V 2.0.5---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*/
die();
require_once("include/config_lite.php");
if ($use_rsa) require_once("include/rsalib.php");
require_once("include/functions.php");
require_once("include/class.user.php");
if ($use_rsa) $rsa = new RSA($rsa_modulo, $rsa_public, $rsa_private);
$user = @new User($_COOKIE["btuser"]);
if (isset($btlanguage) AND is_readable("language/".$btlanguage.".php")) $language = $btlanguage;
if (isset($bttheme) AND is_readable("themes/".$bttheme."/main.php")) $theme = $bttheme;
if (is_readable("language/".$language.".php"))
        require_once("language/".$language.".php");
else
        require_once("language/english.php");
if (file_exists("./themes/".$theme."/main.php")) {
        require_once("./themes/".$theme."/main.php");
} elseif (file_exists("./themes/pmbt/main.php")) {
        $theme = "pmbt";
        require_once("./themes/pmbt/main.php");
} else {
        die("Cannot run without theme! Reinstall phpMyBitTorrent NOW!!");
}
if(!isset($conferm) || $conferm == '' || $conferm != md5($user->name.$user->act_key.$name)){
OpenErrTable(_btaccdenied);
echo _btnoautherizeddownload;
CloseErrTable();
die();
}
if(!isset($backup) || !isset($name) || !isset($method)){
OpenErrTable(_btaccdenied);
echo "Missing Input Please Try again";
CloseErrTable();
}
if(!checkaccess("download")){
OpenErrTable(_btaccdenied);
echo _btnoautherizeddownload;
CloseErrTable();
die();
}
if(!isset($conferm) || $conferm == '' || $conferm != md5($user->name.$user->act_key.$name)){
OpenErrTable(_bterror);
echo _btnoautherizeddownload;
CloseErrTable();
die();
}
if (!is_file($backup) OR !is_readable($backup)) {
        header("HTTP/1.0 500 Internal Server Error");
themeheader();
        bterror(_bttorrentunavailable);
}
$size = @filesize($backup);
$handle = @fopen($backup, 'rb');
	
if($handle){  
								switch ($method)
								{
									case 'text':
										$mimetype = 'text/x-sql';
									break;
									case 'zip':
										$mimetype = 'application/zip';
									break;
									case 'gz':
										$mimetype = 'application/x-gzip';
									break;
								}
	header("Content-Type: $mimetype; name=\"$name\"");
	header("Content-Disposition: attachment; filename=\"$name\"");
	header('X-Download-Options: noopen');
       
       	if ($size)
	{
		header("Content-Length: $size");
	}
	
	while(!feof($handle)) {
	echo fread($handle, 8192);
	}

	fclose($handle);	
		unlink($backup);
		die();
	}else{
	echo 'error';
	}	

?>