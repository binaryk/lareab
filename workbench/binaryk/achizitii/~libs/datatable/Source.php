<?php

namespace Datatable;

class Source 
{

	const SOURCE_SQL 		= 'sql';
	const SOURCE_COLLECTION = 'collection';
	const SOURCE_QUERY   	= 'query';

	protected static $instance = NULL;

	protected $type        = NULL;
	protected $rowssql     = '';
	protected $countsql    = '';
	protected $totalsql    = '';
	protected $fields      = '';
	protected $searchables = '';
	protected $orderables  = '';
	protected $cells       = '';

	protected $columns     = NULL;

	protected $length     = NULL;
	protected $start      = NULL;
	protected $search     = NULL;
	protected $order      = NULL;

	protected $custom_filters = NULL;

	public static function make()
	{
		return self::$instance = new Source();
	}

	public function __call($method, $args)
	{
		if(! property_exists($this, $method))
		{
			throw new \Exception(__CLASS__ .'. Property ' . $method . ' unknown.');
		}
		if( isset($args[0]) )
		{
			$this->{$method} = $args[0];
			return $this;
		}
		return $this->{$method};
	}

	protected function out($data)
	{
		$result = [];
		foreach($data as $i => $record)
		{
			$item = [];
			foreach($this->cells as $j => $cell)
			{
				if($cell->visible())
				{
					$item["DT_RowId"]    = 'record_id_' . $record->id;
					$item["DT_RowClass"] = 'dt-table-row';
					// $item["DT_RowAttr"] = '{"x":1, "y":"2"}';

					$item[$cell->id()] = $cell->out($record, $this->start + $i + 1);
				}
			}
			$result[] = $item;
		}
		return $result;
	}

	protected function searchWhere()
	{
		$result = '';
		if( $this->search )
		{
			if( $this->search['value'] )
			{
				foreach($this->searchables as $i => $field)
				{
					if($field)
					{
						$result .= "(CAST(" . $field . " AS CHAR) LIKE '%" . $this->search['value'] ."%') OR ";
					}
				}
			}
			if( $result )
			{
				$result = "(" . substr($result, 0, strlen($result) - 4) . ")";
			}
		}
		return $result;
	}

	protected function customFilter()
	{
		$result = '';
		foreach($this->custom_filters as $name => $expression)
		{
			$result .= "(" . $expression . ") AND ";
		}
		if( $result )
		{
			$result = "(" . substr($result, 0, strlen($result) - 5) . ")";
		}
		return $result;
	}

	protected function searchByCriterias()
	{
		$result = '';
		if( is_array($this->columns) )
		{
			foreach($this->columns as $i => $col)
			{
				if( array_key_exists('search', $col) )
				{
					if( array_key_exists('value', $col['search']) )
					{
						$value = $col['search']['value'];
						if( strlen($value) )
						{
							$result .= '(' . $value . ') AND ';
						}
					}
				}
			}
		}
		// dd($result);
		if( $result )
		{
			return substr($result, 0, strlen($result) - 5);
		}
		return $result;
	}

	protected function Where()
	{

		if( $search_by_criterias = $this->searchByCriterias() )
		{
			$expressions = [$search_by_criterias];
		}
		else
		{
			$expressions = [$this->searchWhere(), $this->customFilter()];
		}
		$result = '';
		foreach($expressions as $i => $expression)
		{
			if($expression)
			{
				$result .= $expression . " AND ";
			}
		}
		if( $result )
		{
			$result = " WHERE " . substr($result, 0, strlen($result) - 5);
		}
		return $result;
	}

	protected function order()
	{
		$result = '';
		if( $this->order )
		{
			foreach($this->orderables as $i => $item)
			{
				if($this->order[0]['column'] == $i)
				{
					$result = $item . ' ' . strtoupper($this->order[0]['dir']);
					break;
				}
			}
		}
		if( $result )
		{
			$result = ' ORDER BY ' . $result;
		}
		return $result;
	}

	public function data()
	{
		$sql = $this->rowssql;
		$sql = str_replace(':fields:', implode(',', $this->fields), $sql);
		$sql = str_replace(':where:', $this->Where(), $sql);
		$sql = str_replace(':order:', $this->order(), $sql);

		$sql .= ' LIMIT ' . $this->length . ' OFFSET ' . $this->start;

		return $this->out(\DB::select( $sql ));
	}

	public function totalFilteredRecords()
	{
		$sql = $this->countsql;
		$sql = str_replace(':where:', $this->Where(), $sql);

		$result = \DB::select( $sql );
		if( array_key_exists(0, $result) )
		{
			return $result[0]->cnt;
		}
		return 0;
	}

	public function totalRecords()
	{
		$result = \DB::select( $this->totalsql );
		if( array_key_exists(0, $result) )
		{
			return $result[0]->cnt;
		}
		return 0;
	}

}