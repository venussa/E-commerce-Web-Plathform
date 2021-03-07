<?php

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
if(!function_exists("read_file")){

	/**
	 * Readfile
	 *
	 * @param	String
	 * @return	String
	 */
	function read_file($path){

		return implode(null,file($path));

	}

}

if(!function_exists("write_file")){

	/**
	 * Write file
	 *
	 * @param	String
	 * @return	void
	 */
	function write_file($text = null,$path,$type){

		$op = fopen($path,$type);

		if($op){

			fwrite($op,$text);
			fclose($op);

			return true;
		}

	}

}

if(!function_exists("deleteDirectory")){

	/**
	 * Delete Directory
	 *
	 * @param	String
	 * @return	Void
	 */

	function deleteDirectory($dir){

		if (!file_exists($dir)) {
        
        	return true;

   		}

	    if (!is_dir($dir)) {

	        return unlink($dir);

	    }

	    foreach (scandir($dir) as $item) {

	        if ($item == '.' || $item == '..') {
	            continue;
	        }

	        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
	            return false;
	        }

	    }

    return rmdir($dir);

	}

}

if(!function_exists("get_extention")){

	/**
	 * Get Extention
	 *
	 * @param	String
	 * @return	String
	 */
	function get_extention($path){

		$data = explode(".",$path);
		$data = $data[count($data)-1];

		return $data;

	}
}

if(!function_exists("get_file_name")){

	/**
	 * Get file name
	 *
	 * @param	String
	 * @return	String
	 */

	function get_file_name($path){

		$data = explode("/",$path);
		$data = $data[count($data)-1];

		return $data;

	}

}

if(!function_exists("upload")){

	/**
	 * Upload File
	 *
	 * @param	String
	 * @return	String
	 */

	function upload(){

		return new system\library\upload;

	}

}
