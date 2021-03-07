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

if(!function_exists("array_to_json")){

	/**
	 * Array TO Json
	 *
	 * Make array to json
	 *
	 * @param	array
	 * @return	json
	 */

	function array_to_json($json = null,$action = false){

		if(is_array($json)){

			if($action == true){

				header("Content-type:".(new document)->content_type()->json[0]);
				echo json_encode($json);

			}else{

				return json_decode(json_encode($json));

			}

		}

	}

}

if(!function_exists("fetch_json_file")){

	/**
	 * Fetch Jsom
	 *
	 * Make array to json
	 *
	 * @param	Json
	 * @return	array
	 */
	function fetch_json($path){

		if(file_exists($path)){

			$url = read_file($path);

		}else{

			$url = $path;

		}

		return json_decode($url);

	}

}

if(!function_exists("save_json")){

	/**
	 * Save Json
	 *
	 * saving json as file
	 *
	 * @param	array
	 * @param	json
	 * @return	void
	 */

	function save_json($name,$path,$json){

		if(!is_array($json)){

			return write_file(array_to_json($json),$path,"w+");

		}else{

			return write_file($json,$path,"w+");

		}

	}

}


if(!function_exists("array_multidimention")){

	/**
	 * array miltidimention
	 *
	 * @param	string
	 * @param	array
	 * @param	json
	 * @return	Array
	 */

	function array_multidimention($data,$path = null){

		foreach($data as $key => $val){

			if(is_array($val)){

				if(empty($path)){

					$write_path = $key;

				}else{

					$write_path = $path."->".$key;
				}

				return array_multidimention($val,$write_path);

			}else{

				if(empty($path)){

					$write_path = $key;

				}else{
					
					$write_path = $path."->".$key;

				}

				return array_to_json(array("path" => $write_path,"value" => $val));

			}

		}

	}

}

if(!function_exists("update_json")){

	/**
	 * Update Json
	 *
	 * @param	string
	 * @param	array
	 * @param	json
	 * @return	json
	 */

	function update_json($index,$source,$dimention = null){

		$data = array_multidimention($index);
		
		if($dimention !== null)
			
			$dimention = explode($dimention,$data->value);		

		else 

			$dimention = null;		

		if(is_array($dimention)) {

			$built = '$source->'.$data->path.' = $dimention;';

		}else{
		
			$built = '$source->'.$data->path.' = "'.$data->value.'";';

		}

		eval($built);

		return json_encode($source);

	}

}