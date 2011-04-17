<?php if (!defined('IN_PMBT')) exit; ?><table class="tablebg" width="100%" cellspacing="0">

<tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnGeneral');"><img title="Expand item" id="nnGeneralimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>General
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnGeneral">
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="forumline" align="center">
<tr><td class="row2" width="100%"><a href="index.php">Index </a></td></tr>
<tr><td class="row1" width="100%"><a href="rules.php">Rules</a></td></tr>
<tr><td class="row2" width="100%"><a href="faq.php">FAQ'S</a></td></tr>

<tr><td class="row1" width="100%"><a href="forums.php">Forum</a></td></tr>
<tr><td class="row1" width="100%"><a href="chat.php">IRC Chat</a></td></tr>
<tr><td class="row1" width="100%"><a href="mytorrents.php">Your Torrents</a></td></tr>
<tr><td class="row1" width="100%"><a href="torrents.php">Browse</a></td></tr>
<tr><td class="row1" width="100%"><a href="pm.php"><span id="nopm_notif">Private Messages</span></a></td></tr>
<tr><td class="row1" width="100%"><a href="user.php?op=profile&amp;id=<?php echo (isset($this->_rootref['S_USER_ID'])) ? $this->_rootref['S_USER_ID'] : ''; ?>">User Control Panel</a></td></tr>
<tr><td class="row1" width="100%"><a href="memberslist.php">Members List</a></td></tr>
<?php if ($this->_rootref['U_USER']) {  ?><tr><td class="row1" width="100%"><a href="user.php?op=logout">Log Out</a></td></tr><?php } ?>
<tr><td class="row1" width="100%"><a href="games.php">Games</a></td></tr>

<tr><td class="row1" width="100%"><a href="viewrequests.php">View Requests</a></td></tr>
<tr><td class="row1" width="100%"><a href="offers.php">Torrents Offered</a></td></tr>
<tr><td class="row1" width="100%"><a href="helpdesk.php">Help Desk</a></td></tr>
<tr><td class="row2" width="100%"><a href="youtube.php">Video's</a></td></tr>
<?php if ($this->_rootref['U_ADMIN']) {  ?><tr><td class="row1" width="100%"><a href="admin.php">Administration</a></td></tr><?php } ?>
</table>
</div>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</table>

<br clear="all" >
<table class="tablebg" width="100%" cellspacing="0">
<tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnDonations');"><img title="Expand item" id="nnDonationsimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>Donations
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnDonations">
<p class="donation" align="center" ><br><?php echo ((isset($this->_rootref['L__btdonationsprogress'])) ? $this->_rootref['L__btdonationsprogress'] : ((defined('_btdonationsprogress')) ? _btdonationsprogress : '{ _btdonationsprogress }')); ?></p>

<table class=main border=0 width=144px>
<tr>

<td style='padding: 0px; background-image: url(images/loadbarbg.gif); background-repeat: repeat-x'><?php echo (isset($this->_rootref['DONATION_IMAGE'])) ? $this->_rootref['DONATION_IMAGE'] : ''; ?>
<br>
<p class="donation" align="center" ><?php echo (isset($this->_rootref['DONATION_PERC'])) ? $this->_rootref['DONATION_PERC'] : ''; ?>%</p>
</td>
</tr>
</table><p class="donation"> <?php echo ((isset($this->_rootref['L__btdonationsgoal'])) ? $this->_rootref['L__btdonationsgoal'] : ((defined('_btdonationsgoal')) ? _btdonationsgoal : '{ _btdonationsgoal }')); ?> 
<font color="red"><?php echo (isset($this->_rootref['DONATION_ASKED'])) ? $this->_rootref['DONATION_ASKED'] : ''; ?></font><br>
 <?php echo ((isset($this->_rootref['L__btdonationscollected'])) ? $this->_rootref['L__btdonationscollected'] : ((defined('_btdonationscollected')) ? _btdonationscollected : '{ _btdonationscollected }')); ?> 
 <font color="green"><?php echo (isset($this->_rootref['DONATION_IN'])) ? $this->_rootref['DONATION_IN'] : ''; ?></font>
 </p>
<br><br>

<B><font color=red>&raquo;</font></B>
<a href="donate.php"><?php echo ((isset($this->_rootref['L__btdonationsdonate'])) ? $this->_rootref['L__btdonationsdonate'] : ((defined('_btdonationsdonate')) ? _btdonationsdonate : '{ _btdonationsdonate }')); ?></a><br></div>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</table>
<br clear="all" >
</div></td>
<td width="65%" valign="top">
<div id="center">