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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
include ("header.php");
include 'include/textarea.php';
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
/////////////////////Test if offers is enabled////////////////////////////
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_requist_config");
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];
if ($arr_config["enable"]!='true')bterror("Requist system is closed, come back later...","Sorry");
$access_level = $arr_config["class_allowed"];
switch ($access_level) {
        case "user": {
                if (!$user->user) loginrequired("user");
                break;
        }
        case "premium": {
                if (!$user->premium) loginrequired("premium");
                break;
        }
        case "moderator": {
                if (!$user->moderator) loginrequired("moderator");
                break;
        }
        case "admin": {
                if (!$user->admin) loginrequired("admin");
                break;
        }
}
//////////////////////////////////////////////////////////////////////////
function tr($x,$y,$noesc=0) {
    if ($noesc)
        $a = $y;
    else {
        $a = htmlspecialchars($y);
        $a = str_replace("\n", "<br />\n", $a);
    }
    print("<tr><td class=\"heading\" valign=\"top\" align=\"right\">$x</td><td valign=\"top\" align=left>$a</td></tr>\n");
}
function stderr($heading = "", $text, $sort = "") {
 OpenTable("$sort: $heading"); 
  begin_frame("<font color=red>$sort: $heading</font>", center);
  echo $text;
  end_frame();
  CloseTable();
  die;
}



OpenTable(pic("icon_mini_search.gif")._btsearch);
global $db, $db_prefix;

print("<br>\n");

$where = "WHERE userid = ".getuserid($btuser)."";

$res2 = $db->sql_query("SELECT * FROM ".$db_prefix."_requests $where") or die("arghh");
$num2 = $db->sql_numrows($res2);

echo "<form method=\"get\" action=\"search.php\">";
echo "<P align=\"center\">"._btsearchname." <input type=\"text\" name=\"search\" size=\"25\"> ";
echo _btin;
echo " <select name=\"cat\">";
echo "<option value=\"0\">"._btalltypes."</option>";
foreach (catlist() as $category) {
        echo "<option value=\"".$category["id"]."\">".$category["name"]."</option>";
}
echo "</select>";
echo "<input type=\"checkbox\" name=\"incldead\" value=\"true\" />"._btitm;
echo "<br>";
echo _btresfor." <select name=\"orderby\">".
    "<option value=0 selected>"._btinsdate."</option>".
    "<option value=1 >"._btname."</option>".
    "<option value=2 >"._btdim."</option>".
    "<option value=3 >"._btnfile."</option>".
    "<option value=4 >"._btvote."</option>".
    "<option value=5 >"._btdownloaded."</option>".
    "<option value=6 >"._btseeders."</option>".
    "<option value=7 >"._btleechers."</option>".
    "<option value=8 >"._bttotsorc."</option>";
echo "</select>";
echo "<select name=\"ordertype\">".
    "<option value=\"DESC\" selected>"._btdesc."</option>".
    "<option value=\"ASC\" >"._btord."</option>".
    "</select>";
echo "<input type=\"submit\" value=\""._btgo."\" />";
echo "</p></form>";

CloseTable();
OpenTable(" MAKE_REQUEST ");
?>
<div align=Center>
<form action="takerequest.php" name="Form" method="post">
<br>
<br>
<table border="1" cellspacing="0" cellpadding="10">
<?php
tr(""._btname."", "<input type=\"text\" name=\"requesttitle\" size=\"80\" />\n", 1);
echo "<tr><td><p>"._btdescription;
                if (!$allow_html) echo "<br>"._btnohtml."</p></td><td><p><textarea name=\"msg\" rows=\"20\" cols=\"90\"></textarea></p>\n</td></tr>\n";
                else {
                        echo "</td><td>";
echo $textarea->quick_bbcode('Form','msg');
echo $textarea->input('msg');
echo "</table></td></tr>\n";
						}
echo _btin;
echo " <select name=\"cat\">";
echo "<option value=\"0\">"._btalltypes."</option>";
foreach (catlist() as $category) {
        echo "<option value=\"".$category["id"]."\">".$category["name"]."</option>";
}
?>
<tr><td align="center" colspan="2"><input type="submit" class=btn value=<?php echo _btfsend ?> /></td></tr>
</table>
</form>
<br/>
<a href=offers.php><b>See All Offers</b></a>
<?php
CloseTable();

include ("footer.php")
?>