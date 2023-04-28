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
        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email
            : throw new Exception("Email não é válido");
        $this->telefone = strlen(trim($telefone)) == 11 ? trim($telefone)
            : throw new Exception("Telefone não é válido");
        $this->cargo = htmlspecialchars(trim($cargo));
        $this->escolaridade = in_array($escolaridade, ['FC', 'FI', 'MC', 'MI', 'SC', 'SI'])
            ? $escolaridade : throw new Exception("Escolaridade não é válida");
        $this->observacoes = !empty($observacoes) ? htmlspecialchars(trim($observacoes)) 
            : $observacoes;

        $this->dthr = new DateTime($dthr);
    }
}
