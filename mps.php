<?
include("header.php");
if(!$user->admin)loginrequired("admin");
define('THIS_SCRIPT', 'mps');
define('HACK_TITLE', 'Dream\'s Read PMs');  
define('MIN_SEARCH_WORD_LENGTH', '4');
function fetch_row_bgclass()
{
// returns the current alternating class for <TR> rows in the CP.
	global $bgcounter;
	return ($bgcounter++ % 2) == 0 ? 'alt1' : 'alt2';
}
function htmlspecialchars_uni($text, $entities = true)
{
	return str_replace(
		// replace special html characters
		array('<', '>', '"'),
		array('&lt;', '&gt;', '&quot;'),
		preg_replace(
			// translates all non-unicode entities
			'/&(?!' . ($entities ? '#[0-9]+|shy' : '(#[0-9]+|[a-z]+)') . ';)/si',
			'&amp;',
			$text
		)
	);
}
function print_table_start($echobr = true, $width = '100%', $cellspacing = 0, $id = '', $border_collapse = false)
{
	global $tableadded;

	$tableadded = 1;

	if ($echobr)
	{
		echo '<br />';
	}

	$id_html = ($id == '' ? '' : " id=\"$id\"");

	echo "\n<table cellpadding=\"4\" cellspacing=\"$cellspacing\" border=\"0\" align=\"center\" width=\"$width\" style=\"border-collapse:" . ($border_collapse ? 'collapse' : 'separate') . "\" class=\"tborder\"$id_html>\n";
}
function print_form_header($phpscript = '', $do = '', $uploadform = false, $addtable = true, $name = 'cpform', $width = '100%', $target = '', $echobr = true, $method = 'post', $cellspacing = 0, $border_collapse = false)
{
	global $vbulletin, $tableadded;

	if (($quote_pos = strpos($name, '"')) !== false)
	{
		$clean_name = substr($name, 0, $quote_pos);
	}
	else
	{
		$clean_name = $name;
	}

	echo "<form action=\"$phpscript.php?do=$do\"" . iif($uploadform, ' enctype="multipart/form-data"') . " method=\"$method\"" . iif($target, " target=\"$target\"") . " name=\"$clean_name\" id=\"$name\">\n";

	//construct_hidden_code('do', $do);
	echo "<input type=\"hidden\" name=\"do\" value=\"" . htmlspecialchars_uni($do) . "\" />\n";

	if ($addtable)
	{
		print_table_start($echobr, $width, $cellspacing, $clean_name . '_table', $border_collapse);
	}
	else
	{
		$tableadded = 0;
	}
}
// grab the counts of all users that have PMs
function rpm_get_pm_users($totalpms)
{
	global $db, $db_prefix;
	$res ="SELECT COUNT(`pm`.`recipient`) AS total, `pm`.`sender`, `pm`.`recipient`, `user`.`username`, `user`.`id` AS `userid` FROM `torrent_private_messages` AS `pm` INNER JOIN `torrent_users` AS `user` ON (`pm`.`recipient` = `user`.`id`) WHERE `pm`.`recipient` = `user`.`id` GROUP BY  `pm`.`recipient` HAVING total = " . $totalpms . " ORDER BY  `pm`.`recipient` DESC ";
	$pms=$db->sql_query($res) or btsqlerror($res);
	return $pms;
}
function rpm_print_footer()
{
}
function rpm_get_all_pm_users()
{
	global $db, $db_prefix;
	$totals = $db->sql_query("
		SELECT COUNT(*) AS total
		FROM `" . $db_prefix . "_private_messages`
		GROUP BY `recipient`
		ORDER BY total DESC
	");
	return $totals;
}
function rpm_get_pm($pmtextid)
{
	global $db, $db_prefix;
	$get_pm = $db->sql_fetchrow($db->sql_query("
		SELECT *
		FROM `" . $db_prefix . "_private_messages`
		WHERE `id` = " . $pmtextid . "
	"));
	return $get_pm;
}
function print_description_row($text, $htmlise = false, $colspan = 2, $class = '', $align = '', $helpname = NULL)
{
	global $stylevar;

	if (!$class)
	{
		$class = fetch_row_bgclass();
	}


	echo "<tr valign=\"top\">
	<td class=\"$class\"" . iif($colspan != 1," colspan=\"$colspan\"") . iif($align, " align=\"$align\"") . ">" . iif($htmlise, htmlspecialchars_uni($text), $text) . "</td>\n</tr>\n";
}
function iif($expression, $returntrue, $returnfalse = '')
{
	return ($expression ? $returntrue : $returnfalse);
}
function print_table_header($title, $colspan = 2, $htmlise = false, $anchor = '', $align = 'center', $helplink = true)
{
	global $bgcounter, $stylevar;

	if ($htmlise)
	{
		$title = htmlspecialchars_uni($title);
	}
	$title = "<b>$title</b>";
	if ($anchor != '')
	{
		$title = "<a name=\"$anchor\">$title</a>";
	}

	echo "<tr>\n\t<td class=\"tcat\" align=\"$align\"" . iif($colspan != 1, " colspan=\"$colspan\"") . ">$title</td>\n</tr>\n";

	$bgcounter = 0;
}
function rpm_user_exists($userid)
{
	global $db;
	$exists = $db->sql_fetchrow($db->sql_query("
		SELECT `id`
		FROM `torrent_users`
		WHERE `id` = " . $userid . "
	"));
	if ($exists)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function print_table_footer($colspan = 2, $rowhtml = '', $tooltip = '', $echoform = true)
{
	global $tableadded, $vbulletin;

	if ($rowhtml)
	{
		$tooltip = iif($tooltip != '', " title=\"$tooltip\"", '');
		if ($tableadded)
		{
			echo "<tr>\n\t<td class=\"tfoot\"" . iif($colspan != 1 ," colspan=\"$colspan\"") . " align=\"center\"$tooltip>$rowhtml</td>\n</tr>\n";
		}
		else
		{
			echo "<p align=\"center\"$tooltip>$extra</p>\n";
		}
	}

	if ($tableadded)
	{
		echo "</table>\n";
	}

	if ($echoform)
	{

		echo "</form>\n\n\n";
	}
}
function rpm_username_exists($username)
{
	global $db, $db_prefix;
	$exists = $db->sql_fetchrow($db->sql_query("
		SELECT `id`
		FROM `" . $db_prefix . "_users`
		WHERE LOWER(`username`) = LOWER('" . $username . "')
	"));
	if ($exists)
	{
		return $exists['id'];
	}
	else
	{
		return false;
	}
}
function rpm_get_name($userid)
{
	global $db, $db_prefix;
	$result = $db->sql_fetchrow($db->sql_query("
		SELECT `username`
		FROM `" . $db_prefix . "_users`
		WHERE `id` = " . $userid . "
	"));
	return $result['username'];
}
// search for PMs that match key search terms
function rpm_search_pms($search_for, $match)
{
	global $db, $db_prefix;
	if ($match == 'exact')
	{
		$sql = "SELECT DISTINCT `id`, `subject`, `sent`
			FROM `" . $db_prefix . "_private_messages` 
			WHERE `text` LIKE '%" . $search_for . "%'
			ORDER BY `sent` DESC";
	}
	elseif ($match == 'all')
	{
		$a = explode(' ', $search_for);
		$ands = implode("%' AND `message` LIKE '%", $a);
		$sql = "SELECT DISTINCT `id`, `subject`, `sent`
			FROM `" . $db_prefix . "_private_messages`
			WHERE `text` LIKE '%" . $ands . "%'
			ORDER BY `sent` DESC";
	}
	else
	{
		$a = explode(' ', $search_for);
		$ors = implode("%' OR `text` LIKE '%", $a);
		$sql = "SELECT DISTINCT `id`, `subject`, `sent`
			FROM `" . $db_prefix . "_private_messages`
			WHERE `text` LIKE '%" . $ors . "%' 
			ORDER BY `sent` DESC";
	}
	
	$result = $db->sql_query($sql);
	$pms = array();
	while($array = $db->sql_fetchrow($result))
	{
		$pms[] = $array;
	}
$db->sql_freeresult($result);
	return $pms;
}
function rpm_get_latest_pms($limit_by)
{
	global $db, $db_prefix;
	$res = "
		SELECT *
		FROM `" . $db_prefix . "_private_messages`
		ORDER BY `sent` DESC
		LIMIT 0, " . $limit_by . "
	";
	$result = $db->sql_query($res) or btsqlerror($res);
	$pms = array();
	while($array = $db->sql_fetchrow($result))
	{
		$pms[] = $array;
	}
$db->sql_freeresult($result);
	return $pms;
}
function rpm_get_pms($userid)
{
	global $db, $db_prefix;
	$res = "
		SELECT 	*
		FROM `" . $db_prefix . "_private_messages` AS pm
		WHERE pm.sender=" . $userid . " OR pm.recipient=" . $userid . "
		ORDER BY `sent` DESC
	";
	$result = $db->sql_query($res) or btsqlerror($res);
	$pms = array();
	while($array = $db->sql_fetchrow($result))
	{
		$pms[] = $array;
	}
$db->sql_freeresult($result);
	return $pms;
}
function print_cells_row($array, $isheaderrow = false, $class = false, $i = 0, $valign = 'top', $column = false, $smallfont = false)
{
	global $colspan, $bgcounter, $stylevar;

	if (is_array($array))
	{
		$colspan = sizeof($array);
		if ($colspan)
		{
			$j = 0;
			$doecho = 0;

			if (!$class AND !$column AND !$isheaderrow)
			{
				$bgclass = fetch_row_bgclass();
			}
			elseif ($isheaderrow)
			{
				$bgclass = 'thead';
			}
			else
			{
				$bgclass = $class;
			}

			$bgcounter = iif($column, 0, $bgcounter);
			$out = "<tr valign=\"$valign\" align=\"center\">\n";

			foreach($array AS $key => $val)
			{
				$j++;
				if ($val == '' AND !is_int($val))
				{
					$val = '&nbsp;';
				}
				else
				{
					$doecho = 1;
				}

				if ($i++ < 1)
				{
					$align = " align=\"$stylevar[left]\"";
				}
				elseif ($j == $colspan AND $i == $colspan AND $j != 2)
				{
					$align = " align=\"$stylevar[right]\"";
				}
				else
				{
					$align = '';
				}

				if (!$class AND $column)
				{
					$bgclass = fetch_row_bgclass();
				}
				if ($smallfont)
				{
					$val = "<span class=\"smallfont\">$val</span>";
				}
				$out .= "\t<td" . iif($column, " class=\"$bgclass\"", " class=\"$bgclass\"") . "$align>$val</td>\n";
			}

			$out .= "</tr>\n";

			if ($doecho)
			{
				echo $out;
			}
		}
	}
}
function print_label_row($title, $value = '&nbsp;', $class = '', $valign = 'top', $helpname = NULL, $dowidth = false)
{
	global $stylevar;

	if (!$class)
	{
		$class = fetch_row_bgclass();
	}

	if ($helpname !== NULL AND $helpbutton = construct_table_help_button($helpname))
	{
		$value = '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr valign="top"><td>' . $value . "</td><td align=\"$stylevar[right]\" style=\"padding-$stylevar[left]:4px\">$helpbutton</td></tr></table>";
	}

	if ($dowidth)
	{
		if (is_numeric($dowidth))
		{
			$left_width = $dowidth;
			$right_width = 100 - $dowidth;
		}
		else
		{
			$left_width = 70;
			$right_width = 30;
		}
	}

	echo "<tr valign=\"$valign\">
	<td class=\"$class\"" . ($dowidth ? " width=\"$left_width%\"" : '') . ">$title</td>
	<td class=\"$class\"" . ($dowidth ? " width=\"$right_width%\"" : '') . ">$value</td>\n</tr>\n";
}
function rpm_print_stop_back($text = 'error')
{
	global $vbphrase;
	echo '<p>&nbsp;</p><p>&nbsp;</p>';
	print_form_header('', '', 0, 1, 'messageform', '65%');
	print_table_header($vbphrase['vbulletin_message']);
	print_description_row("<blockquote><br />$text<br /><br /></blockquote>");
	print_table_footer(2, '<input class="button" value="Go Back" title="" tabindex="1" onclick="window.location=\'javascript:history.back(1)\';" type="button">');
	rpm_print_footer();
}

// ####################### LIST USERS WITH X AMOUNT OF PMs ##########################
if ( $_REQUEST['do'] == 'havepms' )
{
	// grab list of users that have PMs
	$havepms = rpm_get_pm_users($_REQUEST['totalpms']);

	// if there are no PMs
	if (!$db->num_rows($havepms))
	{
		rpm_print_stop_back('There are no PMs.');
		die();
	}

	// show the list
	OpenTable(HACK_TITLE . ' - List Users With ' . $_REQUEST['totalpms'] . ' PMs');
	print_form_header('', '', 0, 1, 'havepmsForm');
	print_table_header('List of users with ' . $_REQUEST['totalpms'] . ' PMs');
	while($pms = $db->sql_fetchrow($havepms))
	{
		$link1 = THIS_SCRIPT . '.php?do=list&userid=' . $pms['userid'];
		$link2 = 'pm.php?op=send&to=' . $pms['userid'];
		$link3 = 'user.php?op=editprofile&id=' . $pms['userid'];
		$row = '<span style="float:right">[<a href="' . $link1 . '">Show All PMs</a>] ';
		$row .= '[<a href="' . $link2 . '">Send PM to User</a>] ';
		$row .= '[<a href="' . $link3 . '">Edit User</a>]</span>';
		$row .= '<b>' . $pms['username'] . '</b>';
		print_description_row($row);
	}
	print_table_footer(2, '<input class="button" value="Go Back" title="" tabindex="1" onclick="window.location=\'javascript:history.back(1)\';" type="button">');
	CloseTable();
}
// ####################### LIST ALL USERS WITH PMs ##########################
if ($_REQUEST['do'] == 'allusershavepms')
{
	// get array of PM counts
	$pmcounts = rpm_get_all_pm_users();

	print_form_header('', '', 0, 1, 'allusershavepmsForm');
	print_table_header('List Users With PMs');

	// assign the counts
	$pmtotals = array();
	while ($currentpmcount = $db->sql_fetchrow($pmcounts))
	{
		$pmtotals[$currentpmcount['total']]++;
	}

	// construct & display the rows
	foreach ($pmtotals as $pmtotal => $totalusers)
	{	
		if ($totalusers != 1)
		{
		$usertext = 'There are ' . $totalusers .' users';
		}
		else
		{
			$usertext = 'There is ' . $totalusers .' user';
		}
		$link = THIS_SCRIPT . '.php?do=havepms&totalpms=' . $pmtotal;
		$row = '<span style="float:right">[<a href="' . $link . '">List All Users</a>]</span>';
		$row .= $usertext . ' with ' . $pmtotal . ' PMs' ;
		print_description_row($row);
	}
	print_table_footer(2, '<input class="button" value="Go Back" title="" tabindex="1" onclick="window.location=\'javascript:history.back(1)\';" type="button">');
}
// ############################# READ PMs #################################
if ($_REQUEST['do'] == 'list')
{
	// if no userid or username entered
	if (empty($_REQUEST['userid']))
	{
		print('You need to enter a User ID or Username.');
	}
	
	// if it is a username
	if (!is_numeric($_REQUEST['userid']))
	{
		// check the username exists and assign it
		$userid = rpm_username_exists($_REQUEST['userid']);
		
		// if username does not exist
		if (empty($userid))
		{
			print('User <b>' . $_REQUEST['userid'] . '</b> does not exist.' . $userid);
			die();
		}
	}
	else // if userid
	{
		// if userid does not exist
		if (!rpm_user_exists($_REQUEST['userid']))
		{
			print('User ID: <b>' . $_REQUEST['userid'] . '</b> does not exist.');
			die();
		}
		
		// assign the userid
		$userid = $_REQUEST['userid'];
	}
	
	// get all PMs for the user
	$pms = rpm_get_pms($userid);
	
	// if there are no PMs
	if (empty($pms))
	{
		print('User <b>' . $_REQUEST['userid'] . '</b> has no PMs.');
		die();
	}
	
	// get the username
	$name = rpm_get_name($userid);
	
	// seperate sent and recieved PMs
	$sent = array();
	$received = array();
	foreach ($pms AS $pm)
	{
		// seperate sent and recieved PMs (also takes into account user sending to self via to or bcc)
		if ($pm['sender'] == $userid)
		{
			$sent[] = $pm;
		}
		else
		{
			$received[] = $pm;
		}
	}
	
	// display list of sent PMs
	print_form_header('', '', 0, 1, 'sentpmlistForm');
	print_table_header(count($sent) . ' PMs sent from ' . $name . ' (Userid: ' . $userid . ')', 4);
	if (empty($sent))
	{
		print_description_row('<center>There are no sent PMs to view.</center>');
	}
	else
	{
		print_cells_row(array('&nbsp;', 'PM Title', 'Date', ''), 1);
		foreach ($sent AS $pm)
		{
		    if ($pm["is_read"] == "true") $read = pic("pm_read.gif",null,_btpmread);
            else $read = pic("pm_unread.gif",null,_btpmunread);
			$date = $pm['sent'];
			$link = THIS_SCRIPT . '.php?do=read&pmtextid=' . $pm['id'];
			$row = array();
			$row[] = '<div class="smallfont">' . $read . '</div>';
			$row[] = '<div class="smallfont"><span style="float:left">' . stripslashes($pm['subject']) . '</span></div>';
			$row[] = '<div class="smallfont">' . $date . '';
			$row[] = '<div class="smallfont">[<a href="' . $link . '">View Private Message</a>]</div>';
			print_cells_row($row);
		}
	}	
	print_table_footer(4, '<input class="button" value="Go Back" title="" tabindex="1" onclick="window.location=\'javascript:history.back(1)\';" type="button">');
	
	// display list of recieved PMs
	print_form_header('', '', 0, 1, 'receivedpmlistForm');
	print_table_header(count($received) . ' PMs recieved for ' . $name . ' (Userid: ' . $userid . ')', 5);
	if (empty($received))
	{
		print_description_row('<center>There are no recieved PMs to view.</center>');
	}
	else
	{
		print_cells_row(array('&nbsp;', 'PM Title', 'From', 'Date', ''), 1);
		foreach ($received AS $pm)
		{
			$date = $pm['sent'];
			$link = THIS_SCRIPT . '.php?do=read&pmtextid=' . $pm['id'];
		    if ($pm["is_read"] == "true") $read = pic("pm_read.gif",null,_btpmread);
            else $read = pic("pm_unread.gif",null,_btpmunread);
			$row = array();
			$row[] = '<div class="smallfont">' . $read . '</div>';
			$row[] = '<div class="smallfont"><span style="float:left">' . stripslashes($pm['subject']) . '</span></div>';
			$row[] = '<div class="smallfont">' . username_is($pm['sender']) . '</div>';
			$row[] = '<div class="smallfont">' . $date . '';
			$row[] = '<div class="smallfont">[<a href="' . $link . '">View Private Message</a>]</div>';
			print_cells_row($row);
		}
	}
	print_table_footer(5, '<input class="button" value="Go Back" title="" tabindex="1" onclick="window.location=\'javascript:history.back(1)\';" type="button">');
}
if ($_REQUEST['do'] == 'read')
{
	// no pmtextid
	if (empty($_REQUEST['pmtextid']))
	{
		print('Need a pmtextid.');
		die();
	}
	
	// if pmtext is not a number or number < 1
	if (!is_numeric($_REQUEST['pmtextid']) OR $_REQUEST['pmtextid'] < 1)
	{
		print('Pmtextid must be a positive number.');
		die();
	}
	
	// get the requested PM
	$pm = rpm_get_pm($_REQUEST['pmtextid']);
	
	// PM does not exist
	if (empty($pm))
	{
		print('Pmtextid <b>' . $_REQUEST['pmtextid'] . '</b> does not exist.');
		die();
	}
	
	// get all userids for the users that still have the PM with pmtextid
	$userids = $db->sql_fetchrow($db->sql_query("
		SELECT DISTINCT `sender`
		FROM `".$db_prefix."_private_messages`
		WHERE `id` = " . $_REQUEST['pmtextid'] . "
	"));
	
	// If there are no userids then the PM does not exist (this handles the last x PMs)
	if (empty($userids))
	{
		print('
			<center>Pmtextid <b>' . $_REQUEST['pmtextid'] . '</b> has been deleted and can not be recovered.
			<br />The non-existant entry will be automatically removed within the hour by the
			<br /><b>Hourly Cleanup #2</b> scheduled task.</center>
		');
		die();
	}
	
	// grab array of to and bcc users
	//$toarray = array_values(unserialize($pm['touserarray']));

	// convert date to readable format
	$date = $pm['sent'];
	
	// show PM contents
	print_form_header('', '', 0, 1, 'pmlistForm');
	print_table_header('Private Message Text ID : ' . $pm['id'],2);
	print_label_row('<b>From:</b></b><dfn>Link goes to users pmstats.</dfn>', username_is($pm['sender']) . ' (<a href = "user.php?op=profile&id=' . $pm['sender'] . '">userid: ' . $pm['sender'] . '</a>)');
	if (is_array($toarray[0]))
	{
		print_label_row('<b>To:</b><dfn>Link(s) goes to users pmstats.</dfn>' , rpm_display_recipients_with_links($toarray[0]));
	}
	if (is_array($toarray[1]))
	{
		print_label_row('<b>BCC:</b></b><dfn>Link(s) goes to users pmstats.</dfn>' , rpm_display_recipients_with_links($toarray[1]));
	}
	print_label_row('<b>PM Title:</b>', stripslashes($pm['subject']));
	print_label_row('<b>Date:</b>', $date);
	
								$message = format_comment($pm['text'], false, true);
                                parse_smiles($message);
	print_label_row('<b>Message:', '<div class="smallfont">' . $message . '</div>');
	print_table_footer(2, '<input class="button" value="Go Back" title="" tabindex="1" onclick="window.location=\'javascript:history.back(1)\';" type="button">');
}
// ############################### SEARCH #################################
if ($_REQUEST['do'] == 'search')
{
	// if no search terms have been entered
	if (empty($_REQUEST['search']))
	{
		rpm_print_stop_back('You must type in at least one word to search for.');
	}
	
	// assign and make search terms safe
	$search_for = $db->sql_escape($_REQUEST['search']);
	
	// see if any of the search terms is lower than the minimum length 
	$words = explode(" ", $search_for);
	foreach ($words AS $current)
	{
		if (strlen($current) < MIN_SEARCH_WORD_LENGTH)
		{
			rpm_print_stop_back('At least one of your search terms was less than ' . MIN_SEARCH_WORD_LENGTH .' characters long.');
		}
	}
	
	// assign the type of match
	$match = $_REQUEST['match'];
	
	// conduct the search
	$pms = rpm_search_pms($search_for, $match);
	
	// format search words for display purposes
	switch ($match)
	{
		case 'exact':
			$search_words = str_replace(" ", " + ", $search_for);
			$search_wording = 'the exact text';
			break;

		case 'all':
			$search_words = str_replace(" ", " and ", $search_for);
			$search_wording = 'all of the following words';
			break;

		case 'atleastone':
			$search_words = str_replace(" ", " or ", $search_for);
			$search_wording = 'at least one of the following words';
			break;
	}

	// display list of PMs found
	print_form_header('', '', 0, 1, 'pmlistForm');
	print_table_header('Search Results for ' . $search_wording . ': ' . $search_words . '', 4);
	if (empty($pms))
	{
		print_description_row('<center>There are no results to view for the search text.</center>');
	}
	else
	{
		print_cells_row(array('pmtextid', 'PM Title', 'Date', ''), 1);
		foreach ($pms AS $pm)
		{
			$date = $pm['sent'];
			$link = THIS_SCRIPT . '.php?do=read&pmtextid=' . $pm['id'];
			$row = array();
		    if ($pm["is_read"] == "true") $read = pic("pm_read.gif",null,_btpmread);
            else $read = pic("pm_unread.gif",null,_btpmunread);			
			$row[] = '<div class="smallfont">' . $read . '</div>';
			$row[] = '<div class="smallfont"><span style="float:left">' . stripslashes($pm['subject']) . '</span></div>';
			$row[] = '<div class="smallfont">' . $date . '';
			$row[] = '<div class="smallfont">[<a href="' . $link . '">View Private Message</a>]</div>';
			print_cells_row($row);
		}
	}
	print_table_footer(4, '<input class="button" value="Go Back" title="" tabindex="1" onclick="window.location=\'javascript:history.back(1)\';" type="button">');
}

// ########################### LATEST X PMs ###############################
if ($_REQUEST['do'] == 'latest')
{
	// if nothing entered or zero entered
	if (empty($_REQUEST['showlatest']))
	{
		rpm_print_stop_back('Enter a positive number greater than 0.');
	}

	// if non-numeric or negative number entered
	if (!is_numeric($_REQUEST['showlatest']) OR $_REQUEST['showlatest'] < 1)
	{
		rpm_print_stop_back('Enter a positive number greater than 0.');
	}
	
	// get the PM list
	$pms = rpm_get_latest_pms($_REQUEST['showlatest']);
	
	// if no PMs
	if (empty($pms))
	{
		rpm_print_stop_back('There are no PMs to view.');
	}
	
	// display PM list
	print_form_header('', '', 0, 1, 'pmlistForm');
	print_table_header('Show Last ' . $_REQUEST['showlatest'] . ' PMs', 5);
	print_cells_row(array('pmtextid', 'PM Title', 'To','From', 'Date', ''), 1);
	foreach ($pms AS $pm)
	{
		$date = $pm['sent'];
		$link = THIS_SCRIPT . '.php?do=read&pmtextid=' . $pm['id'];
		$row = array();
		    if ($pm["is_read"] == "true") $read = pic("pm_read.gif",null,_btpmread);
            else $read = pic("pm_unread.gif",null,_btpmunread);
		$row[] = '<div class="smallfont">' . $read . '</div>';
		$row[] = '<div class="smallfont"><span style="float:left">' . stripslashes($pm['subject']) . '</span></div>';
		$row[] = '<div class="smallfont">' . username_is($pm['recipient']) . '</div>';
		$row[] = '<div class="smallfont">' . username_is($pm['sender']) . '</div>';
		$row[] = '<div class="smallfont">' . $date . '';
		$row[] = '<div class="smallfont">[<a href="' . $link . '">View Private Message</a>]</div>';
		print_cells_row($row);
	}
	print_table_footer(5, '<input class="button" value="Go Back" title="" tabindex="1" onclick="window.location=\'javascript:history.back(1)\';" type="button">');
}

//$byuser = "WHERE username ='".escape($userid)."' OR name = '".escape($userid)."' OR clean_username = '".escape(strtolower($userid))."' OR id = ".escape($userid)."";
//////////END PAGER///////////
$res = $db->sql_query("SELECT * FROM torrent_private_messages $byuser ORDER BY id DESC $limit") or sqlerr(__FILE__, __LINE__);
if (empty($_REQUEST['do']))
{

?>
<!-- form started:6 queries executed -->
<form action="mps.php?do=list" method="post" name="listForm" id="listForm">
<input type="hidden" name="do" value="list" />
<input type="hidden" name="adminhash" value="3e73dc37dcedd5625580f2b3003a7c54" />
<input type="hidden" name="securitytoken" value="1246320728-ece494df92d839cbf13763b1e8d2fd3fdae46f8c" />

<br />
<table cellpadding="4" cellspacing="0" border="0" align="center" width="90%" style="border-collapse:separate" class="tborder" id="listForm_table">
<tr>
	<td class="tcat" align="center" colspan="2"><b>Read PMs</b></td>
</tr>
<tr valign="top">
	<td class="alt1">User ID or Username</td>
	<td class="alt1"><div id="ctrl_userid"><input type="text" class="bginput" name="userid" id="it_userid_1" value="" size="35" dir="ltr" tabindex="1" /></div></td>
</tr>
<tr>
	<td class="tfoot" colspan="2" align="center">	<input type="submit" id="submit0" class="button" tabindex="1" value="Read PMs" accesskey="s" />

</td>
</tr>
</table>
</form>
<!-- form ended: 6 queries executed -->


<!-- form started:6 queries executed -->
<form action="mps.php?do=havepms" method="post" name="resetForm" id="resetForm">
<input type="hidden" name="do" value="allusershavepms" />
<input type="hidden" name="adminhash" value="3e73dc37dcedd5625580f2b3003a7c54" />
<input type="hidden" name="securitytoken" value="1246320728-ece494df92d839cbf13763b1e8d2fd3fdae46f8c" />
<br />
<table cellpadding="4" cellspacing="0" border="0" align="center" width="90%" style="border-collapse:separate" class="tborder" id="resetForm_table">
<tr>
	<td class="tfoot" colspan="2" align="center">	<input type="submit" id="submit1" class="button" tabindex="1" value="List Users with PMs" accesskey="s" />

</td>
</tr>
</table>
</form>
<!-- form ended: 6 queries executed -->


<!-- form started:6 queries executed -->
<form action="mps.php?do=search" method="post" name="searchForm" id="searchForm">
<input type="hidden" name="do" value="search" />
<input type="hidden" name="adminhash" value="3e73dc37dcedd5625580f2b3003a7c54" />
<input type="hidden" name="securitytoken" value="1246320728-ece494df92d839cbf13763b1e8d2fd3fdae46f8c" />
<br />
<table cellpadding="4" cellspacing="0" border="0" align="center" width="90%" style="border-collapse:separate" class="tborder" id="searchForm_table">
<tr>
	<td class="tcat" align="center" colspan="2"><b>Search for PMs</b></td>

</tr>
<tr valign="top">
	<td class="alt1">Search for<p><input type="button" unselectable="on" value="Large Edit Box" class="button" style="font-weight:normal" onclick="window.open('textarea.php?dir=ltr&name=search','textpopup','resizable=yes,scrollbars=yes,width=' + (screen.width - (screen.width/10)) + ',height=600');" /></p></td>
	<td class="alt1"><div id="ctrl_search"><textarea name="search" id="ta_search_2" rows="4" cols="40" wrap="virtual" dir="ltr" tabindex="1"></textarea><div class="smallfont"><a href="#"  onclick="return resize_textarea(1, 'ta_search_2')">Increase Size</a> <a href="#"  onclick="return resize_textarea(-1, 'ta_search_2')">Decrease Size</a></div></div></td>
</tr>
<tr valign="top">
	<td class="alt2">Match</td>
	<td class="alt2"><div class="normal">

<div class="ctrl_">		<label for="rb_matchexact_3"><input type="radio" name="match" id="rb_matchexact_3" tabindex="1" value="exact" checked="checked" />exact text</label><br />
		<label for="rb_matchall_3"><input type="radio" name="match" id="rb_matchall_3" tabindex="1" value="all" />all words</label><br />
		<label for="rb_matchatleastone_3"><input type="radio" name="match" id="rb_matchatleastone_3" tabindex="1" value="atleastone" />at least one of the words</label><br />
</div>	</div></td>
</tr>
<tr>
	<td class="tfoot" colspan="2" align="center">	<input type="submit" id="submit2" class="button" tabindex="1" value="Search for PMs" accesskey="s" />
</td>

</tr>
</table>
</form>
<!-- form ended: 6 queries executed -->


<!-- form started:6 queries executed -->
<form action="mps.php?do=latest" method="post" name="latestForm" id="latestForm">
<input type="hidden" name="do" value="latest" />
<input type="hidden" name="adminhash" value="3e73dc37dcedd5625580f2b3003a7c54" />
<input type="hidden" name="securitytoken" value="1246320728-ece494df92d839cbf13763b1e8d2fd3fdae46f8c" />
<br />
<table cellpadding="4" cellspacing="0" border="0" align="center" width="90%" style="border-collapse:separate" class="tborder" id="latestForm_table">
<tr>
	<td class="tcat" align="center" colspan="2"><b>Latest PMs</b></td>

</tr>
<tr valign="top">
	<td class="alt1">Number of PMs to show</td>
	<td class="alt1"><div id="ctrl_showlatest"><input type="text" class="bginput" name="showlatest" id="it_showlatest_4" value="100" size="35" dir="ltr" tabindex="1" /></div></td>
</tr>
<tr>
	<td class="tfoot" colspan="2" align="center">	<input type="submit" id="submit3" class="button" tabindex="1" value="Latest PMs" accesskey="s" />
</td>
</tr>
</table>
</form>
<!-- form ended: 6 queries executed -->
<?php
}
include("footer.php");
?>