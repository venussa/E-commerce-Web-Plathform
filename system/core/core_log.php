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

/**
 * system_log Class
 *
 * this class for saving error log
 * into application/cache/logs
 *
 * @package		system
 * @subpackage	core
 * @category	error log
 * @author		IamRoot Team
 */

class system_log{

	/**
    * Message data
    *
    * @var  array
    * @return array
    */

	public $message = array();

	// --------------------------------------------------------------------

    /**
     * public constructor
     *
     * @return void
     */

	public function __construct($message = array()){


		$this->message[] = "########################[".date("h:i:s")."]##########################\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Msgs : ".$message['msg']."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Type : ".$message['type']."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error File : ".$message['e-file']."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Line : ".$message['line']."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Date : ".date("d-M-Y")."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Time : ".date("h:i:s")."\r";
		$this->message[] = "------------------------------------------------------------\r\r\r\r";

		// write error into log file
		write_file(implode(null,$this->message),SERVER."/application/cache/logs/".date("d-M-Y").".log", "a+");

	}

}