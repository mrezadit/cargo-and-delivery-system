<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CrudModel extends CI_Model
{
    public function generateCode($code, $field, $table) // $code = hanya buat 2 angka awal
    {
        return $code.sprintf('%03s', (int) substr($this->db->select_max($field)->get($table)->row()->$field, 2, 3) + 1);
    }

    public function addData($table, $data = [])
    {
        $this->db->insert($table, $data);
    }

    public function updateData($tabel, $fieldid, $fieldvalue, $data = [])
    {
        $this->db->where($fieldid, $fieldvalue)->update($tabel, $data);
    }

    public function updateDataFor($tabel, $fieldid, $fieldvalue, $data = [])
    {
        for ($i = 0; $i < count($fieldid); ++$i){
        $this->db->where($fieldid, $fieldvalue)->update($tabel, $data);
        }
    }

    public function tambahData($tabel, $data = [])
    {
        $this->db->where($tabel)->insert($tabel, $data);
    }

    public function deleteData($tabel, $fieldid, $fieldvalue)
    {
        $this->db->where($fieldid, $fieldvalue)->delete($tabel);
    }

    public function getData($tabel)
    {
        $query = $this->db->get($tabel);

        return $query;
    }

    public function getDataWhere($tabel, $id, $nilai)
    {
        $this->db->where($id, $nilai);
        $query = $this->db->get($tabel);

        return $query;
    }

    public function getDataJoin($table, $onjoin)
    {
        $this->db->from($table);
        for ($i = 0; $i < count($onjoin); ++$i) {
            $this->db->join(array_keys($onjoin)[$i], array_values($onjoin)[$i]);
        }

        return $this->db->get()->result();
    }

    public function getDataJoinWhere($table, $nilai, $onjoin)
    {
        $this->db->from($table)->where($nilai);
        for ($i = 0; $i < count($onjoin); ++$i) {
            $this->db->join(array_keys($onjoin)[$i], array_values($onjoin)[$i]);
        }

        return $this->db->get()->result();
    }

    public function getDataSum($value, $table, $field)
    {
        $this->db->from($table);
        for ($i = 0; $i < count($value); ++$i) {
            $this->db->where(array_keys($value)[$i], array_values($value)[$i]);
        }
        $this->db->select_sum($field);

        return $this->db->get()->row();
    }

    public function getDataCount($value, $table)
    {
        $this->db->from($table);
        for ($i = 0; $i < count($value); ++$i) {
            $this->db->where(array_keys($value)[$i], array_values($value)[$i]);
        }

        return $this->db->count_all_results();
    }

	public function viewByDate($date){
        $this->db->distinct('date', 'package.id_kota');
        $this->db->from('package');
        $this->db->join('kota', 'package.id_kota = kota.id_kota');
		$this->db->where('date', $date);
		$result = $this->db->get()->result(); // Tampilkan semua data kota berdasarkan id provinsi

        // $result = $this->db->query('SELECT DISTINCT date, package.id_kota FROM package JOIN kota WHERE date = "'.$date.'" AND package.id_kota = kota.id_kota')->result();
		
		return $result;  
	}

    public function viewByKota($id_kota){
		$this->db->where('id_kota', $id_kota);
		$result = $this->db->get('package')->result(); // Tampilkan semua data kota berdasarkan id provinsi
		
		return $result;  
	}

    public function viewByPackage($id_kota){
		$this->db->where('id_kota', $id_kota);
		$result = $this->db->get('package')->result(); // Tampilkan semua data kota berdasarkan id provinsi
		
		return $result;  
	}
}
