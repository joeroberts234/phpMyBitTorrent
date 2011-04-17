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
header("Content-Type: text/html; charset=utf-8");
		$save_changes	= (isset($_POST['save'])) ? true : false;
		if ($save_changes && $template_file)
		{
			// Get the filesystem location of the current file
			$file = "themes/".$template_folder.'/'.$template_file;
			//die(stripslashes($template_data));
			$additional = '';

			// If the template is stored on the filesystem try to write the file else store it in the database
			if (file_exists($file) && @is_writable($file))
			{
				if (!($fp = @fopen($file, 'wb')))
				{
					bterror("No Such File");
				}
				fwrite($fp, stripslashes($template_data));
				fclose($fp);
			}else{
			bterror("File Not Writeable");
			}
			}
if(!isset($where))$what = '';
else
$where = $where;
if(!isset($template_folder))
{
$where = '';
$page = "template_folder";
}else{
$where = $template_folder;
$page = "template_file";
$filetype = '';
}
function file_extension($filename)
{
return end(explode(".", $filename));
}if(isset($template_file))$filetype = file_extension($template_file);
$path = "themes/".$where;
$option = '';
// Open the folder
$dir_handle = @opendir($path) or die("Cannot open the damn file $path");
$option = "<select id=\"".$page."\" name=\"".$page."\" onchange=\"if (this.options[this.selectedIndex].value != '') this.form.submit();\">";
// Loop through the files
while ($file = readdir($dir_handle)) {
        $thememaindir = "themes";
                if (is_dir($thememaindir."/".$file) AND $file != "." AND $file != ".." AND $file != "CVS")
                        $option .= "<option value=\"".$file."\">".$file."</option>";
                if (eregi("\.php$",$file) OR eregi("\.css$",$file) AND strtolower($file) != "mailtexts.php")
                        $option .= "<option value=\"".$file."\">".$file."</option>";

}
$option .="</select>";
// Close
closedir($dir_handle); 
function get_url_contents($url){
        $crl = curl_init();
        $timeout = 5;
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($crl);
        curl_close($crl);
        return $ret;
}
			if (file_exists($file) && @is_writable($file))
			{
				if (!($fp = @fopen($file, 'wb')))
				{
					trigger_error($user->lang['NO_TEMPLATE'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
				fwrite($fp, $template_data);
				fclose($fp);
			}
    $url = $path."/$template_file";

				if (!($fp = @fopen($url, 'r')))
				{
					trigger_error("Could not open {$phpbb_root_path}styles/$template_path$pathfile$file", E_USER_ERROR);
				}
				$template_data = fread($fp, filesize($url));
				fclose($fp);
?>
<script type="text/javascript" defer="defer">
		// <![CDATA[

			function change_editor_height(height)
			{
				height = Number(height);

				if (isNaN(height))
				{
					return;
				}

				editor = document.getElementById('template_data');
				editor.rows = Math.max(5, Math.min(height, 999));

				append_text_rows('acp_styles', height);
				append_text_rows('acp_template', height);
			}

			function append_text_rows(form_name, value)
			{
				value = Number(value);

				if (isNaN(value))
				{
					return;
				}

				url = document.getElementById(form_name).action;

				// Make sure &amp; is actually... &
				url = url.replace(/&amp;/g, '&');

				var_start = url.indexOf('&text_rows=');
				if (var_start == -1)
				{
					document.getElementById(form_name).action = url + "&text_rows=" + value;
				}
				else
				{
					url_start = url.substring(0, var_start + 1);
					var_end = url.substring(var_start + 1).indexOf('&');
					if (var_end == -1)
					{
						document.getElementById(form_name).action = url_start + "text_rows=" + value;
					}
					else
					{
						document.getElementById(form_name).action = url_start + url.substring(var_end + var_start + 2) + "&text_rows=" + value;
					}
				}
			}

		// ]]>
		</script>
	<script language="Javascript" type="text/javascript" src="<?php echo $siteurl; ?>/edit_area/edit_area_full.js"></script>
	<script language="Javascript" type="text/javascript">
		// initialisation
		var id='';
		editAreaLoader.init({
			id: "template_data"	// id of the textarea to transform		
			,start_highlight: true	// if start with highlight
			,allow_resize: "both"
			,allow_toggle: true
			,language: "en"
			,syntax: "<? echo $filetype; ?>"	
		});
		
		
		
		// callback functions
		function my_save(id, content){
			alert("Here is the content of the EditArea '"+ id +"' as received by the save callback function:\n"+content);
		}
		
		function my_load(id){
			editAreaLoader.setValue(id, "The content is loaded from the load_callback function into EditArea");
		}
		
		function test_setSelectionRange(id){
			editAreaLoader.setSelectionRange(id, 100, 150);
		}
		
		function test_getSelectionRange(id){
			var sel =editAreaLoader.getSelectionRange(id);
			alert("start: "+sel["start"]+"\nend: "+sel["end"]); 
		}
		
		function test_setSelectedText(id){
			text= "[REPLACED SELECTION]"; 
			editAreaLoader.setSelectedText(id, text);
		}
		
		function test_getSelectedText(id){
			alert(editAreaLoader.getSelectedText(id)); 
		}
		
		function editAreaLoaded(id){
			if(id=="example_2")
			{
				open_file1();
				open_file2();
			}
		}
		
		function open_file1()
		{
			var new_file= {id: "to\\ é # € to", text: "$authors= array();\n$news= array();", syntax: 'php', title: 'beautiful title'};
			editAreaLoader.openFile('example_2', new_file);
		}
		
		function open_file2()
		{
			var new_file= {id: "Filename", text: "<a href=\"toto\">\n\tbouh\n</a>\n<!-- it's a comment -->", syntax: 'html'};
			editAreaLoader.openFile('example_2', new_file);
		}
		
		function close_file1()
		{
			editAreaLoader.closeFile('example_2', "to\\ é # € to");
		}
		
		function toogle_editable(id)
		{
			editAreaLoader.execCommand(id, 'set_editable', !editAreaLoader.execCommand(id, 'is_editable'));
		}
	
	</script>
<? 
OpenTable(_admedt);
if(!isset($template_folder)){
echo"<div>";
	echo "<h1>"._admedt."</h1>

	<p>".ACP_TEMPLATES_EXPLAIN."</p>


	<form id=\"acp_styles\" method=\"post\" action=\"./admin.php?text_rows=20\">";
	echo"<input name=\"op\" value=\"edittheme\" type=\"hidden\">";
		echo "<fieldset>
		<legend>"._admtmpslctf."</legend>
	<dl>
		<dt><label for=\"template_file\">".SELECT_FOLDER.":</label></dt>
		<dd>".$option."<input class=\"button2\" value=\"".SELECT_TEMPLATE."\" type=\"submit\"></dd>
	</dl>
	</fieldset>
		</form>

	</div>";
	}
if(isset($template_folder)){
echo"<div>";
	echo "<h1>"._admedtp."</h1>

	<p>"._admedtpexp."</p>";
    echo "	<p>"._admtmpslct."<strong>".$template_folder."</strong></p>";
	echo"<form id=\"acp_styles\" method=\"post\" action=\"./admin.php?text_rows=20\">";
	echo"<input name=\"op\" value=\"edittheme\" type=\"hidden\">";
	echo"<input name=\"template_folder\" value=\"".$template_folder."\" type=\"hidden\">";
		echo "<fieldset>
		<legend>".SELECT_TEMPLATE."</legend>
	<dl>
		<dt><label for=\"template_file\">Template file:</label></dt>
		<dd>".$option."<input class=\"button2\" value=\"".SELECT_TEMPLATE."\" type=\"submit\"></dd>
	</dl>
	</fieldset>
		</form>

	</div>";
}
if(isset($template_file))
{
	echo"<form name=\"editor\" id=\"acp_template\" method=\"post\" action=\"./admin.php\">
	<input name=\"op\" value=\"edittheme\" type=\"hidden\">

		<fieldset>
			<legend>".TEMPLATE_EDITOR."</legend>
				<dl>
			<dt><label>".SELECTED_TEMPLATE_FILE.":</label></dt>
			<dd>".$template_folder.'/'.$template_file."</dd>
		</dl>

				<dl>
			<dt><label for=\"text_rows\">".TEMPLATE_EDITOR_HEIGHT.":</label></dt>
			<dd><input id=\"text_rows\" maxlength=\"3\" value=\"".$text_rows."\" type=\"text\"> <input class=\"button2\" name=\"update\" onclick=\"change_editor_height(this.form.text_rows.value);\" value=\"Update\" type=\"button\"></dd>
		</dl>
		<textarea id=\"template_data\" name=\"template_data\"  style=\"font-family: 'Courier New',monospace; font-size: 9pt; line-height: 125%; width: 100%;\" cols=\"80\" rows=\"20\">".$template_data."</textarea>
		<p>Custom controls:<br />
			<input type='button' onclick='alert(editAreaLoader.getValue(\"template_data\"));' value='get value' />
			<input type='button' onclick='editAreaLoader.setValue(\"template_data\", \"new_value\");' value='set value' />
			<input type='button' onclick='test_getSelectionRange(\"template_data\");' value='getSelectionRange' />
			<input type='button' onclick='test_setSelectionRange(\"template_data\");' value='setSelectionRange' />
			<input type='button' onclick='test_getSelectedText(\"template_data\");' value='getSelectedText' />
			<input type='button' onclick='test_setSelectedText(\"template_data\");' value='setSelectedText' />
			<input type='button' onclick='editAreaLoader.insertTags(\"template_data\", \"[OPEN]\", \"[CLOSE]\");' value='insertTags' />
			<input type='button' onclick='toogle_editable(\"template_data\");' value='Toggle readonly mode' />
		</p>
		</fieldset>

		<fieldset class=\"submit-buttons\">

			<legend>Submit</legend>
			<input name=\"template_folder\" value=\"".$template_folder."\" type=\"hidden\">
			<input name=\"template_file\" value=\"".$template_file."\" type=\"hidden\">
			<input class=\"button1\" id=\"save\" name=\"save\" value=\"Submit\" type=\"submit\">
		</fieldset>
		</form>";
}
CloseTable();
?>