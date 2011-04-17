<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta3-----------------------*
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

//error_reporting(E_NONE);
$pmbt_cache = new pmbt_cache();
if (preg_match("/class.cache.php/i", $_SERVER['PHP_SELF'])) die("You can't access this file class.cache.php directly");
class pmbt_cache {
	var $cache_dir = 'cache/';
       function get_sql($file, $expire = 60)
	   {
          if (file_exists($this->cache_dir."sql_".md5($file).".php")) 
		  {
		  		  if(filemtime($this->cache_dir."sql_".md5($file).".php") < (time() - $expire))
		         {
		         $this->remove_file("sql_".md5($file).".php");
		         return false;
		         }

                 $record = unserialize(file_get_contents($this->cache_dir."sql_".md5($file).".php"));
				 return $record;
          }else{
		         return false;
		  }
	   }
	   function remove_file($filename)
    	{
    		if (!@unlink($this->cache_dir.$filename))
    		{
    			// E_USER_ERROR - not using language entry - intended.
    			trigger_error('Unable to remove files within ' . $this->cache_dir . $filename . '. Please check directory permissions.', E_USER_ERROR);
    		}
    	}
	   function purge()
	   {
		// Purge all phpbb cache files
		$dir = @opendir($this->cache_dir);

		if (!$dir)
		{
			return;
		}

		while (($entry = readdir($dir)) !== false)
		{
			if (strpos($entry, 'sql_') !== 0 && strpos($entry, 'cache_') !== 0 && strpos($entry, 'staff') !== 0 )
			{
				continue;
			}

			$this->remove_file($this->cache_dir . $entry);
		}
		closedir($dir);
	   }
	   function set_sql($file, $output)
	   {
	       $OUTPUT = serialize($output);
           $fp = fopen($this->cache_dir."sql_".md5($file).".php","w");
          fputs($fp, $OUTPUT);
          fclose($fp);
		  @chmod($this->cache_dir."sql_".md5($file).".php", 0755);
	   }
}
?>
