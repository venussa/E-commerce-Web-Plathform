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
if(!function_exists("is_https")){
	
	/**
	 * https cheker
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */

	function is_https($command = null)	{

		if(isset($_SERVER['HTTPS'])) {

			$protocol = "https://" ; 
			$response = true;

		}else{ 

			$protocol = "http://";
			$response = false;
		}


		if($command == true){

			return $protocol;

		}else{

			return $response;
		}
	}
}

if(!function_exists("domain")){
	/**
	 * Get Domain Name
	 *
	 * @param	string
	 * @return	String
	 */
	function domain(){

		return $_SERVER['HTTP_HOST'];

	}
}

if(!function_exists("homeUrl")){
	/**
	 * Set home site url
	 *
	 * @param	string
	 * @return	String
	 */
	function homeUrl(){

	    $root = explode("/",$_SERVER['DOCUMENT_ROOT']);
	    $root = $root[count($root)-1];
	    $root = explode($root,SERVER);
	    $root = $root[1];
	    $home_dir = $root;

	    $data = array(

	    	is_https(true),
	    	$_SERVER['HTTP_HOST'],
	    	$home_dir

	    );

	    return implode(null,$data);
	}

}


if(!function_exists("sourceUrl")){

	/**
	 * Project Url
	 *
	 * @param	string
	 * @return	String
	 */
	function sourceUrl($response = false){

		if($response == true){

			if(!empty($_SESSION['amp'])){

				return DirSeparator(homeUrl()."/sources/".$_SESSION['amp']);

			}else{

				return homeUrl()."/sources";

			}
		
		}else{

			return homeUrl()."/sources";
		
		}

	}

}

if(!function_exists("documentUrl")){
	/**
	 * Current Url
	 *
	 * @param	string
	 * @return	String
	 */

	function documentUrl(){

		$data = array(

			is_https(true),
			$_SERVER['HTTP_HOST'],
			$_SERVER['REQUEST_URI']

		);

		return implode(null,$data);

	}

}

if(!function_exists("splice")){
	/**
	 * Uri SPlitter
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function splice($num = null){
    	
    	// get uri
     	$root = explode("/",$_SERVER['DOCUMENT_ROOT']);
    	$root = $root[count($root)-1];
    	$root = explode($root,SERVER);
    	$root = $root[1];
    	$home_dir = $root;

    	// chek offset as integer
    	if(!empty( (int) $num)){

			// call offset uri
			$splice = str_replace($home_dir,null,$_SERVER['REQUEST_URI']);
			$splice = explode("?",$splice);
			$splice = $splice[0];
			$data = explode("/",$splice);
			
			// call offset uri
			if($num !== null){

			if(isset($data[$num]))
			return str_replace("\"","",str_replace("'","",$data[$num]));
			else return null;
			
			}else{
			return @$data;
			}
		  
		}else{

			// default call offset
			return str_replace($home_dir,null,$_SERVER['REQUEST_URI']);
		}
	}
	
}

if ( ! function_exists('url_title')) {
	/**
	 * Url generator
	 *
	 * @param	string
	 * @return	String
	 */
	function url_title($str, $separator = '-', $lowercase = FALSE){

		if ($separator === 'dash')
		{
			$separator = '-';
		}
		elseif ($separator === 'underscore')
		{
			$separator = '_';
		}

		$q_separator = preg_quote($separator, '#');

		$trans = array(
			'&.+?;'			=> '',
			'[^\w\d _-]'		=> '',
			'\s+'			=> $separator,
			'('.$q_separator.')+'	=> $separator
		);

		$str = strip_tags($str);
		foreach ($trans as $key => $val)
		{
			$str = preg_replace('#'.$key.'#i', $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

		return trim(trim($str, $separator));
	}
}

if(!function_exists("redirect")){
	/**
	 * redirect
	 *
	 * @param	boolean
	 * @return	void
	 */
	function redirect($url = null,$interval = 0){

		if(empty($url)){

			$url = documentUrl();

		}

		echo "<meta http-equiv='refresh' content='".$interval."; url=".$url."' />";

	}

}