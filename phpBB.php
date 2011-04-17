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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/

define('IN_PORTAL', true);
$page = $_GET['page'];
if ($page=="posting.php" && $mode=="smilies")
{
define('PHPBB_ROOT_PATH','./phpBB3/');
$phpbb_root_path = './phpBB3/';
	include "./phpBB3/posting.php";
	break;
}
if ($page=="posting.php" && $mode=="popup")
{
define('PHPBB_ROOT_PATH','./phpBB3/');
$phpbb_root_path = './phpBB3/';
	include "./phpBB3/posting.php";
	break;
}
if($page =='download/file.php' && isset($id))
{
define('PHPBB_ROOT_PATH','./phpBB3/');
$phpbb_root_path = './phpBB3/';
	include "./phpBB3/download/file.php";
	break;
}
if($page =='download/file.php' && isset($avatar))
{
define('PHPBB_ROOT_PATH','./phpBB3/');
$phpbb_root_path = './phpBB3/';
	include "./phpBB3/download/file.php";
	break;
}
if ($page=="viewonline.php" && $mode=="whois")
{
define('PHPBB_ROOT_PATH','./phpBB3/');
$phpbb_root_path = './phpBB3/';
	include "./phpBB3/viewonline.php";
	break;
}
define('BT_SHARE', true);
include("header.php");
require_once "include/functions_phpBB3.php";
if (isset($user->id))$pmbtuser=$user->id;
define('PHPBB_ROOT_PATH','./'.$forumbase.'/');
define("folder", $forumbase);
define("basefile2", "./".$phpbb2_basefile); 
define("basefile", "./".$phpbb2_basefile."?"); 
define("basefile3", $phpbb2_basefile);
// -------------- Page not included inside pmbt template -------------------
OpenTable('Forum','880');
        echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  align=\"center\"><tr>";
       echo"<td>"; 

echo "<div >";
echo "<br />";
if (!$forumshare)
{
	echo "<center><b>The Forum is closed</b></center>";
	echo"</div></td></tr></table>";
CloseTable();
include("footer.php");
	exit();
}
$page=str_replace('.php','',$page);
$page=str_replace('?','',$page);
if ($page=="ucp" && $mode=="register")
{
	header('Location: user.php?op=register');
	break;
}
// Visual confirmation (display a security png in register page)
if ($page=="profile" && $mode=="confirm")
{
	include "./".$forumbase."/profile.php";
	break;
}
if ($page == "ucp" AND $mode == "login" )
{
$auto = false;
                if (!isset($username) OR $username == "" OR !isset($password) OR $password == "") {
                        loginrequired("user"); //missing data
                } elseif ($gfx_check AND (!isset($gfxcode) OR $gfxcode == "" OR $gfxcheck != md5(strtoupper($gfxcode)))) {
                        bterror(_bterrcode,_btlogin);
                } else {
                        $result = $db->sql_query("SELECT active FROM ".$db_prefix."_users WHERE username = '".addslashes($username)."' AND password = '".md5($password)."'");
                        if ($db->sql_numrows($result) == 1) {
                                list ($active) = $db->sql_fetchrow($result);
                                if ($active == 1) {
								if (isset($autologin)){ 
								$db->sql_query("UPDATE ".$db_prefix."_users SET rem = 'yes' WHERE username = '".addslashes($username)."';")or die("thats not fare");
								$auto =true;
								}
                                        //ob_end_clean();
                                        unset($btuser);
                                        userlogin($username, $btuser);
         								if($forumshare){
                                             $result2 = $db->sql_query("SELECT level  FROM ".$db_prefix."_users WHERE username = '".addslashes($_POST['username'])."'");
                                             list ($level) = $db->sql_fetchrow($result2);
													if($level == 'admin')$admin = '1';
													else
													$admin = '0';
    										 define( 'IN_PHPBB', true );
    										 $phpbb_root_path = './'.$forumbase . '/'; // change in your own root path.
   											 $phpEx = substr(strrchr(__FILE__, '.'), 1);
   											 include($forumbase . '/common.' . $phpEx);
  										     include($forumbase . '/includes/functions_display.' . $phpEx);
    										 include($forumbase . '/includes/bbcode.' . $phpEx);
    
    											$user->session_begin();
    											$auth->acl( $user->data );
    											$user->setup();
												$user->session_create(get_user_forum_name($_POST['username']), $admin, $auto, $admin);
										}
										header("Location: ".$siteurl."/user.php?op=loginconfirm&returnto=phpBB.php");
										#header('location: ' . $returnto);
                                        die();
                                }
                                else {
                                        bterror(_btuserinactive,_btlogin); //user not active
                                }
                        } else {
                                bterror(_btuserpasswrong,_btlogin); //bad data
                        }
                }
	break;
}

if ($page=="ucp" && $mode=="logout")
{
	header('Location: user.php?op=logout');
	break;
}
//search
if (isset($keywords)){
	include "./".$forumbase."/search.php";
	break;
}
//Profile
if ($page=="ucp" && $i=="profile" )
{
$pagetittleucp = 'ucp';
	include "./".$forumbase."/ucp.php";
	break;
}

// Topic review
if ($page=="posting" && $mode=="topicreview")
{
	include "./".$forumbase."/posting.php";
	break;
}

// download review
if ($page=="download" && $mode=="view")
{
	include "./".$forumbase."/download.php";
	break;
}

if ($page=="memberlist" && $mode=="viewprofile")
{
	include "./".$forumbase."/memberlist.php";
	//break;
}



// More smilies
if ($page=="posting" && $mode=="smilies")
{
	include "./".$forumbase."/posting.php";
	break;
}

// Search username
if($page=="search" && $mode=="searchuser")
{
	include "./".$forumbase."/search.php";
	break;
}

// New private message
if ($page=="privmsg" && $mode=="newpm")
{
	include "./".$forumbase."/privmsg.php";
	break;
}


// Login to the admin panel
if ($page=="login" && $redirect == "admin/index.php")
{
	include "./".$forumbase."/login.php";
	break;
}
#if ($i=="prefs" )
#{
#	include "./".$forumbase."/ucp.php";
#	break;
#}

if ($page=="ucp" )
{
$pagetittleucp = 'ucp';
	include "./".$forumbase."/ucp.php";
include("footer.php");
	exit();
}


switch ($page)
{
	case "faq":
	include "./".$forumbase."/faq.php";
break;
	case "adm/index":
	header("Location: ./phpBB3/adm/index.php?sid=".$sid."");

	
	 case "download":
	include "./".$forumbase."/download.php";
break;


	case "viewforum":
	include "./".$forumbase."/viewforum.php";
break;
	
	case "viewonline":{
	include "./".$forumbase."/viewonline.php";
	break;
    }

	case "viewtopic":{
	include "./".$forumbase."/viewtopic.php";
	break;
	}
	
	case "search":
	include "./".$forumbase."/search.php";
break;
	
	case "privmsg":
	include "./".$forumbase."/privmsg.php";
	
	break;
	case "mcp":
	$pagetittlemcp = 'mcp';
	include "./".$forumbase."/mcp.php";
	
/*break;
	case "ucp":
	$pagetittleucp = 'ucp';
	include "./".$forumbase."123/ucp.php";
	
break;*/


	case "posting":
	include "./".$forumbase."/posting.php";
break;

	case "profile":
	if ($mode=="register" && $share_phpbb2_users_with_TT==true)
	{
		header('Location: account-signup.php');
		break;
	}
	if ($mode=="sendpassword" && $share_phpbb2_users_with_TT==true)
	{
		header('Location: account-recover.php');
		break;
	}
	
	
	case "memberlist":
	include "./".$forumbase."/memberlist.php";
	break;
	
	
	case "index":
	include "./".$forumbase."/index.php";
	break;
	
	
default :
	include "./".$forumbase."/index.php";
	break;
}
echo "</td></table>";
$user = @new User($_COOKIE["btuser"]);

include("footer.php");
?>