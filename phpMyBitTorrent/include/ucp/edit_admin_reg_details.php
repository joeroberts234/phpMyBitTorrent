<?php
/*
*-----------------------------phpMyBitTorrent V 2.0.5--------------------------*
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
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: edit_reg_details.php 1 2010-12-08 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
$modcomment											= request_var('modcomment', '');
$group											= request_var('group', '');
$level											= request_var('level', '');
$warned											= request_var('warned', '');
$warnlength											= request_var('warnlength', '');
$warnpm											= request_var('warnpm', '');
$up											= request_var('up', '');
$down											= request_var('down', '');
$seed											= request_var('seed', '');
$invit											= request_var('invit', '');
$seedbox											= request_var('seedbox', '');
$helper											= request_var('helper', '');
$help_able											= request_var('help_able', '');
$active											= request_var('active', '');
$forumban											= request_var('forumban', '');
$shoutban											= request_var('shoutban', '');
$disable											= request_var('disable', '');
$disable_res											= request_var('disable_res', '');
        if (!isset($forumban) OR $forumban == "false") $forumban = "no";
		else
		$forumban = "yes";
        processinput("forumbanned",$forumban);		
        if (!isset($shoutban) OR $shoutban == "false") $shoutban = "false";
		else
		$shoutban = "true";
        processinput("can_shout",$shoutban);		
        if (!isset($disable) OR $disable == "") $disable = "false";
		else
		$disable = $disable;
        processinput("disabled",$disable);		
        processinput("disabled_reason",$disable_res);		
		#make sure user has rites to edit groups
		if(checkaccess("edit_level")){
        if (!isset($group) OR $group == "") $group = "";
						if($userrow["can_do"] != $group)
						logerror('Group Changed for '.username_is($uid)." To ".$group, 'Group edit');//log group chonge
        processinput("can_do",$group);		
		}
        if (!isset($help_able) OR $help_able == "") $help_able = "";
        processinput("help_able",$help_able);		
        if (!isset($helper) OR $helper == "") $helper = "false";
        processinput("helper",$helper);		
        if (!isset($seedbox) OR $seedbox == "") $seedbox = "0.0.0.0";
        processinput("seedbox",sprintf("%u",ip2long($seedbox)));
		if (!isset($up) OR $up =="") $up = '0';
		processload("uploaded",$up);
		if (!isset($invit) OR $invit =="") $invit = '0';
		processload("invites",$invit);
		if (!isset($seed) OR $seed =="") $seed = '0';
		processload("seedbonus",$seed);
		if (!isset($down) OR $down =="") $down = '0';
		processload("downloaded",$down);
        if (checkaccess("edit_level") AND in_array($level,Array("user","premium","moderator","admin"))) {
		if($userrow["level"] != $level)logerror('Level Changed for '.username_is($uid)." To ".$level, 'Level edit');
		processinput("level",$level);
		}
		$modcommentset = "";
		if (in_array($active,Array("0","1"))) processload("active",$active);
        if ($warnlength != 0) $warned = "yes";
        if ($warn_torol == "yes") $warned = "no";
        if ($warned == "no")
        {
		processload("warned",0);
		processload("warn_kapta",'0');
		processload("warn_hossz",'0');
        $replace_markers = Array("**user**");
		$replace_data = Array ($user->name);
		$pm_mess = str_replace($replace_markers,$replace_data,UCP_WARN_REMOVED_MES);
		bt_pm_out($user->id,$uid, WARNNING,$pm_mess);
		$modcommentset = "[ " . gmdate("Y-m-d H:i:s", time()) . " - WARN deleted by " . getusername($user->id) . " ]\n";
		}
        if ($warned == "yes")
        {
        if ($warnlength == 604800) $week = '1';
        if ($warnlength == 1209600) $week = '2';
        if ($warnlength == 2419200) $week = '4';
        if ($warnlength == 4838400) $week = '8';
		if ($warnlength > 604800)$weeks = "'s";
		else
		$weeks = "";
		processload("warned",'1');
		processload("warn_kapta",strtotime(gmdate("Y-m-d H:i:s", time())));
		processload("warn_hossz",$warnlength);
		$weekset = sprintf(UCP_WARN_WEEK,$week,$weeks);
        $replace_markers = Array("**user**","**weeks**","**message**");
		$replace_data = Array ($user->name, $weekset, $warnpm);
		$pm_mess = str_replace($replace_markers,$replace_data,UCP_WARNED_MES);
		bt_pm_out($user->id,$uid, WARNNING,$pm_mess);
        $modcommentset =  "" . gmdate("Y-m-d H:i:s", time()) . " - WARNed for " . $weekset . "  by " . getusername($user->id) . " - Reason: " . $warnpm . "\n";
		}
		$modcomment = $modcommentset.$modcomment;
        processinput("modcomment",$modcomment);
                $sql = "UPDATE ".$db_prefix."_users SET ";
                for ($i = 0; $i < count($sqlfields); $i++) $sql .= $sqlfields[$i] ." = ".$sqlvalues[$i].", ";
                $sql .= "act_key = ".(($admin_mode) ? "act_key" : "'".RandomAlpha(32)."'")." WHERE id = '".$uid."';"; //useless but needed to terminate SQL without a comma
                if (!$db->sql_query($sql)) btsqlerror($sql);
                if (!$admin_mode) userlogin($uname,$btuser); //SQL is executed, cookie is invalid and getusername() function returns nothing, so it must be called earlier
?>