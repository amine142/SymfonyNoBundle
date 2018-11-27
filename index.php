<?php



/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernel as Kernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

// looks inside *this* directory
$fileLocator = new FileLocator(array(__DIR__.'/src/Resources/config/'));
$loader = new YamlFileLoader($fileLocator);
$routes = $loader->load('routes.yml');


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
$request =  Request::createFromGlobals();
$context = new RequestContext('/');
$matcher = new UrlMatcher($routes, $context);

try{
    $parameters = $matcher->match($request->getPathInfo());
    $request->attributes->set('_controller',$parameters['_controller']);
}catch (Exception $e){
    $response = new Response("<b>{$e->getMessage()}</b>", 404);
    $response->send();
    $kernel->terminate($request, $response);
}

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
