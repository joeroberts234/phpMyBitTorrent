<?php
/*
*----------------------------phpMyBitTorrent V 2.0-beta4-----------------------*
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
*------              ?2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/


if (eregi("french.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

define("_LOCALE","en_UK");

//News du site

define ( "_btsitenews", "Actualités");
define ( "_btstart", "Merci d'avoir choisi phpMyBitTorrent <br /> <br />
phpMyBitTorrent éléments à part entière Tracker BitTorrent écrit en PHP, torrent externes indexation, DHT, annoncent Compact, Autres liens (ed2k, Magnet), l'authentification HTTP de base, Passkey Authentication, and Embedded HTML Editor, Mass Torrent Upload et bien plus encore. Vous pouvez retirer ou de remplacer cette actualité dans Administration> Paramètres ");

//Search Cloud
define ( "_btsearchcloud", "Search Cloud");
define ( "_btsearchcloudexplain", "Recherches les plus populaires. Une sélection aléatoire de la population des termes de recherche, pesé par fréquence.");
//Dons Block
define ( "_btdonations", "dons");
define ( "_btdonationsgoal", "Objectif:");
define ( "_btdonationscollected", "Collected:");
define ( "_btdonationsprogress", "Don Progress");
define ( "_btdonationsdonate", "DON");

//COMPLAINTS
function getcomplaints() {
        return Array(0=>"Legal Content, Good Quality",1=>"Fake or Corrupted",2=>"Copyrights Violation",3=>"Pornographic Content",4=>"Child Pornography",5=>"Offensive Content",6=>"Content Related to Illegal Activity");
}
//NewTorrent shout
define ( "_btuplshout", "Salut, je viens de nom Uploaded <b> ** ** </ b>. Profitez-en!");
define ( "_btnewtsh", "Shout Out New Torrent");
define ( "_btnewshex", "Cliquez ici si vous souhaitez ajouter une Shout Shout Box dans le propos de votre nouveau Envoyez sinon laissez l'absence!");

//CLASSI
define ( "_btclassuser", "Utilisateur");
define ( "_btclasspremium", "Premium User");
define ( "_btclassmoderator", "modérateur");
define ( "_btclassadmin", "Administrateur");

//ACCESSO NEGATO
define ( "_btaccdenied", "Accès refusé");
define ( "_btdenuser", "La zone que vous essayez d'accès est limité aux utilisateurs enregistrés <b> </ b>. <br> S'il vous plaît fournir votre accès pouvoirs et essayez à nouveau. Si vous n'êtes pas encore inscrits, vous pouvez <a href=\"user.php?op=register\"> FAIRE </ a> gratuitement. ");
define ( "_btdenpremium", "La zone que vous essayez d'accès est limité aux utilisateurs Premium <b> </ b>. <br>");
define ( "_btdenpremium1", "S'il vous plaît fournir votre accès pouvoirs et essayez à nouveau. Si vous n'avez pas un compte Premium, s'il vous plaît contacter notre personnel pour
des informations détaillées sur l'abonnement Premium. ");
define ( "_btdenpremium2", "Votre compte n'est pas activé pour accéder à des services Premium. S'il vous plaît contacter notre personnel pour
des informations détaillées sur l'abonnement Premium. ");
define ( "_btdenadmin", "La zone que vous essayez d'accès est limité aux administrateurs <b> </ b>. <br>");
define ( "_btdenadmin1", "Si vous avez d'administrateur s'il vous plaît fournir les maintenant, sinon, nous vous demandons de quitter cette page et revenir à
<a href=\"index.php\"> Home Page </ a >.");
define ( "_btdenadmin2", "Votre compte ne dispose pas des privilèges d'administrateur. S'il vous plaît Connectez-vous avec les pouvoirs ou de quitter cette page et
revenir à la page d'accueil <a href=\"index.php\"> </ a >.");
define ( "_btbannedmsg", "Vous avez été bannis de ce site, parce que: la raison <b> ** ** </ b>");

//GENERICS
define ( "_DATESTRING", "% A,% B% Y% d @% T% Z");
define ( "_btpassword", "Mot de passe");
define ( "_btusername", "User Name");
define ( "_btremember", "Remember Me");
define ( "_btsecuritycode", "Code de la sécurité");
define ( "_btusermenu", "Menu utilisateur");
define ( "_btmainmenu", "Menu principal");
define ( "_btgenerror", "phpMyBitTorrent Erreur");
define ( "_btmenu", "Menu");
define ( "_btumenu", "Menu utilisateur");
define ( "_btsyndicate", "syndication");
define ( "_btlegend", "Legend");
define ( "_btircchat", "Chat IRC");
define ( "_btchatnotenabled", "Chat IRC n'est pas activée sur ce site.");
define ( "_btlostpassword", "Mot de passe perdu?");
define ( "_btmakepoll", "Sondages");

//EMAIL SPELLING
define ( "_at", "au");
define ( "_dot", "dot");

//SQL ERREURS
define ( "_btsqlerror1", "Erreur d'exécution de requêtes SQL");
define ( "_btsqlerror2", "Numéro d'erreur:");
define ( "_btsqlerror3", "Message d'erreur:");

//ERREUR HTTP
define ( "_http400errttl", "Erreur HTTP 400 - Bad Request");
define ( "_http400errtxt", "A 400 Une erreur s'est produite lors du traitement de votre demande. \ n
S'il vous plaît vérifier les paramètres de votre navigateur et essayez à nouveau accéder à la page demandée. \ N
Contact e-mail ** ** Si vous rencontrez des problèmes. ");
define ( "_http401errttl", "Erreur HTTP 401 - Access Denied");
define ( "_http401errtxt", "A HTTP 401 Erreur lors du traitement de votre demande. <br>
Vous ne pouvez pas accéder à la page, car vous ne sont pas autorisés. <br>
S'il vous plaît fournir votre accès de vérification des pouvoirs, si vous en avez. <br>
Contact e-mail ** ** Si vous rencontrez des problèmes. ");
define ( "_http403errttl", "Erreur HTTP 403 - Interdit");
define ( "_http403errtxt", "A 403 HTTP erreur s'est produite lors du traitement de votre demande. <br>
Vous ne pouvez pas accéder à la page demandée parce que la configuration de serveur ne permet pas de vous. <br>
S'il vous plaît vérifier soigneusement l'adresse URL de votre navigateur, et le corriger si nécessaire. <br>
Contact e-mail ** ** Si vous rencontrez des problèmes. ");
define ( "_http404errttl", "HTTP Error 404 - Not Found");
define ( "_http404errtxt", "A 404 HTTP erreur s'est produite lors du traitement de votre demande. <br>
La page demandée n'existe pas. <br>
S'il vous plaît vérifier l'URL dans votre navigateur avec soin, et les corriger si nécessaire. <br>
Contact e-mail ** ** Si vous rencontrez des problèmes. ");
define ( "_http500errttl", "HTTP Error 500 - Internal Server Error");
define ( "_http500errtxt", "A 500 HTTP erreur s'est produite lors du traitement de votre demande. <br>
Une erreur s'est produite lors du traitement de vos données. <br>
Informations détaillées peuvent être trouvées dans les logs du serveur. <br>
S'il vous plaît envoyer un rapport détaillé à ce sujet à ** email **");

//USER BLOC
define ( "_btyoureseeding", "vous êtes Torrents de semis");
define ( "_btyoureleeching", "Torrents vous Downloading");
define ( "_btuserstats", "Statistiques utilisateur");
define ( "_bttotusers", "Utilisateurs");
define ( "_btlastuser", "Dernier inscrit:");
define ( "_bttorrents", "Available Torrents:");
define ( "_bttotshare", "Partager Total:");
define ( "_bttotpeers", "Connected Peers:");
define ( "_bttotseed", "Total Semoirs:");
define ( "_bttotleech", "Total Peers:");


//TESTI COMPAIONO CHE DANS USER.PHP
define ( "_btregwelcome", "<P align=\"center\"> Bienvenue! </ P>
Inscrivez-<P> un compte pour rejoindre notre communauté. Cela vous permettra d'utiliser la gamme complète de services de ce site, et il ne vous prendra que quelques minutes. Choisissez un nom d'utilisateur et un mot de passe, et de fournir une adresse e-mail. En quelques minutes, vous recevrez un e-mail, vous demandant de confirmer l'enregistrement. </ P> ");
define ( "_btreggfxcheck", "<P align=\"center\"> S'il vous plaît aussi le code de sécurité ci-après (empêche les bots de l'Enregistrement). <BR> Contact e-mail ** ** Si vous rencontrez des problèmes de lecture de ce code. </ P> ");
define ( "_btemailaddress", "E-mail Address");
define ( "_btpasswd", "Mot de passe (5 Ombles minimum)");
define ( "_btpasswd2", "Confirmer le mot de passe");
define ( "_btsubmit", "Inscription");
define ( "_btreset", "Modifications Annuler");
define ( "_btdisclaimer", "Termes et Conditions:");
define ( "_btdisclaccept", "I Accept");
define ( "_btdisclrefuse", "Je n'accepte pas");
define ( "_btgfxcode", "Code de la sécurité");
define ( "_btsignuperror", "Erreur lors de processus d'inscription");
define ( "_bterruserexists", "Nom d'utilisateur existe déjà.");
define ( "_btfakemail", "L'Adresse e-mail que vous avez entré n'est pas valide.");
define ( "_bterremailexists", "L'Adresse e-mail que vous avez saisi est déjà enregistré. souhaitez récupérer votre mot de passe? Go <a href=\"user.php?op=lostpassword\"> ICI </ a>");
define ( "_btpasswnotsame", "Les mots de passe que vous avez entrés ne sont pas les mêmes");
define ( "_bttooshortpass", "Le mot de passe que vous avez entré est trop court. Longueur minimale est de 5.");
define ( "_bterrcode", "Le code de sécurité que vous avez entré est incorrect");
define("_btdisclerror","You MUST ACCEPT our Disclaimer in order to Sign Up.");
define ( "_btgoback", "S'il vous plaît aller et vérifier la forme");
define ( "_btregcomplete", "Signup presque terminée. Vous avez 24 heures pour confirmer votre inscription. Si vous ne recevez pas le
E-mail de confirmation, sil vous plaît vérifier les données que vous avez entrés. Si vous rencontrez des problèmes, sil vous plaît contacter Webmaster à ** email **");
define ( "_bterrusernamenotset", "Nom d'utilisateur non spécifié.");
define ( "_bterrkeynotset", "Clé d'activation non spécifiée");
define ( "_bterrusernotexists", "Ce nom d'utilisateur n'existe pas.");
define ( "_bterrinvalidactkey", "clé d'activation n'est pas correcte.");
define ( "_btuseralreadyactive", "l'utilisateur est déjà active. Plus Activation obligatoire");
define ( "_btacterror", "Erreur d'activation");
define ("_btactcomplete","Activation Complete. Your Account is now Permanently Active. From now on you can Access
our services using the Username and Password you provided. Have a nice download.");
define ( "_btusrpwdnotset", "Nom dutilisateur ou mot de passe non spécifié.");
define ( "_bterremailnotset", "E-mail non spécifié.");
define ( "_btuserpasswrong", "Nom d'utilisateur ou mot de passe incorrect !!");
define ( "_btuserinactive", "utilisateur enregistrés mais non active !!");
define ( "_btloginsuccessful", "Connexion réussie. Vous avez maintenant priv ** ** privilèges. Have a nice download!");
define ( "_btlogoutsuccessful", "Déconnexion réussie.");
define ( "_btusernoexist", "Désolé, lutilisateur que vous avez saisi n'existe pas.");
define ( "_btuserprofile", "User Control Panel");
define ( "_btedituserprofile", "Edit Profile");
define ( "_btusertorrents", "My Torrents");
define ( "_btcompletename", "Nom complet");
define ( "_btclass", "Niveau");
define ( "_btclassbanned", "Interdit!");
define ( "_btregistered", "inscription");
define ( "_btavatar", "Avatar");
define ( "_btcontacts", "Contacts");
define ( "_btnewavatargallery", "Avatar de la Nouvelle Galerie");
define ( "_btnewavatarupload", "Upload New Avatar");
define ( "_btinvalidimagefile", "Image non valide");
define ( "_btavatartoobig", "va au-delà de l'image permis Size");
define ( "_btlostpasswordintro", "Si vous avez perdu votre mot de passe, vous pouvez ré-accéder à votre compte en entrant votre nom d'utilisateur et un nouveau mot de passe. <br />
Un mail de confirmation sera envoyé à ladresse e-mail associée à votre compte. Assurez-vous que vous pouvez recevoir du courrier (c'est-à-dire votre boîte aux lettres n'est pas pleine) avant de soumettre votre demande. Si vous ne recevez pas ce mail, vérifiez votre filtre de spam. ");
define ( "_btlostpasswordcheckmail", "Un message a été envoyé à votre adresse e-mail contenant un lien de confirmation. S'il vous plaît cliquer sur ce lien pour le changement de mot de passe de prendre effet.");
define ( "_btlostpwdinvalid", "Code de confirmation incorrect ou user ID");
define ( "_btlostpwdcomplete", "Mot de passe modifié. Maintenant, vous pouvez vous identifier avec votre nouveau mot de passe.");
define ( "_btdeluser", "Suppression du compte");
define ( "_btdeluserwarning", "<b> ATTENTION </ b>: vous êtes sur le point de définitivement et complètement supprimer votre compte. Vous perdrez Modification autorisations pour tous vos torrents que vous avez téléchargé. Vous serez en mesure de ré-enregistrer auprès de votre ancien nom d'utilisateur après que. ");
define ( "_btdeluserwarningadm", "<b> ATTENTION </ b>: vous êtes sur le point de complètement et définitivement Supprimer utilisateur ** ** 's compte. ** ** Édition autorisations utilisateur pour tous les torrents, il / elle téléchargés. Re - enregistrement avec le même nom d'utilisateur sera possible après cette date. ");
define ( "_btaccountdeleted", "Compte supprimé");
define ( "_btconfirmdelete", "Confirmer la suppression du compte");
define ( "_btuserdelete", "Supprimer le compte");
define ( "_btuserban", "Interdiction de compte");

define ( "_btnewpassword", "Nouveau mot de passe <br /> (laisser en blanc si vous n'avez pas l'intention de le modifier)");
define ( "_btnewpasswordconfirm", "Confirmer le nouveau mot de passe");
define ( "_btaol", "AOL Instant Messenger");
define ( "_bticq", "ICQ");
define ( "_btjabber", "Jabber IM");
define ( "_btmsn", "MSN Messenger");
define ( "_btskype", "Skype");
define ( "_btyim", "Yahoo! Instant Messenger");
define ( "_btacceptmail", "Accepter E-mail par d'autres utilisateurs");
define ( "_btcustomlanguage", "Langue");
define ( "_btaccountstatus", "l'état du compte");
define ( "_btaccountstatusexplain", "Set utilisateur actif / inactif. ATTENTION! Définition d'un utilisateur qui a été enregistrée depuis plus de 48h à INACTIVE également supprimer le compte.");
define ( "_btaccountactive", "active");
define ( "_btaccountinactive", "inactifs");
define ( "_btcustomtheme", "Theme");
define ( "_btdefault", "par défaut");
define ( "_btchooseavatar", "Choisir Avatar");
define ( "_btusepasskey", "Utiliser Passkey");
define ( "_btpasskeyexplain", "Cette option vous permet de télécharger des torrents en utilisant un code de sécurité personnel. <br />
Utilisation d'un état de l'art-client, vous n'aurez plus à vous connecter au tracker ou l'utilisation du nom d'utilisateur et mot de passe afin d'obtenir votre Ratio Mise à jour pour l'intérieur de chenilles Torrents. <br />
Un code personnalisé est automatiquement inséré dans le fichier. Torrent fichier que vous téléchargez, afin de permettre l'authentification Tracker. <br />
<b> ATTENTION </ b>: ne partagent pas. torrents avec Enabled Passkey Authentication out! Les utilisateurs non autorisés, même sans connexion que vous, mai les utiliser et de l'influence de votre ratio, qui mai, à son tour, réduire vos autorisations de téléchargement sur le Tracker. <br />
Dans le cas d'un. Torrent NE automne dans de mauvaises mains, vous pouvez réinitialiser le Passkey. ");
define ( "_btresetpasskey", "Reset Passkey");
define ( "_btresetpasskeywarning", "<b> ATTENTION </ b>: tous les fichiers torrent téléchargés jusqu'à présent ne seront pas valables plus!");
define ( "_btprofilesaved", "Profil Successfully Saved!");
define ( "_btaccesslevel", "Niveau d'accès");
define ( "_btdeleteaccount", "Supprimer le compte");

define ( "_btindex", "Index");
define ( "_bttorrentupload", "Upload Torrent");
define ( "_btupload", "Envoyer");
define ( "_btlogin", "Connexion");
define ( "_btlogout", "Log Out");
define ( "_btsignup", "Inscription");
define ( "_btpersonal", "Vos Torrents");
define ( "_btpm", "Messages");
define ( "_btadmod", "modérateur");
define ( "_btadmin", "Administration");
define ( "_btrulez", "Règlement");
define ( "_btforums", "Forum");
define ( "_bthelp", "Aide");
define ( "_btadvinst", "Install BitTorrent ou Shareaza Télécharger");
define ( "_btaccessden", "Accès refusé. href=\"user.php?op=register\"> <A Nécessite le téléchargement d'inscription </ a>");
define ( "_btlegenda", "Aide à la vedette et la légende");
define ( "_btyourfilext", "Votre fichier externe Tracker");
define ( "_btfile", "fichier (s)");
define ( "_btexternal", "External Tracker");
define ( "_btyourfile", "Votre dossier");
define ( "_btsticky", "Sticky");
define ( "_btauthforreq", "Autorisation de la demande");
define ( "_btauthreq", "Demande d'autorisation");
define ( "_btdown", "Télécharger");
define ( "_btunknown", "Unknown");
define ( "_btrefresh", "Update");
define ( "_btvisible", "visible");
define ( "_btsd", "SD");
define ( "_btlc", "LC");
define ( "_bttt", "TOTAL");
define ( "_btseedby", "Je suis Torrents semis");
define ( "_btleechby", "Je suis la lixiviation Torrents");
define ( "_btpersonalstats", "Personal Stats");
define ( "_btgeneral", "General");
define ( "_bthtml", "HTML");
define ( "_btcategory", "Categories");

//TESTI COMPAIONO CHE dans index.php
define("_btinfituh","<p>You have ".$user->invites." Invites</p>");
define ( "_btsendiv", "Envoyer une invitation");
define ( "_btinvites", "invite");
define ( "_btgames", "Jeux");
define ( "_btsedbs", "Seeding Bonus:");
define ( "_btviewrqst", "Voir Demande");
define ( "_btfaqs", "FAQ");
define ( "_bttorofferd", "Torrents offerts");
define ( "_btmemlist", "Liste des Membres");
define ( "_btwelcomebk", "Welcome Back");
define ( "_btwelcome", "Bienvenue sur $sitename");
define ( "_btneedseed", "les torrents qui ont besoin de semis");
define ( "_btifyhhelpthem", "S'il vous plaît, aidez-les, si vous avez les fichiers sur votre disque dur. Thank you!");
define ( "_btntnseeded", "No Need Torrents semis");
define ( "_btsearch", "Recherche");
define ( "_btsearchname", "Recherche Torrents");
define ( "_btsearchfeed", "Feed pour ces résultats");
define ( "_btin", "in");
define ( "_btalltypes", "tout");
define ( "_btactivetorrents", "Active Torrents");
define ( "_btitm", "Include Dead Torrents");
define ( "_btstm", "Dead Torrents seulement");
define ( "_btgo", "Go!");
define ( "_btresfor", "Ordre:");
define ( "_btnotfound", "Pas de résultats <h2>! </ h2> \ n <p> Essayez de changer vos termes de recherche. </ p> \ n");
define ( "_btvoidcat", "<h2> Cette catégorie est vide! </ h2>");
define ( "_btorderby", "Ordre");
define ( "_btinsdate", "Date");
define ( "_btname", "Nom");
define ( "_btdim", "Taille");
define ( "_btnfile", "Nombre de fichiers");
define ( "_btevidence", "Sticky");
define ( "_btcomments", "Evaluation / Commentaires");
define ( "_btvote", "Evaluation");
define ( "_btdownloaded", "Downloaded");
define ( "_btprivacy", "Confidentialité");
define ( "_bttotsorc", "Total Peers");
define ( "_btdesc", "Descendant");
define ( "_btord", "Ascendant");

define("_btnosearch","<center><h2>Search the files you would like to download</h2>If you need help, try asking in the Forums; if you cannot use Magnet:/eD2K: links you probably haven't installed the right software<br>We remind you that our Rules state that all files are Private, and it's up to whoever shares a file whether he/she Allows other people to download. It's Strictly Forbidden to Share Copyrighted, Porn, Child-Porn, Racist, Offending material or anything that Violates any Laws.<br>Any Copyright holder can Request the implementation of a free filename filter that allows to protect his/her Copyrights.</center>");
define ( "_bthelpfind", "Aide à la recherche");
define ( "_bttypeCAT", "Catégorie");
define ( "_bttypes", "Categories");
define ( "_bttopsource", "le téléchargement des sources TOP");
define ( "_btnotopsource", "Il n'y a pas d'Active Torrents en ce moment");
define ( "_btnotseeder_noneed", "Il n'y a pas de critique Torrents en ce moment");
define ( "_btnotseeder_desc", "Si vous avez un de ces fichiers, s'il vous plaît Seed (part) avec des gens qui sont en attente pour le télécharger. Télécharger le fichier. torrent, le point de votre client dans le répertoire qui contient le fichier complet, et il va commencer semis. <br> Merci d'être l'un des GOOD GUYS / GALS. </ b> ");
define ( "_btnoseedersontracker", "Vos Seeded Torrent n'est PAS!");
define ( "_btdeadtorrent", "Il semble que votre torrent <b> Seeded n'est PAS </ b>. Ce jugement pourrait ne pas être correcte, nous allons accepter le téléchargement pour le moment, mais <b> Modérateurs mai considérer ultérieurement </ b>. <br> ");
define ( "_bthelpindex", "<p> <a name=\"HELP\"> </ a> <a href='index_help.php'> Installer Shareaza ou BitTorrent pour télécharger </ a>");
define ( "_btnet", "Santé Swarm");
define ( "_btsource", "Seed");
define ( "_bttorrent", "Torrent");
define ( "_btview", "Vu");
define ( "_bthits", "Downloaded");
define ( "_btsnatch", "Terminé");
define ( "_btalternatesource", "seulement <b> Autres sources (Magnet/ed2K) disponible </ b>");
define ( "_btcantscrape", "Impossible de déterminer <b> Peer données </ b>");
define ( "_bteasy", "Well-Seeded <b> </ b>");
define ( "_btmedium", "Pas si <b> Grande </ b>");
define ( "_bthard", "<b> mal Seeded / Dead </ b>");
define ( "_btmisssearchkey", "Missing Key Search");
define ( "_btinfotracker", "Qui est en ligne?");
define ( "_btnouseronline", "il n'ya pas d'inscription Utilisateurs en ligne");
define ( "_btonlineusers", "Utilisateurs en ligne");
define ( "_btadvancedmode", "Advanced Mode");
define ( "_btsimplemode", "Simple Mode");
define ( "_btpagename", "Documents de navigation");
define ( "_btloggedinfor", "pour Logged");
define ( "_jscriptconfirmtext", "vous avez un nouveau PM, s'il vous plaît cliquez sur OK pour accéder à votre boîte de réception AM.");
define ( "_newpm", "New PM");
define ( "_btpmwrote", "écrit:");
define ( "_nonewpm", "Non PM NEW");
define ( "_btbrowse", "Parcourir");

//PMBT PAGES
define ( "_btpage_donate.php", "dons");
define ( "_btpage_admin.php", "Administration");
define ( "_btpage_chat.php", "Chat");
define ( "_btpage_details.php", "Torrent Details Page");
define ( "_btpage_edit.php", "Edit Torrent");
define ( "_btpage_index.php", "Home");
define ( "_btpage_", "Home");
define ( "_btpage_mytorrents.php", "Panneau de configuration Torrent");
define ( "_btpage_search.php", "Recherche");
define ( "_btpage_upload.php", "Envoyer");
define ( "_btpage_phpBB.php", "Affichage Forum");
define ( "_btpage_pm.php", "Utilisation de la messagerie privée");
define ( "_btpage_games.php", "Affichage Game Panel");
define ( "_btpage_casino.php", "Jouer Casino");
define ( "_btpage_arcade.php", "Playing In The Game Room");
define ( "_btpage_keno.php", "Keno Jouer");
define ( "_btpage_blackjack.php", "Black-Jack Jouer");
define ( "_btpage_viewrequests.php", "Affichage Demande");
define ( "_btpage_faq.php", "Lecture F.A.Q");
define ( "_btpage_offers.php", "Affichage d'offres");
define ( "_btpage_offer.php", "Faire une offre");
define ( "_btpage_requests.php", "Faire une demande");
define ( "_btpage_memberslist.php", "Affichage de la liste des membres");
define ( "_btpage_rules.php", "les règles de lecture du site");
define ( "_btpage_torrents.php", "Affichage Torrent List");
define ( "_btpage_user.php", "Affichage de l'utilisateur Panneau de configuration");
define ( "_btpage_flash.php", "Lecture d'un jeu");
define ( "_btpage_flashscores.php", "Affichage des scores de jeux");
define ( "_btpage_flashscores2.php", "Affichage des scores de jeux");
define ( "_btpage_mybonus.php.php", "il ya des dépenses de points de bonus");
define ( "_btpage_mybonuse.php.php", "il ya des dépenses de points de bonus");







//TESTI COMPAIONO CHE DANS DETAILS.PHP
define ( "_btinfo", "Torrent Info");
define ( "_bttracker", "Tracker");
define ( "_btddownloaded", "Downloaded");
define ( "_btdcomplete", "Terminé");
define ( "_dtimeconnected", "Time Connected");
define ( "_btsourceurl", "disponible sur");
define ( "_btdidle", "Pause");
define ( "_btdsuccessfully", "Torrent Uploaded Successfully");
define ( "_btdsuccessfully2", "S'il vous plaît de début de semis NOW. visibilité dépend du nombre de sources");
define ( "_btdsuccessfullye", "Edited Successfully");
define ( "_btdgobackto", "Retour à la page");
define ( "_btdwhenceyoucame", "où l'on vient");
define ( "_btdyoursearchfor", "Your Search for");
define ( "_btnotorrent", "Torrent n'existe pas ou a été interdite");
define ( "_btdratingadded", "Rating Added");
define ( "_btdspytorrentupdate", "a SpyTorrent Mise à jour de la source");
define ( "_btdspytorrentupdate1", "Vous allez être redirigé vers la page en 3 secondes");
define ( "_btdspytorrentupdate2", "Si votre navigateur ne vous redirige pas, cliquez sur");
define ( "_btdspytorrentupdate3", "Ici");
define ( "_btdspytorrentnoupdate", "Il n'est pas nécessaire d'exécuter SpyTorrent intérieur Torrents dans les 15 minutes depuis le dernier scan.");
define ( "_btdownloadas", "Télécharger le");
define ( "_btpieces", "Pieces");
define ( "_btpiecesstring ","** pièces n ** ** ** l de la taille");
define ( "_btauthstatus", "Télécharger Autorisation");
define ( "_btdwauthpending", "en attente");
define ( "_btdwauthgranted", "Accordé!");
define ( "_btdwauthdenied", "Refusé!");
define ( "_btdwauthnorequest", "pas encore fait de demande");
define ( "_btpremiumdownload", "Seuls les utilisateurs peuvent Premium Téléchargez ce Torrent File");
define ( "_btregistereddownload", "Vous devez Inscrivez-vous ou connectez-vous pour télécharger ce Torrent");
define ( "_btnetwork", "network");
define ( "_btdays", "d");
define ( "_bthours", "h");
define ( "_btmins", "m");
define ( "_btsecs", "s");
define ( "_btinfohash", "Info Hash");
define ( "_btinfohashnotice", "<b> ATTENTION </ b>: le Torrent a été modifié de telle manière qu'il doit être re-téléchargé. Le fichier que vous avez téléchargé
n'est pas valable, pas plus. S'il vous plaît utilisez le bouton de téléchargement pour obtenir la version de travail. ");
define ( "_btnodead", "<b> NO </ b> (Dead)");
define ( "_btfiles", "fichier (s)");
define ( "_btothersource", "Autres sources");
define ( "_btnoselected", "Pas de sélection de la catégorie. S'il vous plaît revenir au formulaire.");
define ( "_btago","avant");
define ( "_btlastseeder", "Last Seeder");
define ( "_btlastactivity", "Dernière activité");
define ( "_bttypetorrent", "Type");
define ( "_btsize", "Taille");
define ( "_btminvote", "Non voter (nécessaire au moins __minvotes__ votes");
define ( "_btonly", "seulement");
define ( "_btnone", "none");
define ( "_btnovotes", "Non Rating");
define ( "_btoo5", "avec de 5");
define ( "_btvotestot", "Total Vote (s)");
define ( "_btcomplaints", "plaintes");
define("_btlogintorate","(<a href=\"user.php?op=loginform\">Log In</a> to Vote)");
define ( "_btvot1", "Bad");
define ( "_btvot2", "Pas bon");
define ( "_btvot3", "Not Bad");
define ( "_btvot4", "bon");
define ( "_btvot5", "Très bien");
define ( "_btaddrating", "Vote");
define ( "_btvotenow", "Note");
define ( "_btrating", "taux");
define ( "_bthelpstat", "Statistiques Aide");
define ( "_btviews", "Vu");
define ( "_bttimes", "Time (s)");
define ( "_btleechspeed", "Speed Leech");
define ( "_bteta", "ETA");
define ( "_btuppedby", "En ligne depuis");
define ( "_btnumfiles", "Nombre de fichiers");
define ( "_btfilelist", "Fichiers");
define ( "_btlasttrackerupdate", "Dernière mise à jour Tracker");
define ( "_btshowlist", "Afficher Peers");
define ( "_bthidelist", "Masquer les pairs");
define ( "_bthelpsource", "Peer Help");
define ( "_btseeds", "complet");
define ( "_btcommentsfortorrent", "Commentaires sur cette Torrent");
define ( "_btbacktofull", "Retour à la Full Details");
define("_btnotifyemailcom","If you want to be e-mailed when the First Comment is added, please click <a href=\"details.php?op=comment&trig=on&id=**id**#notify\">HERE</a>.");
define("_btnotnotifyemailcom","<p>You are currently listed to Receive Comment Email. If you Don't want to be e-mailed any more, please click <a href=\"details.php?op=comment&trig=off&id=**id**#notify\">HERE</a>.</p>");
define("_btclickhere","Cliquez Ici");
define("_btnotifyemail1s","If you want to be e-mailed when the First <b>SEED</b> shows up, please click <a href=\"details.php?op=seeder&trig=on&id=**id**#notify\">HERE</a>.");
define("_btnotnotifyemail1s","<p>You are currently listed to be Notified when a Seed pops up. If you don't want to be e-mailed any more, please click <a href=\"details.php?op=seeder&trig=off&id=**id**#notify\">HERE</a>.</p>");
define("_btnocommentsyet","There are NO Comments at this time");
define("_btcommheader","On **time**, <a href=\"user.php?op=profile&id=**uid**\" target=\"_top\">**user**</a> wrote:");
define("_btdgavesresult","has Returned One Result");
define ( "_btdnotifyemaildel", "Vous avez été supprimé de la Liste de notification");
define ( "_btdnotifyemaildel1", "Vous ne recevez pas plus d'e-mails quand un commentaire est ajouté!");
define ( "_btdnotifyemailadd1", "Vous recevrez un e-mail quand un commentaire est ajouté, mais vous ne recevrez plus d'e-mails avant de lire le commentaire!");
define ( "_btdnotifyemailadd", "Vous avez été ajouté à la Liste de notification");
define ( "_btdnotifyadd", "Vous avez été ajouté à la Liste Seeder Notification");
define ( "_btdnotifyadd2", "vous serez notifié des nouveaux Semoirs avec un maximum d'un e-mail tous les jours,");
define ( "_btdnotifydel", "Vous avez été supprimé de la Liste Seeder Notification, vous n'allez pas recevoir plus d'e-mails.");
define ( "_btddetails", "Torrent Details");
define ( "_bteditthistorrent", "Modifier Torrent");
define ( "_btyes", "oui");
define ( "_btno", "non");
define ( "_btadded", "Uploaded");
define ( "_btaddedby", "En ligne depuis");
define ( "_bton", "up");
define ( "_bthelpothersource", "Aide Autres sources");
define ( "_btfilename", "Nom de fichier");
define ( "_btpeers", "Sources");
define ( "_btpeerstot", "Total Source");
define ( "_bthelppeer", "Peer Help");
define ( "_btleecher", "Leecher");
define ( "_btleechers", "leechers");
define ( "_btdhelpdownload", "Aide pour le téléchargement");
define ( "_btyourate", "Vous avez voté");
define ( "_btupdatesource", "Mise à jour Sources maintenant!");
define ( "_btseeder", "Seed");
define ( "_btseeders", "Seeds");
define ( "_btcompletion", "complet");
define ( "_btdirectlink", "Direct Link");
define ( "_btcomplyouvoted", "Vous avez dit que ce Torrent est:");
define ( "_btcomplexplain", "Le Torrent mai être interdits lorsque des résultats d'un certain nombre de plaintes.");
define ( "_btcomplaintform", "Torrent formulaire de plainte. <BR> Ce système vous permet de Flag Torrents qui ne correspondent pas à notre règlement. <BR>
Une fois un certain nombre de plaintes est atteint, le Torrent mai être bannis de la liste. <BR> S'il vous plaît envoyer des commentaires positifs sur les torrents qui sont bonnes et juridiques. <BR> ");
define ( "_btcomplisay", "Ce n'est Torrent");
define ( "_btmagnetlink", "Magnet Link");
define ( "_btnomagnet", "Non Disponible Magnet Link");
define ( "_btmagnetlinkdownload", "Télécharger le fichier en utilisant Magnet Link");
define ( "_bted2klink", "Lien ed2k");
define ( "_btnoed2k", "Non Disponible ed2k Link");
define ( "_bted2klinkdownload", "Télécharger le fichier en utilisant ed2k Link");
define ( "_btcomplatthemoment", "Sent utilisateurs Evaluations positives <b> ** p ** </ b> fois et un feedback négatif <b> ** n ** </ b> fois. <BR>");
define ( "_btnotifications", "E-Mail Notifications");
define ( "_btreadcomms", "Lire les commentaires");
define ( "_btpostcomment", "Post a Comment");
define ( "_bttransfer", "transfert");
define ( "_btdownloadspeed", "Vitesse de téléchargement en aval");
define ( "_btuploadspeed", "Vitesse de téléchargement en amont");
define ( "_bttorrentpassword", "Protection par mot de passe");
define ( "_btpasswordquery", "Ce Torrent est protégé par mot de passe. Le propriétaire du Torrent a décidé de rendre visible qu'aux utilisateurs autorisés. <br /> S'il vous plaît fournir le mot de passe maintenant pour obtenir Torrent Instant Access.");
define ( "_btpasswordwrong", "Attention: Mot de passe incorrect. <br /> N'oubliez pas que les mots de passe sont sensibles à la casse.");
define("_btuploadedpassexplain","You Set the Password to: <b>**pass**</b>");
define ( "_btuploadedpassexplain2", "pour donner aux utilisateurs l'accès à votre Torrent, passer les suivantes Lien direct: <b> ** ** <b> url");
define ( "_btcompletedby", "Completed By");
define ( "_bttrackers", "Autres Trackers");
define ( "_bttrackergroup", "Group *");
define ( "_btexport", "Exporter");
define ( "_btexportexplain", "Téléchargez ce Torrent sans votre Passkey, pour la distribution sur les sites qui fournissent BitTorrent Index Services");


define ( "_btinseriti", "insérés");
define ( "_btand", "et");
define ( "_btnumerror", "leur nombre n'est pas égal, et il n'est pas possible de procéder à la cession Binary");
define ( "_btmaxchar", "ed2k URL ont un maximum de 200 caractères");
define ( "_bted2kstart", "L'URL doit commencer par <b> ed2k ://</ b>");
define ( "_bt2par", "URL Lacks le deuxième paramètre:");
define ( "_bturlfile", "file");
define ( "_bturlcontent", "ne contient pas d'URL");
define ( "_btfname", "filename");
define ( "_bturlsize", "ne contient pas d'URL");
define ( "_btsz", "size");
define ( "_btidcode", "hash info");
define ( "_bturlparerror", "URL ne contient pas le paramètre:");
define ( "_bturlsureerror", "L'URL contient une source illégale");
define ( "_bturlnotinsert", "Faut-Insérer une ed2k Link");
define ( "_btnotip", "IP non spécifiée");
define ( "_btinvip", "IP non valide");
define ( "_btnoport", "Non indiquée Port");
define ( "_btinvport", "Port incorrect");
define ( "_btparmag", "none");
define ( "_btnopresent", "Not Present");
define ( "_btmagchar", "MagnetURLs avoir un maximum de 200 caractères");
define ( "_bftminlimit", "Vous ne pouvez pas partager des fichiers de taille inférieure à");
define ( "_btfmaxlimit", "Vos Torrent contient un fichier qui est trop grand.");
define ( "_btillegalword", "Vos Torrent n'a pas fait par l'intermédiaire du contenu du filtre automatique pour la raison suivante (si spécifié ):.");
define ( "_btillegalwordinfo", "Si vous pensez que vous recevez ce message par erreur, s'il vous plaît contacter $ admin_email");
define ( "_btnoreason", "(No Reason indiquée");
define ( "_bturlinserted1", "Uploaded Torrent. Vous allez être redirigé dans 3 secondes. <BR> Si votre navigateur ne transmet pas, cliquez");
define ( "_bturlinserted2", "ce lien");
define ( "_btaddnotifycomment", "Vous avez été ajouté à la liste de notification: vous envoyez un e-mail sur les nouveaux commentaires.");
define ( "_btaddnotifyseeder", "Vous avez été ajouté à la liste de notification: vous envoyez un e-mail des nouvelles semences.");
define ( "_btnolinkinsert", "Pas de lien inséré");

define ( "_btexnostartwt", "Start eXeem Liens avec exeem ://");
define ( "_btinvalidexeem", "Invalid eXeem Link!");
define ( "_btillegalcat", "Catégorie illégale!");
define ( "_bttorrentpresent", "Le Torrent que vous essayez de transférer a déjà été envoyés à ce site, ou il a été interdit.");
define ( "_btdescrrequired", "Description de champ est vide. S'il vous plaît revenir en arrière et entrer dans une description.");


define ( "_btuploadatorrent", "Envoyer un Torrent File");
define ( "_btphotoext", "Image de dossier doit être GIF, JPG ou PNG");
define ( "_btalertmsg", "formulaire n'a pas été remis en raison des erreurs suivantes:");
define ( "_btalertmsg2", "S'il vous plaît le Fix erreurs et essayer d'Upload Again");
define ( "_btfnotselected", "ERREUR: Fichier non sélectionnés");
define ( "_btalertdesc", "S'il vous plaît entrez la description qui indique le type de fichier et de la qualité, en particulier en cas de Media Files");
define ( "_btalertcat", "Sélectionner une catégorie");
define ( "_btconferma", "prêt à transférer Si votre Torrent contient plusieurs fichiers, s'il vous plaît recréer en tant que multi-Archive contenant le dossier. Sinon, elle pourrait être inutilisable.");
define ( "_btalerturl", "Insérer un lien ed2k ou AIMANT");
define ( "_btalerturlnum1", "Lien ed2k Number");
define ( "_btalerturlnum2", "tout est Nombre AIMANT Link");
define ( "_btalerturlnum3", "Le numéro de l'Liens doit être la même - Torrents compose d'un couple de liens");
define ( "_btalert5char", "Nom de fichier doit être au moins 5 caractères");
define ( "_btofficialurl", "Ce site officiel du Tracker est:");
define ( "_btseeded", "S'il vous plaît seulement Envoyer Torrents qui sont Seeded. Torrents sans pairs ne seront pas affichées sur la page principale.");
define ( "_btupfile", "Envoyer un fichier:");
define ( "_btupnfo", "Upload du fichier NFO:");
define ( "_bttorrentname", "Nom du Torrent");
define ( "_btfromtorrent", "sera généré à partir du fichier, si des Blancs.");
define ( "_btdescname", "Essayez de lui donner un nom");
define ( "_btsrc_url", "Source URL");
define ( "_btcompulsory", "(obligatoire)");
define ( "_btdescription", "Description (requis)");
define ( "_btnohtml", "NO HTML");
define ( "_btchooseone", "Choisir");
define ( "_bttype", "Type");
define ( "_btverduplicate", "Arrivée de semblables Torrents");
define ( "_btduplicatinfo", "Transfert de Empêche Torrents analogues à ceux déjà inscrits sur la Liste. Décochez la case à télécharger de toute façon. Rappelez-vous que le fait d'avoir en double pour les fichiers identiques Torrents Réduit l'efficacité globale.");
define ( "_btupevidence", "Sticky");
define ( "_btupevidencinfo", "Mark Torrent comme Sticky et conservez-le sur le haut de la liste. Limité aux Modérateurs / Administrateurs");
define ( "_btowner", "Display Name");
define ( "_btowner1", "Afficher l'Utilisateur");
define ( "_btowner2", " Mode Vie privée");
define ( "_btowner3", "mode furtif");
define ( "_btownerinfo", " 'SHOW USER' permet aux autres utilisateurs de voir votre nom d'utilisateur, la protection des renseignements personnels MODE« Cuirs, gardant Modifier / Supprimer les autorisations », STEALTH MODE '(si disponibles) masque complètement le propriétaire du Système, et Ça 't permettre à tout Edit / Suppression par l'utilisateur. ");
define ( "_btupnotify", "Notifications");
define ( "_btupnotifynfo", "Recevoir par e-mail de notification quand un commentaire est ajouté");
define ( "_btupnotifyseed", "Recevoir par e-mail de notification quand une Leecher la fin du fichier (uniquement sur Torrents Tracker local)");
define ( "_btfsend", "Valider");
define ( "_btinserte2k", "Insérer ed2k Link");
define ( "_btmagnetinsert", "Insérer Magnet Link");
define ( "_btinsertlinktitle", "Insérer les liens pour les réseaux Gnutella et eDonkey2000");
define ( "_btinsertlinktext", "Vous pouvez ajouter à votre eDonkey2000 Liens Torrent, pour augmenter la disponibilité.");
define ( "_btinserttext2", "Vous pouvez soit seulement AIMANT Ajouter des liens ou des liens ed2k seulement. Si les deux listes sont remplis avec des entrées, deux liens seront associés à chaque fichier: en d'autres termes, le premier lien ed2k et le premier lien sera AIMANT associé au premier fichier, et ainsi de suite ...");
define ( "_bted2kurl", "Insérer ed2k Link");
define ( "_btsyntax", "Like");
define ( "_btfiletype", "extension");
define ( "_btfilesize", "size");
define ( "_btipport", "ip: port");
define ( "_btstatic", "indique que nous sommes seulement à l'aide du protocole eDonkey2000");
define ( "_btfinalname", "est le nom du fichier à télécharger");
define ( "_btfinalsize", "est la taille en octets du fichier");
define ( "_btfinalidcode", "un code de vérification spéciale qui vous permet de trouver un seul fichier, et de ses copies, parmi beaucoup d'similaires");
define ( "_btfinalipport", "représente la principale source stable (utilisé par Releasers)");
define ( "_btor", "ou");
define ( "_btaddmagnet", "Magnet Link");
define ( "_btadded2k", "Lien ed2k");
define ( "_btphoto", "Image");
define ( "_btexeemlink", "eXeem Link");
define ( "_btexeemlinkexplain", "en option. Si le Torrent peut être téléchargé par l'intermédiaire du Réseau eXeem, vous pouvez insérer le lien ici Autre");
define ( "_bttorrentpasswordexplain", "Vous mai choisir un mot de passe pour protéger votre Torrent non autorisée de vue. Si un mot de passe est défini, Torrent NE
être visibles à personne, sauf Premium Utilisateurs et administrateur de la liste et Torrent Torrent Search. Vous devrez fournir un lien direct avec les personnes que vous souhaitez accéder au Torrent.
Torrents seulement interne peut être protégé par mot de passe. ");
define ( "_btupadvopts", "Options avancées");
define ( "_btadvoptsexplain", "Afficher les options avancées, de contrôle technique de certains aspects de l'torrent. Utilisez ces options que si vous savez ce que vous faites!");
define ( "_btleaveintact", "Ne pas modifier ce paramètre");
define ( "_btdhtsupport", "DHT Support");
define ( "_btendht", "Force Backup DHT Tracking");
define ( "_btdisdht", "Désactiver DHT Tracking");
define ( "_btdhtsupportexplain", "Ce Forces Tracking DHT Backup sur votre Torrent, ou le désactive. DHT est utile lorsque le principal est hors connexion ou Tracker est surchargé");
define ( "_btprivatetorrent", "Private Torrent");
define ( "_btenpvt", "Mark Torrent que privé");
define ( "_btdispvt", "Mark Torrent comme public");
define("_btprivatetorrentexplain","The \"Private\"-Option (which ONLY some Clients can handle), tells the Client to Deal only with Peers it receives from the Central Tracker. Enabling the Private Option Disables DHT");


define ( "_btuploadalinkarchive", "Soumettre eD2K/Magnet Link");
define ( "_btsharelink", "Envoyez SEULEMENT si le dossier est partagé.");
define ( "_btlinknotice", "Le lien ne sera pas acceptée si plus de la moitié des fichiers que vous soumettez sont déjà présents sur l'indice. Duplicates Réduire l'efficacité globale");
define ( "_btarchivename", "Nom");
define("_btinsert1file","Enter Link(s) for your File, and Hit 'Add File'. The eD2K Link is Obligatory. You can Add more than one File to your Submission.");
define("_btlinksnomatch","The Links you Entered do NOT Represent the same File");
define ( "_btinvalided2k", "Lien ed2k invalide");
define ( "_btinvalidmagnet", "Invalid Magnet Link");
define ( "_btaddnewfile", "Ajouter un fichier");
define ( "_btaddtoarchive", "Ajouter un fichier");
define ( "_btaddmd5", "hash MD5");
define ( "_btlinks", "Links");
define ( "_bterrduplicatelinks", "Dupliquer fichiers ne sont pas autorisés");
define ( "_btduplicatelinks", "Duplicate File");
define ( "_btduplicateexplain", "Le dossier Représentée par le lien vous est déjà partagée sur ce site. Cliquez sur le Symbole d'avertissement à côté du dossier pour vérifier les Torrent / collection dans laquelle il a été trouvé. Si plus de 50 % des liens que vous avez ajoutés sont déjà présents, votre demande ne seront PAS acceptés ");
define ( "_btinsertfilesfirst", "Vous devez vous présenter au moins un dossier à l'aide du bouton");
define ( "_btfilelistaltered", "La liste des fichiers a été modifié! Il n'a pas été créé à l'aide de cet outil.");


define ( "_btuserhost", "Nom d'utilisateur / hôte");
define ( "_btuserip", "Nom d'utilisateur / IP");
define ( "_btport", "Port");
define ( "_btdownloadedbts", "Downloaded");
define ( "_btuploadedbts", "Uploaded");
define ( "_btratio", "Ratio");
define ( "_btpercent", "Terminé");
define ( "_btconnected", "Connected");
define ( "_btidle", "inactifs");
define ( "_btconn", "Connexion");
define ( "_btactive", "active");
define ( "_btpassive", "passif");
define ( "_btpeerspeed", "AVG vitesse");
define ( "_btnopeer", "Non Peers");


if (!eregi("admin.php",$_SERVER["PHP_SELF"])){
define ( "_admtrackers", "External Trackers");
define("_admtrackerurl","Announce URL");
define ( "_admtrkstatus", "Status");
define ( "_admtrkstatusactive", "active");
define ( "_admtrkstatusdead", "hors ligne");
define ( "_admtrklastupdate", "Mise à jour");
define ( "_admtrkscraping", "Mise à jour");
define ( "_admtrkassociatedtorrents", "Torrents");
define ( "_admtrkcannotopen", "Impossible de contacter l'adresse URL. Tracker sera mis en mode hors connexion");
define ( "_admtrkrawdata", "Tracker atteint. Voici la réponse de codage");
define ( "_admtrkinvalidbencode", "ne peut pas décoder Tracker Response. Invalid Encoding");
define ( "_admtrkdata", "Decoding Terminé. Voici toutes les données obtenues Raclez");
define("_admtrksummarystr","Found <b>**seed**</b> Seeders, <b>**leechers**</b> Leechers, <b>**completed**</b> Completed Downloads for Torrent **name** Info Hash **hash**.");
}


define ( "_btiderror", "ID invalide");
define ( "_btnotfoundid", "Torrent n'existe pas");
define ( "_btaddcomment", "Ajouter un commentaire à");
define ( "_btaddtime", "Uploaded");
define ( "_btby", "par");
define ( "_btsend", "Valider");
define ( "_btnotyourcomment", "Vous ne pouvez pas éditer les commentaires d'autres personnes.");
define("_btcommentinserted","Your Comment has been Posted. You are being Redirected to the Torrent Details page in 3 seconds.<br>Click <a href=\"details.php?id=**id**#comments\">HERE</a> if your Browser doesn't forward you.");
define("_btcommentdeleted","Comment Deleted. You are being Redirected to the Torrent Details page in 3 seconds.<br>Click <a href=\"details.php?id=**id**#comments\">HERE</a> if your Browser doesn't forward you.");


define ( "_bttorrentunavailable", "Torrent de dossier non disponible en raison d'une erreur de configuration du serveur. Désolé pour le dérangement.");
define ( "_btminseedrule", "Vous devez être au moins de semis ** ** min Torrents à télécharger.");
define ( "_btmaxdailydownloads", "Vous ne pouvez pas télécharger plus de fichiers ** ** max par jour. S'il vous plaît essayer à nouveau demain.");
define ( "_btmaxweeklydownloads", "Vous ne pouvez pas télécharger plus de fichiers ** ** max par semaine. S'il vous plaît essayez de nouveau la semaine prochaine.");
define ( "_bterrtoosmall", "Vous avez <li> de semences d'un fichier au moins <b> min_share ** ** </ b> de la taille. <br>");
define ( "_bterrtoobig", "La plus grande <b> dossier vous est Seed");
define ( "_bterrorprivate", "Ceci est un dossier privé: vous avez déjà demandé l'autorisation de téléchargement. Vous ne pouvez pas télécharger le fichier jusqu'à ce que le propriétaire accepte votre demande.");
define ( "_btrefused", "Le propriétaire a refusé votre demande d'autorisation. Vous ne serez pas en mesure de télécharger ce torrent.");
define ( "_bterrblacklist", "Le propriétaire a refusé de vous permettre de télécharger son Torrents. Vous ne serez pas en mesure de télécharger l'une d'elles.");
define ( "_btreqsent", "Ce Torrent est privé. Vous ne serez pas en mesure de télécharger jusqu'à ce que le propriétaire vous donne l'autorisation.
Une demande a été envoyée à l'Torrent propriétaire, qui doit autoriser le téléchargement: vous serez informé du résultat par e-mail. ");


define ( "_btedittorrent", "Edit Torrent");
define ( "_bterreditnoowner", "<h1> Accès refusé </ h1> \ n <p> Torrent Seuls les propriétaires et les administrateurs peuvent modifier Torrents </ p> \ n");
define ( "_btbanned", "Interdit");
define ( "_btcancel", "Annuler");
define ( "_btdelcommand", "Ne pas modifier Torrent, MAIS <input type=\"submit\" value=\"DELETE IT!\" /> \ n");
define ( "_btsure", "Oui, je suis sûr de cela!");
define ( "_btban", "Ban Torrent");
define ( "_btareyousure", "Etes-vous sûr de vouloir supprimer le nom <b> ** ** </ b >?");
define ( "_btareyousure_ban", "Etes-vous sûr de vouloir BAN <b> ** Nom ** </ b >?");
define ( "_bttorrentnoexist", "Ce Torrent n'existe pas");
define ( "_btdelete", "Supprimer Torrent");
define ( "_btcannotdel", "Impossible de supprimer");
define ( "_btmissingdata", "données requis manquant!");
define ( "_btdeldenied", "Seul le propriétaire ou Site Torrent administrateurs peuvent Supprimer ce Torrent");
define ( "_btnotconfirmed", "vous devez confirmer que vous êtes sûr de ce que vous vous apprêtez à faire.");
define ( "_btdeleted", "Torrent supprimé");
define ( "_btsuccessfullyedited", "Edited Torrent avec succès. Vous allez être redirigé vers le Torrent Details Page. N'oubliez pas que si vous avez sélectionné le mode furtif, vous ne serez pas en mesure de modifier ou de supprimer le Torrent plus!");


define ( "_btmytorrentsintrotitle", "Panneau de configuration Torrent");
define ( "_btmytorrentsintrotext", "Dans ce domaine, vous pouvez gérer les torrents que vous avez téléchargé (à l'exception de ceux avec Stealth mode sélectionné). <br>
Vous pouvez également gérer d'autres utilisateurs des requêtes de téléchargement. En sélectionnant l'icône, vous pouvez visualiser toutes les demandes
qui vous sont envoyés par d'autres utilisateurs. Vous aurez à décider s'il convient d'accepter ou de refuser la demande de téléchargement. <br>
Soyez attentif au Upload et Download Montants de l'utilisateur. Les gens qui téléchargent sans le partage sont d'aucune utilité pour
le réseau BitTorrent. Le refus de leur demande de téléchargement peut être un bon moyen de les encourager à plus d'action. ");
define ( "_btmytorrents", "My Torrents");
define ( "_btallauthorized", "Tous les utilisateurs ont été autorisés");
define ( "_btauths", "Les demandes de téléchargement");
define ( "_btauthorized", "Sélection de l'utilisateur a été autorisé");
define ( "_bthasauthorized", "propriétaire vous a autorisé à télécharger des fichiers son");
define ( "_btnowcandownload", "Vous pouvez maintenant télécharger gratuitement tous les fichiers de l'utilisateur. \ nwe protéger votre vie privée.");
define ( "_pendingauths", "En attendant les autorisations:");
define ( "_btauthorizationrequested", "Les utilisateurs ont demandé l'autorisation de téléchargement:");
define ( "_btnotorrents", "Il n'ya pas de Torrents");
define ( "_btnotorrentuploaded", "Vous n'avez pas encore envoyé de Torrents");
define ( "_btactions", "Actions");
define ( "_bthasuploaded", "Uploaded: **");
define ( "_bthasdownloaded", "Téléchargé: **");
define ( "_btauthgrant", "Autoriser");
define ( "_btauthalwaysgrant", "Toujours autoriser");
define ( "_btauthalwaysdeny", "Ne jamais autoriser");
define ( "_btauthdeny", "Ne pas autoriser");
define ( "_btcantseeothertorrents", "Vous ne pouvez pas voir les autres utilisateurs Torrents autorisations!");
define ( "_btauthpanel", "Télécharger les autorisations Control Panel");
define ( "_btnoauthstomanage", "il n'ya pas de gérer les autorisations");
define ( "_btmyglobals", "My Global autorisations");
define ( "_btnoglobals", "Il n'y a pas encore les autorisations Global");
define ( "_btstatus", "Status");
define ( "_btauthreset", "Reset");
define ( "_btwronginput", "Erreur lors de l'entrée de données");
define ( "_btgeneraloptions", "General Options");
define ( "_btprivate", "Privé");
define ( "_btprivateexpl", "Sélectionnez cette option pour les utilisateurs de demander une autorisation d'accès Télécharger ce Torrent. Vous serez avisé de chaque nouvelle en attente d'autorisation par e-mail.
Vous pourrez choisir d'accorder ou refuser l'autorisation pour ce seul Torrent ou pour toutes vos Torrents ");
define ( "_btminratio", "Minimum Ratio");
define ( "_btdisabled", "Disabled");
define ( "_btminratioexpl", "Vous pouvez définir un nombre minimum de valeur à l'auto-Autoriser les utilisateurs. Les utilisateurs ayant Ratio supérieur ou égal à cela la possibilité de télécharger sans demander d'autorisation.
La valeur du ratio minimal ne sera pas affichée, sauf pour les administrateurs ");


define ( "_btcommentkeyfound", "Le système a vérifié votre commentaire. Les mots ne sont pas autorisés: <ol>");
define ( "_btcommentkeyfound2 ","</ ol> <p> Nous savons que le commentaire pourrait être OK, nous nous excusons pour le désagrément et vous demandons d'utiliser des termes différents. </ p>");


define ( "_btmissingformdata", "Missing entrée de données!");
define ( "_bteditfailed", "Edit a échoué");
define ( "_bteditdenied", "Vous ne pouvez pas modifier d'autres personnes Torrents.");
define ( "_btreturl", "avec succès sous la direction de dossier, vous êtes redirigé vers la page Torrent détails en 3 secondes .. <br> Cliquez <a href=\"**returl**\"> ICI </ a> si votre navigateur ne transmet pas vous ");


define ( "_btrate", "Evaluation Torrent");
define ( "_btratefailed", "Vote Failed!");
define ( "_btinvalidrating", "Votez non valide");
define ( "_btidnotorrent", "ID invalide. Torrent n'existe pas");
define ( "_btnovoteowntorrent", "Vous ne pouvez pas noter vos propres torrents");
define ( "_btalreadyrated", "Déjà Torrent Rated");
define ( "_btcantvotetwice", "Nous sommes désolé, mais vous ne pouvez pas évaluer deux fois");
define ( "_btvotedone", "Vote avec succès, vous êtes redirigé vers la page Détails Torrent en 3 secondes. <br> <a href=\"details.php?id=**id**\"> Cliquez ICI </ a>, si votre navigateur ne transmet pas vous. ");


define ( "_btuploaderror", "Échec du transfert!");
define ( "_btemptyfname", "Nom de fichier vide");
define ( "_btinvalidfname", "Nom de fichier non valide");
define ( "_btinvalidnfofname", "Nom du fichier NFO invalide");
define ( "_btfnamenonfo", "Ce n'est pas un fichier NFO (. nfo)");
define ( "_btfnamenotorrent", "Ceci n'est pas une Torrent File (. torrent)");
define ( "_btferror", "File Error");
define ( "_bterrnofileupload", "Erreur fatale dans Uploaded dossier.");
define ( "_bterrnonfoupload", "Erreur fatale dans Uploaded NFO dossier.");
define ( "_btemptyfile", "dossier vide");
define ( "_btnobenc", "Fichier endommagé. Êtes-vous sûr que c'est vraiment un Torrent?");
define ( "_btnodictionary", "Dictionnaire Torrent PAS présent");
define ( "_btdictionarymisskey", "Missing Torrent Dictionnaire Keys");
define ( "_btdictionaryinventry", "données non valide dans Torrent Dictionnaire");
define ( "_btdictionaryinvetype", "Types de données non valide dans le Dictionnaire du Torrent");
define ( "_btinvannounce", "annoncent Invalid URL. Doit être");
define ( "_btactualannounce", "indiquée Tracker");
define ( "_bttrackerdisabled", "Notre Tracker a été désactivé: Seuls Torrents extérieures peuvent être téléchargés.");
define ( "_btinvpieces", "Invalid Torrent Parts");
define ( "_btmissinglength", "Missing Files et de la taille");
define ( "_btnofilesintorrent", "Missing Torrent Files");
define ( "_btfnamerror", "Nom de fichier non valide");
define ( "_btinvalidhtml", "Invalid code HTML. Assurez-vous que vous avez utilisé notre Code Editor sans entrer manuellement.");
define ( "_bttrackerblacklisted", "The Tracker utilisés par ce Torrent (trk <b> ** ** </ b>) a été la liste noire. S'il vous plaît utilisez un autre Tracker.");
define ( "_btfilenamerror", "Erreur dans le fichier");
define ( "_bttorrenttoosmall", "<p> vous ne pouvez pas partager un fichier plus petit que <b>");
define ( "_bttorrenttoosmall2 ","</ b> </ p> Votre Torrent contient un fichier avec la suite Taille: <b>");
define ( "_btmaxuploadexceeded", "Vous ne pouvez pas plus de Upload ** ** maxupload dans une période de 24 heures.");
define ( "_btnumfileexceeded", "Vous ne pouvez pas <p> Envoyer plus de <b> maxupload ** ** </ b> les fichiers dans une période de 24 heures. </ p> Vous avez déjà Uploaded <b> rownum ** ** </ b> Fichiers, un montant total de <b> totsize ** ** </ b> ");
define ( "_btsearchdupl", "Selon la recherche, ces fichiers mai correspondent à ceux que vous êtes partage: <ol>");
define ( "_btduplinfo", "<p> Si votre dossier est dans cette liste, s'il vous plaît un de ces semences Torrents! </ p>");
define ( "_btsocktout", "ERROR: Socket-Timed Out");
define ( "_bttrackernotresponding", "Tracker ne répond pas. \ n Vérifier l'orthographe Tracker (NO EMPTY SPACES INSIDE URL) et que le tracker est en cours. Le Tracker vous est indiquée:");
define ( "_bttrackerdata", "non valide à partir de données externes Tracker. Le Tracker mai ont Server Problems. S'il vous plaît essayer à nouveau plus tard.");
define ( "_bttorrentnotregistered", "Torrent ne semble pas être inscrit sur le Tracker externes. Vous pouvez télécharger des torrents externes seulement si ils sont actifs.");
define("_btuploadcomplete","Successfully Uploaded. You are being redirected to the Torrent Details Page in 3 seconds. Remember to Seed, or the Torrent won't be Visible on the Main Page.<br>Click <a href=\"**url**\">HERE</a> if your Browser doesn't forward you.");
define("_btpresent","This Torrent has Already been Uploaded");
define("_btscrapeerror","Can't get Peer Data from Tracker");


define ( "_btcomplisnowbanned", "Ce Torrent a été interdite en raison d'un certain nombre de plaintes");
define ( "_btcomplcantvotetwice", "nous sommes désolés, mais vous ne pouvez pas envoyer une plainte à deux reprises.");
define ( "_btcomplainttaken", "Plainte Faite. Vous êtes redirigé vers la page Détail du Torrent de 3 secondes. Si votre navigateur ne transmet pas, cliquez");
define ( "_btcomplsuccess", "une plainte a été enregistrée. Nom d'utilisateur et IP sont connectés: S'il vous plaît ne pas abuser du système. <BR>");


define ( "_btshoutbox", "Shoutbox <a href=\"javascript:popshout('shoutdetach.php');\"> (Détacher) </ a>");
define ( "_btnoshouts", "Personne n'est Shouting ...");
define ( "_btshoutnow", "Shout!");
define ( "_btprivates", "[h]");
define ( "_btshoutnowprivate", "Private Shout!");
define ( "_btshoutboxshow", "ShoutBox");
define ( "_btshactive", "Actvie Users");
define ( "_btmoresmiles", "Plus Smiles");
define("_btshouthelp","what is Mode Normal/Mode Expert<ul><li>Mode Normal:<li>Mode Expert:</ul>What does the <img src=\"./themes/".$theme."/pics/drop.gif\" alt=\"\"> do<ul><li>Click this twice to delete your shout.<br />(note admins and mods can delete your shouts to)</ul>What does the <img src=\"./themes/".$theme."/pics/edit.gif\" alt=\"\"> do?<ul><li>Click this twice to edit your shout.<br />(note admins and mods can edit your shouts to)</ul>");



define ( "_btalt_banned", "Banned Torrent");
define ( "_btalt_auth_none", "Non Dans l'attente des autorisations");
define ( "_btalt_auth_pending", "En attendant les autorisations!");
define ( "_btalt_sticky", "Sticky Torrent");
define ( "_btalt_download", "Télécharger");
define ( "_btalt_edit", "Edit");
define ( "_btalt_drop", "Delete");
define ( "_btalt_scrape", "Peer Refresh Data");
define ( "_btalt_noscrape", "Statistiques Mise à jour il ya moins de 30 minutes");
define ( "_btalt_logintoscrape", "Se connecter pour vérifier ses données par les pairs");
define ( "_btalt_duplicate", "Duplicate File");
define ( "_btalt_exeem", "Télécharger avec eXeem");
define ( "_btalt_error.gif", "Erreur");
define ( "_btalt_icon_admin", "Administrateur");
define ( "_btalt_icon_moderator", "modérateur");
define ( "_btalt_icon_premium.gif", "Premium User");
define ( "_btalt_1.gif", "très mauvais");
define ( "_btalt_1.5.gif", "très mauvais");
define ( "_btalt_2.gif", "Bad");
define ( "_btalt_2.5.gif", "pauvres");
define ( "_btalt_3.gif", "moyenne");
define ( "_btalt_3.5.gif", "mieux que la moyenne");
define ( "_btalt_4.gif", "bon");
define ( "_btalt_4.5.gif", "Très bien");
define ( "_btalt_5.gif", "Excellent");
define ( "_btalt_anon_tracker.gif", "Tracker Anonyme");
define ( "_btalt_button_aim.gif", "AOL Instant Messenger");
define ( "_btalt_button_icq.gif", "ICQ");
define ( "_btalt_button_irc.gif", "IRC");
define ( "_btalt_button_msn.gif", "MSN Messenger");
define ( "_btalt_button_yahoo.gif", "Yahoo!");
define ( "_btalt_ed2k_active.gif", "Télécharger en utilisant ed2k URI");
define ( "_btalt_ed2k_inactive.gif", "Lien ed2k non disponible");
define ( "_btalt_magnet", "Télécharger en utilisant des aimants URI");
define ( "_btalt_magnet_inactive.gif", "Autre lien non disponible");
define ( "_btalt_green.gif", "Fast");
define ( "_btalt_yellow.gif", "Slow");
define ( "_btalt_red.gif", "Stop");
define ( "_btalt_quest.gif", "Peer Data Unknown");
define ( "_btalt_lock", "En attendant l'autorisation");
define ( "_btalt_lock_request", "Demande d'autorisation");
define ( "_btalt_noavatar.gif", "Non Avatar");
define ( "_btalt_icon_active.gif", "active");
define ( "_btalt_icon_passive.gif", "passif");
define ( "_btalt_external", "External Tracker");

define ( "_btunknownclient", "Unknown Client");
define ( "_btalt_avatar", "Avatar de l'utilisateur ** **");


define ( "_btstats", "Statistiques");


define ( "_btyougotpm", "Vous avez des nouvelles / de messages non lus!");
define ( "_btpmintro", "Ici, vous pouvez lire des messages privés d'autres utilisateurs. Il n'ya pas de limite de stockage maximale.
Toutefois, nous vous suggérons de supprimer d'anciens messages périodiquement. Vous pouvez envoyer des messages à tous les utilisateurs enregistrés. ");
define ( "_btinbox", "Inbox");
define ( "_btpmnomessages", "Pas de messages");
define ( "_btpmsub", "Objet");
define ( "_btpmfrom", "From");
define ( "_btpmdate", "Date");
define ( "_btplmselect", "Select");
define ( "_btpmread", "Read");
define ( "_btpmunread", "non lu");
define ( "_btimgdelete", "Supprimer l'image");
define ( "_btpmnewmsg", "Nouveau message");
define ( "_btpmdelete", "supprimer les messages");
define ( "_btpmdelall", "supprimer tous les messages");
define ( "_btpmdelconfirm", "Etes-vous sûr de vouloir supprimer tous les messages sélectionnés?");
define ( "_btpmdelbtn", "supprimer les messages");
define ( "_btpmdelallconfirm", "Etes-vous sûr de vouloir supprimer <b> ALL </ b> messages privés?");
define ( "_btpmdeletedsuccessfully", "Messages Successfully Selected");
define ( "_btnewpm", "Nouveau message");
define ( "_btpmto", "Destinataire");
define ( "_btpmtotip", "Si vous voulez envoyer le même message à plusieurs utilisateurs, séparez-les en les séparant par une virgule (;)");
define ( "_btpmshowbookmarks", "Afficher / Masquer la liste de contacts");
define ( "_btpmtext", "Message");
define ( "_btpmnorecipient", "Vous devez spécifier un bénéficiaire");
define ( "_btpmnosubject", "Vous devez spécifier un Sujet");
define ( "_btpmnomessage", "Empty Message");
define ( "_btpminvalidrecipients", "Un ou plusieurs des bénéficiaires que vous avez entré n'existe pas");
define ( "_btpmsentsuccessfully", "Message envoyé avec succès");
define ( "_btpmuserblocked", "L'un des bénéficiaires de ne pas accepter des messages de vous. Vos a écrit: <br>");
define ( "_btmessage", "Message");
define ( "_btinvalidpm", "Message non valide");
define ( "_btpmnoexists", "message n'existe pas");
define ( "_btpmreply", "Répondre");
define ( "_btuserlists", "Amis et ignorés Users");
define ( "_btuserlistsintro", "Ici, vous pouvez gérer la liste des Amis et ignorés des utilisateurs. Les premiers sont disponibles dans votre liste de contacts pour un accès rapide lors de l'envoi d'un nouveau message.
Les messages envoyés par des utilisateurs ignorés sera bloqué. Vous pouvez changer le statut d'un utilisateur dans son profil. Les utilisateurs n'ont pas tous les renseignements sur le statut qui leur ont été confiées par d'autres. ");
define ( "_btpmbookmarkuser", "Ajouter aux Amis");
define ( "_btpmunbookmarkuser", "Supprimer de l'Amis");
define ( "_btpmblacklistuser", "Refuser cet utilisateur Messages");
define ( "_btpmunblacklistuser", "Ne pas refuser de cet utilisateur Messages");
define ( "_btpmbookmarks", "Amis");
define ( "_btpmblacklist", "ignorés Users");


# NO-LINE BREAKS!
define ( "_btperformance", "Performance");
define ( "_btdht", "DHT Support");
define ( "_bttorrentspd", "Speed Total:");
define ( "_btleechspd", "Estimation de vitesse:");
define ( "_btedt", "Durée de téléchargement estimée:");
define ( "_btinfohashhelp", "L'Info Hash est un abrégé, code unique qui identifie un Torrent. <br>");
define ( "_btdhtexplanation", "Ce soutien de Torrent DHT. Avec un Etat de l'Art Client, vous serez en mesure de télécharger ce Torrent, même si une centrale Tracker descend.");
define ( "_btavatarnotice", "Uploaded avatars doivent être au format GIF, JPEG ou PNG, a suggéré de taille 100x100 et ne peut pas être plus grand que 300 Ko");
define ( "_btcustomsearch", "RSS / RDF Feed pour Custom Search");
define ( "_btcustomsearchexplain", "Abonnez-vous à ce flux RSS / RDF Feed pour rester à jour sur les envois qui correspondent à vos termes de recherche");


define("_btrules","Rules");
define("_brrulesadmin","Admin-Rules");
define("_btrulesmod","Moderator-Rules");
define("_btrulesprem","Premium-Rules");

define("_btrulesuser","User-Rules");
define("_btrulesgen","General-Rules");
define("_btrulesadd","Add New Rules Section");
define("_btrulesaddsect","Add Rule Section");
define("_btnamelevel","User Level for this Rule");
define("_bttitle","Section Title");
define("_btlevel","Level");
define("_btrulesedit","Edit Rules");
define("_btmodrulesadd","Add Rules Section");
define("_btmodrulesno","No");
define("_btmodrulesyes","Yes");
define("_btmodrulespublic","Public");
//massmail
define("_btmmbody","Body");
define("_btmmsendto","Send Mass E-mail to Selected Member Levels");
define("_btmmlinks","You May Use Links In Your e-mails");

define ( "_bb_tag_prompt", "Entrez un texte:");
define ( "_bb_img_prompt", "Insérer un lien à partir de l'image");
define ( "_bb_font_formatter_prompt", "Entrez un texte -");
define ( "_bb_link_text_prompt", "Entrez le nom du lien (facultatif ):");
define ( "_bb_link_url_prompt", "Entrez l'adresse complète à gauche:");
define ( "_bb_link_email_prompt", "Entrez votre Full Lien:");
define ( "_bb_list_type_prompt", "Quel type de liste souhaitez-vous? Donnez« 1 »pour une liste numérique, 'a' pour une liste alphabétique, ou rien du tout pour une simple liste de points.");
define ( "_bb_list_item_prompt", "Entrez un point de la liste. Appuyez sur OK pour entrer dans un autre point de la liste ou appuyez sur« Annuler »à la fin.");
define('_btmfreetorrentexplain','<img src="themes/'.$theme.'/pics/magic.gif" alt="FREE TORRENT" title="FREE TORRENT" border="0">Any Torrents with this Symbol are Ratio Boosters. Only your Upload is Recorded!!<br> This is a Great way to Boost your Ratio. Normal Site Seeding Rules Apply.<br>Seed to 1.0 or 36 hours to avoid Hit and Runs.');
define('_btmnuketorrentexplain','<img src="themes/'.$theme.'/pics/nuked.gif" alt="NUKED TORRENT" title="NUKED TORRENT" border="0">Any Torrents with this Symbol are Nuked. <br>This means that for some reason someone has determined that there is something wrong with the Release,<br>and it may or may not be viewable. Use your own discretion when downloading these torrents.<br>Normal Site Seeding Rules still Apply unless also made Free. Please Read Details for Reason');
define('_btactiontime','Time');
define('_btactionmark','Mark');

define ( "_btuploadexpl", "Sélectionnez le fichier que vous souhaitez ajouter à votre torrent et BitBucket. <br /> Vous même pas besoin de charger cette image dans le futuere. <br /> valide les extensions de fichier: bmp, jpeg, jpg, gif jpe png . ");
define ( "_btgalexpl", "Voici toutes les images que vous avez dans votre galerie <br /> Vous pouvez ajouter une de ces images en cliquant sur le Nmae de l'image ou l'image Voir l'intégralité en cliquant sur le pouce.");
define ( "_btvaliext", "valide les extensions de fichier: bmp, jpeg, jpg, gif jpe png");
define ( "_btattach", "Attach Files");
define ( "_btmantitle", "Cliquez ici pour ajouter l'image que vous avez téléchargé à partir d'images");
define ( "_btmanimage", "Gérer les images");
# offres
# requist
?>