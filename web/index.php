<?php

require('../vendor/autoload.php');


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
    $app['monolog']->addDebug( 'logging output.' );


    $responseData = array(
      'test1' => 'this is a test',
      'test2' => 'to see how silax does post endpoints',
      'request' => $request->getContent()
    );

    return $app->json(
      $responseData
    );
  }
);

$app->run();
