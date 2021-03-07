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

use application\config\document;

if(!function_exists("watermark")){
	/**
	 * Watermark
	 *
	 * Create watermark in default image
	 *
	 * @param	string
	 * @return	void
	 */
	function watermark($image,$watermark,$savepath = null){

		$image 		= strtolower($image);
		$watermark 	= strtolower($watermark);

		if(get_extention($image) == "jpg" or get_extention($image) == "jpeg"){

			$im 	= imagecreatefromjpeg($image);

		}elseif(get_extention($image) == "png"){

			$im 	= imagecreatefrompng($image);

		}

		if(get_extention($watermark) == "jpg" or get_extention($watermark) == "jpeg"){

			$stamp 	= imagecreatefrompng($watermark);

		}elseif(get_extention($watermark) == "png"){

			$stamp 	= imagecreatefrompng($watermark);

		}
		
		$marge_right = 40;
		$marge_bottom = 40;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

		if($savepath !== null){

			imagepng($im,$savepath,false);

		}else{

			header('Content-type: '.(new document)->content_type()->png[0]);
			imagepng($im);

		}	

		imagedestroy($im);

		return false;
	}
	
}