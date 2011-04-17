<?php
include("header.php");
function ago($seconds){
$day=date("j",$seconds)-1;
$month=date("n",$seconds)-1;
$year=date("Y",$seconds)-1970;
$hour=date("G",$seconds)-1;
$minute=(int) date("i",$seconds);
$returnvalue=false;
if($year){
if($year==1) $return[]="1 year"; else $return[]="$year years";
}
if($month){
if($month==1) $return[]="1 month"; else $return[]="$month months";
}
if($day){
if($day==1) $return[]="1 day"; else $return[]="$day days";
}
if($hour){
if($hour==1) $return[]="1 hour"; else $return[]="$hour hours";
}
if($minute&&$minute!=00){
if($minute==1){
$return[]="1 minute";
}else{
$return[]="$minute minutes";
}
}
for($i=0;$i<count($return);$i++){
if(!$returnvalue){
$returnvalue=$return[$i];
}elseif($i<count($return)-1){
$returnvalue.= ", ".$return[$i];
}else{
$returnvalue.= " and ".$return[$i];
}
}
return $returnvalue;

}
function getpre($name, $type)
{
$pre['regexp'] = "|<td>(.*)<td>(.*)<td>(.*)</table>|";
$pre['url'] = "http://doopes.com/?cat=454647&lang=0&num=2&mode=0&from=&to=&exc=&inc=" . $name . "&opt=0";
$pre['file'] = @file_get_contents($pre['url']);
preg_match($pre['regexp'], $pre['file'], $pre['matches']);
/**
* Types:
* 1 = Time
* 2 = Category
* 3 = Realesename
*/
//print_r($pre['matches']);
return $pre['matches'][$type];
}  
echo get_formatted_timediff(sql_timestamp_to_unix_timestamp(getpre('Wanted.2008.SE.2DISCS', 1)));
/* 
SELECT COUNT(`torrent_snatched`.`id`)as `count`,  `torrent_snatched`.`torrent_name` as `tname`, `torrent_snatched`.`userid` as `uid`, `torrent_users`.`username` as name,`torrent_users`.`can_do` as `group` FROM `torrent_snatched` left JOIN `torrent_users` ON `torrent_snatched`.`userid` = `torrent_users`.`id` GROUP BY `uid` ORDER BY `name`
set_time_limit(0);
// collation you want to change:
$convert_from = 'latin1_swedish_ci';
// collation you want to change it to:
$convert_to   = 'utf8_general_ci';
// character set of new collation:
$character_set= 'utf8';
$show_alter_table = true;
$show_alter_field = true;
// DB login information
$username = 'user';
$password = 'pass';
$database = 'table';
$host     = 'localhost';
//mysql_connect($host, $username, $password);
//mysql_select_db($database);
$rs_tables = mysql_query(" SHOW TABLES ") or die(mysql_error());
print '<pre>';
while ($row_tables = mysql_fetch_row($rs_tables)) {
    $table = mysql_real_escape_string($row_tables[0]);
    // Alter table collation
    // ALTER TABLE `account` DEFAULT CHARACTER SET utf8
	echo  "\r\n\r\n\r\n";
    if ($show_alter_table) {
        echo("CREATE TABLE `".str_replace("torrent","#prefix#",$table)."` (\r\n");
    }
 
    $rs = mysql_query(" SHOW FULL FIELDS FROM `$table` ") or die(mysql_error());
    while ($row=mysql_fetch_assoc($rs)) {
        
        //if ($row['Collation']!=$convert_from)
          //  continue;
 
        // Is the field allowed to be null?
        if ($row['Null']=='YES') {
            $nullable = ' NULL';
        } else {
            $nullable = ' NOT NULL';
        }
 
        // Does the field default to null, a string, or nothing?
        if ($row['Default']==NULL) {
		if($row['Extra'] == "auto_increment")$default = " auto_increment";
		else
            $default = " DEFAULT NULL";
        } else if ($row['Default']!='') {
            $default = " DEFAULT '".mysql_real_escape_string($row['Default'])."'";
        } else {
            $default = '';
        }
 
        // Alter field collation:
        // ALTER TABLE `account` CHANGE `email` `email` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
        if ($show_alter_field) {
            $field = mysql_real_escape_string($row['Field']);
            echo "`$field` $row[Type]$nullable$default, \r\n";
        }
    }
	echo ") ENGINE=MyISAM ;";
}
/*
error codes 
1054 = Unknown column
1146 = Table 'table' doesn't exist
*/
/*
OpenTable('database');
  $tablename = $_GET["tbname"];
  
    if(!$tablename == ""){
        $cmd = "SELECT * FROM $tablename";
    }
    
    
    
	echo "<BR><center><B><a href=test.php?act=database>Backup / Optimise Database</b></center><BR><BR>";
    echo "<i>WARNING: This area is for <u>advanced users only</u>! Do not send commands of which you do not know the meaning!<br><br>This is for performing manual database tasks.<br>Visit <a href=http://dev.mysql.com/doc/>http://dev.mysql.com/doc/</a> for syntax documentation.</i>";
    echo "<br><hr>";
    print("<form action='test.php' method='post'>\n");
    print("<input type=hidden name='act' value='databaseadmin'>\n");
    print("<input type=hidden name='do' value='submitquery'>\n");
    print("<input type=hidden name='userid' value='$id'>\n");
    print("<table class=main border=1 align=center cellspacing=0 cellpadding=5>\n");
    print("<tr><td>MySQL Command:</td><td align=left><textarea cols=40 rows=6 name=cmd>$cmd</textarea></td></tr>\n");
    print("<tr><td colspan=2 align=center><input type=submit class=btn value='Run'></td></tr>\n");
    print("</table>\n");
    print("</form>\n");
    
    if($do == "submitquery"){
        $validatecmd = mysql_query($cmd);
        echo "<br><br>";
        
        if ($validatecmd){
            echo "<font color=green><b>Execution of MySQL Query successful!</b></font>";
        }else{
            echo "<font color=red><b>" . mysql_error() . "</b></font>";
        }
        echo "<br><br><a href=test.php?act=databaseadmin>Show Database Tables</a>";
    }
    elseif($do == "listfields"){
        echo "<br><br><a href=test.php?act=databaseadmin>Show Database Tables</a><br><br>";
        echo "<table align=center cellpadding=0 cellspacing=0 style=border-collapse: collapse bordercolor=#D6D9DB width=100% border=1>";
        echo "<tr><td class=alt3 align=center><font size=1 face=Verdana color=white>Fields in table \"<b>".$tbname."</b>\"</td></tr></table>";
        echo "<table align=center cellpadding=0 cellspacing=0 style=border-collapse: collapse bordercolor=#D6D9DB width=100% border=1>";
        echo "<tr><td class=alt3 align=center><font size=1 face=Verdana color=white>Name</td><td class=alt3 align=center><font size=1 face=Verdana color=white>Type</td><td class=alt3 align=center><font size=1 face=Verdana color=white>Flags</td></tr>";
        $reslistfields2 = mysql_query ('SHOW FULL FIELDS FROM ' . $tbname);
		$de = mysql_fetch_array($reslistfields2);
		foreach ($de as $key => $value)
		{
		echo "this $key is this $value<br>";
		}
        
        $reslistfields = mysql_query ("SELECT * FROM " . $tbname);
        $numfields = mysql_num_fields ($reslistfields);
        $rows   = mysql_num_rows ($reslistfields);
        $fieldcounter = 0;
        //$table = mysql_field_table ($reslistfields, $i);
        while ($fieldcounter < $numfields) {
            $type  = mysql_field_type  ($reslistfields, $fieldcounter);
            $name  = mysql_field_name  ($reslistfields, $fieldcounter);
            $flags = mysql_field_flags ($reslistfields, $fieldcounter);
            $nameco = mysql_field_len ($reslistfields, $fieldcounter);
            
            if(!$flags){
                $flags = "<i>none</i>";
            }
			if($nameco)$nameco = "(".$nameco.")";
			else
			$nameco = '';
        echo "<tr><td>".$name."</td><td>".$type.$nameco."</td><td>".$flags."</td></tr>";
        //echo $type." ".$name." ".$len." ".$flags."<BR>";
        $fieldcounter++;
        }
    
        echo "</table>";
    }else{
        
    //-----TABLE DISPLAY
    echo "<table align=center cellpadding=0 cellspacing=0 style=border-collapse: collapse bordercolor=#D6D9DB width=100% border=1>";
    echo "<tr><td class=alt3 align=center><font size=1 face=Verdana color=white>Table Names in database \"<b>".$mysql_db."</b>\"</td></tr>";
    $result = mysql_list_tables ('phpmybittorrent');
    $dbtablerowcounter = 0;
    
    while ($dbtablerowcounter < mysql_num_rows ($result)) {
    $tb_names[$dbtablerowcounter] = mysql_tablename ($result, $dbtablerowcounter);
    echo "<tr><td><a href=test.php?act=databaseadmin&do=listfields&tbname=" . $tb_names[$dbtablerowcounter] .">" . $tb_names[$dbtablerowcounter] . "</a></td></tr>";
    $dbtablerowcounter++;
    }
    echo "</table>";
    //----END TABLE DISPLAY
    }
    
CloseTable();
$newtableaddedrequests = "CREATE TABLE `#prefix#_addedrequests` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `requestid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM ;";
$newrowaddedrequests = explode("(,)","  `id` int(10) unsigned NOT NULL auto_increment(,)
  `requestid` int(10) unsigned NOT NULL default '0'(,)
  `userid` int(10) unsigned NOT NULL default '0'(,)
");
foreach ($newrowaddedrequests as $key => $value){
preg_match('/\\`.*\\`/',$value,$m);
$newrowsetaddedrequests[str_replace("`","",$m[0])] = $value;
}

$newtablehit_n_run = "CREATE TABLE `#prefix#_hit_n_run` (
  `hnr_system` enum('true','false') NOT NULL default 'false',
  `seedtime` int(10) NOT NULL default '0',
  `time_before_warn` int(10) NOT NULL default '0',
  `maxhitrun` int(10) NOT NULL default '0',
  `warnlength` int(10) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$newrowhit_n_run = explode("(,)","`hnr_system` enum('true','false') NOT NULL default 'false'(,)
  `seedtime` int(10) NOT NULL default '0'(,)
  `time_before_warn` int(10) NOT NULL default '0'(,)
  `maxhitrun` int(10) NOT NULL default '0'(,)
  `warnlength` int(10) NOT NULL default '0'(,)
  ");
foreach ($newrowhit_n_run as $key => $value){
preg_match('/\\`.*\\`/',$value,$m);
$newrowsethit_n_run[str_replace("`","",$m[0])] = $value;
}
$newtableadmin_forum = "CREATE TABLE `#prefix#_admin_forum` (
  `prefix` varchar(60) NOT NULL default '',
  `cookie_name` varchar(60) NOT NULL default '',
  `cookie_domain` varchar(60) NOT NULL default '',
  `cookie_path` varchar(60) NOT NULL default '',
  `cookie_time` varchar(60) NOT NULL default '0',
  `base_folder` varchar(60) NOT NULL default '',
  `forum_share` enum('true','false') NOT NULL default 'true',
  `auto_post` enum('true','false') NOT NULL default 'false',
  `auto_post_forum` varchar(60) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$newrowadmin_forum = explode("(,)","`prefix` varchar(60) NOT NULL default ''(,)
  `cookie_name` varchar(60) NOT NULL default ''(,)
  `cookie_domain` varchar(60) NOT NULL default ''(,)
  `cookie_path` varchar(60) NOT NULL default ''(,)
  `cookie_time` varchar(60) NOT NULL default '0'(,)
  `base_folder` varchar(60) NOT NULL default ''(,)
  `forum_share` enum('true','false') NOT NULL default 'true'(,)
  `auto_post` enum('true','false') NOT NULL default 'false'(,)
  `auto_post_forum` varchar(60) NOT NULL default '0'(,)");
foreach ($newrowadmin_forum as $key => $value){
preg_match('/\\`.*\\`/',$value,$m);
$newrowsetadmin_forum[str_replace("`","",$m[0])] = $value;
}
$newrow = explode("(,)","  `id` int(11) NOT NULL auto_increment(,)
  `username` varchar(25) character set utf8 collate utf8_bin NOT NULL default ''(,)
  `clean_username` varchar(25) character set utf8 collate utf8_bin NOT NULL default ''(,)
  `name` varchar(50) default NULL(,)
  `email` varchar(255) character set utf8 collate utf8_bin NOT NULL default ''(,)
  `regdate` datetime NOT NULL default '0000-00-00 00:00:00'(,)
  `password` varchar(40) NOT NULL default ''(,)
  `theme` varchar(255) default NULL(,)
  `language` varchar(15) default NULL(,)
  `avatar` varchar(255) NOT NULL default 'blank.gif'(,)
  `accept_mail` enum('yes','no') NOT NULL default 'no'(,)
  `pm_notify` enum('true','false') NOT NULL default 'true'(,)
  `aim` varchar(255) default NULL(,)
  `icq` varchar(10) default NULL,
  `jabber` varchar(255) default NULL(,)
  `msn` varchar(255) default NULL(,)
  `skype` varchar(255) default NULL(,)
  `yahoo` varchar(255) default NULL(,)
  `level` enum('user','premium','moderator','admin') NOT NULL default 'user'(,)
  `can_do` varchar(225) character set utf8 collate utf8_bin NOT NULL default 'user'(,)
  `uploaded` bigint(32) unsigned NOT NULL default '0'(,)
  `downloaded` bigint(32) unsigned NOT NULL default '0'(,)
  `active` tinyint(1) default '0'(,)
  `ban` int(1) unsigned NOT NULL default '0'(,)
  `act_key` varchar(32) default NULL(,)
  `passkey` varchar(32) default NULL(,)
  `newpasswd` varchar(40) default NULL(,)
  `banreason` varchar(255) default NULL(,)
  `lastip` int(10) unsigned NOT NULL default '0'(,)
  `lasthost` varchar(255) NOT NULL default ''(,)
  `lastlogin` datetime NOT NULL default '0000-00-00 00:00:00'(,)
  `rem` enum('yes','no') NOT NULL default 'no'(,)
  `modcomment` longtext character set utf8 collate utf8_bin NULL(,)
  `warned` int(1) unsigned NOT NULL default '0'(,)
  `warn_kapta` int(11) NOT NULL default '0'(,)
  `warn_hossz` int(11) NOT NULL default '0'(,)
  `invited_by` int(10) NOT NULL default '0'(,)
  `invitees` varchar(100) NOT NULL default ''(,)
  `country` int(10) NOT NULL default '0'(,)
  `seedbox` int(10) unsigned NOT NULL default '0'(,)
  `tzoffset` smallint(4) NOT NULL default '0'(,)
  `can_shout` enum('true','false') character set utf8 collate utf8_bin NOT NULL default 'true'(,)
  `Show_online` enum('true','false') character set utf8 collate utf8_bin NOT NULL default 'true'(,)
  `invites` smallint(5) NOT NULL default '0'(,)
  `invitedate` datetime NOT NULL default '0000-00-00 00:00:00'(,)
  `seedbonus` decimal(10,1) NOT NULL default '0.0'(,)
  `donator` enum('true','false') NOT NULL default 'false'(,)
  `donated` decimal(10,1) unsigned NOT NULL default '0.0'(,)
  `dondate` datetime NOT NULL default '0000-00-00 00:00:00'(,)
  `torrent_per_page` int(10) default NULL(,)
  `donator_tell` datetime NOT NULL default '0000-00-00 00:00:00'(,)
  `dongift` int(1) unsigned NOT NULL default '0'(,)
  `inactwarning` tinyint(1) NOT NULL default '0'(,)
  `inactive_warn_time` datetime NOT NULL default '0000-00-00 00:00:00'(,)
  `hitruns` tinyint(3) unsigned NOT NULL default '0'(,)
  `hitrun` datetime NOT NULL default '0000-00-00 00:00:00'(,)
  `HNR_W` int(11) NOT NULL default '0'(,)
  `helper` enum('true','false') character set utf8 collate utf8_bin NOT NULL default 'false'(,)
  `help_able` varchar(225) character set utf8 collate utf8_bin NULL(,)
");
$newrowset = array();
foreach ($newrow as $key => $value){
preg_match('/\\`.*\\`/',$value,$m);
$newrowsetuser[str_replace("`","",$m[0])] = $value;
}
$newtableuser = "CREATE TABLE `torrent_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(25) character set utf8 collate utf8_bin NOT NULL default '',
  `clean_username` varchar(25) character set utf8 collate utf8_bin NOT NULL default '',
  `name` varchar(50) default NULL,
  `email` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `regdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `password` varchar(40) NOT NULL default '',
  `theme` varchar(255) default NULL,
  `language` varchar(15) default NULL,
  `avatar` varchar(255) NOT NULL default 'blank.gif',
  `accept_mail` enum('yes','no') NOT NULL default 'no',
  `pm_notify` enum('true','false') NOT NULL default 'true',
  `aim` varchar(255) default NULL,
  `icq` varchar(10) default NULL,
  `jabber` varchar(255) default NULL,
  `msn` varchar(255) default NULL,
  `skype` varchar(255) default NULL,
  `yahoo` varchar(255) default NULL,
  `level` enum('user','premium','moderator','admin') NOT NULL default 'user',
  `can_do` varchar(225) character set utf8 collate utf8_bin NOT NULL default 'user',
  `uploaded` bigint(32) unsigned NOT NULL default '0',
  `downloaded` bigint(32) unsigned NOT NULL default '0',
  `active` tinyint(1) default '0',
  `ban` int(1) unsigned NOT NULL default '0',
  `act_key` varchar(32) default NULL,
  `passkey` varchar(32) default NULL,
  `newpasswd` varchar(40) default NULL,
  `banreason` varchar(255) default NULL,
  `lastip` int(10) unsigned NOT NULL default '0',
  `lasthost` varchar(255) NOT NULL default '',
  `lastlogin` datetime NOT NULL default '0000-00-00 00:00:00',
  `rem` enum('yes','no') NOT NULL default 'no',
  `modcomment` longtext character set utf8 collate utf8_bin NULL,
  `warned` int(1) unsigned NOT NULL default '0',
  `warn_kapta` int(11) NOT NULL default '0',
  `warn_hossz` int(11) NOT NULL default '0',
  `invited_by` int(10) NOT NULL default '0',
  `invitees` varchar(100) NOT NULL default '',
  `country` int(10) NOT NULL default '0',
  `seedbox` int(10) unsigned NOT NULL default '0',
  `tzoffset` smallint(4) NOT NULL default '0',
  `can_shout` enum('true','false') character set utf8 collate utf8_bin NOT NULL default 'true',
  `Show_online` enum('true','false') character set utf8 collate utf8_bin NOT NULL default 'true',
  `invites` smallint(5) NOT NULL default '0',
  `invitedate` datetime NOT NULL default '0000-00-00 00:00:00',
  `seedbonus` decimal(10,1) NOT NULL default '0.0',
  `donator` enum('true','false') NOT NULL default 'false',
  `donated` decimal(10,1) unsigned NOT NULL default '0.0',
  `dondate` datetime NOT NULL default '0000-00-00 00:00:00',
  `torrent_per_page` int(10) default NULL,
  `donator_tell` datetime NOT NULL default '0000-00-00 00:00:00',
  `dongift` int(1) unsigned NOT NULL default '0',
  `inactwarning` tinyint(1) NOT NULL default '0',
  `inactive_warn_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `hitruns` tinyint(3) unsigned NOT NULL default '0',
  `hitrun` datetime NOT NULL default '0000-00-00 00:00:00',
  `HNR_W` int(11) NOT NULL default '0',
  `helper` enum('true','false') character set utf8 collate utf8_bin NOT NULL default 'false',
  `help_able` varchar(225) character set utf8 collate utf8_bin NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `passkey` (`passkey`),
  KEY `lastip` (`lastip`),
  KEY `lasthost` (`lasthost`),
  KEY `date` (`regdate`)
) ENGINE=MyISAM ;";

$db->sql_query("SELECT * FROM `torrent_users`");
        $err = Array();
        $err = $db->sql_error();
		if($err["code"] == 0){
		foreach ($newrowsetuser as $key => $value){
		if($key == '' )continue;
		$db->sql_query("SELECT ".$key."1 FROM `torrent_users`");
		if($key =='Show_online')$$key = $key;
        $err2 = Array();
        $err2 = $db->sql_error();
echo $err2["code"]."<br>";
echo $err2["message"]."<br>";
echo "SELECT ".$key." FROM `torrent_users`<br>";
		}
echo $err["code"]."<br>";
echo $err["message"];
}*/
include("footer.php");
?>