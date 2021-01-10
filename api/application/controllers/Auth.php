<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Auth extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login_post()
    {

        header('Content-type: application/json; charset=utf-8');

        $data_input = json_decode(file_get_contents("php://input"));

        if (($data_input->email == "" or empty($data_input->email))) {
            $response = [
                'status' => false,
                'message' => "No se envió el correo electrónico",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (($data_input->password == "" or empty($data_input->password))) {
            $response = [
                'status' => false,
                'message' => "No se envió la contraseña.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->load->model("Model_usuarios");

        $query_admin = $this->Model_usuarios->query_admin_email($data_input->email);

        if ($query_admin->num_rows() == 0) {
            $response = [
                'status' => false,
                'message' => "Usuario incorrecto",
            ];
            $this->response($response, 200);
        }

        $info_admin = $query_admin->row();

        if ((!password_verify($data_input->password, $info_admin->password))) {
            $response = [
                'status' => false,
                'message' => "Contraseña incorrecta",
            ];
            $this->response($response, 200);
        }

        //Registrar token
        $token = encode(uniqid());
        $data_insert_token = [
            'fecha' => date("Y-m-d H:i:s"),
            'id_admin' => $info_admin->id_admin,
            'token' => $token,
            'token_estado' => 1,
        ];
        $this->db->insert('tokens_session', $data_insert_token);

        $data = [
            'status' => true,
            'usuario' => [
                'id_admin' => encode($info_admin->id_admin),
                'nombres' => $info_admin->nombres,
                'apellidos' => $info_admin->apellidos,
                'email' => $info_admin->email,
            ],
            'token_session' => $token,
        ];

        $response = [
            'status' => true,
            'message' => "Inicio de sesión exitoso.",
            'data' => $data,
        ];

        $this->response($response, 200);
    }

    public function token_validate_post()
    {

        header('Content-type: application/json; charset=utf-8');

        $data_input = json_decode(file_get_contents("php://input"));

        if (($data_input->token_session == "" or empty($data_input->token_session))) {
            $response = [
                'status' => false,
                'message' => "No se envió el token de usuario.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->load->model("Model_usuarios");

        $query_token = $this->Model_usuarios->query_token_session($data_input->token_session);

        if ($query_token->num_rows() == 0) {
            $response = [
                'status' => false,
                'message' => "Token incorrecto",
            ];
            $this->response($response, 200);
        }

        $response = [
            'status' => true,
            'message' => "Token correcto",
        ];
        $this->response($response, 200);

    }

}