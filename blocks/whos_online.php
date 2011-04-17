<?php
$sqlev = "SELECT name, color FROM ".$db_prefix."_levels";
$reslev = $db->sql_query($sqlev);
        while ($rowlev = $db->sql_fetchrow($reslev)) {
   $template->assign_block_vars('legend', array(
		"NAME"              => $rowlev['name'],
		"COLOR"             => $rowlev['color'],
   ));
}
$db->sql_freeresult($reslev);
$sql = "SELECT O.id AS id, O.page AS page, UNIX_TIMESTAMP(O.logged_in) AS logged_in, IF(U.name IS NULL, U.username, U.name) as name, U.lastpage as lastpage, U.donator AS donator, U.warned AS warned, U.can_do as can_do, U.level AS level, U.Show_online AS Show_online, U.uploaded as uploaded, U.downloaded AS downloaded FROM ".$db_prefix."_online_users O LEFT JOIN ".$db_prefix."_users U ON O.id = U.id WHERE UNIX_TIMESTAMP(NOW()-U.lastlogin) < 1800 ;";
$res = $db->sql_query($sql);
$tot = $db->sql_numrows($res);
$i = 1;
$user_now = $db->sql_numrows($res);
if ($user_now == 0){
	$template->assign_vars(array(
	'S_USER_ON' => $user_now,
	'IS_USERS_ON' => false,
	));

}else {
	$template->assign_vars(array(
	'S_USER_ON' => $user_now,
	'IS_USERS_ON' => true,
	));
        while ($row = $db->sql_fetchrow($res)) {
   $template->assign_block_vars('user_online', array(
		"SHOW"              => ($row['Show_online'] == 'true' ) ? true : (($user->admin) ? true : false),
		"SHOW_ICON"         => ($row['Show_online'] == 'true' ) ? false : true,
		"LEVEL_ICON"        => ($row["level"] == "admin") ? pic("icon_admin.gif",'','admin') : (($row["level"] == "moderator") ? pic("icon_moderator.gif",'','moderator') : (($row["level"] == "premium") ?  pic("icon_premium.gif",'','premium') : '')),
		"ID"                => $row['id'],
		"USERNAME"          => htmlspecialchars($row["name"]),
		"DONER"             => ($row["donator"] == 'true') ? true : false,
		"WARNED"            => ($row["warned"] == '1') ? true : false,
		"RATIO"             => get_u_ratio($row["uploaded"], $row["downloaded"]),
		"COLOR"             => getusercolor($row["can_do"]),
		"LAST_PAGE"         => getlastaction($row['lastpage']),
		"ON_TIME"           => mkprettytime(time()-$row["logged_in"]),
		));
        }
}
$db->sql_freeresult($res);
        //Total users
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_users WHERE `active` = 1 AND UNIX_TIMESTAMP(lastlogin) > UNIX_TIMESTAMP(NOW()) - 86400;";
        $res = $db->sql_query($sql);
        list ($totuser) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
$template->assign_vars(array(
        'ON_NOW'            => $totuser,
));
        //Total users
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_users WHERE `active` = 1 AND UNIX_TIMESTAMP(regdate) > UNIX_TIMESTAMP(NOW()) - 86400*7;";
        $res = $db->sql_query($sql);
        list ($totuser) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
$template->assign_vars(array(
        'ON_REG_WEEK'            => $totuser,
));
        //Total users
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_users WHERE `active` = 1 AND UNIX_TIMESTAMP(regdate) > UNIX_TIMESTAMP(NOW()) - 86400;";
        $res = $db->sql_query($sql);
        list ($totuser) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
$template->assign_vars(array(
        'ON_REG_DAY'            => $totuser,
));
        //Total users
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_users;";
        $res = $db->sql_query($sql);
        list ($totuser) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
$template->assign_vars(array(
        'TOTAL_USERS'            => $totuser,
));
        //Total Torrents and their size
        $sql = "SELECT COUNT(id), SUM(size) FROM ".$db_prefix."_torrents;";
        $res = $db->sql_query($sql);
        list ($tottorrent, $totshare) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
$template->assign_vars(array(
        'TOTTAL_TORRENTS'            => $tottorrent,
        'TOTAL_DATA'            => mksize($totshare),
));
        //Total peers and their speed
        $sql = "SELECT COUNT(id), (SUM(upload_speed)+SUM(download_speed))/2 FROM ".$db_prefix."_peers;";
        $res = $db->sql_query($sql);
        list ($totpeers, $totspeed) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        //Total seeders and total leechers
        $sql = "SELECT COUNT(id) FROM ".$db_prefix."_peers GROUP BY seeder ORDER BY seeder ASC;";
        $res = $db->sql_query($sql);
        list ($totseeders) = $db->sql_fetchrow($res);
        list ($totleechers) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
$template->assign_vars(array(
        'TOTTAL_SEEDERS'            => $totseeders,
        'TOTAL_LEACHERS'            => $totleechers,
        'TOTAL_PEERS'            => ($totleechers+$totseeders),
        'TRANSFER_SPEED'            => mksize($totspeed),
));
        $sql = "SELECT COUNT(id) as cnt, client FROM ".$db_prefix."_peers WHERE client IS NOT NULL GROUP BY client ORDER BY cnt DESC LIMIT 1;";
        $res = $db->sql_query($sql);
        list ($cnt, $client) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
$template->assign_vars(array(
        'MOST_CLIENTS'            => $client,
        'M_CLIENT_CO'            => $cnt,
));
?>