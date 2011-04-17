<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
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
*-------------------   Saturday, JUN 27, 2009 1:05 AM   -----------------------*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);

/* FULL ADMIN CHECK
THE STRONGEST DEFENSE AGAINST HACKED M0DS
*/
$admin_site = array();
$admin_user = array();
$admin_torrents = array();
function get_database_size()
{
	global $db, $db_prefix;

	$database_size = false;

	// This code is heavily influenced by a similar routine in phpMyAdmin 2.2.0
	switch ($db->sql_layer)
	{
		case 'mysql':
		case 'mysql4':
		case 'mysqli':
			$sql = 'SELECT VERSION() AS mysql_version';
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if ($row)
			{
				$version = $row['mysql_version'];

				if (preg_match('#(3\.23|[45]\.)#', $version))
				{
					$db_name = (preg_match('#^(?:3\.23\.(?:[6-9]|[1-9]{2}))|[45]\.#', $version)) ? "`{$db->dbname}`" : $db->dbname;

					$sql = 'SHOW TABLE STATUS
						FROM ' . $db_name;
					$result = $db->sql_query($sql, 7200);

					$database_size = 0;
					while ($row = $db->sql_fetchrow($result))
					{
						if ((isset($row['Type']) && $row['Type'] != 'MRG_MyISAM') || (isset($row['Engine']) && ($row['Engine'] == 'MyISAM' || $row['Engine'] == 'InnoDB')))
						{
							if ($db_prefix != '')
							{
								if (strpos($row['Name'], $db_prefix) !== false)
								{
									$database_size += $row['Data_length'] + $row['Index_length'];
								}
							}
							else
							{
								$database_size += $row['Data_length'] + $row['Index_length'];
							}
						}
					}
					$db->sql_freeresult($result);
				}
			}
		break;

		case 'firebird':
			global $dbname;

			// if it on the local machine, we can get lucky
			if (file_exists($dbname))
			{
				$database_size = filesize($dbname);
			}

		break;

		case 'sqlite':
			global $dbhost;

			if (file_exists($dbhost))
			{
				$database_size = filesize($dbhost);
			}

		break;

		case 'mssql':
		case 'mssql_odbc':
			$sql = 'SELECT ((SUM(size) * 8.0) * 1024.0) as dbsize
				FROM sysfiles';
			$result = $db->sql_query($sql, 7200);
			$database_size = ($row = $db->sql_fetchrow($result)) ? $row['dbsize'] : false;
			$db->sql_freeresult($result);
		break;

		case 'postgres':
			$sql = "SELECT proname
				FROM pg_proc
				WHERE proname = 'pg_database_size'";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if ($row['proname'] == 'pg_database_size')
			{
				$database = $db->dbname;
				if (strpos($database, '.') !== false)
				{
					list($database, ) = explode('.', $database);
				}

				$sql = "SELECT oid
					FROM pg_database
					WHERE datname = '$database'";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$oid = $row['oid'];

				$sql = 'SELECT pg_database_size(' . $oid . ') as size';
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$database_size = $row['size'];
			}
		break;

		case 'oracle':
			$sql = 'SELECT SUM(bytes) as dbsize
				FROM user_segments';
			$result = $db->sql_query($sql, 7200);
			$database_size = ($row = $db->sql_fetchrow($result)) ? $row['dbsize'] : false;
			$db->sql_freeresult($result);
		break;
	}

	if ($database_size !== false)
	{
		$database_size = ($database_size >= 1048576) ? sprintf('%.2f ' . 'MB', ($database_size / 1048576)) : (($database_size >= 1024) ? sprintf('%.2f ' . 'KB', ($database_size / 1024)) : sprintf('%.2f ' . 'BYTES', $database_size));
	}
	else
	{
		$database_size = 'Not available';
	}

	return $database_size;
}

function fulladmincheck($user) {
        if (!$user->admin) return false;
        //THIS is the full check part
        global $db, $db_prefix, $_COOKIE;
        $userdata = cookie_decode($_COOKIE["btuser"]);
        if ($userdata[0] != $user->id) return false;
        if (addslashes($userdata[1]) != $user->name) return false;
        $sql = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$user->id."' AND username = '".$user->name."' AND level = 'admin' AND act_key = '".addslashes($userdata[3])."' AND password = '".addslashes($userdata[2])."';";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        $n = $db->sql_numrows($res);
        $db->sql_freeresult($res);
        if (!$n) return false;
        return true;
}

/* ADMIN ENTRY FUNCTION
DISPLAYS THE APPROPRIATE BUTTON FOR ADMIN SCRIPT

IN:
   NAME - NAME OF THE BUTTON
   OP - OPERATOR TO APPEND IN QUERY STRING
   TITLE - TEXT TO DISPLAY
OUT: NOTHING
*/
function adminentry($name, $op, $title,$section="torrentinfo") {
        global $theme, $admin_site, $admin_user, $admin_torrents;
        $image = "admin_".$name;
        if (file_exists("themes/$theme/pics/admin/".$image.".png")) {
                $image = "themes/$theme/pics/admin/".$image.".png";
        } elseif (file_exists("themes/$theme/pics/admin/".$image.".jpg")) {
                $image = "themes/$theme/pics/admin/".$image.".jpg";
        } elseif (file_exists("themes/$theme/pics/admin/".$image.".gif")) {
                $image = "themes/$theme/pics/admin/".$image.".gif";
        } elseif (file_exists("admin/buttons/".$image.".png")) {
                $image = "admin/buttons/".$image.".png";
        } elseif (file_exists("admin/buttons/".$image.".jpg")) {
                $image = "admin/buttons/".$image.".jpg";
        } elseif (file_exists("admin/buttons/".$image.".gif")) {
                $image = "admin/buttons/".$image.".gif";
        }

        $img = "<img src=\"".$image."\" border=\"0\" alt=\"".$title."\" title=\"".$title."\" /></a><br>";
		if($section =='staff'){
        echo "<td align=\"center\" width=\"16%\"><p><a href=\"admin.php?op=".$op."#".$op."\">".$img."<b>".$title."</b></a><br /><br /></p></td>\n";
		}elseif ($section =="siteinfo") {
		array_push($admin_site, "<td align=\"center\" width=\"16%\"><p><a href=\"admin.php?op=".$op."#".$op."\">".$img."<b>".$title."</b></a><br /><br /></p></td>\n");
		}elseif ($section =="userinfo") {
		array_push($admin_user, "<td align=\"center\" width=\"16%\"><p><a href=\"admin.php?op=".$op."#".$op."\">".$img."<b>".$title."</b></a><br /><br /></p></td>\n");
		}elseif ($section =="torrentinfo") {
		array_push($admin_torrents, "<td align=\"center\" width=\"16%\"><p><a href=\"admin.php?op=".$op."#".$op."\">".$img."<b>".$title."</b></a><br /><br /></p></td>\n");
		}
}
/* ADMIN PICTURE FUNCTION
RETRIEVES AN IMAGE FROM ADMIN FOLDER

IN:
   NAME -  FILENAME OF THE IMAGE TO DISPLAY
   URL - (OPTIONAL) URL TO POINT A LINK TO
   ALT - (OPTIONAL) ALTERNATE TEXT FOR IMAGE
OUT:
   HTML <IMG> TAG POINTING TO ADMIN/PICS DIRECTORY
*/
function adminpic($name, $url = "", $alt = "") {
        if ($alt == "" AND $alt != null AND defined("_btalt_".$name)) $alt = constant("_btalt_".$name);

        $ret = "<img src=\"admin/pics/".$name."\" border=\"0\" alt=\"".$alt."\" title=\"".$alt."\" />";
        if ($url != "") {
                return "<a href=\"".$url."\">".$ret."</a>";
        }
        return $ret;
}

include("header.php");
if (!fulladmincheck($user)) loginrequired("admin");
require_once("admin/language/$language.php");
OpenTable(_admmenu);
//echo "<table border=\"0\" width=\"100%\" cellspacing=\"1\"><tr>\n";
$counter = 2;
adminentry("home","home","Home","siteinfo");
#Fetching operators list and displaying Admin menu

$operators = Array();
$op_keys = Array();
$opdir = "admin/items";
$ophandle = opendir($opdir);
while ($opfile = readdir($ophandle)) {
        $op_keys = Array();
        if (!preg_match("/.php/i",$opfile)) continue;
        include($opdir."/".$opfile);
        foreach ($op_keys as $key) {
                $operators[$key] = $opfile;
        }
        if ($counter == 4) {
               // echo "</tr>\n<tr>\n";
                $counter = 1;
        } else {
                $counter++;
        }
}
closedir($ophandle);
unset($opdir,$opfile,$op_keys);

//echo"</tr>\n</table>\n";
$counter2 = 1;
$tableopen = false;
OpenTable(_adm_tables_site);
echo "<table border=\"0\" width=\"100%\" cellspacing=\"1\"><tr>\n";
foreach($admin_site as &$value) {
    echo  $value ;
        if ($counter2 == 4) {
                echo "</tr>\n<tr>\n";
                $counter2 = 1;
        } else {
                $counter2++;
        }
}
echo"</tr>\n</table>\n";
CloseTable();
$counter2 = 1;
OpenTable(_adm_tables_user);
echo "<table border=\"0\" width=\"100%\" cellspacing=\"1\"><tr>\n";
foreach($admin_user as &$value) {
    echo  $value ;
        if ($counter2 == 4) {
                echo "</tr>\n<tr>\n";
                $counter2 = 1;
        } else {
                $counter2++;
        }
}
echo"</tr>\n</table>\n";
CloseTable();
$counter2 = 1;
OpenTable(_adm_tables_torrents);
echo "<table border=\"0\" width=\"100%\" cellspacing=\"1\"><tr>\n";
foreach($admin_torrents as &$value) {
    echo  $value ;
        if ($counter2 == 4) {
                echo "</tr>\n<tr>\n";
                $counter2 = 1;
        } else {
                $counter2++;
        }
}
echo"</tr>\n</table>\n";
CloseTable();
$tableopen = true;
CloseTable();

//The "Core"
if (isset($op) AND array_key_exists($op,$operators))
{
echo "<a name=\"".$op."\"></a>";
 require_once("admin/files/".$operators[$op]);
}else {
        OpenTable(_admoverview);
        //$sql = "SELECT COUNT(U.id) AS users, COUNT(T.id) AS torrents, COUNT(P.id) AS peers, SUM(P.upload_speed) AS speed FROM torrent_users U, torrent_torrents T, torrent_peers P;";
        echo "<p>";
        //Total users
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_users WHERE `active` = 1 AND UNIX_TIMESTAMP(regdate) > UNIX_TIMESTAMP(NOW()) - 86400*7;";
        $res = $db->sql_query($sql);
        list ($totuser) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>Total Registered Users This Week:</b> ".$totuser."<br />\n";
        //Total users
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_users WHERE `active` = 1 AND UNIX_TIMESTAMP(regdate) > UNIX_TIMESTAMP(NOW()) - 86400;";
        $res = $db->sql_query($sql);
        list ($totuser) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>Total Registered Users Today:</b> ".$totuser."<br />\n";
        //Total users
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_users;";
        $res = $db->sql_query($sql);
        list ($totuser) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admtotalusers."</b> ".$totuser."<br />\n";
        //Total Torrents and their size
        $sql = "SELECT COUNT(id), SUM(size) FROM ".$db_prefix."_torrents;";
        $res = $db->sql_query($sql);
        list ($tottorrent, $totshare) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admtotaltorrents."</b> ".$tottorrent."<br />\n";
        echo "<b>"._admtotalshare."</b> ".mksize($totshare)."<br />\n";
        //Total peers and their speed
        $sql = "SELECT COUNT(id), (SUM(upload_speed)+SUM(download_speed))/2 FROM ".$db_prefix."_peers;";
        $res = $db->sql_query($sql);
        list ($totpeers, $totspeed) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admtotalpeers."</b> ".$totpeers."<br />\n";
        echo "<b>"._admtotalspeed."</b> ".mksize($totspeed)."/s<br />\n";
        //Total seeders and total leechers
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_peers GROUP BY seeder ORDER BY seeder ASC;";
        $res = $db->sql_query($sql);
        list ($totseeders) = $db->sql_fetchrow($res);
        list ($totleechers) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admtotalseeders."</b> ".(($totseeders != '')? $totseeders : '0')."<br />\n";
        echo "<b>"._admtotalleechers."</b> ".(($totleechers != '')? $totleechers : '0')."<br />\n";
        $sql = "SELECT COUNT(id) as cnt, client FROM ".$db_prefix."_peers WHERE client IS NOT NULL GROUP BY client ORDER BY cnt DESC LIMIT 1;";
        $res = $db->sql_query($sql);
        list ($cnt, $client) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<b>"._admmostusedclient."</b> ".$client." (".$cnt.")<br />\n";
		echo "<b>Database size :</b> ".get_database_size();
		echo '<br />';
		echo "<b>Database server : </b> ".$db->sql_server_info();
		echo '<br />';
		echo "<b>phpMyBitTorrent Version : </b> ".$version;
		echo '<br />';
        echo "</p>\n";
        CloseTable();
OpenTable("load");
if (strtoupper(substr(PHP_OS, 0, 3)) == "WIN") {
if (class_exists("COM")) {
	function mkprettytime2($s){
	    foreach (array("60:sec","60:min","24:hour","1:day") as $x) {
	        $y = explode(":", $x);
	        if ($y[0] > 1) {
	            $v = $s % $y[0];
	            $s = floor($s / $y[0]);
	        }
	        else
	            $v = $s;
	        $t[$y[1]] = $v;
	    }

	    if ($t['week'] > 1 || $t['week'] == 0) $wk = " weeks";
	    else $wk = " week";
	    if ($t['day'] > 1 || $t['day'] == 0) $day = " days";
	    else $day = " day";
	    if ($t['hour'] > 1 || $t['hour'] == 0) $hr = " hrs";
	    else $hr = " hr";
	    if ($t['min'] > 1 || $t['min'] == 0) $min = " mins";
	    else $min = " min";
	    if ($t['sec'] > 1 || $t['sec'] == 0) $sec = " secs";
	    else $sec = " sec";

	    if ($t["month"])
	        return "{$t['month']}$mth {$t['week']}$wk {$t['day']}$day ".sprintf("%d$hr %02d$min %02d$sec", $t["hour"], $t["min"], $t["sec"], $f["month"]);
	    if ($t["week"])
	        return "{$t['week']}$wk {$t['day']}$day ".sprintf("%d$hr %02d$min %02d$sec", $t["hour"], $t["min"], $t["sec"], $f["month"]);
	    if ($t["day"])
	        return "{$t['day']}$day ".sprintf("%d$hr %02d$min %02d$sec", $t["hour"], $t["min"], $t["sec"]);
	    if ($t["hour"])
	        return sprintf("%d$hr %02d$min %02d$sec", $t["hour"], $t["min"], $t["sec"]);
	    if ($t["min"])
	        return sprintf("%d$min %02d$sec", $t["min"], $t["sec"]);
	    return $t["sec"].$sec;
	}
	$wmi = new COM("Winmgmts://");
	$cpus = $wmi->InstancesOf("Win32_Processor");
	$os = $wmi->InstancesOf("Win32_OperatingSystem");
	$os = $os->Next();
	$os = $os->Caption." - ".$os->CSDVersion." ".$os->Version;
	$system = $wmi->InstancesOf("Win32_ComputerSystem");
	$system = $system->Next();
	$cpucount = $system->NumberOfProcessors;
	
	$ram = $wmi->InstancesOf("Win32_LogicalMemoryConfiguration");
	$ram = $ram->Next();
	$ramtotal = $ram->TotalPhysicalMemory*1024;
	
	$ram = $wmi->InstancesOf("Win32_PerfRawData_PerfOS_Memory");
	$ram = $ram->Next();
	$ramused = $ramtotal-$ram->AvailableBytes;
	$ramused = mksize($ramused);
	$ramtotal = mksize($ramtotal);
	
	$uptime = $wmi->InstancesOf("Win32_PerfFormattedData_PerfOS_System");
	$uptime = $uptime->Next();
	$uptime = mkprettytime2($uptime->SystemUpTime);

	while ($cpu = $cpus->Next()) {
		$cpus1[] = $cpu->LoadPercentage;
		$totalusage += $cpu->LoadPercentage;
	}
	
	$totalusage = round($totalusage/$cpucount, 2);	

	echo "<b>OS:</b> $os<BR>";
	echo "<b>Number of CPUs:</b> $cpucount<BR>";
	for ($i=0;$i<count($cpus1);$i++)
		echo "<b>CPU$i Usage:</b> $cpus1[$i]%<BR>";
	echo "<b>Total CPU Usage:</b> $totalusage%<BR>";
	echo "<B>RAM Usage:</b> $ramused/$ramtotal<BR>";
	echo "<b>Uptime:</b> $uptime";
}
}else{
// Users and load information
$reguptime = trim(exec("uptime"));
if ($reguptime) {
  if (preg_match("/, *(\d) (users?), .*: (.*), (.*), (.*)/", $reguptime, $uptime)) {
    $users[0] = $uptime[1];
    $users[1] = $uptime[2];
    $loadnow = $uptime[3];
    $load15 = $uptime[4];
    $load30 = $uptime[5];
  }
} else {
  $users[0] = "NA";
  $users[1] = "--";
  $loadnow = "NA";
  $load15 = "--";
  $load30 = "--";
}

$percent = min(100, round(exec('ps ax | grep -c apache') / 256 * 30 ));
echo "<B>Tracker Load:</B> ($percent%)<br>";

echo("<b>Current Users:</b> $users[0]<br>");
echo("<b>Current Load:</b> $loadnow<br><b>Load 15 mins ago:</b> $load15<br><b>Load 30 mins ago:</b> $load30<br><hr>");

// Operating system
$fp = @fopen("/proc/version", "r");
if ($fp) {
  $temp = @fgets($fp);
  fclose($fp);

  if (preg_match("/version (.*?) /", $temp, $osarray)) {
    $kernel = $osarray[1];
    preg_match("/[0-9]{5,} (\((.* *)\)\))/", $temp, $osarray);
    $flavour = $osarray[2];
    $operatingsystem = $flavour." (".PHP_OS." ".$kernel.")";
    if (preg_match("/SMP/", $buf)) {
      $operatingsystem .= " (SMP)";
    }
  } else {
    $result = "(N/A)";
  }
} else {
  $result = "(N/A)";
}

echo("<b>Operating System:</b><br>$operatingsystem");
}
CloseTable();
OpenTable('Cache');
//path to directory to scan
$directory = "cache/";
 
//get all image files with a .jpg extension.
$images = glob("" . $directory . "*");
 
//print each file name
echo "<table border=\"1\" cellpadding=\"3\" width=\"100%\">";
echo "<thead><tr><td>Name</td><td>Last Modefided</td><td>Size</td></tr>";
foreach($images as $image)
{
echo "<tr><td>".((strlen($image) <= 51) ? $image : substr($image,0,50))."</td>";
if (file_exists($image)) {
    echo "<td>".date ("F d Y H:i:s.", filemtime($image))."</td>";
echo "<td>".mksize(filesize($image))."</td></tr>";
}
}
echo "</table>";
CloseTable();
}

include("footer.php");
?>