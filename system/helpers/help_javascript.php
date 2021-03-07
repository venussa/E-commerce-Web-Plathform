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

if(!function_exists("setStaticPath")){

	/**
	 * setStaticPath
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed, json, array
	 */

	function setStaticPath($responsive){

		$data_path['response_url']  = sourceUrl();
		$data_path['response_path'] = SERVER."/sources";

		return json_decode(json_encode($data_path));

	}

}

if(!function_exists("CallJS")){
	/**
	 * Call Js
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */

	function CallJS($data,$responsive = false, $action = false){

		$_PATH = setStaticPath($responsive);

		if(is_array($data)){

			foreach($data as $key => $val){

				if(strpos($val,".js")){

					$join[] = "<script src=\"".$_PATH->response_url."/".$val."\"></script>\r";

				}

			}
				if($action == true){

					return implode(null,$join);

				}else{
				
					return implode(null,$join);

				}

		}else{

			if(strpos($data,".js")){

				if($action == true){

					return "<script src=\"".$_PATH->response_url."/".$data."\"></script>\r";

				}else{
				
					return "<script src=\"".$_PATH->response_url."/".$data."\"></script>\r";

				}

			}

		}
	}
}



if(!function_exists("CallInlineJS")){

	/**
	 * Call Inline Js
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */

	function CallInlineJS($data,$responsive = false,$action = false){

		$_PATH = setStaticPath($responsive);

		if(is_array($data)){

			foreach($data as $key => $val){

				if(strpos($val,".js")){

					$join[] = "<script>".read_file($_PATH->response_path."/".$data)."</script>";

				}

			}

			if($action == true){

					return implode(null,$join);

				}else{
				
					return implode(null,$join);

				}
				

		}else{

			if(strpos($data,".js")){

				if($action == true){

					return "<script>".read_file($_PATH->response_path."/".$data)."</script>";

				}else{
				
					return "<script>".read_file($_PATH->response_path."/".$data)."</script>";

				}

			}

		}

	}
}