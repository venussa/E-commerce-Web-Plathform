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
 * @package IamRoot
 * @author  Shigansina
 * @link  https://iam-root.tech
 * @since Version 1.0.0
 * @filesource
 */

 /**
 * PHPmail Class
 *
 * For connecting to SMTP server for sending 
 * Mail message 
 *
 * @package     system
 * @subpackage  library
 * @category    mailing
 * @author      IamRoot Team
 */


require SERVER.'/application/plugin/PHPMailer-master/PHPMailerAutoload.php';

use application\config\mailserver;

class PHPmail extends mailserver{
	
	/**
	 * Mail destination
	 *
	 * @var string
	 */
	public $mail_to 		= null;
	
	/**
	 * Mail subject
	 *
	 * @var string
	 */
	public $mail_subject	= null;
	
	/**
	 * Mail message
	 *
	 * @var string
	 */
	public $mail_message	= null;
	
	
	// --------------------------------------------------------------------

    /**
	 * Get data config for login to SMTP
     * @param void
     * @return array,json
     */
	protected function getConfig(){
		
		return json_decode(json_encode(self::mail_config()));
		
	}
	
	// --------------------------------------------------------------------

    /**
	 * Set data for sending to destination target
     * @param void
     * @return array,json
     */
	
	protected function message(){
			
		return json_decode(json_encode(array(
			"mailto"	=> $this->mail_to,
			"subject" 	=> $this->mail_subject,
			"message" 	=> $this->mail_message
		)));
		
	}
	
	// --------------------------------------------------------------------

    /**
	 * Login lo smtp to get mail access 
     * @param void
     * @return void
     */
	
	protected function mail_login(){
		
		$mail = new PHPMailer();
		$mail ->IsSmtp();
		$mail ->SMTPDebug = 0;
		$mail ->SMTPAuth = true;
		$mail ->SMTPSecure = $this->getConfig()->smtp_secure;
		$mail ->Host = $this->getConfig()->smtp_host;
		$mail ->Port = $this->getConfig()->smtp_port; 
		$mail ->IsHTML(true);
		$mail ->Username = $this->getConfig()->smtp_user;
		$mail ->Password = $this->getConfig()->smtp_pass;
		$mail ->SetFrom($this->getConfig()->smtp_user);
		$mail ->Subject = $this->message()->subject;
		$mail ->Body = $this->message()->message;
		$mail ->AddAddress($this->message()->mailto);
		
		return $mail;
		
	}

	// --------------------------------------------------------------------

    /**
	 * Execute and sending data
     * @param void
     * @return boolean
     */
	
	public function send(){
		
		if(!$this->mail_login()->Send()){
		   		
			return false;
			
		}else{
			
			return true;
		}
	
	}
	
}