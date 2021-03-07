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

use system\library\magiccaptcha;

if(!function_exists("create_captcha")){

	/**
	 * Captcha Builder
	 *
	 * Hashing or Encrypting String to MD5 hash
	 *
	 * @param	Boolean
	 * @return	JSon
	 */

	function create_captcha($action = null){
		
		if($action == "code"){

			if(isset($_SESSION['captcha'])){

				return $_SESSION['captcha']['code'];

			}else{

				$_SESSION['captcha'] = (new magiccaptcha)->create_captcha();
		
				$_SESSION["captcha_code"] = $_SESSION['captcha']['code'];

			}

		}else{

			$_SESSION['captcha'] = (new magiccaptcha)->create_captcha();
			
			$_SESSION["captcha_code"] = $_SESSION['captcha']['code'];

			$result = array(
				"code" 	=> $_SESSION['captcha']['code'],
				"captcha_image" => "<img src='". $_SESSION['captcha']['image_src']."' alt='CAPTCHA code'>",
				"captcha_image_url" => $_SESSION['captcha']['image_src'],
			);

			return json_decode(json_encode($result));
		}
	}
}