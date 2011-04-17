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
*------              2009 phpMyBitTorrent Development Team              ------* 
*-----------               http://phpmybittorrent.com               -----------* 
*------------------------------------------------------------------------------* 
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------* 
*/ 


if (eregi("english.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

define("_LOCALE","en_UK");
	$u_datetime			= array(
		'TODAY'		=> 'Today',
		'TOMORROW'	=> 'Tomorrow',
		'YESTERDAY'	=> 'Yesterday',

		'Sunday'	=> 'Sunday',
		'Monday'	=> 'Monday',
		'Tuesday'	=> 'Tuesday',
		'Wednesday'	=> 'Wednesday',
		'Thursday'	=> 'Thursday',
		'Friday'	=> 'Friday',
		'Saturday'	=> 'Saturday',

		'Sun'		=> 'Sun',
		'Mon'		=> 'Mon',
		'Tue'		=> 'Tue',
		'Wed'		=> 'Wed',
		'Thu'		=> 'Thu',
		'Fri'		=> 'Fri',
		'Sat'		=> 'Sat',

		'January'	=> 'January',
		'February'	=> 'February',
		'March'		=> 'March',
		'April'		=> 'April',
		'May'		=> 'May',
		'June'		=> 'June',
		'July'		=> 'July',
		'August'	=> 'August',
		'September' => 'September',
		'October'	=> 'October',
		'November'	=> 'November',
		'December'	=> 'December',

		'Jan'		=> 'Jan',
		'Feb'		=> 'Feb',
		'Mar'		=> 'Mar',
		'Apr'		=> 'Apr',
		'May_short'	=> 'May',	// Short representation of "May". May_short used because in English the short and long date are the same for May.
		'Jun'		=> 'Jun',
		'Jul'		=> 'Jul',
		'Aug'		=> 'Aug',
		'Sep'		=> 'Sep',
		'Oct'		=> 'Oct',
		'Nov'		=> 'Nov',
		'Dec'		=> 'Dec'
	);

//Site News 

define("_btsitenews","Site News");
define("_btstart","Thank you for choosing phpMyBitTorrent<br /><br /> 
phpMyBitTorrent features a full-fledged BitTorrent Tracker written in PHP, External Torrent Indexing, DHT, Compact Announce, Alternate Links (eD2K, Magnet), HTTP-Basic Authentication, Passkey Authentication, and Embedded HTML Editor, Mass Torrent Upload and much more. You can Remove or Replace this News Item in Administration > Settings");
//Unatherized 
define("_btnoautherizeddownload","<p>You DO NOT have Permissions to Access Downloads at this time</p>");
define("_btnoautherized","You DO NOT have Permissions to Access **page** ");
define("_btnoautherized_noedit","You are NOT Authorized to Edit this Torrent");
define("_btnoautherized_nodelete","You are NOT Authorized to Delete this Torrent");
define("_btnoautherized_delete_off","You are NOT Authorized to Delete this Offer");
define("_btnoautherized_ml","You DO NOT have Permissions to Access the Members List at this time");
//Search Cloud 
define("_btsearchcloud","Search Cloud");
define("_btsearchcloudexplain","Popular Searches. A random selection of people's search terms, weighed by frequency.");
//Donations Block 
define("_btdonations","Donations");
define("_btdonationsgoal","Goal:");
define("_btdonationscollected","Collected:");
define("_btdonationsprogress","Donation Progress");
define("_btdonationsdonate","DONATE");

//COMPLAINTS 
function getcomplaints() { 
       return Array(0=>"Legal Content, Good Quality",1=>"Fake or Corrupted",2=>"Copyrights Violation",3=>"Pornographic Content",4=>"Child Pornography",5=>"Offensive Content",6=>"Content Related to Illegal Activity");
} 

//NewTorrent shout 
define("_btuplshout","Hi, I have just Uploaded [url=".$siteurl."/details.php?id=**id**][b]**name**[/b][/url]. Enjoy it!");
define("_btnewtsh","Shout Out New Torrent");
define("_btnewshex","Check Here if you would like to ADD a Shout in the Shout Box about your New Upload if not then leave it Unchecked!");

//CLASSI 
define("_btclassuser","User");
define("_btclasspremium","Premium User");
define("_btclassmoderator","Moderator");
define("_btclassadmin","Administrator");

//ACCESSO NEGATO 
define("_btaccdenied","Access Denied");
define("_btdenuser","The area you are trying to Access is Restricted to <b>Registered Users</b>.<br>Please provide your Access Credentials and try again. If you're not Signed Up yet, you can <a href=\"user.php?op=register\"><< <u>DO SO HERE </u>>></a> for FREE.");
define("_btdenpremium","The area you are trying to Access is Restricted to <b>Premium Users</b>.<br>");
define("_btdenpremium1","Please provide your Access Credentials and try again. If you don't have a Premium Account, please contact our Staff for 
detailed information on Premium Subscription.");
define("_btdenpremium2","Your Account is NOT Enabled to access Premium Services. Please contact our Staff for 
detailed information on Premium Subscription.");
define("_btdenadmin","The area you are trying to Access is Restricted to <b>Administrators</b>.<br>");
define("_btdenadmin1","If you have Administrator Credentials please provide them now, else we're asking you to leave this page and go back to 
<a href=\"index.php\">Home Page</a>.");
define("_btdenadmin2","Your Account does not have Administrator Privileges. Please Login with appropriate Credentials or leave this page and 
go back to <a href=\"index.php\">Home Page</a>.");
define("_btbannedmsg","You have been Banned from this Site because: <b>**reason**</b>");
define("_btmissing","Missing form data.");
define("_btprivelages","You DO NOT have these Privileges.");
define("_btauthorized","Not Authorized!");
define("_btokay","Okay");

//GENERICS 
define("_bt_not_valid_num","Not A Valid Mumber");
define("_bt_redirect","Redirecting");
define("_btgoback1","Go Back");
define("_btsitehelper","Site Helper");
define("_btsitehelper_with","Helper For");
define("_bt_seedbox","Seedbox");
define("_bterror","ERROR");
define("_btsorry","Sorry");
define("_DATESTRING","%A, %B %d %Y @ %T %Z");
define("_btpassword","Password");
define("_btusername","User Name");
define("_btremember","Remember Me");
define("_btsecuritycode","Security Code");
define("_btusermenu","User Menu");
define("_btmainmenu","Main Menu");
define("_btgenerror","phpMyBitTorrent Error");
define("_btmenu","Menu");
define("_btumenu","User Menu");
define("_btsyndicate","Syndication");
define("_btlegend","Legend");
define("_btircchat","IRC Chat");
define("_btchatnotenabled","IRC Chat is NOT Enabled on this Site.");
define("_btlostpassword","Lost your Password?");
define("_btmakepoll","Polls");
define("_bt_notice","Notice");
define("_bt_aply","Apply");

//EMAIL SPELLING 
define("_at"," at ");
define("_dot"," dot ");

//SQL ERRORS 
define("_btsqlerror1","Error Executing SQL Query ");
define("_btsqlerror2","Error ID: ");
define("_btsqlerror3","Error Message: ");

//HTTP ERRORS 
define("_http400errttl","HTTP 400 Error - Bad Request");
define("_http400errtxt","A 400 Error Occurred while processing your Request.\n 
Please check your Browser Settings and try again Accessing the Requested Page.\n 
Contact **email** if you're having problems.");
define("_http401errttl","HTTP 401 Error - Access Denied");
define("_http401errtxt","A 401 HTTP Error occurred while processing your Request.<br> 
You can't Access the Requested Page because you are NOT Authorized.<br> 
Please provide your Access Credentials, if you have any.<br> 
Contact **email** if you're having problems.");
define("_http403errttl","HTTP 403 Error - Forbidden");
define("_http403errtxt","A 403 HTTP Error Occurred while processing your Request.<br> 
You can't Access the Requested Page because the Server Configuration doesn't allow you to.<br> 
Please check carefully the URL Address on your Browser, and correct it if needed.<br> 
Contact **email** if you're having problems.");
define("_http404errttl","HTTP 404 Error - Not Found");
define("_http404errtxt","A 404 HTTP Error Occurred while processing your Request.<br> 
The Requested Page Does Not Exist.<br> 
Please check the URL in your Browser carefully, and correct it if needed.<br> 
Contact **email** if you're having problems.");
define("_http500errttl","HTTP 500 Error - Internal Server Error");
define("_http500errtxt","A 500 HTTP Error Occurred while processing your Request.<br> 
An error Occurred while processing Your Data.<br> 
Detailed info can be found in the Server Logs.<br> 
Please send a detailed report about this to **email**");

//USER BLOCK 
define("_btyoureseeding","Torrents you are Seeding");
define("_btyoureleeching","Torrents you are Downloading");
define("_btuserstats","User Stats");
define("_bttotusers","Registered Users:");
define("_btlastuser","Last Registered:");
define("_bttorrents","Available Torrents:");
define("_bttotshare","Total Share:");
define("_bttotpeers","Connected Peers:");
define("_bttotseed","Total Seeders:");
define("_bttotleech","Total Peers:");
define("_btuserdetails","Users Details");

//ViewSnatch 


//TESTI CHE COMPAIONO IN USER.PHP 
define('ACTIVE_IN_FORUM','Most active forum');
define('ACTIVE_IN_TOPIC','Most active topic');
define('SIGNATURE','Signature');
define("_btuseripdisp","User IP");
define("_btuseriphost","User Host");
define("_btregwelcome","<P align=\"center\">Welcome!</P> 
<P>Register an Account to Join Our Community. This will enable you to use the full range of services on this site, and it will only take a few minutes. Choose a User name and a Password, and provide a Valid E-mail Address. Within a few minutes, you'll receive an e-mail, asking you to Confirm the Registration.</P>");
define("_btreggfxcheck","<P align=\"center\"> Please also enter the following Security Code (prevents Bots from Registering).<BR>Contact **email** if you're having problems reading that code.</P>");
define("_btemailaddress","E-mail Address");
define("_btpasswd","Password (5 Chars Minimum)");
define("_btpasswd2","Confirm Password");
define("_btsubmit","Sign Up");
define("_btreset","Cancel Modifications");
define("_btdisclaimer","Terms and Conditions:");
define("_btdisclaccept","I Accept");
define("_btdisclrefuse","I DO NOT Accept");
define("_btgfxcode","Security Code");
define("_btsignuperror","Error during Sign up Process");
define("_bterruserexists","User name Already Exists.");
define("_btfakemail","The E-mail Address you entered is NOT Valid.");
define("_bterremailexists","The E-mail Address you entered is already Registered. Want to Recover your Password? Go <a href=\"user.php?op=lostpassword\">HERE</a>");
define("_btpasswnotsame","The Passwords you entered are NOT the same");
define("_bttooshortpass","The Password you entered is too Short. Minimum Length is 5.");
define("_bterrcode","The Security Code you entered is Wrong");
define("_btdisclerror","You MUST ACCEPT our Disclaimer in order to Sign Up.");
define("_btgoback","Please go back and check the form");
define("_btregcomplete","Sign up almost complete. You have 24 hours to Confirm your Registration. If you don't receive the 
E-mail Confirmation, please check the data you entered. If you're having problems, please contact the Webmaster at **email**");
define("_bterrusernamenotset","User Name NOT Specified.");
define("_bterrkeynotset","Activation Key NOT Specified");
define("_bterrusernotexists","This User Name Does NOT Exist.");
define("_bterrinvalidactkey","Activation Key is NOT Correct.");
define("_btuseralreadyactive","User is already Active. No more Activation Required");
define("_btacterror","Activation Error");
define("_btactcomplete","Activation Complete. Your Account is now Permanently Active. From now on, you can Access 
our services using the User name and Password you provided. Have a nice download.");
define("_btusrpwdnotset","User name or Password NOT Specified.");
define("_bterremailnotset","E-mail Address NOT Specified.");
define("_btuserpasswrong","Incorrect User name or Password!!");
define("_btuserinactive","User Registered but NOT Active!!");
define("_btloginsuccessful","Login Successful. You now have **priv** Privileges. Have a nice download!");
define("_btlogoutsuccessful","Logout Successful.");
define("_btusernoexist","Sorry, the User you entered does NOT Exist.");
define("_btuserprofile","User Control Panel");
define("_btmodprofile","Moderator Control Panel");
define("_btedituserprofile","Edit Profile");
define("_btusertorrents","My Torrents");
define("_btcompletename","Complete Name");
define("_btclass","Level");
define("_btclassbanned","Banned!");
define("_btshoutbanned","You are Banned From Shouts!");
define("_btregistered","Registered");
define("_btavatar","Avatar");
define("_btcontacts","Contacts");
define("_btnewavatargallery","New Avatar from Gallery");
define("_btnewavatarupload","Upload New Avatar");
define("_btinvalidimagefile","Invalid Image File");
define("_btavatartoobig","Image goes beyond Allowed Size");
define("_btlostpasswordintro","If you lost your Password, you can regain access to your account by entering your User name and a NEW Password.<br /> 
A confirmation mail will be sent to the E-mail address associated with your account. Make sure you can receive mail (i.e. your mailbox is not full) before submitting your Request. If you don't receive that mail, try checking your Spam-Filter.");
define("_btlostpasswordcheckmail","A Message has been sent to your E-mail address containing a Confirmation Link. Please click that Link for the Password Change to take effect.");
define("_btlostpwdinvalid","Invalid Confirmation Code or User ID");
define("_btlostpwdcomplete","Password Changed. Now you can Login with your NEW Password.");
define("_btdeluser","Account Deletion");
define("_btdeluserwarning","<b>WARNING</b>: you are about to Permanently and Completely Delete your Account. You'll lose Editing Permissions for all your torrents you uploaded. You'll be able to re-register with your Old User name after that.");
define("_btdeluserwarningadm","<b>WARNING</b>: you are about to Completely and Permanently Delete **user**'s account. **user** Editing Permissions for all torrents he/she uploaded. Re-registering with the same user name will be possible after that.");
define("_btaccountdeleted","Account Deleted");
define("_btconfirmdelete","Confirm Account Deletion");
define("_btuserdelete","Delete Account");
define("_btuserban","Ban Account");
define("_btuserunban","UnBan Account");
define("_btuserban_shout","You DO NOT have access to Ban Shouts");
define("_btuserban_shoutban","Shout Ban");
define("_btusershoutban","Ban Shouts");
define("_btusershoutunban","UnBan Shouts");
define("_btuserban_shoutbanned","User has been banned from Shout Box");
define("_btuserban_hnr","User has been Demoted For HNR");
define("_btuserban_shoutunban","User has been Unbanned from Shout Box");
define("_btusershout_welcome","/notice :welcome: our Newest Member ");
define("_btuserban_userban","User is Banned DO NOT Delete");
define("_btuser_edit","You DO NOT have Access to Edit this Person");

//USER/EDITPROFILE.PHP 
define("_btnewpassword","New Password<br />(leave blank if you don't intend to change it)");
define("_btnewpasswordconfirm","Confirm New Password");
define("_btaol","AOL Instant Messenger");
define("_bticq","ICQ");
define("_btjabber","Jabber IM");
define("_btmsn","MSN Messenger");
define("_btskype","Skype");
define("_btyim","Yahoo! Instant Messenger");
define("_btacceptmail","Accept E-mail by Other Users");
define("_btcustomlanguage","Language");
define("_btaccountstatus","Account Status");
define("_btaccountstatusexplain","Set User Active/Inactive. BEWARE! Setting a User that has been Registered for more than 48h to INACTIVE will also Delete the Account.");
define("_btaccountactive","Active");
define("_btaccountinactive","Inactive");
define("_btcustomtheme","Theme");
define("_btdefault","Default");
define("_btchooseavatar","Choose Avatar");
define("_btusepasskey","Use Passkey");
define("_btpasskeyexplain","This option allows you to download torrents using a Personal Security Code.<br /> 
Using a state-of-the-art client, you will no longer have to log in to the tracker or use User name and Password in order to get your Ratio Updated for Internally Tracked Torrents.<br /> 
A Personalized Code is automatically inserted in the .torrent file you download, in order to allow Tracker Authentication.<br /> 
<b>WARNING</b>: DO NOT share .torrents with Enabled Passkey Authentication! Unauthorized Users, even without logging in as you, may use them and influence your Ratio, which may in turn reduce your Download Permissions on the Tracker.<br /> 
In case a .torrent DOES fall in the wrong hands, you can Reset the Passkey.");
define("_btresetpasskey","Reset Passkey");
define("_btresetpasskeywarning","<b>WARNING</b>: all the torrent files you downloaded so far will NOT be Valid any more!");
define("_btprofilesaved","Profile Saved Successfully!");
define("_btaccesslevel","Access Level");
define("_btdeleteaccount","Delete Account");

//TESTI CHE COMPAIONO IN INCLUDE/BITTORRENT.PHP 
define("_btindex","Index ");
define("_bttorrentupload","Torrent Upload");
define("_btupload","Upload");
define("_btlogin","Log In");
define("_btlogout","Log Out");
define("_btsignup","Register");
define("_btpersonal","Your Torrents");
define("_btpm","Private Messages");
define("_btadmod","Moderator");
define("_btadmin","Administration");
define("_btrulez","Rules");
define("_btforums","Forum");
define("_bthelp","Help");
define("_btadvinst","Install BitTorrent or Shareaza to Download");
define("_btaccessden","Access Denied. Download Requires <A href=\"user.php?op=register\">Registration</a>");
define("_btlegenda","Help with Features and Legend");
define("_btyourfilext","Your File, External Tracker");
define("_btfile","file(s)");
define("_btexternal","External Tracker");
define("_btyourfile","Your File");
define("_btsticky","Sticky");
define("_btauthforreq","Authorization for Request");
define("_btauthreq","Authorization Request");
define("_btdown","Download");
define("_btunknown","Unknown");
define("_btrefresh","Update");
define("_btvisible","Visible");
define("_btsd","SD");
define("_btlc","LC");
define("_bttt","TOT");
define("_btseedby","Torrents I'm Seeding");
define("_btleechby","Torrents I'm Leeching");
define("_btpersonalstats","Personal Stats");
define("_btgeneral","General");
define("_bthtml","HTML");
define("_btcategory","Categories");

//TESTI CHE COMPAIONO IN INDEX.PHP 
define("_btinfituh","<p>You have ".$user->invites." Invites</p>");
define("_btsendiv","Send An Invite");
define("_btinvites","Invites");
define("_btgames","Games");
define("_btsedbs","Seeding Bonus:");
define("_btviewrqst","View Requests");
define("_btfaqs","FAQ'S");
define("_bttorofferd","Torrents Offered");
define("_btmemlist","Members List");
define("_btwelcomebk","Welcome Back");
define("_btwelcome","Welcome to $sitename");
define("_btneedseed","Torrents That Need Seeding");
define("_btifyhhelpthem","Please help them out, if you happen to have the files on your hard disk. Thank You!");
define("_btntnseeded","No Torrents Need Seeding");
define("_btsearch","Search");
define("_btsearchname","Search Torrents");
define("_btsearchfeed","Feed for these Results");
define("_btin","in");
define("_btalltypes","any");
define("_btactivetorrents","Active Torrents");
define("_btitm","Include Dead Torrents");
define("_btstm","Only Dead Torrents");
define("_btgo","Go!");
define("_btresfor","Order By:");
define("_btnotfound","<h2>No Result!</h2>\n<p>Try changing your Search Term.</p>\n");
define("_btvoidcat","<h2>This Category is Empty!</h2>");
define("_btorderby","Order By");
define("_btinsdate","Date");
define("_btname","Name");
define("_btdim","Size");
define("_btnfile","Number of Files");
define("_btevidence","Sticky");
define("_btcomments","Rating / Comments");
define("_btvote","Ratings");
define("_btdownloaded","Downloaded");
define("_btprivacy","Privacy");
define("_bttotsorc","Total Peers");
define("_btdesc","Descending");
define("_btord","Ascending");
define("_btnosearch","<center><h2>Search the files you would like to download</h2>If you need help, try asking in the Forums; if you cannot use Magnet:/eD2K: links you probably haven't installed the right software<br>We remind you that our Rules state that all files are Private, and it's up to whoever shares a file whether he/she Allows other people to download. It's Strictly Forbidden to Share Copyrighted, Porn, Child-Porn, Racist, Offending material or anything that Violates any Laws.<br>Any Copyright holder can Request the implementation of a free file name filter that allows to protect his/her Copyrights.</center>");
define("_bthelpfind","Search Help");
define("_bttypeCAT","Category");
define("_bttypes","Categories");
define("_bttopsource","TOP Download Sources");
define("_btnotopsource","There are No Active Torrents at this time");
define("_btnotseeder_noneed","There are No Critical Torrents at this time");
define("_btnotseeder_desc","If you have one of these files, please Seed (share) it with people who are waiting to download. Download the .torrent, point your client to the directory that contains the complete file, and it will start seeding.<br>Thanks for being one of the GOOD GUYS/GALS.</b>");
define("_btnoseedersontracker","Your Torrent is NOT Seeded!");
define("_btdeadtorrent","It seems like <b>your torrent is NOT Seeded</b>. That judgement might not be correct, so we'll accept the upload for now, but <b>Moderators may take it down later</b>.<br>");
define("_bthelpindex","<p><a name=\"HELP\"></a><a href='index_help.php'>Install BitTorrent or Shareaza to download</a>");
define("_btnet","Swarm Health");
define("_btsource","Peers");
define("_bttorrent","Torrent");
define("_btview","Seen");
define("_bthits","Downloaded");
define("_btsnatch","Completed");
define("_btalternatesource","<b>Only Alternate Sources (Magnet/ed2K) available</b>");
define("_btcantscrape","<b>Unable to Determine Peer Data</b>");
define("_bteasy","<b>Well-Seeded</b>");
define("_btmedium","<b>Not so Great</b>");
define("_bthard","<b>Poorly Seeded/Dead</b>");
define("_btmisssearchkey","Missing Search Key");
define("_btinfotracker","Who's On-line?");
define("_btnouseronline","There are NO Registered Users On-line");
define("_btonlineusers","On-line Users");
define("_btadvancedmode","Advanced Mode");
define("_btsimplemode","Simple Mode");
define("_btpagename","Currently Browsing");
define("_btloggedinfor","Logged in for");
define("_jscriptconfirmtext","You have a NEW PM, please click OK to go to your PM In-Box.");
define("_newpm","New PM");
define("_btpmwrote","&nbsp;wrote:");
define("_nonewpm","No NEW PMs");
define("_btbrowse","Browse");

//PMBT PAGES 
define("_btpage_youtube.php","Watching Trailers");
define("_btpage_outside.php","Admin area");
define("_btpage_donate.php","Donations");
define("_btpage_admin.php","Administration");
define("_btpage_chat.php","Chat");
define("_btpage_details.php","Torrent Details Page");
define("_btpage_edit.php","Edit Torrent");
define("_btpage_index.php","Home");
define("_btpage_modcp.php","Moderator Panel");
define("_btpage_viewsnatches.php","Viewing Torrent Snatch list");
define("_btpage_tickets.php","Purchasing a Ticket for Lottery");
define("_btpage_polloverview.php","Viewing Polls");
define("_btpage_","Home");
define("_btpage_mytorrents.php","Torrent Panel");
define("_btpage_search.php","Search");
define("_btpage_upload.php","Upload");
define("_btpage_phpBB.php","Viewing Forum");
define("_btpage_pm.php","Using Private Messaging");
define("_btpage_games.php","Viewing Game Panel");
define("_btpage_casino.php","Playing Casino");
define("_btpage_arcade.php","Playing In The Game Room");
define("_btpage_keno.php","Playing Keno");
define("_btpage_blackjack.php","Playing Black-Jack");
define("_btpage_viewrequests.php","Viewing Requests");
define("_btpage_faq.php","Reading F.A.Q's");
define("_btpage_offers.php","Viewing Offers");
define("_btpage_offer.php","Making A Offer");
define("_btpage_requests.php","Making A Request");
define("_btpage_memberslist.php","Viewing Members List");
define("_btpage_rules.php","Reading The Site Rules");
define("_btpage_torrents.php","Viewing Torrent List");
define("_btpage_user.php","Viewing User Panel");
define("_btpage_flash.php","Playing a Game");
define("_btpage_flashscores.php","Viewing Game Scores");
define("_btpage_flashscores2.php","Viewing Game Scores");
define("_btpage_mybonus.php","Spending their Bonus points");
define("_btpage_mybonuse.php","Spending their Bonus points");
define("_btpage_faqactions.php","FAQS Manager");







//TESTI CHE COMPAIONO IN DETAILS.PHP 
define("_btimdb","IMDb");
define("_btview_comments","View Comments on this Torrent");
define("_btview_imdb","View Internet Movie Database Info");
define("_btview_details","View Torrent Details");
define("_btnfo","NFO File");
define("_btnfo_view","View NFO File");
define("_btview_btrate","View Torrent Rating");
define("_btview_filelist","View File List");
define("_btview_source","View Peers");
define("_btinfo","Torrent Info");
define("_bttracker","Tracker");
define("_btddownloaded","Downloaded");
define("_btdcomplete","Completed");
define("_dtimeconnected","Time Connected");
define("_btsourceurl","Available on");
define("_btdidle","Paused");
define("_btdsuccessfully","Torrent Uploaded Successfully");
define("_btdsuccessfully2","Please Start Seeding NOW. Visibility depends on the number of the sources");
define("_btdsuccessfullye","Edited Successfully");
define("_btdgobackto","Back to Page");
define("_btdwhenceyoucame","where you came from");
define("_btdyoursearchfor","Your Search for");
define("_btnotorrent","Torrent Does NOT Exist or has been Banned");
define("_btdratingadded","Rating Added");
define("_btdspytorrentupdate","SpyTorrent has Updated the Sources");
define("_btdspytorrentupdate1","You are being Redirected to the page in 3 seconds ");
define("_btdspytorrentupdate2","If your Browser doesn't Redirect you, click");
define("_btdspytorrentupdate3","Here");
define("_btdspytorrentnoupdate","It is not necessary to run SpyTorrent on Internal Torrents within 15 minutes since the last scan.");
define("_btdownloadas","Download as");
define("_btpieces","Pieces");
define("_btpiecesstring","**n** pieces by **l** of size");
define("_btauthstatus","Download Authorization");
define("_btdwauthpending","Pending");
define("_btdwauthgranted","Granted!");
define("_btdwauthdenied","Denied!");
define("_btdwauthnorequest","Not yet Requested");
define("_btpremiumdownload","Only Premium users can Download this Torrent File");
define("_btregistereddownload","You have to Sign Up or Log In to Download this Torrent");
define("_btnetwork","network");
define("_btdays","d ");
define("_bthours","h ");
define("_btmins","m ");
define("_btsecs","s ");
define("_btinfohash","Info Hash");
define("_btinfohashnotice","<b>WARNING</b>: the Torrent has been modified in such a way that it MUST be re-downloaded. The file you uploaded 
is NOT Valid any more. Please use the download button to get the working version.");
define("_btnodead","<b>NO</b> (Dead)");
define("_btfiles","file(s)");
define("_btothersource","Other Sources");
define("_btnoselected","No Category Selected. Please go back to the Upload Form.");
define("_btago","ago");
define("_btlastseeder","Last Seeder");
define("_btlastactivity","Last Activity");
define("_bttypetorrent","Type");
define("_btsize","Size");
define("_btminvote","Not Voted (Required at least __minvotes__ Votes");
define("_btonly","only");
define("_btnone","none");
define("_btnovotes","No Rating");
define("_btoo5","of 5 with");
define("_btvotestot","Total Vote(s)");
define("_btcomplaints","Complaints");
define("_btlogintorate","(<a href=\"user.php?op=loginform\">Log In</a> to Vote)");
define("_btvot1","Bad");
define("_btvot2","Not Good");
define("_btvot3","Not Bad");
define("_btvot4","Good");
define("_btvot5","Very Good");
define("_btaddrating","Vote");
define("_btvotenow","Rating!");
define("_btrating","Rate");
define("_bthelpstat","Statistics Help");
define("_btviews","Seen");
define("_bttimes","Time(s)");
define("_btleechspeed","Leech Speed");
define("_bteta","ETA");
define("_btuppedby","Uploaded By");
define("_btnumfiles","Number of Files");
define("_btfilelist","Files");
define("_btlasttrackerupdate","Last Tracker Update");
define("_btshowlist","Show Peers");
define("_bthidelist","Hide Peers");
define("_bthelpsource","Peer Help");
define("_btseeds","Complete");
define("_btcommentsfortorrent","Comments on this Torrent");
define("_btbacktofull","Go back to the Full Details");
define("_btnotifyemailcom","If you want to be E-mailed when the First Comment is added, please click <a href=\"details.php?op=comment&trig=on&id=**id**#notify\">HERE</a>.");
define("_btnotnotifyemailcom","<p>You are currently listed to Receive Comment Email. If you Don't want to be E-mailed any more, please click <a href=\"details.php?op=comment&trig=off&id=**id**#notify\">HERE</a>.</p>");
define("_btclickhere","Click Here");
define("_btnotifyemail1s","If you want to be E-mailed when the First <b>SEED</b> shows up, please click <a href=\"details.php?op=seeder&trig=on&id=**id**#notify\">HERE</a>.");
define("_btnotnotifyemail1s","<p>You are currently listed to be Notified when a Seed pops up. If you don't want to be E-mailed any more, please click <a href=\"details.php?op=seeder&trig=off&id=**id**#notify\">HERE</a>.</p>");
define("_btnocommentsyet","There are NO Comments at this time");
define("_btcommheader","On **time**, <a href=\"user.php?op=profile&id=**uid**\" target=\"_top\">**user**</a> wrote:");
define("_btdgavesresult","has Returned One Result");
define("_btdnotifyemaildel","You have been Removed from the Comment Notification List");
define("_btdnotifyemaildel1","You're NOT Receiving any more E-mails when a Comment is Added!");
define("_btdnotifyemailadd1","You will Receive an E-mail when a Comment is Added, but you will NOT Receive any more E-mails before you read the Comment!");
define("_btdnotifyemailadd","You have been Added to the Comment Notification List");
define("_btdnotifyadd","You have been Added to the Seeder Notification List");
define("_btdnotifyadd2","you'll be Notified about new Seeders with a Maximum of One E-mail Every Day,");
define("_btdnotifydel","You have been Removed from the Seeder Notification List; you're not going to Receive any more E-mails.");
define("_btddetails","Torrent Details");
define("_bteditthistorrent","Edit this Torrent");
define("_btyes","yes");
define("_btno","no");
define("_btcyes","YES");
define("_btcno","NO");
define("_btadded","Uploaded");
define("_btaddedby","Uploaded By");
define("_bton","up");
define("_bthelpothersource","Help Alternate Sources");
define("_btfilename","Filename");
define("_btpeers","Peers");
define("_btpeerstot","Total Peers");
define("_bthelppeer","Peer Help");
define("_btleecher","Leecher");
define("_btleechers","Leechers");
define("_btdhelpdownload","Download Help");
define("_btyourate","You Voted");
define("_btupdatesource","Update Sources Now!");
define("_btseeder","Seed");
define("_btseeders","Seeds");
define("_btcompletion","Complete");
define("_btdirectlink","Direct Link");
define("_btcomplyouvoted","You said this Torrent is: ");
define("_btcomplexplain","The Torrent may be Banned when Reaching a certain Number of Complaints.");
define("_btcomplaintform","Torrent Complaint form.<BR>This system allows you to Flag Torrents that DO NOT fit our Rules.<BR> 
Once a certain number of Complaints is Reached, the Torrent may be Banned from the List.<BR>Please Send Positive Feedback on Torrents that are Good and Legal.<BR>");
define("_btcomplisay","This Torrent is ");
define("_btmagnetlink","Magnet Link");
define("_btnomagnet","No Magnet Link Available");
define("_btmagnetlinkdownload","Download File using Magnet Link");
define("_bted2klink","eD2K Link");
define("_btnoed2k","No ed2K Link Available");
define("_bted2klinkdownload","Download File using eD2K Link");
define("_btcomplatthemoment","Users Sent Positive Feedback<b>**p**</b> times and Negative Feedback <b>**n**</b> times.<BR>");
define("_btnotifications","E-Mail Notifications");
define("_btreadcomms","Read Comments");
define("_btpostcomment","Post a Comment");
define("_bttransfer","Transfer");
define("_btdownloadspeed","Download Speed");
define("_btuploadspeed","Upload Speed");
define("_bttorrentpassword","Password Protection");
define("_btpasswordquery","This Torrent is Password Protected. The Owner of the Torrent decided to make it visible ONLY to Authorized Users.<br />Please provide the Password NOW to get Instant Torrent Access.");
define("_btpasswordwrong","Warning: Wrong Password.<br />Remember that Passwords are Case-Sensitive.");
define("_btuploadedpassexplain","You Set the Password to: <b>**pass**</b>");
define("_btuploadedpassexplain2","To give Users Access to your Torrent, pass them the following Direct Link: <b>**url**<b>");
define("_btcompletedby","Completed By");
define("_bttrackers","Additional Trackers");
define("_bttrackergroup","Group *");
define("_btexport","Export");
define("_btexportexplain","Download this Torrent without your Passkey, for Distribution on Sites that provide BitTorrent Index Services");

//TESTI PRESENTI IN TAKEUPLOADURL.PHP 
define("_btacces_group","Group");
define("_btinseriti","Inserted");
define("_btand","and");
define("_btnumerror","the Number is NOT equal and it is NOT Possible to Proceed with Binary Assignment");
define("_btmaxchar","ED2K URLs have a 200 Characters Maximum");
define("_bted2kstart","URL should begin with <b>ed2k://</b>");
define("_bt2par","URL Lacks the Second Parameter: ");
define("_bturlfile","file");
define("_bturlcontent","URL doesn't contain");
define("_btfname","filename");
define("_bturlsize","URL doesn't contain");
define("_btsz","size");
define("_btidcode","Hash Info");
define("_bturlparerror","URL doesn't contain the Parameter:");
define("_bturlsureerror","URL contains an Illegal Source");
define("_bturlnotinsert","Must Insert an ED2K Link");
define("_btnotip","IP NOT Specified");
define("_btinvip","Invalid IP");
define("_btnoport","No Port Specified");
define("_btinvport","Invalid Port");
define("_btparmag","none");
define("_btnopresent","NOT Present");
define("_btmagchar","MagnetURLs have a 200 Characters Maximum");
define("_bftminlimit","You Cannot Share Files Smaller than");
define("_btfmaxlimit","Your Torrent contains a file that's TOO Large.");
define("_btillegalword","Your Torrent didn't make it through the Automatic Content Filter for the following Reason (if specified):.");
define("_btillegalwordinfo","If you feel that you're getting this message in error, please contact $admin_email");
define("_btnoreason","(No Reason Specified");
define("_bturlinserted1","Torrent Uploaded. You are being Redirected in 3 seconds.<BR>If your Browser doesn't forward you, click ");
define("_bturlinserted2","this Link");
define("_btaddnotifycomment","You have been Added to the Notification List: you'll be E-mailed about New Comments.");
define("_btaddnotifyseeder","You have been Added to the Notification List: you'll be E-mailed about New Seeds.");
define("_btnolinkinsert","No Link Inserted");
define("_btexnostartwt","eXeem Links Start with exeem://");
define("_btinvalidexeem","Invalid eXeem Link!");
define("_btillegalcat","Illegal Category!");
define("_bttorrentpresent","The Torrent you're trying to Upload has already been Uploaded to this Site, or it has been Banned.");
define("_btdescrrequired","Description Field is Empty. Please go back and enter a Description.");

//TESTI PRESENTI IN UPLOAD.PHP 
define("_btuploadatorrent","Upload a Torrent File");
define("_btphotoext","Image File has to be GIF, JPG or PNG");
define("_btalertmsg","Form has NOT been Submitted due to the following Errors:");
define("_btalertmsg2","Please Fix the Errors and try to Upload Again");
define("_btfnotselected","ERROR: File NOT Selected");
define("_btalertdesc","Please Enter a Description that Indicates File Type and Quality, particularly in case of Media Files");
define("_btalertcat","Select a Category");
define("_btconferma","Ready to Upload? If your Torrent contains Multiple Files, please re-create it as a Multi-Archive containing the Entire Folder. Else, it could be unusable.");
define("_btalerturl","Insert a MAGNET or ED2K Link");
define("_btalerturlnum1","ED2K Link Number");
define("_btalerturlnum2","while MAGNET Link Number is");
define("_btalerturlnum3","The Number of the Links has to be the Same-- Torrents consist of a couple of Links");
define("_btalert5char","File name has to be at Least 5 Characters");
define("_btofficialurl","This Site's Official Tracker is: ");
define("_btseeded","Please Only Upload Torrents that are Seeded. Torrents without Peers will NOT show up on the Main Page.");
define("_btupfile","Upload File:");
define("_btupnfo","Upload NFO File:");
define("_bttorrentname","Torrent Name");
define("_btfromtorrent","Will be Generated from the File Name if left Blank. ");
define("_btdescname","Try to give it a Descriptive Name");
define("_btsrc_url","Source URL");
define("_btcompulsory"," (Compulsory)");
define("_btdescription","Description (Required)");
define("_btdescriptionsemple","Description");
define("_btnohtml","NO HTML");
define("_btchooseone","Choose");
define("_bttype","Type");
define("_btverduplicate","Check for Similar Torrents");
define("_btduplicatinfo","Prevents Uploading of Torrents Similar to Ones Already on the List. Uncheck to upload anyway. Remember that having Duplicate Torrents for Identical Files Reduces Overall Efficiency.");
define("_btupevidence","Sticky");
define("_btupevidencinfo","Mark Torrent as Sticky and keep it on the top of the list. Restricted to Moderators/Admins");
define("_btowner","Display Name");
define("_btowner1","Show User");
define("_btowner2","Privacy Mode");
define("_btowner3","Stealth Mode");
define("_btownerinfo","'SHOW USER' Allows other Users to see your User Name, 'PRIVACY MODE' Hides it, retaining Edit/Delete Permissions, 'STEALTH MODE' (if available) Completely Hides the Owner to the System, and Doesn't allow any Edit/Deletion by the User.");
define("_btupnotify","Notifications");
define("_btupnotifynfo","Receive E-mail-Notification when a Comment is Added");
define("_btupnotifyseed","Receive E-mail-Notification when a Leecher Completes the File (Only Torrents on Local Tracker)");
define("_btfsend","Submit");
define("_btinserte2k","Insert ED2K Link");
define("_btmagnetinsert","Insert Magnet Link");
define("_btinsertlinktitle","Insert Links for GNutella and eDonkey2000 Networks");
define("_btinsertlinktext","You can Add eDonkey2000 Links to your Torrent, to Increase Availability.");
define("_btinserttext2","You can Insert either Only MAGNET Links or Only ED2K Links. If both Lists are filled with entries, two Links will be Associated to each file: in other words the first ED2K Link and the first MAGNET Link will be Associated to the first file, and so on...");
define("_bted2kurl","Insert ED2K Link");
define("_btsyntax","Like");
define("_btfiletype","extension");
define("_btfilesize","size");
define("_btipport","ip:port");
define("_btstatic","indicates that we're only using the eDonkey2000 Protocol");
define("_btfinalname","is the name of the File to Download");
define("_btfinalsize","is the byte size of the File");
define("_btfinalidcode","a Special Verification Code that Allows you to find ONLY ONE FILE, and its Copies, among many Similar");
define("_btfinalipport","represents the Main Stable Source (used by Releasers)");
define("_btor","or");
define("_btaddmagnet","Magnet Link");
define("_btadded2k","eD2K Link");
define("_btphoto","Image");
define("_btexeemlink","eXeem Link");
define("_btexeemlinkexplain","Optional. If the Torrent can be downloaded through the eXeem Network, you can insert the Alternate Link HERE");
define("_bttorrentpasswordexplain","You may choose a Password to Protect your Torrent from Unauthorized View. If a Password is Set, the Torrent will NOT 
be Visible to Anyone Except Premium Users and Administrator's in the Torrent List and Torrent Search. You will have to provide a Direct Link to the people that you want to Access the Torrent. 
Only Internal Torrents can be Password Protected.");
define("_btupadvopts","Advanced Options");
define("_btadvoptsexplain","Show Advanced Options, Controlling some Technical Aspects of the torrent. Use these Options ONLY if you know what you're doing!");
define("_btleaveintact","DO NOT Edit this Setting");
define("_btdhtsupport","DHT Support");
define("_btendht","Force Backup DHT Tracking");
define("_btdisdht","Disable DHT Tracking");
define("_btdhtsupportexplain","This Forces DHT Backup Tracking on your Torrent, or Disables it. DHT is useful when the Main Tracker goes Off-line or is Overloaded");
define("_btprivatetorrent","Private Torrent");
define("_btenpvt","Mark Torrent as Private");
define("_btdispvt","Mark Torrent as Public");
define("_btprivatetorrentexplain","The \"Private\"-Option (which ONLY some Clients can handle), tells the Client to Deal only with Peers it receives from the Central Tracker. Enabling the Private Option Disables DHT");
define("_btnoperms","You do not have Permissions to Access the Upload page at this time");

//UPLOAD-LINK 
define("_btuploadalinkarchive","Submit eD2K/Magnet Link");
define("_btsharelink","Upload ONLY if the File is being Shared.");
define("_btlinknotice","The Link will NOT be Accepted if more than half of the Files you Submit are Already Present on the Index. Duplicates Reduce the Overall Efficiency");
define("_btarchivename","Name");
define("_btinsert1file","Enter Link(s) for your File, and Hit 'Add File'. The eD2K Link is Obligatory. You can Add more than one File to your Submission.");
define("_btlinksnomatch","The Links you Entered DO NOT Represent the same File");
define("_btinvalided2k","Invalid eD2K Link");
define("_btinvalidmagnet","Invalid Magnet Link");
define("_btaddnewfile","Add File");
define("_btaddtoarchive","Add File");
define("_btaddmd5","MD5 Hash");
define("_btlinks","Links");
define("_bterrduplicatelinks","Duplicate Files are NOT Allowed");
define("_btduplicatelinks","Duplicate File");
define("_btduplicateexplain","The File Represented by the Link you Submitted is Already being Shared on this Site. Click on the Warning Symbol next to the File to check out the Torrent/Collection in which it has been Found. If more that 50% of the Links you added are already present, your submission will NOT be Accepted");
define("_btinsertfilesfirst","You have to Submit at least One File using the Appropriate Button");
define("_btfilelistaltered","The File List has been Altered! It has NOT been created using this Tool.");

//INTERNAL TRACKER 
define("_btuserhost","User Name/Host");
define("_btuserip","User Name/IP");
define("_btport","Port");
define("_btdownloadedbts","Downloaded");
define("_btuploadedbts","Uploaded");
define("_btratio","Ratio");
define("_btpercent","Completed");
define("_btconnected","Connected");
define("_btidle","Inactive");
define("_btconn","Connection");
define("_btactive","Active");
define("_btpassive","Passive");
define("_btpeerspeed","AVG Speed");
define("_btnopeer","No Peers");
define("_btIP","IP");

//Add Offer 
define("_bt_offer_up","Your Offered Torrent");
define("_btoffer","Offer");
define("_btofferdeleted","Your offer **name** was Deleted by ".$user->name);
define("_btoffersvote","Offer Vote");
define("_bt_nocheat","Don't Cheat!!!");
define("_bt_Offer_voted","<h3>You've already Voted on this Offer</h3><p>You've already Voted to this Offer, ONLY 1 Vote per Member is Allowed</p><p>Return to <a href=offers.php><b>Offers List</b></a></p>");
define("_bt_off_vote_th","Thank you for your Vote");
define("_bt_off_take_vote","<h3>Vote Accepted</h3><p>Your Vote has been counted</p><p>Back to <a href=offers.php><b>Offer List</b></a></p>");
define("_bt_off_canupload","Your Offer \"**torrent**\" has reached 3 Votes.\nYou can now Upload it to the tracker");
define("_bt_off_denied","You DO NOT have Permissions to Access Offers at this time");
define("_bt_off_name","You should enter a name for your Offer");
define("_bt_off_making"," is making a Offer for ");

//Scrape external torrents 
if (!eregi("admin.php",$_SERVER["PHP_SELF"])){ 
define("_admtrackers","External Trackers");
define("_admtrackerurl","Announce URL");
define("_admtrkstatus","Status");
define("_admtrkstatusactive","Active");
define("_admtrkstatusdead","Off-line");
define("_admtrklastupdate","Updated");
define("_admtrkscraping","Updating");
define("_admtrkassociatedtorrents","Torrents");
define("_admtrkcannotopen","Cannot contact URL Address. Tracker will be set as Off-line");
define("_admtrkrawdata","Tracker Reached. Here is the Encoded Response");
define("_admtrkinvalidbencode","Cannot Decode Tracker Response. Invalid Encoding");
define("_admtrkdata","Decoding Completed. Here is all the Scrape Data obtained");
define("_admtrksummarystr","Found <b>**seed**</b> Seeders, <b>**leechers**</b> Leechers, <b>**completed**</b> Completed Downloads for Torrent **name** Info Hash **hash**.");
} 

//TESTI CHE COMPAIONO IN COMMENT.PHP 
define("_btiderror","Invalid ID");
define("_btnotfoundid","Torrent Does NOT Exist");
define("_btaddcomment","Add Comment to");
define("_btaddtime","Uploaded ");
define("_btby","by");
define("_btsend","Submit");
define("_btnotyourcomment","You can't Edit other people's Comments.");
define("_btcommentinserted","Your Comment has been Posted. You are being Redirected to the Torrent Details page in 3 seconds.<br>Click <a href=\"details.php?id=**id**#comments\">HERE</a> if your Browser doesn't forward you.");
define("_btcommentdeleted","Comment Deleted. You are being Redirected to the Torrent Details page in 3 seconds.<br>Click <a href=\"details.php?id=**id**#comments\">HERE</a> if your Browser doesn't forward you.");

//TESTI CHE COMPAIONO IN DOWNLOAD.PHP 
define("_bttorrentunavailable","Torrent File Unavailable due to a Server Configuration Error. Sorry for the Inconvenience.");
define("_btminseedrule","You MUST be Seeding at least **min** Torrents to Download.");
define("_btmaxdailydownloads","You can't Download more than **max** Files Per Day. Please try again tomorrow.");
define("_btmaxweeklydownloads","You can't Download more than **max** Files per Week. Please try again next week.");
define("_bterrtoosmall","<li>You have to Seed a File at least <b>**min_share**</b> of size.<br>");
define("_bterrtoobig","<b>The Largest File your Seeding is ");
define("_bterrorprivate","This is a Private File: you have already asked for Download Authorization. You cannot download the file until the Owner Accepts your Request.");
define("_btrefused","The Owner Refused your Authorization Request. You won't be able to download this torrent.");
define("_bterrblacklist","The Owner Refused to let you Download his Torrents. You won't be able to download any of them.");
define("_btreqsent","This Torrent is Private. You won't be able to download it until the Owner gives you Authorization. 
A Request has been sent to the Torrent Owner, who needs to Authorize your download: you will be Notified about the Result by E-mail.");

//TESTI CHE COMPAIONO IN EDIT.PHP 
define("_btedittorrent","Edit Torrent");
define("_bterreditnoowner","<h1>Access Denied</h1>\n<p>Only the Torrent Owner and Administrators can Edit Torrents</p>\n");
define("_btbanned","Banned");
define("_btcancel","Cancel");
define("_btdelcommand","DO NOT Edit Torrent, BUT <input type=\"submit\" value=\"DELETE IT!\" />\n");
define("_btsure","Yes: I'm sure about that!");
define("_btban","Ban Torrent");
define("_btareyousure","Are you sure you want to DELETE <b>**name**</b>?");
define("_btareyousure_ban","Are you sure you want to BAN <b>**name**</b>?");
define("_bttorrentnoexist","This Torrent does NOT Exist");
define("_btdelete","Delete Torrent");
define("_btcannotdel","Unable to Delete");
define("_btmissingdata","Required Data Missing!");
define("_btdeldenied","Only the Torrent Owner or Site Administrators can Delete this Torrent");
define("_btnotconfirmed","You have to Confirm you're sure what you're about to do.");
define("_btdeleted","Torrent Deleted");
define("_btsuccessfullyedited","Torrent Successfully Edited. You are being redirected to the Torrent Details Page. Remember that if you have selected Stealth Mode, you won't be able to Edit or Delete the Torrent any more!");

//TESTI CHE COMPAIONO IN MYTORRENTS.PHP 
define("_btmytorrentsintrotitle","Torrent Control Panel");
define("_btmytorrentsintrotext","In this area, you can Manage the torrents you uploaded (except for those with Stealth Mode selected).<br> 
You can also manage other Users' Download Requests. By selecting the appropriate Icon, you can view ALL the Requests 
sent to you by other Users. You'll have to decide whether to Accept or Refuse the Download Request.<br> 
Pay Attention to Upload and Download Amounts of the User. People who download without Sharing are of NO Benefit for 
the BitTorrent Network. Refusing their Download Request can be an appropriate way to encourage them to Share more.");
define("_btmytorrents","My Torrents");
define("_btallauthorized","All Users have been Authorized");
define("_btauths","Download Requests");
define("_bt_authorized","Selected User has been Authorized");
define("_bthasauthorized","Owner has Authorized you to Download his Files");
define("_btnowcandownload","You can now Freely Download all the User's Files.\nWe Protect your Privacy.");
define("_pendingauths","Pending Authorizations: ");
define("_btauthorizationrequested","The following Users have Requested Download Authorization:");
define("_btnotorrents","There are NO Torrents");
define("_btnotorrentuploaded","You have NOT Uploaded any Torrents yet");
define("_btactions","Actions");
define("_bthasuploaded","Uploaded: **");
define("_bthasdownloaded","Downloaded: **");
define("_btauthgrant","Authorize");
define("_btauthalwaysgrant","Always Authorize");
define("_btauthalwaysdeny","Never Authorize");
define("_btauthdeny","DO NOT Authorize");
define("_btcantseeothertorrents","You can't view other Users' Torrents Permissions!");
define("_btauthpanel","Download Authorizations Control Panel");
define("_btnoauthstomanage","There are NO Authorizations to Manage");
define("_btmyglobals","My Global Authorizations");
define("_btnoglobals","There are NO Global Authorizations yet");
define("_btstatus","Status");
define("_btauthreset","Reset");
define("_btwronginput","Error while entering Data");
define("_btgeneraloptions","General Options");
define("_btprivate","Private");
define("_btprivateexpl","Select this option to require Users to ask for a Download Authorization to Access this Torrent. You will be notified of each new Pending Authorization via E-mail. 
You will be able to choose to Grant or Deny the Authorization for this Single Torrent or for ALL your Torrents");
define("_btminratio","Minimum Ratio");
define("_btdisabled","Disabled");
define("_btminratioexpl","You can set a Minimum Ratio Value to Auto-Authorize Users. Users with Ratio Above or Equal to this will be able to download without Requesting Authorization. 
The value of the Minimum Ratio will NOT be displayed, except to Administrators");

//TESTI CHE COMPAIONO IN TAKECOMMENT.PHP 
define("_btcommentkeyfound","The system has checked your Comment. The following words are NOT Allowed:<ol>");
define("_btcommentkeyfound2","</ol><p>We know that the Comment could still be OK, we apologize for the inconvenience and ask you to use different wording.</p>");

//TESTI CHE COMPAIONO IN TAKEEDIT.PHP 
define("_btmissingformdata","Missing Input Data!");
define("_bteditfailed","Edit Failed");
define("_bteditdenied","You can't Edit other people's Torrents.");
define("_btreturl","File Successfully Edited, your being Redirected to the Torrent Details Page in 3 seconds..<br>Click <a href=\"**returl**\">HERE</a>if your Browser doesn't forward you");

//TESTI CHE COMPAIONO IN RATE.PHP 
define("_btrate","Torrent Rating");
define("_btratefailed","Vote Failed!");
define("_btinvalidrating","Invalid Vote");
define("_btidnotorrent","Invalid ID. Torrent Does NOT Exist");
define("_btnovoteowntorrent","You Cannot Rate your Own Torrents");
define("_btalreadyrated","Torrent Already Rated");
define("_btcantvotetwice","We are Sorry, but you can't Rate a Torrent Twice");
define("_btvotedone","Vote Successful, you are being Redirected to the Torrent Details Page in 3 seconds.<br>Click <a href=\"details.php?id=**id**\">HERE</a> if your Browser doesn't forward you.");

//TESTI CHE COMPAIONO IN TAKEUPLOAD.PHP 
define("_btuploaderror","Upload Failed!");
define("_btemptyfname","Empty File name");
define("_btinvalidfname","Invalid File name");
define("_btinvalidnfofname","Invalid NFO File name");
define("_btfnamenonfo","This is NOT a NFO File (.nfo)");
define("_btfnamenotorrent","This is NOT a Torrent File (.torrent)");
define("_btferror","File Error");
define("_bterrnofileupload","Fatal Error in Uploaded File.");
define("_bterrnonfoupload","Fatal Error in Uploaded NFO File.");
define("_btemptyfile","File Empty");
define("_btnobenc","File Damaged. Are you sure it is really a Torrent File?");
define("_btnodictionary","Torrent Dictionary NOT Present");
define("_btdictionarymisskey","Missing Torrent Dictionary Keys");
define("_btdictionaryinventry","Invalid Data inside Torrent Dictionary");
define("_btdictionaryinvetype","Invalid Data Types in Torrent Dictionary");
define("_btinvannounce","Invalid Announce URL. Must be ");
define("_btactualannounce","Specified Tracker ");
define("_bttrackerdisabled","Our Tracker has been Disabled: Only External Torrents can be Uploaded.");
define("_btinvpieces","Invalid Torrent Parts");
define("_btmissinglength","Missing Files and Size");
define("_btnofilesintorrent","Missing Torrent Files");
define("_btfnamerror","Invalid File name");
define("_btinvalidhtml","Invalid HTML Code. Make sure you used our Editor without entering Code Manually.");
define("_bttrackerblacklisted","The Tracker used by this Torrent (<b>**trk**</b>) has been Blacklisted. Please use a different Tracker.");
define("_btfilenamerror","Error in File name");
define("_bttorrenttoosmall","<p>You Cannot Share a File Smaller than <b>");
define("_bttorrenttoosmall2","</b></p><p>Your Torrent Contains a File with the Following Size: <b>");
define("_btmaxuploadexceeded","You can't Upload more than **maxupload** in a 24 hour period.");
define("_btnumfileexceeded","<p>You can't Upload more than <b>**maxupload**</b> Files in a 24 hour period.</p><p>You have already Uploaded <b>**rownum**</b> Files, Totalling <b>**totsize**</b>");
define("_btsearchdupl","According to the Search, these Files may correspond to the ones you are Sharing:<ol>");
define("_btduplinfo","<p>If your File is in this List, please Seed one of these Torrents!</p>");
define("_btsocktout","ERROR: Socket Timed-Out");
define("_bttrackernotresponding","Tracker NOT Responding.\n Check Tracker Spelling (NO EMPTY SPACES INSIDE URLs) and that the Tracker is up and Running. The Tracker you Specified is:");
define("_bttrackerdata","Invalid Data from External Tracker. The Tracker may have Server Problems. Please try again later.");
define("_bttorrentnotregistered","Torrent does NOT seem to be Registered on the External Tracker. You can upload External Torrents ONLY if they're Active.");
define("_btuploadcomplete","Successfully Uploaded. You are being redirected to the Torrent Details Page in 3 seconds. Remember to Seed, or the Torrent won't be Visible on the Main Page.<br>Click <a href=\"**url**\">HERE</a> if your Browser doesn't forward you.");
define("_btpresent","This Torrent has Already been Uploaded");
define("_btscrapeerror","Can't get Peer Data from Tracker");

//TESTI CHE COMPAIONO IN TAKECOMPLAINT.PHP 
define("_btcomplisnowbanned","This Torrent has been Banned due to a number of Complaints");
define("_btcomplcantvotetwice","We're Sorry, but you can't send a Complaint twice.");
define("_btcomplainttaken","Complaint Registered. You are being redirected to the Torrent's Detail Page in 3 seconds. If your Browser doesn't forward you, click ");
define("_btcomplsuccess","Your Complaint has been Registered. User Name and IP are Logged: Please DO NOT Abuse the System.<BR>");

//SHOUTBOX 
define("_btshoutbox","Shoutbox <a href=\"javascript:popshout('shoutdetach.php');\">(Detach)</a> &bull; <a href=\"shoutboxarchive.php\">(Archives)</a>");
define("_btnoshouts","Nobody is Shouting...");
define("_btshoutnow","Shout!");
define("_btprivates","[PM]");
define("_btshoutnowprivate","Private Shout!");
define("_btshoutboxshow","Shout Box");
define("_btshactive","Active Users");
define("_btmoresmiles","More Smiles");
define("_btshouthelp","what is Mode Normal/Mode Expert<ul><li>Mode Normal:<ul><li>If Normal mode is used then you will receive BBcode help from system.</ul><li>Mode Expert:<ul><li>If Expert mode is used the system will not help but will simply insert tags for BBcodes.</ul></ul>What does the <img src=\"./themes/".$theme."/pics/drop.gif\" alt=\"\"> do<ul><li>Click this twice to delete your shout.<br />(note admins and mods can delete your shouts to)</ul>What does the <img src=\"./themes/".$theme."/pics/edit.gif\" alt=\"\"> do?<ul><li>Click this twice to edit your shout.<br />(note Admins and Mods can edit your shouts too)</ul>");



//IMAGE ALTERNATES 
define("_btalt_banned","Banned Torrent");
define("_btalt_auth_none","No Pending Authorizations");
define("_btalt_auth_pending","Pending Authorizations!");
define("_btalt_sticky","Sticky Torrent");
define("_btalt_download","Download");
define("_btalt_edit","Edit");
define("_btalt_drop","Delete");
define("_btalt_viewed","View");
define("_btalt_scrape","Refresh Peer Data");
define("_btalt_noscrape","Stats Updated less than 30min ago");
define("_btalt_logintoscrape","Log in to Check Peer Data");
define("_btalt_duplicate","Duplicate File");
define("_btalt_exeem","Download with eXeem");
define("_btalt_error.gif","Error");
define("_btalt_icon_admin","Administrator");
define("_btalt_icon_moderator","Moderator");
define("_btalt_icon_premium.gif","Premium User");
define("_btalt_1.gif","REALLY Bad");
define("_btalt_1.5.gif","Very Bad");
define("_btalt_2.gif","Bad");
define("_btalt_2.5.gif","Poor");
define("_btalt_3.gif","Average");
define("_btalt_3.5.gif","Better Than Average");
define("_btalt_4.gif","Good");
define("_btalt_4.5.gif","Very Good");
define("_btalt_5.gif","Excellent");
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
define("_btalt_green.gif","Fast");
define("_btalt_yellow.gif","Slow");
define("_btalt_red.gif","Stop");
define("_btalt_quest.gif","Peer Data Unknown");
define("_btalt_lock","Pending Authorization");
define("_btalt_lock_request","Ask for Authorization");
define("_btalt_noavatar.gif","No Avatar");
define("_btalt_icon_active.gif","Active");
define("_btalt_icon_passive.gif","Passive");
define("_btalt_external","External Tracker");

define("_btunknownclient","Unknown Client");
define("_btalt_avatar","Avatar for **user**");


//PRIVATE MESSAGES 
define("_btyougotpm","You've got New/Unread Messages!");
define("_btpmintro","Here you can Read Private Messages from other Users. There is NO Maximum Storage Limit. 
However, we suggest you to periodically Delete Old Messages. You can Send Messages to ALL Registered Users.");
define("_btinbox","Inbox");
define("_btpmnomessages","No Messages");
define("_btpmsub","Subject");
define("_btpmfrom","From");
define("_btpmdate","Date");
define("_btplmselect","Select");
define("_btpmread","Read");
define("_btpmunread","Unread");
define("_btimgdelete","Delete Image");
define("_btpmnewmsg","New Message");
define("_btpmdelete","Delete Messages");
define("_btpmdelall","Delete ALL Messages");
define("_btpmdelconfirm","Are you sure you want to Delete ALL Selected Messages?");
define("_btpmdelbtn","Delete Messages");
define("_btpmdelallconfirm","Are you sure you want to Delete <b>ALL</b> your Private Messages?");
define("_btpmdeletedsuccessfully","Messages Successfully Selected");
define("_btnewpm","New Message");
define("_btpmto","Recipient");
define("_btpmtotip","If you want to Send the SAME Message to Multiple Users, separate them by with a semicolon (;)");
define("_btpmshowbookmarks","Show/Hide Contact List");
define("_btpmtext","Message text");
define("_btpmnorecipient","You have to specify a Recipient");
define("_btpmnosubject","You have to specify a Subject");
define("_btpmnomessage","Empty Message");
define("_btpminvalidrecipients","One or more of the Recipients you entered DO NOT Exist");
define("_btpmsentsuccessfully","Message Sent Successfully");
define("_btpmuserblocked","One of the Recipients DOES NOT Accept Messages from you. You wrote:<br><br>");
define("_btmessage","Message");
define("_btinvalidpm","Invalid Message");
define("_btpmnoexists","Message DOES NOT Exist");
define("_btpmreply","Reply");
define("_btuserlists","Buddies and Ignored Users");
define("_btuserlistsintro","Here you can Manage the List of Buddies and Ignored Users. The former are available in your Contact List for quick access when sending a New Message. 
Any Messages from Ignored Users will be Blocked. You can change a User's Status in his/her Profile. Users DO NOT have any information on the status they have been assigned by others.");
define("_btpmbookmarkuser","Add to Buddies");
define("_btpmunbookmarkuser","Remove from Buddies");
define("_btpmblacklistuser","Refuse this User's Messages");
define("_btpmunblacklistuser","Don't Refuse this User's Messages");
define("_btpmbookmarks","Buddies");
define("_btpmblacklist","Ignored Users");

//OVERLIB HELP 
#NO LINE-BREAKS!!!! 
define("_btperformance","Performance");
define("_btdht","DHT Support");
define("_bttorrentspd","Total Speed:");
define("_btleechspd","Estimated Speed: ");
define("_btedt","Estimated Download Time: ");
define("_btinfohashhelp","The Info Hash is a Short, Unique Code that Identifies a Torrent.<br>");
define("_btdhtexplanation","This Torrent Supports DHT. With a State-of-the-Art Client, you'll be able to download this Torrent even if a Central Tracker goes down.");
define("_btavatarnotice","Uploaded Avatars must be in GIF, JPEG or PNG format, suggested size 100x100 and cannot be larger than 300KB");
define("_btcustomsearch","RSS/RDF Feed for Custom Search");
define("_btcustomsearchexplain","Subscribe to this RSS/RDF Feed to stay Updated on Uploads that match your Search Terms");

// Rules 
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
define("_btmmlinks","You May Use Links In Your E-mails");
//BBcode 
define("_bb_tag_prompt","Enter a Text:");
define("_bb_img_prompt","Insert Link from Image");
define("_bb_font_formatter_prompt","Enter a Text - ");
define("_bb_link_text_prompt","Enter a Link Name (Optional):");
define("_bb_link_url_prompt","Enter the Full Address on the left of:");
define("_bb_link_email_prompt","Enter your Full Link:");
define("_bb_list_type_prompt","Which type of List would you like? Give ' 1 ' for a Numerical List, 'a' for an Alphabetical List, or nothing at all for a Simple Point List.");
define("_bb_list_item_prompt","Enter one point of list. Press OK to enter another point of list or press 'Cancel' to Finish.");
define('_btmfreetorrentexplain','<img src="themes/'.$theme.'/pics/magic.gif" alt="FREE TORRENT" title="FREE TORRENT" border="0">Any Torrents with this Symbol are Ratio Boosters. Only your Upload is Recorded!!<br> This is a Great way to Boost your Ratio. Normal Site Seeding Rules Apply.<br>Seed to 1.0 or 36 hours to avoid Hit and Runs.');
define('_btmnuketorrentexplain','<img src="themes/'.$theme.'/pics/nuked.gif" alt="NUKED TORRENT" title="NUKED TORRENT" border="0">Any Torrents with this Symbol are Nuked. <br>This means that for some reason someone has determined that there is something wrong with the Release,<br>and it may or may not be viewable. Use your own discretion when downloading these torrents.<br>Normal Site Seeding Rules still Apply unless also made Free. Please Read Details for Reason');
define('_btactiontime','Time');
define('_btactionmark','Mark');
//BitBucket 
define("_btuploadexpl","Select the File You wish to add to your torrent and BitBucket.<br />You will not need to upload this Image in the future.<br />Valid file extensions: bmp gif jpe jpeg jpg png.");
define("_btgalexpl","Here are all the Images You have In your Gallery<br />You can add a Images By clicking on the Name of the Image Or View the full Image by Clicking the Thumb.<br>You can also use it else where with [img]".$siteurl."/UserFiles/$user->name/image[/img]");
define("_btvaliext","Valid file extensions: bmp gif jpe jpeg jpg png");
define("_btattach","Attach Files");
define("_btmantitle","Click HERE to add image from you uploaded images");
define("_btmanimage","Manage Images");
define("_brupwait","Uploading File(s) - Please Wait");
define("_btuploading","Uploading");
define("_btselecatt","Please select a file to attach");
define("_btgalery","Image Gallery");
define("_btbuclosed","We are NOT allowing Bit-Bucket Uploads At this time","Bit-Bucket Closed");
define("_btgaltyp","You may only upload file types with the extensions bmp gif jpe jpeg jpg png");
define("_btgalwful","BitBucket is Full");
define("_btgalful","Your BitBucket is Full!<br />Please Delete some of your Images and try again.");
define("_btgalitobig","File To Big");
define("_btgalwitobig","File Size is Too Large!");

#offers 
#arcade 
define("_btarc","ARCADE");
define("_btarcadeclosed","Arcade is Closed.");
define("_btarc_play_Asteroids","Play Asteroids");
define("_btarc_play_Breakout","Play Breakout");
define("_btarc_play_Hexxagon","Play Hexxagon");
define("_btarc_play_Interactive","Play Interactive Buddy");
define("_btarc_play_Invaders","Play Space Invaders");
define("_btarc_play_Moonlander","Play Moonlander");
define("_btarc_play_Pac_Man","Play Pac-Man");
define("_btarc_play_Solitaire","Play Solitaire");
define("_btarc_play_Simon","Play Simon");
define("_btarc_play_Snake","Play Snake");
define("_btarc_play_Free_kick","Play James Original Free-Kick Challenge");
define("_btarc_play_Starcraft","Play Starcraft Flash Action 3");
define("_btarc_play_Tetris","Play Tetris");
define("_btarc_tittle",$sitename." Flash Arcade");
define("_btarc_high","View Highscores");
define("_btarc_stats","View Highscores stats");
#blackjack 
define("_btblj_tittle","BlackJack");
define("_btblj_start_game","Start Game");
define("_btblj_rule","<h3>Rules</h3><p style=\"color:#000033\">You must get as close as possible to 21 points...<br/>If you have more than 21 you loose<bd/><br/>You can win or loose 100MB</p>");
define("_btblj_stand","Stand");
define("_btblj_wratio","Sorry **user**, your Ratio is under **userratio**");
define("_btblj_banned","you're Banned from Casino.");
define("_btblj_play_tover","your playtime is over **maxtry** Times, you have to wait 5 hours.");
define("_btblj_max_download_passed","you have reached the Max Download for a Single User.");
define("_btblj_max_profit","but the maximum of Profits is above ");
define("_btblj_wait_next_player","You have to wait for another user play against you");
define("_btblj_open_game","You have to finish your opened game. <form method=post name=form action=".$_SERVER['PHP_SELF']."><input type=hidden name=game value=cont><input type=submit value='Continue old game'></form>");
define("_btblj_anothercard","Give me another one");
define("_btblj_you_win","You Won **won** of **opon** (You had **youpoint** Points, **opon** had **oppoint** Points). <a href=blackjack.php>Play Again</a>");
define("_btblj_points","Points");
define("_btblj_you_won_points","You won ");
define("_btblj_you_lost","You Lost ");
define("_btblj_you_21","Black Jack you have hit 21 points");
define("_btblj_who_won","You have **ypoint** Points, your opponent was **opon**, they had **tpoint** Points, **won** <a href=blackjack.php>Play Again</a> ");
define("_btblj_you_lost_points","You Lost **lost** to **opon** (You had **youpoint** Points, **opon** had 21 Points) <a href=blackjack.php>Play Again</a>");
define("_btblj_you_lost_points2","You Lost **lost** to **opon** (You had **youpoint** Points, **opon** had **oppoint** Points) <a href=blackjack.php>Play Again</a>");
define("_btblj_no_winner","Nobody Won");
define("_btblj_no_winner2","Your opponent was **opon**, Nobody Won <a href=blackjack.php>Play Again</a>");
define("_btblj_points_wait","You have **points** Points, there's no other players, so you'll have to wait until someone will play against you. You will be PM'd about game results");
define("_btblj_over","Game Over");
#Casino 
define("_btco_","Casino");
define("_btco_maxwin","Global Max win is above ");
define("_btco_upload_low","Sorry **username** you haven't uploaded **upload**");
define("_btco_win","WINNER!!!");
define("_btco_win_exp","Yes **wincolor** is the result **user** you got it and Win **winning**");
define("_btco_loose","LOOSER!!!");
define("_btco_loose_exp","Sorry **facwincolor** is Winner and not **wincolor**, **user** you lost **loose**");
#casino_player_edit.php 
define("_btcs_edit_noplr","No Players with the User ID **id**\n");
define("_btcs_edit_stupdt","Stats for User **id** are now Updated");
define("_btcs_edit_bktl","Back To The Players List");
define("_btcs_edit_pledok","Player Edited");
define("_btcs_edit_bktc","Back To The Casino");
define("_btcs_edit_yaediting","You are now Editing User");
define("_btcs_edit_lost","Lost");
define("_btcs_edit_pls","Plays");
define("_btcs_edit_alow","Allow User To Play Casino");
define("_btcs_edit_laac","Last Access");
define("_btcs_edit_wing","Winnings");
#confirminvite.php 
define("_btreadrules","I have read the Site <a href=/rules.php/ target=_blank font color=red>Rules</a> page.");
define("_btreadfaqs","I agree to read the <a href=/faq.php/ target=_blank font color=red>FAQ</a> before asking questions.");
define("_btofage","I am at least 13 years old.");
define("_btcookies","Note: You need Cookies Enabled to Sign Up or Log In.");
define("_btconinvite","Confirm Invite");
define("_btdupip","Duplicate IP In Use");
define("_bterridnotset","ID is NOT Set Please check Link");
define("_btusercount","The Current User Account Limit (**count**) has been reached. Inactive Accounts are Pruned all the time, please check back again later...");
#requist 

#bbcode 
define("_btbb_header","<p>The forms supports a number of <i>BB tags</i> which you can embed to modify how your posts are displayed.</p>");
define("_btadd_code","add test code here");
#faqaction.php 
define("_bt_faqmang","FAQ Management");
define("_bt_faq_additem","Add Item");
define("_bt_faq_update","Updated");
define("_bt_faq_normal","Normal");
define("_bt_faq_hidden","Hidden");
define("_bt_faq_answer","Answer:");
define("_bt_faq_status","Status:");
define("_bt_faq_catergory","Category:");
define("_bt_faq_new","New");
define("_bt_faq_id","ID:");
define("_bt_faq_title","Title:");
define("_bt_faq_confer_req","Confirmation Required");
define("_bt_faq_confer_ok","Please click <a href=\"faqactions.php?action=delete&amp;id=**id**&amp;confirm=yes\">here</a> to confirm.");
define("_bt_faq_add_section","Add Section");
#flash.php 
define("_bt_flash_closed","Arcade is Disabled.");
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
define("_bt_flash_rank","Rank");
define("_bt_flash_level","Level");
define("_bt_flash_name","Name");
define("_bt_flash_not_saveable","Unable to Save High Scores for this Game!");
define("_bt_flash_set_rez","Select resolution:");
define("_btcasino_ban","Sorry ".$user->name."you're Banned from Casino.");
#flashscore.php 
#youtube 
define("_btvid_clip","Video Clip");
define("_btvid_choose","Please Choose A Video From The Right.");
define("_btvid_fun","Have Fun");
define("_btvid_list","List");
define("_btvid_info","Clips Info");
define("_btvid_url","For URL: ");
define("_btvid_link","just put: qppuuQrklHg in link");
define("_btvid_add","Add New Clip");
define("_btvid_id","ID");
define("_btvid_name","Name");
define("_btvid_link1","Link");
define("_btvid_addedby","Added By");
define("_btvid_added","Added");
define("_btvid_delete","Delete");
define("_btvid_remove","Remove");
#Votes 
define("_btvote_votes","Votes");
define("_btvote_vote"," VOTES :");
define("_btvote_for","VOTE FOR THIS");
define("_btvote_request","REQUEST");
define("_btvote_notfound","NOTHING FOUND");
#Lottery 
define("_btlottery_sold","Tickets Sold");
define("_btlottery_purchased","Purchased Lottery Tickets");
define("_btlottery_disabled","Lottery is Disabled.");
define("_btlottery_end","Lottery Ends:");
define("_btlottery_tickets"," Number of Tickets ");
define("_btlottery_uploaded","You must have Uploaded at least ");
define("_btlottery_buy"," in order to Buy a Ticket!");
define("_btlottery_page"," Tickets Page");
define("_btlottery_purchase"," Buy Lottery Tickets");
define("_btlottery_nonrefund"," Tickets are Non-Refundable.");
define("_btlottery_cost"," Each Ticket Costs ");
define("_btlottery_taken","  which is taken from your Upload amount.");
define("_btlottery_purchaseable"," Purchasable shows how many Tickets you can afford.");
define("_btlottery_amount"," You can ONLY buy up to your purchasable amount.");
define("_btlottery_compend"," The competition will end: ");
define("_btlottery_willbe"," There will be ");
define("_btlottery_winners","  Winners will be picked at Random");
define("_btlottery_eachwinner"," Each Winner will get ");
define("_btlottery_added","  added to their Upload amount.");
define("_btlottery_announced"," The Winners will be announced once the Lottery has Closed and posted on the Home Page.");
define("_btlottery_pot"," The more Tickets that are Sold the Bigger the Pot will be!");
define("_btlottery_own"," You Own Ticket Numbers: ");
define("_btlottery_goodluck","Good Luck!");
define("_btlottery_purchase1","Purchase");
define("_btlottery_totalpot","Total Pot");
define("_btlottery_totalpurchased","Total Tickets Purchased");
define("_btlottery_owned","Tickets Purchased by You");
define("_btlottery_allowed","Purchasable");
define("_btlottery_allowed_tickets", " Tickets");
define("_btlottery_closed"," Lottery is Closed!");
define("_btlottery_sorry"," Sorry I CANNOT Sell you any Tickets!");
define("_btlottery_error"," ERROR");
define("_btlottery_max"," The Max number of Tickets you can Purchase is ");
define("_btlottery_noupload"," You DO NOT have enough Upload amount to Buy a Ticket");
define("_btlottery_lottery","Lottery");
define("_btlottery_just_purchased","You just Purchased ");
define("_btlottery_newtotal","Your New Total is ");
define("_btlottery_newupload","Your New Upload Total is ");
define("_btlottery_goback","Go Back");
define("_btlottery_ticket"," ticket");
#request 
define("_btrequestvote","Vote");
define("_btrequestvoted","<br><p>You've already Voted for this Request, ONLY 1 Vote for each Request is Allowed</p><p>Back to <a href=viewrequests.php><b>Requests</b></a></p><br><br>");
define("_btrequestvotetaken","<br><p>Successfully Voted for Request **requestid**</p><p>Back to <a href=viewrequests.php><b>Requests</b></a></p><br><br>");
define("_btrequest","Requests");
define("_btrequest_add","Add New Request");
define("_btrequest_view","View my Requests");
define("_btrequest_votes","Votes");
define("_btrequest_sort","SORT BY ");
define("_btrequest_added","Date Added");
define("_btrequest_name","Request Name");
define("_btrequest_display","Display");
define("_btrequest_search","Search");
define("_btrequest_addedby","Added By");
define("_btrequest_type","Type");
define("_btrequest_date","Date Added");
define("_btrequest_filled","Filled");
define("_btrequest_filledby","Filled By");
define("_btrequest_delete","Del");
define("_btrequest_dodel","Delete");
define("_btrequest_made","has made a Request for ");
define("_btrequest_closed","Request System is Closed, come back later... ");
define("_btrequest_offers","See All Offers");
define("_btrequest_make","Make Request");
//ViewSnatch 
define("_btsnatch_fin_order","The Users at the top finished the download most recently");
define("_btsnatch_seed_sp","Up Speed");
define("_btsnatch_leech_sp","Down Speed");
define("_btsnatch_time_cmpl","When Completed");
define("_btsnatch_last_action","Last Action");
define("_btsnatch_time_seeding","Seeding Time");
define("_btsnatch_cmpl","Seeding");
define("_btsnatch_pmu","PM User");
define("_btsnatch_here","On/Off");
define("_btsnatch_prev","Prev");
define("_btsnatch_next","Next");
define("_btsnatch_details","Snatch Details");
define("_btsnatch_global","Global");
define("_btsnatch_torrents","Torrent");
define("_btsnatch_online","On-line");
define("_btsnatch_offline","Off-line");
#userfind 
define("_buserfind_found","Found");
define("_buserfind_tryagain","members. Try Again.");
define("_buserfind_retry","[Retry]");
define("_buserfind_member","member");
define("_buserfind_specific","members. Try to be more specific.");
define("_buserfind_recip","members - choose Recipient");
define("_buserfind_recipt","Recipient");
define("_buserfind_Pseudo","Names");
#signup 
define("_btsignup_include","You cannot include this file");
define("_btsignup_limit_reached","Sorry, The Current User Account Limit ");
define("_btsignup_reached"," has been reached. Inactive Accounts are Pruned all the time, please check back again later...");
define("_btsignup_limit","Limit Reached");
define("_btsignup_noinvites","Sorry, No invites!");
define("_btsignup_message","You must enter a message!");
define("_btsignup_invalid_email","That doesn't look like a Valid E-mail Address.");
define("_btsignup_tryagain","Sorry, User Limit Reached. Please try again later.");
define("_btsignup_password_mismatch","Passwords don't match");
define("_btsignup_blank_fields","Don't leave any fields Blank.");
define("_btsignup_toolong","Sorry, User Name is tooLong (Max is 45 chars)");
define("_btsignup_wrong_pass","The Passwords didn't match!  Try again.");
define("_btsignup_tooshort","Sorry, Password is too Short (Min is 6 chars)");
define("_btsignup_pass_toolong","Sorry, password is too Long (Max is 40 chars)");
define("_btsignup_pass_name","Sorry, Password cannot be same as User Name.");
define("_btsignup_invalid_username","Invalid User Name.");
define("_btsignup_not_qualified","Sorry, you're not Qualified to become a Member of this Site.");
define("_btsignup_signup_fail","Sign Up Failed");
#delete requests 
define("_btdelrequest_select_delete","You must select at least one Request to Delete.");
define("_btrdelequest_dodel","Request Deleted OK");
define("_btrdelequest_id","Request ID ");
define("_btrdelequest_table","Request");
define("_btdelrequest_deleted","Deleted");
define("_btrdelequest_noperms","No Permission to Delete Request ID ");
define("_btdelrequest_done","Done");
define("_btdelrequest_messages"," messages.");
define("_btdelrequest_staffcp","Back To Staff CP");
//STATISTICS 
define("_btstats","Statistics");
define("_btstats_rank","Account Rank");
define("_btstats_user","Account User");
define("_btstats_uploaded","Uploaded ");
define("_btstats_downloaded","Downloaded ");
define("_btstats_ratio","Ratio");
define("_btstats_noshow","NOTHING TO SHOW");
define("_btstats_completed","Completed");
define("_btstats_seeds","Seeds ");
define("_btstats_leech","Leech ");
define("_btstats_peers","Peers");
define("_btstats_country","Country");
define("_btstats_users","Users");
define("_btstats_posted","Torrents Posted");
define("_btstats_extra","Extra Stats");
define("_btstats_welcome","Welcome New ");
define("_btstats_total","Total Users ");
define("_btstats_new_today","New Users Today ");
define("_btstats_active","Active Transfers ");
define("_btstats_tracking","Tracking ");
define("_btstats_local","Local Torrents ");
define("_btstats_external","External Torrents ");
define("_btstats_seed_ratio","Seed Ratio ");
define("_btstats_torrents","Torrents");
define("_btstats_top10_posters","Top 10 Posters");
define("_btstats_top10_uploaders","Top 10 Uploaders");
define("_btstats_top10_leechers","Top 10 Leechers");
define("_btstats_top10_best_shares","Top 10 Best Sharers ");
define("_btstats_100mb","(with minimum 100 MB downloaded)");
define("_btstats_top10_worst_shares","Top 10 Worst Sharers ");

define("_btstats_top10_active","Top 10 Most Active Torrents");
define("_btstats_top10_best_seed","Top 10 Best Seeded Torrents  ");
define("_btstats_top10_5seeds","(with minimum 5 seeders)");
define("_btstats_top10_worst_seeded","Top 10 Worst Seeded Torrents  ");
define("_btstats_top10_5leech","(with minimum 5 leechers, excluding un-snatched torrents) ");
define("_btstats_top10_most_complete","Top 10 Most Completed Torrents  ");
define("_btstats_top10_countries","Top 10 Countries ");
#staff 
define("_btstaff","Staff");
define("_btstaff_support","All Software Support Questions and those already answered in the <a href=faq.php><b>FAQ</b></a> will be Ignored.");
define("_btstaff_admin","Administrators");
define("_btstaff_mods","Moderators");
define("_btstaff_premium","Premium Users");
define("_btstaff_fls","Firstline Support");
define("_btstaff_general","General Support Questions should preferably be directed to these Users.<br/>Note that they are Volunteers, giving away their time and effort to help you. 
Treat them accordingly. (Languages listed are those besides English.)");
define("_btstaff_username","User Name");
define("_btstaff_active","Active");
define("_btstaff_contact","Contact");
define("_btstaff_language","Language");
define("_btstaff_supportfor","Support for");
#snatch warning 
define("_btsnatchwarn_warn","You have just received a Site a Warning!\n One week for Hit and Run!\n You have Failed to Seed back ".(defined('warn')? $warn['torrent_name'] : '')." to a 1 to 1 Ratio or Not TRYING to Seed back for 48 hours!\nIf you restart the torrent your Warning will be Removed.");
define("_btsnatchwarn__hnr","Hit And Run'");
define("_btsnatchwarn_pm","This is a Warning for Hit and Run!\n You have Failed to Seed back ".(defined('warn')? $warn['torrent_name'] : '') ." to a 1 to 1 Ratio\n or not TRYING to Seed back for 48 hours!\nIf you DO NOT restart the torrent or are unable to then you will receive a Site Warning for this torrent.");
#shoutbox 
define("_btshout_noperms","YouDO NOT have Permission to use Shouts");
define("_btshout_delete","'Delete Shout");
define("_btshout_shout","Shout");
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
define("_btshout_sandybrown","Sandy Brown");
define("_btshout_sienna","Sienna");
define("_btshout_chocolate","Chocolate");
define("_btshout_teal","Teal");
define("_btshout_silver","Silver");
define("_btshout_normalmode","Mode Normal");
define("_btshout_expertmode","Mode Expert");

#shoutbox archive 
define("_btshout_archive","Shout Box Archive");
define("_btshout_deleteed","Delete");
define("_btshout_edit","Edit");
define("_btshout_statistics","Statistics");
define("_btshout_total_posted","Total Shouts Posted:");
define("_btshout_last24","Shouts in past 24 hours:");
define("_btshout_yourshout","Your Shouts:");
define("_btshout_search","Search Shouts");
define("_btshout_search_terms","Search Terms");
define("_btshout_contains","Shout Contains:");
define("_btshout_usercontains","User Name Contains:");
define("_btshout_within","Within Past ");
define("_btshout_hours"," Hours:");
define("_btshout_sort","Sort Results By:");
define("_btshout_newest","Newest First");
define("_btshout_oldest","Oldest First");
define("_btshout_top15","Top 15 Shouters");
#scrape 
define("_btscrape_sqlerror","SQL ERROR: ");
define("_btscrape_notreg","Torrent NOT Registered with this tracker.");
#reseed req 
define("_btreseed_reg","Reseed Request");
define("_btreseed_msg","You have recently made a Request for this Re-Seed. Please wait longer for another Request.");
define("_btreseed_seeders"," seeders on this torrent ");
define("_btreseed_noneed","No need for this Request there are");
define("_btreseed_sent","Your Request for a Re-Seed has been sent to the following members that have Completed this torrent:");
define("_btreseed_pm"," has Requested a Re-Seed on the torrent below because there are currently FEW OR NO SEEDERS:  
	   click here for more on this file");
define("_btreseed_pm_thankyou","Thank You!");
define("_btreseed_pm_subject","Reseed Request");
#reset requests 
define("_btrequest_filled_errmsg1","No upload Location given");
define("_btrequest_filled_errmsg2","Error No Request ID given");
define("_btrequest_reset","Reset");
define("_btrequest_sent","Request ");
define("_btrequest_success"," Successfully Reset.");
define("_btrequest_sorry","Sorry, cannot Reset a Request when you are NOT the Owner");
#filled requests 
define("_btrequest_filled_filled","Request Filled");
define("_btrequest_filled_thanks","<BR><BR>Thank you for filling a Request :)<br><br><a href=viewrequests.php>View More Requests</a>");
define("_btrequest_filled_msg1","Your Request, <a href=" . $siteurl . "/reqdetails.php?id=**rqid**><b>**filledturl**</b></a>, 
has been filled by <a href=" . $siteurl . "/user.php?op=profile&id=".$user->id."><b>" . $user->name . "</b></a>.  
You can download your Request from <a href=**filledurl**><b>**filledturl**</b></a>.   
Please DO NOT forget to leave thanks where due.   
If for some reason this is not what you requested, please Reset your Request so someone else can fill it by following  
<a href=" . $siteurl . "/reqreset.php?requestid=**rqid**>this</a> link.   
Do <b>NOT</b> follow this link unless you are sure that this does not match your Request.");
define("_btrequest_filled_msg6","<br><BR><div align=left>Request **rqid** Successfully Filled with <a href=**filledurl**>**filledturl**</a>.  User <a href=user.php?op=profile&id=**requester**><b>**requestername**</b></a> was automatically PMd.  <br> Filled that accidentally? No worries, <a href=reqreset.php?requestid=**rqid**>CLICK HERE</a> to mark the Request as Unfilled.  Do <b>NOT</b> follow this link unless you are sure there is a problem.<br><BR></div>");
#requests details 
define("_btrequestdetails","REQUEST DETAILS");
define("_btrequestdetails_request","Request: ");
define("_btrequestdetails_desc","Description");
define("_btrequestdetails_date","Date Requested");
define("_btrequestdetails_req","Requested By");
define("_btrequestdetails_vote","Vote");
define("_btrequestdetails_reqs","REQUESTS");
define("_btrequestdetails_comments","COMMENTS");
define("_btrequestdetails_dateadded","DATE ADDED");
define("_btrequestdetails_addedby","ADDED BY");
define("_btrequestdetails_tofill","<B>To Fill This Request:</B> </td><td>Enter the <b>full</b> direct URL of the torrent i.e. http://www.mysite.com/torrents-details.php?id=134 (just copy/paste from another window/tab) or modify the existing URL to have the correct ID number");
define("_btrequestdetails_url","TYPE-DIRECT-URL-HERE");
define("_btrequestdetails_fill","Fill Request");
define("_btrequestdetails_or"," OR ");
define("_btrequestdetails_add","Add A New Request");
#ratio warn 
define("_btratiowarn_msg","This is a Warning. Your Ratio is too Low and has been Low for ");
define("_btratiowarn_msg1"," days. You have ");
define("_btratiowarn_msg2"," days to get your Ratio above ");
define("_btratiowarn_msg3"," or you will be Banned!");
define("_btratiowarn_msg4"," For Holding a ***Low Ratio*** for  ");
define("_btratiowarn_msg5"," days you where Warned");
#polls 
define("_btpolls_delete","Do you really want to delete a Poll? Click\n");
define("_btpolls_delete_here","HERE");
define("_btpolls_delete_sure"," if you are sure.");
define("_btpolls_delete_poll","Delete Poll");
define("_btpolls_delete_nopolls","There are no Polls!");
define("_btpolls_delete_error","ERROR");
define("_btpolls_index_edit","Edit");
define("_btpolls_index_delete","Delete");
define("_btpolls_index_votes","Votes: ");
define("_btpolls_overview","Polls Overview");
define("_btpolls_overview_id","ID");
define("_btpolls_overview_added","Added");
define("_btpolls_overview_question","Question!");
define("_btpolls_overview_gmt","GMT");
define("_btpolls_overview_sorry","Sorry...There are no Polls with that ID!");
define("_btpolls_overview_ago","ago");
define("_btpolls_overview_questions","Poll Questions");
define("_btpolls_overview_option_no","Option No");
define("_btpolls_overview_user","Polls User Overview");
define("_btpolls_overview_userid","User ID");
define("_btpolls_overview_selection","Selection");
define("_btpolls_overview_novotes","Sorry...There are no Users that Voted!");
define("_btpolls_overview_back","Back");
define("_btpolls_polls_notcounted","An error occured. Your Vote has NOT been counted");
define("_btpolls_polls_mod","Moderator Options");
define("_btpolls_polls_new","New");
define("_btpolls_polls_results","View Results");
define("_btpolls_polls_vote","Vote");
define("_btpolls_polls_login","You must Log In to Vote and View the Poll");
#phpBB.php 
define("_btforum_closed","The Forum is CLOSED");
#paypal 
define("_btpaypal_donation","Donation");
define("_btpaypal_giftmsg","Your Request for FTP was Denied due to Donation not being enouph\nYou will get Free Leech for your Donation.\nIt will stay active for one day for each $0.323 you Donated.");
define("_btpaypal_ftp","Your Request for FTP was Approved and will take UP to 24 hours to Activate");
define("_btpaypal_giftmsg1","Your Request for Free Leech is now Active.\nIt will stay active for one day for each $0.323 you Donated.");
define("_btpaypal_giftmsg2","Your Request for No Hit And Run Warnings is now Active.\nIt will stay active for one day for each $0.323 you Donated.");
define("_btpaypal_donation_ftp","Donation For FTP");
define("_btpaypal_donation_ftp_req"," has Donated and Requested FTP Access");
define("_btpaypal_donation_thanks",":thankyou:\nFor your Donation of ");
#offers 
define("_bt_voteoffer_noaccess",">You DO NOT have Permissions to Access Offers at this time");
define("_bt_voteoffer_votesfor",">Votes for ");
define("_bt_voteoffer_novotes","No Votes Yet");
define("_bt_voteoffer_member","Member");
define("_bt_voteoffer_uploaded","Uploaded");
define("_bt_voteoffer_downloaded","Downloaded");
define("_bt_voteoffer_ratio","Ratio");
define("_bt_voteoffer_joined","Joined");
define("_bt_voteoffer_ago","ago");
define("_bt_voteoffer_yes","Yes");
define("_bt_voteoffer_no","No");
define("_bt_voteoffer_back","Back");
define("_bt_offers_closed","Offers System is Closed, come back later...");
define("_bt_offers_offers","Offers");
define("_bt_offers_ok","OFFER OK");
define("_bt_offers_showall","(Show All)");
define("_bt_offers_category","Category");
define("_bt_offers_torrentname","Torrent Name");
define("_bt_offers_date","Offer Date");
define("_bt_offers_uploader","Uploader");
define("_bt_offers_comments","Comments");
define("_bt_offers_votes","Votes");
define("_bt_offers_pm","Send PM");
define("_bt_offers_edit","[Edit]");
define("_bt_offers_make","Make an Offer");
define("_bt_offers_seeall","See All Offers");
define("_bt_offeredit_owner","You're NOT the Owner!");
define("_bt_offeredit_owner1","You're NOT the Owner! How did that happen?");
define("_bt_offeredit_edit","Edit Offers");
define("_bt_offeredit_release","Release Edit ");
define("_bt_offerdetails_deluser","Deluser");
define("_bt_offerdetails_delacc","Deleted Account");
define("_bt_offerdetails_comemnt","Comments");
define("_bt_offerdetails_level","level: ");
define("_bt_offerdetails_posts","Posts");
define("_bt_offerdetails_edited","Edited By: ");
define("_bt_offerdetails_delete","DELETE COMMENT");
define("_bt_offerdetails_details","Details");
define("_bt_offerdetails_detailsfor","Details for");
define("_bt_offerdetails_name","Name");
define("_bt_offerdetails_desc","Description");
define("_bt_offerdetails_date","Date Offered");
define("_bt_offerdetails_by","Offered By");
define("_bt_offerdetails_vote","Vote");
define("_bt_offerdetails_nocomment","No Comments");
define("_bt_offerdetails_addcomment","Add Comment");

define("_bt_offercomment_id","Wrong ID " . (defined('offid') ? $offid : '' ) . ".");
define("_bt_offercomment_noid","No Offer with ID " . (defined('offid') ? $offid : '' ) . ".");
define("_bt_offercomment_added","Comment Added");
define("_bt_offercomment_added1","ADDED");
define("_bt_offercomment_addedcomment","Add Comment for ");
define("_bt_offercomment_send","Send");
define("_bt_offercomment_reverse","Last comments in Reverse Order.");
define("_bt_offercomment_wrongid","Wrong ID " . (defined('commentid') ? $commentid : '' ) . ".");
define("_bt_offercomment_edited","Comment Edited");
define("_bt_offercomment_edit","EDIT");
define("_bt_offercomment_editcomment","Edit Comment for ");
define("_bt_offercomment_edit1","Edit");
define("_bt_offercomment_aboutdelete","You're about to Delete this Comment. Click\n");
define("_bt_offercomment_here","Here");
define("_bt_offercomment_ifsure",", if you're sure.");
define("_bt_offercomment_delcom","Delete Comment");
define("_bt_offercomment_comdeleted","Comment Deleted");
define("_bt_offercomment_delete","DELETE");
define("_bt_offercomment_invalid","Invalid ID " . (defined('commentid') ? $commentid : '' ) . ".");
define("_bt_offercomment_original","Original");
define("_bt_offercomment_origid","Original Comment: ");
define("_bt_offercomment_unknown","Unknown action " . (defined('action') ? $action : '' ) . "");
define("_bt_offercomment_back","Back");
#bonus system 
define("_btbonus_exchange","Bonus Exchange");
define("_btbonus_exchange_closed","Bonus System is Closed");
define("_btbonus_exchange_closed_msg","Sorry to Announce but at this time we are NOT using the Bonus System<br />If you feel you have reached this error by Mistake please contact on of the sites moderators so they may assist you");
define("_btbonus_","Seeder Bonus");
define("_btbonus_what_is","Here you can Exchange your Seeder-Bonus (currently: ".$user->seedbonus.")<br>(If the button's Deactivated, you DO NOT have enough to Trade.)<br>");
define("_btbonus_option","Option");
define("_btbonus_wb","What's this about?");
define("_btbonus_t","Trade");
define("_btbonus_exchange_now","Exchange!");
define("_btbonus_how_get","How do I get Points?");
define("_btbonus_et"," (each torrent) ");
define("_btbonus_all"," (total) ");
define("_btbonus_how1","You receive {1}{2} Points for every 10 minutes the System Registers you as being a Seeder.<br>");
define("_btbonus_how2","You will Receive {1} Points for Uploading a new torrent.<br>");
define("_btbonus_how3","You will Receive {1} Points for Leaving a Comment on a torrent (that includes a quick thanks).<br>");
define("_btbonus_how4","You will Receive {1} Points for Making a Offer to upload a torrent<br />");
define("_btbonus_how5","You will Receive {1} Points for filling a Requested torrent<br />(Note any comment deleted By you or staff will result in loss of those points so no flooding)");
define("_btbonus_btp","Back to your Profile");
define("_btbonus_notenouph","Not enough Points to Trade...");
define("_btbonus_no_type","No Nalid Type");
define("_btbonus_adm_msg1"," - User has Traded {1} Points for Traffic.\n {2}\n");
define("_btbonus_sucs_trafic","You have Traded {1} Points for Traffic");
define("_btbonus__adm_msg2"," - User has traded {1} Points for Invites.\n ");
define("_btbonus_sucs_invite","You have Traded {1} Points for Invites");
#memberslist.php 
define("_btmemberlist_gp","Usergroup Information");
define("_btmemberlist_gp_gn","Group Name:");
define("_btmemberlist_gp_gd","Group Description:");
define("_btmemberlist","Members");
define("_btmemberlist_gp_mems","Group Members");
#polls 
define("_btpolls_nopollid","No Poll found with ID " . (defined('pollid') ? $pollid : '' ) . ".");
define("_btpolls_missing","Missing form Data!");
define("_btpolls_current","Note: The Current Poll ");
define("_btpolls_old"," is only " . (defined('t') ? $t : '' ) . " old.");
define("_btpolls_polls","Polls");
define("_btpolls_required","Required");
define("_btpolls_edit","Edit Poll");
define("_btpolls_create","Create Poll");
define("_btpolls_yes","Yes");
define("_btpolls_no","No");
define("_btpolls_question","Question ");
define("_btpolls_option1","Option 1 ");
define("_btpolls_option2","Option 2 ");
define("_btpolls_option3","Option 3 ");
define("_btpolls_option4","Option 4 ");
define("_btpolls_option5","Option 5 ");
define("_btpolls_option6","Option 6 ");
define("_btpolls_option7","Option 7 ");
define("_btpolls_option8","Option 8 ");
define("_btpolls_option9","Option 9 ");
define("_btpolls_sort","Sort");

#invite 
define("_btinvite_disbaled","Invites are Disabled, please use the Register Link.");
define("_btinvite_invite","Invite");
define("_btinvite_noinvite","Sorry, No Invites!");
define("_btinvite_email","E-mail Address:");
define("_btinvite_valid","Please make sure this is a Valid E-mail Address, the recipient will receive a Confirmation E-mail.");
define("_btinvite_message","Message:");
define("_btinvite_send","Send Invite (PRESS ONLY ONCE)");
#index 
define("_btindex_video","New Video Clips");
define("_btindex_legend","In total there is " );
define("_btindex_legend1"," Users On-line (based on users active over the past 5 minutes)<br>Most Users ever On-line was " );
define("_btindex_total24","Total Users On-line In Last 24Hours:");
define("_btindex_register7","Total Registered Users In Last 7Days:");
define("_btindex_register24","Total Registered Users In Last 24Hours:");
define("_btindex_totalregister","Total Registered Users:");
define("_btindex_totaltorrents","Total Torrents:");
define("_btindex_totalshare","Total Shared Data:");
define("_btindex_totalpeers","Total Peers:");
define("_btindex_speed","Total Transfer Speed:");
define("_btindex_totalseeders","Total Seeders:");
define("_btindex_totalleechers","Total Leechers");
define("_btindex_client","Most used Client:");
#HIT AND RUN
define("_bt_hnrremoved","Your Hit and Run Warning has been removed because you have restarted your torrent. Please keep seeding for 72 hours or Your Warning well be reinacted");
define("_bt_HNR","Hit and Run");
define("_btmod_HNR_mesage_a",gmdate("d-m-Y")." - Warned by System for Hit and Run.\n");
define("_bt_HNR_WARN_PM","You have repeatidly hit and run on torrents even after we have notified you that you should return to the torrent to continue seeding. Therefor you have received this one week warning. Hopefully you will not hit and run on torrents anymore, and if you do it may result in your account being disabled.");
define("_btmod_HNR_mesage_b",gmdate("d-m-Y")." - Warning Removed by System for Hit and Run.\n");
define("_BT_HNR_NOTICE_PM","It appears that you have hit and run on {hnrtot} torrent{hnrcount}.\n\nWe advise you to return to continue seeding {these} torrent{hnrcount} within 30 minutes or else you risk being warned, or if this happends to you repeatedly you may even risk your account being disabled.\n\nThe torrent{hnrcount} on which you have been found hit and running {is}:\n{hnrtorrents}");
define("_bt_happy_bd","Congratulations to: ");
define("_bt_no_happy_bd","No Birthdays today");
define("_bt_no_nuser","No new members");
define("_bt_poster","Poster");
define("_bt_screensa","Screenshot 1");
define("_bt_screensb","Screenshot 2");
define("_bt_screensc","Screenshot 3");
define("_bt_screensd","Screenshot 4");
define("_bt_poster_exp","(Direct link for a poster,Poster Upload " . $siteurl . ")");
define("_bt_screen_expa","(Direct link for a Screenshot 1)");
define("_bt_screen_expb","(Direct link for a Screenshot 2)");
define("_bt_screen_expc","(Direct link for a Screenshot 3)");
define("_bt_screen_expd","(Direct link for a Screenshot 4)");
define("_bt_fm_del_bookm","Remove selected bookmarks");
define("_bt_fm_del_bookm_CONFIRM","Are you sure you want to delete all selected bookmarks?");
define("_bt_fm_del_draft","Remove selected drafts");
define("_bt_fm_del_draft_CONFIRM","Are you sure you want to delete all selected drafts?");
 
define("_btemailnotsame","The E-mail Adress's you entered are NOT the same");
define("_LOAD_DRAFT","Load draft");
define("_VIEW_EDIT","View/Edit");
define("_TOPIC","Topic");
define("_PRIVATE_MESSAGE","Private message");
define("_NO_TOPIC_FORUM","The topic or forum no longer exists.");
define("_DRAFT_NO_TOPIC_FORUM","No drafts saved.");
define("_OPTIONS","Options");
define("EDIT_DRAFT_EXPLAIN","Here you are able to edit your draft. Drafts do not contain attachment and poll information.");
define("NO_FRIENDS_ONLINE","No friends online");
define("BACK_TO_DRAFTS","Back to saved drafts");
define("_btdraftsaved","Draft successfully saved.");
define("SIGNATURE_PREVIEW","Your signature will appear like this in posts");
define("WATCHED_EXPLAIN","Below is a list of forums and topics you are subscribed to. You will be notified of new posts in either. To unsubscribe mark the forum or topic and then press the <em>Unwatch marked</em> button.");
define("_WATCHED_TORRENTS","Watched torrents");
define("_WATCHED_FORUMS","Watched forums");
define("_WATCHED_TOPICS","Watched topics");
define("JUMP_TO_PAGE","Click to jump to page…");
define("GOTO_PAGE","Go to page");
define("JUMP_PAGE","Enter the page number you wish to go to.");
define("UNMARK_ALL","Unmark all");
define("MARK_ALL","Mark all");
define("UNWATCH_MARKED","Unwatch marked");
define("VIEW_FORUM_TOPIC","1 topic");
define("VIEW_FORUM_TOPICS","%d topics");
define("GLOBAL_ANNOUNCEMENT","Global announcement");
define("WATCHED_FORUMS","Watched forums");
define("WATCHED_TOPICS","Watched topics");
define("NO_SEEDERS","No seeders at this time");
define("_bt_fm_del_subs","Remove selected subscriptions");
define("_bt_fm_del_subs_CONFIRM","Are you sure you want to delete all selected subscriptions?");
define("bterror_draft","Delete Drafts");
define("bterror_draft_no","No Draft is set please check your link");
define("bterror_sub_no_num","The Subscription Is not a number please go back and try again");
define("NO_WATCHED_TOPICS","You are not subscribed to any topics.");
define("NO_WATCHED_TORRENTS","You are not subscribed to any torrents.");
define("NO_WATCHED_FORUMS","You are not subscribed to any forums.");
define("PAGE_OF",'Page <strong>%1$d</strong> of <strong>%2$d</strong>');
define("SORT_TOPIC_TITLE","Topic tittle");
define("DELETE_MARKED","Delete marked");
define("PROFILE_UPDATED",'Your profile has been updated.');
define("UCP_BAN_USER_FORUM","Ban user from the Forum");
define("UCP_BAN_FORUM","Forum Ban");
define("UCP_SHOUT_BAN_EXPL","User well not beable to View or Post shouts");
define("UCP_PARK_ACC","Account parked");
define("UCP_PARK_ACC_EXPL","You can park your account to prevent it from being deleted because of inactivity if you go away on for example a vacation. When the account has been parked limits are put on the account, for example you cannot use the tracker and browse some of the pages.");
define("UCP_DISABLE_ACC","Disable Account");
define("UCP_DISABLE_ACC_EXPL","Disabled accounts can not view Torrents Upload or download Torrents.<br />Disabled accounts well no longer be able to access site announce.<br />This is a Mild form of Ban as the users well be able to access the site to find out why they have been Disabled");
define("UCP_WARN_REASON_EXPL","Note added to users Private Message as to why they have been warned");
define("UCP_WARN_REMOVED_MES","Your WARNNING was deleted by **user**!");
define("UCP_WARNED_MES","You have been WARNNED by **user** for  **weeks**  with reason: **message**.");
define("WARNNING","WARNNING");
define("UCP_WARN_WEEK",'%s Week%s');
/*define("","");
define("","");*/
/*define("","");
define("","");*/
/*define("","");
define("","");*/
/*define("","");
define("","");*/
/*define("","");
define("","");*/
/*define("","");
define("","");*/
?>