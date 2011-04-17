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
<div ><table class="tablebg" width="100%" cellspacing="0">

<tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnGeneral');"><img title="Expand item" id="nnGeneralimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>General
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnGeneral">
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="forumline" align="center">
<tr><td class="row2" width="100%"><a href="index.php">Index </a></td></tr>
<tr><td class="row1" width="100%"><a href="rules.php">Rules</a></td></tr>
<tr><td class="row2" width="100%"><a href="faq.php">FAQ'S</a></td></tr>

<tr><td class="row1" width="100%"><a href="forums.php">Forum</a></td></tr>
<tr><td class="row1" width="100%"><a href="chat.php">IRC Chat</a></td></tr>
<tr><td class="row1" width="100%"><a href="mytorrents.php">Your Torrents</a></td></tr>
<tr><td class="row1" width="100%"><a href="torrents.php">Browse</a></td></tr>
<tr><td class="row1" width="100%"><a href="pm.php"><span id="nopm_notif">Private Messages</span></a></td></tr>
<tr><td class="row1" width="100%"><a href="user.php?op=profile&amp;id=<?php echo (isset($this->_rootref['S_USER_ID'])) ? $this->_rootref['S_USER_ID'] : ''; ?>">User Control Panel</a></td></tr>
<tr><td class="row1" width="100%"><a href="memberslist.php">Members List</a></td></tr>
<?php if ($this->_rootref['U_USER']) {  ?><tr><td class="row1" width="100%"><a href="user.php?op=logout">Log Out</a></td></tr><?php } ?>
<tr><td class="row1" width="100%"><a href="games.php">Games</a></td></tr>

<tr><td class="row1" width="100%"><a href="viewrequests.php">View Requests</a></td></tr>
<tr><td class="row1" width="100%"><a href="offers.php">Torrents Offered</a></td></tr>
<tr><td class="row1" width="100%"><a href="helpdesk.php">Help Desk</a></td></tr>
<tr><td class="row2" width="100%"><a href="youtube.php">Video's</a></td></tr>
<?php if ($this->_rootref['U_ADMIN']) {  ?><tr><td class="row1" width="100%"><a href="admin.php">Administration</a></td></tr><?php } ?>
</table>
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
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnDonations');"><img title="Expand item" id="nnDonationsimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>Donations
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnDonations">
<p class="donation" align="center" ><br><?php echo ((isset($this->_rootref['L__btdonationsprogress'])) ? $this->_rootref['L__btdonationsprogress'] : ((defined('_btdonationsprogress')) ? _btdonationsprogress : '{ _btdonationsprogress }')); ?></p>

<table class=main border=0 width=144px>
<tr>

<td style='padding: 0px; background-image: url(images/loadbarbg.gif); background-repeat: repeat-x'><?php echo (isset($this->_rootref['DONATION_IMAGE'])) ? $this->_rootref['DONATION_IMAGE'] : ''; ?>
<br>
<p class="donation" align="center" ><?php echo (isset($this->_rootref['DONATION_PERC'])) ? $this->_rootref['DONATION_PERC'] : ''; ?>%</p>
</td>
</tr>
</table><p class="donation"> <?php echo ((isset($this->_rootref['L__btdonationsgoal'])) ? $this->_rootref['L__btdonationsgoal'] : ((defined('_btdonationsgoal')) ? _btdonationsgoal : '{ _btdonationsgoal }')); ?> 
<font color="red"><?php echo (isset($this->_rootref['DONATION_ASKED'])) ? $this->_rootref['DONATION_ASKED'] : ''; ?></font><br>
 <?php echo ((isset($this->_rootref['L__btdonationscollected'])) ? $this->_rootref['L__btdonationscollected'] : ((defined('_btdonationscollected')) ? _btdonationscollected : '{ _btdonationscollected }')); ?> 
 <font color="green"><?php echo (isset($this->_rootref['DONATION_IN'])) ? $this->_rootref['DONATION_IN'] : ''; ?></font>
 </p>
<br><br>

<B><font color=red>&raquo;</font></B>
<a href="donate.php"><?php echo ((isset($this->_rootref['L__btdonationsdonate'])) ? $this->_rootref['L__btdonationsdonate'] : ((defined('_btdonationsdonate')) ? _btdonationsdonate : '{ _btdonationsdonate }')); ?></a><br></div>
</td></tr>
<tr>
<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</table>
<br clear="all" >
</div></td>
<td width="65%" valign="top">
<div id="center"><table class="tablebg" width="100%" cellspacing="0">
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
<br clear="all" ><?php if ($this->_rootref['S_TORRENTS']) {  ?>
<table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">

<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nn ');"><img title="Expand item" id="nn&nbsp;img" src="themes/eVo_silver/pics/minus.gif" alt="+"></a>&nbsp;
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td class="row3">
<div id="nn&nbsp;">
<p class="explane"><?php echo ((isset($this->_rootref['L__btmfreetorrentexplain'])) ? $this->_rootref['L__btmfreetorrentexplain'] : ((defined('_btmfreetorrentexplain')) ? _btmfreetorrentexplain : '{ _btmfreetorrentexplain }')); ?></p>
<br>
<br>
<p class="explane"><?php echo ((isset($this->_rootref['L__btmnuketorrentexplain'])) ? $this->_rootref['L__btmnuketorrentexplain'] : ((defined('_btmnuketorrentexplain')) ? _btmnuketorrentexplain : '{ _btmnuketorrentexplain }')); ?></p>
</div>
</td></tr>
<tr>

<td class="cat" colspan="7" valign="middle" align="center"></td>
</tr>
</tbody></table>
<br clear="all">
  <div class="pagination">
    <span>
      <strong>Pages <?php echo (isset($this->_rootref['CURENT_PAGE'])) ? $this->_rootref['CURENT_PAGE'] : ''; ?>/<?php echo (isset($this->_rootref['TOTTAL_PAGES'])) ? $this->_rootref['TOTTAL_PAGES'] : ''; ?></strong>
    </span> • 
	<span>
	  <?php if (! $this->_rootref['PREV_PAGE']) {  ?><strong>&lt;&lt;&lt;&lt;</strong><?php } else { ?><a href="torrents.php?page=<?php echo (isset($this->_rootref['PREV_PAGE'])) ? $this->_rootref['PREV_PAGE'] : ''; ?>">&lt;&lt;&lt;&lt;</a><?php } ?>
<?php echo (isset($this->_rootref['GENERATED_PAGES'])) ? $this->_rootref['GENERATED_PAGES'] : ''; ?>
	    <?php if (! $this->_rootref['NEXT_PAGE']) {  ?><strong>&gt;&gt;&gt;&gt;</strong><?php } else { ?><a href="torrents.php?page=<?php echo (isset($this->_rootref['NEXT_PAGE'])) ? $this->_rootref['NEXT_PAGE'] : ''; ?>">&gt;&gt;&gt;&gt;</a><?php } ?>
		<span>
		</span>
      </span>
	</span>
  </span>
</div>
<br>
<br>
<table border="1" cellpadding="5" cellspacing="0">
<tbody><tr>
<td class="colhead" align="center"><a href="/torrents.php?sort=4&amp;type=desc" title="Sort by Type desc">Type</a></td>
<td class="colhead" align="left"><a href="/torrents.php?sort=1&amp;type=asc" title="Sort by Name asc">Name</a></td>
<td class="colhead" align="right"><a href="/torrents.php?sort=2&amp;type=desc" title="Sort by Number of files desc"><img src="themes/eVo_silver/pics/completed.gif" alt="Number of Files" title="Number of Files" border="0"></a></td>
<td class="colhead" align="right"><img src="themes/eVo_silver/pics/comments.png" alt="Comments" title="Comments" border="0"></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/report.gif" alt="Ratings" title="Ratings" border="0"></td>
<td class="colhead" align="center">Uploaded</td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/completion.gif" alt="AVG Speed" title="AVG Speed" border="0"></td>
<td class="colhead" align="center"><a href="/torrents.php?sort=5&amp;type=desc" title="Sort by Number of files desc"><img src="themes/eVo_silver/pics/servers.png" alt="Size" title="Size" border="0"></a></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/completed.png" alt="Downloaded" title="Downloaded" border="0"></td>
<td class="colhead" align="right"><a href="/torrents.php?sort=7&amp;type=desc" title="Sort by Seeds desc"><img src="themes/eVo_silver/pics/seeders.png" alt="Seeds" title="Seeds" border="0"></a></td>
<td class="colhead" align="right"><a href="/torrents.php?sort=8&amp;type=desc" title="Sort by Leechers desc"><img src="themes/eVo_silver/pics/leechers.png" alt="Leechers" title="Leechers" border="0"></a></td>
<td class="colhead" align="center"><img src="themes/eVo_silver/pics/peers.gif" alt="addedby" title="addedby" border="0"></td>
</tr>
<?php $_torrent_var_count = (isset($this->_tpldata['torrent_var'])) ? sizeof($this->_tpldata['torrent_var']) : 0;if ($_torrent_var_count) {for ($_torrent_var_i = 0; $_torrent_var_i < $_torrent_var_count; ++$_torrent_var_i){$_torrent_var_val = &$this->_tpldata['torrent_var'][$_torrent_var_i]; ?>
<tr>
<td style="padding: 0px;" align="center"><a href="/torrents.php?cat=<?php echo $_torrent_var_val['CAT_ID']; ?>"><?php echo $_torrent_var_val['CATEGORY']; ?></a></td>
<td align="left">
  <nobr>
    <p class="title">
	   <nobr>
      <?php if ($_torrent_var_val['NUKED']) {  ?><img src="themes/eVo_silver/pics/nuked.gif" alt="NUKED TORRENT" title="NUKED TORRENT" border="0"><?php } if ($_torrent_var_val['FREE_DL']) {  ?><img src="themes/eVo_silver/pics/magic.gif" alt="FREE TORRENT" title="FREE TORRENT" border="0"><?php } if (! $_torrent_var_val['LOCAL_T']) {  ?><img src="themes/eVo_silver/pics/external.gif" alt="External Tracker" title="External Tracker" border="0"><?php } if ($_torrent_var_val['DHT_INABLED']) {  ?><span class="overlib" onmouseover="return overlib('This torrent supports DHT. With a state-of-the-art client, you\'ll be able to download this torrent even if a central tracker goes down.',CAPTION, 'DHT Support',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',LEFT,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_silver/pics/help.gif',BORDER,2,SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);" onmouseout="return nd();" style="cursor: help;">
	  <img src="themes/eVo_silver/pics/dht.gif" alt="" title="" border="0"></span><?php } ?>
	  <br />
	  <a style="text-decoration: none;" href="details.php?id=<?php echo $_torrent_var_val['ID']; if ($this->_rootref['HIT_COUNT']) {  ?>&amp;hit=1<?php } ?>" title="<?php echo $_torrent_var_val['FULL_NAME']; ?>"><?php echo $_torrent_var_val['SHORTNAME']; ?></a>
	  </nobr></p><?php if ($_torrent_var_val['CAN_DOWN_LOAD']) {  ?><a class="index" href="download.php?id=<?php echo $_torrent_var_val['ID']; ?>"><img style="border: medium none ;" alt="download" src="themes/eVo_silver/pics/download2.gif" align="right"></a><?php } ?>
	  </nobr><br>
	  <?php if ($_torrent_var_val['BANNED']) {  ?><img src="themes/eVo_silver/pics/banned.png" alt="Banned torrent" title="Banned torrent" border="0"><?php } if ($_torrent_var_val['CAN_EDIT']) {  ?><a href="edit.php?id=<?php echo $_torrent_var_val['ID']; ?>"><img src="themes/eVo_silver/pics/edit.gif" alt="Edit" title="Edit" border="0"></a><?php } if ($_torrent_var_val['CAN_DEL']) {  ?><a href="edit.php?op=delete&amp;id=<?php echo $_torrent_var_val['ID']; ?>"><img src="themes/eVo_silver/pics/drop.gif" alt="Delete" title="Delete" border="0"></a><?php } if ($_torrent_var_val['CAN_BAN']) {  ?><a href="edit.php?op=ban&amp;id=<?php echo $_torrent_var_val['ID']; ?>"><img src="themes/eVo_silver/pics/ban.png" alt="Ban Torrent" title="Ban Torrent" border="0"></a><?php } if (! $_torrent_var_val['LOCAL_T']) {  if ($_torrent_var_val['REFRESH_T']) {  ?><a href="scrape-external.php?id=<?php echo $_torrent_var_val['ID']; ?>&amp;tracker=&amp;return=%2Ftemplate_test.php"><img src="themes/eVo_silver/pics/refresh.png" alt="Refresh Peer Data" title="Refresh Peer Data" border="0"></a>
	  <?php } else { ?><img src="themes/eVo_silver/pics/refresh_gray.png" alt="Stats Updated less than 30min ago" title="Stats Updated less than 30min ago" border="0"><?php } if ($_torrent_var_val['NEED_AUTH']) {  echo $_torrent_var_val['AUTH_LINK']; } } ?>
	  <br>
	  <span id="ID<?php echo $_torrent_var_val['ID']; ?>">
	  <a onclick="sndReq('op=view_details&amp;torrent=<?php echo $_torrent_var_val['ID']; ?>', 'ID<?php echo $_torrent_var_val['ID']; ?>')"><img src="themes/eVo_silver/pics/plus.gif" alt="Torrent Details" title="Torrent Details" border="0"></a>
	  </span>
</td>
<td align="right"><a href="/torrents.php?sort=2&amp;type=desc" title="Sort by Number of files desc"><?php echo $_torrent_var_val['NUM_FILE']; ?></a></td>
<td align="right"><b><a href="details.php?id=199&amp;hit=<?php echo $_torrent_var_val['ID']; ?>&amp;comm=startcomments"><?php echo $_torrent_var_val['NUM_COMENTS']; ?></a></b></td>
<td align="center">---</td>
<td align="center"><?php echo $_torrent_var_val['DATE_ADDED']; ?></td>
<td align="center"><?php echo $_torrent_var_val['DOWNLOAD_SP']; ?>/s</td>
<td align="center"><?php echo $_torrent_var_val['DOWNLOAD_SIZE']; ?></td>

<td align="center"><?php echo $_torrent_var_val['TIMES_SNATHED']; ?><br><?php echo ((isset($this->_rootref['L__bttimes'])) ? $this->_rootref['L__bttimes'] : ((defined('_bttimes')) ? _bttimes : '{ _bttimes }')); ?></td>
<td align="right"><b><?php echo $_torrent_var_val['SEEDERS']; ?></b></td>
<td align="right"><b><?php echo $_torrent_var_val['LEECHERS']; ?></b></td>
<td align="center"><?php if ($_torrent_var_val['ANONUMUS_UPLO']) {  echo $_torrent_var_val['UPLOADERS_NAM']; ?> <?php } else { ?> <a href="user.php?op=profile&amp;id=<?php echo $_torrent_var_val['UPLODER_ID']; ?>"><font color="<?php echo $_torrent_var_val['UPLDER_COLOR']; ?>"><?php echo $_torrent_var_val['UPLOADERS_NAM']; ?></font></a><?php } ?></td>
</tr>
<?php }} ?>
</tbody></table>
<br clear="all">
  <div class="pagination">
    <span>
      <strong>Pages <?php echo (isset($this->_rootref['CURENT_PAGE'])) ? $this->_rootref['CURENT_PAGE'] : ''; ?>/<?php echo (isset($this->_rootref['TOTTAL_PAGES'])) ? $this->_rootref['TOTTAL_PAGES'] : ''; ?></strong>
    </span> • 
	<span>
	  <?php if (! $this->_rootref['PREV_PAGE']) {  ?><strong>&lt;&lt;&lt;&lt;</strong><?php } else { ?><a href="torrents.php?page=<?php echo (isset($this->_rootref['PREV_PAGE'])) ? $this->_rootref['PREV_PAGE'] : ''; ?>">&lt;&lt;&lt;&lt;</a><?php } ?>
<?php echo (isset($this->_rootref['GENERATED_PAGES'])) ? $this->_rootref['GENERATED_PAGES'] : ''; ?>
	    <?php if (! $this->_rootref['NEXT_PAGE']) {  ?><strong>&gt;&gt;&gt;&gt;</strong><?php } else { ?><a href="torrents.php?page=<?php echo (isset($this->_rootref['NEXT_PAGE'])) ? $this->_rootref['NEXT_PAGE'] : ''; ?>">&gt;&gt;&gt;&gt;</a><?php } ?>
		<span>
		</span>
      </span>
	</span>
  </span>
</div>
<?php } else { ?>
<table class="tablebg" width="100%" cellspacing="0">
<tbody><tr><td>
<div class="caption">
<div class="cap-left">
<div class="cap-right">

<a class="c4" style="cursor: pointer; float: left;" onclick="toggle2('nn ');"><img title="Expand item" id="nn&nbsp;img" src="themes/eVo_silver/pics/minus.gif" alt="+"></a>&nbsp;
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
<?php } ?><h2><center><font size="4">Disclaimer</font></center></h2>
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
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnUpload_guide');"><img title="Expand item" id="nnUpload_guideimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>Upload guide
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
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnPersonal_stats');"><img title="Expand item" id="nnPersonal_statsimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>Personal stats
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnPersonal_stats">
<p><img src="themes/eVo_silver/pics/pic_uploaded.gif" border="0" alt="" title=""   /><?php echo (isset($this->_rootref['U_UPLOADED'])) ? $this->_rootref['U_UPLOADED'] : ''; ?><br><img src="themes/eVo_silver/pics/pic_downloaded.gif" border="0" alt="" title=""   /><?php echo (isset($this->_rootref['U_DOWNLOADED'])) ? $this->_rootref['U_DOWNLOADED'] : ''; ?><br><img src="themes/eVo_silver/pics/pic_ratio.gif" border="0" alt="" title=""   />&nbsp;<?php echo (isset($this->_rootref['U_RATIO'])) ? $this->_rootref['U_RATIO'] : ''; ?><br>

<?php if ($this->_rootref['U_TSEEDING']) {  ?><span class="overlib" onmouseover="return overlib('<?php echo (isset($this->_rootref['U_TSEEDING'])) ? $this->_rootref['U_TSEEDING'] : ''; ?>',CAPTION, 'Torrents you are Seeding',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_silver/pics/help.png',BORDER,2,SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);" onmouseout="return nd();" style="cursor:help"><?php } ?>
<img src="themes/eVo_silver/pics/upload.gif" border="0" alt="" title=""   /></span><?php echo (isset($this->_rootref['U_TSEEDING_CNT'])) ? $this->_rootref['U_TSEEDING_CNT'] : ''; ?><br>
<?php if ($this->_rootref['U_TLEECHING']) {  ?><span class="overlib" onmouseover="return overlib('<?php echo (isset($this->_rootref['U_TLEECHING'])) ? $this->_rootref['U_TLEECHING'] : ''; ?>',CAPTION, 'Torrents you are Seeding',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_silver/pics/help.png',BORDER,2,SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);" onmouseout="return nd();" style="cursor:help"><?php } ?>
<img src="themes/eVo_silver/pics/download.gif" border="0" alt="Torrents you are Downloading" title="Torrents you are Downloading"   /><?php echo (isset($this->_rootref['U_TLEECHINGCNT'])) ? $this->_rootref['U_TLEECHINGCNT'] : ''; ?></p><br>
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
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnTheme_change');"><img title="Expand item" id="nnTheme_changeimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>Theme change
</div>
</div>
</div>
</td></tr><tr valign="middle">
<td  class="row3" ><div id="nnTheme_change">
<p align="center"><b>Theme</b></p>
<form id="acp_styles" type="hidden" method="post" action="#"><p><select id="template_file" name="theme_change" onchange="if (this.options[this.selectedIndex].value != '') this.form.submit();">
<option selected value="eVo_silver">eVo_silver</option>
<option value="eVo_blue">eVo_blue</option>
<option value="eVo_red">eVo_red</option>
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
<a class="c4" style="cursor: pointer;float:left;" onclick="toggle2('nnInvites');"><img title="Expand item" id="nnInvitesimg" src="themes/eVo_silver/pics/minus.gif"  alt="+"></a>Invites
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