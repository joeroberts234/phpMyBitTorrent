<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
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

if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
include'include/textarea.php';
if($page=="pm"){
$sender_id = ($_POST['sender'] == 'system' ? 0 : $user->id);

$msg = $_POST['msg'];
if (!isset($message) OR empty($message)) $errmsg[] = _btpmnomessage;
if (!isset($subject) OR empty($subject)) $errmsg[] = _btpmnosubject;
if (count($errmsg) > 0) bterror($errmsg,_btnewpm);
if($level != "")$leveluser = "WHERE level = '".$level."'";
else
$leveluser = "";

$updateset = $_POST['level'];
$sql="SELECT id FROM ".$db_prefix."_users ".$leveluser.";";
$res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($res) < count($recipients)) bterror(_btpminvalidrecipients,_btnewpm);
while ($result = $db->sql_fetchrow($res)) {
	//Echo the ID of every user that is found
	echo $result['id'].'<BR>';
                $sql = "INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('".$sender_id."','".$result['id']."','".addslashes($subject)."','".addslashes($message)."',NOW());";
                $db->sql_query($sql) or btsqlerror($sql);

}
        OpenTable(_btnewpm);
        echo "<p align=\"center\">"._btpmsentsuccessfully."</p>\n";
        CloseTable();
include('footer.php');
die();

}
if ($page == "mail")
{
if($level != "")$leveluser = "level = '".$level."' AND";
else
$leveluser = "";
$res = "SELECT id, username, email FROM ".$db_prefix."_users WHERE ".$leveluser." ban = 0 AND active = 1 AND mass_mail = 'yes' ;" or btsqlerror($res);
$e_mail = $db->sql_query($res);
$from_email = "$admin_email"; //site email

$subject = substr(trim($subject), 0, 80);
if ($subject == "") $subject = "$sitename";
$subject = "$subject";

$message1 = trim($message);
if (!isset($message1) OR empty($message1)) $errmsg[] = _btpmnomessage;
if (count($errmsg) > 0) bterror($errmsg,_btnewpm);

$message1 = htmlspecialchars_decode(stripcslashes($message1));
//die($message1);
while($arr=$db->sql_fetchrow($e_mail)){
//die($arr["email"]);
$to = $arr["email"];
$user = $arr['username'];

$message = "Message received from $sitename on " . gmdate("Y-m-d H:i:s") . " GMT.\n" .
"---------------------------------------------------------------------\n\n" .
$message1 . "\n\n" .
"---------------------------------------------------------------------\nRegards,\n
$sitename Staff\n
$siteurl\n";
                $notify_mail = new eMail();
                $notify_mail->add($to);
                $notify_mail->sender = $admin_email;
                $notify_mail->subject = $subject;
                $notify_mail->body = $message;
                $notify_mail->send();

$success = true;

}


if ($success){
        OpenTable(_btnewpm);
        echo "<p align=\"center\">"._btpmsentsuccessfully."</p>\n";
        CloseTable();
		include('footer.php');
die();

}else{
bterror("<h3>"._admmassmailerror."</h3>", "Error");
include('footer.php');
die();

}
}

if($page=="sendpm"){

OpenTable (_admmasspmlong);
?>

<table class=main width=100% border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>
<div align=center>
<form name="formdata" method=post action=admin.php?op=staffmess&page=pm>
<table cellspacing=0 cellpadding=5>
<tr>
<?php
        echo "<tr><td><p>"._btaccesslevel."</p></td><td><p>";
        echo "<select name=\"level\">";
		echo "<option value=\"\">"._admmassmailall."</option>";
        echo "<option value=\"user\">"._btclassuser."</option>";
        echo "<option value=\"premium\">"._btclasspremium."</option>";
        echo "<option value=\"moderator\">"._btclassmoderator."</option>";
        echo "<option value=\"admin\">"._btclassadmin."</option>";
        echo "</select>";
        echo "</p></td></tr>";
        echo "</td></tr>\n";
        echo "<tr><td><hr /></td><td></td></tr>\n";
        echo "<tr><td><p>"._btpmsub."</p></td><td><p><input type=\"text\" name=\"subject\" size=\"60\" value=\"".$replysub."\" /></p>\n</td>\n</tr>\n";
        echo "<tr><td><p>"._btpmtext."</p></td><td>";
echo $textarea->quick_bbcode('formdata','message');
echo $textarea->input('message');
        echo "</table></td></tr>\n";
?>
<tr>
<td colspan=2><div align="center"><b>Sender:&nbsp;&nbsp;</b>
<?=getusername($btuser)?>
<input name="sender" type="radio" value="self" checked>
&nbsp; System
<input name="sender" type="radio" value="system">
</div></td></tr>
<tr><td colspan=2 align=center><input type=submit value="Send" class=btn></td></tr>
</table>
<input type=hidden name=receiver value=<?=$receiver?>>
</form>

 </div></td></tr></table>

<?

CloseTable();
include('footer.php');
die();
}

if($page=="sendmail"){
OpenTable(_admmmsendto);
?>

<p><table border=0 class=main cellspacing=0 cellpadding=0><tr>
<td class=embedded><img src=/themes/<?php echo "".$theme.""; ?>/pics/pm_write.png></td>
<td class=embedded style='padding-left: 10px'><font size=3><b><?php echo""._btmmsendto."";?></b></font></td>
</tr></table></p>
<table border=1 cellspacing=0 cellpadding=5>
<form method=post action=admin.php?op=staffmess&page=mail>
<!--<tr><td class=rowhead>Your name</td><td><input type=text name=from size=80></td></tr>-->
<?php
        echo "<tr><td><p>"._btaccesslevel."</p></td><td><p>";
        echo "<select name=\"level\">";
		echo "<option value=\"\">"._admmassmailall."</option>";
        echo "<option value=\"user\">"._btclassuser."</option>";
        echo "<option value=\"premium\">"._btclasspremium."</option>";
        echo "<option value=\"moderator\">"._btclassmoderator."</option>";
        echo "<option value=\"admin\">"._btclassadmin."</option>";
        echo "</select>";
        echo "</p></td></tr>";

?>

<!--<tr><td class=rowhead>Your e-mail</td><td><input type=text name=from_email size=80></td></tr>-->
<tr><td class=rowhead><?php echo ""._btpmsub."";?></td><td><input type=text name=subject size=80></td></tr>
<tr><td class=rowhead><?php echo""._btmmbody."";?></td><td><textarea name=message cols=80 rows=20></textarea></td></tr>
<tr><td colspan=2 align=center><input type=submit value="<?php echo ""._btfsend."";?>" class=btn></td></tr>

</form>
</table>
<?php
echo "<p><b>"._btmmlinks."</b></p>";
CloseTable();
include('footer.php');
die();
}
OpenTable(_admmassmessage);
echo "<table border=\"0\" width=\"100%\" cellspacing=\"1\"><tr>\n";
adminentry("massmail","staffmess&page=sendmail",_admmassmail, "staff");
$op_keys = explode(",","massmail");
adminentry("massmail","staffmess&page=sendpm",_admmasspm, "staff");
$op_keys = explode(",","staffmess");
echo"</tr>\n</table>\n";
CloseTable();
?>
