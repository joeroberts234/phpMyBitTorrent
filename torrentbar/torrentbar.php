<?
//
// Author: TracKer
// E-Mail: tracker2k@gmail.com
// Version 0.3 (Major.Minor.Revision)
//
// Copyright (C) 2006-2008  TracKer
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
//
// See doc/copying.txt for details
//
//===========================================================================
// Info
//===========================================================================
//
// [IN]
//   userid - ID of user in TorrentPier forum
//
// [OUT]
//   PNG file
//
// [Example]
//   (Without .htaccess)
//     http://127.0.0.1/torrentbar/torrentbar.php/USERID.png
//   or
//     http://127.0.0.1/torrentbar/torrentbar.php?id=USERID
//   
//   (With .htaccess)
//     http://127.0.0.1/torrentbar/USERID.png
//
//===========================================================================
// Presets
//===========================================================================

// Database Presets
$torrentpier_config_path = "../include/configdata.php";

// Template Presrts
$template_background = "./template/bg.png";
$template_reflection = "./template/ref.png";

$use_binary_prefixes = true;
// true - Use Binary prefixes (KiB, MiB, etc)
// false - Use SI prefixes (KB, MB, etc)

$binary_i_with_point = true;
// true - Use "i" letter with point on top
// false - Use standard "i" letter

$space_width = 0;
// 0 - Standard
// 1, 2, 3 ... - In Pixels

//===========================================================================
// Funtions
//===========================================================================

function getParam() {
	$res = 0;
	if (array_key_exists("id", $_REQUEST)) {
		$res = intval($_REQUEST["id"]);
	} else {
		$res = preg_replace("#(.*)\/(.*)\.png#i", "$2", $_SERVER['REQUEST_URI']);
		$res = intval(trim(substr(trim($res), 0, 10)));
		//if (! is_numeric($res)) { $res=0; }
	}
	return $res;
}

function getStyle() {
	$allowed_letters = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM_";
	$max_length = 128;
	
	$res = 'default';
	if (array_key_exists("style", $_REQUEST)) {
		$s = substr($_REQUEST["style"], 0, $max_length);
		
		$allowed = true;
		for ($i = 0; $i < strlen($s); $i++) {
			$p = strpos($allowed_letters, $s[$i]);
			if ($p === false) {
				$allowed = false;
				break;			
			}
		}
		
		if ($allowed) {
			$res = $s;
		}
	}

	return $res;
}

function trck_BF_Load($name) {
	$res = 0;
	
	$ini = parse_ini_file($name.".ini");
	$font = imagecreatefrompng($name.".png");
	
	if (($ini) && ($font)) {
		$res = array();
		$res["font"] = $font;
		$res["params"] = $ini;
	}
	
	return $res;
}

function trck_BF_Unload($font) {
	@imagedestroy($font["font"]);
	unset($font["font"]);
	unset($font["params"]);
}

function trck_BF_LetterWidth($font, $letter) {
	$res = 0;
	if (strlen($letter) == 0) {
		return $res;
	}
	if (strlen($letter) == 1) {
		$ch = $letter;
	} else {
		$ch = $letter[0];
	}
	
	$ascii = ord($ch);
	$res = $font["params"][$ascii."_w"];
	return $res;
}

function trck_BF_setLetterWidth(&$font, $letter, $width) {
	//$res = 0;
	if (strlen($letter) == 0) {
		return 0;
	}
	if (strlen($letter) == 1) {
		$ch = $letter;
	} else {
		$ch = $letter[0];
	}
	
	$ascii = ord($ch);
	$font["params"][$ascii."_w"] = $width;
	//return $res;
}

function trck_BF_TextWidth($font, $text) {
	$res = 0;
	
	if (strlen($text) > 0) {
		for ($i = 0; $i < strlen($text); $i++) {
			$res += trck_BF_LetterWidth($font, $text[$i]);
		}
	}
	
	return $res;
}

function trck_BF_TextHeight($font) {
	return imagesy($font["font"]);
}

function trck_BF_DrawText($im, $x, $y, $font, $text) {
	if (strlen($text) == 0) {
		return true;
	}
	
	$xc = $x;
	$yc = $y;
	
	for ($i = 0; $i < strlen($text); $i++) {
		$ascii = ord($text[$i]);
		$sx = $font["params"][$ascii."_x"];
		imagecopy($im, $font["font"], $xc, $yc, $sx, 0, trck_BF_LetterWidth($font, $text[$i]), trck_BF_TextHeight($font));
		$xc += trck_BF_LetterWidth($font, $text[$i]);
	}
}

function trck_BF_DrawStroke($im, $text_color, $stroke_color) {
	for($y=0; $y<imagesy($im); $y++) {
		for($x=0; $x<imagesx($im); $x++) {
			$color = imagecolorat($im, $x, $y);
				
			if ($color==$text_color) {
				__trck_BF_drawstroke($im, $x, $y, $text_color, $stroke_color);
			}
		}
	}
}

function __trck_BF_drawstroke($im, $x, $y, $ct, $cs) {
	$im_x2 = imagesx($im)-1;
	$im_y2 = imagesy($im)-1;
	
	$res = false;
	
	$sy = $y-1; if ($sy<0) { $sy=0; }
	while (($sy<=$y+1) && (! $res)) {
		$sx = $x-1; if ($sx<0) { $sx=0; }
		while (($sx<=$x+1) && (! $res)) {
			if ((($sy>=0) && ($sy<=$im_y2)) && (($sx>=0) && ($sx<=$im_x2))) {
				$color = imagecolorat($im, $sx, $sy);
				if (($color!=$ct) && ($color!=$cs)) {
					imagesetpixel($im, $sx, $sy, $cs);
				}
			}
			$sx++;
		}
		$sy++;
	}
}

function trck_BF_CreateTextWithStroke($font, $text) {
	$im = @imagecreatetruecolor(trck_BF_TextWidth($font, $text)+2, trck_BF_TextHeight($font)+2);
	if (! $im) {
		return 0;
	}
	
	imagesavealpha($im, true);
	imagealphablending($im, false);
	$bgalpha_color = imagecolorallocatealpha($im, 0, 0, 0, 127);
	$text_color = imagecolorallocate($im, 255, 255, 255);
	$stroke_color = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, imagesx($im)-1, imagesy($im)-1, $bgalpha_color); 
	
	trck_BF_DrawText($im, 1, 1, $font, $text);
	trck_BF_DrawStroke($im, $text_color, $stroke_color);
	
	return $im;
}


class TorrentBar {
	
	public $img = null;
	public $font = null;
	
	private $userID;
	private $data = array();
	
	const csBinary = 1;
	const csSI = 2;
	
	private $system = TorrentBar::csBinary;

	public $systems_data = array (
		TorrentBar::csSI => array(
			'b'  => array( 'name'=>'B',   'val'=>1),
			'kb' => array( 'name'=>'KB',  'val'=>1000),
			'mb' => array( 'name'=>'MB',  'val'=>1000000),
			'gb' => array( 'name'=>'GB',  'val'=>1000000000),
			'tb' => array( 'name'=>'TB',  'val'=>1000000000000),
			'pb' => array( 'name'=>'PB',  'val'=>1000000000000000),
			'eb' => array( 'name'=>'EB',  'val'=>1000000000000000000),
			'zb' => array( 'name'=>'ZB',  'val'=>1000000000000000000000),
			'yb' => array( 'name'=>'YB',  'val'=>1000000000000000000000000)
		),
	
		TorrentBar::csBinary => array(
			'b'   => array( 'name'=>'B',   'val'=>1),
			'kib' => array( 'name'=>'KiB', 'val'=>1024),
			'mib' => array( 'name'=>'MiB', 'val'=>1048576),
			'gib' => array( 'name'=>'GiB', 'val'=>1073741824),
			'tib' => array( 'name'=>'TiB', 'val'=>1099511627776),
			'pib' => array( 'name'=>'PiB', 'val'=>1125899906842624),
			'eib' => array( 'name'=>'EiB', 'val'=>1152921504606846976),
			'zib' => array( 'name'=>'ZiB', 'val'=>1180591620717411303424),
			'yib' => array( 'name'=>'YiB', 'val'=>1208925819614629174706176)
		)
	);
	
	public function __construct($user_id, $path_to_baselayerImage = '') {
		
		if ($path_to_baselayerImage != '') {
			$this->createBaseLayer($path_to_baselayerImage);			
		}
		
		if ($user_id <= 0) {
			
			$this->throwException(__FUNCTION__, 1,  'user_id <= 0'); 
		}
		$this->userID = $user_id;
		$this->getInfo();
		
	}
	
	public function changeSystem($system) {
		$this->system = $system;
	}
	
	public function createBaseLayer($path_to_baselayerImage) {
		// if not exist throw exception
		$this->img = @imagecreatefrompng($path_to_baselayerImage) or $this->throwException(__FUNCTION__, 2,  'Can\'t create base layer image');
		//imageAlphaBlending($this->img, true);
		imageSaveAlpha($this->img, true);
	}
	
	public function drawLayer($path_to_layerImage, $x = 0, $y = 0) {
		$layer = @imagecreatefrompng($path_to_layerImage) or $this->throwException(__FUNCTION__, 3,  'Can\'t create layer image');
		@imagecopy($this->img, $layer, $x, $y, 0, 0, imagesx($layer), imagesy($layer)) or $this->throwException(__FUNCTION__, 4,  'Can\'t copy layer image to base layer image');
		@imagedestroy($layer) or $this->throwException(__FUNCTION__, 5,  'Can\'t destroy temporary layer image');
	}
	
	public function legacy_initFont($path_to_font) {
		$this->font = trck_BF_Load($path_to_font);
	}
	
	private function getInfo() {
		global $db_prefix;
		$this->mysql_init();
		
		$query = "SELECT count(id) FROM " . $db_prefix . "_users WHERE id = " . $this->userID;
	    $result = @mysql_query($query) or $this->throwException(__FUNCTION__, 6,  'Can\'t select data');
    	$counter = @mysql_result($result, 0) or $this->throwException(__FUNCTION__, 7,  'Can\'t get result data');
	    mysql_free_result($result);
    	
	    if ($counter > 0) {
    		$query = "SELECT uploaded, downloaded, seedbonus FROM " . $db_prefix . "_users WHERE id = " . $this->userID;
        	$result = mysql_query($query) or $this->throwException(__FUNCTION__, 8,  'Can\'t select data');
	        
    	    while ($data = mysql_fetch_array($result))
    		{
            	$this->data['upload_counter'] = $data['uploaded'];
	            $this->data['download_counter'] = $data['downloaded'];
    	        $this->data['release_counter'] = $data['u_up_release'];
        	    $this->data['bonus_counter'] = $data['seedbonus'];
        	    $this->data['rating_counter'] = 0;
            	if ($this->data['download_counter'] > 0) {
	            	$this->data['rating_counter'] = ($this->data['upload_counter'] +
	            									 $this->data['bonus_counter'] +
	            									 $this->data['release_counter']) /
	            									 $this->data['download_counter'];
    	        }
        	}
    	}
			  
	}
	
	private function mysql_init() {
	global $db_host, $db_name, $db_user, $db_pass;
		
		//echo $dbhost ."<br>". $dbname ."<br>". $dbuser ."<br>". $dbpasswd;
    if ($db_pass!='') {
        $link = @mysql_connect($db_host, $db_user, $db_pass) or die("1 Cannot connect to database!"); 
    } else {
        $link = @mysql_connect($db_host, $db_user) or die("2 Cannot connect to database!"); 
    }
    mysql_select_db($db_name) or die("3 Cannot select database!");
    return $link;
	}
	
	public function getPostfixID($val) {		
		$res = 'b';
		foreach ($this->systems_data[$this->system] as $key=>$data) {
			//echo $key .'---'. $data ."!!!"; 
			if ($val >= $data['val']) {
				//return $key;
				$res = $key;
			} else {
				break;
			}
		}
		return $res;		
	}
	
	public function getPostfixName($postfix_id) {
		//echo  $this->systems_data[$this->system][$postfix_id]['name'];
		return $this->systems_data[$this->system][$postfix_id]['name'];
	}
	
	public function roundValue($val) {
		$dot_pos = strpos((string) $val, ".");
		if ($dot_pos > 0) {
    		return (string) round(substr((string) $val, 0, $dot_pos+1+2), 2);
		} else {
			return (string) $val;
		}
	}
	
	public function convertValue($val) {
		
		$postfix_id = $this->getPostfixID($val);		
		return $val / $this->systems_data[$this->system][$postfix_id]['val'];
			
	}
	
	public function drawText($x, $y, $text) {
		$img = trck_BF_CreateTextWithStroke($this->font, $text);
		@imagecopy($this->img, $img, $x, $y, 0, 0, imagesx($img), imagesy($img)) or $this->throwException(__FUNCTION__, 12,  'Can\'t copy temporary image to base layer image');
	}
	
	public function drawRating($x, $y) {
		$val = $this->roundValue($this->data['rating_counter']);
		$val = strval($val);
		$this->drawText($x, $y, $val);
	}
	
	public function drawUpload($x, $y, $draw_postfix = true) {
		
		$postfix_id = $this->getPostfixID($this->data['upload_counter']);
		$val = $this->convertValue($this->data['upload_counter']);
		$val = $this->roundValue($val);
		
		$val = strval($val);
		if ($draw_postfix) {
			$val .= " " . $this->getPostfixName($postfix_id);
		}
		$this->drawText($x, $y, $val);
	}
	
	public function drawDownload($x, $y, $draw_postfix = true) {
		
		$postfix_id = $this->getPostfixID($this->data['download_counter']);
		$val = $this->convertValue($this->data['download_counter']);
		$val = $this->roundValue($val);
		
		$val = strval($val);
		if ($draw_postfix) {
			$val .= " " . $this->getPostfixName($postfix_id);
		}
		$this->drawText($x, $y, $val);
	}
	
	public function useTemplate($template_name) {
		$allowed_letters = '1234567890QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm_';
		
		if (! file_exists('templates/' . $template_name)) {
			$this->throwException(__FUNCTION__, 13,  'Template is not exist');
		}
		
		for ($i = 0; $i < strlen($template_name); $i++) {
			$pos = strpos($allowed_letters, $template_name[$i]);
			
			if ($pos === false) {
				$this->throwException(__FUNCTION__, 14,  'Template name is not allowed');
			}
		}
		
		return 'templates/' . $template_name . '/template.php';
		
	}
	
	public function Finalize() {
		header("Content-type: image/png");// or $this->throwException(__FUNCTION__, 15,  'Can\'t send header');
		@imagepng($this->img) or $this->throwException(__FUNCTION__, 16,  'Can\'t output image');
		@imagedestroy($this->img) or $this->throwException(__FUNCTION__, 17,  'Can\'t destroy image');
		//trck_BF_Unload($this->font);
	}
	
	public function changePostfixName($postfixID, $newName) {
		 if (! isset($this->systems_data[$this->system][$postfixID])) {
		 	//throw Exception (Not exists)
		 	return null;
		 }
		 $this->systems_data[$this->system][$postfixID]['name'] = $newName;
	}
	
	private function throwException($function, $code, $message) {
		$E = new Exception('TorrentBar exception in ' . $function . ': ' . $message, $code);
		throw $E;
	}
	
}


//===========================================================================
// Main body
//===========================================================================

$user_id = getParam();
$style_id = getStyle();

define('BB_ROOT', '1');
include($torrentpier_config_path);

try {
	
	$torrentbar = new TorrentBar($user_id);
	$template = $torrentbar->useTemplate($style_id);
	include $template;
	$torrentbar->Finalize();

} catch(Exception $E) {
	echo $E->getMessage() . " (Code:" . $E->getCode() . ")";
}


?>