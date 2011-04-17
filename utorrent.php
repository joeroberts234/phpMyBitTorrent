<?php

include("header.php");

OpenTable("Utorrent Guide");
?><center>
<table class=main width=750 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>
<h2>Utorrent Uploading Guide</h2>
<table width=100% border=1 cellspacing=0 cellpadding=10><tr><td class=text>
<p>This is a guide explaining how to upload torrents using the BitTorrent client Utorrent.</font></p>
<ol>
<li>Download Utorrent from here: '<a href=[url]http://www.utorrent.com/download.php[/url] target=_blank>Utorrent</a>'.</li>
<li>Go to the µTorrent menu > File > Create a New torrent(This opens the "Create a new .torrent" dialog box;).</li>
<li>First you will need to browse to the location of the torrent directory..</li>
<li>This will open Windows Explorer where you will want to browse to the directory where the file you want to create into a torrent is located, highlight it and click OK.</li>
<li>You will then go back to the Create new Torrent window.</li>
<li>In the "Announce URL" put "<b>[url]http://SITENAMEHERE/announce.php[/url]</b>" disable DHT and check prv box is ticked then click "Create".</li>
<li>just click on Create and Save as.</li>
<li>Windows Explorer will once again open so you can create a name for the torrent and choose where to save the torrent file.(just save it on desktop)</li>
<li>Login to the site '<a href=/ target=_blank>[url]http://SITENAMEHERE[/url]</a>' and go to the "Upload" section or click here <a href=[url]http://SITENAMEHERE/upload.php[/url] target=_blank>Here</a>.</li>
<li>In the "Torrent file" area click the "Browse" button and find the torrent file then click "Open".</li>
<li>In the "Browse nfo" area click the "Browse" button and find the nfo file then click "open".</li>
<li>In the "IMDB" area click the copy the direct link to imdb (movies only).</li>
<li>In the "Description" area type a thorough description of the file. bbcode allowed. Make sure the description is complete and includes all relevant information.  </li>
<li>In the "Type" area choose the type of file by clicking on the pull down menu. Make sure the file is under the correct type.</li>
<li>Check over the following steps and if everything is correct click the "Upload Torrent!" button.</li>
<li>Time to seed the torrent: download the torrent off the site,  "Open".torrent File with utorrent. You will not be able to seed the torrent created by the client because of the passkey that needs to be embedded in the torrent.</li>
<p>It will take a couple minutes for your torrent to appear in the "Browse" section. If you have any trouble following these instructions be sure to check the '<a href=[url]http://www.SITENAMEHERE/faq.php[/url] target=_blank>FaQ</a>' section for additional tips with different clients and so forth! If you still can not seem to upload torrents ask in the forum.</p>
</td></tr></table></font>
</td></tr></table>
<?php

?>
<table class=main width=750 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>
<h2>Rules</h2>
<table width=100% border=1 cellspacing=0 cellpadding=10><tr><td class=text>
<p>Torrents violating these rules may be deleted without notice.</p>
<ol>
<li>You must have legal rights to the file you are uploading.</li>
<li>All uploads must include a detailed description.</li>
<li>No Porn files!</li>
<li>All files must be in a legitiment format so they are functional.</li>
<li>Pre-release stuff should be labeled with an *ALPHA* or *BETA* tag.</li>
<li>Make sure not to include any serial numbers, CD keys or similar in the description (you do <b>not</b> need to edit the NFO!)..
<li>Make sure your torrents are well-seeded for at least 7days or longer if possible.</li>
</ol>
<p>If you have something interesting that somehow violate these rules, ask a mod and we might make an exception.</p>
</td></tr></table>
</td></tr></table></center>
<?php
CloseTable();

include("footer.php");
?>