<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdad8f01e17971c16926a984776951003
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdad8f01e17971c16926a984776951003::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdad8f01e17971c16926a984776951003::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
