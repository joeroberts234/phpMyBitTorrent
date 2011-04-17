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

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
$startpagetime = microtime();
require_once("include/config.php");
if($op != 'profile' && $op != 'editprofile')themeheader();
include_once("language/mailtexts.php");


if (!empty($_GET["returnto"])) {
	$returnto = $_GET["returnto"];
	$returnto = str_replace('mode=login','',$returnto);

}
$welcome = <<<EOF
[center][size=7][color=yellow]This website cannot function correctly without JavaScript![/color][/size][/center]
[center][color=red][size=4][font=times]Please do not be afraid if you only see one seed on a torrent here, the site runs 2 dedi servers + 5 seedbox servers, to back this up there are also 6 users we know of who upload here using servers too. these are all on 100mb/s lines and the speeds are fantastic.[/font][/size][/color][/center]

[center][color=teal] [size=5][font=tahoma]Please contact a member of staff if you wish to donate towards the server costs, or pm Black_heart[/font][/size][/color][/center]

Uploaders wanted the Uploader position is really easy
Just need to know a few things
1. do you know how to make a torrent and make it private
2. can you seed for at least 48 hours or till torrent has 2 seeders on it
3. can you bring good quality torrents (no trash)
4. can upload 5 torrents per week
5. no multi tracker torrents
6. Must have at least a 1mb/s upload speed
If you feel you Have something to Bring Please contact me [url=http://p2p-evolution.com/pm.php?op=send&to=5]Black_heart[/url] or One of our [url=http://p2p-evolution.com,/staff.php]Staff[/url]
Please Be ready to provide Us with an Instant messenger

[center]We are a non-profit organisation entirely dependent on you, the members, to keep us running. We take pride in our unique community and encourage every member to be a part of it. As we do not have our servers or bandwidth donated, we have to pay the bills every month. We therefore ask anyone who is able, to make a donation to contribute to our costs. All donors will receive a pretty star by their name.
Or follow this link to donation page [url=http://p2p-evolution.com/donate.php]Donate[/url][/center]  :thankyou:  :thankyou:  :thankyou:  :thankyou: 
EOF;
switch ($op) {
        case "loginform": {
                //include("header.php");
                OpenTable(_btlogin);
                echo "<form method=\"POST\" action=\"user.php\"><input type=\"hidden\" name=\"op\" value=\"login\">\n";
                echo "<p align=\"center\">"._btusername."<br><input type=\"text\" name=\"username\" size=\"17\">\n<br>"._btpassword."<br><input type=\"password\" name=\"password\" size=\"17\"></p>\n";
                if ($gfx_check) {
                        $rnd_code = strtoupper(RandomAlpha(5));
                        echo "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\"><br><input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\">";
                        echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\">\n\n\n\n";
                }
                echo "<p><input type=\"submit\" value=\""._btlogin."\"></p></form>";
        	echo "<p><a href=\"user.php?op=register\">"._btsignup."</a><br />\n\n";
                CloseTable();
                break;
        }
        case "login": {
                if (!isset($username) OR $username == "" OR !isset($password) OR $password == "") {
                        bterror(_btusrpwdnotset,_btlogin); //missing data
                } elseif ($gfx_check AND (!isset($gfxcode) OR $gfxcode == "" OR $gfxcheck != md5(strtoupper($gfxcode)))) {
                        bterror(_bterrcode,_btlogin);
                } else {
                        $result = $db->sql_query("SELECT active FROM ".$db_prefix."_users WHERE clean_username = '".addslashes(strtolower($username))."' AND password = '".md5($password)."'");
                        if ($db->sql_numrows($result) == 1) {
                                list ($active) = $db->sql_fetchrow($result);
                                if ($active == 1) {
								$ip = getip();
        $sql = "UPDATE ".$db_prefix."_users SET lastip = '".sprintf("%u",ip2long($ip))."', lasthost = '".gethostbyaddr($ip)."', lastlogin = NOW() WHERE clean_username = '".addslashes(strtolower($username))."';";
        $db->sql_query($sql);

								if (isset($remember) AND $remember == "yes"){
								 $db->sql_query("UPDATE ".$db_prefix."_users SET rem = 'yes' WHERE clean_username = '".addslashes(strtolower($username))."';")or die("thats not fare");
								$autologin =true;
								 }
                                        ob_end_clean();
                                        unset($btuser);
                                        userlogin($username, $btuser);
										if(!$returnto)header("Location: ".$siteurl."/user.php?op=loginconfirm");
										else
										header("Location: ".$siteurl."/user.php?op=loginconfirm&returnto=".$returnto);
										#header('location: ' . $returnto);
                                        die('test');
                                }
                                else {
                                        bterror(_btuserinactive,_btlogin); //user not active
                                }
                        } else {
						logerror('User login failed for '.$username, 'Failed Login');
                                bterror(_btuserpasswrong,_btlogin); //bad data
                        }
                }
                break;
        }
        case "loginconfirm": {

		if (!empty($returnto)) {
		$returnto = str_replace('@','&', $returnto);
				echo "<meta http-equiv=\"refresh\" content=\"3;url=" . $returnto."\">";
		}
		else {
				
				echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
				}
                $sql = "SELECT level FROM ".$db_prefix."_users WHERE id = '".$user->id."';";
                $res = $db->sql_query($sql);
                list ($level) = $db->sql_fetchrow($res);
                $db->sql_freeresult($res);
                OpenTable(_btlogin);
                echo "<p>".str_replace("**priv**",@constant("_btclass".$level),_btloginsuccessful)."</p>";
                CloseTable();
                break;
        }
        case "logout": {
                setcookie("btuser","",time()-3600,$cookiepath,$cookiedomain,0);
                setcookie("btlanguage","",time()-3600,$cookiepath,$cookiedomain,0);
                setcookie("bttheme","",time()-3600,$cookiepath,$cookiedomain,0);
                $db->sql_query("UPDATE ".$db_prefix."_users SET act_key ='".RandomAlpha(32)."' WHERE id = '".$user->id."';");
                $db->sql_query("DELETE FROM ".$db_prefix."_online_users WHERE id = '".$user->id."';"); 
				if($forumshare)forumlogout($user->id); 
				$btuser = "";
                ob_end_clean();
                header("Location: ".$siteurl."/user.php?op=logoutconfirm");
                die();
        }
        case "logoutconfirm": {
                echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
                OpenTable(_btlogin);
                echo "<p>"._btlogoutsuccessful."</p>";
                CloseTable();
                break;

        }
        case "takeregister": {
                if ($user->user) die();
                include("user/takeregister.php");
                break;
        }
        case "banchat": {
		if(!checkaccess("bann_shouts")){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to Ban Shouts</p>";
CloseErrTable();
break;
}
                OpenTable("Shout Ban");
                echo "<p>User has ben banned from ShoutBox</p>";
                CloseTable();
                $sql = "UPDATE ".$db_prefix."_users SET can_shout = 'false' WHERE id = '".$id."';";
                if (!$db->sql_query($sql)) btsqlerror($sql);
                break;
        }
        case "demote_user_HNR": {
		if(!checkaccess("hnr_demote")){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to Ban Shouts</p>";
CloseErrTable();
break;
}
logerror("<a href=\"".$siteurl."/user.php?op=profile&id=".$id."\">$n</a> Was demoted by ".$user->name, "HNR Demotion");
                OpenTable("Shout Ban");
                echo "<p>User has ben Demoted For HNR</p>";
                CloseTable();
                $sql = "UPDATE ".$db_prefix."_users SET can_do = 'SHIT HEAD' WHERE id = '".$id."';";
                if (!$db->sql_query($sql)) btsqlerror($sql);
break;
		}
        case "unbanchat": {
		if(!checkaccess("bann_shouts")){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to Ban Shouts</p>";
CloseErrTable();
break;
}
                OpenTable("Shout Ban");
                echo "<p>User has ben unbanned from ShoutBox</p>";
                CloseTable();
                $sql = "UPDATE ".$db_prefix."_users SET can_shout = 'true' WHERE id = '".$id."';";
                if (!$db->sql_query($sql)) btsqlerror($sql);
                break;
        }
        case "confirm": {
                //if ($user->user) die();
				$username			                                = request_var('username', '');
				$act_key			                                = request_var('act_key', '');
                $errmsg = Array();
				//die($username);
                if (!isset($username) OR $username == "")
                        $errmsg[] = _bterrusernamenotset;
                if (!isset($act_key) OR $act_key == "")
                        $errmsg[] = _bterrkeynotset;
                if (count($errmsg) == 0) {
                        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".escape($username)."';")) == 0)
                                $errmsg[] = _bterrusernotexists;
                        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".escape($username)."' AND active = 1;")) != 0)
                                $errmsg[] = _btuseralreadyactive;
                        if ($db->sql_numrows($db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE username ='".escape($username)."' AND md5(act_key) = '".escape($act_key)."';")) == 0)
                                $errmsg[] = _bterrinvalidactkey;
                }
                if (count($errmsg) != 0) bterror($errmsg,_btacterror);
                $sql = "UPDATE ".$db_prefix."_users SET active = 1 WHERE username = '".escape($username)."';";
                if (!$db->sql_query($sql)) btsqlerror($sql);
				$sql = "INSERT INTO ".$db_prefix."_shouts (user, text, posted) VALUES ('1', '/notice :welcome: our newest Member ".escape($username)."', NOW());";
                $db->sql_query($sql);
                //$sql2 = "INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('0','".getuser($username)."','Welcome','".addslashes($welcome)."',NOW());";
                //$db->sql_query($sql2);

                //userlogin(escape($username),$btuser);
				if($forumshare)forumadd($username);
                OpenTable(_btsignup);
                echo "<p>"._btactcomplete."</p>";
                CloseTable();
                break;
        }
        case "register": {
                if ($user->user) die();
                include_once("user/register.php");
                break;
        }
        case "loginfailure": {
                OpenTable(_btlogin);
                switch (intval($errcode)) {
                        case 1: {
                                bterror(_btusrpwdnotset,_btlogin);
                                break;
                        }
                        case 2: {
                                bterror(_btuserpasswrong,_btlogin);
                                break;
                        }
                        case 3: {
                                bterror(_btuserinactive,_btlogin);
                                break;
                        }
                        case 4: {
                                bterror(_btuserinactive,_btlogin);
                                break;
                        }
                }
                CloseTable();
                break;
        }
        case "loginsuccess": {
                echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
                OpenTable(_btlogin);
                echo "<p>"._btloginsuccessful."</p>";
                CloseTable();
                break;
        }
        case "profile": {
                include("user/profile.php");
                break;
        }
        case "editprofile": {
                include("user/editprofile.php");
                break;
        }
        case "lostpassword": {
                if ($user->user) break;
                include("user/lostpassword.php");
                break;
        }
		case "confirmemail": {
				$uid = $_GET['user'];
				$code = $_GET['mail_key'];
                if (!isset($uid) OR !is_numeric($uid) OR !isset($code)) bterror();
				$npas = "SELECT newemail AS newemail FROM ".$db_prefix."_users WHERE id ='".intval($uid)."' AND mail_key = '".escape($code)."';";
				$snpa =  $db->sql_query($npas);
				$fnpa = $db->sql_fetchrow($snpa);
				if($fnpa[0] === '' OR $fnpa[0] === 0){
				bterror('No E-mail change is set');
				die;
				}
                 $sql = "UPDATE ".$db_prefix."_users SET email = '".$fnpa['newemail']."', mail_key = NULL, newemail = NULL WHERE id = '".intval($uid)."' ;";
                if ($db->sql_query($sql)) {
                        OpenTable(_btlostpassword);
                        echo "<p>"._btlostpwdcomplete."</p>";
                        CloseTable();
                } else bterror(_btlostpwdinvalid,_btlostpassword);
		break;
		}
        case "lostpasswordconfirm": {
                if ($user->user) break;
				$uid = $_GET['uid'];
				$code = $_GET['code'];
                if (!isset($uid) OR !is_numeric($uid) OR !isset($code)) bterror();
				$npas = "SELECT newpasswd AS newpasswd FROM ".$db_prefix."_users WHERE id ='".intval($uid)."' AND md5(act_key) = '".escape($code)."';";
				$snpa =  $db->sql_query($npas);
				$fnpa = $db->sql_fetchrow($snpa);
				if($fnpa[0] === '' OR $fnpa[0] === 0){
				bterror('No recover password is set');
				die;
				}
                 $sql = "UPDATE ".$db_prefix."_users SET password = '".$fnpa['newpasswd']."', newpasswd = NULL WHERE id = '".intval($uid)."' ;";
                if ($db->sql_query($sql)) {
                        OpenTable(_btlostpassword);
                        echo "<p>"._btlostpwdcomplete."</p>";
                        CloseTable();
                } else bterror(_btlostpwdinvalid,_btlostpassword);
                break;
        }
        case "delete": {
                if (!$user->user) loginrequired("user");
                if (isset($id)) {
                        //if (!$user->admin) loginrequired("admin");
						if (!checkaccess('del_users')) {
						OpenErrTable(_btaccdenied);
						echo "<p>You do not have access to delete this Person</p>";
						CloseErrTable();
						}
                        else $uid = $id;
                        $sql = "SELECT username, ban FROM ".$db_prefix."_users WHERE id = '".$uid."';";
                        $res = $db->sql_query($sql);
                        list ($username, $ban) = $db->sql_fetchrow($res);
                        $db->sql_freeresult($res);
						if($ban == 1) bterror("User is banned do not delete",_btdeluser);
                        if (empty($username)) bterror(_bterrusernotexists,_btdeluser);
                } else $uid = $user->id;
if(getlevel($uid) == "owner" && $user->group != "owner"){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to edit this Person</p>";
CloseErrTable();
break;
}

                if (isset($postback)) {
                        $sql = "SELECT avatar FROM ".$db_prefix."_users WHERE id = '".$id."';";
                        $res = $db->sql_query($sql);
                        list ($avatar) = $db->sql_fetchrow($res);
                        $db->sql_freeresult($sql);
                        if (eregi("^user/",$avatar)) @unlink($avatar);

                        if ($gfx_check AND (!isset($gfxcode) OR $gfxcode == "" OR $gfxcheck != md5(strtoupper($gfxcode)))) bterror(_bterrcode,_btdeluser);
						if($forumshare AND get_user_forum_name($username)>=2)forum_delete($uid, $username);
                        $sql = Array();
                        $sql[] = "DELETE FROM ".$db_prefix."_tickets WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_snatched WHERE userid = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_shouts WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_download_completed WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_backup WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_file WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_global WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_comments_notify WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_seeder_notify WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_online_users WHERE id = '".$uid."';";
                        $sql[] = "UPDATE ".$db_prefix."_torrents SET owner = '0', ownertype = '2' WHERE owner = '".$uid."';";
                        $sql[] = "UPDATE ".$db_prefix."_peers SET uid = '0' WHERE uid = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_private_messages_bookmarks WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_private_messages WHERE recipient = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_users WHERE id = '".$uid."';";

                        foreach ($sql as $query) {
                                $db->sql_query($query) or btsqlerror($sql);
                        }

                        OpenTable(_btdeluser);
                        echo "<p>"._btaccountdeleted."</p>";
                        if (!isset($id)) echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
                        CloseTable();
                } else {
                        OpenTable(_btdeluser);
                        if (isset($id)) echo "<p>".str_replace("**user**",htmlspecialchars($username),_btdeluserwarningadm)."</p>";
                        else echo "<p>"._btdeluserwarning."</p>";

                        echo "<form method=\"POST\" action=\"user.php\"><input type=\"hidden\" name=\"op\" value=\"delete\" />\n";
                        if (isset($id)) echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\" />\n";

                        if ($gfx_check) {
                                $rnd_code = strtoupper(RandomAlpha(5));
                                echo _btsecuritycode."<br>\n<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\" alt=\"Security Code\"><br>\n<input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\">";
                                echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\"><br>\n";
                        }

                        echo "<p align=\"center\"><input type=\"submit\" name=\"postback\" value=\""._btconfirmdelete."\"></p>\n";

                        echo "</form>";
                        CloseTable();
                }

                break;
        }
        default: bterror("");
}

include("footer.php");
?>
