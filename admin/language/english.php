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
*/

if (!eregi("admin.php",$_SERVER["PHP_SELF"])) die ("You can't access this file directly");

define("_admsavebtn","Save");
define("_admresetbtn","Reset");
define("_admsaved","Settings saved!");

#MENU
define("_adm_tables_user","Edit Users");
define("_adm_tables_torrents","Edit Torrents");
define("_adm_tables_site","Edit Site");
define("_admmenu","Administrative Menu");
define("_admsettings","Settings");
define("_admbans","Bans");
define("_admfilter","Keyword Filter");
define("_admcategories","Categories");
define("_admoptimizedb","Optimize Database");
define("_admirc","IRC Chat");
define("_admwebupdate","Updates");
define("_admuser","User Manager");
define("_admmassupload","Massive Upload");
#prune
define("_userprune",'User Prune Settings');
define("_admpautodel_users","Turn on User Prune System ");
define("_admpautodel_usersexplain","Inable or Disable User Prune System");
define("_admpinactwarning_time","Time before Email Warning In days");
define("_admpinactwarning_timeexplain","How Long To allow a user to be inactive Before a notice is sent to them and account set inactive");
define("_admpautodel_users_time","Time before delete In days");
define("_admpautodel_users_timeexplain","How long after account is set Inactive To Prune it(Delete it)<br> This dose not include Banned accounts");
#HNR
define("_admphnr_system","Turn on Hit And Run System ");
define("_admphnr_systemexplain","Inable or Disable Hit And Run System");
define("_admpseedtime","Seed Time ");
define("_admpseedtimeexplain","The Set Time In Minutes how long A Member Bust Seed a Torrent");
define("_admptime_before_warn","Time allowed Between announce ");
define("_admptime_before_warnexplain","How Long After First Missed Announce to Give a Member Before First Warning PM(Set Time In Minutes)");
define("_admpmaxhitrun","Max Number OF Hit And Runs ");
define("_admpmaxhitrunexplain","Max Hit And Runs Before a Member gets a Site Warning");
define("_admpwarnlength","How long of a warning for Hit and run ");
define("_admpwarnlengthexplain","How Long should warning be for Hit And Run(Time Set In Day's)");
define("_admpban_hnr_users","Ban User for HNR");
define("_admpban_hnr_usersexplain","Ban User for HNR");
define("_admpdemote_hnr_users","Demote User for HNR");
define("_admpdemote_hnr_usersexplain","Demote User for HNR");
define("_admpafter_high_hnr","Demote After Max Number OF Hit And Runs");
define("_admpafter_high_hnrexplain","Demote After Max Number OF Hit And Runs");
define("_admpdemote_hnr_users_to","Demote User to");
define("_admpdemote_hnr_users_toexplain","Demote User to");
define("_admpban_time","How long to Demote for Hit and run");
define("_admpban_timeexplain","How Long should Demotion be for Hit And Run(Time Set In Day's)");
#shoutbox 
define("_admpannounce_ment","Shout Box Announcement ");
define("_admpannounce_mentexplain","A Text that stays at the top of shout box");
define("_admpturn_on","Turn on Shoutbox ");
define("_admpturn_onexplain","Inable or Disable shoutbox");
define("_admprefresh_time","Shoutbox refresh rate ");
define("_admprefresh_timeexplain","This is the time shoutbox refreshes");
define("_admpidle_time","Shoutbox Idle Time ");
define("_admpidle_timeexplain","This is the time shoutbox check for users at Idle");
define("_admpbbcode_on","Allow the use of BBcode in shouts ");
define("_admpbbcode_onexplain","Inable users to use the bbcodes in Ther shouts");
define("_admpautodelete_time","Auto Delete ");
define("_admpautodelete_timeexplain","This is How long you want shouts to Apear");
define("_admpcanedit_on","Can edit Shouts ");
define("_admpcanedit_onexplain","Allow Users to edit there shouts");
define("_admpcandelete_on","Can Delete Shouts ");
define("_admpcandelete_onexplain","Allow Users to delete there shouts");
define("_admpshouts_to_show","Shouts To Show ");
define("_admpshouts_to_showexplain","How Many Shouts You Want To Display");
define("_admpallow_url","Allow Links In Shouts ");
define("_admpallow_urlexplain","Allow Users to Use Links In Shouts");
define("_admpshoutnewuser","Announce New Users ");
define("_admpshoutnewuserexplain","Automaticly Shout A Welcome For New Users");
define("_admpshout_new_torrent","Announce New Torrents ");
define("_admpshout_new_torrentexplain","Automaticly Shout New Uploaded Torrents");
define("_admpshout_new_porn","Announce New Porn Torrents ");
define("_admpshout_new_pornexplain","Automaticly Shout New Uploaded Porn Torrents This Dose Not Over Ride If Announce New Torents Is Off");

#OVERVIEW
define("_admoverview","Overview");
define("_admtotalusers","Total Registered Users:");
define("_admtotaltorrents","Total Torrents:");
define("_admtotalshare","Total shared data:");
define("_admtotalpeers","Total Peers:");
define("_admtotalspeed","Total transfer speed:");
define("_admtotalseeders","Total seeders:");
define("_admtotalleechers","Total leechers:");
define("_admmostusedclient","Most used client:");

#CONFIGURATION SECTION
define("_admconfigttl","phpMyBitTorrent Configuration");

#user
define("_admpgive_sign_up_credit","Give Upload on signup");
define("_admpgive_sign_up_creditexplain","Give users Upload win the sign up to the site.");

define("_admpconferm_email","Force E-mail comfermation");
define("_admpconferm_emailexplain","Force a user to conferm ther e-mail Before they can use the site.");

#torrents
define("_admpallow_multy_tracker","Allow Multy Tracker Torrents");
define("_admpallow_multy_trackerexplain","Allow Users To Upload A Torrent with More then One announce.");

define("_admpallow_external","Allow External Torrents");
define("_admpallow_externalexplain","Allow Users to Upload Torrents From Other Sites.");


define("_admpauto_clean","Auto Clean Timer");
define("_admpauto_cleanexplain","Sets the time intervals Of the clean sessions. For like with the bonus system.");

define("_admppivate_mode","Privat Tracker Mode");
define("_admppivate_modeexplain","Sets tracker to private and no one can see the content inless they are a member and are logged in.");

define("_admpaddprivate","Make all locale Torrents Private");
define("_admpaddprivateexplain","Sets all newly uploaded locale torrents as private if they have not been done so.<br /><b>The uploader well need to down load the torrent from the site once this is active.</b><br /><br />The (private)-option (which only some clients can handle), tells the client to deal only with peers it receives from the central tracker. Enabling the Private option disables DHT");

define("_admpmax_members","Max allowed Members");
define("_admpmax_membersexplain","Max number of members allowed to join your site.");

define("_admpinvite_only","Inite Only");
define("_admpinvite_onlyexplain","Only allows for users to join if they have been invited.");

define("_admpforce_passkey","Force Passkey");
define("_admpforce_passkeyexplain","Set this to force your members to use Passkey system");

define("_admpinvites_open","Invite system");
define("_admpinvites_openexplain","turn on and off the invite system.");

define("_admpupload_dead","Allow 'dead' External Torrents");
define("_admpupload_deadexplain","Use this to allow for (apparently) un-seeded external torrents to be uploaded to tracker. Might be usefull if the external torrent monitoring doesn't work so well, which depends on your server configuration.");

define("_admpsitename","Site Name");
define("_admpsitenameexplain","The name of your site. Will be displayed as the page title.");

define("_admpsiteurl","Site URL");
define("_admpsiteurlexplain","URL of this site. Must be entered for using the tracker.");

define("_admpcookiedomain","Cookie Domain");
define("_admpcookiedomainexplain","Cookie domain. Must be set to the domain name of this site (e.g. yoursite.com). Required for user login to work.");

define("_admpcookiepath","Cookie Path");
define("_admpcookiepathexplain","Cookie Path. Change this setting <b>only</b> if phpMyBitTorrent is installed in a subdirectory of your server. If your installation is in http://yoursite.com/phpMyBitTorrent, the setting should be /phpMyBitTorrent");

define("_admpuse_gzip","Use GZIP compression");
define("_admpuse_gzipexplain","This option allows you to enable or disable PHP's GZIP compression on HTML and Announce output. If enabled, bandwidth usage will be lower but CPU usage will be higher. This setting doesn't work fine on all servers; if your users report any Gzip errors in their clients, turn it off. Verify that your tracker reads the Announce response correctly.");

define("_admpadmin_email","Administrator E-Mail");
define("_admpadmin_emailexplain","E-Mail Address from which all emails to users will be sent (signup,pm notifications, authorizations, etc.). It may be a good idea to enter a valid address.");

define("_admplanguage","Default Language");
define("_admplanguageexplain","Specifies the default language to use.");

define("_admptheme","Theme");
define("_admpthemeexplain","Set the default theme for this site. Registered users can ovverride this setting from their panel.");

define("_admpwelcome_message","Site News");
define("_admpwelcome_messageexplain","Anything you enter here will appear in a box on top of the torrent index. Leave the field blank to make the box disappear altogether.");

define("_admpannounce_text","Tracker Message");
define("_admpannounce_textexplain","This defines the message that users see on their BitTorrent Client when they connect to the Tracker. Useful for announcements and publicity.");

define("_admpallow_html","Use HTML Editor");
define("_admpallow_htmlexplain","Enable this option to allow users to write Torrent Descriptions using the embedded HTML-editor. <br /><b>WARNING</b>: this feature is still experimental!");

define("_admprewrite_engine","SearchRewrite");
define("_admprewrite_engineexplain","SearchRewrite transforms PHP's complex URLs into faux HTML pages, easier to type into the address bar. This feature is also very useful to increase search engine traffic. Apache's mod_rewrite or IIS's ISAPI_Rewrite are REQUIRED on your server.");

define("_admptorrent_prefix","Torrent Prefix");
define("_admptorrent_prefixexplain","This option allows you to add a custom prefix to all Torrents downloaded from this tracker. Useful to spread the word about your community.");

define("_admptorrent_per_page","Torrents per page");
define("_admptorrent_per_pageexplain","Indicates how many Torrents can be displayed each page, both in listing and in search mode.");


define("_admponlysearch","Search Only");
define("_admponlysearchexplain","Hide Torrent List to non-Admins. Users (whether registered or not) have to perform a search to get to any torrents.");

define("_admpmax_torrent_size","Maximum Torrent Size");
define("_admpmax_torrent_sizeexplain","Maximum byte size for uploaded .torrent files. This does NOT put any limit to the size of the actual size of any files shared with the .torrent!");

define("_admpannounce_interval","Announce Update Interval");
define("_admpannounce_intervalexplain","Recommended time interval (seconds) between Announce request. This value is sent to the client.");

define("_admpannounce_interval_min","Minimum Announce Update Interval");
define("_admpannounce_interval_minexplain","Recommended time interval between Announce requests. More frequent requests will be refused.");

define("_admpdead_torrent_interval","Dead Torrent Interval");
define("_admpdead_torrent_intervalexplain","Specifies the amount of time (in seconds) that a dead Torrent (no peers) can be kept visible in the tracker. After that period, it will be automatically hidden.");

define("_admpfree_dl","Free Torrent Down Loads");
define("_admpfree_dlexplain","Give Members Free down loads. None of the down loads well e recorded during the time that this is seleted only ther upload");

define("_admpaddprivate","Make All Internal Torrents private");
define("_admpaddprivateexplain","When this is set all Internal torrents well be set to private and the uploaders well have to down load the torrent from the site in order to seed it<br /><b>This dose not change external torrents!!!</b>");
////////wait
define("_admpwait_time","Add Wait Time");
define("_admpwait_timeexplain","When You set this users with a set cryterea well have to wait for a set amount of time before there downloads well start. <br /><br /><b>You must remember</b><br />To set the anounce access level to users and the torrents well need to be set to Private");

define("_admpGIGSA","For Member With Uploads (IN GIGS) less then");
define("_admpGIGSAexplain","Set the first minnum upload In Gigs for the first wait period");

define("_admpGIGSB","For Member With Uploads (IN GIGS) less then");
define("_admpGIGSBexplain","Set the second minnum upload In Gigs for the first wait period");

define("_admpGIGSC","For Member With Uploads (IN GIGS) less then");
define("_admpGIGSCexplain","Set the third minnum upload In Gigs for the first wait period");

define("_admpGIGSD","For Member With Uploads (IN GIGS) less then");
define("_admpGIGSDexplain","Set the fourth minnum upload In Gigs for the first wait period");

define("_admpRATIOA","For Member With a ratio less then");
define("_admpRATIOAexplain","Set the fist minnamum ratio");

define("_admpRATIOB","For Member With a ratio less then");
define("_admpRATIOBexplain","Set the second minnamum ratio");

define("_admpRATIOC","For Member With a ratio less then");
define("_admpRATIOCexplain","Set the third minnamum ratio");

define("_admpRATIOD","For Member With a ratio less then");
define("_admpRATIODexplain","Set the fourth minnamum ratio");

define("_admpWAITA","Must Wait for this many hours");
define("_admpWAITAexplain","Set the first wait period in hours");

define("_admpWAITB","Must Wait for this many hours");
define("_admpWAITBexplain","Set the second wait period in hours");

define("_admpWAITC","Must Wait for this many hours");
define("_admpWAITCexplain","Set the third wait period in hours");

define("_admpWAITD","Must Wait for this many hours");
define("_admpWAITDexplain","Set the fourth wait period in hours");
///wait end
define("_admpminvotes","Minimum votes");
define("_admpminvotesexplain","Minimum number of votes to display a Torrent rating at all.");

define("_admptime_tracker_update","Autoscrape Interval");
define("_admptime_tracker_updateexplain","Specifies the interval between External Tracker queries. Requires Autoscrape enabled.");

define("_admptime_tracker_update","Autoscrape Interval");
define("_admptime_tracker_updateexplain","Autoscrape Interval");

define("_admpbest_limit","Best Torrent Peer Limit");
define("_admpbest_limitexplain","Number of total peers above which the Torrent is included in the Top Torrents List/RSS feed.");

define("_admpdown_limit","Dead Torrent Peer Limit");
define("_admpdown_limitexplain","Number of total peers below which the Torrent is treated as Dead.");

define("_admptorrent_complaints","Torrent Complaints");
define("_admptorrent_complaintsexplain","Allows users to complain about a  torrent in its details page, in an attempt to to block undesired content, such as child pornography. Torrent that get a certain number of complaints are automatically banned.");

define("_admptorrent_global_privacy","Torrent Authorizations");
define("_admptorrent_global_privacyexplain","Switching this on allows registered uploaders to put limitations on who can download their torrents. The owner of a torrent can either authorize downloads on a case-to case basis, or automatically, by setting a overall share ratio that the downloader has to meet. You have to set the Tracker Access Level to 'User' in order for this to work.");

define("_admpdisclaimer_check","Disclaimer");
define("_admpdisclaimer_checkexplain","If checked, users have to accept a disclaimer before they register. You can change the disclaimer by changing the file /disclaimer/english.php.");

define("_admpgfx_check","Captcha Test");
define("_admpgfx_checkexplain","If checked, users have to type in a code from a captcha image when registering and logging in.");

define("_admpupload_level","Upload access level");
define("_admpupload_levelexplain","Determines the user level required for the permission to upload torrents<ul><li><b>'Everyone'</b> allows anyone to upload Torrent files to this site. They won't be able to edit them or manage authorizations<li><b>'Registered'</b> requires uploaders to be registered. <b>'Premium'</b> only allows Premium users to upload.<li></ul>");
define("_admpupload_levelopt1","Everyone");
define("_admpupload_levelopt2","Registered");
define("_admpupload_levelopt3","Premium");

define("_admpdownload_level","Download access level");
define("_admpdownload_levelexplain","<ul><li><b>'Everyone'</b> allows anyone to download Torrent files from this site<li><b>'Registered'</b> requires registration<li><b>'Premium'</b> allows only Premium users to download a .torrent from this site</ul>This setting does not affect the tracker. So if somebody got their hands on a .torrent, they can download.");
define("_admpdownload_levelopt1","Everyone");
define("_admpdownload_levelopt2","Registered");
define("_admpdownload_levelopt3","Premium");

define("_admpannounce_level","Tracker access level");
define("_admpannounce_levelexplain","<ul><li><b>'Everyone'</b> allows anyone to connect to the tracker (i.e. announce) <li><b>'Registered'</b> requires the user to log in (IP address is checked!) before connecting to the tracker</ul>This setting does not affect Torrent download from site.");
define("_admpannounce_levelopt1","Everyone");
define("_admpannounce_levelopt2","Registered");

define("_admpmax_num_file","Maximum Torrent file number");
define("_admpmax_num_fileexplain","Maximum number a torrent can contain, above which it won't be accepted for upload. Use it if you'd like to encourage people to use compressed archives. Setting to zero will just ignore the parameter.");

define("_admpmax_share_size","Maximum Torrent Share Size");
define("_admpmax_share_sizeexplain","Total combined size of files in a torrent, above which the upload won't be accepted. Setting this to zero will just ignore the parameter.");

define("_admpglobal_min_ratio","Global Minimum Ratio");
define("_admpglobal_min_ratioexplain","Specify a minimum upload/download ratio, below which a user will not be allowed to download any more torrents. The option is applicable only if the Announce Level (above) is set to 'User' of the download page. Setting zero will disable the option.");

define("_admpautoscrape","External Torrent Monitoring");
define("_admpautoscrapeexplain","This allows you to monitor the peer count for torrents tracked by remote trackers.<br>Be careful here.<br>You can use this ONLY if your server can open sockets to any other machines. Many cheap or free hosting services have firewalls that block outgoing connections. If you're not using a Dedicated/Home Server, it is recommended that you DO NOT enable this option unless you're sure what you're doing.<br>If you don't enable it all external torrents will be displayed having zero sources. If you enable it, but your server can't build connections to scrape, external uploads may be rejected (unless you check 'Allow dead External Torrents'");

define("_admpmax_num_file_day_e","Maximum number of daily downloads");
define("_admpmax_num_file_day_eexplain","Defines how many files can be downloaded per day by a single user. Any requests abov that will be refused and the user will be asked to try again the next day.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpmax_num_file_week_e","Maximum number of weekly downloads");
define("_admpmax_num_file_week_eexplain","Defines how many files can be downloaded in a week's time by a single user. Further requests will be refused and the user will be asked to try again the next week.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpmin_num_seed_e","Minimum seed number for new downloads");
define("_admpmin_num_seed_eexplain","Defines how many Torrents the user must be seeding before downloading new files.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpmin_size_seed_e","Minimum seed size for new downloads");
define("_admpmin_size_seed_eexplain","Defines how much share the user must be seeding before downloading new files.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpminupload_size_file","Minimum file size for new Torrents");
define("_admpminupload_size_fileexplain","Defines The Minimum size a torrent file can be.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpmaxupload_day_num","Maximum daily uploads");
define("_admpmaxupload_day_numexplain","Defines how many Torrents can be uploaded in a single day. Any uploads above that won't be accepted and the user will be asked to try again the next day.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpmaxupload_day_share","Maximum Daily upload");
define("_admpmaxupload_day_shareexplain","Defines the maximum total size of files (all files within a torrent combined) a user can upload in a single day. Any further uploads won't be accepted and the user will be asked to try again the next day.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpminupload_file_size","Minimum Torrent size for upload");
define("_admpminupload_file_sizeexplain","Defines Torrent's minimum size (all files within a torrent combined) for upload.<br>Premium users are not affected by this setting. Setting this option to zero will disable it.");

define("_admpallow_backup_tracker","Backup Tracker");
define("_admpallow_backup_trackerexplain","Runs your tracker as a Backup Tracker according to the BitTorrent's Announce-List extension. Usage is subject to Announce level settings and does not affect ratios. This option is ignored if Stealth Mode is enabled.");

define("_admpstealthmode","Disable Local Tracker");
define("_admpstealthmodeexplain","This will disable and hide the local tracker. phpMyBitTorrent will only accept externally tracked torrents.");

#KEYWORD FILTER
define("_admnofilterkey","No filter keywords");
define("_admaddkeyword","Add/Edit keyword");
define("_admkeyword","Keyword");
define("_admkeywordreason","Reason");
define("_admmissingkeyword","Missing keyword");
define("_admmissingreason","Missing reason");
define("_admkeywordillegalformat","Keyword must be 5 to 50 alphanumeric chars");
define("_admreasonillegalformat","Reason must be maximum 255 chars long");
define("_admfilterintro","With the Keyword Filter, you can stop users from uploading Torrents that may violate tracker rules or the law.<br />
This checks the names of the files within a torrent. Be careful to not insert any common words.");

#CATEGORIES ADMIN
define("_admcategoriesintro","In this section you can manage Torrent categories that users may upload. Installation provides this tracker with some common categories for Torrents.<br />
You can add your own ones or edit others. Be careful that every category must be represented by a significant image for best experience. Images are in the <i>cat_pics</i> directory of the tracker's root directory.
If the theme has a <i>pics/cat_pics</i> directory within it, images that are in that directory will be displayed instead of global images.");
define("_admiconintro","In this section you can upload new images to use for you category Icons. At this time you are allowed to use png, gif, jpg , and jpeg. Remember that you have to make the /cat_pics folder writable first. Icons must not exceed 48px X 48px and must not be larger than 17kb. Once you have uploaded the new icon, you can choose it from the drop-down list above.");
define("_admnocategories","No categories to administer");
define("_admcatname","Name");
define("_admchoose","Choose");
define("_admcatimage","Image");
define("_admaddcategory","Add/Edit category");
define("_admnewcategory","Add New Category Icon");
define("_admposition","Position");
define("_admatend","At the end");
define("_admatbegin","At the beginning");
define("_admafter","After");
define("_admupcat","Upload Category Icon:");
define("_admcattoobig","Category Icon Is To Big");
define("_adminvalidcatfname","Invalid Category Icon ");
define("_admerrnocatupload","Fatal error in uploaded Category Icon.");

#DATABASE OPTIMIZATION
define("_admtable","Table");
define("_admstatus","Optimization Status");
define("_admspacesaved","Space Saved");
define("_admaoptimized","Already Optimized");
define("_admoptimized","Optimized");

#BAN
define("_admban","User Ban");
define("_admbanintro","Use this page to ban users from your tracker. You can define IP ranges to ban and manage banned IPs and users. You can also provide a reason that is presented to the banned user when he/she tries to log in.");
define("_admbannedips","Banned IPs");
define("_admbannedusers","Banned Users");
define("_admnobannedips","No Banned IPs");
define("_admbanipstart","Start IP");
define("_admbanendip","End IP");
define("_admbanreason","Reason");
define("_admbanactions","Actions");
define("_admnobannedusers","There are no banned users");
define("_admaddeditban","Add/Edit Ban");
define("_admbaniprange","Ban a single IP or an entire range");
define("_admbanuser","Ban a user");
define("_admbaninvalidip","IP addresses MUST be in AAA.BBB.CCC.DDD format where each octet is a number between 0 and 255.");
define("_admbanusernoexist","This user does not exists");

#EXTERNAL TRACKERS
define("_admtrackers","External Trackers");
define("_admtrackerintro","With this panel you can monitor the status of External Tracker associated to Torrents.
You can set a filter that prevents uploading Torrents from certain Trackers or you can force Tracker update viewing debug information.");
define("_admnotrackers","No External Trackers");
define("_admtrackerurl","Announce URL");
define("_admtrkstatus","Status");
define("_admtrkstatusactive","Active");
define("_admtrkstatusdead","Offline");
define("_admtrkstatusblack","Blacklisted");
define("_admtrklastupdate","Updated");
define("_admtrkscraping","Updating");
define("_admtrkassociatedtorrents","Torrents");
define("_admtrkviewtorrents","(View)");
define("_admtrkforcescrape","Update torrents now");
define("_admtrkblacklist","Exclude");
define("_admtrkunblacklist","Do Not Exclude");
define("_admtrkscraping","Updating Tracker...");
define("_admtrkcannotopen","Cannot contact Tracker. Tracker will be set to 'offline'");
define("_admtrkrawdata","Tracker reached. Here is the encoded response");
define("_admtrkinvalidbencode","Cannot decode Tracker response. Invalid encoding");
define("_admtrkdata","Decoding completed. Here is all the Scrape data obtained");
define("_admtrksummarystr","Found <b>**seed**</b> seeds, <b>**leechers**</b> leechers, <b>**completed**</b> completed downloads for Torrent **name** Info Hash **hash**.");
define("_admbannewtracker","Blacklist a Tracker");
define("_admbannewtrackerintro","Insert the Announce URL of the Tracker you want to blacklist. All Torrents associated to it will be refused during upload.");

#TORRENTCLINIC
define("_admclinicintro","TorrentClinic&trade; allows you to check .torrent file properties.<br />
If you are having trouble with a Torrent you can verify it has been generated correctly, or you can simply look inside it.<br />
Uploading a Torrent from your hard drive you will be able to verify all information that it contains and even check against sources!");
define("_admclinicshowxml","Show Advanced XML Structures (useful for debugging)");
define("_admclinicforcescrape","Force scrape on External Torrents");
define("_admclinicdiag","Diagnostics");
define("_admclinicdecoding","Reading Torrent...");
define("_admclinicdecodeerror","Decoding Error. File is probabily not a valid torrent file.");
define("_admclinicxmlstruct","XML Structure");
define("_admclinickchkannounce","Checking against default tracker...");
define("_admclinicchkannounceerror","Default tracker is not set. Invalid Torrent file.");
define("_admclinicinvalidannounce","Invalid");
define("_admclinickchkinfo","Checking against Info dictionary...");
define("_admclinicchkinfoerror","Info dictionary is not present. Invalid Torrent file.");
define("_admclinicchkinfook","Found");
define("_admclinicchkmulti","Checking against file number...");
define("_admclinicchkmultis","Torrent contains a single file");
define("_admclinicchkmultim","Torrent contains more files");
define("_admclinicchkmultif","Torrent is not consistent!!");
define("_admclinicchkfile","File:");
define("_admchkinvalidfsize","Invalid file size. Must be numeric");
define("_admchkinvalidfilepath","Invalid file path.");
define("_admclinickchktotsize","Total size:");
define("_admclinicchkplen","Checking against Piece Length...");
define("_admclinicchkplenmissing","Piece Length missing. Invalid Torrent!");
define("_admclinicchkpieces","Checking against pieces...");
define("_admclinicchkpiecesok","Data is valid!");
define("_admclinicchkpiecesfail","Data is invalid!");
define("_admclinicchkpiecesmissing","Data is missing!");
define("_admclinicchkbasic","This Torrent is valid and has passed basic tests.");
define("_admclinicchkadvanced","Going through advanced tests...");
define("_admclinicdht","Checking against DHT Support in Azureus...");
define("_admclinicannouncelist","Checking against Multiple Trackers...");
define("_admclinicsupported","Supported");
define("_admclinicnotsupported","Not Supported");
define("_admclinicscraping","Querying Tracker...");
define("_admclinicscrapefail","It looks like this Torrent is not registered with the External Tracker");

#IRC
define("_admircintro","Configure phpMyBitTorrent's built-in IRC Chat.
You may configure every aspect of the PJIRC client: please read PJIRC's documentation before editing advanced parameters.<br />
<b>NOTICE</b>: file <i>include/irc.ini</i> MUST be writable");
define("_admircserver","Server");
define("_admircchannel","Channel");
define("_admircadvsettings","Here you can configure PJIRC's advanced settings. According to PJIRC documentation, insert the parameters with the following syntax:<br />
<i>name</i> = </i>value</i>");
define("_admircedit","Apply settings");
define("_admircenable","Enable IRC");
define("_admircdisable","Disable IRC");
define("_admirccantdelete","Cannot delete <i>include/irc.ini</i> because it's write-protected. Please delete the file manually. IRC Chat is still enabled!");
define("_admircinvalidhost","Invalid hostname or IP address");
define("_admircinvalidchannel","Invalid channel name");
define("_admircinvalidadvanced","Invalid syntax for advanced parameters");
define("_admirccantsave","Cannot save <i>include/irc.ini</i> because it's write-protected. Please save the file manually with the following content:");

#UPDATE
define("_admupdintro","phpMyBitTorrent is now trying to check for a newer version. The server must be capable of opening HTTP connections.");
define("_admupderror","Error: unable to connect.");
define("_admupdcurver","Current phpMyBitTorrent version is");
define("_admupdlastver","Last phpMyBitTorrent version is");
define("_admupdupdate","Please consider updating to the latest version.");
define("_admupdnoupdate","There is no need to update phpMyBitTorrent. Thank you.");

#USER MANAGER
define("_admuserintro","Manage registered users by editing their profile, setting their level or banning them.");
define("_admusersearchbtn","Search user");
define("_admuserlastlogin","Last seen");
define("_admuserlastip","Last IP");
define("_admuserviewprofile","View profile");
define("_admusereditprofile","Edit profile");
define("_admuserdelete","Delete user");
define("_admuserban","Ban user");
define("_admuserunban","Unban user");
define("_admusermailsearchbtn","Search E-Mail");
define("_admuserusername","User");
define("_admuseremail","E-Mail");
define("_admuserregistered","Registered");
define("_admuseripsearchbtn","Search IP");
define("_admuserhostsearchbtn","Search Host");

#DONATIONS
define("_admpdonations","Donations");
define("_admppaypal_email","PayPal E-Mail");
define("_admppaypal_emailexplain","The E-Mail address used with your Paypal-Account. Donations to this account will update the progress bar in the Donations Block on the front page. Log on to your PayPal account, go to My Account>Profile>Instant Payment Notification Preferences, and set the url there to $siteurl/paypal.php");

define("_admpsitecost","Donations Goal");
define("_admpsitecostexplain","Enter a goal for your donations drive in Dollars");

define("_admpreseaved_donations","Donations Collected");
define("_admpreseaved_donationsexplain","Amount of Money you've already got. Any donations reported by PayPal will be added to this, if you fill in your data above.");

define("_admpdonatepage","Donations Page");
define("_admpdonatepageexplain","Edit your Donations Page here (i.e., the page that is linked from the Donations Block on the front page). When pasting the code for the Donate-Button from PayPal, remember to click on 'Source' in the editor first.");

define("_admpdonation_block","Donation Block");
define("_admpdonation_blockexplain","Check if you want a donations block to be shown on the main page.");

define("_admpclock","Clock Block");
define("_admpclockexplain","Select If You Want a clock Block To be shown");

define("_admpradio","Radio Block");
define("_admpradioexplain","Select If You Want a Radio Block To be shown");

define("_admpnodonate","Indicator for zero donations");
define("_admpnodonateexplain","<ul><li><b>EU</b> Displays a EURO symbol when no donations have been made yet<li><b>UK</b> Displays a British Pound symbol when no donations have been made yet<li><b>US</b>  Displays a Dollar symbol when no donations have been made yet</ul>This setting does not affect the donation currency in any way, it's purely optical.");
define("_admpnodonateopt1","EURO");
define("_admpnodonateopt2","BPD");
define("_admpnodonateopt3","USD");

#Mass messages

define("_admmassmail","Mass Mail");
define("_admmassmailall","All");
define("_admmassmessage","Mass Messages");
define("_admmassmailerror","Try Again");
define("_admmasspm","Mass PM");
define("_admmasspmlong","Mass PM to selected User Levels");
define("_admmmsendto","Mass Mail to selected User Levels");


#MASS UPLOAD
define("_admmassuploadintro","With this tool you can upload multiple Torrents at a time.
The Torrents must be in phpMyBitTorrent's subdirectory <i>massupload</i>, which should be writable (in order to delete Torrents once uploaded or duplicated).<br />
<i>Tip</i>: on UNIX systems, if you need to use a different directory for massive upload, you can change the <i>massupload</i> directory with a <i><u>symbolic link</u></i>.");
define("_admmassdirnoexist","Mass upload directory does not exist or is not readable.");
define("_admmassoptions","Search options:");
define("_admmassmaxtorrents","Max Torrents to process (prevents memory or timeout errors)");
define("_admmassautodel","Automatically delete duplicate Torrents");
define("_admmassscan","Scan");
define("_admnomasstorrents","No Torrents there.");
define("_admmasspresent","Torrent is already there.");
define("_admmassalreadyprocessed","Torrent has been been already processed");
define("_admmasscantdelete","Unable to delete duplicate Torrents. Please delete them manually or check directory permissions (must be writable).");
define("_admmassscrapelater","Skips external tracker check. This option skips the check of external tracker sources until the next automatic update.<br />Useful to process large amounts of Torrents faster.");
define("_admmassanonupload","Anonymous upload. If unchecked, the Torrent will look like you manually uploaded it.");
define("_admmassuploaded","Torrent successfully uploaded");
define("_admmasscantdeleteuploaded","Unable to delete torrents that have been processed (whether successfully or not). Please delete them manually or check directory permissions (must be writable).");


#LOGS
define("_admlogs","Log's");
define("_admlogmall","Mark All");
define("_admlogumall","Unmark all");
define("_admlles0","All entries");
define("_admlles1","1 day");
define("_admlles2","7 days");
define("_admlles3","2 weeks");
define("_admlles4","1 month");
define("_admlles5","3 months");
define("_admlles6","6 months");
define("_admlles7","1 year");
define("_admlasc","Ascending");
define("_admldsc","Descending");
define("_admdeleall","Deleteall");
define("_admdellogsal","Delete all");
define("_admdisxpl","Display entries from previous: &nbsp;");
define("_admdodleal","Are you sure you want to Delete all log's ?");
define("_admdellogsse","Delete selected");
define("_admdodlese","Are you sure you want to Delete selected log's ?");
define("_admselcclear","Selected Log's have been cleared");
define("_admallclear","Log's have been cleared");

#style Editor
define("_admedt","Template");
define("_admedtp","Edit Template");
define("_admedtpexp","Here you can edit your template set directly. Please remember that these edits are permanent and cannot be undone once submitted. If PHP can write to the template files in your styles directory any changes here will be written directly to those files. If PHP cannot write to those files they will be copied into the database and all changes will only be reflected there. Please take care when editing your template set, remember to close all replacement variable terms {XXXX} and conditional statements.");
define("_admtmpslct","Selected Template: ");
define("_admtmpslctf","Select Template Folder");
define("SELECTED_TEMPLATE_FILE","Selected template file");
define("SELECT_TEMPLATE","Select template file");
define("SELECT_FOLDER","Theme folder");
define("TEMPLATE_EDITOR_HEIGHT","Template editor height");
define("TEMPLATE_EDITOR","Raw HTML template editor");
define("ACP_TEMPLATES_EXPLAIN","A template set comprises all the markup used to generate the layout of your board. Here you can edit existing template sets and preview sets.");
define("_admteditor","Theme Editor");
#Torrent Cient ban
define("_admnoclient","Client not set");
define("_admnobannedclient","No Banned Clients at this time");
define("_admclientban","Client Ban");
define("_adminclient","Client");
define("_adminclientre","Reason");
define("_admbanclientexp","This is Where you can ban Torrent Client!<br />You can ban eather the hole client or one version of the Client <br />To add  client you well need the pier_id info from the Client You well use such as With<br /> &micro;Torrent 1.8.1 You would add UT1810.<br />The reason for the Ban well be shown in the client So you well want to keep this short.");
#Bonus System
define("_admbonsetting","Bounce Settings");
define("_admbonalo","Allow Bonus");
define("_admbononof","Bonus On/Off");
define("_admbononofexp","This well Turn on Or Off Bonus System.");
define("_admbonup","Upload");
define("_admbonupex","This is the amount a user well get<br />for Uploading a torrent.");
define("_admbonupext","Upload Bonus");
define("_admbonco","Comments");
define("_admboncoex","This is the amount a user well get<br />for making a torrent comment.");
define("_admboncoext","Comment Bonus");
define("_admbonoffer","Offers");
define("_admbonofferex","This is the amount a user well get<br />for making a torrent Offer.");
define("_admbonofferext","Offer Bonus");
define("_admbonseed","Seeding");
define("_admbonseedex","This is the amount a user well get<br />for Seeding a torrent.<br />This setting works with Auto Clean Timer in settings");
define("_admbonseedext","Seeding Bonus");
define("_admbonseedtor","Give Bonus for Each Torrent");
define("_admbonseedtorex","If active Users well get a bonus for each torrent that they are seeding<br />If not they well only get a single bonus no matter how many torrents they seed");
define("_admbonseedtorext","Bonus For Each/All Torrents");
define("_admbonreq","Request Fill");
define("_admbonreqex","This is the amount a user well get<br />for Uploading a Torrent That was requested. This is ontop of the Uploading Bonus");
define("_admbonreqext","Filling Request Bonus");
define("_admbonbongo","Edit Bonus!");
#Level System
define("_adm_level_table","Admin Levels");
define("_adm_level_table_details","Viewing Level Details");
#FAQS
define("_adm_faq_sectile","Section/Item Title");
define("_adm_faq_hidden","Hidden");
define("_adm_faq_updated","Updated");
define("_adm_faq_new","New");
define("_adm_faq_norm","Normal");
define("_adm_faq_tile","Item Title");
define("_adm_faq_additem","Add new item");
define("_adm_faq_addsection","Add new section");
define("_adm_faq_orphen","Orphaned Items");
define("_adm_faq_order","Reorder");
define("_adm_faq_order_no_match","When the position numbers don't reflect the position in the table, it means the order id is bigger than the total number of sections/items and you should check all the order id's in the table and click \"reorder\"\n");
define("","");
define("","");
define("","");
define("","");
?>