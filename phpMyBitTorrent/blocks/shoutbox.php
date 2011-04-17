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

if (eregi("shoutbox.php",$_SERVER["PHP_SELF"])) die("You can't access this file directly");
if($shout_config['turn_on'] == "yes"){
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
OpenTable(_btshoutbox);
$usql = "SELECT id FROM ".$db_prefix."_online_users WHERE page='index.php' AND UNIX_TIMESTAMP(NOW()-last_action) < 600";
$ures = $db->sql_query($usql)or print(mysql_error());
$utot = $db->sql_numrows($ures);
$ucount = $utot;
echo"<span id='shoutTD'></span>\n";
echo"<div id=\"shoutidle\"></div>\n";

echo"<div class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\">";
				echo"<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
				echo"<tr>";
					echo"<td style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" class=\"alt2\"><div class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\"><span style=\"border: 0px none  ! important; margin: 0px; padding: 0px; float: right;\"><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; display: block;\"><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 1px; height: 1px; display: block;\"></span><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 2px; height: 1px; display: block;\"></span><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 3px; height: 1px; display: block;\"></span></span></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 3px; height: 1px; display: block;\"></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 2px; height: 1px; display: block;\"></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 1px; height: 1px; display: block;\"></span></div><div class=\"smallfont\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px 5px 4px; background: transparent none repeat scroll 0% 0%; text-align: center; white-space: nowrap; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;\"><span id=\"shoutthisch\" onclick=\"sndReq('op=view_shout', 'shout_out');\" style=\"cursor: pointer;\">"._btshoutboxshow."</span></div></td><td style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" class=\"alt1\">&nbsp;</td><td style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" class=\"alt2\"><div class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\"><span style=\"border: 0px none  ! important; margin: 0px; padding: 0px; float: right;\"><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; display: block;\"><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 1px; height: 1px; display: block;\"></span><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 2px; height: 1px; display: block;\"></span><span class=\"alt2\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 3px; height: 1px; display: block;\"></span></span></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 3px; height: 1px; display: block;\"></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 2px; height: 1px; display: block;\"></span><span class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px; overflow: hidden; width: 1px; height: 1px; display: block;\"></span></div><div class=\"smallfont\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px 5px 4px; background: transparent none repeat scroll 0% 0%; text-align: center; white-space: nowrap; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;\"><span onclick=\"sndReq('op=activeusers', 'shout_out');\" style=\"cursor: pointer;\" />"._btshactive.": <span id=\"shoutbox_activity\">".$ucount."</span></span></div></td><td style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" class=\"alt1\">&nbsp;</td><td class=\"alt1\" style=\"border: 0px none  ! important; margin: 0px; padding: 0px;\" width=\"100%\">&nbsp;</td>";
				echo"</tr>";

				echo"</table>";
		echo"</div>";
echo"<span id=\"active_user\" class='shoutbox'>";
echo"<span id=\"shout_out\" class='shoutbox'>";
echo"<span id=\"Private_shout\" class='shoutbox'>";
$shoutannounce = format_comment($shout_config['announce_ment'], false, true);
parse_smiles($shoutannounce);
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">".$shoutannounce."</p></div>";
$utc2 = $btback1;
                $sql = "SELECT S.*, U.id as uid, U.can_do as can_do, U.donator AS donator, U.warned as warned, U.level as level, IF(U.name IS NULL, U.username, U.name) as user_name FROM ".$db_prefix."_shouts S LEFT JOIN ".$db_prefix."_users U ON S.user = U.id ORDER BY  posted DESC LIMIT ".$shout_config['shouts_to_show']."";
                $shoutres = $db->sql_query($sql) or btsqlerror($sql);
$num2s = $db->sql_numrows($shoutres);
                if ($num2s > 0) {
                        while ($shout = $db->sql_fetchrow($shoutres)) {
						$donator ='';
						if($shout['donator'] == 'true')$donator ='<img src="images/donator.gif" height="16" width="16" title="donator" alt="donator" />';

if ($num2s > 1)
{
$ucs++;
}
if($ucs%2 == 0)
{
$utc3 = "od";
$utc2 = $btback1;
}
else
{
$utc3 = "even";
$utc2 = $btback2;
}
$i++;
$caneditshout = false;
$candeleteshout = false;
if ($user->moderator) $caneditshout = true;
if ($user->moderator) $candeleteshout = true;
if ($user->id == $shout['uid'] AND $shout_config['canedit_on'] =="yes") $caneditshout = true;
if ($user->id == $shout['uid'] AND $shout_config['candelete_on'] =="yes") $candeleteshout = true;
if ($shout['id_to']!=0){
if ($user->id == $shout['id_to'] OR $user->id == $shout['uid']){
                                echo "<p>";
								$warn = "";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								if($shout["warned"] == "1") $warn = '<img src="images/warning.gif" alt="warned" />';
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                if(preg_match("/\/notice (.*)/",$text,$m)){
								$text = preg_replace('/\/notice/','',$text);
								}elseif(preg_match("/\/me (.*)/",$text,$m)){
								$text = preg_replace('/\/me/','',$text);
								echo _btprivates."<b><span ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.":";
								}else{
                                echo ($candeleteshout ? "<a ondblclick=\"if(confirm('Delete Shout?')==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",_btalt_edit) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "").($shout_config['bbcode_on'] =="yes" ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>]"._btprivates." <b><span  ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.": ";
                                }
								echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div></p>\n";
								}
								}
								if ($shout['id_to']==0){
                                echo "<p>";
								$warn = "";
								$quote = addslashes($shout["text"]);
								$text = format_comment($shout["text"], false, true);
                                parse_smiles($text);
								if($shout["warned"] == "1") $warn = '<img src="images/warning.gif" alt="warned" />';
								$shout_time = gmdate("Y-m-d H:i:s", sql_timestamp_to_unix_timestamp($shout['posted'])+(60 * get_user_timezone($user->id)));
                                echo "<div class=\"".$utc3."\" onMouseOver=\"this.className='over';\" onMouseOut=\"this.className='$utc3';\"><p class=\"shout\" bgcolor=\"#53B54F\">";
                                if(preg_match("/\/notice (.*)/",$text,$m)){
								$text = preg_replace('/\/notice/','',$text);
								}elseif(preg_match("/\/me (.*)/",$text,$m)){
								$text = preg_replace('/\/me/','',$text);
								echo"<b><span  ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.":";
								}else{
                                echo ($candeleteshout ? "<a ondblclick=\"if(confirm('Delete Shout?')==true)sndReq('op=take_delete_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("drop.gif","",_btalt_edit) ."</a>" : "").($caneditshout  ? "<a ondblclick=\"sndReq('op=edit_shout&shout=".$shout['id']."', 'shoutTD')\">" . pic("edit.gif","",_btalt_edit) ."</a>" : "").($shout_config['bbcode_on'] =="yes" ? "<a onclick=\"comment_smile('[quote=".htmlspecialchars($shout["user_name"])."]".$quote."[/quote]',Shoutform.text);\"><img src=\"images/bbcode/bbcode_quote.gif\" border=\"0\" alt=\"quote\"></a>":"")."[<span class=\"shout_time\">".$shout_time."</span>] <b><span  class=\"".$shout['level']."\" ondblclick=\"sndReq('op=private__chat&to=".$shout['uid']."', 'shout_out'); toggleprivate('shout_send','".$shout['uid']."');\"><font color=\"".getusercolor($shout["can_do"])."\">".htmlspecialchars($shout["user_name"])."</font></span></b>".$warn.$donator.": ";
                                }
								echo str_replace("\n","<br />",$text);
                                echo "</p>";
                                echo "<hr></div></p>\n";
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

if ($user->user AND $user->can_shout == "true") {
        echo "<form name=\"Shoutform\" method=\"POST\" action=\"frame.php\" target=\"Shoutbox\" onsubmit=\"sendshout(text.value);\">\n";
        echo "<input type=\"hidden\" name=\"op\" value=\"shout\">\n";
        echo "<textarea autocomplete=\"off\" id=\"shout_textarea\" name=\"text\" rows=\"2\" cols=\"90\"  onkeyup=\" if (event.keyCode == 13) {this.value=''}\" onkeypress=\"if (event.keyCode == 13) {sendshoutout(this.value, 'shout_out');}\"></textarea>\n"; //echo "<textarea name=\"text\" rows=\"5\" cols=\"19\"></textarea>\n";

        $sql = "SELECT * FROM ".$db_prefix."_smiles WHERE id > '1' GROUP BY file ORDER BY id ASC LIMIT 14;";
        $smile_res = $db->sql_query($sql);
        if ($db->sql_numrows($smile_res) > 0) {
                $smile_rows = $db->sql_fetchrowset($smile_res);
                echo "<p>";
                foreach ($smile_rows as $smile) {
                        echo " <a onclick=\"comment_smile('".$smile["code"]."',Shoutform.text);\"><img src=\"smiles/".$smile["file"]."\" border=\"0\" title=\"".$smile['code']."\" alt=\"".$smile["alt"]."\"></a>\n";
                }
if($shout_config['bbcode_on'] == "yes"){
                echo "<br /><img src=\"images/bbcode/bbcode_bold.gif\" alt=Bold&nbsp;Text Text title=Bold&nbsp;Text Text border=0 onclick=bbcode(document.Shoutform,'b','',Shoutform.text) onmouseover=this.style.cursor='pointer'; >";
                echo "<img src=\"images/bbcode/bbcode_underline.gif\" alt=Underlined&nbsp;Text Text title=Underlined&nbsp;Text Text border=0 onclick=bbcode(document.Shoutform,'u','',Shoutform.text) onmouseover=this.style.cursor='pointer'; >";
                echo "<img src=\"images/bbcode/bbcode_italic.gif\" alt=Italic&nbsp;Text Text title=Italic&nbsp;Text Text border=0 onclick=bbcode(document.Shoutform,'i','',Shoutform.text) onmouseover=this.style.cursor='pointer';>";
                echo "<img src=\"images/bbcode/bbcode_quote.gif\" alt=Quote&nbsp;Text Text title=Quote&nbsp;Text Text border=0 onclick=bbcode(document.Shoutform,'quote','',Shoutform.text) onmouseover=this.style.cursor='pointer';>";
                echo "<img src=\"images/bbcode/bbcode_image.gif\" alt=Image&nbsp;Text Text title=Image&nbsp;Text Text border=0 onclick=bbcode(document.Shoutform,'img','',Shoutform.text) onmouseover=this.style.cursor='pointer';>";
                echo "<img src=\"images/bbcode/bbcode_url.gif\" alt=Link&nbsp;Text Text title=Link&nbsp;Text Text border=0 onclick=bbcode(document.Shoutform,'url','',Shoutform.text) onmouseover=this.style.cursor='pointer';>
				                        <select id=fontselect 
                        onchange=fontformat(Shoutform,this.options[this.selectedIndex].value,'font',text)>
                        <option value=0>FONT</option>
                        <option value=arial><font face=\"arial\">Arial</font></option>
                        <option value=comic sans ms>Comic</option>
                        <option value=courier new>Courier New</option>
                        <option value=tahoma>Tahoma</option>
                        <option value=times new roman>Times New Roman</option>
                        <option value=verdana>Verdana</option>

                        </select>
						<select id=sizeselect onchange=fontformat(Shoutform,this.options[this.selectedIndex].value,'size',text)>
                        <option value=0>Size</option>
                        <option value=1>Thery Small</option>
                        <option value=2>Small</option>
                        <option value=3>Normal</option>
                        <option value=4>Large</option>
                        <option value=5>X-Large</option>
                        </select>
                        <select id=colorselect 
                        onchange=fontformat(Shoutform,this.options[this.selectedIndex].value,'color',text)>
                        <option value=0>COLOR</option>
                        <option value=skyblue style=color:skyblue>sky blue</option>
                        <option value=royalblue style=color:royalblue>royal blue</option>
                        <option value=blue style=color:blue>blue</option>
                        <option value=darkblue style=color:darkblue>dark-blue</option>
                        <option value=orange style=color:orange>orange</option>
                        <option value=orangered style=color:orangered>orange-red</option>
                        <option value=crimson style=color:crimson>crimson</option>
                        <option value=red style=color:red>red</option>
                        <option value=firebrick style=color:firebrick>firebrick</option>
                        <option value=darkred style=color:darkred>dark red</option>
                        <option value=green style=color:green>green</option>
                        <option value=limegreen style=color:limegreen>limegreen</option>
                        <option value=seagreen style=color:seagreen>sea-green</option>
                        <option value=deeppink style=color:deeppink>deeppink</option>
                        <option value=tomato style=color:tomato>tomato</option>
                        <option value=coral style=color:coral>coral</option>
                        <option value=purple style=color:purple>purple</option>
                        <option value=indigo style=color:indigo>indigo</option>
                        <option value=burlywood style=color:burlywood>burlywood</option>
                        <option value=sandybrown style=color:sandybrown>sandy brown</option>
                        <option value=sienna style=color:sienna>sienna</option>
                        <option value=chocolate style=color:chocolate>chocolate</option>
                        <option value=teal style=color:teal>teal</option>
                        <option value=silver style=color:silver>silver</option>
                        </select>
                        
                        <input type=\"radio\" name=\"mode\" id=\"radio_bbcodemode_1\" value=\"0\" title=\"normal Mode (alt+n)\" accesskey=\"n\" onclick=\"setmode(this.value)\" checked=\"checked\" /><label for=\"radio_bbcodemode_1\">
                        Mode Normal</label>
                        <input type=\"radio\" name=\"mode\" id=\"radio_bbcodemode_2\" value=\"1\" title=\"enhanced Mode (alt+e)\" accesskey=\"e\" onclick=\"setmode(this.value)\"  /><label for=\"radio_bbcodemode_2\">
                        Mode Expert</label><br />
						<a href=bbcode.php>BBcode help</a><br /><br />";
	}
echo "</p>";
        }
        $db->sql_freeresult($smile_res);
        echo "<input type=\"button\" id=\"shout_send\" onclick=\"sendshoutout(text.value, 'shout_out'); text.value = '';\" value=\""._btshoutnow."\" />\n";
        echo "<input type=\"button\" onclick=\"sndReq('op=view_shout', 'shout_out');\" value=\""._btrefresh."\" />\n";
        echo "<input type=\"button\" onclick=\"sndReq('op=more_smiles', 'shoutTD')\" value=\""._btmoresmiles."\" />\n";
        echo "</form>\n";
help(pic ("help.gif","",null),_btshouthelp,_btshoutboxshow);
}
CloseTable();
}

?>