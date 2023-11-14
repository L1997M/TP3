<?php
require_once './modelo/discoModeloApi.php';
require_once './vista/vistaApi.php';
require_once './helpers/authHelper.php';

class discoControllerApi{
    private $modelo;
    private $vista;
    private $data;
    private $authHelper;

    public function __construct(){
        $this->modelo= new discoModeloApi();
        $this->vista= new vistaApi();
        $this->authHelper= new authHelper();

        $this->data = file_get_contents("php://input");
    }

    private function getData(){
        return json_decode($this->data); //convertir el string recibido a json
    }   

    public function obtenerDiscos(){

        $order = $_GET['order'] ?? null; //el valor puede ser null
        $sortBy = $_GET['sort'] ?? null;
        $page =  $_GET['page'] ?? null;
        $limit = $_GET['limit'] ?? null;
        $genero = $_GET['genero'] ?? null;

        $columnas = array('id_disco','nombre','artista','sello_discografico','anio_lanzamiento','id_genero');
        $orden = array('asc', 'desc');
        $generos = array('Electronica','Pop','Rock','Hip_Hop','Jazz');
        
        
        if ((is_numeric($page) && ($page != 0) && is_numeric($limit)) && (in_array($sortBy, $columnas) && in_array($order, $orden)) && in_array($genero, $generos)) {
            $discos = $this->modelo->sortPageAndFilter($page, $limit, $sortBy, $order, $genero);
            $this->vista->response($discos); //si pongo pag 100 esta bien el arreglo vacio y el 200 porque no hay mas productos   
        } else if ((is_numeric($page) && ($page != 0) && is_numeric($limit)) && (in_array($sortBy, $columnas) && in_array($order, $orden))) {
            $discos = $this->modelo->sortAndPage($page, $limit, $sortBy, $order);
            $this->vista->response($discos);
        } else if ((in_array($sortBy, $columnas) && in_array($order, $orden)) && in_array($genero, $generos) && empty($page) && empty($limit)) {
            $discos = $this->modelo->sortAndFilter($sortBy, $order, $genero);
            $this->vista->response($discos);
        } else if ((is_numeric($page) && ($page != 0) && is_numeric($limit)) && in_array($genero, $generos) && empty($sortBy) && empty($order)) {
            $discos = $this->modelo->filterAndPage($page, $limit, $genero);
            $this->vista->response($discos);
        } else if (is_numeric($page) && ($page != 0) && is_numeric($limit) && empty($sortBy) && empty($order) && empty($genero)) {
            $discos = $this->modelo->pagination($page, $limit);
            $this->vista->response($discos);
        } else if (in_array($sortBy, $columnas) && in_array($order, $orden) && empty($page) && empty($limit)) {
            $discos = $this->modelo->sort($sortBy, $order);
            $this->vista->response($discos);
        } else if (in_array($genero, $generos) && empty($sort) && empty($order) && empty($page) && empty($limit)) {
            $discos = $this->modelo->filterBy($genero);
            $this->vista->response($discos);
        } else if ((empty($page) && empty($limit)) && empty($sortBy) && empty($order) && empty($genero)) {
 
            $discos = $this->modelo->sort();
            $this->vista->response($discos);
        } else {
            $this->vista->response("Verifique que lo ingresado sea correcto", 404);
        }
    } //el recurso productos existe aunque sea vacio entonces esta bien el 200

    function obtenerDisco ($params=null){
        $id=$params[':ID'];
            $disco= $this->modelo->obtenerDisco($id);
            if ($disco){
                $this->vista->response($disco);
            }
            else {
            $this->vista->response("El disco con el ID: $id no existe",404);
            }
        }
    function insertarDisco ($params=null){
            if(!$this->authHelper->isLoggedIn()){
                $this->vista->response("Necesitas loguearte para poder realizar esta accion", 401);
                return;
            }
            $disco=$this->getData();
            if(empty($disco->nombre)||empty($disco->artista)||empty($disco->anio_lanzamiento)||empty($disco->sello_discografico)||empty($disco->id_genero)){
                $this->vista->response("Complete los campos correspondientes",400);
            }
            else{
               $id=$this->modelo->insertarDisco($disco->nombre,$disco->artista,$disco->sello_discografico,$disco->anio_lanzamiento,$disco->id_genero);
               $disco=$this->modelo->obtenerDisco($id);
               $this->vista->response("Carga del disco con exito con el ID: $id",201);
            }
        }
    function modificarDisco($params=null){
        if(!$this->authHelper->isLoggedIn()){
            $this->vista->response("Necesitas loguearte para poder realizar esta accion", 401);
            return;
        }
        $id=$params[':ID'];
        $body=$this->getData();
        $disco=$this->modelo->obtenerDisco($id);
        if(empty($body->nombre)||empty($body->artista)||empty($body->anio_lanzamiento)||empty($body->sello_discografico)||empty($body->id_genero)){
            $this->vista->response("Complete los campos correspondientes",400);
        }
        else {
            if ($disco){
                $this->modelo->modificarDisco($body->nombre,$body->artista,$body->sello_discografico,$body->anio_lanzamiento,$body->id_genero,$id);
                $this->vista->response("El disco se modifico con exito",200);
            }
            else {
                $this->vista->response("El disco que se quiere modificar no existe",404);
                }
        }
    }
}
