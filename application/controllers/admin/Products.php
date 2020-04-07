<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("product_model"); 
        $this->load->library('form_validation'); 
    }

    public function index()
    {
        $data["products"] = $this->product_model->getAll();
        $this->load->view("admin/product/list", $data);
    }

    public function add()
    {
        $product = $this -> product_model; // objek model
        $validation = $this -> form_validation; // objek form validation
        $validation->set_rules($product->rules()); // menerapkan rules

        if($validation->run()) { // melakukan validasi input
            $product->save(); // menyimpan ke database
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }

        $this->load->view("admin/product/new_form"); 
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('admin/products'); // redirect jika id tidak ada

        $product = $this->product_model; // objek model
        $validation = $this->form_validation; // objek form validation
        $validation->set_rules($product->rules()); // menerapkan rules

        if ($validation->run()) { // melakukan validasi input
            $product->update(); // menyimpan ke database
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }

        $data["product"] = $product->getById($id); // mengambil data untuk ditampilkan
        if (!$data["product"]) show_404(); // error, jika data tidak ditemukan

        $this->load->view("admin/product/edit_form", $data);
    }

    public function delete($id=null)
    {
        if (!isset($id)) show_404();
        
        if ($this->product_model->delete($id)) { 
            redirect(site_url('admin/products')); // redirect jika data sukses dihapus
        }
    }

    public function buttons()
    {
        $this->load->view("admin/Components/buttons");
    }

    public function cards()
    {
        $this->load->view("admin/Components/cards");
    }
}