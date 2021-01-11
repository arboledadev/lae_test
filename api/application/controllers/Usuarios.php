<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Usuarios extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Model_usuarios");

    }

    public function get_get()
    {

        header('Content-type: application/json; charset=utf-8');

        if (!isset($this->_args["token"]) or ($this->_args["token"] == "" or empty($this->_args["token"]))) {
            $response = [
                'status' => false,
                'message' => "No se envió el token de usuario.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        $token = $this->_args["token"];

        $data_input = $this->input->get(null, true);

        if (!validate_token($token)) {
            $response = [
                'status' => false,
                'message' => "Token incorrecto",
            ];
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $usuarios = [];

        $query_usuarios = $this->Model_usuarios->query_usuarios();

        if ($query_usuarios->num_rows() != 0) {

            foreach ($query_usuarios->result() as $row) {

                $estado = true;
                if ($row->estado == 0) {
                    $estado = false;
                }

                $usuarios[] = [
                    'id_usuario' => encode($row->id_usuario),
                    'nombres' => $row->nombres,
                    'apellidos' => $row->apellidos,
                    'telefono' => $row->telefono,
                    'email' => $row->email,
                    'estado' => $estado,
                ];
            }

        }

        $response = [
            'status' => true,
            'results' => count($usuarios),
            'data' => $usuarios,
        ];

        $this->response($response, 200);

    }

}