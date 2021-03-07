<?php

namespace system\core;

/**
 * IamRoot
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2018 - 2022, Iamroot Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	IamRoot
 * @author	Shigansina
 * @link	https://iam-root.tech
 * @since	Version 1.0.0
 * @filesource
 */

use application\config\dbconfig;
use \PDO;

/**
 * database Class
 *
 * Build Query and rewrite query for easy access
 * usinjg PDO Driver Extention
 *
 * @package		system
 * @subpackage	core
 * @category	Database Query
 * @author		IamRoot Team
 * @throws 		\DBQuery On call Query
 */

class database extends DBQuery{

	// --------------------------------------------------------------------

	/**
     *Prepare Query
     *
     * @return array
     * @throws \DBQuery On call Query
     */

		public function prepare($data){

			$query = self::PDOconnect()->prepare($data);

			return $query;
		}

	// --------------------------------------------------------------------

	/**
     * Build Query
     *
     * @return array
     * @throws \DBQuery On call Query
     */

		public function query($data){

			$query = self::PDOconnect()->query($data);

			return $query;
		}

	// --------------------------------------------------------------------

	/**
     * Fetch Query as Array
     *
     * @return array
     * @throws \DBQuery On call Query
     */

		public function fetch($data){
			$query = self::PDOconnect()->query($data)->fetch();
			return @$query;
		}

	// --------------------------------------------------------------------

	/**
     * Row Count
     *
     * @return string
     * @return numeric
     * @throws \DBQuery On call Query
     */
		public function rowCount($data){
			$query = self::PDOconnect()->query($data)->rowCount();
			return @$query;	
		}

	// --------------------------------------------------------------------

	/**
     * Query Fetch Assoc
     *
     * @return mixed
     * @throws \DBQuery On call Query
     */

		public function fetchAssoc($data){
			$query = self::PDOconnect()->query($data)->fetch(PDO::FETCH_ASSOC);
			return @$query;
		}

}


class DBQuery extends dbconfig{
	
	// --------------------------------------------------------------------

	/**
     * Connect PDO Driver
     *
     * @return void
     * @return mixed
     * @throws \PDO to connect driver
     */

	protected function PDOconnect(){

		$db = new PDO('mysql:host='.(new dbconfig)->information()->hostname.';dbname='.(new dbconfig)->information()->database,(new dbconfig)->information()->username, (new dbconfig)->information()->password);
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		return $db;

	}

}