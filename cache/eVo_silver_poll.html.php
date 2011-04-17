<?php if (!defined('IN_PMBT')) exit; ?><table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">

<div class="cap-right">
<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nnPolls');"><img title="Expand item" id="nnPollsimg" src="themes/eVo_silver/pics/minus.gif" alt="+"></a>Polls
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td class="row3"><div id="nnPolls">
<?php if ($this->_rootref['U_MODERATOR']) {  ?>
<div align="right">
<font class="small"><?php echo ((isset($this->_rootref['L__btpolls_polls_mod'])) ? $this->_rootref['L__btpolls_polls_mod'] : ((defined('_btpolls_polls_mod')) ? _btpolls_polls_mod : '{ _btpolls_polls_mod }')); ?>
 - [<a class="altlink" href="makepoll.php?returnto=main"><b><?php echo ((isset($this->_rootref['L__bt_faq_new'])) ? $this->_rootref['L__bt_faq_new'] : ((defined('_bt_faq_new')) ? _bt_faq_new : '{ _bt_faq_new }')); ?></b></a>]
 - [<a class="altlink" href="makepoll.php?action=edit&amp;pollid=<?php echo (isset($this->_rootref['POLL_ID'])) ? $this->_rootref['POLL_ID'] : ''; ?>&amp;returnto=main"><b><?php echo ((isset($this->_rootref['L__btshout_edit'])) ? $this->_rootref['L__btshout_edit'] : ((defined('_btshout_edit')) ? _btshout_edit : '{ _btshout_edit }')); ?></b></a>]
 - [<a class="altlink" href="polls.php?action=delete&amp;pollid=<?php echo (isset($this->_rootref['POLL_ID'])) ? $this->_rootref['POLL_ID'] : ''; ?>&amp;returnto=main"><b><?php echo ((isset($this->_rootref['L__btshout_deleteed'])) ? $this->_rootref['L__btshout_deleteed'] : ((defined('_btshout_deleteed')) ? _btshout_deleteed : '{ _btshout_deleteed }')); ?></b></a>]
</font>
 </div>
 <?php } ?>
<table align="center" border="1" cellpadding="2" cellspacing="2"><tbody><tr><td class="text">
<?php if ($this->_rootref['POLL_LOCKED']) {  ?>
<p align="center"><b><?php echo (isset($this->_rootref['POLL_QUESTION'])) ? $this->_rootref['POLL_QUESTION'] : ''; ?></b></p>
<?php if ($this->_rootref['POLL_VOTED']) {  ?>
<table border="1" cellpadding="2" cellspacing="2">
<tbody>
<?php $_poll_var_answered_count = (isset($this->_tpldata['poll_var_answered'])) ? sizeof($this->_tpldata['poll_var_answered']) : 0;if ($_poll_var_answered_count) {for ($_poll_var_answered_i = 0; $_poll_var_answered_i < $_poll_var_answered_count; ++$_poll_var_answered_i){$_poll_var_answered_val = &$this->_tpldata['poll_var_answered'][$_poll_var_answered_i]; ?>
<tr><td width="1%"><nobr><?php echo $_poll_var_answered_val['P_ANSWER']; ?>&nbsp;&nbsp;</nobr></td><td width="99%"><img src="http://p2p-evolution.com/images/bar_left.gif"><img src="http://p2p-evolution.com/images/bar.gif" width="<?php echo $_poll_var_answered_val['P_IMAGE_W']; ?>" height="9"><img src="http://p2p-evolution.com/images/bar_right.gif"> <?php echo $_poll_var_answered_val['ANSWER_VOTES']; ?>%</td></tr>
<?php }} ?>
</tbody></table>
<p align="center">Votes: <?php echo (isset($this->_rootref['POLL_VOTE_COUNT'])) ? $this->_rootref['POLL_VOTE_COUNT'] : ''; ?><br>
[<a class="altlink" href="polloverview.php"><b><?php echo ((isset($this->_rootref['L__btpolls_polls_results'])) ? $this->_rootref['L__btpolls_polls_results'] : ((defined('_btpolls_polls_results')) ? _btpolls_polls_results : '{ _btpolls_polls_results }')); ?></b></a>]</p>
</td></tr></tbody></table></div>
	<?php } else { ?>
<form method="post" action="index.php"><p>
<?php $_poll_var_no_answered_count = (isset($this->_tpldata['poll_var_no_answered'])) ? sizeof($this->_tpldata['poll_var_no_answered']) : 0;if ($_poll_var_no_answered_count) {for ($_poll_var_no_answered_i = 0; $_poll_var_no_answered_i < $_poll_var_no_answered_count; ++$_poll_var_no_answered_i){$_poll_var_no_answered_val = &$this->_tpldata['poll_var_no_answered'][$_poll_var_no_answered_i]; ?>
<input name="choice" value="<?php echo $_poll_var_no_answered_val['VALUE']; ?>" type="radio"><?php echo $_poll_var_no_answered_val['VAL_QUEST']; ?><br>
<?php }} ?>
<br></p><div align="center"><input value="<?php echo ((isset($this->_rootref['L__btpolls_polls_vote'])) ? $this->_rootref['L__btpolls_polls_vote'] : ((defined('_btpolls_polls_vote')) ? _btpolls_polls_vote : '{ _btpolls_polls_vote }')); ?>" class="btn" type="submit"><br>[<a href="polls.php"><b><?php echo ((isset($this->_rootref['L__btpolls_polls_results'])) ? $this->_rootref['L__btpolls_polls_results'] : ((defined('_btpolls_polls_results')) ? _btpolls_polls_results : '{ _btpolls_polls_results }')); ?></b></a>]</div></form></td></tr></tbody></table></div>
    <?php } } else { ?>
<p align="center"><?php echo (isset($this->_rootref['POLL_NO_POLL'])) ? $this->_rootref['POLL_NO_POLL'] : ''; ?><br></td></tr></tbody></table></div>
    <?php } ?>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</tbody></table>