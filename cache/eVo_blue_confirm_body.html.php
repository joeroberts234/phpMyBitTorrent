<?php if (!defined('IN_PMBT')) exit; ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="generator" content="PMBT 2.0.5">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta http-equiv="EXPIRES" content="-1">
<meta http-equiv="Cache-Control" content="no-cache">
<link rel="search" type="application/opensearchdescription+xml" title="<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>" href="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/opensearch.php">
<!--[if lt IE 7]>
<script defer type="text/javascript" src="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/pngfix.js"></script>
<![endif]-->
<title><?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?> &bull; <?php if ($this->_rootref['S_IN_MCP']) {  echo ((isset($this->_rootref['L__btmodprofile'])) ? $this->_rootref['L__btmodprofile'] : ((defined('_btmodprofile')) ? _btmodprofile : '{ _btmodprofile }')); ?> &bull; <?php } else if ($this->_rootref['S_IN_UCP']) {  echo ((isset($this->_rootref['L__btuserprofile'])) ? $this->_rootref['L__btuserprofile'] : ((defined('_btuserprofile')) ? _btuserprofile : '{ _btuserprofile }')); ?> &bull; <?php } echo (isset($this->_rootref['PAGE_TITLE'])) ? $this->_rootref['PAGE_TITLE'] : ''; ?></title>

<script type="text/javascript" src="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/js/prototype.js"></script>
<script type="text/javascript" src="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/js/lightbox.js"></script>
<link rel="stylesheet" href="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/css/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/js/ncode_imageresizer.js"></script>
<script type="text/javascript">
<!--
NcodeImageResizer.MODE = 'newwindow';
NcodeImageResizer.MAXWIDTH = 500;
NcodeImageResizer.MAXHEIGHT =400;

NcodeImageResizer.Msg1 = 'Click here to view the full image.';
NcodeImageResizer.Msg2 = 'This image has been resized. Click image to view the full image.';
NcodeImageResizer.Msg3 = 'This image has been resized. Click image to view the full image.';
NcodeImageResizer.Msg4 = 'Click here to view the small image.';
//-->
</script>
<script type="text/javascript">
pmbtsite_url = "<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>";
tag_prompt = "Enter a Text:";
img_prompt = "Insert Link from Image";
font_formatter_prompt = "Enter a Text - ";
link_text_prompt = "Enter a Link Name (Optional):";
link_url_prompt = "Enter the Full Address on the left of:";
link_email_prompt = "Enter your Full Link:";
list_type_prompt = "Which type of List would you like? Give ' 1 ' for a Numerical List, 'a' for an Alphabetical List, or nothing at all for a Simple Point List.";
list_item_prompt = "Enter one point of list. Press OK to enter another point of list or press 'Cancel' to Finish.";
_btshoutnowprivate = "Private Shout!";
shoutrefresht = "50000";
shoutidle = "30000";
function change_bg(img, state)
{
if (state == "1") 
img.src = img.src.replace(".gif","_over.gif");
else if (state == "0") 
img.src = img.src.replace("_over.gif",".gif");
else if (state == "2") 
img.src = img.src.replace("_over.gif",".gif");
else if (state == "3") 
img.src = img.src.replace("_over.gif",".gif");
}
var pd = new Date();
var last_reload = pd.getTime();
function do_breload() {
    if (document.location.href.match(/\/torrents\.php/)) {
	   var d = new Date();
	   if (last_reload && last_reload > (d.getTime() - "4000")) return;
	      last_reload = d.getTime();   
	   bparam('page=1')	   

	}
}
function toggle2(nome) {
if(document.getElementById(nome).style.display=='none')
{
SetCookie(nome,'');
document.getElementById(nome).style.display = '';
document.getElementById(nome+"img").src="themes/eVo_blue/pics/minus.gif";
} else {
SetCookie(nome,'none',200);
document.getElementById(nome).style.display = 'none';
document.getElementById(nome+"img").src="themes/eVo_blue/pics/plus.gif";
}
}
function SetCookie(cookieName,cookieValue,nDays) {
 var today = new Date();
 var expire = new Date();
 if (nDays==null || nDays==0) nDays=1;
 expire.setTime(today.getTime() + 3600000*24*nDays);
 document.cookie = cookieName+"="+escape(cookieValue)
                 + ";expires="+expire.toGMTString();
}
function bparam(){
    document.getElementById('myAnchor').href="torrents.php"
}
</script>
<link REL="shortcut icon" HREF="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/themes/eVo_blue/favicon.ico" TYPE="image/x-icon">
<link rel="alternate" type="application/rss+xml" title="Last Torrents" href="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/backend.php?op=last">
<link rel="alternate" type="application/rss+xml" title="Best Torrents" href="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/backend.php?op=best">
<link rel="StyleSheet" href="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/themes/eVo_blue/style.css" type="text/css">
<script type="text/javascript" src="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/global.js"></script>
<script type="text/javascript" src="overlib/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<script type="text/javascript" src="overlib/overlib_shadow.js"><!-- overLIB (c) Erik Bosrup --></script>
</head>

<!--[if lt IE 7]><link rel="stylesheet" type="text/css" media="screen" href="themes/eVo_blue/iestyle.css">
<![endif]-->
<!--[if IE]>
<link rel="stylesheet" type="text/css" media="screen" href="themes/eVo_blue/iestyle.css">
<![endif]-->
<body class="ltr" onload="shoutthis_ajax()">
<table border="0" cellspacing="0" cellpadding="0" width="100%" id="maintable" align="center">
<tr>
<td id="logorow" align="center"><div id="logo-left"><div id="logo-right">
</div></div></td>
</tr>
<tr>
<td class="navrow">

</tr>
<tr>

<td  align="center" class="topbuttons" nowrap="nowrap" width="100%" colspan="6">
<a href="index.php" ><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_blue/pics/top_home.gif" border="0" alt="Home" title="Home" id="home"></a>
<a id="myAnchor" href="torrents.php" onclick="do_breload();"><img onclick="do_breload();" onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_blue/pics/top_browse.gif" border="0" alt="" title="Browse" id="browse"></a>
<span class="overlib" onclick="return overlib('<table width=\'100%\' cellspacing=\'1\' cellpadding=\'4\' border=\'0\' class=\'tableinborder\'><tr><td class=\'tabletitle\'><div align=\'center\'><a href=\'javascript:;\' onclick=\'return nd();\'>Profile Menu</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'user.php?op=profile\'>Profile</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'user.php?op=editprofile\'>Edit Profile</a></div></td></tr></table>',CELLPAD,'0',FOLLOWMOUSE,'0',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_blue/pics/help.png',SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);"  ><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_blue/pics/top_profile.gif" border="0" alt="" title="Profile" id="profile"></span>
<a href="pm.php"><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_blue/pics/top_messages.gif" border="0" alt="mess" title="Messages" id="msg"></a>
<a href="upload.php"><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_blue/pics/top_upload.gif" border="0" alt="" title="Upload" id="upload"></a>
<a href="forums.php"><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_blue/pics/top_forum.gif" border="0" alt="" title="Forums" id="forums"></a>
<span class="overlib" onclick="return overlib('<table width=\'100%\' cellspacing=\'1\' cellpadding=\'4\' border=\'0\' class=\'tableinborder\'><tr><td class=\'tabletitle\'><div align=\'center\'><a href=\'javascript:;\' onclick=\'return nd();\'>Help Menu</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'rules.php\'>Rules</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'faq.php\'>F.A.Q</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'staff.php\'>Staff</a></div></td></tr></table>',CELLPAD,'0',FOLLOWMOUSE,'0',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_blue/pics/help.png',SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);"  ><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_blue/pics/top_help.gif" border="0" alt="" title="Staff" id="help"></span>
<a onclick="if(!confirm('Are you sure do you want to logout?')){return false;};" href="user.php?op=logout" r="0" alt="" title="Logout"><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_blue/pics/top_logout.gif" border="0" title="Logout" alt="" id="logout"></a>
</td>
</tr>
<tr>
<td id="contentrow">
<table width="100%">
<tr>
<td width="20%" valign="top">
<div >

<form id="confirm" action="<?php echo (isset($this->_rootref['S_CONFIRM_ACTION'])) ? $this->_rootref['S_CONFIRM_ACTION'] : ''; ?>" method="post">
<div class="panel">
	<div class="inner"><span class="corners-top"><span></span></span>

	<h2><?php echo (isset($this->_rootref['MESSAGE_TITLE'])) ? $this->_rootref['MESSAGE_TITLE'] : ''; ?></h2>
	<p><?php echo (isset($this->_rootref['MESSAGE_TEXT'])) ? $this->_rootref['MESSAGE_TEXT'] : ''; ?></p>
	
	<fieldset class="submit-buttons">
		<?php echo (isset($this->_rootref['S_HIDDEN_FIELDS'])) ? $this->_rootref['S_HIDDEN_FIELDS'] : ''; ?>
		<input type="submit" name="confirm" value="<?php echo ((isset($this->_rootref['L__btcyes'])) ? $this->_rootref['L__btcyes'] : ((defined('_btcyes')) ? _btcyes : '{ _btcyes }')); ?>" class="button2" />&nbsp; 
		<input type="submit" name="cancel" value="<?php echo ((isset($this->_rootref['L__btcno'])) ? $this->_rootref['L__btcno'] : ((defined('_btcno')) ? _btcno : '{ _btcno }')); ?>" class="button2" />
	</fieldset>

	<span class="corners-bottom"><span></span></span></div>
</div>
</form>

</tr></table>
<div id="wrapfooter">
	<span class="gensmall"> <!-- Feel free to add you custom disclaimer or copyright notice here --><!-- YOU ARE NOT ALLOWED TO EDIT THE FOLLOWING COPYRIGHT NOTICE!!! -->
 Theme By Evolution Torrent 2010 © <br>
 Powered by phpMyBitTorrent © 2005-2010 <a href="http://phpmybittorrent.com">phpMyBitTorrent Team</a>.<br>
 This is free software and contains source code version of GNU/LGPL distributed libraries.<br>

 You may redistribute the whole package and its source code according to the GNU/GPL license.<br>
 The Development Team cannot be held responsible in any way for the results of the use of this software.<br>
 <!-- COPYRIGHT NOTICE -->
 Generated in <?php echo (isset($this->_rootref['S_GENTIME'])) ? $this->_rootref['S_GENTIME'] : ''; ?> seconds
<!-- Start of StatCounter Code -->
 <script type="text/javascript">
 var sc_project=2789089;
 var sc_invisible=0;
 var sc_partition=28;
 var sc_security="7d0a2fe3";
 </script>

 <script type="text/javascript" src="http://www.statcounter.com/counter/counter_xhtml.js"></script><noscript><div class="statcounter"><a class="statcounter" href="http://www.statcounter.com/"><img class="statcounter" src="http://c29.statcounter.com/2789089/0/7d0a2fe3/0/" alt="web metrics" ></a></div></noscript>
 </span><br><br>	<span class="copyright">

	
	</span>
</div></body>
</html>