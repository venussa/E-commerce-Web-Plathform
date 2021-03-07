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

if(!function_exists("CreateZip")){

	/**
	 * Create Zip
	 *
	 * Create and make all file into ZIP Compression
	 * Not allowed For empty File
	 *
	 * @uses 	ZipArchive
	 * @uses 	RecursiveIteratorIterator
	 * @uses 	RecursiveDirectoryIterator
	 * @param	string
	 * @param	array
	 * @param	mixed
	 * @return	mixed	depends on what the array contains
	 */

	function CreateZip($zip_file,$dir,$act=null){
			
		$rootPath = realpath($dir);

		$dir = explode("/",$dir);

		if(empty(trim($dir[count($dir)-1]))){

			$dir[count($dir)-1] = "separ-place";

		}

		$dir = str_replace("/separ-place","",implode("/",$dir));


		if(is_file($dir) == true){

			$zip = new ZipArchive();
			if($zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE)){
			$zf = explode("/",$dir);
			$zf = $zf[(count($zf)-1)];

			$path = explode("/",$dir);
				foreach($path as $key => $val){
					if(($key+1) < count($path)){
						$val_path[] = $val;
					}
				}

			$target_dir = implode("/",$val_path);

			$zip->addFile($dir, $zf);

			$response = true;

			}else{

			$response = false;

			}

		}

		if(is_dir($dir) == true){
		
		$zip = new ZipArchive();
		if($zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE)){
		
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
		    if (!$file->isDir() and strpos($file->getRealPath(),"temporary_data") == false )
		    {

		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        $zip->addFile($filePath, $relativePath);
		        
		    }else{
		    	$filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);
				
				$zip->addEmptyDir($relativePath);
		    }
		}
		
		$response = true;

		}else{

		$response = false;

		}

		}
		
		$zip->close();

		return $response;

	}
}


if(!function_exists("ExtractZip")){

	/**
	 * Extract Zip
	 *
	 * Extract All ZIP File From Archive File
	 *
	 * @uses 	ZipArchive
	 * @param	string
	 * @param	array
	 * @param	mixed
	 * @return	boolean
	 */

	function ExtractZip($filename,$path,$act=null){
		 
		 $zip = new ZipArchive;

		 $res = $zip->open($filename);
		 
		 if ($res === TRUE) {

			 $zip->extractTo($path."/");
			 $zip->close();

			 if($act == "clear"){

			 	unlink($filename);
			 	
			 }

			 return true;

		 }else{

		 	 return false;

		 }
	}
}