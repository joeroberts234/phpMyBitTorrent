<?php if (!defined('IN_PMBT')) exit; ?><table class="tablebg" width="100%" cellspacing="0">
<tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnUsers_active_in_the_past_24_hours');"><img title="Expand item" id="nnUsers_active_in_the_past_24_hoursimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>Users active in the past 24 hours
</div>
</div>
</div>

</td></tr><tr valign="middle">
<td  class="row3" >
<div id="nnUsers_active_in_the_past_24_hours">
<?php $_user_today_count = (isset($this->_tpldata['user_today'])) ? sizeof($this->_tpldata['user_today']) : 0;if ($_user_today_count) {for ($_user_today_i = 0; $_user_today_i < $_user_today_count; ++$_user_today_i){$_user_today_val = &$this->_tpldata['user_today'][$_user_today_i]; ?>
<a href="user.php?op=profile&amp;id=<?php echo $_user_today_val['ID']; ?>" title="<?php echo $_user_today_val['LAST_CLICK']; ?> <?php echo ((isset($this->_rootref['L__btago'])) ? $this->_rootref['L__btago'] : ((defined('_btago')) ? _btago : '{ _btago }')); ?>"><font color="<?php echo $_user_today_val['COLOR']; ?>"><?php echo $_user_today_val['USERNAME']; ?></font></a>
			<?php echo $_user_today_val['LEVEL_ICON']; ?>
			<?php if ($_user_today_val['WARNED']) {  ?><img src="images/warning.gif" title="warned" alt="warned" /><?php } if ($_user_today_val['DONER']) {  ?><img src="images/donator.gif" height="16" width="16" title="donator" alt="donator" /><?php } ?>
, 
<?php }} ?>
</div>

</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</table>
<br clear="all" >