<?php namespace Model;

    class Usuarios extends ActiveRecord{
        protected static $tabla = 'usuarios';
        protected static $columnasDB = [
            'id',
            'Nombre',
            'Email',
            'Password',
            'Token',
            'Confirmado'
        ];

        public $id;
        public $Nombre;
        public $Email;
        public $Password;
        public $Token;
        public $Confirmado;

        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->Nombre = $args['Nombre'] ?? '';
            $this->Email = $args['Email'] ?? '';
            $this->Password = $args['Password'] ?? '';
            $this->Password_Actual = $args['Password_Actual'] ?? '';
            $this->Password_Nuevo = $args['Password_Nuevo'] ?? '';
            $this->PassConfirmar = $args['PassConfirmar'] ?? null;
            $this->Token = $args['Token'] ?? '';
            $this->Confirmado = $args['Confirmado'] ?? '0';
        }
        
        public function validarNuevaCuenta(){
            if(!$this->Nombre){
                self::$alertas['error'][] = 'El nombre del usuario es obligatorio';
            }

            if(!$this->Email){
                self::$alertas['error'][] = 'El email del usuario es obligatorio';
            }

            if(!$this->Password){
                self::$alertas['error'][] = 'El password no debe ir vacio';
            }

            if(strlen($this->Password) < 6){
                self::$alertas['error'][] = 'El password debe tener una extensión de al menos 6 carácteres';
            }

            if($this->Password !== $this->PassConfirmar){
                self::$alertas['error'][] = 'Los passwords son diferentes';
            }

            return self::getAlertas();
        }

        public function validarForget(){
            //Validar de que el Campo Email no este vacio.
            if(!$this->Email){
                self::$alertas['error'][] = 'Debes colocar tu email';
            }

            if(!filter_var($this->Email, FILTER_VALIDATE_EMAIL)){
                self::$alertas['error'][] = 'Debes insertar un email válido';
            }

            return self::getAlertas();
        }

        public function ValidarRestablecer(){
            if(!$this->Password){
                self::$alertas['error'][] = 'Debes colocar un password';
            }

            if(strlen($this->Password) < 6){
                self::$alertas['error'][] = 'El password debe tener una extensión de al menos 6 carácteres';
            }
            return self::getAlertas();
        }

        public function ValidarLogin(){
            if(!$this->Email){
                self::$alertas['error'][] = 'El email del usuario es obligatorio';
            }
            if(!filter_var($this->Email, FILTER_VALIDATE_EMAIL)){
                self::$alertas['error'][] = 'Debes insertar un email válido';
            }

            if(!$this->Password){
                self::$alertas['error'][] = 'El password no debe ir vacio';
            }

            return self::getAlertas();
        }
        
        public function ValidarPerfil(){
            if(!$this->Nombre){
                self::$alertas['error'][] = 'Debes colocar un nombre';
            }
            if(!$this->Email){
                self::$alertas['error'][] = 'Debes colocar un email';
            }
            return self::getAlertas();
        }

        public function ValidarCamposPassword(){
           
            if(!$this->Password_Actual){
                self::$alertas['error'][] = 'Es necesario colocar tu password actual para hacer una validación';
            }
            
            if(strlen($this->Password_Actual) < 6 || strlen($this->Password_Nuevo) < 6){
                self::$alertas['error'][] = 'El password debe ser de una extensión de 6 carácteres o más';
            }

            if(!$this->Password_Nuevo){
                self::$alertas['error'][] = 'Debes colocar un password nuevo';
            }

            return self::getAlertas();
        }

        public function PassHash(){
            $this->Password = password_hash($this->Password, PASSWORD_BCRYPT);
            return $this->Password;
        }

        public function HashPassNuevo(){
            $this->Password_Nuevo = password_hash($this->Password_Nuevo, PASSWORD_BCRYPT);
            return $this->Password_Nuevo;
        }

        public function Token(){
            $this->Token = uniqid();
            return $this->Token;
        }

        public function PasswordLogin($pass){

            //verificar por el password.
            $this->Password = password_verify($pass, $this->Password);
            
            if(!$this->Password){
                self::$alertas['error'][] = 'Password incorrecto';
            }else{
                return True;
            }
        }
    }
?>