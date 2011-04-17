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

/***************************************************************************

 *                                 mysql.php

 *                            -------------------

 *   begin                : Saturday, Feb 13, 2001

 *   copyright            : (C) 2001 The phpBB Group

 *   email                : support@phpbb.com

 *

 *   $Id: mysql.php,v 1.2 2007/08/08 13:07:07 joerobe Exp $

 *

 ***************************************************************************/



/***************************************************************************

 *

 *   This program is free software; you can redistribute it and/or modify

 *   it under the terms of the GNU General Public License as published by

 *   the Free Software Foundation; either version 2 of the License, or

 *   (at your option) any later version.

 *

 ***************************************************************************/

if (eregi("mysql.php",$_SERVER["PHP_SELF"])) die("You cannot access this file directly");

if(!defined("SQL_LAYER"))

{



define("SQL_LAYER","mysql");



class sql_db

{


	   /**
	   * Current sql layer
	   */
	   var $sql_layer = '';

        var $db_connect_id;

	   var $mysql_version;

        var $query_result;

        var $row = array();

        var $rowset = array();

        var $num_queries = 0;
	var $fetchtypes = array(
		'DBARRAY_NUM'   => MYSQL_NUM,
		'DBARRAY_ASSOC' => MYSQL_ASSOC,
		'DBARRAY_BOTH'  => MYSQL_BOTH
	);
	var $functions = array(
		'connect'            => 'mysql_connect',
		'pconnect'           => 'mysql_pconnect',
		'select_db'          => 'mysql_select_db',
		'query'              => 'mysql_query',
		'query_unbuffered'   => 'mysql_unbuffered_query',
		'fetch_row'          => 'mysql_fetch_row',
		'fetch_array'        => 'mysql_fetch_array',
		'fetch_field'        => 'mysql_fetch_field',
		'free_result'        => 'mysql_free_result',
		'data_seek'          => 'mysql_data_seek',
		'error'              => 'mysql_error',
		'errno'              => 'mysql_errno',
		'affected_rows'      => 'mysql_affected_rows',
		'num_rows'           => 'mysql_num_rows',
		'num_fields'         => 'mysql_num_fields',
		'field_name'         => 'mysql_field_name',
		'insert_id'          => 'mysql_insert_id',
		'escape_string'      => 'mysql_escape_string',
		'real_escape_string' => 'mysql_real_escape_string',
		'close'              => 'mysql_close',
		'client_encoding'    => 'mysql_client_encoding',
	);



        //

        // Constructor

        //

        function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)

        {



                $this->persistency = $persistency;

                $this->user = $sqluser;

                $this->password = $sqlpassword;

                $this->server = $sqlserver;

                $this->dbname = $database;
		$this->sql_layer = 'mysql';


                if($this->persistency)

                {

                        $this->db_connect_id = @mysql_pconnect($this->server, $this->user, $this->password);

                }

                else

                {

                        $this->db_connect_id = @mysql_connect($this->server, $this->user, $this->password);

                }

                if($this->db_connect_id)

                {

                        if($database != "")

                        {
						$this->mysql_version = mysql_get_server_info($this->db_connect_id);

                                $this->dbname = $database;

                                $dbselect = @mysql_select_db($this->dbname);

                                if(!$dbselect)

                                {

                                        @mysql_close($this->db_connect_id);

                                        $this->db_connect_id = $dbselect;

                                }

                        }

                        return $this->db_connect_id;

                }

                else

                {

                        return false;

                }

        }

	function sql_server_info()
	{
		return 'MySQL ' . $this->mysql_version;
	}
	function sql_build_array($query, $assoc_ary = false)
	{
		if (!is_array($assoc_ary))
		{
			return false;
		}

		$fields = $values = array();

		if ($query == 'INSERT' || $query == 'INSERT_SELECT')
		{
			foreach ($assoc_ary as $key => $var)
			{
				$fields[] = $key;

				if (is_array($var) && is_string($var[0]))
				{
					// This is used for INSERT_SELECT(s)
					$values[] = $var[0];
				}
				else
				{
					$values[] = $this->_sql_validate_value($var);
				}
			}

			$query = ($query == 'INSERT') ? ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')' : ' (' . implode(', ', $fields) . ') SELECT ' . implode(', ', $values) . ' ';
		}
		else if ($query == 'MULTI_INSERT')
		{
			trigger_error('The MULTI_INSERT query value is no longer supported. Please use sql_multi_insert() instead.', E_USER_ERROR);
		}
		else if ($query == 'UPDATE' || $query == 'SELECT')
		{
			$values = array();
			foreach ($assoc_ary as $key => $var)
			{
				$values[] = "$key = " . $this->_sql_validate_value($var);
			}
			$query = implode(($query == 'UPDATE') ? ', ' : ' AND ', $values);
		}

		return $query;
	}
	function _sql_validate_value($var)
	{
		if (is_null($var))
		{
			return 'NULL';
		}
		else if (is_string($var))
		{
			return "'" . $this->sql_escape($var) . "'";
		}
		else
		{
			return (is_bool($var)) ? intval($var) : $var;
		}
	}
	function sql_escape($msg)
	{
		if (!$this->db_connect_id)
		{
			return @mysql_real_escape_string($msg);
		}

		return @mysql_real_escape_string($msg, $this->db_connect_id);
	}


        //

        // Other base methods

        //

        function sql_close()

        {

                if($this->db_connect_id)

                {

                        if($this->query_result)

                        {

                                @mysql_free_result($this->query_result);

                        }

                        $result = @mysql_close($this->db_connect_id);

                        return $result;

                }

                else

                {

                        return false;

                }

        }



        //

        // Base query method

        //

        function sql_query($query = "", $transaction = FALSE)

        {
global $TheQueryCount;
$TheQueryCount ++;
                // Remove any pre-existing queries

                unset($this->query_result);

                if($query != "")

                {



                        $this->query_result = @mysql_query($query, $this->db_connect_id);



                }

                if($this->query_result)

                {

                        unset($this->row[$this->query_result]);

                        unset($this->rowset[$this->query_result]);

                        return $this->query_result;

                }

                else

                {

                        return ( $transaction == END_TRANSACTION ) ? true : false;

                }

        }



        //

        // Other query methods

        //

        function sql_numrows($query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $result = @mysql_num_rows($query_id);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

 	function num_rows($queryresult)
	{
		return @$this->functions['num_rows']($queryresult);
	}
       function sql_affectedrows()

        {

                if($this->db_connect_id)

                {

                        $result = @mysql_affected_rows($this->db_connect_id);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_numfields($query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $result = @mysql_num_fields($query_id);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_fieldname($offset, $query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $result = @mysql_field_name($query_id, $offset);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_fieldtype($offset, $query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $result = @mysql_field_type($query_id, $offset);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_fetchrow($query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $this->row[$query_id] = @mysql_fetch_array($query_id);

                        return $this->row[$query_id];

                }

                else

                {

                        return false;

                }

        }

        function sql_fetchrowset($query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        unset($this->rowset[$query_id]);

                        unset($this->row[$query_id]);

                        while($this->rowset[$query_id] = @mysql_fetch_array($query_id))

                        {

                                $result[] = $this->rowset[$query_id];

                        }

                        return $result;

                }

                else

                {

                        return false;

                }

        }

	function fetch_array($queryresult, $type = DBARRAY_ASSOC)
	{
		return $this->functions['fetch_array']($queryresult, $this->fetchtypes["$type"]);
	}
        function sql_fetchfield($field, $rownum = -1, $query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        if($rownum > -1)

                        {

                                $result = @mysql_result($query_id, $rownum, $field);

                        }

                        else

                        {

                                if(empty($this->row[$query_id]) && empty($this->rowset[$query_id]))

                                {

                                        if($this->sql_fetchrow())

                                        {

                                                $result = $this->row[$query_id][$field];

                                        }

                                }

                                else

                                {

                                        if($this->rowset[$query_id])

                                        {

                                                $result = $this->rowset[$query_id][$field];

                                        }

                                        else if($this->row[$query_id])

                                        {

                                                $result = $this->row[$query_id][$field];

                                        }

                                }

                        }

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_rowseek($rownum, $query_id = 0){

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $result = @mysql_data_seek($query_id, $rownum);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_nextid(){

                if($this->db_connect_id)

                {

                        $result = @mysql_insert_id($this->db_connect_id);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

	function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
	{
		if (!sizeof($array))
		{
			if (!$allow_empty_set)
			{
				// Print the backtrace to help identifying the location of the problematic code
				$this->sql_error('No values specified for SQL IN comparison');
			}
			else
			{
				// NOT IN () actually means everything so use a tautology
				if ($negate)
				{
					return '1=1';
				}
				// IN () actually means nothing so use a contradiction
				else
				{
					return '1=0';
				}
			}
		}

		if (!is_array($array))
		{
			$array = array($array);
		}

		if (sizeof($array) == 1)
		{
			@reset($array);
			$var = current($array);

			return $field . ($negate ? ' <> ' : ' = ') . $this->_sql_validate_value($var);
		}
		else
		{
			return $field . ($negate ? ' NOT IN ' : ' IN ') . '(' . implode(', ', array_map(array($this, '_sql_validate_value'), $array)) . ')';
		}
	}
        function sql_freeresult($query_id = 0){

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }



                if ( $query_id )

                {

                        unset($this->row[$query_id]);

                        unset($this->rowset[$query_id]);



                        @mysql_free_result($query_id);



                        return true;

                }

                else

                {

                        return false;

                }

        }

        function sql_error($query_id = 0)

        {

                $result["message"] = @mysql_error($this->db_connect_id);

                $result["code"] = @mysql_errno($this->db_connect_id);



                return $result;

        }



} // class sql_db



} // if ... define



?>