<?php

namespace App\Controller;

use App\Conexao\Conexao;
use App\Models\Curriculo;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class CurriculoController{
    function submitCurriculo(){
        try{
            $curriculo = new Curriculo();

            $curriculo->setNome($_POST['nome']);
            $curriculo->setEmail($_POST['email']);
            $curriculo->setTelefone($_POST['telefone']);
            $curriculo->setCargo($_POST['cargo']);
            $curriculo->setEscolaridade($_POST['escolaridade']);
            $curriculo->setFile($_FILES['file']);
            $curriculo->setDateTime($_POST['dthr']);
            $curriculo->setObservacoes($_POST['observacoes']);

            $sql = "INSERT INTO curriculos (
                    nome, 
                    email, 
                    telefone, 
                    cargo, 
                    escolaridade, 
                    observacoes, 
                    file_path, 
                    dthr_envio, 
                    ip_client
                ) 
                VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = Conexao::getConn('App/Db/paytour-curriculos.db')->prepare($sql);
            $stmt->bindValue(1, $curriculo->getNome());
            $stmt->bindValue(2, $curriculo->getEmail());
            $stmt->bindValue(3, $curriculo->getTelefone());
            $stmt->bindValue(4, $curriculo->getCargo());
            $stmt->bindValue(5, $curriculo->getEscolaridade());
            $stmt->bindValue(6, $curriculo->getObservacoes());
            $stmt->bindValue(7, $curriculo->getFile()['name']);
            $stmt->bindValue(8, $curriculo->getDateTime()->format("Y-m-d h:i:s"));
            $stmt->bindValue(9, $_SERVER['REMOTE_ADDR']);

            if($stmt->execute()) return $this->sendEmail($curriculo);
            else return [
                "status" => 500, 
                "typeError" => "cadastro", 
                "message" => "Curriculo não foi cadastrado"
            ];
        }
        catch(\Exception $e){
            return ["status" => 500, "message" => $e->getMessage()];
        }
    }

    function sendEmail(Curriculo $curriculo){

        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->SMTPAuth = true;                                     //Enable SMTP authentication
            $mail->SMTPSecure = 'ssl';                                  //Enable implicit TLS encryption
            $mail->Host = 'smtp.gmail.com';                           //Set the SMTP server to send through
            $mail->Port = 465;                                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = 'UTF-8';
            $mail->Username = 'christianPayoutExame@gmail.com';         //SMTP username
            $mail->Password = 'cbdqmphllstmwyxl';                  //SMTP password
        
            //Recipients
            $mail->setFrom('christianPayoutExame@gmail.com', 'Paytour Curriculos');
            $mail->addAddress($curriculo->getEmail(), $curriculo->getNome());               //Name is optional
        
            //Attachments
            $mail->addAttachment(
                './src/files/'.$curriculo->getFile()['name'], 
                $curriculo->getFile()['name']
            );
        
            $body = $this->getBodyEmail($curriculo);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Seu currículo foi enviado para nós!';
            $mail->Body = 'Olá, '.$curriculo->getNome().', seu curriculo foi enviado!<br>
                Aqui está suas informações enviadas:<br>'.$body;
            $mail->AltBody = 'Olá, '.$curriculo->nome.', seu curriculo foi enviado!
            Aqui está suas informações enviadas:<br>'.$body;
        
            if($mail->send()) return ["status" => 200, "message" => "Currículo enviado!"];
            else return [
                "status" => 500, 
                "typeError" => "email",
                "message" => "Currículo cadastrado mas o email não foi enviado!"
            ];
            
        } catch (Exception $e) {
            return [
                "status" => 500,
                "typeError" => "email", 
                "message" => "Currículo cadastrado mas o email não foi enviado!", 
                "textBody" => $mail->ErrorInfo
            ];
        }
    }

    public function getBodyEmail($curriculo)
    {
        $body = "
            <div>
                <div>
                    <label>Nome</label>
                    <input type='text' value='".$curriculo->getNome()."' />
                </div>
                <div>
                    <label>Email</label>
                    <input type='email' value='".$curriculo->getEmail()."' />
                </div>
                <div>
                    <label>Telefone</label>
                    <input type='text' value='".$curriculo->getTelefone()."' />
                </div>
                <div>
                    <label>Cargo Desejado</label>
                    <textarea>".$curriculo->getCargo()."</textarea>
                </div>
                <div>
                    <label>Escolaridade</label>
                    <input type='text' value='".$curriculo->getEscolaridadeName()."' />
                </div>
                <div>
                    <label>Observações</label>
                    <textarea>".$curriculo->getObservacoes()."</textarea>
                </div>
                <div>
                    <label>Data/Hora</label>
                    <input type='date' value='".$curriculo->getDateTime()->format('Y-m-d')."'>
                    <input type='time' value='".$curriculo->getDateTime()->format('H:i')."'>
                </div>
            </div>
        ";

        return $body;
    }
}