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
require_once("include/config.php");
if ($use_rsa) require_once("include/rsalib.php");
require_once("include/class.user.php");
if ($use_rsa) $rsa = New RSA($rsa_modulo, $rsa_public, $rsa_private);
$user = @new User($_COOKIE["btuser"]);
if (isset($btlanguage) AND is_readable("language/".$btlanguage.".php")) $language = $btlanguage;
if (isset($bttheme) AND is_readable("themes/".$bttheme."/main.php")) $theme = $bttheme;
if (is_readable("language/$language.php"))
        include_once("language/$language.php");
else
        include_once("language/english.php");

if (is_readable("themes/$theme/main.php")) {
        require_once("themes/$theme/main.php");
} else {
        die("You should not see this...");
}
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
$sql = "SELECT * FROM `".$db_prefix."_img_bucket` LIMIT 0, 30 ";
$res = $db->sql_query($sql);
$bucketrow = $db->sql_fetchrow($res);
$db->sql_freeresult($res);

echo"<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
echo"<html>\n";
echo"<head>\n";
echo"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
echo"<title>".$sitename."</title>\n";
if (is_readable("themes/$theme/style.css")) {
        echo "<link rel=\"StyleSheet\" href=\"$siteurl/themes/$theme/style.css\" type=\"text/css\"/>\n<script type=\"text/javascript\" src=\"$siteurl/global.js\"></script>\n";
}
echo"</head>\n\n";

echo"<body>\n";
if ($bucketrow["allow"]!='true')bterror(_btbuclosed,_btsorry);
if(!checkaccess("can_use_bitbucket")){
OpenErrTable(_btaccdenied);
echo "<p>".str_replace("**page**","Bit-Bucket",_btnoautherized)."</p>\n";
CloseErrTable();
die();
}
$access_level = $bucketrow["level"];
switch ($access_level) {
        case "user": {
                if (!$user->user) loginrequired("user");
                break;
        }
        case "premium": {
                if (!$user->premium) loginrequired("premium");
                break;
        }
        case "moderator": {
                if (!$user->moderator) loginrequired("moderator");
                break;
        }
        case "admin": {
                if (!$user->admin) loginrequired("admin");
                break;
        }
}

$max_size = $bucketrow['max_file_size'];          //maximum filesize71096
$outtopage = '';
OpenTable("Image Manager");
if (is_uploaded_file($attachment['tmp_name'])) {

if ($attachment['size'] > $max_size) {
OpenErrTable(_btgalitobig);
     echo("<p align='center'>"._btgalwitobig."</p>"); 
CloseErrTable();
die();
}
if (($attachment['type']=="image/gif") || ($attachment['type']=="image/bmp") || ($attachment['type']=="image/png") || ($attachment['type']=="image/pjpeg") || ($attachment['type']=="image/jpeg")) {

if(!is_dir("UserFiles/".$user->name)) @mkdir("UserFiles/".$user->name,0777);
if (GetFolderSize("UserFiles/".$user->name) > $bucketrow["max_folder_size"]) {
OpenErrTable(_btgalwful);
     echo("<p align='center'>"._btgalful."</p>"); 
CloseErrTable();
die();
	 }
     $res = copy($attachment['tmp_name'], "UserFiles/".$user->name .'/' .$attachment['name']);

     if (!$res) { 
	 die("<p align='center'>Did not work, please try again!</p>"); 
	 } else {
	 @chmod("UserFiles/".$user->name .'/' .$attachment['name'], 0777);

$upcount=1;
$outtopage = "window.opener.vB_Attachments.add(".$upcount.", '".$attachment['name']."', '".mksize($attachment['size'])."', '');";
preg_match_all('/imgsize=([^&]*)/i', $_SERVER["QUERY_STRING"], $imgsize_array);
$imgsize_array = str_replace('imgsize=','',$imgsize_array[0]);
preg_match_all('/img=([^&]*)/i', $_SERVER["QUERY_STRING"], $img_array);
$img_array = str_replace('img=','',$img_array[0]);
if (count($img_array) < 1)$allimage = "?img=".$attachment['name'];
else
$allimage = "?img=".implode("&amp;img=", $img_array)."&amp;img=".$attachment['name'];
}

foreach($img_array as $imgupd){
$upcount=$upcount+1;
$imgupsize = filesize("UserFiles/".$user->name."/".$imgupd);
//print_r($imgupsize);
$outtopage .= "window.opener.vB_Attachments.add(".$upcount.", '".$imgupd."', '".mksize($imgupsize)."', '');";
}
$outtopage .= "window.close();";
echo "<br>";
echo "File Name: ".$attachment['name']."<br>\n";
echo "File Size: ".$attachment['size']." <br>\n";
echo "File Type: ".$attachment['type']."<br>\n";
echo "</font>";
} else { 
OpenErrTable("Wrong File Type");
echo _btgaltyp; 
CloseErrTable();
exit; 
}

}
?>
<script type="text/javascript">
<!--
function fetch_object(idname)
{
	if (document.getElementById)
	{
		return document.getElementById(idname);
	}
	else if (document.all)
	{
		return document.all[idname];
	}
	else if (document.layers)
	{
		return document.layers[idname];
	}
	else
	{
		return null;
	}
}
//-->
</script>

<?php

echo"<form enctype=\"multipart/form-data\" action=\"bitbucket-upload.php".$allimage."\" method=\"POST\">\n";
echo"<p class=\"style1\" align=\"center\">\n";
echo"<div align=\"center\">\n";
echo"<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">\n";
echo"<tr>\n<td>\n<p align=\"center\">\n"._btuploadexpl."</p>\n</td>\n</tr>\n";
echo"<tr>\n";
echo"<td align=\"center\">\n";
echo"<input name=\"attachment\" type=\"file\" id=\"attachment\">\n";
echo"</td>\n";
echo"</tr>\n";
echo"<tr>\n";
echo"<td align=\"center\">\n";
echo"<input type=\"submit\" class=\"button\" name=\"upload\" value=\""._btupload."\" style=\"width:70px\" onclick=\"return verify_upload(this.form);\" />\n";
echo"</td>\n";
echo"</tr>\n";
echo"</table>\n";

echo"</div>\n";
echo"</p>\n";
echo"</form>\n";
echo"<div align=\"center\" id=\"uploading\" style=\"display:none; margin-top:6px\">\n";
echo"<strong>"._brupwait."</strong>\n";
echo"</div>\n";
echo"<script type=\"text/javascript\">
<!--

	function verify_upload(formobj)
	{
		var haveupload = false;
		for (var i=0; i < formobj.elements.length; i++)
		{
			var elm = formobj.elements[i];
			if (elm.type == 'file' || elm.type == 'text')
			{
				if (elm.value != \"\")
				{
					haveupload = true;
				}
			}
		}

		if (haveupload)
		{
			obj = fetch_object(\"uploading\");
			obj.style.display = \"\";
			return true;
		}
		else
		{
			alert(\""._btselecatt.".\");
			return false;
		}
	}


	if (typeof window.opener.vB_Attachments != 'undefined')
	{
		window.opener.vB_Attachments.reset();
		".$outtopage."

	}
//-->
</script>";
CloseTable();
$i = 0;
OpenTable(_btgalery);
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
echo"<tr>\n<td>\n<p align=\"center\">\n"._btgalexpl."</p>\n</td>\n</tr></table>\n";
echo"<br /><br /><br /><br />";
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
echo"<tr>\n";
$imgdir = "UserFiles/".$user->name; // the directory, where your images are stored
  $allowed_types = array('png','jpg','jpeg','gif'); // list of filetypes you want to show
if (!is_dir($imgdir))@mkdir($imgdir,0777);  
  $dimg = @opendir($imgdir);
  while($imgfile = @readdir($dimg))
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
   echo '<td align="center" width="16%"><a href="./'.$imgdir.'/'.$a_img[$x].'" target="_blank"><img width="60px" src="./'.$imgdir.'/'.$a_img[$x].'" alt="'.$a_img[$x].'" border="0"></a><br /><a  href="" onclick="window.opener.vB_Attachments.add('.$imagtotnum.', \''.$a_img[$x].'\', \''.mksize(filesize("./".$imgdir.'/'.$a_img[$x])).'\', \'\');">'.$a_img[$x].'</a>('.mksize(filesize("./".$imgdir.'/'.$a_img[$x])).')</td>';
                   if ($i == 4) {
                        echo "</tr><tr>";
                        $i = 0;
                }

  } 
echo "</tr>\n</table>\n";
  CloseTable();
echo"</body>\n";
echo"</html>";

?>