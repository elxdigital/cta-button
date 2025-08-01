<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1ce56f9279fedaafe230a8cd68058ce8
{
    public static $files = array (
        '119c5c23b1750c031f50df500a6fe7c3' => __DIR__ . '/../..' . '/src/helper/string.php',
    );

    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'League\\Plates\\' => 14,
        ),
        'E' => 
        array (
            'Elxdigital\\CtaButton\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'League\\Plates\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/plates/src',
        ),
        'Elxdigital\\CtaButton\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1ce56f9279fedaafe230a8cd68058ce8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1ce56f9279fedaafe230a8cd68058ce8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1ce56f9279fedaafe230a8cd68058ce8::$classMap;

        }, null, ClassLoader::class);
    }
}
