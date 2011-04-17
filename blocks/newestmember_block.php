<?php
//USERS ONLINE
$on_index = true;
if(isset($template))$on_index = false;
if($on_index)OpenTable("Newest Members");
global $db_prefix;
$file = "cache/cache_newestmemberblock.txt";
$expire = 60; // time in seconds
if (file_exists($file) &&
    filemtime($file) > (time() - $expire)) {
    $newestmemberrecords = unserialize(file_get_contents($file));
}else{ 
	$newestmemberquery = mysql_query("SELECT * FROM ".$db_prefix."_users WHERE active = 1 AND ban ='0' ORDER BY id DESC LIMIT 5") or die(mysql_error());
	
	while ($newestmemberrecord = mysql_fetch_array($newestmemberquery) ) {
        $newestmemberrecords[] = $newestmemberrecord;
    }
    $OUTPUT = serialize($newestmemberrecords);
    $fp = fopen($file,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
} // end else 
$new_users = array();
if ($newestmemberrecords == ""){
if($on_index)	echo "No new members";
if(!$on_index){
	$template->assign_vars(array(
	'IS_NEW_USERS' => false,
	));
	}
}else{
if(!$on_index){
	$template->assign_vars(array(
	'IS_NEW_USERS' => true,
	));
	}
if($on_index)echo "<table width=\"100%\" class=\"torrenttable\" border=\"0\" cellpadding=\"3\" ><tr>";
    foreach ($newestmemberrecords as $id=>$row) { 
if($on_index)        echo "<td padding=\"0\">\n<center>";
if($on_index)       echo gen_avatar($row['id']);
if($on_index)       echo "<br />";
if($on_index)        echo "<a href='user.php?op=profile&id=".$row['id']."'><font color=\"".getusercolor($row["can_do"])."\">".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."</font></a>\n</center></td>\n";
if(!$on_index){
$new_users[] = array_push($new_users,array(
'AVATAR' => gen_avatar($row['id']),
'NAME' => ($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]),
'UID' => $row['id'],
'COLOR' => getusercolor($row["can_do"]),
));
}

    }
if($on_index)echo "</tr></table>\n";
}

if($on_index)CloseTable();
?>