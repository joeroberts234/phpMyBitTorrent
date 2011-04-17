<?php
/*
*------------------------------phpMyBitTorrent V 2.0.4-------------------------*
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
*------              ©2009 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");
include'include/textarea.php';
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
if (isset($torrent_id)) $id = $torrent_id;
if (!$user->user) loginrequired("user");
if (is_array($id))
{
foreach($id as $item)
{
$sql = "SELECT owner,name FROM ".$db_prefix."_torrents WHERE id = '".$item."';";
$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) < 1) bterror(_bttorrentnoexist,_btedittorrent);
list ($owner, $tname) = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
}
}else{
$id = intval($id);
$sql = "SELECT owner,name FROM ".$db_prefix."_torrents WHERE id = '".$id."';";
$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) < 1) bterror(_bttorrentnoexist,_btedittorrent);
list ($owner, $tname) = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
}
if (!isset($op)) $op="edit";
if (!isset($banned)) $banned= "no";
if ($op == "edit" AND $owner == $user->id AND !checkaccess("edit_own_torrents"))
{
OpenErrTable(_btaccdenied);
echo _btnoautherized_noedit;
CloseErrTable();
die();
} 
if ($op == "delete" AND $owner == $user->id AND !checkaccess("delete_own_torrents"))
{
OpenErrTable(_btaccdenied);
echo _btnoautherized_nodelete;
CloseErrTable();
die();
} 
if ($op == "delete" AND $owner != $user->id AND !checkaccess("delete_others_torrents"))
{
OpenErrTable(_btaccdenied);
echo _btnoautherized_nodelete;
CloseErrTable();
die();
} 
if ($op == "edit" AND $owner != $user->id AND !checkaccess("can_edit_others_torrents"))
{
OpenErrTable(_btaccdenied);
echo _btnoautherized_noedit;
CloseErrTable();
die();
} 
switch($op) {
        case "admin_delete":{
		if (!$user->moderator) loginrequired("admin");

                        OpenTable(_btdelete);
                        foreach ($id as $item) {
                        $sql = Array();
                        $sql[] = "DELETE FROM ".$db_prefix."_snatched WHERE torrent = '".$item."' ;";
                        $sql[] = "DELETE FROM ".$db_prefix."_torrents WHERE id = '".$item."' LIMIT 1;";
                        $sql[] = "DELETE FROM ".$db_prefix."_files WHERE torrent = '".$item."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_peers WHERE torrent = '".$item."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_file WHERE torrent = '".$item."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_backup WHERE torrent = '".$item."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_comments WHERE torrent = '".$item."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_comments_notify WHERE torrent = '".$item."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_seeder_notify WHERE torrent = '".$item."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_ratings WHERE torrent = '".$item."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_download_completed WHERE torrent = '".$item."';";

                        //Are there still Torrent associated to that tracker?
                        $tracker_sql = "SELECT tracker FROM ".$db_prefix."_torrents WHERE id = '".$item."';";
                        $tracker_res = $db->sql_query($tracker_sql);
                        list ($tracker) = $db->sql_fetchrow($tracker_res);
                        if ($tracker != "" AND $db->sql_numrows($db->sql_query("SELECT id FROM ".$db_prefix."_torrents WHERE tracker = '".$tracker."';")) <= 1) $sql[] = "DELETE FROM ".$db_prefix."_trackers WHERE url = '".$tracker."';";
                        $db->sql_freeresult($tracker_res);


                        foreach ($sql as $query) {
                                $db->sql_query($query) or btsqlerror($query);
                        }

                        if (file_exists("torrent/".$item.".torrent")) @unlink("torrent/".$item.".torrent");
                        if (file_exists("torrent/".$item.".nfo")) @unlink("torrent/".$item.".nfo");
                       
                        echo "<p>"._btdeleted." #".$item."</p>";
                        
                        }
						echo "<meta http-equiv=\"refresh\" content=\"3;url=admin.php?op=torrent\">";
                        CloseTable();
                break;
		
		}
        case "takeedit": {
		//die($evidence);
                $errmsg = Array();
                $sql = "SELECT info_hash, owner FROM ".$db_prefix."_torrents WHERE id = '".$id."';";
                $res = $db->sql_query($sql);
                list ($info_hash, $original_owner) = $db->sql_fetchrow($res);
                $infohash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($torrent["info_hash"],20));
                $db->sql_freeresult($res);

                //if ($exeem != "" AND !preg_match("^exeem://[\\d]{1,2}/".$infohash_hex."/si", $exeem)) $errmsg[] = _btinvalidexeem;

                $category = intval($torrent_category);
                if ($category < 1) $errmsg[] = _btnoselected;

                $nf = $_FILES["nfox"];
                $nfname = unesc($nf["name"]);
                if ($nfname != "") {
                        if (!is_filename($nfname)) $errmsg[] = _btinvalidnfofname;
                        if (!preg_match('/^(.+)\.nfo$/si', $nfname)) $errmsg[] = _btfnamenonfo;
                        if (!is_uploaded_file($nf["tmp_name"])) $errmsg[] = _bterrnonfoupload;
                        if ($nf["size"] <= 0) $errmsg[] = _btemptyfile;
                }
                if (count($errmsg) > 0) bterror($errmsg,_btedit);


                $nfopath = $torrent_dir."/".$id.".nfo";

                if (!empty($nfname)) {
                        @unlink($nfopath);
                        move_uploaded_file($nf["tmp_name"],$nfopath);
                }

                $cats = catlist();
                $in_cat = false;
                while ($cat = each($cats) AND !$in_cat) {
                        if ($category == $cat[1]["id"]) $in_cat = true;
                }
                if (!$in_cat) $errmsg[] = _btillegalcat;

                if (!get_magic_quotes_gpc()) $descr = escape($descr);
                if ($allow_html) {
                        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $descr)) //HTML contains Javascript EVENTS. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $page)) //HTML contains Javascript or VBScript calls. Must refuse
                                bterror(_btinvalidhtml,_btuploaderror);
                }
                parse_html($descr);
				if($evidence == "") $evidence = 0;
				else $evidence = $evidence;
                if ($password == "") $password = "NULL";
                else $password = htmlspecialchars($password);
                if (!get_magic_quotes_gpc()) $namex = escape($namex);
                $ownertype = intval($ownertype);
                if ($ownertype == 2) {
                        $owner = 0;
                        $sql = "DELETE FROM ".$db_prefix."_privacy_global WHERE torrent = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        $sql = "DELETE FROM ".$db_prefix."_privacy_file WHERE torrent = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        $sql = "DELETE FROM ".$db_prefix."_privacy_backup WHERE torrent = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);

                }
                else $owner = $original_owner;

                if (count($errmsg) > 0) bterror($errmsg,_bteditthistorrent);

               $sql = "UPDATE ".$db_prefix."_torrents SET name = '".$namex."', exeem = '".$exeem."', descr = '".$descr."', category = '".$torrent_category."', ownertype = '".$ownertype."', owner = '".$owner."', password = ".$password.", banned = '".$banned."', nuked = '".$nuked."', ratiobuild = '".$build."', nukereason='".$nukereason."', evidence = '".$evidence."', imdb = '".$imdblink."' WHERE id = '".$id."';";

                $db->sql_query($sql) or btsqlerror($sql);
                echo "<meta http-equiv=\"refresh\" content=\"3;url=details.php?id=".$id."\">";
                OpenTable(_bteditthistorrent);
                echo "<p>"._btsuccessfullyedited."</p>";
                CloseTable();
                break;
        }
        case "edit": {
                $sql = "SELECT * FROM ".$db_prefix."_torrents WHERE id = '".$id."';";
                $res = $db->sql_query($sql);
                $row = $db->sql_fetchrow($res);
                $db->sql_freeresult($res);
				$tname = $row["name"];
				$tname =str_replace('"', "'", $tname); 
                OpenTable(_bteditthistorrent);
                echo "<form name=\"formdata\" action=\"edit.php\" method=\"post\" enctype=\"multipart/form-data\">\n\n";
                echo "<input type=\"hidden\" name=\"op\" value=\"takeedit\" />";
                echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\" />";
                echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
                echo "<tr><td><p>"._btupnfo."</p></td><td><p><input type=\"file\" name=\"nfox\" size=\"60\" /></p>\n</td></tr>\n";
                echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
                echo "<tr><td><p>"._bttorrentname."<p></td><td><p><input type=\"text\" name=\"namex\" value=\"".$tname."\" size=\"80\"></p>\n</td></tr>\n";
                echo "<tr><td><p>IMDB Link<p></td><td><p><input type=\"text\" name=\"imdblink\" value=\"".$row['imdb']."\" size=\"80\"></p>\n</td></tr>\n";
                //echo "<tr><td><p>"._btexeemlink."</p></p><td><p><input type=\"text\" name=\"exeem\" value=\"".$row["exeem"]."\" size=\"80\"><br />"._btexeemlinkexplain."</p></td></tr>\n";

		//Ban & Unban
		if ($user->moderator){
		echo "<tr><td><p>"._btbanned."</p></td><td><p><input type=\"radio\" name=\"banned\"" . ($row["banned"] == "yes" ? " checked" : "") . " value=\"yes\">Yes<input type=\"radio\" name=\"banned\"" . ($row["banned"] == "no" ? " checked" : "") . " value=\"no\">No</p>\n</td></tr>\n";
		}
                echo "<tr><td><hr></td><td></td></tr>";
if ($user->premium){
                echo "<tr><td><p>Ratio Builder<p></td><td><p><input type=radio name=build" . ($row["ratiobuild"] == "yes" ? " checked" : "") . " value=yes>Yes<input type=radio name=build" . ($row["ratiobuild"] == "no" ? " checked" : "") . " value=no>No</p>\n</td></tr>\n";
                echo "<tr><td><hr></td><td></td></tr>";
                echo "<tr><td><p>Nuked<p></td><td><p><input type=radio name=nuked" . ($row["nuked"] == "yes" ? " checked" : "") . " value=yes>Yes<input type=radio name=nuked" . ($row["nuked"] == "no" ? " checked" : "") . " value=no>No<input type=radio name=nuked" . ($row["nuked"] == "unnuked" ? " checked" : "") . " value=unnuked>Unnuked</p>\n</td></tr>\n";
                echo "<tr><td><p>Nuke Reason</p></p><td><p><input type=\"text\" name=\"nukereason\" value=\"" . htmlspecialchars($row["nukereason"]) . "\" size=\"80\"></p></td></tr>\n";        
                echo "<tr><td><hr></td><td></td></tr>";
}

                echo "<tr><td><p>"._btdescription;
                        echo "</p></td><td>";
echo $textarea->quick_bbcode('formdata','descr');
echo $textarea->input('descr', 'center', "2", "10", "80",$row["descr"]);
echo "</table></td></tr>\n";

                $s = "<select name=\"torrent_category\">\n";
                $cats = catlist();
                foreach ($cats as $catrow) {
                        $s .= "<option value=\"".$catrow["id"]."\" ";
                        if ($catrow["id"] == $row["category"]) $s .= "selected";
                        $s .= ">" . htmlspecialchars($catrow["name"]) . "</option>\n";
                }
                $s .= "</select>\n";
                echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
                echo "<tr><td><p>"._bttype."</p></td><td><p>". $s ."</p></td></tr>\n";
                #Evidence. Moderators Only
                if ($user->moderator) {
                echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
                echo "<tr><td><p>"._btupevidence."</p></td><td><p><input type=\"checkbox\" "; if($row["evidence"] == 1) echo "checked "; echo "name=\"evidence\" value=\"1\" /> "._btupevidencinfo."</p>\n</td></tr>\n";
                }
                echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
                echo "<tr><td><p>"._btowner."</p></td><td><p>";
                echo "<select name=\"ownertype\">\n";
                echo "<option value=\"0\" "; if($row["ownertype"] == 0) echo "selected"; echo ">"._btowner1."</option>\n";
                echo "<option value=\"1\" "; if($row["ownertype"] == 1) echo "selected"; echo ">"._btowner2."</option>\n";
                echo "<option value=\"2\" >"._btowner3."</option>\n";
                echo "</select> "._btownerinfo."</p>\n";
                echo "</td></tr>\n";
                echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
                if ($torrent["tracker"] == "") {
                        echo "<tr><td><p>"._btpassword."</p></td><td><p><input type=\"text\" name=\"password\" value=\"".$row["password"]."\" /><br />"._bttorrentpasswordexplain."</p>\n</td>\n</tr>\n";
                        echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
                }
                echo "</table><hr /><input type=\"submit\" value=\""._btsend."\" /><input type=\"reset\" value=\""._btreset."\" /></form>\n";
                CloseTable();

                break;
        }

	case "ban": {
		if (!$user->moderator) loginrequired("admin");
		if ($confirm != "ok") {
                        OpenTable(_btban);
                        echo "<form action=\"edit.php\" method=\"POST\">\n";
                        echo "<input type=\"hidden\" name=\"confirm\" value=\"ok\"><input type=\"hidden\" name=\"op\" value=\"ban\"><input type=\"hidden\" name=\"id\" value=\"".$id."\">";
                        echo "<p align=\"center\">".str_replace("**name**",$tname,_btareyousure_ban)."</p>";
						echo"<p align=\"center\">Reason: <input type=\"text\" name=\"reason\" value=\"" . htmlspecialchars($row["nukereason"]) . "\" size=\"80\"></p>";
                        echo "<p>&nbsp;</p>";
                        echo "<p align=\"center\">";
                        if ($gfx_check) {
                                $rnd_code = strtoupper(RandomAlpha(5));
                                echo _btsecuritycode."<br>\n<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\" alt=\"Security Code\"><br>\n<input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\">";
                                echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\"><br>\n";
                        }
                        echo "<input type=\"submit\" value=\""._btban."\">\n";
                        echo "</p>\n";
                        echo "</form>\n";
                        CloseTable();

		} else {
               		if (!is_numeric($id)) bterror(_btwronginput,_btmytorrents);
                	$sql = "UPDATE ".$db_prefix."_torrents SET banned = 'yes' WHERE id = '".$id."';";
               		$db->sql_query($sql) or btsqlerror($sql);
               		OpenTable(_btban);
                	echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
                	echo "<p>"._btbanned."</p>";
                	CloseTable();
		}
                break;        
	}

        case "delete": {
                if ($confirm != "ok") {
                        OpenTable(_btdelete);
                        echo "<form action=\"edit.php\" method=\"POST\">\n";
                        echo "<input type=\"hidden\" name=\"confirm\" value=\"ok\"><input type=\"hidden\" name=\"op\" value=\"delete\"><input type=\"hidden\" name=\"tname\" value=\"".$tname."\"><input type=\"hidden\" name=\"id\" value=\"".$id."\">";
                        echo "<p align=\"center\">".str_replace("**name**",$tname,_btareyousure)."</p>";
                        echo "<p>&nbsp;</p>";
                        echo "<p align=\"center\">";
                        if ($gfx_check) {
                                $rnd_code = strtoupper(RandomAlpha(5));
                                echo _btsecuritycode."<br>\n<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\" alt=\"Security Code\"><br>\n<input type=\"text\" name=\"gfxcode\" size=\"10\" maxlength=\"6\">";
                                echo "<input type=\"hidden\" name=\"gfxcheck\" value=\"".md5($rnd_code)."\"><br>\n";
                        }
                        echo "<input type=\"submit\" value=\""._btdelete."\">\n";
                        echo "</p>\n";
                        echo "</form>\n";
                        CloseTable();
                } else {
                        $sql = Array();
                        $sql[] = "DELETE FROM ".$db_prefix."_snatched WHERE torrent = '".$id."' ;";
                        $sql[] = "DELETE FROM ".$db_prefix."_torrents WHERE id = '".$id."' LIMIT 1;";
                        $sql[] = "DELETE FROM ".$db_prefix."_files WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_peers WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_file WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_backup WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_comments WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_comments_notify WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_seeder_notify WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_ratings WHERE torrent = '".$id."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_download_completed WHERE torrent = '".$id."';";

                        //Are there still Torrent associated to that tracker?
                        $tracker_sql = "SELECT tracker FROM ".$db_prefix."_torrents WHERE id = '".$id."';";
                        $tracker_res = $db->sql_query($tracker_sql);
                        list ($tracker) = $db->sql_fetchrow($tracker_res);
                        if ($tracker != "" AND $db->sql_numrows($db->sql_query("SELECT id FROM ".$db_prefix."_torrents WHERE tracker = '".$tracker."';")) <= 1) $sql[] = "DELETE FROM ".$db_prefix."_trackers WHERE url = '".$tracker."';";
                        $db->sql_freeresult($tracker_res);

                        if ($gfx_check AND (!isset($gfxcode) OR $gfxcode == "" OR $gfxcheck != md5(strtoupper($gfxcode)))) bterror(_bterrcode,_btdelete);

                        foreach ($sql as $query) {
                                $db->sql_query($query) or btsqlerror($query);
                        }

                        if (file_exists("torrent/".$id.".torrent")) @unlink("torrent/".$id.".torrent");
                        if (file_exists("torrent/".$id.".nfo")) @unlink("torrent/".$id.".nfo");
                        OpenTable(_btdelete);
                        echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
                        echo "<p>"._btdeleted."</p>";
                        CloseTable();
                }
                break;
        }
}


include("footer.php");
?>