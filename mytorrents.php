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
*/

if (!eregi("mytorrents.php",$_SERVER["PHP_SELF"])) die("You can't include this file");
include("header.php");
include("language/mailtexts.php");

if (!$user->user) loginrequired("user");

#BUG REPORT
#TORRENT OWNER'S NAME IS DISPLAYED EVEN IF HE SET PRIVACY MODE FOR TORRENTS
#TO BE FIXED IN LATER STAGES OF DEVELOPMENT
#END BUG REPORT

OpenTable(_btmytorrentsintrotitle);
echo "<p>"._btmytorrentsintrotext."</p>";
CloseTable();

if (!isset($op)) $op = null;
switch ($op) {
        case "savetorrentgeneral": {
                if (!is_numeric($id)) bterror(_btwronginput,_btmytorrents);
                if (!isset($private) OR $private != "true") $private = "false";
                if (!isset($minratio) OR !preg_match("/^[0-1]\.[0-9]0$/",$minratio)) bterror(_btwronginput,_btmytorrents);
                $sql = "UPDATE ".$db_prefix."_torrents SET private = '".$private."', min_ratio = '".$minratio."' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $op = "displaytorrent";
                header("Location: mytorrents.php?op=displaytorrent&id=".$id);
                die();
        }
        case "savetorrent": {
                if (!is_numeric($id)) bterror(_btwronginput,_btmytorrents);
                $notifications = New MailingList();
                $auth_users = explode(",",$auth_users);
                foreach ($auth_users as $auth) {
                        if (!is_numeric($auth)) bterror(_btwronginput,_btmytorrents);
                        $uservar = "user".$auth;
                        switch ($$uservar) {
                                case "grant": {
                                        $sql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."' AND torrent = '".$id."';";
                                        $row = $db->sql_fetchrow($db->sql_query($sql));
                                        if ($row["status"] != "granted") {
                                                $sql = "UPDATE ".$db_prefix."_privacy_file SET status = 'granted' WHERE master = '".$user->id."' AND slave = '".$auth."' AND torrent = '".$id."';";
                                                $db->sql_query($sql) or btsqlerror($sql);
                                                $sql = "SELECT U.email, U.username, T.name, T.id FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_torrents T ON T.id = '".$id."' WHERE U.id = ".$auth.";";
                                                $row = $db->sql_fetchrow($db->sql_query($sql));
                                                $search = Array("**sitename**","**siteurl**","**name**","**id**","**master**","**slave**");
                                                $replace = Array($sitename,$siteurl,$row["name"],$row["id"],$user->name,$row["username"]);
                                                $confirm_mail = New eMail;
                                                $confirm_mail->sender = $admin_email;
                                                $confirm_mail->Add($row["email"]);
                                                $confirm_mail->body = str_replace($search,$replace,$authgrantmailtext[$language]);
                                                $confirm_mail->subject = str_replace($search,$replace,$authrespmailsub[$language]);
                                                $notifications->Insert($confirm_mail);
                                                //unset($confirm_mail);
                                        }
                                        break;

                                }
                                case "deny": {
                                            $sql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."' AND torrent = '".$id."';";
                                            $row = $db->sql_fetchrow($db->sql_query($sql));
                                        if ($row["status"] != "denied") {
                                                $sql = "UPDATE ".$db_prefix."_privacy_file SET status = 'denied' WHERE master = '".$user->id."' AND slave = '".$auth."' AND torrent = '".$id."';";
                                                $db->sql_query($sql) or btsqlerror($sql);
                                                $sql = "SELECT U.email, U.username, T.name, T.id FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_torrents T ON T.id = '".$id."' WHERE U.id = ".$auth.";";
                                                $row = $db->sql_fetchrow($db->sql_query($sql));
                                                $search = Array("**sitename**","**siteurl**","**name**","**id**","**master**","**slave**");
                                                $replace = Array($sitename,$siteurl,$row["name"],$row["id"],$user->name,$row["username"]);
                                                $confirm_mail = New eMail;
                                                $confirm_mail->sender = $admin_email;
                                                $confirm_mail->Add($row["email"]);
                                                $confirm_mail->body = str_replace($search,$replace,$authdenymailtext[$language]);
                                                $confirm_mail->subject = str_replace($search,$replace,$authrespmailsub[$language]);
                                                $notifications->Insert($confirm_mail);
                                                //unset($confirm_mail);
                                        }
                                        break;
                                }
                                case "alwaysgrant": {
                                        //PUT USER INTO WHITE LIST
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_global WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_backup WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_global (master, slave, status) VALUES ('".$user->id."', '".$auth."', 'whitelist');";
                                        $db->sql_query($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_backup SELECT * FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."';" ;
                                                                                $db->sql_query($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "SELECT U.email, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
                                        $row = $db->sql_fetchrow($db->sql_query($sql));
                                        $search = Array("**sitename**","**siteurl**","**master**","**slave**");
                                        $replace = Array($sitename,$siteurl,$user->name,$row["username"]);
                                        $confirm_mail = New eMail;
                                        $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($row["email"]);
                                        $confirm_mail->body = str_replace($search,$replace,$authagrantmailtext[$language]);
                                        $confirm_mail->subject = $authrespmailsub[$language];
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;

                                }
                                case "alwaysdeny": {
                                        //PUT USER INTO BLACK LIST
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_global WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_backup WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_global (master, slave, status) VALUES ('".$user->id."', '".$auth."', 'blacklist');";
                                        $db->sql_query($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_backup SELECT * FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."';" ;
                                        $db->sql_query($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "SELECT U.email, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
                                        $row = $db->sql_fetchrow($db->sql_query($sql));
                                        $search = Array("**sitename**","**siteurl**","**master**","**slave**");
                                        $replace = Array($sitename,$siteurl,$user->name,$row["username"]);
                                        $confirm_mail = New eMail;
                                        $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($row["email"]);
                                        $confirm_mail->body = str_replace($search,$replace,$authadenymailtext[$language]);
                                        $confirm_mail->subject = $authrespmailsub[$language];
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;
                                }
                        }
                $notifications->Sendmail();
                //unset($notifications);
                }
        }
        case "displaytorrent": {
                if (!is_numeric($id) OR $id < 1) bterror(_btiderror,_btauthpanel);
                $checkres = $db->sql_query("SELECT id, private, min_ratio FROM ".$db_prefix."_torrents WHERE id = '".$id."' AND owner = '".$user->id."';");
                if ($db->sql_numrows($checkres) != 1) bterror (_btcantseeothertorrents,_btaccdenied);
                list ($tid, $private, $min_ratio) = $db->sql_fetchrow($checkres);
                $db->sql_freeresult($checkres);

                //General Torrent Options
                OpenTable(_btgeneraloptions);
                echo "<form action=\"mytorrents.php?op=savetorrentgeneral\" method=\"POST\">\n";
                echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">\n";
                echo "<table>\n";
                echo "<tr><td><p>"._btprivate."</p></td><td><p><input type=\"checkbox\" name=\"private\" value=\"true\" ";
                if ($private == "true") echo "checked";
                echo " />"._btprivateexpl."</p></td></tr>\n";
                echo "<tr><td><hr /></td><td></td></tr>";
                echo "<tr><td><p>"._btminratio."</p></td><td><p>";
                echo "<select name=\"minratio\">\n";
                echo "<option value=\"0.00\">"._btdisabled."</option>\n";
                for ($r = 0.10; $r <= 1.00; $r += 0.10) {
                        echo "<option value=\"".number_format($r,2)."\" ";
                        if ($min_ratio == number_format($r,2)) echo "selected";
                        echo ">".number_format($r,2)."</option>\n";
                }
                echo "</select>"._btminratioexpl;
                echo "</table>\n";
                echo "<input type=\"submit\" value=\""._btsend."\"><input type=\"reset\" value=\""._btreset."\">\n";
                echo "</form>";
                CloseTable();

                //Start privacy list
                $sql = "SELECT P.*, T.name as torrent, U.id as userid, U.username as username, U.uploaded, U.downloaded FROM ".$db_prefix."_privacy_file P LEFT JOIN ".$db_prefix."_users U ON U.id = P.slave LEFT JOIN ".$db_prefix."_torrents T ON P.torrent = T.id WHERE torrent = '".$id."';";
                $privacyres = $db->sql_query($sql);
                if (!$privacyres) btsqlerror($sql);
                if ($db->sql_numrows($privacyres) < 1) {
                        OpenTable(_btauthpanel);
                        echo "<p>"._btnoauthstomanage."</p>";
                        CloseTable();
                        break;
                }
                OpenTable(_btauthpanel);
                echo "<form action=\"mytorrents.php?op=savetorrent\" method=\"POST\">";
                echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
                echo "<table width=\"100%\">";
                echo "<thead>\n";
                echo "<tr><th><p>"._btusername."</p></th><th><p>"._btstats."</p></th><th></p>"._btactions."</p></th><th></tr>";
                echo "</thead>\n";
                echo "<tbody>";
                $auth_users = Array();
                while ($privacyrow = $db->sql_fetchrow($privacyres)) {
                        echo "<tr>";
                        echo "<td><p>".$privacyrow["username"]."</p></td>";
                        echo "<td><p>".str_replace("**",mksize($privacyrow["uploaded"]),_bthasuploaded);
                        echo "<br />".str_replace("**",mksize($privacyrow["downloaded"]),_bthasdownloaded);
                        echo "<br />"._btratio.": ";
                        echo ($privacyrow["downloaded"] != 0) ? number_format($privacyrow["uploaded"]/$privacyrow["uploaded"],2) : "&infin;";
                        echo "</p></td>";
                        {
                                echo "<td><p><input type=\"radio\" name=\"user".$privacyrow["userid"]."\" value=\"grant\" ";
                                if ($privacyrow["status"] == "granted") echo "checked";
                                echo " >"._btauthgrant."<br />";
                        }
                        {
                                echo "<input type=\"radio\" name=\"user".$privacyrow["userid"]."\" value=\"deny\" ";
                                if ($privacyrow["status"] == "denied") echo "checked";
                                echo " >"._btauthdeny."<br />";
                        }
                        echo "<input type=\"radio\" name=\"user".$privacyrow["userid"]."\" value=\"alwaysgrant\">"._btauthalwaysgrant."<br />\n";
                        echo "<input type=\"radio\" name=\"user".$privacyrow["userid"]."\" value=\"alwaysdeny\">"._btauthalwaysdeny."<br />\n";
                        echo "</p></td>";
                        echo "</tr>\n";
                        echo "<tr><td><hr /></td><td></td></td></tr>";
                        $auth_users[] = $privacyrow["userid"];
                }
                echo "<tbody>\n";
                echo "</table>\n";
                echo "<input type=\"hidden\" name=\"auth_users\" value=\"".implode(",",$auth_users)."\">\n";
                echo "<input type=\"submit\" value=\""._btsend."\"><input type=\"reset\" value=\""._btreset."\">\n";
                echo "</form>\n";
                CloseTable();
                $db->sql_freeresult($privacyres);
                break;
        }
        case "saveglobals": {
                $notifications = New MailingList();
                $auth_users = explode(",",$auth_users);
                foreach ($auth_users as $auth) {
                        if ($auth != intval($auth)) bterror(_btwronginput,_btmytorrents);
                        $auth = intval($auth);
                        $uservar = "user".$auth;
                        switch ($$uservar) {
                                case "alwaysgrant": {
                                        $sql = "UPDATE ".$db_prefix."_privacy_global SET status = 'whitelist' WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $sql = "SELECT U.email, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
                                        $row = $db->sql_fetchrow($db->sql_query($sql));
                                        $search = Array("**sitename**","**siteurl**","**master**","**slave**");
                                        $replace = Array($sitename,$siteurl,$user->name,$row["username"]);
                                        $confirm_mail = New eMail;
                                        $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($row["email"]);
                                        $confirm_mail->body = str_replace($search,$replace,$authagrantmailtext[$language]);
                                        $confirm_mail->subject = $authrespmailsub[$language];
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;
                                }
                                case "alwaysdeny": {
                                        $sql = "UPDATE ".$db_prefix."_privacy_global SET status = 'blacklist' WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlterror($sql);
                                        $sql = "SELECT U.email, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
                                        $row = $db->sql_fetchrow($db->sql_query($sql));
                                        $search = Array("**sitename**","**siteurl**","**master**","**slave**");
                                        $replace = Array($sitename,$siteurl,$user->name,$row["username"]);
                                        $confirm_mail = New eMail;
                                        $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($row["email"]);
                                        $confirm_mail->body = str_replace($search,$replace,$authadenymailtext[$language]);
                                        $confirm_mail->subject = $authrespmailsub[$language];
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;
                                }
                                case "reset": {
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_file SELECT * FROM ".$db_prefix."_privacy_backup WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_global WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_backup WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $sql = "SELECT U.email, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
                                        $row = $db->sql_fetchrow($db->sql_query($sql));
                                        $search = Array("**sitename**","**siteurl**","**master**","**slave**");
                                        $replace = Array($sitename,$siteurl,$user->name,$row["username"]);
                                        $confirm_mail = New eMail;
                                        $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($row["email"]);
                                        $confirm_mail->body = str_replace($search,$replace,$authresetmailtext[$language]);
                                        $confirm_mail->subject = $authrespmailsub[$language];
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;
                                }
                        }
                }
                $notifications->Sendmail();
        }
        default: {
                #My Torrents
                if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
                $from = ($page - 1) * $torrent_per_page;

                $totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_torrents WHERE ".$db_prefix."_torrents.owner = '".$user->id."';";
                $totres = $db->sql_query($totsql) or btsqlerror($totsql);
                list ($tot) = $db->sql_fetchrow($totres);
                $db->sql_freeresult($totres);

                $pages = ceil($tot / $torrent_per_page);

                if($page < $pages) {
                        $next = "<b><a href=\"mytorrents.php?page=".($page+1)."\">&gt;&gt;&gt;&gt;</a></b>";
                } else {
                        $next = "&gt;&gt;&gt;&gt;";
                }
                if ($page > 1) {
			$prev = "<b><a href=\"mytorrents.php?page=".($page-1)."\">&lt;&lt;&lt;&lt;</a></b>";
                } else {
                        $prev = "&lt;&lt;&lt;&lt;";
                }
                $pager = "<a href=\"mytorrents.php\">".(($page == 1) ? "<b>1</b>" : "1")."</a>&nbsp;";

                if (($page - 15) > 1) $pager .= "...";

                for ($i = max(2,$page - 15); $i < min($pages, $page + 15); $i++) {
                        $pager .= "<a href=\"mytorrents.php?page=".$i."\">".(($i == $page) ? "<b>".$i."</b>" : $i)."</a>&nbsp;";
                }
                if (($page + 15) < $pages) $pager .= "...";
                $pager .= "<a href=\"mytorrents.php?page=".$pages."\">".(($page == $pages) ? "<b>".$pages."</b>" : $pages)."</a>";


                $sql = "SELECT ".$db_prefix."_torrents.*, COUNT(".$db_prefix."_privacy_file.status), IF(".$db_prefix."_torrents.numratings < '$minvotes', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, ".$db_prefix."_categories.name AS cat_name, ".$db_prefix."_categories.image AS cat_pic FROM ".$db_prefix."_torrents LEFT JOIN ".$db_prefix."_categories ON category = ".$db_prefix."_categories.id LEFT JOIN ".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id LEFT JOIN ".$db_prefix."_privacy_file ON ".$db_prefix."_torrents.id = ".$db_prefix."_privacy_file.master WHERE ".$db_prefix."_torrents.owner = '".$user->id."' GROUP BY ".$db_prefix."_torrents.id ORDER BY ".$db_prefix."_torrents.added DESC LIMIT ".$from.",".$torrent_per_page.";";
                $myres = $db->sql_query($sql);
                if (!$myres) btsqlerror($sql);
                if ($db->sql_numrows($myres) < 1) {
                        OpenTable();
                        echo _btnotorrentuploaded."<br>";
                        CloseTable();
                } else {
                        torrenttable($myres,"mytorrents");
                        echo "<table border=\"0\" width=\"100%\"><tr><td align=\"left\"><p>".$prev."</p></td><td align=\"center\"><p>".(($pages > 1) ? $pager : "")."</p></td><td align=\"right\"><p>".$next."</p></td></tr></table>";
                }
                $db->sql_freeresult($myres);

                #My Global Authorizations
                if ($torrent_global_privacy) {
                        $sql = "SELECT A.slave, A.status, B.uploaded, B.downloaded, B.username FROM ".$db_prefix."_privacy_global A LEFT JOIN ".$db_prefix."_users B ON B.id = A.slave WHERE A.master = '".$user->id."';";
                        $myres = $db->sql_query($sql);
                        if (!$myres) btsqlerror($sql);
                        OpenTable(_btmyglobals);
                        if ($db->sql_numrows($myres) < 1) echo _btnoglobals;
                        else {
                                echo "<form action=\"mytorrents.php\" method=\"post\"><input type=\"hidden\" name=\"op\" value=\"saveglobals\">";
                                echo "<table width=\"100%\">\n";
                                echo "<thead>\n";
                                echo "<tr>\n<td><b>"._btusername."</b></td>\n<td><b>"._btstats."</b></td>\n<td><b>"._btstatus."</b></td>\n<td><b>"._btactions."</b></td>\n</tr>";
                                echo "</thead>\n<tbody>";
                                $auth_users = Array();
                                while ($myauth = $db->sql_fetchrow($myres)) {
                                        $auth_users[] = $myauth["slave"];
                                        echo "<tr>\n<td><p>".$myauth["username"]."</p></td>\n";
                                        echo "<td><p>".str_replace("**",mksize($myauth["uploaded"]),_bthasuploaded);
                                        echo "<br />\n".str_replace("**",mksize($myauth["downloaded"]),_bthasdownloaded);
                                        echo "<br />"._btratio.": ";
                                        echo ($privacyrow["downloaded"] != 0) ? number_format($privacyrow["uploaded"]/$privacyrow["uploaded"],2) : "&infin;";
                                        echo "</p></td>";
                                        echo "<td>";
                                        if ($myauth["status"] == "whitelist") {
                                                echo "<p class=\"whitelist\">"._btauthalwaysgrant."</p>";
                                        } elseif ($myauth["status"] == "blacklist") {
                                                echo "<p class=\"blacklist\">"._btauthalwaysdeny."</p>";
                                        }
                                        echo "<td><p>\n";
                                        {
                                                echo "<input type=\"radio\" name=\"user".$myauth["slave"]."\" value=\"alwaysgrant\" ";
                                                if ($myauth["status"] == "whitelist") echo "checked";
                                                echo " >"._btauthalwaysgrant;
                                        }
                                        echo "<br />";
                                        {
                                                echo "<p><input type=\"radio\" name=\"user".$myauth["slave"]."\" value=\"alwaysdeny\" ";
                                                if ($myauth["status"] == "blacklist") echo "checked";
                                                echo " >"._btauthalwaysdeny;
                                        }
                                        echo "<br />";
                                        {
                                                echo "<input type=\"radio\" name=\"user".$myauth["slave"]."\" value=\"reset\" ";
                                                echo " >"._btauthreset;
                                        }
                                        echo "</p></td></tr>\n";
                                        echo "<tr><td><hr /></td><td></td><td></td></tr>\n";
                                }
                                echo "</tbody>\n</table>\n\n";
                                echo "<input type=\"hidden\" name=\"auth_users\" value=\"".implode(",",$auth_users)."\">";
                                echo "<input type=\"submit\" value=\""._btsend."\"><input type=\"reset\" value=\""._btreset."\">";
                                echo "</form>";
                        }
                        $db->sql_freeresult($myres);
                        CloseTable();
        }
}
}
include("footer.php");
?>