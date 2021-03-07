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

use application\config\routes;
use system\core\method;
use system\library\user_agent;
use system\library\link_relation;
use system\library\SimpleImage;

/**
 * controller Class
 *
 * this class controlling all bout site and any function
 * to load on your project
 *
 * @package		system
 * @subpackage	core
 * @category	site controller
 * @author		IamRoot Team
 */

class controller{

	// --------------------------------------------------------------------

    /**
     * Rewrite Permalink
     *
     * @return void
     * @return mixed
     */

	public function declarate_space($data,$config = false){

		(new link_relation);
		

		if(!empty(splice(1)) and (splice(1) !== "index.php")) {
			
			// checking and sellection
			
			if(in_array(splice(1),$data)) {

				// amp mode detection

				foreach($data as $key => $val){

					if(splice(1) == $val){

						// url found
						$path = SERVER."/application/controllers/".$val.".php";

						if(file_exists(DirSeparator($path))){	
		    			
			    			set_error_handler("handleError");
			    			
			    			register_shutdown_function('ShutDown');
			    		
				            require_once(DirSeparator($path));

				            ob_start();

				            $def_class = splice(1);

				            $call_class = new $def_class();

				            $ob = ob_get_clean();				                    	

							if(!empty(splice(2))){

								if(method_exists($call_class, splice(2))){

									$method = splice(2);

									$call_class->$method();

									$models = new $method;

									exit;

								}else $call_class->home();

							}else $call_class->home();

							echo $ob;

				    		exit;

						}else{

							//url found but target not found
							set_error_handler("handleError");
    			
    						register_shutdown_function('ShutDown');

							require_once(SERVER."/404.php");
							exit;
						}
					}
				}

			}else{

				// url not found
				if(splice(1) == "image"){

					$source_img = decrypt(splice(2));

					if($source_img !== false){

						$source_img = $source_img;

					}else{

						$source_img = HomeUrl()."/content/404-img.png";

					}

					resize_image($source_img,null,splice(3),splice(4));

					exit;
				
				
				}elseif(splice(1) == "show-error"){

					$_SESSION['debug'] = 1;
					redirect(homeUrl());

				}elseif(splice(1) == "hide-error"){

					$_SESSION['debug'] = 0;
					redirect(homeUrl());

				}else{

					//url found but target not found

					if($config == true){

						$path = SERVER."/application/controllers/defaults.php";

						if(file_exists(DirSeparator($path))){

							set_error_handler("handleError");
			    			
			    			register_shutdown_function('ShutDown');
			    		
				            require_once(DirSeparator($path));

				            ob_start();

				            $def_class = splice(1);

				            $call_class = new defaults();

				            $ob = ob_get_clean();				                    	

							if(!empty(splice(2))){

								if(method_exists($call_class, splice(2))){

									$method = splice(2);

									$call_class->$method();

									$models = new $method;

									exit;

								}else $call_class->home();

							}else $call_class->home();

							echo $ob;

				    		exit;

				    	}else{

				    		set_error_handler("handleError");
			
							register_shutdown_function('ShutDown');

							require_once(SERVER."/404.php");
							exit;

				    	}

					}else{
						
						set_error_handler("handleError");
			
						register_shutdown_function('ShutDown');

						require_once(SERVER."/404.php");
						exit;
				}

				exit;

			}
		}

		}else{
			
			// set default target

			$path = SERVER."/application/controllers/index.php";

			if(file_exists(DirSeparator($path))){	
    			
    			set_error_handler("handleError");
    			
    			register_shutdown_function('ShutDown');
    		
	            require_once(DirSeparator($path));

	            ob_start();

	            $call_class = new index();

	            $ob = ob_get_clean();      	

				if(!empty(splice(2))){

					if(method_exists($call_class, splice(2))){

						$method = splice(2);

						$call_class->$method();

						$models = new $method;

						exit;

					}else $call_class->home();

				}else $call_class->home();

				echo $ob;

	    		exit;

			}else{

				echo "WELCOME TO OUR FRAME WORK";	

				exit;
				
			}
			
		}
	}

}