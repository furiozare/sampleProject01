<?php
date_default_timezone_set('Asia/Jakarta');


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1')) || php_sapi_name() === 'cli-server')
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

$loader = require_once __DIR__.'/../../app_bahana/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../../app_bahana/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);


//use Symfony\Component\ClassLoader\ApcClassLoader;
//use Symfony\Component\HttpFoundation\Request;
//
//$loader = require_once __DIR__.'/../../app/bootstrap.php.cache';
//
//// Enable APC for autoloading to improve performance.
//// You should change the ApcClassLoader first argument to a unique prefix
//// in order to prevent cache key conflicts with other applications
//// also using APC.
///*
//$apcLoader = new ApcClassLoader(sha1(__FILE__), $loader);
//$loader->unregister();
//$apcLoader->register(true);
//*/
//
//require_once __DIR__.'/../../app_bahana/AppKernel.php';
////require_once __DIR__.'/../../app_bahana/AppCache.php';
//
//$kernel = new AppKernel('prod', false);
//$kernel->loadClassCache();
////$kernel = new AppCache($kernel);
//
//// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
////Request::enableHttpMethodParameterOverride();
//$request = Request::createFromGlobals();
//$response = $kernel->handle($request);
//$response->send();
//$kernel->terminate($request, $response);
