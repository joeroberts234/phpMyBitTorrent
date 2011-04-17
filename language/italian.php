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


if (eregi("italian.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

define("_LOCALE","it-IT");
//Donations Block
define("_btdonations","Donations");
define("_btdonationsgoal","Goal:");
define("_btdonationscollected","Collected:");
define("_btdonationsprogress","Donation Progress");
define("_btdonationsdonate","DONATE");

//WELCOME MESSAGE :-D
define("_btstart","<p><b>Benvenuto in Bit Torrent!</b></p>
<p>Grazie alla tecnologia Bit Torrent, condividere i file con le persone di
tutto il mondo non &egrave; stato mai cos&igrave; semplice! Bastano pochi minuti per
condividere e scaricare ad altissima velocit&agrave; i file che pi&ugrave; ti piacciono! Su
questo sito puoi tranquillamente condividere i tuoi file utilizzando il nostro
tracker, o puoi caricare Torrent ospitati su altri tracker per aumentare la loro
visibilit&agrave;. E inoltre, sei tu a decidere quali Torrent condividere con chi!
Rispettiamo la tua privacy, il tuo diritto pi&ugrave; importante dopo la vita!</p>");

//NewTorrent shout
define("_btuplshout","Hi, I have just uploaded <b>**name**</b>. Enjoy it!");
define("_btnewtsh","Shout out New Torrent");
define("_btnewshex","Check Here if you would like to add a shout in the shout box about your new uploade if not then leave it unchecked!");


//COMPLAINTS
function getcomplaints() {
        return Array(0=>"File di buona qualit&agrave; e legale",1=>"File falso o illegibile",2=>"File protetto da copyright",3=>"File pornografico",4=>"File pedofilo",5=>"File offensivo",6=>"File legato ad attivit&agrave; terroristiche");
}

//CLASSI
define("_btclassuser","Utente");
define("_btclasspremium","Utente Premium");
define("_btclassmoderator","Moderatore");
define("_btclassadmin","Amministratore");

//ACCESSO NEGATO
define("_btaccdenied","Accesso Negato");
define("_btdenuser","Stai provando ad accedere ad un'area riservata agli <b>utenti registrati</b>.<br>Per favore fornisci le necessarie credenziali e tenta
nuovamente l'accesso. In alternativa puoi effettuare la <a href=\"user.php?op=signup\">Registrazione</a> gratuita.");
define("_btdenpremium","Stai provando ad accedere ad un'area riservata agli <b>utenti Premium</b>.<br>");
define("_btdenpremium1","Per favore fornisci le oppurtune credenziali e riprova. Se non disponi di un account Premium, contatta lo staff per ottenere
maggiori informazioni sull'iscrizione Premium.");
define("_btdenpremium2","Il tuo account non &egrave; abilitato ai servizi Premium. Esegui il login con nuove credenziali o contatta lo staff per ottenere maggiori
informazioni sulll'iscrizione Premium");
define("_btdenadmin","Stai provando ad accedere ad un'area riservata agli <b>Amministratori</b>.<br>");
define("_btdenadmin1","Se disponi di un accesso Amministrativo fornisci adesso le tue credenziali, altrimenti ti invitiamo a lasciare questa pagina e tornare
alla <a href=\"index.php\">Home</a> del portale.");
define("_btdenadmin2","Il tuo account non ha accesso Amministrativo. Esegui il login con nuove credenziali o lascia questa pagina e torna alla
<a href=\"index.php\">Home</a> del portale.");
define("_btbannedmsg","Sei stato bannato da questo sito perch&egrave;: <b>**reason**</b>");

//GENERICI
define("_DATESTRING","%A, %d %B %Y alle %H:%M:%S %Z");
define("_btpassword","Password");
define("_btusername","Nome utente");
define("_btsecuritycode","Codice di sicurezza");
define("_btusermenu","Menu utente");
define("_btmainmenu","Menu principale");
define("_btgenerror","Errore di phpMyBitTorrent");
define("_btmenu","Menu");
define("_btumenu","Menu Utente");
define("_btsyndicate","Sottoscrivi");
define("_btlegend","Legenda");
define("_btircchat","Chat IRC");
define("_btchatnotenabled","La Chat IRC non &egrave; abilitata su questo sito.");
define("_btlostpassword","Password persa?");
define("_btpm","Messaggi privati");

//EMAIL SPELLING
define("_at"," at ");
define("_dot"," punto ");


//ERRORI SQL
define("_btsqlerror1","Errore nella Query SQL ");
define("_btsqlerror2","ID errore: ");
define("_btsqlerror3","Messaggio di errore: ");

//ERRORI HTTP
define("_http400errttl","Errore HTTP 400 - Richiesta non valida");
define("_http400errtxt","Si &egrave; verificato un errore 400 durante l'elaborazione della richiesta.<br>
Controlla le impostazioni del browser e tenta nuovamente di accedere alla pagina desiderata.<br>
In caso di problemi contatta lo staff all'indirizzo **email**");
define("_http401errttl","Errore HTTP 401 - Accesso Negato");
define("_http401errtxt","Si &egrave; verificato un errore 401 durante l'elaborazione della richiesta.<br>
Non &egrave; possibile accedere alla pagina richiesta in quanto non disponi dell'autorizzazione.<br>
Per favore, fornisci le dovute credenziali d'accesso, se ne sei in possesso.<br>
In caso di problemi contatta lo staff all'indirizzo **email**");
define("_http403errttl","Errore HTTP 401 - Non Permesso");
define("_http403errtxt","Si &egrave; verificato un errore 403 durante l'elaborazione della richiesta.<br>
Non &egrave; possibile accedere alla pagina richiesta perch&egrave; la configurazione del server non lo permette.<br>
Controlla l'indirizzo URL del browser ed eventualmente correggilo.<br>
In caso di problemi contatta lo staff all'indirizzo **email**");
define("_http404errttl","Errore HTTP 404 - Non Trovato");
define("_http404errtxt","Si &egrave; verificato un errore 404 durante l'elaborazione della richiesta.<br>
Non &egrave; possibile accedere alla pagina richiesta perch&egrave; essa non esiste.<br>
Controlla l'indirizzo URL del browser ed eventualmente correggilo.<br>
In caso di problemi contatta lo staff all'indirizzo **email**");
define("_http500errttl","Errore HTTP 500 - Errore Interno del Server");
define("_http500errtxt","Si &egrave; verificato un errore 500 durante l'elaborazione della richiesta.<br>
Si &egrave; verificato un errore durante l'elaborazione dei dati.<br>
Informazioni dettagliate sono disponibili sui log del server.<br>
Per favore invia un rapporto dettagliato sul problema all'indirizzo **email**");

//BLOCCO UTENTI
define("_btuserstats","Utenti");
define("_bttotusers","Utenti registrati:");
define("_btlastuser","Ultimo registrato:");
define("_bttorrents","Torrent scaricabili:");
define("_bttotshare","Share totale:");
define("_bttotpeers","Peers connessi:");
define("_bttotseed","Seeder totali:");
define("_bttotleech","Leecher totali:");
define("_btyoureseeding","Torrent condivisi");
define("_btyoureleeching","Torrent in download");

//TESTI CHE COMPAIONO IN USER.PHP
define("_btregwelcome","<P align=\"center\">Benvenuti in Bit Torrent</P>
<P>Registrati per entrare a far parte della nostra grande comunit&agrave;. Bastano pochi minuti e il tuo account sar&agrave; registrato su questo sito.<BR>
Potrai quindi usufruire di tutti i servizi messi a disposizione dal sito, tra cui ricerca, download e upload Torrent. Basta indicare un nome utente a scelta, il proprio
indirizzo e-mail e in tempi brevissimi riceverai il tuo codice di attivazione. La nostra speciale tecnologia antifrode previene le registrazioni fasulle mediante codice grafico.<BR>
Non esiste strumento elettronico in grado di leggere il codice. Siamo spiacenti ma utenti non vedenti sono costretti a chiedere aiuto a qualcun altro per l'inserimento del codice.
Si tratta di una precauzione.</P>");
define("_btemailaddress","Indirizzo e-mail");
define("_btpasswd","Password (minimo 5 caratteri)");
define("_btpasswd2","Conferma password");
define("_btsubmit","Invia richiesta");
define("_btreset","Annulla modifiche");
define("_btdisclaimer","Termini e Condizioni:");
define("_btdisclaccept","Accetto");
define("_btdisclrefuse","Non Accetto");
define("_btgfxcode","Codice di Sicurezza");
define("_btsignuperror","Errore durante la registrazione");
define("_bterruserexists","Il nome utente &egrave; gi&agrave; esistente");
define("_btfakemail","L'indirizzo email inserito non &egrave; valido");
define("_bterremailexists","L'indirizzo email &egrave; registrato. Vuoi recuperare il tuo account?");
define("_btpasswnotsame","Le password non sono uguali");
define("_bttooshortpass","La password &egrave; troppo corta. Lunghezza minima consentita 5 caratteri");
define("_bterrcode","Il codice di sicurezza fornito non &egrave; corretto");
define("_btdisclerror","Devi ACCETTARE il Disclaimer se vuoi registrarti al sito.");
define("_btregcomplete","La registrazione &egrave; andata a buon fine. Ricorda che hai 24 ore di tempo per confermare la tua iscrizione al sito. Se non dovessi ricevere il messaggio, ricontrolla
i dati forniti. In caso di problemi contatta il Webmaster all'indirizzo ");
define("_bterrusernamenotset","Nome utente non specificato");
define("_bterrkeynotset","Chiave di attivazione non specificata");
define("_bterrusernotexists","Il nome utente indicato non esiste");
define("_bterrinvalidactkey","La chiave di attivazione non &egrave; corretta. Controllare di averla digitata correttamente");
define("_btuseralreadyactive","L'utente &egrave; gi&agrave; stato attivato. Non &egrave; richiesta nuova attivazione");
define("_btacterror","Errore di attivazione");
define("_btactcomplete","Attivazione completata. Adesso il tuo account &egrave; definitivamente attivo. Da adesso in poi potrai accedere ai nostri servizi
utilizzando nome e utente e password forniti in fase di registrazione. Buon download");
define("_btusrpwdnotset","Nome utente o password non specificati");
define("_bterremailnotset","Indirizzo E-mail non specificato");
define("_btuserpasswrong","Nome utente o password errati!!");
define("_btuserinactive","Utente registrato ma non attivo!!");
define("_btloginsuccessful","Login effettuato correttamente. Da adesso puoi godere di tutti i privilegi da **priv**. Divertiti e buon download!");
define("_btlogoutsuccessful","Logout effettuato correttamente. Tutti i tuoi dati di sessione sono stati cancellati dal computer.");
define("_btusernoexist","Spiacenti, ma l'utente non esiste.");
define("_btuserprofile","Profilo Utente");
define("_btedituserprofile","Modifica profilo");
define("_btusertorrents","Torrent di **user**");
define("_btcompletename","Nome Completo");
define("_btclass","Classe");
define("_btclassbanned","Bannato!");
define("_btclassuser","Utente normale");
define("_btclasspremium","Utente Premium");
define("_btclassadmin","Amministratore");
define("_btregistered","Registrato");
define("_btavatar","Avatar");
define("_btcontacts","Contatti");
define("_btnewavatargallery","Nuovo Avatar dalla Galleria");
define("_btnewavatarupload","Upload nuovo Avatar");
define("_btinvalidimagefile","File immagine non valido");
define("__btavatartoobig","L'immagine supera le dimensioni consentite");
define("_btlostpasswordintro","Se hai perso la password, puoi cambiarla semplicemente inserendo il tuo nome utente e la nuova password desiderata.<br />
Ti verr&agrave; spedito un messaggio email per confermare la tua volont&agrave;. Assicurati di poter ricevere messaggi (ad es. che la casella non sia piena) prima di inoltrare la tua richiesta.");
define("_btlostpasswordcheckmail","Ti &egrave; stato spedito un messaggio al tuo indirizzo email contenente il link di conferma. Controlla la tua casella per leggerlo.");
define("_btlostpwdinvalid","Codice di conferma o ID utente non valido");
define("_btlostpwdcomplete","Password cambiata. Ora puoi effettuare il login con la nuova password.");
define("_btdeluser","Cancellazione Account");
define("_btdeluserwarning","<b>ATTENZIONE</b>: stai per cancellare completamente il tuo account. La procedura &egrave; irreversibile e comporta la perdita di possesso di tutti i Torrent. In seguito potrai registrarti nuovamente con lo stesso nome utente.");
define("_btdeluserwarningadm","<b>ATTENZIONE</b>: stai per cancellare completamente l'account di **user**. La procedura &egrave; irreversibile e l'utente perder&agrave; il possesso di tutti i suoi Torrent. In seguito potr&agrave; registrarsi nuovamente con lo stesso nome utente.");
define("_btaccountdeleted","Account cancellato");
define("_btconfirmdelete","Conferma la cancellazione dell'account");

//USER/EDITPROFILE.PHP
define("_btnewpassword","Nuova Password<br />(lascia vuoto per non cambiare)");
define("_btnewpasswordconfirm","Conferma Nuova Password");
define("_btaol","AOL Instant Messenger");
define("_bticq","ICQ");
define("_btjabber","Jabber IM");
define("_btmsn","MSN Messenger");
define("_btskype","Skype");
define("_btyim","Yahoo! Instant Messenger");
define("_btacceptmail","Accetta email dagli altri utenti");
define("_btcustomlanguage","Lingua");
define("_btcustomtheme","Tema");
define("_btdefault","Predefinito");
define("_btusepasskey","Utilizza Passkey");
define("_btpasskeyexplain","Questa opzione permette di accedere al tracker mediante un'apposita modifica ai Torrent scaricati.<br />
Non sar&agrave; pi&ugrave; necessario autenticarsi accedendo prima al tracker o utilizzando nome utente e password nei client evoluti.<br />
Un codice personale viene inserito all'interno del file Torrent in modo da permettere l'autenticazione al tracker.<br />
<b>ATTENZIONE</b>: non cedere a <u>nessuno</u>, per qualsiasi motivo, i Torrent abilitati a questo tipo di autenticazione.
Utenti non autorizzati, pur non potendo accedere al tuo account, potrebbero influenzare la tua ratio, con conseguenti effetti sulle possibilit&agrave; di download.<br />Nel caso uno dei tuoi Torrent finisse nelle mani sbagliate, puoi sempre creare un nuovo codice di sicurezza.");
define("_btresetpasskey","Reimposta Passkey");
define("_btresetpasskeywarning","<b>ATTENZIONE</b>: tutti i Torrent finora scaricati con autenticazione Passkey non saranno pi&ugrave; validi!");
define("_btprofilesaved","Profilo salvato correttamente!");
define("_btaccesslevel","Livello di accesso");
define("_btdeleteaccount","Cancella Account");

//TESTI CHE COMPAIONO IN INCLUDE/BITTORRENT.PHP
define("_btindex","Home Torrent");
define("_bttorrentupload","Invia Torrent");
define("_btlinkupload","Invia Link");
define("_btupload","Upload");
define("_btlogin","Login");
define("_btlogout","Logout");
define("_btsignup","Registrazione");
define("_btpersonal","Torrent di ");
define("_btpm","Messaggi Privati");
define("_btadmin","Amministrazione");
define("_btrulez","Regolamento");
define("_btforums","Forum");
define("_bthelp","Aiuto");
define("_btadvinst","Installa Bit Torrent o Shareaza per scaricare");
define("_btaccessden","Accesso Negato. Per accedere devi essere <A href=\"user.php?op=register\">registrato</a>");
define("_btlegenda","Aiuto Funzioni e legenda");
define("_btyourfilext","File tuo, tracker esterno");
define("_btexternal","Tracker Esterno");
define("_btyourfile","File tuo");
define("_btfile","file");
define("_btsticky","In Evidenza");
define("_btauthforreq","Autorizzazione da richiedere");
define("_btauthreq","Richiesta Autorizzazione");
define("_btdown","Scarica");
define("_btunknown","Sconosciuto");
define("_btrefresh","Aggiorna");
define("_btvisible","Visibile");
define("_btsd","SD");
define("_btlc","LC");
define("_bttt","TOT");

//TESTI CHE COMPAIONO IN INDEX.PHP
define("_btwelcome","Benvenuti in Bit Torrent");
define("_btsearch","Cerca");
define("_btsearchname","Cerca Torrent");
define("_btin","in");
define("_btalltypes","Qualsiasi");
define("_btactivetorrents","Torrent attivi");
define("_btitm","includi Torrent morti");
define("_btstm","solo Torrent morti");
define("_btgo","Vai!");
define("_btresfor","Ordina i risultati per");
define("_btnotfound","<h2>Nessun risultato!</h2>\n<p>Prova ancora ridefinendo le parole di ricerca.</p>\n");
define("_btvoidcat","<h2>Vuota!</h2>\n<p>Seleziona un'altra categoria</p>\n");
define("_btorderby","Ordina per");
define("_btinsdate","Data Inserimento");
define("_btname","Nome");
define("_btdim","Dimensione");
define("_btnfile","Numero file");
define("_btevidence","In Evidenza");
define("_btcomments","Commenti");
define("_btvote","Valutazione");
define("_btdownloaded","Scaricato");
define("_btprivacy","Privacy");
define("_bttotsorc","Fonti Totali");
define("_btdesc","decrescente");
define("_btord","crescente");
define("_btnosearchttl","Solo Ricerca");
define("_btnosearch","<h2 align=\"center\">Per visualizzare i file effettua una ricerca</h2><p>\n
Non &egrave; possibile visualizzare la lista completa dei Torrent. Se sei interessato ad un file in particolare, prova a fare una ricerca.<br>
Se non trovi qui quello che stai cercando, puoi aspettare che qualcuno faccia la release o farla tu. Creare un Torrent &egrave; molto semplice
e ricorda che i milgiori uploader ricevono privilegi sui loro download.</p>");
define("_bthelpfind","Aiuto Ricerca");
define("_bttype","Tipo");
define("_bttopsource","TOP FONTI in download");
define("_btnotopsource","Non ci sono torrent in download in questo momento");
define("_btnotseeder_noneed","Non ci sono Torrent critici in questo momento");
define("_btnotseeder_desc","Per favore se hai uno o pi&ugrave; di questi file completi fai da seeder (fonte completa) per chi li vuole, devi semplicemente scaricare il TORRENT e specificare come destinazione il tuo file, in nessun caso verr&agrave; modificato.<br>Grazie da parte di tutti per il tuo aiuto, molti potrebbero stare da ore/giorni ad espettare <b>FILESHARE PHILOSOPHY INSIDE</b>");
define("_btnoseeder","NESSUNA FONTE COMPLETA in upload");
define("_btnet","Rete");
define("_btsource","Fonti");
define("_bttorrent","Torrent");
define("_btview","Visto");
define("_bthits","Scaricato");
define("_btsnatch","Completo");
define("_btalternatesource","<b>Disponibili solo fonti alternative</b>");
define("_btcantscrape","<b>Impossibile determinare il numero di fonti</b>");
define("_bteasy","<b>Veloce da scaricare</b>");
define("_btmedium","<b>Lento da scaricare</b>");
define("_bthard","<b>Difficile da scaricare</b>");
define("_btstats","Statistiche");
define("_btmisssearchkey","Chiave di ricerca mancante");
define("_btinfotracker","Informazioni sul Tracker");
define("_btnouseronline","Nessun utente registrato &egrave; online");
define("_btonlineusers","Utenti collegati");
define("_btadvancedmode","Modalit&agrave; avanzata");
define("_btsimplemode","Modalit&agrave; semplice");
define("_btpagename","Pagina attuale");
define("_btloggedinfor","Online da");
define("_btseedby","Torrent in seeding da ");
define("_btleechby","Torrents in download da ");

//PAGINE PMBT
define("_btpage_admin.php","Amministrazione");
define("_btpage_chat.php","Chat");
define("_btpage_details.php","Scheda Torrent");
define("_btpage_edit.php","Modfica Torrent");
define("_btpage_index.php","Home");
define("_btpage_mytorrents.php","Pannello Torrent");
define("_btpage_search.php","Ricerca");
define("_btpage_upload.php","Upload");
define("_btpage_user.php","Pannello Utente");

//TESTI CHE COMPAIONO IN DETAILS.PHP
define("_btinfo","Informazioni");
define("_bttracker","Tracker");
define("_bterridnotset","ID del Torrent non specificato");
define("_btddownloaded","Scaricato");
define("_btdcomplete","Completato");
define("_dtimeconnected","Tempo connesso");
define("_btsourceurl","Disponibile su");
define("_btdidle","In pausa");
define("_btdsuccessfully","Torrent caricato con successo");
define("_btdsuccessfully2","Per favore inizia adesso a fare da seed. La visibilit&agrave; del Torrent dipende dal numero delle fonti");
define("_btdsuccessfullye","Modificato con successo");
define("_btdgobackto","Indietro alla pagina");
define("_btdwhenceyoucame","da cui sei venuto");
define("_btdyoursearchfor","La tua ricerca per");
define("_btnotorrent","Il Torrent non esiste o &egrave; stato bannato");
define("_btdratingadded","Votazione aggiunta");
define("_btdspytorrentupdate","SpyTorrent ha aggiornato le fonti");
define("_btdspytorrentupdate1","Tra 3 secondi sarai redirettato alla pagina del Torrent");
define("_btdspytorrentupdate2","Qualunque cosa andasse storto puoi raggiungere la pagina da");
define("_btdspytorrentupdate3","qui");
define("_btdownloadas","Scarica come");
define("_btpieces","Parti");
define("_btpiecesstring","**n** parti da **l**");
define("_btpremiumdownload","Solo gli utenti Premium possono scaricare questo file");
define("_btregistereddownload","Registrati o fai il login per scaricare questo Torrent");
define("_btauthstatus","Autorizzazione Download");
define("_btdwauthpending","In attesa di approvazione");
define("_btdwauthgranted","Concessa!");
define("_btdwauthdenied","Negata!");
define("_btdwauthnorequest","Non ancora richiesta");
define("_btnetwork","network");
define("_btdays","g ");
define("_bthours","h ");
define("_btmins","m ");
define("_btsecs","s ");
define("_btinfohash","Info Hash");
define("_btinfohashnotice","<b>ATTENZIONE</b>: il Torrent &egrave; stato modificato in un modo che impone un NUOVO DOWNLOAD dello stesso.
La versione che hai sul tuo computer non &egrave; pi&ugrave; valida. Utilizza il bottone Download per ottenere una versione funzionante.");
define("_btdescription","Descrizione");
define("_btnodead","<b>no</b> (morto)");
define("_btbanned","Bannato");
define("_btfiles","file");
define("_btothersource","Altre Fonti");
define("_btnoselected","Nessuna categoria selezionata");
define("_btago","fa");
define("_btlastseeder","Ultimo Seeder");
define("_btlastactivity","Ultima Attivit&agrave;");
define("_bttypetorrent","Tipo");
define("_btsize","Dimensione");
define("_btminvote","Non votato (servono almeno __minvotes__ voti");
define("_btonly","solo");
define("_btnone","nessuno");
define("_btnovotes","Nessun voto");
define("_btoo5","di 5 con");
define("_btvotestot","voto(i) totali");
define("_btlogintorate","(Effettua il <a href=\"user.php?op=loginform\">login</a> per votare)");
define("_btvot1","Pessimo");
define("_btvot2","Sufficiente");
define("_btvot3","Mediocre");
define("_btvot4","Buono");
define("_btvot5","Ottimo");
define("_btaddrating","vota");
define("_btvotenow","Vota!");
define("_btrating","Votazione");
define("_bthelpstat","Aiuto Statistiche");
define("_btviews","visto");
define("_bttimes","volta(e)");
define("_btleechspeed","Velocit&agrave; Leech");
define("_bteta","ETA");
define("_btuppedby","Inserito da");
define("_btnumfiles","Numero file");
define("_btfilelist","Lista file");
define("_btlasttrackerupdate","Ultimo aggiornamento tracker");
define("_btshowlist","Mostra Lista");
define("_bthidelist","Nascondi Lista");
define("_bthelpsource","Aiuto Fonti");
define("_btseeds","Completi");
define("_btcomplaints","Lamentele");
define("_btcomplyouvoted","Hai espresso il seguente giudizio sul Torrent: ");
define("_btcomplexplain","Se un certo numero di utenti esprime un giudizio negativo sul Torrent, questo verr&agrave; bannato.");
define("_btcomplaintform","Modulo di valutazione del Torrent.<BR>Questo sistema, a differenza della votazione a punteggio, permette di esprimere un giudizio su Torrent non adatto al regolamento.<BR>
I Torrent che riceveranno numerose lamentele verranno automaticamente bannati dal sistema.<BR>Si raccomanda di esprimere opinioni positive su Torrent il cui contenuto &egrave; in linea con il regolamento.<BR>");
define("_btcomplisay","Questo Torrent contiene ");
//Il marker p indica i commenti positivi, e il marker n quelli negativi
define("_btcomplatthemoment","Al momento sono stati espressi <b>**p**</b> commenti positivi e <b>**n**</b> commenti negativi<BR>");
define("_btmagnetlink","Magnet Link");
define("_bted2klink","eD2K Link");
define("_btcommentsfortorrent","Commenti per il Torrent");
define("_btbacktofull","Torna ai dettagli completi");
define("_btnotifyemailcom","Se vuoi essere avvisato via email quando vengono aggiunti commenti a qusto Torrent, fai click <a href=\"details.php?op=comment&trig=on&id=**id**#notify\">qui</a>.");
define("_btnotnotifyemailcom","Attualmente stai ricevendo la notifica per email se viene aggiunto un commento a questo torrent. Se desideri non riceverla pi&ugrave; fai click <a href=\"details.php?op=comment&trig=off&id=**id**#notify\">qui</a>.");
define("_btclickhere","fai click qui");
define("_btnotifyemail1s","<p>Se vuoi ricevere una notifica per email quando viene aggiunto il primo <b>SEEDER</b> a questo torrent fai click <a href=\"details.php?op=seeder&trig=on&id=**id**#notify\">qui</a>.</p>");
define("_btnotnotifyemail1s","<p>Attualmente stai ricevendo la notifica per email al primo seeder che viene aggiunto a questo Torrent. Se desideri non riceverla pi&ugrave; fai click <a href=\"details.php?op=seeder&trig=off&id=**id**#notify\">qui</a>.</p>");
define("_btnocommentsyet","Attualmente non sono presenti commenti");
define("_btcommheader","**time**, <a href=\"user.php?op=profile&id=**uid**\" target=\"_top\">**user**</a> ha scritto:");
define("_btdgavesresult","ha restituito un solo risultato");
define("_btdnotifyemaildel","Sei stato rimosso dalla lista di notifica per email commento.");
define("_btdnotifyemaildel1","Non riceverai ulteriori email quando verra aggiunto un commento!");
define("_btdnotifyemailadd1","Verrai informato quando commento verr&agrave; aggiunto e non riceverai ulteriori notifiche finché non li visualizzerai!");
define("_btdnotifyemailadd","Sei stato aggiunto alla lista di notifica email per commento.");
define("_btdnotifyadd","Sei stato aggiunto alla lista di notifica email per seeder.");
define("_btdnotifyadd2","Verrai informato quando il primo seeder si collega e riceverai al massimo un email a giorno!");
define("_btdnotifydel","Sei stato rimosso dalla lista di notifica per email da seeder e non riceverai ulteriori email quando verra aggiunto un seeder!");
define("_btddetails","Dettagli per il Torrent");
define("_bteditthistorrent","Modifica questo Torrent");
define("_btyes","si");
define("_btno","no");
define("_btadded","Segnalato il");
define("_btaddedby","Segnalato da");
define("_bton","su");
define("_bthelpothersource","Aiuto Fonti Alternative");
define("_btfilename","Nome file");
define("_btpeers","Fonti");
define("_btpeerstot","Fonti totali");
define("_bthelppeer","Aiuto Fonti");
define("_btleecher","Leecher");
define("_btleechers","Leechers");
define("_btdhelpdownload","Aiuto Download");
define("_btyourate","Tu hai votato");
define("_btupdatesource","Aggiorna le fonti ora!");
define("_btseeder","Seeder");
define("_btseeders","Seeders");
define("_btcompletion","Completo");
define("_btdirectlink","Direct Link");
define("_btnotifications","Notifiche via email");
define("_bttransfer","Trasferimento");
define("_btdownloadspeed","Velocit&agrave; di Download");
define("_btuploadspeed","Velocit&agrave; di Upload");
define("_bttorrentpassword","Protezione Password");
define("_btpasswordquery","Questo Torrent &egrave; protetto da password. L'utente che ha effettuato l'upload ha deciso di permettere l'accesso solo a utenti autorizzati.<br />Per favore forniscila adesso per ottenere accesso immediato al Torrent.
Se non conosci la password, &egrave; probabile che tu non sia autorizzato a stare qui.");
define("_btpasswordwrong","Attenzione: la password fornita &egrave; errata.<br />Suggerimento: attenzione alle MAIUSCOLE e alle minuscole");
define("_btcompletedby","Completato da");
define("_bttrackers","Altri Tracker");
define("_bttrackergroup","Gruppo *");
define("_btexport","Esporta");
define("_btexportexplain","Scarica il Torrent senza Passkey in modo da poterlo distribuire su altri siti che offrono servizi di indicizzazione BitTorrent");

//TRACKER INTERNO
define("_btuserip","Nome utente/IP");
define("_btport","Porta");
define("_btdownloadedbts","Scaricati");
define("_btuploadedbts","Inviati");
define("_btratio","Rapporto");
define("_btpercent","Completo");
define("_btconnected","Connesso per");
define("_btidle","Inattivo per");
define("_btconn","Connessione");
define("_btactive","Attiva");
define("_btpassive","Passiva");
define("_btpeerspeed","Velocit&agrave; media");
define("_btnopeer","Non ci sono peer");
define("_btreadcomms","Leggi i commenti");
define("_btpostcomment","Lascia un commento");

//TESTI PRESENTI IN TAKEUPLOADURL.PHP
define("_btinseriti","Inseriti");
define("_btand","e");
define("_btnumerror","il loro numero non &egrave; uguale e quindi non &egrave; possibile procedere con l'assegnazione binaria");
define("_btmaxchar","L'URL ED2K non pu&ograve; essere pi&ugrave; grande di 200 caratteri");
define("_bted2kstart","L'URL non comincia per <b>ed2k://</b>");
define("_bt2par","L'URL non ha come secondo parametro");
define("_bturlfile","file");
define("_bturlcontent","L'URL non contiene il");
define("_btfname","nome file");
define("_bturlsize","L'URL non contiene la");
define("_btsz","dimensione");
define("_bturlparerror","L'URL non contiene il parametro");
define("_bturlsureerror","L'URL contiene una fonte non regolare");
define("_bturlnotinsert","Obbligatorio inserire un URL ED2K");
define("_btnotip","IP non inserito");
define("_btinvip","IP non valido");
define("_btnoport","Porta non inserita");
define("_btinvport","Porta non valida");
define("_btparmag","nessuno");
define("_btnopresent","non presente");
define("_btmagchar","L'URL Magnet non pu&ograve; essere pi&ugrave; grande di 200 caratteri");
define("_bftminlimit","Non &egrave; possibile fare condividere un file pi&ugrave; piccolo di");
define("_btfmaxlimit","Il Torrent che hai inviato contiene un file troppo grande");
define("_btillegalword","La ricerca effettuata utilizzando le parole del nome del file fa supporre che il Torrent caricato abbia a che fare con attivit&agrave; illegali.");
define("_btillegalwordinfo","Il nostro portale utilizza un filtro basato sulle parole chiave per prevenire attivit&agrave; illegali o dannose. Siamo consapevoli che nonostante siano utilizzate queste parole nel tuo file esso possa essere comunque legale. Accetta le nostre scuse e prova a caricare nuovamente un Torrent con nome leggermente diverso.");
define("_bturlinserted1","Inserimento effettuato correttamente, tra 3 secondi verrai ridiretto sulla scheda del file.<BR>Se non dovessi essere ridiretto puoi raggiungere la pagina da");
define("_bturlinserted2","questo link");
define("_btaddnotifycomment","Sei stato aggiunto alla lista di notifica: se il Torrent ricever&agrave; dei commenti verrai avvisato tramite email.");
define("_btaddnotifyseeder","Sei stato aggiunto alla lista di notifica: quando un utente raggiunger&agrave; il 100% del download verrai avvisato tramite email.");
define("_btnolinkinsert","Nessun link inserito");
define("_btexnostartwt","I link exeem iniziano tutti per exeem://");
define("_btinvalidexeem","Link eXeem non valido!");
define("_btillegalcat","Categoria non valida!");

//TESTI PRESENTI IN UPLOAD.PHP
define("_btuploadatorrent","Carica un file BitTorrent");
define("_btphotoext","Il file di immagine non ha estensione GIF, JPG o PNG");
define("_btalertmsg","Si sono verificati i seguenti errori:");
define("_btalertmsg2","Si prega di corregere gli errori e di inviarlo nuovamente");
define("_btfnotselected","ERRORE: file non selezionato");
define("_btalertdesc","Inserire una descrizione che specifichi la lingua e la qualit&agrave; del file, in particolare in caso di file multimediali");
define("_btalertcat","Selezionare una categoria");
define("_btconferma","Sei pronto per effettuare l'upload? Se il tuo Torrent &egrave; composto da pi&ugrave; file, per cortesia ricrealo come multiarchivio contenente l'intera cartella. Altrimenti potrebbe essere inutilizzabile o dare solo problemi a chi vuole scaricarlo.");
define("_btalerturl","Inserire un link MAGNET o ED2K");
define("_btalerturlnum1","Il numero di ED2K link &egrave;");
define("_btalerturlnum2","mentre quello MAGNET &egrave;");
define("_btalerturlnum3","Il numero deve essere uguale in quanto ogni file per Torrent &egrave; composto da coppie di link");
define("_btalert5char","Il nome del file deve essere composto da almeno 5 caratteri");
define("_btofficialurl","I tracker uffciali di questo sito sono:");
define("_btseeded","Effettua l'upload di questo Torrent solo se hai intenzione di fare da seed. Un Torrent senza fonti non viene visualizzato sulla pagina principale.");
define("_btupfile","Upload del file:");
define("_btupnfo","Upload file NFO:");
define("_bttorrentname","Nome del Torrent");
define("_btsrc_url","URL Sorgente");
define("_btcompulsory"," (Obbligatorio)");
define("_btfromtorrent","Non preoccuparti di lasciare il campo vuoto: ci pensiamo noi a prendere il nome direttamente dal file.");
define("_btdescname","Cerca almeno di dargli un nome descrittivo");
define("_btnohtml","SENZA FARE USO DI HTML");
define("_btchooseone","Scegli");
define("_btverduplicate","Verifica Torrent simili");
define("_btduplicatinfo","Se selezionato impedisce l'upload nel caso in cui il sistema trovi un file probabilmente corrispondente. Deseleziona la casella se vuoi comunque caricare il Torrent. Ricorda che i Torrent duplicati confondono soltanto gli utenti, ed &egrave; bene avere un solo Torrent per ogni prodotto.");
define("_btupevidence","Messo in Evidenza");
define("_btupevidencinfo","Usare questa opzione con responsabilit&agrave;: solo se il file pu&ograve; davvero interessare gli utenti e quando &egrave; garantito un buon seeding (magari 24 ore su 24 per una settimana intera...)");
define("_btowner","Proprietario");
define("_btowner1","Visualizza Utente");
define("_btowner2","Modalit&agrave; Privacy");
define("_btowner3","Modalit&agrave; Stealth");
define("_btownerinfo","L'opzione 'VISUALIZZA UTENTE' permetter&agrave; agli utenti di visualizzare il proprio nick, 'PRIVACY' lo nasconde lasciando comunque attiva le funzionalit&agrave; di modifica/cancellazione nei propri torrent, 'STEALTH' impedisce qualsiasi collegamento con chi fa upload e quindi non visualizzer&agrave; il proprio nick e non sar&agrave; possibile nessun tipo di modifica al file");
define("_btupnotify","Notifica");
define("_btupnotifynfo","Sarai avvisato via email quando verr&agrave; aggiunto un commento");
define("_btupnotifyseed","Sarai avvisato via email quando il Torrent avr&agrave; il primo seeder (solo Torrent interni)");
define("_btfsend","Invia Torrent");
define("_btinserte2k","Inserire URL ED2K");
define("_btmagnetinsert","Inserire URL Magnet");
define("_btinsertlinktitle","Inserisci link per GNutella e eDonkey2000");
define("_btinsertlinktext","Puoi inserire un link eDonkey2000 ai tuoi file Bit Torrent per prevenire cadute del tracker. Il link rester&agrave; inserito finché non verr&agrave; segnalato come fake o senza fonti al nostro staff");
define("_bted2kurl","Inserisci link ED2K");
define("_btsyntax","Del tipo");
define("_btfiletype","estensione");
define("_btfilesize","Proprietario");
define("_btidcode","codice_hash");
define("_btipport","ip:porta");
define("_btstatic","indica semplicemente che lavoriamo in ambiente eDonkey2000");
define("_btfinalname","&egrave; il nome del file da scaricare");
define("_btfinalsize","&egrave; la dimesione, in byte, del file");
define("_btfinalidcode","&egrave; un codice di verifica in grado di identificare SENZA ERRORI il solo unico file a cui &egrave; associato");
define("_btfinalipport","rappresenta la sorgente stabile (opzione usata da chi fa release)");
define("_btor","oppure");
define("_btaddmagnet","Link Magnet");
define("_btadded2k","Link eD2K");
define("_btphoto","Immagine");
define("_btexeemlink","Link eXeem Alternativo");
define("_btexeemlinkexplain","Opzionale. Se il Torrent &egrave; scaricabile anche tramite eXeem inserisci qui il link alternativo");
define("_bttorrentpasswordexplain","Puoi scegliere di proteggere il tuo Torrent con una password. Se &egrave; impostata, il Torrent non sar&agrave; visibile
nella Lista e in Ricerca a nessuno eccetto Utenti Premium e Amministratori. Dovrai fornire un link diretto alle persone che intendi far accedere al Torrent.
La Password pu&ograve; essere applicata solo ai Torrent Interni.");
define("_btuploadedpassexplain","Hai impostato la password: <b>**pass**</b>");
define("_btuploadedpassexplain2","Per permettere agli utenti di accedere al Torrent devi fornire loro il link diretto: <b>**url**<b>");
define("_btupadvopts","Opzioni Avanzate");
define("_btadvoptsexplain","Accedi ad opzioni avanzate di upload che ti permettono di modificare alcuni aspetti tecnici del Torrent. Usa queste opzioni solo se sai quello che fai!");
define("_btleaveintact","Non modificare questa impostazione");
define("_btdhtsupport","Supporto DHT");
define("_btendht","Forza il Tracking DHT di Backup");
define("_btdisdht","Disabilita il supporto DHT");
define("_btdhtsupportexplain","Puoi scegliere se forzare il Torrent a usare il Tracking DHT si Backup o meno, utile quando il tracker principale va offline o viene sovraccaricato");
define("_btprivatetorrent","Torrent Privato");
define("_btenpvt","Imposta Torrent Privato");
define("_btdispvt","Imposta il Torrent Pubblico");
define("_btprivatetorrentexplain","Puoi sovrascrivere l'opzione Torrent Privato, utilizzabile solo in alcuni client, che non accetta peer al di fuori di quelli comunicati dal tracker. L'opzione disabilita il supporto DHT");

//UPLOAD-LINK
define("_btuploadalinkarchive","Carica un Archivio di Link");
define("_btsharelink","Segnala i tuoi link soltanto se hai intenzione di condividerne i file. I link senza fonti sono solo nocivi al network.");
define("_btlinknotice","Ricorda che l'archivio link risulta valido se e soltanto se al pi&ugrave; la met&agrave; dei file &egrave; gi&agrave; presente! Ci&ograve; impedisce ai file duplicati di diffondersi sul Tracker");
define("_btarchivename","Nome Archivio");
define("_btinsert1file","Devi inserire almeno un file. Ogni file deve contenere almeno il link eDonkey2000.");
define("_btlinksnomatch","I link non rappresentano lo stesso file");
define("_btinvalided2k","Link eD2K non valido");
define("_btinvalidmagnet","Link Magnet non valido");
define("_btlinks","Link");
define("_btaddnewfile","Nuovo File");
define("_btaddtoarchive","Aggiungi File");
define("_btaddmd5","Hash MD5");
define("_btlinks","Link");
define("_bterrduplicatelinks","Non sono consentiti file duplicati");
define("_btduplicatelinks","Link Duplicati");
define("_btduplicateexplain","Il link che hai segnalato &egrave; gi&agrave; presente. Fai click per controllare il Torrent/Collezione in cui si trova il file.");
define("_btinsertfilesfirst","Devi inserire almeno un file con l'apposito bottone prima di procedere");
define("_btfilelistaltered","La lista file &egrave; stata alterata! Non &egrave; stata creata con questo programma.");

//TESTI CHE COMPAIONO IN COMMENT.PHP
define("_btiderror","ID non valido");
define("_btnotfoundid","Torrent inesistente");
define("_btaddcomment","Aggiungi un Commento");
define("_btaddtime","Inserito il ");
define("_btby","da");
define("_btsend","Invia");
define("_btnotyourcomment","Non puoi toccare i commenti altrui!!");
define("_btcommentdeleted","Commento cancellato correttamente, tra 3 secondi verrai ridiretto sulla scheda del file.<br>Se non dovessi essere ridiretto puoi raggiungere la pagina da <a href=\"details.php?id=**id**\"> questo link</a>");

//TESTI CHE COMPAIONO IN DOWNLOAD.PHP
//LE PAROLE TRA "** **" SONO INDICATORI
define("_bttorrentunavailable","File Torrent non disponibile a causa di problemi alla configurazione del server. Ci scusiamo per l'inconveniente.");
define("_btdownload","Download Torrent");
define("_btminseedrule","Per scaricare devi fare da seed ad almeno **min** Torrent.");
define("_btminseedsizerule","Per scaricare devi fare da seed ad almeno **min** di Torrent.");
define("_btmaxdailydownloads","Non puoi scaricare pi&ugrave; di **max** file al giorno. Per favore, riprova domani.");
define("_btmaxweeklydownloads","Non puoi scaricare pi&ugrave; di **max** file a settimana. Per favore, riprova la settimana prossima.");
define("_btnogratis","Non si vive di solo gratis!");
define("_bterrminseed","<li>Devi fare da seeder per un totale di almeno <b>**min_share**</b>.<br>");
define("_bterrtoosmall","<li>Devi fare da seeder per un file grande almeno <b>**min_share**</b>.<br>");
define("_bterrtoobig","<b>Il tuo file da seeder pi&ugrave; grande &egrave; ");
define("_bterrorprivate","Questo file &egrave; privato: hai gi&agrave; inviato una richiesta di accesso ai file a questo proprietario. Finché non accetter&agrave; la tua richiesta non potrai scaricare il Torrent.");
define("_btrefused","Il proprietario ha rifiutato la tua richiesta di scaricare: non puoi inviargli ulteriori richieste.");
define("_bterrblacklist","Il proprietario ha deciso di escluderti dai suoi download. Non potrai scaricare nessuno dei suoi Torrent.");
define("_btreqsent","Questo Torrent &egrave; privato. Prima di poterlo scaricare hai bisogno dell'autorizzazione del proprietario.
Per aiutarti, il sistema ha fatto automaticamente richiesta di download al proprietario del Torrent, che dovr&agrave; autorizzarti. Riceverai conferma via email quando il permesso verr&agrave; concesso.");

//TESTI CHE COMPAIONO IN EDIT.PHP
define("_btedittorrent","Modifica Torrent");
define("_bterreditnoowner","<h1>Accesso Negato</h1>\n<p>Solo il proprietario e gli Amministratori possono apportare modifiche</p>\n");
define("_btcancel","Annulla");
define("_btsure","S&igrave;: sono sicuro di volerlo fare");
define("_btareyousure","Sicuro di voler eliminare il Torrent <b>**name**</b>?");
define("_bttorrentnoexist","Il Torrent non esiste");
define("_btdelete","Elimina Torrent");
define("_btcannotdel","Impossibile eliminare");
define("_btmissingdata","Dati di richiesta mancanti!");
define("_btdeldenied","Solo il proprietario o un Amministratore possono eliminare questo Torrent");
define("_btnotconfirmed","Devi essere sicuro di ci&ograve; che stai per fare");
define("_btdeleted","Torrent eliminato");
define("_btgoback","Torna indietro");
define("_btsuccessfullyedited","Torrent modificato con successo. Tra poco verrai indirizzato alla pagina del Torrent. Ricorda che se hai impostato la modalit&agrave; Stealth perderai il diritto a modificare ed eliminare questo Torrent");

//TESTI CHE COMPAIONO IN MYTORRENTS.PHP
define("_btmytorrentsintrotitle","Pannello di Controllo Torrent");
define("_btmytorrentsintrotext","Con questo Pannello di Controllo pui gestire i Torrent di cui hai fatto l'upload SENZA aver selezionato
la modalit&agrave; Stealth. Tutti i Torrent a te associati sono disponibili per la gestione.<br>
In particolare, potrai gestire le richieste di download da parte degli altri utenti. Selezionando l'apposita icona, potrai visualizzare,
qualora ci fossero, le richieste degli altri utenti. Dovrai decidere se concedere o negare il permesso di download.<br>
Nel farlo, tieni presente la quantit&agrave; di dati in upload e download dell'utente. Gli utenti che scaricano senza condividere non sono un
beneficio per il network di Bit Torrent. Negar loro l'autorizzazione pu&ograve; essere un incentivo a migliorare la loro posizione sul tracker.");
define("_btmytorrents","I miei Torrent");
define("_btallauthorized","Tutti gli utenti sono stati autorizzati");
define("_btauthorized","L'utente selezionato &egrave; stato autorizzato");
define("_bthasauthorized","L'utente ti ha autorizzato a scaricare i file che condivide");
define("_btnowcandownload","Da adesso puoi scaricare tranquillamente TUTTI i file di QUESTO utente.\nProteggiamo la tua privacy.");
define("_btauthmailsubj","Autorizzazione accesso file BIT TORRENT");
define("_btauthorizationrequested","I seguenti utenti hanno fatto richiesta di poter scaricare i file da te inseriti:");
define("_btauths","Richieste download");
define("_pendingauths","Nuove Autorizzazioni: ");
define("_btnotorrents","Non ci sono Torrent");
define("_btnotorrentuploaded","Non hai caricato alcun Torrent finora");
define("_btactions","Azioni");
define("_bthasuploaded","Ha inviato **");
define("_bthasdownloaded","Ha scaricato **");
define("_btauthgrant","Autorizza");
define("_btauthalwaysgrant","Autorizza sempre");
define("_btauthalwaysdeny","Nega sempre");
define("_btauthdeny","Nega");
define("_btcantseeothertorrents","Non puoi visualizzare le opzioni di riservatezza per i Torrent altrui!");
define("_btauthpanel","Pannello di Controllo autorizzazioni download");
define("_btnoauthstomanage","Non ci sono autorizzazioni da poter gestire");
define("_btmyglobals","Le mie autorizzazioni globali");
define("_btnoglobals","Non ci sono autorizzazioni globali");
define("_btstatus","Stato");
define("_btauthreset","Azzera");
define("_btwronginput","Errore nell'inserimento dei dati");
define("_btgeneraloptions","Opzioni generali");
define("_btprivate","Privato");
define("_btprivateexpl","Seleziona questa opzione per abilitare l'autorizzazione al download. Quando un utente intender&agrave; scaricare questo Torrent dovr&agrave; prima ricevere la tua approvazione.
Tutte le nuove autorizzazioni ti verranno notificate via email. Potrai scegliere se accettare o negare la richiesta per questo o per tutti i tuoi Torrent");
define("_btminratio","Rapporto minimo");
define("_btdisabled","Disabilitato");
define("_btminratioexpl","Puoi impostare un rapporto di download minimo per autorizzare automaticamente gli utenti. Utenti con rapporto uguale o superiore al valore impostato non dovranno richiedere prima l'autorizzazione per scaricare.
Il valore impostato non sar&agrave; visibile pubblicamente, eccezion fatta per gli Amministratori");

//TESTI CHE COMPAIONO IN TAKECOMMENT.PHP
define("_btcommentkeyfound","Abbiamo effettuato una ricerca utilizzando le parole contenute nel commento. Il sistema considera che le seguenti parole potrebbero essere oggetto di attivit&agrave; illegali:<ol>");
define("_btcommentkeyfound2","</ol><p>Siamo consapevoli del fatto che il commento potrebbe essere del tutto legale, ci scusiamo dell'inconveniente e ti invitiamo a utilizzare altre parole. Questo &egrave; un filtro automatico, e non &egrave; detto che sia sempre dalla parte della ragione</p>");
define("_btcommentinserted","Commento inserito correttamente, tra 3 secondi verrai ridiretto sulla scheda del file.<br>Se non dovessi essere ridiretto puoi raggiungere la pagina da <a href=\"details.php?id=**id**#commments\"> questo link</a>");

//TESTI CHE COMPAIONO IN TAKEEDIT.PHP
define("_btmissingformdata","Mancano i dati in input!");
define("_bteditfailed","Modifica non riuscita");
define("_bteditdenied","Impossibile modificare Torrent altrui");
define("_btreturl","File modificato correttamente, tra 3 secondi verrai ridiretto sulla scheda del file. Se non dovessi essere ridiretto puoi raggiungere la <a href=\"**returl**\">pagina da questo link</a>");

//TESTI CHE COMPAIONO IN RATE.PHP
define("_btrate","Votazione Torrent");
define("_btratefailed","Votazione fallita!");
define("_btinvalidrating","Voto non valido");
define("_btidnotorrent","ID Errato. Torrent inesistente");
define("_btnovoteowntorrent","Non puoi votare i tuoi Torrent");
define("_btalreadyrated","Torrent gi&agrave; votato");
define("_btcantvotetwice","Siamo spiacenti, ma non puoi votare un Torrent due volte");
define("_btvotedone","Votazione riuscita correttamente, tra 3 secondi verrai ridiretto sulla scheda del file.<br>Se non dovessi essere ridiretto puoi raggiungere la pagina da <a href=\"details.php?id=**id**\">questo link</a>");

//TESTI CHE COMPAIONO IN TAKEUPLOAD.PHP
define("_btuploaderror","Upload fallito!");
define("_btscrapeerror","Controllo tracker esterno fallito!");
define("_btemptyfname","Nome file vuoto");
define("_btinvalidfname","Nome file non valido");
define("_btinvalidnfofname","Nome file NFO non valido");
define("_btfnamenotorrent","Questo file non &egrave; un Torrent (.torrent)");
define("_btfnamenonfo","Questo file non &egrave; un NFO (.nfo)");
define("_btferror","Errore file");
define("_bterrnofileupload","Errore grave nel file in upload.");
define("_bterrnonfoupload","Errore grave nel file NFO in upload.");
define("_btemptyfile","File vuoto");
define("_btnobenc","File danneggiato. Sicuro che &egrave; davvero un Torrent?");
define("_btnodictionary","Dizionario Torrent assente");
define("_btdictionarymisskey","Chiavi del Dizionario Torrent mancanti");
define("_btdictionaryinventry","Dati non validi nel Dizionario Torrent");
define("_btdictionaryinvetype","Tipo di dati nel Dizionario Torrent non validi");
define("_btinvannounce","URL Announce non valido. Deve essere un URL contenente lo script announce ");
define("_btdescrrequired","Descrizione Torrent obbligatoria");
define("_btactualannounce","Il tracker che hai specificato &egrave; ");
define("_bttrackerdisabled","Il nostro tracker &egrave; stato disabilitato: &egrave; possibile effettuare l'upload esclusivamente di Torrent esterni.");
define("_btinvpieces","Frazioni Torrent non valide");
define("_btmissinglength","Mancano i file e la loro grandezza");
define("_btnofilesintorrent","File del Torrent mancanti");
define("_btfnamerror","Nome file non valido");
define("_btfilenamerror","Errore nel nome del file");
define("_btinvalidhtml","Codice HTML non valido. Verifica di aver utilizzato il nostro editor e di non aver inserito codice manualmente.");
define("_bttorrentpresent","Il Torrent &egrave; gi&agrave; presente nel nostro archivio. Puoi trovarlo facendo click <a href=\"details.php?id=#id#\">qui</a>.");
define("_bttrackerblacklisted","Non &egrave; possibile effettuare l'upload di Torrent associati al tracker <b>**trk**</b>. Utilizza un URL Announce diverso");
define("_bttorrenttoosmall","<p>Non &egrave; possibile fare condividere un file pi&ugrave; piccolo di <b>");
define("_bttorrenttoosmall2","</b></p><p>Il torrent che hai inviato riguardava un file grande <b>");
define("_btmaxuploadexceeded","Non &egrave; possibile fare l'upload pi&ugrave; di **maxupload** ogni 24 ore.");
define("_btnumfileexceeded","<p>Non &egrave; possibile fare l'upload di una quantit&agrave; di file superiore a <b>**maxupload**</b> in 24 ore.</p><p>Al momento hai gi&agrave; fatto l'upload di <b>**rownum**</b> file per un totale di <b>**totsize**</b>");
define("_btsearchdupl","E' stata effettuata una ricerca utilizzando le parole del nome del file e la dimensione, il sistema considera che i seguenti file potrebbero essere fonti uguali gi&agrave; presenti:<ol>");
define("_btduplinfo","<p>Se il tuo file corrisponde ad uno di questi ti preghiamo di lanciare un .torrent gi&agrave; esistente, grazie!</p>");
define("_btsocktout","ERRORE: Socket time-out");
define("_bttrackernotresponding","Il tracker specificato non risponde.<br>Devi verificare di aver scritto correttamente il nome del tracker (NIENTE SPAZI) e che esso sia in funzione. Tracker specificato:");
define("_bttrackerdata","Il tracker esterno ha risposto con dei dati non corretti. Potrebbero esserci problemi di rete sul tracker. Ti invitiamo a riprovare pi&ugrave; tardi.");
define("_bttorrentnotregistered","Il Torrent non risulta registrato al tracker esterno. Puoi caricare solo Torrent Esterni solo se attivi sul tracker.");
define("_btnoseedersontracker","Il tracker esterno ha risposto confermando la presenza del file ma con nessuna fonte completa. Ti ricordiamo che il file deve essere gi&agrave; presente sull'altro tracker con almeno un seeder per essere inserito sul nostro sito.");
define("_btuploadcomplete","Upload effettuato correttamente, tra 3 secondi verrai ridiretto sulla scheda del file. Ricordati di lanciare il .TORRENT o il tuo file non verr&agrave; visualizzato pubblicamente!<br>Se non dovessi essere ridiretto puoi raggiungere la pagina da <a href=\"**url**\">questo link</a>");

//TESTI CHE COMPAIONO IN TAKECOMPLAINT.PHP
define("_btcomplisnowbanned","Visto il numero di lamentele, il Torrent &egrave; stato bannato dal sistema");
define("_btcomplcantvotetwice","Siamo spiacenti, ma non &egrave; possibile inviare due giudizi.");
define("_btcomplainttaken","Votazione effettuata. Tra tre secondi verrai rediretto sulla pagina del Torrent. In caso di problemi clicca su ");
define("_btcomplsuccess","La tua opinione &egrave; stata registrata. Nome utente e IP sono loggati, quindi non abusare del sistema.<BR>");

//SHOUTBOX
define("_btshoutbox","Urlobox");
define("_btnoshouts","Nessuno urla...");
define("_btshoutnow","Urla!");

//TESTO ALTERNATIVO IMMAGINI
define("_btalt_auth_none.gif","Non ci sono autorizzazioni in attesa");
define("_btalt_auth_pending.gif","Ci sono autorizzazioni in attesa!");
define("_btalt_sticky.gif","Questo è un Torrent in Evidenza");
define("_btalt_download.gif","Scarica");
define("_btalt_edit.gif","Modifica");
define("_btalt_drop.gif","Elimina");
define("_btalt_exeem.gif","Scarica con eXeem");
define("_btalt_error.gif","Errore");
define("_btalt_icon_admin.gif","Amministratore");
define("_btalt_icon_premium.gif","Premium");
define("_btalt_1.gif","Assolutamente Pessimo");
define("_btalt_1.5.gif","Pessimo");
define("_btalt_2.gif","Molto Brutto");
define("_btalt_2.5.gif","Brutto");
define("_btalt_3.gif","Medio");
define("_btalt_3.5.gif","Sopra la Media");
define("_btalt_4.gif","Buono");
define("_btalt_4.5.gif","Ottimo");
define("_btalt_5.gif","Eccellente");
define("_btalt_anon_tracker.gif","Tracker Anonimizzato");
define("_btalt_button_aim.gif","AOL Instant Messenger");
define("_btalt_button_icq.gif","ICQ");
define("_btalt_button_irc.gif","Internet Realtime Chat");
define("_btalt_button_msn.gif","MSN Messenger");
define("_btalt_button_yahoo.gif","Yahoo! Messenger");
define("_btalt_ed2k_active.gif","Scarica con Link eDonkey2000 Alternativo");
define("_btalt_ed2k_inactive.gif","Link Alternativo non disponibile");
define("_btalt_magnet_active.gif","Scarica con Link Magnet Alternativo");
define("_btalt_magnet_inactive.gif","Link Alternativo non disponibile");
define("_btalt_green.gif","Veloce");
define("_btalt_yellow.gif","Lento");
define("_btalt_red.gif","Fermo");
define("_btalt_quest.gif","Link");
define("_btalt_lock.gif","In Attesa di Autorizzazione");
define("_btalt_lock_request.gif","Richiedi Autorizzazione");
define("_btalt_noavatar.gif","Nessun Avatar");
define("_btalt_pic_uploaded.gif","Dati Inviati");
define("_btalt_pic_downloaded.gif","Dati Scaricati");
define("_btalt_pic_ratio.gif","Rapporto");
define("_btalt_icon_active.gif","Attivo");
define("_btalt_icon_passive.gif","Passivo");

define("_btunknownclient","Client Sconosciuto");
define("_btalt_avatar","Avatar per **user**");

//STATISTICS
define("_btstats","Statistiche");

//MESSAGGI PRIVATI
define("_btyougotpm","Hai nuovi messaggi!");
define("_btpmintro","Qui puoi leggere i messaggi che gli altri utenti ti hanno inviato. Non c'&egrave; limite massimo di memorizzazione.
Tuttavia ti consigliamo di cancellare periodicamente i messaggi vecchi. Puoi inoltre inviare messaggi a tutti gli utenti registrati a questo Tracker.");
define("_btinbox","Posta in arrivo");
define("_btpmnomessages","Non ci sono messaggi");
define("_btpmsub","Oggetto");
define("_btpmfrom","Da");
define("_btpmdate","Data");
define("_btplmselect","Seleziona");
define("_btpmread","Letto");
define("_btpmunread","Non letto");
define("_btpmnewmsg","Nuovo messaggio");
define("_btpmdelete","Cancella messaggi");
define("_btpmdelall","Cancella tutti i messaggi");
define("_btpmdelconfirm","Vuoi cancellare i messaggi selezionati?");
define("_btpmdelbtn","Cancella messaggi");
define("_btpmdelallconfirm","Vuoi cancellare <b>tutti</b> i tuoi messaggi privati?");
define("_btpmdeletedsuccessfully","Messaggi cancellati correttamente");
define("_btnewpm","Nuovo messaggio");
define("_btpmto","Destinatario");
define("_btpmtotip","Se vuoi spedire un messaggio a pi&ugrave; utenti, separali con un punto e virgola (;)");
define("_btpmshowbookmarks","Mostra/nascondi la rubrica");
define("_btpmtext","Testo del messaggio");
define("_btpmnorecipient","Nessun destinatario specificato");
define("_btpmnosubject","Oggetto non specificato");
define("_btpmnomessage","Messaggio vuoto");
define("_btpminvalidrecipients","Uno o pi&ugrave; destinatari non esiste");
define("_btpmsentsuccessfully","Messaggio inviato correttamente");
define("_btmessage","Messaggio");
define("_btinvalidpm","Messaggio non valido");
define("_btpmnoexists","Il messaggio non esiste");
define("_btpmreply","Rispondi");
define("_btuserlists","Utenti preferiti e ignorati");
define("_btuserlistsintro","Qui puoi gestire le liste degli utenti preferiti e ignorati. I primi sono rapidamente disponibili in rubrica per l'invio di messaggi,
mentre dai secondi non riceverai alcun messaggio. Puoi cambiare lo stato di un utente dal suo profilo. In ogni caso questi non potr&agrave; mai sapere nulla sulle tue scelte.");
define("_btpmbookmarks","Utenti preferiti");
define("_btpmblacklist","Utenti ignorati");

//OVERLIB HELP
#NIENTE ANDATE A CAPO!!!
define("_btperformance","Prestazioni");
define("_btdht","Supporto DHT");
define("_bttorrentspd","Velocit&agrave; complessiva: ");
define("_btleechspd","Velocit&agrave; stimata: ");
define("_btedt","Al completamento: ");
define("_btinfohashhelp","L'Info Hash &egrave; un codice di breve lunghezza che serve ad identificare UNIVOCAMENTE un Torrent.<br>Ci&ograve; vuol dire che non possono esistere due Torrent con uguale Info Hash. Questo garantisce il 100% di sicurezza sulla qualit&agrave; dei file che scarichi.");
define("_btdhtexplanation","Questo Torrent ha il supporto DHT. I client pi&ugrave; evoluti possono effettuare il download distribuito da fonti indipendenti dal tracker. Ci&ograve; permette di prevenire cadute del tracker e garantire l'anonimato.");
define("_btavatarnotice","Gli avatar in upload possono avere dimensione massima di 100x100 pixel, devono essere in formato GIF, JPEG o PNG e non devono superare i 300KB");
define("_btcustomsearch","RDF Ricerca");
define("_btcustomsearchexplain","Sottoscrivi la tua ricerca personalizzata cliccando qui! Usa il tuo lettore RDF per tenerti aggiornato sui Torrent che preferisci, e solo su quelli!");

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
