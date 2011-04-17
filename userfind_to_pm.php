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

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("include/config.php");
require_once("language/english.php");
if (!$user->user) loginrequired("user");

if (isset($_GET['action']) && $_GET['action'])
            $action=$_GET['action'];
else $action = '';;

if ($action!="find")
   {
?>

<form action="userfind_to_pm.php?action=find" name="users" method="post">
<div vlign="bottom">
  <table cellspacing=0 cellpadding=0 border=0 align=left width=100% bgcolor="#dddddd">
  <tr>
     <td class=col1 align=center><? echo "<b>"._btusername."</b>";?>:</td>
     <td class=col1 align=center><input type="text" name="user" size="30" /></td>
     <td class=col2 align=center><input type="submit" name="confirm" value=<?=_btsearch?> /></td>
  </tr>
  </table>
</div>
</form>
<?
}
else
{
  $res=mysql_query("SELECT username FROM torrent_users WHERE username LIKE '%".mysql_escape_string($_POST["user"])."%' ORDER BY username");
  if (!$res or mysql_num_rows($res)==0)
      {
?>  
<table cellspacing=0 cellpadding=0 border=0 align=left width=100% bgcolor="#dddddd">
<tr><td><p align=center><?=_buserfind_found?> <font color=red><b>0</b></font><?=_buserfind_tryagain?><br />
<a href=userfind_to_pm.php><b><?=_buserfind_retry?></b></a></p></td></tr></table>
<?	}
  else {
	$subres = mysql_query("SELECT COUNT(*) FROM torrent_users WHERE username LIKE '%".mysql_escape_string($_POST["user"])."%'");
	$subrow = mysql_fetch_array($subres);
	$count = $subrow[0];

if ($count == "1"){?>
<p align=center><?=_buserfind_found?> <b>1</b><?=_buserfind_member?></p>
<?php
}elseif ($count >= "500")
{
?>
<p align=center><?=_buserfind_found?> <b><?=$count?></b> <?=_buserfind_specific?></p>
<?}else{?>
<p align=center><?=_buserfind_found?> <b><?=$count?></b> <?=_buserfind_recip?></p>
<?php
}
?>
<div align="center">
  <form name=result>
<table bgcolor="dddddd" align=left width=100% cellspacing=0 cellpadding=0 border=0>
  <tr>
     <td align=center>
<?php
print("<b>"._buserfind_Pseudo."</b>");
?>
:</td>
<?php
     print("<td align=center><select name=\"name\" size=\"1\">");
     while($result=mysql_fetch_array($res))
     print("<option name=uname value=" . $result["username"]. " />" . $result["username"] . "</option>");
     print("</select></td>");
?>
<script language=javascript>

function addusertopm(){
    window.opener.document.forms['formdata'].elements['sendto'].value = document.forms['result'].elements['name'].options[document.forms['result'].elements['name'].options.selectedIndex].value.document.forms['formdata'].elements['sendto'];
    window.close();
}
</script>
<?
     print("<td><input type=\"button\" name=\"confirm\" onclick=\"javascript:addusertopm()\" value="._buserfind_recipt."></td>");
?>
  </tr>
</table>
</form>
</div>
<?
   }
}
?>