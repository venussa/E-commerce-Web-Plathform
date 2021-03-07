<?php

namespace application\config;

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
 * @filesource https://github.com/PHPMailer/PHPMailer
 */

 /**
 * mailserver Class
 *
 * List type of document type of site content
 * read from extention file and document type
 *
 * @package		application
 * @subpackage	config
 * @category	content type
 * @author		IamRoot Team
 */


class mailserver{
	
	 /**
     * mail_config function
     *
     * set login authenticatio to SMTP server
     *
     * @param string
     * @return array,mixed
     */
	
	protected function mail_config(){
				
		return array(
			"protocol" 		=> "smtp",
			"smtp_secure"	=> "ssl",
			"smtp_host" 	=> setting()->smtp_host,
			"smtp_port"		=> setting()->smtp_port,
			"smtp_timeout"	=> 5,
			"smtp_user"		=> setting()->smtp_user,
			"smtp_pass"		=> setting()->smtp_pass,
			"mailtype"		=> "html",
			"crlf"			=> "\r\n",
			"newline"		=> "\r\n",
			"wordwrap"		=> true
		);
		
		
	}
	
}