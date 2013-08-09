<?php

/**
 *      Copyright 2010 vladzur
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
class Model {

	public $link = null;

	/**
	 *
	 * @var string $pk Primary key name
	 */
	public $pk = 'id';

	/**
	 * Class constructor
	 */
	function __construct() {
		$this->connect();
	}

	/**
	 * Connect database
	 */
	function connect() {

		$this->link = mysql_connect(_HOST_, _USER_, _PWD_);
		mysql_select_db(_DB_, $this->link);
	}

	/**
	 * Close database connection
	 */
	function close() {
		mysql_close($this->link);
	}

	/**
	 * Executes a query
	 * @param string $ssql SQL query
	 * @return mixed resultset
	 */
	function query($ssql = null) {
		if ($result = mysql_query($ssql)) {
			while ($row = mysql_fetch_assoc($result)) {
				$output[] = $row;
			}
			return $output;
		}
		return false;
	}

	/**
	 * Saves data into a table
	 * @param string $tabla Table name
	 * @param array $data Array data to save
	 * @return mixed resultset
	 */
	function save($tabla, $data) {
		$campos = array_keys($data);
		$desc = $this->describe_tabla($tabla);
		if ($desc[0]['Field'] == $this->pk && $desc[0]['Type'] == 'char(36)') {
			$uuid = $this->generateUUID();
			$field.="id, ";
			$value.="\"$uuid\", ";
		}
		foreach ($campos as $campo) {
			for ($i = 0; $i < count($desc); $i++) {
				if ($campo == $desc[$i]['Field']
				)
					$tipo = $desc[$i]['Type'];
			}
			if (stristr($tipo, "varchar")
			)
				$value.="\"" . $data[$campo] . "\", ";
			if (stristr($tipo, "text")
			)
				$value.="\"" . $data[$campo] . "\", ";
			if (stristr($tipo, "int")
			)
				$value.=$data[$campo] . ", ";
			if (stristr($tipo, "float")
			)
				$value.=$data[$campo] . ", ";
			if (stristr($tipo, "double")
			)
				$value.=$data[$campo] . ", ";
			if (stristr($tipo, "blob")
			)
				$value.="\"" . $data[$campo] . "\", ";
			if (stristr($tipo, "date")
			)
				$value.="\"" . $data[$campo] . "\", ";
			$field.=$campo . ", ";
		}
		$field = trim($field, ", ");
		$value = trim($value, ", ");
		$sql = "INSERT INTO " . $tabla . " (" . $field . ") VALUES (" . $value . ")";
		return $this->query($sql);
	}

	/**
	 * 	Updates data
	 * @param string $tabla Table name
	 * @param array $data Array data
	 * @param string $condicion Update conditions
	 * @return mixed Resultset
	 */
	function update($tabla, $data, $condicion) {
		$campos = array_keys($data);
		$desc = $this->describe_tabla($tabla);
		foreach ($campos as $campo) {
			for ($i = 0; $i < count($desc); $i++) {
				if ($campo == $desc[$i]['Field']
				)
					$tipo = $desc[$i]['Type'];
			}
			if (stristr($tipo, "varchar")
			)
				$value.=$campo . "='" . $data[$campo] . "', ";
			if (stristr($tipo, "text")
			)
				$value.=$campo . "='" . $data[$campo] . "', ";
			if (stristr($tipo, "int")
			)
				$value.=$campo . "=" . $data[$campo] . ", ";
			if (stristr($tipo, "blob")
			)
				$value.=$campo . "='" . $data[$campo] . "', ";
		}

		$value = trim($value, ", ");
		$sql = "UPDATE " . $tabla . " SET " . $value . " WHERE " . $condicion;
		//echo $sql;
		return $this->query($sql);
	}

	/**
	 * Deletes data from a table
	 * @param string $tabla Table name
	 * @param string $condicion Delete conditions
	 * @return mixed Resultset
	 */
	function delete($tabla, $condicion) {
		$sql = "DELETE " . $tabla . " WHERE " . $condicion;
		if ($result = mysql_query($sql)) {
			$this->close();
			return true;
		}
		return false;
	}

	/**
	 * Describes a table structure
	 * @param string $tabla Table name
	 * @return mixed Resultset
	 */
	function describe_tabla($tabla) {
		$sql = "DESCRIBE " . $tabla;
		$res = mysql_query($sql);
		while ($field = mysql_fetch_assoc($res)) {
			$output[] = array('Field' => $field['Field'], 'Type' => $field['Type']);
		}
		return $output;
	}

	/**
	 * Generates an universal unique identifier
	 * @return string UUID
	 */
	function generateUUID() {
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}

	/**
	 * Reads a table content
	 * @param string $table Table name
	 * @param mixed $id Unique idendifier (pk)
	 * @return mixed Resultset
	 */
	function read($table = null, $id = null) {
		$desc = $this->describe_tabla($table);
		if ($desc[0]['Field'] == $this->pk && $desc[0]['Type'] == 'char(36)') {
			$sql = "SELECT * FROM $table WHERE $this->pk = \"$id\"";
		} else {
			$sql = "SELECT * FROM $table WHERE $this->pk = $id";
		}
		return $this->query($sql);
	}

	/**
	 * Paginates a resultset
	 * @param string $table Table name
	 * @param int $page Current page
	 * @param int $page_size Page size
	 * @return mixed Resultset
	 */
	function paginate($table = null, $page = 1, $page_size = 10) {
		$sql = "SELECT * FROM $table WHERE 1=1";
		$size = count($this->query($sql));
		$start = $page + $page_size;
		if ($page == 1) {
			$start = 0;
		}
		$sql = "SELECT * FROM $table WHERE 1=1 LIMIT $start,$page_size";
		return $this->query($sql);
	}

	/**
	 * Generates a list to be used in a selector form
	 * @param string $table Table name
	 * @param string $field Field to display
	 * @return array Array containing the list
	 */
	function generateList($table, $field) {
		$sql = "SELECT $this->pk , $field FROM $table";
		$list = $this->query($sql);
		foreach ($list as $item) {
			$selectList[$item[$this->pk]] = $item[$field];
		}
		return $selectList;
	}

}

?>