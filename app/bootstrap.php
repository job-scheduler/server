<?php

use JobScheduler\Server\Application;
use Symfony\Component\HttpFoundation\Request;

/** show all errors! */
ini_set('display_errors', 1);
error_reporting(E_ALL);

$basepath = __DIR__ . '/..';
$app = new Application(
    array (
        'jobscheduler.basepath' => $basepath
    )
);

/*

$app->before(function (Request $request) use ($app) {
    $token = $app['security']->getToken();
    if ($token) {
        if ($request->getRequestUri()!='/login') {

            if ($token->getUser() == 'anon.') {
                //exit('anon!');
                //return $app->redirect('/login');
            } else {
                $app['twig']->addGlobal('user', $token->getUser());
            }
        }
    }
});
*/
return $app;
