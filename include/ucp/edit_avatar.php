<?php
/*
*-----------------------------phpMyBitTorrent V 2.0.5--------------------------*
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
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: edit_avatar.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
        $avatar_uploaded = false;
        if (extension_loaded("gd")) {
                $avupload = $_FILES["avupload"];
                if ($avuploadon && $avupload["name"] != "") {
                        $avatar_uploaded = true;
                        $filename = unesc($avupload["name"]);
                        if (preg_match("/\.(gif|jpg|jpeg|png)$",$filename)) {
                                $imageinfo = getimagesize($avupload["tmp_name"]);
                                if($width == '' || $width == 0)$width = $imageinfo[0];
                                if($height == '' || $height == 0)$height = $imageinfo[1];
                                if ($width > $avmaxwt OR $height > $avmaxht) {
                                        $errors[] = _btavatartoobig;
                                        unlink($avupload["tmp_name"]);
                                } else {
                                        $newfname = preg_replace("/^([^\\\\:\/<>|*\"?])*\\.(gif|jpg|jpeg|png)$/si", $uname.".\\2", $filename);
                                        //Deleting any previous images
                                        $fhandle = opendir($avstore);
                                        while ($file = readdir($fhandle)) {
                                                if (preg_match("/^".$uname."\.(gif|jpg|jpeg|png)$/si",$file)) @unlink($avstore."/".$file);
                                        }
                                        closedir($fhandle);
                                        move_uploaded_file($avupload["tmp_name"],$avstore."/".$newfname);
                                        $sqlfields[] = "avatar_type";
                                        $sqlvalues[] = "'1'";
                                        $sqlfields[] = "avatar_ht";
                                        $sqlvalues[] = "'".$height."'";
                                        $sqlfields[] = "avatar_wt";
                                        $sqlvalues[] = "'".$width."'";
                                        $sqlfields[] = "avatar";
                                        $sqlvalues[] = "'".$avstore."/".$newfname."'";
                                }
                        } else {
                                $errors[] = _btinvalidimagefile;
                                unlink($avupload["tmp_name"]);
                        }
                }
/*------------------------------------------ uploadurl ------------------------------------------*/
				if($avremoteupon && $uploadurl !='')
				{
		$upload_ary = array();
		$upload_ary['local_mode'] = true;

		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $uploadurl, $match))
		{
			 bterror($errors,'The URL you specified is invalid.1');
		}
		if (empty($match[2]))
		{
			 bterror($errors,_btphotoext);
		}

		$url = parse_url($uploadurl);

		$host = $url['host'];
		$path = $url['path'];
		$port = (!empty($url['port'])) ? (int) $url['port'] : 80;

		$upload_ary['type'] = 'application/octet-stream';

		$url['path'] = explode('.', $url['path']);
		$ext = array_pop($url['path']);

		$url['path'] = implode('', $url['path']);
		$upload_ary['name'] = basename($url['path']) . (($ext) ? '.' . $ext : '');
		$filename = $url['path'];
		$filesize = 0;

		$errno = 0;
		$errstr = '';

		if (!($fsock = @fsockopen($host, $port, $errno, $errstr)))
		{
			 bterror($errors,'Avatar could not be uploaded.');
		}

		// Make sure $path not beginning with /
		if (strpos($path, '/') === 0)
		{
			$path = substr($path, 1);
		}

		fputs($fsock, 'GET /' . $path . " HTTP/1.1\r\n");
		fputs($fsock, "HOST: " . $host . "\r\n");
		fputs($fsock, "Connection: close\r\n\r\n");

		$get_info = false;
		$data = '';
		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$data .= @fread($fsock, 1024);
			}
			else
			{
				$line = @fgets($fsock, 1024);

				if ($line == "\r\n")
				{
					$get_info = true;
				}
				else
				{
					if (stripos($line, 'content-type: ') !== false)
					{
						$upload_ary['type'] = rtrim(str_replace('content-type: ', '', strtolower($line)));
					}
					else if (stripos($line, '404 not found') !== false)
					{
			 bterror($errors,'The file specified could not be found.');
					}
				}
			}
		}
		@fclose($fsock);

		if (empty($data))
		{
			 bterror($errors,'The specified avatar could not be uploaded because the remote data appears to be invalid or corrupted.');
		}

		$filename = $uname . '.' .$match[2];

		if (!($fp = @fopen("cache/".$filename, 'wb')))
		{
			 bterror($errors,'Avatar could not be uploaded.');
		}

		$upload_ary['size'] = fwrite($fp, $data);
		fclose($fp);
		unset($data);

                                $imageinfo = getimagesize("cache/".$filename);
                                $width = $imageinfo[0];
                                $height = $imageinfo[1];
                                if ($width > $avmaxwt OR $height > $avmaxht) {
                                        $errors[] = _btavatartoobig;
                                        unlink($filename);
                                } elseif ($width < $avminwt OR $height < $avminht) {
                                        $errors[] = "Image is to small";
                                        unlink($filename);
                                }else{
                                        $newfname = preg_replace("/^([^\\\\:\/<>|*\"?])*\\.(gif|jpg|jpeg|png)$/si", $uname.".\\2", $filename);
                                        //Deleting any previous images
                                        $fhandle = opendir("avatars/user");
                                        while ($file = readdir($fhandle)) {
                                                if (preg_match("/^".$uname."\.(gif|jpg|jpeg|png)$/si",$file)) @unlink("avatars/user/".$file);
                                        }
                                        closedir($fhandle);
                                        copy("cache/".$filename,$avstore."/".$newfname);
                                        unlink("cache/".$filename);
                                        $sqlfields[] = "avatar_type";
                                        $sqlvalues[] = "'1'";
                                        $sqlfields[] = "avatar_ht";
                                        $sqlvalues[] = "'".$height."'";
                                        $sqlfields[] = "avatar_wt";
                                        $sqlvalues[] = "'".$width."'";
                                        $sqlfields[] = "avatar";
                                        $sqlvalues[] = "'".$avstore."/".$newfname."'";
                                }
				}
/*------------------------------------------ remotelink ------------------------------------------*/
//$db->sql_query("ALTER TABLE `torrent_peers` CHANGE `real_ip` `real_ip` VARCHAR( 40 )");
				if($avremoteupon && $remotelink !='')
				{
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $remotelink, $match))
		{
			 bterror($errors,'The URL you specified is invalid.');
		}
		if (empty($match[2]))
		{
			 bterror($errors,'The URL you specified is invalid.');
		}
				$imageinfo = getimagesize($remotelink);
                                $width = $imageinfo[0];
                                $height = $imageinfo[1];
								echo $remotelink ."<br />".$width."<br />".$height;
                                        $sqlfields[] = "avatar_type";
                                        $sqlvalues[] = "'2'";
                                        $sqlfields[] = "avatar_ht";
                                        $sqlvalues[] = "'".$height."'";
                                        $sqlfields[] = "avatar_wt";
                                        $sqlvalues[] = "'".$width."'";
                                        $sqlfields[] = "avatar";

                                        $sqlvalues[] = "'".$remotelink."'";
				}
				
        }
        if ($avgalon AND !$avatar_uploaded AND isset($avgallery) AND $avgallery != "none") {
                                        $sqlfields[] = "avatar_type";
                                        $sqlvalues[] = "'3'";
                                         $sqlfields[] = "avatar_ht";
                                        $sqlvalues[] = "'0'";
                                        $sqlfields[] = "avatar_wt";
                                        $sqlvalues[] = "'0'";
               $sqlfields[] = "avatar";
                $sqlvalues[] = "'".$avgal."/".$avgallery."'";
        }
?>