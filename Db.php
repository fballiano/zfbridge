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
use \Zend\Db\Sql\Sql;

class Db
{
	/**
	 * @var \Zend\Db\Adapter\Adapter
	 */
	private $adapter = null;

	/**
	 * @param \Zend\Db\Adapter\Adapter $adapter
	 */
	public function __construct($adapter)
	{
		$this->adapter = $adapter;
	}

	/**
	 * @return \Zend\Db\Adapter\Adapter
	 */
	public function getAdapter()
	{
		return $this->adapter;
	}

	/**
	 * @return \Zend\Db\Sql\Select
	 */
	public function select()
	{
		$sql = new \Zend\Db\Sql\Sql($this->getAdapter());
		return $sql->select();
	}

	/**
	 * @param string $query
	 * @param null|array $params
	 * @return array
	 */
	public function fetchAll($query, $params = null)
	{

		if (is_object($query)) {
			$query = $query->getSqlString();
		}

		$rs = $this->getAdapter()->query($query)->execute($params);
		foreach ($rs as $row) {
			$return[] = $row;
		}

		return $return;
	}

	/**
	 * @param string $query
	 * @param null|array $params
	 * @return array
	 */
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

	/**
	 * @param string $query
	 * @param null|array $params
	 * @return string
	 */
	public function fetchOne($query, $params = null)
	{
		$rs = $this->getAdapter()->query($query)->execute($params);
		foreach ($rs as $row) {
			$row = array_values($row);
			return $row[0];
		}

		return null;
	}

	/**
	 * @param string $query
	 * @param null|array $params
	 * @return array
	 */
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

	/**
	 * @param string $table
	 * @param array $fields
	 * @return int
	 */
	public function insert($table, $fields)
	{
		$tg = new \Zend\Db\TableGateway\TableGateway($table, $this->getAdapter());
		return $tg->insert($fields);
	}

	/**
	 * @param string $table
	 * @param array $fields
	 * @param null|string $where
	 * @return int
	 */
	public function update($table, $fields, $where = null)
	{
		$tg = new \Zend\Db\TableGateway\TableGateway($table, $this->getAdapter());
		return $tg->update($fields, $where);
	}

	/**
	 * @param string $table
	 * @param null|string $where
	 * @return int
	 */
	public function delete($table, $where = null)
	{
		$tg = new \Zend\Db\TableGateway\TableGateway($table, $this->getAdapter());
		return $tg->delete($where);
	}
}