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

namespace RPGFaker;

use RPGFaker\Generators\Name as NameGenerator;

/**
 * RPGFaker is a library that can generate names for
 * you to use in your fantasy games/fiction/whatever.
 * 
 * @author Andreas Indal <andreas@rocketship.se>
 */
class RPGFaker
{
    /**
     * Options
     * 
     * @var array
     */
    protected $options = [
        'race'          => null,
        'length'        => 2,
        'count'         => 2,
        'special'       => 'random',
        'duplicates'    => [false, 5],
    ];

    /**
     * @var \RPGFaker\Generators\Name
     */
    protected $nameGenerator;
    
    /**
     * Construct a new RPGFaker instance, overwriting
     * any options specified by the user.
     */
    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    /**
     * Shortcuts for generators.
     * 
     * @param $var mixed
     * @return mixed
     */
    public function __get($var) {
        switch ($var) {
            case 'name':
                if (!isset($this->nameGenerator))
                    $this->nameGenerator = new NameGenerator();

                return $this->nameGenerator->generate($this->options);
                break;

            default:
                return null;
        }
    }

    public function setOptions($options = []) {
        $this->options = array_merge($this->options, $options);
    }
}