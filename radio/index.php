<?php
define("RADIO_BASE",".././");
/* -----------------8/23/2009-----------------
Shoutcast Status Full 1.9

This is a Nice hack to add Shoutcast Status on your site.
Hope it helps !!!  Zachariah @ http://www.szone.us

SHOUTcast is a free-of-charge audio homesteading solution. It permits anyone
on the internet to broadcast audio from their PC to listeners across the
Internet or any other IP-based network (Office LANs, college campuses, etc.).
http://www.shoutcast.com

=======================================================*/
require ("config.php");
require ("players.php");
if (!$scfp) {
// If server is off line show template (no connect)
  echo '<link rel="stylesheet" href="style.css" type="text/css">
					<title>' . $scdef . ': ' . $servertitle . '</title>
					<body>
					<table class="tborders" cellpadding="6" cellspacing="1" width="100%" border="0">
							<tr>
								<td class="thead" width="100%" colspan="6"><div class="smallfont"><b>' . $scdef . '  - Offline</b></div></td>
							</tr>
							<tr>
								<td rowspan="3" class="alt2s" align="center"><img src="images/radio.gif" alt="" /></td>
								<td valign="top" align="left" class="alt1">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td width="50%" class="alt2s" align="center">Currently our shoutcast server is down. </td>
											<td rowspan="2" width="50%" align="center"><img border="0" src="images/shoutcast_off.gif" alt="Server Down" vspace="5" /><br /><div class="smallfont"><b>' . $scdef . ' is down.</b></div></td>
										</tr>
										<tr>
			     						<td width="50%">&#160;</td>
										</tr>
									</table>
								</td>
							</tr>
					</table>
					</body>';
}
else {
// If server is on line show template (Off Line / On-Line)
  if ($streamstatus == "1") {
// On-line
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<link rel="stylesheet" href="style.css" type="text/css" />
								<title>' . $scdef . ': ' . $servertitle . '</title>
								<body>
								<script type="text/javascript">
									function scastmp(){
										scastmpWindow = window.open("players.php?do=mp","mp","width=360,height=80");
									}
									function scastrp(){
										scastrpWindow = window.open("players.php?do=rp","rp","width=420,height=160");
									}
									function scastqt(){
										scastqtWindow = window.open("players.php?do=qt","qt","width=330,height=50");
									}
									</script>
								<table width="100%" class="tborders" cellpadding="6" cellspacing="1" border="0">
									<tr>
										<td class="thead" width="100%" colspan="6"><div><b>' . $scdef . ': ' . $servertitle . ' (' . $currentlisteners . '/' . $maxlisteners . ' @ ' . $bitrate . ' kbs)</b></div></td>
									</tr>
										<td rowspan="3" class="alt2s" align="center"><img src="images/radio.gif" alt="' . $scdef . ': ' . $servertitle . ' (' . $currentlisteners . '/' . $maxlisteners . ' @ ' . $bitrate . ' kbs)" /></td>
										<td valign="top" align="left" class="alt1">
								<table border="0" cellpadding="1" cellspacing="0" width="100%">
									<tr>
										<td class="alt2s"><b>Tune-In:</b></td>
										<td width="5"> </td>
										<td width="50%" class="alt2s"><b>Now Playing:</b></td>
									</tr>
									<tr >
										<td width="50%" style="padding-left: 5px><a href=" colspan="2" class="smallfont" nowrap>
											<img src="images/im_winamp.gif" alt="Listen w/ Winamp" border="0" hspace="2" /><a href="' . $listenamp . '">Winamp</a>
											<img src="images/im_real.gif" alt="Listen w/ Realplayer" border="0" hspace="2" /><a href="javascript:scastrp()">Real</a>
											<img src="images/im_winmp.gif" alt="Listen w/ Media Player" border="0" hspace="2" /><a href="javascript:scastmp()">Media</a>
											<a href="javascript:scastqt()"><img src="images/im_qt.gif" alt="Listen w/ Quicktime" border="0" hspace="2" /></a>
											<a href="javascript:scastqt()">Quicktime</a>
										</td>
										<td width="50%" style="padding-left: 5px" class="smallfont"><tt><marquee scrolldelay="100" scrollamount="5">+ ' . $song[0] . '</marquee></tt></td>
									</tr>
									<tr>
										<td><br /></td>
									</tr>
										<table border="0" cellpadding="1" cellspacing="0" width="100%">
											<tr>
												<td width="100%" colspan="3"> </td>
											</tr>
											<tr>
												<td class="alt2s" ><b>Stream Info:</b></td>
												<td width="5">&#160;</td>
												<td width="50%" class="alt2s" align="left"><b>Last 19 Songs:</b></td>
											</tr>
											<tr>
												<td valign="top" rowspan="4" style="padding-left: 5px" colspan="2" class="smallfont">
													<div >Most Ever: <b>' . $peaklisteners . '</b><br />Current Listening: <b>' . $currentlisteners . '/' . $maxlisteners . '</b><br />Speed: <b>' . $bitrate . '</b> kbs<br />Media Type: <b>' . $content . '</b><br />Hit Count: <b>' . $streamhits . '</b><br />Avj. Time: <b>' . $averagemin . '</b></div>
													<br /><hr width="90%" size="1" />
													<img src="images/im_genre.gif" alt="Genre" /> ' . $servergenre . '<br /><img src="images/im_icq.gif" alt="ICQ the DJ" /> ' . $icq . '<br /><img src="images/im_aim.gif" alt="AIM the DJ" /> ' . $aim . '<br /><img src="images/im_mirc.gif" alt="IRC Chat with the DJ" /> <a href="' . $irclink . '">' . $ircsite . '</a> : #' . $irc . '<br />
												</td>
											</tr>
											<tr>
												<td width="50%" valign="top" rowspan="5" style="padding-left: 5px" class="smallfont"><div ><tt>+ ' . $song[1] . '<br />+ ' . $song[2] . '<br />+ ' . $song[3] . '<br />+ ' . $song[4] . '<br />+ ' . $song[5] . '<br />+ ' . $song[6] . '<br />+ ' . $song[7] . '<br />+ ' . $song[8] . '<br />+ ' . $song[9] . '<br />+ ' . $song[10] . '<br />+ ' . $song[11] . '<br />+ ' . $song[12] . '<br />+ ' . $song[13] . '<br />+ ' . $song[14] . '<br />+ ' . $song[15] . '<br />+ ' . $song[16] . '<br />+ ' . $song[17] . '<br />+ ' . $song[18] . '<br />+ ' . $song[19] . '</tt></div></td>
											</tr>
										</table>
										</td>
									</tr>
								</table></body>';
  }
  else {
// Off-Line
    echo '<link rel="stylesheet" href="style.css" type="text/css">
                <title>' . $scdef . ': ' . $servertitle . '</title>
                <table class="tborders" cellpadding="6" cellspacing="1" border="0">
                  <tr>
                    <td class="thead" width="100%" colspan="6"><div class="smallfont"><b>' . $scdef . '  - Offline</b></div></td>
                  </tr>
                  <tr>
                    <td rowspan="3" class="alt2s" align="center"><img src="images/radio.gif" alt="" /></td>
                    <td valign="top" align="left" class="alt1">
                      <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                          <td width="50%" class="alt2s" align="center">Currently our shoutcast server is down. </td>
                          <td rowspan="2" width="50%" align="center"><img border="0" src="images/shoutcast_off.gif" alt="Server Down" vspace="5" /><br /><div class="smallfont"><b>' . $scdef . ' is down.</b></div></td>
                        </tr>
                        <tr>
                         <td width="50%">&#160;</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>';
  }
}
?>