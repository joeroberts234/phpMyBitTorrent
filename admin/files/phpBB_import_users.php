<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
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
if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
//define('FORUM_ADD',TRUE);

$sql = ("SELECT `group_id` FROM `".$forumpx."_groups` WHERE `group_name` ='BOTS'");
		$res = $db->sql_query($sql) or btsqlerror($sql);
        $arr = $db->sql_fetchrow($res);
		$bot = $arr['group_id'];
$sql = ("SELECT username_clean, user_email FROM ".$forumpx."_users WHERE  user_id <> ' 1 ' AND group_id <> ".$bot." ORDER BY username_clean") ;
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr0 = $db->sql_numrows($res);
$test=array();
$testemail=array();
for ($i=0;$i<$arr0;$i++)
{
$arr00 = $db->sql_fetchrow($res);
$test[$arr00['username_clean']] = addslashes($arr00['username_clean']);
$testemail[$arr00['user_email']] = $arr00['user_email'];
}
$sql = ("SELECT clean_username, email FROM ".$db_prefix."_users  WHERE active= 1 ORDER BY clean_username") ;
		$res1 = $db->sql_query($sql) or btsqlerror($sql);
		$arr1 = $db->sql_numrows($res1);

$test2=array();
$test2email=array();
for ($i=0;$i<$arr1;$i++)
{
$arrpmbt = $db->sql_fetchrow($res1);
$test2[$arrpmbt['clean_username']] = $arrpmbt['clean_username'];
$test2email[$arrpmbt['email']] = $arrpmbt['email'];
}

function get_date_time($timestamp = 0)
{
if ($timestamp)
return date("Y-m-d H:i:s", $timestamp);
else
  $idcookie = $_COOKIE['uid'];
  return gmdate("Y-m-d H:i:s", time());
}


//$verif = $HTTP_POST_VARS['verif'];
//$phpBB = $HTTP_POST_VARS['phpBB'];
//$phpmybittorent = $HTTP_POST_VARS['phpmybittorrent'];


OpenTable("PHPBB users Verification");

if (!isset($verif)&& $verif != "yes")
{
	echo "<br>This little page will help you synchronize your memberlist between phpBB3 and phpMyBitTorrent<br><br>";
	echo "- It will generate a list with all missing phpBB3 accounts<br>";
	echo "- It will generate a list with all missing phpMyBitTorrent accounts <br><br>";
	echo "- It will not generate new accounts if the email exist  <br><br>";
	echo '<form method="post" action="admin.php?op=phpBB_import_users#phpBB_import_users">';
	echo '<input name="verif" value="yes" type="hidden">';
	echo '<input name="submit" value="Start" type="submit">';
	echo '</form>';
CloseTable();
include("footer.php");
	exit();
}

if ($verif=="yes")
{
global $db, $forumpx, $db_prefix;
echo "<table height=\"100%\" width=\"100%\" border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">";
echo "<tr>";
echo "<td height=\"100%\" width=\"50%\" align=\"center\"><br>The accounts below exist in the Forums,<br> But does not exist in the Tracker.<br> It is to advise the Admin.<br><br>";
echo "</td>";
echo "<td height=\"100%\" width=\"50%\" align=\"center\"><br>The accounts below exist in Tracker,<br> but not in the Forum.<br> It is to advise the importer.<br><br>";
echo "</td></tr></table>";
CloseTable();
OpenTable("PHPBB users Verification");
echo "<table height=\"100%\" width=\"100%\" border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "<td height=\"100%\" width=\"25%\" align=\"center\">\n";
	echo "<form method=\"post\" action=\"admin.php?op=phpBB_import_users#phpBB_import_users\">";
	echo "<input name=\"verif\" value=\"no\" type=\"hidden\">";
	echo "<input name=\"bittorrent\" value=\"IMPORTER To Tracker\" type=\"submit\">";
	echo "</form>";
echo "</td>\n";
echo "<td height=\"100%\" width=\"25%\" align=\"center\">\n";
	echo "<form method=\"post\" action=\"admin.php?op=phpBB_import_users#phpBB_import_users\">";
	echo "<input name=\"verif\" value=\"no\" type=\"hidden\">";
	echo "<input name=\"bittorrent\" value=\"DELETE FORUM USERS\" type=\"submit\">";
	echo "</form>";
echo "</td>\n";
echo "<td height=\"100%\" width=\"25%\" align=\"center\">\n";
	echo "<form method=\"post\" action=\"admin.php?op=phpBB_import_users#phpBB_import_users\">";
	echo "<input name=\"verif\" value=\"no\" type=\"hidden\">";
	echo "<input name=\"phpBB\" value=\"IMPORTER To Forum\" type=\"submit\">";
	echo "</form>";
echo "</td>\n";
echo "<td height=\"100%\" width=\"25%\" align=\"center\">";
	echo "<form method=\"post\" action=\"admin.php?op=phpBB_import_users#phpBB_import_users\">";
	echo "<input name=\"verif\" value=\"no\" type=\"hidden\">";
	echo "<input name=\"phpBB\" value=\"DELETE TRACKER USERS\" type=\"submit\">";
	echo "</form>";
echo "</td></tr></table>";
CloseTable();
OpenTable("PHPBB users Verification");
echo "<table height=\"100%\" width=\"100%\" border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">";
echo "<tr>";
echo "<td height=\"100%\" width=\"50%\" align=\"center\">";
$sqlbb = ("SELECT user_id, username_clean, user_email FROM ".$forumpx."_users WHERE  user_id <> ' 1 ' AND group_id <> ".$bot." AND username_clean NOT IN ( '".implode("','",$test2)."') AND user_email NOT IN ( '".implode("','",$test2email)."')ORDER BY username_clean") ;
		$resbb = $db->sql_query($sqlbb) or btsqlerror($sqlbb);
		$arr0bb = $db->sql_numrows($resbb);
		echo "<p>".$arr0bb."<br>";
for ($i=0;$i<$arr0bb;$i++)
{
$bbuser = $db->sql_fetchrow($resbb);
$bbusername = $bbuser["username_clean"];
$bbemail = $bbuser["user_email"];
echo "<a href=\"phpBB.php?page=memberlist.php&mode=viewprofile&u=".$bbuser["user_id"]."\">".$bbusername."</a><br>\n";
}
echo"</p></td>";
$sqlnow = ("SELECT username, clean_username, email FROM ".$db_prefix."_users WHERE active= 1  AND clean_username NOT IN ( '".implode("','",$test)."') AND email NOT IN ( '".implode("','",$testemail)."') ORDER BY username") ;
		$res1now = $db->sql_query($sqlnow) or btsqlerror($sqlnow);
		$arr1now = $db->sql_numrows($res1now);

echo "<td height=\"100%\" width=\"50%\" align=\"center\">";
echo "<p>".$arr1now."<br>";
for ($i=0;$i<$arr1now;$i++)
{
$pmbtuser = $db->sql_fetchrow($res1now);
$ptusername = $pmbtuser["username"];
$ptemail = $pmbtuser["email"];
//die(implode('<br>', $test2));
if (!in_array($ptusername, $test,true)){
if (!array_key_exists($ptemail, $testemail)){
echo "<a href=\"user.php?op=profile&username=".$ptusername."\">".$ptusername."</a><br>";
}
}
}
echo "</p><br></td>";
echo "</tr></table>";
CloseTable();
}

if ($phpBB=="IMPORTER To Forum")
{
global $db, $forumpx, $db_prefix;
	echo "<b>STEP 1</b><br/>Generate missing Forum accounts<br/>Update existing Forum accounts with matching phpMyBittorrent account values<br/><br/>";
	
	$pmbtsql = "SELECT username, clean_username FROM ".$db_prefix."_users WHERE  active= 1 AND clean_username NOT IN ( '".implode("','",$test)."') AND email NOT IN ( '".implode("','",$testemail)."') " ;
		$pmbtresset = $db->sql_query($pmbtsql) or btsqlerror($pmbtsql);
		$pmbtarr35 = $db->sql_numrows($pmbtresset);
	
		//while ($arr33 = $db->sql_fetchrow($resset)){
		echo $pmbtarr35."<br>";
for ($i=0;$i<$pmbtarr35;$i++){
	$pmbtsql2 = "SELECT username, clean_username FROM ".$db_prefix."_users WHERE  active= 1 AND clean_username NOT IN ( SELECT username_clean FROM ".$forumpx."_users WHERE  user_id <> ' 1 ' AND group_id <> ".$bot.") AND email NOT IN ( SELECT user_email FROM ".$forumpx."_users WHERE  user_id <> ' 1 ' AND group_id <> ".$bot.") AND id <> '2141' LIMIT 1" ;
		$pmbtresset2 = $db->sql_query($pmbtsql2) or btsqlerror($pmbtsql2);
$pmbtarr332 = $db->sql_fetchrow($pmbtresset2);
	echo $pmbtarr332['clean_username'];
if(!forumadd($pmbtarr332['username']) == false){	
			echo "<font color='green'>Forum user " . $pmbtarr332['clean_username'] . " created</font><br/>";
			}else{
			echo "<font color='red'>Forum user " . $pmbtarr332['clean_username'] . " Not created</font><br/>";
			}
ob_flush();
sleep(1);
			}

}

if ($phpBB=="DELETE TRACKER USERS")
{
global $db, $forumpx, $db_prefix;
$sql = ("SELECT id, username FROM ".$db_prefix."_users WHERE username NOT IN (SELECT username FROM ".$forumpx."_users) AND active= 1 ") ;
		$res = $db->sql_query($sql) or btsqlerror($sql);
	$num = $db->sql_numrows($res);
	
	for ($i=0;$i<$num;$i++)
	{
		$arr = $db->sql_fetchrow($res);
		$uid = $arr['id'];
		delte_tracker_user($uid);
echo "User " . $arr['username'] . " deleted !<br>";
}
}

if ($bittorrent=="IMPORTER To Tracker")
{
global $db, $forumpx, $db_prefix;
	echo "<b>STEP 2</b><br/>Generate missing phpMyBitTorrent accounts<br/><br/>";
    $sql = "SELECT username, user_id, user_email, user_password, user_regdate	FROM ".$forumpx."_users WHERE user_id <> '1' ORDER BY user_id";

	if( !($result = $db->sql_query($sql)) )
	{
		sqlerr(__FILE__, __LINE__);
		return;
	}
	
	if ( $row = $db->sql_fetchrow($result) )

	{
		$i = 0;
		do
		{
			$phpBB_username = $row['username'];
			$phpBB_user_id = $row['user_id'];
			$phpBB_user_email = $row['user_email'];
			$phpBB_user_pwd = $row['user_password'];
			$phpBB_regdate = $row['user_regdate'];
			$act_key = RandomAlpha(32);
			
			//check if this phpBB users exists in PMBT

			$res = $db->sql_query("SELECT id,username,password,email FROM ".$db_prefix."_users WHERE username='$phpBB_username' ORDER BY id") ;
			$num = $db->sql_numrows($res);
			if ($num!=1)
			{
				
		    $ret = $db->sql_query("INSERT INTO ".$db_prefix."_users (username, clean_username, email, password, act_key, regdate, active) VALUES ('".$phpBB_username."', '".strtolower($phpBB_username)."', '".$phpBB_user_email."','". $phpBB_user_pwd."', '".$act_key."' , '" . get_date_time() . "', 1)");
		
		    if (!$ret) 
		    {
		      echo "Error creating " . $phpBB_username . " user<br/>";
		    }
		    else
		    {
		    	echo "Torrent user " . $phpBB_username . " created<br/>";
		    }
			}
		}
		while ( $row = $db->sql_fetchrow($result) );
		$db->sql_freeresult($result);
	}
}

if ($bittorrent=="DELETE FORUM USERS")
{
global $db, $forumpx, $db_prefix, $user;
ob_flush();
ob_start();
	echo "<b>STEP 1</b><br/>Generate missing Forum accounts<br/>Update existing Forum accounts with matching phpMyBittorrent account values<br/><br/>";
ob_flush();
flush();
ob_end_flush();
ob_start();

$sql = ("SELECT `group_id` FROM `".$forumpx."_groups` WHERE `group_name` ='BOTS'");
		$res = $db->sql_query($sql) or btsqlerror($sql);
        $arr = $db->sql_fetchrow($res);
		$bot = $arr['group_id'];

$sql2 = ("SELECT COUNT(user_id)as users FROM ".$forumpx."_users WHERE  user_id <> ' 1 ' AND group_id <> ".$bot." AND username_clean NOT IN ( '".implode("','",$test2)."') AND user_email NOT IN ( '".implode("','",$test2email)."')ORDER BY username_clean") ;
		$res2 = $db->sql_query($sql2);
		$numbero = (int) $db->sql_fetchfield('users');
		$db->sql_freeresult($res2);
		echo $numbero."<br>";
ob_flush();
flush();
ob_end_flush();
for ($i=0;$i<$numbero;$i++){
$sql3 = ("SELECT user_id, username_clean, user_email FROM ".$forumpx."_users WHERE  user_id <> ' 1 ' AND group_id <> ".$bot." AND username_clean NOT IN ( '".implode("','",$test2)."') AND user_email NOT IN ( '".implode("','",$test2email)."') LIMIT 1") ;
		$res3 = $db->sql_query($sql3) or btsqlerror($sql3);
		$arr = $db->sql_fetchrow($res3);
		forum_delete($arr['user_id'], $arr['username_clean']);
echo "User " . $arr['username_clean'] . " deleted !<br>";

ob_flush();
flush();
sleep(1);
ob_end_flush();
}
		/*while($arr = $db->sql_fetchrow($res2)){
		forum_delete($arr['user_id'], $arr['username_clean']);
echo "User " . $arr['username_clean'] . " deleted !<br>";
}*/
                        //$db->sql_freeresult($res2);
						echo "done";
//}
}

CloseTable();

?>