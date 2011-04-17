<?php
include("header.php");
  function get_ratio_color($ratio)
  {
    if ($ratio < 0.1) return "#ff0000";
    if ($ratio < 0.2) return "#ee0000";
    if ($ratio < 0.3) return "#dd0000";
    if ($ratio < 0.4) return "#cc0000";
    if ($ratio < 0.5) return "#bb0000";
    if ($ratio < 0.6) return "#aa0000";
    if ($ratio < 0.7) return "#990000";
    if ($ratio < 0.8) return "#880000";
    if ($ratio < 0.9) return "#770000";
    if ($ratio < 1) return "#660000";
    return "#000000";
  }

if (!$user->user) loginrequired("user");
function begin_frame($caption = "-", $align = "justify"){

print("<br /><table cellpadding=0 cellspacing=0 border=0 width=95% align=center>\n"
		."\t<tr>\n"
		."\t\t<TD class=frame_top_left></TD>\n"
		."\t\t<TD class=frame_top align=center><b>$caption</b></TD>\n"
		."\t\t<TD class=frame_top_right></TD>\n"
		."\t</tr>\n"
		."\t<tr>\n"
		."\t\t<TD class=frame_middle_left><span class=space></span></TD>\n"
		."\t\t<TD class=frame_middle width=100% align=$align valign=top><br>");
}

//ATTACH FRAME
function attach_frame($padding = 0) {
    print("\n");
}

//END FRAME
function end_frame() {
print("\t\t</td>\n"
		."\t\t<td class=frame_middle_right><span class=space></span></TD></td>\n"
		."\t</tr>\n"
		."\t<tr>\n"
		."\t\t<td class=frame_bottom_left><span class=space></span></TD></td>\n"
		."\t\t<td class=frame_bottom></TD></td>\n"
		."\t\t<td class=frame_bottom_right><span class=space></span></TD></td>\n"
		."\t</tr>\n"
		."</table>");
}

function get_dt_num()
{
  return gmdate("YmdHis");
}

function get_row_count($table, $suffix = "")
{
  if ($suffix)
    $suffix = " $suffix";
  ($r = mysql_query("SELECT COUNT(*) FROM $table$suffix")) or die(mysql_error());
  ($a = mysql_fetch_row($r)) or die(mysql_error());
  return $a[0];
}

function tr($x,$y,$noesc=0) {
    if ($noesc)
        $a = $y;
    else {
        $a = htmlspecialchars($y);
        $a = str_replace("\n", "<br />\n", $a);
    }
    print("<tr><td class=\"heading\" valign=\"top\" align=\"right\">$x</td><td valign=\"top\" align=left>$a</td></tr>\n");
}


function tr2()
{
$a = func_get_args(tr2);
for($i=0;$i< (func_num_args(tr2)/2)+1;$i++)
 $row .= "<td ".$a[$i].">".$a[++$i]."</td>";
echo "<tr>".$row."</tr>";
}



function usertable($res, $frame_caption) {
  print ("<div align=left><B>$frame_caption </B><BR>");
    if (mysql_num_rows($res) > 0)
	{
	print("<table border=1 cellspacing=0 cellpadding=2 class=table_table>\n");
  $num = 0;
  while ($a = mysql_fetch_assoc($res)) {
    ++$num;
    if ($a["uploaded"] == "0")
	  break;
    if ($a["downloaded"]) {
      $ratio = $a["uploaded"] / $a["downloaded"];
      $color = get_ratio_color($ratio);
      $ratio = number_format($ratio, 2);
      if ($color)
        $ratio = "<font color=$color>$ratio</font>";
    }
    else
      $ratio = "Inf.";
    if ($menu != "1") {
      echo "<tr>"
		."<td class=table_head>ACCOUNT RANK</td>"
		."<td class=table_head align=left>ACCOUNT USER</td>"
		."<td class=table_head>UPLOADED</td>"
		."<td class=table_head>DOWNLOADED</td>"
	    ."<td class=table_head align=right>RATIO</td>"
	    ."</tr>";
      $menu = 1;
    }
    print("<tr><td class=table_col1>$num</td><td class=table_col2 align=left><a href=user.php?op=profile&id=" . $a["id"] . "><b>" . $a["username"] .
          "</b></a></td><td class=table_col1 align=right>" . mksize($a["uploaded"]) .
          "</td><td class=table_col2 align=right>" . mksize($a["downloaded"]) .
          "</td><td class=table_col1 align=right>" . $ratio . "</td></tr>");
  }
  echo "</table></div>";
  	}else{
		echo "<font color=red>NOTHING TO SHOW</font></div>";
	}
}

function _torrenttable($res, $frame_caption) {
  print ("<div align=left><B>$frame_caption </B><BR>");
  if (mysql_num_rows($res) > 0)
	{
	  print("<table border=1 cellspacing=0 cellpadding=2 class=table_table>\n");
  $num = 0;
  while ($a = mysql_fetch_assoc($res)) {
      ++$num;
      if ($a["leechers"])
      {
        $r = $a["seeders"] / $a["leechers"];
        $ratio = "<font color=" . get_ratio_color($r) . ">" . number_format($r, 2) . "</font>";
      }
      else
        $ratio = "Inf.";
        if ($menu != "1") {
          echo "<tr>"
		      ."<td class=ttable_head>ACCOUNT RANK</td>"
		      ."<td class=ttable_head align=left>NAME</td>"
		      ."<td class=ttable_head align=right>COMPLETED</td>"
		      ."<td class=ttable_head align=right>SEEDS</td>"
		      ."<td class=ttable_head align=right>LEECH</td>"
		      ."<td class=ttable_head align=right>PEERS</td>"
	 	      ."<td class=ttable_head align=right>RATIO</td>"
 	          ."</tr>";
 	      $menu = 1;
        }
                $dispname = htmlspecialchars($a["name"]);
                $dispname = str_replace("_", " ", $dispname);
                $dispname = str_replace(".", " ", $dispname);
        print("<tr><td class=ttable_col1>$num</td><td class=ttable_col2 align=left><a   title=\"".$dispname."\" href=details.php?id=" . $a["id"] . "&hit=1><b>" .
        ((strlen($dispname) <= 25) ? $dispname : substr($dispname,0,24)."...")."</b></a></td><td class=ttable_col1 align=center>" . number_format($a["completed"]) .
        "</td><td class=ttable_col2 align=center>" . number_format($a["seeders"]) .
        "</td><td class=ttable_col1 align=center>" . number_format($a["leechers"]) .
        "</td><td class=ttable_col2 align=center>" . ($a["leechers"] + $a["seeders"]) .
        "</td><td class=ttable_col1 align=right>$ratio</td>\n");
    }
    echo "</table></div>";
	}else{
		echo "<font color=red>NOTHING_TO_SHOW</font></div>";
	}
}

function countriestable($res, $frame_caption) {
    OpenTable2($frame_caption);
	  if (mysql_num_rows($res) > 0)
	{
    print("<table border=1 cellspacing=0 cellpadding=2 class=table_table>\n");
	
	echo "<tr>";
	echo "<td class=table_head>ACCOUNT_RANK</td>";
	echo "<td class=table_head align=left>COUNTRY</td>";
	echo "<td class=table_head align=right>USERS</td>";
	echo "</tr>";
	
    $num = 0;
    while ($a = mysql_fetch_assoc($res))
    {
      ++$num;
      print("<tr><td class=table_col1>$num</td>
	  <td class=table_col2 align=left><img align=center src=images/flag/$a[flagpic]>&nbsp;<b>$a[name]</b></td>
	  <td align=right class=table_col1>$a[num]</td></tr>\n");
    }
    echo "</table>";
		CloseTable2();

		}else{
		echo "<font color=red>NOTHING_TO_SHOW</font></div>";
	}
}
function postertable($res, $frame_caption) {
    OpenTable2($frame_caption);
	  if (mysql_num_rows($res) > 0)
	{
	print("<table border=1 cellspacing=0 cellpadding=2 class=table_table>\n");
	
	echo "<tr>";
	echo "<td class=table_head width=80>ACCOUNT_RANK</td>";
	echo "<td class=table_head align=left>ACCOUNT_USER</td>";
	echo "<td class=table_head align=left width=100>TORRENTS_POSTED</td>";
	echo "</tr>";
	
    $num = 0;
    while ($a = mysql_fetch_assoc($res))
    {
      ++$num;
      print("<tr><td class=table_col1>$num</td><td class=table_col2 align=left><a href=user.php?op=profile&id=$a[id]><b>$a[username]</b></td><td align=right class=table_col1>$a[num]</td></tr>\n");
    }
    echo "</table>";
	CloseTable2();
		}else{
		echo "<font color=red>NOTHING_TO_SHOW</font>";
		CloseTable2();
	}
}

//main stats here
$a = @mysql_fetch_assoc(@mysql_query("SELECT id,username FROM ".$db_prefix."_users WHERE active = '1' ORDER BY id DESC LIMIT 5"));
if ($user->user)
  $latestuser = "<a href=user.php?op=profile&id=" . $a["id"] . ">" . $a["username"] . "</a>";
else
  $latestuser = "<b>$a[username]</b>";
$registered = number_format(get_row_count("".$db_prefix."_users"));
$torrents = number_format(get_row_count("".$db_prefix."_torrents"));

$result = mysql_query("SELECT SUM(downloaded) AS totaldl FROM ".$db_prefix."_users") or sqlerr(__FILE__, __LINE__); 

while ($row = mysql_fetch_array ($result)) 
{ 
$totaldownloaded      = $row["totaldl"]; 
} 
$result = mysql_query("SELECT SUM(uploaded) AS totalul FROM ".$db_prefix."_users") or sqlerr(__FILE__, __LINE__); 

while ($row = mysql_fetch_array ($result)) 
{ 
$totaluploaded      = $row["totalul"]; 
}
$seeders = get_row_count("".$db_prefix."_peers", "WHERE seeder='yes'");
$leechers = get_row_count("".$db_prefix."_peers", "WHERE seeder='no'");
$localtorrent = number_format(get_row_count("".$db_prefix."_torrents", "WHERE tracker IS NULL AND exeem IS NOT NULL"));
$externaltorrent = number_format(get_row_count("".$db_prefix."_torrents", "WHERE tracker IS NOT NULL"));

$usersactive = 0;
if ($leechers == 0)
  $ratio = "100";
else
  $ratio = round($seeders / $leechers * 100);
 if ($ratio < 20)
    $ratio = "<font class=red>" . $ratio . "%</font>";
 else
	$ratio .= "%";
$peers = number_format($seeders + $leechers);
$seeders = number_format($seeders);
$leechers = number_format($leechers);
$totaltoday = $arr3[0];
// start count registered today
$res = mysql_query("SELECT COUNT(*) FROM ".$db_prefix."_users WHERE UNIX_TIMESTAMP(" . get_dt_num() . ") - UNIX_TIMESTAMP(regdate) < 86400");
$arr44 = mysql_fetch_row($res);
$regtoday = $arr44[0];

function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}
$time_start = getmicrotime();
//end here

///////////////////////////////////////// PAGE LAYOUT //////////////////////////////

OpenTable("Extra Stats");


echo "<div align=left><font class=stats>WELCOME NEW :  $latestuser</font>";
echo "<br><font class=stats>TOTAL USERS : $registered </font>";
echo "<br><font class=stats>NEWUSERS TODAY : $regtoday </font>";
echo "<br><font class=stats>ACTIVE TRANSFERS :  $peers </font>";
ECHO "<br><font class=stats>DOWNLOADED :  ".mksize($totaldownloaded)." </FONT>";
ECHO "<br><font class=stats>UPLOADED :  ".mksize($totaluploaded)." </FONT>";
echo "<br><font class=stats>TRACKING :  $torrents  Torrents</font>";
echo "<br><font class=stats>Local Torrents :  $localtorrent  Torrents </font>";
echo "<br><font class=stats>External Torrents :  $externaltorrent  Torrents </font>";
echo "<br><font class=stats>SEEDS :  $seeders </font>";
echo "<br><font class=stats>LEECH :  $leechers </font>";
echo "<br><font class=stats>SEED RATIO :  $ratio </font>";
echo "<br><br></div>";



  $r = mysql_query("SELECT ".$db_prefix."_users.id, ".$db_prefix."_users.username, COUNT(".$db_prefix."_torrents.owner) as num FROM ".$db_prefix."_torrents LEFT JOIN ".$db_prefix."_users ON ".$db_prefix."_users.id = ".$db_prefix."_torrents.owner GROUP BY owner ORDER BY num DESC LIMIT 10") or sqlerr();
  postertable($r, "Top 10 Posters"); echo "<br>";

  $r = mysql_query("SELECT * FROM ".$db_prefix."_users  ORDER BY uploaded DESC LIMIT 10") or die;
  usertable($r, "Top 10 Uploaders"); echo "<br>";

  $r = mysql_query("SELECT * FROM ".$db_prefix."_users  ORDER BY downloaded DESC LIMIT 10") or die;
  usertable($r, "Top 10 Leechers"); echo "<br>";

  $r = mysql_query("SELECT * FROM ".$db_prefix."_users WHERE downloaded > 104857600 ORDER BY uploaded - downloaded DESC LIMIT 10") or die(mysql_error());
  usertable($r, "Top 10 Best Sharers <font class=small>(with minimum 100 MB downloaded)</font>"); echo "<br>";

  $r = mysql_query("SELECT * FROM ".$db_prefix."_users WHERE downloaded > 104857600   ORDER BY downloaded - uploaded DESC, downloaded DESC LIMIT 10") or die(mysql_error());
  usertable($r, "Top 10 Worst Sharers <font class=small>(with minimum 100 MB downloaded)</font>"); echo "<br>";

  $r = mysql_query("SELECT * FROM ".$db_prefix."_torrents ORDER BY seeders + leechers DESC, seeders DESC, added ASC LIMIT 10") or sqlerr();
  _torrenttable($r, "Top 10 Most Active Torrents</font>"); echo "<br>";

  $r = mysql_query("SELECT * FROM ".$db_prefix."_torrents WHERE seeders >= 5 ORDER BY seeders / leechers DESC, seeders DESC, added ASC LIMIT 10") or sqlerr();
  _torrenttable($r, "Top 10 Best Seeded Torrents <font class=small>(with minimum 5 seeders)</font>"); echo "<br>";

  $r = mysql_query("SELECT * FROM ".$db_prefix."_torrents WHERE leechers >= 5 AND completed > 0 ORDER BY seeders / leechers ASC, leechers DESC LIMIT 10") or sqlerr();
  _torrenttable($r, "Top 10 Worst Seeded Torrents <font class=small>(with minimum 5 leechers, excluding unsnatched torrents)</font>"); echo "<br>";
  
    $r = mysql_query("SELECT * FROM ".$db_prefix."_torrents WHERE  completed > 0 ORDER BY seeders / leechers ASC, completed DESC LIMIT 10") or sqlerr();
  _torrenttable($r, "Top 10 Most Completed Torrents <font class=small></font>"); echo "<br>";

  $r = mysql_query("SELECT ".$db_prefix."_countries.name, flagpic, COUNT(".$db_prefix."_users.country) as num FROM ".$db_prefix."_countries LEFT JOIN ".$db_prefix."_users ON ".$db_prefix."_users.country = ".$db_prefix."_countries.id GROUP BY ".$db_prefix."_countries.name ORDER BY num DESC LIMIT 10") or sqlerr();
  countriestable($r, "<font class=small>Top 10 Countries</font>");echo "<br><br>";

  CloseTable();
include ("footer.php");
?>