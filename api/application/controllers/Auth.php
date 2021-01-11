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
        $this->load->model("Model_usuarios");

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

    public function signup_post()
    {

        header('Content-type: application/json; charset=utf-8');

        $data_input = json_decode(file_get_contents("php://input"));

        if (($data_input->nombres == "" or empty($data_input->nombres))) {
            $response = [
                'status' => false,
                'message' => "No se envió el nombre del usuario.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (($data_input->email == "" or empty($data_input->email))) {
            $response = [
                'status' => false,
                'message' => "No se envió el correo electrónico del usuario.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (!filter_var($data_input->email, FILTER_VALIDATE_EMAIL)) {
            $response = [
                'status' => false,
                'message' => "El correo electrónico enviado es incorrecto.",
            ];
            $this->response($response, 200);
        }

        $query_admin = $this->Model_usuarios->query_admin_email($data_input->email);

        if ($query_admin->num_rows() != 0) {
            $response = [
                'status' => false,
                'message' => "El correo electrónico que intenta registrar ya existe.",
            ];
            $this->response($response, 200);
        }

        $password = password_hash($data_input->password, PASSWORD_BCRYPT);

        $data_insert = [
            'nombres' => $data_input->nombres,
            'apellidos' => $data_input->apellidos,
            'email' => $data_input->email,
            'password' => $password,
        ];

        $this->db->insert('admin', $data_insert);

        if (!$this->db->insert_id()) {
            $response = [
                'status' => false,
                'message' => "Hubo un error tratando de insertar el registro.",
            ];
            $this->response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $info_admin = $this->Model_usuarios->query_admin_email($data_input->email)->row();

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
            'message' => "Creación de cuenta exitosa.",
            'data' => $data,
        ];

        $this->response($response, 200);

    }

}