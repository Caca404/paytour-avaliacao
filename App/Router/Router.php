<?php

namespace App\Router;

use App\Controller\CurriculoController;

class Router{
    public function findRoute($urlFunction){

        $curriculoController = new CurriculoController();

        switch ($urlFunction) {
            case 'submitForm':
                return json_encode($curriculoController->submitCurriculo(), JSON_UNESCAPED_UNICODE);
                break;
            
            default:
                return json_encode(
                    ["status" => 404, "message" => "Rota não encontrada."], 
                    JSON_UNESCAPED_UNICODE
                );
                break;
        }
    }
}