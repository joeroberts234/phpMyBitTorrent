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
include("header.php");
global $db, $db_prefix;
$phpself = $_SERVER['PHP_SELF'];
function get_date_time($timestamp = 0)
{
if ($timestamp)
return date("Y-m-d H:i:s", $timestamp);
else
  $idcookie = $_COOKIE['uid'];
  return gmdate("Y-m-d H:i:s", time());
}
$mid = "".getuserid($btuser)."";
$msid = "".getusername($btuser)."";

        $sql = "SELECT uploaded, downloaded, uploaded/downloaded AS ratio FROM ".$db_prefix."_users WHERE id = '".$user->id."';";
        $res = $db->sql_query($sql);
        list ($uploaded, $downloaded, $ratio) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);

OpenTable("BlackJack");
/////////////////////Test if casino is enabled////////////////////////////
$sql = ("SELECT * FROM ".$db_prefix."_casino_config") ;
$res = $db->sql_query($sql) or btsqlerror($sql);
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];
if (!$arr_config["enable"])bterror("Casino is Closed, try later...",_btsorry);
//////////////////////////////////////////////////////////////////////////
if(!checkaccess("black_jack")){
OpenErrTable(_btaccdenied);
echo "<p>".str_replace("**page**","Black Jack",_btnoautherized)."</p>\n";
CloseErrTable();
die();
}
$mb_basic=1024*1024;
$max_download_user = $mb_basic*1024*500; //// 25 GB
$max_download_global = $mb_basic*$mb_basic*2.5; //// 2.5 TB :-)
$max_trys = $arr_config['maxtrys']; ///How many times player can play

//////////////////This is the funny part///////////////////////
$user_everytimewin_mb = $mb_basic * 70; ////// means users that wins under 70 mb get a cheat_value of 0 -> win every time
$cheat_value = $arr_config['cheat_value']; // higher value -> less winner 
$cheat_breakpoint = $arr_config['cheat_breakpoint']; ////very important value -> if (win MB > max_download_global/cheat_breakpoint)
$cheat_value_max = $arr_config['cheat_value_max']; ////// then cheat_value = cheat_value_max -->> i hope you know what i mean. ps: must be higher as cheat_value.
$cheat_ratio_user = $arr_config['cheat_ratio_user']; ///if casino_ratio_user > cheat_ratio_user -> $cheat_value = rand($cheat_value,$cheat_value_max)
$cheat_ratio_global = $arr_config['cheat_ratio_global']; /// same as user just global

////////////////////NOUVELLE VERIF DES CLASSES/////////////////////////////
///////////////////////////////////////////////////////////////////

$mb = 1024*1024*100;//bet size
if(!$_POST)$_POST = $_REQUEST;
if ($_POST["game"]){
$cardcountres = $db->sql_query("select count(id) from ".$db_prefix."_cards") or die("arghh1");
$cardcountarr = $db->sql_fetchrow($cardcountres);
$cardcount = $cardcountarr[0];
if ($_POST["game"] == 'start'){

if($uploaded < $mb)
bterror("You haven't uploaded ".mksize($mb), _btsorry." ".$user->name);
if ($downloaded > 0)
  $ratio = number_format($uploaded / $downloaded, 2);
else
  if ($uploaded > 0)
    $ratio = 999;
  else
    $ratio = 0;
/////////////////////////////////////Nouvelle Verif ratio///////////////////////
$required_ratio = $arr_config['ratio_mini'];
   if($ratio < $required_ratio){
  OpenTable(_bterror);
print("
<table class=main width=100% cellspacing=0 cellpadding=5>
<tr>
<td align=center><font color=red><b>".str_replace(array("**user**", "**userratio**"),array($user->name, $required_ratio),_btblj_wratio)."</b></font></td>
</tr>
<tr>
<td align=center><a href=games.php>"._btdgobackto."</a></td>
</tr>
</table>");
CloseTable();

die;
}
////////////////////////////////////////////////////////////////////////////////

////////////////////////TEST VERIFS COMME CASINO////////////////////////
$query ="select * from ".$db_prefix."_casino where userid = '".getuserid($btuser)."'";
$result = $db->sql_query($query) or die("arghh2");
if($db->sql_affectedrows()!=1)
{
 $db->sql_query("INSERT INTO ".$db_prefix."_casino (userid, win, lost, trys, date) VALUES(".getuserid($btuser).",0,0,0, '" . get_date_time() . "')") or die("arghh66");
 $result = $db->sql_query($query); ///query another time to get the new user, if the bterror is uncomment
}

$row = $db->sql_fetchrow($result);
 $user_win = $row["win"];
 $user_lost = $row["lost"];
 $user_trys = $row["trys"];
 $user_date = $row["date"];
 $user_deposit = $row["deposit"];
 $user_enableplay = $row["enableplay"];

if($user_enableplay=="no")
 bterror(_btsorry.getusername($btuser),_btblj_banned); 

if($user_trys > $max_trys)
 bterror(str_replace("**maxtry**",$max_trys,_btblj_play_tover),_btsorry." ".getusername($btuser));
 
if(($user_win - $user_lost) > $max_download_user)
 bterror(_btblj_max_download_passed,_btsorry." ".getusername($btuser));

 if ($downloaded > 0)
   $ratio = number_format($uploaded / $downloaded, 2);
 else
   if ($uploaded > 0)
     $ratio = 999;
   else
     $ratio = 0;
 $global_down2 =  $db->sql_query(" select (sum(win)-sum(lost)) as globaldown,(sum(deposit)) as globaldeposit, sum(win) as win, sum(lost) as lost from ".$db_prefix."_casino") or die("arghh4");
 $row = $db->sql_fetchrow($global_down2);
 $global_down = $row["globaldown"];
 $global_win = $row["win"];
 $global_lost = $row["lost"];
 $global_deposit = $row["globaldeposit"];
 
 if ($user_win > 0)
   $casino_ratio_user = number_format($user_lost / $user_win, 2);
 else
   if ($user_lost > 0)
     $casino_ratio_user = 999;
   else
     $casino_ratio_user = 0.00;
     
 if ($global_win > 0)
   $casino_ratio_global = number_format($global_lost / $global_win, 2);
 else
   if ($global_lost > 0)
     $casino_ratio_global = 999;
   else
     $casino_ratio_global = 0.00;
 
 //get users that bet the first time or win very less :-)
 if($user_win < $user_everytimewin_mb)
  $cheat_value = 0;
 else
 {
  //i think this is a god idea GLOBAL
  if($global_down > ($max_download_global / $cheat_breakpoint))
   $cheat_value = $cheat_value_max;
  if($casino_ratio_global < $cheat_ratio_global)
   $cheat_value = rand($cheat_value,$cheat_value_max);
  
  //i think this is a god idea for EACH USER
  if(($user_win - $user_lost) > ($max_download_user / $cheat_breakpoint))
   $cheat_value = $cheat_value_max;
  if($casino_ratio_user < $cheat_ratio_user)
   $cheat_value = rand($cheat_value,$cheat_value_max);
 } 
 
if($global_down > $max_download_global)
 bterror(_btblj_max_profit.mksize($max_download_global),_btsorry." ".$user->name);


////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
$res = $db->sql_query("select count(*) from ".$db_prefix."_blackjack where userid=$mid and status='waiting'");
$arr = $db->sql_fetchrow($res);
if ($arr[0] > 0) {
bterror(_btblj_wait_next_player,_btsorry." ".getusername($btuser));
include("footer.php");
}else{
$res = $db->sql_query("select count(*) from ".$db_prefix."_blackjack where userid=$mid and status='playing'");
$arr = $db->sql_fetchrow($res);
if ($arr[0] > 0)
bterror(_btblj_open_game,_btsorry." ".getusername($btuser));}
$cardid = rand(1,$cardcount);
$cardres = $db->sql_query("select * from ".$db_prefix."_cards where id=$cardid") or die("arghh5");
$cardarr = $db->sql_fetchrow($cardres);
$db->sql_query("insert into ".$db_prefix."_blackjack (userid, points, cards) values ('".$mid."', $cardarr[points], $cardid)") or die("arghh67");
OpenTable(_btblj_tittle);
print("<table width=100% cellspacing=0 cellpadding=0 background=casino/blakjack.jpg>");
print("<tr><td>");
print("<div align=center>");
?><table bgcolor="#FFFFFF" align="center" width="50%" border="1">
  <tr>
    <td><font color="#009900"><h2><center><?php print(_btwelcome." <a href=user.php?op=profile&id=$mid>$msid"); ?></a>!</center></h2></font></td>
  </tr>
</table>
<br/>
<?php
print("<table  cellspacing=0 cellpadding=3 width=600>\n");
print("<tr><td colspan=2 cellspacing=0 cellpadding=5 >");
print("<form name=blackjack method=post action=$phpself>");
print("<table class=message width=100% cellspacing=0 cellpadding=5 bgcolor=white>\n");
print("<tr><td align=center><img src=casino/cards/".$cardarr["pic"]." border=0></td></tr>");
print("<tr><td align=center><b>"._btblj_points." = $cardarr[points]</b></td></tr>");
print("<tr><td align=center><input type=hidden name=game value=cont><input type=submit value='"._btblj_anothercard."'></td></tr>");
print("</table><br>");
print("</form>");
print("</table><br>");
print("</td></tr></table><br>");
print("</div>");
print("</td></tr></table><br>");
CloseTable();
}
elseif ($_POST["game"] == 'cont'){

$playeres = $db->sql_query("select * from ".$db_prefix."_blackjack where userid=$mid") or die("arghh68");
$playerarr = $db->sql_fetchrow($playeres);
$showcards = "";
$cards = $playerarr["cards"];
$usedcards = explode(" ", $cards);
$arr = array();
foreach($usedcards as $array_list)
$arr[] = $array_list;
foreach($arr as $card_id)
{
$used_card = $db->sql_query("SELECT * FROM ".$db_prefix."_cards WHERE id='$card_id'") or die("arghh69");
$used_cards = $db->sql_fetchrow($used_card);
$showcards .= "<img src=casino/cards/".$used_cards["pic"]." border=0> "; 
$i++;
}
$cardid = rand(1,$cardcount);
while (in_array($cardid, $arr))
{
$cardid = rand(1,$cardcount);
}
$cardres = $db->sql_query("select * from ".$db_prefix."_cards where id=$cardid") or die("arghh70");
$cardarr = $db->sql_fetchrow($cardres);
$showcards .= "<img src=casino/cards/".$cardarr["pic"]." border=0> ";
$points = $playerarr["points"] + $cardarr["points"];
$mysqlcards = "$playerarr[cards] $cardid";
$db->sql_query("update ".$db_prefix."_blackjack set points=points+$cardarr[points], cards='$mysqlcards' where userid=$mid") or die("arghh10");
if ($points == 21){
$waitres = $db->sql_query("select count(*) from ".$db_prefix."_blackjack where status='waiting'");
$waitarr = $db->sql_fetchrow($waitres);
if ($waitarr[0] > 0){
$r = $db->sql_query("select * from ".$db_prefix."_blackjack where status='waiting' order by date asc LIMIT 1");
$a = $db->sql_fetchrow($r);
if ($a["points"] != 21){
$winorlose = _btblj_you_won.mksize($mb);
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded + $mb where id=$mid") or die("arghh11");
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded - $mb where id=$a[userid]") or die("arghh12");
//////////Updater le casino////////////////////////
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$mb." WHERE userid= $mid") or die("arghh13");
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1 ,lost = lost + ".$mb." WHERE userid= $mid") or die("arghh14");
/////////FIN UPDATER LE CASINO/////////////////////
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$mid");
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$a[userid]");
$msg = str_replace(array("**lost**","**opon**","**youpoint**"),array(mksize($mb),$msid,$a[points]),_btblj_you_lost_points);
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh15"); 
}else{
$winorlose = _btblj_no_winner;
}
bterror(str_replace(array("**opon**","**points**","**winner**"),array(username_is($a["userid"]),$a[points],$winorlose),_btblj_who_won),_btblj_over);
}
else{
$db->sql_query("update ".$db_prefix."_blackjack set status = 'waiting', date='".get_date_time()."' where userid = $mid") or die("arghh16");
bterror(_btblj_you_21,_btblj_over);
}
}
elseif ($points > 21) {
$waitres = $db->sql_query("select count(*) from ".$db_prefix."_blackjack where status='waiting'");
$waitarr = $db->sql_fetchrow($waitres);
if ($waitarr[0] > 0){
$r = $db->sql_query("select * from ".$db_prefix."_blackjack where status='waiting' order by date asc LIMIT 1");
$a = $db->sql_fetchrow($r);
if ($a["points"] == $points){
$winorlose = _btblj_no_winner;
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$mid");
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$a[userid]");
$msg = str_replace("**opon**",$msid,_btblj_no_winner2);
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh17");}
elseif ($a["points"] > $points){
$winorlose = _btblj_you_won_points.mksize($mb);
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded + $mb where id=$mid") or die("arghh18");
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded - $mb where id=$a[userid]") or die("arghh19");
//////////Updater le casino////////////////////////
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$mb." WHERE userid=$mid") or die("arghh20");
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1 ,lost = lost + ".$mb." WHERE userid=$mid") or die("arghh21");
/////////FIN UPDATER LE CASINO/////////////////////
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$mid");
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$a[userid]");
$msg = str_replace(array("**lost**","**opon**","**youpoint**"),array(mksize($mb),$msid,$a[points]),_btblj_you_lost_points);
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh22");
}
elseif ($a["points"] < $points){
$winorlose = _btblj_you_lost.mksize($mb);
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded - $mb where id=$mid") or die("arghh23");
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded + $mb where id=$a[userid]") or die("arghh24");
//////////Updater le casino////////////////////////
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$mb." WHERE userid=$mid") or die("arghh25");
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1 ,lost = lost + ".$mb." WHERE userid=$mid") or die("arghh26");
/////////FIN UPDATER LE CASINO/////////////////////
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$mid");
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$a[userid]");
$msg = "You won ".mksize($mb)." of $msid (You have $a[points] points, $msid had $points points) <a href=blackjack.php>Play Again</a> ";
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh27");
}
bterror(str_replace(array("**ypoint**","**opon**","**tpoint**","**won**"),array($points,username_is($a["userid"]),$a[points],$winorlose),_btblj_who_won),_btblj_over);
}
else
{
$db->sql_query("update ".$db_prefix."_blackjack set status = 'waiting', date='".get_date_time()."' where userid = $mid") or die("arghh28");
bterror(str_replace("**points**",$points,_btblj_points_wait),_btblj_over);
}
}

else{
OpenTable(_btblj_tittle);
print("<table width=100% cellspacing=0 cellpadding=0 background=casino/blakjack.jpg>");
print("<tr><td>");
print("<div align=center>");
?><table bgcolor="#FFFFFF" align="center" width="50%" border="1">
  <tr>
    <td><font color="#009900"><h2><center><?php print(_btwelcome.", <a href=user.php?op=profile&id=$mid>$msid"); ?></a>!</center></h2></font></td>
  </tr>
</table>
<br/>
<?php
print("<table  cellspacing=0 cellpadding=3 width=600 border=1>\n");
print("<tr><td colspan=2 cellspacing=0 cellpadding=5 >");
print("<table class=message width=100% cellspacing=0 cellpadding=5 bgcolor=white>\n");
print("<tr><td align=center>$showcards</td></tr>");
print("<tr><td align=center><p style=\"color:#000033\"><b>"._btblj_points." = $points</b></p></td></tr>");
print("<form name=blackjack method=post action=$phpself>");
print("<tr><td align=center><input type=hidden name=game value=cont><input type=submit value='"._btblj_anothercard."'></td></tr>");
print("</form>");
print("<form name=blackjack method=post action=$phpself>");
print("<tr><td align=center><input type=hidden name=game value=stop><input type=submit value='"._btblj_stand."'></td></tr>");
print("</form>");
print("</table><br>");
print("</td></tr></table><br>");
print("</div>");
print("</td></tr></table><br>");
CloseTable();

}
}elseif ($_POST["game"] == 'stop')
{

$playeres = $db->sql_query("select * from ".$db_prefix."_blackjack where userid=$mid") or die("arghh29");
$playerarr = $db->sql_fetchrow($playeres);
$waitres = $db->sql_query("select count(*) from ".$db_prefix."_blackjack where status='waiting' AND userid NOT '".$user->id."'");
$waitarr = $db->sql_fetchrow($waitres);
if ($waitarr[0] > 0){
$r = $db->sql_query("select * from ".$db_prefix."_blackjack where status='waiting' order by date asc LIMIT 1");
$a = $db->sql_fetchrow($r);
if ($a["points"] == $playerarr[points]){
$winorlose = _btblj_no_winner;
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$mid");
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$a[userid]");
$msg = str_replace("**opon**",$msid,_btblj_no_winner2);
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh30");}
elseif ($a["points"] < $playerarr[points] && $a[points] < 21){
$winorlose = _btblj_you_won_points.mksize($mb);
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded + $mb where id=$mid") or die("arghh31");
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded - $mb where id=$a[userid]") or die("arghh32");
//////////Updater le casino////////////////////////
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$mb." WHERE userid=$mid") or die("arghh33");
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1 ,lost = lost + ".$mb." WHERE userid=".$a["userid"]) or die("arghh34");
/////////FIN UPDATER LE CASINO/////////////////////
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$mid");
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$a[userid]");
$msg = str_replace(array("**lost**","**opon**","**youpoint**","**oppoint**"),array(mksize($mb),$msid,$a[points],$playerarr[points]),_btblj_you_lost_points2);
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh35");
}
elseif ($a["points"] > $playerarr[points] && $a[points] < 21){
$winorlose = _btblj_you_lost.mksize($mb);
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded - $mb where id=$mid") or die("arghh36");
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded + $mb where id=$a[userid]") or die("arghh37");
//////////Updater le casino////////////////////////
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$mb." WHERE userid=".$a["userid"]) or die("arghh38");
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1 ,lost = lost + ".$mb." WHERE userid=$mid") or die("arghh39");
/////////FIN UPDATER LE CASINO/////////////////////
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$mid");
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$a[userid]");
$msg = str_replace(array("**won**","**opon**","**youpoint**","**oppoint**"),array(mksize($mb),$msid,$a[points],$playerarr[points]),_btblj_you_win);
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh40");
}
elseif ($a["points"] == 21){
$winorlose = _btblj_you_lost.mksize($mb);
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded - $mb where id=$mid") or die("arghh41");
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded + $mb where id=$a[userid]") or die("arghh42");
//////////Updater le casino////////////////////////
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$mb." WHERE userid=".$a["userid"]) or die("arghh43");
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1 ,lost = lost + ".$mb." WHERE userid=$mid") or die("arghh44");
/////////FIN UPDATER LE CASINO/////////////////////
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$mid");
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$a[userid]");
$msg = str_replace(array("**won**","**opon**","**youpoint**","**oppoint**"),array(mksize($mb),$msid,$a[points],$playerarr[points]),_btblj_you_win);
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh45");
}
elseif ($a["points"] < $playerarr[points] && $a[points] > 21){
$winorlose = _btblj_you_lost.mksize($mb);
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded - $mb where id=$mid") or die("arghh46");
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded + $mb where id=$a[userid]") or die("arghh47");
//////////Updater le casino////////////////////////
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$mb." WHERE userid=".$a["userid"]) or die("arghh48");
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1 ,lost = lost + ".$mb." WHERE userid=$mid") or die("arghh49");
/////////FIN UPDATER LE CASINO/////////////////////
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$mid");
$db->sql_query("delete from ".$db_prefix."_blackjack where userid=$a[userid]");
$msg = str_replace(array("**won**","**opon**","**youpoint**","**oppoint**"),array(mksize($mb),$msid,$a[points],$playerarr[points]),_btblj_you_win);
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh50");
}
elseif ($a["points"] > $playerarr[points] && $a[points] > 21){
$winorlose = _btblj_you_won_points.mksize($mb);
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded + $mb where id=$mid") or die("arghh51");
$db->sql_query("update ".$db_prefix."_users set uploaded = uploaded - $mb where id=$a[userid]") or die("arghh52");
//////////Updater le casino////////////////////////
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$mb." WHERE userid=$mid") or die("arghh53");
$db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1 ,lost = lost + ".$mb." WHERE userid=".$a["userid"]) or die("arghh54");
/////////FIN UPDATER LE CASINO/////////////////////
$db->sql_query("delete from blackjack where userid=$mid");
$db->sql_query("delete from blackjack where userid=$a[userid]");
$msg = str_replace(array("**lost**","**opon**","**youpoint**","**oppoint**"),array(mksize($mb),$msid,$a[points],$playerarr[points]),_btblj_you_lost_points2);
$db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES('".$user->id."', '".$a['userid']."', 'BLACKJACK', '".$msg."', NOW())") or die("arghh55");
}
bterror(str_replace(array("**ypoint**","**opon**","**tpoint**","**winner**"),array($playerarr[points],username_is($a["userid"]),$a[points],$winorlose),_btblj_who_won),_btblj_over);
}
else
{
$db->sql_query("update ".$db_prefix."_blackjack set status = 'waiting', date='".get_date_time()."' where userid = $mid") or die("arghh65");
bterror(str_replace("**points**",$playerarr[points],_btblj_points_wait),_btblj_over);
}
}
}
else
{
OpenTable(_btblj_tittle);
print("<div align=center>");
print("<h1>BlackJack</h1>\n");
print("<table  cellspacing=0 cellpadding=3 width=400 border=1>\n");
print("<tr><td colspan=2 cellspacing=0 cellpadding=5 align=center>");
print("<table  width=100% cellspacing=0 cellpadding=10 bgcolor=white>\n");
print("<tr><td align=left>"._btblj_rule."</td></tr>");
print("</table><br>");
print("<form name=form method=post action=$phpself>
<input type=hidden name=game value=start>
<input type=submit class=btn value='"._btblj_start_game."'>");
print("</td></tr></table>");
print("</div>");
CloseTable();
include("footer.php");
}
?>