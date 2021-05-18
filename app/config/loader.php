<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]

    );
// Register some namespaces
$loader->registerNamespaces(
    [
       'App\Form'    => APP_PATH.'/forms/',
    ]
);

// Register autoloader
$loader->register();