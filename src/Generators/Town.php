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

use RPGFaker\Assets\Towns;

/**
 * RPGFaker’s town name generator.
 * 
 * @author  Andreas Indal <andreas@rocketship.se>
 * @since   1.1.0
 */
class Town extends Generator
{
    /**
     * Cache to store used names.
     * 
     * @var array
     */
    protected $cache = [];

    /**
     * Generate a town name.
     * 
     * @param $options array
     * @return string
     */
    public function generate(array $options)
    {
        $n = 0;
        list($prefixes, $suffices, $space) = $this->prepare();
        $name = $this->townName($prefixes, $suffices, $space);

        # If duplicates are disabled, try to generate a new, available
        # name. Maximum of 5 tries, or as specified in the options.
        if (is_array($options['duplicates']) && $options['duplicates'][0] === false) {
            $m = isset($options['duplicates'][1]) ? $options['duplicates'][1] : 5;

            do {
                $name = $this->townName($prefixes, $suffices, $space);
                $n++;
            } while ($this->checkAvailability($name) === false && $n < $m);
        }

        return $this->beautify($name);
    }

    protected function townName($prefixes, $suffices, $space)
    {
        $n = count($prefixes) - 1;
        $m = count($suffices) - 1;

        return $prefixes[rand(0, $n)] . ($space ? ' ' : '') . $suffices[rand(0, $m)];
    }

    /**
     * Prepare the town name generation. Returns an
     * array containing prefixes, suffices and a boolean
     * value that is true if the name should contain a
     * space, and false otherwise.
     * 
     * @return array
     */
    protected function prepare()
    {
        return rand(0, 1) === 0 ? [Towns::SINGLE_PREFIXES, Towns::SINGLE_SUFFICES, false] :
                                  [Towns::DOUBLE_PREFIXES, Towns::DOUBLE_SUFFICES, true];
    }
}