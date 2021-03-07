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
 * @package IamRoot
 * @author  Shigansina
 * @link    https://iam-root.tech
 * @since   Version 1.0.0
 * @filesource
 */

 /**
 * pushstateurl Class
 *
 * this class will colaboration with javascript
 * pjaxstandalone.js to hide page load and incrase page speed load
 * without using cache
 *
 * @package     system
 * @subpackage  library
 * @category    data transmision
 * @author      IamRoot Team
 */

class pushstateurl{

	/**
    * Web Container
    *
    * @var string
    */
	public $container;

	/**
    * Web Content
    *
    * @var string
    */
	public $content;

    /**
    * Content class
    *
    * @var string
    */
    public $class;

    /**
    * Content action
    *
    * @var string
    */
    public $action = array(

        "before"    => null,
        "success"   => null,
        "error"     => null,

    );

	// --------------------------------------------------------------------

    /**
     * Load Pjax stand alone javascript file
     *
     * @return  string
     * @return  bool
     */
	public function pjax_load(){

		return "<script src='".homeUrl()."/application/plugin/PjaxStandAlone/pjax-standalone.min.js'></script>";


	}

	// --------------------------------------------------------------------

    /**
     * RLoad Ajax Configuration
     *
     * @return  array
     */
	public function pjax_write(){

		require_once(SERVER."/application/plugin/PjaxStandAlone/pjax.php");
		
		return pjax($this->class,$this->container,$this->content,$this->action);

	}

	// --------------------------------------------------------------------

    /**
     * Running pjax
     *
     * @return  string
     * @return void
     * @return mixed
     */

    public function pjax_start(){

    	$data = array(

    		$this->pjax_load(),
    		$this->pjax_write(),

    	);

    	return implode(null,$data);
    }
}