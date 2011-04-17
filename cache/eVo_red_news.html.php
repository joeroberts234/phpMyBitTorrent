<?php if (!defined('IN_PMBT')) exit; ?><table class="tablebg" width="100%" cellspacing="0">
<tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnSite_News');"><img title="Expand item" id="nnSite_Newsimg" src="themes/eVo_red/pics/minus.gif"  alt="+"></a>Site News
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnSite_News">

<table width="100%"><tr><td><?php echo (isset($this->_rootref['SITE_NEWS'])) ? $this->_rootref['SITE_NEWS'] : ''; ?></td></tr></table></div>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</table>
<br clear="all" >
