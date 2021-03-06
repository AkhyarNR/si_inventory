<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_laporan extends CI_Model {

public function getAllAlatKeluar(){
      $this->db->select('*');
      $this->db->from  ('tb_alatkeluar');
      $this->db->join  ('tb_spesifikasi', 'tb_spesifikasi.id_spesifikasi = tb_alatkeluar.id_spesifikasi');
      $this->db->join  ('kondisi_barang', 'kondisi_barang.id_kondisi = tb_alatkeluar.id_kondisi');
      $this->db->order_by('tanggal_keluar', 'asc');
      $query= $this->db->get();
      return $query->result();
    }

public function getAllAlatMasuk(){
       $this->db->select('a.*, b.*, c.*');
       $this->db->from  ('tb_alatmasuk a');
       $this->db->join  ('tb_spesifikasi b','a.id_spesifikasi=b.id_spesifikasi');
       $this->db->join  ('kondisi_barang c', 'a.id_kondisi=c.id_kondisi');
       $this->db->order_by('tanggal_masuk', 'asc');
       $query = $this->db->get();
       return $query->result();
    }

public function getAllBahanKeluar(){
      $this->db->select('*');
      $this->db->from  ('tb_bahankeluar');
      $this->db->order_by('tanggal_keluar', 'asc');
      $query= $this->db->get();
      return $query->result();
    }

public function getAllBahanMasuk(){
       $this->db->select('*');
       $this->db->from  ('tb_bahanmasuk');
       $this->db->order_by('tanggal_masuk', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

public function getAllPeminjaman(){
       $this->db->select('*');
       $this->db->from  ('peminjaman');
       $this->db->join  ('tb_spesifikasi', 'tb_spesifikasi.id_spesifikasi = peminjaman.id_spesifikasi');
       $this->db->order_by('tanggal_pinjam', 'desc');
        $query= $this->db->get();
        return $query->result();
    }


public function getLapAlatkeluar($tglAwal,$tglAkhir){
        return $this->db->query("SELECT * from tb_alatkeluar a
                left join tb_spesifikasi b on a.id_spesifikasi=b.id_spesifikasi
                left join kondisi_barang c on a.id_kondisi=c.id_kondisi
                where a.tanggal_keluar between '$tglAwal' and '$tglAkhir' GROUP BY a.id_alatkeluar ORDER BY tanggal_keluar ASC")->result();
    }

    public function getLapAlatmasuk($tglAwal,$tglAkhir){
        return $this->db->query("SELECT * from tb_alatmasuk p
                left join tb_spesifikasi q on p.id_spesifikasi=q.id_spesifikasi
                left join kondisi_barang r on p.id_kondisi=r.id_kondisi
                where p.tanggal_masuk between '$tglAwal' and '$tglAkhir' GROUP BY p.id_alatmasuk ORDER BY tanggal_masuk ASC")->result();
    }

public function getLapBahankeluar($tglAwal,$tglAkhir){
        return $this->db->query("SELECT * from tb_bahankeluar 
                where tanggal_keluar between '$tglAwal' and '$tglAkhir' GROUP BY id_bahankeluar ORDER BY tanggal_keluar ASC")->result();
    }

    public function getLapBahanmasuk($tglAwal,$tglAkhir){
        return $this->db->query("SELECT * from tb_bahanmasuk 
                where tanggal_masuk between '$tglAwal' and '$tglAkhir' GROUP BY id_bahanmasuk ORDER BY tanggal_masuk ASC")->result();
    }


public function getLapPeminjaman($tglAwal,$tglAkhir){
        return $this->db->query("SELECT * from peminjaman k
                left join tb_spesifikasi l on k.id_spesifikasi=l.id_spesifikasi
                where k.tanggal_pinjam between '$tglAwal' and '$tglAkhir' GROUP BY id_peminjaman ORDER BY tanggal_pinjam ASC")->result();
    }

	
}
?>