<?php

namespace App\Repository;
use App\Order;
use Illuminate\Database\Eloquent\Model;

class OrderRepository
{
	protected $model;

	public function __construct(Order $order)
	{
		$this->model = $order;
	}

	public function all()
	{
		return $this->model->all();
	}

	public function paginate($page)
	{
		return $this->model->paginate($page);
	}

	public function store(array $data)
	{
		$this->model->create($data);
	}

	public function orderByPaginate($col, $sort, $page)
	{
		return $this->model->orderBy($col, $sort)->paginate($page);
	}


}