<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*/

if (!defined('IN_PMBT')) die ("You can't access this file directly");

//Turn the Search Cloud Block ON/OFF

//I took this from admin/files/settings.php, and there's some redundancy with arrays and stuff, as there's only 1 setting as of now. Decided to leave the stuff in for the event that more settings will be added.
define("_admsearch_cloud_blockexplain","Display a Block with a Search Cloud. All terms your users search for are recorded and displayed in a cloud. The more often a term is searched, the larger the font size/weight.");
define("_admsearch_cloud_block","Display Search Cloud");
define("_admcloud","Search Terms");
define("_admcloudintro","This tool allows you to list and remove search terms saved in the database and displayed in the Search Cloud. Terms are ordered by search frequency, and can be searched.");
define("_admcloudsearchbtn","Search");
define("_admcloudterm","Search Term");
define("_admcloudhit","Times Searched");
define("_admcloudid","Term ID");
define("_admcloudtermdel","Term Removed");
define("_admclouddelterm","Remove Term from Database");

$cfgquery = "SELECT search_cloud_block FROM ".$db_prefix."_config;";
$cgfres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
$db->sql_freeresult($cfgres);

function drawRow($param, $type, $options = NULL) {
        global $cfgrow;
        echo "<tr>";
        echo "<td width=\"16\">";
        help(pic("help.gif"),constant("_adm".$param."explain"),constant("_adm".$param));
        echo "</td>\n";
        echo "<td>".constant("_adm".$param)."</td>\n";
        echo "<td align=\"right\">";
        if ($type == "text") {
                echo "<input type=\"text\" name=\"sub_".$param."\" value=\"".$cfgrow[$param]."\" size=\"40\">";
        } elseif ($type == "select") {
                echo "<select name=\"sub_".$param."\">\n";
                foreach ($options as $key=>$val) {
                        echo "<option ";
                        if ($cfgrow[$param] == $key) echo "selected";
                        echo " value=\"".$key."\">".$val."</option>\n";
                }
                echo "</select>";
        } elseif ($type == "checkbox") {
                echo "<input type=\"checkbox\" name=\"sub_".$param."\" value=\"true\" ";
                if ($cfgrow[$param] == "true") echo "checked";
                echo ">";
        } elseif ($type == "textarea") {
                $oFCKeditor = new FCKeditor("sub_".$param) ;
                $oFCKeditor->BasePath = "FCKeditor/";
                $oFCKeditor->Value = $cfgrow[$param];
                $oFCKeditor->Height = 300;
                $oFCKeditor->ToolbarSet = "Admin";
                $oFCKeditor->Create();


        }
        echo "</td>\n";
        echo "</tr>\n";
}

function esc_magic($x) {
        if (!get_magic_quotes_gpc()) return escape($x);
        else return $x;
}

if ($do == "savesettings") {
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();

        //Process Request

        //Then I accurately check each parameter before inserting it in SQL statement
        //Some parameters that must be numeric have to be checked with an if clause because intval() function truncates to max integer
		if (!isset($sub_search_cloud_block) OR $sub_search_cloud_block != "true") $sub_search_cloud_block = "false"; array_push($params,"search_cloud_block"); array_push($values,$sub_search_cloud_block);

        //Now I save the settings
        //but first I test the insertion against SQL errors, or I lose everything in case of error
        $sql = "UPDATE ".$db_prefix."_config SET ".implode(", ",$params)." = ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        #$db->sql_query("TRUNCATE TABLE ".$db_prefix."_config;");
        $db->sql_query($sql);

        //echo "INSERT INTO ".$db_prefix."_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        //Finally, I redirect the user to configuration page
        header("Location: modcp.php?op=searchcloud&saved=1");
        die();
}
echo "<a name=\"cloud\"></a>";
if (isset($saved)) {
        OpenTable2();
        echo "<h3>"._admsaved."</h3>";
        CloseTable2();
}

OpenTable(_admcloud);

echo "<form method=\"POST\" action=\"modcp.php?op=searchcloud&do=savesettings#cloud\">\n";
echo "<table style=\"padding-bottom: 10px;\" width=\"30%\">\n";

drawrow("search_cloud_block","checkbox");

echo "</table>\n\n";
echo "<p><input type=\"submit\" value=\""._admsavebtn."\" /><input type=\"reset\" value=\""._admresetbtn."\" /></p>\n";
echo "</form>\n";

CloseTable();


switch ($op) {
	case "delterm": {
                        #$sql = "SELECT text FROM ".$db_prefix."_search_text WHERE id = '".$id."' LIMIT 1;";
                        #$res = $db->sql_query($sql) or bterror($sql);
                        #list ($owner) = $db->sql_fetchrow($res);
                        #$db->sql_freeresult($res);
                        $sql = "DELETE FROM ".$db_prefix."_search_text WHERE id = '".$id."';";
                                $db->sql_query($sql) or btsqlerror($sql);
                                echo "<meta http-equiv=\"refresh\" content=\"3;url=modcp.php?op=searchcloud#cloud\">";
                                OpenTable2();
				echo "<h3>"._admcloudtermdel."</h3>";
                                CloseTable2();
                        }
                        break;
                }



if (!isset($page) OR $page < 1) $page = 1;
$from = ($page - 1) * 50;


if (!isset($usearch)) $usearch = "";
if(!isset($mod))$mod = false;

OpenTable(_admcloud);
echo "<p>"._admcloudintro."</p>\n";
echo "<p>&nbsp;</p>";

//Search Form
echo "<form action=\"modcp.php#cloud\" method=\"GET\">\n";
echo "<input type=\"hidden\" name=\"op\" value=\"searchcloud\" />";
echo "<p><input type=\"text\" name=\"usearch\" value=\"".$usearch."\" /> <input type=\"submit\" value=\""._admcloudsearchbtn."\" />";
echo "</form>\n";

echo "<p>&nbsp;</p>\n";
echo "<p>&nbsp;</p>\n";

if (!empty($usearch)) {
        $sql = "SELECT id, text, hit FROM ".$db_prefix."_search_text WHERE text LIKE '%".addslashes($usearch)."%' ORDER BY hit DESC;";
        $tot = 1;
        $res = $db->sql_query($sql);
} else {
        $totsql = "SELECT COUNT(id) FROM ".$db_prefix."_search_text;";
        $sql = "SELECT id, text, hit FROM ".$db_prefix."_search_text ORDER BY hit DESC LIMIT ".$from.",50;";

        $totres = $db->sql_query($totsql);
        list ($tot) = $db->sql_fetchrow($totres);
        $db->sql_freeresult($totres);
}

$res = $db->sql_query($sql);
$pages = ceil($tot / 50);
$pageplus = $page + 1;
$pagemin = $page - 1;

$i = 1;

//Terms Table

echo "<table width=\"100%\" border=\"1\" cellpadding=\"3\" cellspacing=\"0\">\n";
echo "<thead>\n<tr><th style=\"border:0;\" align=\"center\" width=\"60%\"><p>"._admcloudterm."</p></th><th style=\"border:0;\" align=\"center\" width=\"15%\"><p>"._admcloudhit."</p></th><th style=\"border:0;\" align=\"center\" width=\"15%\"><p>"._admcloudid."</p></th>";

while ($row = $db->sql_fetchrow($res)){

//Start writing row
        echo "<tr>";
        echo "<td style=\"border-bottom:0; border-left:0;\"><p>".htmlspecialchars($row["text"]);
        echo "</p></td>";
        echo "<td style=\"border-bottom:0; border-left:0; text-align: center;\"><p>";
	echo $row["hit"];
        echo"</p></td>";
	echo "<td style=\"border-bottom:0; border-left:0; text-align: center;\"><p>";
	echo $row["id"];
        echo"</p></td>";
	echo "<td style=\"border-bottom:0; border-left:0; border-right:0; text-align: center;\"><p>";
	echo pic("drop.gif","modcp.php?op=delterm&id=".$row["id"]."#cloud",_admclouddelterm);
        echo"</p></td>";
        echo "</tr>\n";
}

echo "</table>";


$pager = "<a href=\"modcp.php?op=searchcloud\">".(($page == 1) ? "<b>1</b>" : "1")."</a>&nbsp;";

if (($page - 15) > 1) $pager .= "...";

for ($i = max(2,$page - 15); $i < min($pages, $page + 15); $i++) {
        $pager .= "<a href=\"modcp.php?op=searchcloud&page=".$i."\">".(($i == $page) ? "<b>".$i."</b>" : $i)."</a>&nbsp;";
}

if (($page + 15) < $pages) $pager .= "...";
$pager .= "<a href=\"modcp.php?op=searchcloud&page=".$pages."\">".(($page == $pages) ? "<b>".$pages."</b>" : $pages)."</a>";

if ($pages >1) echo "<div align=\"center\">".$pager."</div>";
$db->sql_freeresult($res);
CloseTable();


?>