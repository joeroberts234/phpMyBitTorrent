<?php if (!defined('IN_PMBT')) exit; ?><link href="./themes/eVo_silver/forums/style.css" rel="stylesheet" type="text/css" media="screen, projection" />
<table class="tablebg" width="100%" cellspacing="0">
<tr><td>
<div class="caption">
<div class="cap-left">

<div class="cap-right">
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnRecent_Posts');"><img title="Expand item" id="nnRecent_Postsimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>Recent Posts
</div>
</div>
</div>
</td>
</tr>
<tr valign="middle">
<td  class="row3" >
<div id="nnRecent_Posts">
<b>Latest Topics</b><br>
<table align=center cellpadding=1 cellspacing=0 style='border-collapse: collapse' bordercolor=#646262 width=100% border=1 >
<tr>
    <td class = ftableback align=left  width=100%><b>Topic Title</b></td>
    <td class = ftableback align=center width=47><b>Replies</b></td>
    <td class = ftableback align=center width=47><b>Views</b></td>
    <td class = ftableback align=center width=85><b>Author</b></td>
    <td class = ftableback align=right width=85><b>Last Post</b></td>
</tr>
<?php $_recent_posts_count = (isset($this->_tpldata['recent_posts'])) ? sizeof($this->_tpldata['recent_posts']) : 0;if ($_recent_posts_count) {for ($_recent_posts_i = 0; $_recent_posts_i < $_recent_posts_count; ++$_recent_posts_i){$_recent_posts_val = &$this->_tpldata['recent_posts'][$_recent_posts_i]; ?>
<tr class=alt1>
    <td style='padding-right: 5px'><a href=forums.php?action=viewtopic&amp;topicid=<?php echo $_recent_posts_val['TOPIC_ID']; ?>><b><?php echo $_recent_posts_val['SUBJECT']; ?></b></a></td>
    <td class=alt2 align=center><?php echo $_recent_posts_val['REPLIES']; ?></td>
    <td class=alt1 align=center><?php echo $_recent_posts_val['VIEWS']; ?></td>
    <td class=alt1 align=center><a href=user.php?op=profile&amp;id=<?php echo $_recent_posts_val['AUTHOR_ID']; ?>><font color="<?php echo $_recent_posts_val['AUTHOR_COLOR']; ?>"><?php echo $_recent_posts_val['AUTHOR']; ?></font></a></td>
    <td class=alt2 align=center><nobr><small><nobr><?php echo $_recent_posts_val['ADDED']; ?></nobr><br /><a href=user.php?op=profile&amp;id=<?php echo $_recent_posts_val['POSTER_ID']; ?>><font color="<?php echo $_recent_posts_val['POSTER_COLOR']; ?>"><?php echo $_recent_posts_val['POSTER']; ?></font></a> <a href=forums.php?action=viewtopic&amp;topicid=<?php echo $_recent_posts_val['TOPIC_ID']; ?>&amp;page=last#last><img src="/themes/eVo_silver/forums/icon_topic_latest.gif" alt="View the latest post" title="View the latest post" width="11" height="8"border="0"></a></small></nobr></td>
</tr>
<?php }} ?>
</table>
<br>
</div>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</table>
<br clear="all" >
