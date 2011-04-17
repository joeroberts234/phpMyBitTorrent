<?php
include("header.php");
require_once 'editTorrent.php';
 
/***********************
    Get torrent info
***********************/
if (isset($filex)){
$errmsg = Array();
$f = $_FILES["filex"];
$fname = unesc($f["name"]);
if (empty($fname))
        $errmsg[] = _btemptyfname;
if (!is_filename($fname))
        $errmsg[] = _btinvalidfname;
if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches))
        $errmsg[] = _btfnamenotorrent;
if (count($errmsg) > 0)
        bterror($errmsg,_btupload);
$tmpname = $f["tmp_name"];

if (!is_uploaded_file($tmpname))
        $errmsg[] = _bterrnofileupload;
if (!filesize($tmpname))
        $errmsg[] = _btemptyfile;

#Return Error
if (count($errmsg) > 0)
        bterror($errmsg,_btuploaderror);
#File read
require_once("include/bdecoder.php");
require_once("include/bencoder.php");
$pagetorrent = "";
$fp = @fopen($tmpname,"rb");
while (!@feof($fp)) {
        $pagetorrent .= @fread($fp,1000);
}
@fclose($fp);
$torrenta = Bdecode($pagetorrent);
unset($pagetorrent);
$torrentpath = $torrent_dir."/".$fname;
if (file_exists($torrentpath)) unlink($torrentpath);
$fp = fopen($torrentpath,"wb");
fwrite($fp,Bencode($torrenta));
fclose($fp);
@unlink($tmpname);
$torrent = new Torrent($torrentpath);
echo "<pre>\nPrivate: ", $torrent->is_private() ? 'yes' : 'no', 
    "\nAnnounce: ", $torrent->announce(), 
    "\nName: ", $torrent->name(), 
    "\nComment: ", $torrent->comment(), 
    "\nPiece_length: ", $torrent->piece_length(), 
    "\nSize: ", $torrent->size( 2 ),
    "\nHash info: ", $torrent->hash_info(),
    "\nStats: ";
    var_dump( $torrent->scrape() );
    echo "\nContents: ";
    print_r( $torrent->content() );
    //echo "\nSource data: ",  $torrent;
 
/***********************
    Create a new torrent
***********************/
//$torrent = new Torrent( array( 'test.mp3', 'test.jpg' ), 'http://torrent.tracker/announce' );
//Send it to the browser 
//$torrent->send();
//Alternatively, you can also save it as a new file
//file_put_contents('new.torrent', (string) $torrent);
}else{
OpenTable(_btupload);

if (!$stealthmode) echo "<p>" . _btofficialurl." <b>".$announce_url."</b></p>\n";
include'include/textarea.php';
//echo "<p>"._btseeded."</p>";
echo "<form enctype=\"multipart/form-data\" action=\"fixtorrent.php\" method=\"post\" id=\"data\" name=\"formdata\">\n\n";
echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".$max_torrent_size."\" />\n";
echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\">\n";
echo "<tr><td><p>"._btupfile."</p></td><td><p><input type=\"file\" name=\"filex\" size=\"60\" /></p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
echo "<tr><td><p>"._bttorrentname."</p></td><td><p><input type=\"text\" name=\"namex\" size=\"80\" /><br />("._btfromtorrent. "<b>"._btdescname."</b>)</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
echo "<tr><td><p>"._btdescription."</p></td>";
echo '<td>';
echo $textarea->quick_bbcode('formdata','descr');
echo $textarea->input('descr');
echo "</table></td></tr>\n";
echo "</table><hr /><input type=\"submit\" value=\""._btfsend."\"></form>\n";
CloseTable();
}
include("footer.php");
?>