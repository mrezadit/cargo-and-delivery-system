<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CrudModel', 'crudModel');
        $this->load->library('session');
        if ($this->session->userdata('role') !== 'admin') {
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

            'content' => 'admin/beranda',
            'navlink' => 'beranda',
            
        ];

        $this->load->view('admin/vbackend', $data);
    }

    public function package()
    {
        if ($this->uri->segment(4) === 'view') {

            $id = $this->uri->segment(3);

            $tampil = $this->db->query('SELECT * FROM package JOIN kota
            WHERE package.id_package = ' . $id. ' AND package.id_kota = kota.id_kota')->row();

            $data = [
                'package' => [
                    'id_package' => $tampil->id_package,
                    'no_package' => $tampil->no_package,
                    'customer_name' => $tampil->customer_name,
                    'phone' => $tampil->phone,
                    'address' => $tampil->address,
                    'kota' => $tampil->kota,
                    't_kg' => $tampil->t_kg,
                    't_kgv' => $tampil->t_kgv,
                    'date' => $tampil->date,
                ],

                'product' => $this->db->query('SELECT * FROM product')->result(),
                'v_package' => $this->db->query('SELECT * FROM v_package JOIN package JOIN product WHERE v_package.id_package = ' . $id. ' AND v_package.id_package = package.id_package AND v_package.id_product = product.id_product')->result(),
                'content' => 'admin/package/addvolume',
                'navlink' => 'package',
            ];

        } else if ($this->uri->segment(3) === 'addpackage') {

            $data = [
                'product' => $this->db->query('SELECT * FROM product')->result(),
                'kota' => $this->db->query('SELECT * FROM kota')->result(),
                'content' => 'admin/package/addpackage',
                'navlink' => 'package',
            ];

        } else if ($this->uri->segment(4) === 'update') {
            
            $id = $this->uri->segment(3);

            $tampil = $this->crudModel->getDataWhere('package', 'id_package', $id)->row();

            $data = [
                'detail' => [
                    'id_package' => $tampil->id_package,
                    'customer_name' => $tampil->customer_name,
                    'phone' => $tampil->phone,
                    'address' => $tampil->address,
                    'id_kota' => $tampil->id_kota,
                    'date' => $tampil->date,
                ],

                'content' => 'admin/package/updatepackage',
                'navlink' => 'package',
                'kota' => $this->db->query('SELECT * FROM kota')->result(),
                ]; 

        } else {
            $data = [
                'package' => $this->db->query('SELECT * FROM package JOIN kota
                             WHERE package.id_kota = kota.id_kota ORDER BY pstatus DESC ')->result(),
                'content' => 'admin/package/package',
                'navlink' => 'package',
            ];
        }

        $this->load->view('admin/vbackend', $data);
    }

    public function addPackage()
    {
        $add = [
            'id_package' => $this->crudModel->generateCode(1, 'id_package', 'package'),
            'no_package' => $this->crudModel->generateCode('PACK', 'id_package', 'package'),
            'customer_name' => trim($this->input->post('customer_name')),
            'phone' => trim($this->input->post('phone')),
            'address' => trim($this->input->post('address')),
            'id_kota' => trim($this->input->post('id_kota')),
            'date' => trim($this->input->post('date')),
            'pstatus' => trim($this->input->post('pstatus')),
        ];

        $this->crudModel->addData('package', $add);

        $this->session->set_flashdata('flash', 'ditambah');

        redirect(site_url('Admin/package'));
    }

    public function updatePackage()
    {
        $id_package = $this->input->post('id_package');

        $update = [
            'customer_name' => trim($this->input->post('customer_name')),
            'phone' => trim($this->input->post('phone')),
            'address' => trim($this->input->post('address')),
            'id_kota' => trim($this->input->post('id_kota')),
            'date' => trim($this->input->post('date')),
        ];

        $this->crudModel->updateData('package', 'id_package', $id_package, $update);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('Admin/package'));
    }

    public function deletePackage()
    {
        $id_package = $this->uri->segment(3);

        $this->crudModel->deleteData('package', 'id_package', $id_package);

        $this->crudModel->deleteData('v_package', 'id_package', $id_package);

        $this->session->set_flashdata('flash', 'dihapus');

        redirect(site_url('Admin/package'));
    }

    public function deleteVProduct()
    {
        $id_vpackage = $this->uri->segment(3);
        $id_package = $this->uri->segment(4);

        $min = $this->crudModel->getDataWhere('package', 'id_package', $id_package)->row();

        $get = $this->crudModel->getDataWhere('v_package', 'id_vpackage', $id_vpackage)->row();

        $update = [
            't_kg' => $min->t_kg - $get->t_berat,
            't_kgv' => $min->t_kgv - $get->t_volume,
        ];

        $this->crudModel->updateData('package', 'id_package', $id_package, $update);

        $this->crudModel->deleteData('v_package', 'id_vpackage', $id_vpackage);

        $this->session->set_flashdata('flash', 'dihapus');

        redirect(site_url('admin/package/'.$id_package.'/view'));
    }

    public function addVolume()
    {
        $id_package = $this->input->post('id_package');

        $add = [
            'id_vpackage' => $this->crudModel->generateCode(1, 'id_vpackage', 'v_package'),
            'id_package' => trim($this->input->post('id_package')),
            'id_product' => trim($this->input->post('id_product')),
            'qty' => trim($this->input->post('qty')),
        ];

        $volume = $this->crudModel->getDataWhere('product', 'id_product', $add['id_product'])->row();

        $kgv = $this->crudModel->getDataWhere('package', 'id_package', $add['id_package'])->row();

        $update = [
            't_berat' => $volume->berat * $add['qty'],
            't_volume' => $volume->panjang * $volume->lebar * $volume->tinggi / 1000000 * $add['qty'],
        ];

        $this->crudModel->addData('v_package', $add);
        
        $this->crudModel->updateData('v_package', 'id_vpackage', $add['id_vpackage'], $update);

        $update2 = [
            't_kg' => $kgv->t_kg + $update['t_berat'],
            't_kgv' => $kgv->t_kgv + $update['t_volume'],
        ];

        $this->crudModel->updateData('package', 'id_package', $add['id_package'], $update2);

        $this->session->set_flashdata('flash', 'ditambah');

        redirect(site_url('admin/package/'.$id_package.'/view'));
    }

    public function product()
    {   
        if ($this->uri->segment(3) === 'addproduct') {

        $data = [
            'product' => $this->db->query('SELECT * FROM product')->result(),
            'content' => 'admin/product/addproduct',
            'navlink' => 'product',
        ];

    } else if ($this->uri->segment(4) === 'update') {

        $id = $this->uri->segment(3);

        $tampil = $this->crudModel->getDataWhere('product', 'id_product', $id)->row();

        $data = [
            'detail' => [
                'id_product' => $tampil->id_product,
                'product_name' => $tampil->product_name,
                'berat' => $tampil->berat,
                'tinggi' => $tampil->tinggi,
                'panjang' => $tampil->panjang,
                'lebar' => $tampil->lebar,
            ],

            'content' => 'admin/product/updateproduct',
            'navlink' => 'product',
            ]; 

    } else {

        $data = [
            'product' => $this->crudModel->getData('product')->result(),
            'content' => 'admin/product/product',
            'navlink' => 'product',
            ];
        }
    
        $this->load->view('admin/vbackend', $data);
    }

    public function addproduct() 
    {
        $add = [
            'id_product' => $this->crudModel->generateCode(1, 'id_product', 'product'),
            'product_name' => trim($this->input->post('product_name')),
            'berat' => trim($this->input->post('berat')),
            'panjang' => trim($this->input->post('panjang')),
            'tinggi' => trim($this->input->post('tinggi')),
            'lebar' => trim($this->input->post('lebar')),
        ];

        $this->crudModel->addData('product', $add);

        $this->session->set_flashdata('flash', 'ditambah');

        redirect(site_url('admin/product'));
    }

    public function updateProduct()
    {
        $id_product = $this->input->post('id_product');

        $update = [
            'product_name' => trim($this->input->post('product_name')),
            'berat' => trim($this->input->post('berat')),
            'panjang' => trim($this->input->post('panjang')),
            'tinggi' => trim($this->input->post('tinggi')),
            'lebar' => trim($this->input->post('lebar')),
        ];

        $this->crudModel->updateData('product', 'id_product', $id_product, $update);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('admin/product'));
    }

    public function deleteProduct()
    {
        $id_product = $this->uri->segment(3);

        $this->crudModel->deleteData('product', 'id_product', $id_product);

        $this->session->set_flashdata('flash', 'dihapus');

        redirect(site_url('admin/product'));
    }


    public function capacity()
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
                'package2' => $this->db->query('SELECT DISTINCT date FROM package WHERE pstatus = 1 OR pstatus = 3 ORDER BY date ASC')->result(),
                'package' => $this->db->query('SELECT * FROM v_capacity JOIN package JOIN kota WHERE v_capacity.id_capacity = ' . $id. ' AND v_capacity.id_package = package.id_package AND package.id_kota = kota.id_kota ORDER BY kota.priority DESC')->result(),
                'content' => 'admin/capacity/addcapacity',
                'navlink' => 'capacity',
            ];

        } else if ($this->uri->segment(3) === 'addcapacity') {

            $data = [
                'truck' => $this->db->query('SELECT * FROM truck')->result(),
                'driver' => $this->db->query('SELECT * FROM driver')->result(),
                'content' => 'admin/capacity/tambahcapacity',
                'navlink' => 'capacity',
            ];

        } else if ($this->uri->segment(4) === 'update') {
            
            $id = $this->uri->segment(3);

            $tampil = $this->crudModel->getDataWhere('capacity', 'id_capacity', $id)->row();

            $data = [
                'detail' => [
                    'id_capacity' => $tampil->id_capacity,
                    'schedule' => $tampil->schedule,
                    'id_truck' => $tampil->id_truck,
                    'id_driver' => $tampil->id_driver,
                ],

                'truck' => $this->db->query('SELECT * FROM truck')->result(),
                'driver' => $this->db->query('SELECT * FROM driver')->result(),
                'content' => 'admin/capacity/updatecapacity',
                'navlink' => 'capacity',
                ]; 

        } else {
            $data = [
                'capacity' => $this->db->query('SELECT * FROM capacity JOIN truck JOIN driver
                              WHERE capacity.id_truck = truck.id_truck AND capacity.id_driver = driver.id_driver ORDER BY cstatus DESC')->result(),
                'content' => 'admin/capacity/capacity',
                'navlink' => 'capacity',
            ];
        }
    
        $this->load->view('admin/vbackend', $data);
    }

    public function tambahcapacity() 
    {
        $add = [
            'id_capacity' => $this->crudModel->generateCode(1, 'id_capacity', 'capacity'),
            'schedule' => trim($this->input->post('schedule')),
            'id_truck' => trim($this->input->post('id_truck')),
            'id_driver' => trim($this->input->post('id_driver')),
        ];

        $this->crudModel->addData('capacity', $add);

        $this->session->set_flashdata('flash', 'ditambah');

        redirect(site_url('admin/capacity'));
    }

    public function updateCapacity()
    {
        $id_capacity = $this->input->post('id_capacity');

        $update = [
            'schedule' => trim($this->input->post('schedule')),
            'id_truck' => trim($this->input->post('id_truck')),
            'id_driver' => trim($this->input->post('id_driver')),
        ];

        $this->crudModel->updateData('capacity', 'id_capacity', $id_capacity, $update);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('admin/capacity'));
    }

    public function deleteCapacity()
    {
        $id_capacity = $this->uri->segment(3);

        $id_package = $this->db->query('SELECT id_package FROM v_capacity WHERE v_capacity.id_capacity = '.$id_capacity.'')->result();

        foreach($id_package as $data){
            $this->db->query('UPDATE package SET pstatus = 1 WHERE id_package = '.$data->id_package.' ');
        }

        $this->crudModel->deleteData('v_capacity', 'id_capacity', $id_capacity);

        $this->crudModel->deleteData('capacity', 'id_capacity', $id_capacity);

        $this->session->set_flashdata('flash', 'dihapus');

        redirect(site_url('admin/capacity'));
    }

    public function deleteVCapacity()
    {
        $id_capacity = $this->uri->segment(3);
        $id_package = $this->uri->segment(4);

        $min = $this->crudModel->getDataWhere('capacity', 'id_capacity', $id_capacity)->row();

        $get = $this->crudModel->getDataWhere('package', 'id_package', $id_package)->row();

        $status = [
            'pstatus' => 1,
        ];

        $update = [
            'b_capacity' => $min->b_capacity - $get->t_kg,
            'r_capacity' => $min->r_capacity - $get->t_kgv,
        ];

        $this->crudModel->updateData('package', 'id_package', $id_package, $status);

        $this->crudModel->updateData('capacity', 'id_capacity', $id_capacity, $update);

        $this->crudModel->deleteData('v_capacity', 'id_package', $id_package);

        $this->session->set_flashdata('flash', 'dihapus');

        redirect(site_url('admin/capacity/'.$id_capacity.'/view'));
    }
    
	public function listKota(){
		
		$date = $this->input->post('date');
		
		$kota = $this->db->query('SELECT DISTINCT date, package.id_kota, kota.kota FROM package JOIN kota WHERE date = "'.$date.'" AND pstatus = 1 AND package.id_kota = kota.id_kota OR date = "'.$date.'" AND pstatus = 3 AND package.id_kota = kota.id_kota ORDER BY date ASC')->result();
		
		$lists = "<option value=''>Pilih</option>";
		
		foreach( $kota as $data){
			$lists .= "<option value='".$data->id_kota."'>".$data->kota."</option>"; 
		}
		
		$callback = array('list_kota'=>$lists);

		echo json_encode($callback); 
	}

    public function listPackage(){

		$date = $this->input->post('date');

		$id_kota = $this->input->post('id_kota');
		
		$package = $this->db->query('SELECT * FROM package WHERE date = "'.$date.'" AND id_kota = '.$id_kota.' AND pstatus = 1 OR date = "'.$date.'" AND id_kota = '.$id_kota.' AND pstatus = 3 ')->result();

		$lists = "<option value=''>Pilih</option>";
		 
		foreach($package as $data){
			$lists .= "<option value='".$data->id_package."'>".$data->customer_name."</option>"; 
		}
		
		$callback = array('list_package'=>$lists); 

		echo json_encode($callback); 
	}

    public function addCapacity()
    {
        $id_capacity = $this->input->post('id_capacity');

        $add = [
            'id_vcapacity' => $this->crudModel->generateCode(1, 'id_vcapacity', 'v_capacity'),
            'id_capacity' => trim($this->input->post('id_capacity')),
            'id_package' => trim($this->input->post('id_package')),
        ];

        $volume = $this->crudModel->getDataWhere('package', 'id_package', $add['id_package'])->row();

        $capacity = $this->crudModel->getDataWhere('capacity', 'id_capacity', $add['id_capacity'])->row();

        $update = [
            'b_capacity' => $capacity->b_capacity + $volume->t_kg,
            'r_capacity' => $capacity->r_capacity + $volume->t_kgv,
        ];

        $update2 = [
            'pstatus' => 2,
        ];

        $this->crudModel->addData('v_capacity', $add);
        
        $this->crudModel->updateData('capacity', 'id_capacity', $add['id_capacity'], $update);

        $this->crudModel->updateData('package', 'id_package', $add['id_package'], $update2);

        $this->session->set_flashdata('flash', 'ditambah');

        redirect(site_url('admin/capacity/'.$id_capacity.'/view'));
    }

    public function addCapacitys()
    {
        $id_capacity = $this->input->post('id_capacity');

        $date = $this->input->post('date');
        $kota = $this->input->post('id_kota');

        $bmax =  $this->db->query('SELECT bmax - b_capacity + 1000 as b_capacity FROM capacity JOIN truck WHERE id_capacity = '.$id_capacity.' AND capacity.id_truck = truck.id_truck')->row();
        $vmax =  $this->db->query('SELECT capacity - r_capacity + 10 as s_capacity FROM capacity JOIN truck WHERE id_capacity = '.$id_capacity.' AND capacity.id_truck = truck.id_truck')->row();

        $cpciy = $this->db->query('SELECT id_package,
        id_kota,
        date,
        t_kg,
        t_kgv
        from ( SELECT id_package,
               id_kota,
               date,
               t_kg,
               t_kgv,
               SUM(t_kg) OVER(ORDER BY t_kg ASC) AS b_sum,
               SUM(t_kgv) OVER(ORDER BY t_kgv ASC) AS v_sum
        FROM package
        WHERE id_kota = '.$kota.' AND date = "'.$date.'" AND pstatus = 1 OR id_kota = '.$kota.' AND date = "'.$date.'" AND pstatus = 3) cum_sum WHERE v_sum <= '.$vmax->s_capacity.' AND b_sum <= '.$bmax->b_capacity.' ')->result();

        foreach($cpciy as $data){
        $this->db->query('INSERT INTO v_capacity (id_vcapacity, id_capacity, id_package) VALUES ('.$this->crudModel->generateCode(1, 'id_vcapacity', 'v_capacity').', '.$id_capacity.' , '.$data->id_package.' )');
        }

        $getb = $this->db->query('SELECT v_capacity.id_capacity, v_capacity.id_package, sum(t_kg) as t_kg FROM v_capacity JOIN package JOIN capacity WHERE v_capacity.id_capacity = '.$id_capacity.' AND v_capacity.id_capacity = capacity.id_capacity AND v_capacity.id_package = package.id_package')->row();

        $getv = $this->db->query('SELECT v_capacity.id_capacity, v_capacity.id_package, sum(t_kgv) as t_kgv FROM v_capacity JOIN package JOIN capacity WHERE v_capacity.id_capacity = '.$id_capacity.' AND v_capacity.id_capacity = capacity.id_capacity AND v_capacity.id_package = package.id_package')->row();

        $update = [
            'b_capacity' => $getb->t_kg,
            'r_capacity' => $getv->t_kgv,
        ];

        $this->crudModel->updateData('capacity', 'id_capacity', $id_capacity, $update);

        $status = $this->db->query('SELECT v_capacity.id_package FROM v_capacity WHERE v_capacity.id_capacity = '.$id_capacity.'')->result();

        foreach($status as $data){
            $this->db->query('UPDATE package SET pstatus = 2 WHERE id_package = '.$data->id_package.' ');
        }
        
        redirect(site_url('admin/capacity/'.$id_capacity.'/view'));
    }

    public function processCapacity()
    {
        $id_capacity = $this->uri->segment(3);

        $count = $this->db->query('SELECT COUNT(id_capacity) as t_package FROM v_capacity WHERE id_capacity ='.$id_capacity.'')->row();

        $update = [
            't_package' => $count->t_package,
            'cstatus' => 2,
        ];

        $this->crudModel->updateData('capacity', 'id_capacity', $id_capacity, $update);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('admin/capacity'));
    }

    public function truck()
    {   
        if ($this->uri->segment(3) === 'addtruck') {

        $data = [
            'truck' => $this->db->query('SELECT * FROM truck')->result(),
            'content' => 'admin/truck/addtruck',
            'navlink' => 'truck',
        ];

    } else if ($this->uri->segment(4) === 'update') {

        $id = $this->uri->segment(3);

        $tampil = $this->crudModel->getDataWhere('truck', 'id_truck', $id)->row();

        $data = [
            'detail' => [
                'id_truck' => $tampil->id_truck,
                'truck' => $tampil->truck,
                'no_plate' => $tampil->no_plate,
                'bmax' => $tampil->bmax,
                'capacity' => $tampil->capacity,
            ],

            'content' => 'admin/truck/updatetruck',
            'navlink' => 'truck',
            ]; 

    } else {

        $data = [
            'truck' => $this->crudModel->getData('truck')->result(),
            'content' => 'admin/truck/truck',
            'navlink' => 'truck',
            ];
        }
    
        $this->load->view('admin/vbackend', $data);
    }

    public function addtruck() 
    {
        $add = [
            'id_truck' => $this->crudModel->generateCode(1, 'id_truck', 'truck'),
            'truck' => trim($this->input->post('truck')),
            'no_plate' => trim($this->input->post('no_plate')),
            'bmax' => trim($this->input->post('bmax')),
            'capacity' => trim($this->input->post('capacity')),
        ];

        $this->crudModel->addData('truck', $add);

        $this->session->set_flashdata('flash', 'ditambah');

        redirect(site_url('admin/truck'));
    }

    public function updateTruck()
    {
        $id_truck = $this->input->post('id_truck');

        $update = [
            'truck' => trim($this->input->post('truck')),
            'no_plate' => trim($this->input->post('no_plate')),
            'bmax' => trim($this->input->post('bmax')),
            'capacity' => trim($this->input->post('capacity')),
        ];

        $this->crudModel->updateData('truck', 'id_truck', $id_truck, $update);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('admin/truck'));
    }

    public function deleteTruck()
    {
        $id_truck = $this->uri->segment(3);

        $this->crudModel->deleteData('truck', 'id_truck', $id_truck);

        $this->session->set_flashdata('flash', 'dihapus');

        redirect(site_url('admin/truck'));
    }

    public function driver()
    {   
        if ($this->uri->segment(3) === 'adddriver') {

        $data = [
            'driver' => $this->db->query('SELECT * FROM driver')->result(),
            'content' => 'admin/driver/adddriver',
            'navlink' => 'driver',
        ];

    } else if ($this->uri->segment(4) === 'update') {

        $id = $this->uri->segment(3);

        $tampil = $this->crudModel->getDataWhere('driver', 'id_driver', $id)->row();

        $data = [
            'detail' => [
                'id_driver' => $tampil->id_driver,
                'driver' => $tampil->driver,
                'phone' => $tampil->phone,
                'email' => $tampil->email,
            ],

            'content' => 'admin/driver/updatedriver',
            'navlink' => 'driver',
            ]; 

    } else {

        $data = [
            'driver' => $this->crudModel->getData('driver')->result(),
            'content' => 'admin/driver/driver',
            'navlink' => 'driver',
            ];
        }
    
        $this->load->view('admin/vbackend', $data);
    }

    public function adddriver() 
    {
        $add = [
            'id_driver' => $this->crudModel->generateCode(1, 'id_driver', 'driver'),
            'driver' => trim($this->input->post('driver')),
            'phone' => trim($this->input->post('phone')),
            'email' => trim($this->input->post('email')),
        ];

        $this->crudModel->addData('driver', $add);

        $this->session->set_flashdata('flash', 'ditambah');

        redirect(site_url('admin/driver'));
    }

    public function updatedriver()
    {
        $id_driver = $this->input->post('id_driver');

        $update = [
            'driver' => trim($this->input->post('driver')),
            'phone' => trim($this->input->post('phone')),
            'email' => trim($this->input->post('email')),
        ];

        $this->crudModel->updateData('driver', 'id_driver', $id_driver, $update);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('admin/driver'));
    }

    public function deletedriver()
    {
        $id_driver = $this->uri->segment(3);

        $this->crudModel->deleteData('driver', 'id_driver', $id_driver);

        $this->session->set_flashdata('flash', 'dihapus');

        redirect(site_url('admin/driver'));
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
                'content' => 'admin/shipping/addshipment',
                'navlink' => 'shipping',
            ];

        } else {

            $data = [
                'capacity' => $this->db->query('SELECT * FROM capacity JOIN truck JOIN driver
                            WHERE capacity.id_truck = truck.id_truck AND capacity.id_driver = driver.id_driver AND cstatus = 2')->result(),
                'content' => 'admin/shipping/shipping',
                'navlink' => 'shipping',
            ];
        }

        $this->load->view('admin/vbackend', $data);
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

        redirect(site_url('admin/shipping/'.$id_capacity.'/view'));
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

        redirect(site_url('admin/shipping/'.$id_capacity.'/view'));
    }

    public function completeShipping()
    {
        $id_capacity = $this->uri->segment(3);

        $update = [
            'cstatus' => 3,
        ];

        $this->crudModel->updateData('capacity', 'id_capacity', $id_capacity, $update);

        $this->session->set_flashdata('flash', 'diubah');

        redirect(site_url('admin/shipping'));
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
                'content' => 'admin/report/viewreport',
                'navlink' => 'report',
            ];

            $this->load->view('admin/report/viewreport', $data);

        } else {

            $data = [
                'capacity' => $this->db->query('SELECT * FROM capacity JOIN truck JOIN driver 
                            WHERE capacity.id_truck = truck.id_truck AND capacity.id_driver = driver.id_driver AND capacity.cstatus = 3')->result(),
                'content' => 'admin/report/report',
                'navlink' => 'report',
            ];

            $this->load->view('admin/vbackend', $data);

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