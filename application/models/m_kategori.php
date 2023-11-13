<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_kategori extends CI_Model {

    private $id_ktg;
    private $nama_kategori;
    private $keterangan;

    public function getKategori($nama_kategori)
    {
        if($nama_kategori != ""){
                $query = $this->db->select('id_ktg, nama_kategori, keterangan')
                ->from('kategori')
                ->where("nama_kategori LIKE '%$nama_kategori%'")
                ->get();
        } else {
                $query = $this->db->get('kategori'); 
        }
            return $query->result();
    }

    public function insertKtg($id, $nama_kategori, $keterangan)
    {
        $timestamp = time();  
        $formattedDate = date('Y-m-d H:i:s', $timestamp);
        $data = array(
                'id_ktg' => $id,
                'nama_kategori' => $nama_kategori,
                'keterangan' => $keterangan,
                'created_at' => $formattedDate
        );

        $query = $this->db->insert('kategori', $data);
    }

    public function getMaxID(){
        $query = $this->db->select('max(id_ktg) as id')
        ->from('kategori')
        ->get();

        $res = $query->row();
        if($res){
                return $res->id;
        } else {
                return null;
        }
    }

    public function delKtg($id){
        $query = $this->db->where('id_ktg', $id)
        ->delete('kategori');
    }

    public function detailKtg($id){
        $query = $this->db->where('id_ktg', $id)
        ->get('kategori');

        return $query->result();
    }

    public function updateKtg($id, $data)
    {
        $query = $this->db->where('id_ktg', $id)
        ->update('kategori', $data);
    }

}
?>