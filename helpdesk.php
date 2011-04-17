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
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");
global $db, $db_prefix;
if(!isset($op)) $op="";
$sql="SELECT status FROM ".$db_prefix."_helpdesk";
$res=$db->sql_query($sql);
$pendin = $solved = $inprog = $not_go = $waiting = 0;
while ($ticket=$db->sql_fetchrow($res)) {
if($ticket['status']=='Solved')$solved = $solved+1;
if($ticket['status']=='Inprogress')$inprog = $inprog+1;
if($ticket['status']=='Not Going To Solve')$not_go = $not_go+1;
if($ticket['status']=='Waiting On More Info')$waiting = $waiting+1;
if($ticket['status']=='New')$pendin = $pendin+1;
}
$all_tik = $pendin + $solved + $inprog + $not_go + $waiting;
echo "<table cellpadding=\"0\"  cellspacing=\"0\" border=\"0\" width='100%'><tr><td width=\"50%\">";
OpenTable('Summary');
?>
<style media="screen">
.DashboardTable {border:1px solid #b2b2b2;border-bottom:1px solid #b2b2b2;padding:0; font:Arial, Helvetica, sans-serif; color:#000000!important;}
tr.summarylist_gradbg_3, .summarylist_gradbg_3 a {background:#FFF url(http://demo.servicedeskplus.com/images/summarylist_gradbg_3.gif) top repeat-x;height:71px;color:#000000!important;}
tr.summarylist_gradbg_3:hover {background:#ffe8e8 url(http://demo.servicedeskplus.com/images/summarylist_gradbghover_3.gif) top repeat-x;color:#000000;}
img.summary_duetoday, img.summary_duetoday_3 	{ background:url(http://demo.servicedeskplus.com/images/sdp-icons-pack1.gif) -157px -17px no-repeat; width:32px; height:32px; display:block;color:#000000; }
img.summary_overdue_icon, img.summary_overdue_icon_3	{ background:url(http://demo.servicedeskplus.com/images/sdp-icons-pack1.gif) -127px -17px no-repeat; width:32px; height:32px; display:block;color:#000000; }
img.summary_open, img.summary_open_3			{ background:url(http://demo.servicedeskplus.com/images/sdp-icons-pack1.gif) -188px -17px no-repeat; width:32px; height:32px; display:block;color:#000000; }
tr.summarylist_gradbg_7 td.myview-count {text-decoration:none;font:bold 11px Verdana, Arial, Helvetica, sans-serif!important;color:#000000;width:10%!important;padding:0 10px;}
</style>
<table cellpadding="0" class="DashboardTable" cellspacing="0" border="0" width='100%'>
	<tr class="DashboardTableColor" height="24">
		<th colspan='4'><nobr><b>My Summary</b></nobr></th>
	</tr>

<tr class="summarylist_gradbg_3">
	<td width="10%"><img src="/images/spacer.gif" border="0" hspace="5" class="summary_overdue_icon_3"></td>

	
			<td><a href="/problems.php?viewName=Pending">Pending Tickets</a></td>
			<td class='myview-count'><a href="/problems.php?viewName=Pending"><?php echo $pendin; ?></a></td>
			
	<td>&nbsp;</td>
</tr>
<tr class="summarylist_gradbg_3">
	<td width="10%"><img src="../images/spacer.gif" border="0" hspace="5" class="summary_duetoday_3"></td>
	
			<td><a href="/problems.php?viewName=Completed">Completed Tickets</a></td>
			<td class='myview-count'><a href="/problems.php?viewName=Completed"><?php echo $solved; ?></a></td>

			
	<td>&nbsp;</td>
</tr>
<tr class="summarylist_gradbg_3">
	<td width="10%"><img src="../images/spacer.gif" border="0" hspace="5" class="summary_open_3"></td>
	
			<td><a href="/problems.php?viewName=Inprogress">Inprogress</a></td>
			<td class='myview-count'><a href="/problems.php?viewName=Inprogress"><?php echo $inprog; ?></a></td>
			
	<td>&nbsp;</td>
</tr>
<tr class="summarylist_gradbg_3">
	<td width="10%"><img src="../images/spacer.gif" border="0" hspace="5" class="summary_open_3"></td>
	
			<td><a href="/problems.php?viewName=Waiting">Waiting On More Info</a></td>
			<td class='myview-count'><a href="/problems.php?viewName=Waiting"><?php echo $waiting; ?></a></td>
			
	<td>&nbsp;</td>
</tr>
<tr class="summarylist_gradbg_3">
	<td width="10%"><img src="../images/spacer.gif" border="0" hspace="5" class="summary_open_3"></td>
	
			<td><a href="/problems.php?viewName=Not">Not Going To Solve</a></td>
			<td class='myview-count'><a href="/problems.php?viewName=Not"><?php echo $not_go; ?></a></td>
			
	<td>&nbsp;</td>
</tr>
<tr class="summarylist_gradbg_3">
	<td width="10%"><img src="../images/spacer.gif" border="0" hspace="5" class="summary_open_3"></td>
	
			<td><a href="/problems.php?viewName=All_Requester">All Tickets</a></td>
			<td class='myview-count'><a href="/problems.php?viewName=All_Requester"><?php echo $all_tik; ?></a></td>
			
	<td>&nbsp;</td>
</tr>


</table>
<?php
CloseTable();
echo"</td><td width=\"50%\">";
$problem = trim($_POST["problem"]);
if ($op == "ticket" ){
$errmsg = Array();
if($title =="")$errmsg[] = 'No TiTle';
if($problem =="") $errmsg[] = 'No Problem listed';
if($category =="0")$errmsg[] = "Category Not Set";
if($priority =="0")$errmsg[] = "Priority Not Set";
if (count($errmsg) > 0)
        bterror($errmsg,'Help Ticket');
$upd_sql = "INSERT INTO ".$db_prefix."_helpdesk (`uid`, `title`, `problem`, `category`, `priority`, `open_date`) VALUES  ('".$user->id."', '".$title."', '".$problem."', ".$category.", '".$priority."', NOW())";
$db->sql_query($upd_sql) or btsqlerror($upd_sql);
$id = $db->sql_nextid();
$db->sql_query("INSERT INTO `phpMyBitTorrent`.`torrent_help_responce` (
`ticket` ,
`reps` ,
`responce`)
VALUES (
'".$id."', '".$user->id."', '".$problem."');");
echo "<meta http-equiv=\"refresh\" content=\"3;url=problems.php\">";
OpenSuccTable('Help desk');
echo "Message sent! Await for reply.";
CloseSuccTable();
exit();
   }
OpenTable("Open New Suport Ticket");
print("<center><a href=problems.php><h1>View Posted Tickerts</h1></a></center><br/>");
?>
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
</script>
<!-- Start Darks Help Desk -->
<center><font color=red size=2><blockquote>Before using <b>Our Help Desk</b> <br>make sure to read <a href=faq.php><b>FAQ</b></a> and search the <a href=phpBB.php><b>Forums</b></a> first!</blockquote></font><br/></center>
<center><font color="red"><h1>Darks Help Desk @2009 All Rights PMBT</h1></center></font>
<center><font color="red" size="2"><b>Please Note This Help Desk Is In The Testing Stage</b></font></center><br/>
<form method="post" action="helpdesk.php">
<input type="hidden" name="op" value="ticket" >
<table border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="left" width="150">Category: <font class="important">*</font></td>
	<td><select name="category">
	<option value="0">(Choose)</option>
	<option value="1">Uploading</option>
	<option value="2">DownLoading</option>
	<option value="3">Shouts</option>
	<option value="4">Forum</option>
	<option value="5">Other</option>
	</select>
	</td>
	</tr>
	<tr>

	<td align="left" width="150">Priority: <font class="important">*</font></td>
	<td><select name="priority">
	<option value="0">(Choose)</option>
	<option value="Low">Low</option>
	<option value="Medium">Medium</option>
	<option value="High">High</option>
	</select></td>
	</tr>
	<tr>
<td align="left">Title: <font class="important">*</font></td>
<td><input type="text" size="35" maxlength="60" name="title"></td>
</tr>
<tr>
<td align="left">Problem: <font class="important">*</font></td>
<td><textarea name="problem" id="message" cols="30" rows="6"></textarea>
			<div style="text-align: right" class="resizer">
				<a href="javascript:resizer(1,'message')" id="bigger">Bigger</a>
				<a href="javascript:resizer(-1,'message')" id="smaller">Smaller</a>
			</div>
</td>
</tr>
<tr>
<td><input type="submit" value="SEND" class="btn"></td>
</tr>
</table>
</form>

<?php
CloseTable();
echo"</td></tr></table>";
include("footer.php");
?>
