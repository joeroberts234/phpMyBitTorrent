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
if (!eregi("casino.php",$_SERVER["PHP_SELF"])) die("You cannot include this file.");
include("header.php");
global $db, $db_prefix;
OpenTable(_btco_);
function get_date_time($timestamp = 0)
{
if ($timestamp)
return date("Y-m-d H:i:s", $timestamp);
else
  $idcookie = $_COOKIE['uid'];
  return gmdate("Y-m-d H:i:s", time());
}

function tr($x,$y,$noesc=0) {
    if ($noesc)
        $a = $y;
    else {
        $a = htmlspecialchars($y);
        $a = str_replace("\n", "<br />\n", $a);
    }
    print("<tr><td class=casino  valign=\"top\" align=\"left\">$x</td><td class=casino  valign=\"top\" align=right>$a</td></tr>\n");
}


function tr2()
{
$a = func_get_args(tr2);
for($i=0;$i< (func_num_args(tr2)/2)+1;$i++)
 $row .= "<td ".$a[$i].">".$a[++$i]."</td>";
echo "<tr>".$row."</tr>";
}

if(!checkaccess("casino")){
OpenErrTable(_btaccdenied);
echo "<p>".str_replace("**page**","Casino",_btnoautherized)."</p>\n";
CloseErrTable();
die();
}
///////////////////////////////////////////////////////////////////////////////
//////////////////////////////////Casino Config////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
$dummy = '';
/////////////////////Test if casino is enabled////////////////////////////
$sql = ("SELECT * FROM ".$db_prefix."_casino_config") ;
$res = $db->sql_query($sql) or btsqlerror($sql);
while ($arr = $db->sql_fetchrow($res))
$arr_config[$arr['name']] = $arr['value'];
if (!$arr_config["enable"])bterror("Casino is Closed, try later...","Sorry");
//////////////////////////////////////////////////////////////////////////
$access_level = $arr_config["class_allowed"];
switch ($access_level) {
        case "user": {
                if (!$user->user) loginrequired("user");
                break;
        }
        case "premium": {
                if (!$user->premium) loginrequired("premium");
                break;
        }
        case "moderator": {
                if (!$user->moderator) loginrequired("moderator");
                break;
        }
        case "admin": {
                if (!$user->admin) loginrequired("admin");
                break;
        }
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
$win_amount = $arr_config['win_amount']; // how much do the player win in the first game eg. bet 300, win_amount=3 ---->>> 300*3= 900 win
$win_amount_on_number = $arr_config['win_amount_on_number']; // same as win_amount for the number game
$show_real_chance = false; ///shows the user the real chance true or false
$bet_value1 = $mb_basic * 20; ///this is in MB but you can also choose gb or tb :-)
$bet_value2 = $mb_basic * 50;
$bet_value3 = $mb_basic * 100;
$bet_value4 = $mb_basic * 250;
$bet_value5 = $mb_basic * 500;
$bet_value6 = $mb_basic * 1024;
$bet_value7 = $mb_basic * 2048;
//////////////////End of Funny Part///////////////////////////////


///////////////config game 3////////////////////
$maxusrbet = $arr_config['maxusrbet'];    //Amount of bets to allow per person
$maxtotbet = $arr_config['maxtotbet'];    //Amount of total open bets allowed
$alwdebt = 'n';     //Allow users to get into debt
$delold='y';     //Clear bets once finished? (cleanup.php will if value isn't 'y')
$sendfrom = $user->id;     //The id of the user which notification PM's are noted as sent from
$casino=$HTTP_SERVER_VARS['PHP_SELF'];    //Name of file
//////////////End of Config//////////////////////

////////////////////NOUVELLE VERIF DES CLASSES/////////////////////////////
///////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
        $sql = "SELECT uploaded, downloaded, uploaded/downloaded AS ratio FROM ".$db_prefix."_users WHERE id = '".$user->id."';";
        $res = $db->sql_query($sql);
        list ($uploaded, $downloaded, $ratio) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$query ="select * from ".$db_prefix."_casino where userid = '".getuserid($btuser)."';";
$result = $db->sql_query($query) or die (mysql_error());
if($db->sql_affectedrows()!=1)
{
 $db->sql_query("INSERT INTO ".$db_prefix."_casino (userid, win, lost, trys, date) VALUES(" .getuserid($btuser). ",0,0,0, '" . get_date_time() . "')") or mysql_error();
 //bterror("This is the first time you try to play at the Casino please refresh the site","Hi ".$user->name);
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
 
/*if(($user_win - $user_lost) > $max_download_user)
 bterror("Sorry ".getusername($btuser)."you have reached the max download for a single user.");*/

   
/////////////////////////////////////Nouvelle Verif ratio///////////////////////
$miniratio = $arr_config['ratio_mini'];
  if($ratio < $miniratio){
  
  OpenTable("ERROR");
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
 $sql = (" select (sum(win)-sum(lost)) as globaldown,(sum(deposit)) as globaldeposit, sum(win) as win, sum(lost) as lost from ".$db_prefix."_casino") or die (mysql_error());
$global_down2 = $db->sql_query($sql) or btsqlerror($sql);
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
 bterror(_btco_maxwin.mksize($max_download_global),_btsorry." ".getusername($btuser));


////////////////////////////////////////////////////////////////////////////////////////////////

if((($_POST["color"]=="red"||$_POST["color"]=="black")||($_POST["number"]=="1"||$_POST["number"]=="2"||$_POST["number"]=="3"||$_POST["number"]=="4"||$_POST["number"]=="5"||$_POST["number"]=="6"))&&($_POST["betmb"]==$bet_value1||$_POST["betmb"]==$bet_value2||$_POST["betmb"]==$bet_value3||$_POST["betmb"]==$bet_value4||$_POST["betmb"]==$bet_value5||$_POST["betmb"]==$bet_value6||$_POST["betmb"]==$bet_value7))   
{  
if($_POST["number"])
{
 $win_amount = $win_amount_on_number;
 $cheat_value = $cheat_value+5;
 $winner_was = $_POST["number"];
}
else
 $winner_was = $_POST["color"];

 $win = $win_amount*$betmb;

 if ($uploaded < $betmb)
 bterror(str_replace(array("**username**","**upload**"),array(getusername($btuser),mksize($betmb)),_btco_upload_low),_btsorry." ".getusername($btuser));
 bterror("Sorry ".getusername($btuser)."you don't have uploaded ".mksize($betmb));


 

if(rand(0,$cheat_value)==$cheat_value)
{
 OpenTable(_btco_win);
 echo str_replace(array("**wincolor**","**user**","**winning**"),array($winner_was,getusername($btuser),mksize($win)),_btco_win_exp);
 echo "<h3 align=center><a href=\"casino.php\">Back to Casino</a></h3><br/>";
 CloseTable();
 $db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = uploaded + ".$win." WHERE id=".getuserid($btuser)) or sqlerr();
 $db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$win." WHERE userid=".getuserid($btuser)) or sqlerr();
}
else
{
 if($_POST["number"])
 {
  do
  {
   $fake_winner = rand(1,6);
  }
  while($_POST["number"]==$fake_winner);
 }
 else
 {
  if($_POST["color"]=="black")
   $fake_winner= "red";
  else
   $fake_winner= "black";
 }
 OpenTable(_btco_loose);
 echo str_replace(array("**facwincolor**","**wincolor**","**user**","**loose**"),array($fake_winner,$winner_was,getusername($btuser),mksize($win)),_btco_loose_exp);
 echo "<h3 align=center><a href=\"casino.php\">Back to Casino</a></h3><br/>";
 CloseTable();
 $db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = uploaded - ".$betmb." WHERE id=".getuserid($btuser)) or sqlerr();
 $db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1 ,lost = lost + ".$betmb." WHERE userid=".getuserid($btuser)) or sqlerr();
}
  
}
else
{
///////////////////////////////////////GAME 3//////////////////////////////////// 

//////////Notice game 3 is NOT counted with the trys in casino!!!///////////////

//get user stats
$betsp = $db->sql_query("SELECT challenged FROM ".$db_prefix."_casino_bets WHERE proposed = '".getusername($btuser)."'");
$openbet = 0;
while($tbet2 =  $db->sql_fetchrow($betsp))
{
if($tbet2[challenged]=='empty')
 $openbet++;
}

//Convert bet amount into bits

if(isset($_POST['unit'])){
if ($_POST["unit"] =='1')
 $nobits = $amnt*$mb_basic;
else
 $nobits = $amnt*$mb_basic*1024;
}

$ratio2 = number_format($uploaded/$downloaded);

if(mksize($downloaded) ==0|| mksize($uploaded)==0)
$ratio='0';
else
$ratio = number_format($uploaded/$downloaded);

$time = strtotime("now");
$time = date('Y-n-j G:i:s',$time);
$goback = "<a href=$casino>"._btgoback1."</a>";
/////////////////////////GAME 1/////////////////////////////////
//Take Bet

if (isset($_GET["takebet"]))
{
$betid=$_GET["takebet"];
$random = rand(0,1);
$loc = $db->sql_query("SELECT * FROM ".$db_prefix."_casino_bets WHERE id = '".$betid."'")or print(mysql_error());
$tbet=  $db->sql_fetchrow($loc);
$nogb = mksize($tbet[amount]);

if($user->id == $tbet['userid'])
 bterror("want to bet yourself?&nbsp;&nbsp;&nbsp;$goback", "Sorry");
elseif($tbet['challenged']!="empty")
 bterror("Someone has already taken that bet!&nbsp;&nbsp;&nbsp;$goback", "Sorry");

if($uploaded < $tbet['amount'])
{
 $debt = $tbet['amount']-$uploaded;
 $newup = $uploaded-$debt;
}

if(isset($debt) && $alwdebt !='y')
 bterror("<h2>You are ".mksize(($nobits-mksize($uploaded)))." short of making that bet!</h2>&nbsp;&nbsp;&nbsp;$goback", "Sorry");

if($random==1)
{

 $db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = uploaded+".$tbet['amount']." WHERE id = '".getuserid($btuser)."'") or print(mysql_error());
 /////////////////////Casino Stats//////////////////////////////////
 $db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, lost = lost + ".$tbet['amount']." WHERE userid='".$tbet['userid']."'") or print(mysql_error()); //NEW
 $db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$tbet['amount']." WHERE userid='".getuserid($btuser)."'") or print(mysql_error()); //NEW
 ///////////////////////////////////////////////////////////////////
 $db->sql_query("UPDATE ".$db_prefix."_casino SET deposit = deposit-".$tbet['amount']." WHERE userid = '".$tbet['userid']."'") or print(mysql_error());
 if($db->sql_affectedrows()==0)
  $db->sql_query("INSERT INTO ".$db_prefix."_casino (userid, date, deposit) VALUES (".$tbet['userid'].", '$time', '-".$tbet['amount']."')") or print(mysql_error());
 
 $db->sql_query("UPDATE ".$db_prefix."_casino_bets SET challenged = '".getusername($btuser)."'  WHERE id = $betid") or print(mysql_error());
 $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('$sendfrom', '".$tbet['userid']."', 'CASINO BET','You lost a bet! ".$user->name." just won $nogb of your upload credit!' , NOW())") or print(mysql_error());

OpenTable("WINNER!!!!!!!!!!!");
echo("<h3>You got it</h3>, <h3>You won the bet, $nogb has been creditied to your account, at <a href=account-details.php?id=$tbet[userid]>$tbet[proposed]'s</a> !</h3>&nbsp;&nbsp;&nbsp;$goback");
 CloseTable();
 
 if($delold=='y')
  $db->sql_query("DELETE  FROM ".$db_prefix."_casino_bets WHERE id = $tbet[id]") or print(mysql_error());
}
else
{
 if(empty($newup))
  $newup = $uploaded - $tbet['amount'];
 $newup2 = $tbet['amount']*2;
 
 $db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = $newup WHERE id = '".getuserid($btuser)."'") or print(mysql_error());
 $db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = uploaded + $newup2 WHERE id = '".$tbet['userid']."'") or print(mysql_error());
 ////////////////////////////Casino Stats////////////////////////////////////
 $db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, win = win + ".$tbet['amount']." WHERE userid='".$tbet['userid']."'") or print(mysql_error()); //NEW
 $db->sql_query("UPDATE ".$db_prefix."_casino SET date = '".get_date_time()."', trys = trys + 1, lost = lost + ".$tbet['amount']." WHERE userid='".getuserid($btuser)."'") or print(mysql_error()); //NEW
 ////////////////////////////////////////////////////////////////////////////
 $db->sql_query("UPDATE ".$db_prefix."_casino SET deposit = deposit-".$tbet['amount']." WHERE userid = '".$tbet['userid']."'")or print(mysql_error());
 if($db->sql_affectedrows()==0)
  $db->sql_query("INSERT INTO ".$db_prefix."_casino (userid, date, deposit) VALUES (".$tbet['userid'].", '$time', '-".$tbet['amount']."')") or print(mysql_error());
  $db->sql_query("UPDATE ".$db_prefix."_casino_bets SET challenged = '".getusername($btuser)."' WHERE id = $betid") or print(mysql_error());
  $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('" . $user->id . "', '" . $tbet['userid'] . "', 'CASINO BET', 'You just won $nogb of upload credit from ".$user->name."!', NOW())") or print(mysql_error());
 //if($writelog=='y')
  //write_log("$tbet[proposed] gagne $nogb de crédits d'upload de ".getusername($btuser));

OpenTable("LOOSER!!!!!!!!!!!");
echo("<h3>Damn it</h3>, <h3>You lost the bet, <a href=user.php?op=profile&id=$tbet[userid]>$tbet[proposed]</a> has won $nogb of your hard earnt upload credit!</h3> &nbsp;&nbsp;&nbsp;$goback");
CloseTable();
  
 if($delold=='y')
  $db->sql_query("DELETE  FROM ".$db_prefix."_casino_bets WHERE id = $tbet[id]") or sqlerr();
 }

exit(); //// the user should not reach this code but for security :-)
}

//Add a new bet
$loca = $db->sql_query("SELECT * FROM ".$db_prefix."_casino_bets WHERE challenged ='empty'") or sqlerr();
$totbets = $db->sql_numrows($loca);

if (isset($_POST["unit"]))
{
if($openbet >= $maxusrbet)
bterror ("There are already $openbet bets open, take an open bet and don´t *tsk tsk... bad language!* with the system!", "Sorry");
if($nobits==0)
bterror ("If you win a amount of 0, zero, nada, niente or nichts you are very unhappy. so please don´t add bets without a win!", "Sorry");
if($nobits < 0)
bterror ("Sorry","Don't try to cheat the system, or I ban you right now!");
$newup = $uploaded - $nobits;
$debt  = $nobits-$uploaded;
if($uploaded < $nobits)
{
 if($alwdebt!='y')
  bterror("<h2>Thats ".mksize($debt)." more than you got!</h2>$goback", "Sorry");
}
$betsp = $db->sql_query("SELECT id, amount FROM ".$db_prefix."_casino_bets WHERE userid = ".getuserid($btuser)." ORDER BY time ASC") or sqlerr();
$tbet2 = $db->sql_fetchrow($betsp);


$dummy = "<table bgcolor=#FFFFFF width=60% cellspacing=0 cellpadding=3 border=1><tr><td><H3>Bet added, you will receive a PM notifying you of the results when someone has taken it</H3></td></tr></table>";
$db->sql_query("INSERT INTO ".$db_prefix."_casino_bets ( userid, proposed, challenged, amount, time) VALUES ('".getuserid($btuser)."','".getusername($btuser)."', 'empty', '$nobits', '$time')") or sqlerr();
$db->sql_query("UPDATE ".$db_prefix."_users SET uploaded = $newup  WHERE id = ".getuserid($btuser)) or sqlerr();
$db->sql_query("UPDATE ".$db_prefix."_casino SET deposit = deposit + $nobits WHERE userid = ".getuserid($btuser)) or sqlerr();
if($db->sql_affectedrows()==0)
 $db->sql_query("INSERT INTO ".$db_prefix."_casino (userid, date, deposit) VALUES (".getuserid($btuser).", '$time', '".$nobits."')") or sqlerr(); 
}
$loca = $db->sql_query("SELECT * FROM ".$db_prefix."_casino_bets WHERE challenged ='empty'");
$totbets = $db->sql_numrows($loca);
////////////////////////////////////////////////standard html begin

OpenTable(_btco_);
print("<table width=100% cellspacing=0 cellpadding=0 background=casino/dados2.jpg>");
print("<tr><td>");
print("<tr><td>");
print("<br/>");
?><table bgcolor="#FFFFFF" align="center" width="50%" border="1">
  <tr>
    <td><font class="casinotext"><h2><center>Bet P2P with other users</center></h2></font></td>
  </tr>
</table>
<br/>
<?php
print("<center>");
print("<table class=message width=650 cellspacing=0 cellpadding=5>\n");
print("<tr><td class=casino  align=center >");
echo($dummy);

//Place bet table

if ($openbet < $maxusrbet)
{
if($totbets >= $maxtotbet)
 echo "<br>are already $maxtotbet bets open, take an open bet!<br>";
else
{
 echo "<br><table bgcolor=#FFFFFF width=60% cellspacing=0 cellpadding=3 border=1>";
 tr2('class=casino align=center colspan=2 ','<font class="casinotext"><h2><b>Place bet</b></h2></font>');
 tr2('class=casino align=center','<b>Amount to bet</b>',
  'align=center','<form name=p2p method=post action='.$phpself.'><input type=text name=amnt size=20 value=1>
  <select name=unit>
  <option value=1>MB</option>
  <option value=2>GB</option>
     </select>');
 tr2('class=casino align=center colspan=2','<input type=submit value=Gamble!>');
 echo"</table></form>";
}
}
//else
//echo "<br><table bgcolor=#FFFFFF width=60% cellspacing=0 cellpadding=3 border=1>";
//print"<td class=casino  align=center colspan=2 class=colhead>You already have $maxusrbet open bets, wait until they are completed before you start another.</td>";
//echo"</table>";

///Open Bets table
echo ("<table bgcolor=\"#FFFFFF\" width=\"90%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\"><br>");
tr2('class=casino align=center  colspan=4','<font class="casinotext"><h2><b>Open Bets</b></h2></font>');
echo("<tr>");
echo("<td class=casino  align=center width=15%><b>Name</b></td><td class=casino  width=15% align=center><b>Amount</b></td>");
echo("<td class=casino  width=45% align=center><b>Time</b></td><td class=casino  align=center><b>Take Bet</b></td>");
echo("</tr>");
while ($res = $db->sql_fetchrow($loca))
{
 echo (" <tr>");
 echo("<td class=casino  align=center>$res[proposed]</td>");
 echo("<td class=casino  align=center>".mksize($res['amount'])."</td>");
 echo("<td class=casino  align=center>$res[time]</td>");
 echo("<td class=casino  align=center><b><a href=".$casino."?takebet=$res[id]>HERE</a></b></td>");
 echo("</tr>");
 $abcdefgh=1;
}
if($abcdefgh==false)echo("<tr><td class=casino  align=center colspan=4>Sorry no Bets</td></tr>");
echo "</table>";
echo('</table><br>');
print("</center>");
print("<hr>");
//CloseTable();
//////////////////////////////////////////////////////////////////////////////////////// game 3 
print("<tr><td>");

echo'<table bgcolor="#FFFFFF" align="center" width="50%" border="1">
  <tr>
    <td><font class="casinotext"><h2><center>Bet on a Color</center></h2></font></td>
  </tr>
</table>
<br/>';

print("<center>");
print("<form name=casino method=post action=$phpself>");
 print("<table bgcolor=#FFFFFF class=message width=40% cellspacing=0 cellpadding=5 border=1>\n");
  tr("Bet on:","<input type=submit value='Go!' >",1);
  tr("black",'<input name="color" type="radio" checked value="black">',1);
  tr("red",'<input name="color" type="radio" value="red">',1);
  tr("How Much:",'
  <select name="betmb">
  <option value="'.$bet_value1.'">'.mksize($bet_value1).'</option>
<option value="'.$bet_value2.'">'.mksize($bet_value2).'</option>
<option value="'.$bet_value3.'">'.mksize($bet_value3).'</option>

<option value="'.$bet_value4.'">'.mksize($bet_value4).'</option>
<option value="'.$bet_value5.'">'.mksize($bet_value5).'</option>
<option value="'.$bet_value6.'">'.mksize($bet_value6).'</option>
<option value="'.$bet_value7.'">'.mksize($bet_value7).'</option>
  </select>',1);
  
 if($show_real_chance)
  $real_chance=$cheat_value+1;
 else
  $real_chance=2;
 tr("your chance:","1 : ".$real_chance,1);
 tr("you can win:",$win_amount." * stake",1);
 echo('</table><br>');
 print("</form>");
print("</center>");
 print("<hr>");
 print("<tr><td>");
 ?><table bgcolor="#FFFFFF" align="center" width="50%" border="1">
  <tr>
    <td><font class="casinotext"><h2><center>Bet on a Number</center></h2></font></td>
  </tr>
</table>
<br/>
<?php
 print("<form name=casino2 method=post action=$phpself>");
 print("<table align=center bgcolor=#FFFFFF class=message width=40% cellspacing=0 cellpadding=5 border=1>\n");
  tr("Bet on number:","<input type=submit value='GO!' >",1);
  tr("number:",'<input name="number" type="radio" checked value="1">1&nbsp;&nbsp;<input name="number" type="radio" value="2">2&nbsp;&nbsp;<input name="number" type="radio" value="3">3
  &nbsp;&nbsp;<input name="number" type="radio" value="4">4&nbsp;&nbsp;<input name="number" type="radio" value="5">5&nbsp;&nbsp;<input name="number" type="radio" value="6">6',1);
  tr("How much:",'
  <select name="betmb">
  <option value="'.$bet_value1.'">'.mksize($bet_value1).'</option>
<option value="'.$bet_value2.'">'.mksize($bet_value2).'</option>
<option value="'.$bet_value3.'">'.mksize($bet_value3).'</option>
<option value="'.$bet_value4.'">'.mksize($bet_value4).'</option>
<option value="'.$bet_value5.'">'.mksize($bet_value5).'</option>
<option value="'.$bet_value6.'">'.mksize($bet_value6).'</option>
<option value="'.$bet_value7.'">'.mksize($bet_value7).'</option>
  </select>',1);
  
 if($show_real_chance)
  $real_chance=$cheat_value+5;
 else
  $real_chance=6;
 tr("Your chances:","1 : ".$real_chance,1);
tr("You can win:",$win_amount_on_number." * stake",1);
 echo('</table><br>');
 print("</form>");
print("<hr>");
print("<tr><td>");
?>
<table bgcolor="#FFFFFF" align="center" width="50%" border="1">
  <tr>
    <td><font class="casinotext"><h2><center><?php echo("".getusername($btuser).""); ?>'s details: </center></h2></font></td>
  </tr>
</table>
<br/>
<?php
print("<div align=center>");
print("<table bgcolor=#1b8007 border=2 cellspacing=0 width=650 cellpadding=3>\n"); 
print("<tr><td class=casino  align=center>");
 print("<font color=#FFFFFF><h3>Your Casino Stats</h3></font>\n");
 print("<table class=colhead  bgcolor=FFFFFF cellspacing=0 cellpadding=5>\n");
  tr("You can win:",mksize($max_download_user),1);
  tr("Won:",mksize($user_win),1);
  tr("Lost:",mksize($user_lost),1);
  tr("Ratio:",$casino_ratio_user,1);
  tr('Deposit on P2P:', mksize($user_deposit+$nobits));

    
 echo('</table>');
print("</td><td class=casino  align=center>"); 
 print("<font color=#FFFFFF><h3>Global Stats</h3></font>\n");
 print("<table class=message  bgcolor=FFFFFF cellspacing=0 cellpadding=5>\n");
  tr("Members can win:",mksize($max_download_global),1);
  tr("Won:",mksize($global_win),1);
  tr("Lost:",mksize($global_lost),1);
  tr("Ratio:",$casino_ratio_global,1);
  tr("Deposit on P2P:",mksize($global_deposit));
 echo('</table>');
print("</td><td class=casino  align=center>"); 
  print("<font color=#FFFFFF><h3>Your Current Stats</h3></font>\n");
print("<table class=message  bgcolor=FFFFFF cellspacing=0 cellpadding=5>\n");
 tr('Uploaded: ',(mksize($uploaded)));
 tr('Downloaded:',(mksize($downloaded)));
 tr('Ratio:',$ratio);
 tr("&nbsp;","");
 tr("&nbsp;","");
echo('</table>');   
print("</td></tr>");
echo('</table>');
print("</div>");
print("<br/>");
print("<center><h2><a href=games.php>Back to Games Choice</a></h2></center>");
print("<br/>");
print("</tr></td>");
print("</table>");
print("<br/>");
CloseTable();
}
include ("footer.php");
?>