<?php

namespace App\Interfaces;

interface GroupInterface
{
    public function index();
    public function store(array $data);
    public function update(array $data, string $id);
    public function delete(string $id);
    public function show(string $id);
    public function getUserGroups();
    public function searchGroup(string $group);
}
