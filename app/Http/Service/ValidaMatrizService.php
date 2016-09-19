<?php

namespace App\Http\Service;

class ValidaMatrizService
{
    const MSJ_CASO_NUM_PERMITIDO = 'el n&uacute;mero de casos debe ser: 1 <= T <= 50 ';
    const MSJ_CASO_POS_ARR = 'El parametro de Matriz y Ejecución debe contener 2 parametros requeridos, ejemplo: N M  &oacute; 4 5 ';
    const MSJ_CASO_NUMERICO = 'El parametro de Matriz y Ejecución debe contener 2 parametros requeridos, y deben ser n&uacute;merico';
    const MSJ_MATRIZ_NUM_PERMITIDO = 'Los parametros de matriz y ejecuci&oacute;n deben ser:  1 <= N <= 100  y  1 <= M <= 1000 ';
    const MSJ_TIPO_OPERACION = 'La operacion debe ejecutarse con las palabras UPDATE o QUERY Ejemplo: UPDATE x y z W &oacute; QUERY  x1 y1 z1 x2 y2 z2';
    const MSJ_UPD_OPERACION_POS_ARR = 'La operacion UPDATE debe ejecutarse de la siguiente manera Ejemplo: UPDATE x y z W ';
    const MSJ_UPD_NUMERICO = 'La operacion UPDATE debe ejecutarse de la siguiente manera Ejemplo: UPDATE x y z W donde x y z W son numericos';
    const MSJ_UPD_NUM_PERMITIDO = 'Los parametros xyz de la operacion UPDATE deben ser: 1 <= x,y,z <= N';
    const MSJ_UPD_VALOR_PERMITIDO = 'El parametro W debe ser: -10^9 <= W <= 10^9';
    const MSJ_QUERY_POS_ARR = 'La operacion QUERY debe ejecutarse de la siguiente manera Ejemplo: QUERY x1 y1 z1 x2 y2 z2';
    const MSJ_QUERY_NUMERICO = 'La operacion QUERY debe ejecutarse de la siguiente manera Ejemplo: QUERY x1 y1 z1 x2 y2 z2 donde x y z son numericos';
    const MSJ_QUERY_NUM_PERMITIDO_X = 'Los parametros de la operacion QUERY debe ser: 1 <= x1 <= x2 <= N';
    const MSJ_QUERY_NUM_PERMITIDO_Y = 'Los parametros de la operacion QUERY debe ser: 1 <= y1 <= y2 <= N';
    const MSJ_QUERY_NUM_PERMITIDO_Z = 'Los parametros de la operacion QUERY debe ser: 1 <= z1 <= z2 <= N';

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
        $numCaso = $arrParm['txtNumCaso'];
        $matrizEjecucion = $arrParm['txtMatriz'];

        if ($numCaso < 1 OR $numCaso > 50)
            return ['codResp' => 0,
                'msj' => self::MSJ_CASO_NUM_PERMITIDO];

        $arrMatriz = explode(' ', $matrizEjecucion);
        if (sizeof($arrMatriz) <> 2)
            return ['codResp' => 0,
                'msj' => self::MSJ_CASO_POS_ARR];

        if (!is_numeric($arrMatriz[0]) OR !is_numeric($arrMatriz[1]))
            return ['codResp' => 0,
                'msj' => self::MSJ_CASO_NUMERICO];

        if ($arrMatriz[0] < 1 OR $arrMatriz[1] < 1 OR $arrMatriz[0] > 100 OR $arrMatriz[1] > 1000)
            return ['codResp' => 0,
                'msj' => self::MSJ_MATRIZ_NUM_PERMITIDO];

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
        $arrOperacion[0] = strtoupper($arrOperacion[0]);

        if ($arrOperacion[0] <> 'UPDATE' AND $arrOperacion[0] <> 'QUERY')
            return ['codResp' => 0,
                'msj' => self::MSJ_TIPO_OPERACION];

        if ($arrOperacion[0] == 'UPDATE') {
            if (sizeof($arrOperacion) <> 5)
                return ['codResp' => 0,
                    'msj' => self::MSJ_UPD_OPERACION_POS_ARR];

            if (!is_numeric($arrOperacion[1]) OR !is_numeric($arrOperacion[2]) OR !is_numeric($arrOperacion[3])
                OR !is_numeric($arrOperacion[4])
            )
                return ['codResp' => 0,
                    'msj' => self::MSJ_UPD_NUMERICO];

            if ($arrOperacion[1] < 1 OR $arrOperacion[2] < 1 OR $arrOperacion[3] < 1
                OR $arrOperacion[1] > $dataMatrizJson['n'] OR $arrOperacion[2] > $dataMatrizJson['n']
                OR $arrOperacion[3] > $dataMatrizJson['n']
            )
                return ['codResp' => 0,
                    'msj' => self::MSJ_UPD_NUM_PERMITIDO];

            if ($arrOperacion[4] < pow(-10, 9) OR $arrOperacion[4] > pow(10, 9))
                return ['codResp' => 0,
                    'msj' => self::MSJ_UPD_VALOR_PERMITIDO];
        }

        if ($arrOperacion[0] == 'QUERY') {
            if (sizeof($arrOperacion) <> 7)
                return ['codResp' => 0,
                    'msj' => self::MSJ_QUERY_POS_ARR];

            if (!is_numeric($arrOperacion[1]) OR !is_numeric($arrOperacion[2]) OR !is_numeric($arrOperacion[3])
                AND !is_numeric($arrOperacion[4]) OR !is_numeric($arrOperacion[5]) OR !is_numeric($arrOperacion[6])
            )
                return ['codResp' => 0,
                    'msj' => self::MSJ_QUERY_NUMERICO];

            if ($arrOperacion[1] > $arrOperacion[4] OR $arrOperacion[1] < 1 OR $arrOperacion[1] > $dataMatrizJson['n']
                OR $arrOperacion[4] < 1 OR $arrOperacion[4] > $dataMatrizJson['n']
            )
                return ['codResp' => 0,
                    'msj' => self::MSJ_QUERY_NUM_PERMITIDO_X];
            if ($arrOperacion[2] > $arrOperacion[5] OR $arrOperacion[2] < 1 OR $arrOperacion[2] > $dataMatrizJson['n']
                OR $arrOperacion[5] < 1 OR $arrOperacion[5] > $dataMatrizJson['n']
            )
                return ['codResp' => 0,
                    'msj' => self::MSJ_QUERY_NUM_PERMITIDO_Y];
            if ($arrOperacion[3] > $arrOperacion[6] OR $arrOperacion[3] < 1 OR $arrOperacion[3] > $dataMatrizJson['n']
                OR $arrOperacion[6] < 1 OR $arrOperacion[6] > $dataMatrizJson['n']
            )
                return ['codResp' => 0,
                    'msj' => self::MSJ_QUERY_NUM_PERMITIDO_Z];
        }

        return ['codResp' => 1];
    }
}