<?php

namespace App\Http\Service;

class ValidaMatrizService
{

    /**
     * Metodo que valida los parametros basicos de entrada
     * 'txtNumCaso' -> numero de casos
     * 'txtMatriz' -> dimension de la matriz y cantidad de ejecuciones
     *
     * @param array $arrParm
     * @return array
     */
    public static function validaParmBasico($arrParm)
    {

        if ($arrParm['txtNumCaso'] < 1 OR $arrParm['txtNumCaso'] > 50)
            return ['codResp' => 0,
                'msj' => 'el n&uacute;mero de casos debe ser: 1 <= T <= 50 '];

        $arrMatriz = explode(' ', $arrParm['txtMatriz']);
        if (sizeof($arrMatriz) <> 2)
            return ['codResp' => 0,
                'msj' => 'El parametro de Matriz y Ejecución debe contener 2 parametros requeridos, ejemplo: N M  &oacute; 4 5 '];

        if (!is_numeric($arrMatriz[0]) OR !is_numeric($arrMatriz[1]))
            return ['codResp' => 0,
                'msj' => 'El parametro de Matriz y Ejecución debe contener 2 parametros requeridos, y deben ser n&uacute;merico'];

        if ($arrMatriz[0] < 1 OR $arrMatriz[1] < 1 OR $arrMatriz[0] > 100 OR $arrMatriz[1] > 1000)
            return ['codResp' => 0,
                'msj' => 'Los parametros de matriz y ejecuci&oacute;n deben ser:  1 <= N <= 100  y  1 <= M <= 1000 '];

        return ['codResp' => 1];
    }

    /**
     * Metodo que valida el tipo de operacion
     * a ejecutar y su correcta parametrizaciob
     *
     * @param string $operacion
     * @return array
     */
    public static function validaParmOperacion($operacion)
    {
        $arrOperacion = explode(' ', $operacion);
        $pathJson = _PATH_PRIVADO . 'public/matriz.json';//Path ubicacion matriz
        $dataMatrizJson = file_get_contents($pathJson);//obetenemos informacion del json
        $dataMatrizJson = json_decode($dataMatrizJson, true);

        if ($arrOperacion[0] <> 'UPDATE' AND $arrOperacion[0] <> 'QUERY')
            return ['codResp' => 0,
                'msj' => 'La operacion debe ejecutarse con las palabras UPDATE o QUERY Ejemplo: UPDATE x y z W &oacute; QUERY  x1 y1 z1 x2 y2 z2'];

        if ($arrOperacion[0] == 'UPDATE') {
            if (sizeof($arrOperacion) <> 5)
                return ['codResp' => 0,
                    'msj' => 'La operacion UPDATE debe ejecutarse de la siguiente manera Ejemplo: UPDATE x y z W '];

            if (!is_numeric($arrOperacion[1]) OR !is_numeric($arrOperacion[2]) OR !is_numeric($arrOperacion[3])
                OR !is_numeric($arrOperacion[4])
            )
                return ['codResp' => 0,
                    'msj' => 'La operacion UPDATE debe ejecutarse de la siguiente manera Ejemplo: UPDATE x y z W donde x y z W son numericos '];

            if ($arrOperacion[1] < 1 OR $arrOperacion[2] < 1 OR $arrOperacion[3] < 1
                OR $arrOperacion[1] > $dataMatrizJson['n'] OR $arrOperacion[2] > $dataMatrizJson['n']
                OR $arrOperacion[3] > $dataMatrizJson['n']
            )
                return ['codResp' => 0,
                    'msj' => 'Los parametros xyz de la operacion UPDATE deben ser: 1 <= x,y,z <= N'];

            if ($arrOperacion[4] < pow(-10, 9) OR $arrOperacion[4] > pow(10, 9))
                return ['codResp' => 0,
                    'msj' => 'El parametro W debe ser: -10^9 <= W <= 10^9'];
        }

        if ($arrOperacion['0'] == 'QUERY') {
            if (sizeof($arrOperacion) <> 7)
                return ['codResp' => 0,
                    'msj' => 'La operacion QUERY debe ejecutarse de la siguiente manera Ejemplo: QUERY x1 y1 z1 x2 y2 z2 '];

            if (!is_numeric($arrOperacion[1]) OR !is_numeric($arrOperacion[2]) OR !is_numeric($arrOperacion[3])
                AND !is_numeric($arrOperacion[4]) OR !is_numeric($arrOperacion[5]) OR !is_numeric($arrOperacion[6])
            )
                return ['codResp' => 0,
                    'msj' => 'La operacion QUERY debe ejecutarse de la siguiente manera Ejemplo: QUERY x1 y1 z1 x2 y2 z2 donde x y z son numericos '];

            if ($arrOperacion[1] > $arrOperacion[4] OR $arrOperacion[1] < 1 OR $arrOperacion[1] > $dataMatrizJson['n']
                OR $arrOperacion[4] < 1 OR $arrOperacion[4] > $dataMatrizJson['n']
            )
                return ['codResp' => 0,
                    'msj' => 'Los parametros de la operacion QUERY debe ser: 1 <= x1 <= x2 <= N'];
            if ($arrOperacion[2] > $arrOperacion[5] OR $arrOperacion[2] < 1 OR $arrOperacion[2] > $dataMatrizJson['n']
                OR $arrOperacion[5] < 1 OR $arrOperacion[5] > $dataMatrizJson['n']
            )
                return ['codResp' => 0,
                    'msj' => 'Los parametros de la operacion QUERY debe ser: 1 <= y1 <= y2 <= N'];
            if ($arrOperacion[3] > $arrOperacion[6] OR $arrOperacion[3] < 1 OR $arrOperacion[3] > $dataMatrizJson['n']
                OR $arrOperacion[6] < 1 OR $arrOperacion[6] > $dataMatrizJson['n']
            )
                return ['codResp' => 0,
                    'msj' => 'Los parametros de la operacion QUERY debe ser: 1 <= z1 <= z2 <= N'];
        }

        return ['codResp' => 1];
    }
}