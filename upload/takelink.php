<?php
/*
*----------------------------phpMyBitTorrent V 2.0-----------------------------*
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

if (!eregi("upload.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly.");

if (isset($postback)) {
        require_once("upload/link.php");
} else {
        /*
        VULNERABILITY REPORT

        AT THIS TIME, LINKS ARE NOT RE-CHECKED AGAINST VALIDITY AND DUPLICATE
        ENTRIES. A MALICIOUS USER IS STILL ABLE TO HACK THE INPUT FORM AND SEND
        BAD DATA. THIS MAY RESULT IN BAD DISPLAYING OF THE COLLECTION, THAT HAS
        SIMPLY TO BE DELETED BY THE ADMINISTRATOR
        */
        //Upload section
        $errmsg = Array();
        if (!isset($namex) OR $namex == "") $errmsg[] = _btemptyfname;
        if (!isset($descr) OR $descr == "") $errmsg[] = _btdescrrequired;
        if (!isset($link_category)) $link_category = 0;

        $cats = catlist();
        $in_cat = false;
        while ($cat = each($cats) AND !$in_cat) if ($link_category == $cat[1]["id"]) $in_cat = true;
        if (!$in_cat) $errmsg[] = _btillegalcat;

        if (!isset($old_files)) $errmsg[] = _btinsertfilesfirst;

        if (!empty($errmsg)) {
                bterror($errmsg,_btuploaderror,false);
                require_once("upload/link.php");
        }
        if (get_magic_quotes_gpc()) $descr = stripslashes($descr);
        //Now we can proceed

        if ($use_rsa) $files = unserialize($rsa->decrypt($old_files));
        else $files = unserialize(base64_decode($old_files));
        if (!$files) bterror("Bad Data",_btuploaderror);

        preg_match_all('/([\\w]{6,}+)/', $descr, $search_descr);
        preg_match_all('/([\\w]{6,}+)/', $namex, $search_name);
        $searchtext = implode(" ",$search_descr[0])." ".implode(" ",$search_name[0]);

        $numfiles = count($files);
        $size = 0;

        foreach ($files as $file) {
                //Should check the rest
                $size += $file["size"];
        }

        $sqlfields = Array();
        $sqlvalues = Array();

        $sqlfields[] = "info_hash";
        $sqlvalues[] = "NULL";

        $sqlfields[] = "name";
        $sqlvalues[] = "'".addslashes($namex)."'";

        $sqlfields[] = "search_text";
        $sqlvalues[] = "'".addslashes($searchtext)."'";

        $sqlfields[] = "descr";
        $sqlvalues[] = "'".addslashes($descr)."'";

        $sqlfields[] = "category";
        $sqlvalues[] = "'".intval($link_category)."'";

        $sqlfields[] = "size";
        $sqlvalues[] = "'".addslashes($size)."'";

        $sqlfields[] = "type";
        $sqlvalues[] = "'link'";

        $sqlfields[] = "numfiles";
        $sqlvalues[] = "'".$numfiles."'";

        $sqlfields[] = "added";
        $sqlvalues[] = "NOW()";

        $sqlfields[] = "visible";
        $sqlvalues[] = "'yes'";

        $sqlfields[] = "owner";
        $sqlvalues[] = "'".$user->id."'";

        $sqlfields[] = "ownertype";
        $sqlvalues[] = "'0'";

        $sqlfields[] = "uploader_host";
        $sqlvalues[] = "'".gethostbyaddr($_SERVER["REMOTE_ADDR"])."'";

        $sql_collection = "INSERT INTO ".$db_prefix."_torrents (".implode(", ",$sqlfields).") VALUES (".implode(", ",$sqlvalues).");";

        if (!$db->sql_query($sql_collection)) btsqlerror($sql_collection);

        $tid = $db->sql_nextid();

        foreach ($files as $file) {
                $sqlfields = Array();
                $sqlvalues = Array();

                $sqlfields[] = "torrent";
                $sqlvalues[] = "'".$tid."'";

                $sqlfields[] = "filename";
                $sqlvalues[] = "'".addslashes($file["name"])."'";

                $sqlfields[] = "size";
                $sqlvalues[] = "'".addslashes($file["size"])."'";

                $sqlfields[] = "md5sum";
                $sqlvalues[] = ((!empty($file["md5sum"])) ? "'".addslashes($file["md5sum"])."'" : "NULL");

                $sqlfields[] = "ed2k";
                $sqlvalues[] = "'".addslashes($file["ed2k"])."'";

                $sqlfields[] = "magnet";
                $sqlvalues[] = ((!empty($file["magnet"])) ? "'".addslashes($file["magnet"])."'" : "NULL");

                $sql_file = "INSERT INTO ".$db_prefix."_files (".implode(", ",$sqlfields).") VALUES (".implode(", ",$sqlvalues).");";
                if (!$db->sql_query($sql_file)) {
                        $sql_query("DELETE FROM ".$db_prefix."_files WHERE torrent = '".$tid."';");
                        $sql_query("DELETE FROM ".$db_prefix."_torrents WHERE id = '".$tid."';");
                        btsqlerror($sql_file);
                }
        }
        $url = "details.php?id=".$tid."&upcomplete=1";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=".$url."\">";

        OpenTable(_btupload);
        echo "<p>".str_replace("**url**",$url,_btuploadcomplete)."</p>\n";

        if (isset($commnotify)){
                $sql = "INSERT INTO ".$db_prefix."_comments_notify (torrent, user) VALUES ('".$id."', ".$user->id.")";
                $db->sql_query($sql) or btsqlerror($sql);
                echo "<p>&nbsp;</p>";
                echo  "<p>"._btaddnotifycomment."</p>\n";
        }
        CloseTable();
}
?>
