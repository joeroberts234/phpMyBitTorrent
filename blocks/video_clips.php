<?php
if(!$pmbt_cache->get_sql("video_clips")){
$query = " SELECT COUNT( DISTINCT id ) AS idcount, id, link, name, addedby, addtime, `group`
FROM ".$db_prefix."_youtubevideo
GROUP BY id
ORDER BY addtime
LIMIT 10 ";
$sql = $db->sql_query($query);
$rowsets = array();
	while ($rowset = $db->sql_fetchrow($sql) ) {
        $rowsets[] = $rowset;
    }
$pmbt_cache->set_sql("video_clips", $rowsets);
}else{
$rowsets = $pmbt_cache->get_sql("video_clips");
}
//print_r($vidrow);
foreach ($rowsets  as $id=>$row) {
   $template->assign_block_vars('vidoe_clip', array(
		"LINK"                =>  str_replace("http://youtube.com/v/","",$row["link"]),
		"NAME"                =>  $row['name'],
   ));
}
?>