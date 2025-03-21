<?php

/**
 * Parse config file and creates specify constants
 * @throws Exception
 */
function loadConfig(){
    $configFile = '../config';
    if(!file_exists($configFile)){
        throw new Exception('no config file');
    }
    $configStr = file_get_contents($configFile);
    $configPairs = explode(PHP_EOL, $configStr);
    foreach ($configPairs as $configPair){
        if(empty($configPair)){
            continue;
        }
        $confComponents = explode('=', $configPair);
        if(count($confComponents) != 2){
            throw new Exception('Incorrect config pair ' . $configPair);
        }
        $configKey = trim($confComponents[0]);
        $configVal = trim($confComponents[1]);
        define($configKey, $configVal);
    }
}

spl_autoload_register(function($class){
    $classFile = '..' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if(file_exists($classFile)){
        include_once $classFile;
        return true;
    }
    return false;
});

loadConfig();

\app\core\Route::init();