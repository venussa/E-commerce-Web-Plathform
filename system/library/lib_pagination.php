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
 * @package	IamRoot
 * @author	Shigansina
 * @link	https://iam-root.tech
 * @since	Version 1.0.0
 * @filesource
 */

 /**
 * pagination Class
 *
 * generate pagination page
 *
 * @package		system
 * @subpackage	library
 * @category	paging
 * @author		IamRoot Team
 */

class pagination{

	// --------------------------------------------------------------------

	/**
	 * Generate pagination template
	 *
	 * sum all of page and generating paging template
	 *
	 * @return	mixed
	 */
	
	public function generate(
		$noPage = 1,
		$dataPerPage = 10,
		$jumData = 0,
		$url,
		$container_class = null,
		$list_class = null,
		$a_class = null,
		$pjax = null,
		$list_class_active = null,
		$other_attr = null
	){
		
		// url method detector
		if(strpos($url,"?") == true){

			$url = $url."&";

		}else{

			$url = $url."?";	

		}
		
		$offset = ($noPage - 1) * $dataPerPage;

		$list = "<ul class='".$container_class."'>";

		$jumPage = ceil($jumData/$dataPerPage);

		$list .= "<li class='".$list_class."'><a page='1' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=1' ".$other_attr.">First</a></li>";

		if ($noPage > 1) {

			$list .= "<li class='".$list_class."' ><a page='".($noPage-1)."' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=".($noPage-1)."' ".$other_attr.">Prev</a></li>";

		}

			for($page = 1; $page <= $jumPage; $page++)
			{
					 if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 0) || ($page == 0))
					 {
						if ($page == $noPage){

							$list .= "<li> <a class='".$list_class_active."'>".$page."</a></li>";

						}else{

							$list .= "<li class='".$list_class."'> <a page='".($page)."' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=".$page."' ".$other_attr.">".$page."</a> </li>";

						}

						$showPage = $page;
					 }
			}

			if ($noPage < $jumPage) {

				$list .= "<li class='".$list_class."'><a page='".($noPage+1)."' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=".($noPage+1)."' ".$other_attr.">Next</a></li>";

			}

			$list .= "<li class='".$list_class."' ><a page='".($jumPage)."' data-pjax='".$pjax."' class='".$a_class."' href='".$url."page=".($jumPage)."' ".$other_attr.">Last</a></li>";
			$list .= "</ul>";

		return $list;
	}       
}