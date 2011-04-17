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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*--------- Greek language by mrPink ... mourmouradiko 2009 (alpha) ------------*
*/


if (eregi("greek.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

//define("_LOCALE","el");

//Site News

define("_btsitenews","Τα Νέα του Site");
define("_btstart","Ευχαριστούμε που επιλέξατε το phpMyBitTorrent<br /><br />
Το phpMyBitTorrent διαθέτει έναν πλήρη BitTorrent Tracker γραμμένο σε PHP, καταλογοποίηση εξωτερικών torrents, DHT, Ψηφιακή Κοινοποίηση, εναλλακτικούς υπερσυνδέσμους (eD2K, Magnet), Πιστοποίηση HTTP-Basic, Πιστοποίηση Κλειδιού Πρόσβασης, και ενσωματωμένο Συντάκτη HTML, Μαζική Φόρτωση Torrents και περισσότερα. Μπορείτε να αφαιρέσετε ή να αντικαταστήσετε αυτό το αντικείμενο ειδήσεων από το μενού Διεύθυνση > Ρυθμίσεις");

//Search Cloud
define("_btsearchcloud","Σύννεφο Αναζήτησης");
define("_btsearchcloudexplain","Δημοφιλείς Αναζητήσεις. Μια τυχαία επιλογή από όρους αναζήτησης των χρηστών, κατανεμημένη βάσει συχνότητας.");
//Donations Block
define("_btdonations","Δωρεές");
define("_btdonationsgoal","Στόχος:");
define("_btdonationscollected","Έχουν συλλεχθεί:");
define("_btdonationsprogress","Πρόοδος Δωρεάς");
define("_btdonationsdonate","ΔΩΡΕΑ");

//COMPLAINTS
function getcomplaints() {
        return Array(0=>"Νόμιμο πειεχόμενο, καλή ποιότητα",1=>"Ψεύτικο ή παραφθαρμένο",2=>"Παραβίαση πνευματικών δικαιωμάτων",3=>"Πορνογραφικό περιεχόμενο",4=>"Παιδική πορνογραφία",5=>"Προσβλητικό περιεχόμενο",6=>"Περιεχόμενο σχετικό με παράνομες δραστηριότητες");
}

//NewTorrent shout
define("_btuplshout","Γεια, μόλις ανέβασα το <b>**name**</b>. Απολαύστε το!");
define("_btnewtsh","Ενημέρωσε για το Καινούριο Torrent");
define("_btnewshex","Επιλέξτε το, αν επιθυμείτε να προστεθεί μια ενημέρωση στο shout box για το νέο torrent - αν όχι, τότε μην το επιλέξετε!");

//CLASSI
define("_btclassuser","User");
define("_btclasspremium","Premium User");
define("_btclassmoderator","Moderator");
define("_btclassadmin","Administrator");

//ACCESSO NEGATO
define("_btaccdenied","Απαγορεύεται η Πρόσβαση");
define("_btdenuser","Η περιοχή που προσπαθείτε να επισκεφτείτε είναι προσβάσιμη μόνον σε <b>registered users</b>.<br>Παρακαλώ δώστε τα διαπιστευτήρια εισόδου σας και προσπαθήστε ξανά. Εαν δεν έχετε εγγραφεί ακόμη, μπορείτε να το κάνετε <a href=\"user.php?op=register\">ΕΔΩ</a> δωρεάν.");
define("_btdenpremium","Η περιοχή που προσπαθείτε να επισκεφτείτε είναι προσβάσιμη μόνον σε <b>Premium Users</b>.<br>");
define("_btdenpremium1","Παρακαλώ δώστε τα διαπιστευτήρια εισόδου σας και προσπαθήστε ξανά. Εάν δεν διαθέτετε έναν Premium λογαριασμό, παρακαλώ επικοινωνήστε με το Staff μας για λεπτομερείς πληροφορίες σχετικά με την Premium Εγγραφή.");
define("_btdenpremium2","Ο λογαριασμός σας δεν είναι εξουσιοδοτημένος για πρόσβαση σε Premium Υπηρεσίες. Παρακαλώ επικοινωνήστε με το Staff μας για λεπτομερείς πληροφορίες σχετικά με την Premium Εγγραφή.");
define("_btdenadmin","Η περιοχή που προσπαθείτε να επισκεφτείτε είναι προσβάσιμη μόνον σε <b>administrators</b>.<br>");
define("_btdenadmin1","Εάν έχετε διαπιστευτήρια administrator παρακαλώ δώστε τα τώρα, διαφορετικά σας ζητούμε να φύγετε από αυτήν τη σελίδα και να επιστρέψετε στην <a href=\"index.php\">Αρχική Σελίδα</a>.");
define("_btdenadmin2","Ο λογαριασμός σας δεν διαθέτει προνόμια administrator. Παρακαλώ συνδεθείτε με τα κατάλληλα διαπιστευτήρια ή φύγετε από τη σελίδα και επιστρέψτε στην <a href=\"index.php\">Αρχική Σελίδα</a>.");
define("_btbannedmsg","Έχει απαγορευτεί η είσοδός σας σ' αυτήν την ιστοσελίδα, διότι: <b>**reason**</b>");

//GENERICS
define("_DATESTRING","%A, %B %d %Y @ %T %Z");
define("_btpassword","Κωδικός Πρόσβασης");
define("_btusername","Όνομα Χρήστη");
define("_btremember","Θυμήσου με");
define("_btsecuritycode","Κωδικός Ασφαλείας");
define("_btusermenu","Μενού Χρήστη");
define("_btmainmenu","Βασικό Μενού");
define("_btgenerror","Σφάλμα phpMyBitTorrent");
define("_btmenu","Μενού");
define("_btumenu","Μενού Χρήστη");
define("_btsyndicate","Syndication");
define("_btlegend","Επεξήγηση");
define("_btircchat","IRC Chat");
define("_btchatnotenabled","Το IRC Chat δεν είναι ενεργοποιημένο σ' αυτήν την ιστοσελίδα.");
define("_btlostpassword","Ξεχάσατε τον κωδικό σας?");

//EMAIL SPELLING
define("_at"," at ");
define("_dot"," dot ");

//SQL ERRORS
define("_btsqlerror1","Σφάλμα κατά την εκτέλεση SQL Αιτήματος ");
define("_btsqlerror2","Σφάλμα ID: ");
define("_btsqlerror3","Σφάλμα Μηνύματος: ");

//HTTP ERRORS
define("_http400errttl","Σφάλμα HTTP 400 - Bad request");
define("_http400errtxt","Ένα Σφάλμα 400 συνέβη κατά την επεξεργασία του αιτήματός σας.\n
Παρακαλούμε ελέγξτε τις ρυθμίσεις του φυλλομετρητή σας και προσπαθήστε ξανά να ανοίξετε την ιστοσελίδα.\n
Επικοινωνήστε **email** εάν αντιμετωπίζετε προβλήματα.");
define("_http401errttl","Σφάλμα HTTP 401 - Απαγορεύεται η πρόσβαση");
define("_http401errtxt","Ένα Σφάλμα 401 HTTP Error συνέβη κατά την επεξεργασία του αιτήματός σας.<br>
Δεν μπορείτε να ανοίξετε την ιστοσελίδα, διότι δεν είστε εξουσιοδοτημένος/η.<br>
Παρακαλούμε να δώσετε τα διαπιστευτήρια πρόσβασής σας, εάν έχετε.<br>
Επικοινωνήστε **email** εάν αντιμετωπίζετε προβλήματα.");
define("_http403errttl","Σφάλμα HTTP 403 - Απαγορεύεται");
define("_http403errtxt","Ένα Σφάλμα 403 HTTP συνέβη κατά την επεξεργασία του αιτήματός σας.<br>
Δεν μπορείτε να ανοίξετε την ιστοσελίδα, διότι οι ρυθμίσεις του server δεν σας το επιτρέπουν.<br>
Παρακαλούμε ελέγξτε προσεκτικά την URL διεύθυνση στον φυλλομετρητή σας, και διορθώστε την αν χρειάζεται.<br>
Επικοινωνήστε **email** εάν αντιμετωπίζετε προβλήματα.");
define("_http404errttl","Σφάλμα HTTP 404 - Δεν Βρέθηκε");
define("_http404errtxt","Ένα Σφάλμα 404 HTTP συνέβη κατά την επεξεργασία του αιτήματός σας.<br>
Η ιστοσελίδα δεν υπάρχει.<br>
Παρακαλούμε ελέγξτε την URL διεύθυνση στον φυλλομετρητή σας προσεκτικά, και διορθώστε την αν χρειάζεται.<br>
Επικοινωνήστε **email** εάν αντιμετωπίζετε προβλήματα.");
define("_http500errttl","Σφάλμα HTTP 500 - Εσωτερικό Σφάλμα του Server");
define("_http500errtxt","Ένα Σφάλμα 500 HTTP συνέβη κατά την επεξεργασία του αιτήματός σας.<br>
Ένα Σφάλμα συνέβη κατά την επεξεργασία των δεδομένων σας.<br>
Λεπτομερείς πληροφορίες μπορούν να βρεθούν στα μητρώα καταγραφής του server.<br>
Παρακαλούμε στείλτε μια λεπτομερή αναφορά γι' αυτό στο **email**");

//USER BLOCK
define("_btyoureseeding","Torrents που διαμοιράζετε");
define("_btyoureleeching","Torrents που λαμβάνετε");
define("_btuserstats","Στατιστικά Χρήστη");
define("_bttotusers","Εγγεγραμμένοι Χρήστες:");
define("_btlastuser","Τελευταίοι Καταγεγραμμένοι Χρήστες:");
define("_bttorrents","Διαθέσιμα Torrents:");
define("_bttotshare","Σύνολο Μοιρασμένων:");
define("_bttotpeers","Συνδεδεμένοι Χρήστες:");
define("_bttotseed","Σύνολο Διαμοιραστών:");
define("_bttotleech","Σύνολο Ληπτών:");


//TESTI CHE COMPAIONO IN USER.PHP
define("_btregwelcome","<P align=\"center\">Καλωσορίσατε!</P>
<P>Δημιουργήστε έναν λογαριασμό για να γίνετε μέλος της κοινότητάς μας. Αυτό θα σας επιτρέψει να χρησιμοποιήσετε σε πλήρη εμβέλεια τις υπηρεσίες της ιστοσελίδας, και θα σας πάρει μόνον λίγα λεπτά. Διαλέξτε ένα όνομα χρήστη και έναν κωδικό πρόσβασης, και δώστε μια ισχύουσα διεύθυνση ηλεκτρονικού ταχυδρομείου. Μέσα σε λίγα λεπτά θα δεχθείτε ένα mail, που θα σας ζητά να επιβεβαιώσετε την εγγραφή.</P>");
define("_btreggfxcheck","<P align=\"center\"> Παρακαλούμε επίσης να εισάγετε τον ακόλουθο κωδικό ασφαλείας (αποτρέπει την εγγραφή αυτοματοποιημένων προγραμμάτων).<BR>Επικοινωνήστε **email** εάν αντιμετωπίζετε προβλήματα ανάγνωσης αυτού του κωδικού.</P>");
define("_btemailaddress","Διεύθυνση Ηλεκτρονικού Ταχυδρομείου");
define("_btpasswd","Κωδικός πρόσβασης (5 χαρακτήρες τουλάχιστον)");
define("_btpasswd2","Επιβεβαίωση Κωδικού");
define("_btsubmit","Εγγραφή");
define("_btreset","Ακύρωση τροποποιήσεων");
define("_btdisclaimer","Όροι και προϋποθέσεις:");
define("_btdisclaccept","Δέχομαι");
define("_btdisclrefuse","Δεν Δέχομαι");
define("_btgfxcode","Κωδικός Ασφαλείας");
define("_btsignuperror","Σφάλμα κατά τη Διαδικασία Εγγραφής");
define("_bterruserexists","Το όνομα χρήστη υπάρχει ήδη.");
define("_btfakemail","Η διεύθυνση ηλεκτρονικού ταχυδρομείου που εισαγάγατε δεν ισχύει.");
define("_bterremailexists","Η διεύθυνση ηλεκτρονικού ταχυδρομείου που εισαγάγατε είναι ήδη εγγεγραμμένη. Επιθυμείτε να ανακτήσετε τον κωδικό πρόσβασής σας? Πηγαίνετε <ahref=\"user.php?op=lostpassword\">ΕΔΩ</a>");
define("_btpasswnotsame","Οι κωδικοί που εισαγάγατε δεν είναι οι ίδιοι");
define("_bttooshortpass","Ο κωδικός που εισαγάγατε είναι πολύ μικρός. Το ελάχιστο μέγεθος είναι 5 χαρακτήρες.");
define("_bterrcode","Ο κωδικός ασφαλείας που εισαγάγατε είναι λανθασμένος");
define("_btdisclerror","ΠΡΕΠΕΙ να ΑΠΟΔΕΧΘΕΙΤΕ την Απέκδυση Ευθυνών μας, για να εγγραφείτε.");
define("_btgoback","Παρακαλούμε επιστρέψτε και ελέγξτε την αίτηση");
define("_btregcomplete","Η εγγραφή σχεδόν ολοκληρώθηκε. Έχετε 24 ώρες για να επιβεβαιώσετε την εγγραφή σας. Εάν δεν λάβετε την επιβεβαίωση μέσω email, παρακαλούμε ελέγξτε τα δεδομένα που εισαγάγατε. Εάν αντιμετωπίζετε προβλήματα, παρακαλούμε επικοινωνήστε με τον Webmaster στο **email**");
define("_bterrusernamenotset","Δεν ορίστηκε Όνομα Χρήστη.");
define("_bterrkeynotset","Δεν ορίστηκε Κλειδί Ενεργοποίησης");
define("_bterrusernotexists","Αυτό το Όνομα Χρήστη δεν υπάρχει.");
define("_bterrinvalidactkey","Το Κλειδί Ενεργοποίησης δεν είναι σωστό.");
define("_btuseralreadyactive","Ο Χρήστης είναι ήδη ενεργός. Δεν απαιτείται περαιτέρω ενεργοποίηση");
define("_btacterror","Σφάλμα Ενεργοποίησης");
define("_btactcomplete","Η Ενεργοποίηση Ολοκληρώθηκε. Ο λογαριασμός σας είναι τώρα μονίμως ενεργός. Από δω και πέρα, μπορείτε να έχετε πρόσβαση στις υπηρεσίες μας χρησιμοποιώντας το Όνομα Χρήστη και τον Κωδικό Πρόσβασης που ορίσατε. Καλά Κατεβάσματα.");
define("_btusrpwdnotset","Δεν ορίστηκε Όνομα Χρήστη ή Κωδικός Πρόσβασης.");
define("_bterremailnotset","Δεν ορίστηκε Διεύθυνση Ηλεκτρονικού Ταχυδρομείου.");
define("_btuserpasswrong","Λάθος Όνομα Χρήστη ή Κωδικός Πρόσβασης!!");
define("_btuserinactive","Χρήστης εγγεγραμμένος αλλά όχι ενεργός!!");
define("_btloginsuccessful","Επιτυχής Σύνδεση. Τώρα έχετε προνόμια **priv**. Καλά Κατεβάσματα!");
define("_btlogoutsuccessful","Επιτυχής Αποσύνδεση.");
define("_btusernoexist","Συγγνώμη, το Όνομα Χρήστη που εισαγάγατε, δεν υπάρχει.");
define("_btuserprofile","Το Προφίλ μου");
define("_btedituserprofile","Τροποποίηση Προφίλ");
define("_btusertorrents","Τα Torrents μου");
define("_btcompletename","Πλήρες Όνομα");
define("_btclass","Βαθμίδα");
define("_btclassbanned","Τιμωρημένος!");
define("_btregistered","Εγγεγραμμένος");
define("_btavatar","Φωτογραφία");
define("_btcontacts","Επαφές");
define("_btnewavatargallery","Νέα Φωτογραφία από την Πινακοθήκη");
define("_btnewavatarupload","Ανεβάστε νέα Φωτογραφία");
define("_btinvalidimagefile","Μη υποστηριζόμενο αρχείο εικόνας");
define("_btavatartoobig","Το μέγεθος της εικόνας είναι μεγαλύτερο από το επιτρεπτό");
define("_btlostpasswordintro","Εάν ξεχάσατε τον κωδικό πρόσβασής σας, μπορείτε να επαναποκτήσετε πρόσβαση στον λογαριασμό σας εισάγοντας το Όνομα Χρήστη σας και έναν ΝΕΟ κωδικό πρόσβασης.<br />
Ένα mail επιβεβαίωσης θα αποσταλεί στην διεύθυνση ηλεκτρονικού ταχυδρομείου που σχετίζεται με τον λογαριασμό σας. Σιγουρευτείτε ότι μπορείται να δέχεστε mails (δηλαδή ότι το mailbox σας δεν είναι γεμάτο) προτού καταθέσετε το αίτημά σας. Εάν δεν λάβετε αυτό το mail, προσπαθήστε να ελέγξετε το φίλτρο spam σας.");
define("_btlostpasswordcheckmail","Ένα μήνυμα εστάλη στη διεύθυνση ηλεκτρονικού ταχυδρομείου σας που περιέχει έναν υπερσύνδεσμο ενεργοποίησης. Παρακαλούμε πατήστε αυτόν τον υπερσύνδεσμο, ώστε να πραγματοποιηθεί η αλλαγή Κωδικού Πρόσβασης.");
define("_btlostpwdinvalid","Άκυρος κωδικός ενεργοποίησης ή ID χρήστη");
define("_btlostpwdcomplete","Ο Κωδικός Πρόσβασης άλλαξε. Τώρα μπορείτε να συνδεθείτε με τον νέο σας Κωδικό Πρόσβασης.");
define("_btdeluser","Διαγραφή Λογαριασμού");
define("_btdeluserwarning","<b>ΠΡΟΣΟΧΗ</b>: πρόκειται να διαγράψετε τον λογαριασμό σας μόνιμα και ολοκληρωτικά. Θα χάσετε τα δικαιώματα τροποποίησης για όλα τα torrents που ανεβάσατε. Θα είστε σε θέση να ξανα-εγγραφείτε με το παλιό σας Όνομα Χρήστη μετά από αυτό.");
define("_btdeluserwarningadm","<b>ΠΡΟΣΟΧΗ</b>: πρόκειται να διαγράψετε τον λογαριασμό του/της **user** μόνιμα και ολοκληρωτικά. Ο/Η **user** Θα χάσει τα δικαιώματα τροποποίησης για όλα τα torrents που ανέβασε. Επανεγγραφή με το ίδιο Όνομα Χρήστη θα είναι πιθανή μετά από αυτό.");
define("_btaccountdeleted","Ο λογαριασμός έχει διαγραφεί");
define("_btconfirmdelete","Επιβεβαίωση διαγραφής λογαριασμού");

//USER/EDITPROFILE.PHP
define("_btnewpassword","Νέος Κωδικός Πρόσβασης<br />(αφήστε το κενό, εάν δεν σκοπεύετε να τον αλλάξετε)");
define("_btnewpasswordconfirm","Επιβεβαίωση Νέου Κωδικού Πρόσβασης");
define("_btaol","AOL Instant Messenger");
define("_bticq","ICQ");
define("_btjabber","Jabber IM");
define("_btmsn","MSN Messenger");
define("_btskype","Skype");
define("_btyim","Yahoo! Instant Messenger");
define("_btacceptmail","Να δέχομαι e-mails από άλλους χρήστες");
define("_btcustomlanguage","Γλώσσα");
define("_btaccountstatus","Κατάσταση Λογαριασμού");
define("_btaccountstatusexplain","Ενεργοποίηση/Απενεργοποίηση χρήστη. ΠΡΟΣΟΧΗ! ΑΠΕΝΕΡΓΟΠΟΙΩΝΤΑΣ έναν εγγεγραμμένο χρήστη για περισσότερες από 48 ώρες θα προκαλέσει επίσης διαγραφή του λογαριασμού.");
define("_btaccountactive","Ενεργός");
define("_btaccountinactive","Ανενεργός");
define("_btcustomtheme","Θέμα");
define("_btdefault","Προεπιλογή");
define("_btchooseavatar","Επιλέξτε Φωτογραφία");
define("_btusepasskey","Χρησιμοποιήστε Κλειδί Πρόσβασης");
define("_btpasskeyexplain","Αυτή η επιλογή σας επιτρέπει να κατεβάζετε torrents χρησιμοποιώντας έναν προσωπικό κωδικό ασφαλείας.<br />
Χρησιμοποιώντας έναν προηγμένης τεχνολογίας client, δεν θα πρέπει πια να συνδέεστε στον tracker ή να χρησιμοποιείται Όνομα Χρήστη και Κωδικό Πρόσβασης, ώστε να διατηρείτε ενημερωμένο το ratio σας για τα εσωτερικά torrents του tracker.<br />
Ένας εξατομικευμένος κωδικός εισάγεται αυτόματα στο αρχείο .torrent που κατεβάζετε, ώστε να επιτρέπει την πιστοποίηση του tracker.<br />
<b>ΠΡΟΣΟΧΗ</b>: ΜΗΝ δίνετε .torrents με ενεργοποιημένη πιστοποίηση Κλειδιού Πρόσβασης ανεξέλεγκτα! Μη εξουσιοδοτημένοι χρήστες, ακόμη και χωρίς να συνδεθούν στην ιστοσελίδα, μπορούν να τα χρησιμοποιήσουν και να επηρεάσουν το ratio σας, κάτι που μπορεί με τη σειρά του να μειώσει τις ελευθερίες σας για κατέβασμα από τον tracker.<br />
Στην περίπτωση που ένα .torrent ΠΕΣΕΙ σε λάθος χέρια, μπορείτε να επαναφέρετε το Κλειδί Πρόσβασης.");
define("_btresetpasskey","Επαναφορά Κλειδιού Πρόσβασης");
define("_btresetpasskeywarning","<b>ΠΡΟΣΟΧΗ</b>: όλα τα αρχεία torrent που κατεβάσατε ώς τώρα δεν θα ισχύουν πια!");
define("_btprofilesaved","Το Προφίλ αποθηκεύτηκε επιτυχώς!");
define("_btaccesslevel","Βαθμίδα Πρόσβασης");
define("_btdeleteaccount","Διαγραφή Λογαριασμού");

//TESTI CHE COMPAIONO IN INCLUDE/BITTORRENT.PHP
define("_btindex","Κατάλογος Torrents ");
define("_bttorrentupload","Ανέβασμα Torrent");
define("_btupload","Ανέβασμα");
define("_btlogin","Σύνδεση");
define("_btlogout","Αποσύνδεση");
define("_btsignup","Εγγραφή");
define("_btpersonal","Torrents από ");
define("_btpm","Προσωπικά Μηνύματα");
define("_btadmin","Διεύθυνση");
define("_btrulez","Κανόνες");
define("_btforums","Forum");
define("_bthelp","Βοήθεια");
define("_btadvinst","Εγκαταστήστε το BitTorrent ή το Shareaza για να κατεβάσετε");
define("_btaccessden","Απαγορεύεται η Πρόσβαση. Το κατέβασμα απαιτεί <A href=\"user.php?op=register\">εγγραφή</a>");
define("_btlegenda","Βοήθεια για χαρακτηριστικά και επεξηγήσεις");
define("_btyourfilext","Το αρχείο σας, εξωτερικός tracker");
define("_btfile","αρχείο/αρχεία");
define("_btexternal","Εξωτερικός Tracker");
define("_btyourfile","Το αρχείο σας");
define("_btsticky","Μόνιμο");
define("_btauthforreq","Εξουσιοδότηση για αίτηση");
define("_btauthreq","Αίτηση για Εξουσιοδότηση");
define("_btdown","Κατέβασμα");
define("_btunknown","Άγνωστος");
define("_btrefresh","Ενημέρωση");
define("_btvisible","Ορατό");
define("_btsd","ΔΜ");
define("_btlc","ΛΠ");
define("_bttt","ΣΥΝ");
define("_btseedby","Torrents που διαμοιράζω");
define("_btleechby","Torrents που λαμβάνω");

//TESTI CHE COMPAIONO IN INDEX.PHP
define("_btinfituh","<p>ΕΧΕΤΕ ".$user->invites." ΠΡΟΣΚΛΗΣΕΙΣ</p>");
define("_btsendiv","ΣΤΕΙΛΤΕ ΜΙΑ ΠΡΟΣΚΛΗΣΗ");
define("_btinvites","ΠΡΟΣΚΛΗΣΕΙΣ");
define("_btgames","Παιχνίδια");
define("_btsedbs","Δώρο Διαμοιρασμού:");
define("_btviewrqst","Προβολή αιτημάτων");
define("_btfaqs","Συχνές Ερωτήσεις");
define("_bttorofferd","Torrents που προσφέρονται");
define("_btmemlist","Λίστα Μελών");
define("_btwelcomebk","Καλωσορίσατε");
define("_btwelcome","Καλωσορίσατε στο $sitename");
define("_btneedseed","TORRENTS ΠΟΥ ΧΡΕΙΑΖΟΝΤΑΙ ΔΙΑΜΟΙΡΑΣΜΟ");
define("_btifyhhelpthem","Παρακαλούμε βοηθήστε τα, αν τυχαίνει να έχετε τα αρχεία στον σκληρό σας δίσκο. Ευχαριστούμε!");
define("_btntnseeded","ΚΑΝΕΝΑ TORRENT ΔΕΝ ΧΡΕΙΑΖΕΤΑΙ ΔΙΑΜΟΙΡΑΣΜΟ");
define("_btsearch","Αναζήτηση");
define("_btsearchname","Αναζήτηση torrents");
define("_btsearchfeed","Feed γι' αυτά τ' Αποτελέσματα");
define("_btin","σε");
define("_btalltypes","οτιδήποτε");
define("_btactivetorrents","Ενεργά Torrents");
define("_btitm","Να συμπεριληφθούν νεκρά torrents");
define("_btstm","Μόνον νεκρά Torrents");
define("_btgo","Αναζήτηση!");
define("_btresfor","ταξινόμηση κατά:");
define("_btnotfound","<h2>Κανένα αποτέλεσμα!</h2>\n<p>Δοκιμάστε να αλλάξετε τους όρους αναζήτησής σας.</p>\n");
define("_btvoidcat","<h2>Αυτή η κατηγορία είναι κενή!</h2>");
define("_btorderby","ταξινόμηση κατά");
define("_btinsdate","Ημερομηνία");
define("_btname","Όνομα");
define("_btdim","Μέγεθος");
define("_btnfile","Αριθμός αρχείων");
define("_btevidence","Μόνιμο");
define("_btcomments","Βαθμολογία / Σχόλια");
define("_btvote","Βαθμολογίες");
define("_btdownloaded","Κατεβασμένο");
define("_btprivacy","Μυστικότητα");
define("_bttotsorc","Σύνολο Χρηστών");
define("_btdesc","φθίνουσα");
define("_btord","αύξουσα");
define("_btnosearch","<center><h2>Αναζητήστε τα αρχεία που επιθυμείτε να κατεβάσετε</h2>Αν χρειάζεστε βοήθεια, δοκιμάστε να ρωτήσετε στα Forums; εάν δεν μπορείτε να χρησιμοποιήσετε τους συνδέσμους Magnet:/eD2K:, πιθανώς δεν έχετε εγκατεστημένο το σωστό λογισμικό<br>Σας υπενθυμίζουμε πως σύμφωνα με τους κανόνες μας όλα τα αρχεία είναι ιδιωτικά, και εξαρτάται από όποιον μοιράζεται ένα αρχείο το αν θα επιτρέψει σε άλλους να το κατεβάσουν. Απαγορεύεται αυστηρά να μοιράζεστε υλικό που υπόκειται σε πνευματικά δικαιώματα, πορνογραφικό, παιδικής πορνογραφίας, ρατσιστικό, προσβλητικό ή οτιδήποτε αντίκειται σε νόμους.<br>Κάθε κάτοχος πνευματικών δικαιωμάτων μπορεί να ζητήσει την εφαρμογή ενός δωρεάν φίλτρου ονομάτων αρχείων που επιτρέπει την προστασία των πνευματικών δικαιωμάτων του/της.</center>");
define("_bthelpfind","Βοήθεια Αναζήτησης");
define("_bttypeCAT","Κατηγορία");
define("_bttypes","Κατηγορίες");
define("_bttopsource","ΚΟΡΥΦΑΙΕΣ πηγές κατεβάσματος");
define("_btnotopsource","Δεν υπάρχουν ενεργά torrents αυτήν τη στιγμή");
define("_btnotseeder_noneed","Δεν υπάρχουν κρίσιμα torrents αυτήν τη στιγμή");
define("_btnotseeder_desc","Εάν έχετε κάποιο από αυτά τα αρχεία, παρακαλούμε διαμοιράστε (μοιραστείτε) το με ανθρώπους που περιμένουν να το κατεβάσουν. Κατεβάστε το .torrent, υποδείξτε στον client σας τον φάκελο που περιέχει το πλήρες αρχείο, και αυτό θα αρχίσει να διαμοιράζεται.<br>Ευχαριστούμε που είστε ένας/μία από τους ΚΑΛΟΥΣ/ΚΑΛΕΣ.</b>");
define("_btnoseedersontracker","Το torrent σας δεν διαμοιράζεται!");
define("_btdeadtorrent","Φαίνεται πως <b>το torrent σας δεν διαμοιράζεται</b>. Αυτή η κρίση μπορεί να μην είναι σωστή, επομένως θ' αποδεχθούμε τη φόρτωση του torrent προς το παρόν, αλλά <b>μπορεί οι moderators να το υποστείλουν αργότερα</b>.<br>");
define("_bthelpindex","<p><a name=\"ΒΟΗΘΕΙΑ\"></a><a href='index_help.php'>Εγκαταστήστε το BitTorrent ή το Shareaza για να κατεβάσετε</a>");
define("_btnet","Υγεία Σμήνους");
define("_btsource","Χρήστες");
define("_bttorrent","Torrent");
define("_btview","Αναγνώστηκε");
define("_bthits","Κατέβηκε");
define("_btsnatch","Ολοκληρώθηκε");
define("_btalternatesource","<b>Μόνον εναλλακτικές πηγές (Magnet/ed2K) είανι διαθέσιμες</b>");
define("_btcantscrape","Αδυναμία<b> προσδιορισμού των δεδομένων του χρήστη</b>");
define("_bteasy","<b>Καλοδιαμοιρασμένο</b>");
define("_btmedium","<b>Όχι και τόσο καλά</b>");
define("_bthard","<b>Κακοδιαμοιρασμένο/νεκρό</b>");
define("_btmisssearchkey","Λείπει το Κλειδί Αναζήτησης");
define("_btinfotracker","Ποιος είναι συνδεδεμένος?");
define("_btnouseronline","Κανένας εγγεγραμμένος χρήστης δεν είναι συνδεδεμένος");
define("_btonlineusers","Συνδεδεμένοι Χρήστες");
define("_btadvancedmode","Προχωρημένη Ρύθμιση");
define("_btsimplemode","Απλή Ρύθμιση");
define("_btpagename","Τρέχουσα φυλλομέτρηση");
define("_btloggedinfor","Συνδεδεμένος για");
define("_jscriptconfirmtext","Έχετε ένα νέο ΠΜ, παρακαλούμε πιέστε OK για να μεταφερθείτε στα Εισερχόμενα ΠΜ σας.");
define("_newpm","Νέο ΠΜ");
define("_nonewpm","Κανένα νέο ΠΜ");

//PMBT PAGES
define("_btpage_admin.php","Διεύθυνση");
define("_btpage_chat.php","Συνομιλία");
define("_btpage_details.php","Σελίδα Λεπτομερειών Torrent");
define("_btpage_edit.php","Τροποποίηση Torrent");
define("_btpage_index.php","Αρχική");
define("_btpage_mytorrents.php","Τα Torrents μου");
define("_btpage_search.php","Αναζήτηση");
define("_btpage_upload.php","Φόρτωση");
define("_btpage_phpBB.php","Forum");
define("_btpage_pm.php","Προσωπικά Μηνύματα");
define("_btpage_games.php","Παιχνίδια");
define("_btpage_casino.php","Casino");
define("_btpage_arcade.php","Χώρος Παιχνιδιών");
define("_btpage_keno.php","Keno");
define("_btpage_blackjack.php","Black-Jack");
define("_btpage_viewrequests.php","Ζητούνται Torrents");
define("_btpage_faq.php","Συχνές Ερωτήσεις");
define("_btpage_offers.php","Προσφορές");
define("_btpage_offer.php","Προσφέρτε ένα Torrent");
define("_btpage_requests.php","Ζητήστε ένα Torrent");
define("_btpage_memberslist.php","Λίστα Μελών");
define("_btpage_rules.php","Κανόνες της Ιστοσελίδας");
define("_btpage_torrents.php","Λίστα των Torrents");
define("_btpage_user.php","Πίνακας Ελέγχου Χρήστη");







//TESTI CHE COMPAIONO IN DETAILS.PHP
define("_btinfo","Πληροφορίες Torrent");
define("_bttracker","Tracker");
define("_btddownloaded","Κατέβηκε");
define("_btdcomplete","Ολοκληρώθηκε");
define("_dtimeconnected","Χρόνος Σύνδεσης");
define("_btsourceurl","Διαθέσιμο στο");
define("_btdidle","Διακόπηκε");
define("_btdsuccessfully","Το Torrent φορτώθηκε επιτυχώς");
define("_btdsuccessfully2","Παρακαλούμε αρχίστε τώρα τον διαμοιρασμό. Η ορατότητα εξαρτάται από τον αριθμό των πηγών");
define("_btdsuccessfullye","Τροποποιήθηκε επιτυχώς");
define("_btdgobackto","Πίσω στην σελίδα");
define("_btdwhenceyoucame","Από τότε που ήρθατε");
define("_btdyoursearchfor","Η αναζήτησή σας για");
define("_btnotorrent","Το Torrent δεν υπάρχει ή έχει απαγορευτεί");
define("_btdratingadded","Προστέθηκε Βαθμολογία");
define("_btdspytorrentupdate","Το SpyTorrent ανανέωσε τις πηγές");
define("_btdspytorrentupdate1","Θα ανακατευθυνθείτε στην σελίδα σε 3 δευτερόλεπτα ");
define("_btdspytorrentupdate2","Εάν ο φυλλομετρητής σας δεν σας ανακατευθύνει, πιέστε");
define("_btdspytorrentupdate3","εδώ");
define("_btdspytorrentnoupdate","Δεν είναι απαραίτητο να τρέξετε το SpyTorrent στα εσωτερικά Torrents μέσα σε 15 λεπτά από την τελευταία ανίχνευση.");
define("_btdownloadas","Κατεβάστε ως");
define("_btpieces","Τμήματα");
define("_btpiecesstring","**n** τμήματα μεγέθους **l**");
define("_btauthstatus","Εξουσιοδότηση Κατεβάσματος");
define("_btdwauthpending","Εκκρεμεί");
define("_btdwauthgranted","Χορηγήθηκε!");
define("_btdwauthdenied","Απαγορεύτηκε!");
define("_btdwauthnorequest","Δεν ζητήθηκε ακόμη");
define("_btpremiumdownload","Μόνον Premium χρήστες μπορούν να κατεβάσουν αυτό το αρχείο torrent");
define("_btregistereddownload","Πρέπει να εγγραφείτε ή να συνδεθείτε για να κατεβάσετε αυτό το torrent");
define("_btnetwork","δίκτυο");
define("_btdays","μ ");
define("_bthours","ω ");
define("_btmins","λ ");
define("_btsecs","δ ");
define("_btinfohash","Πληροφορίες Hash");
define("_btinfohashnotice","<b>ΠΡΟΣΟΧΗ</b>: το Torrent τροποποιήθηκε σε βαθμό που ΠΡΕΠΕΙ να ξανα-κατεβαστεί. Το αρχείο που ανεβάσατε δεν ισχύει τώρα πια. Παρακαλούμε χρησιμοποιήστε το κουμπί για κατέβασμα, ώστε να αποκτήσετε την ισχύουσα έκδοση.");
define("_btnodead","<b>όχι</b> (νεκρό)");
define("_btfiles","αρχείο/αρχεία");
define("_btothersource","Άλλες Πηγές");
define("_btnoselected","Δεν επιλέχθηκε κατηγορία. Παρακαλούμε επιστρέψτε στη φόρμα ανεβάσματος.");
define("_btago","πριν");
define("_btlastseeder","Τελευταίος Διαμοιραστής");
define("_btlastactivity","Τελευταία Δραστηριότητα");
define("_bttypetorrent","Τύπος");
define("_btsize","Μέγεθος");
define("_btminvote","Χωρίς ψήφο (απαιτούνται τουλάχιστον __minvotes__ ψήφοι");
define("_btonly","μόνο");
define("_btnone","κανένα");
define("_btnovotes","Χωρίς Αξιολόγηση");
define("_btoo5","από 5 με");
define("_btvotestot","σύνολο ψήφων");
define("_btcomplaints","Παράπονα");
define("_btlogintorate","(<a href=\"user.php?op=loginform\">Συνδεθείτε</a> για να ψηφίσετε)");
define("_btvot1","Κακό");
define("_btvot2","Όχι Καλό");
define("_btvot3","Όχι Κακό");
define("_btvot4","Καλό");
define("_btvot5","Πολύ καλό");
define("_btaddrating","Ψηφίστε");
define("_btvotenow","Αξιολόγηση!");
define("_btrating","Αξιολογήστε");
define("_bthelpstat","Βοήθεια Στατιστικών");
define("_btviews","Αναγνώστηκε");
define("_bttimes","φορές");
define("_btleechspeed","Ταχύτητα Λήψης");
define("_bteta","Εκτιμώμενη Διάρκεια");
define("_btuppedby","Φορτώθηκε από");
define("_btnumfiles","Αριθμός Αρχείων");
define("_btfilelist","Αρχεία");
define("_btlasttrackerupdate","Τελευταία ενημέρωση του tracker");
define("_btshowlist","Δείξε τους Πυρήνες");
define("_bthidelist","Απόκρυψη λίστας Πυρήνων");
define("_bthelpsource","Βοήθεια για τους Πυρήνες");
define("_btseeds","Ολοκληρωμένες Λήψεις");
define("_btcommentsfortorrent","Σχόλια γι' αυτό το torrent");
define("_btbacktofull","Επιστροφή στις πλήρεις λεπτομέρειες");
define("_btnotifyemailcom","Εάν επιθυμείτε να ενημερωθείτε μέσω e-mail, όταν το πρώτο σχόλιο προστεθεί, παρακαλούμε πιέστε <a href=\"details.php?op=comment&trig=on&id=**id**#notify\">ΕΔΩ</a>.");
define("_btnotnotifyemailcom","<p>Έχετε επιλέξει να ενημερώνεστε μέσω e-mail για τα νέα σχόλια. Εάν δεν επιθυμείται να δέχεστε e-mails πια, παρακαλούμε πιέστε <a href=\"details.php?op=comment&trig=off&id=**id**#notify\">ΕΔΩ</a>.</p>");
define("_btclickhere","click here");
define("_btnotifyemail1s","Εάν επιθυμείτε να ενημερωθείτε μέσω e-mail, όταν εμφανιστεί ο πρώτος <b>ΔΙΑΜΟΙΡΑΣΤΗΣ</b>, παρακαλούμε πιέστε <a href=\"details.php?op=seeder&trig=on&id=**id**#notify\">ΕΔΩ</a>.");
define("_btnotnotifyemail1s","<p>Έχετε επιλέξει να ενημερώνεστε μέσω e-mail, όταν εμφανίζεται ένα διαμοιραστής. Εάν δεν επιθυμείται να δέχεστε e-mails πια, παρακαλούμε πιέστε <a href=\"details.php?op=seeder&trig=off&id=**id**#notify\">ΕΔΩ</a>.</p>");
define("_btnocommentsyet","Δεν υπάρχουν σχόλια αυτήν τη στιγμή");
define("_btcommheader","Στις **time**, <a href=\"ο χρήστης.php?op=profile&id=**uid**\" target=\"_top\">**user**</a> έγραψε:");
define("_btdgavesresult","έδωσε ένα αποτέλεσμα");
define("_btdnotifyemaildel","Έχετε επιλέξει να μην λαμβάνετε ειδοποιήσεις για τα νέα σχόλια");
define("_btdnotifyemaildel1","Δεν θα λαμβάνετε πια e-mails, όταν θα προστίθεται κάποιο νέο σχόλιο!");
define("_btdnotifyemailadd1","Θα λαμβάνετε ένα e-mail, όταν προστίθεται κάποιο νέο σχόλιο, αλλά δεν θα λαμβάνετε άλλα e-mails προτού διαβάσετε το σχόλιο!");
define("_btdnotifyemailadd","Έχετε επιλέξει να λαμβάνετε ειδοποιήσεις για τα νέα σχόλια");
define("_btdnotifyadd","Έχετε επιλέξει να λαμβάνετε ειδοποιήσεις για τους νέους διαμοιραστές");
define("_btdnotifyadd2","Θα ενημερώνεστε για τους νέους διαμοιραστές με ένα e-mail καθημερινώς,");
define("_btdnotifydel","Έχετε επιλέξει να μην λαμβάνετε ειδοποιήσεις για τους νέους διαμοιραστές: δεν πρόκειται να λάβετε άλλα e-mails.");
define("_btddetails","Λεπτομέρειες Torrent");
define("_bteditthistorrent","Τροποποίηση Torrent");
define("_btyes","ναι");
define("_btno","όχι");
define("_btadded","Φορτώθηκε");
define("_btaddedby","Φορτώθηκε από");
define("_bton","πάνω");
define("_bthelpothersource","Βοήθεια Εναλλακτικών Πηγών");
define("_btfilename","Όνομα Αρχείου");
define("_btpeers","Πυρήνες");
define("_btpeerstot","Σύνολο Πυρήνων");
define("_bthelppeer","Βοήθεια Πυρήνων");
define("_btleecher","Λήπτης");
define("_btleechers","Λήπτες");
define("_btdhelpdownload","Βοήθεια για Κατέβασμα");
define("_btyourate","Ψηφίσατε");
define("_btupdatesource","Ανανέωση πηγών τώρα!");
define("_btseeder","Διαμοιραστής");
define("_btseeders","Διαμοιραστές");
define("_btcompletion","Complete");
define("_btdirectlink","Ευθύς Υπερσύνδεσμος");
define("_btcomplyouvoted","Χαρακτηρίσατε αυτό το torrent ως: ");
define("_btcomplexplain","Το torrent μπορεί να απαγορευθεί, όταν τα παράπονα γι' αυτό φτάσουν σ' ένα συγκεκριμένο αριθμό.");
define("_btcomplaintform","Φόρμα Παραπόνων Torrent.<BR>Αυτό το σύστημα σας επιτρέπει να επισημάνετε torrents που απάδουν στους κανόνες μας.<BR>
όταν τα παράπονα φτάσουν σ' ένα συγκεκριμένο αριθμό, το torrent μπορεί να απαγορευθεί.<BR>Παρακαλούμε ανατροφοδοτήστε θετικά τα torrents που είναι καλά και νόμιμα.<BR>");
define("_btcomplisay","Αυτό το Torrent είναι ");
define("_btmagnetlink","Υπερσύνδεσμος Magnet");
define("_btnomagnet","Κανένας Υπερσύνδεσμος Magnet δεν είναι διαθέσιμος");
define("_btmagnetlinkdownload","Κατεβάστε το Αρχείο χρησιμοποιώντας Υπερσύνδεσμο Magnet");
define("_bted2klink","Υπερσύνδεσμος eD2K");
define("_btnoed2k","Κανένας Υπερσύνδεσμος ed2K δεν είναι διαθέσιμος");
define("_bted2klinkdownload","Κατεβάστε το Αρχείο χρησιμοποιώντας Υπερσύνδεσμο eD2K");
define("_btcomplatthemoment","Οι χρήστες ανατροφοδότησαν θετικά <b>**p**</b> φορές και αρνητικά <b>**n**</b> φορές.<BR>");
define("_btnotifications","Ειδοποιήσεις μέσω E-Mail");
define("_btreadcomms","Σχόλια");
define("_btpostcomment","Σχολιάστε");
define("_bttransfer","Μεταφορά");
define("_btdownloadspeed","Ταχύτητα Λήψης");
define("_btuploadspeed","Ταχύτητα Διαμοιρασμού");
define("_bttorrentpassword","Προστασία με Κωδικό");
define("_btpasswordquery","Αυτό το torrent προστατεύεται από κωδικό. Ο ιδιοκτήτης του torrent αποφάσισε να το κάνει ορατό μόνον σε εξουσιοδοτημένους χρήστες.<br />Παρακαλούμε δώστε τον κωδικό τώρα, για να αποκτήσετε άμεση πρόσβαση στο torrent.");
define("_btpasswordwrong","Προσοχή: Λάθος Κωδικός.<br />Να θυμάστε ότι στους κωδικούς ισχύει διάκριση πεζών - κεφαλαίων.");
define("_btuploadedpassexplain","Τοποθετήσατε τον κωδικό: <b>**pass**</b>");
define("_btuploadedpassexplain2","Για να παρέχετε σε χρήστες πρόσβαση στο torrent σας, δώστε τους τον ακόλουθο ευθύ υπερσύνδεσμο: <b>**url**<b>");
define("_btcompletedby","Ολοκληρώθηκε από");
define("_bttrackers","Πρόσθετοι Trackers");
define("_bttrackergroup","Ομάδα *");
define("_btexport","Εξαγωγή");
define("_btexportexplain","Κατεβάστε αυτό το Torrent χωρίς το Κλειδί Πρόσβασής σας, για διανομή σε ιστοσελίδες που παρέχουν Υπηρεσίες BitTorrent ευρετηρίου");

//TESTI PRESENTI IN TAKEUPLOADURL.PHP
define("_btinseriti","Εισήχθη");
define("_btand","και");
define("_btnumerror","ο αριθμός τους δεν είναι ίσος και δεν είναι δυνατή η πρόοδος με δυαδική εντολή");
define("_btmaxchar","Οι Διευθύνσεις ED2K έχουν ανώτατο όριο 200 χαρακτήρων");
define("_bted2kstart","Η Διεύθυνση θα έπρεπε να αρχίζει με <b>ed2k://</b>");
define("_bt2par","Από την Διεύθυνση λείπει η δεύτερη παράμετρος: ");
define("_bturlfile","αρχείο");
define("_bturlcontent","Η Διεύθυνση δεν περιλαμβάνει");
define("_btfname","όνομα αρχείου");
define("_bturlsize","Η Διεύθυνση δεν περιλαμβάνει");
define("_btsz","μέγεθος");
define("_btidcode","πληροφορίες hash");
define("_bturlparerror","Η Διεύθυνση δεν περιλαμβάνει την παράμετρο:");
define("_bturlsureerror","Η Διεύθυνση περιλαμβάνει μια παράνομη πηγή");
define("_bturlnotinsert","Πρέπει να εισάγετε έναν Σύνδεσμο ED2K");
define("_btnotip","Δεν προσδιορίστηκε η IP");
define("_btinvip","Μη ισχύουσα IP");
define("_btnoport","Δεν προσδιορίστηκε καμία Θύρα");
define("_btinvport","Μη ισχύουσα Θύρα");
define("_btparmag","καμία");
define("_btnopresent","απούσα");
define("_btmagchar","Οι Διευθύνσεις Magnet έχουν ανώτατο όριο 200 χαρακτήρων");
define("_bftminlimit","Δεν μπορείτε να μοιραστείτε αρχεία μικρότερα από");
define("_btfmaxlimit","Το torrent σας περιλαμβάνει ένα αρχείο που είναι υπερβολικά μεγάλο.");
define("_btillegalword","Το torrent σας δεν πέρασε από το φίλτρο αυτομάτου περιεχομένου για τον ακόλουθο λόγο (αν προσδιορίζεται):.");
define("_btillegalwordinfo","Εάν αισθάνεστε πως δεχθήκατε αυτό το μήνυμα από λάθος, παρακαλούμε επικοινωνήστε $admin_email");
define("_btnoreason","(Δεν προσδιορίστηκε η αιτία");
define("_bturlinserted1","Το Torrent φορτώθηκε. Θα ανακατευθυνθείτε σε 3 δευτερόλεπτα.<BR>Εάν ο φυλλομετρητής σας δεν σας προωθεί, πιέστε ");
define("_bturlinserted2","αυτόν τον υπερσύνδεσμο");
define("_btaddnotifycomment","Προστεθήκατε στη λίστα ενημερώσεων: θα δέχεστε e-mails για τα νέα σχόλια.");
define("_btaddnotifyseeder","Προστεθήκατε στη λίστα ενημερώσεων: θα δέχεστε e-mails για τους νέους διαμοιραστές.");
define("_btnolinkinsert","Δεν εισήχθη κανένας υπερσύνδεσμος");
define("_btexnostartwt","Οι υπερσύνδεσμοι eXeem ξεκινούν με exeem://");
define("_btinvalidexeem","Μη ισχύων υπερσύνδεσμος eXeem!");
define("_btillegalcat","Μη ισχύουσα κατηγορία!");
define("_bttorrentpresent","Το torrent που προσπαθείτε να φορτώσετε έχει ήδη φορτωθεί σ' αυτήν την ιστοσελίδα, ή έχει απαγορευθεί.");
define("_btdescrrequired","Το πεδίο Περιγραφής είναι κενό. Παρακαλούμε επιστρέψτε και εισάγετε μια περιγραφή.");

//TESTI PRESENTI IN UPLOAD.PHP
define("_btuploadatorrent","Φορτώστε ένα Αρχείο Torrent");
define("_btphotoext","Το αρχείο Εικόνας πρέπει να είναι GIF, JPG ή PNG");
define("_btalertmsg","Η αίτηση δεν υποβλήθηκε εξαιτίας των ακόλουθων σφαλμάτων:");
define("_btalertmsg2","Παρακαλούμε διορθώστε τα λάθη και προσπαθήστε ξανά την φόρτωση");
define("_btfnotselected","ΣΦΑΛΜΑ: δεν επιλέχθηκε αρχείο");
define("_btalertdesc","Παρακαλούμε εισάγετε μια περιγραφή που προσδιορίζει τύπο αρχείου και ποιότητα, ιδίως στην περίπτωση αρχείων πολυμέσων");
define("_btalertcat","Επιλέξτε μια κατηγορία");
define("_btconferma","Έτοιμοι για Φόρτωση? Έαν το torrent σας περιέχει πολλαπλά αρχεία, παρακαλούμε ξαναφτιάξτε το σαν ένα πολυ-αρχείο που να περιέχει ολόκληρο τον φάκελο. Διαφορετικά, θα μπορούσε να είναι άχρηστο.");
define("_btalerturl","Εισάγετε έναν υπερσύνδεσμο MAGNET ή ED2K");
define("_btalerturlnum1","Αριθμός υπερσυνδέσμου ED2K");
define("_btalerturlnum2","Ενώ ο αριθμός υπερσυνδέσμου MAGNET είναι");
define("_btalerturlnum3","Ο αριθμός των υπερσυνδέσμων πρέπει να είναι ο ίδιος-- τα torrents αποτελούνται από ζεύγη υπερσυνδέσμων");
define("_btalert5char","Το Όνομα Αρχείου πρέπει να αποτελείται τουλάχιστον από 5 χαρακτήρες");
define("_btofficialurl","Ο επίσημος tracker της ιστοσελίδας είναι: ");
define("_btseeded","Παρακαλούμε φορτώστε μόνον torrents που διαμοιράζονται. Torrents χωρίς πυρήνες δεν θα εμφανιστούν στην κεντρική σελίδα.");
define("_btupfile","Φόρτωση αρχείου:");
define("_btupnfo","Φόρτωση NFO αρχείου:");
define("_bttorrentname","Όνομα Torrent");
define("_btfromtorrent","Θα προκύψει από το Όνομα Αρχείου, αν αφεθεί κενό. ");
define("_btdescname","Προσπαθήστε να του δώσετε ένα περιγραφικό όνομα");
define("_btsrc_url","Πηγή Διεύθυνσης");
define("_btcompulsory"," (Υποχρεωτικό)");
define("_btdescription","Περιγραφή (απαιτείται)");
define("_btnohtml","ΟΧΙ HTML");
define("_btchooseone","Επιλέξτε");
define("_bttype","Τύπος");
define("_btverduplicate","Έλεγχος για όμοια torrents");
define("_btduplicatinfo","Αποτρέπει τη φόρτωση torrents όμοιων με αυτά που υπάρχουν ήδη. Αποεπιλέξτε για να το φορτώσετε εν πάσει περιπτώσει. Να θυμάστε ότι η ύπαρξη πανομοιότυπων torrents για ολόιδια αρχεία μειώνει τη συνολική αποδοτικότητα.");
define("_btupevidence","Μόνιμο");
define("_btupevidencinfo","Χαρακτηρίστε το torrent ως μόνιμο και διατηρήστε το στην κορυφή της λίστας. Περιορισμένο σε moderators/admins");
define("_btowner","Παρουσίαση Ονόματος");
define("_btowner1","Επίδειξη Χρήστη");
define("_btowner2","Ρύθμιση Μυστικότητας");
define("_btowner3","Ρύθμιση Αορατότητας");
define("_btownerinfo","'ΕΠΙΔΕΙΞΗ ΧΡΗΣΤΗ' επιτρέπει σε άλλους χρήστες να βλέπουν το Όνομα Χρήστη σας, η 'ΡΥΘΜΙΣΗ ΜΥΣΤΙΚΟΤΗΤΑΣ' το κρύβει, διατηρώντας δικαιώματα τροποποίησης/διαγραφής, η 'ΡΥΘΜΙΣΗ ΑΟΡΑΤΟΤΗΤΑΣ' (αν είναι διαθέσιμη) κρύβει εντελώς τον χρήστη από το σύστημα, και δεν επιτρέπει καμία τροποποίηση/διαγραφή.");
define("_btupnotify","Ειδοποιήσεις");
define("_btupnotifynfo","Ειδοποίηση μέσω e-mail, όταν ένα σχόλιο προστίθεται");
define("_btupnotifyseed","Ειδοποίηση μέσω e-mail, όταν ένας λήπτης ολοκληρώσει το κατέβασμα του αρχείου (μόνο για torrents του tracker)");
define("_btfsend","Υποβολή");
define("_btinserte2k","Εισαγωγή Υπερσυνδέσμου ED2K");
define("_btmagnetinsert","Εισαγωγή Υπερσυνδέσμου Magnet");
define("_btinsertlinktitle","Εισαγωγή υπερσυνδέσμων για Δίκτυα GNutella και eDonkey2000");
define("_btinsertlinktext","Μπορείτε να προσθέσετε υπερσυνδέσμους eDonkey2000 στο torrent σας, για να αυξήσετε τη διαθεσιμότητα.");
define("_btinserttext2","Μπορείτε να εισάγετε είτε μόνον υπερσυνδέσμους MAGNET είτε μόνον υπερσυνδέσμους ED2K. Εάν και οι δύο λίστες είναι γεμάτες με εγγραφές, δύο υπερσύνδεσμοι θα σχετιστούν με το κάθε αρχείο: με άλλα λόγια ο πρώτος υπερσύνδεσμος ED2K και ο πρώτος υπερσύνδεσμος MAGNET θα σχετιστούν με το πρώτο αρχείο, και πάει λέγοντας...");
define("_bted2kurl","Εισαγωγή υπερσυνδέσμου ED2K");
define("_btsyntax","Όπως");
define("_btfiletype","επέκταση");
define("_btfilesize","μέγεθος");
define("_btipport","ip:θύρα");
define("_btstatic","υποδεικνύει ότι χρησιμοποιούμε μόνον το πρωτόκολλο eDonkey2000");
define("_btfinalname","είναι το όνομα του αρχείου που θα κατέβει");
define("_btfinalsize","είναι το μέγεθος του αρχείου σε bytes");
define("_btfinalidcode","είναι ένας ειδικός κωδικός επιβεβαίωσης που επιτρέπει την εύρεση ΕΝΟΣ ΜΟΝΟΝ ΑΡΧΕΙΟΥ, και των αντιγράφων του, ανάμεσα σε πολλά όμοια");
define("_btfinalipport","αντιπροσωπεύει την κύρια σταθερή πηγή (χρησιμοποιείται από αυτούς που κάνουν τα releases)");
define("_btor","ή");
define("_btaddmagnet","Υπερσύνδεσμος Magnet");
define("_btadded2k","Υπερσύνδεσμος eD2K");
define("_btphoto","Εικόνα");
define("_btexeemlink","Υπερσύνδεσμος eXeem");
define("_btexeemlinkexplain","Προαιρετικό. Εάν το torrent μπορεί να κατέβει μέσω του δικτύου eXeem, μπορείτε να εισάγετε τον εναλλακτικό υπερσύνδεσμο εδώ");
define("_bttorrentpasswordexplain","Μπορείτε να επιλέξετε έναν κωδικό πρόσβασης για να προστατεύσετε το Torrent σας από μη εξουσιοδοτημένη προβολή. Εάν ένας κωδικός πρόσβασης τοποθετηθεί, το Torrent δεν θα είναι ορατό σε κανέναν εκτός από τους Premium Χρήστες και τους Administrators στη Λίστα των Torrents και στην Αναζήτηση των Torrents. Θα πρέπει να παράσχετε έναν ευθύ υπερσύνδεσμο στους ανθρώπους που επιθυμείτε να έχουν πρόσβαση στο Torrent.
Μόνον Εσωτερικά Torrents μπορούν να Προστατεύονται με Κωδικό Πρόσβασης.");
define("_btupadvopts","Προχωρημένες Επιλογές");
define("_btadvoptsexplain","Προβολή προχωρημένων επιλογών, που ελέγχουν κάποιες τεχνικές πτυχές του torrent. Χρησιμοποιήστε αυτές τις επιλογές μόνον αν ξέρετε τι κάνετε!");
define("_btleaveintact","Μην τροποποιήσετε αυτήν τη ρύθμιση");
define("_btdhtsupport","Υποστήριξη DHT");
define("_btendht","Εξαναγκασμός αντιγράφου tracker DHT");
define("_btdisdht","Απενεργοποίηση DHT tracker");
define("_btdhtsupportexplain","Αυτό εξαναγκάζει τη λειτουργία ενός αντιγράφου tracker DHT στο torrent σας, ή την απενεργοποιεί. Το DHT είναι χρήσιμο όταν ο κεντρικός tracker είναι αποσυνδεδεμένος ή παραφορτωμένος");
define("_btprivatetorrent","Ιδιωτικό Torrent");
define("_btenpvt","Χαρακτηρισμός torrent ως ιδιωτικού");
define("_btdispvt","Χαρακτηρισμός torrent ως δημοσίου");
define("_btprivatetorrentexplain","Η \"private\"-επιλογή (την οποία μόνον ορισμένοι clients μπορούν να χειριστούν), λέει στον client to συναλλάσσεται μόνον με πυρήνες που δέχεται από τον κεντρικό tracker. Η Ενεργοποίηση της Ιδιωτικής επιλογής απενεργοποιεί το DHT");

//UPLOAD-LINK
define("_btuploadalinkarchive","Υποβολή Υπερσυνδέσμου eD2K/Magnet");
define("_btsharelink","Φόρτωση μόνον εάν το αρχείο μοιράζεται.");
define("_btlinknotice","Ο υπερσύνδεσμος ΔΕΝ θα γίνει δεκτός, εάν περισσότερα από τα μισά αρχεία που υποβάλλετε είναι ήδη παρόντα στον κατάλογο. Οι διπλοεγγραφές μειώνουν τη συνολική αποδοτικότητα");
define("_btarchivename","Όνομα");
define("_btinsert1file","Εισάγετε υπερσύνδεσμο για το αρχείο σας, και πιέστε 'Προσθήκη Αρχείου'. Ο υπερσύνδεσμος eD2K είναι υποχρεωτικός. Μπορείτε να προσθέσετε περισσότερα από ένα αρχεία κατά την υποβολή σας.");
define("_btlinksnomatch","Οι σύνδεσμοι που εισαγάγατε δεν ανταποκρίνονται στο ίδιο αρχείο");
define("_btinvalided2k","Μη ισχύων σύνδεσμος eD2K");
define("_btinvalidmagnet","Μη ισχύων σύνδεσμος Magnet");
define("_btaddnewfile","Προσθήκη Αρχείου");
define("_btaddtoarchive","Προσθήκη Αρχείου");
define("_btaddmd5","MD5 Hash");
define("_btlinks","Υπερσύνδεσμοι");
define("_bterrduplicatelinks","Διπλοεγγεγραμμένα Αρχεία δεν επιτρέπονται");
define("_btduplicatelinks","Διπλοεγγεγραμμένα Αρχεία");
define("_btduplicateexplain","Το αρχείο που αναπαρίσταται από τον υπερσύνδεσμο που υποβάλατε φιλοξενείται ήδη σ' αυτήν την ιστοσελίδα. Πιέστε το προειδοποιητικό σύμβολο δίπλα στο αρχείο για να ελέγξετε το torrent/τη συλλογή στο/ην οποίο/α βρέθηκε. Εάν περισσότερα από το 50% των υπερσυνδέσμων που προσθέσατε υπάρχει ήδη, η υποβολή σας δεν θα γίνει δεκτή");
define("_btinsertfilesfirst","Πρέπει να υποβάλλετε τουλάχιστον ένα αρχείο χρησιμοποιώντας το κατάλληλο κουμπί");
define("_btfilelistaltered","Η λίστα αρχείων τροποποιήθηκε! Δεν δημιουργήθηκε με χρήση αυτού του εργαλείου.");

//INTERNAL TRACKER
define("_btuserip","Όνομα Χρήστη/IP");
define("_btport","Θύρα");
define("_btdownloadedbts","Κατεβασμένα");
define("_btuploadedbts","Ανεβασμένα");
define("_btratio","Ratio");
define("_btpercent","Ολοκληρωμένες Λήψεις");
define("_btconnected","Συνδεδεμένος");
define("_btidle","Ανενεργός");
define("_btconn","Σύνδεση");
define("_btactive","Ενεργός");
define("_btpassive","Παθητικός");
define("_btpeerspeed","Μέση Ταχύτητα");
define("_btnopeer","Δεν υπάρχουν Πυρήνες");

//Scrape external torrents
if (!eregi("admin.php",$_SERVER["PHP_SELF"])){
define("_admtrackers","Εξωτερικοί Trackers");
define("_admtrackerurl","Διεύθυνση URL Κοινοποίησης Tracker");
define("_admtrkstatus","Κατάσταση");
define("_admtrkstatusactive","Ενεργός");
define("_admtrkstatusdead","Αποσυνδεδεμένος");
define("_admtrklastupdate","Ενημερωμένος");
define("_admtrkscraping","Ενημέρωση");
define("_admtrkassociatedtorrents","Torrents");
define("_admtrkcannotopen","Αδυναμία επικοινωνίας με τη Διεύθυνση URL. Ο Tracker θα χαρακτηριστεί ως αποσυνδεδεμένος");
define("_admtrkrawdata","Ο Tracker έγινε προσβάσιμος. Ορίστε η κωδικοποιημένη απάντηση");
define("_admtrkinvalidbencode","Αδυναμία αποκωδικοποίησης της απάντησης του Tracker. Μη ισχύουσα κωδικοποίηση");
define("_admtrkdata","Η Αποκωδικοποίηση ολοκληρώθηκε. Ορίστε όλα τα δεδομένα Scrape που αποσπάστηκαν");
define("_admtrksummarystr","Εύρεση <b>**seed**</b> διαμοιραστές, <b>**leechers**</b> λήπτες, <b>**completed**</b> ολοκληρωμένες λήψεις για το Torrent **name** Πληροφορίες Hash **hash**.");
}

//TESTI CHE COMPAIONO IN COMMENT.PHP
define("_btiderror","Μη ισχύουσα ID");
define("_btnotfoundid","Το Torrent δεν υπάρχει");
define("_btaddcomment","Πρόσθεσε σχόλιο σε");
define("_btaddtime","Φορτωμένο ");
define("_btby","από");
define("_btsend","Υποβολή");
define("_btnotyourcomment","Δεν μπορείτε να τροποποιήσετε τα σχόλια άλλων.");
define("_btcommentinserted","Το Σχόλιό σας δημοσιεύτηκε. Θα ανακατευθυνθείτε στη σελίδα πληροφοριών του torrent σε 3 δευτερόλεπτα.<br>Πιέστε <a href=\"details.php?id=**id**#comments\">ΕΔΩ</a> αν ο φυλλομετρητής σας δεν σας προωθεί.");
define("_btcommentdeleted","Το Σχόλιο διαγράφτηκε. Θα ανακατευθυνθείτε στη σελίδα πληροφοριών του torrent σε 3 δευτερόλεπτα.<br>Πιέστε <a href=\"details.php?id=**id**#comments\">ΕΔΩ</a> αν ο φυλλομετρητής σας δεν σας προωθεί.");

//TESTI CHE COMPAIONO IN DOWNLOAD.PHP
define("_bttorrentunavailable","Το αρχείο Torrent δεν είναι διαθέσιμο εξαιτίας ενός σφάλματος διαμόρφωσης του server. Συγγνώμη για την αναστάτωση.");
define("_btminseedrule","Πρέπει να διαμοιράζετε τουλάχιστον **min** torrents για να κατεβάσετε.");
define("_btmaxdailydownloads","Δεν μπορείτε να κατεβάσετε περισσότερα από **max** αρχεία την ημέρα. Παρακαλούμε προσπαθήστε ξανά αύριο.");
define("_btmaxweeklydownloads","Δεν μπορείτε να κατεβάσετε περισσότερα από **max** αρχεία τη βδομάδα. Παρακαλούμε προσπαθήστε ξανά την επόμενη βδομάδα.");
define("_bterrtoosmall","<li>Πρέπει να διαμοιράσετε ένα αρχείο τουλάχιστον <b>**min_share**</b> το μέγεθος του.<br>");
define("_bterrtoobig","<b>Το μεγαλύτερο αρχείο που διαμοιράζετε είναι ");
define("_bterrorprivate","Αυτό είναι ένα ιδιωτικό αρχείο: έχετε ήδη αιτηθεί εξουσιοδότησης για να το κατεβάσετε. Δεν μπορείτε να κατεβάσετε το αρχείο ώσπου ο ιδιοκτήτης να δεχθεί το αίτημά σας.");
define("_btrefused","Ο ιδιοκτήτης δεν δέχθηκε το αίτημά σας για εξουσιοδότηση. Δεν θα μπορέσετε να κατεβάσετε αυτό το torrent.");
define("_bterrblacklist","Ο ιδιοκτήτης δεν δέχθηκε να σας επιτρέψει να κατεβάσετε τα torrents του. Δεν θα μπορέσετε να κατεβάσετε κανένα από αυτά.");
define("_btreqsent","Αυτό το Torrent είναι ιδιωτικό. Δεν θα μπορείτε να το κατεβάσετε ώσπου ο ιδιοκτήτης σας δώσει εξουσιοδότηση.
Ένα αίτημα εστάλη στον ιδιοκτήτη του torrent, που πρέπει να εξουσιοδοτήσει το κατέβασμά σας: θα ενημερωθέιτε για το αποτέλεσμα μέσω e-mail.");

//TESTI CHE COMPAIONO IN EDIT.PHP
define("_btedittorrent","Τροποποίηση Torrent");
define("_bterreditnoowner","<h1>Απαγορεύεται η Πρόσβαση</h1>\n<p>Μόνον ο ιδιοκτήτης του torrent και οι administrators μπορούν να τροποποιήσουν τα torrents</p>\n");
define("_btbanned","Απαγορευμένο");
define("_btcancel","Άκυρο");
define("_btdelcommand","Μην τροποποιήσετε το torrent, αλλά <input type=\"submit\" value=\"ΔΙΑΓΡΑΨΤΕ ΤΟ!\" />\n");
define("_btsure","Ναι: είμαι σίγουρος γι' αυτό!");
define("_btban","Απαγόρευση Torrent");
define("_btareyousure","Είστε σίγουρος/η πως θέλετε να διαγράψετε το <b>**name**</b>?");
define("_btareyousure_ban","Είστε σίγουρος/η πως θέλετε να απαγορέψετε το <b>**name**</b>?");
define("_bttorrentnoexist","Αυτό το torrent δεν υπάρχει");
define("_btdelete","Διαγραφή torrent");
define("_btcannotdel","Αδυναμία διαγραφής");
define("_btmissingdata","Έλλειψη απαραίτητων δεδομένων!");
define("_btdeldenied","Μόνον ο ιδιοκτήτης του torrent ή οι administrators της ιστοσελίδας μπορούν να διαγράψουν αυτό το torrent");
define("_btnotconfirmed","Πρέπει να επιβεβαιώσετε πως είστε σίγουρος/η για το τι πρόκειται να κάνετε.");
define("_btdeleted","Το Torrent διαγράφτηκε");
define("_btsuccessfullyedited","Το Torrent επιτυχώς τροποποιήθηκε. Θα ανακατευθυνθείτε στη σελίδα πληροφοριών του torrent. Να θυμάστε πως εάν έχετε επιλέξει Ρύθμιση Αορατότητας, δεν θα μπορείτε πια να τροποποιήσετε ή να διαγράψετε το torrent!");

//TESTI CHE COMPAIONO IN MYTORRENTS.PHP
define("_btmytorrentsintrotitle","Πίνακας Ελέγχου Torrent");
define("_btmytorrentsintrotext","Σ' αυτήν την περιοχή, μπορείτε να διαχειρίζεστε τα torrents που ανεβάσατε (εκτός από εκείνα για τα οποία έχει επιλεγεί Ρύθμιση Αορατότητας).<br>
Μπορείτε επίσης να διαχειρίζεστε τα αιτήματα άλλων χρηστών για κατέβασμα. Επιλέγοντας την κατάλληλη εικόνα, μπορείτε να δείτε όλα τα αιτήματα που στάλθηκαν σε σας από άλλους χρήστες. Θα πρέπει να αποφασίσετε αν δεχθείτε ή όχι ένα αίτημα για κατέβασμα.<br>
Δώστε προσοχή στους όγκους ανεβασμένων και κατεβασμένων του χρήστη. Άνθρωποι που κατεβάζουν χωρίς να μοιράζονται δεν είναι ωφέλιμοι για το Δίκτυο BitTorrent. Απορρίπτοντας το αίτημά τους για κατέβασμα μπορεί να είναι ένας κατάλληλος τρόπος να τους ενθαρρύνετε να μοιραστούν περισσότερο.");
define("_btmytorrents","Τα Torrents μου");
define("_btallauthorized","Όλοι οι χρήστες είναι εξουσιοδοτημένοι");
define("_btauths","Αιτήματα για Κατέβασμα");
define("_btauthorized","Ο επιλεγμένος χρήστης είναι εξουσιοδοτημένος");
define("_bthasauthorized","Ο ιδιοκτήτης σας εξουσιοδότησε να κατεβάσετε τα αρχεία του");
define("_btnowcandownload","Μπορείτε τώρα ελεύθερα να κατεβάσετε όλα τα αρχεία του χρήστη.\nΠροστατεύουμε την ιδιωτικότητά σας.");
define("_pendingauths","Εκκρεμείς Εξουσιοδοτήσεις: ");
define("_btauthorizationrequested","Οι ακόλουθοι χρήστες έχουν αιτηθεί εξουσιοδότησης για κατέβασμα:");
define("_btnotorrents","Δεν υπάρχουν torrents");
define("_btnotorrentuploaded","Δεν έχετε ακόμη ανεβάσει κανένα torrent");
define("_btactions","Ενέργειες");
define("_bthasuploaded","Ανεβασμένα: **");
define("_bthasdownloaded","Κατεβασμένα: **");
define("_btauthgrant","Εξουσιοδότησε");
define("_btauthalwaysgrant","Πάντα να Εξουσιοδοτείς");
define("_btauthalwaysdeny","Ποτέ να μην Εξουσιοδοτείς");
define("_btauthdeny","Μην Εξουσιοδοτήσεις");
define("_btcantseeothertorrents","Δεν μπορείτε να δείτε τις άδειες των torrents άλλων χρηστών!");
define("_btauthpanel","Πίνακας Ελέγχου Εξουσιοδοτήσεων Κατεβάσματος");
define("_btnoauthstomanage","Δεν υπάρχουν Εξουσιοδοτήσεις για να διαχειριστείτε");
define("_btmyglobals","Οι Γενικές μου Εξουσιοδοτήσεις");
define("_btnoglobals","Δεν υπάρχουν ακόμη Γενικές Εξουσιοδοτήσεις");
define("_btstatus","Κατάσταση");
define("_btauthreset","Επαναφορά");
define("_btwronginput","Σφάλμα κατά την εισαγωγή δεδομένων");
define("_btgeneraloptions","Γενικές Επιλογές");
define("_btprivate","Ιδιωτικό");
define("_btprivateexpl","Επιλέξτε το για να απαιτείτε από τους χρήστες να ζητούν μια εξουσιοδότηση για κατέβασμα για να έχουν πρόσβαση στο Torrent. Θα ενημερώνεστε για κάθε νέα εκκρεμή εξουσιοδότηση μέσω e-mail.
Θα μπορείτε να επιλέγετε να χορηγήσετε ή να αρνηθείτε την εξουσιοδότηση για αυτό το torrent ξεχωριστά ή για όλα σας τα torrents");
define("_btminratio","Ελάχιστο Ratio");
define("_btdisabled","Απενεργοποιήθηκε");
define("_btminratioexpl","Μπορείτε να ορίσετε μια ελάχιστη τιμή του ratio για να αυτο-εξουσιοδοτείτε χρήστες. Χρήστες με ratio μεγαλύτερο ή ίσο με αυτήν θα μπορούν να κατεβάζουν χωρίς να ζητούν εξουσιοδότηση.
Η ελάχιστη τιμή του ratio δεν θα παρουσιάζεται σε άλλους, εκτός από τους Administrators");

//TESTI CHE COMPAIONO IN TAKECOMMENT.PHP
define("_btcommentkeyfound","Το σύστημα έλεγξε το σχόλιό σας. Οι ακόλουθες λέξεις δεν επιτρέπονται:<ol>");
define("_btcommentkeyfound2","</ol><p>Γνωρίζουμε πως το σχόλιο μπορεί ακόμη να είναι εν τάξει, ζητούμε συγγνώμη για την αναστάτωση και σας παρακαλούμε να χρησιμοποιήσετε διαφορετικό λεξιλόγιο.</p>");

//TESTI CHE COMPAIONO IN TAKEEDIT.PHP
define("_btmissingformdata","Απουσία εισαγωγής δεδομένων!");
define("_bteditfailed","Αποτυχία Τροποποίησης");
define("_bteditdenied","Δεν μπορείτε να τροποποιήσετε τα torrents άλλων.");
define("_btreturl","Επιτυχής τροποποίηση του Αρχείου, θα ανακατευθυνθείτε στη σελίδα πληροφοριών του torrent σε 3 δευτερόλεπτα.<br>Πιέστε <a href=\"**returl**\">ΕΔΩ</a>εάν ο φυλλομετρητής σας δεν σας προωθεί");

//TESTI CHE COMPAIONO IN RATE.PHP
define("_btrate","Αξιολόγηση Torrent");
define("_btratefailed","Αποτυχία Ψήφου!");
define("_btinvalidrating","Άκυρη ψήφος");
define("_btidnotorrent","Μη ισχύουσα ID. Το Torrent δεν υπάρχει");
define("_btnovoteowntorrent","Δεν μπορείτε να αξιολογήσετε τα δικά σας torrents");
define("_btalreadyrated","Το Torrent ήδη αξιολογήθηκε");
define("_btcantvotetwice","Συγγνώμη, αλλά δεν μπορείτε να αξιολογήσετε ένα torrent δυο φορές");
define("_btvotedone","Επιτυχής Ψήφος, θα ανακατευθυνθείτε στη σελίδα πληροφοριών του torrent σε 3 δευτερόλεπτα.<br>Πιέστε <a href=\"details.php?id=**id**\">ΕΔΩ</a>εάν ο φυλλομετρητής σας δεν σας προωθεί.");

//TESTI CHE COMPAIONO IN TAKEUPLOAD.PHP
define("_btuploaderror","Αποτυχία Φόρτωσης!");
define("_btemptyfname","Κενό Όνομα Αρχείου");
define("_btinvalidfname","Μη ισχύον Όνομα Αρχείου");
define("_btinvalidnfofname","Μη ισχύον Όνομα Αρχείου NFO");
define("_btfnamenonfo","Αυτό δεν είναι ένα αρχείο NFO (.nfo)");
define("_btfnamenotorrent","Αυτό δεν είναι ένα αρχείο torrent (.torrent)");
define("_btferror","Σφάλμα Αρχείου");
define("_bterrnofileupload","Κρίσιμο σφάλμα στο ανεβασμένο αρχείο.");
define("_bterrnonfoupload","Κρίσιμο σφάλμα στο ανεβασμένο αρχείο NFO.");
define("_btemptyfile","Κενό Αρχείο");
define("_btnobenc","Κατεστραμμένο Αρχείο. Είστε σίγουρος/η πως αυτό είναι στ' αλήθεια ένα αρχείο torrent?");
define("_btnodictionary","Ανυπαρξία λεξικού Torrent");
define("_btdictionarymisskey","Απουσία Κλειδιών Λεξικού Torrent");
define("_btdictionaryinventry","Μη ισχύοντα δεδομένα εντός Λεξικού Torrent");
define("_btdictionaryinvetype","Μη ισχύοντες τύποι δεδομένων εντός Λεξικού Torrent");
define("_btinvannounce","Μη ισχύουσα Διεύθυνση URL Κοινοποίησης. Πρέπει να είναι ");
define("_btactualannounce","Καθορισμένος tracker ");
define("_bttrackerdisabled","Ο tracker μας είναι απενεργοποιημένος: μόνον εξωτερικά torrents μπορούν να ανέβουν.");
define("_btinvpieces","Μη ισχύοντα μέρη torrent");
define("_btmissinglength","Απουσία αχείων και μέγεθος");
define("_btnofilesintorrent","Απουσία αχείων Torrent");
define("_btfnamerror","Μη ισχύον όνομα αρχείου");
define("_btinvalidhtml","Μη ισχύον Κώδικας HTML. Σιγουρευτείτε ότι χρησιμοιήσατε τον συντάκτη μας χωρίς χειροκίνητη εισαγωγή κώδικα.");
define("_bttrackerblacklisted","Ο tracker που χρησιμοποιείται από αυτό το torrent (<b>**trk**</b>) έχει μπει στην μαύρη λίστα. Παρακαλούμε χρησιμοποιήστε έναν διαφορετικό.");
define("_btfilenamerror","Σφάλμα στο όνομα αρχείου");
define("_bttorrenttoosmall","<p>Δεν μπορείτε να μοιραστείτε ένα αρχείο μικρότερο από <b>");
define("_bttorrenttoosmall2","</b></p><p>Το torrent περιέχει ένα αρχείο με το ακόλουθο μέγεθος: <b>");
define("_btmaxuploadexceeded","Δεν μπορείτε να ανεβάσετε περισσότερα από **maxupload** σε μια περίοδο 24 ωρών.");
define("_btnumfileexceeded","<p>Δεν μπορείτε να ανεβάσετε περισσότερα από <b>**maxupload**</b> αρχεία σε μια περίοδο 24 ωρών.</p><p>Ήδη ανεβάσατε <b>**rownum**</b> αρχεία, συνολικού μεγέθους <b>**totsize**</b>");
define("_btsearchdupl","Σύμφωνα με την αναζήτηση, αυτά τα αρχεία μπορεί να ανταποκρίνονται σ' αυτά που μοιράζεστε:<ol>");
define("_btduplinfo","<p>Εάν το αρχείο σας είναι στη λίστα, παρακαλούμε διαμοιράστε ένα από αυτά τα torrents!</p>");
define("_btsocktout","ΣΦΑΛΜΑ: λήξη χρόνου Υποδοχής");
define("_bttrackernotresponding","Ο Tracker δεν ανταποκρίνεται.\n Ελέγξτε την ορθρογραφία του tracker (ΟΧΙ ΚΕΝΑ ΔΙΑΣΤΗΜΑΤΑ ΕΝΤΟΣ ΔΙΕΥΘΥΝΣΕΩΝ URL) και ότι ο tracker είναι σε λειτουργία. Ο tracker που προσδιορίσατε είναι:");
define("_bttrackerdata","Μη ισχύοντα δεδομένα από εξωτερικό tracker. Ο tracker μπορεί να έχει προβλήματα σχετικά με τον servers. Παρακαλούμε προσπαθήστε ξανά αργότερα.");
define("_bttorrentnotregistered","Το Torrent φαίνεται πως δεν είναι εγγεγραμμένο στον εξωτερικό tracker. Μπορείτε να ανεβάσετε εξωτερικά torrents μόνον εάν αυτά είναι ενεργά.");
define("_btuploadcomplete","Επιτυχής φόρτωση. Θα ανακατευθυνθείτε στη σελίδα πληροφοριών του torrent σε 3 δευτερόλεπτα. Θυμηθείτε να το διαμοιράσετε, διαφορετικά το torrent δεν θα είναι ορατό στην κεντρική σελίδα.<br>Πιέστε <a href=\"**url**\">ΕΔΩ</a> εάν ο φυλλομετρητής σας δεν σας προωθεί.");
define("_btpresent","Αυτό το torrent έχει ήδη ανέβει");
define("_btscrapeerror","Αδυναμία λήψης δεδομένων πυρήνα από τον tracker");

//TESTI CHE COMPAIONO IN TAKECOMPLAINT.PHP
define("_btcomplisnowbanned","Αυτό το Torrent απαγορεύθηκε εξαιτίας ενός αριθμού παραπόνων");
define("_btcomplcantvotetwice","Λυπούμαστε, μα δεν μπορείτε να διαμαρτυρηθείτε δυο φορές.");
define("_btcomplainttaken","Το Παράπονο καταγράφηκε. Θα ανακατευθυνθείτε στη σελίδα πληροφοριών του torrent σε 3 δευτερόλεπτα. Εάν ο φυλλομετρητής σας δεν σας προωθεί, πιέστε ");
define("_btcomplsuccess","Το Παράπονο σας καταγράφηκε. Το Όνομα Χρήστη και η IP καταγράφηκαν: παρακαλούμε μην καταχραστείτε το σύστημα.<BR>");

//SHOUTBOX
define("_btshoutbox","Shoutbox");
define("_btnoshouts","Κανείς δεν φωνάζει...");
define("_btshoutnow","Φώναξε!");


//IMAGE ALTERNATES
define("_btalt_banned","Απαγορευμένο torrent");
define("_btalt_auth_none","Δεν υπάρχουν Εκκρεμείς Εξουσιοδοτήσεις");
define("_btalt_auth_pending","Εκκρεμείς Εξουσιοδοτήσεις!");
define("_btalt_sticky","Μόνιμο torrent");
define("_btalt_download","Κατέβασμα");
define("_btalt_edit","Τροποποίηση");
define("_btalt_drop","Διαγραφή");
define("_btalt_scrape","Ανανέωση Δεδομένων Πυρήνων");
define("_btalt_noscrape","Τα στατιστικά ενημερώθηκαν πριν από λιγότερο από 30 λεπτά");
define("_btalt_logintoscrape","Συνδεθείτε για να Ελέγξετε τα Δεδομένα των Πυρήνων");
define("_btalt_duplicate","Διπλοεγγεγραμμένο αρχείο");
define("_btalt_exeem","Κατέβασμα μέσω eXeem");
define("_btalt_error.gif","Σφάλμα");
define("_btalt_icon_admin","Administrator");
define("_btalt_icon_moderator","Moderator");
define("_btalt_icon_premium.gif","Premium Χρήστης");
define("_btalt_1.gif","ΚΑΚΙΣΤΟ");
define("_btalt_1.5.gif","Πολύ Κακό");
define("_btalt_2.gif","Κακό");
define("_btalt_2.5.gif","Κάτω του μετρίου");
define("_btalt_3.gif","Μέτριο");
define("_btalt_3.5.gif","Καλύτερα από μέτριο");
define("_btalt_4.gif","Καλό");
define("_btalt_4.5.gif","Πολύ Καλό");
define("_btalt_5.gif","Άριστο");
define("_btalt_anon_tracker.gif","Ανώνυμος Tracker");
define("_btalt_button_aim.gif","AOL Instant Messenger");
define("_btalt_button_icq.gif","ICQ");
define("_btalt_button_irc.gif","IRC");
define("_btalt_button_msn.gif","MSN Messenger");
define("_btalt_button_yahoo.gif","Yahoo! Messenger");
define("_btalt_ed2k_active.gif","Κατέβασμα με χρήση eD2K URI");
define("_btalt_ed2k_inactive.gif","Υπερσύνδεσμος eD2K μη Διαθέσιμος");
define("_btalt_magnet","Κατέβασμα με χρήση Magnet URI");
define("_btalt_magnet_inactive.gif","Εναλλάκτικός Υπερσύνδεσμος μη Διαθέσιμος");
define("_btalt_green.gif","Γρήγορα");
define("_btalt_yellow.gif","Αργά");
define("_btalt_red.gif","Παύση");
define("_btalt_quest.gif","Άγνωστα δεδομένα πυρήνων");
define("_btalt_lock","Εκκρεμής Εξουσιοδότηση");
define("_btalt_lock_request","Αίτηση Εξουσιοδότησης");
define("_btalt_noavatar.gif","Χωρίς Φωτογραφία Προφίλ");
define("_btalt_icon_active.gif","Ενεργός");
define("_btalt_icon_passive.gif","Παθητικός");
define("_btalt_external","Εξωτερικός Tracker");

define("_btunknownclient","Άγνωστος Client");
define("_btalt_avatar","Φωτογραφία Προφίλ για **user**");

//STATISTICS
define("_btstats","Στατιστικά");

//PRIVATE MESSAGES
define("_btyougotpm","Έχετε νέα/αδιάβαστα μηνύματα!");
define("_btpmintro","Εδώ μπορείτε να διαβάζετε προσωπικά μηνύματα από άλλους χρήστες. Δεν υπάρχει ανώτατο όριο αποθηκευτικού χώρου.
Παρόλ' αυτά, προτείνουμε να διαγράφετε που και που τα παλιά μηνύματα. Μπορείτε να στείλετε μήνυμα σε όλους τους εγγεγραμμένους χρήστες.");
define("_btinbox","Εισερχόμενα");
define("_btpmnomessages","Δεν υπάρχουν μηνύματα");
define("_btpmsub","Θέμα");
define("_btpmfrom","Από");
define("_btpmdate","Ημερομηνία");
define("_btplmselect","Επιλογή");
define("_btpmread","Αναγνωσμένο");
define("_btpmunread","Μη Αναγνωσμένο");
define("_btpmnewmsg","Νέο μήνυμα");
define("_btpmdelete","Διαγραφή μηνυμάτων");
define("_btpmdelall","Διαγραφή όλων των μηνυμάτων");
define("_btpmdelconfirm","Σίγουρα επιθυμείτε να διαγράψετε όλα τα επιλεγμένα μηνύματα?");
define("_btpmdelbtn","Διαγραφή μηνυμάτων");
define("_btpmdelallconfirm","Σίγουρα επιθυμείτε να διαγράψετε <b>όλα</b> τα προσωπικά σας μηνύματα?");
define("_btpmdeletedsuccessfully","Επιτυχής διαγραφή μηνυμάτων");
define("_btnewpm","Νέο μήνυμα");
define("_btpmto","Αποδέκτης");
define("_btpmtotip","Εάν επιθυμείτε να στείλετε το ίδιο μήνυμα σε πολλούς χρήστες, χωρίστε τους με ένα ελληνικό ερωτηματικό (;)");
define("_btpmshowbookmarks","Εμφάνιση/Απόκρυψη λίστας επαφών");
define("_btpmtext","Κείμενο μηνύματος");
define("_btpmnorecipient","Πρέπει να προσδιορίσετε έναν αποδέκτη");
define("_btpmnosubject","Πρέπει να προσδιορίσετε ένα θέμα");
define("_btpmnomessage","Κενό μήνυμα");
define("_btpminvalidrecipients","Ένας ή περισσότεροι από τους αποδέκτες που εισαγάγατε δεν υπάρχει");
define("_btpmsentsuccessfully","Επιτυχής αποστολή μηνύματος");
define("_btpmuserblocked","Ένας από τους αποδέκτες έχει επιλέξει να μην δέχεται μηνύματά σας. Γράψατε:<br><br>");
define("_btmessage","Μήνυμα");
define("_btinvalidpm","Μη ισχύον μήνυμα");
define("_btpmnoexists","Το μήνυμα δεν υπάρχει");
define("_btpmreply","Απάντηση");
define("_btuserlists","Φίλοι και αγνοημένοι χρήστες");
define("_btuserlistsintro","Εδώ μπορείτε να διαχειρίζεστε τις λίστες των φίλων και των αγνοημένων χρηστών. Η πρώτη είναι διαθέσιμη στη λίστα επαφών σας για γρήγορη πρόσβαση κατά την αποστολή νέου μηνύματος.
Μηνύματα από αγνοημένους χρήστες θα εμποδίζονται. Μπορείτε να αλλάξετε την κατάσταση ενός χρήστη από το προφίλ του/της. Οι χρήστες δεν πληροφορούνται για την κατάσταση  που τους προσέδωσαν άλλοι.");
define("_btpmbookmarkuser","Προσθήκη στη λίστα Φίλων");
define("_btpmunbookmarkuser","Διαγραφή από τη λίστα Φίλων");
define("_btpmblacklistuser","Να μην λαμβάνω τα μηνύματα αυτού του χρήστη");
define("_btpmunblacklistuser","Να λαμβάνω τα μηνύματα αυτού του χρήστη");
define("_btpmbookmarks","Φίλοι");
define("_btpmblacklist","Αγνοημένοι χρήστες");

//OVERLIB HELP
#NO LINE-BREAKS!!!!
define("_btperformance","Απόδοση");
define("_btdht","Υποστήριξη DHT");
define("_bttorrentspd","Συνολική Ταχύτητα:");
define("_btleechspd","Εκτιμώμενη Ταχύτητα: ");
define("_btedt","Εκτιμώμενος Χρόνος Κατεβάσματος: ");
define("_btinfohashhelp","Οι Πληροφορίες Hash είναι ένα σύντομος μοναδικός κωδικός που ταυτοποιεί ένα torrent.<br>");
define("_btdhtexplanation","Αυτό το torrent υποστηρίζει DHT. Με έναν προηγμένης τεχνολογίας client, θα μπορείτε να κατεβάσετε αυτό το torrent ακόμα κι αν ένας κεντρικός tracker καταρρεύσει.");
define("_btavatarnotice","Ανεβασμένες Φωτογραφίες Προφίλ πρέπει να είναι σε GIF, JPEG ή PNG μορφή, προτεινόμενο μέγεθος 100x100 και δεν μπορεί να καταλαμβάνουν χώρο μεγαλύτερο των 300KB");
define("_btcustomsearch","Ροές RSS/RDF για προσαρμοσμένη αναζήτηση");
define("_btcustomsearchexplain","Εγγραφείτε σ' αυτή τη ροή RSS/RDF για να ενημερώνεστε για τα torrents που ταιριάζουν στους όρους αναζήτησής σας");

// Rules
define("_btrules","Κανόνες");
define("_brrulesadmin","Κανόνες Admins");
define("_btrulesmod","Κονόνες Moderators");
define("_btrulesprem","Κανόνες Premiums");

define("_btrulesuser","Κανόνες Χρηστών");
define("_btrulesgen","Γενικοί Κανόνες");
define("_btrulesadd","Προσθήκη νέου Τομέα Κανόνων");
define("_btrulesaddsect","Προσθήκη Τομέα Κανόνων");
define("_btnamelevel","Βαθμίδα Χρήστη γι' αυτόν τον κανόνα");
define("_bttitle","Τίτλος Τομέα");
define("_btlevel","Βαθμίδα");
define("_btrulesedit","Τροποποίηση Κανόνων");
define("_btmodrulesadd","Προσθήκη Τομέα Κανόνων");
define("__btmodrulesno","Όχι");
define("_btmodrulesyes","Ναι");
define("_btmodrulespublic","Δημόσιοι");
//massmail
define("_btmmbody","Σώμα");
define("_btmmsendto","Αποστολή μαζικών e-mails σε επιλεγμένες βαθμίδες χρηστών");
define("_btmmlinks","Μπορείτε Να Χρησιμοποιείτε Υπερσυνδέσμους Στα e-mails Σας");
//BBcode
define("_bb_tag_prompt","Εισαγωγή Κειμένου:");
define("_bb_img_prompt","Εισαγωγή Υπερσυνδέσμου από Εικόνα");
define("_bb_font_formatter_prompt","Εισάγετε ένα κείμενο - ");
define("_bb_link_text_prompt","Εισάγετε ένα όνομα υπερσυνδέσμου (προαιρετικά):");
define("_bb_link_url_prompt","Εισάγετε την πλήρη διεύθυνση στ' αριστερά:");
define("_bb_link_email_prompt","Εισάγετε τον πλήρη υπερσύνδεσμό σας:");
define("_bb_list_type_prompt","Τι είδους λίστα θα επιθυμούσατε? Επιλέξτε ' 1 ' για λίστα αριθμών, 'a' για λίστα γραμμάτων, ή τίποτα απολύτως για μία απλή λίστα κουκκίδων.");
define("_bb_list_item_prompt","Εισάγετε ένα στοιχείο της λίστας. Πιέστε OK για να εισάγετε ένα άλλο στοιχείο της λίστας ή πιέστε 'Cancel' για να ολοκληρώσετε.");
define('_btmfreetorrentexplain','<img src="themes/'.$theme.'/pics/magic.gif" alt="ΕΛΕΥΘΕΡΟ TORRENT" title="FREE TORRENT" border="0">Τα Torrents με αυτό το Σύμβολο είναι Τονωτικά του Ratio. Μόνον τα ανεβασμένα καταγράφονται στα στατιστικά!!<br> Αυτός είναι ένας πολύ καλός τρόπος να τονώσετε το ratio σας. Οι Κανονικοί κανόνες διαμοιρασμού της ιστοσελίδας ισχύουν.<br>Διαμοιράστε μέχρι η αναλογία να είναι 1.0 ή για 36 ώρες για να αποφευχθούν τα hit and runs.');
//define('_btmnuketorrentexplain','<img src="themes/'.$theme.'/pics/nuked.gif" alt="ΡΗΜΑΓΜΕΝΟ TORRENT" title="NUKED TORRENT" border="0">Τα Torrents με αυτό το Σύμβολο είναι Ρημαγμένα. <br>Αυτό σημαίνει πως για κάποιο λόγο κάποιος αποφάσισε ότι κάτι δεν πάει καλά μ' αυτά,<br>και μπορεί να βλέπονται αλλά μπορεί και όχι. Χρησιμοποιήστε την κρίση σας όταν κατεβάζετε αυτά τα torrents.<br>Οι Κανονικοί κανόνες διαμοιρασμού της ιστοσελίδας ισχύουν ακόμη, εκτός αν χαρακτηρίστηκαν ως δωρεάν. Παρακαλούμε Διαβάστε Λεπτομέρειες για τους Λόγους');
?>
