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

use system\core\controller;

/**
 * method Class
 *
 * Filtering paramater from GET / POST / SESSION / COOKIE / SERVER / FILES
 * and to clean xss / character non utf8
 *
 * @package		system
 * @subpackage	core
 * @category	filter paramater
 * @author		IamRoot Team
 */

class method{

	/**
    * url splitter and get method reader
    *
    * @var  array
    */

	private $identification = array("?","=");

	/**
    * uri splitter
    *
    * @var  array
    */

	private $splice_data = array("&");

	// --------------------------------------------------------------------

    /**
     * Reade GET Mehod
     *
     * @return array
     * @return string
     * @return method
     */

		public function get($index = null){

			// fetch data
			$start = @explode($this->identification[0],splice());

			if(isset($start[1])){
				$split = @explode($this->splice_data[0],$start[1]);

				// checking visible paramater
				foreach ($split as $key => $value) {

						$extract = explode($this->identification[1], $value);
						
						if(!empty($index)){

						$response = true;

						// check allowing paramater
						if($index == $extract[0]){
						
						return $extract[1];

					// if no config found
					}else{

					}
				}else{

				// commbine data
				$response = false;
				
				if(isset($extract[1]))

					$result[$extract[0]] = $extract[1];
				else
					$result[$extract[0]] = null;
							
				}
			}

				// return all
				if($response == false){

					return $result;

				}

			}else{

				// if method get not found
				return array();
			}
		}

	// --------------------------------------------------------------------

    /**
     * Reade POST Method
     *
     * @return array
     * @return string
     * @return method
     */

		public function post($index = null){

			if(!empty($index)){

				foreach ($_POST as $key => $value) {

					if($index == $key){
						
						return $value;
					}
				}	

			}else{

				return $_POST;

			}
		}

	// --------------------------------------------------------------------

    /**
     * Reade SESSION Mehod
     *
     * @return array
     * @return string
     * @return method
     */
		
		public function session($index = null,$val = null){

			if(!empty($val)){

			$_SESSION[$index] = $val;

			}else{

			if(!empty($index)){

				foreach ($_SESSION as $key => $value) {

					if($index == $key){
						return $value;
						}
					}	

				}else{

					return $_SESSION;

				}
			}
		}

	// --------------------------------------------------------------------

    /**
     * Reade SERVER Mehod
     *
     * @return array
     * @return string
     * @return method
     */
		
		public function server($index = null){

			if(!empty($index)){

				foreach ($_SERVER as $key => $value) {

					if($index == $key){

						return $value;

					}
				}	

			}else{

				return $_SERVER;
			}
		}
}