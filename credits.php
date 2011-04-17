<?php
/*
*------------------------------phpMyBitTorrent V 2.0.4-------------------------*
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
*------              ©2009 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
if (!eregi("credits.php",$_SERVER["PHP_SELF"])) die ("You cannot include this file");
include("header.php");
$action = isset($_GET["action"]) ? htmlspecialchars(trim($_GET["action"])) : '';
$act_validation = array('', 'add', 'edit', 'delete', 'update');
$id = 0 + $_GET['id'];
if(!in_array($action, $act_validation))
bterror("Unknown action.","Error");

/*Check if CutName function exists, if not declare it */
if (!function_exists('CutName'))
  {
  
function CutName ($txt, $len)
  {
return (strlen($txt)>$len ? substr($txt,0,$len-4) .'[...]':$txt);
  }
  
}



if ($_POST['action'] == 'add' && $user->admin){
	
    $name = ($_POST['name']);
    $description = ($_POST['description']);
    $category = ($_POST['category']);
    $link = ($_POST['link']);
    $status = ($_POST['status']);
    $credit = ($_POST['credit']);
    
    mysql_query("INSERT INTO ".$db_prefix."_modscredits (
	name, 
	description,  
	category,  
	PMBT,  
	status, 
	credit
	) 
	VALUES(
	'" . $name . "', '" . $description . "', '" . $category . "', '" . $link . "', '" . $status . "', '" . $credit . "')") or sqlerr(__FILE__, __LINE__);

	header("Location: credits.php");
	die();
	
}

if ($_GET['action'] == "delete") {

	if (!$id) { bterror("No Id");}

	mysql_query("DELETE FROM ".$db_prefix."_modscredits where id = '$id'") or sqlerr(__FILE__, __LINE__);
	
	header("Location: credits.php");
	die();
}


if ($action == "edit" && $user->admin)
{
	$id = (int)$_GET["id"];
	
	$res = mysql_query("SELECT name, description, category, PMBT, status, credit FROM ".$db_prefix."_modscredits WHERE id = $id") or sqlerr(__FILE__, __LINE__);

	if (mysql_num_rows($res) == 0)
		echo('Error No credit mod found with that ID!');
		
	while($mod = mysql_fetch_assoc($res)){

	
    echo "<table width=850 cellpadding=10 cellspacing=1 border=1>";
	print("<form method=post action=".$_SERVER['PHP_SELF']."?action=update&id=$id>\n");
	print("<tr><td class=rowhead>Mod name</td>" .
	"<td align=left style='padding: 0px'><input type=text size=60 maxlength=120 name=name " .
	"value=\"".htmlspecialchars($mod['name'])."\"></td></tr>\n".
	"<tr><td class=rowhead>Description</td>" .
	"<td align=left style='padding: 0px'><input type=text size=60 maxlength=120 name=description value=\"".htmlspecialchars($mod['description'])."\"></td></tr>\n".
	"<tr><td class=rowhead>Category</td>");
?>
<td align="left" style='padding: 0px'>
<select name="category">
<?
$result=mysql_query('SHOW COLUMNS FROM '.$db_prefix.'_modscredits WHERE field=\'category\'');
while ($row=mysql_fetch_row($result))
{
   foreach(explode("','",substr($row[1],6,-2)) as $v)
   {
     print("<option value=$v". ($mod["category"] == $v ? " selected" : "") . ">$v</option>");
   }
}
?>
</select>
</td>
</tr>
<?
  print("<tr><td class=rowhead>Link</td>" .
	"<td align=left style='padding: 0px'><input type=text size=60 maxlength=120 name=link " .
	"value=\"".htmlspecialchars($mod['PMBT'])."\"></td></tr>\n");
  print("<tr><td class=rowhead>Status</td>");
?>
<td align="left" style='padding: 0px'>
<select name="modstatus">
<?
$result=mysql_query('SHOW COLUMNS FROM '.$db_prefix.'_modscredits WHERE field=\'status\'');
while ($row=mysql_fetch_row($result))
{
   foreach(explode("','",substr($row[1],6,-2)) as $y)
   {
     print("<option value=$y". ($mod["status"] == $y ? " selected" : "") . ">$y</option>");
   }
}
?>
</select>
</td>
</tr>
<?
print("<tr><td class=rowhead>Credits</td><td align=left style='padding: 0px'><input type=text size=60 maxlength=120 name=credits value=\"".htmlspecialchars($mod['credit'])."\"></td></tr>\n");
	print("<tr><td colspan=2 align=center><input type=submit value='Submit'></td></tr>\n");
	print("</form></table>");
	}
CloseTable();
}else if ($action == "update" && $user->admin)
{
	$id = (int)$_GET["id"];
		//if (!is_valid_id($id))
		//bterror('Error', 'Invalid ID!');
	$res = mysql_query('SELECT id FROM '.$db_prefix.'_modscredits WHERE id = '.$id);
	if (mysql_num_rows($res) == 0)
		bterror('No mod credit with that ID!');
	
	$name = $_POST['name'];
	$description = $_POST['description'];
	$category = $_POST['category'];
	$link = $_POST['link'];
	$modstatus = $_POST['modstatus'];
	$credit = $_POST['credits'];
	function sqlesc($esc)
	{
	return "'".$esc."'";
	}
	if (empty($name))
		bterror("You must specify a name for this credit.");
	
	if (empty($description))
		bterror("You must provide a description for this credit.");
		
	//if (empty($link))
		//bterror("Error", "You must provide a link to TBDev for this credit.");
		
	if (empty($credit))
		bterror("You must provide a credit for the author(s) of this credit.");
	
	mysql_query("UPDATE ".$db_prefix."_modscredits SET name = ".sqlesc($name).", category = ".sqlesc($category).", status = ".sqlesc($modstatus).",  PMBT = ".sqlesc($link).", credit = ".sqlesc($credit).", description = ".sqlesc($description)." WHERE id = ".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
	
header("Location: {$_SERVER['PHP_SELF']}");

	exit();
}else if ($action == ""){
OpenTable("Credits");



?>
<script language="JavaScript">
<!--
function confirm_delete(id)
	{
		ht = document.getElementsByTagName("html");
		ht[0].style.filter = "progid:DXImageTransform.Microsoft.BasicImage(grayscale=1)";
		if (confirm('Are you sure you want to delete this mod credit?'))
		{
			return true;
		}
		else
		{
			ht[0].style.filter = "";
			return false;
		}
	}
//-->
</script>



<?
/*
Begin displaying the mods
*/



 /*Query the db*/

  $res = mysql_query("SELECT * FROM ".$db_prefix."_modscredits") or sqlerr(__FILE__, __LINE__);
 
  //Begin displaying the table
  echo "<table width=850 cellpadding=10 cellspacing=1 border=1>";
    echo "<tr>";
    echo "<td align=center class=colhead>Name</td>";
    echo "<td align=center class=colhead>Category</td>";
    echo "<td align=center class=colhead>Status</td>";
    echo "<td align=center class=colhead>Credits</td>";
    echo "</tr>";
  if($row = mysql_fetch_array($res)){
   do{
      $id = $row["id"];
      $name = $row["name"];
      $category =$row["category"];
      if($row["status"]=="In-Progress"){
      $status = "[b][color=#ff0000]".$row["status"]."[/color][/b]";
      }else{
      $status = "[b][color=#018316]".$row["status"]."[/color][/b]";
      }
      $link = $row["PMBT"];
      $credit = $row["credit"];
      $descr = $row["description"];
      
      echo "<tr><td><p><a target=_blank class=altlink href=".$link.">".htmlspecialchars(CutName($name,60)) ."</a>";
      if ($user->admin){
      echo "&nbsp<a class=altlink_blue href=?action=edit&id=".$id.">[Edit]</a>&nbsp<a class=altlink_blue href=\"credits.php?action=delete&amp;id=".$id."\" onclick=\"return confirm_delete('".$id."')\">[Delete]</a>";
      
      }

      echo "<br/>".htmlspecialchars($descr)."</p></td>";
      echo "<td><b>".htmlspecialchars($category)."</b></td>";
      echo "<td><b>".format_comment($status)."<b></td>";
      echo "<td>".htmlspecialchars($credit)."</td></tr>";
    
    }while($row = mysql_fetch_array($res));
  }else{
      echo "<tr><td colspan=4>No mods credits so far...</td></tr>";
}

 echo "</table>";
CloseTable();
	if ($user->admin) //I recommend a higher class like UC_CODER
	{
	OpenTable("Add New Credit");
	
	?>
	<br/>
	<table width="100%" cellpadding="8" border="1" cellspacing="0">
   <tr>
		<td colspan="2" class="colhead">
      Add Mods Credits
		</td>
	 </tr>
  		
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="hidden" name="action" value="add" />
		<tr>
		<td>Name:</td><td><input name="name" type="text" size="120"></td>
		</tr>
		<tr>
		<td>Description:</td><td><input name="description" type="text" size="120" length="120"></td>
		</tr>
				
		<tr>
		<td>Category:</td><td>
		
    <select name="category">
    <option value="Addon">Addon</option>
    <option value="Forum">Forum</option>
    <option value="Message/Email">Message/Email</option>
    <option value="Display/Style">Display/Style</option>
    <option value="Staff/Tools">Staff/Tools</option>
    <option value="Browse/Torrent/Details">Browse/Torrent/Details</option>
    <option value="Misc">Misc</option>
    </select>
        
		
		
		</td>
		</tr>
		<tr>
		<td>Link:</td><td><input name="link" type="text" size="50"></td>
		</tr>
		<tr>
		<td>Status:</td><td>
		<select name="status">
    <option value="In-Progress">In-Progress</option>
    <option value="Complete">Complete</option>
    </select>
		
		</td>
		</tr>
	<tr>
	<td>Credits:</td><td><input name="credit" type="text" size="120" length="120"><br><font class="small">Values separated by commas</font></td>
	</tr>
	<tr>
		<td colspan="2">
		<input type="submit" value="Add Credit" />
		</td>
	</tr>
		
		</form>

</table>   
	<?
CloseTable();
}
}
include("footer.php");
?>