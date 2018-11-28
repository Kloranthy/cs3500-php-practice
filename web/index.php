<?php

require('../vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;


$app = new Silex\Application();
$app['debug'] = true;


// Register the monolog logging service
$app->register(
  new Silex\Provider\MonologServiceProvider(),
  array(
    'monolog.logfile' => 'php://stderr',
  )
);

// Register view rendering
/*/
$app->register(
  new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
  )
);
//*/



// Our web handlers

$app->get(
  '/',
  function() use($app) {
    $app['monolog']->addDebug( 'logging output.' );

    /*/
    return $app->sendFile(
      './client/index.html'
    );
    //*/
    return $app->redirect(
      './client/index.html'
    );
  }
);

$app->post(
  '/test-post/',
  function(
    Request $request
  ) use( $app ) {
    // todo: check content type = app/json
    $requestData = $request->getContent();

    $jsonDecodedRequestData = json_decode(
      $requestData,
      true
    );

    $app['monolog']->addDebug(
      'requestData: ' . $requestData
    );


    $app['monolog']->addDebug(
      'jsonDecodedRequestData message: ' . $jsonDecodedRequestData['message']
    );

    $responseData = array(
      'test1' => 'this is a test',
      'test2' => 'to see how silax does post endpoints',
      'requestMessage' => $jsonDecodedRequestData['message']
    );


    return $app->json(
      $responseData
    );
  }
);

$app->run();
