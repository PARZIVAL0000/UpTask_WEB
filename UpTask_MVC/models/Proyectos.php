<?php namespace Model;

    class Proyectos extends ActiveRecord{

        protected static $tabla = 'proyectos';
        protected static $columnasDB = [
            'id', 
            'Proyecto', 
            'Url', 
            'PropietarioId'
        ]; 

        public $id;
        public $Proyecto;
        public $Url;
        public $PropietarioId;

        public function __construct($args = []){
            $this->id = $args['id'] ?? null;
            $this->Proyecto = $args['Proyecto'] ?? '';
            $this->Url = $args['Url'] ?? '';
            $this->PropietarioId = $args['PropietarioId'] ?? '';
        }

        public function validacionProyect(){
            if(!$this->Proyecto){
                self::$alertas['error'][] = 'Debes colocar un tema para tu proyecto';
            }
            return self::$alertas;
        }
        
    }

?>