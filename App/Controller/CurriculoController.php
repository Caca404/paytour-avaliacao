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
            $curriculo = new Curriculo(
                $_POST['nome'],
                $_POST['email'],
                $_POST['telefone'],
                $_POST['cargo'],
                $_POST['escolaridade'],
                $_POST['observacoes'],
                null,
                $_POST['dthr']
            );

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
            $stmt->bindValue(1, $curriculo->nome);
            $stmt->bindValue(2, $curriculo->email);
            $stmt->bindValue(3, $curriculo->telefone);
            $stmt->bindValue(4, $curriculo->cargo);
            $stmt->bindValue(5, $curriculo->escolaridade);
            $stmt->bindValue(6, $curriculo->observacoes);
            $stmt->bindValue(7, md5($curriculo->nome.date('Y-m-d h:i:s')));
            $stmt->bindValue(8, $curriculo->dthr->format("Y-m-d h:i:s"));
            $stmt->bindValue(9, $_SERVER['REMOTE_ADDR']);

            if($stmt->execute()) return $this->sendEmail($curriculo);
            else
                return ["status" => 500, "message" => "Curriculo não foi enviado"];
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
            $mail->addAddress($curriculo->email, $curriculo->nome);               //Name is optional
        
            //Attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Seu currículo foi enviado para nós!';
            $mail->Body = 'Olá, '.$curriculo->nome.', seu curriculo foi enviado!<br>
                Aqui está suas informações enviadas:';
            $mail->AltBody = 'Olá, '.$curriculo->nome.', seu curriculo foi enviado!
            Aqui está suas informações enviadas:';
        
            if($mail->send())
                return ["status" => 200, "message" => "Currículo enviado!"];
            else return ["status" => 500, "message" => "Algo errado!"];
            
        } catch (Exception $e) {
            return [
                "status" => 500, 
                "message" => "Currículo enviado mas o email não foi enviado!", 
                "textBody" => $mail->ErrorInfo
            ];
        }
    }
}