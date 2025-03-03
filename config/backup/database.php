<?php
// live
//$host = "49.157.74.6";
//$username = "rtayong_2020";
//$password = "rtayong_2020";



// local
$host = "localhost";
$username = "root";
$password = "12345";

// dummy
// $host = "192.168.110.50";
// $username = "rtayong_dummy50";
// $password = "rtayong_dummy50";

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'tsekap_main', //doh_tsekap_vii sdn_v2 doh_tsekap_nir doh_tsekap_training
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'db_2017' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'tsekap_2017', //doh_tsekap_vii sdn_v2 doh_tsekap_nir doh_tsekap_training
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'db_2018' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'tsekap_2018', //doh_tsekap_vii sdn_v2 doh_tsekap_nir doh_tsekap_training
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'db_2019' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'tsekap_2019', //doh_tsekap_vii sdn_v2 doh_tsekap_nir doh_tsekap_training
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'db_2020' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'tsekap_2020',
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'db_2021' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'tsekap_2021',
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'db_2022' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'tsekap_2022',
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'db_2023' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'tsekap_2023',
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'dengvaxia' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'doh_dengvaxia',
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'doh_referral' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'doh_referral',
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'dengvaxia_dummy' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'doh_dengvaxia_dummy',
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'db_dengvaxia' => [
            'driver' => 'mysql',
            'host' => $host,
            'port' => '3306',
            'database' => 'doh_dengvaxia',
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'cluster' => false,

        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];