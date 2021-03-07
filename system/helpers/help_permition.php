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
 * @link    https://iam-root.tech
 * @since   Version 1.0.0
 * @filesource
 */

if(!function_exists("get_file_perm_code")){

     /**
     * Get Permition code
     *
     * @param   mixed data
     * @return  string utf8
     */
    
    function get_file_perm_code($file){
    
        return substr(sprintf("%o", fileperms($file)), -4);
    
    }
}

if(!function_exists("get_file_perm_owner")){

    /**
     * Get Permition Owner
     *
     * @param   mixed data
     * @return  string utf8
     */

    function get_file_perm_owner($file){
        $stat = stat($file);
        if($stat){
            $group = posix_getgrgid($stat[5]);
            $user = posix_getpwuid($stat[4]);
            return compact("user", "group");
        }
        else
            return false;
    }
}

if(!function_exists("get_file_perm_asci_code")){

    /**
     * Get Permition ASCI Code
     *
     * @param   mixed data
     * @return  string utf8
     */

    function get_file_perm_asci_code($perms, $file){
        $rwx = array(
            "---",
            "--x",
            "-w-",
            "-wx",
            "r--",
            "r-x",
            "rw-",
            "rw"
        );
        $type = is_dir($file) ? "d" : "-";
        $owner = $perms[1];
        $group = $perms[2];
        $public = $perms[3];
        return $type.$rwx[$owner].$rwx[$group].$rwx[$public];
    }
}