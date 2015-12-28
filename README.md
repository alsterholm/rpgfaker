# RPGFaker

RPGFaker is a library that can generate names for you to use in your fantasy games/fiction/whatever. To add RPGFaker to your project, simply run:

    composer require andreasindal/rpgfaker


## Usage

```php
<?php

use RPGFaker\RPGFaker;

$faker = new RPGFaker();
echo $faker->name;

// example output: Rildess Fazhria
```


### Options

When instantating the RPGFaker object, you can supply an array of options. The defaults are:

```php
$faker = new RPGFaker([
    'race'          => null,
    'length'        => 2,
    'count'         => 2,
    'special'       => 'random',
    'duplicates'    => [true, 5],
]);
```

#### Race (string)

The `race` option gives you the ability to supply the name of a fantasy race, and the name generated will fit nicely to that race.
Examples on names tied to a race:

    Elf:        Dessiell Rianahr
    Human:      Cynwin Whiteley
    Orc/Troll:  Voshyzh Roshzak

The currently accepted races are `elf`, `human`, `orc` and `troll` (orc and troll share the same settings). If `null` or any other race is supplied, a mix of all race’s settings will be used.

#### Length (integer|array)

The `length` option defines how many syllables\* the names generated will have. For example, a length of 2 may generate a name such as "Cynwin", while a length of 3 may generate the name "Fazhtargmoh". The length option can also be an array of integers, and if it is, it must contain the same amount of elements as the number of the "count" option (see below). If the length supplied is an array, then each element specifies the number of syllables for each name. However, the length parameter is not taken into account when a [special last name](#special-boolstring) is generated.

Example:

```php
<?php

use RPGFaker\RPGFaker;

$faker = new RPGFaker([
    'length' => [1, 2, 3],
    'count'  => 3
]);
echo $faker->name;

// example output: Varr Iennahr Cynsadorf
```

    
\* *In some cases, what is considered as one syllable by RPGFaker may in fact be two syllables, e.g. "fara".*

#### Count (integer)

`count` simply defines the amount of names that should be generated. Default is 2.

Example:

```php
<?php

use RPGFaker\RPGFaker;

$faker = new RPGFaker([
    'count'  => 1
]);
echo $faker->name;

// example output: Wogien

$faker = new RPGFaker([
    'count'  => 3
]);
echo $faker->name;

// example output: Steinril Annton Saeith
```

#### Special (bool|string)

`special` can be set to either the string `'random'`, `true` or `false`. Special defines wether or not a special last name will be used.

Example:

```php
<?php

use RPGFaker\RPGFaker;

$faker = new RPGFaker([
    'special' => true
]);
echo $faker->name;

// example output: Dirwog Greenhorn

$faker = new RPGFaker([
    'special' => false
]);
echo $faker->name;

// example output: Annlor Makceh
```

#### Duplicates (array)

The first element in the duplicates option specifies whether or not duplicates should be allowed, and the second element specifies the number of retries that should be attempted if a duplicate occurs. The duplicate flags controls all parts of a name, that is, generating `Rileith Doreith` after `Rileith Starcleaver` will attempt a retry.

This setting can be particularly useful when generating large sets of names.

## Future updates

I will try to update RPGFaker regularly, and among the coming updates I plan to include both towns and items.

## License

MIT.