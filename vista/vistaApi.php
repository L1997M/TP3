<?php
class vistaApi {

public function response($data, $status = 200) { //data es mi objeto json
    header("Content-Type: application/json");
    header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));//llama al metodo de abajo
   // convierte los datos a un formato json
    echo json_encode($data);
}

private function _requestStatus($code){
    $status = array(
      200 => "OK",
      201 => "Created", 
      400 => "Bad Request",
      401=> "Unauthorized",
      404 => "Not Found",
      500=> "Internal Server Error"
    );
    return (isset($status[$code])) ? $status[$code] : $status[500]; //esto es un if
  }

}