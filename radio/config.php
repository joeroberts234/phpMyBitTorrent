<?php
/* -----------------8/23/2009-----------------
Shoutcast Status Full 1.9

This is a Nice hack to add Shoutcast Status on your site.
Hope it helps !!!  Zachariah @ http://www.szone.us

SHOUTcast is a free-of-charge audio homesteading solution. It permits anyone
on the internet to broadcast audio from their PC to listeners across the
Internet or any other IP-based network (Office LANs, college campuses, etc.).
http://www.shoutcast.com

=======================================================*/
//Configuration

$scdef = "Pirate";         // Default station name to display when server or stream is down
$scip = "0.0.0.0";              // ip or url of shoutcast server
$scport = "";                 // port of shoutcast server
$scpass = "";           // password to shoutcast server
$ircsite = "";    // IRC Server to host chat for listners
$file = RADIO_BASE."radio/shout.xml";            // file to write to. remember to chmod 777 to not get errors
$cache_tolerance = "120";         // How many seconds old the cache file can get
//End configuration


// ############################################################################################
// ##################  STOP !!! Only edit BELOW If you know what your doing  ##################
// ############################################################################################

//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);

// Shoutcast Server Stats
// Parses shoutcasts xml to make an effective stats thing for any website
if (!isset ($_REQUEST['do'])) {
//If not isset provide a dummy value here
  $_REQUEST['do'] = "";
}
// Check if Cache needs an update
if (file_exists($file)) {
  clearstatcache();
// filemtime info gets cached so we must ensure that the cache is empty
  $time_difference = time() - filemtime($file);
//   echo "$file was last modified: " . date ("F d Y H:i:s.", filemtime($file)) . "( " . $time_difference . " seconds ago) <br>" . "The cache is set to update every " . $cache_tolerance . " seconds.<br>";
}
else {
  $time_difference = $cache_tolerance;
// force update
}
// Parses shoutcasts xml to make an effective stats thing for any website
$scfp = fsockopen($scip, $scport, $errno, $errstr, 1);
// Connect to the server
if ($scfp) {
  if ($time_difference >= $cache_tolerance) {
// update the cache if need be
// Get XML feed from server
    if (empty ($scsuccs)) {
      fputs($scfp, "GET /admin.cgi?pass=$scpass&mode=viewxml HTTP/1.0\r\nUser-Agent: SHOUTcast Song Status (Mozilla Compatible)\r\n\r\n");
      while (!feof($scfp)) {
        $xmlfeed = fgets($scfp, 8192);
      }
      fclose($scfp);
    }
// Output to cache file
    $tmpfile = @fopen($file, "w+");
    $fp = @fwrite($tmpfile, $xmlfeed);
    @fclose($tmpfile);
    flush();
// Outputs the cached file after new data
    $xmlcache = fopen($file, "r");
    $page = '';
    if ($xmlcache) {
      while (!feof($xmlcache)) {
        $page .= fread($xmlcache, 8192);
      }
      fclose($xmlcache);
    }
  }
  else {
// outputs the cached file
    $xmlcache = fopen($file, "r");
    $page = '';
    if ($xmlcache) {
      while (!feof($xmlcache)) {
        $page .= fread($xmlcache, 8192);
      }
      fclose($xmlcache);
    }
  }
  $loop = array("AVERAGETIME", "CURRENTLISTENERS", "PEAKLISTENERS", "MAXLISTENERS", "SERVERGENRE", "SERVERURL", "SERVERTITLE", "SONGTITLE", "SONGURL", "IRC", "ICQ", "AIM", "WEBHITS", "STREAMHITS", "LISTEN", "STREAMSTATUS", "BITRATE", "CONTENT", "LISTENER");
//define all the variables to get (delte any ones you don't want)
  $y = '0';
  while (!empty ($loop[$y])) {
    $pageed = ereg_replace(".*<$loop[$y]>", "", $page);
    $scphp = strtolower($loop[$y]);
    $$scphp = ereg_replace("</$loop[$y]>.*", "", $pageed);
    if ($loop[$y] == 'SERVERGENRE' || $loop[$y] == 'SERVERTITLE' || $loop[$y] == 'SONGTITLE' || $loop[$y] == 'SERVERTITLE')
      $$scphp = urldecode($$scphp);
    ;
    $y++;
  }
//end intro xml elements
//get song info and history
  $pageed = ereg_replace(".*<SONGHISTORY>", "", $page);
  $pageed = ereg_replace("<SONGHISTORY>.*", "", $pageed);
  $songatime = explode("<SONG>", $pageed);
  $r = 1;
  while (!empty ($songatime[$r])) {
    $t = $r - 1;
    $playedat[$t] = ereg_replace(".*<PLAYEDAT>", "", $songatime[$r]);
    $playedat[$t] = ereg_replace("</PLAYEDAT>.*", "", $playedat[$t]);
    $song[$t] = ereg_replace(".*<TITLE>", "", $songatime[$r]);
    $song[$t] = ereg_replace("</TITLE>.*", "", $song[$t]);
    $song[$t] = urldecode($song[$t]);
    $dj[$t] = ereg_replace(".*<SERVERTITLE>", "", $page);
    $dj[$t] = ereg_replace("</SERVERTITLE>.*", "", $pageed);
    $r++;
  }
//end song info
  $averagemin = "";
  $hours = intval(intval($averagetime) / 3600);
  $averagemin .= ($hours) ? str_pad($hours, 2, "0", STR_PAD_LEFT) : $hours . 'h&nbsp;';
  $minutes = intval(($averagetime / 60) % 60);
  $averagemin .= str_pad($minutes, 2, "0", STR_PAD_LEFT) . 'm&nbsp;';
  $seconds = intval($averagetime % 60) . 's';
  $averagemin .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

  $irclink = 'irc://' . $ircsite . '/' . $irc . '';
  $listenamp = 'http://' . $scip . ':' . $scport . '/listen.pls';
  $listenlnk = 'http://' . $scip . ':' . $scport . '';
}
?>