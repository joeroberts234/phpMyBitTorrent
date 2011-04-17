<?php if (!defined('IN_PMBT')) exit; ?><h2><center><font size="4">Disclaimer</font></center></h2>
<table width=100% height='50' border=1 cellspacing=0 cellpadding=3><tr><td align=center><marquee onmouseover=this.stop() onmouseout=this.start() scrollAmount=1 direction=up width='100%' height='50'>
<p>Disclaimer:
None of the files shown here are actually hosted on this server. <br />
The links are provided solely by this site's users.<br />
These BitTorrent files are meant for the distribution of backup files. <br />
By downloading the BitTorrent file, you are claiming that you own the original file. <br />

The administrator of this site <strong>P2P-Evolution</strong> holds <strong>NO RESPONSIBILITY</strong> if these files are misused in any way and <br />
cannot be held responsible for what its users post, or any other actions of its users.. For controversial reasons, <br />
if you are affiliated with any government, <strong>ANTI-Piracy</strong> group or any other related group, <br />
or were formally a worker of one you <strong>CANNOT</strong> download any of these BitTorrent files. <br />

If you download these files you are not agreeing to these terms and you are violating code 431.322.12 of the Internet Privacy Act <br />
signed by Bill Clinton in 1995 and that means that you <strong>CANNOT</strong> threaten our ISP(s) or any person(s) or company storing these files, <br />
and cannot prosecute any person(s) affiliated with this page which includes family, friends or individuals who run or enter this web site. <br />
If you do not agree to these terms, please do not use this service or you will face consequences. <br />
You may not use this site to distribute or download any material when you do not have the legal rights to do so. <br />
It is your own responsibility to adhere to these terms.</p>
</marquee>
</td></tr></table></div></td><td width="20%" valign="top"><table class="tablebg" width="100%" cellspacing="0">

<tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnUpload_guide');"><img title="Expand item" id="nnUpload_guideimg" src="themes/eVo_red/pics/minus.gif"  alt="+"></a>Upload guide
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnUpload_guide">
<center><a href="utorrent.php">Utorrent Guide</a></center>
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
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnPersonal_stats');"><img title="Expand item" id="nnPersonal_statsimg" src="themes/eVo_red/pics/minus.gif"  alt="+"></a>Personal stats
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnPersonal_stats">
<p><img src="themes/eVo_red/pics/pic_uploaded.gif" border="0" alt="" title=""   /><?php echo (isset($this->_rootref['U_UPLOADED'])) ? $this->_rootref['U_UPLOADED'] : ''; ?><br><img src="themes/eVo_red/pics/pic_downloaded.gif" border="0" alt="" title=""   /><?php echo (isset($this->_rootref['U_DOWNLOADED'])) ? $this->_rootref['U_DOWNLOADED'] : ''; ?><br><img src="themes/eVo_red/pics/pic_ratio.gif" border="0" alt="" title=""   />&nbsp;<?php echo (isset($this->_rootref['U_RATIO'])) ? $this->_rootref['U_RATIO'] : ''; ?><br>

<?php if ($this->_rootref['U_TSEEDING']) {  ?><span class="overlib" onmouseover="return overlib('<?php echo (isset($this->_rootref['U_TSEEDING'])) ? $this->_rootref['U_TSEEDING'] : ''; ?>',CAPTION, 'Torrents you are Seeding',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_red/pics/help.png',BORDER,2,SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);" onmouseout="return nd();" style="cursor:help"><?php } ?>
<img src="themes/eVo_red/pics/upload.gif" border="0" alt="" title=""   /></span><?php echo (isset($this->_rootref['U_TSEEDING_CNT'])) ? $this->_rootref['U_TSEEDING_CNT'] : ''; ?><br>
<?php if ($this->_rootref['U_TLEECHING']) {  ?><span class="overlib" onmouseover="return overlib('<?php echo (isset($this->_rootref['U_TLEECHING'])) ? $this->_rootref['U_TLEECHING'] : ''; ?>',CAPTION, 'Torrents you are Seeding',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_red/pics/help.png',BORDER,2,SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);" onmouseout="return nd();" style="cursor:help"><?php } ?>
<img src="themes/eVo_red/pics/download.gif" border="0" alt="Torrents you are Downloading" title="Torrents you are Downloading"   /><?php echo (isset($this->_rootref['U_TLEECHINGCNT'])) ? $this->_rootref['U_TLEECHINGCNT'] : ''; ?></p><br>
<br>
<p align="center"><b>Welcome Back</b></p>
<p align="center"><b><?php echo (isset($this->_rootref['U_USER_USERNAME'])) ? $this->_rootref['U_USER_USERNAME'] : ''; ?></b></p>
<b><?php echo (isset($this->_rootref['U_AVATAR'])) ? $this->_rootref['U_AVATAR'] : ''; ?></b><br><br>
<p>Seeding Bonus: <a href='mybonus.php'><?php echo (isset($this->_rootref['U_SEED_BONUS'])) ? $this->_rootref['U_SEED_BONUS'] : ''; ?></a></p>
<p>Transfer Bonus: <a href="bonus_transfer.php">here</a></p>
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
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnTheme_change');"><img title="Expand item" id="nnTheme_changeimg" src="themes/eVo_red/pics/minus.gif"  alt="+"></a>Theme change
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnTheme_change">
<p align="center"><b>Theme</b></p>
<form id="acp_styles" type="hidden" method="post" action="#"><p><select id="template_file" name="theme_change" onchange="if (this.options[this.selectedIndex].value != '') this.form.submit();">
<option value="eVo_silver">eVo_silver</option>
<option selected value="eVo_red">eVo_red</option>
<option value="eVo_blue">eVo_blue</option>
</select></p><p align="center"><b>Language</b></p>
<p><select id="language_file" name="language_change" onchange="if (this.options[this.selectedIndex].value != '') this.form.submit();"><option  value="spanish">Spanish</option>
<option  value="brazilian">Brazilian</option>
<option  value="german">German</option>
<option  value="help">Help</option>
<option  value="turkish">Turkish</option>
<option  value="tessw">Tessw</option>

<option  value="czech">Czech</option>
<option  value="greek">Greek</option>
<option  value="italian">Italian</option>
<option  value="french">French</option>
<option selected value="english">English</option>
</select></p> <input class="button2" type="submit" value="SELECT" ></form></div>
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
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnInvites');"><img title="Expand item" id="nnInvitesimg" src="themes/eVo_red/pics/minus.gif"  alt="+"></a>Invites
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnInvites">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td align="center"><p>You have <?php echo (isset($this->_rootref['U_INVITES'])) ? $this->_rootref['U_INVITES'] : ''; ?> Invites</p><br></td></tr>
<tr><td align="center"><a href=invite.php>Send An Invite</a><br></td></tr>

</table></div>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</table>
<br clear="all" >
