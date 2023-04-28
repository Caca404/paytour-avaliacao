<?php

namespace App\Models;

use DateTime;
use Exception;

class Curriculo
{
    public $nome;
    public $email;
    public $telefone;
    public $cargo;
    public $escolaridade;
    public $observacoes;
    public $file;
    public $dthr;

    function __construct(
        $nome, 
        $email, 
        $telefone,
        $cargo, 
        $escolaridade, 
        $observacoes = null, 
        $file, 
        $dthr
    ) {
        $this->nome = htmlspecialchars(trim($nome));

        if(filter_var($email, FILTER_VALIDATE_EMAIL)) $this->email = $email;
        else throw new Exception("Email não é válido");

        if(strlen(trim($telefone)) == 11) $this->telefone = trim($telefone);
        else throw new Exception("Telefone não é válido");

        $this->cargo = htmlspecialchars(trim($cargo));

        if(in_array($escolaridade, ['FC', 'FI', 'MC', 'MI', 'SC', 'SI']))
            $this->escolaridade = $escolaridade;
        else 
            throw new Exception("Escolaridade não é válida");

        $this->observacoes = !empty($observacoes) ? htmlspecialchars(trim($observacoes)) 
            : $observacoes;

        $this->dthr = new DateTime($dthr);
    }
}
