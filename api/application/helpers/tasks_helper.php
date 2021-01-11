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