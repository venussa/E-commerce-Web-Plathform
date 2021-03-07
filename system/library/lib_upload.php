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

 /**
 * upload Class
 *
 * doing upload action with some 
 * allowed content and spesification
 *
 * @package		system
 * @subpackage	library
 * @category	caracter set
 * @author		IamRoot Team
 */

class upload {

	/**
	 * new name after upload
	 *
	 * @var string
	 */

	public $newname;

	/**
	 * path upload of file
	 *
	 * @var string
	 */

	public $destination;

	/**
	 * disallow uplload extention list of file
	 *
	 * @var string
	 */

	public $allow_extention = [];

	/**
	 * max file upload size
	 *
	 * @var string
	 */

	public $max_file_size = 100;

	/**
	 * Attribute name for $_FILES method
	 *
	 * @var string
	 */

	public $attribute_name = "file";

	// --------------------------------------------------------------------

	/**
	 * Register of attribute name
	 *
	 * @return	array
	 */

		private function scan_method(){

			if(isset($_FILES[$this->attribute_name]))

			return $_FILES[$this->attribute_name];

		}

	// --------------------------------------------------------------------

	/**
	 * Scanning bout filename who have illegal extention or scanning if didn't change name
	 *
	 * @return	string
	 */

		private function filter_name(){

			if(count($this->allow_extention) > 0){

			if(!empty($this->newname)){

					if(!in_array(get_extention($this->newname),$this->allow_extention)){

						return false;

					}else{

						return $this->newname;

					}

				}else{

					return $this->scan_method()['name'];

				}

			}else{

				if(!empty($this->newname)){

					return $this->newname;

				}else{

					return $this->scan_method()['name'];

				}

			}
		}

	// --------------------------------------------------------------------

	/**
	 * Detect the size of the file that is allowed to be uploaded
	 *
	 * @return	bool
	 */

		private function filter_max_size(){

			$size = ($this->scan_method()['size'] / 1000000);

			if($size > $this->max_file_size){

				return false;

			}else{

				return true;

			}

		}

	/**
	 * Upload Action
	 *
	 * @return	bool
	 */

		public function upload(){

			if($this->filter_name() !== false){

				if($this->filter_max_size() == true){

					if(move_uploaded_file(
						$this->scan_method()['tmp_name'], 
						DirSeparator($this->destination."/".$this->filter_name())
					) ){

						return true;

					}else return false;

				}else return false;

			}else return false;

		}
}