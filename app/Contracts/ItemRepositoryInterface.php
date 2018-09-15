<?php

namespace App\Repository;

interface ItemRepositoryInterface
{

	public function all();
	public function paginate($page);
	public function findOrFail($id);
	public function store(array $data);
	public function show($id);
	public function update($item, array $data);
	public function delete($item);

}