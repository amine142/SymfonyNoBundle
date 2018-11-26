<?php



/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernel as Kernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
// Enable APC for autoloading to improve performance.
// You should change the ApcClassLoader first argument to a unique prefix
// in order to prevent cache key conflicts with other applications
// also using APC.
/*
$apcLoader = new Symfony\Component\ClassLoader\ApcClassLoader(sha1(__FILE__), $loader);
$loader->unregister();
$apcLoader->register(true);
*/
$eventDispatch = new EventDispatcher();
$controllerResolver = new ControllerResolver();
$kernel = new Kernel($eventDispatch, $controllerResolver);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request =  new Request(
    $_GET,
    $_POST,
    $_GET,
    $_COOKIE,
    $_FILES,
    $_SERVER
);;

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
