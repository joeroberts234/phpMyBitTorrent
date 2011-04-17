<?php if (!defined('IN_PMBT')) exit; if ($this->_rootref['IS_NEED_SEEDS']) {  ?>
<table class="tablebg" width="100%" cellspacing="0">
<tr><td>
<div class="caption">

<div class="cap-left">
<div class="cap-right">
<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nnTorrents_That_Need_Seeding');"><img title="Expand item" id="nnTorrents_That_Need_Seedingimg" src="themes/eVo_silver/pics/minus.gif" alt="+"></a>Torrents That Need Seeding
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnTorrents_That_Need_Seeding">
<CENTER><B><?php echo ((isset($this->_rootref['L__btifyhhelpthem'])) ? $this->_rootref['L__btifyhhelpthem'] : ((defined('_btifyhhelpthem')) ? _btifyhhelpthem : '{ _btifyhhelpthem }')); ?></B></CENTER>
<center><table  style="width: 100%;" class=table_table border=2 cellspacing=0 cellpadding=0 >
<tr><td class=colhead><?php echo ((isset($this->_rootref['L__bttorrent'])) ? $this->_rootref['L__bttorrent'] : ((defined('_bttorrent')) ? _bttorrent : '{ _bttorrent }')); ?></td><td class=colhead><?php echo ((isset($this->_rootref['L__btleechers'])) ? $this->_rootref['L__btleechers'] : ((defined('_btleechers')) ? _btleechers : '{ _btleechers }')); ?></td><td class=colhead><?php echo ((isset($this->_rootref['L__btdownloaded'])) ? $this->_rootref['L__btdownloaded'] : ((defined('_btdownloaded')) ? _btdownloaded : '{ _btdownloaded }')); ?></td><td class=colhead><?php echo ((isset($this->_rootref['L__btsnatch'])) ? $this->_rootref['L__btsnatch'] : ((defined('_btsnatch')) ? _btsnatch : '{ _btsnatch }')); ?></td><td class=colhead><?php echo ((isset($this->_rootref['L__btadded'])) ? $this->_rootref['L__btadded'] : ((defined('_btadded')) ? _btadded : '{ _btadded }')); ?></td></tr>
<?php $_need_seeded_count = (isset($this->_tpldata['need_seeded'])) ? sizeof($this->_tpldata['need_seeded']) : 0;if ($_need_seeded_count) {for ($_need_seeded_i = 0; $_need_seeded_i < $_need_seeded_count; ++$_need_seeded_i){$_need_seeded_val = &$this->_tpldata['need_seeded'][$_need_seeded_i]; ?>
<tr><td class=table_col1  align=left><a href="details.php?id=<?php echo $_need_seeded_val['SEED_ID']; ?>&hit=1" alt="<?php echo $_need_seeded_val['SEED_NAME']; ?>" 	title="<?php echo $_need_seeded_val['SEED_NAME']; ?>"><?php echo $_need_seeded_val['SEED_NAME_SHORT']; ?></a></td><td  class=table_col1><font color=red><?php echo $_need_seeded_val['SEED_LEECH']; ?></td><td  class=table_col1><?php echo $_need_seeded_val['SEED_DOWN']; ?></td><td  class=table_col1><?php echo $_need_seeded_val['SEED_COMPL']; ?></td><td  class=table_col1><?php echo $_need_seeded_val['SEED_ADDED']; ?></td></tr>
<?php }} ?>
</table></center>
</div>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</table>
<br clear="all" >
<?php } ?>