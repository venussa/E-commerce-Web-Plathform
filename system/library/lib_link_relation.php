<?php

namespace system\library;

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

use application\config\document;

 /**
 * link_relation Class
 *
 * rewire dir : application\views
 * for include some file from thasts path
 *
 * @package		system
 * @subpackage	library
 * @category	data transmision
 * @author		IamRoot Team
 */

class link_relation{

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * Set a new virtual path and rewrite path from /application/views/*
	 *
	 * @return	mixed
	 */

	public function __construct(){

		$this->rewriteDocument();

	}

	// --------------------------------------------------------------------

	/**
	 * get File name
	 *
	 * Get the original name from uri
	 *
	 * @return	string
	 */

	private function file_name(){

		return get_file_name(documenturl());

	}

	// --------------------------------------------------------------------

	/**
	 * Read File
	 *
	 * Scan and detection if file found or not found 
	 * if found, this function wiil be read the file target
	 *
	 * @return	bool
	 */

	private function defined_realpath($action = false){

		if(file_exists(DirSeparator(SERVER."/sources/".splice()))) {

			if($action == true){

				return true;

			}else{
					
				return read_file(SERVER."/sources/".splice());

			}

		}else{

			return false;

		}

	}

	// --------------------------------------------------------------------

	/**
	 * rewrite path of file
	 *
	 * By scanning the content-typr of file
	 *
	 * @return	void
	 */

	private function rewriteDocument(){

		$data = (new document)->content_type();

		$extention = get_extention($this->file_name());

		if($extention !== "php" and self::defined_realpath(true) and !empty($this->file_name()) and isset($data->$extention) ){

			$data = $data->$extention;

				if(is_array($data)){

					header("Content-type:".$data[0]);

				}else{
								
					header("Content-type:".$data);

				}

			echo self::defined_realpath();

			exit;	
		}	
	}
}