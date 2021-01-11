<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Tareas extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Model_usuarios");
        $this->load->model("Model_tareas");
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

        $info_token = $this->Model_usuarios->query_token_session($token)->row();

        $tareas = [];

        $query_tareas = $this->Model_tareas->query_tareas($info_token->id_admin);

        if ($query_tareas->num_rows() != 0) {

            foreach ($query_tareas->result() as $row) {

                $estado = true;
                if ($row->estado == 0) {
                    $estado = false;
                }

                $tareas[] = [
                    'id_tarea' => encode($row->id_tarea),
                    'tarea' => $row->tarea,
                    'estado' => $estado,
                ];
            }

        }

        $response = [
            'status' => true,
            'results' => count($tareas),
            'data' => $tareas,
        ];

        $this->response($response, 200);

    }

    public function set_post()
    {
        header('Content-type: application/json; charset=utf-8');

        $data_input = json_decode(file_get_contents("php://input"));

        if (!isset($this->_args["token"]) or ($this->_args["token"] == "" or empty($this->_args["token"]))) {
            $response = [
                'status' => false,
                'message' => "No se envió el token de usuario.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (($data_input->tarea == "" or empty($data_input->tarea))) {
            $response = [
                'status' => false,
                'message' => "No se envió la descripción de la tarea.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        $token = $this->_args["token"];

        if (!validate_token($token)) {
            $response = [
                'status' => false,
                'message' => "Token incorrecto",
            ];
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $info_token = $this->Model_usuarios->query_token_session($token)->row();

        $data_insert = [
            'id_admin' => $info_token->id_admin,
            'tarea' => $data_input->tarea,
            'estado' => 0,
        ];

        $this->db->insert('tareas', $data_insert);

        if (!$this->db->insert_id()) {
            $response = [
                'status' => false,
                'message' => "Hubo un error tratando de insertar el registro.",
            ];
            $this->response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $id_tarea = $this->db->insert_id();

        $response = [
            'status' => true,
            'message' => "Creación de tarea exitosa.",
            'id_tarea' => encode($id_tarea),
        ];

        $this->response($response, 200);

    }

    public function update_put()
    {
        header('Content-type: application/json; charset=utf-8');

        $data_input = json_decode(file_get_contents("php://input"));

        if (!isset($this->_args["token"]) or ($this->_args["token"] == "" or empty($this->_args["token"]))) {
            $response = [
                'status' => false,
                'message' => "No se envió el token de usuario.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (($data_input->tarea == "" or empty($data_input->tarea))) {
            $response = [
                'status' => false,
                'message' => "No se envió la descripción de la tarea.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        $token = $this->_args["token"];

        if (!validate_token($token)) {
            $response = [
                'status' => false,
                'message' => "Token incorrecto",
            ];
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $data_update = [
            'tarea' => $data_input->tarea,
        ];

        $this->db->where('tareas.id_tarea', decode($data_input->id_tarea));
        $this->db->update('tareas', $data_update);

        $response = [
            'status' => true,
            'message' => "Actualización de tarea exitosa.",
        ];

        $this->response($response, 200);

    }

    public function update_estado_put()
    {
        header('Content-type: application/json; charset=utf-8');

        $data_input = json_decode(file_get_contents("php://input"));

        if (!isset($this->_args["token"]) or ($this->_args["token"] == "" or empty($this->_args["token"]))) {
            $response = [
                'status' => false,
                'message' => "No se envió el token de usuario.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        $token = $this->_args["token"];

        if (!validate_token($token)) {
            $response = [
                'status' => false,
                'message' => "Token incorrecto",
            ];
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $estado = 1;
        if ($data_input->estado) {
            $estado = 0;
        }

        $data_update = [
            'estado' => $estado,
        ];

        $this->db->where('tareas.id_tarea', decode($data_input->id_tarea));
        $this->db->update('tareas', $data_update);

        $response = [
            'status' => true,
            'message' => "Actualización de tarea exitosa.",
        ];

        $this->response($response, 200);

    }

    public function delete_delete($id_tarea = null)
    {
        header('Content-type: application/json; charset=utf-8');

        $data_input = json_decode(file_get_contents("php://input"));

        if (!isset($this->_args["token"]) or ($this->_args["token"] == "" or empty($this->_args["token"]))) {
            $response = [
                'status' => false,
                'message' => "No se envió el token de usuario.",
            ];
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($id_tarea == null) {
            $response = [
                'status' => false,
                'message' => "No se envió el ID de la tarea.",
            ];
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $token = $this->_args["token"];

        if (!validate_token($token)) {
            $response = [
                'status' => false,
                'message' => "Token incorrecto",
            ];
            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $this->db->where('tareas.id_tarea', decode($id_tarea));
        $this->db->delete('tareas');

        $response = [
            'status' => true,
            'message' => "Eliminación de tarea exitosa.",
        ];

        $this->response($response, 200);

    }

}