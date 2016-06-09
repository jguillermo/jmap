<?php

namespace Jmap\Filter;

use Zend\Filter\FilterInterface;

class PrimaryKeyInt implements FilterInterface {

    /**
     * filtra los valores de un primari Key,
     * si es NULL lo convierte en 0
     * si es numeric y solo tiene caracteres numericos [09], lo convierte en un integer
     * caso contrario retorna el mismo valor ingresado
     * @param  obj  $value valor ingresado para ser analizado
     * @return obj       valor devuelto, si cumple las condiciones es un integer
     */
    public function filter($value) {
        if (is_null($value)) {
            $value = 0;
        } elseif (is_numeric($value)) {
            $value = (string) $value;
            if (ctype_digit($value)) {
                return (int) $value;
            }
        }
        return $value;
    }

}
