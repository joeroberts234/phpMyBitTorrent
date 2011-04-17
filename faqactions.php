<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-------------------   Saturday, JUN 27, 2009 1:05 AM   -----------------------*
*/
if (!eregi("faqactions.php",$_SERVER["PHP_SELF"])) die("You cannot include this file.");
include ("header.php");
if(!checkaccess("manage_faqs")){
OpenErrTable(_btaccdenied);
echo "<p>".str_replace("**page**",_bt_faqmang,_btnoautherized)."</p>\n";
CloseErrTable();
die();
}
$action			= request_var('action', '');
$order			= request_var('order', '');
$fid			= request_var('id', '');
$question		= request_var('question', '');
$type			= request_var('type', '');
$flag			= request_var('flag', '');
$title			= request_var('title', '');
$answer			= request_var('answer', '');
$categ			= request_var('categ', '');

// ACTION: reorder - reorder sections and items
if ($action == "reorder") {
 foreach($order as $id => $position) $db->sql_query("UPDATE `".$db_prefix."_faq` SET `order`='$position' WHERE id='$id'") or sqlerr();
 header("Refresh: 0; url=admin.php?op=faqmanage"); 
}

// ACTION: edit - edit a section or item
elseif ($action == "edit" && isset($fid)) {
OpenTable(_btfaqs);
OpenTable2(_bt_faqmang);

 print("<h1 align=\"center\">Edit Section or Item</h1>");

 $res1 = "SELECT * FROM `".$db_prefix."_faq` WHERE `id`='".$fid."' LIMIT 1;";
 $res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res)) {
  $arr['question'] = stripslashes(htmlspecialchars($arr['question']));
  $arr['answer'] = stripslashes(htmlspecialchars($arr['answer']));
  if ($arr['type'] == "item") {
   print("<form method=\"post\" action=\"faqactions.php?action=edititem\">");
   print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
   print("<tr><td>"._bt_faq_id."</td><td>$arr[id] <input type=\"hidden\" name=\"id\" value=\"$arr[id]\" /></td></tr>\n");
   print("<tr><td>Question:</td><td><input style=\"width: 300px;\" type=\"text\" name=\"question\" value=\"$arr[question]\" /></td></tr>\n");
   print("<tr><td style=\"vertical-align: top;\">"._bt_faq_answer."</td><td><textarea style=\"width: 300px; height=100px;\" name=\"answer\">$arr[answer]</textarea></td></tr>\n");
   if ($arr['flag'] == "0") print("<tr><td>"._bt_faq_status."</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\" selected=\"selected\">"._bt_faq_hidden."</option><option value=\"1\" style=\"color: #000000;\">"._bt_faq_normal."</option><option value=\"2\" style=\"color: #0000FF;\">"._bt_faq_update."</option><option value=\"3\" style=\"color: #008000;\">"._bt_faq_new."</option></select></td></tr>");
   elseif ($arr['flag'] == "2") print("<tr><td>"._bt_faq_status."</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">"._bt_faq_hidden."</option><option value=\"1\" style=\"color: #000000;\">"._bt_faq_normal."</option><option value=\"2\" style=\"color: #0000FF;\" selected=\"selected\">"._bt_faq_update."</option><option value=\"3\" style=\"color: #008000;\">"._bt_faq_new."</option></select></td></tr>");
   elseif ($arr['flag'] == "3") print("<tr><td>"._bt_faq_status."</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">"._bt_faq_hidden."</option><option value=\"1\" style=\"color: #000000;\">"._bt_faq_normal."</option><option value=\"2\" style=\"color: #0000FF;\">"._bt_faq_update."</option><option value=\"3\" style=\"color: #008000;\" selected=\"selected\">"._bt_faq_new."</option></select></td></tr>");
   else print("<tr><td>"._bt_faq_status."</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">"._bt_faq_hidden."</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">"._bt_faq_normal."</option><option value=\"2\" style=\"color: #0000FF;\">"._bt_faq_update."</option><option value=\"3\" style=\"color: #008000;\">"._bt_faq_new."</option></select></td></tr>");
   print("<tr><td>"._bt_faq_catergory."</td><td><select style=\"width: 300px;\" name=\"categ\" />");
   $res3 = "SELECT `id`, `question` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
$res = $db->sql_query($res3);
$db->sql_freeresult($res3);
while ($arr2 = $db->sql_fetchrow($res)) {
    $selected = ($arr2[id] == $arr[categ]) ? " selected=\"selected\"" : "";
    print("<option value=\"$arr2[id]\"". $selected .">$arr2[question]</option>");
   }
   print("</td></tr>\n");
   print("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"edit\" value=\""._btalt_edit."\" style=\"width: 60px;\"></td></tr>\n");
   print("</table>");
  }
  elseif ($arr[type] == "categ") {
   print("<form method=\"post\" action=\"faqactions.php?action=editsect\">");
   print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
   print("<tr><td>"._bt_faq_id."</td><td>$arr[id] <input type=\"hidden\" name=\"id\" value=\"$arr[id]\" /></td></tr>\n");
   print("<tr><td>"._bt_faq_title."</td><td><input style=\"width: 300px;\" type=\"text\" name=\"title\" value=\"$arr[question]\" /></td></tr>\n");
   if ($arr[flag] == "0") print("<tr><td>"._bt_faq_status."</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\" selected=\"selected\">"._bt_faq_hidden."</option><option value=\"1\" style=\"color: #000000;\">"._bt_faq_normal."</option></select></td></tr>");
   else print("<tr><td>"._bt_faq_status."</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">"._bt_faq_hidden."</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">"._bt_faq_normal."</option></select></td></tr>");
   print("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"edit\" value=\""._btalt_edit."\" style=\"width: 60px;\"></td></tr>\n");
   print("</table>");
  }
 }

 CloseTable2();
 CloseTable();
 
}

// subACTION: edititem - edit an item
elseif ($action == "edititem" && $fid != NULL && $question != NULL && $answer != NULL && $flag != NULL && $categ != NULL) {
 $question = addslashes(htmlspecialchars_decode($question));
 $answer = addslashes(htmlspecialchars_decode($answer));
 $db->sql_query("UPDATE `".$db_prefix."_faq` SET `question`='$question', `answer`='$answer', `flag`='$flag', `categ`='$categ' WHERE id='$fid'") or sqlerr();
 header("Refresh: 0; url=admin.php?op=faqmanage"); 
}

// subACTION: editsect - edit a section
elseif ($action == "editsect" && $fid != NULL && $title != NULL && $flag != NULL) {
 $title = addslashes(htmlspecialchars_decode($title));
 $db->sql_query("UPDATE `".$db_prefix."_faq` SET `question`='$title', `answer`='', `flag`='$flag', `categ`='0' WHERE id='$fid'") or sqlerr();
 header("Refresh: 0; url=admin.php?op=faqmanage"); 
}

// ACTION: delete - delete a section or item
elseif ($action == "delete" && isset($_GET[id])) {
 if ($_GET[confirm] == "yes") {
  $db->sql_query("DELETE FROM `".$db_prefix."_faq` WHERE `id`='$_GET[id]' LIMIT 1") or sqlerr();
  header("Refresh: 0; url=admin.php?op=faqmanage"); 
 }
 else {
  OpenTable(_bt_faqmang);

  print("<h1 align=\"center\">"._bt_faq_confer_req."</h1>");
  print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\" width=\"95%\">\n<tr><td align=\"center\">".str_replace("**id**",$_GET[id],_bt_faq_confer_ok)."</td></tr>\n</table>\n");
  CloseTable();

 }
}

// ACTION: additem - add a new item
elseif ($action == "additem" && $_GET[inid]) {
 OpenTable(_bt_faqmang);

OpenTable2(_bt_faq_additem);
 print("<form method=\"post\" action=\"faqactions.php?action=addnewitem\">");
 print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
 print("<tr><td>Question:</td><td><input style=\"width: 300px;\" type=\"text\" name=\"question\" value=\"\" /></td></tr>\n");
 print("<tr><td style=\"vertical-align: top;\">"._bt_faq_answer."</td><td><textarea style=\"width: 300px; height=100px;\" name=\"answer\"></textarea></td></tr>\n");
 print("<tr><td>"._bt_faq_status."</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">"._bt_faq_hidden."</option><option value=\"1\" style=\"color: #000000;\">"._bt_faq_normal."</option><option value=\"2\" style=\"color: #0000FF;\">"._bt_faq_update."</option><option value=\"3\" style=\"color: #008000;\" selected=\"selected\">"._bt_faq_new."</option></select></td></tr>");
 print("<tr><td>"._bt_faq_catergory."</td><td><select style=\"width: 300px;\" name=\"categ\" />");
 $res1 = "SELECT `id`, `question` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
 $res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res)) {
  $selected = ($arr[id] == $_GET[inid]) ? " selected=\"selected\"" : "";
  print("<option value=\"$arr[id]\"". $selected .">$arr[question]</option>");
 }
 print("</td></tr>\n");
 print("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"edit\" value=\"Add\" style=\"width: 60px;\"></td></tr>\n");
 print("</table>");
 CloseTable2();
CloseTable();
}

// ACTION: addsection - add a new section
elseif ($action == "addsection") {
OpenTable(_bt_faqmang);
OpenTable2(_bt_faq_add_section);
 print("<form method=\"post\" action=\"faqactions.php?action=addnewsect\">");
 print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
 print("<tr><td>"._bt_faq_title."</td><td><input style=\"width: 300px;\" type=\"text\" name=\"title\" value=\"\" /></td></tr>\n");
 print("<tr><td>"._bt_faq_status."</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">"._bt_faq_hidden."</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">"._bt_faq_normal."</option></select></td></tr>");
 print("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"edit\" value=\"Add\" style=\"width: 60px;\"></td></tr>\n");
 print("</table>");
CloseTable2(); 
 CloseTable();

}

// subACTION: addnewitem - add a new item to the db
elseif ($action == "addnewitem" && $question != NULL && $answer != NULL && $flag != NULL && $categ != NULL) {
 $question = addslashes(htmlspecialchars_decode($question));
 $answer = addslashes(htmlspecialchars_decode($answer));
 $res1 = "SELECT MAX(`order`) FROM `".$db_prefix."_faq` WHERE `type`='item' AND `categ`='$categ';";
$res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res)) $order = $arr[0] + 1;
 $db->sql_query("INSERT INTO `".$db_prefix."_faq` (`type`, `question`, `answer`, `flag`, `categ`, `order`) VALUES ('item', '$question', '$answer', '$flag', '$categ', '$order')") or sqlerr();
 header("Refresh: 0; url=admin.php?op=faqmanage"); 
}

// subACTION: addnewsect - add a new section to the db
elseif ($action == "addnewsect" && $title != NULL && $flag != NULL) {
 $title = addslashes(htmlspecialchars_decode($title));
 $res1 ="SELECT MAX(`order`) FROM `".$db_prefix."_faq` WHERE `type`='categ';";
$res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res)) $order = $arr[0] + 1;
 $db->sql_query("INSERT INTO `".$db_prefix."_faq` (`type`, `question`, `answer`, `flag`, `categ`, `order`) VALUES ('categ', '$title', '', '$flag', '0', '$order')") or sqlerr();
 header("Refresh: 0; url=admin.php?op=faqmanage");
}
else header("Refresh: 0; url=admin.php?op=faqmanage");
include ("footer.php")
?>