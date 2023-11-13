<?php

class discoModeloApi{
    private $db;
    function __construct(){
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=vinilos_db;charset=utf8', 'root', '');

    }
    
    function getAll(){
        $query = 'SELECT discos.*, genero.nombre as genero FROM discos JOIN genero ON discos.id_genero = genero.id_genero ';
        return $query;
    }

    function prepare($query)
    {
        $respuesta = $this->db->prepare($query);
        $respuesta->execute();
        return $respuesta->fetchAll(PDO::FETCH_OBJ);
    }
    function sortPageAndFilter($page, $limit, $sortBy, $order, $genero){
        $query = $this->getAll();
        $offset = $page * $limit - $limit;
        $query .= 'WHERE genero.nombre = "' . $genero . ' " ORDER BY ' . $sortBy . ' ' . $order . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        return $this->prepare($query);

    }
    function sortAndPage($page, $limit, $sortBy, $order){
        $query = $this->getAll();
        $offset = $page * $limit - $limit;
        $query .= 'ORDER BY ' . $sortBy . ' ' . $order . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        return $this->prepare($query);

    }
    function sortAndFilter($sortBy, $order, $genero){
        $query = $this->getAll();
        $query .= 'WHERE genero.nombre= "' . $genero . '"' . 'ORDER BY ' . $sortBy . ' ' . $order;
        return $this->prepare($query);
        

    }
    function filterAndPage($page, $limit, $genero){
        $query = $this->getAll();
        $offset = $page * $limit - $limit;
        $query .= 'WHERE genero.nombre= "' . $genero . '" LIMIT ' . $limit . ' OFFSET ' . $offset;
        return $this->prepare($query);
        
    }
    function pagination($page, $limit){
        $query = $this->getAll();
        $offset = $page * $limit - $limit;
        $query .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        return $this->prepare($query);

    }
    function sort ($sortBy = "id_disco", $order = "asc"){
        $query = $this->getAll();
        $query .= 'ORDER BY ' . $sortBy . ' ' . $order;
        return $this->prepare($query);

    }
    function filterBy($genero){
        $query = $this->getAll();
        $query .= 'WHERE genero.nombre = "' . $genero . '"';
        return $this->prepare($query);

    }
    function obtenerDisco($id) {
        $query = $this->db->prepare("SELECT discos.*, genero.nombre as genero FROM discos JOIN genero ON discos.id_genero = genero.id_genero WHERE id_disco = ?");
        $query->execute(array($id));
        $disco= $query->fetch(PDO::FETCH_OBJ);  // devuelve un arreglo de objetos
        return $disco;

    }
    public function insertarDisco($nombre,$artista,$sello,$añoLanzamiento,$genero) {
        $query = $this->db->prepare ("INSERT INTO discos (nombre,artista,sello_discografico,anio_lanzamiento,id_genero) VALUES (?,?,?,?,?) ");
        $query->execute([$nombre,$artista,$sello,$añoLanzamiento,$genero]);
        return $this->db->lastInsertId();
    }
    public function modificarDisco($nombre,$artista,$sello,$añoLanzamiento,$genero, $id_disco) {
        $query = $this->db->prepare("UPDATE discos SET nombre = ?, artista = ?, sello_discografico = ?, anio_lanzamiento = ?, id_genero = ? WHERE id_disco = ?");
        $query->execute([$nombre,$artista,$sello,$añoLanzamiento,$genero,$id_disco]);
       
       
        

    }
}
