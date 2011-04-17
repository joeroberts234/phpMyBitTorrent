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

if (eregi("ratiowarn.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");
        global $db, $db_prefix;
    //require("backend/functions.php");
    $resrws = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn_config");
	while ($arr = $db->sql_fetchrow($resrws))$arr_config[$arr['name']] = $arr['value'];

//RATIO WARNING VARS
$RATIO_WARNINGON = ($arr_config["enable"] == "true") ? true : false;    //ratiowarn on/off
$RATIOWARN_AMMOUNT = $arr_config["ratio_mini"]; //user warned if this ratio is held
$RATIOWARN_TIME = $arr_config["ratio_warn"];   //ammount of time for user have have poor ratio before warning
$RATIOWARN_BAN = $arr_config["ratio_ban"];     //ammount of time after warning to auto-ban user.
if($RATIO_WARNINGON)
{    
if ($user->user){
    //ECHO "RATIOWARN MODULE LOADED<br>"; ###DEBUG PURPOSES
	$sql = "SELECT uploaded, downloaded, uploaded/downloaded AS ratio FROM ".$db_prefix."_users WHERE id = '".$user->id."';";
        $res = $db->sql_query($sql);
        list ($uploaded, $downloaded, $ratio) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);
    $userratio = number_format($uploaded / $downloaded, 2);
    if ($userratio <= $RATIOWARN_AMMOUNT && $userratio){
	    
    }
    //$userid = $userrow["id"];
    $warningmsg ="This is a warning. Your ratio is too low and has been low for $RATIOWARN_TIME days. You have $RATIOWARN_BAN days to get your ratio above $RATIOWARN_AMMOUNT or you will be banned!";
    $warningmsg2 =" For Holding a ***Low Ratio*** for  $RATIOWARN_BAN days you where Warned";
    if ($userratio <= $RATIOWARN_AMMOUNT ){
    //ECHO "RATIOWARN MODULE LOADED :: POOR RATIO<br>"; ###DEBUG PURPOSES
        //check if user is in table
        $check = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn WHERE userid='".$user->id."'");
    
            //user is in table
            $status = $db->sql_fetchrow($check);
            if($status["warned"] == "yes"){
                //check date of warning
                //ECHO "RATIOWARN MODULE LOADED :: USER WARNED PREVIOUSLY<br>"; ###DEBUG PURPOSES
                        $sql = $db->sql_query("SELECT warntime,TO_DAYS(NOW()) - TO_DAYS(warntime) as difference FROM ".$db_prefix."_ratiowarn WHERE userid='".$user->id."'");
        if (($db->sql_numrows($sql) != "0")){
                        $warnedate = $db->sql_fetchrow($sql);
                    if($warnedate["difference"] > $RATIOWARN_BAN){ //if warned for 10 days,
                        //ban
                        echo "RATIOWARN MODULE LOADED :: USER BANNED<br>"; ###DEBUG PURPOSES
                        $db->sql_query("UPDATE ".$db_prefix."_ratiowarn SET banned='yes' WHERE userid='".$user->id."'");
                        $db->sql_query("UPDATE ".$db_prefix."_users SET ban='1', modcomment='".$status["modcomment"] . $warningmsg2 . "'  WHERE id='".$user->id."'");
                        $db->sql_query("INSERT INTO ".$db_prefix."_bans (ipstart, ipend, reason) VALUES ('".getip()."', '".getip()."', '".$warningmsg2."')");
              
                        /*
                            begin_frame("You have been banned", center);
                                echo "You have been automatically banned for maintaing a poor ratio.";
                            end_frame();
                        */
                    }
            }
            else{
                //check date of notification
                //ECHO "RATIOWARN MODULE LOADED :: USER NOT PREVIOUSLY WARNED<br>"; ###DEBUG PURPOSES
                
                        $sql = $db->sql_query("SELECT ratiodate,TO_DAYS(NOW()) - TO_DAYS(ratiodate) as difference FROM ".$db_prefix."_ratiowarn WHERE userid='".$user->id."'");
                        $notificationdate = $db->sql_fetchrow($sql);
                    if($notificationdate["difference"] > $RATIOWARN_TIME){//if notification date is > $RATIOWARN_TIME
                    
                        //ECHO "RATIOWARN MODULE LOADED :: USER WARNED<br>"; ###DEBUG PURPOSES
                        
                        $db->sql_query("UPDATE ".$db_prefix."_ratiowarn SET warntime=NOW() WHERE userid='".$user->id."'");   //add to warned list
                        $db->sql_query("UPDATE ".$db_prefix."_ratiowarn SET warned='yes' WHERE userid='".$user->id."'");//warn
                        $db->sql_query("UPDATE ".$db_prefix."_users SET warned='1' WHERE id='".$user->id."'");
                        $db->sql_query("INSERT INTO ".$db_prefix."_private_messages (sender, recipient, subject, text, sent) VALUES ('0', ".$user->id.", 'LOW RATIO WARNNING', '" . $warningmsg . "', now())");  //send pm
                        
                        /*
                            begin_frame("You will be banned", center);
                                echo $warningmsg;
                            end_frame();
                        */
                    }
            }
        }else{
            //insert user into table
            //ECHO "RATIOWARN MODULE LOADED :: USER ADDED TO WATCH LIST<br>"; ###DEBUG PURPOSES
            $db->sql_query("INSERT INTO ".$db_prefix."_ratiowarn (userid, ratiodate) VALUES (".$user->id.", NOW())");    //add to watch list
        }
    }
    ##Makre sure user is not in table
    if ($userratio > $RATIOWARN_AMMOUNT && $userratio){
    //ECHO "RATIOWARN MODULE LOADED :: USER HAS OK RATIO<br>"; ###DEBUG PURPOSES
        $check = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn WHERE userid='".$user->id."'");
        
        if($db->sql_numrows($check) != "0"){
        
            //remove user from database
            
            //ECHO "RATIOWARN MODULE LOADED :: USER REMOVED FROM LIST<br>"; ###DEBUG PURPOSES
            $db->sql_query("DELETE FROM ".$db_prefix."_ratiowarn WHERE userid='".$user->id."'");
            $db->sql_query("UPDATE ".$db_prefix."_users SET warned='0' WHERE id='".$user->id."'");
        }
    }
}//mustbeloggedin
}
?>