<?php

namespace App\Interfaces;

interface UserInterface
{
    public function index();
    public function store(array $data);
    public function update(array $data);
    public function destroy(string $id);
    public function show(string $id);
    public function login(array $data);
    public function resetPassword(string $email);
}
