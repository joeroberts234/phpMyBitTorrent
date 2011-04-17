<?php

function get_user_tracker_name($username){
global $db, $forumpx, $db_prefix;

        $sql = ("SELECT * FROM ".TRACKERPX."_users WHERE username ='".$username."'LIMIT 1");
		#die($sql);
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr = $db->sql_fetchrow($res);
$fid = "".$arr['user_id']."";
return "".$fid."";
}

function get_user_tracker_id($uid) {
global $db, $forumpx, $db_prefix;
        $sql =("SELECT * FROM ".FORUMPRX."_users WHERE user_id = '".$uid."'LIMIT 1");
		#die($sql);
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr1 = $db->sql_fetchrow($res);
        $sql = ("SELECT * FROM ".TRACKERPX."_users WHERE username ='".$arr1['username']."'LIMIT 1");
		#die($sql);
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$arr = $db->sql_fetchrow($res);
$fid = "".$arr['id']."";
return "".$fid."";
}
function delte_tracker_user($uid)
{
global $db, $forumpx, $db_prefix;
$uid = get_user_tracker_id($uid);
                        $sql = "SELECT username FROM ".TRACKERPX."_users WHERE id = '".$uid."';";
                        $res = $db->sql_query($sql);
                        $rowname = $db->sql_fetchrow($res);
						$username= $rowname['username'];
                        $db->sql_freeresult($res);
                        if (empty($username)) die($username);

                        $sql = "SELECT avatar FROM ".TRACKERPX."_users WHERE id = '".$id."';";
                        $res = $db->sql_query($sql);
                        list ($avatar) = $db->sql_fetchrow($res);
                        $db->sql_freeresult($sql);
                        if (eregi("../../avatars/user/",$avatar)) @unlink($avatar);
                        $sql = Array();
                        $sql[] = "DELETE FROM ".TRACKERPX."_download_completed WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_privacy_backup WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_privacy_file WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_privacy_global WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_comments_notify WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_seeder_notify WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_online_users WHERE id = '".$uid."';";
                        $sql[] = "UPDATE ".TRACKERPX."_torrents SET owner = '0', ownertype = '2' WHERE owner = '".$uid."';";
                        $sql[] = "UPDATE ".TRACKERPX."_peers SET uid = '0' WHERE uid = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_private_messages_blacklist WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_private_messages_bookmarks WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_private_messages WHERE recipient = '".$uid."';";
                        $sql[] = "DELETE FROM ".TRACKERPX."_users WHERE id = '".$uid."';";

                        foreach ($sql as $query) {
                                $db->sql_query($query) or btsqlerror($sql);
                        }
}

// --------------------------------------------------------------------
// ------------------------ Update mybit password ------------------------
// --------------------------------------------------------------------

function update_mybitpassword ($username, $newMD5password)
{
	global $share_phpbb2_users_with_TT,$activate_phpbb2_forum;
	//if(($share_phpbb2_users_with_TT!=true)||($activate_phpbb2_forum!=true)) return;
	if ((!isset($newMD5password))||(!isset($username))) return;
	
	$res = mysql_query("SELECT id FROM torrent_users WHERE username = '$username'");
	$row = mysql_fetch_array($res);
	mysql_query("UPDATE torrent_users SET password='" . $newMD5password . "' WHERE id=".$row["id"]);
}

// --------------------------------------------------------------------
// ------------------------ Update mybit email ------------------------
// --------------------------------------------------------------------

function update_mybitemail ($username, $newemail)
{
	global $share_phpbb2_users_with_TT,$activate_phpbb2_forum;
	//if(($share_phpbb2_users_with_TT!=true)||($activate_phpbb2_forum!=true)) return;
	if ((!isset($newemail))||(!isset($username))) return;
	
	$res = mysql_query("SELECT id FROM torrent_users WHERE username = '$username'");
	$row = mysql_fetch_array($res);
	mysql_query("UPDATE torrent_users SET email='" . $newemail . "' WHERE id=".$row["id"]);
}

?>