<?php namespace Mail;

use PHPMailer\PHPMailer\PHPMailer;
    class Mail{
        protected $Nombre;
        protected $Email;
        protected $Token;

        public function __construct($nombre, $email, $token)
        {
            $this->Nombre = $nombre;
            $this->Email = $email;
            $this->Token = $token;
        }

        public function EmailSend(){
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'f12b5fba027f31';
            $mail->Password = 'f037598f908feb';

            $mail->setFrom('Uptask@uptask.com', 'Centro Uptask');
            $mail->addAddress("{$this->Email}", 'User Uptask');

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Email de confirmación de cuenta';
            $contenido = "<html>";
            $contenido .= "     <body>";
            $contenido .= "         <h1>Confirmación de cuenta</h1>";
            $contenido .= "         <p>Estimado Usuario : <strong>{$this->Nombre}</strong>. Su cuenta (<strong>{$this->Email}</strong>) ha sido creada correctamente. Pero debe confirmarla,</p>";
            $contenido .= "         <p>para poder hacer uso de ella debe ingresar al siguiente enlace:  <a href='http://localhost:3000/confirmacion?token=". $this->Token ."'>Confirmar Mi Cuenta</a></p>";
            $contenido .= "         <p>Si tú no creaste esta cuenta, puedes ignorarla sin ningún problema</p>";
            $contenido .= "     </body>";
            $contenido .= "</html>";
            $mail->Body = $contenido;
            $mail->AltBody = 'Mensaje para poder confirmar cuenta creada';

            $mail->send();
            
        }


        public function EmailForget(){
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'f12b5fba027f31';
            $mail->Password = 'f037598f908feb';

            $mail->setFrom('Uptask@uptask.com', 'Centro Uptask');
            $mail->addAddress("{$this->Email}", 'User Uptask');

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Email de Reestablecer mi Cuenta';
            $contenido = "<html>";
            $contenido .= "     <body>";
            $contenido .= "         <h1>Cambiar password de mi cuenta Uptask</h1>";
            $contenido .= "         <p>Estimado Usuario : <strong>{$this->Nombre}</strong>. Parece que ha olvidado su password.</p>";
            $contenido .= "         <p>Para lograr colocar un nuevo password y tener nuevamente acceso a tu cuenta ingresa al siguiente enlace:  <a href='http://localhost:3000/reestablecer?token=". $this->Token ."'>Cambiar mi password</a></p>";
            $contenido .= "         <p>Si por alguna razón usted no solicitó este cambio puede ignorar este mensaje.</p>";
            $contenido .= "     </body>";
            $contenido .= "</html>";
            $mail->Body = $contenido;
            $mail->AltBody = 'Mensaje para cambiar password de mi cuenta Uptask';

            $mail->send();
        }
    }
?>