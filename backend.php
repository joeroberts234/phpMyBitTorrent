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
*------              ?2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("include/config_lite.php");
function search_word($word, $search){
global $search;
if(empty($search))return $word;
$search = str_replace("+"," ",$search);
$newterm = str_ireplace($search,"<span style=\"background: #242424;\" class=\"highlight\">$search</span>",$word);
return $newterm;
}
function sql_timestamp_to_unix_timestamp($s)
{
  return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));
}
function searchfield($s) {
        return preg_replace(array('/[^a-z0-9]/si', '/^\s*/s', '/\s*$/s', '/\s+/s'), array(" ", "", "", " "), $s);
}
function parse_smiles(&$text) { //Parses text against smiles
        global $db, $db_prefix, $siteurl;
        $sql = "SELECT * FROM ".$db_prefix."_smiles;";
        $smile_res = $db->sql_query($sql);
        $search = Array();
        $replace = Array();
        while ($smile = $db->sql_fetchrow($smile_res)) {
                $search[] = $smile["code"];
                $replace[] = "<img src=\"".$siteurl."/smiles/".$smile["file"]."\" border=\"0\" alt=\"".$smile["alt"]."\">";
        }
        $text = str_replace($search,$replace,$text);
        $db->sql_freeresult($smile_res);
}
function format_comment($text, $strip_html = false, $strip_slash = false)
{
	global $smilies, $privatesmilies;

	$s = $text;

	if ($strip_html)
		$s = htmlspecialchars($s);

	if ($strip_slash)
		$s = stripslashes($s);

$s = str_replace("]\n", "]", $s);
$match = array(
"/\[list\]\s*((\s|.)+?)\s*\[\/list\]/i",
"/\[list=(.*?)\]\s*((\s|.)+?)\s*\[\/list=(.*?)\]/i",
"/\[\*\]/i",
"/\[br\]/",
"/\[b\]((\s|.)+?)\[\/b\]/",
"/\[i\]((\s|.)+?)\[\/i\]/",
"/\[u\]((\s|.)+?)\[\/u\]/",
"/\[img\](http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png))\[\/img\]/i",
"/\[img=(http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png))\]/i",
"/\[color=([a-zA-Z]+)\]((\s|.)+?)\[\/color\]/i",
"/\[color=(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\]((\s|.)+?)\[\/color\]/i",
"/\[url=((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
"/\[url\]((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\[\/url\]/i",
"/\[size=([1-7])\]((\s|.)+?)\[\/size\]/i",
"/\[center\]((\s|.)+?)\[\/center\]/i",
"/\[font=([a-zA-Z ,]+)\]((\s|.)+?)\[\/font\]/i",
"/\[video=[^\s'\"<>]*youtube.com.*v=([^\s'\"<>]+)\]/ims",
"/\[video=[^\s'\"<>]*video.google.com.*docid=(-?[0-9]+).*\]/ims",
'#\[code=php\](.*?)\[\/code\]#se',
'#\[php\](.*?)\[\/php\]#se',
"/\[skype\]((\s|.)+?)\[\/skype\]\s*/i",
"/\[website\](.*?)\[\/website\]\s*/i",
"/\[spoiler\]\s*((\s|.)+?)\s*\[\/spoiler\]\s*/i",
"/\[msn=(.*?)\]\s*/i",
"/\[yahoo\](.*?)\[\/yahoo\]\s*/i",
"/\[aim=(.*?)\](.*?)\[\/aim\]\s*/i",
);
$replace = array(
"<span><ul>\\1</ul></span>",
"<span><ol TYPE=\\1>\\2</ol></span>",
"<li>",
"<br>",
"<b>\\1</b>",
"<i>\\1</i>",
"<u>\\1</u>",
"<a href=\"\\1\" target=\"_blank\"><img border=0 src=\"\\1\" ></a>",
"<a href=\"\\1\" target=\"_blank\"><img border=0 src=\"\\1\" ></a>",
"<font color=\\1>\\2</font>",
"<font color=\\1>\\2</font>",
"<a href=redirect.php?url=\\1 target=\"_blank\">\\3</a>",
"<a href=redirect.php?url=\\1 target=\"_blank\">\\1</a>",
"<font size=\\1>\\2</font>",
"<center>\\1</center>",
"<font face=\"\\1\">\\2</font>",
"<object width=\"500\" height=\"410\"><param name=\"movie\" value=\"http://www.youtube.com/v/\\1\"></param><embed src=\"http://www.youtube.com/v/\\1\" type=\"application/x-shockwave-flash\" width=\"500\" height=\"410\"></embed></object>",
"<embed style=\"width:500px; height:410px;\" id=\"VideoPlayback\" align=\"middle\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=\\1\" allowScriptAccess=\"sameDomain\" quality=\"best\" bgcolor=\"#ffffff\" scale=\"noScale\" wmode=\"window\" salign=\"TL\"  FlashVars=\"playerMode=embedded\"> </embed>",
"'<dl class=\"codebox\"><dt>Code: <a href=\"#\" onclick=\"selectCode(this); return false;\">Select all</a></dt><table class=main2 border=0 cellspacing=0 cellpadding=10><tr><td>'.highlight_string(stripslashes('$1'), true).'<td></tr></table><br /></dl>'",
"'<dl class=\"codebox\"><dt>Code: <a href=\"#\" onclick=\"selectCode(this); return false;\">Select all</a></dt><table class=main2 border=0 cellspacing=0 cellpadding=10><tr><td>'.highlight_string(stripslashes('$1'), true).'<td></tr></table><br /></dl>'",
"<script type=\"text/javascript\" src=\"http://download.skype.com/share/skypebuttons/js/skypeCheck.js\"></script><a href=\"skype:spockst?call\"><img src=\"http://mystatus.skype.com/smallclassic/\\1\" style=\"border: none;\" width=\"114\" height=\"20\" alt=\"My status\" /></a>",
"<iframe src=\"\\1\" name=\"frame1\" scrolling=\"auto\" frameborder=\"0\" align=\"middle\" height = \"500px\" width = \"600px\"></iframe>",
"<div style=\"padding: 3px; background-color: #FFFFFF; border: 1px solid #d8d8d8; font-size: 1em;\"><div style=\"text-transform: uppercase; border-bottom: 1px solid #CCCCCC; margin-bottom: 3px; font-size: 0.8em; font-weight: bold; display: block;\"><span onClick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') {  this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '<b>Spoiler: </b><a href=\'#\' onClick=\'return false;\'>hide</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '<b>Spoiler: </b><a href=\'#\' onClick=\'return false;\'>show</a>'; }\" /><b>Spoiler: </b><a href=\"#\" onClick=\"return false;\">show</a></span></div><div class=\"quotecontent\"><div style=\"display: none;\">\\1</div></div></div>",
"<img title=\"msn online indicator\" alt=\"msn status\" src=\"http://www.bencastricum.nl/msn/status.php/\\1.png\"/>",
"<a href=http://edit.yahoo.com/config/send_webmesg?.target=\\1&.src=pg><img border=0 src=http://opi.yahoo.com/online?u=\\1",
"<img src=http://www.funnyweb.dk:8080/aim/\\1 alt=\\2>",
);
$s = preg_replace($match, $replace, $s);
	// URLs
	$s = format_urls($s);


	// Maintain spacing
	$s = str_replace("  ", " &nbsp;", $s);
	//Quotes
$s = format_quotes($s);
	// Linebreaks
	$s = nl2br($s);

	return $s;
}
function format_urls($s)
{
return preg_replace(
    "/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^<>\s]+)/i",
    "\\1<a href=redirect.php?url=\\2>\\2</a>", $s);
}
function format_quotes($s)
{
   preg_match_all('/\\[quote.*?\\]/', $s, $result, PREG_PATTERN_ORDER);
    $openquotecount = count($openquote = $result[0]);
   preg_match_all('/\\[\/quote\\]/', $s, $result, PREG_PATTERN_ORDER);
    $closequotecount = count($closequote = $result[0]);

   if ($openquotecount != $closequotecount) return $s; // quote mismatch. Return raw string...

   // Get position of opening quotes
    $openval = array();
   $pos = -1;

   foreach($openquote as $val)
 $openval[] = $pos = strpos($s,$val,$pos+1);

   // Get position of closing quotes
   $closeval = array();
   $pos = -1;

   foreach($closequote as $val)
       $closeval[] = $pos = strpos($s,$val,$pos+1);


   for ($i=0; $i < count($openval); $i++)
 if ($openval[$i] > $closeval[$i]) return $s; // Cannot close before opening. Return raw string...


    $s = str_replace("[quote]","<p class=sub><b>Quote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>",$s);
   $s = preg_replace("/\\[quote=(.+?)\\]/", "<p class=sub><b>\\1 wrote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>", $s);
   $s = str_replace("[/quote]","</td></tr></table><br>",$s);
   return $s;
}


//Last Torrents
if (!isset($op)) $op = "";
switch($op) {
        case "category": {
                $sql = "SELECT id, name, descr, seeders, leechers, category, size FROM ".$db_prefix."_torrents 
				WHERE banned = 'no' AND visible = 'yes' AND category = '".$cat."' AND password IS NULL 
				ORDER BY tot_peer, seeders, completed, added DESC LIMIT 10;";
				$sql_cat = "SELECT name FROM ".$db_prefix."_categories 
				WHERE id = ".$cat."";
                $res = $db->sql_query($sql_cat);
                $cat_row = $db->sql_fetchrow($res);
                $descr = "Best 10 Torrents for Category ".$cat_row['name']." on ".$sitename."' (files feed)";
                break;
        }
        case "best": {
                $sql = "SELECT id, name, descr, seeders, leechers, category, owner, added, size FROM ".$db_prefix."_torrents WHERE banned = 'no' AND visible = 'yes' AND password IS NULL ORDER BY tot_peer, seeders, completed, added DESC LIMIT 10;";
                $descr = "Best 10 Torrents on ".$sitename."' (files feed)";
                break;
        }
        case "search": {
		        if(!isset($dead))
				$rssdead ="AND visible = 'yes' ";
				else
				$rssdead = "";
                if (!isset($search)) $search = "";
                $cat = (isset($cat)) ? intval($cat) : 0;
                $orderby = (isset($orderby)) ? intval($orderby) : -1;
                $sql = "SELECT id, name, descr, seeders, leechers, category, owner, size FROM ".$db_prefix."_torrents  WHERE banned = 'no' ".$rssdead." AND password IS NULL ";
                if (!empty($search)) $sql .= " AND search_text LIKE ('%".addslashes(searchfield($search))."%') ";
                if (!isset($ordertype) OR $ordertype != "ASC") $ordertype = "DESC";
                if (isset($incldead) AND $incldead != "true") $sql .= "AND visible = 'yes' ";
                if ($cat > 0) $sql .= " AND category = '".$cat."' ";

switch ($orderby) {
        case 0: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.added ".$ordertype;
                break;
        }
	case 1: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.seeders ".$ordertype;
                break;
        }
        case 2: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.leechers ".$ordertype;
                break;
        }
        case 3: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.tot_peer ".$ordertype;
                break;
        }
	case 4: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.downloaded ".$ordertype;
                break;
        }
        
        case 5: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.ratingsum ".$ordertype;
                break;
        }
	case 6: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.name ".$ordertype;
                break;
        }
        case 7: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.size ".$ordertype;
                break;
        }
        case 8: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.numfiles ".$ordertype;
                break;
        }
        default: {
                $sql .= "ORDER BY ".$db_prefix."_torrents.id ".$ordertype;
        }
                }
                $sql .= " LIMIT 10;";
                $descr = "Results for search term ".$search." on ".$sitename." (files feed)";
                break;
        }
        case "last":
        default: {
                $sql = "SELECT id, name, descr, seeders, leechers, category, owner, added, size FROM ".$db_prefix."_torrents WHERE banned = 'no' AND visible = 'yes' AND password IS NULL ORDER BY added DESC LIMIT 10;";
                $descr = "The Latest 10 Torrents on ".$sitename." (files feed)";
        }
}


$res = $db->sql_query($sql);
$rss = '';
$rss .= "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?><rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">
<channel>
<title>".$sitename."</title>
<link>".$siteurl."/</link>
<description>".$descr."</description>
<language>en-us</language>
<atom:link href=\"".$siteurl."/backend.php\" rel=\"self\" type=\"application/rss+xml\" />";

while ($row = $db->sql_fetchrow($res)) {
                $cat = "SELECT name FROM ".$db_prefix."_categories WHERE id = ".$row["category"]." ;";
$cat2 = $db->sql_query($cat);
$cat3 = $db->sql_fetchrow($cat2);
                $sql_own = "SELECT username FROM ".$db_prefix."_users WHERE id = ".$row["owner"]." ;";
$sql_own1 = $db->sql_query($sql_own);
$owner = $db->sql_fetchrow($sql_own1);
								$text = format_comment($row["descr"], false, true);
                                parse_smiles($text);
								    $year = substr($row['added'], 0, 4);
    $month = substr($row['added'], 4, 2);
    $day = substr($row['added'], 6, 2);
    $hour = substr($row['added'], 8, 2);
    $min = substr($row['added'], 10, 2);
    $sec = substr($row['added'], 12, 2);
    $pubdate = date('D, d M Y H:i:s O', mktime($hour, $min, $sec, $month, $day, $year));



        $ids = $row["id"];
        $names = $row["name"];
        $descrption = "&lt;font &gt;&lt;b&gt;Category:&lt;/b&gt;&lt;/font&gt; ".$cat3["name"]."&lt;br /&gt;&lt;font &gt;&lt;b&gt;Description:&lt;/b&gt;&lt;br /&gt;&lt;/font&gt; ".htmlspecialchars($text)."&lt;br /&gt; &lt;font size=\"3\"&gt;&lt;b&gt;Seeders: &lt;/b&gt;&lt;/font&gt;".$row["seeders"]."&lt;br /&gt; &lt;font size=\"3\"&gt;&lt;b&gt;Leeches: &lt;/b&gt;&lt;/font&gt;".$row["leechers"];
$rss .='
<item><title>'.htmlspecialchars($names).'</title><guid isPermaLink=\'true\'>'.$siteurl.'/details.php?id='.$ids.'</guid><guid isPermaLink=\'true\'>'.$siteurl.'/download.php?id='.$ids.'</guid><pubDate>'.$pubdate.'</pubDate><category>'.$cat3['name'].'</category><link>'.$siteurl.'/details.php?id='.$ids.'</link>
      <description>'.$descrption.'</description><enclosure url="'.$siteurl.'/download.php?id='.$ids.'" length="'.$row["size"].'" type="application/x-bittorrent" />
</item>
	';
      }
$rss .='</channel>
</rss>';

$db->sql_freeresult($res);
$db->sql_freeresult($cat2);
$db->sql_freeresult($sql_own1);

if (!$persistency) $db->sql_close();

echo ($rss);

die();
?>