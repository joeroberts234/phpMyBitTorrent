<?php

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");
if ($_GET["id"] != ""){
$id = $_GET["id"];
if (checkaccess('can_add_uttube')){
mysql_query("DELETE FROM ".$db_prefix."_youtubevideo WHERE id= $id") or sqlerr(__FILE__, __LINE__);
}
else{
bterror("not authorized!","Sorry");
		die();
}
} 
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
if ($link == "" || $name == "")bterror("missing form data.","Sorry");
if(!checkaccess('can_add_uttube')){
        bterror("You do not have these Privelages.","Sorry");
		die();
}
    $name = $_POST["name"];
    $user = $user->name;
    $link = "http://youtube.com/v/".$_POST[link]."";
    mysql_query("INSERT INTO ".$db_prefix."_youtubevideo (link, name, addedby, addtime) VALUES('$link', '$name', '$user',NOW())") or sqlerr(__FILE__, __LINE__);
                        echo "<meta http-equiv=\"refresh\" content=\"0;url=youtube.php\">";
  }
if (checkaccess('can_view_utube')){
$showvid = "";
if ($op == "show"){
//$showvid = $video;
$showvid = $video;
}else{
$showvid = "";
}

print("\n\n\n<table border=0 cellspacing=0 cellpadding=0 align=center><tr>\n");
print("<td width=502 valign=top>\n");
print("<table width=502 border=1>\n");
Opentable("Vidoe Clip");
?>
<center>
<span class="style3"><font color=blue>Please Choose A Video From The Right.</font></span> </p>
</center>
<tr><td>

<iframe src="<?=$showvid?>" name="games" width="570" height="570" scrolling="no"></iframe>
<?
CloseTable();
print("<td width=300 valign=top><table border=1>");
OpenTable("List");
?>
<center>
<span class="style3"><font color=blue> Have Fun</font></span> </p>
</center>
<?
$query = "SELECT * FROM ".$db_prefix."_youtubevideo ORDER BY name";
$sql = $db->sql_query($query);
while ($row = $db->sql_fetchrow($sql)) {
$link = $row['link'];
$name = $row['name'];
print("<tr><td align=left>  <a href=".$link." target=games>".$name."</td></tr>");
}
CloseTable();
print("</td></tr></table>");
if (checkaccess('can_add_uttube')){
OpenTable("Add New Clip");
echo "<table align=center cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#D6D9DB\" width=\"100%\" border=\"1\">";
?>
<form method="post" action="youtube.php">
<div align=center>
For URL: "http://youtube.com/watch?v=qppuuQrklHg"<br />just put: qppuuQrklHg in link

</div>
<tr><td class="tableb">Link:</td><td class="tablea"><input type="text" name="link" size="60"></td></tr>
<tr><td class="tableb">Name:</td><td class="tablea"><input type="text" name="name" size="60"></td></tr>
<tr><td class="tablea" colspan="2" style="text-align:center"><input type="submit" value="Okay" class="btn"></td></tr>
</form>
<?
echo "</table>";
CloseTable();
OpenTable("Clips Info");
echo "<table align=center cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#D6D9DB\" width=\"100%\" border=\"1\">";
?>
<tr>
 <td width="5%" class="tablecat"><div align="center">ID</div></td>
 <td width="45%"class="tablecat"><div align="center">Name</div></td>
 <td width="15%"class="tablecat"><div align="center">Link</div></td>
 <td width="20%"class="tablecat"><div align="center">Added by</div></td>
 <td width="10%"class="tablecat"><div align="center">Added</div></td>
 <td width="5%"class="tablecat"><div align="center">Delete</div></td>
</tr>
<tr>
<?
$query = "SELECT * FROM ".$db_prefix."_youtubevideo ORDER BY id";
$sql = mysql_query($query);
    while ($row2 = mysql_fetch_array($sql)){
     $link = str_replace("http://youtube.com/v/","",$row2["link"]);
     $name = $row2["name"];
     $id = $row2["id"];
     $addedby = $row2["addedby"];
     $addtime = $row2["addtime"];
?>
<tr>
 <td width="5%" class="tablea"><div align="center"> <?=$id?></div></td>
 <td width="45%" class="tablea"><div align="center"> <?=$name?></div></td>
 <td width="15%" class="tablea"><div align="center"> <?=$link?></div></td>
 <td class="tablea"><div align="center"> <?=$addedby?></div></td>
 <td class="tablea"><div align="center"> <?=$addtime?></div></td>
 <td class="tablea"><div align="center"><?=pic("drop.gif","youtube.php?id=".$id,"Remove");?></div></td>
</tr>
<?
$nr = $nr+1;
}
echo "</table>";
CloseTable();
}
}
include ("footer.php");
?>