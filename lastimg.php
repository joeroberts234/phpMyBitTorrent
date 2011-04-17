<?php

if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
include("header.php");
OpenTable("Latest Posters");

	?>
	<style type="text/css">

	#marqueecontainer{
	position: relative;
	/*width: 200px; marquee width */
	height: 1000px; /*marquee height */
	background-color: transparent;
	overflow: hidden;
	/*border: 3px solid orange;*/
	padding: 2px;
	padding-left: 4px;
	}

	</style>

	<script type="text/javascript">

	/***********************************************
	* Cross browser Marquee II- © Dynamic Drive (www.dynamicdrive.com)
	* This notice MUST stay intact for legal use
	* Visit http://www.dynamicdrive.com/ for this script and 100s more.
	***********************************************/

	var delayb4scroll=1000 //Specify initial delay before marquee starts to scroll on page (2000=2 seconds)
	var marqueespeed=1 //Specify marquee scroll speed (larger is faster 1-10)
	var pauseit=1 //Pause marquee onMousever (0=no. 1=yes)?

	////NO NEED TO EDIT BELOW THIS LINE////////////

	var copyspeed=marqueespeed
	var pausespeed=(pauseit==0)? copyspeed: 0
	var actualheight=''

	function scrollmarquee(){
	if (parseInt(cross_marquee.style.top)>(actualheight*(-1)+8))
	cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+"px"
	else
	cross_marquee.style.top=parseInt(marqueeheight)+8+"px"
	}

	function initializemarquee(){
	cross_marquee=document.getElementById("vmarquee")
	cross_marquee.style.top=0
	marqueeheight=document.getElementById("marqueecontainer").offsetHeight
	actualheight=cross_marquee.offsetHeight
	if (window.opera || navigator.userAgent.indexOf("Netscape/7")!=-1){ //if Opera or Netscape 7x, add scrollbars to scroll and exit
	cross_marquee.style.height=marqueeheight+"px"
	cross_marquee.style.overflow="scroll"
	return
	}
	setTimeout('lefttime=setInterval("scrollmarquee()",10)', delayb4scroll)
	}

	if (window.addEventListener)
	window.addEventListener("load", initializemarquee, false)
	else if (window.attachEvent)
	window.attachEvent("onload", initializemarquee)
	else if (document.getElementById)
	window.onload=initializemarquee


	</script>

	<div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
	<div id="vmarquee" style="position: absolute; width: 100%;">

	<!--YOUR SCROLL CONTENT HERE-->
	<?php
	$news = mysql_query("SELECT id, name, added, post_img FROM ".$db_prefix."_torrents WHERE banned = 'no' AND visible='yes'")or sqlerr(__FILE__, __LINE__);

	if (mysql_num_rows($news) > 0) {

		print("<table align=center cellpadding=0 cellspacing=0 width=100% border=0>");

		while ($row2 = mysql_fetch_array($news)) {
			$tor = $row2['0'];
			$altname = $row2['1'];
			//$date_time=get_date_time(time()-(3600*168)); // the 24 is the hours you want listed change by whatever you want
			$orderby = "ORDER BY ".$db_prefix."_torrents.id DESC"; //Order

			$limit = "LIMIT 100"; //Limit

			$where = "WHERE banned = 'no' AND visible='yes' AND ".$db_prefix."_torrents.id='$tor'";

			$res = mysql_query("SELECT ".$db_prefix."_torrents.id, ".$db_prefix."_torrents.post_img, ".$db_prefix."_torrents.screan1, ".$db_prefix."_torrents.screan2, ".$db_prefix."_torrents.screan3, ".$db_prefix."_torrents.screan4, ".$db_prefix."_torrents.added, ".$db_prefix."_categories.name AS cat_name FROM ".$db_prefix."_torrents LEFT JOIN ".$db_prefix."_categories ON ".$db_prefix."_torrents.category = ".$db_prefix."_categories.id $where  $orderby $limit")or sqlerr(__FILE__, __LINE__);
			$row = mysql_fetch_array($res);
			$cat = $row['cat_name'];
                        $simg1 = $row['screan1'];
                        $simg2 = $row['screan2'];
                        $simg3 = $row['screan3'];
                        $simg4 = $row['screan4'];
			$img1 = "<a href='$siteurl/details.php?id=$row[id]'><img border='0' src='$row[post_img]' alt=\"$altname / $cat\" width='130' onmouseover=\" return overlib('<center><h1><b>screan Shots:</b></h1></center><hr><table width=100%><br><tr><td><img src=$simg1 width=250 border=0></td><td><img src=$simg2 width=250 border=0><img src=$simg3 width=250 border=0><img src=$simg4 width=250 border=0></td></tr></table>', CENTER, HEIGHT, 250, WIDTH, 300);\" onmouseout=\"return nd();\"></a><br>";
                        $img2 = "<a href='$siteurl/details.php?id=$row[id]'><img border='0' src='$row[post_img]' alt=\"$altname / $cat\" width='130' onmouseover=\" return overlib('<center><h1><b>screan Shots:</b></h1></center><hr><table width=100%><br><br><br><br><br><tr><td><center><font color=red size=4><b>Sorry no screans available</b></font></center></td></tr></table>', CENTER, HEIGHT, 250, WIDTH, 300);\" onmouseout=\"return nd();\"></a><br>";
			if ($row["post_img"] != ""){
                        if ($row["screan1"]!=''){
				print("<tr><td align=center>". $img1 ."<BR></td></tr>");
                        }else{
                                print("<tr><td align=center>". $img2 ."<BR></td></tr>");
                         }
			}
                     
		//}

		print("</table>");

	}

		?>
		</div>
		</div>
		<?php
}
CloseTable();
include ("footer.php");
?>