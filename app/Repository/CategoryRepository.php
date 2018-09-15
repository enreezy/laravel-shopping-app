<?php

namespace App\Repository;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository
{
	protected $model;

	public function __construct(Category $model)
	{
		$this->model = $model;
	}

	public function all()
	{	
		return $this->model->all();
	}

	public function paginate($page)
	{
		return $this->model->paginate($page);
	}

	public function findOrFail($id)
	{
		return $this->model->findOrFail($id);
	}

	public function store(array $data)
	{
		$this->model->create($data);
	}

	public function show($id)
	{
		return $this->model->findOrFail($id);
	}

	public function update($category, $data)
	{
		return $category->update($data);
	}

	public function delete($category)
	{
		return $category->delete();
	}
}
