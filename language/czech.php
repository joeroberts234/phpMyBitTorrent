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
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/


if (eregi("czech.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

define("_LOCALE","cz_CZ");

//WELCOME MESSAGE :-D
define("_btstart","Welcome to phpMyBitTorrent!<br />
Díky technologii Bit Torrent, sdílení vašich dat s lidmi po celém svìtì
nikdy nebylo jednodušší! Staèí pár minut ka zaèátku sdílení a
stahování všech souborù co chcete! Náš tracker mùete volnì pouívat ke sdílení vašich souborù,
 nebo mùete nahrát Torrenty uloené na jinıch trackerech k
zvıšení jejich dùleitosti. A také, Vy rozhodujete kdo mùe stahovat torrenty! Chráníme
vaše soukromí, nejdùleitìjší vìc hned po ivotì!");

//Donations Block
define("_btdonations","Pøíspìvky");
define("_btdonationsgoal","Cíl:");
define("_btdonationscollected","Nasbíráno:");
define("_btdonationsprogress","Vıvoj pøíspìvkù");
define("_btdonationsdonate","PØISPÌT");

//COMPLAINTS
function getcomplaints() {
        return Array(0=>"Legální obsah, dobrá kvalita",1=>"Podvrh nebo poškozenı",2=>"Porušení copyrightu",3=>"Pornografickı obsah",4=>"Dìtská pornografie",5=>"Urálivı obsah",6=>"Obsah spojenı s nelegální èinností");
}

//CLASSI
define("_btclassuser","Uivatel");
define("_btclasspremium","Premiovı Uivatel");
define("_btclassmoderator","Moderátor");
define("_btclassadmin","Administrátor");

//ACCESSO NEGATO
define("_btaccdenied","Pøístup zakázán");
define("_btdenuser","Oblast do které se snaíte vstoupit je pøístupná pro <b>registrované uivatele</b>.<br>Prosím zadejte vaše údaje a zkuste to znovu. Nebo, se mùete <a href=\"user.php?op=signup\">zaregistrovat</a> zdarma.");
define("_btdenpremium","Oblast do které se snaíte vstoupit je pøístupná pro <b>Prémiové uivatele</b>.<br>");
define("_btdenpremium1","Prosím zadejte Vaše pøístupové údaje a zkuste to znovu. Pokud nemáte Prémiovı úèet, prosím kontaktujte náše pracovníky pro
detailní informace o schválení Premiového úètu.");
define("_btdenpremium2","Váš úèet není nastaven pro pøístup k Premiovım slubám. Prosím kontaktujte náše pracovníky pro
detailní informace o schválení Premiového úètu.");
define("_btdenadmin","Oblast do které se snaíte vstoupit je pøístupná pro <b>administrátory</b>.<br>");
define("_btdenadmin1","Pokud máte administrátorské pøístupové údaje prosím zadejte je nyní, jinak vás ádáme k opuštìní této stránky a k návratu na
<a href=\"index.php\">Domovskou stránku</a>.");
define("_btdenadmin2","Váš úèet nemá administrátorské práva. Prosím pøihlašte se se správnımi údaji nebo opuste tuto stránku a 
vrate se zpìt na <a href=\"index.php\">Domovskou stránku</a>.");
define("_btbannedmsg","Byl jste vypovìzen z této stránky protoe: <b>**reason**</b>");

//GENERICS
define("_DATESTRING","%A, %B %d %Y @ %T %Z");
define("_btpassword","Heslo");
define("_btusername","Uivatelské jméno");
define("_btsecuritycode","Bezpeènostní kód");
define("_btusermenu","Uivatelské menu");
define("_btmainmenu","Hlavní menu");
define("_btgenerror","phpMyBitTorrent Error");
define("_btmenu","Menu");
define("_btumenu","Uivatelské Menu");
define("_btsyndicate","Spolupráce");
define("_btlegend","Legenda");
define("_btircchat","IRC Chat");
define("_btchatnotenabled","IRC Chat není povolen na této stránce.");
define("_btlostpassword","Zapomnìli jste heslo?");
define("_btpm","Soukromé zprávy");

//EMAIL SPELLING
define("_at"," zavináè ");
define("_dot"," teèka ");

//SQL ERRORS
define("_btsqlerror1","Error pøi provádìní SQL dotazu ");
define("_btsqlerror2","Error ID: ");
define("_btsqlerror3","Zpráva Erroru: ");

//HTTP ERRORS
define("_http400errttl","HTTP 400 Error - Špatnı poadavek");
define("_http400errtxt","400 Error nastal pøi zpracování vaší ádosti.\n
Prosím zkontrolujte nastavení vašeho prohlíeèe a zkuste znovu pøistoupit k poadované stránce.\n
Kontaktujte **email** pokud máte problémy.");
define("_http401errttl","HTTP 401 Error - Pøístup zakázán");
define("_http401errtxt","401 HTTP Error nastal pøi zpracování vaší ádosti.<br>
Nemùete vstoupit na poadovanou stránku protoe nejste oprávnìni.<br>
Prosím poskytnìte vaše pøístupové údaje, pokud nìjaké máte.<br>
Kontaktujte **email** pokud máte potíe.");
define("_http403errttl","HTTP 403 Error - Zakázáno");
define("_http403errtxt","403 HTTP Error nastal pøi zpracování vaší ádosti.<br>
Nemùete pøistoupit k poadované stránce, protoe vám to konfigurace serveru nedovoluje.<br>
Prosím peèlivì zkontrolujte URL adresu ve vašem prohlíeèi, a opravte ji pokud je tøeba.<br>
Kontaktujte **email** pokud máte problémy.");
define("_http404errttl","HTTP 404 Error - Nenalezeno");
define("_http404errtxt","404 HTTP Error nastal pøi zpracování vaší ádosti.<br>
Poadovaná stránka neexistuje.<br>
Prosím zkontrolujte peèlivì URL ve vašem prohlíeèi, a pokud je tøeba opravte.<br>
Kontaktujte **email** pokud máte problémy.");
define("_http500errttl","HTTP 500 Error - Vnitøní Error serveru");
define("_http500errtxt","500 HTTP Error nastal pøi zpracování vaší ádosti.<br>
Nastala chyba pøi zpracování vašich dat.<br>
Detailní info mùete nalézt v záznamech serveru.<br>
Prosím pošlete o tomtu detailní zprávu na **email**");

//USER BLOCK
define("_btyoureseeding","Torrenty které seedujete");
define("_btyoureleeching","Torrenty které stahujete");
define("_btuserstats","Uivatelské Statistiky");
define("_bttotusers","Registrovaní uivatelé:");
define("_btlastuser","Poslední registrovanı:");
define("_bttorrents","Dostupné torrenty:");
define("_bttotshare","Celkovì sdíleno:");
define("_bttotpeers","Pøipojeno Peerù:");
define("_bttotseed","Celkem Seederù:");
define("_bttotleech","Celkem Peerù:");


//TESTI CHE COMPAIONO IN USER.PHP
define("_btregwelcome","<P align=\"center\">Vítejte!</P>
<P>Zaregistrujte si úèet a pøidejte se do naší komunity. To vám umoní plné vyuití slueb na této stránce, a zabere to jen pár minut. Zvolte si uivatelské jméno a heslo a poskytnìte platnou e-mailovou adresu. Bìhem pár minut obdríte mail, ádající vás potvrdit registraci.</P>");
define("_btreggfxcheck","<P align=\"center\"> Prosím zadejte následující bezpeènostní kód (zabraòuje botùm v registraci).<BR>Kontaktujte **email** pokud máte problémy s pøeètením kódu.</P>");
define("_btemailaddress","E-Mailová adresa");
define("_btpasswd","Heslo (5 znakù minimum)");
define("_btpasswd2","Potvrzení password");
define("_btsubmit","Registruj");
define("_btreset","Zruš úpravy");
define("_btdisclaimer","Podmínky:");
define("_btdisclaccept","Souhlasím");
define("_btdisclrefuse","Nesouhlasím");
define("_btgfxcode","Bezpeènostní kód");
define("_btsignuperror","Error bìhem procesu registrace");
define("_bterruserexists","Uivatelské jméno u existuje.");
define("_btfakemail","Emailová adresa kterou jste zadali není platná.");
define("_bterremailexists","Emailová adresa kterou jste zadali je ji registrovaná. Chcete zjistit heslo? Kliknìte <a href=\"user.php?op=lostpassword\">SEM</a>");
define("_btpasswnotsame","Hesla která jste zadala nejsou shodná");
define("_bttooshortpass","Heslo které jste zadal/a je moc krátké. Minimální délka je 5.");
define("_bterrcode","Bezpeènostní kód kterı jste zadal/a je špatnì");
define("_btdisclerror","MUSÍTE PØIJMOUT naše Práva a ustanovení aby ste se mohli registrovat.");
define("_btgoback","Prosím vrate se a zkontrolujte údaje");
define("_btregcomplete","Registrace skoro dokonèena. Máte 24 hodin na potvrzení vaší registrace. Pokud neobdríte
emailové potvrzení, prosím zkontrolujte data která ste zadal/a. Pokud máte problémy, prosím kontaktujte Webmastera na **email**");
define("_bterrusernamenotset","Uivatelské jméno nevyplnìno.");
define("_bterrkeynotset","Aktivaèní klíè nespecifikován");
define("_bterrusernotexists","Toto uivatelské jméno neexistuje.");
define("_bterrinvalidactkey","Aktivaèní klíè není správnı.");
define("_btuseralreadyactive","Uivatel je ji aktivován. ádná další aktivace není tøeba");
define("_btacterror","Error aktivace");
define("_btactcomplete","Aktivace dokonèena. Váš úèet je nyní trvale aktivován. Od teï, mùete pøistupovat
k našim slubám pomocí uivatelského jména a hesla které jste zadali. Pøejeme pøíjemné stahování.");
define("_btusrpwdnotset","Uivatelské jméno nebo heslo nespecifikováno.");
define("_bterremailnotset","E-Mailová adresa nespecifikována.");
define("_btuserpasswrong","Nesprávné uivatelské jméno nebo heslo!!");
define("_btuserinactive","Uivatel registrován ale neaktivován!!");
define("_btloginsuccessful","Pøihlášení úspìšné. Nyní máte **priv** práva. Pøejeme pøíjemné stahování!");
define("_btlogoutsuccessful","Odhlášení úspìšné. Data o vaší session byla smazána z vašeho PC.");
define("_btusernoexist","Omlouváme se, ale poadovanı uivatel neexistuje.");
define("_btuserprofile","Uivatelskı profil");
define("_btedituserprofile","Editace profilu");
define("_btusertorrents","Torrenty uivatele **user**");
define("_btcompletename","Celé jméno");
define("_btclass","Level");
define("_btclassbanned","Zakázán!");
define("_btclassuser","Uivatel");
define("_btclasspremium","Premiovı Uivatel");
define("_btclassadmin","Administrátor");
define("_btregistered","Registerovanı");
define("_btavatar","Avatar");
define("_btcontacts","Kontakty");
define("_btnewavatargallery","Novı Avatar z Galerie");
define("_btnewavatarupload","Upload nového Avataru");
define("_btinvalidimagefile","Špatnı soubor obrázku");
define("_btavatartoobig","Obrázek pøesahuje povolenou velikost");
define("_btlostpasswordintro","Pokud jste ztratili heslo, mùete znovu získat pøístup k vašemu úètu po zadání uivatelského jména a NOVÉHO hesla.<br />
Potvrzovací mail bude zaslán na e-mailovou adresu spojenou s vaším úètem. Ujistìte se e mùete pøijímat maily (napø. vaše schránka není plná) ne potvrdíte svou ádost. Pokud neobdríte tento mail, zkuste zkontrolovat váš spamovı-filtr.");
define("_btlostpasswordcheckmail","Zpráva obsahující potvrzovací odkaz byla odeslána na emailovou adresu. Prosím kliknìte na odkaz aby nastala zmìna hesla.");
define("_btlostpwdinvalid","Špatnı potvrzovací kód nebo uivatelské ID");
define("_btlostpwdcomplete","Heslo zmìnìno. Nyní se mùete pøihlásit s vaším novım heslem.");
define("_btdeluser","Smazání úètu");
define("_btdeluserwarning","<b>VAROVÁNÍ</b>: chystáte se trvale a úplnì smazat váš úèet. Ztratíte editovací práva pro všechny torrenty které ste nauploadoval/a. Bude moné se následnì znovu registrovat s vaším starım uivatelskım jménem.");
define("_btdeluserwarningadm","<b>VAROVÁNÍ</b>: chystáte se trvale a úplnì smazat úèet uivatele **user**. Práva uivatele **user** editovat všechny torrenty které on/ona nauploadoval/a budou ztraceny. Registrace znovu se stejnım uivatelskım jménem bude potom moná.");
define("_btaccountdeleted","Úèet smazán");
define("_btconfirmdelete","Potvrïte smazání úètu");

//USER/EDITPROFILE.PHP
define("_btnewpassword","Nové heslo<br />(nechte prázdné pokud ho nechcete mìnit)");
define("_btnewpasswordconfirm","Potvrïte nové heslo");
define("_btaol","AOL Instant Messenger");
define("_bticq","ICQ");
define("_btjabber","Jabber IM");
define("_btmsn","MSN Messenger");
define("_btskype","Skype");
define("_btyim","Yahoo! Instant Messenger");
define("_btacceptmail","Pøijímat emaily od ostatních uivatelù");
define("_btcustomlanguage","Jazyk");
define("_btaccountstatus","Stav úètu");
define("_btaccountstatusexplain","Zaktivuje/deaktivuje uivatele. POZOR! Nastavením uivatele kterı byl registrovanı více jak 48 hodin na DEAKTIVOVANÉHO mu také smae jeho úèet.");
define("_btaccountactive","Aktivní");
define("_btaccountinactive","Neaktivní");
define("_btcustomtheme","Vzhled");
define("_btdefault","Vıchozí");
define("_btchooseavatar","Zvolte si Avatar");
define("_btusepasskey","Pouít Passkey (šifrovanı klíè)");
define("_btpasskeyexplain","Tato monost vám umoòuje stahovat Torrenty pomocí osobního bezpeènostnío kódu.<br />
Pouitím klienta state-of-the-art (stavu techniky), se u nebudete muset pøihlašovat k trackeru nebo pouívat uivatelské jméno a heslo aby ste zaktualizovali ratio (pomìr u/d) pro interní torrenty trackeru.<br />
Osobní kód se automaticky vkládá do souboru .torrent kterı stáhnete, z dùvodu autentikace trackeru.<br />
<b>VAROVÁNÍ</b>: NEDÁVEJTE .torrenty s bezpeènostním kódem z ruky! Neautorizovaní uivatelé, i bez pøihlášení na váš úèet, by je mohli pouít k ovlivnìní vašeho ratia, které mùe v dùsledku sníit vaše práva stahovat z trackeru.<br />
V pøípadì e se .torrent DOSTANE do špatnıch rukou, mùete resetovat passkey.");
define("_btresetpasskey","Resetovat Passkey");
define("_btresetpasskeywarning","<b>VAROVÁNÍ</b>: všechny torrenty které jste dosud stáhli ji nebudou platné!");
define("_btprofilesaved","Profil úspìšnì uloen!");
define("_btaccesslevel","Pøístupovı level");
define("_btdeleteaccount","Smazat úèet");

//TESTI CHE COMPAIONO IN INCLUDE/BITTORRENT.PHP
define("_btindex","Index Torrentù");
define("_bttorrentupload","Upload Torrentu");
define("_btupload","Upload");
define("_btlogin","Pøihlášení");
define("_btlogout","Odhlášení");
define("_btsignup","Registrace");
define("_btpersonal","Torrenty od ");
define("_btpm","Soukromé Zprávy");
define("_btadmin","Administrace");
define("_btrulez","Pravidla");
define("_btforums","Forum");
define("_bthelp","Pomoc");
define("_btadvinst","Nainstalujte BitTorrent nebo Shareazu ke stáhnutí");
define("_btaccessden","Pøístup zamítnut. Staení vyaduje <A href=\"user.php?op=register\">registraci</a>");
define("_btlegenda","Pomoc s vlastnostmi a legendou");
define("_btyourfilext","Váš soubor, externí tracker");
define("_btfile","soubor(y)");
define("_btexternal","Externí Tracker");
define("_btyourfile","Váš soubor");
define("_btsticky","Stálé");
define("_btauthforreq","Authorizace k ádosti");
define("_btauthreq","Authorizace ádosti");
define("_btdown","Download");
define("_btunknown","Neznámé");
define("_btrefresh","Aktualizace");
define("_btvisible","Viditelnı");
define("_btsd","SD");
define("_btlc","LC");
define("_bttt","TOT");
define("_btseedby","Torrenty seedované uivatelem");
define("_btleechby","Torrenty stahované uivatelem ");

//TESTI CHE COMPAIONO IN INDEX.PHP
define("_btwelcome","Vítejte v phpMyBitTorrent");
define("_btsearch","Hledat");
define("_btsearchname","Hledat torrenty");
define("_btin","v");
define("_btalltypes","jakékoli");
define("_btactivetorrents","Aktivní Torrenty");
define("_btitm","zahrnout mrtvé torrenty");
define("_btstm","Jen mrtvé Torrenty");
define("_btgo","Hledej!");
define("_btresfor","vısledky tøídìny podle:");
define("_btnotfound","<h2>ádnı vısledek!</h2>\n<p>Zkuste zmìnit vyhledávanı vıraz.</p>\n");
define("_btvoidcat","<h2>Tato kategorie je prázdná!</h2>");
define("_btorderby","Øaï podle");
define("_btinsdate","Datum vloení");
define("_btname","Jméno");
define("_btdim","Velikost");
define("_btnfile","Poèet souborù:");
define("_btevidence","Stálé");
define("_btcomments","Hodnocení / Komentáøe");
define("_btvote","Hodnocení");
define("_btdownloaded","Staeno");
define("_btprivacy","Soukromé");
define("_bttotsorc","Celkovı poèet peerù");
define("_btdesc","sestupnì");
define("_btord","vzestupnì");
define("_btnosearch","<center><h2>Hledejte soubory které chcete stahovat</h2>Pokud potøebujete pomoc, zkuste se zeptat ve Fóru; pokud nemùete pouít Magnet:/eD2K: odkazy pravdìpodobnì nemáte nainstalovanı správnı software<br>Pøipomínáme e naše pravidla øíkají, e všechny soubory jsou soukromé, a záleí na tom kdo sdílí soubory zda dovolí ostatním lidem stahovat. Je pøísnì zakázáno sdílet materiál s copyrightem, porno, dìtské-porno, rasistickı, urálivı materiál nebo cokoli co porušuje zákony.<br>Jakıkoli dritel ochrané známky se mùe doadovat pøidání volného filtru jména souboru kterı mu umoní chránit jeho/její ochranou známku.</center>");
define("_bthelpfind","Pomoc pøi hledání");
define("_bttype","Kategorie");
define("_bttypes","Kategorie");
define("_bttopsource","NEJLEPŠÍ zdroje stahování");
define("_btnotopsource","Zatím nejsou ádné aktivní torrenty");
define("_btnotseeder_noneed","Zatím nejsou ádné kritické torrenty");
define("_btnotseeder_desc","Pokud máte jeden z tìchto souborù, prosím seedujte (sdílejte) je s lidmi kteøí èekají na staení. Stáhnìte .torrent, nastavte vašemu klientovi adresáø s kompletním souborem, a on zaène seedovat.<br>Díky e jste jeden/a z tìch HODNİCH KLUKÙ/HOLEK.</b>");
define("_btnoseedersontracker","Váš torrent není seedován!");
define("_btdeadtorrent","Vypadá to e <b>váš torrent není seedován</b>. Tento pøedpoklad nemusí bıt správnı, take prozatím pøijmeme váš upload, ale <b>moderátoøi ho mohou pozdìji odebrat</b>.<br>");
define("_bthelpindex","<p><a name=\"HELP\"></a><a href='index_help.php'>Nainstalujte BitTorrent nebo Shareaza ke stáhnutí</a>");
define("_btnet","Zdraví Swarmu");
define("_btsource","Zroje");
define("_btvisible","Viditelné");
define("_bttorrent","Torrent");
define("_btview","Vidìn");
define("_bthits","Stáhnut");
define("_btsnatch","Dokonèen");
define("_btalternatesource","<b>Jen alternativní zdroje (Magnet/ed2K) k dispozici</b>");
define("_btcantscrape","<b>Nepodaøilo se urèit data o peeru</b>");
define("_bteasy","<b>Dobøe-seedováno</b>");
define("_btmedium","<b>Ne tak skvìle</b>");
define("_bthard","<b>Špatnì seedováno/mrtvé</b>");
define("_btstats","Statistiky");
define("_btmisssearchkey","Schází klíè k hledání");
define("_btinfotracker","Kdo je online?");
define("_btnouseronline","Nikdo z registrovanıch uivatelù není online");
define("_btonlineusers","Online uivatelé");
define("_btadvancedmode","Rozšíøenı Mód");
define("_btsimplemode","Jednoduchı Mód");
define("_btpagename","Nyní prohlíí");
define("_btloggedinfor","Pøihlášen po dobu");

//PMBT PAGES
define("_btpage_admin.php","Administrace");
define("_btpage_chat.php","Chat");
define("_btpage_details.php","Stránka s detaily Torrentu");
define("_btpage_edit.php","Editovat Torrent");
define("_btpage_index.php","Domovská stránka");
define("_btpage_mytorrents.php","Torrent Panel");
define("_btpage_search.php","Hledat");
define("_btpage_upload.php","Upload");
define("_btpage_user.php","Uivatelskı Panel");

//TESTI CHE COMPAIONO IN DETAILS.PHP
define("_btinfo","Info o Torrentu");
define("_bttracker","Tracker");
define("_btddownloaded","Stáhnuto");
define("_btdcomplete","Dokonèeno");
define("_dtimeconnected","Èas pøipojení");
define("_btsourceurl","Dostupné na");
define("_btdidle","Pozastaveno");
define("_btdsuccessfully","Torrent nahrán úspìšnì");
define("_btdsuccessfully2","Prosím zaènìte seedovat. Viditelnost závisí na poètu zdrojù");
define("_btdsuccessfullye","Editace úspìšná");
define("_btdgobackto","Zpátky na stránku");
define("_btdwhenceyoucame","odkud jste pøišli");
define("_btdyoursearchfor","Vaše hledání pro");
define("_btnotorrent","Torrent neexistuje nebo byl zakázán");
define("_btdratingadded","Hodnocení pøidáno");
define("_btdspytorrentupdate","SpyTorrent aktualizoval zdroje");
define("_btdspytorrentupdate1","Bìhem 3 sekund jste pøesmìrování na stránku ");
define("_btdspytorrentupdate2","Pokud vás váš prohlíeè nepøesmìruje, kliknìte");
define("_btdspytorrentupdate3","zde");
define("_btdspytorrentnoupdate","Není tøeba spouštìt SpyTorrent na interních Torrentech døíve ne 15 minut pøed posledním scanováním.");
define("_btname","Jméno");
define("_btdownloadas","Stáhnout jako");
define("_btpieces","Èásti");
define("_btpiecesstring","**n** èásti po **l** velikosti");
define("_btauthstatus","Povolení ke staení");
define("_btdwauthpending","V øízení");
define("_btdwauthgranted","Schváleno!");
define("_btdwauthdenied","Zamítnuto!");
define("_btdwauthnorequest","Zatím nevyádáno");
define("_btpremiumdownload","Pouze prémioví uivatelé smìjí stáhnout tento soubor torrent");
define("_btregistereddownload","Musíte se pøihlásit nebo zaregistrovat abyste mohli stáhnout tento torrent");
define("_btnetwork","sí");
define("_btdays","d ");
define("_bthours","h ");
define("_btmins","m ");
define("_btsecs","s ");
define("_btinfohash","Info Hash");
define("_btinfohashnotice","<b>VAROVÁNÍ</b>: Torrent byl modifikován tak e MUSÍ bıt znovu stáhnut. Soubor kterı ste nahráli
není ji dále platnı. Prosím pouijte tlaèítko stáhnout abyste dostali funknèí verzi.");
define("_btdescription","Popis");
define("_btnodead","<b>ne</b> (mrtvı)");
define("_btvisible","Viditelnı");
define("_btbanned","Zakázanı");
define("_btfiles","soubor(y)");
define("_btothersource","Jiné Zdroje");
define("_btnoselected","Nezvolena ádná kategorie");
define("_btago","pøed");
define("_btlastseeder","Poslední seeder");
define("_btlastactivity","Poslední Aktivita");
define("_bttypetorrent","Typ");
define("_btsize","Velikost");
define("_btminvote","Nezvoleno (poadováno alespoò __minvotes__ hlasù");
define("_btonly","jen");
define("_btnone","ádnı");
define("_btnovotes","Bez hodnocení");
define("_btoo5","z 5 s");
define("_btvotestot","celkem hlasù");
define("_btcomplaints","Stínosti");
define("_btlogintorate","(<a href=\"user.php?op=loginform\">Pøihlašte se</a> aby ste mohli volit)");
define("_btvot1","Špatnı");
define("_btvot2","Horší");
define("_btvot3","Ne tak špatnı");
define("_btvot4","Dobrı");
define("_btvot5","Nejlepší");
define("_btaddrating","hlasuj");
define("_btvotenow","Hodno!");
define("_btrating","Hodnocení");
define("_bthelpstat","Pomoc se Statistikou");
define("_btviews","vidìno");
define("_bttimes","krát");
define("_btleechspeed","Rychlost stahování");
define("_bteta","ETA");
define("_btuppedby","Náhrano uivatelem");
define("_btnumfiles","Poèet souborù");
define("_btfilelist","Soubory");
define("_btlasttrackerupdate","Poslední update trackeru");
define("_btshowlist","Uka Peery");
define("_bthidelist","Schovej Peery");
define("_bthelpsource","Pomoc s Peery");
define("_btseeds","Dokonèeno");
define("_btcommentsfortorrent","Komenáøe na tomto torrentu");
define("_btbacktofull","Vrate se zpìt pro plné detaily");
define("_btnotifyemailcom","Pokud chcete obdret email jakmile je pøidán první komentáø, prosím kliknìte <a href=\"details.php?op=comment&trig=on&id=**id**#notify\">SEM</a>.");
define("_btnotnotifyemailcom","<p>Nyní jste zapsáni aby ste obdreli email o komentáøi. Pokud dále nechcete dostávat e-maily, prosím kliknìte <a href=\"details.php?op=comment&trig=off&id=**id**#notify\">SEM</a>.</p>");
define("_btclickhere","kliknìte sem");
define("_btnotifyemail1s","Pokud chcete obdret email jakmile se objeví první <b>SEEDER</b>, prosím kliknìte <a href=\"details.php?op=seeder&trig=on&id=**id**#notify\">SEM</a>.");
define("_btnotnotifyemail1s","<p>Nyní jste zapsáni aby ste obdreli email jakmile se objeví seeder. Pokud dále nechcete dostávat e-maily, prosím kliknìte <a href=\"details.php?op=seeder&trig=off&id=**id**#notify\">SEM</a>.</p>");
define("_btaddcomment","Pøidat komentáø");
define("_btnocommentsyet","Zatím nejsou ádné komentáøe");
define("_btcommheader","**time**, <a href=\"user.php?op=profile&id=**uid**\" target=\"_top\">**user**</a> napsal/a:");
define("_btnotnotifyemail1s","aby ste dostal/a e-mail jakmile se první SEEDER objeví");
define("_btdgavesresult","vrátil jeden vısledek");
define("_btdnotifyemaildel","Byl/a jste odebrán/a ze seznamu notifikací komentáøù");
define("_btdnotifyemaildel1","Ji neobdríte další e-maily pokud bude pøidán komentáø!");
define("_btdnotifyemailadd1","Obdríte e-mail jakmile bude pøidán komentáø, ale neobdríte další emaily ne si pøeètete komentáø!");
define("_btdnotifyemailadd","Byl/a jste pøidán/a ze seznamu notifikací komentáøù");
define("_btdnotifyadd","Byl/a jste pøidán/a ze seznamu notifikací seederù");
define("_btdnotifyadd2","dostanete oznámení o novıch seederech s maximem jednoho emailu dennì,");
define("_btdnotifydel","Byl/a jste odebrán/a ze seznamu notifikací seederù; neobdríte ádné další e-maily.");
define("_btddetails","Detaily Torrentu");
define("_bteditthistorrent","Editovat tento Torrent");
define("_btyes","ano");
define("_btno","ne");
define("_btadded","Nahráno");
define("_btaddedby","Nahráno uivatelem");
define("_bton","nahoru");
define("_bthelpothersource","Pomoc k Alternativním zdrojùm");
define("_btfilename","Jméno souboru");
define("_btpeers","Peerù");
define("_btpeerstot","Celkem peerù");
define("_bthelppeer","Pomoc k Peerùm");
define("_btleecher","Stahující");
define("_btleechers","Stahujících");
define("_btdhelpdownload","Pomoc k downloadu");
define("_btyourate","Hlasovali jste");
define("_btupdatesource","Aktualizovat zdroje nyní!");
define("_btseeder","Seeder");
define("_btseeders","Seederù");
define("_btcompletion","Dokonèeno");
define("_btdirectlink","Pøímı odkaz");
define("_btcomplyouvoted","Øekl/a jste e torrent je: ");
define("_btcomplexplain","Torrent mùe bıt zakázán pokud dosáhne urèitého poètu stíností.");
define("_btcomplaintform","Formuláø stínosti na torrent.<BR>Tento systém umoòuje oznaèit torrenty které nevyhovují našim pravidlùm.<BR>
Jakmile je dosaen urèitı poèet stíností, torrent mùe bıt zakázán v seznamu.<BR>Prosím posílejte pozitivní ohlasy na torrenty které jsou dobré a legální.<BR>");
define("_btcomplisay","Tento Torrent je ");
define("_btmagnetlink","Odkaz na Magnet");
define("_bted2klink","eD2K odkaz");
define("_btcomplatthemoment","Uivatelé poslali pozitivní ohlas <b>**p**</b> krát and negativní ohlas <b>**n**</b> krát.<BR>");
define("_btnotifications","E-Mailové Upozornìní");
define("_btreadcomms","Èíst komentáøe");
define("_btpostcomment","Pøidat komentáø");
define("_bttransfer","Pøenos");
define("_btdownloadspeed","Rychlost downloadu");
define("_btuploadspeed","Rychlost uploadu");
define("_bttorrentpassword","Ochrana heslem");
define("_btpasswordquery","Tento torrent je chránìn heslem. Majitel torrentu se rozhodl e bude viditelnı pouze oprávnìnım uivatelùm.<br />Prosím poskytnìte heslo nyní aby ste získali bezprostøední pøístup k torrentu.");
define("_btpasswordwrong","Varování: Špatné heslo.<br />Pamatujte e hesla jsou case-sensitive.");
define("_btuploadedpassexplain","Nastavili jste heslo na: <b>**pass**</b>");
define("_btuploadedpassexplain2","Aby uivatelé mohli pøistupovat k vašemu torrentu, rozšiøte mezi nì následující pøímı odkaz: <b>**url**<b>");
define("_btcompletedby","Dokonèeno uivatelem");
define("_bttrackers","Další Trackery");
define("_bttrackergroup","Skupina *");
define("_btexport","Export");
define("_btexportexplain","Stáhnout tento Torrent bez vašeho Passkey, pro distribuci na stránkách které poskytují BitTorrent index services");

//TESTI PRESENTI IN TAKEUPLOADURL.PHP
define("_btinseriti","Vloeno");
define("_btand","a");
define("_btnumerror","jejich èíslo se nerovná a tak není moné pokraèovat s binárním pøiøazením");
define("_btmaxchar","ED2K URL mají maximum 200 znakù");
define("_bted2kstart","URL by mìla zaèínat <b>ed2k://</b>");
define("_bt2par","URL schází druhı parametr: ");
define("_bturlfile","soubor");
define("_bturlcontent","URL neobsahuje");
define("_btfname","jméno souboru");
define("_bturlsize","URL neobsahuje");
define("_btsz","velikost");
define("_btidcode","hash info");
define("_bturlparerror","URL neobsahuje parametr:");
define("_bturlsureerror","URL obsahuje ilegální zdroj");
define("_bturlnotinsert","Musíte vloit ED2K Link");
define("_btnotip","IP nespecifikována");
define("_btinvip","Neplatná IP");
define("_btnoport","Nespecifikován port");
define("_btinvport","Neplatnı Port");
define("_btparmag","ádnı");
define("_btnopresent","není pøítomnı");
define("_btmagchar","MagnetURL mají maximum 200 znakù");
define("_bftminlimit","Nemùete sdílet soubory menší ne");
define("_btfmaxlimit","Váš torrent obsahuje soubor, kterı je pøíliš velkı.");
define("_btillegalword","Klíèová slova názvu souboru naznaèují ilegální aktivitu spojenou s tímto uploadem.");
define("_btillegalwordinfo","Náš portál pouívá filtr klíèovıch slov k zabránìní ilegálních uploadù. Víme, e i kdy váš upload obsahuje slova, která mùou aktivovat filtr, mùe bıt poøád naprosto legální. Prosím pøijmìte naše omluvy a zkuste upload s jinım jménem souboru.");
define("_bturlinserted1","Torrent nauploadován. Budete pøesmìrováni bìhem 3 sekund.<BR>Pokud vás váš prohlíec nepøesmìruje, kliknìte ");
define("_bturlinserted2","na tento odkaz");
define("_btaddnotifycomment","Byl jste pøidán do listu notifikací: obdríte e-mail o novıch komentáøích.");
define("_btaddnotifyseeder","Byl jste pøidán do listu notifikací: obdríte e-mail o novıch seedrech.");
define("_btnolinkinsert","Nevloen ádnı odkaz");
define("_btexnostartwt","eXeem odkazy zaèínají exeem://");
define("_btinvalidexeem","Neplatnı eXeem odkaz!");
define("_btillegalcat","Ilegální kategorie!");
define("_bttorrentpresent","Torrent, kterı se snaíte uploadovat u byl nauploadován na tuto stránku, nebo byl zakázán.");
define("_btdescrrequired","Pole popisu je prázdné. Prosím vrate se a doplòte popis.");

//TESTI PRESENTI IN UPLOAD.PHP
define("_btuploadatorrent","Uploadovat Torrent");
define("_btphotoext","Soubor obrázku musí bıt GIF, JPG nebo PNG");
define("_btalertmsg","Formuláø nebyl odeslán kvùli následujícím chybám:");
define("_btalertmsg2","Prosím opravte chyby a zkuste upload znovu");
define("_btfnotselected","ERROR: nebyl vybrán soubor");
define("_btalertdesc","Prosím zadejte popis, kterı udává typ souboru a kvalitu, zvláš v pøípadu soborù médií");
define("_btalertcat","Zvolte kategorii");
define("_btconferma","Pøipraveni na upload? Pokud torrent obsahuje více souborù, prosím vytvoøte ho znovu jako multiarchiv obsahující celı adresáø. Jinak by mohl bıt nepouitelnı.");
define("_btalerturl","Vlote MAGNET nebo ED2K link (odkaz)");
define("_btalerturlnum1","Èíslo ED2K odkazu ");
define("_btalerturlnum2","zatímco èíslo MAGNET odkazu je");
define("_btalerturlnum3","Èíslo odkazù musí bıt stejné -- torrenty se skládají z párù odkazù");
define("_btalert5char","Název souboru musí mít alespoò 5 znakù");
define("_btofficialurl","Official tracker této stránky je: ");
define("_btseeded","Prosím uploadujte pouze torrenty, které jsou seedovány. Torrenty bez peerù se nezobrazí na hlavní stránce.");
define("_btupfile","Uploadovat soubor:");
define("_btupnfo","Uploadovat NFO soubor:");
define("_bttorrentname","Jméno Torrentu");
define("_btfromtorrent","Bude generováno z jména souboru pokud bude ponecháno prázdné. ");
define("_btdescname","Zkuste dát popisné jméno");
define("_btsrc_url","Zdrojová URL");
define("_btcompulsory"," (Povinné)");
define("_btdescription","Popis (vyadován)");
define("_btnohtml","ÁDNÉ HTML");
define("_btchooseone","Zvolte");
define("_bttype","Typ");
define("_btverduplicate","Kontrolovat pro podobné torrenty");
define("_btduplicatinfo","Zabraòuje uploadování torrentù podobnım tìm, které u jsou v seznamu. Odškrtnìte pokud i pøesto chcete uploadovat. Pamatujte e duplikátní torrenty pro stejné soubory sniují celkovou efektivitu.");
define("_btupevidence","Stálı");
define("_btupevidencinfo","Oznaèit torrent jako Stálı aby se drel na vrchu v seznamu. Vyhrazeno pro moderátory/adminy");
define("_btowner","Zobrazit Jméno");
define("_btowner1","Ukázat Uivatele");
define("_btowner2","Dùvìrnı Mód");
define("_btowner3","Neviditelnı Mód");
define("_btownerinfo","'UKÁZAT UIVATELE' umoní ostatním uivatelùm vidìt vaše uivatelské jméno, 'DÙVÌRNİ MÓD' ho schová, ponechá editovací/mazací práva, 'NEVIDITELNİ MÓD' (pokud dostupnı) kompletnì schová vlastníka systému, a nepovoluje ádné editace/mazání uivatelem.");
define("_btupnotify","Notifikace");
define("_btupnotifynfo","Obdret e-mailovou-notifikaci pøi pøidání komentáøe");
define("_btupnotifyseed","Obdret e-mailovou-notifikaci jakmile leecher dokonèí soubor (pouze torrenty na lokálním trackeru)");
define("_btfsend","Potvrdit");
define("_btinserte2k","Vloit ED2K Odkaz");
define("_btmagnetinsert","Vloit Magnet Odkaz");
define("_btinsertlinktitle","Vloit odkazy pro sítì GNutella a eDonkey2000");
define("_btinsertlinktext","Mùete pøidat odkazy eDonkey2000 k vašemu torrentu, pro zvıšení dostupnosti.");
define("_btinserttext2","Mùete vloit buï jen MAGNET odkazy nebo jen ED2K odkazy. Pokud jsou oba vyplnìny, dva odkazy budou asociovány ke kadému souboru: jinımi slovy první ED2K odkaz a první MAGNET odkaz bude asociován na první soubor, a tak dále...");
define("_bted2kurl","Vloit ED2K odkaz");
define("_btsyntax","Jako");
define("_btfiletype","pøípona");
define("_btfilesize","velikost");
define("_btidcode","infohash");
define("_btipport","ip:port");
define("_btstatic","ukazuje e pouíváme pouze protokol eDonkey2000");
define("_btfinalname","je jméno souboru ke staení");
define("_btfinalsize","je velikost bytu souboru");
define("_btfinalidcode","je speciální ovìøovací kód, kterı umoòuje najít POUZE JEDEN SOUBOR, a jeho kopie, mezi mnohımi podobnımi");
define("_btfinalipport","reprezentuje hlavní stabilní zdroj (pouívanı vydavateli)");
define("_btor","nebo");
define("_btaddmagnet","Magnet odkaz");
define("_btadded2k","eD2K odkaz");
define("_btphoto","Obrázek");
define("_btexeemlink","eXeem odkaz");
define("_btexeemlinkexplain","Volitelné. Pokud torrent mùe bıt stáhnut skrz sí eXeem, mùete vloit alternativní odkaz sem");
define("_bttorrentpasswordexplain","Mùete zvolit heslo k ochranì vašeho Torrentu od nepovolenıch pøístupù. Pokud je heslo nastaveno, Torrent nebude
viditelnı nikomu kromì Premiovıch Uivatelù a Administrátorù v Torrent Listu a Hledání Torrentù. Budete muset poskytnout pøímı odkaz lidem, kterım chcete dát pøístup k Torrentu.
Pouze Interní Torrenty mùou bıt Chránìny Heslem.");
define("_btupadvopts","Rozšíøené Monosti");
define("_btadvoptsexplain","Ukázat rozšíøené monosti, ovládající nìkteré technické aspekty torrentu. Pouijte tyto monosti pouze pokud víte co dìláte!");
define("_btleaveintact","Nemìnit toto nastavení");
define("_btdhtsupport","Podpora DHT");
define("_btendht","Vynutit záloní DHT");
define("_btdisdht","Vypnout DHT");
define("_btdhtsupportexplain","Toto vynutí záloní DHT na vašem torrentu, nebo ho vypne. DHT je uiteèné pokud má hlavní tracker vıpadek nebo je pøetíenı");
define("_btprivatetorrent","Soukromı Torrent");
define("_btenpvt","Oznaèit torrent jako soukromı");
define("_btdispvt","Oznaèit torrent jako veøejnı");
define("_btprivatetorrentexplain","\"soukromı\"-monost (kterou zvládnou jen nìkteøí klienti), øíká klientovi aby pracoval pouze s peery, které obdrí od centrálního trackeru. Zapnutí monosti Soukromé vypne DHT");

//UPLOAD-LINK
define("_btuploadalinkarchive","Uploadovat eD2K/Magnet odkaz");
define("_btsharelink","Uploadovat pouze pokud je soubor sdílen.");
define("_btlinknotice","Odkaz NEBUDE pøijat pokud více ne pùlka souborù, které posílate u je pøítomna v indexu. Duplikáty sniují celkovou efektivitu");
define("_btarchivename","Jméno");
define("_btlinks","Odkazy na soubor");
define("_btinsert1file","Vlote odkaz(y) pro váš soubor, a stisknìte 'Pøidat Soubor'. eD2K odkaz je povinnı. Mùete pøidat víc jak jeden soubor k vašemu pøíspìvku.");
define("_btlinksnomatch","Odkazy, které jste zadal nereprezentují stejnı soubor");
define("_btinvalided2k","Neplatnı eD2K odkaz");
define("_btinvalidmagnet","Neplatnı Magnet odkaz");
define("_btaddnewfile","Pøidat Soubor");
define("_btaddtoarchive","Pøidat Soubor");
define("_btaddmd5","MD5 Hash");
define("_btlinks","Odkazy");
define("_bterrduplicatelinks","Duplikované soubory nejsou povoleny");
define("_btduplicatelinks","Duplikovanı Soubor");
define("_btduplicateexplain","Soubor reprezentovanı odkazem vámi poslanım je u sdílen na této stránce. Kliknìte na symbol varování vedle souboru ke zkontrolování torrentu/kolekce v které byl nalezen. Pokud je více ne 50% odkazù vámi pøidanıch u pøítomno, váš pøíspìvìk nebude pøijat");
define("_btinsertfilesfirst","Musíte poslat alespoò jeden soubor pouitím pøíslušného tlaèítka");
define("_btfilelistaltered","Seznam souborù byl zmìnìn! Nebyl vytvoøen za uití tohoto nástroje.");

//INTERNAL TRACKER
define("_btuserip","Uivatelské jméné/IP");
define("_btport","Port");
define("_btdownloadedbts","Staeno");
define("_btuploadedbts","Uploadováno");
define("_btratio","Pomìr");
define("_btpercent","Kompletní Zdroje");
define("_btconnected","Pøipojeno");
define("_btidle","Neaktivní");
define("_btconn","Pøipojení");
define("_btactive","Aktivní");
define("_btpassive","Pasivní");
define("_btpeerspeed","Prùm. Rychlost");
define("_btnopeer","ádní peeøi");

//Scrape external torrents

define("_admtrackers","Externí Trackery");
define("_admtrackerurl","Oznamovací URL");
define("_admtrkstatus","Status");
define("_admtrkstatusactive","Aktivní");
define("_admtrkstatusdead","Offline");
define("_admtrklastupdate","Aktualizován");
define("_admtrkscraping","Aktualizuji");
define("_admtrkassociatedtorrents","Torrenty");
define("_admtrkscraping","Aktualizuji Tracker...");
define("_admtrkcannotopen","Nemohu kontaktovat URL Adresu. Tracker bude nastaven jako Offline");
define("_admtrkrawdata","Tracker dosaen. Zde je kódovaná odpovìï");
define("_admtrkinvalidbencode","Nemùu dekódovat odpovìï Trackeru. Neplatné kódování");
define("_admtrkdata","Dekódování dokonèeno. Zde jsou obdrená Scrape data");
define("_admtrksummarystr","Nalezeno <b>**seed**</b> seederù, <b>**leechers**</b> leecherù, <b>**completed**</b> dokonèenıch downloadù pro Torrent **name** Info Hash **hash**.");


//TESTI CHE COMPAIONO IN COMMENT.PHP
define("_btiderror","Neplatné ID");
define("_btnotfoundid","Torrent neexistuje");
define("_btaddcomment","Pøidat komentáø k");
define("_btaddtime","Upload ");
define("_btby","od");
define("_btsend","Pøijmout");
define("_btnotyourcomment","Nemùete mìnit komentáøe jinıch lidí.");
define("_btcommentinserted","Váš komentáø byl vloen. Budete pøesmìrování na stránku s detaily torrentu bìhem 3 sekund.<br>Kliknìte <a href=\"details.php?id=**id**#comments\">ZDE</a> pokud vás prohlíeè nepøesmìruje.");
define("_btcommentdeleted","Komentáø smazán. Budete pøesmìrování na stránku s detaily torrentu bìhem 3 sekund.<br>Kliknìte <a href=\"details.php?id=**id**#comments\">ZDE</a> pokud vás prohlíeè nepøesmìruje.");

//TESTI CHE COMPAIONO IN DOWNLOAD.PHP
define("_bttorrentunavailable","Torrent není dostupnı kvùli chybì v konfiguraci serveru. Omlouváme se za nepøíjemnosti.");
define("_btminseedrule","Musíte seedovat minimálnì **min** torrentù aby ste mohl stahovat.");
define("_btmaxdailydownloads","Nemùete stáhnout více ne **max** souborù dennì. Prosím zkuste to znovu zítra.");
define("_btmaxweeklydownloads","Nemùete stáhnout více ne **max** souborù tıdnì. Prosím zkuste to znovu pøíští tıden.");
define("_bterrtoosmall","<li>Musíte seedovat soubor alespoò <b>**min_share**</b> velikı.<br>");
define("_bterrtoobig","<b>Nejvìtší soubor, kterı seedujete je ");
define("_bterrorprivate","Toto je soukromı soubor: ji jste ádal o povolení stáhnout. Nemùete stáhnout soubor dokud vlastník nepøijme vaši ádost.");
define("_btrefused","Vlastník zamítl vaši ádost. Nebudete si moci stáhnout tento torrent.");
define("_bterrblacklist","Vlastník vám zakázal stáhnout si jeho torrenty. Nebudete moci si stáhnout jakıkoli z nich.");
define("_btreqsent","Tento Torrent je soukromı. Nebudete si ho moci stáhnout dokud vám vlastník nedá povolení.
ádost byla poslána vlastníkovi torrentur, kterı musí povolit váš download: vısledek vám bude oznámen e-mailem.");

//TESTI CHE COMPAIONO IN EDIT.PHP
define("_btedittorrent","Zmìnit Torrent");
define("_bterreditnoowner","<h1>Pøístup Zamítnut</h1>\n<p>Jen vlastník torrentu a administrátoøi mohou mìnit torrenty</p>\n");
define("_btbanned","Zakázáno");
define("_btcancel","Zrušit");
define("_btdelcommand","Needitovat torrent, ale <input type=\"submit\" value=\"SMAZAT HO!\" />\n");
define("_btsure","Ano: Jsem si tím jistı!");
define("_btban","Zakázat Torrent");
define("_btareyousure","Jste si jistı e chcete smazat <b>**name**</b>?");
define("_btareyousure_ban","Jste si jistı e chcete zakázat <b>**name**</b>?");
define("_bttorrentnoexist","Tento torrent neexistuje");
define("_btdelete","Smazat torrent");
define("_btcannotdel","Nemohu smazat");
define("_btmissingdata","Poadovaná data chybí!");
define("_btdeldenied","Jen vlastník torrentu nebo administrátoøi mohou mazat tento torrent");
define("_btnotconfirmed","Musíte potvrdit e si jste jistı co se chystáte udìlat.");
define("_btdeleted","Torrent smazán");
define("_btgoback","Vrátit se zpìt");
define("_btsuccessfullyedited","Torrent úspìšnì zmìnìn. Budete pøesmìrováni na stránku s detaily torrentu. Zapamatujte si e pokud jste zvolili Neviditelnı Mód, nebudete u moci mìnit nebo mazat torrent!");

//TESTI CHE COMPAIONO IN MYTORRENTS.PHP
define("_btmytorrentsintrotitle","Kontrolní Panel Torrentù");
define("_btmytorrentsintrotext","V této oblasti mùete spravovat vaše nauploadované torrenty (kromì tìch se zvolenım Neviditelnım Módem).<br>
Take mùete spravovat ádosti ostatních uivatelù na stáhnutí. Vybráním správné ikony, mùete vidìt všechny ádosti ostatních uivatelù
poslanıch vám. Budete se muset rozhodnout jestli pøijmout nebo odmítnout ádost ke staení.<br>
Dávejte pozor na velikost uploadu a downloadu uivatele. Lidé, kteøí stahují a nesdílejí nejsou ádnım pøínosem pro
Sí BitTorrent. Odmítnutí jejich ádostí ke staení mùe bıt pøimìøená cesta povzbudit je sdílet více.");
define("_btmytorrents","Mé Torrenty");
define("_btallauthorized","Všichni uivatelé byli autorizováni");
define("_btauths","ádosti o staení");
define("_btauthorized","Zvolení uivatelé byli autorizováni");
define("_bthasauthorized","Vlastník vás autorizoval stáhnout si jeho soubory");
define("_btnowcandownload","Mùete nyní volnì stahovat všechny uivatelovi soubory.\nOchraòujeme vaše soukromí.");
define("_pendingauths","Nerozhodnuté Autorizace: ");
define("_btauthorizationrequested","Následující uivatelé poádali o autorizaci ke staení:");
define("_btnotorrents","Nejsou ádné torrenty");
define("_btnotorrentuploaded","Nenauploadoval jste ještì ádné torrenty");
define("_btactions","Akce");
define("_bthasuploaded","Uploadováno: **");
define("_bthasdownloaded","Staeno: **");
define("_btauthgrant","Autorizovat");
define("_btauthalwaysgrant","Vdy Autorizovat");
define("_btauthalwaysdeny","Nikdy Neautorizovat");
define("_btauthdeny","Neautorizovat");
define("_btcantseeothertorrents","Nemùete prohlíet povolení u torrentù ostatních uivatelù!");
define("_btauthpanel","Kontolní Panel Autorizací Staení");
define("_btnoauthstomanage","Nejsou autorizace ke spravování");
define("_btmyglobals","Mé Globální Autorizace");
define("_btnoglobals","Zatím nejsou ádné Globlní Autorizace");
define("_btstatus","Status");
define("_btauthreset","Reset");
define("_btwronginput","Error pøi zadávání dat");
define("_btgeneraloptions","Hlavní Monosti");
define("_btprivate","Soukromé");
define("_btprivateexpl","Oznaète tuto monost pro uivatele k vyádání authorizace k pøístupu ke staení tohoto Torrentu. Budete upozornìni na kadou nerozhodnutou authorizace emailem.
Budete moci vybrat jestli povolit nebo zamítnout authorizaci pro tento jeden torrent nebo pro všechny vaše torrenty");
define("_btminratio","Minimální Pomìr");
define("_btdisabled","Zakázáno");
define("_btminratioexpl","Mùete nastavit minimální hodnotu pomìru pro auto-autorizování uivatelù. Uivatelé s pomìrem vìtším nebo stejnım jako je nastavenı budou moci stáhnout bez vyadování autorizace.
Hodnota minimálního pomìru nebude zobrazena nikomu, pouze s vıjimkou Administratorù");

//TESTI CHE COMPAIONO IN TAKECOMMENT.PHP
define("_btcommentkeyfound","Systém zkontroloval váš komentáø. Následující slova nejsou povolena:<ol>");
define("_btcommentkeyfound2","</ol><p>Víme e komentáø mùe bıt i tak v poøádku, omlouváme se za potíe a ádáme vás o pouití jinıch slov.</p>");
define("_btcommentinserted","Komentáø úspìšnì vloen, budete pøesmìrován na stránku s detaily torrentu bìhem 3 sekund...<br>Kliknìte <a href=\"details.php?id=**id**#comm**newid**\">SEM</a> pokud vás váš prohlíec nepøesmìruje.");

//TESTI CHE COMPAIONO IN TAKEEDIT.PHP
define("_btmissingformdata","Chybìjící vstupní data!");
define("_bteditfailed","Úprava selhala");
define("_bteditdenied","Nemùete upravovat torrenty ostatních lidí.");
define("_btreturl","Soubor úspìšnì zmìnìn, budete pøesmìrován na stránku s detaily torrentu bìhem 3 sekund...<br>Kliknìte <a href=\"**returl**\">SEM</a> pokud vás váš prohlíec nepøesmìruje.");

//TESTI CHE COMPAIONO IN RATE.PHP
define("_btrate","Hodnocení Torrentu");
define("_btratefailed","Hlasování selhalo!");
define("_btinvalidrating","Neplatnı hlas");
define("_btidnotorrent","Neplatné ID. Torrent neexistuje");
define("_btnovoteowntorrent","Nmùete hodnotit vlastní torrenty");
define("_btalreadyrated","Torrent u byl hodnocen");
define("_btcantvotetwice","Je nám líto, ale nemùete hodnotit torrent dvakrát");
define("_btvotedone","Hlasování úspìšné, budete pøesmìrován na stránku s detaily torrentu bìhem 3 sekund.<br>Kliknìte <a href=\"details.php?id=**id**\">SEM</a> pokud vás váš prohlíec nepøesmìruje.");

//TESTI CHE COMPAIONO IN TAKEUPLOAD.PHP
define("_btuploaderror","Upload selhal!");
define("_btemptyfname","Prázdné jméno souboru");
define("_btinvalidfname","Neplatné jméno souboru");
define("_btinvalidnfofname","Neplatnı NFO soubor");
define("_btfnamenonfo","Toto není NFO soubor (.nfo)");
define("_btfnamenotorrent","Toto není soubor torrentu (.torrent)");
define("_btferror","Error Souboru");
define("_bterrnofileupload","Kritickı error v uploadovaném souboru.");
define("_bterrnonfoupload","Kritickı error v uploadovaném NFO souboru.");
define("_btemptyfile","Prázdnı soubor");
define("_btnobenc","Soubor poškozen. Jste si opravdu jist e to je soubor torrentu?");
define("_btnodictionary","Slovník Torrentu chybí");
define("_btdictionarymisskey","Chybejí Klíèe Slovníku Torrentu");
define("_btdictionaryinventry","Neplatná data uvnitø Slovníku Torrentu");
define("_btdictionaryinvetype","Neplatné datové typy ve Slovníku Torrentu");
define("_btinvannounce","Neplatná Announce URL. Musí bıt ");
define("_btactualannounce","Specifikovanı tracker ");
define("_bttrackerdisabled","Náš tracker byl vypnut: pouze externí torrenty mohou bıt uploadovány.");
define("_btinvpieces","Neplatné èásti torrentu");
define("_btmissinglength","Chybí soubory a velikost");
define("_btnofilesintorrent","Chybí soubory Torrentu");
define("_btfnamerror","Neplatné jméno souboru");
define("_btinvalidhtml","Neplatnı HTML Kód. Ujistìte se e jste pouili náš editor místo ruèního zadávání kódu.");
define("_bttrackerblacklisted","Tracker pouívanı tímto torrentem (<b>**trk**</b>) byl zakázán. Prosím pouijte jinı tracker.");
define("_btfilenamerror","Error v názvu souboru");
define("_bttorrenttoosmall","<p>Nemùete sdílet soubor menší ne <b>");
define("_bttorrenttoosmall2","</b></p><p>Váš torrent obsahuje soubor s následující velikostí: <b>");
define("_btmaxuploadexceeded","Nemùete uploadovat více ne **maxupload** bìhem 24 hodin.");
define("_btnumfileexceeded","<p>Nemùete uploadovat více ne <b>**maxupload**</b> souborù bìhem 24 hodin.</p><p>U jste uploadoval <b>**rownum**</b> souborù, o celkové velikosti <b>**totsize**</b>");
define("_btsearchdupl","Podle hledání, tyto soubory mohou odpovídat tìm co sdílíte:<ol>");
define("_btduplinfo","<p>Pokud je váš soubor v tomto seznamu, prosím seedujte jeden z tìchto torrentù!</p>");
define("_btsocktout","ERROR: Socketu vypršel èas");
define("_bttrackernotresponding","Tracker neodpovídá.\n Ovìøte hláskování trackeru (ÁDNÉ PRÁZDNÉ MÍSTA UVNITØ URL) a e tracker bìí a funguje. Tracker vámi specifikovanı je:");
define("_bttrackerdata","Neplatná data z externího trackeru. Tracker mùe mít potíe se serverem. Prosím zkuste to pozdìji znovu.");
define("_bttorrentnotregistered","Torrent se nezdá bıt registrován na externím trackeru. Mùete uploadovat externí torrenty pouze pokud jsou aktivní.");
define("_btuploadcomplete","Úspìšnì nauploadováno. Budete pøesmìrován na stránku s detaily torrentu bìhem 3 sekund. Nezapomeòte seedovat, jinak nebude torrent viditelnı na hlavní stránce.<br>Kliknìte <a href=\"**url**\">SEM</a> pokud vás váš prohlíeè nepøesmìruje.");
define("_btpresent","Tento torrent u byl nauploadován");
define("_btscrapeerror","Nemùu získat data o peerech z trackeru");

//TESTI CHE COMPAIONO IN TAKECOMPLAINT.PHP
define("_btcomplisnowbanned","Tento Torrent byl zakázán kvùli mnoství stíností");
define("_btcomplcantvotetwice","Je nám líto, ale nemùete poslat stínost dvakrát.");
define("_btcomplainttaken","Stínost zaregistrována. Budete pøesmìrován na stránku s detaily torrentu bìhem 3 sekund. Pokud vás váš prohlíeè nepøesmìruje, kliknìte ");
define("_btcomplsuccess","Vaše stínost byla zaregistrována. Uivatelské jméno a IP jsou zaznamenány: prosím nezneuívejte systém.<BR>");

//SHOUTBOX
define("_btshoutbox","Shoutbox");
define("_btnoshouts","Nikdo nekøièí...");
define("_btshoutnow","Vykøiknout!");

//Donations Block
define("_btdonations","Pøíspìvky");
define("_btdonationsgoal","Cíl:");
define("_btdonationscollected","Shromádìno:");
define("_btdonationsprogress","Vıvoj Pøíspìvkù");
define("_btdonationsdonate","PØISPÌT");

//IMAGE ALTERNATES
define("_btalt_banned","Zakázanı torrent");
define("_btalt_auth_none","ádné nevyøízené Autorizace");
define("_btalt_auth_pending","Nevyøízené Autorizace!");
define("_btalt_sticky","Stálı torrent");
define("_btalt_download","Stáhnout");
define("_btalt_edit","Zmìnit");
define("_btalt_drop","Smazat");
define("_btalt_scrape","Zkontrolovat Data Peerù");
define("_btalt_duplicate","Duplikovat soubor");
define("_btalt_exeem","Stáhnout pomocí eXeemu");
define("_btalt_error.gif","Error");
define("_btalt_icon_admin","Administrátor");
define("_btalt_icon_moderator","Moderátor");
define("_btalt_icon_premium.gif","Premovı Uivatel");
define("_btalt_1.gif","OPRAVDU Špatnı");
define("_btalt_1.5.gif","Velmi Špatnı");
define("_btalt_2.gif","Špatná");
define("_btalt_2.5.gif","Slabı");
define("_btalt_3.gif","Prùmìrnı");
define("_btalt_3.5.gif","Lepší ne Prùmìrnı");
define("_btalt_4.gif","Dobrı");
define("_btalt_4.5.gif","Velmi Dobrı");
define("_btalt_5.gif","Vynikající");
define("_btalt_anon_tracker.gif","Animace Trackeru");
define("_btalt_button_aim.gif","AOL Instant Messenger");
define("_btalt_button_icq.gif","ICQ");
define("_btalt_button_irc.gif","IRC");
define("_btalt_button_msn.gif","MSN Messenger");
define("_btalt_button_yahoo.gif","Yahoo! Messenger");
define("_btalt_ed2k_active.gif","Stáhnout pomocí eD2K URI");
define("_btalt_ed2k_inactive.gif","eD2K odkaz Nedostupnı");
define("_btalt_magnet","Stáhnout pomocí Magnet URI");
define("_btalt_magnet_inactive.gif","Alternativní odkaz Nedostupnı");
define("_btalt_green.gif","Rychlı");
define("_btalt_yellow.gif","Pomalı");
define("_btalt_red.gif","Zastaveno");
define("_btalt_quest.gif","Data o Peerech neznámá");
define("_btalt_lock","Nevyøízená Autorizace");
define("_btalt_lock_request","Poádat o Autorizaci");
define("_btalt_noavatar.gif","ádnı Avatar");
define("_btalt_icon_active.gif","Aktivní");
define("_btalt_icon_passive.gif","Pasivní");
define("_btalt_external","Externí Tracker");

define("_btunknownclient","Neznámı Klient");
define("_btalt_avatar","Avatar pro **user**");

//STATISTICS
define("_btstats","Statistiky");

//PRIVATE MESSAGES
define("_btyougotpm","Máte nové/nepøeètené zprávy!");
define("_btpmintro","Zde si mùete pøeèíst soukromé zprávy od ostatních uivatelù. Není maximální sladovací limit.
Nicménì vám doporuèujeme pravidelnì mazat staré zprávy. Mùete posílat zprávy všem registrovanım uivatelùm.");
define("_btinbox","Schránka");
define("_btpmnomessages","ádné zprávy");
define("_btpmsub","Pøedmìt");
define("_btpmfrom","Od");
define("_btpmdate","Datum");
define("_btplmselect","Oznaèit");
define("_btpmread","Pøeètené");
define("_btpmunread","Nepøeètené");
define("_btpmnewmsg","Nová zpráva");
define("_btpmdelete","Smazat zprávy");
define("_btpmdelall","Smazat všechny zprávy");
define("_btpmdelconfirm","Jste si jistı e chcete smazat všechny oznaèené zprávy?");
define("_btpmdelbtn","Smazat zprávy");
define("_btpmdelallconfirm","Jste si jistı e chcete smazat <b>všechny</b> vaše soukromé zprávy?");
define("_btpmdeletedsuccessfully","Zprávy úspìšnì smazány");
define("_btnewpm","Nová zpráva");
define("_btpmto","Pøíjemce");
define("_btpmtotip","Pokud chcete poslat stejnou zprávu více uivatelùm, oddìlte je pomocí støedníku (;)");
define("_btpmshowbookmarks","Ukázat/Schovat seznam kontaktù");
define("_btpmtext","Text zprávy");
define("_btpmnorecipient","Musíte specifikovat pøíjemce");
define("_btpmnosubject","Musíte specifikovat pøedmìt");
define("_btpmnomessage","Prázdná zpráva");
define("_btpminvalidrecipients","Jeden nebo více pøíjemcù, které jste uvedl, neexistují");
define("_btpmsentsuccessfully","Zpráva úspìšnì poslána");
define("_btpmuserblocked","Jeden z pøíjemcù od vás nepøijímá zprávy. Napsal jste:<br><br>");
define("_btmessage","Zpráva");
define("_btinvalidpm","Neplatná zpráva");
define("_btpmnoexists","Zpráva neexistuje");
define("_btpmreply","Odpovìdìt");
define("_btuserlists","Pøátelé a ignorovaní uivatelé");
define("_btuserlistsintro","Zde mùete spravovat seznam pøátel a ignorovanıch uivatelù. Tito jsou dostupní ve vašem seznamu kontaktù pro rychlı pøístup pøi posílání zprávy.
Všechny zprávy od ignorovanıch uivatelù budou blokovány. Mùete zmìnit stav uivatele v jeho/jejím profilu. Uivatelé nemají informaci o stavu pøiøazeném ostatními.");
define("_btpmbookmarkuser","Pøidat do Pøátel");
define("_btpmunbookmarkuser","Odstranit z Pøátel");
define("_btpmblacklistuser","Odmítnout zprávy tohoto uivatele");
define("_btpmunblacklistuser","Neodmítat zprávy tohoto uivatele");
define("_btpmbookmarks","Pøátelé");
define("_btpmblacklist","Ignorovaní uivatelé");

//OVERLIB HELP
#NO LINE-BREAKS!!!!
define("_btperformance","Vıkon");
define("_btdht","Podpora DHT");
define("_bttorrentspd","Celková Rychlost:");
define("_btleechspd","Odhadovaná Rychlost: ");
define("_btedt","Odhadovanı Èas Staení: ");
define("_btinfohashhelp","Info Hash je krátkı, unikátní kód indentifikující torrent.<br>");
define("_btdhtexplanation","Tento torrent podporuje DHT. S klientem schopnım tohoto vyuít, budete schopni stáhnout tento torrent i kdy centrální tracker bude mít vıpadek.");
define("_btavatarnotice","Uploadovaní avataøi musí bıt ve formátu GIF, JPEG nebo PNG, doporuèená velikost 100x100 a nemùe bıt vìtší ne 300KB");
define("_btcustomsearch","RSS/RDF zdroj pro vlastní vyhledávání");
define("_btcustomsearchexplain","Podepište se k tomuto RSS/RDF zdroji aby jste byl aktualizován o uploadech odpovídajícím vaším termínùm");

// Rules
define("_btrules","Pravidla");
define("_brrulesadmin","Admin-Pravidla");
define("_btrulesmod","Moderátor-Pravidla");
define("_btrulesprem","Premium-Pravidla");
define("_btrulesuser","Uivatel-Pravidla");
define("_btrulesgen","Obecná-Pravidla");
define("_btrulesadd","Pøidat Sekci Nová Pravidla");
define("_btrulesaddsect","Pøidat Sekci Pravidlo");
define("_btnamelevel","Uivatelskı Level pro toto pravidlo");
define("_bttitle","Titulek Sekce");
define("_btlevel","Level");
define("_btrulesedit","Zmìnit Pravidla");
define("_btmodrulesadd","Pøidat Sekci Pravidel");
define("__btmodrulesno","Ne");
define("_btmodrulesyes","Ano");
define("_btmodrulespublic","Veøejnı");
//massmail
define("_btmmbody","Tìlo");
define("_btmmsendto","Poslat hromadnı e-mail oznaèenım èlenùm levelu");
define("_btmmlinks","Mùete pouívat odkazy ve Vašich emailech");

?>
