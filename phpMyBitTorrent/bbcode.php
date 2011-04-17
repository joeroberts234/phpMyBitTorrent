<?php
/*
*----------------------------phpMyBitTorrent V 2.0.4---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*/
include('header.php');
$test = request_var('test', '');
function insert_tag($name, $description, $syntax, $example, $remarks)
{
	$result = format_comment($example);
OpenTable($name);
	print("<table class=main width=100% border=1 cellspacing=0 cellpadding=3>\n");
	print("<tr valign=top><td width=25%>"._btdescriptionsemple.":</td><td>$description\n");
	print("<tr valign=top><td>Syntax:</td><td><tt>$syntax</tt>\n");
	print("<tr valign=top><td>Example:</td><td><tt>$example</tt>\n");
	print("<tr valign=top><td>Result:</td><td>$result\n");
	if ($remarks != "")
		print("<tr><td>Remarks:</td><td>$remarks\n");
	print("</table>\n");
CloseTable();	
}

OpenTable('code test');
echo"<font face=\"arial\">\n"._btbb_header;

echo"<form method=post action=?>";
echo"<textarea class=upload name=test cols=60 rows=3>".($test ? htmlspecialchars($test) : _btadd_code)."</textarea>";
echo"<input type=submit value=\"Test this code!\" style='height: 23px; margin-left: 5px'>";
echo"</form>";
CloseTable();
if ($test != ""){
OpenTable('TEST');
  print("<p><b>TEST PREVIEW:</b><hr>" . format_comment($test) . "<hr></p>\n");
CloseTable();
}
insert_tag(
	"Bold",
	"Makes the enclosed text bold.",
	"[b]<i>Text</i>[/b]",
	"[b]This is bold text.[/b]",
	""
);

insert_tag(
	"Italic",
	"Makes the enclosed text italic.",
	"[i]<i>Text</i>[/i]",
	"[i]This is italic text.[/i]",
	""
);

insert_tag(
	"Underline",
	"Makes the enclosed text underlined.",
	"[u]<i>Text</i>[/u]",
	"[u]This is underlined text.[/u]",
	""
);

insert_tag(
	"Color (alt. 1)",
	"Changes the color of the enclosed text.",
	"[color=<i>Color</i>]<i>Text</i>[/color]",
	"[color=blue]This is blue text.[/color]",
	"What colors are valid depends on the browser. If you use the basic colors (red, green, blue, yellow, pink etc) you should be safe."
);

insert_tag(
	"Color (alt. 2)",
	"Changes the color of the enclosed text.",
	"[color=#<i>RGB</i>]<i>Text</i>[/color]",
	"[color=#0000ff]This is blue text.[/color]",
	"<i>RGB</i> must be a six digit hexadecimal number."
);

insert_tag(
	"Size",
	"Sets the size of the enclosed text.",
	"[size=<i>n</i>]<i>text</i>[/size]",
	"[size=4]This is size 4.[/size]",
	"<i>n</i> must be an integer in the range 1 (smallest) to 7 (biggest). The default size is 2."
);

insert_tag(
	"Font",
	"Sets the type-face (font) for the enclosed text.",
	"[font=<i>Font</i>]<i>Text</i>[/font]",
	"[font=Impact]Hello world![/font]",
	"You specify alternative fonts by separating them with a comma."
);

insert_tag(
	"Hyperlink (alt. 1)",
	"Inserts a hyperlink.",
	"[url]<i>URL</i>[/url]",
	"[url]http://phpmybittorrent.com/[/url]",
	"This tag is superfluous; all URLs are automatically hyperlinked."
);

insert_tag(
	"Hyperlink (alt. 2)",
	"Inserts a hyperlink.",
	"[url=<i>URL</i>]<i>Link text</i>[/url]",
	"[url=http://phpmybittorrent.com/]phpMyBitTorrent[/url]",
	"You do not have to use this tag unless you want to set the link text; all URLs are automatically hyperlinked."
);

insert_tag(
	"Image (alt. 1)",
	"Inserts a picture.",
	"[img=<i>URL</i>]",
	"[img=http://phpmybittorrent.com/immagini/12_01.jpg]",
	"The URL must end with <b>.gif</b>, <b>.jpg</b> or <b>.png</b>."
);

insert_tag(
	"Image (alt. 2)",
	"Inserts a picture.",
	"[img]<i>URL</i>[/img]",
	"[img]http://phpmybittorrent.com/immagini/12_01.jpg[/img]",
	"The URL must end with <b>.gif</b>, <b>.jpg</b> or <b>.png</b>."
);

insert_tag(
	"Quote (alt. 1)",
	"Inserts a quote.",
	"[quote]<i>Quoted text</i>[/quote]",
	"[quote]The quick brown fox jumps over the lazy dog.[/quote]",
	""
);

insert_tag(
	"Quote (alt. 2)",
	"Inserts a quote.",
	"[quote=<i>Author</i>]<i>Quoted text</i>[/quote]",
	"[quote=John Doe]The quick brown fox jumps over the lazy dog.[/quote]",
	""
);

insert_tag(
	"List",
	"Inserts a list item.",
	"[*]<i>Text</i>",
	"[*] This is item 1\n[*] This is item 2",
	""
);
insert_tag(
	"No Parse (alt. 1)",
	"Sets It so BBcode well not be Parced",
	"[np]<i>text</i>[/np]",
	"[np][code]if(&phpinfo)echo 'no';[/code][/np]",
	""
);
insert_tag(
	"No Parse (alt. 2)",
	"Sets It so BBcode well not be Parced",
	"[noparse]<i>text</i>[/noparse]",
	"[noparse][code]if(&phpinfo)echo 'no';[/code][/noparse]",
	""
);
insert_tag(
	"MSN Online image",
	"Adds a Icon of online/offline for MSN",
	"[msn=<i>addy</i>]",
	"[msn=joeroberts234@hotmail.com]",
	""
);
insert_tag(
	"Yahoo Online image",
	"Adds a Icon of online/offline for yahoo",
	"[yahoo]<i>text</i>[/yahoo]",
	"[yahoo]joeroberts234[/yahoo]",
	""
);
insert_tag(
	"AIM Online image",
	"Adds a Icon of online/offline for AIM",
	"[aim=<i>addy</i>]<i>addy</i>[/aim]",
	"[aim=joeroberts234]joeroberts234[/aim]",
	""
);

include('footer.php');
?>