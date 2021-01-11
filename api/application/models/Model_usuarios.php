<?php

class Model_usuarios extends CI_Model
{

    public function query_admin_email($email)
    {
        $this->db->from('admin');
        $this->db->where('admin.email', $email);

        return $this->db->get();
    }

    public function query_usuarios()
    {
        $this->db->from('usuarios');
        return $this->db->get();
    }

    public function query_token_session($token)
    {
        $this->db->from('tokens_session');
        $this->db->where('tokens_session.token', $token);
        $this->db->where('tokens_session.token_estado', 1);

        return $this->db->get();
    }

}