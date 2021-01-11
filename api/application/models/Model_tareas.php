<?php

class Model_tareas extends CI_Model
{

    public function query_tareas($id_admin = null)
    {
        $this->db->from('tareas');

        if ($id_admin != null) {
            $this->db->where('tareas.id_admin', $id_admin);
        }

        return $this->db->get();
    }

}