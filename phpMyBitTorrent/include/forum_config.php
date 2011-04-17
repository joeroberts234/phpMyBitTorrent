<?php
if(!$pmbt_cache->get_sql("forum_config")){
$sql = "SELECT * FROM ".$db_prefix."_forum_config LIMIT 1;";
$configquery = $db->sql_query($sql);
if (!$configquery) die("Configuration not found! Make sure you have installed phpMyBitTorrent Forum correctly.");
if (!$row = $db->sql_fetchrow($configquery)) die("phpMyBitTorrent not correctly installed! Ensure you have run setup.php!!");
$pmbt_cache->set_sql("forum_config", $row);
}else{
$row = $pmbt_cache->get_sql("forum_config");
}
$FORUMS = ($row['forum_open'] == 'true')? true : false;
$board_disable_msg = stripslashes($row['board_disable_msg']);
$CENSORWORDS = ($row['censor_words'] == 'true')? true : false;
$postsper_page = $row['postsper_page'];
$topics_per_page = $row['topics_per_page'];
$max_subject_length = $row['max_subject_length'];
$max_post_length = $row['max_post_length'];
$show_latest_topic = ($row['show_latest_topic'] == 'true')? true : false;
$search_word_min = $row['search_word_min'];
$allow_bookmarks = ($row['allow_bookmarks'] == 'true')? true : false;
$shout_new_topic = ($row['shout_new_topic'] == 'true')? true : false;
$shout_new_post = ($row['shout_new_post'] == 'true')? true : false;
?>