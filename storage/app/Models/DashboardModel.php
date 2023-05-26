<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $productsTB;

    public function __construct()
    {
        parent::__construct();
        $this->productsTB = $this->db->table('products');
    }

    public function fetchProduct()
    {
        $query = $this->productsTB->get();
        return $query->getResult();
    }

    public function addProduct($data)
    {
        $query = $this->productsTB->insert($data);
        return $query;
    }

    public function updatedProduct($id, $data)
    {
        $query = $this->productsTB->where('product_id', $id);
        return $query->update($data);
    }

    public function deleteProduct($id)
    {
        $query = $this->productsTB->where('product_id', $id);
        return $query->delete();
    }
}