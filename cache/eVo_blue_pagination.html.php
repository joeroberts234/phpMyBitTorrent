<?php if (!defined('IN_PMBT')) exit; ?><script type="text/javascript">
// <![CDATA[
function jumpto()
{
	var page = prompt('<?php echo ((isset($this->_rootref['LA_JUMP_PAGE'])) ? $this->_rootref['LA_JUMP_PAGE'] : ((isset($this->_rootref['L_JUMP_PAGE'])) ? addslashes($this->_rootref['L_JUMP_PAGE']) : ((isset($user->lang['JUMP_PAGE'])) ? addslashes($user->lang['JUMP_PAGE']) : '{ JUMP_PAGE }'))); ?>:', '<?php echo (isset($this->_rootref['ON_PAGE'])) ? $this->_rootref['ON_PAGE'] : ''; ?>');
	var perpage = '<?php echo (isset($this->_rootref['PER_PAGE'])) ? $this->_rootref['PER_PAGE'] : ''; ?>';
	var base_url = '<?php echo (isset($this->_rootref['A_BASE_URL'])) ? $this->_rootref['A_BASE_URL'] : ''; ?>';

	if (page !== null && !isNaN(page) && page > 0)
	{
		document.location.href = base_url.replace(/&amp;/g, '&') + '&start=' + ((page - 1) * perpage);
	}
}
// ]]>
</script>
<?php if ($this->_rootref['PAGINATION']) {  ?><b><a href="#" onclick="jumpto(); return false;" title="<?php echo ((isset($this->_rootref['L_JUMP_TO_PAGE'])) ? $this->_rootref['L_JUMP_TO_PAGE'] : ((defined('JUMP_TO_PAGE')) ? JUMP_TO_PAGE : '{ JUMP_TO_PAGE }')); ?>"><?php echo ((isset($this->_rootref['L_GOTO_PAGE'])) ? $this->_rootref['L_GOTO_PAGE'] : ((defined('GOTO_PAGE')) ? GOTO_PAGE : '{ GOTO_PAGE }')); ?></a> <?php if ($this->_rootref['PREVIOUS_PAGE']) {  ?><a href="<?php echo (isset($this->_rootref['PREVIOUS_PAGE'])) ? $this->_rootref['PREVIOUS_PAGE'] : ''; ?>"><?php echo ((isset($this->_rootref['L__btsnatch_prev'])) ? $this->_rootref['L__btsnatch_prev'] : ((defined('_btsnatch_prev')) ? _btsnatch_prev : '{ _btsnatch_prev }')); ?></a>&nbsp;&nbsp;<?php } echo (isset($this->_rootref['PAGINATION'])) ? $this->_rootref['PAGINATION'] : ''; if ($this->_rootref['NEXT_PAGE']) {  ?> &nbsp;<a href="<?php echo (isset($this->_rootref['NEXT_PAGE'])) ? $this->_rootref['NEXT_PAGE'] : ''; ?>"><?php echo ((isset($this->_rootref['L__btsnatch_next'])) ? $this->_rootref['L__btsnatch_next'] : ((defined('_btsnatch_next')) ? _btsnatch_next : '{ _btsnatch_next }')); ?></a><?php } ?></b><?php } ?>