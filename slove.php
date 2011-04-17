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
*------              ©2008 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   SAT, FEB 21, 2009 18:12 PM   ---------------------*
*/
include("header.php");
global $db, $db_prefix;
include'language/help.php';
if (isset($cid))
{
if($add_msg !="")$msg = $add_msg;
else
$msg = "Your ticket Catigory was changed  By ".$user->name." Please go to [url=".$siteurl."/slove.php?a=view&id=$tid]Help Desk[/url] to view this ticket";
      $db->sql_query("UPDATE `".$db_prefix."_helpdesk` SET  `category` = '".$cid."' WHERE `".$db_prefix."_helpdesk`.`id` =".$tid." LIMIT 1 ;");
	  if(isset($trans_alert))$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sent, sender, recipient, subject, text) VALUES (NOW(), 0, $z, 'Help Desk', '$msg')") ;
}
if (isset($rid))
{
$msg = "You have Been asigned a help ticket By ".$user->name." Please go to [url=".$siteurl."/slove.php?a=view&id=$tid]Help Desk[/url] to view this ticket";
      $db->sql_query("UPDATE `".$db_prefix."_helpdesk` SET `helper` = '$rid' WHERE `".$db_prefix."_helpdesk`.`id` =".$tid." LIMIT 1 ;");
      if(isset($trans_alert))$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sent, sender, recipient, subject, text) VALUES (NOW(), 0, $rid, 'Help Desk', '$msg')") ;
}
$html = array();
$html['option'] = '<option value="%s"%s>%s</option>';
$html['input'] = '<input type="%s" name="%s" value="%s"%s> %s';
$html['error'] = '<span id="err">%s</span>';
$html['end'] = '<a name="end"></a>';
$html['open']['submitmsg'] = '
<h3>' . LANG_OPENED_TICKET_SUBJECT . '</h3>
<p>' . nl2br(LANG_OPENED_TICKET_MSG) . '</p>
<p><a href="%s">%s</a></p>
';
if(!isset($id)){
OpenErrTable('Help desk');
echo "No id set.";
CloseErrTable();
exit();
}
$sql="SELECT * FROM ".$db_prefix."_helpdesk WHERE id='".$id."'";
$result=$db->sql_query($sql);
$rows=$db->sql_fetchrow($result);
//reps
$tmp = '';
if (($user->admin) || $user->id === $rows['helper'] || !$rows['helper'] === 0) {
    $query = mysql_query("SELECT * FROM ".$db_prefix."_users WHERE `helper` = 'true'");
    while ($array = mysql_fetch_array($query)) {
        $selected = ($array['id'] == $rows['helper']) ? ' SELECTED' : '';
        $tmp.= sprintf($html['option'], $array['id'], $selected, $array['username'] . $hidden) . "\n";
    }
    if (!empty($tmp)) $vars['reps'] = $tmp;
}
$tmp = '';
if ($user->admin) {
    $query = mysql_query("SELECT * FROM ".$db_prefix."_help_category");
    while ($array = mysql_fetch_array($query)) {
        $selected = ($array['id'] == $rows['category']) ? ' SELECTED' : '';
        $hidden = $array['hidden'] ? '*' : '';
        $tmp.= sprintf($html['option'], $array['id'], $selected, $array['name'] . $hidden) . "\n";
    }
    if (!empty($tmp)) $vars['cats'] = $tmp;
}
if(!$rows['answer'] == "")$rows['answer'] = "\n --------------------------------------------------------------\n".$rows['last_answer_help']."\n--------------------------------------------------------------\n".$rows['answer'];
?><style>
.msgBorderInfo { background-color:#999999; }
.mainTable { background-color: #666666; }
.msgBorder { background-color: #ADADAD;  margin-top: 10px; }
.inputsubmit {
	font-size: 11px;
	background: #EEB358 url("images/bgbar.gif");
	color: white;
	border: #A6A6A6 solid 1px;
}
option { padding-right: 5px; }
.inputsubmit2 {
	font-size: 11px;
	background-color: #FFFFFF; 
	color: #006699;
	border: #FFFFFF; 
	border-style: solid;
 	border-top-width: 1px; 
	border-right-width: 1px; 
	border-bottom-width: 1px; 
	border-left-width: 1px
}
.msgReceived { background-color: #E9E9E9; color: #3E3E3E; font-size: 10px; }
.msgBox { background-color: #F9F9F9; color: #000000;}
</style>
<table align="center" class="msgBorderInfo" cellspacing="1" cellpadding="3" width="100%" border="0">
	<tr>
		<td width="100" class="mainTable"><b>Ticket ID:</b></td>
		<td class="mainTable"><?php echo $rows['id']; ?></td>
	</tr>
	<tr>
		<td width="100" class="mainTable"><b>Status:</b></td>
		<td class="mainTable"><?php echo $rows['status']; ?></td>
	</tr>
	<tr>
		<td width="100" class="mainTable"><b>Date:</b></td>
		<td class="mainTable"><?php echo $rows['open_date']; ?></td>
	</tr>
	<tr>
		<td class="mainTable"><b>SUBJECT:</b></td>
		<td class="mainTable"><?php echo htmlspecialchars(stripslashes($rows['title'])); ?></td>
	</tr>
	<tr>
		<td class="mainTable"><b>Problem:</b></td>
		<td class="mainTable"><?php echo htmlspecialchars(stripslashes($rows['problem'])); ?></td>
	</tr>
	<?php /*if ($ticket->name !== $ticket->email): */?>
	<tr>
		<td class="mainTable"><b>User:</b></td>
		<td class="mainTable"><?php echo htmlspecialchars(stripslashes(username_is($rows['uid']))); ?></td>
	</tr>
	<tr>
		<td class="mainTable"><b>Priority:</b></td>
		<td class="mainTable"><?php echo $rows['priority']; ?></td>
	</tr>
   <tr>
   <td class="mainTable"><b>Representative:</b></td>
   <td class="mainTable">
    <?php
if ($vars['reps']) {
?>
     <form name="rep" action="" method="POST">
     <input type="hidden" name="a" value="transfer_rep">
       <input type="hidden" name="tid" value="<?php echo $rows['id']; ?>">
         <select name="rid">
             <?php echo $vars['reps']; ?>
         </select>
         <input type="checkbox" title="Send Alert?" name="trans_alert" checked>
         <input type="submit" name="submit_rep" value="Transfer" class="inputsubmit">
     </form>
     <?php
} else {
    echo htmlspecialchars(stripslashes(username_is($rows['helper'])));
}
?>
     </td>
  </tr>
</table>
<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%" border="0">
	<tr>
		<td width="100" class="mainTable"><b>Category:</b></td>
		<td class="mainTable">
			<?php if ($rows['category']) { ?>
		  <form name="transfer" action="<?php echo $form_action; ?>" method="POST">
			<input type="hidden" name="a" value="transfer">
			<input type="hidden" name="tid" value="<?php echo $rows['id']; ?>">
			<input type="hidden" name="z" value="<?php echo $rows['uid']; ?>">
      <table cellspacing="0" cellpadding="0" border="0">
      	<tr>
      		<td>
	          <select name="cid">
	    	    <?php echo $vars['cats']; ?>
	    	    </select>
    	    </td>
    	    <td>&nbsp;</td>
    	    <td>Optional Message:</td>
					<td><input type="text" size="20" name="add_msg"></td>
					<td>Send Alert?:</td>
					<td><input type="checkbox" title="Send Alert?" name="trans_alert" checked></td>
					<td><input type="submit" name="transfer" value="Transfer" class="inputsubmit"></td>
      	</tr>
      </table>
			</form>
			<?php
} else {
    echo $cat_row['name'];
}
?>
		</td>
	</tr>
</table>
<BR>
<?
$sql="SELECT * FROM ".$db_prefix."_help_responce WHERE `ticket`='".$id."' ORDER BY `".$db_prefix."_help_responce`.`time` ASC";
$res=$db->sql_query($sql);
    while($reply=$db->sql_fetchrow($res)) {

?>
<table align="center" class="msgBorder" cellspacing="1" cellpadding="3" width="100%%" border="0">
			<tr class="msgAnswered">
				<td class="msgAnswered">
					<b><?php echo username_is($reply['reps']); ?></b> <span class="datetime">(<?php echo $reply['time']; ?>)</span>
				</td>
			</tr>
			
			<tr class="msgBox">
				<td align="left">
				  <?php echo $reply['responce']; ?>
				</td>
			</tr>
</table>
<?php
}
?>
<div style="margin: auto">
  <form name="replyForm" action="takehelpans.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="a" value="post">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
		<table border="0" cellspacing="0" cellpadding="5">
			<tr> 
				<td valign="top">
					<div style="text-align: right" class="resizer">
						<a href="javascript:resizer(1,'d')" id="bigger"><?php echo LANG_BIGGER; ?></a>
						<a href="javascript:resizer(-1,'d')" id="smaller"><?php echo LANG_SMALLER; ?></a>
					</div>
					<textarea name="a_answer" id="d" cols="60" rows="8" wrap="soft"></textarea>
					<input type="hidden" id="textarea_next_time" name="textarea_next_time" value="8">
	      </td>
	      <td valign="top">
<script language="javascript" type="text/javascript">
	function setMessage() {
		var newmessage = document.replyForm.responses.value;
		document.replyForm.message.value += newmessage;
		document.replyForm.message.focus();
	}
function resizer(inc,eid) {
  var txtarea = document.getElementById(eid);
  if (inc==1) {
    txtarea.rows = txtarea.rows + 5;
  } else {
    txtarea.rows = txtarea.rows - 5;
  }
  document.getElementById("textarea_next_time").value=txtarea.rows;
}
var upload_number = 1;
function addFileInput(i) {
	if(upload_number > 10) { return; } //no more than 10
	var d = document.createElement("div");
	var l = document.createElement("a");
	var file = document.createElement("input");
	file.setAttribute("type", "file");
	file.setAttribute("name", "attachment"+upload_number);
	l.setAttribute("href", "javascript:removeFileInput('f"+upload_number+"');");
	l.appendChild(document.createTextNode("Remove"));
	d.setAttribute("id", "f"+upload_number);
	d.appendChild(file); d.appendChild(l);
	document.getElementById(i).appendChild(d); upload_number++;
}

function removeFileInput(i) {
	var elm = document.getElementById(i);
	document.getElementById("moreUploads").removeChild(elm);
	upload_number = upload_number - 1; // decrement the max file upload counter if the file is removed
}
</script>
<br>
	<input type="file" name="attachment" id="attachment" onchange="document.getElementById('moreUploadsLink').style.display = 'block';" />
	<div id="moreUploads"></div>
	<div id="moreUploadsLink" style="display:none;"><a href="javascript:addFileInput('moreUploads');">Attach another File</a></div>
<table>
<?php
if ($user->admin):
?>
		<tr>
			<td>&nbsp;
				
			</td>
		</tr>
		<tr>
			<td>
				<?php echo LANG_NEWSTATUS; ?> <select size="1" name="newstatus">
	<option <?php echo($rows['status'] == 'Solved') ? "selected" : "" ?> value="Solved">Solved</option>
	<option <?php echo($rows['status'] == 'Not Going To Solve') ? "selected" : "" ?> value="Not Going To Solve">Not Going To Solve</option>
	<option <?php echo($rows['status'] == 'Waiting On More Info') ? "selected" : "" ?> value="Waiting On More Info">Waiting On More Info</option>
	<option <?php echo($rows['status'] == 'New') ? "selected" : "" ?> value="New">New</option>
	<option <?php echo($rows['status'] == 'Inprogress') ? "selected" : "" ?> value="Inprogress">Inprogress</option>
                </select>
			</td>
		</tr>
		<tr>
            <td>
                <input class="inputsubmit" type="submit" name="change_status" value="<?php echo LANG_CHANGE_TICKET_STATUS; ?>">
            </td>
        </tr>
<?php
endif; // user admin

?>
		<tr>
			<td>&nbsp;
				
			</td>
		</tr>
		<tr>
			<td>
				<input class="inputsubmit" type="submit" name="submit" value="<?php echo LANG_REPLY_TO_MSG; ?>">
			</td>
		</tr>
<?php
if ($user->admin):
?>
	<tr>
		<td>
			<br>
			<input class="inputsubmit" type="submit" name="delete" value="<?php echo LANG_DELETE; ?>" onClick='if(confirm("<?php echo LANG_DELETE_CONFIRM; ?>")) return; else return false;'>
		</td>
	</tr>
<?php
endif; // user admin and access
if ($rows['solved']=='yes' AND ($user->id == $rows['uid'] OR $user->admin)):
?>
		<tr>
			<td>&nbsp;
				
			</td>
		</tr>
		<tr>
			<td>
				<input class="inputsubmit" type="submit" name="reopen" value="<?php echo LANG_REOPEN; ?>">
			</td>
		</tr>
<?php endif; ?>
</table>
<!-- reply buttons end -->

		</td>
	</tr>
</table>
</form>
<!-- replyform end -->
</div>
<div id="backtomain" style="margin: auto; text-align: center;"><a href="<?php echo $vars['backurl']; ?>"><?php echo LANG_BACK_TO_MAIN; ?></a></div>
<a name="end"></a>
<?php
include("footer.php");
?>
