<?php

namespace App\Dataset;
use App\Repository\ItemRepository;

class DatasetBuilder
{
	protected $item;

	public function __construct(ItemRepository $item)
	{
		$this->item = $item;
	}

	public function getAllItem()
	{
		$data = array();

		foreach($this->item->all() as $item)
		{
			array_push($data, $item->name);
		}

		return $data;
	}

	public function getAllItemQuantity()
	{
		$data = array();

		foreach($this->item->all() as $item)
		{
			array_push($data, $item->quantity);
		}

		return $data;
	}

	public function getAllItemBGColor()
	{
		$data = array();

		

		foreach($this->item->all() as $item)
		{
			$color = $this->randomColor();
			array_push($data, $color);
		}

		return $data;
	}

	public function randomColor()
	{
		$val1 = rand(0,9);
		$val2 = rand(0,9);
		$val3 = rand(0,9);
		$val4 = rand(0,9);
		$val5 = rand(0,9);
		$val6 = rand(0,9);

		$color = "#$val1$val2$val3$val4$val5$val6";

		return $color;
	}
}