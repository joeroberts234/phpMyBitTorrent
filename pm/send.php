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
if (!defined('IN_PMBT')) die ("You can't access this file directly");

echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
include'include/textarea.php';
if(isset($save)){
$subject = $db->sql_escape(stripslashes($subject));
$descr = $db->sql_escape(stripslashes($descr));
        $recipients = preg_split("/;[\\s]*/",$sendto);
        for ($i = 0; $i < count($recipients); $i++) $recipients[$i] = addslashes($recipients[$i]);
        $sql = "SELECT id FROM ".$db_prefix."_users WHERE username IN ('".implode("', '",$recipients)."');";

        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($res) < count($recipients)) bterror(_btpminvalidrecipients,_btnewpm);
        while (list ($id) = $db->sql_fetchrow($res)) {
			$draft = "INSERT INTO ".$db_prefix."_drafts ( user_id, save_time, draft_subject, draft_message, draft_type, user_to) VALUES ('" . $user->id . "', '" . time() . "', '" . $subject . "', '" . $descr . "', 'pm', '" . $id . "');";
			$db->sql_query($draft) or btsqlerror($draft);
			$draft_id = $db->sql_nextid();
		}
        OpenTable(_btnewpm);
        echo "<p align=\"center\">"._btpmsentsuccessfully."</p>\n";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=template_test.php?action=overview&mode=drafts\">\n";
        CloseTable();
		$draft = $draft_id;
		$to = $id;
}
if (!isset($postback)) {
        //Form
        OpenTable(_btnewpm);
        echo "<form method=\"POST\" action=\"pm.php\" id=\"data\" name=\"formdata\">\n";
        echo "<input type=\"hidden\" name=\"op\" value=\"send\" />\n";
        if (!isset($replyto) OR !is_numeric($replyto)) $replyto = 0;
        if (!isset($to) OR !is_numeric($to)) $to = 0;

        echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\">\n";

        if ($replyto) {
                $sql = "SELECT U.username as sender, P.subject, P.text FROM ".$db_prefix."_private_messages P LEFT JOIN ".$db_prefix."_users U ON P.sender = U.id WHERE P.id = '".$replyto."';";
                $res = $db->sql_query($sql) or btsqlerror($sql);
                if ($db->sql_numrows($res)) {
                        list ($replysender, $replysub, $replytext) = $db->sql_fetchrow($res);
                        if (!eregi("^Re: ",$replysub)) $replysub = "Re: ".$replysub;
                }
                else list ($replysender,$replysub) = Array("","");
                $db->sql_freeresult($res);
        } elseif ($to) {
                $sql = "SELECT username as sender FROM ".$db_prefix."_users WHERE id = '".$to."';";
                $res = $db->sql_query($sql) or btsqlerror($sql);
                if ($db->sql_numrows($res)) {
                        list ($replysender) = $db->sql_fetchrow($res);
                }
                else $replysender = "";
                $replysub = "";
                $db->sql_freeresult($res);
        } else list ($replysender,$replysub) = Array("","");


		if(isset($draft)){
			$sql_draft = "SELECT * FROM ".$db_prefix."_drafts WHERE draft_id = '" . $draft ."' LIMIT 1;";
			$res_draft = $db->sql_query($sql_draft) or btsqlerror($sql_draft);
			$row_draft = $db->sql_fetchrow($res_draft);
			$replysub = $row_draft['draft_subject'];
			$draft = stripslashes($row_draft['draft_message']);
			echo "<input type=\"hidden\" name=\"predraft\" value=\"" . $row_draft['draft_id'] . "\" />\n";
		}
        echo "<tr><td><p>"._btpmto."</p></td><td><p><input id=\"sendto\" type=\"text\" name=\"sendto\" value=\"".$replysender."\" size=\"60\" /><br />"._btpmtotip."</p><a href=\"javascript:popusers('userfind_to_pm.php');\">find user to pm</a>";
        //Bookmarks
        //Bookmarks
        $sql = "SELECT B.slave, U.username, IF (U.name IS NULL, U.username, U.name) as name FROM ".$db_prefix."_private_messages_bookmarks B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$user->id."' ORDER BY name ASC;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($n = $db->sql_numrows($res)) {
                echo "<p>&nbsp;</p>\n";
                echo "<p><a href=\"javascript:expandpm();\">"._btpmshowbookmarks."</a></p>\n";
                echo "<p class=\"hide\" id=\"bookmarks\">";
                for ($i = 1; list($uid, $username, $user_name) = $db->sql_fetchrow($res); $i++) {
                        if ($i != 1) echo "&nbsp;";
                        echo "<a href=\"javascript:add('".addslashes($username)."');\">".$user_name."</a>";
                        if ($i != $n) echo "&nbsp; -";
                }
                echo "</p>\n";
        }
        $db->sql_freeresult($res);

        echo "</td></tr>\n";
        echo "<tr><td><hr /></td><td></td></tr>\n";
        echo "<tr><td><p>"._btpmsub."</p></td><td><p><input type=\"text\" name=\"subject\" size=\"60\" value=\"".$replysub."\" /></p>\n</td>\n</tr>\n";
        echo "<tr><td><p>"._btpmtext."</p></td><td>";
echo $textarea->quick_bbcode('formdata','descr');
echo $textarea->input('descr','center','2','10','80',$draft);
        echo "</table></td></tr>\n";

        echo "</table>\n";
        echo "<hr /><input type=\"submit\" name=\"postback\" value=\""._btsend."\"><input type=\"submit\" name=\"save\" value=\"Save\"></form>\n";
        CloseTable();
if ($replyto) {
OpenTable($replysender." "._btpmwrote."");
		$replytext = format_comment($replytext);
		parse_smiles($replytext);
echo "<br>";
echo "<p>".$replytext."</p>";
CloseTable();
}
} else {
$message = $descr;
        //Send
        $errmsg = Array();
        if (!isset($sendto) OR empty($sendto)) $errmsg[] = _btpmnorecipient;
        if (!isset($subject) OR empty($subject)) $errmsg[] = _btpmnosubject;
        if (!isset($message) OR empty($message)) $errmsg[] = _btpmnomessage;
        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $descr)) //HTML contains Javascript EVENTS. Must refuse
                $errmsg[] = _btinvalidhtml;
        elseif (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $page)) //HTML contains Javascript or VBScript calls. Must refuse
                $errmsg[] = _btinvalidhtml;
        if (count($errmsg) > 0) bterror($errmsg,_btnewpm);
        parse_html($message);

        $recipients = preg_split("/;[\\s]*/",$sendto);
        for ($i = 0; $i < count($recipients); $i++) $recipients[$i] = addslashes($recipients[$i]);
        $sql = "SELECT id , username, email, pm_notify FROM ".$db_prefix."_users WHERE username IN ('".implode("', '",$recipients)."');";

        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($res) < count($recipients)) bterror(_btpminvalidrecipients,_btnewpm);
		if (isset($predraft))$db->sql_query("DELETE FROM ".$db_prefix."_drafts WHERE draft_id = '" . $predraft ."' AND user_id = '" . $user->id ."' LIMIT 1");
        include("language/mailtexts.php");
        while (list ($id, $name, $email, $pm_notify) = $db->sql_fetchrow($res)) {
        
                $ban = "SELECT master as master FROM ".$db_prefix."_private_messages_blacklist WHERE slave = '".$user->id."' AND master = '".$id."';";
                $black = $db->sql_query($ban);
                $master = $db->sql_fetchrow($black);
                $db->sql_freeresult($black);
                if ($master[0] && !$user->admin){
                $id = $user->id;
                $message1 = ""._btpmuserblocked."\n".$message."";
                unset($email);
                }else{$message1 = $message;}
                $sql = "INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('".$user->id."','".$id."','".addslashes($subject)."','".addslashes($message1)."',NOW());";

                $db->sql_query($sql) or btsqlerror($sql);
				if($pm_notify == "true"){
                $mid = $db->sql_nextid();

                $notify_mail = new eMail();
                $notify_mail->add($email);
                $notify_mail->sender = $admin_email;
                $notify_mail->subject = $newpmemailsub[$language];
                $search = Array("**user**","**sender**","**sitename**","**siteurl**","**mid**");
                $replace = Array($name,$user->name,$sitename,$siteurl,$mid);
                $notify_mail->body = str_replace($search,$replace,$newpmemailbody[$language]);
                $notify_mail->send();
				}
                
        }
        $db->sql_freeresult($sql);
        OpenTable(_btnewpm);
        echo "<p align=\"center\">"._btpmsentsuccessfully."</p>\n";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=pm.php\">\n";
        CloseTable();
}
?> 