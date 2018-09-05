<?php

namespace App\Repository;

interface ItemRepositoryInterface
{

	public function all();
	public function paginate($page);

}