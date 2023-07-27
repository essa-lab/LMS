<?php
namespace App\Service;

interface UserServiceInterface{
    public function login(array $credentials);
    public function register(array $data);
    public function logout();
    public function resetPassword(array $credentials);
    public function verifyEmail($pin);
    public function verifyPin(array $credentials);
    public function forgetPassword($email);
}