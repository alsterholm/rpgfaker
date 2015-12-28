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

use InvalidArgumentException;
use RPGFaker\Assets\Prefixes;
use RPGFaker\Assets\Specials;
use RPGFaker\Assets\Suffices;
use RPGFaker\Assets\Syllables;
use RPGFaker\Interfaces\Generator;

/**
 * RPGFaker’s name generator.
 * 
 * @author Andreas Indal <andreas@rocketship.se>
 */
class Name implements Generator
{
    /**
     * Cache to store used names.
     * 
     * @var array
     */
    protected $cache = [];

    /**
     * Generate a character name.
     * 
     * @param $options array
     * @return string
     */
    public function generate(array $options)
    {
        $syllables  = [];
        $prefixes   = [];
        $suffices   = [];

        switch ($options['race']) {
            case 'elf':
                $syllables = Syllables::ELVEN;
                $prefixes  = Prefixes::ELVEN;
                $suffices  = Suffices::ELVEN;
                break;

            case 'human':
                $syllables = Syllables::HUMAN;
                $prefixes  = Prefixes::HUMAN;
                $suffices  = Suffices::HUMAN;
                break;

            case 'orc':
            case 'troll':
                $syllables = Syllables::ORCISH;
                $prefixes  = Prefixes::ORCISH;
                $suffices  = Suffices::ORCISH;
                break;

            default:
                $syllables = array_merge(
                    Syllables::ELVEN,
                    Syllables::HUMAN,
                    Syllables::ORCISH
                );
                $prefixes = array_merge(
                    Prefixes::ELVEN,
                    Prefixes::HUMAN,
                    Prefixes::ORCISH
                );
                $suffices = array_merge(
                    Suffices::ELVEN,
                    Suffices::HUMAN,
                    Suffices::ORCISH
                );
        }

        $name = $this->characterName(
            $syllables,
            $prefixes,
            $suffices,
            $options
        );

        # If duplicates are disabled, try to generate a new, available
        # name. Maximum of 5 tries, or as specified in the options.
        if (is_array($options['duplicates']) && $options['duplicates'][0] === false) {
            $n = isset($options['duplicates'][1]) ? $options['duplicates'][1] : 5;

            do {
                $name = $this->characterName(
                    $syllables,
                    $prefixes,
                    $suffices,
                    $options
                );

                $n++;
            } while ($this->checkAvailability($name) || $n === 5);
        }

        return $this->beautify($name);
    }

    /**
     * Generate a character name.
     * 
     * @param $syllables array
     * @param $prefixes  array
     * @param $suffices  array
     * @param $options   array
     * 
     * @return string
     */
    protected function characterName(array $syllables,
                                     array $prefixes,
                                     array $suffices,
                                     array $options)
    {
        $name = '';

        $length     = $options['length'];
        $count      = $options['count'];
        $special    = $options['special'];
        $race       = $options['race'];

        if (is_array($length) && $count > count($length)) {
            throw new InvalidArgumentException(
                'If "length" is an array, it must have the same amount of ' .
                'elements as the value of "count".'
            );
        }

        for ($i = 0; $i < $count; $i++) {
            if ($i === $count - 1 && $special === true) {
                $name .= $this->specialLastname($prefixes, $suffices);
                break;
            } else if ($i === $count - 1 && $special === 'random') {
                $rand = rand(1, 3);

                switch (true) {
                    case $race === 'human' && $rand === 1:
                        $n = count(Specials::HUMAN_LASTNAMES) - 1;
                        $name .= Specials::HUMAN_LASTNAMES[rand(0, $n)];
                        break;

                    case $rand === 2:
                        $name .= $this->specialLastname($prefixes, $suffices);
                        break;

                    default:
                        $rand = 3;
                }

                if ($rand !== 3) {
                    break;
                }
            }

            $n = is_array($length) ? $length[$i] : $length;

            $m = count($syllables) - 1;
            for ($j = 0; $j < $n; $j++) {
                $name .= $syllables[rand(0, $m)];
            }

            $name .= ' ';
        }

        return $name;
    }

    /**
     * Generate a special last name from a set of
     * prefixes and suffices.
     * 
     * @param $prefixes array
     * @param $suffices array
     * 
     * @return string
     */
    protected function specialLastname(array $prefixes, array $suffices)
    {
        $name = '';

        $n = count($prefixes) - 1;
        $name .= $prefixes[rand(0, $n)];

        $n = count($suffices) - 1;
        $name .= $suffices[rand(0, $n)];

        return $name;
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
}