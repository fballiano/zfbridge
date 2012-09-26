<?php
/**
 * ZFBridge
 *
 * @link      https://github.com/fballiano/zfbridge for the canonical source repository
 * @copyright Copyright (c) 2012 Fabrizio Balliano (http://www.fabrizioballiano.it)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   zfbridge
 */

namespace ZFBridge;

class Db
{
	private $adapter = null;

	public function __construct($adapter)
	{
		$this->adapter = $adapter;
	}

	public function getAdapter()
	{
		return $this->adapter;
	}

	public function fetchAll($query, $params = null)
	{
		$return = array();

		$rs = $this->getAdapter()->query($query)->execute($params);
		foreach ($rs as $row) {
			$return[] = $row;
		}

		return $return;
	}

	public function fetchPairs($query, $params = null)
	{
		$return = array();

		$rs = $this->getAdapter()->query($query)->execute($params);
		foreach ($rs as $row) {
			$row = array_values($row);
			$return[$row[0]] = $row[1];
		}

		return $return;
	}

	public function fetchOne($query, $params = null)
	{
		$rs = $this->getAdapter()->query($query)->execute($params);
		foreach ($rs as $row) {
			$row = array_values($row);
			return $row[0];
		}

		return null;
	}

	public function fetchCol($query, $params = null)
	{
		$return = array();

		$rs = $this->getAdapter()->query($query)->execute($params);
		foreach ($rs as $row) {
			$row = array_values($row);
			$return[] = $row[0];
		}

		return $return;
	}

	public function insert($table, $fields)
	{
		$tg = new \Zend\Db\TableGateway\TableGateway($table, $this->getAdapter());
		return $tg->insert($fields);
	}

	public function update($table, $fields, $where = null)
	{
		$tg = new \Zend\Db\TableGateway\TableGateway($table, $this->getAdapter());
		return $tg->update($fields, $where);
	}

	public function delete($table, $where = null)
	{
		$tg = new \Zend\Db\TableGateway\TableGateway($table, $this->getAdapter());
		return $tg->delete($where);
	}
}