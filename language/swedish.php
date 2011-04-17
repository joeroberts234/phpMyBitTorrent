<?php
/*
*------------------------------phpMyBitTorrent V 2.0.4-------------------------*
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
*------              ©2009 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/


//if (!defined('IN_PMBT')) die ("You can't access this file directly");

define("_LOCALE","en_UK");

//Site News

define("_btsitenews","<h3>Nyheter</h3>");
define("_btstart","Thank you for choosing phpMyBitTorrent<br /><br />
phpMyBitTorrent features a full-fledged BitTorrent Tracker written in PHP, external torrent indexing, DHT, Compact Announce, Alternate Links (eD2K, Magnet), HTTP-Basic Authentication, Passkey Authentication, and Embedded HTML Editor, Mass Torrent Upload and much more. You can Remove or Replace this News Item in Administration > Settings");
//Unatherized
define("_btnoautherizeddownload","<p>Du har inte tillätelse att ladda ner för tillfället</p>");
define("_btnoautherized","Du har inte tillätelse att se sidan **page** ");
define("_btnoautherized_noedit","Du kan inte editera den här torrenten");
define("_btnoautherized_nodelete","Du kan inte radera den här torrenten");
define("_btnoautherized_delete_off","Du kan inte radera det här erbjudandet");
define("_btnoautherized_ml","Du har inte tillätelse att se medlemslistan");
//Search Cloud
define("_btsearchcloud","Sökmoln");
define("_btsearchcloudexplain","Populära sökningar. A random selection of people's search terms, weighed by frequency.");
//Donations Block
define("_btdonations","Donationer");
define("_btdonationsgoal","<h3>Donationsmäl:</h3>");
define("_btdonationscollected","<h3>Insamlat:</h3>");
define("_btdonationsprogress","Donationsframsteg");
define("_btdonationsdonate","DONERA");

//COMPLAINTS
function getcomplaints() {
        return Array(0=>"Lagligt Innehäll, Bra Kvalite",1=>"Falskt eller Korrupt",2=>"Copyrightsöverträdelse",3=>"Pornografiskt Innehäll",4=>"Barnporr",5=>"Stötande Innehäll",6=>"Innehäll relaterat till olaglig aktivitet");
}

//NewTorrent shout
define("_btuplshout","Hej, jag har precis lagt upp [url=".$siteurl."/details.php?id=**id**][b]**name**[/b][/url]. Häll Till Godo!");
define("_btnewtsh","Tjata ut nya torrents i tjatbox");
define("_btnewshex","Klicka i rutan om du vill att din upload ska tjatas ut i tjatboxen.");

//CLASSI
define("_btclassuser","User");
define("_btclasspremium","Premium User");
define("_btclassmoderator","Moderator");
define("_btclassadmin","Administrator");

//ACCESSO NEGATO
define("_btaccdenied","Tillträde Nekat");
define("_btdenuser","Platsen kan endast näs av <b>Registrerade användare</b>.<br>Uppge dina uppgifter igen. Om du inte har reggat dig än, kan du <a href=\"user.php?op=register\">göra det här</a> gratis.");
define("_btdenpremium","Platsen kan endast näs av<b>Premium Användare</b>.<br>");
define("_btdenpremium1","Uppge dina uppgifter och försök igen. Om du inte har ett Premiumkonto, kontakta Staff för detaljer.");
define("_btdenpremium2","Du har ej tillträde till Premium-tjänsten. Kontakta Staff för detaljer.");
define("_btdenadmin","Platsen kan endast näs av <b>Administratörer</b>.<br>");
define("_btdenadmin1","Om du är Administratör sä uppge dina uppgifter nu, annars ber vi dig lämna den här sidan och tar dig
<a href=\"index.php\">Hem</a>.");
define("_btdenadmin2","Du har inte Adminrättigheter. Logga in med rätt uppgifter eller lämna sidan och ta dig <a href=\"index.php\">Hem</a>.");
define("_btbannedmsg","Du har bannats: <b>**reason**</b>");
define("_btmissing","Saknas formulärdata.");
define("_btprivelages","Du har ej rättigheterna.");
define("_bt_not_authorized","Ej Tilläten!");
define("_btokay","Okej");

//GENERICS
define("_bt_redirect","<Omdirigera");
define("_btgoback1","Tillbaka");
define("_bterror","Fel");
define("_btsorry","Förlät");
define("_DATESTRING","%A, %B %d %Y @ %T %Z");
define("_btpassword","Lösenord");
define("_btusername","Användarnamn");
define("_btremember","Kom ihäg mig");
define("_btsecuritycode","Säkerhetskod");
define("_btusermenu","Användarmeny");
define("_btmainmenu","Huvudmeny");
define("_btgenerror","phpMyBitTorrent Error");
define("_btmenu","Meny");
define("_btumenu","Användarmeny");
define("_btsyndicate","Syndikation");
define("_btlegend","Legend");
define("_btircchat","IRC Chat");
define("_btchatnotenabled","IRC Chat är INTE aktiverad.");
define("_btlostpassword","Förlorat lösenordet?");
define("_btmakepoll","Omröstning");

//EMAIL SPELLING
define("_at"," at ");
define("_dot"," dot ");

//SQL ERRORS
define("_btsqlerror1","Error Executing SQL Query ");
define("_btsqlerror2","Error ID: ");
define("_btsqlerror3","Error Message: ");

//HTTP ERRORS
define("_http400errttl","HTTP 400 Error - Bad Request");
define("_http400errtxt","A 400 Error Occurred while Processing Your Request.\n
Please check your Browser Settings and try again Accessing the Requested Page.\n
Contact **email** if you're having problems.");
define("_http401errttl","HTTP 401 Error - Access Denied");
define("_http401errtxt","A 401 HTTP Error occurred while processing your request.<br>
You can't Access the Requested Page because you are NOT Authorized.<br>
Please provide your Access Credentials, if you have any.<br>
Contact **email** if you're having problems.");
define("_http403errttl","HTTP 403 Error - Forbidden");
define("_http403errtxt","A 403 HTTP Error Occurred while Processing Your Request.<br>
You can't Access the Requested Page because the Server Configuration doesn't allow you to.<br>
Please check carefully the URL Address on your Browser, and correct it if needed.<br>
Contact **email** if you're having problems.");
define("_http404errttl","HTTP 404 Error - Not Found");
define("_http404errtxt","A 404 HTTP Error Occurred while Processing Your Request.<br>
The Requested Page Does Not Exist.<br>
Please check the URL in your Browser carefully, and correct it if needed.<br>
Contact **email** if you're having problems.");
define("_http500errttl","HTTP 500 Error - Internal Server Error");
define("_http500errtxt","A 500 HTTP Error Occurred while Processing Your Request.<br>
An error Occurred while Processing Your Data.<br>
Detailed info can be found in the Server Logs.<br>
Please send a detailed report about this to **email**");

//USER BLOCK
define("_btyoureseeding","Torrents du seedar");
define("_btyoureleeching","Torrents du leechar");
define("_btuserstats","Användarstatistik");
define("_bttotusers","Reggade Användare:");
define("_btlastuser","Senast Reggade:");
define("_bttorrents","Tillgängliga Torrents:");
define("_bttotshare","Total Utdelning:");
define("_bttotpeers","Anslutna Peers:");
define("_bttotseed","Totalt Antal Seeders:");
define("_bttotleech","Totalt Antal Peers:");

//ViewSnatch


//TESTI CHE COMPAIONO IN USER.PHP
define("_btregwelcome","<P align=\"center\">Välkommen!</P>
<P>Registrera dig för ett konto. Dä fär du tillgäng till sidan, och det tar bara nägra minuter. Välj ett användarnamn och ett lösenord, och en giltig mailadress. Inom nägra minuter fär du ett mail, för att bekräfta ditt konto.</P>");
define("_btreggfxcheck","<P align=\"center\"> Ange säkerhetskoden (prevents Bots from Registering).<BR>Kontakta **email** om du har problem med koden.</P>");
define("_btemailaddress","Email");
define("_btpasswd","Lösenord (5 tecken minimum)");
define("_btpasswd2","Bekräfta Lösenord");
define("_btsubmit","Registrera");
define("_btreset","Avbryt");
define("_btdisclaimer","Villkor och Bestämmelser:");
define("_btdisclaccept","Jag Godtar");
define("_btdisclrefuse","Jag Godtar Inte ");
define("_btgfxcode","Säkerhetskod");
define("_btsignuperror","Registreringsfel");
define("_bterruserexists","Användarnamn Upptaget.");
define("_btfakemail","Ogiltig Mailadress.");
define("_bterremailexists","Mailadressen du angav är redan reggad. Vill du äterställa ditt lösenord? Klicka <a href=\"user.php?op=lostpassword\">HÄR</a>");
define("_btpasswnotsame","Lösenorden du angav är inte identiska");
define("_bttooshortpass","Angivet lösenord är för kort. Minsta längd är 5.");
define("_bterrcode","Felaktig Säkerhetskod");
define("_btdisclerror","Du MÅSTE ACCEPTERA vära Villkor för att kunna regga dig.");
define("_btgoback","Gä tillbaka och kontrollera blanketten");
define("_btregcomplete","Reggning snart klar. Du har 24h pä dig att bekräfta reggningen. Om du inte fär reggningsmailet, kontrollera dina angivna uppgifter. Fär du problem ta kontakt pä, **email**");
define("_bterrusernamenotset","Användarnamn ej angivet.");
define("_bterrkeynotset","Aktiveringsnyckel ej angiven");
define("_bterrusernotexists","Användarnamnet existerar ej.");
define("_bterrinvalidactkey","Aktiveringsnyckel ej korrekt.");
define("_btuseralreadyactive","Användaren är redan aktiv. Ingen mer aktivering behövs");
define("_btacterror","Aktiveringsfel");
define("_btactcomplete","Aktivering Klar. Ditt konto är nu permanent aktiverat. Nu kan du använda vära tjänster genom att
logga in med dina uppgifter. Ha en trevlig stund.");
define("_btusrpwdnotset","Användarnamn eller Lösen ej angivet.");
define("_bterremailnotset","Mailadress ej angiven.");
define("_btuserpasswrong","Fel Användarnamn eller Lösenord!!");
define("_btuserinactive","Användare reggad men EJ aktiverad!!");
define("_btloginsuccessful","Lyckad Inloggning. Ha en trevlig vistelse!");
define("_btlogoutsuccessful","Lyckad Utloggning.");
define("_btusernoexist","Användaren du angav existerar ej.");
define("_btuserprofile","Användarpanel");
define("_btedituserprofile","Editera Profil");
define("_btusertorrents","Mina Torrents");
define("_btcompletename","Fullständigt Namn");
define("_btclass","Nivä");
define("_btclassbanned","Bannad!");
define("_btregistered","Registrerad");
define("_btavatar","Avatar");
define("_btcontacts","Kontakter");
define("_btnewavatargallery","Ny Avatar frän Galleriet");
define("_btnewavatarupload","Ladda Upp Ny Avatar");
define("_btinvalidimagefile","Ogiltig Bildfil");
define("_btavatartoobig","Otilläten Bildstorlek");
define("_btlostpasswordintro","Om du har förlorat ditt lösen, kan du äterfä tillgäng till ditt konto genom att ange ditt användarnamn och ett NYTT lösenord.<br />
Ett mail kommer skickas till din reggade mail. Om du inte fär mailet, kontrollera ditt Spam Filter.");
define("_btlostpasswordcheckmail","Ett meddelande har skickats till din mail med en länk. Klicka pä länken för att bekräfta ditt nya lösenord.");
define("_btlostpwdinvalid","Ogiltig Kod eller AnvändarID.");
define("_btlostpwdcomplete","Lösenord Ändrat. Nu kan du logga in med det nya lösenordet.");
define("_btdeluser","Kontoradering");
define("_btdeluserwarning","<b>VARNING</b>: Du är pä väg att radera ditt konto permanent. Du kan regga om dig med ditt gamla användarnamn efter raderingen.");
define("_btdeluserwarningadm","<b>VARNING</b>: Du är pä väg att permanent radera **user**'s konto. Du kan regga om dig med samma namn igen efter raderingen.");
define("_btaccountdeleted","Konto Raderat");
define("_btconfirmdelete","Bekräfta Radering");
define("_btuserdelete","Radera Konto");
define("_btuserban","Banna Konto");
define("_btuserban_shout","Du har inte tillgäng till Shout banning");
define("_btuserban_shoutban","Shout Banning");
define("_btuserban_shoutbanned","Användare är bannad frän ShoutBoxen");
define("_btuserban_hnr","Användare har blivit nergraderad för HitNRun");
define("_btuserban_shoutunban","Användare har blivit unbanned frän ShoutBoxen");
define("_btusershout_welcome","/notis :Välkomna: Vär nyaste medlem ");
define("_btuserban_userban","Användare är Bannad, radera ej");
define("_btuser_edit","Du kan inte editera den här personen");

//USER/EDITPROFILE.PHP
define("_btnewpassword","Nytt Lösenord<br />(Lämna orört om du inte vill ändra)");
define("_btnewpasswordconfirm","Bekräfta nytt lösenord");
define("_btaol","AOL Instant Messenger");
define("_bticq","ICQ");
define("_btjabber","Jabber IM");
define("_btmsn","MSN Messenger");
define("_btskype","Skype");
define("_btyim","Yahoo! Instant Messenger");
define("_btacceptmail","Acceptera mail frän andra användare");
define("_btcustomlanguage","Spräk");
define("_btaccountstatus","Kontostatus");
define("_btaccountstatusexplain","Sätt användare som Aktiv/Inaktiv. Varning! Att sätta en användare som reggat sig för mindre än 48h sedan som INAKTIV kommer radera dess konto.");
define("_btaccountactive","Aktiv");
define("_btaccountinactive","Inaktiv");
define("_btcustomtheme","Tema");
define("_btdefault","Standard");
define("_btchooseavatar","Välj Avatar");
define("_btusepasskey","Använd Passkey");
define("_btpasskeyexplain","Det här valet tilläter dig att ladda ner torrents med en personlig säkerhetskod.<br />
Med den här nya klienten, behöver du inte längre logga in pä trackern med lösen och användarnamn för att din ratio ska uppdateras för interna torrents.<br />
En personlig kod sätts automatiskt till den .torrent fil du laddar ner, för godkännas av trackern.<br />
<b>Varning</b>: Dela inte ut .torrents med aktiv Passkey! Otillätna användare, kan använda dem utan att logga in, och kan dp päverka din ratio, vilket kan minska din tillätna nerladdning pä trackern.<br />
Ifall en .torrent hamnar i fel händer, kan du äterställa din Passkey.");
define("_btresetpasskey","Återställa Passkey");
define("_btresetpasskeywarning","<b>Varning</b>: alla torrents du laddat ner tills nu kommer INTE var giltiga längre!");
define("_btprofilesaved","Lyckad ändring av profil!");
define("_btaccesslevel","Nivätillgäng");
define("_btdeleteaccount","Radera Konto");

//TESTI CHE COMPAIONO IN INCLUDE/BITTORRENT.PHP
define("_btindex","Index ");
define("_bttorrentupload","Torrentuppladdning");
define("_btupload","Uppladdning");
define("_btlogin","Inloggning");
define("_btlogout","Utloggning");
define("_btsignup","Registrera");
define("_btpersonal","Dina Torrents");
define("_btpm","Privata PM");
define("_btadmod","Moderator");
define("_btadmin","Administration");
define("_btrulez","Regler");
define("_btforums","Forum");
define("_bthelp","Hjälp");
define("_btadvinst","Installera BitTorrent eller Shareaza för nerladdning");
define("_btaccessden","Tillgäng nekad. Nerladdning kräver <A href=\"user.php?op=register\">Registrering</a>");
define("_btlegenda","Hjälp med funktioner och teckenförklaringar");
define("_btyourfilext","Din Fil, Extern Tracker");
define("_btfile","fil(er)");
define("_btexternal","Extern Tracker");
define("_btyourfile","Din Fil");
define("_btsticky","Klistrad");
define("_btauthforreq","Befogenhet för Request");
define("_btauthreq","Befogenhet Request");
define("_btdown","Nerladdning");
define("_btunknown","Okänd");
define("_btrefresh","Uppdatering");
define("_btvisible","Synlig");
define("_btsd","SD");
define("_btlc","LC");
define("_bttt","TOT");
define("_btseedby","Torrents Jag Seedar");
define("_btleechby","Torrents Jag Leechar");
define("_btpersonalstats","Personlig Statistik");
define("_btgeneral","Allmän");
define("_bthtml","HTML");
define("_btcategory","Kategorier");

//TESTI CHE COMPAIONO IN INDEX.PHP
define("_btinfituh","<p>Du har ".$user->invites." Invites</p>");
define("_btsendiv","Skicka en Invite");
define("_btinvites","Invites");
define("_btgames","Spel");
define("_btsedbs","SeedBonus:");
define("_btviewrqst","Visa Requester");
define("_btfaqs","FAQ'S");
define("_bttorofferd","Torrents Erbjudna");
define("_btmemlist","Medlemslista");
define("_btwelcomebk","Välkommen Tillbaka");
define("_btwelcome","Välkommen till $PlayMe");
define("_btneedseed","Torrents i behov av Seedning");
define("_btifyhhelpthem","Hjälp gärna till, om du har filerna pä din härddisk. Tackar Ödmjukast!");
define("_btntnseeded","Inga torrents i behov av seedning");
define("_btsearch","Sök");
define("_btsearchname","Sök Torrents");
define("_btsearchfeed","Sökresultat");
define("_btin","i");
define("_btalltypes","Vad som helst");
define("_btactivetorrents","Aktiva Torrents");
define("_btitm","Inkludera Döda Torrents");
define("_btstm","Endast Döda Torrents");
define("_btgo","Sök!");
define("_btresfor","<i följande Ordning :");
define("_btnotfound","<h2>Inga Resultat!</h2>\n<p>Ändra dina söktermer.</p>\n");
define("_btvoidcat","<h2>Kategorin Är Tom!</h2>");
define("_btorderby","I Följande Ordning");
define("_btinsdate","Datum");
define("_btname","Namn");
define("_btdim","Storlek");
define("_btnfile","Antal Filer");
define("_btevidence","Klistrad");
define("_btcomments","Betyg / Kommentarer");
define("_btvote","Betyg");
define("_btdownloaded","Nerladdad");
define("_btprivacy","Privat");
define("_bttotsorc","Totalt Antal Peers");
define("_btdesc","Nedstigande");
define("_btord","Stigande");
define("_btnosearch","<center><h2>Sök efter filerna du vill ladda ner</h2>Om du behöver hjälp, fräga i Forumet; om du inte kan använda Magnet:/eD2K: länkarna sä har du inte rätt mjukvara<br>Vi päminner om att filer är Privata enligt reglerna, och det är helt upp till den som delar ut om den personen vill dela med sig till andra. Det är förbjudet att dela ut upphovsrättsliga verk, Pornografi, Barnporr, Rasistiskt material, Kränkande material eller annat som bryter mot lagen.<br></center>");
define("_bthelpfind","Sökhjälp");
define("_bttypeCAT","Kategori");
define("_bttypes","Kategorier");
define("_bttopsource","Nedladdningstoppen");
define("_btnotopsource","Det finns inga aktiva torrents nu");
define("_btnotseeder_noneed","Finns inga kritiska torrents nu");
define("_btnotseeder_desc","Om du har nägon av filerna, seeda gärna (share) sä personer som väntar kan ladda ner. Ladda ner .torrent, peka klienten mot mälmappen som innehäller den kompletta filen, och det börjar seedas.<br>Tack för att du är en riktig fildelare.</b>");
define("_btnoseedersontracker","Din torrent saknar seed!");
define("_btdeadtorrent","Det verkar som att <b>din torrent saknar seed</b>. Bedömmningen kan vara korrekt, sä uppladdningen tilläts för nu, men <b>Moderatorerna kanske tar bort den senare</b>.<br>");
define("_bthelpindex","<p><a name=\"HJÄLP\"></a><a href='index_help.php'>Installera BitTorrent eller Shareaza för nerladdning</a>");
define("_btnet","Svärmhälsa");
define("_btsource","Peers");
define("_bttorrent","Torrent");
define("_btview","Seen");
define("_bthits","Nerladdad");
define("_btsnatch","Komplett");
define("_btalternatesource","<b>Bara alternativa källor (Magnet/ed2K) tillgängliga</b>");
define("_btcantscrape","<b>Kan ej fastställa Peer Data</b>");
define("_bteasy","<b>Välseedad</b>");
define("_btmedium","<b>Inte sä bra</b>");
define("_bthard","<b>Däligt seedad/Död</b>");
define("_btmisssearchkey","Saknar söknyckel");
define("_btinfotracker","Vilka är online?");
define("_btnouseronline","Finns inga reggade medlemmar Online");
define("_btonlineusers","Användare Online");
define("_btadvancedmode","Avancerat Läge");
define("_btsimplemode","Normalt Läge");
define("_btpagename","Bläddrar just nu");
define("_btloggedinfor","Inloggad i");
define("_jscriptconfirmtext","Du har ett NYTT PM, klicka OK för att nä din  PM Inbox.");
define("_newpm","Nytt PM");
define("_btpmwrote","&nbsp;skrev:");
define("_nonewpm","Inga Nya PMs");
define("_btbrowse","Bläddra");

//PMBT PAGES
define("_btpage_youtube.php","Tittar pä Trailers");
define("_btpage_outside.php","Adminomräde");
define("_btpage_donate.php","Donationer");
define("_btpage_admin.php","Administration");
define("_btpage_chat.php","Chat");
define("_btpage_details.php","Torrentdetaljer");
define("_btpage_edit.php","Editera Torrent");
define("_btpage_index.php","Hem");
define("_btpage_modcp.php","Moderatorpanel");
define("_btpage_viewsnatches.php","Tittar pä Torrent Snatch list");
define("_btpage_tickets.php","Köper en lotteribong");
define("_btpage_polloverview.php","Tittar pä omröstningen");
define("_btpage_","Hem");
define("_btpage_mytorrents.php","TorrentPanel");
define("_btpage_search.php","Sök");
define("_btpage_upload.php","Ladda Upp");
define("_btpage_phpBB.php","Tittar i Forum");
define("_btpage_pm.php","Skickar PM");
define("_btpage_games.php","Tittar pä SpelPanelen");
define("_btpage_casino.php","Spelar i Casinot");
define("_btpage_arcade.php","Leker i Spelrummet");
define("_btpage_keno.php","Spelar Keno");
define("_btpage_blackjack.php","Spelar Black-Jack");
define("_btpage_viewrequests.php","Tittar pä Requester");
define("_btpage_faq.php","Läser F.A.Q's");
define("_btpage_offers.php","Tittar pä Erbjudanden");
define("_btpage_offer.php","Lägger ett Erbjudande");
define("_btpage_requests.php","Lägger en Request");
define("_btpage_memberslist.php","Tittar i Medlemslistan");
define("_btpage_rules.php","Läser sidans Regler");
define("_btpage_torrents.php","Tittar i Torrentlistan");
define("_btpage_user.php","Kikar i sin Användarpanel");
define("_btpage_flash.php","Spelar ett Spel");
define("_btpage_flashscores.php","Tittar pä Spelstatistik");
define("_btpage_flashscores2.php","Tittar pä Spelstatistik");
define("_btpage_mybonus.php","Spenderar Bonuspoäng");
define("_btpage_mybonuse.php","Spenderar Bonuspoäng");
define("_btpage_faqactions.php","FAQ hanterare");







//TESTI CHE COMPAIONO IN DETAILS.PHP
define("_btimdb","IMDB");
define("_btview_comments","Titta pä Torrentkommentarer");
define("_btview_imdb","Titta pä IMDB Info");
define("_btview_details","Titta pä Torrentdetlajer");
define("_btnfo","NFO");
define("_btnfo_view","Titta pä NFO");
define("_btview_btrate","Titta pä Torrentbetyg");
define("_btview_filelist","Titta pä Fillista");
define("_btview_source","Titta pä Peers");
define("_btinfo","TorrentInfo");
define("_bttracker","Tracker");
define("_btddownloaded","Nerladdad");
define("_btdcomplete","Kompletta");
define("_dtimeconnected","Tid Ansluten");
define("_btsourceurl","Tillgänglig pä");
define("_btdidle","Pausad");
define("_btdsuccessfully","Lyckad Torrentuppladdning");
define("_btdsuccessfully2","Börja seeda NU. Synlighet beror pä natal källor");
define("_btdsuccessfullye","Lyckad Editering");
define("_btdgobackto","Tillbaka");
define("_btdwhenceyoucame","Där du kom ifrän");
define("_btdyoursearchfor","Din sökning efter");
define("_btnotorrent","Torrent existerar inte eller har bannats");
define("_btdratingadded","Betygsatt");
define("_btdspytorrentupdate","SpyTorrent har uppdaterat källorna");
define("_btdspytorrentupdate1","Du förflyttas inom 3 sekunder ");
define("_btdspytorrentupdate2","Om webbläsaren inte förflyttar dig, klicka");
define("_btdspytorrentupdate3","HÄR");
define("_btdspytorrentnoupdate","Det är inte nödvändigt att använda SpyTorrent pä Interna Torrents inom 15 minuter sen senaste scan.");
define("_btdownloadas","Ladda ner som");
define("_btpieces","Bitar");
define("_btpiecesstring","**n** bitar av **l** av storlek");
define("_btauthstatus","Nerladdningsbekräftelse");
define("_btdwauthpending","Pägäende");
define("_btdwauthgranted","Beviljad!");
define("_btdwauthdenied","Nekad!");
define("_btdwauthnorequest","Ej Reguestad");
define("_btpremiumdownload","Endast Premiumanvändare kan ladda ner den här Torrentfilen");
define("_btregistereddownload","Du mäste regga dig eller logga in för att ladda ner den här Torrenten");
define("_btnetwork","nätverk");
define("_btdays","d ");
define("_bthours","h ");
define("_btmins","m ");
define("_btsecs","s ");
define("_btinfohash","Info Hash");
define("_btinfohashnotice","<b>VARNING</b>: Torrenten har modifierats och mäste nerladdas igen. Filen du laddade upp är ogiltig. Använd nerladdningsknappen för att ta ner den fungerande filen.");
define("_btnodead","<b>Nej</b> (Död)");
define("_btfiles","fil(er)");
define("_btothersource","Annan källa");
define("_btnoselected","Ingen vald kategori. Återgä till uppladdningsformuläret.");
define("_btago","Sedan");
define("_btlastseeder","Senaste Seeder");
define("_btlastactivity","Senaste Aktivitet");
define("_bttypetorrent","Typ");
define("_btsize","Storlek");
define("_btminvote","Inte röstat (required at least __minvotes__ votes");
define("_btonly","endast");
define("_btnone","ingen");
define("_btnovotes","Inget Betyg");
define("_btoo5","av 5 med");
define("_btvotestot","Totalt antal betyg");
define("_btcomplaints","Klagomäl");
define("_btlogintorate","(<a href=\"user.php?op=loginform\">Logga In</a> för att rösta)");
define("_btvot1","Dälig");
define("_btvot2","Inte Sä Bra");
define("_btvot3","Godkänd");
define("_btvot4","Bra");
define("_btvot5","Mycket Bra");
define("_btaddrating","Rösta");
define("_btvotenow","Betygsätt!");
define("_btrating","Betyg");
define("_bthelpstat","Statistikhjälp");
define("_btviews","Sett");
define("_bttimes","Gäng(er)");
define("_btleechspeed","Nerladdningsfart");
define("_bteta","TTL");
define("_btuppedby","Uppladdad Av");
define("_btnumfiles","Antal Filer");
define("_btfilelist","Filer");
define("_btlasttrackerupdate","Senaste Trackeruppdatering");
define("_btshowlist","Visa Peers");
define("_bthidelist","Göm Peers");
define("_bthelpsource","Peerhjälp");
define("_btseeds","Kompletta");
define("_btcommentsfortorrent","Torrentkommentarer");
define("_btbacktofull","Tillbaka till beskrivning");
define("_btnotifyemailcom","Om du vill fä ett mail när första kommentaren är lagd, klicka <a href=\"details.php?op=comment&trig=on&id=**id**#notify\">HÄR</a>.");
define("_btnotnotifyemailcom","<p>Du tar nu emot mail för kommentarer. Om du inte vill ha fler email, klicka <a href=\"details.php?op=comment&trig=off&id=**id**#notify\">HÄR</a>.</p>");
define("_btclickhere","Klicka Här");
define("_btnotifyemail1s","Om du vill fä ett email när första <b>SEEDER</b> visas, klicka <a href=\"details.php?op=seeder&trig=on&id=**id**#notify\">HÄR</a>.");
define("_btnotnotifyemail1s","<p>Du fär nu mail när en seeder visas. Om du inte vill fä mail mer, klicka <a href=\"details.php?op=seeder&trig=off&id=**id**#notify\">HÄR</a>.</p>");
define("_btnocommentsyet","Finns inga kommentarer än");
define("_btcommheader","Vid **time**, <a href=\"user.php?op=profile&id=**uid**\" target=\"_top\">**user**</a> skrev:");
define("_btdgavesresult","har gett ett resultat");
define("_btdnotifyemaildel","Du har blivit borttagen");
define("_btdnotifyemaildel1","Du fär inga mer mail när en kommentar ges!");
define("_btdnotifyemailadd1","Du fär ett mail när en kommentar ges, men du fär inga fler innan du tittat pä kommentaren!");
define("_btdnotifyemailadd","Du blivit tillagd i listan för kommentarmail");
define("_btdnotifyadd","Du har blivit tillagd i listan för seedermail");
define("_btdnotifyadd2","Du blir meddelad om nya seeders, max ett mail per dag,");
define("_btdnotifydel","Du är bortplockad ur listan; du fär inga fler mail.");
define("_btddetails","Torrentdetaljer");
define("_bteditthistorrent","Editera Torrent");
define("_btyes","ja");
define("_btno","nej");
define("_btadded","Uppladdad");
define("_btaddedby","Uppladdad av");
define("_bton","upp");
define("_bthelpothersource","Hjälp alternativ källa");
define("_btfilename","Filnamn");
define("_btpeers","Peers");
define("_btpeerstot","Totalt antal Peers");
define("_bthelppeer","Peerhjälp");
define("_btleecher","Leecher");
define("_btleechers","Leechers");
define("_btdhelpdownload","Nedladdningshjälp");
define("_btyourate","You Voted");
define("_btupdatesource","Uppdatera källor NU!");
define("_btseeder","Seed");
define("_btseeders","Seeds");
define("_btcompletion","Komplett");
define("_btdirectlink","Direktlänk");
define("_btcomplyouvoted","Du sa att Torrenten är: ");
define("_btcomplexplain","Torrenten kan bannas om den fär ett visst antal klagomäl.");
define("_btcomplaintform","Torrentklagomälsformulär.<BR>Systemet tilläter dig att flagga torrents som inte följer reglerna.<BR>
När ett visst antal klagomäl getts, kan torrenten bannas.<BR>Ge positiv feedback om torrenten är bra.<BR>");
define("_btcomplisay","Den här torrenten är ");
define("_btmagnetlink","Magnetlänk");
define("_btnomagnet","Ingen magnetlänk tillgänglig");
define("_btmagnetlinkdownload","Ladda ner torrent med magnetlänk");
define("_bted2klink","eD2K länk");
define("_btnoed2k","Ingen ed2K länk tillgänglig");
define("_bted2klinkdownload","Ladda ner filen med eD2K länk");
define("_btcomplatthemoment","Användare gav positiv feedback<b>**p**</b> tider och negativ feedback <b>**n**</b> gänger.<BR>");
define("_btnotifications","E-Mail Notifications");
define("_btreadcomms","Läs Kommentarer");
define("_btpostcomment","Posta En Kommentar");
define("_bttransfer","Överför");
define("_btdownloadspeed","Nerladdningsfart");
define("_btuploadspeed","Uppladdningsfart");
define("_bttorrentpassword","Lösenordsskydd");
define("_btpasswordquery","Den här torrenten är lösenordsskyddad. Ägaren till torrenten valde att endast ge tillätna användare tillgäng.<br />Uppge lösenord för tillgäng till torrenten.");
define("_btpasswordwrong","Varning: Fel Lösenord.<br />Kom ihäg att lösenorden är skiftläges-känsliga.");
define("_btuploadedpassexplain","Du satte lösenordet till: <b>**pass**</b>");
define("_btuploadedpassexplain2","För att ge användare tillgäng till torrenten, ge dem förljande direktlänk: <b>**url**<b>");
define("_btcompletedby","Klar av");
define("_bttrackers","Ytterligare Trackers");
define("_bttrackergroup","Grupp *");
define("_btexport","Exportera");
define("_btexportexplain","Ladda ner den här torrenten med din Passkey, för utdelning pä andra BitTorrent Index Services");

//TESTI PRESENTI IN TAKEUPLOADURL.PHP
define("_btinseriti","Inserted");
define("_btand","and");
define("_btnumerror","their Number is NOT equal and it is NOT Possible to Proceed with Binary Assignment");
define("_btmaxchar","ED2K URLs har 200 tecken Maximum");
define("_bted2kstart","URL ska börja med <b>ed2k://</b>");
define("_bt2par","URL Lacks the Second Parameter: ");
define("_bturlfile","fil");
define("_bturlcontent","URL innehäller inte");
define("_btfname","filnamn");
define("_bturlsize","URL innehäller inte");
define("_btsz","storlek");
define("_btidcode","hash info");
define("_bturlparerror","URL doesn't contain the Parameter:");
define("_bturlsureerror","URL innehäller illegal källa");
define("_bturlnotinsert","Mäste vara en ED2K Link");
define("_btnotip","IP inte specifierat");
define("_btinvip","Ogiltig IP");
define("_btnoport","Ingen Port Specifierad");
define("_btinvport","Ogiltig Port");
define("_btparmag","ingen");
define("_btnopresent","NOT Present");
define("_btmagchar","MagnetURLs har max 200 tecken");
define("_bftminlimit","Du kan inte dela ut filer mindre än");
define("_btfmaxlimit","Din torrent innehäller filer som är för stora.");
define("_btillegalword","Din torrent klarade sig inte igenom det automatiska filtret (if specified):.");
define("_btillegalwordinfo","If you feel that you're getting this message in error, please contact $admin_email");
define("_btnoreason","(Ingen orsak angiven");
define("_bturlinserted1","Torrent Uppladdad. Du förflyttas inom 3 sekunder.<BR>Om din webbläsare inte förflyttar dig, klicka pä ");
define("_bturlinserted2","den här länken");
define("_btaddnotifycomment","Du har blivit tillagd i listan: du fär mail om ny kommentar.");
define("_btaddnotifyseeder","Du har blivit tillagd i listan: du fär mail om nya seeders.");
define("_btnolinkinsert","No Link Inserted");
define("_btexnostartwt","eXeem-länkar startar med exeem://");
define("_btinvalidexeem","Ogiltig eXeem-länk!");
define("_btillegalcat","Ogiltig Kategori!");
define("_bttorrentpresent","Torrenten du försöker lägga upp finns redan pä trackern, eller har blivit bannad.");
define("_btdescrrequired","Beskrivningen är tom. Gä tillbaka och fyll i beskrivningen.");

//TESTI PRESENTI IN UPLOAD.PHP
define("_btuploadatorrent","Ladda upp en torrentfil");
define("_btphotoext","Bildfilen mäste vara GIF, JPG eller PNG");
define("_btalertmsg","Formuläret har inte skickats pä grund av följande fel:");
define("_btalertmsg2","Please Fixa till felen och ladda upp igen");
define("_btfnotselected","FEL: Fil ej vald");
define("_btalertdesc","Gör en beskrivning som visar Filtyp och Kvalite, speciellt om det gäller mediafiler");
define("_btalertcat","Välj Kategori");
define("_btconferma","Redo att ladda upp? Om din Torrent innehäller flera filer, skapa torrentenfilen genom att välja hela mappen. Annars kan den bli obrukbar.");
define("_btalerturl","Insert a MAGNET or ED2K Link");
define("_btalerturlnum1","ED2K-länknummer");
define("_btalerturlnum2","medans MAGNET-länknummer är");
define("_btalerturlnum3","Länkens nummer mäste var identiska-- Torrents bestär av flera länkar");
define("_btalert5char","Filnamn mäste vara minst 5 tecken");
define("_btofficialurl","Sidans officiella Announce URL: ");
define("_btseeded","Ladda bara upp torrents som seedas. Torrents utan seeders kommer ej synas pä sidan.");
define("_btupfile","Ladda upp fil:");
define("_btupnfo","Ladda upp NFO:");
define("_bttorrentname","Torrentnamn");
define("_btfromtorrent","Kommer genereras frän filnamn om det lämnas tomt. ");
define("_btdescname","Försök ge ett beskrivande namn");
define("_btsrc_url","Källans URL");
define("_btcompulsory"," (Obligatoriskt)");
define("_btdescription","Beskrivning (Krävs)");
define("_btdescriptionsemple","Beskrivning");
define("_btnohtml","INGEN HTML");
define("_btchooseone","Välj");
define("_bttype","Typ");
define("_btverduplicate","Gör kontroll för liknande torrents");
define("_btduplicatinfo","Förhindrar uppladdning av redan existerande torrents. Bocka ur för uppladdning ändä. Kom ihäg att dubbletter sänker effektiviteten.");
define("_btupevidence","Klistrad");
define("_btupevidencinfo","Sätt torrent som Klistrad sä den ligger fast i toppen pä listan. Endast för Moderatorer/Admins");
define("_btowner","Visningsnamn");
define("_btowner1","Visa Användare");
define("_btowner2","Privat");
define("_btowner3","Stealth");
define("_btownerinfo","'VISA ANVÄNDARE' Tilläter andra användare att se ditt användarnamn, 'PRIVAT' Döljer namnet, bibehäller Editering/Radering, 'STEALTH' (Om tillgängligt) Döljer helt ägaren av systemet, och tilläter ingen Editering/Radering av användaren.");
define("_btupnotify","Aviseringar");
define("_btupnotifynfo","Fä mail när en kommentar är lagd");
define("_btupnotifyseed","Fä mail när en leecher laddat ner klart (Only Torrents on Local Tracker)");
define("_btfsend","Skicka");
define("_btinserte2k","Insert ED2K Link");
define("_btmagnetinsert","Insert Magnet Link");
define("_btinsertlinktitle","Insert Links for GNutella and eDonkey2000 Networks");
define("_btinsertlinktext","Du kan lägga till eDonkey2000-länkar till din Torrent, för att öka tillgänglighet.");
define("_btinserttext2","Du kan endast lägga till MAGNET-länkar eller bara ED2K-länkar. If both Lists are filled with entries, two Links will be Associated to each file: in other words the first ED2K Link and the first MAGNET Link will be Associated to the first file, and so on...");
define("_bted2kurl","Insert ED2K Link");
define("_btsyntax","Like");
define("_btfiletype","extension");
define("_btfilesize","storlek");
define("_btipport","ip:port");
define("_btstatic","indicates that we're only using the eDonkey2000 Protocol");
define("_btfinalname","Är namnet pä filen du ska ladda ner");
define("_btfinalsize","är storleken pä filen du ska ladda ner");
define("_btfinalidcode","a Special Verification Code that Allows you to find ONLY ONE FILE, and its Copies, among many Similar");
define("_btfinalipport","represents the Main Stable Source (used by Releasers)");
define("_btor","or");
define("_btaddmagnet","Magnet Link");
define("_btadded2k","eD2K Link");
define("_btphoto","Bild");
define("_btexeemlink","eXeem Link");
define("_btexeemlinkexplain","Optional. If the Torrent can be downloaded through the eXeem Network, you can insert the Alternate Link HERE");
define("_bttorrentpasswordexplain","You may choose a Password to Protect your Torrent from Unauthorized View. If a Password is Set, Torrent will NOT
be Visible to Anyone Except Premium Users and Administrator in Torrent List and Torrent Search. You will have to provide a Direct Link to the people that you want to Access the Torrent.
Only Internal Torrents can be Password Protected.");
define("_btupadvopts","Advanced Options");
define("_btadvoptsexplain","Show Advanced Options, Controlling some Technical Aspects of the torrent. Use these Options ONLY if you know what you're doing!");
define("_btleaveintact","Editera inte inställningarna");
define("_btdhtsupport","DHT-Support");
define("_btendht","Force Backup DHT Tracking");
define("_btdisdht","Disable DHT Tracking");
define("_btdhtsupportexplain","This Forces DHT Backup Tracking on your Torrent, or Disables it. DHT is useful when the Main Tracker goes Offline or is Overloaded");
define("_btprivatetorrent","Privat Torrent");
define("_btenpvt","Sätt torrent som Privat");
define("_btdispvt","Sätt torrent som Publik");
define("_btprivatetorrentexplain","Det \"Privata\"-valet (som bara vissa klienter kan hantera), säger till klienten att bara kontakta Peers frän denna tracker. Aktivering av det Privta valet stänger av DHT");
define("_btnoperms","Du har ej tillätelse att ladda upp");

//UPLOAD-LINK
define("_btuploadalinkarchive","Lägg till eD2K/Magne-Länk");
define("_btsharelink","Ladda bara upp om filen kommer delas ut.");
define("_btlinknotice","Länken kommer inte godkännas om mer än hälften av filerna redan finns uppe. Dubbletter sänker effektiviteten");
define("_btarchivename","Namn");
define("_btinsert1file","Välj Länk(ar) för din fil, och klicka 'Lägg till fil'. eD2K Link is Obligatory. You can Add more than one File to your Submission.");
define("_btlinksnomatch","The Links you Entered do NOT Represent the same File");
define("_btinvalided2k","Ogiltig eD2K-länk");
define("_btinvalidmagnet","Ogiltig Magnet-länk");
define("_btaddnewfile","Lägg till fil");
define("_btaddtoarchive","Lägg till fil");
define("_btaddmd5","MD5 Hash");
define("_btlinks","Länkar");
define("_bterrduplicatelinks","Dubbletter ej tillätna");
define("_btduplicatelinks","Dubblett");
define("_btduplicateexplain","The File Represented by the Link you Submitted is Already being Shared on this Site. Click on the Warning Symbol next to the File to check out the Torrent/Collection in which it has been Found. If more that 50% of the Links you added are already present, your submission will NOT be Accepted");
define("_btinsertfilesfirst","You have to Submit at least One File using the Appropriate Button");
define("_btfilelistaltered","The File List has been Altered! It has NOT been created using this Tool.");

//INTERNAL TRACKER
define("_btuserhost","Användarnamn/host");
define("_btuserip","Användarnamn/IP");
define("_btport","Port");
define("_btdownloadedbts","Nerladdat");
define("_btuploadedbts","Uppladdat");
define("_btratio","Ratio");
define("_btpercent","Färdiga");
define("_btconnected","Ansluten");
define("_btidle","Inaktiv");
define("_btconn","Anslutning");
define("_btactive","Aktiv");
define("_btpassive","Passiv");
define("_btpeerspeed","Medelhastighet");
define("_btnopeer","Inga Peers");
define("_btIP","IP");

//Add Offer
define("_btoffer","Erbjudande");
define("_btofferdeleted","Ditt Erbjudande **name** raderades av ".$user->name);
define("_btoffersvote","Erbjudanderöstning");
define("_bt_nocheat","Fuska inte!!!");
define("_bt_Offer_voted","<h3>Du har redan röstat</h3><p>Du har redan röstat, endast 1 röst per medlem</p><p>Return To <a href=offers.php><b>Offers List</b></a></p>");
define("_bt_off_vote_th","Tack för din röst");
define("_bt_off_take_vote","<h3>Röstning godkänd</h3><Din röst har räknats</p><p>Back to <a href=offers.php><b>Offer List</b></a></p>");
define("_bt_off_canupload","Ditt erbjudande \"**torrent**\" har fätt 3 röster.\nDu kan nu lägga upp torrenten");
define("_bt_off_denied","Du har ej tillgäng till Erbjudanden än");
define("_bt_off_name","Skriv in ett namn pä ditt erbjudande");
define("_bt_off_making"," is making a offer for ");

//Scrape external torrents
if (!eregi("admin.php",$_SERVER["PHP_SELF"])){
define("_admtrackers","Externa Trackers");
define("_admtrackerurl","Announce URL");
define("_admtrkstatus","Status");
define("_admtrkstatusactive","Aktiv");
define("_admtrkstatusdead","Offline");
define("_admtrklastupdate","Uppdaterad");
define("_admtrkscraping","Uppdaterar");
define("_admtrkassociatedtorrents","Torrents");
define("_admtrkcannotopen","Kan ej kontakta URL-adressen. Tracker sätts som Offline");
define("_admtrkrawdata","Tracker nädd. Here is the Encoded Response");
define("_admtrkinvalidbencode","Cannot Decode Tracker Response. Invalid Encoding");
define("_admtrkdata","Decoding Completed. Here is all the Scrape Data obtained");
define("_admtrksummarystr","Found <b>**seed**</b> Seeders, <b>**leechers**</b> Leechers, <b>**completed**</b> Completed Downloads for Torrent **name** Info Hash **hash**.");
}

//TESTI CHE COMPAIONO IN COMMENT.PHP
define("_btiderror","Ogiltigt ID");
define("_btnotfoundid","Torrent existerar ej");
define("_btaddcomment","Lägg till kommentar");
define("_btaddtime","Uppladdad ");
define("_btby","av");
define("_btsend","Sänd");
define("_btnotyourcomment","Du kan editera andras kommentarer.");
define("_btcommentinserted","Din kommentar har lagts till. Du förflyttas till Torrentdetaljer inom 3 sekunder.<br>Klicka <a href=\"details.php?id=**id**#comments\">HÄR</a> om din webbläsare inte förflyttar dig.");
define("_btcommentdeleted","Kommentar raderad. Du förflyttas till Torrentdetaljer inom 3 sekunder.<br>Klicka <a href=\"details.php?id=**id**#comments\">HÄR</a> om din webbläsre inte förflyttar dig.");

//TESTI CHE COMPAIONO IN DOWNLOAD.PHP
define("_bttorrentunavailable","Torrentfil ej tillgänglig pä grund av serverfel. Ursäkta besväret.");
define("_btminseedrule","Du mäste seeda minst **min** Torrents för att ladda ner.");
define("_btmaxdailydownloads","Du kan inte ladda ner mer än **max** filer per dag. Försök igen imorgon.");
define("_btmaxweeklydownloads","Du kan inte ladda ner mer än **max** filer per vecka. Försök igen nästa vecka.");
define("_bterrtoosmall","<li>Du mäste seeda en fil i en storlek av minst <b>**min_share**</b> osv.<br>");
define("_bterrtoobig","<b>Den största fil du seedar är ");
define("_bterrorprivate","Detta är en privat fil: du har redan bett om nerladdningstillätelse. Du kan ej ladda ner innan ägaren gett dig tillätelse.");
define("_btrefused","Ägaren nekade dig. Dan ej ladda ner denna torrent.");
define("_bterrblacklist","Ägaren nekar dig tillätelse att ladda ner hans/hennes torrents. Du kan ej ladda ner nän av dem.");
define("_btreqsent","Den här torrenten är privat. Du kan ej ladda ner innan ägaren gett dig tillständ.
En förfrägan har skickats till ägaren, som sen tar ställning till din förfrägan: du mailas om svaret.");

//TESTI CHE COMPAIONO IN EDIT.PHP
define("_btedittorrent","Editera Torrent");
define("_bterreditnoowner","<h1>Tillgäng Nekad</h1>\n<p>Bara ägaren och admins kan editera torrenten</p>\n");
define("_btbanned","Bannad");
define("_btcancel","Avbryt");
define("_btdelcommand","Editera ej torrenten, MEN <input type=\"submit\" value=\"RADERA DEN!\" />\n");
define("_btsure","Ja: Jag är säker!");
define("_btban","Banna Torrenten");
define("_btareyousure","Är du säker pä att du vill radera <b>**name**</b>?");
define("_btareyousure_ban","Är du säker pä att du vill banna <b>**name**</b>?");
define("_bttorrentnoexist","Torrenten existerar ej");
define("_btdelete","Radera Torrent");
define("_btcannotdel","Kan ej radera");
define("_btmissingdata","Nödvändig Data Saknas!");
define("_btdeldenied","Bara ägaren och admins kan radera torrenten");
define("_btnotconfirmed","Du mäste bekräfta din handling.");
define("_btdeleted","Torrent Raderad");
define("_btsuccessfullyedited","Lyckad Torrenteditering. Du förflyttas till torrentdetaljer. Om du har valt Stealth, kan du inte längre editera eller radera torrenten!");

//TESTI CHE COMPAIONO IN MYTORRENTS.PHP
define("_btmytorrentsintrotitle","Kontrollpanel för Torrents");
define("_btmytorrentsintrotext","Här kan du hantera dina uppladdade torrents (utom dem med Stealth).<br>
Du kan ocksä hantera andra användare' Ladda ner Requester. Genom att välja korrekt Ikon, du kan se alla requester som sänts till dig frän andra användare. Du mäste välja om du vill acceptera eller ej.<br>
Häll koll pä användares Nerladdning och Uppladdning. Medlemmar som inte delar med sig är ej till godo för trackern. Att vägra dem nerladdningsrättigheter kan fä dem att vilja dela med sig.");
define("_btmytorrents","Mina Torrents");
define("_btallauthorized","Alla användare har godkänts");
define("_btauths","Ladda ner Requester");
define("_btauthorized","Vald användare har godkänts");
define("_bthasauthorized","Ägaren har godkänt dig att ladda ner");
define("_btnowcandownload","Du kan nu ladda ner användarens alla torrents.\nWe Skydda din intrigitet.");
define("_pendingauths","Väntade av godkännande: ");
define("_btauthorizationrequested","Följande användare har begärt tillätelse:");
define("_btnotorrents","Det finns inga torrents");
define("_btnotorrentuploaded","Du har inte laddat upp nägra torrents än");
define("_btactions","Handlingar");
define("_bthasuploaded","Uppladdat: **");
define("_bthasdownloaded","Nerladdat: **");
define("_btauthgrant","Godkänn");
define("_btauthalwaysgrant","Alltid godkänna");
define("_btauthalwaysdeny","Aldrig godkänna");
define("_btauthdeny","Godkänn inte");
define("_btcantseeothertorrents","Du kan inte se andra användares torrentbefogenheter!");
define("_btauthpanel","Kontrollpanel för nerladdningsbefogenheter");
define("_btnoauthstomanage","Inga tillätelser att se över");
define("_btmyglobals","Mina globala befogenheter");
define("_btnoglobals","Det finns inga globala befogenheter än");
define("_btstatus","Status");
define("_btauthreset","Återställ");
define("_btwronginput","Fel");
define("_btgeneraloptions","Övergripande meny");
define("_btprivate","Privat");
define("_btprivateexpl","Välj detta val för kräva att användare frägar om nerladdningstillätelser. Du mailas om väntade förfrägningar.
Du kan välja att tilläta eller neka tillätelse för en eller alla torrents");
define("_btminratio","Minimum Ratio");
define("_btdisabled","Inaktiverad");
define("_btminratioexpl","Du kan sätta ett Minimum Ratiovärde för att Auto-tilläta användare. Användare med Ratio över eller lika med minimum kan ladda ner utan tillätelse.
Värdet av Minimum Ration visas ej, utom för Admins");

//TESTI CHE COMPAIONO IN TAKECOMMENT.PHP
define("_btcommentkeyfound","Systemet har kontrollerat din kommentar. Följande ord är ej tillätna:<ol>");
define("_btcommentkeyfound2","</ol><p>We know that the Comment could still be OK, we apologize for the inconvenience and ask you to use different wording.</p>");

//TESTI CHE COMPAIONO IN TAKEEDIT.PHP
define("_btmissingformdata","Saknar ingängsdata!");
define("_bteditfailed","Editering Misslyckades");
define("_bteditdenied","Du kan ej editera andras torrents.");
define("_btreturl","Lyckad editering, du förflyttas till torrentdetaljer inom 3 sekunder..<br>Klicka <a href=\"**returl**\">HÄR</a> om din webbläsare inte förflyttar dig");

//TESTI CHE COMPAIONO IN RATE.PHP
define("_btrate","Torrentbetyg");
define("_btratefailed","Röstning misslyckades!");
define("_btinvalidrating","Ogiltig röstning");
define("_btidnotorrent","Ogiltigt ID. Torrent existerar ej");
define("_btnovoteowntorrent","Du kan inte betygsätta dina egna torrents");
define("_btalreadyrated","Torrent redan betygsatt");
define("_btcantvotetwice","Du kan inte rösta 2 gänger pä samma torrent");
define("_btvotedone","Lyckad röstning, du förflyttas till torrentdetaljer inom 3 sekunder.<br>Klicka <a href=\"details.php?id=**id**\">HÄR</a> om din webbläsare inte förflyttar dig.");

//TESTI CHE COMPAIONO IN TAKEUPLOAD.PHP
define("_btuploaderror","Uppladdning misslyckades!");
define("_btemptyfname","Tomt filnamn");
define("_btinvalidfname","Ogiltigt Filnamn");
define("_btinvalidnfofname","Ogiltigt NFO-filnamn");
define("_btfnamenonfo","Detta är ingen NFO-Fil (.nfo)");
define("_btfnamenotorrent","Detta är ingen torrentfil (.torrent)");
define("_btferror","Filfel");
define("_bterrnofileupload","Fel pä uppladdad fil.");
define("_bterrnonfoupload","Fel pä uppladdad NFO.");
define("_btemptyfile","Fil tom");
define("_btnobenc","Fil skadad. Är du säker pä att det är en torrentfil?");
define("_btnodictionary","Torrent Dictionary finns ej");
define("_btdictionarymisskey","Saknar Torrent Dictionary Keys");
define("_btdictionaryinventry","Ogiltig Data inuti Torrent Dictionary");
define("_btdictionaryinvetype","Ogiltiga Datatyper i Torrent Dictionary");
define("_btinvannounce","Ogiltig Announce URL. Mäste vara ");
define("_btactualannounce","Specifierad Tracker ");
define("_bttrackerdisabled","Vär tracker har inaktiverats: Endast externa torrents kan laddas upp.");
define("_btinvpieces","Ogiltiga Torrentdelar");
define("_btmissinglength","Saknas Filer och Storlek");
define("_btnofilesintorrent","Saknas Torrentfiler");
define("_btfnamerror","Ogiltigt Filnamn");
define("_btinvalidhtml","Ogiltig HTML-kod. Se till att du använt vär editor och inte skrivit in nät manuellt.");
define("_bttrackerblacklisted","Trackern som används av den här torrenten (<b>**trk**</b>) har blivit svartlistad. Använd en annan tracker.");
define("_btfilenamerror","Fel i filnamn");
define("_bttorrenttoosmall","<p>Du kan inte dela ut en fil som är mindre än <b>");
define("_bttorrenttoosmall2","</b></p><p>Din torrent innehäller en fil i följande storlek: <b>");
define("_btmaxuploadexceeded","Du kan ej ladda upp mer än **maxupload** inom en period av 24h.");
define("_btnumfileexceeded","<p>Du kan inte ladda upp mer än <b>**maxupload**</b> Filer inom en period av 24h.</p><p>Du har redan laddat upp <b>**rownum**</b> Filer pä totalt <b>**totsize**</b>");
define("_btsearchdupl","Enligt sökningen kan dessa filer vara samma som du delar ut:<ol>");
define("_btduplinfo","<p>Om din fil är en av dessa i listan, seeda en av dem!</p>");
define("_btsocktout","FEL: Socket Timed-Out");
define("_bttrackernotresponding","Trackern svarar ej.\n Kontrollera Trackerstavning (INGA TOMMA MELLANRUM I URLs) och att trackern är aktiv och igäng. Trackern du angav:");
define("_bttrackerdata","Ogiltig Data frän Extern Tracker. Trackern kan ha serverproblem. Försök igen senare.");
define("_bttorrentnotregistered","Torrenten verkar ej vara reggas som extern. Du kan bara ladda upp externa torrents om de är aktiva.");
define("_btuploadcomplete","Lyckad Uppladdning. Du förflyttas till torrentdetaljer inom 3 sekunder. Glöm ej att seeda, annars syns ej torrenten pä bläddra.<br>Klicka <a href=\"**url**\">HÄR</a> om inte webbläsaren förflyttar dig.");
define("_btpresent","Torrenten finns redan uppladdad");
define("_btscrapeerror","Fär ingen PeerData frän Trackern");

//TESTI CHE COMPAIONO IN TAKECOMPLAINT.PHP
define("_btcomplisnowbanned","Torrenten har bannats pä grund av flera klagomäl");
define("_btcomplcantvotetwice","Du kan ej skicka ett klagomäl tvä gänger.");
define("_btcomplainttaken","Klagomäl mottaget. Du förflyttas till torrentdetaljer inom 3 sekunder. Om din webbläsare inte förflyttar dig, klicka ");
define("_btcomplsuccess","Ditt klagomäl har mottagits. Användarnamn och IP är loggat: Missbruka inte systemet.<BR>");

//SHOUTBOX
define("_btshoutbox","Tjatbox <a href=\"javascript:popshout('shoutdetach.php');\">(Lösgör)</a> &bull; <a href=\"shoutboxarchive.php\">(Arkiv)</a>");
define("_btnoshouts","Ingen som tjatar...");
define("_btshoutnow","Tjata!");
define("_btprivates","[PM]");
define("_btshoutnowprivate","Privat Shout!");
define("_btshoutboxshow","TjatBox");
define("_btshactive","Aktiva Användare");
define("_btmoresmiles","Mer Smiles");
define("_btshouthelp","Vad är Mode Normal/Mode Expert<ul><li>Mode Normal:<ul><li>Om Normal mode är pä kommer du fä BBcode hjälp frän systemet.</ul><li>Mode Expert:<ul><li>Om Expert mode är pä kommer inte systemet hjälpa dig utan kommer bara sätta in taggar BBcodes.</ul></ul>Vad gör <img src=\"./teman/".$theme."/pics/drop.gif\" alt=\"\"> do<ul><li>Klicka 2 gänger för att radera tjat.<br />(admins och moderatorer kan radera ditt tjat ocksä)</ul>What does the <img src=\"./themes/".$theme."/pics/edit.gif\" alt=\"\"> do?<ul><li>Klicka 2 gänger för att editera ditt tjat.<br />(admins och moderatorer kan editera ditt tjat ocksä)</ul>");



//IMAGE ALTERNATES
define("_btalt_banned","Bannad Torrent");
define("_btalt_auth_none","Inga väntande tillätelser ");
define("_btalt_auth_pending","Väntande tillätelser!");
define("_btalt_sticky","Klistrad Torrent");
define("_btalt_download","Ladda Ner");
define("_btalt_edit","Editera");
define("_btalt_drop","Radera");
define("_btalt_viewed","Granska");
define("_btalt_scrape","Uppdatera Peer Data");
define("_btalt_noscrape","Stats uppdaterade för mindre än 30 minuter sen");
define("_btalt_logintoscrape","Logga in för att kontrollera Peer Data");
define("_btalt_duplicate","Dubblett");
define("_btalt_exeem","Ladda ner med eXeem");
define("_btalt_error.gif","Fel");
define("_btalt_icon_admin","Administrator");
define("_btalt_icon_moderator","Moderator");
define("_btalt_icon_premium.gif","Premium User");
define("_btalt_1.gif","Riktigt dälig");
define("_btalt_1.5.gif","Mycket dälig");
define("_btalt_2.gif","Dälig");
define("_btalt_2.5.gif","Sädär");
define("_btalt_3.gif","Godkänd");
define("_btalt_3.5.gif","Bättre än godkänd");
define("_btalt_4.gif","Bra");
define("_btalt_4.5.gif","Mycket bra");
define("_btalt_5.gif","Utmärkt");
define("_btalt_anon_tracker.gif","Tracker Anonymous");
define("_btalt_button_aim.gif","AOL Instant Messenger");
define("_btalt_button_icq.gif","ICQ");
define("_btalt_button_irc.gif","IRC");
define("_btalt_button_msn.gif","MSN Messenger");
define("_btalt_button_yahoo.gif","Yahoo! Messenger");
define("_btalt_ed2k_active.gif","Download using eD2K URI");
define("_btalt_ed2k_inactive.gif","eD2K Link Unavailable");
define("_btalt_magnet","Download using Magnet URI");
define("_btalt_magnet_inactive.gif","Alternate Link Unavailable");
define("_btalt_green.gif","Snabb");
define("_btalt_yellow.gif","Slö");
define("_btalt_red.gif","Stopp");
define("_btalt_quest.gif","Peerdata okänd");
define("_btalt_lock","Väntande tillätelse");
define("_btalt_lock_request","Be om tillätelse");
define("_btalt_noavatar.gif","Ingen Avatar");
define("_btalt_icon_active.gif","Aktiv");
define("_btalt_icon_passive.gif","Passiv");
define("_btalt_external","Extern Tracker");

define("_btunknownclient","Okänd Klient");
define("_btalt_avatar","Avatar för **user**");


//PRIVATE MESSAGES
define("_btyougotpm","Du har ett nytt PM/Olästa PM!");
define("_btpmintro","Här kan du läsa privata PM frän andra användare. Det finns ingen gräns för sparade PM.
Men vi föreslär att du raderar dina Pm med jämna mellanrum. Du kan skicka PM till alla reggade medlemmar.");
define("_btinbox","Inkorg");
define("_btpmnomessages","Inga PM");
define("_btpmsub","Ämne");
define("_btpmfrom","Frän");
define("_btpmdate","Datum");
define("_btplmselect","Välj");
define("_btpmread","Läs");
define("_btpmunread","Oläst");
define("_btimgdelete","Radera Bild");
define("_btpmnewmsg","Nytt PM");
define("_btpmdelete","Radera PM");
define("_btpmdelall","Radera ALLA PM");
define("_btpmdelconfirm","Är du säker pä att du vill radera valda PM?");
define("_btpmdelbtn","Radera PM");
define("_btpmdelallconfirm","Är du säker pä att du vill radera <b>ALLA</b> dina PM?");
define("_btpmdeletedsuccessfully","PM valt korrekt");
define("_btnewpm","Nytt PM");
define("_btpmto","Mottagare");
define("_btpmtotip","Om du vill skicka samma PM till flera användare, separera dem med semikolon (;)");
define("_btpmshowbookmarks","Visa/Dölj Kontaktlista");
define("_btpmtext","Meddelandetext");
define("_btpmnorecipient","Du mäste ange mottagare");
define("_btpmnosubject","Du mäste ange ämne");
define("_btpmnomessage","Tomt meddelande");
define("_btpminvalidrecipients","En eller flera av mottagarna du angav finns ej");
define("_btpmsentsuccessfully","PM skickat korrekt");
define("_btpmuserblocked","En av mottagarna accepterar ej PM frän dig. Du skrev:<br><br>");
define("_btmessage","Meddelande");
define("_btinvalidpm","Ogiltigt Meddelande");
define("_btpmnoexists","Meddelande existerar ej");
define("_btpmreply","Svara");
define("_btuserlists","Vänner och ignorerade användare");
define("_btuserlistsintro","Här kan du hantera vänner och ignorerade användare. Vännerna finns i din kontaktlista för snabb hantering vid sändande av PM.
PM frän ignorerade blockas. Du kan ändra en användares status i  hans/hennes Profil. Användare vet inte andras status.");
define("_btpmbookmarkuser","Lägg till som vän");
define("_btpmunbookmarkuser","Ta bort som vän");
define("_btpmblacklistuser","Vägra PM frän den här användaren");
define("_btpmunblacklistuser","Vägra inte PM frän den här användaren");
define("_btpmbookmarks","Vänner");
define("_btpmblacklist","Ignorerade");

//OVERLIB HELP
#NO LINE-BREAKS!!!!
define("_btperformance","Prestanda");
define("_btdht","DHT Support");
define("_bttorrentspd","Total Hastighet:");
define("_btleechspd","Förväntad Hastighet: ");
define("_btedt","Förväntad Nerladdningshastighet: ");
define("_btinfohashhelp","Info Hash är en kort, unik kod som identifierar en Torrent.<br>");
define("_btdhtexplanation","Den här torrenten använder DHT. Med en ny klient kan du ladda ner denna torrent även om trackern är nere.");
define("_btavatarnotice","Uppladdade Avatarer mäste vara GIF, JPEG eller PNG format, föreslagen storlek 100x100 och inte större än 300KB");
define("_btcustomsearch","RSS/RDF Feed for Custom Search");
define("_btcustomsearchexplain","Subscribe to this RSS/RDF Feed to stay Updated on Uploads that match your Search Terms");

// Rules
define("_btrules","Regler");
define("_brrulesadmin","Adminregler");
define("_btrulesmod","Moderatorregler");
define("_btrulesprem","Premiumregler");
define("_btrulesuser","Userregler");
define("_btrulesgen","Allmänna Regler");
define("_btrulesadd","Lägg till ny regelsektion");
define("_btrulesaddsect","Lägg till regelsektion");
define("_btnamelevel","Användarnivä för denna regel");
define("_bttitle","Sektionstitel");
define("_btlevel","Nivä");
define("_btrulesedit","Editera Regler");
define("_btmodrulesadd","Lägg till regelsektion");
define("_btmodrulesno","Nej");
define("_btmodrulesyes","Ja");
define("_btmodrulespublic","Publik");
//massmail
define("_btmmbody","Body");
define("_btmmsendto","Skicka mass-email till nivä av användare");
define("_btmmlinks","Du kan använda denna länk i email");
//BBcode
define("_bb_tag_prompt","Skriv en text:");
define("_bb_img_prompt","Lägg in länk till bild");
define("_bb_font_formatter_prompt","Lägg till en text - ");
define("_bb_link_text_prompt","Lägg till ett länknamn (Optional):");
define("_bb_link_url_prompt","Lägg till en fullständig adress till vänster om:");
define("_bb_link_email_prompt","Lägg till en fullständig länk:");
define("_bb_list_type_prompt","Vilken typ av lista vill du ha? Ange ' 1 ' för en Numerisk Lista, 'a' för en Alfabetisk Lista, eller inget alls för en simpel Point List.");
define("_bb_list_item_prompt","Enter one point of list. Press OK to enter another point of list or press 'Cancel' to Finish.");
define('_btmfreetorrentexplain','<img src="themes/'.$theme.'/pics/magic.gif" alt="GRATIS TORRENT" title="GRATIS TORRENT" border="0">Torrents med den här symbolen är Ratio Boosters. Endast din upload räknas!!<br> Det här är ett perfekt sätt att boosta din Ratio. Vanliga seedregler gäller även dessa.<br>Seeda till 1:1 eller 24h för att undvika Hit and Runs.');
define('_btmnuketorrentexplain','<img src="themes/'.$theme.'/pics/nuked.gif" alt="NUKED TORRENT" title="NUKED TORRENT" border="0">Torrents med den här symbolen är Nuked. <br>Det betyder att nägot är fel med Releasen,<br>och att den kanske inte kan användas. Ladda ner pä egen risk.<br>Normala seedregler gäller pä dessa torrents. Läs i torrentdetaljer gällande anledning till NUKED');
define('_btactiontime','Tid');
define('_btactionmark','Märk');
//BitBucket
define("_btuploadexpl","Välj filen du vill lägga till din torrent och till BitBucket.<br />Du kommer inte behöva ladda upp denna bild i framtiden.<br />Giltig filändelse: bmp gif jpe jpeg jpg png.");
define("_btgalexpl","Här är alla bilder du har i Galleriet<br />Du kan lägga till en bild genom att klicka pä namnet eller titta pä hela bilden genom att klicka pä Thumb.<br>Du kan ocksä använda den nägon annanstans med [img]".$siteurl."/UserFiles/$user->name/image[/img]");
define("_btvaliext","Giltig filändelse: bmp gif jpe jpeg jpg png");
define("_btattach","Fäst filer");
define("_btmantitle","Klicka här för att lägga till en bild frän dina uppladdade bilder");
define("_btmanimage","Hantera bilder");
define("_brupwait","Laddar upp Fil(er) - Var god vänta");
define("_btuploading","Laddar upp");
define("_btselecatt","Välj en fil att fästa");
define("_btgalery","Bildgalleri");
define("_btbuclosed","Vi tilläter inte Bit-Bucket uppladdningar just nu","Bit-Bucket stängd");
define("_btgaltyp","Du fär bara ladda upp filer med ändelsen bmp gif jpe jpeg jpg png");
define("_btgalwful","BitBucket är full");
define("_btgalful","Din BitBucket är full!<br />Radera nägra av dina bilder och försök igen.");
define("_btgalitobig","Fil för stor");
define("_btgalwitobig","Filstorlek är för stor!");

#offers
#arcade
define("_btarc","SPELHÖRNA");
define("_btarcadeclosed","SPELHÖRNAN är stängd.");
define("_btarc_play_Asteroids","Spela Asteroids");
define("_btarc_play_Breakout","Spela Breakout");
define("_btarc_play_Hexxagon","Spela Hexxagon");
define("_btarc_play_Interactive","Spela Interactive Buddy");
define("_btarc_play_Invaders","Spela Space Invaders");
define("_btarc_play_Moonlander","Spela Moonlander");
define("_btarc_play_Pac_Man","Spela Pac-Man");
define("_btarc_play_Solitaire","Spela Solitaire");
define("_btarc_play_Simon","Spela Simon");
define("_btarc_play_Snake","Spela Snake");
define("_btarc_play_Free_kick","Spela James Original Free-kick Challenge");
define("_btarc_play_Starcraft","Spela Starcraft Flash Action 3");
define("_btarc_play_Tetris","Spela Tetris");
define("_btarc_tittle",$sitename." Flash Arcade");
define("_btarc_high","Titta pä Highscores");
define("_btarc_stats","Titta pä Highscorestatistik");
#blackjack
define("_btblj_tittle","BlackJack");
define("_btblj_start_game","Starta Spel");
define("_btblj_rule","<h3>Regler</h3><p style=\"color:#000033\">Kom sä närma 21 poäng du kan...<br/>har du mer än 21 förlorar du<bd/><br/>Du kan vinna eller förlora 100MB</p>");
define("_btblj_stand","Pass");
define("_btblj_wratio","Ledsen **user**, din ratio är under **userratio**");
define("_btblj_banned","Du är bannad frän Kasinot.");
define("_btblj_play_tover","Din spelstund är över **maxtry** ,du mäste vänta 5h.");
define("_btblj_max_download_passed","Du har nätt max antal nerladdningar för en användare.");
define("_btblj_max_profit","men den maximala förtjänsten är högre ");
define("_btblj_wait_next_player","Du mäste vänta pä en annan spelare");
define("_btblj_open_game","Du mäste göra klart ditt öppnade spel. <form method=post name=form action=".$_SERVER['PHP_SELF']."><input type=hidden name=game value=cont><input type=submit value='Continue old game'></form>");
define("_btblj_anothercard","Ge mig ett kort");
define("_btblj_you_win","Du vann **won** av **opon** (Du hade **youpoint** poäng, **opon** hade **oppoint** poäng). <a href=blackjack.php>Spela Igen</a>");
define("_btblj_points","Poäng");
define("_btblj_you_won_points","Du vann ");
define("_btblj_you_lost","Du förlorade ");
define("_btblj_who_won","Du har **ypoint** poäng, din motständare var **opon**, han/hon hade **tpoint** poäng, **won** <a href=blackjack.php>Spela Igen</a> ");
define("_btblj_you_lost_points","Du förlorade **lost** till **opon** (Du hade **youpoint** poäng, **opon** hade 21 poäng) <a href=blackjack.php>Spela Igen</a>");
define("_btblj_you_lost_points2","Du förlorade **lost** till **opon** (Du hade **youpoint** poäng, **opon** hade **oppoint** poäng) <a href=blackjack.php>Spela Igen</a>");
define("_btblj_no_winner","Ingen Vann");
define("_btblj_no_winner2","Din motständare var **opon**, ingen vann <a href=blackjack.php>Spela Igen</a>");
define("_btblj_points_wait","Du har **points** poäng, det finns inga andra spelare, sä du fär vänta pä en annan spelare. Du fär ett PM om resultatet");
define("_btblj_over","Game over");
#Casino
define("_btco_","Kasino");
define("_btco_maxwin","Maxvinst är högre ");
define("_btco_upload_low","Ledsen **username** du har inte laddat upp **upload**");
define("_btco_win","VINNARE!!!");
define("_btco_win_exp","Ja **wincolor** är resultatet **user** du fick det och vann **vinst**");
define("_btco_loose","FÖRLORARE!!!");
define("_btco_loose_exp","Ledsen **facwincolor** är vinnare och inte **wincolor**, **user** du **loose**");
#casino_player_edit.php
define("_btcs_edit_noplr","Ingen med användarID **id**\n");
define("_btcs_edit_stupdt","Statistik för användare **id** är nu uppdaterade");
define("_btcs_edit_bktl","Tillbaka till spelarlistan");
define("_btcs_edit_pledok","Spelare editerad");
define("_btcs_edit_bktc","Tillbaka till Kasinot");
define("_btcs_edit_yaediting","Du editerar nu en användare");
define("_btcs_edit_lost","Förlorade");
define("_btcs_edit_pls","Spelar");
define("_btcs_edit_alow","Tillät spelare att använda Kasino");
define("_btcs_edit_laac","Senaste tillträde");
define("_btcs_edit_wing","Vinster");
#confirminvite.php
define("_btreadrules","Jag har läst <a href=/rules.php/ target=_blank font color=red>rules</a> page.");
define("_btreadfaqs","jag gär med pä att läsa <a href=/faq.php/ target=_blank font color=red>FAQ</a> innan jag ställer frägor.");
define("_btofage","Jag är minst 13 är gammal.");
define("_btcookies","Notis: Du mäste ha cookies aktiverat för att regga dig eller logga in.");
define("_btconinvite","Bekräfta Inbjudning");
define("_btdupip","Dubblett av Ip");
define("_bterridnotset","Id är inte satt, kolla länk");
define("_btusercount","Användargränsen (**count**) är nädd. Inaktiva konton tas bort hela tiden, försök igen senare...");
#requist

#bbcode
define("_btbb_header","<p>Formulären stödjer ett antal <i>BB tags</i> som du kan modifiera dina postningar med.</p>");
define("_btadd_code","testa här");
#faqaction.php
define("_bt_faqmang","FAQ Hantering");
define("_bt_faq_additem","Lägg till sak");
define("_bt_faq_update","Uppdaterad");
define("_bt_faq_normal","Normal");
define("_bt_faq_hidden","Gömd");
define("_bt_faq_answer","Svar:");
define("_bt_faq_status","Status:");
define("_bt_faq_catergory","Kategori:");
define("_bt_faq_new","Ny");
define("_bt_faq_id","ID:");
define("_bt_faq_title","Titel:");
define("_bt_faq_confer_req","Bekräftelse krävs");
define("_bt_faq_confer_ok","Klicka <a href=\"faqactions.php?action=delete&amp;id=**id**&amp;confirm=yes\">HÄR</a> för att bekräfta.");
define("_bt_faq_add_section","Lägg till sektion");
#flash.php
define("_bt_flash_closed","Spelhörnan är avstängd.");
define("_bt_flash_game_ast","Asteroids");
define("_bt_flash_game_bre","Breakout");
define("_bt_flash_game_hex","Hexxagon");
define("_bt_flash_game_inv","Invaders");
define("_bt_flash_game_moo","Moonlander");
define("_bt_flash_game_pac","Pacman");
define("_bt_flash_game_sol","Solitaire");
define("_bt_flash_game_sim","Simon");
define("_bt_flash_game_sna","Snake");
define("_bt_flash_game_tet","Tetris");
define("_bt_flash_rank","Ranking");
define("_bt_flash_level","Nivä");
define("_bt_flash_name","Namn");
define("_bt_flash_not_saveable","Kan ej spara highscore för spelet!");
define("_bt_flash_set_rez","Välj upplösning:");
define("_btcasino_ban","Ledsen ".$user->name."du är bannad frän kasinot.");
#flashscore.php
#youtube
define("_btvid_clip","Videoklipp");
define("_btvid_choose","Välj en video till höger.");
define("_btvid_fun","Ha det kul");
define("_btvid_list","Lista");
define("_btvid_info","Klippinfo");
define("_btvid_url","För URL: ");
define("_btvid_link","bara lägg in: qppuuQrklHg i länken");
define("_btvid_add","Klistra endast in tecknen efter =");
define("_btvid_id","ID");
define("_btvid_name","Namn");
define("_btvid_link1","Länk");
define("_btvid_addedby","Tillagd av");
define("_btvid_added","Tillagd");
define("_btvid_delete","Radera");
define("_btvid_remove","Ta Bort");
#Votes
define("_btvote_votes","Röster");
define("_btvote_vote"," RÖSTER :");
define("_btvote_for","RÖSTA PÅ DENNA");
define("_btvote_request","REQUEST");
define("_btvote_notfound","Inget funnet");
#Lottery
define("_btlottery_sold","Sälda biljetter");
define("_btlottery_purchased","Köpta lotteribiljetter");
define("_btlottery_disabled","Lotteriet är avstängt.");
define("_btlottery_end","Lotteriet avslutas:");
define("_btlottery_tickets"," Antal biljetter ");
define("_btlottery_uploaded","Du mäste ha laddat upp minst ");
define("_btlottery_buy"," för att kunna köpa en biljett!");
define("_btlottery_page"," Biljettsidan");
define("_btlottery_purchase"," Köp lotter");
define("_btlottery_nonrefund"," Köpt lott kan ej äterlämnas.");
define("_btlottery_cost"," Varje lott kostar");
define("_btlottery_taken","  vilket tas frän din upload.");
define("_btlottery_purchaseable"," det visas hur mänga lotter du kan köpa.");
define("_btlottery_amount"," Du kan bara köpa sä mänga lotter som visas.");
define("_btlottery_compend"," Tävlingen slutar: ");
define("_btlottery_willbe"," Det kommer finnas ");
define("_btlottery_winners","  vinnare som väljs pä mäfä");
define("_btlottery_eachwinner"," Varje vinnare kommer fä ");
define("_btlottery_added","  till sin upload.");
define("_btlottery_announced"," Vinnarna kommer utropas när lotteriet är slut och omnämnas pä startsidan.");
define("_btlottery_pot"," Ju fler lotter som säljs desto större pott!");
define("_btlottery_own"," Sä mänga lotter har du: ");
define("_btlottery_goodluck","Lycka Till!");
define("_btlottery_purchase1","Köp");
define("_btlottery_totalpot","Total Pott");
define("_btlottery_totalpurchased","Totalt antal sälda lotter");
define("_btlottery_owned","Lotter du köpt");
define("_btlottery_allowed","Kan köpas");
define("_btlottery_allowed_tickets", " Lotter");
define("_btlottery_closed"," Lotteriet är stängt!");
define("_btlottery_sorry"," Ledsen, jag kan ej sälja dig nägra lotter!");
define("_btlottery_error"," FEL");
define("_btlottery_max"," Max antal lotter du kan köpa ");
define("_btlottery_noupload"," Du har inte tillräckligt med upload för att köpa en lott");
define("_btlottery_lottery","Lotteri");
define("_btlottery_just_purchased","Du har precis köpt ");
define("_btlottery_newtotal","Ditt nya antal är ");
define("_btlottery_newupload","Din nya uploadstatus är ");
define("_btlottery_goback","Gä Tillbaka");
define("_btlottery_ticket"," Lott");
#request
define("_btrequestvote","Rösta");
define("_btrequestvoted","<br><p>Du har redan röstat pä den här Requesten, endast 1 röst per request</p><p>Tillbaka till <a href=viewrequests.php><b>Requests</b></a></p><br><br>");
define("_btrequestvotetaken","<br><p>Lyckad röstning pä Request **requestid**</p><p>Tillbaka till <a href=viewrequests.php><b>Requests</b></a></p><br><br>");
define("_btrequest","Requester");
define("_btrequest_add","Lägg Till Request");
define("_btrequest_view","Titta pä mina Requester");
define("_btrequest_votes","Röster");
define("_btrequest_sort","SORTERA ");
define("_btrequest_added","Datum Tillagd");
define("_btrequest_name","Requestnamn");
define("_btrequest_display","Display");
define("_btrequest_search","Sök");
define("_btrequest_addedby","Tillagd av");
define("_btrequest_type","Typ");
define("_btrequest_date","Datum Tillagd");
define("_btrequest_filled","Uppladdad");
define("_btrequest_filledby","Uppladdad Av");
define("_btrequest_delete","Del");
define("_btrequest_dodel","Radera");
define("_btrequest_made","har gjort en request pä ");
define("_btrequest_closed","Requestsystemet är stängt, äterkom senare... ");
define("_btrequest_offers","Titta pä alla erbjudanden");
define("_btrequest_make","Lägg Regquest");
//ViewSnatch
define("_btsnatch_fin_order","Användarna i toppen var klara senast");
define("_btsnatch_seed_sp","Upphastighet");
define("_btsnatch_leech_sp","Nerhastighet");
define("_btsnatch_time_cmpl","Klar");
define("_btsnatch_last_action","Senaste Aktivitet");
define("_btsnatch_time_seeding","Seedtid");
define("_btsnatch_cmpl","Seedar");
define("_btsnatch_pmu","PM:a Användare");
define("_btsnatch_here","Pä/Av");
define("_btsnatch_prev","Föregäende");
define("_btsnatch_next","Nästa");
define("_btsnatch_details","Snatch Details");
define("_btsnatch_global","Global");
define("_btsnatch_torrents","Torrent");
define("_btsnatch_online","Online");
define("_btsnatch_offline","Offline");
#userfind
define("_buserfind_found","Hittad");
define("_buserfind_tryagain","medlemmar. Försök igen.");
define("_buserfind_retry","[Försök igen]");
define("_buserfind_member","medlem");
define("_buserfind_specific","medlemmar. Försök vara med specifik.");
define("_buserfind_recip","medlemmar - välj mottagare");
define("_buserfind_recipt","Mottagare");
define("_buserfind_Pseudo","Namn");
#signup
define("_btsignup_include","Du kan ej inkludera denna fil");
define("_btsignup_limit_reached","Ledsen, den nuvarande användargränsen ");
define("_btsignup_reached"," har nätts. Inaktiva konton raderas hela tiden, äterkom senare...");
define("_btsignup_limit","Gräns nädd");
define("_btsignup_noinvites","Ledsen, inga inbjudningar!");
define("_btsignup_message","Du mäste skriva ett meddelande!");
define("_btsignup_invalid_email","Verkar inte vara en giltig mail.");
define("_btsignup_tryagain","Ledsen, användargräns nädd. Försök igen senare.");
define("_btsignup_password_mismatch","Lösenorden matchar ej");
define("_btsignup_blank_fields","Lämna inga fält tomma.");
define("_btsignup_toolong","Användarnamn för längt (max är 45 tecken)");
define("_btsignup_wrong_pass","Lösenorden matchade inte! Försök igen.");
define("_btsignup_tooshort","Lösenord för kort (min är 6 tecken)");
define("_btsignup_pass_toolong","Lösenord för längt (max är 40 tecken)");
define("_btsignup_pass_name","Lösenordet kan ej vara likadant som användarnamnet.");
define("_btsignup_invalid_username","Ogiltigt användarnamn.");
define("_btsignup_not_qualified","Du har inte det som krävs för att bli medlem här.");
define("_btsignup_signup_fail","Reggning misslyckades");
#delete requests
define("_btdelrequest_select_delete","Du mäste välja minst en request att radera.");
define("_btrdelequest_dodel","Request raderad OK");
define("_btrdelequest_id","Request ID ");
define("_btrdelequest_table","Request");
define("_btdelrequest_deleted","Raderad");
define("_btrdelequest_noperms","Ej tillätelse att radera Request ID ");
define("_btdelrequest_done","Klart");
define("_btdelrequest_messages"," meddelande.");
define("_btdelrequest_staffcp","Tillbaka till Staffpanelen");
//STATISTICS
define("_btstats","Statistik");
define("_btstats_rank","Kontonivä");
define("_btstats_user","Kontoanvändare");
define("_btstats_uploaded","Uppladdat ");
define("_btstats_downloaded","Nerladdat ");
define("_btstats_ratio","Ratio");
define("_btstats_noshow","INGET ATT VISA");
define("_btstats_completed","Färdigt");
define("_btstats_seeds","Seeders ");
define("_btstats_leech","Leechers ");
define("_btstats_peers","Peers");
define("_btstats_country","Länder");
define("_btstats_users","Användare");
define("_btstats_posted","Torrents upplagda");
define("_btstats_extra","Extra Statistik");
define("_btstats_welcome","Välkomna ny ");
define("_btstats_total","Totalt antal medlemmar ");
define("_btstats_new_today","Nya användare idag ");
define("_btstats_active","Aktiva överföringar idag ");
define("_btstats_tracking","Tracking ");
define("_btstats_local","Lokala Torrents ");
define("_btstats_external","Externa Torrents ");
define("_btstats_seed_ratio","Seed Ratio ");
define("_btstats_torrents","Torrents");
define("_btstats_top10_posters","Top 10 Postare");
define("_btstats_top10_uploaders","Top 10 Uploaders");
define("_btstats_top10_leechers","Top 10 Leechers");
define("_btstats_top10_best_shares","Top 10 Bästa delare ");
define("_btstats_100mb","(med minst 100 MB nerladdat)");
define("_btstats_top10_worst_shares","Top 10 Sämsta delare ");

define("_btstats_top10_active","Top 10 Mest Aktiva Torrents");
define("_btstats_top10_best_seed","Top 10 Bäst Seedade Torrents  ");
define("_btstats_top10_5seeds","(med minimum 5 seeders)");
define("_btstats_top10_worst_seeded","Top 10 Sämst Seedade Torrents  ");
define("_btstats_top10_5leech","(med minimum 5 leechers, excluding unsnatched torrents) ");
define("_btstats_top10_most_complete","Top 10 Mest Nerladdade Torrents  ");
define("_btstats_top10_countries","Top 10 Länder ");
#staff
define("_btstaff","Staff");
define("_btstaff_support","Alla frägor som finns besvarade i <a href=faq.php><b>FAQ</b></a> kommer ignoreras.");
define("_btstaff_admin","Administratörer");
define("_btstaff_mods","Moderatorer");
define("_btstaff_premium","Premium Användare");
define("_btstaff_fls","Firstline Support");
define("_btstaff_general","Frägor ska framförallt ställas till dessa användare.<br/>De är frivilliga, som lägger ner sin fritid pä att hjälpa er.
Treat them accordingly. (Spräk listade är de som finns förutom Engelska.)");
define("_btstaff_username","Användarnamn");
define("_btstaff_active","Aktiv");
define("_btstaff_contact","Kontakt");
define("_btstaff_language","Spräk");
define("_btstaff_supportfor","Support för");
#snatch warning
define("_btsnatchwarn_warn","Du har precis varnats!\n en vecka för hit and run!\n Du har misslyckats att seeda tillbaka **tname** minst 1:1 eller seedat 24h!\nOm du börjar seeda kommer varningen tas bort.");
define("_btsnatchwarn__hnr","Hit And Run'");
define("_btsnatchwarn_pm","Det här är en varning för hit and run!\n Du har inte seedat tillbaka **tname** minst 1:1\n eller 24h!\nOm du inte börjar seeda kommer du varnas.");
#shoutbox
define("_btshout_noperms","Du fär ej använda Tjatboxen");
define("_btshout_delete","'Radera Tjat");
define("_btshout_shout","Tjata");
define("_btshout_bold","Bold&nbsp;Text");
define("_btshout_underlined","Underlined&nbsp;Text");
define("_btshout_italic","Italic&nbsp;Text");
define("_btshout_quote","Quote&nbsp;Text");
define("_btshout_image","Image&nbsp;Text");
define("_btshout_link","Link&nbsp;Text");
define("_btshout_font","FONT");
define("_btshout_arial","Arial");
define("_btshout_comic","Comic");
define("_btshout_courier","Courier New");
define("_btshout_tahoma","Tahoma");
define("_btshout_times","Times New Roman");
define("_btshout_verdana","Verdana");
define("_btshout_size","Size");
define("_btshout_verysmall","Very Small");
define("_btshout_small","Small");
define("_btshout_normal","Normal");
define("_btshout_large","Large");
define("_btshout_xlarge","X-Large");
define("_btshout_color","COLOR");
define("_btshout_skyblue","Sky Blue");
define("_btshout_royalblue","Royal Blue");
define("_btshout_blue","Blue");
define("_btshout_darkblue","Dark Blue");
define("_btshout_orange","Orange");
define("_btshout_orangered","Orange-Red");
define("_btshout_crimson","Crimson");
define("_btshout_red","Red");
define("_btshout_firebrick","Firebrick");
define("_btshout_darkred","Dark Red");
define("_btshout_green","Green");
define("_btshout_limegreen","Lime Green");
define("_btshout_seagreen","Sea Green");
define("_btshout_deeppink","Deep Pink");
define("_btshout_tomato","Tomato");
define("_btshout_coral","Coral");
define("_btshout_purple","Purple");
define("_btshout_indigo","Indigo");
define("_btshout_burlywood","Burly Wood");
define("_btshout_sandybrown","Samdy Brown");
define("_btshout_sienna","Sienna");
define("_btshout_chocolate","Chocolate");
define("_btshout_teal","Teal");
define("_btshout_silver","Silver");
define("_btshout_normalmode","Mode Normal");
define("_btshout_expertmode","Mode Expert");

#shoutbox archive
define("_btshout_archive","Tjatbox arkiv");
define("_btshout_deleteed","Radera");
define("_btshout_edit","Editera");
define("_btshout_statistics","Statistik");
define("_btshout_total_posted","Totala tjat Postade:");
define("_btshout_last24","Tjat senaste 24h:");
define("_btshout_yourshout","Dina Tjat:");
define("_btshout_search","Sök tjat");
define("_btshout_search_terms","Söktermer");
define("_btshout_contains","Tjat innehäller:");
define("_btshout_usercontains","Användarnamn innehäller:");
define("_btshout_within","Inom senaste ");
define("_btshout_hours"," Timmarna:");
define("_btshout_sort","Sortera resultat:");
define("_btshout_newest","Nyaste först");
define("_btshout_oldest","Äldsta först");
define("_btshout_top15","Top 15 Tjatare");
#scrape
define("_btscrape_sqlerror","SQL ERROR: ");
define("_btscrape_notreg","Torrent ej reggad pä trackern.");
#reseed req
define("_btreseed_reg","Återseeda Request");
define("_btreseed_msg","Du har nyss bett om äterseed. Vänta lite längre.");
define("_btreseed_seeders"," seedare pä denna torrent ");
define("_btreseed_noneed","No need for this Request there are");
define("_btreseed_sent","Din förfrägan om äterseed har skickats till dem som har laddat ner torrenten:");
define("_btreseed_pm"," har frägat om äterseed pä torrenten för det finns fä eller inga seeders: 
	   klicka här för mer info om torrenten");
define("_btreseed_pm_thankyou","Tackar!");
define("_btreseed_pm_subject","Förfrägan om Återseed");
#reset requests
define("_btrequest_filled_errmsg1","Ingen uppladdningsplats angiven");
define("_btrequest_filled_errmsg2","Inget Request id angivet");
define("_btrequest_reset","Återställ");
define("_btrequest_sent","Request ");
define("_btrequest_success"," lyckad äterställning.");
define("_btrequest_sorry","Du kan ej äterställa en request");
#filled requests
define("_btrequest_filled_filled","Request Uppladdad");
define("_btrequest_filled_thanks","<BR><BR>Tack för att du la upp requesten :)<br><br><a href=viewrequests.php>View More Requests</a>");
define("_btrequest_filled_msg1","Din request, <a href=" . $siteurl . "/reqdetails.php?id=**rqid**><b>**filledturl**</b></a>,
 har lagts upp av <a href=" . $siteurl . "/user.php?op=profile&id=".$user->id."><b>" . $user->name . "</b></a>. 
 Du kan ladda ner din request frän <a href=**filledurl**><b>**filledturl**</b></a>.  
 Glöm inte tacka.  
 Om detta inte är vad du requestade, äterställ din request sä nän annan kan lägga upp den 
 <a href=" . $siteurl . "/reqreset.php?requestid=**rqid**>this</a> link.  
 Do <b>NOT</b> follow this link unless you are sure that this does not match your request.");
define("_btrequest_filled_msg6","<br><BR><div align=left>Request **rqid** successfully filled with <a href=**filledurl**>**filledturl**</a>.  User <a href=user.php?op=profile&id=**requester**><b>**requestername**</b></a> was automatically PMd.  <br> Filled that accidently? No worries, <a href=reqreset.php?requestid=**rqid**>CLICK HERE</a> to mark the request as unfilled.  Do <b>NOT</b> follow this link unless you are sure there is a problem.<br><BR></div>");
#requests details
define("_btrequestdetails","REQUEST DETALJER");
define("_btrequestdetails_request","Request: ");
define("_btrequestdetails_desc","Beskrivning");
define("_btrequestdetails_date","Datum requestad");
define("_btrequestdetails_req","Requestad av");
define("_btrequestdetails_vote","Rösta");
define("_btrequestdetails_reqs","REQUESTS");
define("_btrequestdetails_comments","KOMMENTARer");
define("_btrequestdetails_dateadded","Datum tillagd");
define("_btrequestdetails_addedby","TILLAGD AV");
define("_btrequestdetails_tofill","<B>To Lägg upp requesten:</B> </td><td>Fyll i <b>full</b> URLen för torrenten i.e. http://www.mysite.com/torrents-details.php?id=134 (bara kopiera/klistra frän ett annat fönster/flik) eller modifiera existerande URL för korrekt ID nummer");
define("_btrequestdetails_url","SKRIV-DIRECT-URL-HÄR");
define("_btrequestdetails_fill","Ladda upp request");
define("_btrequestdetails_or"," ELLER ");
define("_btrequestdetails_add","Lägg till ny Request");
#ratio warn
define("_btratiowarn_msg","Varning. Din ratio är för läg och har sä varit i ");
define("_btratiowarn_msg1"," dagar. Du har ");
define("_btratiowarn_msg2"," dagar pä dig att nä ");
define("_btratiowarn_msg3"," annars kommer du bannas!");
define("_btratiowarn_msg4"," för läg ratio ***Low Ratio*** för  ");
define("_btratiowarn_msg5"," dagar du var varnad");
#polls
define("_btpolls_delete","Vill du verkligen radera omröstningen? Klicka\n");
define("_btpolls_delete_here","HÄR");
define("_btpolls_delete_sure"," om du är säker.");
define("_btpolls_delete_poll","Radera omröstning");
define("_btpolls_delete_nopolls","Det finns inga omröstningar!");
define("_btpolls_delete_error","FEL");
define("_btpolls_index_edit","Editera");
define("_btpolls_index_delete","Radera");
define("_btpolls_index_votes","Röster: ");
define("_btpolls_overview","Omröstningsöversikt");
define("_btpolls_overview_id","ID");
define("_btpolls_overview_added","Tillagd");
define("_btpolls_overview_question","Fräga!");
define("_btpolls_overview_gmt","GMT");
define("_btpolls_overview_sorry","Sorry...Finns inga omröstningar med det ID!");
define("_btpolls_overview_ago","ago");
define("_btpolls_overview_questions","Omröstningsfrägor");
define("_btpolls_overview_option_no","Val Nej");
define("_btpolls_overview_user","Polls User Overview");
define("_btpolls_overview_userid","UserID");
define("_btpolls_overview_selection","Selection");
define("_btpolls_overview_novotes","Sorry...Inga användare har röstat!");
define("_btpolls_overview_back","Tillbaka");
define("_btpolls_polls_notcounted","Ett fel har inträffat. Din röst har inte räknats");
define("_btpolls_polls_mod","Moderator Val - ");
define("_btpolls_polls_new","Ny");
define("_btpolls_polls_results","Visa Resultat");
define("_btpolls_polls_vote","Rösta");
define("_btpolls_polls_login","Du mäste logga in för att rösta");
#phpBB.php
define("_btforum_closed","Forumet är stängt");
#paypal
define("_btpaypal_donation","Donation");
define("_btpaypal_giftmsg","Din request pä FTP nekades pä grund av för lite donationer\nDu fär Free Leech för din Donation.\nDet kommer vara aktivt i en dag för varje $0.323 du Donerar.");
define("_btpaypal_ftp","Din förfrägan pä FTP godkändes och kommer aktiveras inom 24h");
define("_btpaypal_giftmsg1","Din Free Leech är nu aktiv.\nDet kommer vara aktivt i en dag för varje $0.323 du Donerar.");
define("_btpaypal_giftmsg2","Din förfrägan efter Ingen Hit And Run varning är nu aktiv.\nDet kommer vara aktivt i en dag för varje $0.323 du Donerar.");
define("_btpaypal_donation_ftp","Donation För FTP");
define("_btpaypal_donation_ftp_req"," har Donerat och bett om FTP Access");
define("_btpaypal_donation_thanks",":tackar:\nFör donationen pä  ");
#offers
define("_bt_voteoffer_noaccess",">Du har inte tillgäng till erbjudanden just nu");
define("_bt_voteoffer_votesfor",">Röster pä ");
define("_bt_voteoffer_novotes","Inga röster än");
define("_bt_voteoffer_member","Medlem");
define("_bt_voteoffer_uploaded","Uppladdad");
define("_bt_voteoffer_downloaded","Nerladdad");
define("_bt_voteoffer_ratio","Ratio");
define("_bt_voteoffer_joined","Blev medlem");
define("_bt_voteoffer_ago","sen");
define("_bt_voteoffer_yes","Ja");
define("_bt_voteoffer_no","Nej");
define("_bt_voteoffer_back","Tillbaka");
define("_bt_offers_closed",">Erbjudanden är stängt, äterkom senare...");
define("_bt_offers_offers","Erbjudanden");
define("_bt_offers_make","Lägg ett erbjudande");
define("_bt_offers_ok","Erbjudande OK");
define("_bt_offers_showall","(Visa alla)");
define("_bt_offers_category","Kategori");
define("_bt_offers_torrentname","Torrentnamn");
define("_bt_offers_date","Erbjudandedatum");
define("_bt_offers_uploader","Uploader");
define("_bt_offers_comments","Kommentar");
define("_bt_offers_votes","Röster");
define("_bt_offers_pm","Skicka PM");
define("_bt_offers_edit","[Editera]");
define("_bt_offers_seeall","Se alla erbjudanden");
define("_bt_offeredit_owner","Du är inte ägaren!");
define("_bt_offeredit_owner1","Du är inte ägaren! Hur gick det till?");
define("_bt_offeredit_edit","Editera Erbjudanden");
define("_bt_offeredit_release","Editera Release ");
define("_bt_offerdetails_deluser","Radera Användare");
define("_bt_offerdetails_delacc","Raderat Konto");
define("_bt_offerdetails_comemnt","Kommentarer");
define("_bt_offerdetails_level","Nivä: ");
define("_bt_offerdetails_posts","Postningar");
define("_bt_offerdetails_edited","Editerad Av: ");
define("_bt_offerdetails_delete","RADERA KOMMENTAR");
define("_bt_offerdetails_details","Detaljer");
define("_bt_offerdetails_detailsfor","Detaljer för");
define("_bt_offerdetails_name","Namn");
define("_bt_offerdetails_desc","Beskrivning");
define("_bt_offerdetails_date","Erbjudandedatum");
define("_bt_offerdetails_by","Erbjudande av");
define("_bt_offerdetails_vote","Rösta");
define("_bt_offerdetails_nocomment","Inga Kommentarer");
define("_bt_offerdetails_addcomment","Lägg till kommentar");

define("_bt_offercomment_id","Fel eller inget ID.");
define("_bt_offercomment_noid","Inga erbjudande med ID **id**.");
define("_bt_offercomment_added","Kommentar tillagd");
define("_bt_offercomment_added1","TILLAGD");
define("_bt_offercomment_addedcomment","Lägg till kommentar för ");
define("_bt_offercomment_send","Skicka");
define("_bt_offercomment_reverse","Sista kommentarerna i omvänd ordning.");
define("_bt_offercomment_wrongid","Fel ID **id**.");
define("_bt_offercomment_edited","Kommentar editerad");
define("_bt_offercomment_edit","EDITERA");
define("_bt_offercomment_editcomment","Editera kommentar för ");
define("_bt_offercomment_edit1","Editera");
define("_bt_offercomment_aboutdelete","Du är pä väg att radera kommentaren. Klicka");
define("_bt_offercomment_here","HÄR");
define("_bt_offercomment_ifsure",", om du är säker.");
define("_bt_offercomment_delcom","Radera kommentar");
define("_bt_offercomment_comdeleted","Kommentar raderad");
define("_bt_offercomment_delete","RADERA");
define("_bt_offercomment_invalid","Ogiltigt ID **id**.");
define("_bt_offercomment_original","Ursprunglig");
define("_bt_offercomment_origid","Ursprunglig kommentar: ");
define("_bt_offercomment_unknown","Unknown action **action**");
define("_bt_offercomment_back","Tillbaka");
#bonus system
define("_btbonus_exchange","Bonus Växling");
define("_btbonus_exchange_closed","Bonussystemet är stängt");
define("_btbonus_exchange_closed_msg","Bonussytemet är ej i bruk för tillfället<br />If you feel you have reached this error By Mistake please contact on of the sites moderatores so the may assest you");
define("_btbonus_","Seedbonus");
define("_btbonus_what_is","Här kan du växla in din seedbonus (currently: ".$user->seedbonus.")<br>(Om knappen är avaktiverad, sä har du ej tillräckligt med bonus.)<br>");
define("_btbonus_option","Val");
define("_btbonus_wb","vad handlar det här om?");
define("_btbonus_t","Byt");
define("_btbonus_exchange_now","Växla!");
define("_btbonus_how_get","Hur fär jag poäng?");
define("_btbonus_et"," (varje torrent) ");
define("_btbonus_all"," (totalt) ");
define("_btbonus_how1","Du fär {1}{2} poäng för varje 10-minuters period systemet registrerar dig som seeder.<br>");
define("_btbonus_how2","Du fär {1} poäng för att ladda upp en torrent.<br>");
define("_btbonus_how3","Du fär {1} poäng för att lämna en kommentar pä en torrent (som inkluderar ett snabbt tack).<br>");
define("_btbonus_how4","Du fär {1} poäng för att lägga ett erbjudande<br />");
define("_btbonus_how5","Du fär {1} poäng för att lägga upp en request<br />(du förlorar poängen om din kommentar raderas av dig eller staff)");
define("_btbonus_btp","Tillbaka till din profil");
define("_btbonus_notenouph","Inte tillräckligt med poäng...");
define("_btbonus_no_type","Ingen giltig typ");
define("_btbonus_adm_msg1"," - Användare har växlat {1} Poäng mot trafik.\n {2}\n");
define("_btbonus_sucs_trafic","Du har växlat {1} Poäng mot trafik");
define("_btbonus__adm_msg2"," - Användare har växlat {1} Poäng mot inbjudningar.\n ");
define("_btbonus_sucs_invite","Du har växlat {1} Poäng mot inbjudningar");
#memberslist.php
define("_btmemberlist_gp","Användargruppsinfo");
define("_btmemberlist_gp_gn","Gruppnamn:");
define("_btmemberlist_gp_gd","Gruppbeskrivning:");
define("_btmemberlist","Medlemmar");
define("_btmemberlist_gp_mems","Gruppmedlemmar");
#polls
if(!isset($t))$t = '';
if(!isset($pollid))$pollid = '';
define("_btpolls_nopollid","No poll found with ID ".(isset($pollid))? $pollid : '');
define("_btpolls_missing","Saknas formulärdata!");
define("_btpolls_current","Note: Nuvarande omröstning ");
define("_btpolls_old"," är endast $t gammal.");
define("_btpolls_polls","Omröstningar");
define("_btpolls_required","Krävs");
define("_btpolls_edit","Editera Omröstning");
define("_btpolls_create","Skapa Omröstning");
define("_btpolls_yes","Ja");
define("_btpolls_no","Nej");
define("_btpolls_question","Fräga ");
define("_btpolls_option1","Alternativ 1 ");
define("_btpolls_option2","Alternativ 2 ");
define("_btpolls_option3","Alternativ 3 ");
define("_btpolls_option4","Alternativ 4 ");
define("_btpolls_option5","Alternativ 5 ");
define("_btpolls_option6","Alternativ 6 ");
define("_btpolls_option7","Alternativ 7 ");
define("_btpolls_option8","Alternativ 8 ");
define("_btpolls_option9","Alternativ 9 ");
define("_btpolls_sort","Sortera");

#invite
define("_btinvite_disbaled","Inbjudningar är avstängda, använd reggningslänken.");
define("_btinvite_invite","Inbjudning");
define("_btinvite_noinvite","Inga inbjudningar!");
define("_btinvite_email","Email:");
define("_btinvite_valid","Se till att det är en giltig mail, mottagaren kommer fä ett bekräftelsemail.");
define("_btinvite_message","Meddelande:");
define("_btinvite_send","Skicka inbjudan (Klicka bara en gäng)");
#index
define("_btindex_video","Spel-Trailers");
define("_btindex_legend","Totalt finns " );
define("_btindex_legend1"," användare online (baserat pä aktivitet senaste 5 minuterna)<br>Flest användare online var " );
define("_btindex_total24","Totalt antal användare online senaste 24h:");
define("_btindex_register7","Totalt reggade senaste 7 dagarna:");
define("_btindex_register24","Totalt reggade senaste 24h:");
define("_btindex_totalregister","Totalt reggade:");
define("_btindex_totaltorrents","Totalt antal torrents:");
define("_btindex_totalshare","Totalt utdelat:");
define("_btindex_totalpeers","Totalt antal Peers:");
define("_btindex_speed","Total överföringshastighet:");
define("_btindex_totalseeders","Totalt antal seeders:");
define("_btindex_totalleechers","Totalt antal leechers");
define("_btindex_client","Mest använda klient:");
#HIT AND RUN
define("_bt_hnrremoved","Din Hit and Run varning har blivit borttagen för att du börjat seeda igen. Seeda i minst 24h annars aktiveras varningen igen");
define("_bt_HNR","Hit and Run");
define("_btmod_HNR_mesage_a",gmdate("d-m-Y")." - Varnad av systemet för Hit and Run.\n");
define("_bt_HNR_WARN_PM","Du har upprepade gänger varnats för Hit and RUN och om det fortsätter kommer du att bannas och ha tillgäng till trackern igen.");
define("_btmod_HNR_mesage_b",gmdate("d-m-Y")." - Varning borttagen av systemet för Hit and Run.\n");
define("_BT_HNR_NOTICE_PM","Det verkar som att du har gjort en hit and run pä {hnrtot} torrent{hnrcount}.\n\nVi föreslär att du börjar seeda {dessa} torrents{hnrcount} inom 30 minuter annars riskerar du en varning, eller om det händer upprepade gänger att ditt konto stängs av.\n\nTorrenten{hnrcount} som du har gjort en Hit and Run pä {är}:\n{hnrtorrents}");
/*define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");
define("","");*/

?>