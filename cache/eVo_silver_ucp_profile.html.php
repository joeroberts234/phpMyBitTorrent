<?php if (!defined('IN_PMBT')) exit; ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta name="generator" content="HTML Tidy for Linux (vers 6 November 2007), see www.w3.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="generator" content="PMBT 2.0.2">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta http-equiv="EXPIRES" content="-1">
<meta http-equiv="Cache-Control" content="no-cache">
<link rel="search" type="application/opensearchdescription+xml" title="<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>" href="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/opensearch.php">
<!--[if lt IE 7]>
<script defer type="text/javascript" src="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/pngfix.js"></script>
<![endif]-->
<title><?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?> &bull; <?php if ($this->_rootref['S_IN_MCP']) {  echo ((isset($this->_rootref['L_MCP'])) ? $this->_rootref['L_MCP'] : ((defined('MCP')) ? MCP : '{ MCP }')); ?> &bull; <?php } else if ($this->_rootref['S_IN_UCP']) {  echo ((isset($this->_rootref['L_UCP'])) ? $this->_rootref['L_UCP'] : ((defined('UCP')) ? UCP : '{ UCP }')); ?> &bull; <?php } echo (isset($this->_rootref['PAGE_TITLE'])) ? $this->_rootref['PAGE_TITLE'] : ''; ?></title>

<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/ncode_imageresizer.js"></script>
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
document.getElementById(nome+"img").src="themes/eVo_silver/pics/minus.gif";
} else {
SetCookie(nome,'none',200);
document.getElementById(nome).style.display = 'none';
document.getElementById(nome+"img").src="themes/eVo_silver/pics/plus.gif";
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
<link REL="shortcut icon" HREF="http://p2p-evolution.com/themes/eVo_silver/favicon.ico" TYPE="image/x-icon">
<link rel="alternate" type="application/rss+xml" title="Last Torrents" href="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/backend.php?op=last">
<link rel="alternate" type="application/rss+xml" title="Best Torrents" href="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/backend.php?op=best">
<link rel="StyleSheet" href="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/themes/eVo_silver/style.css" type="text/css">
<script type="text/javascript" src="<?php echo (isset($this->_rootref['SITE_URL'])) ? $this->_rootref['SITE_URL'] : ''; ?>/global.js"></script>
<script type="text/javascript" src="overlib/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<script type="text/javascript" src="overlib/overlib_shadow.js"><!-- overLIB (c) Erik Bosrup --></script>
</head>

<!--[if lt IE 7]><link rel="stylesheet" type="text/css" media="screen" href="themes/eVo_silver/iestyle.css">
<![endif]-->
<!--[if IE]>
<link rel="stylesheet" type="text/css" media="screen" href="themes/eVo_silver/iestyle.css">
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
<a href="index.php" ><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_silver/pics/top_home.gif" border="0" alt="" title="Home" id="home"></a>
<a id="myAnchor" href="torrents.php" onclick="do_breload();"><img onclick="do_breload();" onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_silver/pics/top_browse.gif" border="0" alt="" title="Browse" id="browse"></a>
<span class="overlib" onclick="return overlib('<table width=\'100%\' cellspacing=\'1\' cellpadding=\'4\' border=\'0\' class=\'tableinborder\'><tr><td class=\'tabletitle\'><div align=\'center\'><a href=\'javascript:;\' onclick=\'return nd();\'>Profile Menu</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'user.php?op=profile\'>Profile</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'user.php?op=editprofile\'>Edit Profile</a></div></td></tr></table>',CELLPAD,'0',FOLLOWMOUSE,'0',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_blue/pics/help.png',SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);"  ><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_blue/pics/top_profile.gif" border="0" alt="" title="Profile" id="profile"></span>
<a href="pm.php"><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_silver/pics/top_messages.gif" border="0" alt="mess" title="Messages" id="msg"></a>
<a href="upload.php"><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_silver/pics/top_upload.gif" border="0" alt="" title="Upload" id="upload"></a>
<a href="forums.php"><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_silver/pics/top_forum.gif" border="0" alt="" title="Forums" id="forums"></a>
<span class="overlib" onclick="return overlib('<table width=\'100%\' cellspacing=\'1\' cellpadding=\'4\' border=\'0\' class=\'tableinborder\'><tr><td class=\'tabletitle\'><div align=\'center\'><a href=\'javascript:;\' onclick=\'return nd();\'>Help Menu</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'rules.php\'>Rules</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'faq.php\'>F.A.Q</a></div></td></tr><tr><td class=\'tableb\'><div align=\'center\'><a href=\'staff.php\'>Staff</a></div></td></tr></table>',CELLPAD,'0',FOLLOWMOUSE,'0',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_silver/pics/help.png',SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);"  ><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_silver/pics/top_help.gif" border="0" alt="" title="Staff" id="help"></span>
<a onclick="if(!confirm('Are you sure do you want to logout?')){return false;};" href="user.php?op=logout" r="0" alt="" title="Logout"><img onmouseover="change_bg(this,'1')" onmouseout="change_bg(this,'0')" src="themes/eVo_silver/pics/top_logout.gif" border="0" title="Logout" alt="" id="logout"></a>
</td>
</tr>
<tr>
<td id="contentrow">
<table width="100%">
<tr>
<td width="20%" valign="top">
<div >
<div id="pagecontent">

	<form method="post" action="/memberslist.php?mode=group">

    	<table class="tablebg" width="100%" cellspacing="0">
	<div class="caption">
<div class="cap-left">
<div class="cap-right">
&nbsp;Viewing profile - <?php echo (isset($this->_rootref['CP_UNAME'])) ? $this->_rootref['CP_UNAME'] : ''; ?>&nbsp;</div>
</div>
</div>	<tbody><tr>
		<td class="cat" width="40%" align="center"><h4>Board presence</h4></td>
		<td class="cat" width="60%" align="center"><h4>User statistics</h4></td>
	</tr>
	<tr>

		<td class="row1" align="center">

			<table border="0" cellpadding="2" cellspacing="1">
						<tbody><tr>
				<td align="center"><b class="gen" style="color: <?php echo (isset($this->_rootref['CP_UCOLOR'])) ? $this->_rootref['CP_UCOLOR'] : ''; ?>;"><?php echo (isset($this->_rootref['CP_UNAME'])) ? $this->_rootref['CP_UNAME'] : ''; ?></b><?php if ($this->_rootref['U_ADMIN']) {  ?><span class="genmed"><br>[ <a href="/user.php?op=editprofile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>">Administrate user</a> ]</span><?php } ?></td>
			</tr>
						<tr>
					<td align="center"><?php echo (isset($this->_rootref['CP_UGROUP'])) ? $this->_rootref['CP_UGROUP'] : ''; ?></td>
				</tr>
				<tr>
					<td align="center"><?php echo (isset($this->_rootref['RANK_IMG'])) ? $this->_rootref['RANK_IMG'] : ''; ?></td>
				</tr>

							<tr>
					<td align="center"><?php echo (isset($this->_rootref['CP_UAVATAR'])) ? $this->_rootref['CP_UAVATAR'] : ''; ?></td>
				</tr>
						<tr>

				<td align="center"><img src="/images/<?php echo (isset($this->_rootref['CP_ONLINE'])) ? $this->_rootref['CP_ONLINE'] : ''; ?>line.png" alt="<?php echo (isset($this->_rootref['CP_ONLINE'])) ? $this->_rootref['CP_ONLINE'] : ''; ?>line" title="<?php echo (isset($this->_rootref['CP_ONLINE'])) ? $this->_rootref['CP_ONLINE'] : ''; ?>line"></td>
			</tr>
							<?php if ($this->_rootref['U_ADMIN']) {  ?><tr>
					<td class="genmed" align="center">[ <a href="user.php?op=profile&amp;id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&amp;mode=<?php echo (isset($this->_rootref['UPERMSET'])) ? $this->_rootref['UPERMSET'] : ''; ?>&amp;u=<?php echo (isset($this->_rootref['CP_UCAN_DO'])) ? $this->_rootref['CP_UCAN_DO'] : ''; ?>">Test out user’s permissions</a> ]</td>
				</tr><?php } ?>
							<tr>
					<td class="genmed" align="center"><?php if ($this->_rootref['U_ADD_FRIEND'] && $this->_rootref['U_ADD_FOE']) {  ?>[ <a href="<?php echo (isset($this->_rootref['U_ADD_FRIEND'])) ? $this->_rootref['U_ADD_FRIEND'] : ''; ?>"><?php echo ((isset($this->_rootref['L__btpmbookmarkuser'])) ? $this->_rootref['L__btpmbookmarkuser'] : ((defined('_btpmbookmarkuser')) ? _btpmbookmarkuser : '{ _btpmbookmarkuser }')); ?></a> | <a href="<?php echo (isset($this->_rootref['U_ADD_FOE'])) ? $this->_rootref['U_ADD_FOE'] : ''; ?>"><?php echo ((isset($this->_rootref['L__btpmblacklistuser'])) ? $this->_rootref['L__btpmblacklistuser'] : ((defined('_btpmblacklistuser')) ? _btpmblacklistuser : '{ _btpmblacklistuser }')); ?></a> ]<?php } if ($this->_rootref['U_REMOVE_FRIEND']) {  ?>[ <a href="<?php echo (isset($this->_rootref['U_REMOVE_FRIEND'])) ? $this->_rootref['U_REMOVE_FRIEND'] : ''; ?>"><?php echo ((isset($this->_rootref['L__btpmunbookmarkuser'])) ? $this->_rootref['L__btpmunbookmarkuser'] : ((defined('_btpmunbookmarkuser')) ? _btpmunbookmarkuser : '{ _btpmunbookmarkuser }')); ?></a> ]<?php } if ($this->_rootref['U_REMOVE_FOE']) {  ?>[ <a href="<?php echo (isset($this->_rootref['U_REMOVE_FOE'])) ? $this->_rootref['U_REMOVE_FOE'] : ''; ?>"><?php echo ((isset($this->_rootref['L__btpmunblacklistuser'])) ? $this->_rootref['L__btpmunblacklistuser'] : ((defined('_btpmunblacklistuser')) ? _btpmunblacklistuser : '{ _btpmunblacklistuser }')); ?></a> ]<?php } ?></td>
				</tr>
						</tbody></table>
		</td>
		<td class="row1">
			<table width="100%" border="0" cellpadding="2" cellspacing="1">
			<tbody><tr>
				<td class="gen" align="right" nowrap="nowrap">Joined: </td>
				<td width="100%"><b class="gen"><?php echo (isset($this->_rootref['CP_UREGDATE'])) ? $this->_rootref['CP_UREGDATE'] : ''; ?></b></td>

			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Last visited: </td>
				<td width="100%"><b class="gen"><?php echo (isset($this->_rootref['CP_ULASTSEEN'])) ? $this->_rootref['CP_ULASTSEEN'] : ''; ?></b></td>
			</tr>
							<tr>
					<td class="gen" valign="top" align="right" nowrap="nowrap">Warnings: </td>

					<td width="100%"><b class="gen">0<?php if ($this->_rootref['U_ADMIN']) {  ?></b><br><span class="genmed">[ <a href="/pmbt/phpBB.php?page=mcp.php&amp;i=notes&amp;mode=user_notes&amp;u=315&amp;sid=51564e7e75314969436b03c6e682e0e9">View user notes</a>  | <a href="/pmbt/phpBB.php?page=mcp.php&amp;i=warn&amp;mode=warn_user&amp;u=315&amp;sid=51564e7e75314969436b03c6e682e0e9">Warn user</a> ]</span><?php } ?></td>
				</tr>
			<?php if ($this->_rootref['U_BAN_USER']) {  ?>
			<tr>
				<td class="gen" align="right" nowrap="nowrap"><?php echo ((isset($this->_rootref['L__btuserban'])) ? $this->_rootref['L__btuserban'] : ((defined('_btuserban')) ? _btuserban : '{ _btuserban }')); ?>:</td>
				<td width="100%"><b class="gen">[<?php echo (isset($this->_rootref['U_BAN_USER'])) ? $this->_rootref['U_BAN_USER'] : ''; ?>]</b></td>
			</tr>
			<?php } if ($this->_rootref['U_BAN_SHOUTS']) {  ?>
			<tr>
				<td class="gen" align="right" nowrap="nowrap"><?php echo ((isset($this->_rootref['L__btuserban_shoutban'])) ? $this->_rootref['L__btuserban_shoutban'] : ((defined('_btuserban_shoutban')) ? _btuserban_shoutban : '{ _btuserban_shoutban }')); ?>:</td>
				<td width="100%"><b class="gen">[<?php echo (isset($this->_rootref['U_BAN_SHOUTS'])) ? $this->_rootref['U_BAN_SHOUTS'] : ''; ?>]</b></td>
			</tr>
			<?php } ?>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Uploaded: </td>
				<td width="100%"><b class="gen"><?php echo (isset($this->_rootref['CP_UUPLOADED'])) ? $this->_rootref['CP_UUPLOADED'] : ''; ?></b></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Downloaded: </td>
				<td width="100%"><b class="gen"><?php echo (isset($this->_rootref['CP_UDOWNLOADED'])) ? $this->_rootref['CP_UDOWNLOADED'] : ''; ?></b></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Ratio: </td>
				<td width="100%"><b class="gen"><img src="themes/eVo_silver/pics/pic_ratio.gif" alt="" title="" border="0">&nbsp;<?php echo (isset($this->_rootref['CP_URATIO'])) ? $this->_rootref['CP_URATIO'] : ''; ?></b></td>
			</tr>
						<tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Comments left: </td>
				<td width="100%"><b class="gen"><?php echo (isset($this->_rootref['T_COMMENTS'])) ? $this->_rootref['T_COMMENTS'] : ''; ?></b></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Thanks left: </td>
				<td width="100%"><b class="gen"><?php echo (isset($this->_rootref['T_THANKS'])) ? $this->_rootref['T_THANKS'] : ''; ?></b></td>
			</tr>
				<td class="gen" valign="top" align="right" nowrap="nowrap">Total posts: </td>

				<td><b class="gen"><?php echo (isset($this->_rootref['CP_POST_COUNT'])) ? $this->_rootref['CP_POST_COUNT'] : ''; ?></b><span class="genmed"><br>[<?php echo (isset($this->_rootref['POSTS_PCT'])) ? $this->_rootref['POSTS_PCT'] : ''; ?> / <?php echo (isset($this->_rootref['POSTS_DAY'])) ? $this->_rootref['POSTS_DAY'] : ''; ?> ]<br><a href="/forums.php?action=search&search_id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>">Search user’s posts</a></span></td>
			</tr>
			<?php if ($this->_rootref['S_SHOW_ACTIVITY']) {  ?>
				<tr>
					<td class="gen" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="top" nowrap="nowrap"><?php echo ((isset($this->_rootref['L_ACTIVE_IN_FORUM'])) ? $this->_rootref['L_ACTIVE_IN_FORUM'] : ((defined('ACTIVE_IN_FORUM')) ? ACTIVE_IN_FORUM : '{ ACTIVE_IN_FORUM }')); ?>: </td>
					<td><?php if ($this->_rootref['ACTIVE_FORUM']) {  ?><b><a class="gen" href="<?php echo (isset($this->_rootref['U_ACTIVE_FORUM'])) ? $this->_rootref['U_ACTIVE_FORUM'] : ''; ?>"><?php echo (isset($this->_rootref['ACTIVE_FORUM'])) ? $this->_rootref['ACTIVE_FORUM'] : ''; ?></a></b><br /><span class="genmed">[ <?php echo (isset($this->_rootref['ACTIVE_FORUM_POSTS'])) ? $this->_rootref['ACTIVE_FORUM_POSTS'] : ''; ?> / <?php echo (isset($this->_rootref['ACTIVE_FORUM_PCT'])) ? $this->_rootref['ACTIVE_FORUM_PCT'] : ''; ?> ]</span><?php } else { ?><span class="gen">-</span><?php } ?></td>
				</tr>
				<tr>
					<td class="gen" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="top" nowrap="nowrap"><?php echo ((isset($this->_rootref['L_ACTIVE_IN_TOPIC'])) ? $this->_rootref['L_ACTIVE_IN_TOPIC'] : ((defined('ACTIVE_IN_TOPIC')) ? ACTIVE_IN_TOPIC : '{ ACTIVE_IN_TOPIC }')); ?>: </td>
					<td><?php if ($this->_rootref['ACTIVE_TOPIC']) {  ?><b><a class="gen" href="<?php echo (isset($this->_rootref['U_ACTIVE_TOPIC'])) ? $this->_rootref['U_ACTIVE_TOPIC'] : ''; ?>"><?php echo (isset($this->_rootref['ACTIVE_TOPIC'])) ? $this->_rootref['ACTIVE_TOPIC'] : ''; ?></a></b><br /><span class="genmed">[ <?php echo (isset($this->_rootref['ACTIVE_TOPIC_POSTS'])) ? $this->_rootref['ACTIVE_TOPIC_POSTS'] : ''; ?> / <?php echo (isset($this->_rootref['ACTIVE_TOPIC_PCT'])) ? $this->_rootref['ACTIVE_TOPIC_PCT'] : ''; ?> ]</span><?php } else { ?><span class="gen">-</span><?php } ?></td>
				</tr>
			<?php } ?>
						</tbody></table>
		</td>
	</tr>
	<tr>

		<td class="cat" align="center"><h4>Contact</h4></td>
		<td class="cat" align="center"><h4>Profile</h4></td>
	</tr>
	<tr>
		<td class="row1">
			<table width="100%" border="0" cellpadding="2" cellspacing="1">
			<tbody><tr>
				<td class="gen" align="right" nowrap="nowrap">E-mail address: </td>

				<td width="100%"><?php echo (isset($this->_rootref['U_EMAIL'])) ? $this->_rootref['U_EMAIL'] : ''; ?></td>
			</tr>
							<tr>
					<td class="gen" align="right" nowrap="nowrap">PM: </td>
					<td><?php echo (isset($this->_rootref['U_PM'])) ? $this->_rootref['U_PM'] : ''; ?></td>
				</tr>
						<tr>
				<td class="gen" align="right" nowrap="nowrap">MSNM/WLM: </td>

				<td><?php echo (isset($this->_rootref['U_MSN'])) ? $this->_rootref['U_MSN'] : ''; ?></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">YIM: </td>
				<td><?php echo (isset($this->_rootref['U_YIM'])) ? $this->_rootref['U_YIM'] : ''; ?></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">AIM: </td>

				<td><?php echo (isset($this->_rootref['U_ICQ'])) ? $this->_rootref['U_ICQ'] : ''; ?></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">ICQ: </td>
				<td><?php echo (isset($this->_rootref['U_ICQ'])) ? $this->_rootref['U_ICQ'] : ''; ?></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Jabber: </td>

				<td><?php echo (isset($this->_rootref['U_JABBER'])) ? $this->_rootref['U_JABBER'] : ''; ?></td>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Skype: </td>

				<td><?php echo (isset($this->_rootref['U_SKYPE'])) ? $this->_rootref['U_SKYPE'] : ''; ?></td>
			</tr>
			</tbody></table>
		</td>
		<td class="row1">
			<table border="0" cellpadding="2" cellspacing="1">
			<tbody><tr>
				<td class="gen" align="right" nowrap="nowrap">Groups: </td>

				<td><?php echo (isset($this->_rootref['S_GROUP_OPTIONS'])) ? $this->_rootref['S_GROUP_OPTIONS'] : ''; ?> <input class="btnlite" name="submit" value="Go" type="submit"></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Location: </td>
				<td><?php echo (isset($this->_rootref['LOCATION'])) ? $this->_rootref['LOCATION'] : ''; ?></td>
			</tr>
						<tr>

				<td class="gen" align="right" nowrap="nowrap">Occupation: </td>
				<td></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Interests: </td>
				<td></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap">Age: </td>
				<td><b class="genmed"><?php echo (isset($this->_rootref['AGE'])) ? $this->_rootref['AGE'] : ''; ?></b></td>
			</tr>
<?php if ($this->_rootref['U_IP']) {  ?>
			<tr>
				<td class="gen" align="right" nowrap="nowrap"><?php echo ((isset($this->_rootref['L__btuseripdisp'])) ? $this->_rootref['L__btuseripdisp'] : ((defined('_btuseripdisp')) ? _btuseripdisp : '{ _btuseripdisp }')); ?>: </td>
				<td><b class="genmed"><?php echo (isset($this->_rootref['U_IP'])) ? $this->_rootref['U_IP'] : ''; ?></b></td>
			</tr>
			<tr>
				<td class="gen" align="right" nowrap="nowrap"><?php echo ((isset($this->_rootref['L__btuseriphost'])) ? $this->_rootref['L__btuseriphost'] : ((defined('_btuseriphost')) ? _btuseriphost : '{ _btuseriphost }')); ?>: </td>
				<td><b class="genmed"><?php echo (isset($this->_rootref['U_IP_HOST'])) ? $this->_rootref['U_IP_HOST'] : ''; ?></b></td>
			</tr>
<?php } ?>
						</tbody></table>
		</td>
	</tr>
	<?php if ($this->_rootref['SIGNATURE']) {  ?>
		<tr>
			<td class="cat" colspan="2" align="center"><h4><?php echo ((isset($this->_rootref['L_SIGNATURE'])) ? $this->_rootref['L_SIGNATURE'] : ((defined('SIGNATURE')) ? SIGNATURE : '{ SIGNATURE }')); ?></h4></td>
		</tr>
		<tr>
			<td class="row1" colspan="2"><div class="postbody" style="padding: 10px;"><?php echo (isset($this->_rootref['SIGNATURE'])) ? $this->_rootref['SIGNATURE'] : ''; ?></div></td>
		</tr>
	<?php } ?>
		</tbody></table>
	
	</form>

</div>
<?php if ($this->_rootref['S_TORRENTSMYU']) {  ?>
<table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">

<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nn ');"><img title="Expand item" id="nn&nbsp;img" src="themes/eVo_silver/pics/minus.gif" alt="+"></a><?php echo ((isset($this->_rootref['L__btpersonal'])) ? $this->_rootref['L__btpersonal'] : ((defined('_btpersonal')) ? _btpersonal : '{ _btpersonal }')); ?>
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td class="row3">
<div id="nn&nbsp;">
<br clear="all">
  <div class="pagination">
    <span>
      <strong>Pages <?php echo (isset($this->_rootref['CURENT_PAGEMYU'])) ? $this->_rootref['CURENT_PAGEMYU'] : ''; ?>/<?php echo (isset($this->_rootref['TOTTAL_PAGESMYU'])) ? $this->_rootref['TOTTAL_PAGESMYU'] : ''; ?></strong>
    </span> • 
	<span>
	  <?php if (! $this->_rootref['PREV_PAGEMYU']) {  ?><strong>&lt;&lt;&lt;&lt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p1=<?php echo (isset($this->_rootref['PREV_PAGEMYU'])) ? $this->_rootref['PREV_PAGEMYU'] : ''; ?>">&lt;&lt;&lt;&lt;</a><?php } ?>
<?php echo (isset($this->_rootref['GENERATED_PAGESMYU'])) ? $this->_rootref['GENERATED_PAGESMYU'] : ''; ?>
	    <?php if (! $this->_rootref['NEXT_PAGEMYU']) {  ?><strong>&gt;&gt;&gt;&gt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p1=<?php echo (isset($this->_rootref['NEXT_PAGEMYU'])) ? $this->_rootref['NEXT_PAGEMYU'] : ''; ?>">&gt;&gt;&gt;&gt;</a><?php } ?>
		<span>
		</span>
      </span>
	</span>
  </span>
</div>
<br>
<br>
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td class="colhead" align="center">Type</td>
<td class="colhead" align="left">Name</td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/completed.gif" alt="Number of Files" title="Number of Files" border="0"></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/comments.png" alt="Comments" title="Comments" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/report.gif" alt="Ratings" title="Ratings" border="0"></td>
<td class="colhead" align="center">Uploaded</td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/completion.gif" alt="AVG Speed" title="AVG Speed" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/servers.png" alt="Size" title="Size" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/completed.png" alt="Downloaded" title="Downloaded" border="0"></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/seeders.png" alt="Seeds" title="Seeds" border="0"></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/leechers.png" alt="Leechers" title="Leechers" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/peers.gif" alt="addedby" title="addedby" border="0"></td>
</tr>
<?php $_torrent_varmyu_count = (isset($this->_tpldata['torrent_varmyu'])) ? sizeof($this->_tpldata['torrent_varmyu']) : 0;if ($_torrent_varmyu_count) {for ($_torrent_varmyu_i = 0; $_torrent_varmyu_i < $_torrent_varmyu_count; ++$_torrent_varmyu_i){$_torrent_varmyu_val = &$this->_tpldata['torrent_varmyu'][$_torrent_varmyu_i]; ?>
<tr>
<td style="padding: 0px;" align="center"><a href="/torrents.php?cat=16"><?php echo $_torrent_varmyu_val['CATEGORY']; ?></a></td>
<td align="left">
  <nobr>
    <p class="title">
	   <nobr>
      <?php if ($_torrent_varmyu_val['NUKED']) {  ?><img src="themes/eVo_silver/pics/nuked.gif" alt="NUKED TORRENT" title="NUKED TORRENT" border="0"><?php } if ($_torrent_varmyu_val['FREE_DL']) {  ?><img src="themes/eVo_silver/pics/magic.gif" alt="FREE TORRENT" title="FREE TORRENT" border="0"><?php } if (! $_torrent_varmyu_val['LOCAL_T']) {  ?><img src="themes/eVo_silver/pics/external.gif" alt="External Tracker" title="External Tracker" border="0"><?php } if ($_torrent_varmyu_val['DHT_INABLED']) {  ?><span class="overlib" onmouseover="return overlib('This torrent supports DHT. With a state-of-the-art client, you\'ll be able to download this torrent even if a central tracker goes down.',CAPTION, 'DHT Support',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',LEFT,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_silver/pics/help.gif',BORDER,2,SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);" onmouseout="return nd();" style="cursor: help;">
	  <img src="themes/eVo_silver/pics/dht.gif" alt="" title="" border="0"></span><?php } ?>
	  <br />
	  <a style="text-decoration: none;" href="details.php?id=<?php echo $_torrent_varmyu_val['ID']; if ($this->_rootref['HIT_COUNT']) {  ?>&amp;hit=1<?php } ?>" title="<?php echo $_torrent_varmyu_val['FULL_NAME']; ?>"><?php echo $_torrent_varmyu_val['SHORTNAME']; ?></a>
	  </nobr></p><?php if ($_torrent_varmyu_val['CAN_DOWN_LOAD']) {  ?><a class="index" href="download.php?id=<?php echo $_torrent_varmyu_val['ID']; ?>"><img style="border: medium none ;" alt="download" src="themes/eVo_silver/pics/download2.gif" align="right"></a><?php } ?>

	  </nobr><br>
	  <?php if ($_torrent_varmyu_val['BANNED']) {  ?><img src="themes/eVo_silver/pics/banned.png" alt="Banned torrent" title="Banned torrent" border="0"><?php } if ($_torrent_varmyu_val['CAN_EDIT']) {  ?><a href="edit.php?id=<?php echo $_torrent_varmyu_val['ID']; ?>"><img src="themes/eVo_silver/pics/edit.gif" alt="Edit" title="Edit" border="0"></a><?php } if ($_torrent_varmyu_val['CAN_DEL']) {  ?><a href="edit.php?op=delete&amp;id=<?php echo $_torrent_varmyu_val['ID']; ?>"><img src="themes/eVo_silver/pics/drop.gif" alt="Delete" title="Delete" border="0"></a><?php } if ($_torrent_varmyu_val['CAN_BAN']) {  ?><a href="edit.php?op=ban&amp;id=<?php echo $_torrent_varmyu_val['ID']; ?>"><img src="themes/eVo_silver/pics/ban.png" alt="Ban Torrent" title="Ban Torrent" border="0"></a><?php } if (! $_torrent_varmyu_val['LOCAL_T']) {  if ($_torrent_varmyu_val['REFRESH_T']) {  ?><a href="scrape-external.php?id=<?php echo $_torrent_varmyu_val['ID']; ?>&amp;tracker=&amp;return=%2Ftemplate_test.php"><img src="themes/eVo_silver/pics/refresh.png" alt="Refresh Peer Data" title="Refresh Peer Data" border="0"></a>
	  <?php } else { ?><img src="themes/eVo_silver/pics/refresh_gray.png" alt="Stats Updated less than 30min ago" title="Stats Updated less than 30min ago" border="0"><?php } if ($_torrent_varmyu_val['NEED_AUTH']) {  echo $_torrent_varmyu_val['AUTH_LINK']; } } ?>
	  <br>
	  <span id="ID<?php echo $_torrent_varmyu_val['ID']; ?>">
	  <a onclick="sndReq('op=view_details&amp;torrent=<?php echo $_torrent_varmyu_val['ID']; ?>', 'ID<?php echo $_torrent_varmyu_val['ID']; ?>')"><img src="themes/eVo_silver/pics/plus.gif" alt="Torrent Details" title="Torrent Details" border="0"></a>
	  </span>
</td>
<td align="right"><a href="/torrents.php?sort=2&amp;type=desc" title="Sort by Number of files desc"><?php echo $_torrent_varmyu_val['NUM_FILE']; ?></a></td>
<td align="right"><b><a href="details.php?id=199&amp;hit=<?php echo $_torrent_varmyu_val['ID']; ?>&amp;comm=startcomments"><?php echo $_torrent_varmyu_val['NUM_COMENTS']; ?></a></b></td>
<td align="center">---</td>
<td align="center"><?php echo $_torrent_varmyu_val['DATE_ADDED']; ?></td>
<td align="center"><?php echo $_torrent_varmyu_val['DOWNLOAD_SP']; ?>/s</td>
<td align="center"><?php echo $_torrent_varmyu_val['DOWNLOAD_SIZE']; ?></td>

<td align="center"><?php echo $_torrent_varmyu_val['TIMES_SNATHED']; ?><br><?php echo ((isset($this->_rootref['L__bttimes'])) ? $this->_rootref['L__bttimes'] : ((defined('_bttimes')) ? _bttimes : '{ _bttimes }')); ?></td>
<td align="right"><b><?php echo $_torrent_varmyu_val['SEEDERS']; ?></b></td>
<td align="right"><b><?php echo $_torrent_varmyu_val['LEECHERS']; ?></b></td>
<td align="center"><?php if ($_torrent_varmyu_val['ANONUMUS_UPLO']) {  echo $_torrent_varmyu_val['UPLOADERS_NAM']; ?> <?php } else { ?> <a href="user.php?op=profile&amp;id=<?php echo $_torrent_varmyu_val['UPLODER_ID']; ?>"><font color="<?php echo $_torrent_varmyu_val['UPLDER_COLOR']; ?>"><?php echo $_torrent_varmyu_val['UPLOADERS_NAM']; ?></font></a><?php } ?></td>
</tr>
<?php }} ?>
</tbody></table>
<br clear="all">
  <div class="pagination">
    <span>
      <strong>Pages <?php echo (isset($this->_rootref['CURENT_PAGEMYU'])) ? $this->_rootref['CURENT_PAGEMYU'] : ''; ?>/<?php echo (isset($this->_rootref['TOTTAL_PAGESMYU'])) ? $this->_rootref['TOTTAL_PAGESMYU'] : ''; ?></strong>
    </span> • 
	<span>
	  <?php if (! $this->_rootref['PREV_PAGEMYU']) {  ?><strong>&lt;&lt;&lt;&lt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p1=<?php echo (isset($this->_rootref['PREV_PAGEMYU'])) ? $this->_rootref['PREV_PAGEMYU'] : ''; ?>">&lt;&lt;&lt;&lt;</a><?php } ?>
<?php echo (isset($this->_rootref['GENERATED_PAGESMYU'])) ? $this->_rootref['GENERATED_PAGESMYU'] : ''; ?>
	    <?php if (! $this->_rootref['NEXT_PAGEMYU']) {  ?><strong>&gt;&gt;&gt;&gt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p1=<?php echo (isset($this->_rootref['NEXT_PAGEMYU'])) ? $this->_rootref['NEXT_PAGEMYU'] : ''; ?>">&gt;&gt;&gt;&gt;</a><?php } ?>
		<span>
		</span>
      </span>
	</span>
  </span>
</div>
</div>
</td></tr>
<tr>

<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</tbody></table>
<br clear="all">
<?php } else { ?>
<table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">

<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nn ');"><img title="Expand item" id="nn&nbsp;img" src="themes/eVo_silver/pics/minus.gif" alt="+"></a><?php echo ((isset($this->_rootref['L__btpersonal'])) ? $this->_rootref['L__btpersonal'] : ((defined('_btpersonal')) ? _btpersonal : '{ _btpersonal }')); ?>
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td class="row3">
<div id="nn&nbsp;">
<h3><?php echo ((isset($this->_rootref['L__btnotorrents'])) ? $this->_rootref['L__btnotorrents'] : ((defined('_btnotorrents')) ? _btnotorrents : '{ _btnotorrents }')); ?></h3>
</div>
</td></tr>
<tr>

<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</tbody></table>
<br clear="all">
<?php } if ($this->_rootref['S_TORRENTSMYS']) {  ?>
<table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">

<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nn ');"><img title="Expand item" id="nn&nbsp;img" src="themes/eVo_silver/pics/minus.gif" alt="+"></a><?php echo ((isset($this->_rootref['L__btseedby'])) ? $this->_rootref['L__btseedby'] : ((defined('_btseedby')) ? _btseedby : '{ _btseedby }')); ?>;
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td class="row3">
<div id="nn&nbsp;">
<br clear="all">
  <div class="pagination">
    <span>
      <strong>Pages <?php echo (isset($this->_rootref['CURENT_PAGEMYS'])) ? $this->_rootref['CURENT_PAGEMYS'] : ''; ?>/<?php echo (isset($this->_rootref['TOTTAL_PAGESMYS'])) ? $this->_rootref['TOTTAL_PAGESMYS'] : ''; ?></strong>
    </span> • 
	<span>
	  <?php if (! $this->_rootref['PREV_PAGEMYS']) {  ?><strong>&lt;&lt;&lt;&lt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p2=<?php echo (isset($this->_rootref['PREV_PAGEMYS'])) ? $this->_rootref['PREV_PAGEMYS'] : ''; ?>">&lt;&lt;&lt;&lt;</a><?php } ?>
<?php echo (isset($this->_rootref['GENERATED_PAGESMYS'])) ? $this->_rootref['GENERATED_PAGESMYS'] : ''; ?>
	    <?php if (! $this->_rootref['NEXT_PAGEMYS']) {  ?><strong>&gt;&gt;&gt;&gt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p2=<?php echo (isset($this->_rootref['NEXT_PAGEMYS'])) ? $this->_rootref['NEXT_PAGEMYS'] : ''; ?>">&gt;&gt;&gt;&gt;</a><?php } ?>
		<span>
		</span>
      </span>
	</span>
  </span>
</div>
<br>
<br>
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td class="colhead" align="center">Type</td>
<td class="colhead" align="left">Name</td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/completed.gif" alt="Number of Files" title="Number of Files" border="0"></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/comments.png" alt="Comments" title="Comments" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/report.gif" alt="Ratings" title="Ratings" border="0"></td>
<td class="colhead" align="center">Uploaded</td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/completion.gif" alt="AVG Speed" title="AVG Speed" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/servers.png" alt="Size" title="Size" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/completed.png" alt="Downloaded" title="Downloaded" border="0"></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/seeders.png" alt="Seeds" title="Seeds" border="0"></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/leechers.png" alt="Leechers" title="Leechers" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/peers.gif" alt="addedby" title="addedby" border="0"></td>
</tr>
<?php $_torrent_varmys_count = (isset($this->_tpldata['torrent_varmys'])) ? sizeof($this->_tpldata['torrent_varmys']) : 0;if ($_torrent_varmys_count) {for ($_torrent_varmys_i = 0; $_torrent_varmys_i < $_torrent_varmys_count; ++$_torrent_varmys_i){$_torrent_varmys_val = &$this->_tpldata['torrent_varmys'][$_torrent_varmys_i]; ?>
<tr>
<td style="padding: 0px;" align="center"><a href="/torrents.php?cat=16"><?php echo $_torrent_varmyu_val['CATEGORY']; ?></a></td>
<td align="left">
  <nobr>
    <p class="title">
	   <nobr>
      <?php if ($_torrent_varmys_val['NUKED']) {  ?><img src="themes/eVo_silver/pics/nuked.gif" alt="NUKED TORRENT" title="NUKED TORRENT" border="0"><?php } if ($_torrent_varmys_val['FREE_DL']) {  ?><img src="themes/eVo_silver/pics/magic.gif" alt="FREE TORRENT" title="FREE TORRENT" border="0"><?php } if (! $_torrent_varmys_val['LOCAL_T']) {  ?><img src="themes/eVo_silver/pics/external.gif" alt="External Tracker" title="External Tracker" border="0"><?php } if ($_torrent_varmys_val['DHT_INABLED']) {  ?><span class="overlib" onmouseover="return overlib('This torrent supports DHT. With a state-of-the-art client, you\'ll be able to download this torrent even if a central tracker goes down.',CAPTION, 'DHT Support',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',LEFT,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_silver/pics/help.gif',BORDER,2,SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);" onmouseout="return nd();" style="cursor: help;">
	  <img src="themes/eVo_silver/pics/dht.gif" alt="" title="" border="0"></span><?php } ?>
	  <br />
	  <a style="text-decoration: none;" href="details.php?id=<?php echo $_torrent_varmys_val['ID']; if ($this->_rootref['HIT_COUNT']) {  ?>&amp;hit=1<?php } ?>" title="<?php echo $_torrent_varmys_val['FULL_NAME']; ?>"><?php echo $_torrent_varmys_val['SHORTNAME']; ?></a>
	  </nobr></p><?php if ($_torrent_varmys_val['CAN_DOWN_LOAD']) {  ?><a class="index" href="download.php?id=<?php echo $_torrent_varmys_val['ID']; ?>"><img style="border: medium none ;" alt="download" src="themes/eVo_silver/pics/download2.gif" align="right"></a><?php } ?>

	  </nobr><br>
	  <?php if ($_torrent_varmys_val['BANNED']) {  ?><img src="themes/eVo_silver/pics/banned.png" alt="Banned torrent" title="Banned torrent" border="0"><?php } if ($_torrent_varmys_val['CAN_EDIT']) {  ?><a href="edit.php?id=<?php echo $_torrent_varmys_val['ID']; ?>"><img src="themes/eVo_silver/pics/edit.gif" alt="Edit" title="Edit" border="0"></a><?php } if ($_torrent_varmys_val['CAN_DEL']) {  ?><a href="edit.php?op=delete&amp;id=<?php echo $_torrent_varmys_val['ID']; ?>"><img src="themes/eVo_silver/pics/drop.gif" alt="Delete" title="Delete" border="0"></a><?php } if ($_torrent_varmys_val['CAN_BAN']) {  ?><a href="edit.php?op=ban&amp;id=<?php echo $_torrent_varmys_val['ID']; ?>"><img src="themes/eVo_silver/pics/ban.png" alt="Ban Torrent" title="Ban Torrent" border="0"></a><?php } if (! $_torrent_varmys_val['LOCAL_T']) {  if ($_torrent_varmys_val['REFRESH_T']) {  ?><a href="scrape-external.php?id=<?php echo $_torrent_varmys_val['ID']; ?>&amp;tracker=&amp;return=%2Ftemplate_test.php"><img src="themes/eVo_silver/pics/refresh.png" alt="Refresh Peer Data" title="Refresh Peer Data" border="0"></a>
	  <?php } else { ?><img src="themes/eVo_silver/pics/refresh_gray.png" alt="Stats Updated less than 30min ago" title="Stats Updated less than 30min ago" border="0"><?php } if ($_torrent_varmys_val['NEED_AUTH']) {  echo $_torrent_varmys_val['AUTH_LINK']; } } ?>
	  <br>
	  <span id="ID<?php echo $_torrent_varmys_val['ID']; ?>">
	  <a onclick="sndReq('op=view_details&amp;torrent=<?php echo $_torrent_varmys_val['ID']; ?>', 'ID<?php echo $_torrent_varmys_val['ID']; ?>')"><img src="themes/eVo_silver/pics/plus.gif" alt="Torrent Details" title="Torrent Details" border="0"></a>
	  </span>
</td>
<td align="right"><a href="/torrents.php?sort=2&amp;type=desc" title="Sort by Number of files desc"><?php echo $_torrent_varmys_val['NUM_FILE']; ?></a></td>
<td align="right"><b><a href="details.php?id=199&amp;hit=<?php echo $_torrent_varmys_val['ID']; ?>&amp;comm=startcomments"><?php echo $_torrent_varmys_val['NUM_COMENTS']; ?></a></b></td>
<td align="center">---</td>
<td align="center"><?php echo $_torrent_varmys_val['DATE_ADDED']; ?></td>
<td align="center"><?php echo $_torrent_varmys_val['DOWNLOAD_SP']; ?>/s</td>
<td align="center"><?php echo $_torrent_varmys_val['DOWNLOAD_SIZE']; ?></td>

<td align="center"><?php echo $_torrent_varmys_val['TIMES_SNATHED']; ?><br><?php echo ((isset($this->_rootref['L__bttimes'])) ? $this->_rootref['L__bttimes'] : ((defined('_bttimes')) ? _bttimes : '{ _bttimes }')); ?></td>
<td align="right"><b><?php echo $_torrent_varmys_val['SEEDERS']; ?></b></td>
<td align="right"><b><?php echo $_torrent_varmys_val['LEECHERS']; ?></b></td>
<td align="center"><?php if ($_torrent_varmys_val['ANONUMUS_UPLO']) {  echo $_torrent_varmys_val['UPLOADERS_NAM']; ?> <?php } else { ?> <a href="user.php?op=profile&amp;id=<?php echo $_torrent_varmys_val['UPLODER_ID']; ?>"><font color="<?php echo $_torrent_varmys_val['UPLDER_COLOR']; ?>"><?php echo $_torrent_varmys_val['UPLOADERS_NAM']; ?></font></a><?php } ?></td>
</tr>
<?php }} ?>
</tbody></table>
<br clear="all">
  <div class="pagination">
    <span>
      <strong>Pages <?php echo (isset($this->_rootref['CURENT_PAGEMYS'])) ? $this->_rootref['CURENT_PAGEMYS'] : ''; ?>/<?php echo (isset($this->_rootref['TOTTAL_PAGESMYS'])) ? $this->_rootref['TOTTAL_PAGESMYS'] : ''; ?></strong>
    </span> • 
	<span>
	  <?php if (! $this->_rootref['PREV_PAGEMYS']) {  ?><strong>&lt;&lt;&lt;&lt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p2=<?php echo (isset($this->_rootref['PREV_PAGEMYS'])) ? $this->_rootref['PREV_PAGEMYS'] : ''; ?>">&lt;&lt;&lt;&lt;</a><?php } ?>
<?php echo (isset($this->_rootref['GENERATED_PAGESMYU'])) ? $this->_rootref['GENERATED_PAGESMYU'] : ''; ?>
	    <?php if (! $this->_rootref['NEXT_PAGEMYS']) {  ?><strong>&gt;&gt;&gt;&gt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p2=<?php echo (isset($this->_rootref['NEXT_PAGEMYS'])) ? $this->_rootref['NEXT_PAGEMYS'] : ''; ?>">&gt;&gt;&gt;&gt;</a><?php } ?>
		<span>
		</span>
      </span>
	</span>
  </span>
</div>
</td></tr>
<tr>

<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</tbody></table>
<br clear="all">
<?php } else { ?>
<table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">

<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nn ');"><img title="Expand item" id="nn&nbsp;img" src="themes/eVo_silver/pics/minus.gif" alt="+"></a><?php echo ((isset($this->_rootref['L__btseedby'])) ? $this->_rootref['L__btseedby'] : ((defined('_btseedby')) ? _btseedby : '{ _btseedby }')); ?>;
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td class="row3">
<div id="nn&nbsp;">
<h3><?php echo ((isset($this->_rootref['L__btnotorrents'])) ? $this->_rootref['L__btnotorrents'] : ((defined('_btnotorrents')) ? _btnotorrents : '{ _btnotorrents }')); ?></h3>
</div>
</td></tr>
<tr>

<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</tbody></table>
<br clear="all">
<?php } if ($this->_rootref['S_TORRENTSMYL']) {  ?>
<table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">

<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nn ');"><img title="Expand item" id="nn&nbsp;img" src="themes/eVo_silver/pics/minus.gif" alt="+"></a><?php echo ((isset($this->_rootref['L__btleechby'])) ? $this->_rootref['L__btleechby'] : ((defined('_btleechby')) ? _btleechby : '{ _btleechby }')); ?>;
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td class="row3">
<div id="nn&nbsp;">
<br clear="all">
  <div class="pagination">
    <span>
      <strong>Pages <?php echo (isset($this->_rootref['CURENT_PAGEMYL'])) ? $this->_rootref['CURENT_PAGEMYL'] : ''; ?>/<?php echo (isset($this->_rootref['TOTTAL_PAGESMYL'])) ? $this->_rootref['TOTTAL_PAGESMYL'] : ''; ?></strong>
    </span> • 
	<span>
	  <?php if (! $this->_rootref['PREV_PAGEMYL']) {  ?><strong>&lt;&lt;&lt;&lt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p3=<?php echo (isset($this->_rootref['PREV_PAGEMYL'])) ? $this->_rootref['PREV_PAGEMYL'] : ''; ?>">&lt;&lt;&lt;&lt;</a><?php } ?>
<?php echo (isset($this->_rootref['GENERATED_PAGESMYL'])) ? $this->_rootref['GENERATED_PAGESMYL'] : ''; ?>
	    <?php if (! $this->_rootref['NEXT_PAGEMYL']) {  ?><strong>&gt;&gt;&gt;&gt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p3=<?php echo (isset($this->_rootref['NEXT_PAGEMYL'])) ? $this->_rootref['NEXT_PAGEMYL'] : ''; ?>">&gt;&gt;&gt;&gt;</a><?php } ?>
		<span>
		</span>
      </span>
	</span>
  </span>
</div>
<br>
<br>
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td class="colhead" align="center">Type</td>
<td class="colhead" align="left">Name</td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/completed.gif" alt="Number of Files" title="Number of Files" border="0"></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/comments.png" alt="Comments" title="Comments" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/report.gif" alt="Ratings" title="Ratings" border="0"></td>
<td class="colhead" align="center">Uploaded</td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/completion.gif" alt="AVG Speed" title="AVG Speed" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/servers.png" alt="Size" title="Size" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/completed.png" alt="Downloaded" title="Downloaded" border="0"></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/seeders.png" alt="Seeds" title="Seeds" border="0"></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/leechers.png" alt="Leechers" title="Leechers" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/peers.gif" alt="addedby" title="addedby" border="0"></td>
</tr>
<?php $_torrent_varmyl_count = (isset($this->_tpldata['torrent_varmyl'])) ? sizeof($this->_tpldata['torrent_varmyl']) : 0;if ($_torrent_varmyl_count) {for ($_torrent_varmyl_i = 0; $_torrent_varmyl_i < $_torrent_varmyl_count; ++$_torrent_varmyl_i){$_torrent_varmyl_val = &$this->_tpldata['torrent_varmyl'][$_torrent_varmyl_i]; ?>
<tr>
<td style="padding: 0px;" align="center"><a href="/torrents.php?cat=16"><?php echo $_torrent_varmyu_val['CATEGORY']; ?></a></td>
<td align="left">
  <nobr>
    <p class="title">
	   <nobr>
      <?php if ($_torrent_varmyl_val['NUKED']) {  ?><img src="themes/eVo_silver/pics/nuked.gif" alt="NUKED TORRENT" title="NUKED TORRENT" border="0"><?php } if ($_torrent_varmyl_val['FREE_DL']) {  ?><img src="themes/eVo_silver/pics/magic.gif" alt="FREE TORRENT" title="FREE TORRENT" border="0"><?php } if (! $_torrent_varmyl_val['LOCAL_T']) {  ?><img src="themes/eVo_silver/pics/external.gif" alt="External Tracker" title="External Tracker" border="0"><?php } if ($_torrent_varmyl_val['DHT_INABLED']) {  ?><span class="overlib" onmouseover="return overlib('This torrent supports DHT. With a state-of-the-art client, you\'ll be able to download this torrent even if a central tracker goes down.',CAPTION, 'DHT Support',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',LEFT,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_silver/pics/help.gif',BORDER,2,SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);" onmouseout="return nd();" style="cursor: help;">
	  <img src="themes/eVo_silver/pics/dht.gif" alt="" title="" border="0"></span><?php } ?>
	  <br />
	  <a style="text-decoration: none;" href="details.php?id=<?php echo $_torrent_varmyl_val['ID']; if ($this->_rootref['HIT_COUNT']) {  ?>&amp;hit=1<?php } ?>" title="<?php echo $_torrent_varmyl_val['FULL_NAME']; ?>"><?php echo $_torrent_varmyl_val['SHORTNAME']; ?></a>
	  </nobr></p><?php if ($_torrent_varmyl_val['CAN_DOWN_LOAD']) {  ?><a class="index" href="download.php?id=<?php echo $_torrent_varmyl_val['ID']; ?>"><img style="border: medium none ;" alt="download" src="themes/eVo_silver/pics/download2.gif" align="right"></a><?php } ?>

	  </nobr><br>
	  <?php if ($_torrent_varmyl_val['BANNED']) {  ?><img src="themes/eVo_silver/pics/banned.png" alt="Banned torrent" title="Banned torrent" border="0"><?php } if ($_torrent_varmyl_val['CAN_EDIT']) {  ?><a href="edit.php?id=<?php echo $_torrent_varmyl_val['ID']; ?>"><img src="themes/eVo_silver/pics/edit.gif" alt="Edit" title="Edit" border="0"></a><?php } if ($_torrent_varmyl_val['CAN_DEL']) {  ?><a href="edit.php?op=delete&amp;id=<?php echo $_torrent_varmyl_val['ID']; ?>"><img src="themes/eVo_silver/pics/drop.gif" alt="Delete" title="Delete" border="0"></a><?php } if ($_torrent_varmyl_val['CAN_BAN']) {  ?><a href="edit.php?op=ban&amp;id=<?php echo $_torrent_varmyl_val['ID']; ?>"><img src="themes/eVo_silver/pics/ban.png" alt="Ban Torrent" title="Ban Torrent" border="0"></a><?php } if (! $_torrent_varmyl_val['LOCAL_T']) {  if ($_torrent_varmyl_val['REFRESH_T']) {  ?><a href="scrape-external.php?id=<?php echo $_torrent_varmyl_val['ID']; ?>&amp;tracker=&amp;return=%2Ftemplate_test.php"><img src="themes/eVo_silver/pics/refresh.png" alt="Refresh Peer Data" title="Refresh Peer Data" border="0"></a>
	  <?php } else { ?><img src="themes/eVo_silver/pics/refresh_gray.png" alt="Stats Updated less than 30min ago" title="Stats Updated less than 30min ago" border="0"><?php } if ($_torrent_varmyl_val['NEED_AUTH']) {  echo $_torrent_varmyl_val['AUTH_LINK']; } } ?>
	  <br>
	  <span id="ID<?php echo $_torrent_varmyl_val['ID']; ?>">
	  <a onclick="sndReq('op=view_details&amp;torrent=<?php echo $_torrent_varmyl_val['ID']; ?>', 'ID<?php echo $_torrent_varmyl_val['ID']; ?>')"><img src="themes/eVo_silver/pics/plus.gif" alt="Torrent Details" title="Torrent Details" border="0"></a>
	  </span>
</td>
<td align="right"><a href="/torrents.php?sort=2&amp;type=desc" title="Sort by Number of files desc"><?php echo $_torrent_varmyl_val['NUM_FILE']; ?></a></td>
<td align="right"><b><a href="details.php?id=199&amp;hit=<?php echo $_torrent_varmyl_val['ID']; ?>&amp;comm=startcomments"><?php echo $_torrent_varmyl_val['NUM_COMENTS']; ?></a></b></td>
<td align="center">---</td>
<td align="center"><?php echo $_torrent_varmyl_val['DATE_ADDED']; ?></td>
<td align="center"><?php echo $_torrent_varmyl_val['DOWNLOAD_SP']; ?>/s</td>
<td align="center"><?php echo $_torrent_varmyl_val['DOWNLOAD_SIZE']; ?></td>

<td align="center"><?php echo $_torrent_varmyl_val['TIMES_SNATHED']; ?><br><?php echo ((isset($this->_rootref['L__bttimes'])) ? $this->_rootref['L__bttimes'] : ((defined('_bttimes')) ? _bttimes : '{ _bttimes }')); ?></td>
<td align="right"><b><?php echo $_torrent_varmyl_val['SEEDERS']; ?></b></td>
<td align="right"><b><?php echo $_torrent_varmyl_val['LEECHERS']; ?></b></td>
<td align="center"><?php if ($_torrent_varmyl_val['ANONUMUS_UPLO']) {  echo $_torrent_varmyl_val['UPLOADERS_NAM']; ?> <?php } else { ?> <a href="user.php?op=profile&amp;id=<?php echo $_torrent_varmyl_val['UPLODER_ID']; ?>"><font color="<?php echo $_torrent_varmyl_val['UPLDER_COLOR']; ?>"><?php echo $_torrent_varmyl_val['UPLOADERS_NAM']; ?></font></a><?php } ?></td>
</tr>
<?php }} ?>
</tbody></table>
<br clear="all">
  <div class="pagination">
    <span>
      <strong>Pages <?php echo (isset($this->_rootref['CURENT_PAGEMYL'])) ? $this->_rootref['CURENT_PAGEMYL'] : ''; ?>/<?php echo (isset($this->_rootref['TOTTAL_PAGESMYL'])) ? $this->_rootref['TOTTAL_PAGESMYL'] : ''; ?></strong>
    </span> • 
	<span>
	  <?php if (! $this->_rootref['PREV_PAGE']) {  ?><strong>&lt;&lt;&lt;&lt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p3=<?php echo (isset($this->_rootref['PREV_PAGEMYL'])) ? $this->_rootref['PREV_PAGEMYL'] : ''; ?>">&lt;&lt;&lt;&lt;</a><?php } ?>
<?php echo (isset($this->_rootref['GENERATED_PAGESMYL'])) ? $this->_rootref['GENERATED_PAGESMYL'] : ''; ?>
	    <?php if (! $this->_rootref['NEXT_PAGE']) {  ?><strong>&gt;&gt;&gt;&gt;</strong><?php } else { ?><a href="user.php?op=profile&id=<?php echo (isset($this->_rootref['CP_UID'])) ? $this->_rootref['CP_UID'] : ''; ?>&p3=<?php echo (isset($this->_rootref['NEXT_PAGEMYL'])) ? $this->_rootref['NEXT_PAGEMYL'] : ''; ?>">&gt;&gt;&gt;&gt;</a><?php } ?>
		<span>
		</span>
      </span>
	</span>
  </span>
</div>
</td></tr>
<tr>

<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</tbody></table>
<br clear="all">
<?php } else { ?>
<table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">

<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nn ');"><img title="Expand item" id="nn&nbsp;img" src="themes/eVo_silver/pics/minus.gif" alt="+"></a><?php echo ((isset($this->_rootref['L__btleechby'])) ? $this->_rootref['L__btleechby'] : ((defined('_btleechby')) ? _btleechby : '{ _btleechby }')); ?>;
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td class="row3">
<div id="nn&nbsp;">
<h3><?php echo ((isset($this->_rootref['L__btnotorrents'])) ? $this->_rootref['L__btnotorrents'] : ((defined('_btnotorrents')) ? _btnotorrents : '{ _btnotorrents }')); ?></h3>
</div>
</td></tr>
<tr>

<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</tbody></table>
<br clear="all">
<?php } ?></tr></table>
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