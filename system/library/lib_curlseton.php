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
 * curlseton Class
 *
 * this class for doing curl or data transmision from
 * other source page or source url
 *
 * @package     system
 * @subpackage  library
 * @category    data transmision
 * @author      IamRoot Team
 */

class curlseton
{
    /**
    * Static curl ini extention
    *
    * @var mixed
    */

    private $ch;

    /**
    * Responde the callebale file
    *
    * @var bool
    */

    private $response = false;

    // --------------------------------------------------------------------

    /**
     * @param string $url
     * @param array  $options
     */
    public function __construct($url, array $options = array())
    {
        $this->ch = curl_init($url);

        foreach ($options as $key => $val) {
            curl_setopt($this->ch, $key, $val);
        }

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    // --------------------------------------------------------------------

    /**
     * Get the response
     * @return string
     * @throws \RuntimeException On cURL error
     */
    public function getResponse()
    {
         if ($this->response) {
             return $this->response;
         }

        $response = curl_exec($this->ch);
        $error    = curl_error($this->ch);
        $errno    = curl_errno($this->ch);

        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }

        return $this->response = $response;
    }

    // --------------------------------------------------------------------

    /**
     * Let echo out the response
     * @return string
     */
    public function __toString()
    {
        return $this->getResponse();
    }
}
