<?php if (!defined('IN_PMBT')) exit; ?>  <table class="tablebg" width="100%" cellspacing="0">
    <tr>
	  <td>
      <div class="caption">
       <div class="cap-left">
        <div class="cap-right">
         <a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nnNewest_Members');"><img title="Expand item" id="nnNewest_Membersimg" src="themes/eVo_blue/pics/minus.gif" alt="+"></a>Newest Members
       </div>
      </div>
</div>
</td></tr><tr valign="middle">
<td class="row3"><div id="nnNewest_Members">
<table class="torrenttable" width="100%" border="0" cellpadding="3"><tr>
<?php if ($this->_rootref['IS_NEW_USERS']) {  $_new_user_count = (isset($this->_tpldata['new_user'])) ? sizeof($this->_tpldata['new_user']) : 0;if ($_new_user_count) {for ($_new_user_i = 0; $_new_user_i < $_new_user_count; ++$_new_user_i){$_new_user_val = &$this->_tpldata['new_user'][$_new_user_i]; ?>
<td padding="0">
<center><?php echo $_new_user_val['AVATAR']; ?><br>
<a href="user.php?op=profile&amp;id=<?php echo $_new_user_val['UID']; ?>"><font color="<?php echo $_new_user_val['COLOR']; ?>"><?php echo $_new_user_val['NAME']; ?></font></a>
</center>
</td>
<?php }} } else { ?>
<td padding="0"><?php echo ((isset($this->_rootref['L__bt_no_nuser'])) ? $this->_rootref['L__bt_no_nuser'] : ((defined('_bt_no_nuser')) ? _bt_no_nuser : '{ _bt_no_nuser }')); ?></td>
<?php } ?>
</tr></table>
</div>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</table>
<br clear="all">
