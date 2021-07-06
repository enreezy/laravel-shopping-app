<?php

namespace App\Repository;
use App\Topic;
use Illuminate\Database\Eloquent\Model;

class TopicRepository
{
	protected $model;

	public function __construct(Topic $topic)
	{
		$this->model = $topic;
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

	public function find($id)
	{
		return $this->model->findOrFail($id);
	}


}