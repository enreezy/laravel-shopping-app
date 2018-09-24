<?php

namespace App\Repository;
use App\Message;
use Illuminate\Database\Eloquent\Model;

class MessageRepository
{
	protected $model;

	public function __construct(Message $message)
	{
		$this->model = $message;
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

	public function where($data)
	{
		return $this->model->where($data)->get();
	}


}