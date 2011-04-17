<?php
        if(! $res = $db->sql_query(
        "SELECT *
FROM `torrent_categories`
ORDER BY `torrent_categories`.`parent_id` , `torrent_categories`.`id` , `torrent_categories`.`sort_index` ASC"
        ) )
            bterror("SELECT id, name FROM ".$db_prefix."_categories ORDER BY sort_index, id ASC");
 $ncats = 0;
		$first=true;
        while ($row = $db->sql_fetchrow($res)){
		if($row['parent_id'] == '-1'){
		$ncats = ($ncats + 1);
		if(!isset($first_id))$first_id = $row['id'];
		   $template->assign_block_vars('cats_var', array(
				"ID"           => $row['id'],
				"NAME"         => $row['name'],
				"IMAGE"        => (file_exists("themes/".$theme."/pics/cat_pics/".$row["image"])) ? "<img src=\"themes/".$theme."/pics/cat_pics/".$row["image"]."\" title=\"".$row["name"]."\" border=\"0\" alt=\"".$row["name"]."\" width=\"30px\">" : "<img src=\"cat_pics/".$row["image"]."\" border=\"0\" title=\"".$row["name"]."\" alt=\"".$row["name"]."\" width=\"30px\">",
				"PARENT_ID"    =>  $row['parent_id'],
				"TABLETYPE"    =>  $row['tabletype'],
				"SUBSCOUNT"    =>  $row['subcount'],
		   ));
		}else{//subcount
		if($first_id == $row['parent_id'] and !isset($count)) $count = 0;
		if($count == 0)$count = $row['subcount'];
		$count = ($count -1);
		//echo $count."<br>";
   $template->assign_block_vars('sub_cats_var', array(
		"ID"           => $row['id'],
		"NAME"         => $row['name'],
		"IMAGE"        => (file_exists("themes/".$theme."/pics/cat_pics/".$row["image"])) ? "<img src=\"themes/".$theme."/pics/cat_pics/".$row["image"]."\" title=\"".$row["name"]."\" border=\"0\" alt=\"".$row["name"]."\" width=\"30px\">" : "<img src=\"cat_pics/".$row["image"]."\" border=\"0\" title=\"".$row["name"]."\" alt=\"".$row["name"]."\" width=\"30px\">",
		"PARENT_ID"    =>  $row['parent_id'],
		"TABLETYPE"    =>  $row['parent_id'],
		"DIVSTART"     =>  ($count == ($row['subcount'] -1)) ? true : false,
		"DIVEND"       =>  ($count == 0) ? true : false,
   ));
		}
		$this_id = $row['parent_id'];
		}
$template->assign_vars(array(
        'NCATS_VAR'     => $ncats,
		'FIRST_SUB'     => $first_id,
));

?>