<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class AuthService 
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Untuk mengambil semua list user
     */
    public function getAll() : ?Object
    {
        $users = $this->authRepository->getAll();
        $user = $users->isEmpty() ? null : $users;
        return $user;
    }

    /**
     * Untuk menambahkan user
     */
    public function store(array $data) : Object
    {
        $validator = Validator::make($data, [
            'username' => 'required|string|min:4|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->authRepository->store($validator->validated());
        return $result;
    }

    /**
     * Untuk melakukan login user dengan data yang diperlukan
     */
    public function login(array $credentials) : string|bool
    {        
        $validator = Validator::make($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }        

        $token = auth()->attempt($credentials, true);

        return $token;
    }

    /**
     * Untuk melihat detail user yang telah dalam keadaan logged in
     */
    public function data() : Authenticatable
    {
        return auth()->user();
    }

    /**
     * Untuk melakukan logout pada user
     */
    public function logout() : string
    {
        $username = auth()->user()['username'];
        auth()->logout();
        return $username;
    }
}