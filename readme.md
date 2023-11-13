
# Vinilos API
Esta API REST nos permite manejar un CRUD de vinilos trayendo toda su informacion la cual se puede ordenar, paginar y filtrar por genero.

## Importar base de datos
Desde phpMyAdmin importar database/vinilos_db.sql.

Se registran los discos y  los generos en distintas tablas.

Discos contiene las siguientes columnas :**(int) id_disco, (varchar) nombre , (varchar) artista , (varchar) sello_discografico , (varchar) anio_lanzamiento ,(int) id_genero**

Generos contiene las siguientes columnas : ** (int) id_genero, (varchar) nombre , (varchar) descripcion**
 
# Requests
### Prueba desde postman
Se debe colocar la siguiente URL http://localhost/TP3/api/discos para discos.

## GET (ALL)
Para obtener todos los registros de los discos.

verbo: GET

http://localhost/TP3/api/discos

## Listar solo un disco:
verbo: GET

http://localhost/TP3/api/discos/:id


## Crear un nuevo disco:
verbo: POST

Para crearlo deberiamos colocar en el body un objeto con los siguientes campos completos:
{
        "nombre": ---,
        "artista": ---,
        "sello_discografico": ---,
        "anio_lanzamiento": ---,
        "id_genero": ---,
        
}

El nombre, artista, sello_discografico son varchar , anio_lanzamiento es int e id_genero es un int que tiene que estar si o si en la tabla genero.


## Editar un disco:
verbo: PUT

http://localhost/TP3/api/discos/:id

Para editar un disco se debe colocar en la url el id del disco que se quiere editar y en el body el json con los nuevos valores de los campos (nombre,artista,sello_discografico, anio_lanzamiento, id_genero).


## Filtrado:
Solo se podra filtrar por gemero, para hacerlo a nuestra url se le agrega el parametro
genero seguido de lo que se quiere filtrar:

http://localhost/TP3/api/discos?genero=Rock

El ejemplo nos devolvera todos los discos del genero Rock.

## Orden: 
Para que la lista de discos se muestre ordenada por uno de sus campos de forma ascendente
o descendente debemos agregarle a la url el parametro sort y order(asc o desc):

http://localhost/TP3/api/discos?sort=nombre&order=desc

El ejemplo nos devolveria todos los discos ordenados por nombre de forma descendente.

## Paginacion:
Para paginar los discos debemos agregar los parametros page y limit, donde el page indica
el numero de pagina y el limit la cantidad de discos que queremos ver por pagina:

http://localhost/TP3/api/discos?page=1&limit=2

El ejemplo nos devolveria los 2 discos que se encuentran en la pagina 1.


Los 3 items anteriores pueden combinarse entre si, asi sean 2 o 3, por ejemplo:

http://localhost/TP3/api/discos?sort=nombre&order=desc&page=1&limit=2

se ordena por nombre de manera descendente y al mismo tiempo se pagina.

Ejemplo con los 3 items: http://localhost/TP3/api/discos?sort=nombre&order=desc&page=1&limit=2&genero=Rock
todos los productos resultantes del filtrado se van a ordenar y paginar.


## Resumen
|Route		    | Method	  |   Description
|---------------|:---------:  |-----------------------------------------------------:
|/discos	    | GET	      | Retorna todos los discos
|/discos/:id 	|GET	      | Retorna un disco con el id especificado
|/discos	    |  POST	      |Se crea un nuevo disco con lo colocado en el body
|/discos/:id	|  PUT	      | Edita el disco con el id especificado


## Token
Para realizar actualizacionesde discos debemos tener permiso, para eso debemos ingresar usuario (webadmin) y contraseña(admin) en authorization con el type Basic Auth, luego en la URL colocar http://localhost/TP3/api/auth/token cuando se clickee en send se generara un token (por 15min) el cual hay que colocar en authorization type bearer token y en la url http://localhost/TP3/api/discos luego de esto ya se podra editar discos.


## Codigos de respuesta:
|Status| Mensaje    |Significado
|----  |:----------:|-----------------------------------------------------:
|200   |OK          |Si la solicitud ha tenido exito.
|201   |Created     |Como resultado de la solicitus se ha creado un nuevo recurso.
|400   | Bad Request|Indica que el servidor no puede procesar la peticion debido a un error del cliente.
|401   |Unauthorized|Indica que la peticion no ha sido ejecutada porque carece de credenciales validas de autenticacion.
|404   |Not Found   |Indica que el host ha sido capaz de comunicarse con el servidor, pero no existe el recurso que ha sido pedido.

