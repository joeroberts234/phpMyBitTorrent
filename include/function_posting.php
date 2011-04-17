<?php
/*
*-----------------------------phpMyBitTorrent V 2.0.5--------------------------*
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
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: funtion_posting.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
function add_attach($form_name, $forum_id, $local = false, $local_storage = '', $is_message = false, $local_filedata = false)
{
	global $db_prefix, $user, $db, $siteurl, $attach_config;
	include_once('language/attachment/english.php');
	include_once('include/function_attach.php');
	$filedata = array(
		'error'	=> array()
	);
	$upload = new fileupload();
	if (!$local)
	{
		$filedata['post_attach'] = ($upload->is_valid($form_name)) ? true : false;
	}
	else
	{
		$filedata['post_attach'] = true;
	}
	if (!$filedata['post_attach'])
	{
		$filedata['error'][] = NO_UPLOAD_FORM_FOUND;
		return $filedata;
	}
	$extensions = array();
$sql = 'SELECT `extension` as extension FROM `' . $db_prefix . '_extensions`'; 
$res = $db->sql_query($sql) OR btsqlerror($sql);
while ($ct_a = $db->sql_fetchrow($res))$extensions[] = $ct_a['extension'];
$upload->set_allowed_extensions($extensions);
	$file = ($local) ? $upload->local_upload($local_storage, $local_filedata) : $upload->form_upload($form_name);
	
	if ($file->init_error)
	{
		$filedata['post_attach'] = false;
		return $filedata;
	}
	$cat_id = (isset($extensions[$file->get('extension')]['display_cat'])) ? $extensions[$file->get('extension')]['display_cat'] : ATTACHMENT_CATEGORY_NONE;
	if ($cat_id == ATTACHMENT_CATEGORY_IMAGE && !$file->is_image())
	{
		$file->remove();
		bterror("Error", ATTACHED_IMAGE_NOT_IMAGE);
	}
	$filedata['thumbnail'] = ($cat_id == ATTACHMENT_CATEGORY_IMAGE && $attach_config['img_create_thumbnail']) ? 1 : 0;

	if (!$user->admin && $cat_id == ATTACHMENT_CATEGORY_IMAGE)
	{
		$file->upload->set_allowed_dimensions(0, 0, $attach_config['img_max_width'], $attach_config['img_max_height']);
	}

	if (!$user->admin && !$user->moderator)
	{
		if (!empty($extensions[$file->get('extension')]['max_filesize']))
		{
			$allowed_filesize = $extensions[$file->get('extension')]['max_filesize'];
		}
		else
		{
			$allowed_filesize = ($is_message) ? $attach_config['max_filesize_pm'] : $attach_config['max_filesize'];
		}

		$file->upload->set_max_filesize($allowed_filesize);
	}

	$file->clean_filename('unique', $user->id . '_');

	$no_image = ($cat_id == ATTACHMENT_CATEGORY_IMAGE) ? false : true;

	$file->move_file($attach_config['upload_path'], false, $no_image);

	if (sizeof($file->error))
	{
		$file->remove();
		$filedata['error'] = array_merge($filedata['error'], $file->error);
		$filedata['post_attach'] = false;

		return $filedata;
	}
	$filedata['filesize'] = $file->get('filesize');
	$filedata['mimetype'] = $file->get('mimetype');
	$filedata['extension'] = $file->get('extension');
	$filedata['physical_filename'] = $file->get('realname');
	$filedata['real_filename'] = $file->get('uploadname');
	$filedata['filetime'] = time();

	if ($attach_config['attachment_quota'])
	{
		if ($attach_config['upload_dir_size'] + $file->get('filesize') > $attach_config['attachment_quota'])
		{
			$filedata['error'][] = ATTACH_QUOTA_REACHED;
			$filedata['post_attach'] = false;

			$file->remove();

			return $filedata;
		}
	}
	if ($free_space = @disk_free_space("/" . $attach_config['upload_path']))
	{
		if ($free_space <= $file->get('filesize'))
		{
			$filedata['error'][] = ATTACH_QUOTA_REACHED;
			$filedata['post_attach'] = false;

			$file->remove();

			return $filedata;
		}
	}

	return $filedata;
}
function delete_attachments($mode, $ids, $resync = true)
{
	global $db, $attach_config, $db_prefix;
	if (is_array($ids) && sizeof($ids))
	{
		$ids = array_unique($ids);
		$ids = array_map('intval', $ids);
	}
	else
	{
		$ids = array((int) $ids);
	}

	if (!sizeof($ids))
	{
		return false;
	}

	$sql_id = ($mode == 'user') ? 'poster_id' : (($mode == 'post') ? 'post_msg_id' : (($mode == 'topic') ? 'topic_id' : 'attach_id'));

	$post_ids = $topic_ids = $physical = array();

	// Collect post and topics ids for later use
	if ($mode == 'attach' || $mode == 'user' || ($mode == 'topic' && $resync))
	{
		$sql = 'SELECT post_msg_id as post_id, topic_id, physical_filename, thumbnail, filesize
			FROM ' . ATTACHMENTS_TABLE . '
			WHERE ' . $db->sql_in_set($sql_id, $ids);
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$post_ids[] = $row['post_id'];
			$topic_ids[] = $row['topic_id'];
			$physical[] = array('filename' => $row['physical_filename'], 'thumbnail' => $row['thumbnail'], 'filesize' => $row['filesize']);
		}
		$db->sql_freeresult($result);
	}

	if ($mode == 'post')
	{
		$sql = 'SELECT topic_id, physical_filename, thumbnail, filesize
			FROM ' . ATTACHMENTS_TABLE . '
			WHERE ' . $db->sql_in_set('post_msg_id', $ids) . '
				AND in_message = 0';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$topic_ids[] = $row['topic_id'];
			$physical[] = array('filename' => $row['physical_filename'], 'thumbnail' => $row['thumbnail'], 'filesize' => $row['filesize']);
		}
		$db->sql_freeresult($result);
	}

	// Delete attachments
	$sql = 'DELETE FROM ' . ATTACHMENTS_TABLE . '
		WHERE ' . $db->sql_in_set($sql_id, $ids);
	$db->sql_query($sql);
	$num_deleted = $db->sql_affectedrows();

	if (!$num_deleted)
	{
		return 0;
	}

	// Delete attachments from filesystem
	$space_removed = $files_removed = 0;
	foreach ($physical as $file_ary)
	{
		if (_unlink($file_ary['filename'], 'file', true))
		{
			$space_removed += $file_ary['filesize'];
			$files_removed++;
		}

		if ($file_ary['thumbnail'])
		{
			_unlink($file_ary['filename'], 'thumbnail', true);
		}
	}

	if ($mode == 'topic' && !$resync)
	{
		return $num_deleted;
	}

	if ($mode == 'post')
	{
		$post_ids = $ids;
	}
	unset($ids);

	$post_ids = array_unique($post_ids);
	$topic_ids = array_unique($topic_ids);

	// Update post indicators
	if (sizeof($post_ids))
	{
		if ($mode == 'post' || $mode == 'topic')
		{
			$sql = 'UPDATE ' . POSTS_TABLE . '
				SET post_attachment = 0
				WHERE ' . $db->sql_in_set('id', $post_ids);
			$db->sql_query($sql);
		}

		if ($mode == 'user' || $mode == 'attach')
		{
			$remaining = array();

			$sql = 'SELECT post_msg_id
				FROM ' . ATTACHMENTS_TABLE . '
				WHERE ' . $db->sql_in_set('post_msg_id', $post_ids) . '
					AND in_message = 0';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$remaining[] = $row['post_msg_id'];		
			}
			$db->sql_freeresult($result);

			$unset_ids = array_diff($post_ids, $remaining);

			if (sizeof($unset_ids))
			{
				$sql = 'UPDATE ' . POSTS_TABLE . '
					SET post_attachment = 0
					WHERE ' . $db->sql_in_set('id', $unset_ids);
				$db->sql_query($sql);
			}

			$remaining = array();

			$sql = 'SELECT post_msg_id
				FROM ' . ATTACHMENTS_TABLE . '
				WHERE ' . $db->sql_in_set('post_msg_id', $post_ids) . '
					AND in_message = 1';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$remaining[] = $row['post_msg_id'];		
			}
			$db->sql_freeresult($result);

			$unset_ids = array_diff($post_ids, $remaining);

			if (sizeof($unset_ids))
			{
				$sql = 'UPDATE ' . PRIVMSGS_TABLE . '
					SET message_attachment = 0
					WHERE ' . $db->sql_in_set('id', $unset_ids);
				$db->sql_query($sql);
			}
		}
	}

	if (sizeof($topic_ids))
	{
		// Update topic indicator
		if ($mode == 'topic')
		{
			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET topic_attachment = 0
				WHERE ' . $db->sql_in_set('id', $topic_ids);
			$db->sql_query($sql);
		}

		if ($mode == 'post' || $mode == 'user' || $mode == 'attach')
		{
			$remaining = array();

			$sql = 'SELECT topic_id
				FROM ' . ATTACHMENTS_TABLE . '
				WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$remaining[] = $row['topic_id'];		
			}
			$db->sql_freeresult($result);

			$unset_ids = array_diff($topic_ids, $remaining);

			if (sizeof($unset_ids))
			{
				$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET topic_attachment = 0
					WHERE ' . $db->sql_in_set('id', $unset_ids);
				$db->sql_query($sql);
			}
		}
	}

	return $num_deleted;
}
function _unlink($filename, $mode = 'file', $entry_removed = false)
{
	global $db, $attach_config;

	// Because of copying topics or modifications a physical filename could be assigned more than once. If so, do not remove the file itself.
	$sql = 'SELECT COUNT(attach_id) AS num_entries
		FROM ' . ATTACHMENTS_TABLE . "
		WHERE physical_filename = '" . $db->sql_escape(basename($filename)) . "'";
	$result = $db->sql_query($sql);
	$num_entries = (int) $db->sql_fetchfield('num_entries');
	$db->sql_freeresult($result);

	// Do not remove file if at least one additional entry with the same name exist.
	if (($entry_removed && $num_entries > 0) || (!$entry_removed && $num_entries > 1))
	{
		return false;
	}

	$filename = ($mode == 'thumbnail') ? 'thumb_' . basename($filename) : basename($filename);
	return @unlink($attach_config['upload_path'] . '/' . $filename);
}
?>