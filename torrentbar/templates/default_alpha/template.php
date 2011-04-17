<?
$location = dirname(__FILE__);
if (($location[strlen($location)-1] != "/") && ($location[strlen($location)-1] != "\\")) {
	$location .= "/";
}

$torrentbar->legacy_initFont($location . 'fonts/visitor_rus');
$torrentbar->createBaseLayer($location . 'images/baselayer.png');

if (! $use_binary_prefixes) {
	$torrentbar->changeSystem(TorrentBar::csSI);
} else {
	if ($binary_i_with_point) {
		
		$torrentbar->changePostfixName('kib', 'K' . chr(127) . 'B');
		$torrentbar->changePostfixName('mib', 'M' . chr(127) . 'B');
		$torrentbar->changePostfixName('gib', 'G' . chr(127) . 'B');
		$torrentbar->changePostfixName('tib', 'T' . chr(127) . 'B');
		$torrentbar->changePostfixName('pib', 'P' . chr(127) . 'B');
		$torrentbar->changePostfixName('eib', 'E' . chr(127) . 'B');
		$torrentbar->changePostfixName('zib', 'Z' . chr(127) . 'B');
		$torrentbar->changePostfixName('yib', 'Y' . chr(127) . 'B');
	}
}

if ($space_width > 0) {
	trck_BF_setLetterWidth($torrentbar->font, " ", $space_width);
}

$torrentbar->drawText(6, 4, 'Ratio:');
$torrentbar->drawRating(37, 4);

$torrentbar->drawText(93, 4, 'U:');
$torrentbar->drawUpload(104, 4);

$torrentbar->drawText(187, 4, 'D:');
$torrentbar->drawDownload(198, 4);



$torrentbar->drawLayer($location . 'images/layer01.png');

?>