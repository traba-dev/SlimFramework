<?php

    require_once('vendor/autoload.php');

    $app = new \Slim\Slim();

    $db = new mysqli("localhost","root","","pruebas");

    $app->get("/productos",function() use($db,$app){
        $query = $db->query("SELECT * FROM productos");
        $productos = array();
        while($fila=$query->fetch_assoc()){
            $productos[] = $fila;
        }

        echo json_encode($productos);
    });

    $app->post("/productos",function() use($db,$app){

        $query = "INSERT INTO productos VALUES (NULL,"
                . "'{$app->request->post("name")}',"
                . "'{$app->request->post("description")}',"
                . "'{$app->request->post("price")}'"
                . ")";

        $insertar = $db->query($query);

        if ($insertar) {
            $result = array("STATUS" => "true", "message" => "Registro Insertó");
        }else {
            $result = array("STATUS" => "false", "message" => "Registro no insertó");
        }

        echo json_encode($result);
    });

    $app->post("/productos/:id",function($id) use($db,$app){

        $query = "UPDATE productos SET "
                . "name = '{$app->request->post("name")}',"
                . "description ='{$app->request->post("description")}',"
                . "price = '{$app->request->post("price")}'"
                . " WHERE id={$id}";

        $update = $db->query($query);
        
        if ($update) {
            $result = array("STATUS" => "true", "message" => "Registro Actualizo");
        }else {
            $result = array("STATUS" => "false", "message" => "Registro no actualizo");
        }

        echo json_encode($result);
    });

    $app->delete("/productos/:id",function($id) use($db,$app){

        $query = "DELETE FROM productos "
                . " WHERE id={$id}";

        $delete = $db->query($query);
        
        if ($delete) {
            $result = array("STATUS" => "true", "message" => "Registro eliminado");
        }else {
            $result = array("STATUS" => "false", "message" => "Registro no eliminado");
        }

        echo json_encode($result);
    });


    $app->run();