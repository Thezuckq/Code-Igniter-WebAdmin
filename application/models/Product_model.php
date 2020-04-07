<?php defined('BASEPATH') OR exit('No drirect script access allowed');

class Product_model extends CI_Model
{
	Private $_table = "products";

	public $product_id;
	public $name;
	public $price;
	public $image = "default.jpg";
	public $description;
	public function rules()
	{
		return [
			['field' => 'name',
            'label' => 'Name',
            'rules' => 'required'],

            ['field' => 'price',
            'label' => 'Price',
            'rules' => 'numeric'],
            
            ['field' => 'description',
            'label' => 'Description',
            'rules' => 'required']
		];
	}

	public function getAll()
	{
		return $this->db->get($this->_table)->result();
	}

	public function getById($id)
	{
		return $this->db->get_where($this->_table, ["product_id" => $id])->row();
	}

	public function save() // method untuk menyimpan data baru
	{
		$post = $this->input->post(); //mengambil data dari form
		$this->product_id = uniqid(); //membuat unik id
		$this->name = $post["name"]; //isi field name
		$this->price = $post["price"]; // isi field price
		$this->description = $post["description"]; // isi field description
		return $this->db->insert($this->_table, $this); // menyimpan ke database
	}

	public function update() // method untuk melakukan update
    {
        $post = $this->input->post();
        $this->product_id = $post["id"]; // mengambil id dari form
        $this->name = $post["name"];
        $this->price = $post["price"];
        $this->description = $post["description"];
        return $this->db->update($this->_table, $this, array('product_id' => $post['id']));
    }

    public function delete($id) // method untuk menghapus
    {
        return $this->db->delete($this->_table, array("product_id" => $id));
    }
}