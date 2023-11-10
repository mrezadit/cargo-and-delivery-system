<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Driver extends CI_Controller
{
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CrudModel', 'crudModel');
        $this->load->library('session');
        if ($this->session->userdata('role') !== 'driver') {
            redirect('login/');
        }
    }

    public function index()
    {

        $data = [

            'processed' => $this->db->query('SELECT cstatus FROM capacity WHERE cstatus=2')->num_rows(),
            'completed' => $this->db->query('SELECT cstatus FROM capacity WHERE cstatus=3')->num_rows(),
            'receive' => $this->db->query('SELECT pstatus FROM package WHERE pstatus=4')->num_rows(),
            'return' => $this->db->query('SELECT pstatus FROM package WHERE pstatus=3')->num_rows(),

            'package' => $this->db->query('SELECT * FROM package')->num_rows(),
            'product' => $this->db->query('SELECT * FROM product')->num_rows(),
            'truck' => $this->db->query('SELECT * FROM truck')->num_rows(),
            'driver' => $this->db->query('SELECT * FROM driver')->num_rows(),

            'content' => 'driver/beranda',
            'navlink' => 'beranda',
            
        ];

        $this->load->view('driver/vbackend', $data);
    }
    
    public function shipping()
    {
        if ($this->uri->segment(4) === 'view') {                    
            $id = $this->uri->segment(3);

            $tampil = $this->db->query('SELECT * FROM capacity JOIN truck JOIN driver
            WHERE capacity.id_capacity = '.$id.' AND capacity.id_truck = truck.id_truck AND capacity.id_driver = driver.id_driver')->row();

            $data = [
                'capacity' => [
                    'id_capacity' => $tampil->id_capacity,
                    'schedule' => $tampil->schedule,
                    'truck' => $tampil->truck,
                    'driver' => $tampil->driver,
                    'no_plate' => $tampil->no_plate,
                    'phone' => $tampil->phone,
                    'bmax' => $tampil->bmax,
                    'capacity' => $tampil->capacity,
                    'b_capacity' => $tampil->b_capacity,
                    'r_capacity' => $tampil->r_capacity,
                ],

                'idcapacity' => $this->db->query('SELECT id_capacity FROM capacity WHERE id_capacity = '.$id.'')->row(),
                'date' => $this->db->query('SELECT * FROM package  ORDER BY date ASC')->result(),
                'package2' => $this->db->query('SELECT DISTINCT date FROM package WHERE pstatus = 1 ORDER BY date ASC')->result(),
                'package' => $this->db->query('SELECT * FROM v_capacity JOIN package JOIN kota WHERE v_capacity.id_capacity = ' . $id. ' AND v_capacity.id_package = package.id_package AND package.id_kota = kota.id_kota ORDER BY kota.priority DESC')->result(),
                'content' => 'driver/shipping/addshipment',
                'navlink' => 'shipping',
            ];

        } else {

            $data = [
                'capacity' => $this->db->query('SELECT * FROM capacity JOIN truck JOIN driver
                            WHERE capacity.id_truck = truck.id_truck AND capacity.id_driver = driver.id_driver AND cstatus = 2')->result(),
                'content' => 'driver/shipping/shipping',
                'navlink' => 'shipping',
            ];
        }

        $this->load->view('driver/vbackend', $data);
    }

    public function receiveShipping()
    {
        $id_capacity = $this->uri->segment(3);
        $id_package = $this->uri->segment(4);
        
        $update = [
            'rstatus' => 2,
        ];

        $update2 = [
            'pstatus' => 4,
        ];

        $this->crudModel->updateData('package', 'id_package', $id_package, $update2);

        $this->crudModel->updateData('v_capacity', 'id_package', $id_package, $update);

        $count = $this->db->query('SELECT COUNT(rstatus) as received FROM v_capacity WHERE id_capacity ='.$id_capacity.' AND rstatus = 2')->row();

        $update3 = [
            'receive' => $count->received,
        ];
        
        $this->crudModel->updateData('capacity', 'id_capacity', $id_capacity, $update3);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('driver/shipping/'.$id_capacity.'/view'));
    }

    public function returnShipping()
    {
        $id_capacity = $this->uri->segment(3);
        $id_package = $this->uri->segment(4);

        $update = [
            'pstatus' => 3,
        ];

        $update2 = [
            'rstatus' => 3,
        ];

        $this->crudModel->updateData('package', 'id_package', $id_package, $update);

        $this->crudModel->updateData('v_capacity', 'id_package', $id_package, $update2);

        $count = $this->db->query('SELECT COUNT(rstatus) as returned FROM v_capacity WHERE id_capacity ='.$id_capacity.' AND rstatus = 3')->row();

        $update3 = [
            'return' => $count->returned,
        ];
        
        $this->crudModel->updateData('capacity', 'id_capacity', $id_capacity, $update3);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('driver/shipping/'.$id_capacity.'/view'));
    }

    public function completeShipping()
    {
        $id_capacity = $this->uri->segment(3);

        $update = [
            'cstatus' => 3,
        ];

        $this->crudModel->updateData('capacity', 'id_capacity', $id_capacity, $update);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('driver/shipping'));
    }

    public function report()
    {
        if ($this->uri->segment(4) === 'view') {                    
            $id = $this->uri->segment(3);

            $tampil = $this->db->query('SELECT * FROM capacity JOIN truck JOIN driver
            WHERE capacity.id_capacity = '.$id.' AND capacity.id_truck = truck.id_truck AND capacity.id_driver = driver.id_driver')->row();

            $data = [
                'capacity' => [
                    'id_capacity' => $tampil->id_capacity,
                    'schedule' => $tampil->schedule,
                    'truck' => $tampil->truck,
                    'driver' => $tampil->driver,
                    'no_plate' => $tampil->no_plate,
                    'phone' => $tampil->phone,
                    'bmax' => $tampil->bmax,
                    'capacity' => $tampil->capacity,
                    'b_capacity' => $tampil->b_capacity,
                    'r_capacity' => $tampil->r_capacity,
                ],

                'idcapacity' => $this->db->query('SELECT id_capacity FROM capacity WHERE id_capacity = '.$id.'')->row(),
                'date' => $this->db->query('SELECT * FROM package  ORDER BY date ASC')->result(),
                'package2' => $this->db->query('SELECT DISTINCT date FROM package WHERE pstatus = 1 ORDER BY date ASC')->result(),
                'package' => $this->db->query('SELECT * FROM v_capacity JOIN package JOIN kota WHERE v_capacity.id_capacity = ' . $id. ' AND v_capacity.id_package = package.id_package AND package.id_kota = kota.id_kota ORDER BY kota.priority DESC')->result(),
                'content' => 'driver/report/viewreport',
                'navlink' => 'report',
            ];

            $this->load->view('driver/report/viewreport', $data);

        } else {

            $data = [
                'capacity' => $this->db->query('SELECT * FROM capacity JOIN truck JOIN driver 
                            WHERE capacity.id_truck = truck.id_truck AND capacity.id_driver = driver.id_driver AND capacity.cstatus = 3')->result(),
                'content' => 'driver/report/report',
                'navlink' => 'report',
            ];

            $this->load->view('driver/vbackend', $data);

        }
    }

    public function printReport()
    {
        $id = $this->uri->segment(3);

        $tampil = $this->db->query('SELECT * FROM capacity JOIN truck JOIN driver
        WHERE capacity.id_capacity = '.$id.' AND capacity.id_truck = truck.id_truck AND capacity.id_driver = driver.id_driver')->row();

        $data = [
            'capacity' => [
                'id_capacity' => $tampil->id_capacity,
                'schedule' => $tampil->schedule,
                'truck' => $tampil->truck,
                'driver' => $tampil->driver,
                'no_plate' => $tampil->no_plate,
                'phone' => $tampil->phone,
                'bmax' => $tampil->bmax,
                'capacity' => $tampil->capacity,
                'b_capacity' => $tampil->b_capacity,
                'r_capacity' => $tampil->r_capacity,
            ],

            'idcapacity' => $this->db->query('SELECT id_capacity FROM capacity WHERE id_capacity = '.$id.'')->row(),
            'date' => $this->db->query('SELECT * FROM package  ORDER BY date ASC')->result(),
            'package2' => $this->db->query('SELECT DISTINCT date FROM package WHERE pstatus = 1 ORDER BY date ASC')->result(),
            'package' => $this->db->query('SELECT * FROM v_capacity JOIN package JOIN kota WHERE v_capacity.id_capacity = ' . $id. ' AND v_capacity.id_package = package.id_package AND package.id_kota = kota.id_kota ORDER BY kota.priority DESC')->result(),
        ];

        $this->load->view('printReport', $data);
    }
    
    public function logout()
    {
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('user_id');
        redirect('login/');
    }



}