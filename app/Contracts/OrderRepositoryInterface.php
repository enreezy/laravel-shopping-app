<?php

namespace App\Repository;

interface OrderRepositoryInterface
{
	public function all();
	public function paginate($page);
	public function store(array $data);
}