<?php

namespace App\Repository;

use App\Item;
use Illuminate\Database\Eloquent\Model;
use App\Repository\ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface
{
	protected $model;

	public function __construct(Item $model)
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
}
