<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5b34908d489f1601e2e1cb188a509221
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BeycanPress\\Http\\' => 17,
            'BeycanPress\\AccountSwitcher\\' => 28,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BeycanPress\\Http\\' => 
        array (
            0 => __DIR__ . '/..' . '/beycanpress/http/src',
        ),
        'BeycanPress\\AccountSwitcher\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5b34908d489f1601e2e1cb188a509221::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5b34908d489f1601e2e1cb188a509221::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5b34908d489f1601e2e1cb188a509221::$classMap;

        }, null, ClassLoader::class);
    }
}
