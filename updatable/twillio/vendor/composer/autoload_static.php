<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInited79713ec48dee80e5476284f43a6adc
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInited79713ec48dee80e5476284f43a6adc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInited79713ec48dee80e5476284f43a6adc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInited79713ec48dee80e5476284f43a6adc::$classMap;

        }, null, ClassLoader::class);
    }
}
