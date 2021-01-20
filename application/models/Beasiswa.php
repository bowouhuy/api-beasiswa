<?php

Class Beasiswa extends CI_Model{

    public function list($where, $npm=null){

        if($npm != null){
            $result = $this->db->query("SELECT npm, m.nama, p.prodi_nama, f.fakultas_nama, semester, beasiswa, periode FROM mahasiswa m 
                        LEFT JOIN prodi p ON m.prodi = p.id
                        LEFT JOIN fakultas f ON p.fakultas_id = f.id
                        WHERE m.npm = '$npm'")->row_array();
            
        }else{
            $result = $this->db->query("SELECT npm, m.nama, p.prodi_nama, f.fakultas_nama, semester, beasiswa, periode FROM mahasiswa m 
                        LEFT JOIN prodi p ON m.prodi = p.id
                        LEFT JOIN fakultas f ON p.fakultas_id = f.id")->result_array();
                        
        }
        return $result;

    }

    public function insert($data){
            if(! $this->db->insert('mahasiswa', $data)){
                
                return $this->db->error();
            }
    }

    public function edit($data){
        $this->db->set($data);
        // print_r($data['npm']);exit;
        $this->db->where('npm', $data['npm']);
        if (! $this->db->update('mahasiswa')){
            return $this->db->error();
        }
        
    }

    public function destroy($npm){

        if(! $this->db->delete('mahasiswa', array('npm' => $npm))){
            return $this->db->error();
        }
    }


}