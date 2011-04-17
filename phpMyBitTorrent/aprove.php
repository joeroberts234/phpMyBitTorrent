<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
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
include("header.php");
if (!checkaccess("modforum"))
{
OpenErrTable(_btaccdenied);
echo _btnoautherized_noedit;
CloseErrTable();
die();
}
?>
<script type="text/javascript" language="JavaScript">
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
if(!isset($action) OR $action == "")
{
        echo "<form method=\"POST\" id=\"viewfolder\" name=\"torrents\" action=\"aprove.php\">\n";
        echo "<input type=\"hidden\" name=\"action\" value=\"aprove\" />\n";
$sql = ("SELECT username, email, id, invited_by FROM ".$db_prefix."_users WHERE active = 0 AND ban ='0'") ;
		$res1 = $db->sql_query($sql) or btsqlerror($sql);
echo "<table  border=\"0\" cellpadding=\"3\" width=\"100%\">";
		while($new =$db->sql_fetchrow($res1))
		{
		if(!$row['invited_by'] == "")$inviter = "<br>Invited By: ".$row['invited_by'];
		else
		$inviter = "";
		echo "<tr><td>";
		echo "<p>User Name: ".$new['username']."<br> User E_mail: ".$new['email']."  <input type=\"checkbox\" name=\"torrent_id[]\" value=\"".$new["id"]."\" />".$inviter;
		echo "</td></tr>";
		}
echo "</table>\n";
}
include("footer.php");
?>