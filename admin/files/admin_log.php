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
if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't include this file");
if(isset($delall))
{
		if ($confirm != "ok") {
                        OpenTable(_admdellogsal);
                        echo "<form action=\"admin.php\" method=\"POST\">\n";
                        echo "<input type=\"hidden\" name=\"confirm\" value=\"ok\"><input type=\"hidden\" name=\"delall\" value=\"delall\"><input type=\"hidden\" name=\"op\" value=\"log\">";
                        echo "<p align=\"center\">"._admdodleal."</p>";
                        echo "<p>&nbsp;</p>";
                        echo "<p align=\"center\">";
                        if ($gfx_check) {
                                $rnd_code = strtoupper(RandomAlpha(5));
                                echo _btsecuritycode."<br>\n<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\" alt=\"Security Code\"><br>\n<input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\">";
                                echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\"><br>\n";
                        }
                        echo "<input type=\"submit\" value=\""._admdellogsal."\">\n";
                        echo "</p>\n";
                        echo "</form>\n";
                        CloseTable();

		}else{
		$db->sql_query("TRUNCATE `".$db_prefix."_log`;");
        OpenTable2();
        echo "<h3 align=\"center\">"._admallclear."</h3>";
        CloseTable2();
		}
}
if(isset($delmarked))
{
		if ($confirm != "ok") {
                        OpenTable(_admdellogsse);
						$marks = Array();
						foreach ($mark as $key=>$val) {
						$marks[]=$val;
						}
                        echo "<form action=\"admin.php\" method=\"POST\"/>\n";
                        echo "<input type=\"hidden\" name=\"confirm\" value=\"ok\"/>\n";
						echo "<input type=\"hidden\" name=\"del\" value=\"".implode(",",$marks)."\"/>\n";
						echo "<input type=\"hidden\" name=\"op\" value=\"log\"/>\n";
						echo "<input type=\"hidden\" name=\"delmarked\" value=\"delmarked\"/>\n";
                        echo "<p align=\"center\">"._admdodlese."</p>";
                        echo "<p>&nbsp;</p>";
                        echo "<p align=\"center\">";
                        if ($gfx_check) {
                                $rnd_code = strtoupper(RandomAlpha(5));
                                echo _btsecuritycode."<br>\n<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\" alt=\"Security Code\"><br>\n<input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\">";
                                echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\"><br>\n";
                        }
                        echo "<input type=\"submit\" value=\""._admdellogsse."\">\n";
                        echo "</p>\n";
                        echo "</form>\n";
                        CloseTable();

		}else{
                        $sql = "DELETE FROM ".$db_prefix."_log WHERE event IN (".$del.");";
                        $db->sql_query($sql) or btsqlerror($sql);
        OpenTable2();
        echo "<h3 align=\"center\">"._admselcclear."</h3>";
        CloseTable2();
						}
}
$sort_dir	= '';
if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
if(isset($sk))$order = "ORDER BY ".$sk." ";
if(isset($st)AND $st != "0")$sort_days = "WHERE datetime > SUBDATE(SYSDATE(), INTERVAL ".$st." DAY) ";
else
$sort_days = '';
if(isset($sd) AND $sd == 'a')$sort_dir	= ' ASC ';
if(isset($sd) AND $sd == 'd')$sort_dir	= ' DESC ';
//echo $sd;

//TRUNCATE `torrent_log`;
?>
<script language="javascript" type="text/javascript">
function marklist(id, name, state)
{
	var parent = document.getElementById(id);
	if (!parent)
	{
		eval('parent = document.' + id);
	}

	if (!parent)
	{
		return;
	}

	var rb = parent.getElementsByTagName('input');
	
	for (var r = 0; r < rb.length; r++)
	{
		if (rb[r].name.substr(0, name.length) == name)
		{
			rb[r].checked = state;
		}
	}
}
</script>
<?php
		OpenTable(_admlogs);
		$from = ($page - 1) * $torrent_per_page;
		$totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_log ".$sort_days.";";
		$totres = $db->sql_query($totsql);
		list ($tot) = $db->sql_fetchrow($totres);
		$db->sql_freeresult($totres);
		$pages = ceil($tot / $torrent_per_page);
		if($page < $pages) {
        $next = "<b><a href=\"admin.php?op=log&page=".($page + 1);
        $next .= "\">&gt;&gt;&gt;&gt;</a></b>";
} else {
        $next = "&gt;&gt;&gt;&gt;";
}
if ($page > 1) {
        $prev = "<b><a href=\"admin.php?op=log&page=".($page - 1);
        $prev .= "\">&lt;&lt;&lt;&lt;</a></b>";
} else {
        $prev = "&lt;&lt;&lt;&lt;";
}
$pager = "<a href=\"admin.php?op=log\"";
$pager .= "\">".(($page == 1) ? "<b>1</b>" : "1")."</a>&nbsp;";
if (($p1 - 15) > 1) $pager .= "...";
for ($i = max(2,$p1 - 15); $i < min($pages, $page + 15); $i++) {
        $pager .= "<a href=\"admin.php?op=log&page=".$i;
        $pager .= "\">".(($i == $p1) ? "<b>".$i."</b>" : $i)."</a>&nbsp;";
}
if (($page + 15) < $pages) $pager .= "...";
$pager .= "<a href=\"admin.php?op=log&page=".$pages;
$pager .= "\">".(($page == $pages) ? "<b>".$pages."</b>" : $pages)."</a>";


		$sql = "SELECT event, action, results, ip, datetime, userid FROM `".$db_prefix."_log` ".$sort_days.$order.$sort_dir."LIMIT ".$from.",".$torrent_per_page."; "; 
		//echo $sql;
		$res = $db->sql_query($sql);
		//$errors = $db->sql_fetchrow($res);
		echo"<form id=\"list\" method=\"post\" action=\"./admin.php\">";
        echo "<input type=\"hidden\" name=\"op\" value=\"log\" />\n";
        echo "<table width=\"720px\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">\n";
        echo "<thead>\n";
        echo "<tr>";
    	echo "<td border=\"1\"><p><b>"._btusername."</b></p></td>";
	    echo "<td border=\"1\"><p><b>"._btactiontime."</b></p></td>";
	    echo "<td border=\"1\"><p><b>"._btuserip."</b></p></td>";
	    echo "<td border=\"1\"><p><b>"._btactions."</b></p></td>";
	    echo "<td border=\"1\"><p><b>"._btactionmark."</b></p></td>";
        echo"</tr>\n";
        echo "</thead>\n";
        echo"<tbody>\n";
        while ($errors = $db->sql_fetchrow($res)) {
		if($errors['userid'] == "0")
		{
		$by2['username'] = "Unknown";
		}else{
		$sqler = ("SELECT username FROM ".$db_prefix."_users WHERE id='".$errors['userid']."'");
        $by = $db->sql_query($sqler);
        $by2 = $db->sql_fetchrow($by);
		}
	    echo "<tr>\n";
		echo "<td width=\"15%\">".$by2['username']."</td>\n";
		echo "<td width=\"30%\">".$errors['datetime']."</td>\n";
		echo "<td width=\"25%\">".long2ip($errors["ip"])."</td>\n";
		echo "<td><p><font color=\"red\">".$errors['action']."</font></p><br /><p>".$errors['results']."</p></td>\n";
		echo "<td style=\"text-align: center;\"><input class=\"radio\" name=\"mark[]\" value=\"".$errors['event']."\" type=\"checkbox\"></td>\n";
    	echo "</tr>\n";
        } 
		$db->sql_freeresult($res);
        echo "</tbody>\n";
        echo "</table>\n";
		//selected="selected"
		echo'<fieldset class="display-options">
	'._admdisxpl.'
	<select name="st">
	<option '.(($st == '0') ? 'selected="selected" ' : '').'value="0">'._admlles0.'</option>
	<option '.(($st == '1') ? 'selected="selected" ' : '').'value="1">'._admlles1.'</option>
	<option '.(($st == '7') ? 'selected="selected" ' : '').'value="7">'._admlles2.'</option>
	<option '.(($st == '14') ? 'selected="selected" ' : '').'value="14">'._admlles3.'</option>
	<option '.(($st == '30') ? 'selected="selected" ' : '').'value="30">'._admlles4.'</option>
	<option '.(($st == '90') ? 'selected="selected" ' : '').'value="90">'._admlles5.'</option>
	<option '.(($st == '180') ? 'selected="selected" ' : '').'value="180">'._admlles6.'</option>
	<option '.(($st == '365') ? 'selected="selected" ' : '').'value="365">'._admlles7.'</option>
	</select>
	&nbsp;Sort by: 
	<select name="sk">
	<option '.(($sk == 'userid') ? 'selected="selected" ' : '').'value="userid">'._btusername.'</option>
	<option '.(($sk == 'datetime') ? 'selected="selected" ' : '').'value="datetime">'._btactiontime.'</option>
	<option '.(($sk == 'ip') ? 'selected="selected" ' : '').'value="ip">'._btuserip.'</option>
	<option value="action">'._btactionmark.'</option>
	</select> 
	<select name="sd">
	<option '.(($sd == 'a') ? 'selected="selected" ' : '').'value="a">'._admlasc.'</option>
	<option '.(($sd == 'd') ? 'selected="selected" ' : '').'value="d">'._admldsc.'</option>
	</select>	
	<input class="button" type="submit" value="'._btgo.'" name="sort" />

	</fieldset>
<hr />';
        echo "<table border=\"0\" width=\"100%\"><tr><td align=\"left\"><p>".$prev."</p></td><td align=\"center\"><p>".(($pages > 1) ? $pager : "")."</p></td><td align=\"right\"><p>".$next."</p></td></tr></table>";

		echo"<fieldset class=\"quick\"><input class=\"button\" name=\"delall\" value=\""._admdellogsal."\" type=\"submit\">&nbsp;
		<input class=\"button\" name=\"delmarked\" value=\""._admdellogsse."\" type=\"submit\"><br>
		<p class=\"small\"><a href=\"#\" onclick=\"marklist('list', 'mark', true); return false;\">"._admlogmall."</a>&bull;<a href=\"#\" onclick=\"marklist('list', 'mark', false); return false;\">"._admlogumall."</a></p></fieldset>";
		echo"</forum>";

		CloseTable();
?>