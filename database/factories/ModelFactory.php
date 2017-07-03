<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\RotaSlotStaff::class, function (Faker\Generator $faker) {

    return [
        'rotaid' => $faker->numberBetween($min = 332, $max = 332),
        'daynumber' => $faker->numberBetween($min = 0, $max = 6),
        'staffid' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'slottype' => $faker->randomElement($array = array ('shift','dayoff')) ,
        'starttime' => $faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get()) ,
        'endtime' => $faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get()) ,
        'workhours' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10),
        'premiumminutes' => $faker->randomDigit,
        'roletypeid' => $faker->randomDigit,
        'freeminutes' => $faker->numberBetween($min = 10, $max = 20),
        'seniorcashierminutes' => $faker->randomDigit,
        'splitshifttimes' => $faker->text($maxNbChars = 10),

    ];

});

