<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*/

if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
global $user;
//include'admin/language/addon/level_'.$user->ulanguage.'.php';
		if(!checkaccess("edit_level")){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to edit Profiles</p>";
CloseErrTable();
die();
}
echo "<a name=\"levels\"></a>";
OpenTable(_adm_level_table);
echo "<p>&nbsp;</p>\n";

$sql = "SELECT level, name FROM ".$db_prefix."_levels;";
echo selectaccess("admin");
$res = $db->sql_query($sql) or btsqlerror($sql);
$res2 = $db->sql_query($sql) or btsqlerror($sql);
        echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "<thead>\n";
        echo "<tr>";
	echo "<td><p><b>" . _btalt_edit . "<b></p></td>";
	echo "<td><p><b>" . _btalt_drop . "<b></p></td>";
	echo "<td><p><b>" . _btalt_viewed ."<b></p></td>";
		$levelsdisp = array();
foreach ($db->sql_fetchrow($res) as $key => $val) {
    if(!is_numeric($key)){
	$levelsdisp[$key] = $val;
	echo "<td><p><b>".$key."<b></p></td>";
	}
} 
echo"</tr>\n";
        echo "</thead>\n";
echo"<tbody>\n";
while ($tracker = $db->sql_fetchrow($res2)) {
       echo "<tr>";
	echo "<td><p><b>".pic("editprofile.png","admin.php?op=levels&do=editlevel&level=".$tracker['level']."#editlevel",_btalt_edit)."<b></p></td>";
	echo "<td><p><b>".pic("drop.gif","admin.php?op=levels&do=deletelevel&level=".$tracker['level']."#dellevel",_btalt_drop)."<b></p></td>";
	echo "<td><p><b>".pic("viewed.gif","admin.php?op=levels&do=viewlevel&level=".$tracker['level']."#viewlevel",_btalt_viewed)."<b></p></td>";
	foreach ($tracker as $key2 => $val2) {
    if(!is_numeric($key2)){
	echo "<td><p><b>".$val2."</b></p></td>";
	}
} 
	echo "</tr>\n";
}
        echo "</tbody>\n";
        echo "</table>\n";
$db->sql_freeresult($res);
$db->sql_freeresult($res2);
echo "<form enctype=\"multipart/form-data\" action=\"admin.php#newlevel\" method=\"post\"><input type=\"hidden\" name=\"op\" value=\"levels\" /><input type=\"hidden\" name=\"do\" value=\"addlevel\"><p><input type=\"submit\" value=\"Creat New Level\" /></p></form>";
echo "<form enctype=\"multipart/form-data\" action=\"admin.php#addlevelaction\" method=\"post\"><input type=\"hidden\" name=\"op\" value=\"levels\" /><input type=\"hidden\" name=\"do\" value=\"addlevelaction\"><p><input type=\"submit\" value=\"Creat New Access\" /></p></form>";
echo "<form enctype=\"multipart/form-data\" action=\"admin.php#droplevelaction\" method=\"post\"><input type=\"hidden\" name=\"op\" value=\"levels\" /><input type=\"hidden\" name=\"do\" value=\"droplevelaction\"><p><input type=\"submit\" value=\"Drop Access\" /></p></form>";

CloseTable();
            if ($do == "viewlevel")
			{
			$sql = "SELECT * FROM ".$db_prefix."_levels WHERE `level` = '".$level."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
			echo "<a name=\"viewlevel\"></a>";
			Opentable(_adm_level_table_details);
			echo "<br />For level: $level<br />";
	                       echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		foreach ($row as $show => $val)
			                              {
										  if(!is_numeric($show)){
	    								  if($val=="false"){
										  echo "<tr><td><font color=red>".$show."</font></td><td align=\"right\">".$val."</td></tr>\n";
										  }elseif($val=="true"){
										  echo "<tr><td><font color=green>".$show."</font></td><td align=\"right\">".$val."</td></tr>\n";
										  }elseif($show=="color"){
										  echo "<tr><td>".$show."</td><td align=\"right\" bgcolor=\"".$val."\">".$val."</td></tr>\n";
										  }elseif($show=="group_desc"){
										  echo "<tr><td>".$show."</td><td align=\"right\">".$val."</td></tr>\n";
										  }else{
										  echo "<tr><td>".$show."</td><td align=\"right\">".$val."</td></tr>\n";
										  }
										  }
										  }
										  echo"</table>";
										  echo pic("drop.gif","admin.php?op=levels&do=deletelevel&level=".$level."#dellevel",_btalt_drop);
										  echo pic("edit.gif","admin.php?op=levels&do=editlevel&level=".$level."#editlevel",_btalt_edit);
										  CloseTable();
										  }
if ($do == "addlevelaction"){
Opentable("New Access");
                       echo "<form enctype=\"multipart/form-data\" action=\"admin.php#takeaddlevelaction\" method=\"post\">\n";
                       echo "<input type=\"hidden\" name=\"op\" value=\"levels\" />";
                       echo "<input type=\"hidden\" name=\"do\" value=\"takeaddlevelaction\" />";
                       echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
					   echo "<tr><td><p><b>NEW Access<b></p></td><td><p><input type=\"text\" name=\"access_set\"  size =\"40\" /></p></td></tr>\n";
                       echo "</table>\n";
                       echo "<p><input type=\"submit\" name=\"postback\" value=\""._btsend."\"></p>\n";
                       echo "</form>\n";
CloseTable();
}
echo "<a name=\"newlevel\"></a>";
if ($do == "takeaddlevelaction"){
Opentable("takeaddlevelaction");
$db->sql_query("ALTER TABLE `".$db_prefix."_levels` ADD `".$access_set."` ENUM( 'true', 'false' ) NOT NULL DEFAULT 'false';");
echo  "takeaddlevelaction";
CloseTable();
}
if ($do == "confermdroplevelaction"){
                if (isset($postback)) {
                } else {
Opentable("confermdroplevelaction");
                        echo "<form method=\"POST\" action=\"admin.php#confermdroplevelaction\"><input type=\"hidden\" name=\"op\" value=\"confermdroplevelaction\" />\n";
echo  "confermdroplevelaction";
                        echo "<p align=\"center\"><input type=\"submit\" name=\"postback\" value=\""._btconfirmdelete."\"></p>\n";

                        echo "</form>";
CloseTable();
                }
}
if ($do == "droplevelaction"){
Opentable("droplevelaction");
echo  "droplevelaction";
                       echo "<form enctype=\"multipart/form-data\" action=\"admin.php#confermdroplevelaction\" method=\"post\">\n";
                       echo "<input type=\"hidden\" name=\"op\" value=\"levels\" />";
                       echo "<input type=\"hidden\" name=\"do\" value=\"confermdroplevelaction\" />";
                       echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
					   echo "<tr><td><p><b>Drop Access<b></p></td><td><p><input type=\"text\" name=\"access_set\"  size =\"40\" /></p></td></tr>\n";
                       echo "</table>\n";
                       echo "<p><input type=\"submit\"  value=\""._btsend."\"></p>\n";
                       echo "</form>\n";
//$db->sql_query("ALTER TABLE `".$db_prefix."_levels` DROP `".$droplevel."`");
CloseTable();
}
echo "<a name=\"newlevel\"></a>";
if ($do == "addlevel"){
                       Opentable("addlevel");
                       echo  "addlevel";
                       echo "<br />For level: $level";
                       echo "<form enctype=\"multipart/form-data\" action=\"admin.php#takenew\" method=\"post\">\n";
                       echo "<input type=\"hidden\" name=\"op\" value=\"levels\" />";
                       echo "<input type=\"hidden\" name=\"do\" value=\"takenew\" />";
                       echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
					   echo "<tr><td><p><b>NEW level<b></p></td><td><p><input type=\"text\" name=\"level\"  size =\"40\" /></p></td></tr>\n";
					   echo "<tr><td><p><b>New level Name<b></p></td><td><p><input type=\"text\" name=\"name\"  size =\"40\" /></p></td></tr>\n";
					   echo "<tr><td><p><b>New level Color<b></p></td><td><p><input type=\"text\" name=\"color\"  size =\"40\" /></p></td></tr>\n";
                       echo "</table>\n";
                       echo "<p><input type=\"submit\" name=\"postback\" value=\""._btsend."\"></p>\n";
                       echo "</form>\n";
CloseTable();
}
echo "<a name=\"editlevel\"></a>";
if ($do == "editlevel"){
if($level == "owner" && !$user->group == "owner"){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to edit Profiles</p>";
CloseErrTable();
CloseTable();
include'footer.php';
}

                        $sql = "SELECT * FROM ".$db_prefix."_levels WHERE `level` = '".$level."';";
                        $res = $db->sql_query($sql) or btsqlerror($sql);
                        $row = $db->sql_fetchrow($res);
                        Opentable("editlevel");
                        echo  "editlevel";
                        echo "<br />For level: $level";
                        echo "<form enctype=\"multipart/form-data\" action=\"admin.php#takeed\" method=\"post\">\n";
                        echo "<input type=\"hidden\" name=\"op\" value=\"levels\" />";
                        echo "<input type=\"hidden\" name=\"do\" value=\"take_edit\" />";
                        echo "<input type=\"hidden\" name=\"level\" value=\"".$level."\" />";
                        echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
                        echo "<thead>\n";
	                    foreach ($row as $show => $val){
	                                                    if(!is_numeric($show)){
	                                                                           if ($val == "true" OR $val == "false"){
	                                                                                                                  echo "<tr><td><p><b>$show<b></p></td><td><p>Yes <input name=\"".$show."\" value=\"true\" ";
	                                                                                                                  if ($val == "true") echo "checked=\"checked\" ";
	                                                                                                                  echo "type=\"radio\"> No <input name=\"".$show."\" value=\"false\" ";
                                                                                                                      if ($val == "false") echo "checked=\"checked\" ";
                                                                                                                       echo "type=\"radio\"></p></td></tr>\n";
	                                                     }else{
                                                               if ($show != "level")echo "<tr><td><p><b>$show<b></p></td><td><p><input type=\"text\" name=\"".$show."\" value=\"".$val."\" size =\"40\" /></p></td></tr>\n";
	                                                                           }
	                                                          }
	                                                     }
                      echo "</tbody>\n";
                      echo "</table>\n";
                      echo "<p><input type=\"submit\" name=\"postback\" value=\""._btsend."\"></p>\n";
                      echo "</form>\n";
                      CloseTable();
                     }
echo "<a name=\"takenew\"></a>";
if ($do == "takenew"){
Opentable("takenew");
echo  "takenew";
echo "<br />For level: $level";
echo "<br />For level: $name";
$db->sql_query("INSERT INTO ".$db_prefix."_levels (level, name ) VALUES ('".$level."', '".$name."');")or  btsqlerror();
CloseTable();
}
echo "<a name=\"dellevel\"></a>";
if ($do == "deletelevel"){
Opentable("deletelevel");
if(isset($group) AND $group != "")
{
OpenSuccTable();
$oldl = $db->sql_fetchrow($db->sql_query("SELECT `name` FROM `".$db_prefix."_levels`WHERE `level`= '" . $level . "'"));
$newl = $db->sql_fetchrow($db->sql_query("SELECT `name` FROM `".$db_prefix."_levels`WHERE `level`= '" . $group . "'"));
echo "<br />" . $oldl['name'] . " has Been removed and all users changed to " . $newl['name'] . "";
$db->sql_query("UPDATE FROM ".$db_prefix."_users SET `can_do = '" . $group . "'WHERE `can_do` = '".$level."';")or  btsqlerror();
$db->sql_query("DELETE FROM ".$db_prefix."_levels WHERE `level` = '".$level."';")or  btsqlerror();
CloseSuccTable();
}else{
if($level == "owner"){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to edit Profiles</p>";
CloseErrTable();
CloseTable();
include'footer.php';
}
                        $sql = "SELECT COUNT(can_do)as can_do FROM ".$db_prefix."_users WHERE `can_do` = '".$level."';";
                        $res = $db->sql_query($sql) or btsqlerror($sql);
		                $numbero = (int) $db->sql_fetchfield('can_do');
                		$db->sql_freeresult($sql);
						if($numbero>0){
                        echo "You have $numbero Members set to $level Please Select new Group to set them to";
                        echo "<form enctype=\"multipart/form-data\" action=\"admin.php#takeed\" method=\"post\">\n";
                        echo "<input type=\"hidden\" name=\"op\" value=\"levels\" />";
                        echo "<input type=\"hidden\" name=\"do\" value=\"deletelevel\" />";
                        echo "<input type=\"hidden\" name=\"level\" value=\"".$level."\" />";
						echo selectaccess();
                        echo "<p><input type=\"submit\" name=\"postback\" value=\""._btsend."\"></p>\n";
                        echo "</form>\n";
						}else{
						OpenSuccTable();
	                    echo "<br />Level: $level Has Been removed";
                        $db->sql_query("DELETE FROM ".$db_prefix."_levels WHERE `level` = '".$level."';")or  btsqlerror();
						CloseSuccTable();
					}

}
CloseTable();
}
echo "<a name=\"takeed\"></a>";
if ($do == "take_edit"){
if($level == "owner" && !$user->group == "owner"){
OpenErrTable(_btaccdenied);
echo "<p>You do not have access to edit Profiles</p>";
CloseErrTable();
CloseTable();
include'footer.php';
}
                        OpenTable("take_edit");
                        echo  "take_edit";
                        echo "<br />For level: $level<br />";
                        $sqlrow=array();
                        $sqlinsert=array();
                        foreach ($_POST as $show => $val){
                                                          if(!is_numeric($show) AND $show != "do" AND $show != "op" AND $show != "level" AND $show != "postback")
														  {
														  $sqlrow[] .= $show;
														  $sqlinsert[] .= "'".$val."'";
														  echo $show.":  ".$val."<br />";
														  }
										                  }
			           $sql= "UPDATE ".$db_prefix."_levels SET ";
					   for ($i = 0; $i < count($sqlrow); $i++) $sql .= $sqlrow[$i] ." = ".$sqlinsert[$i].", ";
					   $sql .= " `level` = '".$level."' WHERE `level` = '".$level."';";
					   $db->sql_query($sql) or  btsqlerror($sql);
					   CloseTable();
					   }
?>