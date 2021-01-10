<?php

function encode($value)
{
    $ci = &get_instance();
    $ci->load->library('encryption');
    $value = $ci->encryption->encrypt($value);
    $value = strtr($value, array('+' => '.', '=' => '-', '/' => '~'));
    return $value;
}

function decode($value)
{

    $ci = &get_instance();
    $ci->load->library('encryption');
    $value = strtr($value, array('.' => '+', '-' => '=', '~' => '/'));
    $value = $ci->encryption->decrypt($value);
    return $value;
}

function validate_token($token = null)
{

    if ($token == null) {
        return false;
    }

    $ci = &get_instance();

    $ci->load->model("Model_usuarios");

    $query_token = $ci->Model_usuarios->query_token_session($token);

    if ($query_token->num_rows() == 0) {
        return false;
    }

    return true;

}

function formato_moneda($valor)
{
    $fmt = numfmt_create('es_CO', NumberFormatter::CURRENCY);
    $valor = numfmt_format($fmt, $valor);

    return $valor;
}

function formato_fecha($fecha, $tipo)
{

    $fecha_format = null;

    if (($fecha != null) and $fecha != "0000-00-00") {

        date_default_timezone_set('America/Bogota');

        $diasem = date("N", strtotime($fecha));
        $dia = date("d", strtotime($fecha));
        $mes = date("m", strtotime($fecha));
        $mesc = date("m", strtotime($fecha));
        $ano = date("Y", strtotime($fecha));
        $anoc = date("y", strtotime($fecha));
        $hora = date("H:i:s", strtotime($fecha));
        $hora2 = date("H:i", strtotime($fecha));

        switch ($mes) {
            case "01":
                $mesn = $mes;
                $mes = "enero";
                $mescorto = "ene";
                $mescortoM = "ENE";
                break;
            case "02":
                $mesn = $mes;
                $mes = "febrero";
                $mescorto = "feb";
                $mescortoM = "FEB";
                break;
            case "03":
                $mesn = $mes;
                $mes = "marzo";
                $mescorto = "mar";
                $mescortoM = "MAR";
                break;
            case "04":
                $mesn = $mes;
                $mes = "abril";
                $mescorto = "abr";
                $mescortoM = "ABR";
                break;
            case "05":
                $mesn = $mes;
                $mes = "mayo";
                $mescorto = "may";
                $mescortoM = "MAY";
                break;
            case "06":
                $mesn = $mes;
                $mes = "junio";
                $mescorto = "jun";
                $mescortoM = "JUN";
                break;
            case "07":
                $mesn = $mes;
                $mes = "julio";
                $mescorto = "jul";
                $mescortoM = "JUL";
                break;
            case "08":
                $mesn = $mes;
                $mes = "agosto";
                $mescorto = "ago";
                $mescortoM = "AGO";
                break;
            case "09":
                $mesn = $mes;
                $mes = "setiembre";
                $mescorto = "sep";
                $mescortoM = "SEP";
                break;
            case "10":
                $mesn = $mes;
                $mes = "octubre";
                $mescorto = "oct";
                $mescortoM = "OCT";
                break;
            case "11":
                $mesn = $mes;
                $mes = "noviembre";
                $mescorto = "nov";
                $mescortoM = "NOV";
                break;
            case "12":
                $mesn = $mes;
                $mes = "diciembre";
                $mescorto = "dic";
                $mescortoM = "DIC";
                break;
        }

        switch ($diasem) {
            case 1:
                $diasem = "lunes";
                break;
            case 2:
                $diasem = "martes";
                break;
            case 3:
                $diasem = "miércoles";
                break;
            case 4:
                $diasem = "jueves";
                break;
            case 5:
                $diasem = "viernes";
                break;
            case 6:
                $diasem = "sábado";
                break;
            case 7:
                $diasem = "domingo";
                break;
        }

        switch ($tipo) {
            case 1:
            default:
                $fecha_format = $dia . "-" . $mescorto . "-" . $anoc;
                break;

            case 2:
                $fecha_format = $dia . "-" . $mescorto . "-" . $anoc . " a las " . $hora;
                break;

            case 3:
                $fecha_format = $mes . " " . $dia . " de " . $ano;
                break;

            case 4:
                $fecha_format = "$dia-$mesc-$ano";
                break;

            case 5:
                $fecha_format = $mescortoM . "" . $dia . "/" . $ano;
                break;

            case 6:
                $fecha_format = $dia . "/" . $mesn . "/" . $ano;
                break;

            case 7:
                $fecha_format = $hora2;
                break;

            case 8:
                $fecha_format = $dia . " de " . $mes . " de " . $ano;
                break;
        }
    }

    return $fecha_format;
}

function get_new_pass()
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXZ';
    return substr(str_shuffle($permitted_chars), 0, 7);
}