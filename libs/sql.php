<?php
/**
 * MODELO REALACIONAL DE SEGURIDAD BASE DE DATOS
 * NANO SOFT (C) OBORO CP 15|11|2k15 - 3o/o3/2k17
 * 	- persistant conection
 *  - Users as instances
 *  - execute as query
 *  - Migración PDO::
 **/
class DATABASE extends CONFIG
{
	private $PDO = FALSE;
	private $PDO_FORUM = FALSE;
	private $result;
	public $stmt;
	private $EndSQL;

	/**
	* Crea la conexión a la DB al entrar a la página
	* 16/08/2017 Security Update
	* Crea la instancia SQL a Main o Forum, dependiendo de la necesidad.
	* Esto ya que el foro no puede estar en la misma DB del In-Game.
	* Misma debe estar en la DB del WebHost.
	**/
	public function getConnection($option = "main") 
	{
		if (!strcasecmp($option,"main"))
		{
			if (!$this->PDO)
			{
				try
				{
					$dns = 'mysql:host='.$this->getConfig('DBHost').';dbname='.$this->getConfig('DBase').';charset=utf8';
					$this->PDO = new PDO($dns, $this->getConfig('DBUser'), $this->getConfig('DBPswd'));
				} catch (PDOException $e) 
				{
					die('cannot connect to Main DataBase');
				}
			}
			return $this->PDO;
		}
		else
		{
			if (!strcasecmp($option,"forum"))
			{
				if (!$this->PDO_FORUM)
				{
					try
					{
						$dns = 'mysql:host='.$this->getConfig('WEBHost').';dbname='.$this->getConfig('WEBBase').';charset=utf8';
						$this->PDO_FORUM = new PDO($dns, $this->getConfig('WEBUser'), $this->getConfig('WEBPswd'));
					} catch (PDOException $e) 
					{
						die('cannot connect to Forum DataBase');
					}
				}
				return $this->PDO_FORUM;
			}
		}
	}

	/**
	 * Cierra conxiones existentes a la base de datos
	 * al dejar la página
	 * @private
	 **/
	public function __destruct() 
	{
		if ($this->PDO)
			$this->EndSQL();
		if ($this->PDO_FORUM)
			$this->EndSQL("Forum");
	}

	/**
	 * [ISAAC] Nanosoft (c) 31/03/2017
	 * Ejecuta de manera rápida y segura una consulta con un conjunto de parámetros;
	 * En donde ya no hay que preocuparse de los injects a su vez esta función genera
	 * lo que Query y MRES hacían en Oboro 3.0 y posterior.
	 * $args = array();
	 * 	- Para enviar parametros a una consulta se utiliza así:
	 *  	$param = [<parametro1>,<parametro2>,<parametro3>,...]
	 *    
	 *    [VAR_DUMP Vars]
	 *    	- $DB->stmt:
	 *     		->affected_rows: INSERT UPDATE DELETE Row(s)
	 *       
	 *      - $DB->result(boolean):
	 *      	will return TRUE if a INSERT/UPDATE/DELETE is without errors in $consult
	 *       	will return FALSE if a INSERT/UPDATE/DELETE have some errors in $consult
	 *     $result:
	 *     		->num_rows: the correct way to know if a SELECT has data(rows);
	 *     	
	 **/
	public function execute($consult, $args = array(), $option = "Main")
	{
		if ($this->stmt = $this->getConnection($option)->prepare($consult))
		{  
			$this->stmt->setFetchMode(PDO::FETCH_ASSOC);
			$this->stmt->execute($args);
			
			return $this->stmt;
		}
		else
			return FALSE;
	}

	/**
	 * Destructor de Conexiones abiertas a la DB
	 */
	public function EndSQL($option = "Main")
	{
		if ($option == "Main")
			$this->PDO = null;
		else if ($option == "Forum")
			$this->PDO_FORUM = null;
		return;
	}
	
	public function free()
	{
		$this->stmt->closeCursor();
		return;
	}

	public function num_rows($option = "Main")
	{
		$result = $this->execute("SELECT FOUND_ROWS()", [], $option);
		return (!empty($result) ? $result->fetchColumn() : FALSE);
	}
	
	public function ShowColumns($table, $option = "Main") 
	{
		$result = $this->execute("SHOW COLUMNS FROM `".$table."`", [], $option);
		$storeArray = Array();
		while ($row = $result->fetch(PDO::FETCH_NUM)) 
			$storeArray[] =  $row[0];
		$this->free($result);
		return $storeArray;
	}

}
?>