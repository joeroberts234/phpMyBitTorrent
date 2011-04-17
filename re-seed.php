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
if (!eregi("re-seed.php",$_SERVER["PHP_SELF"])) die("You can't include this file");
include("header.php");
global $db, $db_prefix;


$reseedid = 0 + $_GET["id"];
OpenTable(_btreseed_reg);


if (isset($_COOKIE["PMBTreseedreq$reseedid"])){ //check cookie for spam prevention
   echo "<div align=left>"._btreseed_msg."</div>";
//end cookie check
}else{
 $sqlc = "SELECT COUNT(id) FROM ".$db_prefix."_peers WHERE seeder = 'yes' and torrent = " .$reseedid. "";
$resc = $db->sql_query($sqlc);
$torrowc = $db->sql_fetchrow($resc);
if ($torrowc[0] >= 3){
echo ""._btreseed_noneed."".$torrowc[0]." "._btreseed_seeders."";
CloseTable();
die();
}

   echo "<BR><br><div align=left>"._btreseed_sent."<br><Br>";
   //GET THE TORRENT AND USER ID FROM THIS TORRENTS COMPLETED LIST, YOU CAN AMMEND THIS TO LOOK AT SNATCHED TABLE IF NEEDED
   $sql = ("SELECT * FROM ".$db_prefix."_torrents WHERE id = " .$reseedid. "");
$res = $db->sql_query($sql);
$torrow = $db->sql_fetchrow($res);
   
   $sql = ("SELECT * FROM ".$db_prefix."_download_completed WHERE torrent = " .$reseedid. "");
$sres = $db->sql_query($sql);
   while ($srow = $db->sql_fetchrow($sres))
       {
       //SELECT THE COMPLETED USERS DETAILS
       $sql = ("SELECT id, username, email FROM ".$db_prefix."_users WHERE id = ".$srow['user']." ") or die(mysql_error());
$res = $db->sql_query($sql);
       $result=$db->sql_fetchrow($res);
   
       //DO MSG
       print("<a href=\"user.php?op=profile&id=$result[id]\">".$result["username"]."</a> ");
           
       $pn_msg = "" . $user->name . " "._btreseed_pm."
   
       <a href=\"details.php?id=".$_GET["id"]."&hit=1\">".$torrow['name']."</a>  <br />"._btreseed_pm_thankyou."";
       $subject= ""._btreseed_pm_subject."";
	                 $tor = $siteurl . "/details.php?id=".$_GET["id"]."&hit=1";
                     $rec=$result["id"];
					 $email=$result["email"];
					 $name=$result["username"];
                     $send=$user_>id;
                  include("language/mailtexts.php");
                  //SEND MSG
                 $sql = "INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('".$user->id."','".$rec."','RESEED','".addslashes($pn_msg)."',NOW());";

                $db->sql_query($sql) or btsqlerror($sql); 
				$mid2 = $db->sql_nextid();

                $notify_mail = new eMail();
                $notify_mail->add($email);
                $notify_mail->sender = $admin_email;
                $notify_mail->subject = $reseedemailsub[$language];
                $search = Array("**name**","**sender**","**sitename**","**siteurl**","**mid2**","**torrent**","**torname**");
                $replace = Array($name,$user->name,$sitename,$siteurl,$mid2,$tor,$torrow['name']);
                $notify_mail->body = str_replace($search,$replace,$reseedemailbody[$language]);
                $notify_mail->send();
       
       //request spamming prevention
       @setcookie("PMBTreseedreq".$reseedid, $reseedid);
   
   }
}
echo "<BR><br>";

CloseTable();
include("footer.php");
?>