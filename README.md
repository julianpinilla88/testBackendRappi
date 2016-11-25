# testBackendGrability
Prueba Técnica para el BackEnd de Grability

## Backend Software Developer Test

Prueba tecnica para cargo BackEnd Developer Grability|Rappi

## Acceso a la prueba 

+ Enters from here to [test] (http://ec2-54-208-170-78.compute-1.amazonaws.com/testBackendRappi/public/)

## Ejemplo

**Ejemplo 1:**
2
4 5
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
UPDATE 1 1 1 23
QUERY 2 2 2 4 4 4
QUERY 1 1 1 3 3 3

![Alt text](http://ec2-54-208-170-78.compute-1.amazonaws.com/EJEMPLO1.jpg "Ejemplo 1")

**Ejemplo 2:**
2
2 4
UPDATE 2 2 2 1
QUERY 1 1 1 1 1 1
QUERY 1 1 1 2 2 2
QUERY 2 2 2 2 2 2

![Alt text](http://ec2-54-208-170-78.compute-1.amazonaws.com/EJEMPLO2.jpg "Ejemplo 2")


## Capas de aplicacion

Laravel estandariza el patron de diseño MVC, en el cual para poder interrelacionar y etructurarlo adecuadamente se utilizaron las siguientes capas que conforman MVC

**Presentación:** para la capa de presentación se utilizo *Bootstrap* y *HTML* por medio del motor de plantillas de *laravel Blade*

+ Directorio *\resources\views\layout* se encuentran las plantillas por defecto de la aplicacion y la implementación de bootstrap.
+ Directorio *\resources\views* se encuentra el index de la aplicación en ella se encuentra los input basicos para la prueba.
+ Directorio *\resources\views\Matriz* se encuentra la plantilla para la ejecución de las operaciones UPDATE y QUERY
+ Directorio *\resources\views\message* se encuentran las plantillas para la presentación de mensajes de validación tanto propios como de laravel.

**Negocio:** para la capa de negocio e implementación se utilizan controladores generados en PHP, el cual controla las acciones sobre las solicitudes que se generan en la capa de presentación.

+ Directorio *\app\Http\Controllers* se encuentran los controladores FrontController.php y MatrizController.php.
+ Directorio *\app\Http\Requests* se encuentran los validadores de laravel FrontRequest.php y MatrizRequest.php.

**Persistencia:** para la capa de persistencia se utiliza servicios en PHP, el cual ejecuta la solicitud indicada desde el controlador.

+ Directorio *\app\Http\Service* se encuentran los archivo Service.php y ValidaMatrizService.php

## Responsabilidad de las clases

+ Clase **FrontController.php** es la clase mas basica, esta clase redirecciona al index principal de la aplicación.
+ Clase **MatrizController.php** es la clase encargada de redireccionar al index de ejecución de operaciones, y la que solicita la ejecucion de las operaciones UPDATE y QUERY.
+ Clase **Service.php** es la clase encargada de validar la existencia de el archivo matriz.json el cual consiste en la información respectiva a los parametros iniciales y las ejecuciones realizadas, en el caso en que no exista la aplicacion lo crea en el directorio *\public\matriz.json*. Tambien de acuerdo a la información registrada la clase contiene metodos que obtienen la información para su respectiva operación, ya sea creando una nueva posición de la matriz o sumando los valores de la matriz.
+ Clase **ValidaMatrizService.php** es la clase encargada de validar los valores ingresados ya sea el ingreso de T, N y M como las ejecuciones UPDATE x y z W o QUERY x1 y1 z1 x2 y2 z2.

**Nota:** El archivo matriz.json es utilizado para no sobreutilizar la memoria disponible en el server y sobre la aplicación asi la aplicación es mas agil sobre la lectura de un archivo que contiene el arreglo de la información tanto de los parametros basicos como de las ejecuciones realizadas.


## Componentes Usardos

+ [Bootstrap] http://getbootstrap.com/

### Framework

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
