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

if (eregi("bittorrent.php", $_SERVER['PHP_SELF'])) die ("You can't access this file directly...bittorrent.php");
if ($use_rsa) require_once("include/rsalib.php");
require_once("include/functions.php");
require_once("include/class.user.php");
require_once("include/class.email.php");
if ($use_rsa) $rsa = New RSA($rsa_modulo, $rsa_public, $rsa_private);
if(!function_exists('str_ireplace')) {
    function str_ireplace($search, $replacement, $string){
        $delimiters = array(1,2,3,4,5,6,7,8,14,15,16,17,18,19,20,21,22,23,24,25,
        26,27,28,29,30,31,33,247,215,191,190,189,188,187,186,
        185,184,183,182,180,177,176,175,174,173,172,171,169,
        168,167,166,165,164,163,162,161,157,155,153,152,151,
        150,149,148,147,146,145,144,143,141,139,137,136,135,
        134,133,132,130,129,128,127,126,125,124,123,96,95,94,
        63,62,61,60,59,58,47,46,45,44,38,37,36,35,34);
        foreach ($delimiters as $d) {
            if (strpos($string, chr($d))===false){
                $delimiter = chr($d);
                break;
            }
        }
        if (!empty($delimiter)) {
            return preg_replace($delimiter.quotemeta($search).$delimiter.'i', $replacement, $string);
        }
        else { 
            trigger_error('Homemade str_ireplace could not find a proper delimiter.', E_USER_ERROR);
        }
    }
}
$user = @new User($_COOKIE["btuser"]);
function search_word($word, $search){
global $search;
if(empty($search))return $word;
$search = str_replace("+"," ",$search);
$newterm = str_ireplace($search,"<span class=\"highlight\">$search</span>",$word);
return $newterm;
}

function torrenttable($res, $variant = "index", $user = "", $block = "") {
        global $db, $name, $search, $user, $download_level, $torrent_global_privacy, $onlysearch, $db_prefix, $autoscrape, $theme, $btback1, $btback2, $btback3, $free_dl;
		if(function_exists('theme_torrenttable'))return theme_torrenttable($res, $variant, $user, $block);
$utc = $btback1;
$phpself = $_SERVER['PHP_SELF'];
echo <<<EOF
<script type="text/javascript" language="JavaScript">
var expanded = 0;
function expand(id) {
        if (expanded == id) return;
        var obj;
        var obj2;
        obj = document.getElementById("userpanel_"+id);
        obj.className = 'show';
        if (expanded != 0) {
                obj2 = document.getElementById("userpanel_"+expanded);
                obj2.className = 'hide';
        }
        expanded = id;
}
function toggle(nome) {
if(document.getElementById(nome).style.display=='none')
{
document.getElementById(nome).style.display = '';
document.getElementById(nome+"img").src="images/collapse.png";
} else {
document.getElementById(nome).style.display = 'none';
document.getElementById(nome+"img").src="images/expand.png";
}
}

</script>
EOF;
?>
<?php
        if ($variant == "index") {
                OpenTable("Torrents");
        } 
$count_get = 0;

foreach ($_GET as $get_name => $get_value) {
if ($get_name != "sort" && $get_name != "type") {
if ($count_get > 0) {
$oldlink = $oldlink . "&" . $get_name . "=" . $get_value;
} else {
$oldlink = $oldlink . $get_name . "=" . $get_value;
}
$count_get++;
}}

if ($count_get > 0) {
$oldlink = "?" . $oldlink . "&";
}else{
$oldlink = "?";
}
if ($_GET['sort'] == "1") {
if ($_GET['type'] == "desc") {
$link1 = "asc";
} else {
$link1 = "desc";
}
}

if ($_GET['sort'] == "2") {
if ($_GET['type'] == "desc") {
$link2 = "asc";
} else {
$link2 = "desc";
}
}

if ($_GET['sort'] == "3") {
if ($_GET['type'] == "desc") {
$link3 = "asc";
} else {
$link3 = "desc";
}
}

if ($_GET['sort'] == "4") {
if ($_GET['type'] == "desc") {
$link4 = "asc";
} else {
$link4 = "desc";
}
}

if ($_GET['sort'] == "5") {
if ($_GET['type'] == "desc") {
$link5 = "asc";
} else {
$link5 = "desc";
}
}

if ($_GET['sort'] == "6") {
if ($_GET['type'] == "desc") {
$link6 = "asc";
} else {
$link6 = "desc";
}
}

if ($_GET['sort'] == "7") {
if ($_GET['type'] == "desc") {
$link7 = "asc";
} else {
$link7 = "desc";
}
}

if ($_GET['sort'] == "8") {
if ($_GET['type'] == "desc") {
$link8 = "asc";
} else {
$link8 = "desc";
}
}

if ($_GET['sort'] == "9") {
if ($_GET['type'] == "desc") {
$link9 = "asc";
} else {
$link9 = "desc";
}
}

if ($link1 == "") { $link1 = "asc"; } // for torrent name
if ($link2 == "") { $link2 = "desc"; }
if ($link3 == "") { $link3 = "desc"; }
if ($link4 == "") { $link4 = "desc"; }
if ($link5 == "") { $link5 = "desc"; }
if ($link6 == "") { $link6 = "desc"; }
if ($link7 == "") { $link7 = "desc"; }
if ($link8 == "") { $link8 = "desc"; }
if ($link9 == "") { $link9 = "desc"; }
if ($variant == "index")
{
        echo "<p class=\"explane\">"._btmfreetorrentexplain."</p><br><br>";
		echo "<p class=\"explane\">"._btmnuketorrentexplain."</p>";
}
        echo "<table border=\"0\" cellpadding=\"3\" width=\"100%\">";

        //Table Header
if ($variant == "index")
{
        echo "<thead><tr><th align=\"center\" width=\"7%\"><p><a href=\"$phpself?sort=4&amp;type=$link4\" title=\"Sort by "._bttype." ".$link4."\">"._bttype."</a></p></th>";
        echo "<th align=\"center\" width=\"51%\"><p><a href=\"$phpself".$oldlink."sort=1&amp;type=$link1\" title=\"Sort by "._btname." ".$link1."\">"._btname."</a></p></th>";
        echo "<th align=\"center\" width=\"1%\"><p>"._btcomments."</p></th>";
        echo "<th align=\"center\" width=\"7%\"><p><a href=\"$phpself".$oldlink."sort=7&amp;type=$link7\" title=\"Sort by "._btseeders." ".$link7."\">"._btseeders."</a></p></th>";
        echo "<th align=\"center\" width=\"7%\"><p><a href=\"$phpself".$oldlink."sort=8&amp;type=$link8\" title=\"Sort by "._btleechers." ".$link8."\">"._btleechers."</a></p></th>";
		echo "<th align=\"center\" width=\"1%\"><p>"._btnet."</p></th>";
}else{
        echo "<thead><tr><th align=\"center\" width=\"7%\"><p>"._bttype."</p></th>";
        echo "<th align=\"center\" width=\"51%\"><p>"._btname."</p></th>";
        echo "<th align=\"center\" width=\"1%\"><p>"._btcomments."</p></th>";
        echo "<th align=\"center\" width=\"7%\"><p>"._btseeders."</p></th>";
        echo "<th align=\"center\" width=\"7%\"><p>"._btleechers."</p></th>";
		echo "<th align=\"center\" width=\"1%\"><p>"._btnet."</p></th>";
}
        echo "</tr></thead><tbody>";

        while ($row = $db->sql_fetchrow($res)) {
                $id = $row["id"];

                echo "<tr bgcolor=\"#$utc\" onMouseOver=\"this.bgColor='$btback3';\" onMouseOut=\"this.bgColor='#$utc';\">";

                //Category
                echo "<td align=\"center\">";
                if (isset($row["cat_name"])) {
                        if (!$onlysearch AND $variant == "index") echo "<a href=\"$phpself?cat=".$row["category"]."\">";
                        if (isset($row["cat_pic"]) AND $row["cat_pic"] != "" AND is_readable("themes/".$theme."/pics/cat_pics/".$row["cat_pic"]))
                                echo "<img border=\"0\" src=\"themes/" . $theme . "/pics/cat_pics/". $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" >";
                                elseif (isset($row["cat_pic"]) AND $row["cat_pic"] != "" AND is_readable("cat_pics/".$row["cat_pic"]))
                                echo "<img border=\"0\" src=\"cat_pics/" . $row["cat_pic"] . "\" alt=\"" . $row["cat_name"] . "\" >";
                        else
                                echo $row["cat_name"];
                        if (!$onlysearch AND $variant == "index") echo "</a>";
                } else echo "-";

                echo "</td>" ;

                echo "<td><table><tr><td>";

                //Status Icons
                $imgs = 0;
				//help(pic ("help.gif","",null),preg_replace("/[^0-9a-z -<>._#]/i",'',$row["descr"]),$dispname);
				if($row["ratiobuild"] == "yes" || $free_dl) {help(pic ("magic.gif","",null),"This File Is Set As A Ratio Builder Yuor Download Is Not Counted Only your Upload");$imgs++; }
				if($row["nuked"] == "yes") {help(pic ("nuked.gif","",null),"This File Has Been Nuked. Wich meens It may have parts missing Sound is off time or some other troubles so download at your own risk"); $imgs++; }
                if ($row["evidence"] != 0) { echo pic("sticky.gif",null,_btalt_sticky); $imgs++; }
		if ($row["banned"] == "yes") { echo pic("banned.png",null,_btalt_banned); $imgs++; }
		if ($row["type"]=="link") { echo pic("minidonkey.gif",$row["ed2k"],_btalternatesource); $imgs++; }
		if ($row["tracker"] != "" AND $row["tracker"] != "dht:") { echo pic("external.gif",null,_btalt_external); $imgs++; }
                if ($imgs == 2) { echo "<br>"; $imgs = 0; }
                if ($row["dht"] == "yes" AND $variant != "mytorrents") { help(pic("dht.gif","",null),_btdhtexplanation,_btdht); $imgs++; }
               // echo "</td>";
$num2 = $db->sql_numrows($res);
if ($num2 > 1)
{
$uc++;
}
if($uc%2 == 0)
$utc = $btback1;
else
$utc = $btback2;
$i++;
 if (!$id_pedido) $mostrar = 'none';
else $mostrar = '';

$img = 'expand'; 


if ($id_pedido == $id) $mostrar = '';              

                //Name
                $dispname = htmlspecialchars($row["name"]);
                $dispname = str_replace("_", " ", $dispname);
                $dispname = str_replace(".", " ", $dispname);
				//help(pic ("help.gif","",null),preg_replace("/[^0-9a-z -<>_=.#]/i",'',search_word(format_comment($row["descr"]), $search)),$dispname);$imgs++;
//echo"</td>";
		if ($variant == "index")echo "
		<p class=\"title\"><a id=\"n".$id."\"></a><a style=\"cursor: pointer;\" onClick=\"toggle('nn".$id."');\"><img title=\"Expand item\" id=\"nn".$id."img\" src=\"images/".$img.".png\" width=\"11px\" height=\"8px\" alt=\"+\"></a><a STYLE=\"text-decoration:none\" href=\"details.php?id=".$id;
		else
		echo "<td><p class=\"title\"><a STYLE=\"text-decoration:none\" href=\"details.php?id=".$id;
                if ($row["owner"] != $user->id)
                        echo "&amp;hit=1";

                echo "\"  title=\"".$dispname."\">".((strlen($dispname) <= 51) ? search_word($dispname, $search): search_word(substr($dispname,0,50)."...", $search))."</a></p>";


        if ($variant == "index")echo "<tr ><td width=\"100%\" nowrap ><div id=\"nn".$id."\" style=\"display:".$mostrar."\"><p>";



                //File
                if ($variant == "index" OR $variant == "usertorrent") {
                        //Size
                        echo "<p class=\"file\">".mksize($row["size"])."&nbsp;";

                        if ($row["type"] == "single" OR $row["numfiles"] <= 1)
                                echo("<a href=\"$phpself".$oldlink."sort=2&amp;type=$link2\" title=\"Sort by Number of files ".$link2."\">" .$row["numfiles"]."</a> file");
                        else {
                                if ($row["owner"] != $user->id)
                                        echo "<a href=\"$phpself".$oldlink."sort=2&amp;type=$link2\" title=\"Sort by Number of files ".$link2."\">" . $row["numfiles"] . "</a> "._btfile."";
                                else
                                        echo "<a href=\"$phpself".$oldlink."sort=2&amp;type=$link2\" title=\"Sort by Number of files ".$link2."\">" . $row["numfiles"] . "</a> "._btfile."";
                        }
                }

                //Date and by

                if ($variant == "index") {
                        if (isset($row["username"]) AND $row["ownertype"]==0) {
                                if ($row["user_level"] == "user") $userclass = "";
				elseif ($row["user_level"] == "premium") $userclass = "premium";
               			elseif ($row["user_level"] == "moderator") $userclass = "mod";
                		elseif ($row["user_level"] == "admin") $userclass = "admin";
                                echo " by <a class=\"$userclass\" href=\"user.php?op=profile&amp;username=".$row["username"]."\">" . htmlspecialchars($row["user_name"])."</a>";
                        } else
                        echo " by (<i>"._btunknown."</i>)";
                }
                if ($variant == "index" OR $variant == "usertorrent") echo "<br>";
                //Download torrent
                if (($user->user OR $download_level == "all") AND $row["type"] != "link") echo pic("download.gif","download.php?id=".$row["id"],_btalt_download);
                //Edit & Delete
                if ($user->moderator OR ($row["owner"] == $user->id AND $row["owner"] != "0")) echo pic("edit.gif","edit.php?id=".$row["id"],_btalt_edit).pic("drop.gif","edit.php?op=delete&id=".$row["id"],_btalt_drop);
		// Ban
		if ($user->moderator AND $row["banned"] != "yes"){
			echo pic("ban.png","edit.php?op=ban&amp;id=".$row["id"],_btban);
		}
		//Scrape
		if ($row["tracker"] != "") {
			if ($user->user){
				if (time()- sql_timestamp_to_unix_timestamp($row["tracker_update"])> 1800) {
				 	echo pic("refresh.png","scrape-external.php?id=".$row["id"]."&amp;tracker=".$row["tracker"]."&amp;return=". urlencode($_SERVER["REQUEST_URI"]),_btalt_scrape);
				}else{
					echo pic("refresh_gray.png",NULL,_btalt_noscrape);
				}
			
			}elseif ($user->moderator){
				echo pic("refresh.png","scrape-external.php?id=".$row["id"]."&amp;tracker=".$row["tracker"]."&amp;return=". urlencode($_SERVER["REQUEST_URI"]),_btalt_scrape);
			}else{
				echo pic("refresh_gray.png","scrape-external.php",_btalt_logintoscrape);
               		}
		}
                //Permission Administration
                if ($torrent_global_privacy AND $user->user AND $row["type"] != "link") {
                        if ($row["owner"] == $user->id) {
                                $pic = "auth_none.gif";
                                $authsql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row["id"]."' AND status = 'pending';";
                                $authres = $db->sql_query($authsql) or btsqlerror($authsql);
                                if ($db->sql_numrows($authres) > 0) $pic = "auth_pending.gif";
                                echo pic($pic,"mytorrents.php?op=displaytorrent&id=".$row["id"]);
                        } elseif (!can_download($user,$row)) {
                                $authres = $db->sql_query("SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row["id"]."' AND slave = '".$user->id."' LIMIT 1;");
                                if ($db->sql_numrows($authres) == 0) echo pic("lock_request.gif","details.php?op=authorization&id=".$row["id"],_btalt_lock_request);
                                else echo pic("lock.gif",null,_btalt_lock);
                        }
                }
				echo pic("lock.gif",null,_btalt_lock);
                if ($variant == "index" OR $variant == "usertorrent") echo "</p>";

		 //Close Table
				if ($variant == "index")echo "</div></td></tr>";
				else
                echo "</td></tr></table></td>";
$mostrar = 'none';
$img = 'expand';
				if ($variant == "index")echo"</table><span id=ID" . $row["id"] . "><a onclick=\"sndReq('op=view_details&torrent=" . $row["id"] . "', 'ID" . $row["id"] . "')\">".pic("plus.gif","",_btddetails)."</a></span></td>";
                echo "<td align=\"center\"><p>";
                if (!isset($row["rating"]))
                        echo "---";
                else {
                        $rating = round($row["rating"] * 2) / 2;
                        $rating = ratingpic($row["rating"]);
                        if (!isset($rating))
                                echo "---";
                        else
                                echo ($rating);
                }
                echo "<br>";
                if (!$row["comments"])
                        print($row["comments"] . "");
                else {
                        $hit = ($row["owner"] == $user->id) ? "" : "&amp;hit=1";
                        echo "<b><a href=\"details.php?id=".$row["id"].$hit."&amp;comm=startcomments\">" . $row["comments"] . "</a></b>";
                }
                echo "</p></td>";

                //Statistics
                if($row["type"] == "link")
                        echo "<td align=\"center\"><br><p>".pic("seeders.png",null,_btseeders)."</p></td><td></td>";
                else
                        echo "<td align=\"center\"><br><p>".pic("seeders.png",null,_btseeders)." ".$row["seeders"]."</p></td><td align=\"center\"><br><p>".pic("leechers.png",null,_btleechers)." ".$row["leechers"]."</p></td>";
                $tot = $row["tot_peer"];
                echo "<td align=\"center\">";
                if ($row["type"] != "link" AND $row["tracker"] == "") {
                        if ($row["leechers"] > 0 AND $row["speed"] > 0) {
                                $ro = $row["seeders"]/$row["leechers"];
                                $speed_leech = ($ro == 0) ? round($row["speed"]/$row["leechers"]) : min($row["speed"],round($row["speed"]*$ro));
                                $edt_m = ($row["size"] / $speed_leech)/60; //to minutes
                                $edt = ($edt_m % 60)."m"; //minutes
                                $edt_h = floor($edt_m / 60);
                                if ($edt_h>0) $edt = $edt_h."h ".$edt;
                                $speed_leech = mksize($speed_leech)."/s";
                        } else {
                                $speed_leech = "--";
                                $edt = "--";
                        }
                }
//Torrent Speed
                $spd = "<br>";

                if (($row["tracker"] == "" OR $autoscrape) AND $row["type"] != "link") {
				        if ($row["tracker"] != "") {
						       $spd .="<br>Last Scrape: ".get_formatted_timediff(sql_timestamp_to_unix_timestamp($row["tracker_update"]))." "._btago;
						}
                        if ($row["tracker"] == "") {
                                $spd .= "<br>"._bttorrentspd.mksize($row["speed"])."/s<br>".
                                _btleechspd.$speed_leech."<br>".
                                _btedt.$edt;
                        }
                        $spd .= "<br>"._btseeders.": ".$row["seeders"]."<br>".
                        _btleechers.": ".$row["leechers"]."<br>".
                        _bttotsorc.": ".$row["tot_peer"];
                }
                // ---------- patch:
                $leechers = intval($row["leechers"]);
                $seeders = intval($row["seeders"]);
                echo"<br>";
                if ($seeders == 0){
                        if ($row["type"]=="link"){
                                help(pic("quest.png"),_btalternatesource,_btperformance);

                        } elseif (!$autoscrape AND $row["tracker"] != "") {
                                help(pic("quest.png"),_btcantscrape,_btperformance);

                        } else {
                                help(pic("1.png"), _bthard.$spd,_btperformance);

                        }
                } elseif ( $leechers === 0 ) {
                	 if($row["tot_peer"] > 0) {
						help(pic("6.png"),_bteasy.$spd,_btperformance);
						} elseif($row["tot_peer"] == 0) {
						help(pic("6.png"),_bthard.$spd,_btperformance);
                        }  
                } else {
                	 $ratio = $seeders/$leechers;

                	 if($row["tot_peer"] > 40) {
						if( $ratio <= 0.25  ) {
							help(pic("4.png"),_btmedium.$spd,_btperformance);

						}elseif( $ratio <= 0.50  ) {
							help(pic("5.png"),_btmedium.$spd,_btperformance);

						}elseif( $ratio <= 0.75  ) {
							help(pic("6.png"),_bteasy.$spd,_btperformance);

						} else {
							help(pic("7.png"),_bteasy.$spd,_btperformance);

						}
					} elseif ( $row["tot_peer"] > 15 ) {
						if( $ratio <= 0.25  ) {
							help(pic("4.png"),_btmedium.$spd,_btperformance);

						}elseif( $ratio <= 0.50  ) {
							help(pic("5.png"),_btmedium.$spd,_btperformance);

						}elseif( $ratio <= 0.75  ) {
							help(pic("6.png"),_bteasy.$spd,_btperformance);

						} else {
							help(pic("7.png"),_bteasy.$spd,_btperformance);

						}
					} else {
						if( $ratio <= 0.25  ) {
							help(pic("4.png"),_btmedium.$spd,_btperformance);

						}elseif( $ratio <= 0.50  ) {
							help(pic("5.png"),_btmedium.$spd,_btperformance);

						}elseif( $ratio <= 0.75  ) {
							help(pic("6.png"),_bteasy.$spd,_btperformance);

						} else {
							help(pic("7.png"),_bteasy.$spd,_btperformance);

						}
					}
                }
        }
        echo "</tbody></table>";
        CloseTable();
        return;
}
?>