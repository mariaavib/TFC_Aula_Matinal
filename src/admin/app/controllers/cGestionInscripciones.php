<?php
class CGestionInscripciones{
    private $obj_modelo;
    public $vista;

    public $mensaje;

    public function __construct(){
        require_once(RUTA_MODELOS.'GestionInscripciones.php');
        $this->obj_modelo = new MGestionInscripciones();
    }

    public function alta(){
        $this->vista = 'vAltaInscripcion';
        $datos = $this->obj_modelo->listarclases();
        return $datos;
    }

    public function insertar(){
        print_r($_POST);
        // if(empty($_POST['']) && empty())
    }

    public function alumnosinscritos(){
        $this->vista = 'vAlumnosInscritos';
        $datos = $this->obj_modelo->alumnosinscritos();
        if(is_string($datos)){
            $this->mensaje = $datos;
            return $this->mensaje;
        }else{
            return $datos; //si no es un string, es un array con los datos de los alumnos inscritos
        }
    }

    public function consultardatos(){
        $this->vista = 'vConsultarDatos';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $datos = $this->obj_modelo->datosAlumnosinscritos($id);
        }
        
        if(is_string($datos)){
            $this->mensaje = $datos;
            return $this->mensaje; 
        }else{
            return $datos; //si no es un string, es un array con los datos del alumno
        }
    }

    public function modificacion(){
        $this->vista = 'vModificarInscripcion';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $datos = $this->obj_modelo->datosAlumnosinscritos($id);
            $clases = $this->obj_modelo->listarclases();
        }
        
        if(is_string($datos) && is_string($clases)){
            $this->mensaje = $datos;
            return $this->mensaje; 
        }else{
            return [
                'datos' => $datos,
                'clases' => $clases
            ]; 
        }
    }

    public function modificarInscripcion(){
        
    }

    public function inscripcionesincompletas(){
        $this->vista = 'vInscripcionesIncompletas';
        $datos = $this->obj_modelo->inscripcionesincompletas();
        if(is_string($datos)){
            $this->mensaje = $datos;
            return $this->mensaje;
        }else{
            return $datos; //si no es un string, es un array con los datos de los alumnos inscritos
        }
    }
}


?>