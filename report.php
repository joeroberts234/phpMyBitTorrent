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

include("header.php");
global $db, $prefix, $user;
OpenTable("Report");


$takeuser = false;
$taketorrent = false;
$takeforumid = false;
$takecomment = false;
$takeforumpost = false;
$takereason = false;

$userp = false;
$torrent = false;
$comment = false;
$forumid = false;
$forumpost = false;

if(isset($_POST["user"]))$takeuser = $_POST["user"];
if(isset($_POST["torrent"]))$taketorrent = $_POST["torrent"];
if(isset($_POST["forumid"]))$takeforumid = $_POST["forumid"];
if(isset($_POST["comment"]))$takecomment = $_POST["comment"];
if(isset($_POST["forumpost"]))$takeforumpost = $_POST["forumpost"];
if(isset($_POST["reason"]))$takereason = mysql_real_escape_string($_POST["reason"]);

if(isset($_GET["user"]))$userp = (int)$_GET["user"];
if(isset($_GET["torrent"]))$torrent = (int)$_GET["torrent"];
if(isset($_GET["comment"]))$comment = (int)$_GET["comment"];
if(isset($_GET["forumid"]))$forumid = (int)$_GET["forumid"];
if(isset($_GET["forumpost"]))$forumpost = (int)$_GET["forumpost"];

//take report user
if (!empty($takeuser)){
    if (empty($takereason)){
bterror("You must enter a reason.","Error");
        CloseTable();
        die;
    }

    $sql = "SELECT id FROM ".$db_prefix."_reports WHERE addedby = ".$user->id." AND votedfor = $takeuser AND type = 'user'";
	$res = $db->sql_query($sql)or btsqlerror($sql); 

    if (mysql_num_rows($res) == 0){
        mysql_query("INSERT into ".$db_prefix."_reports (addedby,votedfor,type,reason) VALUES (".$user->id.",$takeuser,'user', '$takereason')");
        print("User: $takeuser, Reason: $takereason<p></p>Successfully Reported");
        CloseTable();
        die();
    }else{
        print("You have already reported user $takeuser");
        CloseTable();
        die();
    }
}

//take report torrent
if (($taketorrent !="") && ($takereason !="")){
    if (!$takereason){
bterror("You must enter a reason.","Error");
        CloseTable();
        die;
    }

    $res = mysql_query("SELECT id FROM ".$db_prefix."_reports WHERE addedby = ".$user->id." AND votedfor = $taketorrent AND type = 'torrent'");
    if (mysql_num_rows($res) == 0){
        mysql_query("INSERT ".$db_prefix."_into reports (addedby,votedfor,type,reason) VALUES (".$user->id.",$taketorrent,'torrent', '$takereason')");
        print("Torrent: $taketorrent, Reason: $takereason<p></p>Successfully Reported");
        CloseTable();
        die();
    }else{
        print("You have already reported torrent $taketorrent");
        CloseTable();
        die();
    }
}

//take report comment
if (($takecomment !="") && ($takereason !="")){
    if (!$takereason){
bterror("You must enter a reason.","Error");
        CloseTable();
        die;
    }

    $res = mysql_query("SELECT id FROM ".$db_prefix."_reports WHERE addedby = ".$user->id." AND votedfor = $takecomment AND type = 'comment'");
    if (mysql_num_rows($res) == 0){
        mysql_query("INSERT into ".$db_prefix."_reports (addedby,votedfor,type,reason) VALUES (".$user->id.",$takecomment,'comment', '$takereason')");
        print("Comment: $takecomment, Reason: $takereason<p></p>Successfully Reported");
        CloseTable();
        die();
    }else{
        print("You have already reported torrent $takecomment");        CloseTable();
die();
    }
}

//take forum post report
if (($takeforumid !="") && ($takereason !="")){
    if (!$takereason){
bterror("You must enter a reason.","Error");
        CloseTable();
        die;
    }
    $sql = "SELECT id FROM ".$db_prefix."_reports WHERE addedby = ".$user->id." AND votedfor= $takeforumid AND votedfor_xtra= $takeforumpost AND type = 'forum'";
	$res = $db->sql_query($sql)or btsqlerror($sql); 
    if (mysql_num_rows($res) == 0){
        mysql_query("INSERT into ".$db_prefix."_reports (addedby,votedfor,votedfor_xtra,type,reason) VALUES (".$user->id.",$takeforumid,$takeforumpost ,'forum', '$takereason')");
        print("Forum post: $takeforumid, Reason: $takereason<p></p>Successfully Reported");
		        CloseTable();
die();
    }else{
        print("You have already reported post $takeforumid");
		        CloseTable();
die();
    }

}

//report user form
if ($userp !=""){
    $res = mysql_query("SELECT username, can_do as class FROM ".$db_prefix."_users WHERE id=$userp");
    if (mysql_num_rows($res) == 0){
        print("Invalid UserID");
		        CloseTable();
die();
    }    

    $arr = mysql_fetch_assoc($res);
    
    print("<b>Are you sure you would like to report user:</b><BR><a href=account-details.php?id=$userp><b>$arr[username]</b></a>?<BR>");
    print("<p>Please note, this is <b>not</b> to be used to report leechers, we have scripts in place to deal with them</p>");
    print("<b>Reason</b> (required): <form method=post action=report.php><input type=hidden name=user value=$userp><input type=text size=100 name=reason><p></p><input type=submit class=btn value=Confirm></form>");
	        CloseTable();
die();
}

//report torrent form
if ($torrent !=""){
    $res = mysql_query("SELECT name FROM ".$db_prefix."_torrents WHERE id=$torrent");

    if (mysql_num_rows($res) == 0){
        print("Invalid TorrentID");
		        CloseTable();
die();
    }

    $arr = mysql_fetch_array($res);
    print("<b>Are you sure you would like to report torrent:</b><BR><a href=torrents-details.php?id=$torrent><b>$arr[name]</b></a>?<BR>");
    print("<b>Reason</b> (required): <form method=post action=report.php><input type=hidden name=torrent value=$torrent><input type=text size=100 name=reason><p></p><input type=submit class=btn value=Confirm></form>");
	        CloseTable();
die();
}

//report forum post form
if (($forumid !="") && ($forumpost !="")){
    $res = mysql_query("SELECT subject FROM ".$db_prefix."_forum_topics WHERE id=$forumid");

    if (mysql_num_rows($res) == 0){
        print("Invalid Forum ID");
		        CloseTable();
die();
    }

    $arr = mysql_fetch_array($res);
    print("<b>Are you sure you would like to report the following forum post:</b><BR><a href=forums.php?action=viewtopic&topicid=$forumid&page=p#$forumpost><b>$arr[subject]</b></a>?<BR>");
    print("<b>Reason</b> (required): <form method=post action=report.php><input type=hidden name=forumid value=$forumid><input type=hidden name=forumpost value=$forumpost><input type=text size=100 name=reason><p></p><input type=submit class=btn value=Confirm></form>");
		        CloseTable();
die();
}

//report comment form
if ($comment !=""){
    $res = mysql_query("SELECT id, text FROM ".$db_prefix."_comments WHERE id=$comment");
    if (mysql_num_rows($res) == 0){
        print("Invalid Comment");
		        CloseTable();
die();
    }    

    $arr = mysql_fetch_assoc($res);
    
    print("<b>Are you sure you would like to report Comment:</b><BR><BR><b>".format_comment($arr["text"])."</b>?<BR>");
    print("<p>Please note, this is <b>not</b> to be used to report leechers, we have scripts in place to deal with them</p>");
    print("<b>Reason</b> (required): <form method=post action=report.php><input type=hidden name=comment value=$comment><input type=text size=100 name=reason><p></p><input type=submit class=btn value=Confirm></form>");        CloseTable();
die();
}

//error
if (($userp !="") && ($torrent !="")){
    print("<h1>Missing Info</h1>");
	        CloseTable();
die();
}

bterror("Missing Info.","Error");
        CloseTable();
?>