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
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
echo "<html>\n";
echo "<head>\n";
echo"<script type=\"text/javascript\" language=\"JavaScript\" src=\"$siteurl/bbcode.js\"></script>";
echo "<!--[if lt IE 7]>
<script defer type=\"text/javascript\" src=\"$siteurl/pngfix.js\"></script><![endif]-->";
echo "<title>".$sitename."</title>\n";
?>
<script type="text/javascript">
pmbtsite_url = "<?php echo $siteurl; ?>";
tag_prompt = "<?php echo _bb_tag_prompt; ?>";
img_prompt = "<?php echo _bb_img_prompt; ?>";
font_formatter_prompt = "<?php echo _bb_font_formatter_prompt; ?>";
link_text_prompt = "<?php echo _bb_link_text_prompt; ?>";
link_url_prompt = "<?php echo _bb_link_url_prompt; ?>";
link_email_prompt = "<?php echo _bb_link_email_prompt; ?>";
list_type_prompt = "<?php echo _bb_list_type_prompt; ?>";
list_item_prompt = "<?php echo _bb_list_item_prompt; ?>";
_btshoutnowprivate = "<?php echo _btshoutnowprivate; ?>";
</script>
<?php
$reason = "";
if (is_banned($user, $reason)) {
echo "<meta http-equiv=\"refresh\" content=\"0;url=ban.php?reson=".urlencode($reason)."\">";        die();
}
if($user->can_shout != "true")
{
echo _btshout_noperms;
die();
}
if (is_readable("themes/$theme/style.css")) {
        echo "<link rel=\"StyleSheet\" href=\"$siteurl/themes/$theme/style.css\" type=\"text/css\">\n<script type=\"text/javascript\" src=\"$siteurl/global.js\"></script>\n";
}
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
echo "<body onload=\"shoutthis_ajax()\">\n";
OpenTable(_btshoutboxshow);
$usql = "SELECT id FROM ".$db_prefix."_online_users WHERE page='index.php' AND UNIX_TIMESTAMP(NOW()-last_action) < 600";
$ures = $db->sql_query($usql)or print(mysql_error());
$utot = $db->sql_numrows($ures);
$ucount = $utot;
echo"<span id='shoutTD'></span>\n";
echo"<div class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\">";
				echo"<table id=\"vbshout_pro_tabs\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
				echo"<tr>";
					echo"<td style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" class=\"alt2\"><div class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\"><span style=\"border: 0px none  ! important; margin: 0px; padding: 0px; float: right;\"><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; display: block;\"><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 1px; height: 1px; display: block;\"></span><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 2px; height: 1px; display: block;\"></span><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 3px; height: 1px; display: block;\"></span></span></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 3px; height: 1px; display: block;\"></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 2px; height: 1px; display: block;\"></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 1px; height: 1px; display: block;\"></span></div><div class=\"smallfont\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px 5px 4px; background: transparent none repeat scroll 0% 0%; text-align: center; white-space: nowrap; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;\"><span id=\"shoutthisch\" onclick=\"sndReq('op=view_shout', 'shout_out');\" style=\"cursor: pointer;\">"._btshoutboxshow."</span></div></td><td style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" class=\"alt1\">&nbsp;</td><td style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" class=\"alt2\"><div class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\"><span style=\"border: 0px none  ! important; margin: 0px; padding: 0px; float: right;\"><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; display: block;\"><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 1px; height: 1px; display: block;\"></span><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 2px; height: 1px; display: block;\"></span><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 3px; height: 1px; display: block;\"></span></span></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 3px; height: 1px; display: block;\"></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 2px; height: 1px; display: block;\"></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 1px; height: 1px; display: block;\"></span></div><div class=\"smallfont\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px 5px 4px; background: transparent none repeat scroll 0% 0%; text-align: center; white-space: nowrap; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;\"><span onclick=\"sndReq('op=activeusers', 'shout_out');\" style=\"cursor: pointer;\" />Active Users: <span id=\"shoutbox_activity\">".$ucount."</span></span></div></td><td style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" class=\"alt1\">&nbsp;</td><td class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" width=\"100%\">&nbsp;</td>";
				echo"</tr>";

				echo"</table>";
		echo"</div>";

echo"<span id='active_user' class='shoutbox'>";
echo"<span id='shout_out' class='shoutbox'>";
echo"<span id='Private_shout' class='shoutbox'>";
$utc2 = $btback1;
                $sql = "SELECT S.*, U.id as uid, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id ORDER BY posted DESC LIMIT 30;";
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
$num2s = $db->sql_numrows($shoutres);
                if ($num2s > 0) {
                        while ($shout = $db->sql_fetchrow($shoutres)) {

if ($num2s > 1)
{
$ucs++;
}
if($ucs%2 == 0)
$utc2 = $btback1;
else
$utc2 = $btback2;
$i++;
						$caneditshout = false;
if ($user->admin) $caneditshout = true;
if ($user->id == $shout['uid']) $caneditshout = true;
if ($shout['id_to']!=0){
if ($user->id == $shout['id_to'] OR $user->id == $shout['uid']){
                                echo "<p>";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                echo "<div style=\"background-color: #$utc2;\" onMouseOver=\"this.style.backgroundColor='$btback3';\" onMouseOut=\"this.style.backgroundColor='#$utc2';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                echo ($user->admin ? "<a ondblclick=\"if(confirm("._btshout_delete.")==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",_btalt_edit) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', "._btshout_shouttd.")\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "").($user->user ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>]"._btprivates."  <b><span class=\"".$shout['level']."\" onclick=\"sndReq('op=private__chat&to=".$shout['uid']."', "._btshout_shoutout."); toggleprivate('shout_send','".$shout['uid']."');\">".htmlspecialchars($shout["user_name"])."</span></b>: ";
                                echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div>\n";
								}
								}
								if ($shout['id_to']==0){
                                echo "<p>";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                echo "<div style=\"background-color: #$utc2;\" onMouseOver=\"this.style.backgroundColor='$btback3';\" onMouseOut=\"this.style.backgroundColor='#$utc2';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                echo ($user->admin ? "<a ondblclick=\"if(confirm("._btshout_delete.")==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",_btalt_edit) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "").($user->user ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>] <b><span class=\"".$shout['level']."\" onclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\">".htmlspecialchars($shout["user_name"])."</span></b>: ";
                                echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div>\n";
								}
								
								
                        }
                } else {
                        echo "<p align=\"center\">"._btnoshouts."</p>\n";
                }
                $db->sql_freeresult($shoutres);
echo"</span>";
echo"</span>";
echo"</span>";
unset($shout, $shoutres); 

if ($user->user ) {
        echo "<form name=\"Shoutform\" method=\"POST\" action=\"frame.php\" target=\"Shoutbox\" onsubmit=\"sendshout(text.value);\">\n";
        echo "<input type=\"hidden\" name=\"op\" value=\""._btshout."\">\n";
        echo "<textarea id=\"shout_textarea\" name=\"text\" rows=\"1\" cols=\"90\"  onkeyup=\" if (event.keyCode == 13) {this.value=''}\" onkeypress=\"if (event.keyCode == 13) {sendshoutout(this.value, 'shout_out');}\"></textarea>\n"; //echo "<textarea name=\"text\" rows=\"5\" cols=\"19\"></textarea>\n";

        $sql = "SELECT * FROM ".$db_prefix."_smiles GROUP BY file ORDER BY id ASC LIMIT 14;";
        $smile_res = $db->sql_query($sql);
        if ($db->sql_numrows($smile_res) > 0) {
                $smile_rows = $db->sql_fetchrowset($smile_res);
                echo "<p>";
                foreach ($smile_rows as $smile) {
                        echo " <a onclick=\"comment_smile('".$smile["code"]."',Shoutform.text);\"><img src=\"smiles/".$smile["file"]."\" border=\"0\" alt=\"".$smile["alt"]."\"></a>\n";
                }
                echo "<br><img src=\"images/bbcode/bbcode_bold.gif\" alt="._btshout_bold." title="._btshout_bold." border=0 onclick=bbcode(document.Shoutform,'b','',Shoutform.text) onmouseover=this.style.cursor='pointer'; >";
                echo "<img src=\"images/bbcode/bbcode_underline.gif\" alt="._btshout_underlined." title="._btshout_underlined." border=0 onclick=bbcode(document.Shoutform,'u','',Shoutform.text) onmouseover=this.style.cursor='pointer'; >";
                echo "<img src=\"images/bbcode/bbcode_italic.gif\" alt="._btshout_italic." title="._btshout_italic." border=0 onclick=bbcode(document.Shoutform,'i','',Shoutform.text) onmouseover=this.style.cursor='pointer';>";
                echo "<img src=\"images/bbcode/bbcode_quote.gif\" alt="._btshout_quote." title="._btshout_quote." border=0 onclick=bbcode(document.Shoutform,'quote','',Shoutform.text) onmouseover=this.style.cursor='pointer';>";
                echo "<img src=\"images/bbcode/bbcode_image.gif\" alt="._btshout_image." title="._btshout_image." border=0 onclick=bbcode(document.Shoutform,'img','',Shoutform.text) onmouseover=this.style.cursor='pointer';>";
                echo "<img src=\"images/bbcode/bbcode_url.gif\" alt="._btshout_link." title="._btshout_link." border=0 onclick=bbcode(document.Shoutform,'url','',Shoutform.text) onmouseover=this.style.cursor='pointer';>
				                        <select id=fontselect 
                        onchange=fontformat(Shoutform,this.options[this.selectedIndex].value,'font',text)>
                        <option value=0>"._btshout_font."</option>
                        <option value=arial><font face=\"arial\">"._btshout_arial."</font></option>
                        <option value=comic sans ms>"._btshout_comic."</option>
                        <option value=courier new>"._btshout_courier."</option>
                        <option value=tahoma>"._btshout_tahoma."</option>
                        <option value=times new roman>"._btshout_times."</option>
                        <option value=verdana>"._btshout_verdana."</option>

                        </select>
						<select id=sizeselect onchange=fontformat(Shoutform,this.options[this.selectedIndex].value,'size',text)>
                        <option value=0>"._btshout_size."</option>
                        <option value=1>"._btshout_verysmall."</option>
                        <option value=2>Small"._btshout_small."</option>
                        <option value=3>"._btshout_normal."</option>
                        <option value=4>"._btshout_large."</option>
                        <option value=5>"._btshout_xlarge."</option>
                        </select>
                        <select id=colorselect 
                        onchange=fontformat(Shoutform,this.options[this.selectedIndex].value,'color',text)>
                        <option value=0>"._btshout_color."</option>
                        <option value=skyblue style=color:skyblue>"._btshout_skyblue."</option>
                        <option value=royalblue style=color:royalblue>"._btshout_royalblue."</option>
                        <option value=blue style=color:blue>"._btshout_blue."</option>
                        <option value=darkblue style=color:darkblue>"._btshout_darkblue."</option>
                        <option value=orange style=color:orange>"._btshout_orange."</option>
                        <option value=orangered style=color:orangered>"._btshout_orangered."</option>
                        <option value=crimson style=color:crimson>"._btshout_crimson."</option>
                        <option value=red style=color:red>"._btshout_red."</option>
                        <option value=firebrick style=color:firebrick>"._btshout_firebrick."</option>
                        <option value=darkred style=color:darkred>"._btshout_darkred."</option>
                        <option value=green style=color:green>"._btshout_green."</option>
                        <option value=limegreen style=color:limegreen>"._btshout_limegreen."</option>
                        <option value=seagreen style=color:seagreen>"._btshout_seagreen."</option>
                        <option value=deeppink style=color:deeppink>"._btshout_deeppink."</option>
                        <option value=tomato style=color:tomato>"._btshout_tomato."</option>
                        <option value=coral style=color:coral>"._btshout_coral."</option>
                        <option value=purple style=color:purple>"._btshout_purple."</option>
                        <option value=indigo style=color:indigo>"._btshout_indigo."</option>
                        <option value=burlywood style=color:burlywood>"._btshout_burlywood."</option>
                        <option value=sandybrown style=color:sandybrown>"._btshout_.sandybrown."</option>
                        <option value=sienna style=color:sienna>"._btshout_sienna."</option>
                        <option value=chocolate style=color:chocolate>"._btshout_chocolate."</option>
                        <option value=teal style=color:teal>"._btshout_teal."</option>
                        <option value=silver style=color:silver>"._btshout_silver."</option>
                        </select>
                        
                        <input type=\"radio\" name=\"mode\" id=\"radio_bbcodemode_1\" value=\"0\" title=\"normal Mode (alt+n)\" accesskey=\"n\" onclick=\"setmode(this.value)\" checked=\"checked\" /><label for=\"radio_bbcodemode_1\">
                        "._btshout_normalmode."</label>
                        <input type=\"radio\" name=\"mode\" id=\"radio_bbcodemode_2\" value=\"1\" title=\"enhanced Mode (alt+e)\" accesskey=\"e\" onclick=\"setmode(this.value)\"  /><label for=\"radio_bbcodemode_2\">
                        "._btshout_expertmode."</label><br><br>
</p>";
        }
        $db->sql_freeresult($smile_res);
        echo "<input type=\"button\" id=\"shout_send\" onclick=\"sendshoutout(text.value, 'shout_out'); text.value = '';\" value=\""._btshoutnow."\" />\n";
        echo "<input type=\"button\" onclick=\"sndReq('op=view_shout', 'shout_out');\" value=\""._btrefresh."\" />\n";
        echo "<input type=\"button\" onclick=\"sndReq('op=more_smiles', 'shoutTD')\" value=\""._btmoresmiles."\" />\n";
        echo "</form>\n";
}
CloseTable();
echo '</body>
</html>';
?>
