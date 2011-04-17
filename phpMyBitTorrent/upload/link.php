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
echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";
define("INVALID_LINK",0);
define("LINK_OK",1);
define("FILES_DONT_MATCH",-2);
include'include/textarea.php';
$ed2k_regex = "/^ed2k:\/\/\|file\|(?P<name>[^|]*)\|(?P<size>[0-9]*)\|(?P<hash>[0-f]*)\|/i";
$magnet_regex_sha1 = "/^magnet:\\?xt=urn:btih:(?P<hash>[0-Z]*)&dn=(?P<name>[^&\\s]*)/i";
$magnet_regex_bitprint = "/^magnet:\\?xt=urn:bitprint:(?P<bitprint>[a-zA-Z0-9]*)&dn=(?P<name>[^&\\s]*)/i";
$md5sum_regex = "/^[0-f]{32}$/i";
preg_match($magnet_regex_sha1,$magnetlink,$matches);
print_r($matches);

function checked2k($link, &$out) {
        global $db, $ed2k_regex, $db_prefix;
        $matches = Array();
        if (!preg_match($ed2k_regex,$link,$matches)) return INVALID_LINK;
        $out = Array("name" => rawurldecode($matches["name"]), "size" => $matches["size"], "hash" => $matches["hash"], "torrent" => 0);

        //We get only one Torrent
        $sql = "SELECT torrent FROM ".$db_prefix."_files WHERE size = ".$out["size"]." AND ed2k LIKE '%".$out["hash"]."%' LIMIT 1;";
        $res = $db->sql_query($sql);
        if ($db->sql_numrows($res) != 0) {
                list ($torrentid) = $db->sql_fetchrow($res);
                $out["torrent"] = $torrentid;
        }
        $db->sql_freeresult($res);
        return LINK_OK;
}

function checkmagnet($link, $fname, &$out) {
        global $magnet_regex_sha1, $magnet_regex_bitprint;
        $sha1 = $bitprint = false;
        if (preg_match($magnet_regex_sha1,$link,$matches)) {
                $out = Array("name" => rawurldecode($matches["name"]), "hash" => $matches["hash"], "bitprint" => "");
                if ($out["name"] != $fname) return FILES_DONT_MATCH;
                return LINK_OK;
        }
        if (preg_match($magnet_regex_bitprint,$link,$matches)) {
                $out = Array("name" => rawurldecode($matches["name"]), "hash" => "", "bitprint" => $matches["bitprint"]);
                if ($out["name"] != $fname) return FILES_DONT_MATCH;
                return LINK_OK;
        }
        return INVALID_LINK;
}

if (!isset($namex)) $namex = "";
if (!isset($descr)) $descr = "";
if (!isset($md5sum)) $md5sum = "";
if (!isset($link_category)) $link_category = 0;
if (!isset($old_files)) $old_files = "";
$can_submit = false;
$files = Array();

$priv_key = base64_encode($_SERVER["SERVER_SIGNATURE"].$_SERVER["SCRIPT_NAME"]);
if ($old_files != "") {
        if ($use_rsa) {
                $files = unserialize($rsa->decrypt($old_files));
        } else {
                $files = unserialize(base64_decode($old_files));
                if (crypt($old_files,$priv_key) != $fingerprint) bterror(_btfilelistaltered,_btuploaderror);
        }
}

if (isset($postback) AND is_numeric($postback)) {
        $nf = Array();
        for ($i = 0; $i < count($files); $i++) {
                if ($i == $postback) continue;
                $nf[] = $files[$i];
                $i++;
        }
        $files = $nf;
        unset($nf);
        /* SECURITY NOTICE
        In order to avoid a faker to alter the content of a Link Archive by
        submitting a custom string (that could even be dangerous for SQL)
        phpMyBitTorrent does the following:
        IF RSA Security is enabled, the hidden field of the old files is simply
        encrypted with private keys.
        Else a fingerprint is attached to the form. This fingerprint is, at
        this time, generated with values that nobody should know.
        This will make impossible to alter the form input during postback.
        */
        if ($use_rsa) {
                $old_files = $rsa->encrypt(serialize($files));
        } else {
                $old_files = base64_encode(serialize($files));
                $fingerprint = crypt($old_files,$priv_key);
        }
}

if (isset($postback) AND !is_numeric($postback)) {
        if (isset($ed2klink)) {
                $file = Array();
                $torrentid = null;
                $result = checked2k($ed2klink,$file);

                if ($result == INVALID_LINK) bterror(_btinvalided2k,_btuploaderror,false);
                else {
                        $file["ed2k"] = "ed2k://|file|".urlencode($file["name"])."|".$file["size"]."|".strtoupper($file["hash"])."|/";
                        $file["md5sum"] = $md5sum;
                        if (isset($magnetlink) AND !empty($magnetlink)) {
                                $magnetfile = Array();
                                $result = checkmagnet($magnetlink,$file["name"],$magnetfile);
                                if ($result == LINK_OK) {
                                        $file["magnet"] = (($magnetfile["hash"] != "") ? "magnet:?xt=urn:sha1:".strtoupper($magnetfile["hash"])."&dn".$file["name"] : "magnet:?xt=urn:bitprint:".strtoupper($magnetfile["bitprint"])."&dn".$file["name"]);
                                        unset($magnetfile);
                                        $magnet_ok = true;
                                } else {
                                        $magnet_ok = false;
                                        if ($result == FILES_DONT_MATCH) bterror(_btlinksnomatch,_btuploaderror,false);
                                        else bterror(_btinvalidmagnet,_btuploaderror,false);
                                }
                        } else {
                                $magnet_ok = true;
                                $file["magnet"] = "";
                        }
                        if ($magnet_ok) {
                                //Ready to insert file but must check against duplicate!
                                $duplicate = false;
                                if (count($files) > 0) foreach ($files as $sf) if ($sf["name"] == $file["name"]) $duplicate = true;
                                if (!$duplicate) {
                                        $files[] = $file;
                                        if ($use_rsa) {
                                                $old_files = $rsa->encrypt(serialize($files));
                                        } else {
                                                $old_files = base64_encode(serialize($files));
                                                $fingerprint = crypt($old_files,$priv_key);
                                        }
                                } else bterror(_bterrduplicatelinks,_btuploaderror,false);
                                //Add file
                        } //else error has been displayed
                }
        } else bterror(_ed2krequired,_btuploaderror,false);

} else $old_files = "";

OpenTable(_btupload);
echo "<form action=\"upload.php?op=takelink\" method=\"post\" id=\"data\" name=\"formdata\">\n\n";
echo "<input type=\"hidden\" name=\"old_files\" value=\"".$old_files."\" />\n";
if (!$use_rsa) echo "<input type=\"hidden\" name=\"fingerprint\" value=\"".$fingerprint."\" />\n";
echo "<p>"._btsharelink."<br />"._btlinknotice."</p>";
echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\">\n";

echo "<tr><td><p>"._btarchivename."</p></td><td><p><input type=\"text\" name=\"namex\" size=\"80\" value=\"".$namex."\"/></p>\n</td></tr>\n";
echo "<tr><td><p>"._btdescription."</p></td><td>";
echo $textarea->quick_bbcode('formdata','descr');
echo $textarea->input('descr');
echo "</table><br />\n";
echo <<<EOF
<script type="text/javascript">
<!--
function vB_Attachment(listobjid, editorid)
{
	this.attachments = new Array();
	this.menu_contents = new Array();
	this.windows = new Array();

	this.listobjid = listobjid;

	if (editorid == '')
	{
		for (var editorid in vB_Editor)
		{
			if (typeof vB_Editor[editorid] != 'function')
			{
				this.editorid = editorid;
				break;
			}
		}
	}
	else
	{
		this.editorid = (editorid ? editorid : null);
	}
};

// =============================================================================
// vB_Attachment methods

/**
* Does the editor popup exist in a built state?
*
* @return	boolean
*/
vB_Attachment.prototype.popup_exists = function()
{
	if (
		this.editorid &&
		((typeof vB_Editor[this.editorid].popups['attach'] != 'undefined' && vB_Editor[this.editorid].popups['attach'] != null)
		||
		(!vB_Editor[this.editorid].popupmode && typeof vB_Editor[this.editorid].buttons['attach'] != 'undefined' && vB_Editor[this.editorid].buttons['attach'] != null))
	)
	{
		return true;
	}
	else
	{
		return false;
	}
};

/**
* Add a new attachment
*
* @param	integer	Attachment ID
* @param	string	File name
* @param	string	File size
* @param	string	Path to item's image (images/attach/jpg.gif etc.)
*/
vB_Attachment.prototype.add = function(id, filename, filesize, imgpath)
{
	this.attachments[id] = new Array();
	this.attachments[id] = {
		'filename' : filename,
		'filesize' : filesize,
		'imgpath'  : imgpath
	};

	this.update_list();
};

/**
* Remove an attachment
*
* @param	integer	Attachment ID
*/
vB_Attachment.prototype.remove = function(id)
{
	if (typeof this.attachments[id] != 'undefined')
	{
		this.attachments[id] = null;

		this.update_list();
	}
};

/**
* Do we have any attachments?
*
* @return	boolean
*/
vB_Attachment.prototype.has_attachments = function()
{
	for (var id in this.attachments)
	{
		if (this.attachments[id] != null)
		{
			return true;
		}
	}
	return false;
};

/**
* Reset the attachments array
*/
vB_Attachment.prototype.reset = function()
{
	this.attachments = new Array();

	this.update_list();
};

/**
* Build Attachments List
*
* @param	string	ID of the HTML element to contain the list of attachments
*/
vB_Attachment.prototype.build_list = function(listobjid)
{
	var listobj = fetch_object(listobjid);

	if (listobjid != null)
	{

		for (var id in this.attachments)
		{
			var div = document.getElementById("descr");
			// try to use the template if it's been submitted to Javascript
				div.innerHTML =div.value +' [img]$siteurl/UserFiles/$user->name/'+ this.attachments[id]['filename'] + '[/img]';
			listobj.appendChild(div);
		}
	}
};

/**
* Update the places we show a list of attachments
*/
vB_Attachment.prototype.update_list = function()
{
	this.build_list(this.listobjid);

	if (this.popup_exists())
	{
		vB_Editor[this.editorid].build_attachments_popup(
			vB_Editor[this.editorid].popupmode ? vB_Editor[this.editorid].popups['attach'] : vB_Editor[this.editorid].buttons['attach'],
			vB_Editor[this.editorid].buttons['attach']
		);
	}
};

/**
* Opens the attachment manager window
*
* @param	string	URL
* @param	integer	Width
* @param	integer	Height
* @param	string	Hash
*
* @return	window
*/
vB_Attachment.prototype.open_window = function(url, width, height, hash)
{
	if (typeof(this.windows[hash]) != 'undefined' && this.windows[hash].closed == false)
	{
		this.windows[hash].focus();
	}
	else
	{
		this.windows[hash] = openWindow(url, width, height, 'Attach' + hash);
	}

	return this.windows[hash];
};
//-->
</script>
<script type="text/javascript" src="./java/tl.js"><!-- overLIB (c) Erik Bosrup --></script>

<fieldset class="fieldset">
	<legend>Attach Files</legend>

	<div style="padding:3px">
		<div style="margin-bottom:3px">
			<div>Valid file extensions: bmp gif jpe jpeg jpg png</div>
		</div>
		<div style="margin-bottom:3px" id="attachlist">
			
		</div>
		<div>
			<input type="button" id="manage_attachments_button" class="button" tabindex="1" style="font-weight:normal" value="Manage Attachments" title="Click here to add or edit files attached to this message" onclick="vB_Attachments.open_window('bitbucket-upload.php', 800, 600, '')" />

			<script type="text/javascript">vB_Attachments = new vB_Attachment('descr', '');</script>
			<noscript>
			<a rel="nofollow" href="newattachment.php?f=23&amp;poststarttime=1230080445&amp;posthash=68db1fa686788e92c0ebd0f96cefb1a9" target="manageattach" title="Click here to add or edit files attached to this message" tabindex="1"><strong>Manage Attachments</strong></a>
			</noscript>
		</div>
	</div>
</fieldset>
EOF;
echo"</td></tr>\n";
$s = "<select name=\"link_category\"><option value=\"0\">("._btchooseone.")</option>\n";
$cats = genrelist2();
foreach ($cats as $cat)
{
 $s .= "<optgroup label=\"" . htmlspecialchars($cat["name"]) . "\">";
 $subcats = $cat[subcategory];

 if (count($subcats) > 0)
 {
 foreach ($subcats as $subcat)
 {
 $s .= "<option value=\"" . $subcat["id"] . "\" ".(($link_category == $subcat["id"]) ? "selected" : "")." >" . htmlspecialchars($subcat["name"]) . "</option>\n";

 }
 }
 $s .= "</optgroup>\n";

}  
$s .= "</select>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";
echo "<tr><td>"._btlinks."</td><td>";
echo "<p>"._btinsert1file."</p>";
echo "<HR SIZE=1 NOSHADE>";

//Start file list
//print_r($files);
$total = count($files);
$duplicate = 0;

if ($total > 0) {
        $i = 0;
        echo "<table>\n";
        echo "<thead>\n";
        echo "<tr><td nowrap></td><td><p>"._btfilename."</td><td><p>"._btdim."</p></td><td><p>"._btlinks."</p></td></tr>\n";
        echo "</thead>\n";
        echo "<tbody>\n";

        foreach ($files as $file) {
                if ($file["torrent"] != 0) $duplicate++;
                echo "<tr>";
                echo "<td nowrap><p><input type=\"image\" style=\"border: 0px;\" value=\"".$i."\" src=\"themes/".$theme."/pics/drop.gif\" name=\"postback\" />";
                if ($file["torrent"] != 0) echo pic("warning.gif","details.php?id=".$file["torrent"]);
                echo "</p></td>";
                echo "<td><p>".htmlspecialchars(urldecode($file["name"]))."</p></td>";
                echo "<td><p>".mksize($file["size"])."</p></td>";
                echo "<td>".pic("minimagnet.gif",$file["magnet"]).pic("minidonkey.gif",$file["ed2k"])."</td>";
                echo "</tr>\n";
                $i++;
        }

        if ($duplicate <= $total/2) $can_submit = true;

        echo "</tbody>\n";
        echo "</table>\n";
        if ($duplicate > 0) echo "<blockquote><p>".pic("warning.gif")._btduplicatelinks."<br />"._btduplicateexplain."</p></blockquote>";
        echo "<HR SIZE=1 NOSHADE>";
}


//New file

echo "<table width=\"100%\" border=\"0\">\n<thead><tr><th><p>"._btaddnewfile."</p></th><th></th></thead>\n<tbody>";
echo "<tr><td><p>"._btaddmagnet."</p></td><td><p><input type=\"text\" name=\"magnetlink\" size=\"60\" maxlength=\"255\" /></p></td></tr>\n";
echo "<tr><td><p>"._btadded2k."</p></td><td><p><input type=\"text\" name=\"ed2klink\" size=\"60\" maxlength=\"255\" /></p></td></tr>\n";
echo "<tr><td><p>"._btaddmd5."</p></td><td><p><input type=\"text\" name=\"md5sum\" size=\"60\" maxlength=\"32\" /></p></td></tr>\n";
echo "<tr><td><p><input type=\"submit\" name=\"postback\" value=\""._btaddnewfile."\" /></p></td><td></td></tr>\n";
echo "</tbody>\n</table>";

echo "</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";

echo "<tr><td><p>"._bttype."</p></td><td><p>".$s."</p></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";

if ($user->user) {
        echo "<tr><td><p>"._btupnotify."</p></td><td><p><input type=\"checkbox\" name=\"commnotify\" value=\"ok\" checked> "._btupnotifynfo;
        echo "<tr><td><HR SIZE=1 NOSHADE></td></tr>\n";
}


echo "</table><HR SIZE=1 NOSHADE><input type=\"submit\" value=\""._btfsend."\" ".((!$can_submit) ? "disabled" : "")." /></form>\n";
CloseTable();

?>
