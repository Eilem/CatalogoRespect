<?php

require "vendor/autoload.php";

$db = new PDO("sqlite:./Catalogo.db");

$mapper = new \Respect\Relational\Mapper($db);

$router = new Respect\Rest\Router();

$router->get("/mercadoria/*" , function( $id) use($mapper){ 
    $m = $mapper->mercadoria[$id]->fetch();
    
    return json_encode($m);
});

$router->get("/mercadoria/criar", function(){

    return file_get_contents("./criar.html");
    
});


$router->post("/mercadoria", function() use($mapper){


//recebo data do ajax
	$mercadoria = new stdClass();
    $mercadoria->id_book = $_POST['book'];
    $mercadoria->nome = $_POST['nome'];
    $mercadoria->titulo = $_POST['titulo'];
    $mercadoria->descricao = $_POST['descricao'];
    $mercadoria->imagem = $_POST['imagem'];

    $mapper->mercadoria->persist($mercadoria);
    $mapper->flush();

    return json_encode($mercadoria);
    
});

print $router->run();