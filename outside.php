<?php
include('header.php');
include 'lastRSS.php';
?>
<SCRIPT LANGUAGE="JavaScript">
<!-- 	
// by Nannette Thacker
// http://www.shiningstar.net
// This script checks and unchecks boxes on a form
// Checks and unchecks unlimited number in the group...
// Pass the Checkbox group name...
// call buttons as so:
// <input type=button name="CheckAll"   value="Check All"
	//onClick="checkAll(document.myform.list)">
// <input type=button name="UnCheckAll" value="Uncheck All"
	//onClick="uncheckAll(document.myform.list)">
// -->

<!-- Begin

function checkAll(field)
{
for (i = 0; i < field.length; i++)
	field[i].checked = true ;
}

function uncheckAll(field)
{
for (i = 0; i < field.length; i++)
	field[i].checked = false ;
}
//  End -->
</script>
<?php
//unset($GLOBALS['PHP_SELF']);
// create lastRSS object
$rss = new lastRSS;
        $dict555  = array('á', 'ä', 'c', 'd',
            'é', 'e', 'í', 'l', 'l',
            'n', 'ô', 'ó', 'š', 'r',
            'ú', 'u', 't', 'ý', 'ž',
            'Á', 'Ä', 'C', 'D', 'É',
            'E', 'Í', 'L', 'L', 'N',
            'Ô', 'Ó', 'Š', 'R', 'Ú',
            'U', 'T', 'Ý', 'Ž', 'â');
// setup transparent cache      <span class="first"><span id="checkall">Check All</span> - <span id="clearall">Clear All</span></span>
$rss->cache_dir = './newsCache';
$rss->cache_time = 3600*24*7; // one hour
function cp1250_to_utf2($text){
        $dict  = array('á', 'ä', 'c', 'd',
            'é', 'e', 'í', 'l', 'l',
            'n', 'ô', 'ó', 'š', 'r',
            'ú', 'u', 't', 'ý', 'ž',
            'Á', 'Ä', 'C', 'D', 'É',
            'E', 'Í', 'L', 'L', 'N',
            'Ô', 'Ó', 'Š', 'R', 'Ú',
            'U', 'T', 'Ý', 'Ž', 'â');
        return $text = str_replace($dict, "", text);
    }
	function hex_to_base32($hex) {
  $b32_alpha_to_rfc3548_chars = array(
    '0' => 'A',
    '1' => 'B',
    '2' => 'C',
    '3' => 'D',
    '4' => 'E',
    '5' => 'F',
    '6' => 'G',
    '7' => 'H',
    '8' => 'I',
    '9' => 'J',
    'a' => 'K',
    'b' => 'L',
    'c' => 'M',
    'd' => 'N',
    'e' => 'O',
    'f' => 'P',
    'g' => 'Q',
    'h' => 'R',
    'i' => 'S',
    'j' => 'T',
    'k' => 'U',
    'l' => 'V',
    'm' => 'W',
    'n' => 'X',
    'o' => 'Y',
    'p' => 'Z',
    'q' => '2',
    'r' => '3',
    's' => '4',
    't' => '5',
    'u' => '6',
    'v' => '7'
  );
  $b32_alpha = "";
  for ($pos = 0; $pos < strlen($hex); $pos += 10) {
    $hs = substr($hex,$pos,10);
    $b32_alpha_part = base_convert($hs,16,32);
    $expected_b32_len = strlen($hs) * 0.8;
    $actual_b32_len = strlen($b32_alpha_part);
    $b32_padding_needed = $expected_b32_len - $actual_b32_len;
    for ($i = $b32_padding_needed; $i > 0; $i--) {
      $b32_alpha_part = '0' . $b32_alpha_part;
    }
    $b32_alpha .= $b32_alpha_part;
  }
  $b32_rfc3548 = "";
  for ($i = 0; $i < strlen($b32_alpha); $i++) {
    $b32_rfc3548 .= $b32_alpha_to_rfc3548_chars[$b32_alpha[$i]];
  }
  return $b32_rfc3548;
}
function take_snatch($namex, $link, $descr, $torrent_category, $ownertype = 1){
global $autoscrape, $db, $db_prefix, $user, $force_upload, $torrent_dir, $force_upload, $announce_url;
@ini_set("upload_max_filesize",$max_torrent_size);
@set_time_limit(60);
@ini_set("memory_limit","64M");


require_once("include/bdecoder.php");
require_once("include/bencoder.php");


$torrent_edited = false;

$errmsg = Array();

if (!isset($link))
        $errmsg[] = "test5555";


$category = intval($torrent_category);
if ($category < 1) return bterror(_btnoselected,_btuploaderror,false);

$cats = catlist();
$in_cat = false;
while ($cat = each($cats) AND !$in_cat) {
        if ($category == $cat[1]["id"]) $in_cat = true;
}

if (!$in_cat) $errmsg[] = _btillegalcat;

$f = "./massupload/".$_FILES[$link];

/*#$f = $link;
$fname = unesc($f["name"]);

if (empty($fname))
        $errmsg[] = _btemptyfname;
if (!is_filename($fname))
        $errmsg[] = _btinvalidfname;
if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches))
        $errmsg[] = _btfnamenotorrent . $link . $fname;

$nf = $_FILES["nfox"];
$nfname = unesc($nf["name"]);
if ($nfname != "") {
        if (!is_filename($nfname))
                $errmsg[] = _btinvalidnfofname;
        if (!preg_match('/^(.+)\.nfo$/si', $nfname))
                $errmsg[] = _btfnamenonfo;
        if (!is_uploaded_file($nf["tmp_name"]))
                $errmsg[] = _bterrnonfoupload;
        if ($nf["size"] <= 0)
                $errmsg[] = _btemptyfile;
}

#Return Error
if (count($errmsg) > 0)
       return bterror($errmsg,_btupload);
*/
$shortfname = $torrentname = $matches[1];
if (!empty($namex))
        $torrentname = unesc($namex);

$tmpname = $link;

if (!is_uploaded_file($tmpname))
        $errmsg[] = _bterrnofileupload;
if (!filesize($tmpname))
        $errmsg[] = _btemptyfile;

#Return Error
#if (count($errmsg) > 0)
 #       return bterror($errmsg,_btuploaderror);


$uploader_host = gethostbyaddr($_SERVER["REMOTE_ADDR"]); //uploader's hostname

#File read
$pagetorrent = "";
$fp = @fopen($tmpname,"rb");
while (!@feof($fp)) {
        $pagetorrent .= @fread($fp,1000);
}
@fclose($fp);
//Decode
$torrent = Bdecode($pagetorrent);
unset($pagetorrent);
if (!entry_exists($torrent,"info(Dictionary)")) return bterror("test1".$torrent."",_btuploaderror,false);
if (!entry_exists($torrent,"announce(String)")) return bterror("test2".$torrent."",_btuploaderror,false);
$info = entry_get($torrent,"info");
$announce = entry_read($torrent,"announce(String)");


#Checking against DHT
$dht = "no";
if (entry_exists($torrent,"azureus_properties/dht_backup_enable(Integer)")) {
        if (entry_read($torrent,"azureus_properties/dht_backup_enable(Integer)") != 0) $dht = "yes";
}

$info_intact = true;

if (isset($adv_opts) AND $adv_opts == 1 OR $addprivate) {
        if (!isset($dht_support)) $dht_support = 0;
        if (!isset($private_torrent)) $private_torrent = 0;

        //If DHT Support is forced we must disable Private Flag
        $root = $torrent->first_child();
        if ($dht_support == 1) {

                $private_torrent = 2;
                if ($dht == "no") {
                        if (entry_exists($torrent,"azureus_properties")) {
                                $az_props = entry_get($torrent,"azureus_properties");
                        } else {
                                $az_props = $torrent->create_element("azureus_properties");
                                $az_props->set_attribute("type","Dictionary");
                        }
                        if (entry_exists($torrent,"dht_backup_enable")) {
                                $dht_back = $torrent->create_element("dht_backup_enable");
                                $az_props->remove_child($dht_back);
                        }
                        $dht_back = $torrent->create_element("dht_backup_enable");
                        $dht_back->set_attributes("type","Integer");
                        $enable = $torrent->create_text_node("1");
                        $dht_back->append_child($enable);
                        $az_props->append_child($dht_back);
                        foreach ($root->child_nodes() as $child) {
                                if ($child->node_name() > "azureus_properties") break;
                        }
                        $root->insert_before($az_props,$child);
                }
        } elseif ($dht_support == 2) {
                if ($dht == "yes") {
                        $aznode = entry_get($torrent,"azureus_properties");
                        $dhtnode = entry_get($torrent,"azureus_properties/dht_backup_enable");
                        $aznode->remove_child($dhtnode);
                        if (!$aznode->has_child_nodes()) $root->remove_child($aznode);

                }
        }
        unset($root);

        $priv_exists = entry_exists($torrent,"info/private(Integer)");
        $priv_enabled = ($priv_exists AND entry_read($torrent,"info/private(Integer)") == 1);

        if ($private_torrent == 1 OR $addprivate) {
		if($announce == $announce_url){
                //Force enabling Private Torrent
                if (!$priv_enabled ) {
                        $info_intact = false;
                        if ($priv_exists) {
                                $private = entry_get($torrent,"info/private");
                                $info->remove_child($private);
                        }
                        $private = $torrent->create_element("private");
                        $private->set_attribute("type","Integer");
                        $enable = $torrent->create_text_node("1");
                        $private->append_child($enable);
                        foreach ($info->child_nodes() as $child) {
                                if ($child->node_name() > "private") break;
                        }
                        $info->insert_before($private,$child);
                }
			}
        } elseif ($private_torrent == 2) {
                if ($priv_exists) {
                        $info_intact = false;
                        $private = entry_get($torrent,"info/private");
                        $info->remove_child($private);
                }
        }
}


#Name, piece length and pieces

if (!entry_exists($torrent,"info/piece length(Integer)")) return bterror("test3",_btuploaderror,false);
if (!entry_exists($torrent,"info/pieces(String)")) return bterror("test4",_btuploaderror,false);
$dname = (entry_exists($torrent,"info/name(String)")) ? $dname = entry_read($torrent,"info/name(String)") : "";
$plen = entry_read($torrent,"info/piece length(Integer)");
$pieces = entry_read($torrent,"info/pieces(String)");

if (strlen($pieces) % 20 != 0)
        return bterror(_btinvpieces,_btuploaderror,false);
unset($pieces);

$tcomment = (entry_exists($torrent,"comment(String)")) ? entry_read($torrent,"comment(String)") : "";

#Parsing Torrent Description
if ($tcomment == "" AND (!isset($descr) OR empty($descr))) return bterror(_btdescrrequired,_btuploaderror,false);
if (get_magic_quotes_gpc()) $descr = stripslashes($descr);
if ($descr == "") $descr = parsedescr($tcomment);
if ($allow_html) {
        if (preg_match("/<[^>]* (on[a-z]*[.]*)=[^>]*>/i", $descr)) //HTML contains Javascript EVENTS. Must refuse
                return bterror(_btinvalidhtml,_btuploaderror,false);
        if (preg_match('/<a[^>]* href="[^"]*(javascript|vbscript):[^>]*>/i', $descr)) //HTML contains Javascript or VBScript calls. Must refuse
                return bterror(_btinvalidhtml,_btuploaderror,false);
}
parse_html($descr);
$descr = addslashes($descr);


#Parsing Announce
$annregexp_http = "/(http[s]?+):\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
$annregexp_dht = "/^dht:\/\/[0-9a-f]*.dht\/announce$/i";
$annregexp_udp = "/udp:\/\/[-\/.:_\\w]*\/announce[^\/\\s]*/i";
if ($announce == $announce_url) {
        if ($stealthmode) return bterror(str_replace("**name**",$sitename,_bttrackerdisabled),_btuploaderror,false);
        $announce = "";
} elseif (preg_match($annregexp_http, $announce)) {
        $sql = "SELECT id FROM ".$db_prefix."_trackers WHERE url = '".addslashes($announce)."' AND status = 'blacklisted' LIMIT 1;";
        $res = $db->sql_query($sql);
        if ($db->sql_numrows($res) > 0) return bterror(str_replace("**trk**",$announce,_bttrackerblacklisted),_btuploaderror,false);
        $db->sql_freeresult($res);
} elseif (preg_match($annregexp_dht,$announce)) {
        $dht = "yes";
} else {
        return bterror(_btinvannounce."<b>".$announce."</b>",_btuploaderror,false);
}
//UDP trackers or trackers inside the TOR/I2P networks are not supported *yet*



#Parsing Multiple Announce
$trackers = "NULL";
$backup_tracker = "false";
if (entry_exists($torrent,"announce-list(List)")) {
        $trackers = Array();
        $to_check = Array();
        $announce_list = entry_read($torrent,"announce-list(List)");
        foreach ($announce_list as $group) {
                $trackers_in_group = Array();
                foreach ($group->child_nodes() as $tracker_node) {
                        $tracker = $tracker_node->get_content();
                        if (!preg_match($annregexp_http,$tracker) AND !preg_match($annregexp_udp,$tracker)) return bterror(_btinvannounce."<b>".$tracker."</b>",_btuploaderror,false);
                        //If the main tracker is NOT this one, but this one APPEARS within the Announce list then we're running backup tracker
                        if ($tracker["value"] == $announce_url AND $announce != "") $backup_tracker = "true";
                        array_push($trackers_in_group,$tracker);
                        array_push($to_check,"'".$tracker."'");
                        unset($tracker, $tracker_node);
                }
                array_push($trackers,$trackers_in_group);
                unset($trackers_in_group, $group);

        }
        $sql = "SELECT url FROM ".$db_prefix."_trackers WHERE url IN (".implode(", ",$to_check).") AND status = 'blacklisted';";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($res) > 0) {
                $blacklisted_trackers = $db->sql_fetchrowset($res);
                $blacklisted_trackers = implode(",",$blacklisted_trackers);
                return bterror(str_replace("**trk**",$blacklisted_trackers,_bttrackerblacklisted),_btuploaderror,false);
        }
        $db->sql_freeresult($res);
        unset($sql, $to_check,$announce_list, $res);
        for ($i = 0; $i < count($trackers); $i++) $trackers[$i] = implode("\n",$trackers[$i]);
        $trackers = "'".addslashes(implode("\n\n",$trackers))."'";
}


#Parsing password
$torrentpass = $password; //Keep for URL Redirect
if ($password != "" AND $announce == "") {
        if (!get_magic_quotes_gpc()) $password = addslashes($password);
        $password = "'".$password."'";
} else $password = "NULL";


#Parsing files
$filelist = Array();
if (entry_exists($torrent,"info/length(Integer)")) {
        //Single file
        $totallen = entry_read($torrent,"info/length(Integer)");

        if (entry_exists($torrent,"info/sha1(String)")) {
                $sha1code = entry_read($torrent, "info/sha1(String)");
                $magnet_link = "magnet:?xt=urn:sha1:".addslashes(hex_to_base32($sha1code))."&dn=".urlencode($dname);
        } else {
                $magnet_link = "";
        }
        if (entry_exists($torrent,"info/ed2k(String)")) {
                $ed2k = entry_read($torrent, "info/ed2k(String)");
                $ed2k_link = "ed2k://|file|".urlencode($dname)."|".$totallen."|".strtoupper(str_pad($ed2k,32,"0"))."|/";
        } else {
                $ed2k_link = "";
        }
        $filelist[] = Array($dname, $totallen, $magnet_link, $ed2k_link);
        $type = "single";
} else {
        //Multiple files
        $flist = entry_read($torrent, "info/files(List)");
        if (!isset($flist))
                return bterror(_btmissinglength,_btuploaderror,false);
        if (!count($flist))
                return bterror(_btnofilesintorrent,_btuplaoderror,false);
        #$totallen = 0;
        foreach ($flist as $fn) {
                $ffe = "";
                $magnet_link = "";
                $ed2k_link = "";
                $children = $fn->child_nodes();
                $file = Array();
                foreach ($children as $child) {
                        $file[$child->tagname] = $child;
                }

                if (!array_key_exists("length",$file) OR !array_key_exists("path",$file)) return bterror("test5",_btuploaderror,false);

                $ll = $file["length"]->get_content();

                $path = Array();
                foreach ($file["path"]->child_nodes() as $p) array_push($path,$p->get_content());
                $ffe = implode("/",$path);
                if (empty($ffe)) return bterror(_btfilenamerror,_btuploaderror,false);

                if (array_key_exists("sha1",$file)) {
                        $magnet_link = "magnet:?xt=urn:sha1:".addslashes(hex_to_base32($file["sha1"]->get_content()))."&dn=".urlencode($path[count($path)-1]);
                }
                if (array_key_exists("ed2k",$file)) {
                        $ed2k_link = "ed2k://|file|".urlencode($path[count($path)-1])."|".$ll."|".strtoupper(str_pad($file["ed2k"]->get_content(),32,0))."|/";
                }
                unset($p, $path);

                $filelist[] = Array($ffe, $ll, $magnet_link, $ed2k_link);
                $totallen += $ll;
        }
        $type = "multi";
}

#Info Hash. The most important value
$infohash_hex = sha1(Benc($info));
$infohash = pack("H*", $infohash_hex);
unset($info);

#eXeem Alternate Link
if (isset($exeem) AND $exeem != "" AND $info_intact) {
        if (!eregi("^exeem://[\\d]{1,2}/".$infohash_hex."/", $exeem)) return bterror(_btinvalidexeem,_btuploaderror,false);
} else {
        $exeem = "";
}

#Torrent Owner
$owner = $user->id;
$ownertype = ($owner == 0) ? 0 : intval($ownertype);
if ($ownertype == 2) $owner = 0;
if (isset($evidence) AND is_moderator($btuser)) $evidence = 1;
else $evidence = 0;

#Checking against the SAME Torrent
$sql = "SELECT id FROM ".$db_prefix."_torrents WHERE info_hash = '".addslashes($infohash)."';";
$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) > 0) {
        list ($id) = $db->sql_fetchrow($res);
        return bterror(str_replace("#id#",$id,_bttorrentpresent),_btuploaderror,false);
}
$db->sql_freeresult($res);

if (!is_premium($btuser)) {
        $sql = "SELECT count(id) as num, sum(size) as tot_size FROM ".$db_prefix."_torrents where added > sysdate() - 1000000 AND owner = '".$user->id."'";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        list ($torrents, $uploaded_size) = $db->sql_fetchrow($res);
        $db->sql_freeresult($res);

        #Checking against minimumupload size
        if ($totallen < $minupload_size_file)
                return bterror(_bttorrenttoosmall1.mksize($minupload_size_file)._bttorrenttoosmall2.mksize($totallen)."</b>.",_btuploaderror,false);

        #Checking against Max num upload on 24h time
        if ($maxupload_day_num > 0 AND $maxupload_day_num <= $torrents)
                return bterror(str_replace("**maxupload**",$maxupload_day_num,_btmaxuploadexceeded),_btuploaderror,false);

        #Max size share upload on 24h
        if ($maxupload_day_share > 0 AND $maxupload_day_share < $uploaded_size+$totallen) {
                $search = Array("**maxupload**","**rownum**","**totsize**");
                $replace = Array($maxupload_day_share,$torrents,mksize($uploaded_size));
                return bterror(str_replace($search,$replace,_btnumfileexceeded),_btuploaderror,false);
        }
}

#Filename must be at least 4 chars
$materia = trim($fname);
$pos = strrpos($materia, '.');
if (!$pos===false)
        $materia = substr($materia, 0, $pos);
$search = array ("'[^\w]'",                 // Remove not letter
        "'([\r\n])[\s]+'"                 // Remove Blank space
);
$replace = array (
        " ",
        "\\1"
);
$materia = preg_replace ($search, $replace, $materia);
$materia = explode(" ", $materia);

$sql_filter = "";
foreach($materia as $x) {
        $x = trim($x);
        if(strlen($x) > 2){
                $sql_filter .= " OR keyword LIKE '".$x."'";
        }
}
$errmsg = "";
$sql_filter = "SELECT * FROM ".$db_prefix."_filter WHERE 1=0 ".$sql_filter.";";
$res = $db->sql_query($sql_filter) or btsqlerror($sql_filter);
if ($db->sql_numrows($res) > 0) {
                $errmsg = "<p align=\"center\">"._btillegalword."</p></br>";
              
                while ($row = $db->sql_fetchrow($res)){
                        $errmsg.= "<p align=\"center\">".htmlspecialchars($row["reason"])."</p></br>";
                }
              
                $errmsg.= "<p align=\"center\">"._btillegalwordinfo."</p>";
                return bterror($errmsg,_btuploaderror,false);
}
$db->sql_freeresult($res);

#Checking against SIMILAR files
if (isset($jump_check) AND $jump_check == 1) {
        $materia=trim($fname);
        $pos = strrpos($materia, '.');
        if (!$pos===false)
                $materia = substr($materia, 0, $pos);
        $search = array (
                 "'[^a-zA-Z]'",                 // Remove not lecter
                 "'([\r\n])[\s]+'"                 // Remove Blank space
        );
        $replace = array (
                 " ",
                 "\\1"
        );

        $materia = preg_replace ($search, $replace, $materia);
        $materia = explode(" ", $materia);

        $sql = "";
        $sql_filter = "";
        foreach($materia as $x){
                $x = trim($x);
                if(strlen($x)>=5){
                        $sql .= " OR filename LIKE '".str_replace("\'","\\\'",$x)."'";
                }
        }
        foreach ($filelist as $file) {
                $sql .= " OR size = '".$file[1]."'";
        }


        $sql = "SELECT torrent, filename, size FROM ".$db_prefix."_files WHERE 1=0 ".$sql;
        $res = $db->sql_query($sql) or bterror($sql);

        $errmsg = "";
        if ($db->sql_numrows($res) > 0){
                $errmsg = _btsearchdupl;
                $errmsg .= "<ul>\n";
                while ($row = $db->sql_fetchrow($res)){
                        $errmsg.= "<li><p><a href='details.php?id=".$row["torrent"]."&hit=1'>".$row["filename"]."</a> (".mksize($row["size"]).")</p></li>\n";
                }
                $errmsg .= "</ul>\n";
                $errmsg .= _btduplinfo;
                return bterror($errmsg,_btuploaderror,false);
        }
}


#$searchtext = "".$shortfname." ". $dname." ". $descr." ".implode(" ",$filelist);

$searchtext = "".$shortfname." ". $dname." ". $descr." ";
foreach($filelist as $subarray) {
$searchtext.=implode(" ",$subarray);
}

#Parsing external tracker sources
global $force_upload; //Used to force upload even if Torrent has 0 peers or the tracker does not respond
$seeders = $leechers = $tot_peer = 0;
if($autoscrape AND $announce != "") {
        $tmp_tracker = str_replace("announce", "scrape", $announce);//.((strpos($scrape_url,"?")) ? "&" : "?")."info_hash=".urlencode($infohash);
$mystring = $tmp_tracker;
$findme   = '?';
$pos = strpos($mystring, $findme);        #print $tmp_tracker;
if ($pos !== false) {
$tmp_tracker .= "&info_hash=".urlencode($infohash);
}else{
$tmp_tracker .= "?info_hash=".urlencode($infohash);
}
$ctx = stream_context_create(array(
    'http' => array(
        'timeout' => 3
        )
    )
); 
	@$status = file_get_contents($tmp_tracker, 0, $ctx);
		if (!$status){
		return $tmp_tracker."<br>".bterror(_bttrackerdata,_btscrapeerror,false);
		}
       // return $status."test";
        if ($status) {
               // stream_set_timeout($fp, 10);
                $page = "";
                //while (!feof($fp)) {
                        $page .= $status;
               // }
               // @fclose($fp);
				#print $page;
				
                $scrape = Bdecode($page,"Scrape");
                unset($page);
                #Debug 2
                //return str_replace(Array(" ","\n"),Array("&nbsp;","<br />\n"),htmlspecialchars($scrape->dump_mem(true,"UTF-8")));
                #Check data
                if (!entry_exists($scrape,"files(dictionary)","Scrape")) {
                        return bterror(_bttrackerdata,_btscrapeerror,false);
                } elseif (!entry_exists($scrape,"files/a".$infohash_hex."(Dictionary)","Scrape")) {
                        return bterror(_bttorrentnotregistered,_btscrapeerror,false);
                } else {
                        #Check seeder
                        $seeders = entry_read($scrape,"files/a".$infohash_hex."/complete(Integer)","Scrape");
						#if ($seeders <= 0 AND $force_upload) return bterror(_btnoseedersontracker,_btnoseedersontracker,false);
                        if ($seeders <= 0 AND !$force_upload) return bterror(_btnoseedersontracker,_btscrapeerror,false);
                        $leechers = entry_read($scrape,"files/a".$infohash_hex."/incomplete(Integer)","Scrape");
                        $completed = entry_read($scrape,"files/a".$infohash_hex."/downloaded(Integer)","Scrape");
                }
                unset($scrape);
                $visible = ($tot_peer > 0) ? "yes" : "no";				
        } elseif (!$force_upload) {
                return bterror(_bttrackernotresponding.$announce,_btscrapeerror,false);
        }
} else {
                $completed = 0;
                $visible = ($announce != "") ? "yes" : "no";
}


#Preparing SQL
$torrentfields = Array();
$torrentvalues = Array();

$torrentfields[] = "info_hash";
$torrentvalues[] = "'".addslashes($infohash)."'";

$torrentfields[] = "name";
$torrentvalues[] = "'".addslashes($torrentname)."'";

$torrentfields[] = "filename";
$torrentvalues[] = "'".addslashes($dname)."'";

$torrentfields[] = "save_as";
$torrentvalues[] = "'".addslashes($shortfname)."'";

$torrentfields[] = "md5sum";
$torrentvalues[] = "'".md5_file($tmpname)."'";

$torrentfields[] = "search_text";
$torrentvalues[] = "'".addslashes($searchtext)."'";

$torrentfields[] = "descr";
$torrentvalues[] = "'".$descr."'";

$torrentfields[] = "size";
$torrentvalues[] = "'".$totallen."'";

$torrentfields[] = "plen";
$torrentvalues[] = "'".$plen."'";

$torrentfields[] = "category";
$torrentvalues[] = "'".intval($category)."'";

$torrentfields[] = "type";
$torrentvalues[] = "'".$type."'";

$torrentfields[] = "numfiles";
$torrentvalues[] = "'".count($filelist)."'";

$torrentfields[] = "added";
$torrentvalues[] = "NOW()";

$torrentfields[] = "exeem";
if (isset($exeem)) $torrentvalues[] = "'".$exeem."'";
else $torrentvalues[] = "NULL";

$torrentfields[] = "dht";
$torrentvalues[] = "'".$dht."'";

$torrentfields[] = "backup_tracker";
$torrentvalues[] = "'".$backup_tracker."'";

$torrentfields[] = "views";
$torrentvalues[] = "'0'";

$torrentfields[] = "downloaded";
$torrentvalues[] = "'0'";

$torrentfields[] = "completed";
$torrentvalues[] = "'".$completed."'";

$torrentfields[] = "banned";
$torrentvalues[] = "'no'";

$torrentfields[] = "password";
$torrentvalues[] = $password;

$torrentfields[] = "visible";
$torrentvalues[] = "'".$visible."'";

$torrentfields[] = "evidence";
$torrentvalues[] = "'".intval($evidence)."'";

$torrentfields[] = "owner";
$torrentvalues[] = "'".intval($owner)."'";

$torrentfields[] = "ownertype";
$torrentvalues[] = "'".intval($ownertype)."'";

$torrentfields[] = "uploader_host";
$torrentvalues[] = "'".$uploader_host."'";

$torrentfields[] = "numratings";
$torrentvalues[] = "'0'";

$torrentfields[] = "ratingsum";
$torrentvalues[] = "'0'";

$torrentfields[] = "seeders";
$torrentvalues[] = "'".intval($seeders)."'";

$torrentfields[] = "leechers";
$torrentvalues[] = "'".intval($leechers)."'";

$torrentfields[] = "tot_peer";
$torrentvalues[] = "'".intval($seeders+$leechers)."'";

$torrentfields[] = "speed";
$torrentvalues[] = "'0'";

$torrentfields[] = "comments";
$torrentvalues[] = "'0'";

$torrentfields[] = "complaints";
$torrentvalues[] = "'0,0'";

$torrentfields[] = "tracker";
if ($announce == "") $torrentvalues[] = "NULL";
else $torrentvalues[] = "'".$announce."'";

$torrentfields[] = "tracker_list";
$torrentvalues[] = $trackers;

$torrentfields[] = "tracker_update";
$torrentvalues[] = "NOW()";

$torrentfields[] = "last_action";
$torrentvalues[] = "NOW()";


$torrentsql = "INSERT INTO ".$db_prefix."_torrents (".implode(", ",$torrentfields).") VALUES (".implode(", ",$torrentvalues).");";

$db->sql_query($torrentsql) or btsqlerror($torrentsql);
$id = $db->sql_nextid();
if ($id == 0) return bterror("Torrent ID Error",_btuploaderror,false);

if ($announce != ""){ 
$db->sql_query("INSERT INTO ".$db_prefix."_trackers (url, updated) VALUES ('".addslashes($announce)."', NOW());");
}
$db->sql_query("DELETE FROM ".$db_prefix."_files WHERE torrent = '".$id."'") or btsqlerror("DELETE FROM ".$db_prefix."_files WHERE torrent = '$id'");
foreach ($filelist as $file) {
        list ($fname, $fsize, $magnet, $ed2k) = $file;
        $fields = "(torrent, filename, size";
        $values = "('".$id."', '".str_replace("'","\'",$fname)."', '".$fsize."'";
        if ($magnet != "") {
                $fields.= ", magnet";
                $values.= ", '".addslashes($magnet)."'";
        }
        if ($ed2k != "") {
                $fields.= ", ed2k";
                $values.= ", '".addslashes($ed2k)."'";
        }
        $fields.= ")";
        $values.= ")";
        $filesql = "INSERT INTO ".$db_prefix."_files ".$fields." VALUES ".$values.";";
        if (!$db->sql_query($filesql)) { //Rollback
                $db->sql_query("DELETE FROM ".$db_prefix."_torrents WHERE id = '".$id."' LIMIT 1;");
                $db->sql_query("DELETE FROM ".$db_prefix."_files WHERE torrent = '".$id."';");
                btsqlerror($filesql);
        }
}

$torrentpath = $torrent_dir."/".$id.".torrent";
if (file_exists($torrentpath)) unlink($torrentpath);

$fp = fopen($torrentpath,"wb");
fwrite($fp,Bencode($torrent));
fclose($fp);
global $allow_posting, $siteurl;//Are we allowed to post new topics
if($allow_posting)newtopic($torrentname, htmlspecialchars($descr).' <br />
[url='.$siteurl.'/details.php?id='.$id.']See more here[/url]
[url='.$siteurl.'/download.php?id='.$id.']Down Load Here[/url]', '0'); 

return "Upload succesful<br>Seeders: ".$seeders."<br>Leechers: ".$leechers;
}
define('_btautouploaded','This torrent was uploaded by the system from a random site.');
if (!isset($site)) $site=0;

OpenTable("Torrents Snatcher");
print "<p>Welcome to Torrent Snatcher,<br />\n";
print "With this script you can... <b>grab</b> all the Torrents from the most known directories on the web, inluding Mininova, The Pirate Bay and Fulldls<br />\n";
print "Please do not abuse of it.</p>";

print "<p>&nbsp;</p>";
print "<hr />";
print "<p>&nbsp;</p>";
switch ($site) {
        case 0: {
                ?>
                <p>Please select a site to Snatch Torrents from:
                <ul>
                <li><p><a href="outside.php?site=11">Latest at Mininova.org</a></p></li>
                <li><p><a href="outside.php?site=1">Enter your own address for Mininova.org</a></p></li>
                <li><p><a href="outside.php?site=2">Search Mininova.org for your Torrents</a></p></li>
                <li><p><a href="outside.php?site=3">Choose By category at Mininova.org</a></p></li>
                <li><p><a href="outside.php?site=4">Search Fulldls.com</a></p></li>
                <li><p><a href="outside.php?site=5">Choose By category at Fulldls.com</a></p></li>
                <li><p><a href="outside.php?site=6">Latest fulldls torrents</a></p></li>
                <li><p><a href="outside.php?site=7">Latest The Piratebay torrents</a></p></li>
                <li><p><a href="outside.php?site=8">Choose By category thepiratebay.org</a></p></li>
                <li><p><a href="outside.php?site=9">Latest from BTJunkie</a></p></li>
                <li><p><a href="outside.php?site=10">Latest from demonoid</a></p></li>
                <li><p><a href="outside.php?site=11">Coda.fm | New releases</a></p></li>
                <li><p><a href="outside.php?site=12">Coda.fm | Just added</a></p></li>
                </ul>
                </p>
                <?php
                break;
        }
            case 1: {
                if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
                        case 0: {
						OpenTable2('Mininova Torrents');
                                ?>
                                <p>You chose mininova.org. <a href="outside.php">Change site</a></p>
                                <form method="POST" action="outside.php">
                                <p><b>Step 0: Choose the Page</b></p>
                                <p>&nbsp;</p>
                                <p>Please input the URL address of the page containing the Torrents you want
                                to grab</p>
                                <p><input type="text" name="url" size="20"><input type="submit" value="Go"></p>
                                <input type="hidden" name="site" value="1">
                                <input type="hidden" name="step" value="1">
                                </form>

                                <?php
								CloseTable2();
                                break;
                        }
                        case 1: {
                                if (!isset($url) OR !is_url($url)) {
                                        print "<p>ERROR! Invalid URL address(".$url.")!!!</p>";
                                        break;
                                }
            OpenTable2('Mini Nova Torrents');
            print "<table  width=\"100%\">\n";
			if ($rs = $rss->get($url)) {
                                print "<form name=\"myform\" method=\"POST\" action=\"outside.php\">";
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 print "<p>".$item['title']."</p>";
					 
                                        print "<p><input type=\"checkbox\" name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"> <input type=\"button\" name=\"CheckAll\" value=\"Check All\" onClick=\"checkAll(document.myform.snatch[])\"> <input type=\"button\" name=\"UnCheckAll\" value=\"Uncheck All\" onClick=\"uncheckAll(document.myform.snatch[])\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"1\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"2\">";
                                print "<input type=\"hidden\" name=\"url\" value=\"".$url."\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 2: {
            OpenTable('Mini Nova Torrents');
			print "<table width=\"100%\">\n";
			die($snatch);
						if ($rs = $rss->get($url)) {
						          foreach($rs['items'] as $item) {
								  $link = str_replace('tor','get',$item['link']);
								  if($item['description'] == '') $desc = _btautouploaded;
								  else
								  $desc = html_entity_decode($item['description']);
								  $cat = 1;
								  if($item['category'] == 'Anime') $cat = 1;
								  if($item['category'] == 'Music') $cat = 2;
								  if($item['category'] == 'TV Shows') $cat = 3;
								  if($item['category'] == 'Games') $cat = 4;
								  if($item['category'] == 'Software') $cat = 5;
								  if($item['category'] == 'Books') $cat = 11;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
    }
	break;
}
            case 2: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
				
						OpenTable2('Mininova Torrents');
                                ?>
                                <p>You choose to search mininova.org. <a href="outside.php">Change site</a></p>
                                <form method="POST" action="outside.php">
                                <p>&nbsp;</p>
                                <p>Please input the search text 
                                to snatch</p>
                                <p><input type="text" name="search" size="20"><input type="submit" value="Go"></p>
                                <input type="hidden" name="site" value="2">
                                <input type="hidden" name="step" value="1">
                                </form>

                                <?php
								CloseTable2();
                                break;
                        }
                        case 1: {
            OpenTable2('Mini Nova Torrents');
            print "<table  width=\"100%\">\n";
			$search = urlencode($search);
			print $search;
						if ($rs = $rss->get("http://www.mininova.org/rss/".$search)) {
                                print "<form method=\"POST\" action=\"outside.php\">";
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 print "<p>".$item['title']."</p>";
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"2\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"2\">";
                                print "<input type=\"hidden\" name=\"search\" value=\"".$search."\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 2: {
            OpenTable('Mini Nova Torrents');
			print "<table width=\"100%\">\n";
			$search = urlencode($search);
			print $search;
						if ($rs = $rss->get("http://www.mininova.org/rss/".$search)) {
						          foreach($rs['items'] as $item) {
								  $link = str_replace('tor','get',$item['link']);
								  if(html_entity_decode($item['description']) == '') $desc = _btautouploaded;
								  else
								  $desc = html_entity_decode($item['description']);
								  $cat = 1;
								  if($item['category'] == 'Anime') $cat = 1;
								  if($item['category'] == 'Music') $cat = 2;
								  if($item['category'] == 'TV Shows') $cat = 3;
								  if($item['category'] == 'Games') $cat = 4;
								  if($item['category'] == 'Software') $cat = 5;
								  if($item['category'] == 'Books') $cat = 11;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
			break;
		}
            case 3: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
				
						OpenTable2('Mininova Torrents');
                                ?>
                                <p>You choose to select a category mininova.org. <a href="outside.php">Change site</a></p>
                                <form method="POST" action="outside.php">
                                <p>&nbsp;</p>
                                <p>Please select a category 
                                to snatch</p>
                                <p><select name="category"><option value="1">Anime</option><option value="2">Books</option><option value="3">Games</option><option value="4">Movies</option><option value="5">Music</option><option value="6">Pictures</option><option value="7">Softwaer</option><option value="8">TV Shows</option><option value="9">Other</option></select><input type="submit" value="Go"></p>
                                <input type="hidden" name="site" value="3">
                                <input type="hidden" name="step" value="1">
                                </form>

                                <?php
								CloseTable2();
                                break;
                        }
                        case 1: {
            OpenTable2('Mini Nova Torrents');
            print "<table  width=\"100%\">\n";
						if ($rs = $rss->get("http://www.mininova.org/rss.xml?cat=".$category)) {
                                print "<form method=\"POST\" action=\"outside.php\">";
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 print "<p>".$item['title']."</p>";
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"3\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"2\">";
                                print "<input type=\"hidden\" name=\"category\" value=\"".$category."\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 2: {
            OpenTable('Mini Nova Torrents');
			print "<table width=\"100%\">\n";
						if ($rs = $rss->get("http://www.mininova.org/rss.xml?cat=".$category)) {
						          foreach($rs['items'] as $item) {
								  $link = str_replace('tor','get',$item['link']);
								  if($item['description'] == '') $desc = _btautouploaded;
								  else
								  $desc = html_entity_decode($item['description']);
								  $cat = 12;
								  if($item['category'] == 'Anime') $cat = 1;
								  if($item['category'] == 'Music') $cat = 2;
								  if($item['category'] == 'TV Shows') $cat = 3;
								  if($item['category'] == 'Games') $cat = 4;
								  if($item['category'] == 'Software') $cat = 5;
								  if($item['category'] == 'Books') $cat = 11;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  $namex = str_replace("/","",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   echo take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
		break;
    }
            case 4: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
				
						OpenTable2('Fulldls.com Torrents');
                                ?>
                                <p>You choose to search fulldls.com. <a href="outside.php">Change site</a></p>
                                <form method="POST" action="outside.php">
                                <p>&nbsp;</p>
                                <p>Please input the search text 
                                to snatch</p>
                                <p><input type="text" name="search" size="20"><input type="submit" value="Go"></p>
                                <input type="hidden" name="site" value="4">
                                <input type="hidden" name="step" value="1">
                                </form>

                                <?php
								CloseTable2();
                                break;
                        }
                        case 1: {
            OpenTable2('Fulldls.com Torrents');
            print "<table  width=\"100%\">\n";
			$search = urlencode($search);
			print $search;
						if ($rs = $rss->get("http://www.fulldls.com/searchrss.php?search=".$search)) {
                                print "<form method=\"POST\" action=\"outside.php\">";
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 print "<p>".$item['title']."</p>";
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"4\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"2\">";
                                print "<input type=\"hidden\" name=\"search\" value=\"".$search."\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 2: {
            OpenTable('Fulldls.com Torrents');
			print "<table width=\"100%\">\n";
			$search = urlencode($search);
			//print $search;
						if ($rs = $rss->get("http://www.fulldls.com/searchrss.php?search=".$search)) {
						          foreach($rs['items'] as $item) {
								  $title = str_replace('-','',$item['title']);
								  $title = str_replace('  ',' ',$title);
								  $link = str_replace('torrent','download',$item['link']);
								  $link = str_replace('.html','-'.urlencode($title).'.torrent',$link);
								  $link = str_replace('+-+','+',$link);
								  $link = str_replace('%28','',$link);
								  $link = str_replace('%29','',$link);
								  $link = str_replace('%5B','[',$link);
								  $link = str_replace('%5D',']',$link);
								  print $item['title'].'<br>';
								  print $link;
								  if($item['description'] == '') $desc = _btautouploaded;
								  else
								  $desc = html_entity_decode($item['description']);
								  $cat = 1;
								  if($item['category'] == 'Anime') $cat = 1;
								  if($item['category'] == 'Music') $cat = 2;
								  if($item['category'] == 'TV Shows') $cat = 3;
								  if($item['category'] == 'Games - Windows(PC)') $cat = 4;
								  if($item['category'] == 'Software') $cat = 5;
								  if($item['category'] == 'Books') $cat = 11;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
			break;
		}
            case 5: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
				
						OpenTable2('Mininova Torrents');
                                ?>
                                <p>You choose to select a category mininova.org. <a href="outside.php">Change site</a></p>
                                <form method="POST" action="outside.php">
                                <p>&nbsp;</p>
                                <p>Please select a category 
                                to snatch</p>
                                <p><select name="category"><option value="anime">Anime</option><option value="ebooks">Books</option><option value="games">Games</option><option value="movies">Movies</option><option value="music">Music</option><option value="pictures">Pictures</option><option value="app">Softwaer</option><option value="tv">TV Shows</option><option value="others">Other</option></select><input type="submit" value="Go"></p>
                                <input type="hidden" name="site" value="5">
                                <input type="hidden" name="step" value="1">
                                </form>

                                <?php
								CloseTable2();
                                break;
                        }
                        case 1: {
            OpenTable2('Mini Nova Torrents');
            print "<table  width=\"100%\">\n";
						if ($rs = $rss->get("http://www.fulldls.com/rssfor".$category.".php")) {
                                print "<form method=\"POST\" action=\"outside.php\">";
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 print "<p>".$item['title']."</p>";
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"5\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"2\">";
                                print "<input type=\"hidden\" name=\"category\" value=\"".$category."\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 2: {
            OpenTable('Mini Nova Torrents');
			print "<table width=\"100%\">\n";
			$search = urlencode($search);
			print $search;
						if ($rs = $rss->get("http://www.fulldls.com/rssfor".$category.".php")) {
						          foreach($rs['items'] as $item) {
								  $title = str_replace('-','',$item['title']);
								  $title = str_replace('  ',' ',$title);
								  $link = str_replace('torrent','download',$item['link']);
								  $link = str_replace('.html','-'.urlencode($title).'.torrent',$link);
								  $link = str_replace('+-+','+',$link);
								  $link = str_replace('%28','',$link);
								  $link = str_replace('%29','',$link);
								  $link = str_replace('%5B','[',$link);
								  $link = str_replace('%5D',']',$link);
								  print $item['title'].'<br>';
								  print $link;
								  if($item['description'] == '') $desc = _btautouploaded;
								  else
								  $desc = html_entity_decode($item['description']);
								  $cat = 1;
								  if($item['category'] == 'Anime') $cat = 1;
								  if($item['category'] == 'Music') $cat = 2;
								  if($item['category'] == 'TV Shows') $cat = 3;
								  if($item['category'] == 'Games - Windows(PC)') $cat = 4;
								  if($item['category'] == 'Software') $cat = 5;
								  if($item['category'] == 'Books') $cat = 11;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
		break;
    }
            case 6: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
            OpenTable2('Fulldls Torrents');
            print "<table  width=\"100%\">\n";
						if ($rs = $rss->get("http://www.fulldls.com/rss.xml")) {
                                print "<form method=\"POST\" action=\"outside.php\">";
								print 'there are '.count($rs['items']).' torrents to choose from';
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 print "<p>".$item['title']."</p>";
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"5\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"2\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 1: {
            OpenTable('Fulldls Torrents');
			print "<table width=\"100%\">\n";
						if ($rs = $rss->get("http://www.fulldls.com/rss.xml")) {
						          foreach($rs['items'] as $item) {
								  $title = str_replace('-','',$item['title']);
								  $title = str_replace('  ',' ',$title);
								  $link = str_replace('torrent','download',$item['link']);
								  $link = str_replace('.html','-'.urlencode($title).'.torrent',$link);
								  $link = str_replace('+-+','+',$link);
								  $link = str_replace('%28','',$link);
								  $link = str_replace('%29','',$link);
								  $link = str_replace('%5B','[',$link);
								  $link = str_replace('%5D',']',$link);
								  print $item['title'].'<br>';
								  print $link;
								  if($item['description'] == '') $desc = _btautouploaded;
								  else
								  $desc = html_entity_decode($item['description']);
								  $cat = 1;
								  if($item['category'] == 'Anime') $cat = 1;
								  if($item['category'] == 'albums') $cat = 2;
								  if($item['category'] == 'tv') $cat = 3;
								  if($item['category'] == 'app') $cat = 4;
								  if($item['category'] == 'Software') $cat = 5;
								  if($item['category'] == 'Books') $cat = 11;
								  if($item['category'] == 'pictures') $cat = 12;
								  if($item['category'] == 'others') $cat = 12;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
		break;
    }
            case 7: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
            OpenTable2('The Pirate Bay - Torrents');
            print "<table  width=\"100%\">\n";
						if ($rs = $rss->get("http://rss.thepiratebay.org/0")) {
                                print "<form name=\"myform\" method=\"POST\" action=\"outside.php\">";
								print 'there are '.count($rs['items']).' torrents to choose from';
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['title'].'</p>';
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"><input type=\"button\" name=\"CheckAll\" value=\"Check All\"
onClick=\"checkAll(document.myform.snatch)\">
<input type=\"button\" name=\"UnCheckAll\" value=\"Uncheck All\"
onClick=\"uncheckAll(document.myform.snatch)\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"7\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"1\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 1: {
            OpenTable('The Pirate Bay - Torrents');
			print "<table width=\"100%\">\n";
						if ($rs = $rss->get("http://rss.thepiratebay.org/0")) {
						          foreach($rs['items'] as $item) {
								  $title = str_replace('-','',$item['title']);
								  $title = str_replace('  ',' ',$title);
								  $link = $item['link'];
								  if($item['description'] == '') $desc = _btautouploaded;
								  else
								  $desc = html_entity_decode($item['description']);
								  $cat = 12;
if($item['category'] == 'Porn > Other') $cat = 1;
if($item['category'] == 'Applications > Windows') $cat = 5;
if($item['category'] == 'Applications > Mac') $cat = 7;
if($item['category'] == 'Applications > UNIX') $cat = 6;
if($item['category'] == 'Applications > Handheld') $cat = 4;
if($item['category'] == 'Applications > Other OS') $cat = 5;
if($item['category'] == 'Audio > Other') $cat = 2;
if($item['category'] == 'Video > Movies') $cat = 1;
if($item['category'] == 'Porn > Movies') $cat = 1;
if($item['category'] == 'Audio > Audio books') $cat = 2;
if($item['category'] == 'Audio > Music') $cat = 2;
if($item['category'] == 'Video > Movies DVDR') $cat = 1;
if($item['category'] == 'Video > Music videos') $cat = 1;
if($item['category'] == 'Video > Movies DVDR') $cat = 1;
if($item['category'] == 'Video > TV shows') $cat = 3;
if($item['category'] == 'Other > Comics') $cat = 1;
if($item['category'] == 'Other > Pictures') $cat = 2;
								  if($item['category'] == 'TV Shows') $cat = 3;
								  if($item['category'] == 'Games - Windows(PC)') $cat = 4;
								  if($item['category'] == 'Software') $cat = 5;
								  if($item['category'] == 'Other > E-books') $cat = 11;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
		break;
    }
            case 8: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
				
						OpenTable2('The Pirate Bay - Torrents');
                                ?>
                                <p>You choose to select a category mininova.org. <a href="outside.php">Change site</a></p>
                                <form method="POST" action="outside.php">
                                <p>&nbsp;</p>
                                <p>Please select a category 
                                to snatch</p>
                                <p><select name="category"><option value="100">Audio</option><option value="101">Music</option><option value="102">Audio Books</option><option value="103">Sound Clips</option><option value="199">Audio-Other</option><option value="200">Video</option><option value="201">Movies</option><option value="202">Movies-DVDR</option><option value="203">Music-Video</option><option value="204">Movie-Clips</option><option value="205">TV-Shows</option><option value="206">Hand-Held-Videos</option><option value="299">Other-Video</option><option value="300">Applications</option><option value="301">Windows</option><option value="302">Mac</option><option value="303">Unix</option><option value="304">Hand-Held-Apps</option><option value="399">Other-OS</option><option value="400">Games</option><option value="401">PC</option><option value="402">Mac</option><option value="403">PS2</option><option value="404">Xbox360</option><option value="405">Wii</option><option value="406">Hand-Held-Games</option><option value="499">Other-Games</option><option value="500">Other's</option><option value="501">E-Books</option><option value="502">Comics</option><option value="503">Pictures</option><option value="504">Covers</option><option value="599">All-Other's</option></select><input type="submit" value="Go"></p>
                                <input type="hidden" name="site" value="8">
                                <input type="hidden" name="step" value="1">
                                </form>

                                <?php
								CloseTable2();
                                break;
                        }
                        case 1: {
            OpenTable2('The Pirate Bay - Torrents');
            print "<table  width=\"100%\">\n";
									print "http://rss.thepiratebay.org/".$category;

						if ($rs = $rss->get("http://rss.thepiratebay.org/".$category)) {
                                print "<form method=\"POST\" action=\"outside.php\">";
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 print "<p>".$item['title']."</p>";
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"8\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"2\">";
                                print "<input type=\"hidden\" name=\"category\" value=\"".$category."\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 2: {
            OpenTable('The Pirate Bay - Torrents');
			print "<table width=\"100%\">\n";
			$search = urlencode($search);
			print $search;
						if ($rs = $rss->get("http://rss.thepiratebay.org/".$category)) {
						          foreach($rs['items'] as $item) {
								  $link = $item['link'];
								  if($item['description'] == '') $desc = _btautouploaded;
								  else
								  $desc = html_entity_decode($item['description']);
								  $cat = 12;
if($item['category'] == 'Porn > Other') $cat = 1;
if($item['category'] == 'Applications > Windows') $cat = 5;
if($item['category'] == 'Applications > Mac') $cat = 7;
if($item['category'] == 'Applications > UNIX') $cat = 6;
if($item['category'] == 'Applications > Handheld') $cat = 4;
if($item['category'] == 'Applications > Other OS') $cat = 5;
if($item['category'] == 'Audio > Other') $cat = 2;
if($item['category'] == 'Video > Movies') $cat = 1;
if($item['category'] == 'Porn > Movies') $cat = 1;
if($item['category'] == 'Audio > Audio books') $cat = 2;
if($item['category'] == 'Audio > Music') $cat = 2;
if($item['category'] == 'Video > Movies DVDR') $cat = 1;
if($item['category'] == 'Video > Music videos') $cat = 1;
if($item['category'] == 'Video > Movies DVDR') $cat = 1;
if($item['category'] == 'Video > TV shows') $cat = 3;
if($item['category'] == 'Other > Comics') $cat = 1;
if($item['category'] == 'Other > Pictures') $cat = 2;
								  if($item['category'] == 'TV Shows') $cat = 3;
								  if($item['category'] == 'Games - Windows(PC)') $cat = 4;
								  if($item['category'] == 'Software') $cat = 5;
								  if($item['category'] == 'Other > E-books') $cat = 11;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
		break;
    }
            case 9: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
            OpenTable2('Btjunkie Torrents');
            print "<table  width=\"100%\">\n";
						if ($rs = $rss->get("http://btjunkie.org/rss.xml")) {
                                print "<form method=\"POST\" action=\"outside.php\">";
								print 'there are '.count($rs['items']).' torrents to choose from';
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 print "<p>".$item['title']."</p>";
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"9\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"1\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 1: {
            OpenTable('Btjunkie Torrents');
			print "<table width=\"100%\">\n";
						if ($rs = $rss->get("http://btjunkie.org/rss.xml")) {
						          foreach($rs['items'] as $item) {
								  $link = $item['link'];
								  $link .= "/download.torrent";
								  print $item['title'].'<br>';
								  print $link;
								  $desc = _btautouploaded;
								  $string = $item['description'];
								  $cat = 12;
								  if (preg_match("/tv/i", $string))$cat = 3;
								  if (preg_match("/audio/i", $string))$cat = 2;
								  if (preg_match("/video/i", $string))$cat = 1;
								  if (preg_match("/software/i", $string))$cat = 5;
								  if (preg_match("/games/i", $string))$cat = 4;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
		break;
    }
            case 10: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
            OpenTable2('demonoid Torrents');
            print "<table  width=\"100%\">\n";
						if ($rs = $rss->get("http://static.demonoid.com/rss/0.xml")) {
                                print "<form method=\"POST\" action=\"outside.php\">";
								print 'there are '.count($rs['items']).' torrents to choose from';
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['title'].'</p>';
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"10\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"1\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 1: {
            OpenTable('demonoid Torrents');
			print "<table width=\"100%\">\n";
						if ($rs = $rss->get("http://static.demonoid.com/rss/0.xml")) {
						          foreach($rs['items'] as $item) {
								  //print $item['title'].'<br>';
								  print $link;
								  $desc = _btautouploaded;
								  $string = $item['description'];
								  $cat = 12;
								  if (preg_match("/tv/i", $string))$cat = 3;
								  if (preg_match("/audio/i", $string))$cat = 2;
								  if (preg_match("/video/i", $string))$cat = 1;
								  if (preg_match("/software/i", $string))$cat = 5;
								  if (preg_match("/games/i", $string))$cat = 4;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  if(in_array($item['title'] , $snatch)){
								  $link = str_replace('details','download/HTTP',$item['link']);
								  $link = str_replace('775222/','',$link);
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
		break;
    }
            case 11: {
	            if (!isset($step)) $step = 0;
                else $step = intval($step);

                switch($step) {
				case 0:{
            OpenTable2('demonoid Torrents');
            print "<table  width=\"100%\">\n";
						if ($rs = $rss->get("http://static.demonoid.com/rss/0.xml")) {
                                print "<form method=\"POST\" action=\"outside.php\">";
								print 'there are '.count($rs['items']).' torrents to choose from';
			      foreach($rs['items'] as $item ) {
				  print '<p>'.$item['pubDate'].'</p>';
				  print '<p>'.$item['category'].'</p>';
				  print '<p>'.html_entity_decode($item['description']).'</p>';
					 print "<p>".$item['title']."</p>";
					 
                                        print "<p><input type=\"checkbox\" checked name=\"snatch[]\" value=\"".$item['title']."\" /></p>";
                                        print "<hr />";

			}
		}
     print"</table>";
                                print "<p><input type=\"submit\" value=\"Go\"></p>";
                                print "<input type=\"hidden\" name=\"site\" value=\"11\">";
                                print "<input type=\"hidden\" name=\"step\" value=\"1\">";
                                print "</form>";
     CloseTable2();
								break;
	}
                        case 1: {
            OpenTable('Btjunkie Torrents');
			print "<table width=\"100%\">\n";
						if ($rs = $rss->get("http://www.demonoid.com/rss/0.xml")) {
						          foreach($rs['items'] as $item) {
								  $link = str_replace('tor','get',$item['link']);
								  if($item['description'] == '') $desc = _btautouploaded;
								  else
								  $desc = html_entity_decode($item['description']);
								  $cat = 1;
								  if($item['category'] == 'Anime') $cat = 1;
								  if($item['category'] == 'Music') $cat = 2;
								  if($item['category'] == 'TV Shows') $cat = 3;
								  if($item['category'] == 'Games') $cat = 4;
								  if($item['category'] == 'Software') $cat = 5;
								  if($item['category'] == 'Books') $cat = 11;
								  $namex =  preg_replace("/\[(.+?)\]\s*/i","",$item['title']);
								  $namex = str_replace(" ","_",$namex);
								  $namex = str_replace("/","",$namex);
								  if(in_array($item['title'] , $snatch)){
								   print '<br>'.$item['title'];
								   copy($link,"massupload/".$namex.".torrent");
								   $sntorr = "massupload/".$namex.".torrent";
								   print take_snatch($namex, $sntorr, $desc, $cat);
								   if(file_exists($sntorr))unlink($sntorr);
								   print '<hr>';
								   }
								  }
								  print'</table>';
						}
            	break;
	        }
		}
		break;
    }
}

CloseTable();
include('footer.php');
?>