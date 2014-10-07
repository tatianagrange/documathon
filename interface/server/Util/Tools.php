<?php
/**
 * Documathon - How to make and share documentation about a project
 *
 * @author      Tatiana Grange <contact@tgrange.com>
 * @copyright   2014 Tatiana Grange
 * @link        TO DO
 * @license     http://opensource.org/licenses/MIT
 * @version     0.2
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Tools
 *
 * This class contain some functions to use everywhere. It is a toolbox.
 *
 * @author  Tatiana Grange
 * @since   0.2
 */
class Tools
{

	public static function isValidTimeStamp($timestamp)
	{
	    return ((string) (int) $timestamp === $timestamp) && ($timestamp <= PHP_INT_MAX)&& ($timestamp >= ~PHP_INT_MAX);
	}

	public static function isCorrect($data){
		return $data != null;
	}

	public static function base64ToJpeg($base64, $file) {
		file_put_contents($file, base64_decode($base64));
	}

	public static function isInteger($input){
	    return(ctype_digit(strval($input)));
	}

}