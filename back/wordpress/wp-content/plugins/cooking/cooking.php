<?php
 /*
  Plugin Name: Cooking
  */
  
use cooking\Api;
use cooking\Plugin;

  require __DIR__ . '/vendor-cooking/autoload.php';

  $cooking = new Plugin();
  // STEP API instanciation d'un nouvel Api
$api = new Api();

register_activation_hook(
   __FILE__,
   [$cooking, 'activate']
);


register_deactivation_hook(
   __FILE__,
   [$cooking, 'deactivate']
);

