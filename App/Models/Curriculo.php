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

    public function getNome() { return $this->nome; }

    public function setNome($nome)
    {
        if(empty($nome)) throw new \InvalidArgumentException("O nome não pode ser nulo.");

        if(strlen($nome) <= 200) $this->nome = htmlspecialchars(trim($nome));
        else throw new \LengthException("O nome deve ser no máximo 200 caracteres.");
    }

    public function getEmail() { return $this->email; }

    public function setEmail($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) $this->email = $email;
        else throw new \InvalidArgumentException("Email não é válido.");
    }

    public function getTelefone() { return $this->telefone; }

    public function setTelefone($telefone)
    {
        if(empty($telefone)) throw new \InvalidArgumentException("O telefone não pode ser vazio.");
        
        if(strlen(trim($telefone)) == 11) $this->telefone = trim($telefone);
        else throw new \InvalidArgumentException("Telefone não é válido.");
    }

    public function getCargo() { return $this->cargo; }

    public function setCargo($cargo)
    {
        if(empty($cargo)) throw new \InvalidArgumentException("O cargo não pode ser nulo.");

        if(strlen($cargo) <= 200) $this->cargo = htmlspecialchars(trim($cargo));
        else throw new \LengthException("O cargo deve ser no máximo 200 caracteres.");
    }

    public function getEscolaridade() { return $this->escolaridade; }

    public function setEscolaridade($escolaridade)
    {
        if(in_array($escolaridade, ['FC', 'FI', 'MC', 'MI', 'SC', 'SI']))
            $this->escolaridade = $escolaridade;
        else 
            throw new \InvalidArgumentException("Escolaridade não é válida");
    }

    public function getFile() { return $this->file; }

    public function setFile($file)
    {
        $validMime = [
            'application/pdf', 
            'application/msword', 
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        if(!in_array($file['type'], $validMime)) 
            throw new \InvalidArgumentException("Formato de arquivo não aceito");

        if(round($file['size']*100/pow(1024, 2))/100 > 1) 
            throw new \LengthException("Arquivo muito grande. Tamanho máx.: 1 MB");

            
        if(move_uploaded_file(
            $file['tmp_name'], 
            './src/files/'.date('Y-m-d-H-i-s').basename($file['name'])
        )){
            $file['name'] = (date('Y-m-d-H-i-s').basename($file['name']));
            $this->file = $file;
        }
        else throw new Exception('Arquivo não foi movido.');
    }

    public function getObservacoes() { return $this->observacoes; }

    public function setObservacoes($observacoes)
    {
        if(!empty($observacoes)){
            if(strlen($observacoes) > 200) 
                throw new \LengthException("Observações deve ser no máximo 200 caracteres.");

            $this->observacoes = htmlspecialchars(trim($observacoes));
        }
    }

    public function getDateTime() { return $this->dthr; }

    public function setDateTime($dthr)
    {
        $this->dthr = new DateTime($dthr);
    }
}
