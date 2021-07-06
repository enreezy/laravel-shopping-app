<?php

namespace App\Repository;

use App\AdminImage;
use Illuminate\Database\Eloquent\Model;

class AdminImageRepository
{
	protected $model;

	public function __construct(AdminImage $model)
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

	public function update($item, array $data)
	{
		return $item->update($data);
	}

	public function delete($item)
	{
		return $item->delete();
	}

}
