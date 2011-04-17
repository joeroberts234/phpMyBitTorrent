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
ALTER TABLE `torrent_torrents` ADD `post_img` TEXT CHARACTER SET utf8 COLLATE utf8_bin NULL AFTER `descr` ,
ADD `screan1` TEXT CHARACTER SET utf8 COLLATE utf8_bin NULL AFTER `post_img` ,
ADD `screan2` TEXT CHARACTER SET utf8 COLLATE utf8_bin NULL AFTER `screan1` ,
ADD `screan3` TEXT CHARACTER SET utf8 COLLATE utf8_bin NULL AFTER `screan2` ,
ADD `screan4` TEXT CHARACTER SET utf8 COLLATE utf8_bin NULL AFTER `screan3` ;*/

if (!eregi("upload.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly.");

echo"<script type=\"text/javascript\" src=\"bbcode.js\"></script>";


OpenTable(_btupload);

if (!$stealthmode) echo "<p>" . _btofficialurl." <b>".$announce_url."</b></p>\n";
include'include/textarea.php';
echo "<p>"._btseeded."</p>";
echo "<form enctype=\"multipart/form-data\" action=\"upload.php?op=taketorrent\" method=\"post\" id=\"data\" name=\"formdata\">\n\n";
echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".$max_torrent_size."\" />\n";
echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"5\">\n";
echo "<tr><td><p>"._btupfile."</p></td><td><p><input type=\"file\" name=\"filex\" size=\"60\" /></p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
echo "<tr><td><p>"._btupnfo."</p></td><td><p><input type=\"file\" name=\"nfox\" size=\"60\" /></p>\n</td></tr>\n";
echo "<tr><td><hr /></td><td></td></tr>\n";
echo "<tr><td><p>"._bttorrentname."</p></td><td><p><input type=\"text\" name=\"namex\" size=\"80\" /><br />("._btfromtorrent. "<b>"._btdescname."</b>)</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
// Poster Modd
echo "<tr><td><p>"._bt_poster."</p></td><td><p><input type=\"text\" name=\"post_img\" size=\"80\" /><br />"._bt_poster_exp."</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
// Screen shot Mod
echo "<tr><td><p>"._bt_screensa."</p></td><td><p><input type=\"text\" name=\"screan1\" size=\"80\" /><br />"._bt_screen_expa."</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
echo "<tr><td><p>"._bt_screensb."</p></td><td><p><input type=\"text\" name=\"screan2\" size=\"80\" /><br />"._bt_screen_expb."</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
echo "<tr><td><p>"._bt_screensc."</p></td><td><p><input type=\"text\" name=\"screan3\" size=\"80\" /><br />"._bt_screen_expc."</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
echo "<tr><td><p>"._bt_screensd."</p></td><td><p><input type=\"text\" name=\"screan4\" size=\"80\" /><br />"._bt_screen_expd."</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
// End Mods
echo "<tr><td><p>IMDB LINK</p></td><td><p><input type=\"text\" name=\"imdb_info\" size=\"80\" /><br />(Add IMDB to details page By providing a imdb link or IMDB NUMBER)</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
echo "<tr><td><p>"._btdescription."</p></td>";
echo '<td>';
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
			<div>Your Image Bucket</div>
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
$s = "<select name=\"torrent_category\"><option value=\"0\">("._btchooseone.")</option>\n";
$cats = genrelist2();
foreach ($cats as $cat)
{
 $s .= "<optgroup label=\"" . htmlspecialchars($cat["name"]) . "\">";
 $subcats = $cat[subcategory];

 if (count($subcats) > 0)
 {
 foreach ($subcats as $subcat)
 {
 $s .= "<option value=\"" . $subcat["id"] . "\">" . htmlspecialchars($subcat["name"]) . "</option>\n";

 }
 }
 $s .= "</optgroup>\n";

}  
$s .= "</select>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

echo "<tr><td><p>"._bttype."</p></td><td><p>". $s ."</p></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

echo "<tr><td><p>"._btverduplicate."</p></td><td><p><input type=\"checkbox\" name=\"jump_check\" value=\"1\"  /> "._btduplicatinfo."</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
if ($user->premium){
                echo "<tr><td><p>Ratio Builder<p></td><td><p><input type=radio name=build value=yes>Yes<input type=radio name=build checked value=no>No</p>\n</td></tr>\n";
                echo "<tr><td><hr size=\"1\" noshade></td><td></td></tr>";
}
#shout new torrent
echo "<tr><td><p>"._btnewtsh."</p></td><td><p><input type=\"checkbox\" checked name=\"shout\" value=\"1\"  /> "._btnewshex."</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

#Evidence. Moderators Only
if ($user->moderator) {
        echo "<tr><td><p>"._btupevidence."</p></td><td><p><input type=\"checkbox\" name=\"evidence\" value=\"1\" /> "._btupevidencinfo."</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
}

#Owner Preferences. Not for Anonymous Users
if ($user->user) {
        echo "<tr><td><p>"._btowner."</p></td><td><p><select name=\"ownertype\">\n<option value=\"0\">"._btowner1."</option><option value=\"1\">"._btowner2."</option><option value=\"2\">"._btowner3."</option></select> "._btownerinfo."</p>\n</td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
}

#Torrent Password
echo "<tr><td><p>"._btpassword."</p></td><td><p><input type=\"text\" name=\"password\" value=\"\" /><br />"._bttorrentpasswordexplain."</p>\n</td>\n</tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";


#Advanced Options
echo "<tr><td><p>"._btupadvopts."</p></td><td><p><input type=\"checkbox\" name=\"adv_opts\" value=\"1\" onClick=\"javascript:expand();\" id=\"adv_check\" /><br />"._btadvoptsexplain."</p></td></tr>\n";
##DHT Support
echo "<tr id=\"advanced_options_1\" class=\"hide\"><td><p>"._btdhtsupport."</p></td><td><p><input type=\"radio\" name=\"dht_support\" value=\"0\" checked />"._btleaveintact."<br /><input type=\"radio\" name=\"dht_support\" value=\"1\" onClick=\"javascript:document.formdata.private_torrent[2].checked = true;\" />"._btendht."<br /><input type=\"radio\" name=\"dht_support\" value=\"2\" />"._btdisdht."<br />"._btdhtsupportexplain."</p></td></tr>\n";
##Private Torrent
echo "<tr id=\"advanced_options_2\" class=\"hide\"><td><p>"._btprivatetorrent."</p></td><td><p><input type=\"radio\" name=\"private_torrent\" value=\"0\" checked />"._btleaveintact."<br /><input type=\"radio\" name=\"private_torrent\" value=\"1\" onClick=\"javascript:document.formdata.dht_support[2].checked = true;\" />"._btenpvt."<br /><input type=\"radio\" name=\"private_torrent\" value=\"2\">"._btdispvt."<br />"._btprivatetorrentexplain."</p></td></tr>\n";


echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
#Notify. Only for Registered Users
if ($user->user) {
        echo "<tr><td><p>"._btupnotify."</p></td><td><p><input type=\"checkbox\" name=\"commnotify\" value=\"ok\" > "._btupnotifynfo."<br /><input type=\"checkbox\" name=\"seednotify\" value=\"ok\" > "._btupnotifyseed."</p></td></tr>\n";
echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";
}

echo "</table><hr /><input type=\"submit\" value=\""._btfsend."\"></form>\n";
CloseTable();
?>