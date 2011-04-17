<?php
/*
-----
*/

if (!defined('IN_PMBT')) die ("You can't access this file directly");
include_once'themes/'.$theme.'/bittorrent.php';  
$tableopen = false;
$errtableopen = false;
$table2open = false;
$btback1 = "191919";
$btback2 = "242424";
$btback3 = "2C2C2C";
                   

function OpenTable($title = "title", $tablewidth = "") {
        global $tableopen, $siteurl, $theme, $extitle;
        if ($tableopen) return;
$img2 = 'minus'; 
						  if (isset($id_pedido) AND $id_pedido == $title) $mostrartable = ''; 
						  $extitle = strip_tags($title);
						  $extitle = str_replace(' ','_',$extitle);             
						  $extitle = str_replace('/','_',$extitle);             
						  $extitle = str_replace("'",'_',$extitle);             
						  $extitle = str_replace("?",'_',$extitle);             

 if (!isset($id_pedido) AND isset($_COOKIE['nn'.$extitle]) AND $_COOKIE['nn'.$extitle] !='') $mostrartable = ' style="display: '.$_COOKIE['nn'.$extitle].';"';
else $mostrartable = '';
        echo "<table class=\"tablebg\" width=\"100%\" cellspacing=\"0\">\n";
		echo "<tr><td>\n";
	    echo "<div class=\"caption\">\n";
		echo "<div class=\"cap-left\">\n";
		echo "<div class=\"cap-right\">\n";
		echo "<a class=\"c4\" style=\"cursor: pointer;float:left;\" onclick=\"toggle2('nn".$extitle."');\"><img title=\"Expand item\" id=\"nn".$extitle."img\" src=\"themes/eVo_blue/pics/minus.gif\"  alt=\"+\"></a>".$title."\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "</td></tr>";
	    echo "<tr valign=\"middle\">\n";
	    echo "<td  class=\"row3\" ><div id=\"nn".$extitle."\"".$mostrartable.">\n";   
	$tableopen = true;
}

function CloseTable() {
        global $tableopen, $siteurl;
        if (!$tableopen) return;
        echo "</div>\n";
		echo "</td></tr>\n";
		echo "<tr>\n";
		echo "<td class=\"cat\" colspan=\"7\" valign=\"middle\" align=\"center\"></td>\n";
	    echo "</tr>\n";
	    echo "</table>\n";
		echo "<br clear=\"all\" >\n";

        $tableopen = false;
}

function OpenTable2($title = "") {
      global $tableopen2, $siteurl;
        if ($tableopen2) return;
        echo "<div id=\"messagebox\" > ";
	echo "<span class=\"messagebox-title\">".$title."</span><div style=\"margin: 0 auto;\">";
	       
	$tableopen2 = true;
 }

function CloseTable2() {
          global $tableopen2, $siteurl;
        if (!$tableopen2) return;
        echo "</div></div>";

        $tableopen2 = false;
}

function OpenNewsTable($title = "") {
      global $OpenNewsTable, $siteurl;
        if ($OpenNewsTable) return;
        echo "<div id=\"newsbox\" > ";
	       
	$OpenNewsTable = true;
 }

function CloseNewsTable() {
          global $OpenNewsTable, $siteurl;
        if (!OpenNewsTable) return;
        echo "</div>";

        $OpenNewsTable = false;
}

function OpenMessTable($title = "") {
      global $OpenMessTable, $siteurl;
        if ($OpenMessTable) return;
        echo "<div id=\"messagebox\"> ";
	echo "<span class=\"messagebox-title\">".$title."</span>";
	       
	$OpenMessTable = true;
 }

function CloseMessTable() {
          global $OpenMessTable, $siteurl;
        if (!$OpenMessTable) return;
        echo "</div>";

        $OpenMessTable = false;
}

function OpenSuccTable($title = "") {
      global $OpenSuccTable, $siteurl;
        if ($OpenSuccTable) return;
        echo "<div id=\"successbox\" > ";
	echo "<span class=\"successbox-title\">".$title."</span>";
	       
	$OpenSuccTable = true;
 }

function CloseSuccTable() {
          global $OpenSuccTable, $siteurl;
        if (!$OpenSuccTable) return;
        echo "</div>";

        $OpenSuccTable = false;
}
function OpenErrTable($title) {
      global $OpenErrTable, $siteurl;
        if ($OpenErrTable) return;
        echo "<div id=\"errorbox\" > ";
	echo "<span class=\"errorbox-title\">".$title."</span>";
	       
	$OpenErrTable = true;
 }

function CloseErrTable() {
          global $OpenErrTable, $siteurl;
        if (!$OpenErrTable) return;
        echo "</div>";

        $OpenErrTable = false;
}

function themechange(){
{
global $bttheme;
        $themes = Array();
        $thememaindir = "themes";
        $themehandle = opendir($thememaindir);
        while ($themedir = readdir($themehandle)) {
                if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
                        $themes[$themedir] = $themedir;
        }
        closedir($themehandle);
        unset($thememaindir,$themedir);
}
        $change = '';
foreach ($themes as $key=>$val) {
		$change .= "<option ";
        if ($bttheme == $key) $change .="selected ";
        $change .= "value=\"".$key."\">".$val."</option>\n";
}
unset($themes);
return $change;
}
function languagechange(){
{
global $language;
        $languages = Array();
        $langdir = "language";
        $langhandle = opendir($langdir);
        while ($langfile = readdir($langhandle)) {
                if (eregi("\.php$",$langfile) AND strtolower($langfile) != "mailtexts.php")
                        $languages[str_replace(".php","",$langfile)] = ucwords(str_replace(".php","",$langfile));
        }
        closedir($langhandle);
        unset($langdir,$langfile);
}
        $change = '';
foreach ($languages as $key=>$val) {
        $change .="<option ";
        if ($language == $key) $change .="selected";
        $change .=" value=\"".$key."\">".$val."</option>\n";
}
unset($languages);
return $change;
}

function themeheader() {
global $db, $db_prefix, $theme, $siteurl, $user, $upload_level, $sitename, $gfx_check, $donations, $INVITEONLY,$onlysearch, $pivate_mode, $forumshare, $PHP_SELF, $shout_config;

if ($user->user) {
        //Update online user list
        $pagename = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
        $sqlupdate = "UPDATE ".$db_prefix."_online_users SET page = '".addslashes($pagename)."', last_action = NOW() WHERE id = ".$user->id.";";
        $sqlinsert = "INSERT INTO ".$db_prefix."_online_users VALUES ('".$user->id."','".addslashes($pagename)."', NOW(), NOW())";
        $res = $db->sql_query($sqlupdate);
        if (!$db->sql_affectedrows($res)) $db->sql_query($sqlinsert);
}
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
echo "<html>\n";
echo "<head>\n";
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
echo "<meta name=\"generator\" content=\"HTML Tidy for Linux (vers 6 November 2007), see www.w3.org\">\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n";
echo "<meta name=\"generator\" content=\"PMBT 2.0.2\">\n";
echo "<meta http-equiv=\"PRAGMA\" content=\"NO-CACHE\">\n";
echo "<meta http-equiv=\"EXPIRES\" content=\"-1\">\n";
echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\">\n";
echo '<link rel="search" type="application/opensearchdescription+xml" title="' . $sitename . '" href="'.$siteurl.'/opensearch.php">';
echo "<!--[if lt IE 7]>\n
<script defer type=\"text/javascript\" src=\"$siteurl/pngfix.js\"></script>\n<![endif]-->\n";
echo "<title>".$sitename."</title>\n";
echo"\n<script type=\"text/javascript\" src=\"js/prototype.js\"></script>
<script type=\"text/javascript\" src=\"js/scriptaculous.js?load=effects,builder\"></script>
<script type=\"text/javascript\" src=\"js/lightbox.js\"></script>

<link rel=\"stylesheet\" href=\"css/lightbox.css\" type=\"text/css\" media=\"screen\" />";
?>
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
pmbtsite_url = "<?php echo $siteurl; ?>";
tag_prompt = "<?php echo _bb_tag_prompt; ?>";
img_prompt = "<?php echo _bb_img_prompt; ?>";
font_formatter_prompt = "<?php echo _bb_font_formatter_prompt; ?>";
link_text_prompt = "<?php echo _bb_link_text_prompt; ?>";
link_url_prompt = "<?php echo _bb_link_url_prompt; ?>";
link_email_prompt = "<?php echo _bb_link_email_prompt; ?>";
list_type_prompt = "<?php echo _bb_list_type_prompt; ?>";
list_item_prompt = "<?php echo _bb_list_item_prompt; ?>";
_btshoutnowprivate = "<?php echo _btshoutnowprivate; ?>";
shoutrefresht = "<?php echo $shout_config['refresh_time']; ?>";
shoutidle = "<?php echo $shout_config['idle_time']; ?>";
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
<?php
if (is_readable("themes/$theme/favicon.ico")) {
        echo "<link REL=\"shortcut icon\" HREF=\"$siteurl/themes/".$theme."/favicon.ico\" TYPE=\"image/x-icon\">\n";
}

if (!$onlysearch) {
        echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"Last Torrents\" href=\"$siteurl/backend.php?op=last\">\n";
        echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"Best Torrents\" href=\"$siteurl/backend.php?op=best\">\n";
}


if (is_readable("themes/$theme/style.css")) {
        echo "<link rel=\"StyleSheet\" href=\"$siteurl/themes/$theme/style.css\" type=\"text/css\">\n<script type=\"text/javascript\" src=\"$siteurl/global.js\"></script>\n";
}
overlib_init();
echo "</head>\n\n";
$has_newpm = false;
$sql = "SELECT id FROM ".$db_prefix."_private_messages WHERE recipient = '".$user->id."' AND is_read = 'false' LIMIT 1;";
$res = $db->sql_query($sql) or btsqlerror($sql);
$pmcount = $db->sql_numrows($res);
$has_newpm = ($pmcount > 0) ? true : false;
$db->sql_freeresult($res);
if ($has_newpm)
{
  echo "<script type=\"text/javascript\" language=\"JavaScript\">";
  echo "sPath = window.location.pathname;";
  echo "sPage = sPath.substring(sPath.lastIndexOf('/') + 1);";
  
  echo "if (sPage != \"pm.php\"){ var answer = confirm (\""._jscriptconfirmtext."\");";
  echo "if (answer) window.location=\"pm.php?op=inbox\";";
  echo "}";
  echo "</script>";

}


$themepage = false;
?><!--[if lt IE 7]><link rel="stylesheet" type="text/css" media="screen" href="themes/eVo_blue/iestyle.css">
<![endif]-->
<!--[if IE]>
<link rel="stylesheet" type="text/css" media="screen" href="themes/eVo_blue/iestyle.css">
<![endif]-->
<?php
if($user->user)echo "<body class=\"ltr\" onload=\"shoutthis_ajax()\">\n";
else
echo "<body class=\"ltr\">";
echo"<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" id=\"maintable\" align=\"center\">\n";
echo"<tr>\n";
	echo"<td id=\"logorow\" align=\"center\"><div id=\"logo-left\"><div id=\"logo-right\">\n";
	echo"</div></div></td>\n";
echo"</tr>\n";

echo"<tr>\n";
	echo"<td class=\"navrow\">\n";
		echo"&nbsp;\n";

echo"</tr>\n";
echo "<tr>\n";
echo "<td  align=\"center\" class=\"topbuttons\" nowrap=\"nowrap\" width=\"100%\" colspan=\"6\">\n";
echo "<a href=\"index.php\" ><img onmouseover=\"change_bg(this,'1')\" onmouseout=\"change_bg(this,'0')\" src=\"themes/eVo_blue/pics/top_home.gif\" border=\"0\" alt=\"\" title=\"Home\" id=\"home\"></a>\n";
echo "<a id=\"myAnchor\" href=\"".((preg_match("/torrents.php/",$_SERVER["PHP_SELF"]))? "#" : "torrents.php")."\" onclick=\"do_breload();\"><img onclick=\"do_breload();\" onmouseover=\"change_bg(this,'1')\" onmouseout=\"change_bg(this,'0')\" src=\"themes/eVo_blue/pics/top_browse.gif\" border=\"0\" alt=\"\" title=\"Browse\" id=\"browse\"></a>\n";
echo "<a href=\"user.php?op=profile&amp;id=".$user->id."\"><img onmouseover=\"change_bg(this,'1')\" onmouseout=\"change_bg(this,'0')\" src=\"themes/eVo_blue/pics/top_profile.gif\" border=\"0\" alt=\"\" title=\"Profile\" id=\"profile\"></a>\n";
echo "<a href=\"pm.php\"><img onmouseover=\"change_bg(this,'1')\" onmouseout=\"change_bg(this,'0')\" src=\"themes/eVo_blue/pics/top_messages.gif\" border=\"0\" alt=\"mess\" title=\"Messages\" id=\"msg\"></a>\n";
echo "<a href=\"upload.php\"><img onmouseover=\"change_bg(this,'1')\" onmouseout=\"change_bg(this,'0')\" src=\"themes/eVo_blue/pics/top_upload.gif\" border=\"0\" alt=\"\" title=\"Upload\" id=\"upload\"></a>\n";
echo "<a href=\"forums.php\"><img onmouseover=\"change_bg(this,'1')\" onmouseout=\"change_bg(this,'0')\" src=\"themes/eVo_blue/pics/top_forum.gif\" border=\"0\" alt=\"\" title=\"Forums\" id=\"forums\"></a>\n";
help("<img onmouseover=\"change_bg(this,'1')\" onmouseout=\"change_bg(this,'0')\" src=\"themes/eVo_blue/pics/top_help.gif\" border=\"0\" alt=\"\" title=\"Staff\" id=\"help\">","<table width=\"100%\" cellspacing=\"1\" cellpadding=\"4\" border=\"0\" class=\"tableinborder\"><tr><td class=\"tabletitle\"><div align=\"center\"><a href=\"javascript:;\" onclick=\"return nd();\">Help Menu</a></div></td></tr><tr><td class=\"tableb\"><div align=\"center\"><a href=\"rules.php\">Rules</a></div></td></tr><tr><td class=\"tableb\"><div align=\"center\"><a href=\"faq.php\">F.A.Q</a></div></td></tr><tr><td class=\"tableb\"><div align=\"center\"><a href=\"staff.php\">Staff</a></div></td></tr></table>",'eVo_blue','eVo_blue');
if($user->user)echo "\n<a onclick=\"if(!confirm('Are you sure do you want to logout?')){return false;};\" href=\"user.php?op=logout\" r=\"0\" alt=\"\" title=\"Logout\"><img onmouseover=\"change_bg(this,'1')\" onmouseout=\"change_bg(this,'0')\" src=\"themes/eVo_blue/pics/top_logout.gif\" border=\"0\" title=\"Logout\" alt=\"\" id=\"logout\"></a>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td id=\"contentrow\">\n";
if($pivate_mode AND !$user->user AND !preg_match("/user.php/",$_SERVER["PHP_SELF"])){
 loginrequired("user", true);
 die();
 }


//echo "<link rel=\"search\" type=\"application/opensearchdescription+xml\" href=\"/w/opensearch_desc.php\" title=\"Wikipedia (English)\" >";
$reason = "";
if (is_banned($user, $reason)) {
        echo "<p>&nbsp;</p>\n";
        echo "<p>&nbsp;</p>\n";
        echo "<h3 align=\"center\">".str_replace("**reason**",htmlspecialchars($reason),_btbannedmsg)."</p>\n";
        echo "<p>&nbsp;</p>\n";
        echo "<p>&nbsp;</p>\n";
        include("footer.php");
        die();
}
echo "<table width=\"100%\">\n";
echo "<tr>\n";
if(!preg_match("/phpBB.php/",$_SERVER["PHP_SELF"]))
{
echo "<td width=\"20%\" valign=\"top\">\n";

echo "<div >";

//{
OpenTable("General");
          echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" class=\"forumline\" align=\"center\">\n";
          if ($user->user)
		  {
		  echo "<tr><td class=\"row2\" width=\"100%\"><a href=\"index.php\">"._btindex."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"rules.php\">Rules</a></td></tr>\n";
          echo "<tr><td class=\"row2\" width=\"100%\"><a href=\"faq.php\">"._btfaqs."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"forums.php\">Forum</a></td></tr>\n";
          if (file_exists("include/irc.ini"))echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"chat.php\">"._btircchat."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"mytorrents.php\">"._btpersonal."</a></td></tr>\n";
          if ($upload_level == "all")echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"upload.php\">"._btupload."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"torrents.php\">Browse</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"pm.php\"><span id=\"nopm_notif\">"._btpm."</span></a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"user.php?op=profile&id=".$user->id."\">"._btuserprofile."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"memberslist.php\">"._btmemlist."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"user.php?op=logout\">"._btlogout."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"games.php\">"._btgames."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"viewrequests.php\">"._btviewrqst."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"offers.php\">"._bttorofferd."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"helpdesk.php\">Help Desk</a></td></tr>\n";
          echo "<tr><td class=\"row2\" width=\"100%\"><a href=\"youtube.php\">Video's</a></td></tr>\n";
          if ($user->admin)echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"admin.php\">"._btadmin."</a></td></tr>\n";
		  }else{
		  echo "<tr><td class=\"row2\" width=\"100%\"><a href=\"index.php\">"._btindex."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"rules.php\">Rules</a></td></tr>\n";
          echo "<tr><td class=\"row2\" width=\"100%\"><a href=\"faq.php\">"._btfaqs."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"phpBB.php\">Forum</a></td></tr>\n";
          echo "<tr><td class=\"row2\" width=\"100%\"><a href=\"chat.php\">"._btircchat."</a></td></tr>\n";
          echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"helpdesk.php\">Help Desk</a></td></tr>\n";
          if ($upload_level == "all") echo "<tr><td class=\"row1\" width=\"100%\"><a href=\"upload.php\">"._btupload."</a></td></tr>\n";
		  }
          echo "</table>\n";
if (!$user->user) {
	    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">\n";
        echo "<tr>\n<td align=\"center\">\n<p align=\"center\"><b>"._btlogin."</b></p>\n</td>\n</tr>\n";
        echo "<tr>\n<td align=\"center\">\n<p>&nbsp;</p>\n";
        echo "<form method=\"POST\" action=\"user.php\">\n<input type=\"hidden\" name=\"op\" value=\"login\" >\n</td>\n</tr>\n";	
	    echo "<tr>\n<td align=\"center\">\n<p>"._btusername."</p>\n</td>\n</tr>\n
		<tr>\n<td align=\"center\">\n<input type=\"text\" name=\"username\" size=\"10\">\n</td>\n</tr>\n
		<tr>\n<td align=\"center\">\n<p>"._btpassword."</p></td>\n</tr>\n
		<tr>\n<td align=\"center\">\n<input type=\"password\" name=\"password\" size=\"10\">\n</td>\n</tr>\n
		<tr>\n<td align=\"center\">\n<p>"._btremember."</p>\n</td>\n</tr>\n
		<tr>\n<td align=\"center\">\n<input type=\"checkbox\" name=\"remember\" value=\"yes\">\n</td>\n</tr>\n";
        if ($gfx_check) {
                $rnd_code = strtoupper(RandomAlpha(5));
                echo "<tr><td align=\"center\"><p align=\"center\">"._btsecuritycode."<br><img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\" alt=\"Security Code\"><br>\n<input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\">";
                echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\"></td></tr>\n\n";
        }
        echo "<tr><td><p align=\"center\"><input type=\"submit\" value=\""._btlogin."\"></p></td></tr></table></form>";
        echo "<p><a href=\"user.php?op=register\">"._btsignup."</a><br>\n\n";
        echo "<a href=\"user.php?op=lostpassword\">"._btlostpassword."</a></p>\n\n";
 }      
          CloseTable();
//}


if ($donations){
include("./blocks/donation_block.php");
}

echo "</div></td>\n";
}
echo "<td width=\"65%\" valign=\"top\">\n";
echo "<div id=\"center\">";
$sql_profile = "SELECT * FROM ".$db_prefix."_users where id = '".$user->id."' ;";
$res_profile = $db->sql_query($sql_profile);
$userrow = $db->sql_fetchrow($res_profile);
$db->sql_freeresult($res_profile);
// WARN things START
if ($user->user) {
if ($user->downloaded > 0){
include ("./ratiowarn.php");
}
}
 if ($userrow["warned"] ==1)
 {
$warn_kapta = $userrow["warn_kapta"];
$warn_hossz = $userrow["warn_hossz"];
$modcomment = $userrow["modcomment"];

if ($warn_hossz != -1) {
$warn = $warn_kapta + $warn_hossz;
$time_now = strtotime(gmdate("Y-m-d H:i:s", time()));
if ($warn < $time_now)
{
$modcomment = "[ " . gmdate("Y-m-d H:i:s", time()) . " - WARN time expired ]\n" . $modcomment;
$msg = ("Your WARN time expired, so we deleted it!");
     @$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES(1, " .$user->id. ",'WARNING' '" . $msg ."', NOW())") or die(mysql_error());  
$modcomment = $modcomment;
$frissites = $db->sql_query("UPDATE ".$db_prefix."_users SET modcomment='$modcomment', warned='0', warn_kapta='0', warn_hossz='0' WHERE id='".$user->id."'") or sqlerr();
}
}
}
// WARN things END
 //////////////////// Kommentera modd ////////////////////////
$komment = '';
$res =  $db->sql_query("SELECT torrent FROM ".$db_prefix."_peers WHERE uid='".$user->id."'")or print(mysql_error());
while($row = $db->sql_fetchrow($res)){
$kom = $db->sql_fetchrow( $db->sql_query("SELECT count(*) FROM ".$db_prefix."_comments WHERE user= '".$user->id."' AND torrent='$row[torrent]'"))or print(mysql_error());
$tor = $db->sql_fetchrow( $db->sql_query("SELECT name,owner FROM ".$db_prefix."_torrents WHERE id='$row[torrent]'"))or print(mysql_error());
if(!$kom[0] && $tor['owner'] !=  $user->id && $user->id != 2){
 $komment .= "<a href=details.php?id=".$row[torrent].">".$tor[name]."</a><br>";
}
}
 /////////////////////////////////////////////////////////////
if ($user->user) {
 if (!$komment == ''){
 print("<p><table border=0 cellspacing=0 cellpadding=10 bgcolor=green><tr><td style='padding: 50px; background: green'>\n");
 print("Please leave a comment on:<br>$komment");
 print("</td></tr></table></p>\n");
}
}
}

function overlib_init() {
        echo "<script type=\"text/javascript\" src=\"overlib/overlib.js\"><!-- overLIB (c) Erik Bosrup --></script>\n";
        echo "<script type=\"text/javascript\" src=\"overlib/overlib_shadow.js\"><!-- overLIB (c) Erik Bosrup --></script>\n";
}
function themefooter(){
global $startpagetime, $db, $db_prefix, $user,$INVITEONLY,$sitename;//y can move them now ?should
echo"<h2><center><font size=\"4\">Disclaimer</font></center></h2>
<table width=100% height='50' border=1 cellspacing=0 cellpadding=3><tr><td align=center>";
echo "<marquee onmouseover=this.stop() onmouseout=this.start() scrollAmount=1.5 direction=up width='100%' height='50'>
<p>Disclaimer:
None of the files shown here are actually hosted on this server. <br />
The links are provided solely by this site's users.<br />
These BitTorrent files are meant for the distribution of backup files. <br />
By downloading the BitTorrent file, you are claiming that you own the original file. <br />
The administrator of this site <strong>$sitename</strong> holds <strong>NO RESPONSIBILITY</strong> if these files are misused in any way and <br />
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
</td></tr></table>";
echo"</div></td>";
if(!preg_match("/phpBB.php/",$_SERVER["PHP_SELF"])){
echo"<td width=\"20%\" valign=\"top\">";
#right side here


OpenTable('Upload guide');
        echo "<center><a href=\"utorrent.php\">Utorrent Guide</a></center>\n";
 CloseTable();
if ($user->user AND $INVITEONLY)
{

OpenTable("Personal stats");
        $sql = "SELECT seedbonus, avatar, uploaded,  downloaded, invites, uploaded/downloaded AS ratio FROM ".$db_prefix."_users WHERE id = '".$user->id."';";
        $res = $db->sql_query($sql);
        list ($seedbonus, $avatar, $uploaded, $downloaded, $invites, $ratio) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
        echo "<p>".pic("pic_uploaded.gif").mksize($uploaded)."<br>";
        echo pic("pic_downloaded.gif").mksize($downloaded)."<br>";
        echo pic("pic_ratio.gif");
        echo "&nbsp;";
        if ($downloaded == 0)
                echo "&infin;";
        elseif ($ratio < 0.1)
                echo "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.2)
                echo "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.3)
                echo "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.4)
                echo "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.5)
                echo "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.6)
                echo "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.7)
                echo "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.8)
                echo "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 0.9)
                echo "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
        elseif ($ratio < 1)
                echo "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
        else
                echo "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
        echo "<br>\n";
        #Numer of seeding Torrents
        $sql = "SELECT P.torrent AS id, T.name as name FROM ".$db_prefix."_peers P, ".$db_prefix."_torrents T WHERE P.uid = '".$user->id."' AND P.seeder = 'yes' AND T.id = P.torrent;";
        $res = $db->sql_query($sql);
        $cnt = $db->sql_numrows($res);
        $torrents = Array();
        while ($tor = $db->sql_fetchrow($res)) {
                $torrents[] = htmlspecialchars((strlen($tor["name"]) > 33) ? substr($tor["name"],0,30)."..." : $tor["name"]);
        }
        if ($cnt > 0) help(pic("upload.gif"),"<p>".implode($torrents,"<br>")."</p>",_btyoureseeding);
        else echo pic("upload.gif",null,_btyoureseeding);
        echo $cnt;
        $db->sql_freeresult($sql);
        unset($sql, $res, $torrents, $tor, $cnt);
        #Number of downloading Torrents
        echo "<br>\n";
        $sql = "SELECT P.torrent AS id, T.name as name FROM ".$db_prefix."_peers P, ".$db_prefix."_torrents T WHERE P.uid = '".$user->id."' AND P.seeder = 'no' AND T.id = P.torrent;";
        $res = $db->sql_query($sql);
        $cnt = $db->sql_numrows($res);
        $torrents = Array();
        while ($tor = $db->sql_fetchrow($res)) {
                $torrents[] = htmlspecialchars((strlen($tor["name"]) > 33) ? substr($tor["name"],0,30)."..." : $tor["name"]);
        }
        if ($cnt > 0) help(pic("download.gif"),"<p>".implode($torrents,"<br>")."</p>",_btyoureleeching);
        else echo pic("download.gif",null,_btyoureleeching);
        echo $cnt;
        $db->sql_freeresult($sql);
        unset($sql, $res, $torrents, $tor, $cnt);
		if($avatar=="blank.gif")$thavatar = "themes/eVo_blue/pics/noavatar.gif";
		else 
		$thavatar = "avatars/".$avatar;
        echo "</p>";
        echo "<br>\n";
		echo "<br>\n";
		echo "<p align=\"center\"><b>"._btwelcomebk."</b></p>\n";
		echo "<p align=\"center\"><b>".$user->name."</b></p>\n";		
		echo "<b>".gen_avatar($user->id)."</b><br>";
		echo "<br>\n";
		print("<p>Seeding Bonus: <a href='mybonus.php'>".$seedbonus."</a></p>");
		echo "<br />\n"; 
        print("<p>Transfer Bonus: <a href='bonus_transfer.php'>here</a></p>");

CloseTable();	
} 
OpenTable('Theme change');
		echo "<p align=\"center\"><b>Theme</b></p>\n";
	    echo "<form id=\"acp_styles\" type=\"hidden\" method=\"post\" action=\"#\">";
        echo "<p><select id=\"template_file\" name=\"theme_change\" onchange=\"if (this.options[this.selectedIndex].value != '') this.form.submit();\">".themechange()."</select></p>";
		echo "<p align=\"center\"><b>Language</b></p>\n";
	    echo "<p><select id=\"language_file\" name=\"language_change\" onchange=\"if (this.options[this.selectedIndex].value != '') this.form.submit();\">".languagechange()."</select></p>";
		echo " <input class=\"button2\" type=\"submit\" value=\"SELECT\" ></form>";
CloseTable();
if($user->user){
OpenTable(_btinvites);
		echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
		echo "<tr><td align=\"center\">"._btinfituh."<br></td></tr>\n";
		if ($user->invites > 0 ){
		echo "<tr><td align=\"center\"><a href=invite.php>"._btsendiv."</a><br></td></tr>\n";
		}
		echo "</table>";
		
		CloseTable();
		}
echo"</td>";
}
echo"</tr></table>";
echo'<div id="wrapfooter">
	<span class="gensmall"> <!-- Feel free to add you custom disclaimer or copyright notice here -->
 <!-- YOU ARE NOT ALLOWED TO EDIT THE FOLLOWING COPYRIGHT NOTICE!!! -->
 Theme By Evolution Torrent 2010 &copy; <br>
 Powered by phpMyBitTorrent &copy; 2005-2010 <a href="http://phpmybittorrent.com">phpMyBitTorrent Team</a>.<br>
 This is free software and contains source code version of GNU/LGPL distributed libraries.<br>
 You may redistribute the whole package and its source code according to the GNU/GPL license.<br>
 The Development Team cannot be held responsible in any way for the results of the use of this software.<br>
 <!-- END OF COPYRIGHT NOTICE -->
 Generated in ' . abs(round(microtime()-$startpagetime,2)) . ' seconds
<!-- Start of StatCounter Code -->
 <script type="text/javascript">
 var sc_project=2789089;
 var sc_invisible=0;
 var sc_partition=28;
 var sc_security="7d0a2fe3";
 </script>

 <script type="text/javascript" src="http://www.statcounter.com/counter/counter_xhtml.js"></script><noscript><div class="statcounter"><a class="statcounter" href="http://www.statcounter.com/"><img class="statcounter" src="http://c29.statcounter.com/2789089/0/7d0a2fe3/0/" alt="web metrics" ></a></div></noscript>
<!-- End of StatCounter Code --></span><br><br>	<span class="copyright">

	
	</span>
</div>



	</td>
</tr>
</table>

</body>
</html>';
//die();
}
function help($name,$help,$title = "",$link = "") {
        if ($link != "") echo "<span class=\"overlib\" onclick=\"return overlib('".addslashes(str_replace(Array("\n","\""),Array("","'"),$help)),"'";
        if ($link == "") echo "<span class=\"overlib\" onmouseover=\"return overlib('".addslashes(str_replace(Array("\n","\""),Array("","'"),$help)),"'";
        if ($title != "" AND $link == "") echo ",CAPTION, '".addslashes(str_replace(Array("\n","\""),Array("","'"),$title))."'";
       // if ($title != "" AND $link != "") echo ",CAPTION, '".addslashes(str_replace(Array("\n","\""),Array("","'"),$title))."'";
        if ($link == "") echo ",TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#0000FF',CAPICON,'themes/eVo_blue/pics/help.png',BORDER,2,SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);\" onmouseout=\"return nd();\" style=\"cursor:help\">".$name."</span>";
        if ($link != "") echo ",CELLPAD,'0',FOLLOWMOUSE,'0',TEXTFONT,'Verdana',TEXTCOLOR,'#FFFFFF',CAPTIONFONT,'Lucida Console, Verdana',CENTER,FGCOLOR,'#000000',BGCOLOR,'#6F7578',CAPICON,'themes/eVo_blue/pics/help.png',SHADOW,SHADOWOPACITY,40,SHADOWCOLOR,'#030303',SHADOWX,2,SHADOWY,2);\"  >".$name."</span>";
}
?>