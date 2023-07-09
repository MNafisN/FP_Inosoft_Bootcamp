<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    protected $users;

    public function __construct(User $user)
    {
        $this->users = $user;
    }

    /**
     * Untuk mengambil semua list user
     */
    public function getAll() : Object
    {
        $users = $this->users->get();
        return $users;
    }

    /**
     * Untuk mengambil data user berdasarkan id
     */
    public function getById(string $id) : Object
    {
        $user = $this->users->where('_id', $id)->get();
        return $user;
    }

    /**
     * Untuk menyimpan data user baru
     */
    public function store(array $data) : Object
    {
        $userBaru = new $this->users;

        $userBaru->username = $data['username'];
        $userBaru->email = $data['email'];
        $userBaru->password = bcrypt($data['password']);
        $userBaru->first_name = $data['first_name'];
        $userBaru->last_name = $data['last_name'];
        $userBaru->email_verified_at = time();

        $userBaru->save();
        return $userBaru->fresh();
    }

    /**
     * Untuk menghapus data user berdasarkan id
     */
    public function delete(string $id) : void
    {
        $this->users->where('_id', $id)->delete();
    }
}