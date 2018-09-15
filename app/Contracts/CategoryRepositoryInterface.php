<?php

namespace App\Repository;

interface CategoryRepositoryInterface
{

	public function all();
	public function paginate($page);
	public function findOrFail($id);
	public function store(array $data);
	public function show($id);
	public function update($item, $data);
	public function delete($item);

}