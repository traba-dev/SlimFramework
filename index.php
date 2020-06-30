<?php

require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->get("/hola/:nombre", function($nombre) use ($app) {
	echo "Hola " . $nombre;
});

function pruebaMiddle() {
	echo "Soy un middleware";
}

function pruebaTwo() {
	echo "Soy un middleware 2";
}

$app->get("/pruebas(/:uno(/:dos))", 'pruebaMiddle', 'pruebaTwo', function($uno = NULL, $dos = NULL) {
	echo $uno . "<br/>";
	echo $dos . "<br/>";
})->conditions(array(
	"uno" => "[a-zA-Z]*",
	"dos" => "[0-9]*"
));

$uri="/slim/index.php/api/ejemplo/";
$app->group("/api", function() use ($app,$uri) {
	
	$app->group("/ejemplo", function() use ($app,$uri) {
		
		$app->get("/hola/:nombre", function($nombre) {
			echo "Hola " . $nombre;
		})->name("hola");
		
		$app->get("/dime-tu-apellido/:apellido", function($apellido) {
			echo "Tu apellido es: " . $apellido;
		});
		
		$app->get("/mandame-a-hola", function() use ($app,$uri) {
			//$app->redirect($uri."hola/Victor");
			$app->redirect($app->urlFor("hola", array(
				"nombre" => "Victor Robles"
			)));
		});
		
	});
	
});



$app->run();
