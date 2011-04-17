<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 06, 2009 9:05 PM   ---------------------*
*/
//die();
include'header.php';
							
function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $path.$filename;
	//die($file);
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    if (mail($mailto, $subject, "", $header)) {
        echo "go<br>"; // or use booleans here
    } else {
        echo "no go<br>";
    }
}


/* backup the db OR just a table */
function backup_tables($tables = '*',$struc=false,$data=false,$name='backup')
{
        global $db;
	
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = $db->sql_query('SHOW TABLES');
		while($row = $db->sql_fetchrow($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = $db->sql_query('SELECT * FROM '.$table);
		$num_fields = $db->sql_numfields($result);
		
		if($struc)$return.= 'DROP TABLE '.$table.';';
		$row2 = $db->sql_fetchrow($db->sql_query('SHOW CREATE TABLE '.$table));
		if($struc)$return.= "\n\n".$row2[1].";\n\n";
		
		if($data){
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = $db->sql_fetchrow($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		}
		$return.="\n\n\n";
	}
	
	//save file
	$handle = fopen('./backups/'.$name.'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}

if(isset($do) && $do == "budb")
{
if($type == 'full'){
$struc=true;
$data=true;
}
if($type == 'data'){
$struc=false;
$data=true;
}
if($type == 'structure'){
$struc=true;
$data=false;
}
 $today = getdate();
 $day = $today['mday'];
 if ($day < 10) {
    $day = "0$day";
 }
 $month = $today['mon'];
 if ($month < 10) {
    $month = "0$month";
 }
 $year = $today['year'];
 $hour = $today['hours'];
 $min = $today['minutes'];
 $sec = "00";
$name = $db_name."-".$day."-".$month."-".$year;
backup_tables($tables,$struc,$data,$name);
$zippath = './backups';
if($method =='rar')
{
$method2 = 'gzip';
$method = 'gz';
}elseif($method =='zip')
{
$method2 ='zip';
}else{
$method2 = 'sql';
}
ob_start();
ob_implicit_flush(0);
$zipname = "$zippath/$name.$method";
if($method != 'text')passthru("nice -n 16 $method2 -q -r $zipname $zippath ");
if($method != 'text')@unlink("$zippath/$name.sql");
	if($where == 'download'){
	$name = $name.(($method == 'zip')? '': ".sql").(($method == 'text')? '': ".$method");
	$backup = $zippath.'/'.$name;
	$confermation = md5($user->name.$user->act_key.$name);
echo "<meta http-equiv=\"refresh\" content=\"3;url=admindownload.php?backup=" . $backup."&name=".$name."&method=".$method."&conferm=".$confermation."\">";
	}
OpenSuccTable("Backup Completed Succes fully");
if($where == 'download')echo "Your Back Was Succes Fully Complete download well begin shortly";
else
echo "Your Back Was Succes Fully Complete";
CloseSuccTable();
}
if(isset($do) && $do == "bufile"){
 $today = getdate();
 $day = $today['mday'];
 if ($day < 10) {
    $day = "0$day";
 }
 $month = $today['mon'];
 if ($month < 10) {
    $month = "0$month";
 }
 $year = $today['year'];
 $hour = $today['hours'];
 $min = $today['minutes'];
 $sec = "00";
$zipfile = $db_name."-".$day."-".$month."-".$year.(($method2 == 'rar')? '.tar':'.zip');
$path = "./";
$zippath = './backups';
$zip_split_size = 1024 * 1024 *9;
$zipname = "$zippath/$zipfile";
$zipname2 = "$zippath/$zipfile.gz";
$archive = "$zippath/$zipfile";
$directory = "$path";
//die($zipname);
if($method2 == 'rar' AND !$where2 == 'email'){ 
exec( "tar cf $archive $directory");
exec( "gzip $archive");
}else{
passthru("nice -n 16 zip -q -r $zipname $path ");
}
if (file_exists($zipname)==false){
exit ("<h4><center><font color=\"#FF0000\">Server failed to $zipname to $path! <br><br>Hint: Make sure $zippath directory is CHOMD 777 and $path path exists.<br>Quiting... :( </font></center></h4>") ;
}
	if($where == 'download'){
	$name = $zipfile;
	$backup = $zippath.'/'.$name;
	$confermation = md5($user->name.$user->act_key.$name);
//echo "<meta http-equiv=\"refresh\" content=\"3;url=admindownload.php?backup=" . $backup."&name=".$name."&method=".$method."&conferm=".$confermation."\">";
	}
	//$zipname = "$zippath/$zipfile.zip";
	//die("zipsplit -t -n $zip_split_size -b $zippath $zipname ");
$EstimateSplittedFiles = intval(exec("zipsplit -t -n $zip_split_size -b $zippath $zipname "));
echo $EstimateSplittedFiles ;
die();
@unlink ($zipname2);
$EstimateSplittedFilesw = 10;
$i = 0;
while (file_exists("$zippath/backup_".(($i == 0 || $i == 1 || $i == 2 || $i == 3 || $i == 4 || $i == 5 || $i == 6 || $i == 7 || $i == 8 || $i == 9 )? '0' : '') .  $i))
{
rename("$zippath/backup_".(($i == 0 || $i == 1 || $i == 2 || $i == 3 || $i == 4 || $i == 5 || $i == 6 || $i == 7 || $i == 8 || $i == 9 )? '0' : '').  $i, "$zippath/backup_" .  ($i+1) .".gz");
$i++;
$my_file = "backup_" .  $i.".gz";
$my_path = "$zippath/";
$my_name = $sitename;
$my_mail = $admin_email;
$my_replyto = $admin_email;
$my_subject = "This is a mail with attachment.";
$my_message = "Hallo,\r\ndo you like this script? I hope it will help.\r\n\r\ngr. Olaf";
//mail_attachment($my_file, $my_path, "joeroberts@jungle-pirate.com", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
//unlink ("$zippath/backup_" .  $i.".tar.gz");


				ob_flush;
}
/*while (file_exists("$zippath/backup_" . FormatFileNumber($i) ))
{
echo "backup_" . FormatFileNumber($i) ."gz<br>";
				//rename("$zippath/backup_" . FormatFileNumber($i), "backup_" . FormatFileNumber($i) ."gz");
				}
        $themehandle = opendir("backups");
        while ($themedir = readdir($themehandle)) {
                if ($themedir != $zipfile.".gz" AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
				{
rename("$zippath/$themedir", "$zippath/$themedir.gz");
$my_file = "$themedir.gz";
$my_path = "$zippath/";
$my_name = "Olaf Lederer";
$my_mail = $admin_email;
$my_replyto = $admin_email;
$my_subject = "This is a mail with attachment.";
$my_message = "Hallo,\r\ndo you like this script? I hope it will help.\r\n\r\ngr. Olaf";
mail_attachment($my_file, $my_path, "joeroberts234@yahoo.com", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
}
@unlink("$zippath/$themedir.gz");
				flush;
        }
        closedir($themehandle);*/
//exec("split –verbose –bytes=8m -d $zippath/phpmybittorrent-27-01-2010.tar.gz bac_");

//$EstimateSplittedFiles = intval(exec("split -b $zip_split_size  $archive Split"));

//if ($EstimateSplittedFiles<=0){
//exit ("<h4><center><font color=\"#FF0000\">Server failed to split zip file $zipname! <br>Try to increase desired spilt size in \$zip_split_size variable.<br>Quiting... :( </center></h4>") ;
//}
/*
echo ("<h4><center>Estimated number of splitted files: " . $EstimateSplittedFiles .
				"</center></h4> <br>");
echo ("<h4><center>Splitting zip file: $zipname</center></h4> <br>");
echo ("<center>");
exec("nice -n 16 zipsplit -n $zip_split_size -b $zippath $zipname ");
echo ("</center> <br>");
die();*/
}
echo "<div>\n";
OpenTable('Backup Data Base');
OpenMessTable();
echo "<p>Here you can backup all your site data. You may store the resulting archive in your <samp>backups/</samp> folder or download it directly. Depending on your server configuration you may be able to compress the file in a number of formats.</p>\n";
CloseMessTable();
?>
	<script type="text/javascript">
	// <![CDATA[

		function selector(bool)
		{
			var table = document.getElementById('table');

			for (var i = 0; i < table.options.length; i++)
			{
				table.options[i].selected = bool;
			}
		}

	// ]]>
	</script>
	<form id="acp_backup" method="post" action="./backup-database.php">
	<input name="op" type="hidden" id="backup" value="backup">
	<input name="do" type="hidden" id="backup" value="budb">
	<fieldset style="margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; ">
		<legend style="padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: 1.6em;font-weight: bold;color: #CC0000;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;">Backup options</legend>
	<dl style="margin-bottom: 10px;font-size: 0.85em;">
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="type">Backup type:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
		    <label><input type="radio" class="radio" name="type" value="full" id="type" checked="checked" /> Full</label>
			<label><input type="radio" name="type" class="radio" value="structure" /> Structure only</label>
			<label><input type="radio" class="radio" name="type" value="data" /> Data only</label></dd>

	</dl>
	<dl style="margin-bottom: 10px;font-size: 0.85em;">
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="method">File type:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
		<label><input name="method" id="method" checked="checked" type="radio" class="radio" value="rar" /> rar</label>
		<label><input name="method" type="radio" class="radio" value="zip" /> zip</label>
		<label><input name="method" type="radio" class="radio" value="text" /> text</label>
		</dd>
	</dl>
	<dl>
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="table">Table select:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
		<select id="table" name="tables[]" size="10" multiple="multiple">
<?php
$result = $db->sql_query('SHOW TABLES');
		while($row = $db->sql_fetchrow($result))
		{
			echo "<option value=\"".$row[0]."\">".$row[0]."</option>
";
		}
?>		
		</select></dd>
		<dd><a href="#" onclick="selector(true); return false;">Select all</a> :: <a href="#" onclick="selector(false); return false;">Deselect all</a></dd>
	</dl>
	<dl style="margin-bottom: 10px;font-size: 0.85em;">
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="where">Action:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
			<label><input id="where" type="radio" class="radio" name="where" value="store" checked="checked" /> Store file locally</label>

			<label><input type="radio" class="radio" name="where" value="download" /> Download</label>
		</dd>
	</dl>

	<p class="submit-buttons">
		<input class="button1" type="submit" id="submit" name="submit" value="Submit" />&nbsp;

		<input class="button2" type="reset" id="reset" name="reset" value="Reset" />
	</p>
	
	</fieldset>
	</form>
	
<?php
CloseTable();
OpenTable('Backup Files');
OpenMessTable();
echo "<p>Here you can backup all your site Files. You may store the resulting archive in your <samp>backups/</samp> folder or download it directly. Depending on your server configuration you may be able to compress the file in a number of formats.</p>\n";
CloseMessTable();
?>
	
	<form id="acp_backup" method="post" action="./backup-database.php">
	<input name="op" type="hidden" id="backup" value="backup">
	<input name="do" type="hidden" id="backup" value="bufile">
	<fieldset style="margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; ">
		<legend style="padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: 1.6em;font-weight: bold;color: #CC0000;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;">Backup options</legend>
	<dl style="margin-bottom: 10px;font-size: 0.85em;">
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="method">File type:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
		<label><input name="method2" id="method" checked="checked" type="radio" class="radio" value="rar" /> rar</label>
		<label><input name="method2" type="radio" class="radio" value="zip" /> zip</label>

		</dd>
	</dl>
	<dl style="margin-bottom: 10px;font-size: 0.85em;">
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="where">Action:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
			<label><input id="where" type="radio" class="radio" name="where2" value="store" checked="checked" /> Store file locally</label>
			<label><input type="radio" class="radio" name="where2" value="download" /> Download</label>
			<label><input type="radio" class="radio" name="where2" value="email" /> e-mail(this well send you several emails as it well need to break your file down to atach able sizes)</label>
		</dd>
	</dl>
	<dl style="margin-bottom: 10px;font-size: 0.85em;">
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="where">E_mail address:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
			<label>
			<input name="addy" type="text" id="addy" value="addy">
			</textarea></label>
		</dd>
	</dl>
	<p class="submit-buttons">
		<input class="button1" type="submit" id="submit" name="submit" value="Submit" />&nbsp;

		<input class="button2" type="reset" id="reset" name="reset" value="Reset" />
	</p>
	
	</fieldset>
	</form>

<?php
CloseTable();
OpenTable('Backup ALL');
OpenMessTable();
echo "<p>Here you can backup Every thing. You may store the resulting archive in your <samp>backups/</samp> folder or download it directly. Depending on your server configuration you may be able to compress the file in a number of formats.</p>\n";
CloseMessTable();
?>

	<form id="acp_backup" method="post" action="./backup-database.php">
	<input name="op" type="hidden" id="backup" value="backup">
	<input name="do" type="hidden" id="backup" value="buall">
	<fieldset style="margin: 15px 0; padding: 10px; border-top: 1px solid #D7D7D7; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #D7D7D7; background-color: #FFFFFF; position: relative; ">
		<legend style="padding: 1px 0;font-family: Tahoma,arial,Verdana,Sans-serif;font-size: 1.6em;font-weight: bold;color: #CC0000;margin-top: -.4em;position: relative;text-transform: none;line-height: 1.2em;top: 0;vertical-align: middle;">Backup options</legend>
	<dl style="margin-bottom: 10px;font-size: 0.85em;">
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="method">File type:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
		<label><input name="method" id="method" checked="checked" type="radio" class="radio" value="rar" /> rar</label>
		
		<label><input name="method" type="radio" class="radio" value="bzip2" /> zip</label>

		</dd>
	</dl>
	<dl style="margin-bottom: 10px;font-size: 0.85em;">
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="where">Action:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
			<label><input id="where" type="radio" class="radio" name="where" value="store" checked="checked" /> Store file locally</label>
			<label><input type="radio" class="radio" name="where" value="download" /> Download</label>
			<label><input type="radio" class="radio" name="where" value="email" /> e-mail(this well send you several emails as it well need to break your file down to atach able sizes)</label>
		</dd>
	</dl>
	<dl style="margin-bottom: 10px;font-size: 0.85em;">
		<dt style="width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;"><label for="where">E_mail address:</label></dt>
		<dd style="margin: 0 0 0 45%;padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;vertical-align: top;font-size: 1.00em;">
			<label>
			<input name="addy" type="text" id="addy" value="addy">
			</textarea></label>
		</dd>
	</dl>
	<p class="submit-buttons">
		<input class="button1" type="submit" id="submit" name="submit" value="Submit" />&nbsp;

		<input class="button2" type="reset" id="reset" name="reset" value="Reset" />
	</p>
	
	</fieldset>
	</form>
<?php
CloseTable();
echo "</div>\n";
include'footer.php';

?>
