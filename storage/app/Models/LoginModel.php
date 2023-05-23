<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $usersTB;

    public function __construct()
    {
        parent::__construct();
        $this->usersTB = $this->db->table('users');
    }

    public function loginUser($data)
    {
        $query = $this->usersTB->where('email', $data)->get();
        return $query;
    }
}