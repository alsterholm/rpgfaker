<?php
/**
 * RPGFaker
 * 
 * @author      Andreas Indal <andreas@rocketship.se>
 * @copyright   2015 Andreas Indal
 * @link        https://github.com/andreasindal/rpgfaker
 * @license     https://github.com/andreasindal/rpgfaker/blob/master/LICENSE
 * @version     1.0.0
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

namespace RPGFaker\Generators;

/**
 * Abstract generator class.
 * 
 * @author  Andreas Indal <andreas@rocketship.se>
 * @since   1.0.0
 */
abstract class Generator
{
    /**
     * Cache to store used names.
     * 
     * @var array
     */
    protected $cache = [];
    
    /**
     * Generate a randomized fantasy-ish string.
     * 
     * @param $options array
     * @return string
     */
    abstract function generate(array $options);

    /**
     * Beautify a name.
     * 
     * @param $name string
     * @return string
     */
    protected function beautify($name)
    {
        # Remove any occurances of three letters in a row, (e.g. replace
        # "nnn" with "nn").
        $name = preg_replace('/(.)\1\1/', substr("$1", 0, 2), $name);

        # Remove trailing spaces and transform each name to upper case.
        return trim(ucwords(strtolower($name)));
    }

    /**
     * Check if any of the names are in the cache,
     * and if so, return false. Otherwise, add the
     * names to the cache and return true.
     * 
     * @param $name string
     * @return bool
     */
    protected function checkAvailability($name)
    {
        $names = explode(' ', $name);

        foreach ($names as $name) {
            if (in_array($name, $this->cache))
                return false;
        }

        foreach ($names as $name) {
            $this->cache[] = $name;
        }

        return true;
    }
}