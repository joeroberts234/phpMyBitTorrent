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
*------                    Hacked For phpMyBitTorrent                   -------*
*----------------                 By joeroberts                   -------------*
*------------------------------------------------------------------------------*
*/
include("header.php");
OpenTable('Divx');

$id = 0 + $_GET['id'];

function MakeSQLSafe($msg)
{

//this will allow all punctuation in the message, and also prevent sql injection.

$msg = str_replace("'", '&#39;', $msg);
$msg = str_replace("--", '&#45;&#45;', $msg);

return $msg;
};

function MakeHTMLSafe($msg)
{

//this will stop people from using javascript and html tags in their posts.

$msg = str_replace('<', '&lt;', $msg);
$msg = str_replace('>', '&gt;', $msg);
$msg = str_replace('javascript:', 'java script:', $msg);

return $msg;
}

//begin_frame("divx");

$res = mysql_query("SELECT COUNT(*) FROM ".$db_prefix."_divx");
$row = mysql_fetch_array($res);
$count = $row[0];

if ($act=="search") {
$perpage = 15;
}else {
$perpage = 50;
}

//list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] ."?" );

if (!$act or $act == "search") {

if ($id) {
$mess = "Press Play";
$res = mysql_query("SELECT * FROM ".$db_prefix."_divx WHERE id='$id'");
$arr = mysql_fetch_array($res);
$divx = $arr["url"];
$titre = $arr["title"];
}else {
$mess="Select a Video";
}

 ?>

<STYLE type=text/css>
.td_search {
background: none;
BORDER-TOP: #a0a0a0 1px solid;
BORDER-BOTTOM: #a0a0a0 1px solid;
BORDER-LEFT: #a0a0a0 1px solid;
BORDER-RIGHT: #a0a0a0 1px solid;
}
</style>

<table width="100%" height="300" align="center" border="0" cellpadding="0" cellspacing="">
<tr>
<td colspan="2" width="100%" valign="top" align="center">
<br>
<?php
if ($titre) {
echo "<font size='3'><b>".$titre."</b></font>";
echo "<br><br>";
}
 ?>
<center><object classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" width="623" height="350" codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">

 <param name="custommode" value="Stage6" />

  <param name="mode" value="null" />
  <param name="autoPlay" value="false" />
  <param name="allowContextMenu" value="false" />
  <param name="src" value="<?php echo $divx; ?>" />

<embed type="video/divx" src="<?php echo $divx; ?>" custommode="Stage6" width="720" height="394" mode="null"  autoPlay="false"  allowContextMenu="false"  pluginspage="http://go.divx.com/plugin/download/">
</embed>
</object></center>
<br><br>
</td>
</tr>
</table>

<br>

<fieldset class="td_search"><legend><b>Search a video</b></legend>
<form name="divx_form_1" id="divx_form_1" method="post" action="divx.php">
<table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr><td width="100%" align="center">
<input type="text" name="recherche" value="<?php echo $recherche; ?>" maxlength='100' size='30'>
<input type="hidden" name="act" value="search">
<?php if($ajax_browse == "yes") { ?>
<input onclick="javascript:sndAjaxPost('divx.php','divx_form_1');" type="button" value="Search!">
<?php }else { ?>
<input type="submit" value="Search!">
<?php } ?>
</tr></td></table></form></fieldset>
<br>
<fieldset class="td_search"><legend><b>Now Playing</b></legend>
<table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<?php

if ($act=="search") {

$recherche = str_replace("+"," ",$_POST['recherche']);
$recherche = trim($recherche);
while(strpos($recherche,"  ")) {
$recherche = str_replace("  "," ",$recherche);
}
$recherche = MakeSQLSafe($recherche);

$res = mysql_query("SELECT * FROM ".$db_prefix."_divx WHERE title LIKE '%$recherche%' ORDER BY id DESC $limit");

while($arr = mysql_fetch_array($res))
{

$url = MakeHTMLSafe($arr["url"]);
$title = MakeHTMLSafe($arr["title"]);
$description = MakeHTMLSafe($arr["description"]);
$id = $arr["id"];
$thumbnail = $arr["thumbnail"];
$width = $arr["width"];
$height = $arr["height"];

print ("<tr><td width=\"".($width+20)."px\"><img src=\"".$thumbnail."\" title=\"".$title."\" alt=\"".$title."\" width=\"".$width."px\" hight=\"".$height."px\" border=\"0\"></td><td><p>".$title."</p><br><br><br><p>".$description."</p><br><br><p><a href=\"".(($ajax_browse == 'yes') ? "javascript:sndAjaxReq('divx.php?id=".$id."');" : "divx.php?id=".$id."")."\"><img src=\"images/button_play.gif\" title=\"PLAY\" alt=\"\" width=\"34px\" hight=\"15px\" border=\"0\"></a>");
if ($user->admin) {
print ("<a width=100 href=\"".(($ajax_browse == 'yes') ? "javascript:sndAjaxReq('divx.php?act=edit&id=".$id."');" : "divx.php?act=edit&id=".$id."")."\"><img src=\"images/button_edit.gif\" title=\"EDIT\" alt=\"\" width=\"34px\" hight=\"15px\" border=\"0\"></a>");
print ("<a href=\"".(($ajax_browse == 'yes') ? "javascript:sndAjaxReq('divx.php?act=del&id=".$id."');" : "divx.php?act=del&id=".$id."")."\"><img src=\"images/button_delete.gif\" title=\"Delete\" alt=\"\" width=\"34px\" hight=\"15px\" border=\"0\"></a></p></td>");
}
print ('</tr>');
}
}else {

$res = mysql_query("SELECT * FROM ".$db_prefix."_divx ORDER BY id DESC $limit");
$row = mysql_num_rows($res);

if($row !== 0){

while ($arr = mysql_fetch_array($res))
{

$url = MakeHTMLSafe($arr["url"]);
$title = MakeHTMLSafe($arr["title"]);
$description = MakeHTMLSafe($arr["description"]);
$id = $arr["id"];
$thumbnail = $arr["thumbnail"];
$width = $arr["width"];
$height = $arr["height"];

print ("<tr><td width=\"".($width+20)."px\"><img src=\"".$thumbnail."\" title=\"".$title."\" alt=\"".$title."\" width=\"".$width."px\" hight=\"".$height."px\" border=\"0\"></td><td><p>".$title."</p><br><br><br><p>".$description."</p><br><br><p><a href=\"".(($ajax_browse == 'yes') ? "javascript:sndAjaxReq('divx.php?id=".$id."');" : "divx.php?id=".$id."")."\"><img src=\"images/button_play.gif\" title=\"PLAY\" alt=\"\" width=\"34px\" hight=\"15px\" border=\"0\"></a>");
if ($user->admin) {
print ("<a width=100 href=\"".(($ajax_browse == 'yes') ? "javascript:sndAjaxReq('divx.php?act=edit&id=".$id."');" : "divx.php?act=edit&id=".$id."")."\"><img src=\"images/button_edit.gif\" title=\"EDIT\" alt=\"\" width=\"34px\" hight=\"15px\" border=\"0\"></a>");
print ("<a href=\"".(($ajax_browse == 'yes') ? "javascript:sndAjaxReq('divx.php?act=del&id=".$id."');" : "divx.php?act=del&id=".$id."")."\"><img src=\"images/button_delete.gif\" title=\"Delete\" alt=\"\" width=\"34px\" hight=\"15px\" border=\"0\"></a></p></td>");
}
print ('</tr>');
}
}else{
	echo "<tr><td align=center><font color=red><b>Pas de Videos !</b></font></td></tr>";
}
}
echo "</table>";

if($row !== 0)
echo $pagerbottom;

echo "</fieldset><br>";
}

if ($user->admin and $act=="") {

 ?>
<br>
<form name="divx_form_2" id="divx_form_2" action="divx.php" method="post">
<table width="500" bordercolor=#33CC00 style='border-collapse: collapse' align="center" border="1">
<tr><td colspan="2" valign="top">
<center><b>Moderators Options</b><br>(Add a video)</center>
</td></tr>
<input type="hidden" name="act" value="add">
<tr><td width="100" align="right">Video Title : </td><td><input type="text" name="title" maxlength='100' size='50'></td></tr>
<tr><td width="100" align="right">Video URL :<br>(Format divx)&nbsp;&nbsp;</td><td><input type="text" name="url" maxlength='120' size='50'></td></tr>
<tr><td width="100" align="right">New Video Image URL :</td><td><input type="text" name="image"  maxlength='100' size='50'></td></tr>
<tr><td width="100" align="right">New Video Description :</td><td><input type="text" name="desc"  maxlength='100' size='50'></td></tr>
<tr><td width="100" align="right">New Video IMDB Link:</td><td><input type="text" name="imdb"  maxlength='100' size='50'></td></tr>
<tr><td align="center" colspan="2">
<?php if($ajax_browse == "yes") { ?>
<input onclick="javascript:sndAjaxPost('divx.php','divx_form_2');" type="button" value="Add">
<?php }else { ?>
<input type="submit" value="Add">
<?php } ?>
</td></tr>
</table></form><br>
<?php
}

if ($user->admin and $act=="add") {

$title = MakeSQLSafe($_POST["title"]);
$url = MakeSQLSafe($_POST["url"]);

mysql_query("INSERT INTO ".$db_prefix."_divx (title, url) VALUES ('".$title."', '".$url."')");

echo "<center><font color=red>Video added !</font><br><br></center>";
echo "Nom : ";
echo MakeHTMLSafe($_POST["title"]);
echo "<br>URL : ";
echo MakeHTMLSafe($_POST["url"]);
echo "<br><br><center><a href=\"".(($ajax_browse == 'yes') ? "javascript:sndAjaxReq('divx.php');" : "divx.php")."\">Back</a></center>";
}

if ($user->admin and $act=="addedit") {

$title = MakeSQLSafe($_POST["title"]);
$url = MakeSQLSafe($_POST["url"]);
$id = MakeSQLSafe(0 + $_POST["id"]);

mysql_query("UPDATE divx SET title='$title', url='$url' where id='$id'");

echo "<center><font color=red>Video updated !</font><br><br></center>";
echo "Nom : ";
echo MakeHTMLSafe($_POST["title"]);
echo "<br>URL : ";
echo MakeHTMLSafe($_POST["url"]);
echo "<br><br><center><a href=\"".(($ajax_browse == 'yes') ? "javascript:sndAjaxReq('divx.php');" : "divx.php")."\">Back</a></center>";
}

if ($user->admin and $act=="edit") {

$id = MakeSQLSafe(0 + $_GET['id']);

$res = mysql_query("SELECT * FROM divx WHERE id='$id'");
$arr = mysql_fetch_array($res);

$title = $arr["title"];
$url = $arr["url"];

 ?>
<form name="divx_form_3" id="divx_form_3" action="divx.php" method="post">
<table width="500" align="center" border="0">
<tr><td colspan="2" valign="top">
<center><b>Edit Video</b><br><br></center>
</td></tr>
<input type="hidden" name="act" value="addedit">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<tr><td width="100" align="right">New Video Title : </td><td><input type="text" name="title" value="<?php echo $title; ?>" maxlength='100' size='50'></td></tr>
<tr><td width="100" align="right">New Video URL :<br>(Format divx)&nbsp;&nbsp;</td><td><input type="text" name="url" value="<?php echo $url; ?>" maxlength='100' size='50'></td></tr>
<tr><td width="100" align="right">New Video Image URL :</td><td><input type="text" name="image" value="<?php echo $url; ?>" maxlength='100' size='50'></td></tr>
<tr><td width="100" align="right">New Video Description :</td><td><input type="text" name="desc" value="<?php echo $url; ?>" maxlength='100' size='50'></td></tr>
<tr><td width="100" align="right">New Video IMDB Link:</td><td><input type="text" name="imdb" value="<?php echo $url; ?>" maxlength='100' size='50'></td></tr>
<tr><td align="center" colspan="2">
<?php if($ajax_browse == "yes") { ?>
<input onclick="javascript:sndAjaxPost('divx.php','divx_form_3');" type="button" value="Edit">
<?php }else { ?>
<input type="submit" value="Edit">
<?php } ?>
</td></tr>
</table></form><br>
<?php
}

if ($user->admin and $act=="del") {

$id = MakeSQLSafe(0 + $_GET['id']);

mysql_query("DELETE FROM divx WHERE id='$id'");

echo "<br><br><center><font color=red>Video deleted !</font><br><br><a href=\"".(($ajax_browse == 'yes') ? "javascript:sndAjaxReq('divx.php');" : "divx.php")."\">Back</a></center>";
}

CloseTable();

include("footer.php");
