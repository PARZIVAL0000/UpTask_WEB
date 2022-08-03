<?php namespace Model;

    class Tareas extends ActiveRecord{
        protected static $tabla = 'tareas'; 
        protected static $columnasDB = [
            'id',
            'Nombre',
            'Estado', 
            'ProyectoId'
        ];

        public $id;
        public $Nombre;
        public $Estado;
        public $ProyectoId;

        public function __construct($args = []){
            $this->id = $args['id'] ?? null; 
            $this->Nombre = $args['Nombre'] ?? '';
            $this->Estado = $args['Estado'] ?? '0';
            $this->ProyectoId = $args['ProyectoId'] ?? '';
        }



    }

?>