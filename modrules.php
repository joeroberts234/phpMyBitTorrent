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
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------               Hacked For phpMyBitTorrent                     --------*
*--------                       By Joeroberts                         ---------*
*--------              http://www.moviegamesmore.net                   --------*
*------------------------------------------------------------------------------*
*/
include("header.php");
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
include'include/textarea.php';
//DELETE RULE SECTION PAGE/FORM
$id = $_GET["id"];
if ($_GET["act"] == "delete")
{
$sql = "DELETE FROM ".$db_prefix."_rules WHERE id = $id ";
if (!$db->sql_query($sql)) btsqlerror($sql);
				header("Refresh: 0; url=modrules.php");
}				

//ADD NEW RULE SECTION PAGE/FORM
elseif ($_GET["act"] == "newsect")
{
OpenTable(_btrulesaddsect);

print("<form name=\"formdata\" method=\"post\" action=\"modrules.php?act=addsect\">");
print("<table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
print("<tr><td>"._bttitle.":</td><td><input style=\"width: 400px;\" type=\"text\" name=\"title\"/></td></tr>\n");
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
echo "<tr><td><p>"._btdescription."</p>";
echo "</td><td>";
echo $textarea->quick_bbcode('formdata','text');
echo $textarea->input('text','center','2','10','80',$res['text']);
echo "</table></td></tr>\n";
		echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";		
                echo "<tr><td><p>"._btmodrulespublic."</p></td><td>";
                echo "<select name=\"public\">\n";
                echo "<option value=\"yes\">"._btmodrulesyes."</option>\n";
                echo "<option value=\"no\">"._btmodrulesno."</option>\n";
                echo "</select>\n";
                echo "</td></tr>\n";
                echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
                echo "<tr><td><p>"._btlevel."</p></td><td><p>";
                echo "<select name=\"level\">\n";
                echo "<option value=\"user\">"._btclassuser."</option>\n";
                echo "<option value=\"premium\">"._btclasspremium."</option>\n";
                echo "<option value=\"moderator\" >"._btclassmoderator."</option>\n";
				echo "<option value=\"admin\" >"._btclassadmin."</option>\n";
                echo "</select></p>\n";
                echo "</td></tr>\n";
print("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\""._btsend."\" style=\"width: 60px;\"></td></tr>\n");
print("</table></form>");
CloseTable();
}
//ADD NEW RULE SECTION TO DATABASE
elseif ($_GET["act"]=="addsect"){
$msg = $_POST['text'];
$title = $_POST["title"];
$public = $_POST["public"];
$level = $_POST["level"];
if (!get_magic_quotes_gpc()) $msg = escape($msg);
                if ($allow_html) {
                        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $text)) //HTML contains Javascript EVENTS. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $page)) //HTML contains Javascript or VBScript calls. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                }
                parse_html($msg);
$sql = "INSERT INTO ".$db_prefix."_rules ( `id` , `title` , `text` , `public` , `level` )VALUES (NULL , '$title', '".$msg."', '$public', '$level')";
if (!$db->sql_query($sql)) btsqlerror($sql);
header("Refresh: 0; url=modrules.php");
}
//EDIT RULE
elseif ($_GET["act"] == "edit"){
$id = $_POST["id"];
$sql_rule = "select * from ".$db_prefix."_rules where id=$id;";
$res_rule = $db->sql_query($sql_rule);
$res = $db->sql_fetchrow($res_rule);
$db->sql_freeresult($res_rule);


OpenTable(_btrulesedit);
$body =$res["text"];
print("<form name=\"formdata\" method=\"post\" action=\"modrules.php?act=edited\">");
print("<table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
print("<tr><td>"._bttitle.":</td><td><input style=\"width: 400px;\" type=\"text\" name=\"title\" value=\"$res[title]\" /></td></tr>\n");
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";;
echo "<tr><td><p>"._btdescription;
                        echo "</td><td>";
echo $textarea->quick_bbcode('formdata','text');
echo $textarea->input('text','center','2','10','80',$body);
echo "</table></td></tr>\n";
		echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";		
                echo "<tr><td><p>"._btmodrulespublic."</p></td><td><p>";
                echo "<select name=\"public\">\n";
                echo "<option value=\"yes\""; if($res["public"] == "yes") echo "selected"; echo ">"._btmodrulesyes."</option>\n";
                echo "<option value=\"no\""; if($res["public"] == "no") echo "selected"; echo ">"._btmodrulesno."</option>\n";
                echo "</select></p>\n";
                echo "</td></tr>\n";
                echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
                echo "<tr><td><p>"._btlevel."</p></td><td><p>";
                echo "<select name=\"level\">\n";
                echo "<option value=\"user\" "; if($res["level"] == "user") echo "selected"; echo ">"._btclassuser."</option>\n";
                echo "<option value=\"premium\" "; if($res["level"] == "premium") echo "selected"; echo ">"._btclasspremium."</option>\n";
                echo "<option value=\"moderator\" "; if($res["level"] == "moderator") echo "selected"; echo " >"._btclassmoderator."</option>\n";
				echo "<option value=\"admin\" "; if($res["level"] == "admin") echo "selected"; echo " >"._btclassadmin."</option>\n";
                echo "</select></p>\n";
                echo "</td></tr>\n";
print("<tr><td colspan=\"2\" align=\"center\"><input type=hidden value=". $id . " name=id><input type=\"submit\" value=\"Save\" style=\"width: 60px;\"></td></tr>\n");
print("</table></form>");
CloseTable();
}
//DO EDIT RULE, UPDATE DB
elseif ($_GET["act"]=="edited"){
$msg = request_var('text', '');
$id			= request_var('id', '');
$title = request_var('title', '');
$public = request_var('public', '');
$level = request_var('level', '');
                if ($allow_html) {
                        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $msg)) //HTML contains Javascript EVENTS. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $page)) //HTML contains Javascript or VBScript calls. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                }
                parse_html($msg);
$sql = "update ".$db_prefix."_rules set title='$title', text = '".$db->sql_escape(stripslashes($msg))."', public='$public', level='$level' where id='$id'";
if (!$db->sql_query($sql)) btsqlerror($sql);
header("Refresh: 0; url=modrules.php");
}
else{
// STANDARD MENU OR HOMEPAGE ETC
$sql_rule = "select * from ".$db_prefix."_rules order by level;";
$res = $db->sql_query($sql_rule);
$db->sql_freeresult($sql_rule);
OpenTable("Site Rules Editor");
print("<br><table width=100% border=0 cellspacing=0 cellpadding=10>");
print("<tr><td align=center><a href=modrules.php?act=newsect>"._btmodrulesadd."</a></td></tr></table>\n");
CloseTable();

while ($arr = $db->sql_fetchrow($res))
{
$rule = format_comment($arr["text"]);
parse_smiles($rule);

	OpenTable($arr[title]);
	print("<table width=95% border=0 cellspacing=0 cellpadding=0>");
	print("<tr><td width=100%>");
	echo "<p>".str_replace("\n","<br>",$rule)."</p>";
	print("</td></tr><tr><td><form method=post action=modrules.php?act=edit&id=><input type=hidden value=$arr[id] name=id><input type=submit value='Edit'></form></td></tr>");
	print("<tr><td><form name=delete-rule method=post action=modrules.php?act=delete&id=$arr[id]><input type=hidden name=delete value=$arr[id]> <input class=btn type=submit value=DELETE ></form></td></tr></table>\n");
	
	CloseTable();
}

echo "<br><br>";


echo "<br><br>";


}
include("footer.php");
?>