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

use system\library\SimpleImage;

if(!function_exists("generate_image_url")){
	/**
	 * Set image url
	 *
	 * Generate image url
	 *
	 * @param	string
	 * @return	string
	 */
	function generate_image_url($url,$width = null,$height = null ){

		if(!empty($url)){
			
			return (new SimpleImage)->generate_url($url,$width,$height);

		}

	}

}

if(!function_exists("resize_image")){
	/**
	 * Resize image
	 *
	 * COmpress And Resize image with Hight Quality
	 *
	 * @param	string
	 * @param	int
	 * @param	mixed
	 * @return	void
	 * @return	mixed
	 */

	function resize_image($url_image,$save_path = null,$width = null, $height = null){
		
		if(empty($width) or empty($height)){
				
				list($width,$height) = getimagesize($url_image);

		}else{

				if(is_numeric($width) == false or is_numeric($height) == false){
			
					list($width,$height) = getimagesize($url_image);

				}

		}

		$image = new SimpleImage();
		$image->load($url_image);
		$image->resize($width, $height);

		if(empty($save_path)){

			$save = $image->output();

		}else{

			$save = $image->save($save_path);

		}

		if($save){

			return true;
			
		}else{

			return false;
		}
	}
}