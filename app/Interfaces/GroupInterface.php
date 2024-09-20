<?php

namespace App\Interfaces;

interface GroupInterface
{
    public function index();
    public function store(array $data);
    public function update(array $data, string $id);
    public function destroy(string $id);
    public function show(string $id);
}
