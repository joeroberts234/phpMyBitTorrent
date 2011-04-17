<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
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
*/


//COMPLAINTS
function getcomplaints() {
        return Array(0=>"Gute Qualtät und legaler Inhalt",1=>"Gefälscht oder defekt",2=>"Urheberrechtlich geschuetzt",3=>"Pornographischer Inhalt",4=>"Kinderpornographischer  Inhalt",5=>"Anstoessiger Inhalt",6=>"Inhalt mit Bezug zu terroristischen Aktivitäten");
}

//Donations Block
define("_btdonations","Donations");
define("_btdonationsgoal","Goal:");
define("_btdonationscollected","Collected:");
define("_btdonationsprogress","Donation Progress");
define("_btdonationsdonate","DONATE");

//NewTorrent shout
define("_btuplshout","Hi, I have just uploaded <b>**name**</b>. Enjoy it!");
define("_btnewtsh","Shout out New Torrent");
define("_btnewshex","Check Here if you would like to add a shout in the shout box about your new uploade if not then leave it unchecked!");

//ERRORI SQL
define("_btsqlerror1","Fehler beim Ausfuehren der SQL Anfrage ");
define("_btsqlerror2","Fehler ID: ");
define("_btsqlerror3","Fehler-Nachricht: ");

//TESTI CHE COMPAIONO IN INCLUDE/BITTORRENT.PHP
define("_btindex","Home Torrent");
define("_btupload","Upload");
define("_btlogin","Login");
define("_btsignup","Registrieren");
define("_btpersonal","Torrent von ");
define("_btrulez","Regeln");
define("_btforums","Forum");
define("_bthelp","Hilfe");
define("_btadvinst","Installiere Bit Torrent oder Shareaza für den Download");
define("_btaccessden","Zugriff verweigert. Zum Download bitte <A href=\"modules.php?name=Your_Account&op=new_user\">registrieren</a>.");
define("_btlegenda","Hilfe und Legende für die Features");
define("_btyourfilext","Deine Dateien, externer Tracker");
define("_btexternal","Externer Tracker");
define("_btyourfile","Deine Datei");
define("_btsticky","Sticky");
define("_btauthforreq","Authorization to reqüst");
define("_btauthreq","Authorization Reqüst");
define("_btdown","Download");
define("_btunknown","Unbekannt");
define("_btrefresh","Update");
define("_btvisible","Sichtbar");

//TESTI CHE COMPAIONO IN INDEX.PHP

define("_btstart","Bitte lass dein Bit Torrent-Fenster nach dem Download so lange auf wie eben möglich! Das beschleunigt alle Downloads.<br />
Um deine Download-Geschwindigkeit zu erhöhen, versuche den <b>ACTIVE</b> Modus zu verwenden");
define("_btsearch","Suche");
define("_btin","in");
define("_btalltypes","jede");
define("_btactivetorrents","Aktive Torrents");
define("_btitm","tote Torrents einschliessen");
define("_btstm","nur tote Torrents");
define("_btgo","Los!");
define("_btresfor","Ergebnisse gefunden für");
define("_btnotfound","<h2>Kein Ergebnis!</h2>\n<p>Überprüfe deine Suchparameter.</p>\n");
define("_btvoidcat","<h2>Leer!</h2>\n<p>Wähle eine andere Kategorie</p>\n");
define("_btorderby","Sortieren nach");
define("_btinsdate","Einfügedatum");
define("_btname","Name");
define("_btdim","Grösse");
define("_btnfile","Anzahl der Dateien:");
define("_btevidence","Beweise");
define("_btcomments","Kommentare");
define("_btvote","Bewertung");
define("_btdownloaded","Heruntergeladen");
define("_btprivacy","Privacy");
define("_bttotsorc","Peers insgesamt");
define("_btdesc","absteigend");
define("_btord","aufsteigend");
define("_btnosearch","<center><h2>Suche die Dateien, die du herunterladen willst</h2>Wenn du Hilfe benötigst, frage in den Foren; wenn du von Magnet:/eD2K: links nichts herunterladen kannst, hast du wahrscheinlich Shareaza nicht installiert.<br>Wir möchten daran erinnern, dass unsere Regeln besagen, dass jede Datei privat ist, und dass es demjenigen, der sie teilt, uberlassen ist, anderen Leuten zu erlauben, diese herunterzuladen. Ausserdem ist es streng verboten, urheberrechtlich geschützte, pornographische,kinderpornographische, rassistische oder sonstwie anstössige Dateien zu verteilen, oder sonst etwas, das in irgendeiner Weise gegen die Gesetze verstossen könnte, wie zum Beispiel Anleitungen zum Bau von Bomben.<br>Jeder kann die Anwendung eines kostenlosen Dateinamen-Filters verlangen, um sein Urheberrecht zu schützen.</center>");
define("_bthelpfind","Hilfe durchsuchen");
define("_bttype","Kategorien");
define("_bttopsource","TOP Download-Qüllen");
define("_btnotopsource","Im Moment werden keine Torrents heruntergeladen");
define("_btnotseeder_noneed","Im Moment gibt es keine kritischen Torrents");
define("_btnotseeder_desc","Wenn du eine dieser Dateien hast, teile (seede) sie bitte für Leute, die auf ihren Download warten. Versuche einfach, die Datei erneut herunterzuladen, und deine Datei als Ziel festzulegen. Dein Client wird dies feststellen und NIEMALS deine Datei verändern.<br>Danke von allen für deine Hilfe. Es könnte Leute geben, die für Stunden oder Tage warten. <b>FILESHARE PHILOSOPHY INSIDE</b>");
define("_btnoseeder","KEINE VOLLSTÄNDIGE Qülle");
define("_btnet","Netzwerk");
define("_btsource","Qüllen");
define("_btvisible","Sichtbar");
define("_bttorrent","Torrent");
define("_btview","Gesehen");
define("_bthits","Heruntergeladen");
define("_btsnatch","Vollständig");
define("_btalternatesource","Nur alternative Qüllen verfügbar");
define("_bteasy","Schneller download");
define("_btmedium","Langsamer download");
define("_bthard","Schwierig herunterzuladen");
define("_btstats","Statistiken");

//TESTI CHE COMPAIONO IN DETAILS.PHP
define("_btddownloaded","Heruntergeladen");
define("_btdcomplete","Vollständig");
define("_dtimeconnected","Zeit verbunden");
define("_btsourceurl","Verfügbar auf");
define("_btdidle","Pausiert");
define("_btdsuccessfully","Torrent erfolgreich hochgeladen");
define("_btdsuccessfully2","Bitte beginne das Verteilen (seeding). Die Sichtbarkeit hängt von der Zahl der Qüllen ab.");
define("_btdsuccessfullye","Änderung erfolgreich");
define("_btdgobackto","Zurück zur Seite");
define("_btdwhenceyoucame","seit du gekommen bist von");
define("_btdyoursearchfor","Deine Suche nach");
define("_btnotorrent","Torrent existiert nicht oder wurde gesperrt");
define("_btdratingadded","Bewertung hinzugefügt");
define("_btdspytorrentupdate","SpyTorrent hat die Qüllen aktualisiert");
define("_btdspytorrentupdate1","Du wirst in 3 Sekunden zur Seite umgeleitet");
define("_btdspytorrentupdate2","Wenn etwas schief geht, kannst Seite erreichen von");
define("_btdspytorrentupdate3","hier");
define("_btdspytorrentnoupdate","Es ist nicht nötig, SpyTorrent zu auf internen Torrents laufen zu lassen, oder bevor 15 Minuten seit dem letzten Scan vergangen sind.");
define("_btname","Name");
define("_btdownloadas","Download als");
define("_btnetwork","Netzwerk");
define("_bthelpinfohash","Info Hash Help");
define("_btdescription","Beschreibung");
define("_btnodead","<b>keine</b> (toten)");
define("_btvisible","Sichtbar");
define("_btbanned","Verbannt");
define("_btfiles","Datei(en)");
define("_btothersource","Andere Qüllen");
define("_btnoselected","Keine Kategorie ausgewählt");
define("_btago","seit");
define("_btlastseeder","Letzter Seeder");
define("_btlastactivity","Letzte Aktivität");
define("_bttypetorrent","Typ");
define("_btsize","Grösse");
define("_btminvote","Keine Bewertung. (Mindestens __minvotes__ Stimmen benötigt");
define("_btonly","nur");
define("_btnone","keine");
define("_btnovotes","Keine Bewertung");
define("_btoo5","von 5 mit");
define("_btvotestot","Stimmen insgesamt");
define("_btlogintorate","Login</a> um abzustimmen");
define("_btvot1","Sehr schlecht");
define("_btvot2","Nicht gut");
define("_btvot3","Nicht schlecht");
define("_btvot4","Gut");
define("_btvot5","Sehr gut");
define("_btaddrating","Bewerten");
define("_btvote","Abstimmen!");
define("_btrating","Bewertung");
define("_bthelpstat","Statistik-Hilfe");
define("_btviews","gesehen");
define("_bttimes","mal");
define("_btleechspeed","Leech-Geschwindigkeit");
define("_bteta","ETA");
define("_btuppedby","Hochgeladen von");
define("_btnumfiles","Anzahl der Dateien");
define("_btfilelist","Dateiliste");
define("_btlasttrackerupdate","Letztes Tracker-Update");
define("_bthidelist","Liste verbergen");
define("_btleechers","Unvollständig");
define("_bthelpsource","Peer-Hilfe");
define("_btseeds","Vollständig");
define("_btcommentsfortorrent","Kommentare uber den Torrent");
define("_btbacktofull","Zurück zu den vollständigen Details");
define("_btnotifyemailcom","Wenn du eine e-mail erhalten willst, wenn Kommentare hinzugefügt werden, ");
define("_btnotnotifyemailcom","Im Moment erhältst du eine e-mail, wenn Kommentare hinzugefügt werden. Wenn du keine e-mails mehr erhalten willst, ");
define("_btclickhere","clicke hier");
define("_btnotifyemail1s","Falls du eine e-mail erhalten willst, wenn der erste <b>SEEDER</b> hinzugefügt wird");
define("_btnotnotifyemail1s","Die bekommst im Moment e-mail bei neün Seedern. Wenn du diese e-mails nicht mehr bekommen willst,");
define("_btaddcomment","Kommentar hinzufügen");
define("_btnocommentsyet","Im Moment gibt es noch keine Kommentare");
define("_btnotnotifyemail1s","damit du eine email erhältst, wenn der erste SEEDER hinzugefügt wird");
define("_btdgavesresult","hat ein Ergebnis");
define("_btdnotifyemaildel","Du bekommst keine Benachrichtigungen per e-mail mehr.");
define("_btdnotifyemaildel1","Du bekommst keine e-mail mehr, wenn ein Kommentar hinzugefügt wurde.");
define("_btdnotifyemailadd1","Du wirst eine e-mail bekommen, wenn sobald ein Kommentar hinzugefügt wurde, aber keine weiteren bevor du den ersten Kommentar gelesen hast!");
define("_btdnotifyemailadd","Du wirst e-mails bekommen, sobald Kommentare hinzugefügt werden");
define("_btdnotifyadd","Du wurdest zur Liste für Seeder-Benachrichtigungen hinzugefügt.");
define("_btdnotifyadd2","Du wirst über neü Seeder lediglich eine e-mail pro Tag erhalten!");
define("_btdnotifydel","Du wurdest von der Benachrichtigungsliste entfernt und erhältst keine e-mails mehr!");
define("_btddetails","Torrent details");
define("_bteditthistorrent","Diesen Torrent ändern");
define("_btyes","Ja");
define("_btno","Nein");
define("_btadded","Hochgeladen");
define("_btaddedby","Hochgeladen von");
define("_bton","hoch");
define("_bthelpothersource","Hilfe über alternative Qüllen");
define("_btfilename","Dateiname");
define("_btpeers","Qüllen");
define("_btpeerstot","Gesamtzahl der peers");
define("_bthelppeer","Peer Hilfe");
define("_btleechers","Leecher");
define("_btdhelpdownload","Download Hilfe");
define("_btyourate","Du hast abgestimmt");
define("_btupdatesource","Qüllen aktualisieren!");
define("_btseeders","Seeder");
define("_btcomplyouvoted","Du fandest diesen Torrent: ");
define("_btcomplexplain","Der Torrent wird verbannt, wenn eine Zahl von Beschwerden über ihn eingeht.");
define("_btcomplaintform","Beschwerdeformular für Torrents.<BR>Dieses System ist anders als unser Bewertungssystem und erlaubt es, gegen Torrents zu stimmen, die gegen unsere Regeln verstossen.<BR>Torrents, die eine gewisse Zahl von Beschwerden bekommen, werden automatisch vom System verbannt.<BR>Bitte schicke positive Meinungen über Torrents, die gut und legal sind.<BR>");
define("_btcomplisay","Dieser Torrent ist ");
//Marker p means positive feedback, n means negative
define("_btcomplatthemoment","Bis jetzt haben Benutzer  <b>**p**</b> positive Meinungen und  <b>**n**</b> negative Meinungen abgegeben.<BR>");


//TESTI PRESENTI IN TAKEUPLOADURL.PHP
define("_btinseriti","Eingefügt");
define("_btand","und");
define("_btnumerror","ihre Zahl ist nicht gleich und es ist nicht möglich, mit der Zuweissung der Binärdateien fortzufahren.");
define("_btmaxchar","ED2K URL darf nur 200 Zeichen lang sein");
define("_bted2kstart","URL beginnt nicht mit <b>ed2k://</b>");
define("_bt2par","URL hat keinen zweiten Parameter: ");
define("_bturlfile","Datei");
define("_bturlcontent","URL enthält keinen");
define("_btfname","Dateiname");
define("_bturlsize","URL enthält keine");
define("_btsz","Grösse");
define("_btidcode","hash info");
define("_bturlparerror","Bei der URL fehlt der Parameter:");
define("_bturlsureerror","URL enthält eine ungültige Qülle");
define("_bturlnotinsert","ED2K Link muss eingefügt werden");
define("_btnotip","IP nicht angegeben");
define("_btinvip","Ungültige IP");
define("_btnoport","Kein Port angegeben");
define("_btinvport","Ungültiger Port");
define("_btparmag","kein");
define("_btnopresent","nicht anwesend");
define("_btmagchar","MagnetURL darf maximal 200 Zeichen lang sein");
define("_bftminlimit","Du darst keine Dateien sharen, die kleiner sind als");
define("_btfmaxlimit","Dein Torrent enthält eine Datei, die zu gross ist");
define("_btillegalword","Schlüsselworte des Dateinamens deuten auf illegale Inhalte hin.");
define("_btillegalwordinfo","Unser Portal verwendet einen speziellen Wortfilter, um illegale Aktivitäten einzudämmen. Uns ist bewusst, dass eine Datei legal sein kann, auch wenn sie Wörter enthält, die auf illegale Inhalte hinweisen. Bitte nimm unsere Entschuldigung an und versuche eine Datei mit einem etwas anderen Namen hochzuladen.");
define("_bturlinserted1","Torrent hochgeladen. Du wirst in 3 Sekunden umgeleitet.<BR>Wenn die Umleitung nicht funktioniert erreichst du die Seite über ");
define("_bturlinserted2","diesen link");
define("_btnotify","Du wurdest zur Benachrichtigungsliste hinzugefügt; du wirst per e-mail benachrichtig, wenn neü Kommentare abgegeben wurden.");
define("_btnolinkinsert","Keinen link eingefügt");
define("_btexnostartwt","eXeem links beginnen mit exeem://");
define("_btillegalcat"," Verboten kategorie!");

//TESTI PRESENTI IN UPLOAD.PHP
define("_btphotöxt","Bilddatei hat nicht die Erweiterung GIF, JPG or PNG");
define("_btalertmsg","Daten wurden nicht übermittelt aufgrund der folgenden Fehler:");
define("_btalertmsg2","Bitte behebe die Fehler und versuche das Hochladen erneut.");
define("_btfnotselected","FEHLER: Datei nicht ausgewählt");
define("_btalertdesc","Bitte gib eine Beschreibung ein, die den Dateityp und die QualitÃt angibt. Dies gilt besonders für Multimedia-Dateien.");
define("_btalertcat","Wähle eine Kategorie");
define("_btconferma","Bist du bereit, die Datei hochzuladen? Wenn dein Torrent aus mehreren Dateien besteht, erzeuge es noch einmal als Container für mehrere Dateien, der ein ganzes Verzeichnis enthält. Ansonsten ist der Torrent unbrauchbar und bereitet Leuten, ihn herunterladen wollen, nur Ärger.");
define("_btalerturl","Füge einen  MAGNET oder ED2K-Link hinzu");
define("_btalerturlnum1","Anzahl im ED2K-Link");
define("_btalerturlnum2","während die Anzahl im die MAGNET-Link ist");
define("_btalerturlnum3","Die Zahl der links muss gleich sein, da Torrents aus einem Paar von Links bestehen.");
define("_btalert5char","Dateiname muss mindestens 5 Zeichen lang sein");
define("_btofficialurl","Die offiziellen Tracker dieser Seite sind:");
define("_btseeded","Lade nur Torrents hoch, wenn du diese auch teilst (seedest). Ein Torrent ohne peers scheint nicht auf der Hauptseite.");
define("_btupfile","Datei hochladen:");
define("_bttorrentname","Name des Torrent");
define("_btfromtorrent","Sorge dich nicht über das Ausfüllen dieses Feldes: es wurde automatisch vom System anhand des Dateinamens ausgefüllt werden.");
define("_btdescname","Versuche einen beschreibenden Namen zu geben");
define("_btsrc_url","URL der QÜlle");
define("_btcompulsory"," (Verpflichtend)");
define("_btdescription","Beschreibung des Torrent (benötigt)");
define("_btnohtml","OHNE HTML");
define("_btchooseone","Wähle");
define("_bttype","Typ");
define("_btverduplicate","Prüfe, ob es ähnliche Torrents gibt");
define("_btduplicatinfo","Wenn ausgewählt stoppt das System das Hochladen, wenn ein ähnlicher Torrent gefunden wird. Wähle es nur dann ab, wenn du immer noch dein Torrent hochladen willst. Denke daran, dass doppelte Torrents die Benutzer lediglich verwirren, so dass es besser ist, nur einen Torrent pro Produkt zu haben.");
define("_btupevidence","Beweise");
define("_btupevidencinfo","Bitte benutze das System veratwortungsvoll: benutze es nur, wenn die Datei fÃr die meisten Leute interessant sein önnte, und wenn es einen stabilen Seed gi (vielleicht 24/7 wenn mÃglich, fÃr mindestens eine Wo...)");
define("_btowner","Besitzer");
define("_btowner1","Zeige User");
define("_btowner2","Privater Modus");
define("_btowner3","Stealth Modus");
define("_btownerinfo","Die Option 'ZEIGE USER' erlaubt es, anderen Benutzern deinen Benutzernamen anzuzeigen. 'PRIVATER MODUS' verbirgt ihn, aber erlaubt die Funktion zum Ändern und Löschen des Torrents, 'STEALTH MODE' verbirgt den Beutzer vollständig vor dem System und erlaubt dem Benutzer weder das Löschen noch das Ändern seiner Torrents.");
define("_btupnotify","Benachrichtigen");
define("_btupnotifynfo","Du wirst eine e-mail erhalten, wenn ein Kommentar hinzugefügt wurde");
define("_btfsend","Torrent senden ");
define("_btinserte2k","ED2K Link einfügen");
define("_btmagnetinsert","Magnet Link einfügen");
define("_btinsertlinktitle","Links für GNutella and eDonkey2000 Netzwerke einfügen");
define("_btinsertlinktext","Du kannst einen eDonkey2000-Link zu deinen Bit Torrent-Dateien hinzufügen, um den Ausfall des Trackers zu vermeiden. Deine Links werden aktiv sein bis sie von unserem Team als Fakes oder als peerless erkannt werden.");
define("_btinserttext2","Du kannst entweder nur MAGNET-Links oder nur ED2K-Links einfügen. Wenn beide listen mit Einträgen gefüllt sind werden zwei Links jedem File zugeordnert. In anderen worten werden der erste ED2K-Link und der erste MAGNET-Link der ersten Datei zugeordnet, usw... Durch das Erzeugen von langen Dateilisten stehen mehr Dateien zum Download bereit. Dies ist ein sehr interessantes Feature und nützlich,  um deinen Download in kleine Teile zu unterteilen Shareaza benutzt (das beide Arten von Links erkennt).");
define("_bted2kurl","ED2K-Link einfügen");
define("_btsyntax","Wie");
define("_btfiletype","Erweiterung");
define("_btfilesize","Grösse");
define("_btidcode","infohash");
define("_btipport","ip:port");
define("_btstatic","zeigt an, dass wir nur das eDonkey2000-Protokoll benutzen");
define("_btfinalname","ist der Name der herunterzuladenden Datei");
define("_btfinalsize","ist die Grösse der Datei in Bytes");
define("_btfinalidcode","ist ein spezieller Code zur Verifizierung, der es erlaubt, EINE DATEI und ihre Kopien unter ähnlichen Dateien zu finden.");
define("_btfinalipport","repräsentiert die stabile Hauptqülle (von Releasern benutzt)");
define("_btor","oder");
define("_btaddmagnet","MAGNET-Link hinzufügen");
define("_btadded2k","eD2K-Link hinzufügen");
define("_bthelpupload","Benötigst du Hilfe?  Dann sieh in unsere <a href='modules.php?name=$name&file=upload_help'>Anleitung</a>.");
define("_btphoto","Bild");


//TESTI CHE COMPAIONO IN ADDCOMMENT.PHP
define("_btiderror","Ungültige ID");
define("_btnotfoundid","Torrent existiert nicht");
define("_btaddcomment","Kommentar hinzufügen zu");
define("_btaddtime","Hochgeladen ");
define("_btby","von");
define("_btsend","Senden");

//TESTI CHE COMPAIONO IN DELETE.PHP
define("_btcannotdel","Kann nicht geloscht werden!");
define("_btmissingdata","Daten zur Anfrage fehlen!");
define("_btdeldenied","Nur der Besitzer oder ein Administrator können diesen Torrent löschen");
define("_btnotconfirmed","Du solltest dir sicher sein, was du tun willst.");
define("_btdeleted","Torrent gelöscht");
define("_btgoback","Zurück");

//TESTI CHE COMPAIONO IN DOWNLOAD.PHP
//LE PAROLE TRA "** **" SONO INDICATORI
define("_btantiscrocco","<p>Wenn du weiterhin herunterladen willst, kannst  **min_num** weittere Torrents sharen, die jeweils  **min_size** an Daten enthalten und mindestens einen Seeder haben. Denke daran, einen externen Tracker zu verwenden und lade die Datei hier hoch. Wir erinnern daran, dass nur LEGALE Dateien erlaubt sind, und dass du nicht den STEALTH MODE verwenden darfst, da dich das System ansonsten nicht als seeder erkennt. Nur Dateien, die von dir hochgeladen sind können zu den Seeds gezählt werden. Überflüssige und alte Torrents führen dazu, dass dein Benutzeraccount gelöscht wird. Dieser Server synchronisiert sich stündlich mit Torrent-Qüllen, so dass du manchmal Schwierigkeiten haben kannst. Indem man Leute dazu zwingt zu teilen, ermöglicht man ein Wachstum der Community.</p><P>Versuche soviele Torrents zu seeden wie du kannst. Versuche nicht, dich unter einem anderen Benutzernamen anzumelden, da wir die IP-Adresen nachvollziehen. Benutzer, die eine Spende machen werden VOLLSTÄNDIGEN Zugriff auf alle Downloads erhalten. Bitte denke daran, bei der Spende deinen Benutzernamen anzugeben. Denke auch daran, dass wir nicht für den Inhalt der Torrents verantwortlich sind, eben so wenig wie für Benutzer, die privat Torrents untereinander austauschen: nur sie können entscheiden, wer herunterladen kann oder auch nciht. $nukeurl kann lediglich Statistiken erstellen, hat aber keine Kontrolle über die Torrents selber. Aber tausende von Leuten sind Zufrieden mit unserem Portal.</p>");
define("_btnogratis","Du kannst ich nicht immer auf Kosten anderer Leben!");
define("_bttodayused","Heute hast du ");
define("_bttomorrow","Torrents benutzt und es ist nicht möglich, heute noch mehr zu benutzen. Komm moren wieder, und denke daran, dass du maximal **maxfile** Torrents pro Tag nutzen kannst.</p>");
define("_btlantoday","Heute hast du oder jemand in deinem LAN mit der IP **ip** hat bereits ");
define("_btlantomorrow"," Torrents benutzt und kann keine weiteren benutzen. Komem morgen wieder und denke daran, dass du ein Maximum von **max_num** Torrents pro Tag benutzen kannst. Wir wissen, dass LANs benachteiligt werden,  We know LANs are penalized, aber wir müssen einen Missbrauch des Netzwerks verhindern.</p>");
define("_btthisweek","In dieser Woche hast du bereits ");
define("_btnextweek"," Torrents benutzt, und weitere sind nicht möglich. Komme nächste Woche wieder und denke daran, dass du ein Maximum von **max_num** Torrents pro Woche benutzen kannst.</p>");
define("_btthisweeklan","Diese Woche hast du, oder jemand der die gleiche IP **ip** hat, bereits ");
define("_btnextweeklan"," Torrents benutzt, und es ist nicht möglich, weitere zu benutzen. and it is not possible to use any more. Komme nächste Woche wieder und denke daran, dass du ein Maximum von **max_num** Torrents pro Woche benutzen kannst.</p>");
define("_btmsgbody1","Der Besitzer hat dir erlaubt, die Dateien, die er oder sie auf BIT TORRENT by **nukeurl** teilt, herunterzuladen, nachdem du dafür um Erlaubnis gefragt hast: ");
define("_btmsgbody2","Von jetzt an kannst du alle Dateien des Benutzers herunterladen. **nukeurl** schützt deine Privatssphäre.");
define("_btmsgsubject","Zugriffserlaubnis für BIT TORRENT-Dateien von **nukeurl**");
define("_btauthreqbody","Benutzer **username** hat darum gebenten, ihm zu erlauben, die Datei die du auf BIT TORRENT von **nukeurl** teilst einsehen zu dürfen. Um die Erlaubnis zu erteilen, gehe zu:\n\n   **nukeurl**/modules.php?name=$name&file=mytorrents&privacy=**userid**\n\n\nUm alle anhängigen Anfragen zu authorisieren, clicke hier:\n\n$nukeurl/modules.php?name=$name&file=mytorrents&privacy=all\n\n\nDu wirst keine weiteren e-mails erhalten bevor du nicht den download aller anhängigen Files erlaubt oder verweigert hast.\nUm alle Benutzer anzuzeigen, die um Erlaubnis gebeten haben:\n\n**nukeurl**/modules.php?name=$name&file=mytorrents\n\n\n**sname** schützt deine Privatssphäre, dein wichtigstes Recht gleich nach Freiheit!");
define("_btautherrpending","Du haast diesen Benutzer bereits um Erlaubnis zum Download gefragt. Bis er oder sie nicht entschieden hat, den Download zu erlauben oder zu verbieten, kannst du keine weiteren Anfragen stellen. Es gibt insgesamt **tot** anhängige Anfragen.");
define("_bterrminseed","<li>Du musstmindestens <b>**min_share**</b> an daten seeden.<br>");
define("_btruleok","Regel ist OK");
define("_btruleko","<b>WARNING: die Regel passt nicht auf dich</b>. ");
define("_bterrnoseeder","<b>Du seedest nichts!</b>");
define("_bterrnotenoughshare1","<b>Du seedest ");
define("_bterrnotenoughshare2"," an Daten und musst mehr seeden ");
define("_bterrtoosmall","<li>Du must mindestens ein File mit der Grösse <b>**min_share**</b> seeden.<br>");
define("_bterrtoobig","<b>Das grösste File, das du seedest ist ");
define("_bterrmaxnumnoseed", "<li>Du kannst maximal <b>**maxfile**</b> herunterladen, ohne Seeder zu sein.<br> ");
define("_bterrmaxdownloadsize","<li>Du kannst jenseits der Grenze von <b>**maxsize**</b> nichts herunterladen.<br>");
define("_btfinalerrmsg1","Zu diesem Zeitpunkt bist du, der die IP <b>**ip**</b> benutzt (du bist der einige, der dies liest) oder andere Benutzer in deinem LAN über die Grenze des <b>freien</b> Download-Limits hinausgegangen.<br>Die Limits für diese Site sind:<ol>");
define("_btfinalerrmsg2","</ol>Um weiterhin <b>ohne Einschränkungen</b> herunterladen zu können, müssen die folgenden Regeln auf dich zutreffen:<ol>");
define("_btfinalerrmsg3","</ol><p>Seeding bedeutet,<b>eine 100% vollständige Datei</b> zu teilen, indem man seine vollständige Datei als Ziel für den Download angibt. Diese Datei wird von Bit Torrent nicht angerührt.<br></p><p>Du kannst auch neü Torrent-Dateien<a href='modules.php?name=**name**&file=upload'>HOCHLADEN</a></p><p>Ansonsten kannst du auch das Ende deiner momentanen Downloads abwarten, die dann automatisch geseeded werden, wenn du dein Download-Fenster NICHT schliesst.</p><p>Wenn du alle Anforderungen erfüllst, kannst du wieder herunterladen.</p>");
define("_bterrorprivate","Dieses ist eine private Datei. DU hast bereits nach eine Erlaubnis zum Download gefragt. Bis der Besitzer deiner Anfrage nicht stattgegeben hat, kannst du diese Datei nicht herunterladen.");
define("_btrefused","Der Benutzer hat deine Bitte um Erlaubnis abgelehnt. Du kannst keine weiteren Anfragen an diesen Benutzer stellen.");
define("_btreqsent","Eine e-mail wurde an den Besitzer der Torrent-Dateo gesendet, um ihn um Erlaubnis zum Download zu fragen. Das Ergebnis dieser Anfrage wird dir per e-mail mitgeteilt.");

//TESTI CHE COMPAIONO IN EDIT.PHP
define("_btedittorrent","Torrent ändern \"");
define("_bterreditnoowner","<h1>Zugriff verweigert</h1>\n<p>Nur der Besitzer und der Administrator können einen Torrent verändern.</p>\n");
define("_btbanned","Verbannt");
define("_btcancel","Abbrechen");
define("_btdelcommand","Torrent nicht ändern, sondern <input type=\"submit\" valü=\"LÖSCHEN!\" />\n");
define("_btsure","Ja, ich bin sicher!");

//TESTI CHE COMPAIONO IN MYTORRENTS.PHP
define("_btallauthorized","Alle Benutzer wurden authorisiert");
define("_btauthorized","Ausgewählter Benutzer wurde authorisiert");
define("_bthasauthorized","Besitzer hat dir erlaubt, seine Dateien herunterzuladen");
define("_btnowcandownload","Du kannst jetzt alle Dateien des Besitzers herunterladen.\nWir schützen deine Privatssphäre.");
define("_btauthmailsubj","Zugriffsgenehmigung für eine BIT TORRENT-Datei");
define("_btauthorizationreqüsted","Die folgenden Benutzer haben eine Erlaubnis zum Herunterladen erbeten:");
define("_btnotorrents","Es gibt keine Torrents");
define("_btnotorrentuploaded","Du hast noch keine Torrents hochgeladen");

//TESTI CHE COMPAIONO IN TAKECOMMENT.PHP
define("_btcommentkeyfound","Das System hat die Wörter aus deinem Kommentar überprüft. Die folgenden Worter könnten mit illegalen Aktivitäten verbunden werden:<ol>");
define("_btcommentkeyfound2","</ol><p>Wir wissen, dass der Kommentar dennoch legal sein kann und entschuldigen uns für die Unannehmlichkeiten, indem wir dich bitten, andere Wörter zu verwenden. Dieses ist ein automatischer Filter, der manchmal Fehler macht.</p>");
define("_bttorrentmailbody","Hallo, du bekommst diese Nachricht, weil du dieses ausdrücklich auf BIT TORRENT service\nrabout TORRENT **nome** verlangt hast.\n\nUm den Kommentar zu sehen, clicke auf:\n\n**url_site**/modules.php?name=**name**&file=details&id=**id**&viewcomm=**newid**&sn=u#comm**newid**\n\n\nDu musst auf der Seite eingeloggt sein, um ihn zu sehen..\n\nDu wirst keine weiteren e-mails über diesen Torrent erhalten bis du den Kommentar gelesen hast.\n\n\nUm keine weitere Benachrichtigung über Kommentare über diesen Torrent zu erhalten, clicke hier:\n**url_site**/modules.php?name=**name**&file=details&id=**id**&cn=n");
define("_btcommentinserted","Kommentar erfolgreich eingefügt. Du wirst in 3 Sekunden auf die Torrent-Seite umgeleitet.<br>Du kannst die Seite auch  <a href=\"modules.php?name=**name**&file=details&id=**id**&viewcomm=**newid**#comm**newid**\">hier</a> erreichen, wenn du Probleme hast.");

//TESTI CHE COMPAIONO IN TAKEEDIT.PHP
define("_btmissingformdata","Fehlende Daten!");
define("_bteditfailed","Änderung fehlgeschlagen");
define("_bteditdenied","Du darfst die Torrents von anderen Benutzern nicht ändern!");
define("_btreturl","Datei erfolgreich geändert. Du wirst in 3 Sekunden zur Torrent-Seite geleitet..<br>Du kannst die Seite <a href=\"**returl**\">hier</a> erreichen, wenn du Probleme hast.");

//TESTI CHE COMPAIONO IN TAKERATE.PHP
define("_btratefailed","Stimmabgabe fehlgeschlagen!");
define("_btinvalidrating","Ungültige Bewertung");
define("_btidnotorrent","Ungültige ID. Torrent existiert nicht");
define("_btnovoteowntorrent","Du kannst nicht für deine eigenen Torrents stimmen");
define("_btalreadyrated","Torrent bereits bewertet");
define("_btvotedone","Stimmabgabe erfolgreich. Du wirst in 3 Sekunden zur Torrent-Seite geleitet.<br>Du kannst die Seite <a href=\"modules.php?name=**name**&details.php&id=**id**&rated=1\">hier</a> erreichen, wenn du Probleme hast.");

//TESTI CHE COMPAIONO IN TAKEUPLOAD.PHP
define("_btuploadfailed","Upload fehlgeschlagen!");
define("_btemptyfname","Leerer Dateiname");
define("_btinvalidfname","Ungültiger Dateiname");
define("_btfnamenotorrent","Dies ist keine Torrent-Datei (.torrent)");
define("_btferror","Dateifehler");
define("_bterrnofileupload","Schwerer Fehler in der Datei.");
define("_btemptyfile","Datei ist leer");
define("_btnobenc","Datei beschädigt. Bist du sicher, dass es wirklich ein Torrent ist?");
define("_btnodictionary","Torrent dictionary fehlt");
define("_btdictionarymisskey","Fehlende Torrent Dictionary Keys");
define("_btdictionaryinventry","Ungültige Daten im  Torrent Dictionary");
define("_btdictionaryinvetype","Ungültige Datentypen im Torrent Dictionary");
define("_btinvannounce","Ungültige Announce URL. Sie muss lauten ");
define("_btactualannounce","Angegebener Tracker ");
define("_bttrackerdisabled","Unser Tracker wurde abgeschaltet. <a href='modules.php?name=**name**&file=upload_help'>Lies die Anleitung</a>, um zu lernen, wie man externe Tracker benutzt.");
define("_btinvpieces","Ungültige Torrent-Teile");
define("_btmissinglength","Fehlende Dateien und Grösse");
define("_btnofilesintorrent","Fehlende Dateien im Torrent");
define("_btfnamerror","Ungültiger Dateiname");
define("_btfilenamerror","Fehler im Dateinamen");
define("_bttorrenttoosmall","<p>Du kannst keine Datei teilen, die kleiner ist als <b>");
define("_bttorrenttoosmall2","</b></p><p>Dein Torrent enthält eine Datei mit <b>");
define("_btmaxuploadexceeded","Es ist nicht erlaubt, mehr als  **maxupload** innerhalb von  24 Stunden hochzuladen.");
define("_btnumfileexceeded","<p>Es ist nicht möglich, mehr als  <b>**maxupload**</b> Dateien innerhalb von 24 Stunden hochzuladen.</p><p>Bis jetzt hast du bereits <b>**rownum**</b> Dateien hochgeladen, mit einer Gesamtgrösse von <b>**totsize**</b>.");
define("_btsearchdupl","Die Suche ergibt folgende Dateien, die zu denen korrespondieren, die zu gerade teilst:<ol>");
define("_btduplinfo","<p>Wenn deine Datei in der Liste ist, seede bitte einen dieser Torrents!</p>");
define("_btsocktout","FEHLER: Time-Out im Socket");
define("_bttrackernotresponding","Tracker antwortet nicht.\n Überprüfe den Namen des Trackers (KEINE LEERZEICHEN IN URLs) und prüfe, ob der Tracker läuft. Angegebener Tracker:");
define("_bttrackerdata","Ungültige Daten auf dem externen Tracker. Dies kann ein Server-Problem auf dem Tracker sein. Versuche es später noch einmal.");
define("_btuploadcomplete","Der Upload war erfolgreich. Du wirst in 3 Sekunden auf die Dateien-Seite umgeleitet.  Denke daran, die Datei zu seeden, oder der Torrent wird auf der Hauptseite nicht sichtbar sein!<br>Du kannst die Seite <a href=\"**url**\">hier</a> erreichen, wenn du Probleme hast.");


//TESTI CHE COMPAIONO IN TAKECOMPLAINT.PHP
define("_btcomplisnowbanned","Dieser Torrent wurde aufgrund einer Zahl von Beschwerden gesperrt");
define("_btcomplcantvotetwice","Es tut uns leid, aber sie können eine Beschwerde nur einmal senden.");
define("_btcomplainttaken","Beschwerde aufgenommen. In 3 Sekunden wirst du auf die Torrent-Seite umgeleitet. Ansonsten clicke auf ");
define("_btcomplsuccess","Deine Meinung wurde aufgezeichnet. Benutzername und IP wurden ebenfalls aufgezeichnet, um einen Missbrauch des Systems zu verhindern.<BR>");

//eXeem
define("_btaddexeem","eXeem-Link hinzufügen");
define("_btsegment","Segment");
define("_btexeeminsert","eXeem-link einfügen");
define("_btlinkstart","Link beginnt nicht mit ");
define("_btumagneturl","Magnet-link hinzufügen");
define("_btexeemurl","eXeem-link");
define("_btalerturlnum4","while Magnet is");
define("_btalerturlnum5","Magnet links number is");
define("_btinserttext3","You may insert either only eXeem links or combinations of the three types. Remember there must be as many eXeem links as many other netowrks' links. If you insert 3 eXeem links and you want to insert eD2K links you must insert 3 eDonkey2000 links and they will be associated.");
define("_btalerturlnum5","Magnet link Nummer ist");
define("_btuploadurl","Links senden");
define("_btlinkmaxchar","Maximale Linkgrösse überschritten");
define("_btalertmsg1","Aufgrund der folgenden Fehler wurden die Formulardaten nicht übermittelt.");
define("_btalertmsg2","Bitte das Formular korrigieren und erneut übermitteln.");
define("_btconferma2","Bist du bereit für den Upload? Wenn dein Packet aus mehreren Dateien besteht, füge diese bitte ebenfalls in die gleiche Einsendung ein.");
define("_btevidenced","Sticky");
define("_btinsertlinktitle","GNutella - eDonkey2000 - eXeem Links einfügen");
define("_btalerturlnum3","Links number must be equal since each file is composed by pairs of links");

// Rules
define("_btrules","Rules");
define("_brrulesadmin","Admin-Rules");
define("_btrulesmod","Moderator-Rules");
define("_btrulesprem","Premium-Rules");
define("_btrulesuser","User-Rules");
define("_btrulesgen","General-Rules");
define("_btrulesadd","Add New Rules Section");
define("_btrulesaddsect","Add Rule Section");
define("_btnamelevel","User Level for this rule");
define("_bttitle","Section Title");
define("_btlevel","Level");
define("_btrulesedit","Edit Rules");

//massmail
define("_btmmbody","Body");
define("_btmmsendto","Send mass e-mail to selected member levels");
define("_btmmlinks","You May Use Links In Your emails");

?>
