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
header("Content-Type: text/html; charset=utf-8");
function GetFolderSize($d ="." ) {
    // © kasskooye and patricia benedetto
    $h = @opendir($d);
    if($h==0)return 0;

    while ($f=readdir($h)){
        if ( $f!= "..") {
            $sf+=filesize($nd=$d."/".$f);
            if($f!="."&&is_dir($nd)){
                $sf+=GetFolderSize ($nd);
            }
        }
    }
    closedir($h);
    return $sf ;
} 
function num_files($directory='.'){
    if ($handle = opendir($directory)) {
        $numFiles = 0;
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $numFiles++;
            }
        }
        closedir($handle);
        return $numFiles;
    }
} 
if ($op == "imagesettings"){
if(isset($allow)) $allow = $allow;
else
$allow = "false";
        $sql = "INSERT INTO ".$db_prefix."_img_bucket (allow, level, max_folder_size, max_file_size) VALUES ('".$allow."', '".$level."', '".$max_folder_size."', '".$max_file_size."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_img_bucket;");
        $db->sql_query($sql);
        header("Location: admin.php?op=image-bucket&saved=1");
}
if ($op == "delimage"){
if (file_exists("./UserFiles/".$file."/".$name))@unlink("./UserFiles/".$file."/".$name);
echo"works";
if(!num_files("./UserFiles/".$file."/") > 0)@unlink("./UserFiles/".$file);
else
$userfile = $file;
}
if(!isset($userfile)){
$sql = "SELECT * FROM `".$db_prefix."_img_bucket` LIMIT 0, 30 ";
$res = $db->sql_query($sql);
$bucketrow = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
if (isset($saved)) {
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}

OpenTable("BitBucket Settings");
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
echo"<tr>\n";
echo"<td>\n";
echo "<form name=\"formdata\"method=\"POST\" action=\"admin.php\">\n";
	echo"<input name=\"op\" value=\"imagesettings\" type=\"hidden\">\n";
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
echo"<tr>\n";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),"With this You can allow or disallow access<br />To the BitBucket.","Allow Users Access");
echo"</td>";
echo "<td>Allow BitBucket</td>";
echo "<td align=\"right\"><input type=\"radio\" name=\"allow\" value=\"true\"";
if ($bucketrow['allow'] == "true") echo "checked";
echo" /></td>";
echo"</tr>\n<tr>\n";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),"Select the user Level wich can use the BitBucket!","Select Access Level");
echo"</td>";
echo "<td>BitBucket Access Level</td>";
echo "<td align=\"right\">";
                echo "<select name=\"level\">\n";
                        echo "<option ";
                        if ($bucketrow['level'] == "user") echo "selected";
                        echo " value=\"user\">User</option>\n";
                        echo "<option ";
                        if ($bucketrow['level'] == "premium") echo "selected";
                        echo " value=\"premium\">Premium</option>\n";
                        echo "<option ";
                        if ($bucketrow['level'] == "moderator") echo "selected";
                        echo " value=\"moderator\">Moderator</option>\n";
                        echo "<option ";
                        if ($bucketrow['level'] == "admin") echo "selected";
                        echo " value=\"admin\">Admin</option>\n";
                echo "</select>";
echo"</td>";
echo"</tr>\n<tr>\n";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),"Set the max size of folder the user is allowed to have in Bytes!","Max Folder Size");
echo "<td>Max Size Of User Folder</td>";
echo "<td align=\"right\">";
echo "<input type=\"text\" name=\"max_folder_size\" value=\"".$bucketrow['max_folder_size']."\" size=\"40\">";
echo"</td>";
echo"</tr>\n<tr>\n";
echo"<td width=\"16\">";
echo help(pic ("help.gif","",null),"Set the max size of a image a user can upload in Bytes","Max File Size");
echo "<td>Max Allowed Size of Image</td>";
echo "<td align=\"right\">";
echo "<input type=\"text\" name=\"max_file_size\" value=\"".$bucketrow['max_file_size']."\" size=\"40\">";
echo"</td>";
echo "</tr>\n</table>\n";
echo"</td>";
echo"</tr>\n<tr>\n";
echo"<td>";
echo"<input class=\"button\" value=\""._admsavebtn."\" type=\"submit\"><input value=\""._admresetbtn."\" type=\"reset\">\n";
echo"<form>\n";
echo"</td>";
echo "</tr>\n</table>\n";
CloseTable();
OpenTable("User Files");
        $themes = Array();
        $thememaindir = "UserFiles";
        $themehandle = opendir($thememaindir);
        while ($themedir = readdir($themehandle)) {
                if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
                        $themes[$themedir] = $themedir;
        }
        closedir($themehandle);
        unset($thememaindir,$themedir);
        $change = '';
		$change = "<table border=\"0\" width=\"100%\" cellspacing=\"1\"><tr>\n";
		$countusim = 0;
foreach ($themes as $key=>$val) {
        $countusim = $countusim+1;
        $change .= '<td><a href="admin.php?op=image-bucket&amp;userfile='.$val.'"><img src="admin/pics/userfile.png" alt="User Images" title="User Images" border="0"></a><br />'.$val."<br />Folder size: (".GetFolderSize("./UserFiles/".$val).") <br />Total Files: (".num_files("./UserFiles/".$val."/").')</td>';
		if($countusim == 5){
		$change .= "</tr><tr>";
		$countusim = 0;
		}

}
$change .= "</tr>\n</table>\n";
unset($themes);
echo $change;
CloseTable();
}else{
OpenTable("User Images");
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
echo"<tr>\n";
$imgdir = "UserFiles/".$userfile."/"; // the directory, where your images are stored
  $allowed_types = array('png','jpg','jpeg','gif'); // list of filetypes you want to show
  
  $dimg = opendir($imgdir);
  while($imgfile = readdir($dimg))
  {
   if(in_array(strtolower(substr($imgfile,-3)),$allowed_types))
   {
    $a_img[] = $imgfile;
    sort($a_img);
    reset ($a_img);
   }
  }
 $imagtotnum = 1; 
  $totimg = count($a_img); // total image number
   
  for($x=0; $x < $totimg; $x++)
  {
   $size = getimagesize($imgdir.'/'.$a_img[$x]);
   $i++;
  $imagtotnum = $imagtotnum + 1;
   // do whatever
   $halfwidth = ceil($size[0]/2);
   $halfheight = ceil($size[1]/2);
   echo "<td align=\"center\" >\n";
   echo'<a href="'.$siteurl.'/'.$imgdir.$a_img[$x].'" target="_blank"><img border="0" src="'.$siteurl.'/'.$imgdir.$a_img[$x]."\"  onLoad='SetSize(this, 100)'\"></a>\n";
   echo"<br />\n";
   echo $a_img[$x].'('.mksize(filesize("./".$imgdir.'/'.$a_img[$x])).")\n";
echo "<form name=\"formdata\"method=\"POST\" action=\"admin.php\">\n";
	echo"<input name=\"op\" value=\"delimage\" type=\"hidden\">\n";
	echo"<input name=\"file\" value=\"".$userfile."\" type=\"hidden\">\n";
	echo"<input name=\"name\" value=\"".$a_img[$x]."\" type=\"hidden\">\n";
echo "<table width=\"100%\">\n";
echo"<tr><td align=\"center\">\n";
echo"<input class=\"button\" value=\""._btimgdelete."\" type=\"submit\">\n";
echo"</td></tr>\n";
echo"</table>\n</form>\n";
   echo'</td>';
                   if ($i == 4) {
                        echo "</tr><tr>";
                        $i = 0;
                }

  } 
echo "</tr>\n</table>\n";
  CloseTable();
}
?>