<?php
/*
*----------------------------phpMyBitTorrent V 2.0.5---------------------------*
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
include("header.php");
include("include/forum_config.php");
if (!checkaccess("modforum"))
{
OpenErrTable(_btaccdenied);
echo _btnoautherized_noedit;
CloseErrTable();
die();
}
if(isset($do) && $do == "saveboard_settings")
{
        $errors = array();
        $sqlfields = array();
        $sqlvalues = array();
		       if(isset($config['forum_open'])){
			   $sqlfields[] = (($config['forum_open'] == 0)? "false" : "true");
			   $sqlvalues[] = "forum_open";
			   }
			   else
			   $errors[] = "1";

		       if($config['board_disable_msg']){
			   $sqlfields[] = $db->sql_escape(stripslashes($config['board_disable_msg']));
			   $sqlvalues[] = "board_disable_msg";
			   }
			   else
			   {
			   $sqlfields[] = '';
			   $sqlvalues[] = "board_disable_msg";
			   }
			   
		       if(isset($config['censor_words'])){
			   $sqlfields[] = (($config['censor_words'] == 0)? "false" : "true");
			   $sqlvalues[] = "censor_words";
			   }
			   else
			   $errors[] = "2";
			   
		       if(isset($config['postsper_page'])){
			   if(is_numeric($config['postsper_page'])){
			   $sqlfields[] = $config['postsper_page'];
			   $sqlvalues[] = "postsper_page";
			   }
			   else
			   $errors[] = "Posts Perpage not Numeric";
			   }
			   else
			   $errors[] = "3";
			   
		       if(isset($config['topics_per_page'])){
			   if(is_numeric($config['topics_per_page'])){
			   $sqlfields[] = $config['topics_per_page'];
			   $sqlvalues[] = "topics_per_page";
			   }
			   else
			   $errors[] = "Topics Perpage not Numeric";
			   }
			   else
			   $errors[] = "4";
		       if(isset($config['max_subject_length'])){
			   if(is_numeric($config['max_subject_length'])){
			   $sqlfields[] = $config['max_subject_length'];
			   $sqlvalues[] = "max_subject_length";
			   }
			   else
			   $errors[] = "Max Subject Length not Numeric";
			   }
			   else
			   $errors[] = "5";
		       if(isset($config['max_post_length'])){
			   if(is_numeric($config['max_post_length'])){
			   $sqlfields[] = $config['max_post_length'];
			   $sqlvalues[] = "max_post_length";
			   }
			   else
			   $errors[] = "Max Post Length not Numeric";
			   }
			   else
			   $errors[] = "6";
		       if(isset($config['show_latest_topic'])){
			   $sqlfields[] = (($config['show_latest_topic'] == 0)? "false" : "true");
			   $sqlvalues[] = "show_latest_topic";
			   }
			   else
			   $errors[] = "7";
		       if(isset($config['search_word_min'])){
			   if(is_numeric($config['search_word_min'])){
			   $sqlfields[] = $config['search_word_min'];
			   $sqlvalues[] = "search_word_min";
			   }
			   else
			   $errors[] = "Search Word Minumum not Numeric";
			   }
			   else
			   $errors[] = "8";
		       if(isset($config['allow_bookmarks'])){
			   $sqlfields[] = (($config['allow_bookmarks'] == 0)? "false" : "true");
			   $sqlvalues[] = "allow_bookmarks";
			   }
			   else
			   $errors[] = "9";
		       if(isset($config['shout_new_topic'])){
			   $sqlfields[] = (($config['shout_new_topic'] == 0)? "false" : "true");
			   $sqlvalues[] = "shout_new_topic";
			   }
			   else
			   $errors[] = "10";
		       if(isset($config['shout_new_post'])){
			   $sqlfields[] = (($config['shout_new_post'] == 0)? "false" : "true");
			   $sqlvalues[] = "shout_new_post";
			   }
			   else
			   $errors[] = "11";
        if (count($errors) > 0)
		{
		bterror($errors,"Board settings not saved");
		die();
		}
        $sql = "INSERT INTO ".$db_prefix."_forum_config (".implode(", ",$sqlvalues).") VALUES ('".implode("', '",$sqlfields)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_forum_config;");
        $db->sql_query($sql);
		$pmbt_cache->remove_file("sql_".md5("forum_config").".php");
        header("Location: admin-forums.php?saved=1");
        die();
}
function get_groups()
{
        global $db, $db_prefix;
            $sql = "SELECT level as level, name as name FROM ".$db_prefix."_levels;";
            $res = $db->sql_query($sql) or btsqlerror($sql);
            return $res;
}
if (isset($saved)) {
        OpenTable2();
        echo "<h3>Saved Settings</h3>";
        CloseTable2();
}
OpenTable("Edit Forums");

echo"<BR><BR><center><a href=admin.php>RETURN TO STAFF CP</a></center>";
echo"<BR><center><a href=forums.php>RETURN Forum</a></center><BR><BR>";
//edit forumcats
if($do == "del_forumcat")
{
$t = $db->sql_query("SELECT * FROM ".$db_prefix."_forumcats WHERE id = '$id'");
$v = $db->sql_fetchrow($t);

  echo"<form action=\"admin-forums.php\" method=\"post\">";
  echo"<input type=\"hidden\" name=\"do\" value=\"delete_forumcat\">";
  echo"<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
      echo"Really delete the Forum category  <b>". $v['name']." with ID " . $v['id'] . " ???</b> All Sub Forums will now be invisible";
      echo"<input type=\"submit\" name=\"delcat\" class=\"button\" value=\"Delete\">";
     echo" </form>";

}
if($do == "add_this_forumcat")
//add to db & create autolink
{
$error_ac == "";
if($new_forumcat_name == "") $error_ac .= "<li>Forum cat name was empty\n";
if($new_forumcat_sort == "") $error_ac .= "<li>Forum cat sort order was empty\n";

if($error_ac == "")
{
  $sql = "INSERT INTO ".$db_prefix."_forumcats (`name`, `sort`) VALUES ('$new_forumcat_name', '$new_forumcat_sort')";
  $ok = $db->sql_query($sql);
  if($ok) {
  echo("Forum added <a href='admin-forums.php'><strong>back</strong></a>");
  die();
  }
  else echo "<h4>Could not save to DB - check your connection & settings!</h4>";
}
}
if($do == "delete_forumcat")
{
if($delcat != "")
{
  $sql2 = "DELETE FROM ".$db_prefix."_forumcats WHERE id = '$id'";
        $ok2 = $db->sql_query($sql2);
  if($ok2) ;
}
}
if($do == "edit_forumcat")
{
$q = $db->sql_query("SELECT * FROM ".$db_prefix."_forumcats WHERE id = '$id'");
$r = $db->sql_fetchrow($q);
      echo"<table align='center' width='80%' bgcolor='#cecece' cellspacing='2' cellpadding='2' style='border: 1px solid black'>";
  echo"<form action=\"admin-forums.php\" method=\"post\">";
  echo"<input type=\"hidden\" name=\"do\" value=\"save_editcat\">";
  echo"<input type=\"hidden\" name=\"id\" value=\"". $id . "\">";
      echo"<tr><td>New Name for Category:</td></tr>";
      echo"<tr><td><input type=\"text\" name=\"changed_forumcat\" class=\"option\" size=\"35\" value=\"" . $r['name'] . "\"></td></tr>";
      echo"<tr><td>New Sort Order:</td></tr>";
      echo"<tr><td><input type=\"text\" name=\"changed_sortcat\" class=\"option\" size=\"35\" value=\"" . $r['sort'] . "\"></td></tr>";
      echo"<tr><td><input type=\"submit\" class=\"button\" value=\"Change\"></td></tr>";
      echo"</form>";
      echo"</table>";
}
//save edited data cat
if($do == "save_editcat")
{
        $db->sql_query("UPDATE ".$db_prefix."_forumcats SET sort = '$changed_sortcat', name = '$changed_forumcat' WHERE id='$id'");
echo "<br><br><center><b>Updated Completed</b></center>";

}

//Delete Forums
if($_GET['action'] == 'delforum'){
    $delid = $_GET['forumid'];
    $name = $_GET['forumname'];
    $sure = $_GET['sure'];
    if($sure == 'yes') {
        $query = "DELETE FROM ".$db_prefix."_forum_forums WHERE id = " .$delid . " LIMIT 1";
        $sql= $db->sql_query($query);
        echo("Forum, '$name' has been succesfully deleted! [ <a href='admin-forums.php'>Back to Edit</a> ]");
        CloseTable();
        die();
    }else{
        if($delid >= 0) {
            echo("Are you sure you want to delete forum '$name'?
            ( <strong><a href='admin-forums.php?action=delforum&forumid=$delid&forumname=$name&sure=yes'>Y</a></strong>
            / <strong><a href='admin-forums.php'>N</a></strong> )");
            }
    }
    CloseTable();
    die();
}

//Add new forum

if($_GET['action'] == 'add') {
$sql = "SELECT `id` as id, `name` as name FROM `".$db_prefix."_forumcats`";
$arr = $db->sql_query($sql);
$catts = array();
while ($res = $db->sql_fetchrow($arr)) {
$catts[] = $res;
}
$sql = "SELECT `level` FROM `".$db_prefix."_levels` WHERE `modforum` = 'true'";
$arr = $db->sql_query($sql)or mysql_error();
$modscs = array();
while ($res = $db->sql_fetchrow($arr)) {
$modscs[] = $res['level'];
}
$sql = "SELECT `id`, `username` FROM `".$db_prefix."_users` WHERE `can_do` IN ('".implode("','",$modscs)."')";
$arr = $db->sql_query($sql)or mysql_error();
$mods = array();
while ($res = $db->sql_fetchrow($arr)) {
$mods[] = $res;
}
    echo("<a href='admin-forums.php'><strong>Back</strong></a>");
    echo("<br><form name='add' method='get' action='admin-forums.php'>");
    echo("<input type='hidden' name='action' value='takeadd'>");
    echo("<table cellspacing=0 cellpadding=5 width=100%>");
    echo("<tr><td>Name: </td><td align='left'><input type='text' size=50 name='name'></td></tr>");
    echo("<tr><td>Description: </td><td align='left'><input type='text' size=50 name='desc'></td></tr>");
    echo("<tr><td>Sort: </td><td align='left'><input type='text' size=50 name='sort'></td></tr>");
    echo("<tr><td>Show Sub Topics In Forum List: </td><td align='left'><input name=\"show_topic\" value=\"1\" type=\"checkbox\"></td></tr>");
    echo("<tr><td>Category: </td><td align='left'>");
        echo"<select id=\"table\" name=\"category\">";
    foreach($catts as $val){
    echo "<option value=\"".$val['id']."\">".$val['name']."</option>";
    }
    echo"</select>";

    //echo("<input type='text' size=50 name='category'></td></tr>");
    echo("<tr><td>Viewable By: </td>");
    echo "<td>";
    $res = get_groups();
    $i =0;
while ($group = $db->sql_fetchrow($res)) {
$i++;
echo "<input name=\"viewby[]\" value=\"".$group['level']."\" type=\"checkbox\"> ".$group['name']." ";
if($i == 4)
{
echo "<br />";
$i = 0;
}
}
        //$db->sql_freeresult($res);
        echo "</td></tr>";
    echo("</td></tr>\n");
    echo("<tr><td>Able to post: </td><td>");
    $i =0;
        $res = get_groups();
while ($group = $db->sql_fetchrow($res)) {
$i++;
echo "<input name=\"apost[]\" value=\"".$group['level']."\" type=\"checkbox\"> ".$group['name']." ";
if($i == 4)
{
echo "<br />";
$i = 0;
}
}
    echo("</td></tr>\n");
    echo("<tr><td>Moderators: </td><td align=left>");
        echo"<select id=\"table\" name=\"moder[]\"  multiple=\"multiple\">";
    foreach($mods as $val){
    echo "<option value=\"".$val['id']."\">".$val['username']."</option>";
    }
    echo"</select>";
    echo("</td></tr>\n");

    echo("<tr><td colspan=2><div align='left'><input type='Submit'></div></td></tr></table>");
}

if($_GET['action'] == 'takeadd') {
    $viewby = implode("  ", $viewby);
    $apost = implode("  ", $apost);
    if(isset($show_topic) && $show_topic == 1)
    $show_topic = ", show_topic = '".$show_topic."'";
    else
    $show_topic = '';
    //echo $sort.", ".$name.", ".$desc.", ".$moder;
    if(!is_numeric($category) || !isset($name) || !isset($desc) || !isset($moder)) {
        echo("Please fill in all required fields <a href='admin-forums.php?action=add'><strong>back</strong></a>");
        CloseTable();
        die();
    }
    $query = "SELECT sort FROM ".$db_prefix."_forum_forums WHERE sort = " . $sort . " AND category = " . $category . "";
    $loc = $db->sql_query($query);
    if($db->sql_numrows($loc) > '0')    {
        echo("That sort number ($sort) already exists for Category ($category)! <a href='admin-forums.php?action=add'><strong>back</strong></a>");
    }else{
        $query = "INSERT INTO ".$db_prefix."_forum_forums SET
        sort = '$sort',
        name = '$name',
        description = '$desc',
        minclasswrite = '$viewby',
        minclassread = '$apost',
        category = '$category',
        moderator = '".implode(" ",$moder)."'"
        .$show_topic;
        $db->sql_query($query) OR btsqlerror($query);
        echo("Forum added <a href='admin-forums.php'><strong>back</strong></a>");
    }
    CloseTable();
    die();
}

// Edit forum

if($action == 'editforum') {
$edid = $_GET['forumid'];
$query = "SELECT * FROM ".$db_prefix."_forum_forums WHERE id = $edid";
$loc = $db->sql_query($query);
$row = $db->sql_fetchrow($loc);
$sql = "SELECT `id` as id, `name` as name FROM `".$db_prefix."_forumcats`";
$arr = $db->sql_query($sql);
$catts = array();
while ($res = $db->sql_fetchrow($arr)) {
$catts[] = $res;
}
$sql = "SELECT `level` FROM `".$db_prefix."_levels` WHERE `modforum` = 'true'";
$arr = $db->sql_query($sql)or mysql_error();
$modscs = array();
while ($res = $db->sql_fetchrow($arr)) {
$modscs[] = $res['level'];
}
$sql = "SELECT `id`, `username` FROM `".$db_prefix."_users` WHERE `can_do` IN ('".implode("','",$modscs)."')";
$arr = $db->sql_query($sql)or mysql_error();
$mods = array();
while ($res = $db->sql_fetchrow($arr)) {
$mods[] = $res;
}

echo("<a href='admin-forums.php'><strong>Back</strong></a>");
echo("<br><form name='add' method='get' action='admin-forums.php'>");
echo("<input type='hidden' name='action' value='takeedit'>");
echo("<input type='hidden' name='forumid' value='$edid'>");
echo("<table cellspacing=0 cellpadding=5 width=50%>");
echo("<tr><td>Name: </td><td align='center'><input type='text' value='".$row['name']."' size=50 name='name'></td></tr>");
echo("<tr><td>Description: </td><td align='center'><input type='text' value='".$row['description']."' size=50 name='desc'></td></tr>");
echo("<tr><td>Sort: </td><td align='center'><input type='text' value='".$row['sort']."' size=50 name='sort'></td></tr>");
    echo("<tr><td>Show Sub Topics In Forum List: </td><td align='left'><input name=\"show_topic\" value=\"1\" type=\"checkbox\" ".(($row['show_topic'] == 1)? 'checked' : '' )."></td></tr>");
echo("<tr><td>Category: </td><td align='center'>");
        echo"<select id=\"table\" name=\"category\">";
    foreach($catts as $val){
    echo "<option value=\"".$val['id']."\"".((in_array($val['id'] ,explode(" ",$row['category'])))? ' selected '  : '').">".$val['name']."</option>";
    }
    echo"</select>";//<input type='text' value='".$row['category']."' size=50 name='category'></td></tr>");
echo("<tr><td>Viewable by:</td><td>\n");
    $res = get_groups();
    $sread = explode("  ", $row["minclassread"]);
    $i =0;
while ($group = $db->sql_fetchrow($res)) {
$i++;
echo "<input name=\"newread[]\" value=\"".$group['level']."\" type=\"checkbox\" ".(in_array($group['level'],$sread) ? "checked" : "")."> ".$group['name']." ";
if($i == 4)
{
echo "<br />";
$i = 0;
}
}
echo("</td></tr>");
echo("<tr><td>Able to post:</td><td>\n");
    $res = get_groups();
    $swrite = explode("  ", $row["minclasswrite"]);
    $i =0;
while ($group = $db->sql_fetchrow($res)) {
$i++;
echo "<input name=\"newwrite[]\" value=\"".$group['level']."\" type=\"checkbox\" ".(in_array($group['level'],$swrite) ? "checked" : "")."> ".$group['name']." ";
if($i == 4)
{
echo "<br />";
$i = 0;
}
}
echo("</td></tr>");
    echo("<tr><td>Moderators: </td><td align=center>");
        echo"<select id=\"table\" name=\"moder[]\"  multiple=\"multiple\">";
    foreach($mods as $val){
    echo "<option value=\"".$val['id']."\"".((in_array($val['id'] ,explode(" ",$row['moderator'])))? ' selected '  : '').">".$val['username']."</option>";
    }
    echo"</select>";//<input type='text' size=50 name='moder' value=\"".$row["moderator"]."\">");
    echo("</td></tr>\n");
echo("<tr><td colspan=2><div align='center'><input type='Submit'></div></td></tr></table>");
}

if($action == 'takeedit') {
    $id = $forumid;
    $newshow_topic = $show_topic;
    $newname = $name;
    $newdesc = $desc;
    $newsort = $sort;
    $newcategory = $category;
    $newread = implode("  ",$newread);
    $newwrite = implode("  ", $newwrite);
    $query = "SELECT * FROM ".$db_prefix."_forum_forums WHERE id = $id";
    $loc = $db->sql_query($query)or sqlerr(__FILE__, __LINE__);
    $row = $db->sql_fetchrow($loc);
    $query2 = "SELECT sort FROM ".$db_prefix."_forum_forums WHERE id = $id";
    $loc2 = $db->sql_query($query2);
    while($row2 = $db->sql_fetchrow($loc2))
    {
    if($newsort == $row2['sort'] && $row['sort'] !== $newsort)
    {
    $se = 'TRUE';
    }
    }
    if($newname == $row['name'] && $newdesc == $row['description'] && $newread == $row['minclassread']
    && $newwrite == $row['minclasswrite'] && implode(" ",$moder) == $row['moderator'] && $newcategory == $row['category']
    && $newshow_topic == $row['show_topic'])
    echo("No change has been made <a href='admin-forums.php?action=editforum&forumid=$id'><strong>back</strong></a><br>");
    elseif($se == 'TRUE')
    echo("This sort number already exists ($newsort)<a href='admin-forums.php?action=editforum&forumid=$id'><strong>back</strong></a><br>");
    else{
    if($newshow_topic != $row['show_topic'])
    $updateset[] = "show_topic = '".$newshow_topic."'";
    if($newname != $row['name'])
    $updateset[] = "name = '". $newname."'";
    if($newdesc != $row['description'])
    $updateset[] = "description = '". $newdesc."'";
    if($newsort != $row['sort'])
    $updateset[] = "sort = $newsort";
    if($newcategory != $row['category'])
    $updateset[] = "category = $newcategory";
    if($newread != $row['minclassread'])
    $updateset[] = "minclassread = '$newread'";
    if($newwrite != $row['minclasswrite'])
    $updateset[] = "minclasswrite = '$newwrite'";
    if($moder != $row['moderator'])
    $updateset[] = "moderator = '".implode(" ",$moder)."'";

    //echo $updateset[0] . "<br>" . $updateset[1] . "<br>";

    $db->sql_query("UPDATE ".$db_prefix."_forum_forums SET " . implode(", ", $updateset) . " WHERE id=$id") or sqlerr(__FILE__, __LINE__);

    echo("Forum updated! <a href='admin-forums.php'><strong>back</strong></a><br>");
    }
    CloseTable();
    die();
}

// Current Forums

echo("<br><table cellspacing=0 cellpadding=3 border=1>");
echo("<tr>
<td class=colhead>Sort:</td>
<td class=colhead>ID:</td>
<td class=colhead>Category:</td>
<td class=colhead>Name:</td>
<td class=colhead>Description:</td>
<td class=colhead>Viewable By:</td>
<td class=colhead>Able To Post:</td>
<td class=colhead>Edit:</td>
<td class=colhead>Delete:</td>
</tr>");
$query = "SELECT * FROM ".$db_prefix."_forum_forums ORDER BY sort ASC";
$loc = $db->sql_query($query);
while($row = $db->sql_fetchrow($loc))
{
$id = $row['id'];
$sort = $row['sort'];
$category = $row['category'];
$name = $row['name'];
$desc = $row['description'];
$minr = $row['minclassread'];
$minw = $row['minclasswrite'];
echo"<tr>
<td><strong>$sort</strong></td><td><strong>$id</strong></td><td><strong>$category</strong></td><td><a href='forums.php?action=viewforum&forumid=$id'>$name</a></td><td>$desc</td>
<td>".$minr."</td>
<td>".$minw."</td>
<td><div align='center'><a href='admin-forums.php?action=editforum&forumid=$id'>
<img src='$siteurl/themes/".$theme."/pics/edit.gif' border='0' /></a></div></td>
<td><div align='center'><a href='admin-forums.php?action=delforum&forumid=$id&forumname=$name'>
<img src='$siteurl//themes/".$theme."/pics/drop.gif' border='0' /></a></div></td>
</tr>";
}
echo"</table>";
if(!$action)
{
echo"<br><a href=\"admin-forums.php?action=add\">Add new Forum</a><br><br>";
}else{
echo"<br><br>";
}
echo "<BR><table align='center' width='100%' class=colhead cellspacing='2' cellpadding='2' style='border: 1px solid black'>
<h5>Current Forum Categories:</h5>";
// get forum from db
 echo "<tr><td width='60'><font size='2'><b>ID</b></td><td width='120'>NAME</td><td  width='18'>SORT</td><td width='18'>EDIT</td><td width='18'>DEL</td></font>\n";
$query = $db->sql_query("SELECT * FROM ".$db_prefix."_forumcats ORDER BY sort, name");
$allcat = $db->sql_numrows($query);
if($allcat == 0) {
  echo "<h4>None set</h4>\n";
} else {
  while($row =$db->sql_fetchrow($query))
  {
  echo "<tr><td width='60'><font size='2'><b>ID($row[id])</b></td><td width='120'> $row[name]</td><td width='18'>$row[sort]</td>\n";
            echo "<td width='18'><a href='admin-forums.php?do=edit_forumcat&id=$row[id]'><img src='$siteurl/themes/".$theme."/pics/edit.gif' border='0' /></a></td>\n";
            echo "<td width='18'><a href='admin-forums.php?do=del_forumcat&id=$row[id]'><img src='/themes/".$theme."/pics/drop.gif' alt='Delete  Category' width='17' height='17' border='0'></a></td></tr>\n";
  }
//MYSQL_FREE_RESULT($query);
} //endif
echo "</table>\n";

echo "<BR><table align='center' width='100%' class=colhead cellspacing='2' cellpadding='2' style='border: 1px solid black'>";
echo "<form action='admin-forums.php' method='post'>";
echo "<input type='hidden' name='sid' value='".$sid."'>";
echo "<input type='hidden' name='act' value='sql'>";
echo "<input type='hidden' name='do' value='add_this_forumcat'>";
echo "<tr>";
echo "<td>Name of the new Category:</td>";
echo "<td align='right'><input type='text' name='new_forumcat_name' size='30' maxlength='30'  value='".$new_forumcat_name."'></td>";
echo "</tr>";
echo "<tr>";
echo "<td>Category Sort Order:</td>";
echo "<td align='right'><input type='text' name='new_forumcat_sort' size='10' maxlength='10'  value='".$new_forumcat_sort."'></td>";
echo "</tr>";
echo " <tr>";
echo "<td colspan='2' align='center'>";
echo "<input type='submit' value='Add new category'>";
echo "<input type='reset' value='Reset'>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";
CloseTable();
OpenTable("Edit Forum Settings");
$sql = "SELECT * FROM ".$db_prefix."_forum_config LIMIT 1;";
$configquery = $db->sql_query($sql);
$row = $db->sql_fetchrow($configquery);
            echo "<div id=\"main\">\n";
            echo "<form id=\"acp_board\" method=\"post\" action=\"./admin-forums.php\">\n";
			echo "<input type=\"hidden\" name=\"do\" value=\"saveboard_settings\" />\n";
            echo "<fieldset style=\"margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; \">\n";
			echo "<legend style=\"padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: .9em;font-weight: bold;color: #115098;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;\">Forum Settings</legend>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"forum_open\">Disable board:</label><br>";
			echo "<span>This will make the board unavailable to users. <br />You can also enter a short (255 character) message to display if you wish.</span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"forum_open\" name=\"config[forum_open]\" value=\"1\" ".(($row['forum_open'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[forum_open]\" value=\"0\" ".(($row['forum_open'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label><br><input id=\"board_disable_msg\" name=\"config[board_disable_msg]\" maxlength=\"255\" size=\"40\" value=\"".$row['board_disable_msg']."\" type=\"text\"></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"censor_words\">Cenor Words:</label><br>";
			echo "<span></span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"censor_words\" name=\"config[censor_words]\" value=\"1\" ".(($row['censor_words'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[censor_words]\" value=\"0\" ".(($row['censor_words'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar\">Posts Listed Perpage:</label><br>";
			echo "<span></span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"postsper_page\" size=\"4\" maxlength=\"10\" name=\"config[postsper_page]\" value=\"".$row['postsper_page']."\" type=\"text\"></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar\">Topics Listed Perpage:</label><br>";
			echo "<span></span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"topics_per_page\" size=\"4\" maxlength=\"10\" name=\"config[topics_per_page]\" value=\"".$row['topics_per_page']."\" type=\"text\"></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"max_subject_length\">Maximum characters in Subject:</label><br>";
			echo "<span></span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"max_subject_length\" size=\"4\" maxlength=\"10\" name=\"config[max_subject_length]\" value=\"".$row['max_subject_length']."\" type=\"text\"></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"max_post_length\">Maximum characters per post:</label><br>";
			echo "<span>The number of characters allowed within a post. <br />Set to 0 for unlimited characters.</span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"max_post_length\" size=\"4\" maxlength=\"10\" name=\"config[max_post_length]\" value=\"".$row['max_post_length']."\" type=\"text\"></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"show_latest_topic\">show_latest_topic:</label><br>";
			echo "<span></span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"show_latest_topic\" name=\"config[show_latest_topic]\" value=\"1\" ".(($row['show_latest_topic'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[show_latest_topic]\" value=\"0\" ".(($row['show_latest_topic'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"search_word_min\">search_word_min:</label><br>";
			echo "<span></span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><input id=\"search_word_min\" size=\"4\" maxlength=\"10\" name=\"config[search_word_min]\" value=\"".$row['search_word_min']."\" type=\"text\"></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar\">Allow bookmarking topics:</label><br>";
			echo "<span>User is able to store personal bookmarks.</span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"allow_bookmarks\" name=\"config[allow_bookmarks]\" value=\"1\" ".(($row['allow_bookmarks'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[allow_bookmarks]\" value=\"0\" ".(($row['allow_bookmarks'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar\">shout_new_topic:</label><br>";
			echo "<span></span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"shout_new_topic\" name=\"config[shout_new_topic]\" value=\"1\" ".(($row['shout_new_topic'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[shout_new_topic]\" value=\"0\" ".(($row['shout_new_topic'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
			echo "<hr></dl>\n";
			//////////////////////////////////////////////////////////
			echo "<dl style=\"margin-bottom: 10px;font-size: 0.85em;\">\n";
			echo "<dt style=\"width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;\"><label for=\"allow_avatar\">shout_new_post:</label><br>";
			echo "<span></span>\n";
			echo "</dt>\n";
			echo "<dd style=\"margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;\"><label><input id=\"shout_new_post\" name=\"config[shout_new_post]\" value=\"1\" ".(($row['shout_new_post'] == "true")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> Yes</label><label><input name=\"config[shout_new_post]\" value=\"0\" ".(($row['shout_new_post'] == "false")? "checked=\"checked\"" : '')." class=\"radio\" type=\"radio\"> No</label></dd>\n";
			echo "<hr></dl>\n";
		    echo "<p class=\"submit-buttons\">\n";
		    echo "<input class=\"button1\" id=\"submit\" name=\"submit\" value=\"Submit\" type=\"submit\">&nbsp;\n";
		    echo "<input class=\"button2\" id=\"reset\" name=\"reset\" value=\"Reset\" type=\"reset\">\n";
	        echo "</p>\n";
            echo "</fieldset>\n";
            echo "</form>\n";
            echo "</div>\n";
CloseTable();
OpenTable("Rapporter Items traités par");

// Start reports block
$type = $_GET["type"];
if ($type == "user")
$where = " WHERE type = 'user'";
else if ($type == "torrent")
$where = " WHERE type = 'torrent'";
else if ($type == "forum")
$where = " WHERE type = 'forum'";
else
$where = "";

$res = mysql_query("SELECT count(id) FROM ".$db_prefix."_reports $where") or die(mysql_error());
$row = mysql_fetch_array($res);

$count = $row[0];
$perpage = 25;
//list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] . "?type=" . $_GET["type"] . "&" );

print("<br><center><a href=reports-complete.php>Voir Repports Complets</a></center><br>");

echo $pagertop;

print("<table border=1 cellspacing=0 cellpadding=1 align=center width=95%>\n");
print("<tr><td class=table_head align=center>By</td><td class=table_head align=center>Reported</td><td class=table_head align=center>Type</td><td class=table_head align=center>Reason</td><td class=table_head align=center>Date</td><td class=table_head align=center>Responder</td><td class=table_head align=center>Mark as Treated</td>");
if (checkaccess("modforum"))
 printf("<td class=table_head align=center>Erase</td>");
print("</tr>");
print("<form method=post action=takedelreport.php>");
$res = mysql_query("SELECT ".$db_prefix."_reports.id, ".$db_prefix."_reports.dealtwith,".$db_prefix."_reports.dealtby, ".$db_prefix."_reports.addedby, ".$db_prefix."_reports.votedfor,".$db_prefix."_reports.votedfor_xtra, ".$db_prefix."_reports.reason, ".$db_prefix."_reports.type, ".$db_prefix."_users.username, ".$db_prefix."_reports.complete, ".$db_prefix."_reports.dealtdate FROM ".$db_prefix."_reports INNER JOIN ".$db_prefix."_users on ".$db_prefix."_reports.addedby = ".$db_prefix."_users.id $where AND complete = '0' ORDER BY id desc $limit");

while ($arr = mysql_fetch_assoc($res))
{
if ($arr[dealtwith])
{
$res3 = mysql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$arr[dealtby]");
$arr3 = mysql_fetch_assoc($res3);
$dealtwith = "<font color=green><b>Oui - <a href=account-details.php?id=$arr[dealtby]><b>$arr3[username]</b></a></b></font>";
}
else
$dealtwith = "<font color=red><b>Non</b></font>";
if ($arr[type] == "user")
{
$type = "account-details";
$res2 = mysql_query("SELECT username FROM ".$db_prefix."_users WHERE id=$arr[votedfor]");
$arr2 = mysql_fetch_assoc($res2);
$name = $arr2[username];
}
else if  ($arr[type] == "forum")
{
$type = "forums";
$res2 = mysql_query("SELECT subject FROM ".$db_prefix."_forum_topics WHERE id=$arr[votedfor]");
$arr2 = mysql_fetch_assoc($res2);
$subject = $arr2[subject];
}
else if ($arr[type] == "torrent")
{
$type = "torrents-details";
$res2 = mysql_query("SELECT name FROM ".$db_prefix."_torrents WHERE id=$arr[votedfor]");
$arr2 = mysql_fetch_assoc($res2);
$name = $arr2[name];
if ($name == "")
 $name = "<b>[Deleted]</b>";
}

if ($arr[type] == "forum")
  { print("<tr><td><a href=user.php?op=profile&id=$arr[addedby]><b>$arr[username]</b></a></td><td align=left><a href=$type.php?action=viewtopic&topicid=$arr[votedfor]&page=p#$arr[votedfor_xtra]><b>$subject</b></a></td><td align=left>$arr[type]</td><td align=left>$arr[reason]</td><td align=left>$arr[dealtdate]</td><td align=left>$dealtwith</td><td align=center><input type=\"checkbox\" name=\"delreport[]\" value=\"" . $arr[id] . "\" /></td></tr>\n");
  }
else {
    print("<tr><td><a href=user.php?op=profile&id=$arr[addedby]><b>$arr[username]</b></a></td><td align=left><a href=$type.php?id=$arr[votedfor]><b>$name</b></a></td><td align=left>$arr[type]</td><td align=left>$arr[reason]</td><td align=left>$arr[dealtdate]</td><td align=left>$dealtwith</td><td align=center><input type=\"checkbox\" name=\"delreport[]\" value=\"" . $arr[id] . "\" /></td>\n");
if (checkaccess("modforum"))
    printf("<td><a href=delreport.php?id=$arr[id]>Delete</a></td>");
print("</tr>");
}}

print("</table>\n");

print("<p align=right><input type=submit value=Confirm></p>");
print("</form>");

echo $pagerbottom;

print("<center><b>There is no need to delete the reports they once treated are marked as archived by the system.</b></center><br>");
CloseTable();
?> 