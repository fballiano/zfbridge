<?php
/**
 * zfbridge
 *
 * @link      https://github.com/fballiano/zfbridge for the canonical source repository
 * @copyright Copyright (c) 2012 Fabrizio Balliano (http://www.fabrizioballiano.it)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   zfbridge
 */

namespace zfbridge;

class Db
{
	private $adapter_read = null;
	private $adapter_write = null;

	public function __construct($adapter_read, $adapter_write = null)
	{
		$this->adapter_read = $adapter_read;
		$this->adapter_write = $adapter_write;
	}

	public function getAdapterRead()
	{
		return $this->adapter_read;
	}

	public function getAdapterWrite()
	{
		if ($this->adapter_write) return $this->adapter_write;
		return $this->adapter_read;
	}

	public function fetchAll($query, $params = null)
	{
		$return = array();

		$rs = $this->getAdapterRead()->query($query)->execute($params);
		foreach ($rs as $row) {
			$return[] = $row;
		}

		return $return;
	}

	public function fetchPairs($query, $params = null)
	{
		$return = array();

		$rs = $this->getAdapterRead()->query($query)->execute($params);
		foreach ($rs as $row) {
			$row = array_values($row);
			$return[$row[0]] = $row[1];
		}

		return $return;
	}

	public function fetchOne($query, $params = null)
	{
		$rs = $this->getAdapterRead()->query($query)->execute($params);
		foreach ($rs as $row) {
			$row = array_values($row);
			return $row[0];
		}

		return null;
	}

	public function fetchCol($query, $params = null)
	{
		$return = array();

		$rs = $this->getAdapterRead()->query($query)->execute($params);
		foreach ($rs as $row) {
			$row = array_values($row);
			$return[] = $row[0];
		}

		return $return;
	}

	public function insert($table, $fields)
	{
		$tg = new \Zend\Db\TableGateway\TableGateway($table, $this->getAdapterWrite());
		return $tg->insert($fields);
	}

	public function update($table, $fields, $where = null)
	{
		$tg = new \Zend\Db\TableGateway\TableGateway($table, $this->getAdapterWrite());
		return $tg->update($fields, $where);
	}

	public function update($table, $where = null)
	{
		$tg = new \Zend\Db\TableGateway\TableGateway($table, $this->getAdapterWrite());
		return $tg->delete($where);
	}
}