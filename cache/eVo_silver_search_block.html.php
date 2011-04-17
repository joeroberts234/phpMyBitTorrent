<?php if (!defined('IN_PMBT')) exit; ?><table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">
<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nnSearch');"><img title="Expand item" id="nnSearchimg" src="themes/eVo_silver/pics/minus.gif" alt="+"></a><img src="themes/eVo_silver/pics/icon_mini_search.gif" alt="" title="" border="0">Search
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td class="row3"><div id="nnSearch">
<script type="text/javascript" src="http://p2p-evolution.com/browse.js"></script>  
<form method="get" action="search.php"><br>

<div id="cats" style="display: block;">
<table>
  <tbody align="left">
    <tr>
<?php $_cats_var_count = (isset($this->_tpldata['cats_var'])) ? sizeof($this->_tpldata['cats_var']) : 0;if ($_cats_var_count) {for ($_cats_var_i = 0; $_cats_var_i < $_cats_var_count; ++$_cats_var_i){$_cats_var_val = &$this->_tpldata['cats_var'][$_cats_var_i]; ?>
      <td class="nopad" style="padding-bottom: 2px; padding-left: 7px;"><?php echo $_cats_var_val['IMAGE']; ?>&nbsp;&nbsp;<input id="checkAll<?php echo $_cats_var_val['ID']; ?>" onclick="checkAllFields(1,<?php echo $_cats_var_val['TABLETYPE']; ?>);" type="checkbox"><a href="javascript: ShowHideMainSubCats(<?php echo $_cats_var_val['TABLETYPE']; ?>,<?php echo (isset($this->_rootref['NCATS_VAR'])) ? $this->_rootref['NCATS_VAR'] : ''; ?>)"><img src="themes/eVo_silver/pics/plus.gif" id="pic<?php echo $_cats_var_val['ID']; ?>" alt="Show/Hide" border="0">&nbsp;<?php echo $_cats_var_val['NAME']; ?></a>&nbsp;</td>
<?php }} ?>
    </tr>
  </tbody>
</table>
</div>
<?php $_sub_cats_var_count = (isset($this->_tpldata['sub_cats_var'])) ? sizeof($this->_tpldata['sub_cats_var']) : 0;if ($_sub_cats_var_count) {for ($_sub_cats_var_i = 0; $_sub_cats_var_i < $_sub_cats_var_count; ++$_sub_cats_var_i){$_sub_cats_var_val = &$this->_tpldata['sub_cats_var'][$_sub_cats_var_i]; if ($_sub_cats_var_val['DIVSTART']) {  ?>
<div id="tabletype<?php echo $_sub_cats_var_val['PARENT_ID']; ?>" style="display: none;">
  <table>
    <tbody align="left">
	  <tr>

<?php } ?>
	    <td class="subcatlink" style="padding-bottom: 2px; padding-left: 7px; width: 14.2857%;"><?php echo $_sub_cats_var_val['IMAGE']; ?>&nbsp;&nbsp;<input onclick="checkAllFields(2,<?php echo $_sub_cats_var_val['TABLETYPE']; ?>);" name="cats<?php echo $_sub_cats_var_val['TABLETYPE']; ?>[]" value="<?php echo $_sub_cats_var_val['ID']; ?>" type="checkbox"><?php echo $_sub_cats_var_val['NAME']; ?></td>
<?php if ($_sub_cats_var_val['DIVEND']) {  ?>

	    <td rowspan="4">&nbsp;</td>
	  </tr>
    </tbody>
  </table>
</div>

<?php } }} ?>
<table align="center" border="0" cellpadding="1" cellspacing="1"><tbody><tr><td></td><td>
<input id="actb_textbox" name="search" value="" size="25" type="text"> </td><td>
<?php echo (isset($this->_rootref['S_ACTB'])) ? $this->_rootref['S_ACTB'] : ''; ?>
<script type="text/javascript" language="JavaScript">actb(document.getElementById("actb_textbox"),customarray);</script>
</td><td><input value="Go!" type="submit"></td></tr></tbody></table><table align="center" border="0" cellpadding="1" cellspacing="1"><tbody><tr><td><p>Order By:</p></td><td> <select name="orderby">

<option value="0" selected="selected">Date</option>
<option value="1">Seeds</option>
<option value="2">Leechers</option>
<option value="3">Total Peers</option>
<option value="4">Downloaded</option>
<option value="5">Ratings</option>
<option value="6">Name</option>
<option value="7">Size</option>
<option value="8">Number of Files</option>

</select></td>
<td><select name="ordertype"><option value="DESC">Descending</option><option value="ASC">Ascending</option></select></td><td><p><input name="incldead" value="true" type="checkbox">Include Dead Torrents</p></td></tr></tbody></table></form></div>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</tbody></table>
<br clear="all">
<br clear="all" >