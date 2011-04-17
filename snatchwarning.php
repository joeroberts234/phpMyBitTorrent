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
if (eregi("snatchwarning.php",$_SERVER["PHP_SELF"])) die ("You cannot include this file");
$seedingtimeneeded = 172800*20;
$sql="SELECT * FROM ".$db_prefix."_snatched WHERE userid = ".$user->id." AND finished = 'yes' AND seeder = 'no' AND seeding_time < $seedingtimeneeded AND uploaded < downloaded";
$row = $db->sql_query($sql); 
if ($db->sql_numrows($row) > 0)
{
while ($warn = $db->sql_fetchrow($row)){
if(time()- sql_timestamp_to_unix_timestamp($warn['last_action']) >'600'){
if($warn['hnr_warning'] == 'no'){
                        $warnlength = 604800;
                        $warningmsg = _btsnatchwarn_warn;
						$modmsg = "" . gmdate("Y-m-d H:i:s", time()) . " - WARNED for 1 WEEK  by HNR SYSTEM - Reason: HIT AND RUN for torrent ".$warn['torrent_name'];
                        $sqlw="UPDATE ".$db_prefix."_users SET modcomment='".$modmsg."', warned='1', warn_kapta='" . strtotime(gmdate("Y-m-d H:i:s", time())) . "', warn_hossz='".$warnlength."' WHERE id='".$user->id."'";
						$db->sql_query($sqlw)or die('2');
                        $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('0', ".$user->id.", '"._btsnatchwarn__hnr.", '" . $warningmsg . "', now())")or die('3');   //send pm
                        $db->sql_query("UPDATE ".$db_prefix."_snatched SET hnr_warning='yes', warned='yes' WHERE id='".$warn['id']."'")or die('4');
						}
}else{
if($warn['warned'] == 'no'){
                        $warningmsg = _btsnatchwarn_pm;
                        $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('0', ".$user->id.", 'Hit And Run', '" . $warningmsg . "', now())")or die('5');   //send pm
                        $db->sql_query("UPDATE ".$db_prefix."_snatched SET warned='yes' WHERE id='".$warn['id']."'")or die('6');
}
}
}
}
?>