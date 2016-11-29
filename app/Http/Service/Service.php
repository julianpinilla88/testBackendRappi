<?php

namespace App\Http\Service;

use App\User;
use App\EstUser;
use App\RoleXUser;
use App\RoleXPermission;
use App\Role;
use Session;

class Service
{

    const PATH_JSON_MATRIZ = _PATH_PRIVADO . 'public/matriz.json';//Path ubicacion matriz
    const MSJ_UPD_LIMIT_CASO = 'Se supero el numero de casos';
    const MSJ_UPD_LIMIT_OPERACION = 'Se supero el numero de operaciones';

    /**
     * Metodo que valida si el archivo matriz.json existe
     *
     * @param array $arrParms
     */
    public function existeFileJson($arrParms)
    {
        if (file_exists(self::PATH_JSON_MATRIZ))
            $this::creaFileJson([]);

        $this::construirJson($arrParms);
    }

    /**
     * Metodo que crea el archivo matriz.json
     *
     * @param array $arrParm
     */
    private function creaFileJson($arrParm)
    {
        $json_string = json_encode($arrParm);
        file_put_contents(self::PATH_JSON_MATRIZ, $json_string);
    }

    /**
     * Metodo que construye arreglo inicial y lo
     * transforma en un json para su respectiva consulta
     *
     * @param array $arrParms
     */
    private function construirJson($arrJson)
    {
        $arrJson['ejecucion'] = ['cantUpdate' => 0, 'cantEjecucion' => 0];
        $this::creaFileJson($arrJson);
    }

    /**
     * Metodo que valida el tipo de ejecucion a realizar
     * 'UPDATE' -> actualiza la posiscion respectiva
     * 'QUERY' -> Ejecuta operacion de suma sobre las posiciones
     *
     * @param array $operacion
     * @return array
     */
    public function validaOperacion($operacion)
    {
        $arrOpe = explode(' ', trim($operacion));
        $dataMatrizJson = file_get_contents(self::PATH_JSON_MATRIZ);
        $arrDataMatriz = json_decode($dataMatrizJson, true);
        $arrOpe[0] = strtoupper($arrOpe[0]);
        if ($arrOpe[0] == 'UPDATE') {
            return $this->actualizaMatriz($arrDataMatriz, $arrOpe, $operacion);
        } elseif ($arrOpe[0] == 'QUERY') {
            return $this->calculaMatriz($arrDataMatriz, $arrOpe, $operacion);
        }
    }

    /**
     * Metodo que actualiza el valor de la posicion especificada
     * y calcula la cantidad de ejecuciones realizadas
     *
     * @param array $arrDataMatriz
     * @param array $arrOpe
     * @param array $operacion
     * @return array
     */
    private function actualizaMatriz($arrDataMatriz, $arrOpe, $operacion)
    {
        if ($arrDataMatriz['ejecucion']['cantUpdate'] < $arrDataMatriz['t']
            && $arrDataMatriz['ejecucion']['cantEjecucion'] < $arrDataMatriz['m']
        ) {
            $arrDataMatriz['ejecucion']['cantUpdate'] += 1;
            $arrDataMatriz['ejecucion']['cantEjecucion'] += 1;
        } else {
            return ['codResp' => 0,
                'msj' => self::MSJ_UPD_LIMIT_CASO,
                'operacion' => $arrDataMatriz['operacion']];
        }

        $arrDataMatriz['matriz'][$arrOpe[1]][$arrOpe[2]][$arrOpe[3]] = strtoupper($arrOpe[4]);
        $arrDataMatriz['operacion'][] = ['operacion' => strtoupper($operacion), 'resp' => 'OK'];

        $this->creaFileJson($arrDataMatriz);
        return ['codResp' => 1,
            'operacion' => ['operacion' => strtoupper($operacion), 'resp' => 'OK']];
    }

    /**
     * Metodo que realiza la suma o calculo sumatorio sobre
     * las posiciones que se encuentren en el rango asignado
     *
     * @param array $arrDataMatriz
     * @param array $arrOpe
     * @param array $operacion
     * @return array
     */
    private function calculaMatriz($arrDataMatriz, $arrOpe, $operacion)
    {
        if ($arrDataMatriz['ejecucion']['cantEjecucion'] < $arrDataMatriz['m']) {
            $arrDataMatriz['ejecucion']['cantEjecucion'] += 1;
        } else {
            return ['codResp' => 0,
                'msj' => self::MSJ_UPD_LIMIT_OPERACION,
                'operacion' => $arrDataMatriz['operacion']];
        }

        $suma = 0;
        for ($i = $arrOpe[1]; $i <= $arrOpe[4]; $i++) {
            for ($j = $arrOpe[2]; $j <= $arrOpe[5]; $j++) {
                for ($k = $arrOpe[3]; $k <= $arrOpe[6]; $k++) {
                    if (isset($arrDataMatriz['matriz'][$i][$j][$k])) {
                        $suma += $arrDataMatriz['matriz'][$i][$j][$k];
                    }
                }
            }
        }

        $arrDataMatriz['operacion'][] = ['operacion' => strtoupper($operacion), 'resp' => $suma];
        $this->creaFileJson($arrDataMatriz);
        return ['codResp' => 1,
            'operacion' => ['operacion' => strtoupper($operacion), 'resp' => $suma]];
    }


}