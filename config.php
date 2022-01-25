<?php

define('mode', 'development');

function autoloadFunction($trida) {
	if($trida === 'Database') {
    require_once(__DIR__.'/db/Database.php');
    return;
  }
	if (substr($trida, -10) === 'Controller') {
    require(__DIR__.'/controllers/' . $trida . '.php');
    return;
  }
  if (substr($trida, -5) === 'Model') {
    require(__DIR__.'/models/' . $trida . '.php');
    return;
  }
  if(file_exists(__DIR__.'/main/'.$trida.'.php')) {
 		require(__DIR__.'/main/' . $trida .'.php') ;
  }
}

spl_autoload_register("autoloadFunction");
