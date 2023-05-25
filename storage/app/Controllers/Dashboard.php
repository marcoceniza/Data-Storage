<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    public function fetchProductController()
    {
        $model = model(DashboardModel::class);

        $result = $model->fetchProduct();

        return $this->response->setJSON(['success' => true, 'result' => $result]);
    }

    public function addProductController()
    {
        $model = new DashboardModel();

        $post = $this->request->getPost(['name', 'price', 'description']);

        if(empty($post['name']) || empty($post['price']) || empty($post['description'])) return $this->response->setJSON(['success' => false, 'result' => 'All Fields are Required!']);

        $data = [
            'name' => $post['name'],
            'price' => $post['price'],
            'description' => $post['description'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $result = $model->addProduct($data);

        return $this->response->setJSON(['success' => true, 'result' => 'Added Successfully!']);
    }

    public function deleteProductController()
    {
        $model = new DashboardModel();

        $post = $this->request->getPost(['productID']);

        $data = [
            'product_id' => $post['productID']
        ];

        $result = $model->deleteProduct($data);

        return $this->response->setJSON(['success' => true, 'result' => 'Deleted Successfully!']);
    }
}
