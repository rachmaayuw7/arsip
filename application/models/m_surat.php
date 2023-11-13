<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_surat extends CI_Model {

    private $id_surat;
    private $nomor_surat;
    private $id_ktg;
    private $judul;
    private $file;
    private $created_at;
    private $update_at;

    public function getSurat($judul)
    {
        if($judul != ""){    
            $query = $this->db->select('surat.id_surat, surat.nomor_surat, kategori.nama_kategori, surat.judul, surat.file, surat.created_at')
                ->from('surat')
                ->join('kategori','kategori.id_ktg=surat.id_ktg')
                ->like('surat.judul', $judul)
                ->group_by('surat.id_surat, surat.nomor_surat, kategori.nama_kategori, surat.judul, surat.file,surat.created_at')   
                ->order_by('surat.created_at', 'DESC')            
                ->get();
        } else {
            $query = $this->db->select('surat.id_surat, surat.nomor_surat, kategori.nama_kategori, surat.judul, surat.file, surat.created_at')
                ->from('surat')
                ->join('kategori','kategori.id_ktg=surat.id_ktg')
                ->group_by('surat.id_surat, surat.nomor_surat, kategori.nama_kategori, surat.judul, surat.file, surat.created_at')   
                ->order_by('surat.created_at', 'DESC')            
                ->get();
        }
            return $query->result();
    }

    public function detailSurat($id_surat){
        $query = $this->db->select('surat.id_surat, surat.nomor_surat, surat.id_ktg, kategori.nama_kategori, surat.judul, surat.file, surat.created_at')
            ->from('surat')
            ->join('kategori','kategori.id_ktg=surat.id_ktg')
            ->where('surat.id_surat', $id_surat)
            ->group_by('surat.id_surat, surat.nomor_surat, kategori.nama_kategori, surat.judul, surat.file,surat.created_at')   
            ->order_by('surat.created_at', 'DESC')            
            ->get();
        return $query->result();
    }

    public function insertSurat($nomor, $kategori, $judul, $file)
    {
        $timestamp = time();  
        $formattedDate = date('Y-m-d H:i:s', $timestamp);
        $data = array(
            'nomor_surat' => $nomor,
            'id_ktg' => $kategori, 
            'judul' => $judul,
            'file' => $file,
            'created_at' => $formattedDate
        );

        $query = $this->db->insert('surat', $data);
    }

    public function hapusSurat($id_surat)
    {
        $query = $this->db->where('id_surat', $id_surat)
        ->delete('surat');
    }

    public function getNameFile($id_surat)
    {
        $query = $this->db->select('surat.file')
        ->from('surat')
        ->where('id_surat', $id_surat)
        ->get();

        $result = $query->row(); 

        if ($result) {
            return $result->file;
        } else {
            return null; 
        }
    }

    public function updateSurat($id, $data)
    {
        $query = $this->db->where('id_surat', $id)
        ->update('surat', $data);
    }

}
?>