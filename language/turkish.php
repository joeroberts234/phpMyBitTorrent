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
        return Array(0=>"Good quality and legal content",1=>"Fake or corrupted",2=>"Copyrightes",3=>"Porn content",4=>"Child-porn content",5=>"Offensive content",6=>"Content related to terroristic activities");
}
//Donations Block
define("_btdonations","Donations");
define("_btdonationsgoal","Goal:");
define("_btdonationscollected","Collected:");
define("_btdonationsprogress","Donation Progress");
define("_btdonationsdonate","DONATE");

//ERRORI SQL
define("_btsqlerror1","SQL Sorgusunu çalýþtýrmada hata oluþtu ");
define("_btsqlerror2","Hata ID: ");
define("_btsqlerror3","Hata Mesajý: ");

//NewTorrent shout
define("_btuplshout","Hi, I have just uploaded <b>**name**</b>. Enjoy it!");
define("_btnewtsh","Shout out New Torrent");
define("_btnewshex","Check Here if you would like to add a shout in the shout box about your new uploade if not then leave it unchecked!");

//TESTI CHE COMPAIONO IN INCLUDE/BITTORRENT.PHP
define("_btindex","Torrent Anasayfa");
define("_btupload","Gönder");
define("_btlogin","Giriþ");
define("_btsignup","Kayýt Ol");
define("_btpersonal","Torrent by ");
define("_btrulez","Kurallar");
define("_btforums","Forum");
define("_bthelp","Yardým");
define("_btadvinst","Ýndirmek için Bit Torrent veya Shareaza yükleyin");
define("_btaccessden","Eriþim Engellendi. Ýndirmek için <A href=\"modules.php?name=Your_Account&op=new_user\">üye</a> olmanýz gerekmektedir");
define("_btlegenda","Özellikler Yardým ve Açýklamalar****");
define("_btyourfilext","Dosyanýz, harici tracker");
define("_btexternal","Harici Tracker");
define("_btyourfile","Dosyanýz");
define("_btsticky","Evidence");
define("_btauthforreq","Yetki ver");
define("_btauthreq","Yetki Ýsteði");
define("_btdown","Download");
define("_btunknown","Bilinmeyen");
define("_btrefresh","Güncelle");
define("_btvisible","Görülebilir");

//TESTI CHE COMPAIONO IN INDEX.PHP
define("_btwelcome","BIT TORRENT'e Hoþgeldiniz");
define("_btstart","Lütfen Bit Torrent penceresini indirmeden sonra olabildiðince açýk tutunuz! Bu tüm indirmeleri hýzlandýracaktýr.<br />
Ýndirme hýzýnýzý artýrmak için, <b>ACTIVE</b> modunu kullanmayý deneyin");
define("_btsearch","Arama");
define("_btin","içinde");
define("_btalltypes","herhangi");
define("_btactivetorrents","Aktif Torrent'ler");
define("_btitm","Ölü Torrents'leri içer");
define("_btstm","sadece ölü Torrent'ler");
define("_btgo","Git!");
define("_btresfor","Bulunan sonuçlar");
define("_btnotfound","<h2>Sonuç bulunamadý!</h2>\n<p>Arama anahtar kelimelerini gözden geçirin.</p>\n");
define("_btvoidcat","<h2>Boþ!</h2>\n<p>Baþka kategori seçiniz</p>\n");
define("_btorderby","Bu sýrayla");
define("_btinsdate","Tarih girin");
define("_btname","Adý");
define("_btdim","Boyut");
define("_btnfile","Dosya sayýsý:");
define("_btevidence","Ýfade");
define("_btcomments","Yorumlar");
define("_btvote","Derece");
define("_btdownloaded","Ýndirildi");
define("_btprivacy","Gizlilik");
define("_bttotsorc","Toplam peer");
define("_btdesc","azalan");
define("_btord","artan");
define("_btnosearch","<center><h2>Ýndirmek istediðiniz dosyalar için arama yapýn</h2>Yardým gerektirdiði takdirde Forum'lara sormayý deneyin; eðer Magnet:/eD2K: linklerinden indiremiyorsanýz muhtemelen Shareaza yüklememiþsinizdir.<br>Size hatýrlatýrýz ki kurallarýmýz tüm dosyalarýn gizli olduðunu belirtir ve diðer kiþilerin kullanýmýna açanlar için de geçerlidir ve kesinlikle paylaþýmý tescilli, porno, çocuk pornosu, ýrkçýlýk, rahatsýz edici içerik ve yasalara aykýrý herþey için (ör. bomba yapým öðretimi) yasaktýr.<br>Herkes kendine ait markasýný korumak amacýyla ücretsiz dosyaadý filtreleme aracýný kullanabilir.</center>");
define("_bthelpfind","Arama Yardým");
define("_bttype","Kategoriler");
define("_bttopsource","En iyi download kaynaklarý");
define("_btnotopsource","Þu anda indirilen Torrent yok");
define("_btnotseeder_noneed","Þu anda kritik Torrent yok");
define("_btnotseeder_desc","Eðer bu dosyalardan biri sizde varsa, lütfen bekleyenler için paylaþýma açýn. Dosyayý kendi dosyanýza hedefleyin ve tekrar indirmeyi deneyin, istemciniz bunu bulacak ve ASLA dokunmayacaktýr.<br>Yardýmýnýz için herkes tarafýndan teþekkür ederiz. Günlerdir/saatlerdir bekleyen kullanýcýlar olabilir. <b>DOSYA PAYLAÞIM FELFESÝ ÝÇÝMÝZDE</b>");
define("_btnoseeder","TAM OLMAYAN gönderi kaynaðý");
define("_bthelpindex","<p><a name=\"HELP\"></a><a href='modules.php?name=$name&file=index_help'>Ýndirmek için Bit Torrent veya Shareaza yükleyin</a>");
define("_btnet","Að");
define("_btsource","Kaynaklar");
define("_btvisible","Görülebilir");
define("_bttorrent","Torrent");
define("_btview","Görülmüþ");
define("_bthits","Ýndirilmiþ");
define("_btsnatch","Tamamlanmýþ");
define("_btalternatesource","Sadece altenatif kaynaklar mevcut");
define("_bteasy","Hýzlý indirme");
define("_btmedium","Yavaþ indirme");
define("_bthard","Ýndirmesi zor");
define("_btstats","Ýstatistikler");

//TESTI CHE COMPAIONO IN DETAILS.PHP
define("_btddownloaded","Ýndirilmiþ");
define("_btdcomplete","Tamamlanmýþ");
define("_dtimeconnected","Baðlý kalýnan süre");
define("_btdidle","Beklemede");
define("_btdsuccessfully","Torrent baþarýyla gönderildi");
define("_btdsuccessfully2","Lütfen paylaþýma þimdi baþlayýn. Görülebilirlik kaynaklarýn sayýsýna baðlýdýr");
define("_btdsuccessfullye","Baþarýyla düzenlendi");
define("_btdgobackto","Sayfaya geri dön");
define("_btdwhenceyoucame","geldiðinizden beri");
define("_btdyoursearchfor","Aramanýz için");
define("_btnotorrent","Torrent bulunamadý veya yasaklandý");
define("_btdratingadded","Deðerlendirme eklendi");
define("_btdspytorrentupdate","SpyTorrent kaynaklarý güncelledi");
define("_btdspytorrentupdate1","3 saniye içinde sayfaya yönlendirileceksiniz");
define("_btdspytorrentupdate2","Birþey yanlýþ giderse, sayfaya buradan ulaþabilirsiniz");
define("_btdspytorrentupdate3","burada");
define("_btdspytorrentnoupdate","Dahili Torrent'lerden veya son taramadan 15 saniye önce SpyTorrent'i çalýþtýrmak gerekli deðildir.");
define("_btname","Adý");
define("_btdownloadas","Olarak indir");
define("_btnetwork","að");
define("_bthelpinfohash","Karýþýk Bilgi Yardým");
define("_btdescription","Açýklama");
define("_btnodead","(ölü) <b>yok</b>");
define("_btvisible","Görülebilir");
define("_btbanned","Yasaklanmýþ");
define("_btnoselected","Kategori Seçilmedi");
define("_btfiles","dosya");
define("_btago","önce");
define("_btlastseeder","Son Daðýtýcý");
define("_btlastactivity","Son Aktivite");
define("_bttypetorrent","Tür");
define("_btsize","Boyut");
define("_btminvote","Oylanmamýþ (enaz __minvotes__ oy gerekli");
define("_btonly","sadece");
define("_btnone","hiçbiri");
define("_btnovotes","Deðerlendirilmemiþ");
define("_btoo5","of 5 with");
define("_btvotestot","toplam oylama");
define("_btlogintorate","Giriþ</a> oylama için");
define("_btvot1","Çok kötü");
define("_btvot2","Ýyi deðil");
define("_btvot3","Kötü deðil");
define("_btvot4","Ýyi");
define("_btvot5","Çok Ýyi");
define("_btaddrating","oyla");
define("_btvote","Oyla!");
define("_btrating","Deðerlendir");
define("_bthelpstat","Ýstatistik Yardým");
define("_btviews","görülmüþ");
define("_bttimes","kere");
define("_btleechspeed","Leech Hýzý");
define("_bteta","ETA");
define("_btuppedby","Gönderen");
define("_btnumfiles","Dosya sayýsý");
define("_btfilelist","Dosya listesi");
define("_btlasttrackerupdate","Son tracker güncellemesi");
define("_bthidelist","Listeyi Sakla");
define("_btleechers","Tamamlanmamýþ");
define("_bthelpsource","Peer Yardým");
define("_btseeds","Tamamlanmýþ");
define("_btcommentsfortorrent","Torrent Yorumlarý");
define("_btbacktofull","Tam detaylara geri dön");
define("_btnotifyemailcom","Yorum eklendiði zaman e-posta ile haberdar edilmek için");
define("_btnotnotifyemailcom","Þu an yorumlar e-posta servisi listesi içinde yeralmaktasýnýz, eðer daha fazla e-posta ile bilgilendirilmek istemiyorsanýz");
define("_btclickhere","buraya týklayýn");
define("_btnotifyemail1s","Ýlk <b>DAÐITICI</b> eklendiði zaman e-posta ile bilgilendirilmek istiyorsanýz");
define("_btnotnotifyemail1s","Þu an daðýtýcý e-porta servisi listesi içinde yeralmaktasýnýz, eðer daha fazla e-posta ile bilgilendirilmek istemiyorsanýz");
define("_btaddcomment","Yorum Ekle");
define("_btnocommentsyet","Þu an herhangi bir yorum yok");
define("_btnotnotifyemail1s","ilk DAÐITICI eklendiði zaman e-posta ile bilgilendirilmek için");
define("_btdgavesresult","bir sonuç döndürdü");
define("_btdnotifyemaildel","Yorum bildiri listesinden çýkarýldýnýz");
define("_btdnotifyemaildel1","Yorum eklendiði zaman herhangi bir e-posta almayacaksýnýz!");
define("_btdnotifyemailadd1","Yorum eklendiði zaman e-posta ile haberdar edileceksiniz ve birdaha yorum okumadan e-posta almayacaksýnýz!");
define("_btdnotifyemailadd","Yorum bildiri listesine eklendiniz");
define("_btdnotifyadd","Daðýtýcý bildiri listesine eklendiniz");
define("_btdnotifyadd2","Yeni daðýtýcýlardan haberdar olmanýz için günde en fazla 1 e-posta alacaksýnýz!");
define("_btdnotifydel","Daðýtýcý bildiri listesinden çýkarýldýnýz ve bir daha e-posta almayacaksýnýz!");
define("_btddetails","Torrent detaylarý");
define("_bteditthistorrent","Bu Torrent'i düzenle");
define("_btyes","evet");
define("_btno","hayýr");
define("_btaddedby","Gönderen");
define("_bton","up");
define("_bthelpothersource","Alternatif Kaynaklar Yardým");
define("_btadded","Uploaded");
define("_btfilename","Dosya Adý");
define("_btpeers","Kaynaklar");
define("_btpeerstot","Toplam peer");
define("_bthelppeer","Peer Yardým");
define("_btleechers","Leecher'lar");
define("_btdhelpdownload","Dosya Ýndirme Yardým");
define("_btyourate","Oylama yaptýnýz");
define("_btupdatesource","Kaynaklarý þimdi güncelle!");
define("_btseeders","Daðýtýcýlar");
define("_btcomplyouvoted","You said this Torrent is: ");
define("_btcomplexplain","The Torrent will be banned when getting a number of complaints.");
define("_btcomplaintform","Torrent complaint form.<BR>This system, different from score rating, allows you to vote Torrents that not fit our rules.<BR>
Torrent that will get a number of complaint will be automatically banned by the system.<BR>Please send positive feedback on Torrents that are good and legal.<BR>");
define("_btcomplisay","This Torrent is ");
//Marker p means positive feedback, n means negative
define("_btcomplatthemoment","Right now users sent <b>**p**</b> positive feedbacks and <b>**n**</b> negative feedbacks<BR>");

//TESTI PRESENTI IN TAKEUPLOADURL.PHP
define("_btinseriti","Girilmiþ");
define("_btand","ve");
define("_btnumerror","sayýlarý eþit deðil ve binary assignment ile devam etmek mümkün deðil");
define("_btmaxchar","ED2K URL en fazla 200 karakter uzunluðunda olmalý");
define("_bted2kstart","URL <b>ed2k://</b> ile baþlayamaz");
define("_bt2par","URL ikinci parametreyi içermiyor: ");
define("_bturlfile","dosya");
define("_bturlcontent","URL içermiyor");
define("_btfname","dosyaadý");
define("_bturlsize","URL içermiyor");
define("_btsz","boyut");
define("_btidcode","karýþýk bilgi");
define("_bturlparerror","URL parametre içermiyor:");
define("_bturlsureerror","URL kaynak içeriyor");
define("_bturlnotinsert","ED2K Link eklenmeli");
define("_btnotip","IP tanýmlanmamýþ");
define("_btinvip","Geçersiz IP");
define("_btnoport","Herhangi bir port tanýmlanmamýþ");
define("_btinvport","Geçersiz Port");
define("_btparmag","hiçbir");
define("_btnopresent","bulunmuyor");
define("_btmagchar","MagnetURL en fazla 200 karakter uzunluðunda olmalý");
define("_bftminlimit","Bu boyuttan daha küçük dosyalarý paylaþamazsýnýz");
define("_btfmaxlimit","Torrent çok büyük dosya içeriyor");
define("_btillegalword","Dosyaadý anahtar kelimeleri yasal olmayan aktiviteleri içeriyor gibi görünüyor.");
define("_btillegalwordinfo","Portalýmýz illegal aktiviteleri engellemek için özel bir kelime filtresi kullanmaktadýr. Biliyoruz ki, eðer dosyanýz illegal kelimeler içerse bile, hala tamamen yasal olabilir. Lütfen özürlerimizi kabul edin ve dosyayý farklý bir isim altýnda gönderin.");
define("_bturlinserted1","Torrent gönderildi. 3 saniye içinde yönlendirileceksiniz.<BR>Eðer yönlendirme gerçekleþmemiþse, sayfaya buradan ulaþabilirsiniz");
define("_bturlinserted2","bu link");
define("_btnotify","Bildiri listesine eklendiniz: yeni yorumlar e-posta adresinize gönderilecektir.");
define("_btnolinkinsert","Link girilmemiþ");
define("_btexnostartwt","eXeem links start with exeem://");
define("_btillegalcat"," Illegal category!");

//TESTI PRESENTI IN UPLOAD.PHP
define("_btphotoext","Resim dosyasý GIF, JPG veya PNG uzantýlarýna sahip deðil");
define("_btalertmsg","Form bu hatalardan dolayý iþleme giremedi:");
define("_btalertmsg2","Lütfen hatalarý düzeltip tekrar göndermeyi deneyin");
define("_btfnotselected","HATA: dosya seçilmedi");
define("_btalertdesc","Lütfen dosyanýn tipini ve niteliðini belirten bir açýklama yazýn, özellikle multimedya dosyasý olduðu zaman");
define("_btalertcat","Kategori seçin");
define("_btconferma","Göndermeye hazýr mýsýnýz? Eðer Torrent birden fazla dosyadan oluþmuþsa, lütfen bütün klasörü içeren bir arþiv yaratýnýz. Eðer arþiv deðilse, kullanýlamayabilir veya indirecek kiþiye sorunlar yaratabilir.");
define("_btalerturl","MAGNET veya ED2K linki giriniz");
define("_btalerturlnum1","ED2K link numarasý");
define("_btalerturlnum2","MAGNET link numarasý þu olduðu sürece");
define("_btalerturlnum3","Torrent'ler birkaç linkten yapýlmýþsa link sayýlarý ayný olmalýdýr");
define("_btalert5char","Dosyaadý en az 5 karakter uzunluðunda olmalýdýr");
define("_btofficialurl","Bu sitenin resmi tracker'larý:");
define("_btseeded","Eðer paylaþýyorsanýz sadece Torrent'leri gönderin!!! Eþsiz bir Torrent anasayfada görülmeyecektir.");
define("_btupfile","Dosyayý gönder:");
define("_bttorrentname","Torrent adý");
define("_btfromtorrent","Alaný doldurmak için uðraþmayýn: dosyaadýndan otomatik olarak doldurulacaktýr.");
define("_btdescname","Açýklayýcý bir isim vermeye çalýþýn");
define("_btdescription","Torrent açýklamasý (gerekli)");
define("_btnohtml","HTML KULLANMADAN");
define("_btsrc_url","Kaynak URL");
define("_btcompulsory"," (Mecburi)");
define("_btchooseone","Seçiniz");
define("_bttype","Tipi");
define("_btverduplicate","Benzer Torrent'ler için kontrol ediniz");
define("_btduplicatinfo","Eðer iþaretlenmiþse ve eðer benzer Torrent bulunursa sistem gönderimi durduracaktýr. Eðer hala Torrent'i göndermek istiyorsanýz ozaman iþareti kaldýrýn. Birbirinin aynýsý Torrent'ler sadece kullanýcýnýn kafasýný karýþtýrýr, bu yüzden her ürün için bir Torrent olmasý daha iyidir.");
define("_btupevidence","Ýfade");
define("_btupevidencinfo","Bu sorumlulukla kullanýn: sadece dosyanýn halk için önemli olduðunu düþündüðünüz zaman ve saðlam daðýtým verdiðinizde kullanýn (en az bir hafta için mümkün olduðunca 24/7 olabilir...)");
define("_btowner","Sahip");
define("_btowner1","Kullanýcýyý Göster");
define("_btowner2","Gizlilik Modu");
define("_btowner3","Görünmezlik Modu");
define("_btownerinfo","'KULLANICI GÖSTER' seçeneði diðer kullanýcýlara kullanýcý adýnýzýn gösterilmesini saðlar, 'GÝZLÝLÝK MODU' kullanýcý adýnýzý saklar fakat kendi Torrent'lerinin düzenle/sil fonksiyonlarýný elde tutar, 'GÖRÜNMEZLÝK MODU' sahip olaný tamamen sisteme saklar ve herhangi bir düzenleme/sil fonksiyonu kullanýlamaz.");
define("_btupnotify","Bilgilendir");
define("_btupnotifynfo","Herhangi bir yorum eklendiði zaman e-posta ile bilgilendirileceksiniz");
define("_btfsend","Torrent Gönder");
define("_btinserte2k","ED2K Linki Giriþi");
define("_btmagnetinsert","Magnet Linki Giriþi");
define("_btinsertlinktitle","GNutella ve eDonkey2000 Aðlarý için link giriniz");
define("_btinsertlinktext","Tracker hatalarýný önlemek için Bit Torrent dosyalarýnýza eDonkey2000 linki ekleyebilirsiniz. Sahte veya elemanýmýzla ayný olmadýðý sürece linkleriniz aktif olacaktýr");
define("_btinserttext2","Sadece ya MAGNET linki yada ED2K linki ekleyebilirsiniz. Eðer her iki liste de giriþle doldurulmuþsa, tek bir dosyaya iki link atanmýþ olacaktýr: diðer bir deyiþle ilk ED2K linki ve ilk MAGNET linki ilk dosyaya atanmýþ olacaktýr, vb... Uzun dosya listeleri yaratýrsanýz daha fazla dosya indirilmeye hazýr olacaktýr: bu çok ilginç bir özelliktir, indirilenleri daha küçük parçalara ayýrdýðýndan daha kullanýþlýdýr ve Shareaza kullanmazsýnýz (bu her iki tür link için de geçerlidir).");
define("_bted2kurl","ED2K link giriniz");
define("_btsyntax","Benzer");
define("_btfiletype","uzantý");
define("_btfilesize","boyut");
define("_btidcode","infohash");
define("_btipport","ip:port");
define("_btstatic","sadece eDonkey2000 protokolü kullandýðýmýzý belirtir");
define("_btfinalname","indirilecek dosyanýn adýdýr");
define("_btfinalsize","dosyanýn byte boyutudur");
define("_btfinalidcode","benzer dosyalar içerisinden SADECE BÝR DOSYA bulmamýza olanak tanýyan özel doðrulama kodudur");
define("_btfinalipport","ana stabil kaynaðý sunar (yayýnlayýcýlar tarafýndan kullanýlýr)");
define("_btor","veya");
define("_btaddmagnet","MAGNET linki ekle");
define("_btadded2k","eD2K linki ekle");
define("_bthelpupload","Yardýma ihtiyacýnýz mý var? <a href='modules.php?name=$name&file=upload_help'>Öðretimize</a> bir bakýn");
define("_btphoto","Resim");

//TESTI CHE COMPAIONO IN ADDCOMMENT.PHP
define("_btiderror","Geçersiz ID");
define("_btnotfoundid","Torrent bulunamadý");
define("_btaddcomment","Buna yorum ekle");
define("_btaddtime","Gönderildi ");
define("_btby","tarafýndan");
define("_btsend","Gönder");

//TESTI CHE COMPAIONO IN DELETE.PHP
define("_btcannotdel","Silinemiyor!");
define("_btmissingdata","Ýstek bilgisi eksik!");
define("_btdeldenied","Bu Torrent'i sadece sahibi veya site Yöneticisi silebilir");
define("_btnotconfirmed","Ne yapýyor olduðunuzdan emin olmalýsýnýz");
define("_btdeleted","Torrent silindi");
define("_btgoback","Geri dön");


//TESTI CHE COMPAIONO IN DOWNLOAD.PHP
//LE PAROLE TRA "** **" SONO INDICATORI
define("_btantiscrocco","<p>Ýndirme hakkýnýz saklý tutmak istiyorsanýz herbiri en az **min_size** bilgi içeren diðer **min_num** Torrent'leri paylaþabilir ve en azýndan daðýtýcý olarak kalabilirsiniz. Harici tracker kullanmayý ve dosyayý buraya göndermeyi unutmayýn. Sadece YASAL dosyalarý kabul ettiðimizi ve gizlilik için GÖRÜNMEZLÝK MODU'nda olmamanýzý veya sistem sizi daðýtýcý olarak tanýmazsa dosya izinlerini yönetebileceðiniz durumda olmanýz gerektiðini size hatýrlatmak isteriz. Sadece sizin tarafýnýzdan gönderilen dosyalar daðýtým olarak sayýlacaktýr. Gereksiz ve kapýlmýþ Torrent'ler hesap iptaline sebep olabilir. Bu sunucu her saat Torrent'lerin kaynaklarýný senkronize eder, bu yüzden bazen sorunlarla karþýlaþabilirsiniz (SpyTorrent'i daðýtýlmýþ Torrent'lerde zorlamayý deneyin). Bu insanlarý paylaþýma zorlayarak topluluðun büyümesini saðlayacaktýr.</p><P>Yapabildiðiniz kadar çok Torrent daðýtmaya çalýþýn. Farklý bir kullanýcý adýyla kayýt olmayýn, çünkü IP'leri izliyoruz.
 Baðýþ yapan kiþiler TAMAMEN kýsýtlamasýz indirme özelliklerini kazanacaklardýr. Kullanýcý adýnýzý açýkça belirtmeyi unutmayýn. Torrent'lerin içeriðinden sorumlu olmadýðýmýzý ve kullanýcýlar istedikleri gibi Torrent'leri paylaþabildiklerini unutmayýn: kimin indirme yapýp yapamayacaðýna karar verebilirler. $nukeurl sadece istatistikleri tutar ve her paylaþýlan Torrent'in kontrolünü saðlayamaz fakat binlerce kiþi portalýmýzý kullanmaktan memnun olur.</p>");
define("_btnogratis","Herzaman bedava için yaþayamazsýnýz!");
define("_bttodayused","Bugün kullandýðýnýz");
define("_bttomorrow","Torrentler ve o daha fazla kullaným için mümkün görünmüyor. Yarýn yine gelin ve günlük en fazla **maxfile** Torrent kullanabileceðinizi unutmayýn.</p>");
define("_btlantoday","Bugün **ip** IP'siyle siz veya sizin aðýnýzdaki bir baþka kiþi bunu zaten kullanýyor ");
define("_btlantomorrow"," Torrentler ve o daha fazla kullaným için mümkün görünmüyor. Yarýn yine gelin ve günlük en fazla **maxfile** Torrent kullanabileceðinizi unutmayýn. LAN'larýn cezalandýrýldýðýný biliyoruz, fakat aðýn kötüye kullanýlmasýný önlemek istiyoruz.</p>");
define("_btthisweek","Zaten zaten bu kadar kullandýnýz ");
define("_btnextweek"," Torrentler ve o daha fazla kullaným için mümkün görünmüyor. Haftaya yine gelin ve haftalýk en fazla **maxfile** Torrent kullanabileceðinizi unutmayýn.</p>");
define("_btthisweeklan","Bu hafta, siz veya sizinkine benzer **ip** IP'sini kullanan biri bu kadar kullandý ");
define("_btnextweeklan"," Torrentler ve o daha fazla kullaným için mümkün görünmüyor. Haftaya yine gelin ve haftalýk en fazla **maxfile** Torrent kullanabileceðinizi unutmayýn.</p>");
define("_btmsgbody1","**nukeurl** tarafýndan BIT TORRENT üzerinden paylaþýlan dosyayý indirmek için izin istediðiniz kullanýcý isteðinizi kabul etti: ");
define("_btmsgbody2","Þu andan itibaren tüm kullanýcýlarýn dosyalarýný indirebilirisiniz. **nukeurl** gizliliðinizi korur.");
define("_btmsgsubject","BIT TORRENT için **nukeurl** tarafýndan Eriþim Yetkisi");
define("_btauthreqbody","**nukeurl** tarafýndan BIT TORRENT üzerinden paylaþtýðýnýz dosyayý görebilmek için kullanýcý **username** yetkili olmak istiyor: Yetkili yapmak için:\n\n   **nukeurl**/modules.php?name=$name&file=mytorrents&privacy=**userid**\n\n\nTüm beklemedeki izin isteklerine onay vermek için buraya týklayýn:\n\n$nukeurl/modules.php?name=$name&file=mytorrents&privacy=all\n\n\nBekleyen dosyalara indirme izni verdikten veya reddetmeden önce hiçbir e-posta almayacaksýnýz.\nÝzin isteyen kullanýcýlarý görmek için:\n\n**nukeurl**/modules.php?name=$name&file=mytorrents\n\n\n**sname** gizliliðinizi korur, özgürlükten sonra en önemli hak!");
define("_btautherrpending","Bu kullanýcý için zaten indirme izni istediniz. Kabul veya reddetmesi durumunda daha fazla indirme izni için yetki isteyemezsiniz. **tot** bekleyen yetki izni var.");
define("_bterrminseed","<li>En az <b>**min_share**</b> bilgi daðýtmalýsýnýz.<br>");
define("_btruleok","Kural Tamam");
define("_btruleko","<b>UYARI: bu kurala uymuyorsunuz</b>. ");
define("_bterrnoseeder","<b>Hiçbirþey daðýtmýyorsunuz!</b>");
define("_bterrnotenoughshare1","<b>Daðýtýyorsunuz");
define("_bterrnotenoughshare2"," bilgisi, daha fazla daðýtmalýsýnýz ");
define("_bterrtoosmall","<li>En az <b>**min_share**</b> boyutunda dosya daðýtmalýsýnýz.<br>");
define("_bterrtoobig","<b>En büyük daðýttýðýnýz dosya ");
define("_bterrmaxnumnoseed", "<li>Daðýtýcý olmadan en fazla <b>**maxfile**</b> indirme yapabilirsiniz.<br> ");
define("_bterrmaxdownloadsize","<li><b>**maxsize**</b> limitini aþtýðýnýz zaman indirme yapamazsýnýz.<br>");
define("_btfinalerrmsg1","þu andan itibaren, kullanýlan ip <b>**ip**</b> (bunu okuyan sadece sizsiniz) veya LAN'ýnýnýzdaki diðer kullanýcýlar bu site için <b>bedava</b> indirme limitini aþtý!<br>Site limitleri:<ol>");
define("_btfinalerrmsg2","</ol><b>Limitsiz</b> indirmeye devam edebilmek için aþaðýdaki kurallara uymalýsýnýz:<ol>");
define("_btfinalerrmsg3","</ol><p>Daðýtmak demek <b>100% tam bir dosyayý</b> indirme için sizin tam dosyanýzý açýkça hedef dosya olarak paylaþmanýzdýr (Bit Torrent tarafýndan dokunulmayacaktýr).<br></p><p>Ayrýca yeni Torrent'ler <a href='modules.php?name=**name**&file=upload'>GÖNDEREBÝLÝR</a> ve çalýþtýrabilirsiniz.</p><p>Yada eðer indirme pencerenizi KAPAMAMIÞSANIZ otomatik olarak daðýtýlan þimdiki indirmelerinizin bitmesini bekleyebilirsiniz.</p><p>Kurallara uyduðunuz sürece, tekrar dosya indirebilirsiniz</p>");
define("_bterrorprivate","Bu özel bir dosya: zaten indirme izni istediniz. Eðer dosyanýn sahibi henüz isteðinizi kabul etmemiþse, dosyayý indiremezsiniz.");
define("_btrefused","Dosyanýn sahibi izin isteðinizi reddetti. Bu kullanýcýya bir daha istek gönderemezsiniz.");
define("_btreqsent","Torrent sahibine indirme izni için bir e-posta gönderilmiþtir: sonuç bir e-posta ile bilginize sunulacaktýr.");

//TESTI CHE COMPAIONO IN EDIT.PHP
define("_btedittorrent","Torrent'i Düzenle \"");
define("_bterreditnoowner","<h1>Eriþim Engellendi</h1>\n<p>Sadece sahipleri veya site yöneticileri bu Torrent'i silebilir</p>\n");
define("_btbanned","Yasaklý");
define("_btcancel","Ýptal");
//define("_btdelcommand","Torrent'i düzenlemedi, fakat <input type=\"submit\" value=\"SÝLDÝ!\" />\n");
//define("_btsure","Evet: Bundan eminim!");

//TESTI CHE COMPAIONO IN MYTORRENTS.PHP
define("_btallauthorized","Tüm kullanýcýlar yetkilendirildi");
define("_btauthorized","Seçilen kullanýcýlar yetkilendirildi");
define("_bthasauthorized","Kullanýcý dosyalarýný indirmenize yetki verdi");
define("_btnowcandownload","Þimdi tüm kullanýcý dosyalarýný serbestçe indirebilirsiniz.\nGizliliðinizi koruyacaðýz.");
define("_btauthmailsubj","BIT TORRENT dosya eriþim Yetkisi");
define("_btauthorizationrequested","Bu kullanýcýlar indirme yetkisi istedi:");
define("_btnotorrents","Torrent yok");
define("_btnotorrentuploaded","Henüz bir Torrent göndermediniz");

//TESTI CHE COMPAIONO IN TAKECOMMENT.PHP
define("_btcommentkeyfound","Sistem yorumunuz kelimelerini kontrol etti. Aþaðýdaki sözcükler illegal aktivitelerle baðlantýlý olabilir:<ol>");
define("_btcommentkeyfound2","</ol><p>Yorumunuzun hala yasal olabileceðini biliyoruz, verdiðimiz rahatsýzlýk için özür dileriz ve kelimelerinizi deðiþtirmenizi rica ediyoruz. Bu otomatik bir filtrelemedir ve bazen yanlýþlýk sözkonusu olabilir.</p>");
define("_bttorrentmailbody","Merhaba, Bu mesajý almayý BIT TORRENT servisinde TORRENT **nome** hakkýnda yaptýðýnýz istekten beri alýyorsunuz\n\nBuraya týklayarak yorumunuzu görebilirsiniz:\n\n**url_site**/modules.php?name=**name**&file=details&id=**id**&viewcomm=**newid**&sn=u#comm**newid**\n\n\nGörebilmeniz için siteye giriþ yapmanýz gerekmektedir.\n\nEðer bu Torrent'i okumadýysanýz bir daha bu Torrent hakkýnda e-posta almayacaksýnýz.\n\n\nEðer bu Torrent hakkýnda bildiri almak istemiyorsanýz buraya týklayýn:\n**url_site**/modules.php?name=**name**&file=details&id=**id**&cn=n");
define("_btcommentiserted","Yorum baþarýyla girildi, Torrent sayfasýnda 3 saniye içinde yönlendirileceksiniz.<br>Sorun yaþýyorsanýz sayfaya <a href=\"modules.php?name=**name**&file=details&id=**id**&viewcomm=**newid**#comm**newid**\">buradan</a> eriþebilirsiniz");

//TESTI CHE COMPAIONO IN TAKEEDIT.PHP
define("_btmissingformdata","Kayýp veri giriþi!");
define("_bteditfailed","Düzenle yapýlamadý");
define("_bteditdenied","Diðer kiþilerin Torrent'lerini düzenleme yapýlamadý");
define("_btreturl","Dosya baþarýyla düzenlendi, 3 saniye içinde Torrent sayfasýna yönlendirileceksiniz.<br>You can reach the page from <a href=\"**returl**\">here</a> if you have troubles");

//TESTI CHE COMPAIONO IN TAKERATE.PHP
define("_btratefailed","Oylama baþarýsýz!");
define("_btinvalidrating","Geçersiz oy");
define("_btidnotorrent","Geçersiz ID. Torrent bulunamadý");
define("_btnovoteowntorrent","Kendi Torrent'lerinizi oylayamazsýnýz");
define("_btalreadyrated","Torrent zaten derecelendirilmiþ");
define("_btvotedone","Oylama baþarýlý, 3 saniye içinde Torrent sayfasýna yönlendirileceksiniz.<br>Sorun yaþýyorsanýz sayfaya <a href=\"modules.php?name=**name**&details.php&id=**id**&rated=1\">buradan</a> eriþebilirsiniz");

//TESTI CHE COMPAIONO IN TAKEUPLOAD.PHP
define("_btuploadfailed","Gönderim baþarýsýz!");
define("_btemptyfname","Boþ dosyaadý");
define("_btinvalidfname","Geçersiz dosyaadý");
define("_btfnamenotorrent","Bu bir Torrent dosyasý deðil (.torrent)");
define("_btferror","Dosya Hatasý");
define("_bterrnofileupload","Dosyada ölümcül hata.");
define("_btemptyfile","Dosya boþ");
define("_btnobenc","Dosya zarar görmüþ. Gerçekten Torrent olduðuna emin misiniz?");
define("_btnodictionary","Torrent sözlüðü bulunamadý");
define("_btdictionarymisskey","Kayýp Torrent Sözlüðü Anahtar Kelimeleri");
define("_btdictionaryinventry","Torrent Sözlüðü'nde geçersiz veri");
define("_btdictionaryinvetype","Torrent Sözlüðü'nde geçersiz veri tipleri");
define("_btinvannounce","Geçersiz Bildiri URL'si. Þöyle olmalý ");
define("_btactualannounce","Açýkça belirtilen tracker ");
define("_bttrackerdisabled","Tracker'ýmýz pasifleþtirildi, harici tracker'larýn nasýl kullanýldýðýný öðrenmek için <a href='modules.php?name=**name**&file=upload_help'>bu öðretileri</a> okuyunuz");
define("_btinvpieces","Geçersiz Torrent bölümleri");
define("_btmissinglength","Kayýp dosyalar boyutlarý");
define("_btnofilesintorrent","Kayýp Torrent dosyalarý");
define("_btfnamerror","Geçersiz dosyaadý");
define("_btfilenamerror","Dosyaadýnda hata");
define("_bttorrenttoosmall","<p>Bu boyuttan daha küçük dosya paylaþamazsýnýz <b>");
define("_bttorrenttoosmall2","</b></p><p>Torrent'iniz bu isimde dosya içeriyor <b>");
define("_btmaxuploadexceeded","Her 24 saatte bir **maxupload**'dan daha çok gönderim yapmanýz mümkün deðil.");
define("_btnumfileexceeded","<p>24 saat içinde <b>**maxupload**</b>'dan fazla dosya gönderemezsiniz.</p><p>Þu anda zaten toplam <b>**totsize**</b> boyutunda <b>**rownum**</b> dosya göndermiþsiniz");
define("_btsearchdupl","Arama sonuçlarýna göre bu dosyalar paylaþtýklarýnýzla uyuþabilir:<ol>");
define("_btduplinfo","<p>Eðer dosyanýz listedeyse, Bu Torrent'lerden birini paylaþýn!</p>");
define("_btsocktout","HATA: Socket timed-out");
define("_bttrackernotresponding","Tracker yanýt vermiyor.\n Tracker yazýmýný kontrol etmelisiniz (URL'lerde BOÞLUKLAR OLMAMALI) and çalýþtýðýna bakmalýsýnýz. Açýkça belirtilen tracker:");
define("_bttrackerdata","Harici tracker'da geçersiz bilgi. Tracker'da sunucu problemleri olabilir. Daha sonra tekrar deneyiniz.");
define("_btuploadcomplete","Baþarýyla gönderildi, dosya sayfasýna 3 saniye içinde yönlendirileceksiniz. Remember to seed it or the Torrent won't be visible on main page!<br>Sorun yaþýyorsanýz sayfaya <a href=\"**url**\">buradan</a> eriþebilirsiniz");

//TESTI CHE COMPAIONO IN TAKECOMPLAINT.PHP
define("_btcomplisnowbanned","This Torrent has been banned due to the number of complaints");
define("_btcomplcantvotetwice","We're sorry, but you can't send a complaint twice.");
define("_btcomplainttaken","Complaint registered. You are being redirected to the Torrent's page in 3 seconds. Else click on ");
define("_btcomplsuccess","Your opinion has been logged. User name and IP are logged too, do not abuse of the system.<BR>");

//eXeem
define("_btaddexeem","Add eXeem link");
define("_btsegment","segment");
define("_btexeeminsert","Insert eXeem link");
define("_btlinkstart","Link doesn't start with ");
define("_btumagneturl","Insert Magnet link");
define("_btexeemurl","Insert eXeem link");
define("_btalerturlnum4","while Magnet is");
define("_btalerturlnum5","Magnet links number is");
define("_btinserttext3","You may insert either only eXeem links or combinations of the three types. Remember there must be as many eXeem links as many other netowrks' links. If you insert 3 eXeem links and you want to insert eD2K links you must insert 3 eDonkey2000 links and they will be associated.");
define("_btalerturlnum5","Magnet link number is");
define("_btuploadurl","Send Links");
define("_btlinkmaxchar","Beyond maximum link size");
define("_btalertmsg1","The form has not been submitted due to the following errors.");
define("_btalertmsg2","Plaese correct the form and submit it again.");
define("_btconferma2","Are you ready to upload? If your package is made by more files, please include them in the same submission.");
define("_btevidenced","Sticky");
define("_btinsertlinktitle","Insert GNutella - eDonkey2000 - eXeem links");
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
