<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta4-----------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2008 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   SAT, FEB 21, 2009 18:12 PM   ---------------------*
*/
include("header.php");
global $db, $db_prefix;
include'language/help.php';
$list_only = '';
if(isset($viewName)) 
{
$list_only = " WHERE `status` =  ";
if($viewName == 'Completed')$list_only .= "'Solved'";
if($viewName == 'Inprogress')$list_only .= "'Inprogress'";
if($viewName=='Not')$list_only .= "'Not Going To Solve'";
if($viewName=='Waiting')$list_only .= "'Waiting On More Info'";
if($viewName=='Pending')$list_only .= "'New'";
if($viewName=='All_Requester')$list_only = "";
}
function escape_string($value, $quotes = true) {
    $value = trim($value);
    $value = get_magic_quotes_gpc() ? stripslashes($value) : $value;
    if (!(is_numeric($value) && intval($value) == $value)) {
        if (function_exists('mysql_real_escape_string')) {
            $value = mysql_real_escape_string($value);
        } else {
            $value = addslashes($value);
        }
    }
    if ($quotes == true) {
        $value = "'$value'";
    }
    return $value;
}
if($_POST['delete']=='Delete')
{
foreach($t as $tid=>$action)
{
$db->sql_query("DELETE FROM `".$db_prefix."_helpdesk` WHERE `id` = ".$tid." LIMIT 1");
$db->sql_query("DELETE FROM `".$db_prefix."_help_responce` WHERE `ticket` = ".$tid."");
//echo $tid;
}
}
if($_POST['close']=='Close')
{
foreach($t as $tid=>$action)
{
$db->sql_query("UPDATE `".$db_prefix."_helpdesk` SET `solved` = 'yes' WHERE `id` =".$tid." LIMIT 1 ;");
//echo $tid;
}
}
//anti-XSS fix for logins
if (isset($_GET['e'])) {
    $e = htmlspecialchars(trim($_GET['e']));
}
if (isset($_GET['t'])) {
    $t = htmlspecialchars(trim($_GET['t']));
}
if (isset($_GET['em'])) {
    $em = htmlspecialchars(trim($_GET['em']));
}
if (isset($_GET['tt'])) {
    $tt = htmlspecialchars(trim($_GET['tt']));
}
if (isset($_GET['a'])) {
    $a = $_GET['a'];
}
if (empty($_SESSION)) {
    session_start();
}
if ($a == 'view_reopen') {
    $_SESSION['view']['status'] = 'reopened'; 
} elseif ($a == 'view_open') {
    $_SESSION['view']['status'] = 'open';
} elseif ($a == 'view_onhold') {
    $_SESSION['view']['status'] = 'onhold';
} elseif ($a == 'view_awaitingcustomer') {
    $_SESSION['view']['status'] = 'awaitingcustomer';
} elseif ($a == 'view_closed') {
    $_SESSION['view']['status'] = 'closed';
} elseif ($a == 'view_all') {
    $_SESSION['view']['status'] = 'all';
} elseif ($a == 'view_new') {
    $_SESSION['view']['status'] = 'new';
} elseif ($a == 'view_reopened') {
    $_SESSION['view']['status'] = 'reopened';
}
if (!isset($_SESSION['view']['status'])) {
    if ($user->admin) $_SESSION['view']['status'] = 'open';
    if ($user->user) $_SESSION['view']['status'] = 'all';
}
?>
<style>
option { padding-right: 5px; }
.TableHeaderText { color: #FFFFFF; font-size: 11px; text-align: center; }
.TableHeaderText a { color:#FF0000;}
.mainTable a { color:#FF0000;}
.mainTableAlt a { color:#FF0000;}
.mainTable { background-color: #F4FAFF; }
.mainTableAlt { background-color: #FFFFFF; }
td {
	color: #3E3E3E;
	text-decoration: none;
	border: none;
}
.prilow { background-color: #DDFFDD; }
.primedium { background-color: #FFFFF0; }
.prihigh { background-color: #FEE7E7; }
.inputsubmit2 {
	font-size: 11px;
	background-color: #FFFFFF; 
	color: #006699;
	border: #FFFFFF; 
	border-style: solid;
 	border-top-width: 1px; 
	border-right-width: 1px; 
	border-bottom-width: 1px; 
	border-left-width: 1px
}
.inputsubmit {
	font-size: 11px;
	background: #EEB358 url("images/bgbar.gif");
	color: white;
	border: #A6A6A6 solid 1px;
}
</style>
<?php
$html['main_table'] = '
<table border="0" cellspacing="1" cellpadding="2" class="TableMsg" width="100%" align="center">
	  <tr>
	    <td>&nbsp;</td>
	    <td class="TableHeaderText" title="' . LANG_TIP_TICKET . '"><a href="?s=advanced&sort=ID&status=%status&way=%way">' . LANG_TICKET . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_DATE . '"><a href="?s=advanced&sort=timestamp&status=%status&way=%way">' . LANG_DATE . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_SUBJECT . '"><a href="?s=advanced&sort=subject&status=%status&way=%way">' . LANG_SUBJECT . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_CAT . '"><a href="?s=advanced&sort=cat&status=%status&way=%way">' . LANG_CAT . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_REP . '"><a href="?s=advanced&sort=rep&status=%status&way=%way">' . LANG_REP . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_PRIORITY . '"><a href="?s=advanced&sort=priority&status=%status&way=%way">' . LANG_PRIORITY . '</a></td>
	    <td class="TableHeaderText" title="' . LANG_TIP_FROM . '"><a href="?s=advanced&sort=name&status=%status&way=%way">' . LANG_FROM . '</a></td>
	    <td class="TableHeaderText" title="Status"><a href="?s=advanced&sort=status&way=%way">Status</a></td>
	    <td class="TableHeaderText" title="Closed"><a href="?s=advanced&sort=status&way=%way">Closed</a></td>
	  </tr>
	  %content
</table>
';
$html['main_table_content'] = '
		  <tr class="{class}" onmouseover="this.className=\'mainTableOn\';" onmouseout="this.className=\'{class}\';">
		   <td align="center" class="checkbox">{checkbox}</td>
		   <td align="center" class="ticket"><a href="{page}?a=view&amp;id={id}">{id}</a></td>
		   <td align="center" class="date">{short_time}</td>
		   <td class="subject"><a href="slove.php?a=view&amp;id={id}">{subject}</a></td>
		   <td class="category">{cat_name}</td>
		   <td class="rep">{rep_name}</td>
		   <td {pri_style}>{pri_text}</td>
		   <td class="from"><a onClick="document.search.email.value=\'{email}\';" title="{email}">{name}</a></td>
		   <td align="center" class="ticket">{status}</td>
		   <td align="center" class="ticket">{closed}</td>
			</tr>
';
$html['main']['currentpage'] = '<span id="currentpage">%s</span>';
$html['main']['page'] = '<a href="%s">%s</a>';
$html['main']['no_tickets'] = '<p style="text-align: center;" id="no_tickets">' . LANG_NO_TICKETS . '</p>';
$html['main']['input'] = '<input type="%s" name="%s" class="%s">';
$main_table = $html['main']['no_tickets'];
$main_table_content = '';
$html['button'] = '
            <form action="admin.php?a=%s" method="POST" style="display: inline;">
         			<input class="inputsubmit" type="submit" id="%s" name="%s" value="%s">
         		</form>';
$html['buttons'] = '<div class="buttons">%s</div><br>';
if (!function_exists('add_trailing_slash')) {
    function add_trailing_slash($dir, $slash = DIRECTORY_SEPARATOR) {
        if (substr($dir, -1) != $slash) {
            $dir = $dir . $slash;
        }
        return $dir;
    }
}
$titles = array('viewticket' => LANG_TITLE_VIEWTICKET, 'admin_login' => LANG_TITLE_ADMIN_LOGIN, 'user_login' => LANG_TITLE_USER_LOGIN, 'main' => '', 'pref' => LANG_TITLE_PREF, 'db' => LANG_TITLE_DB, 'mail' => LANG_TITLE_MAIL, 'cat' => LANG_TITLE_CAT, 'rep' => LANG_TITLE_REP, 'user_group' => LANG_TITLE_GROUPS, 'banlist' => LANG_TITLE_BANLIST, 'my' => LANG_TITLE_MY);
$themes_dir = 'themes'; //directory of themes
$image_dir = 'images'; //directory of images in themes
$buttons_dir = 'buttons'; //directory of button images in themes
$themes_dir = add_trailing_slash($themes_dir, DIRECTORY_SEPARATOR);
$theme_dir = add_trailing_slash($themes_dir . $theme, DIRECTORY_SEPARATOR);
$image_dir = add_trailing_slash($theme_dir . $image_dir, DIRECTORY_SEPARATOR);
$buttons_dir = add_trailing_slash($image_dir . $buttons_dir, DIRECTORY_SEPARATOR);
function load_buttons() { //These are the admin buttons that appear in the admin area
    global  $titles, $image_dir, $html, $user;
    if ($user->admin) {
        $access = array();
        foreach($titles as $item => $val) {
            if ($item == 'my') {
		  
                $button = sprintf($html['button'], $item, $item, $item, $val);
                array_push($access, $button);
            }
       }
        $access = join(" \n", $access);
        if (!empty($access)) {
            echo sprintf($html['buttons'], $access);
        }
    }
}
$cats_res = mysql_query("SELECT * FROM torrent_help_category");
while ($cats_row = mysql_fetch_array($cats_res)) {
    $cats_rows[$cats_row['id']] = $cats_row;
}
$sql="SELECT id FROM ".$db_prefix."_helpdesk $list_only";
$res=$db->sql_query($sql);
$resultsc=$db->sql_numrows($res);
$per = 15;
$total = $resultsc;
$pages = ceil($total/$per);
//if total pages is more than current page, display last page instead of nothing
if ($p > ($pages-1)) {
    $p = $pages;
}
if ((!$_SESSION['view']['sort']) || (!$_SESSION['view']['way']) || !$_REQUEST['s']) {
    switch ($_SESSION['view']['status']) {
        case open:
            $_SESSION['view']['sort'] = 'timestamp';
            $_SESSION['view']['way'] = 'ASC';
        break;
        case answered:
            $_SESSION['view']['sort'] = 'timestamp';
            $_SESSION['view']['way'] = 'DESC';
        break;
        case closed:
            $_SESSION['view']['sort'] = 'timestamp';
            $_SESSION['view']['way'] = 'DESC';
        break;
        case all:
            $_SESSION['view']['sort'] = 'status';
            $_SESSION['view']['way'] = 'DESC';
        break;
    }
}
if ($_REQUEST['s']) {
    if ($_REQUEST['sort']) {
        $_SESSION['view']['sort'] = htmlspecialchars($_REQUEST['sort'], ENT_QUOTES);
    }
    if ($_REQUEST['way']) {
        $_SESSION['view']['way'] = htmlspecialchars($_REQUEST['way'], ENT_QUOTES);
    }
}
if (($_SESSION['view']['sort']) && ($_SESSION['view']['way'])) {
    $_SESSION['view']['orderby'] =  'torrent_helpdesk.' . $_SESSION['view']['sort'] . ' ' . $_SESSION['view']['way'];
}
//filter by catagory
if (isset($_REQUEST['cat'])) $_SESSION['view']['cat'] = htmlspecialchars($_REQUEST['cat'], ENT_QUOTES);
//filter by rep
if (isset($_REQUEST['rep'])) $_SESSION['view']['rep'] = htmlspecialchars($_REQUEST['rep'], ENT_QUOTES);
//set tickets per page
$_SESSION['view']['per'] = (int)$_REQUEST['per'] ? $_REQUEST['per'] : $torrent_per_page;
//set page number
$_SESSION['view']['p'] = $_REQUEST['p'] ? htmlspecialchars($_REQUEST['p'], ENT_QUOTES) : 1;
/* Filter & Session Data - END */
//correct dates
if (isset($_REQUEST['date_from'])) {
    $_REQUEST['date_from'] = format_time('Y-m-d', strtotime($_REQUEST['date_from']));
    $_SESSION['view']['date_from'] = $_REQUEST['date_from'];
}
if (isset($_REQUEST['date_to'])) {
    $_REQUEST['date_to'] = format_time('Y-m-d', strtotime($_REQUEST['date_to']));
    $_SESSION['view']['date_to'] = $_REQUEST['date_to'];
}
/* set vars */
if ((isset($_REQUEST['text'])) && ($_REQUEST['text'])) $text = htmlspecialchars($_REQUEST['text'], ENT_QUOTES);
if (isset($_REQUEST['s'])) {
    $s = $_REQUEST['s'] == 'advanced' ? 'advanced' : 'basic';
}
$orderby = $_SESSION['view']['orderby'];
$per = $_SESSION['view']['per'];
$p = $_SESSION['view']['p'];
$status = $_SESSION['view']['status'];
$date_from = $_SESSION['view']['date_from'];
$date_to = $_SESSION['view']['date_to'];
/*Table Details*/
if ($_REQUEST['s']) {
    $newway = ($_SESSION['view']['way'] == 'ASC') ? 'DESC' : 'ASC';
} else {
    $newway = $_SESSION['view']['way'];
}
/* Create Query Start */
//set filters for the where statement
if ($_SESSION['view']['status']!='all' && $_SESSION['view']['status']!='open')
	$filter['status'] = $_SESSION['view']['status'];

if ($_SESSION['view']['cat']) {
    $filter['cat'] = ($user->user) ? $_SESSION['view']['cat'] : '';
}
if ($_SESSION['view']['rep']) $filter['rep'] = $_SESSION['view']['rep'];
//print_r($filter);
//implode the $filter array together into the WHERE
if (is_array($filter)) {
    foreach($filter as $key => $value) {
        if (empty($where)) {
            $where = '';
        } else {
            $where.= ' AND ';
        }
        if (!preg_match('/\./', $key)) {
            $key = "torrent_helpdesk.$key";
        }
        if (!empty($value)) {
            $value = escape_string($value);
            $where.= " $key = $value";
        }
    }
}
if ($user->user) {
    if (empty($where)) {
        $where = '';
    } else {
        $where.= ' AND ';
    }
    $key = "torrent_helpdesk.cat";
   // $where.= "$key =" . implode(" OR $key = ", $login['cat_access']);
}
$start = ((($p-1) *$per) -1);
$end = (($p*$per) -1);
$reps_res = mysql_query("SELECT * FROM torrent_users WHERE level = 'admin'");
while ($reps_row = mysql_fetch_array($reps_res)) {
    $reps_rows[$reps_row['id']] = $reps_row;
}
$sql="SELECT * FROM ".$db_prefix."_helpdesk$list_only";
$res=$db->sql_query($sql)or btsqlerror($sql);
    $class = 'mainTable'; //for table stripes (default)
    while($results=$db->sql_fetchrow($res)) {
            $class = ($class == 'mainTableAlt') ? 'mainTable' : 'mainTableAlt';
            $cat_row = $cats_rows[$results['category']];
            $cat_row['name'] = $cat_row['name'];
            $this_content = $html['main_table_content'];
			if($results['solved'] == 'yes')$ticket_closed = "Yes";
			else
			$ticket_closed = "No";
            $this_content = str_replace('{class}', $class, $this_content);
            $this_content = str_replace('{page}', $page, $this_content);
            $this_content = str_replace('{id}', $results['id'], $this_content);
            $this_content = str_replace('{closed}', $ticket_closed, $this_content);
            $this_content = str_replace('{checkbox}', sprintf($html['main']['input'], 'checkbox', 't[' . $results['id'] . ']', 'checkbox'), $this_content);
            $this_content = str_replace('{short_time}', $results['open_date'], $this_content);
            $this_content = str_replace('{subject}', htmlspecialchars(stripslashes($results['title'])), $this_content);
            $this_content = str_replace('{cat_name}', $cat_row['name'], $this_content);
            $this_content = str_replace('{rep_name}',htmlspecialchars(stripslashes(username_is($results['helper']))), $this_content);
            $this_content = str_replace('{pri_style}', 'class="pri'.$results['priority'].'"', $this_content);
            $this_content = str_replace('{pri_text}', $results['priority'], $this_content);
            $status = $results['status'];
            $this_content = str_replace('{status}', $status, $this_content);
            $this_content = str_replace('{name}', htmlspecialchars(stripslashes(username_is($results['uid']))), $this_content);
            $main_table_content.= $this_content;
        }
    if (!empty($main_table_content)) {
        $main_table = $html['main_table'];
        $main_table = str_replace('%way', $newway, $main_table);
        $main_table = str_replace('%status', $status, $main_table);
        $main_table = str_replace('%content', $main_table_content, $main_table);
    }
    unset($main_table_content);
    /*pagination*/
    @($pages = $total/$per);
    $pages = (intval($pages) == $pages) ? $pages : intval($pages) +1;
    if ($pages > 1) {
        $pgs = array();
        for ($x = 1;$x <= $pages;++$x) {
            if ($x == $p) {
                $pgs[] = sprintf($html['main']['currentpage'], $x) . "\n";
            } else {
                $purl = $_SERVER['PHP_SELF'] . '?p=' . $x;
                $qs = preg_replace('/p=[0-9]+/', '', $_SERVER['QUERY_STRING']);
                if (!empty($qs)) {
                    $purl.= (substr($qs, 0, 1) == '&') ? $qs : "&amp;$qs";
                }
                $pgs[] = sprintf($html['main']['page'], $purl, $x) . "\n";
            }
        }
        $pgs = implode(', ', $pgs);
}
//echo '123'.load_buttons();
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  <div id="main">
    <?php echo $main_table;
unset($main_table); ?>
  	<input class="inputsubmit2" id="checkall" type="button" onclick="checkAll(this.form)" value="<?php echo LANG_SELECT_ALL; ?>"> 
  	<input class="inputsubmit2" id="uncheckall" type="button" onclick="uncheckAll(this.form)" value="<?php echo LANG_UNSELECT; ?>">
  	<br>
    <span id="tickets_found"><?php echo intval($total); ?> <em><?php echo LANG_TICKETS_FOUND; ?></em></span>
    <?php if ($pgs) { ?>
    <span class="pages"><b><?php echo LANG_PAGES; ?>:</b> <?php echo $pgs;
    unset($pgs); ?></span>
    <?php
} ?>
  </div>

<br>

<!-- buttons start -->
<div class="buttons">
<input class="inputsubmit" type="submit" id="close" name="close" title="<?php echo LANG_TIP_CLOSE; ?>" value="<?php echo LANG_CLOSE; ?>"> 
<?php
if ($user->admin):
?>
<input class="inputsubmit" type="submit" id="delete" name="delete" title="<?php echo LANG_TIP_DELETE; ?>" onClick='if(confirm("<?php echo LANG_DELETE_CONFIRM; ?>")) return; else return false;' value="<?php echo LANG_DELETE; ?>">
<br><br>
<?php echo LANG_SHOW_TICKETS; ?>
<select onChange="window.location=this.options[this.selectedIndex].value;" >
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_all"<?php echo $_SESSION['view']['status'] == 'all' ? ' selected' : ''; ?>><?php echo LANG_ALL; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_new"<?php echo $_SESSION['view']['status'] == 'new' ? 'selected' : ''; ?>><?php echo LANG_NEW; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_open"<?php echo $_SESSION['view']['status'] == 'open' ? ' selected' : ''; ?>><?php echo LANG_OPEN; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_onhold"<?php echo $_SESSION['view']['status'] == 'onhold' ? ' selected' : ''; ?>><?php echo LANG_ONHOLD; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_awaitingcustomer"<?php echo $_SESSION['view']['status'] == 'awaitingcustomer' ? ' selected' : ''; ?>><?php echo LANG_AWAITINGCUSTOMER; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_reopened"<?php echo $_SESSION['view']['status'] == 'reopened' ? ' selected' : ''; ?>><?php echo LANG_REOPENED; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_closed"<?php echo $_SESSION['view']['status'] == 'closed' ? ' selected' : ''; ?>><?php echo LANG_CLOSED; ?></option>
</select>
<?php
endif; ?>
<input class="inputsubmit" type="submit" id="refresh" name="refresh" title="<?php echo LANG_TIP_REFRESH; ?>" value="<?php echo LANG_REFRESH; ?>">
 </div>
<!-- buttons end -->
</form><?php
include("footer.php");
?>
