<?php
if(!$pmbt_cache->get_sql("today_online")){
unset($rowsets);
        $sql = "SELECT * FROM ".$db_prefix."_users WHERE `active` = 1 AND UNIX_TIMESTAMP(lastlogin) > UNIX_TIMESTAMP(NOW()) - 86400 ORDER BY username  ASC;";
        $res = $db->sql_query($sql);
	while ($rowset = $db->sql_fetchrow($res) ) {
        $rowsets[] = $rowset;
    }
$pmbt_cache->set_sql("today_online", $rowsets);
}else{
$rowsets = $pmbt_cache->get_sql("today_online");
}
        foreach ($rowsets  as $id=>$row) {
   $template->assign_block_vars('user_today', array(
		"USERNAME"          => ($row['name'] == '') ? htmlspecialchars($row['username']) : htmlspecialchars($row["name"]),
		"DONER"             => ($row["donator"] == 'true') ? true : false,
		"WARNED"            => ($row["warned"] == '1') ? true : false,
		"ID"                =>  $row['id'],
		"COLOR"             => getusercolor($row["can_do"]),
		"LEVEL_ICON"        => ($row["level"] == "admin") ? pic("icon_admin.gif",'','admin') : (($row["level"] == "moderator") ? pic("icon_moderator.gif",'','moderator') : (($row["level"] == "premium") ?  pic("icon_premium.gif",'','premium') : '')),
		'LAST_CLICK'        =>  get_formatted_timediff(sql_timestamp_to_unix_timestamp($row["lastlogin"]))
   ));
		}
        $db->sql_freeresult($res);
?>