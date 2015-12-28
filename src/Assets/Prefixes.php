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

namespace RPGFaker\Assets;

/**
 * Class contains assets to use for last name
 * prefixes.
 * 
 * @author Andreas Indal <andreas@rocketship.se>
 */
class Prefixes
{
    const ELVEN = [
        'storm', 'wooden', 'summer', 'sage', 'wind', 'star', 'sun',
        'dawn', 'moon', 'green', 'blue', 'silent', 'night', 'light',
        'high', 'silver',
    ];

    const HUMAN = [
        'silver', 'gold', 'raven', 'wooden', 'sea', 'river', 'leaf',
        'bright', 'brave', 'cold', 'vale', 'dew', 'rose', 'green',
        'wind',
    ];

    const ORCISH = [
        'blood', 'stone', 'black', 'night', 'storm', 'gore', 'rage',
        'grim', 'wolf', 'hell', 'doom', 'rock', 'red', 'skull', 'thunder',
        'bone', 'dragon', 'dark', 'iron', 'lone', 'ash',
    ];
}