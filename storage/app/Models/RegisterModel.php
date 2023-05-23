<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterModel extends Model
{
    protected $usersTB;

    public function __construct()
    {
        parent::__construct();
        $this->usersTB = $this->db->table('users');
    }

    public function registerUser($data)
    {
        $query = $this->usersTB->insert($data);
        return $query;
    }
}