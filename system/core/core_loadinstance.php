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

use system\core\method;
use system\core\database;

/**
 * load Class
 *
 * Read views and models
 *
 * @package		system
 * @subpackage	core
 * @category	controller
 * @author		IamRoot Team
 */

 class load {

 	// --------------------------------------------------------------------

    /**
     * call views file
     *
     * @return array
     * @return mixed
     */

 	protected function view($path = null, $data = null,$print = true){

 		$path = SERVER."/application/views/".$path.".php";

 		if(!empty($path) and file_exists($path)){

            ob_start();

 			require_once($path);

            $ob = ob_get_clean();

            $result = $ob;

            if(!empty($data) and is_array($data)){

                foreach($data as $key => $val){

                    $build[] = "{".$key."}";
                    $value[] = $val;

                }

            $result = str_replace($build,$value,$ob);

            }

            if($print == false) return $result;

            else echo $result;

 		}else{

            return false;

        }

 	}

 	// --------------------------------------------------------------------

    /**
     * call model files
     *
     * @return array
     * @return mixed
     */

 	protected function model($path = null){

 		$path = SERVER."/application/models/".$path.".php";

 		if(!empty($path) and file_exists($path)){

 			require_once($path);

 		}else{

            return false;

        }

 	}

    // --------------------------------------------------------------------

    /**
     * method and query reader
     *
     * @return array
     * @return mixed
     */

    function generate_data(){

        return new method();

    }

    function db(){

        return new database();
        
    }



    // --------------------------------------------------------------------

    /**
     * Filter get method
     *
     * @return array
     * @return mixed
     */

    protected function get($index = null,$remove = ["'",";","{","}","@","(",")","$","!","^","*"]){

        $get = $this->generate_data()->get($index);

        if(!empty($get)){
            
            if(!empty($remove) and is_array($remove)){

                $get = str_replace($remove,null,$get);

                if(in_array("'",$remove) or in_array('"',$remove)){

                    $get = str_replace(["'","\"","%27","%22"],null,$get);

                }

            }

         return strip_tags($get);

        }else{

            return false;

        }

    }

    // --------------------------------------------------------------------

    /**
     * Filter post method
     *
     * @return array
     * @return mixed
     */

    protected function post($index = null,$remove = ["'",";"]){

        $get = $this->generate_data()->post($index);

        if(!empty($get)){
            
            if(!empty($remove) and is_array($remove)){

                $get = str_replace($remove,null,$get);

                if(in_array("'",$remove) or in_array('"',$remove)){

                    $get = str_replace(["'","\"","%27","%22"],null,$get);

                }

            }

         return ($get);

        }else{

            return false;

        }

    }

 }