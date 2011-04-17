<?
//set these variables-----------------------------------------------------------------
$domain = "torrentdreamz.org";      //your domainname
$path = "bitbucket/";   //path to your targetfolder
$path_after_domain = "bitbucket/";   //path to your targetfolder for use in url
$max_size = 50000;          //maximum filesize
//------------------------------------------------------------------------------------
?>

<FORM ENCTYPE="multipart/form-data" ACTION="bitbucket-upload.php" METHOD="POST">
    <p class="style1 " align="center">
 <div align="center">
 <table border=0 cellspacing=0 cellpadding=0 width="33">
       <tr>
        <p class="style1 " align="center"> <td class=rowhead align="center">
     <p class="style1 " align="center"><p align="center"><INPUT NAME="userfile" TYPE="file" id="userfile">            </td>
       </tr>
       <tr>
         <p class="style1 " align="center"><td align=center><input name="submit" type="submit" id="submit" value="Upload">          </td>
       </tr>
     </table>

 </div>
<?

if (!isset($HTTP_POST_FILES['userfile']));

if (is_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'])) {

if ($HTTP_POST_FILES['userfile']['size']>$max_size) {
     echo "<p align='center'>File size is too large!</p><br>\n"; }
if (($HTTP_POST_FILES['userfile']['type']=="image/gif") || ($HTTP_POST_FILES['userfile']['type']=="image/png") || ($HTTP_POST_FILES['userfile']['type']=="image/pjpeg") || ($HTTP_POST_FILES['userfile']['type']=="image/jpeg")) {

if(!is_dir("UserFiles/"$user->name)) mkdir("UserFiles/"$user->name);
     $res = copy($HTTP_POST_FILES['userfile']['tmp_name'], "UserFiles/"$user->name .'/' .$HTTP_POST_FILES['userfile']['name']);

     if (!$res) { echo "<p align='center'>Did not work, please try again!</p><br>\n"; } else {
?>
<br>
<p>
<br>Direct Link:<br><a href="http://<? echo $domain; ?>/<? echo $path_after_domain; ?><? echo $HTTP_POST_FILES['userfile']['name']; ?>" target="_blank">http://<? echo $domain; ?>/<? echo $path_after_domain; ?><? echo $HTTP_POST_FILES['userfile']['name']; ?></a>
<br>HTML Code:<br>&lt;img src=&quot;http://<? echo $domain; ?>/<? echo $path_after_domain; ?><? echo $HTTP_POST_FILES['userfile']['name']; ?>&quot;&gt;
<br>Forum Code:<br>[img]http://<? echo $domain; ?>/<? echo $path_after_domain; ?><? echo $HTTP_POST_FILES['userfile']['name']; ?>[/img]
</p>
<?
}
echo "<br>";
echo "File Name: ".$HTTP_POST_FILES['userfile']['name']."<br>\n";
echo "File Size: ".$HTTP_POST_FILES['userfile']['size']." bytes<br>\n";
echo "File Type: ".$HTTP_POST_FILES['userfile']['type']."<br>\n";
echo "</font>";
echo "<br><br><img src=\"http://".$domain."/".$path_after_domain.$HTTP_POST_FILES['userfile']['name']."\">";
} else { echo "You may only upload file types with the extensions .gif / .jpg / .rar"; exit; }

}
?>