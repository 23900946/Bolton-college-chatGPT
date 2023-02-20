<?php

/**
 * A class to stand-alone or plug-in integrate in to a project with a simple include and instantiation in your class/file. (new SQL).
 * Provides, CRUD (CREATE, READ, UPDATE & DELETE) operations on any database table declared on instantiation.
 * PARAMS are passed in as an array to the SQL query.
 * Example update/select/delete: $instance = $test->update('UPDATE <table> SET name=? WHERE id=?', ['Dean Baggaley',2]);
 * SQL injections are automatically pevented with the PDO driver and placeholders.
 */
class SQL
{
	/**
	 * Connect to the database and return the connection instance.
	 */
	public function __construct()
	{
		// Connection to the database and use try/catch to catch any issues.
		try
		{
			// Handle any PDO errors here.
			$opt = array(
		    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);

			$this->conn = new PDO('mysql:host=10.3.112.172;dbname=data;charset=utf8mb4','mike','r3v3rbj0y',$opt);
		}
		// Catch some PDO errors.
		catch (PDOException $e)
		{
			throw new Exception('PDO Database connection failed to connect to SID database failed in line: ' . __LINE__ . ' of the file: '. __FILE__ .' with the message: '. $e->getMessage());
		}

		// Return the database connection and instance.
		return $this->conn;
	}

	/**
	 * SELECT query made here. Either call can be made, a select * or with PARAMS array passed.
	 * @param  [string] $query [Just the query string]
	 * @param  [array] $array [array or params]
	 * @return [array] [Result set is returned as an array]
	 */
	public function select($query, $array=NULL)
	{
		try
		{
			// No params.
			if(!isset($array))
			{
				$result = $this->conn->query($query);
				return ($result->rowCount()<=0) ? FALSE : $result->fetchAll(PDO::FETCH_ASSOC);
			}
			// Params passed in.
			else
			{
				// Prepare the query.
				$stm = $this->conn->prepare($query);
	        	// If the query fails to execute.
				if(!$stm->execute($array)) throw new Exception('Select query failed to execute at line: ' .__LINE__.' in file: '. __FILE__ );

				// Return the result set or false on failure.
				return ($stm->rowCount()<=0) ? FALSE : $stm->fetchAll(PDO::FETCH_ASSOC);
			}

		}

		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	public function truncate($query)
	{
		try
		{
			// Prepare the query.
			$stm = $this->conn->prepare($query);
			return true;
		}

		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	/**
	 * Update query made here. PARAMS array passed.
	 * @param  [string] $query [Just the query string]
	 * @param  [array] $array [array of params]
	 * @return [integer] [Returns an integer of the affected rows]
	 */
	public function update($query,$array)
	{
		try
		{
			// Prepare the query.
			$stm = $this->conn->prepare($query);

      		// If the query fails to execute.
			if(!$stm->execute($array)) throw new Exception('Update query failed to execute at line: ' .__LINE__.' in file: '. __FILE__ );

      		// Return the affected row count or false on failure.
			return ($stm->rowCount()<=0) ? FALSE : $stm->rowCount();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	/**
	 * Delete query made here. PARAMS array passed.
	 * @param  [string] $query [Just the query string]
	 * @param  [array] $array [array of params]
	 * @return [integer] [Returns an integer of the affected rows]
	 */
	public function delete($query,$array=null)
	{
		try
		{
			// No params.
			if(!isset($array))
			{
				$result = $this->conn->query($query);
				return ($result->rowCount()<=0) ? FALSE : $result->rowCount();
			}

        	// Params passed in.
			else
			{
				// Prepare the query.
				$stm = $this->conn->prepare($query);
				// If the query fails to execute.
				if(!$stm->execute($array)) throw new Exception('Delete query failed to execute at line: ' .__LINE__.' in file: '. __FILE__ );
        		// Returns the number of affected rows.
				return ($stm->rowCount()<=0) ? FALSE : $stm->rowCount();
			}
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	/**
	 * Insert query made here. PARAMS array passed.
	 * @param  [string] $query [Just the query string]
	 * @param  [array] $array [array of params]
	 * @return [integer] [Returns an integer of the last insert id for the row]
	 */
	public function insert($query, $array)
	{
		try
		{
			// Prepare the query.
			$stm = $this->conn->prepare($query);
      		// If the query fails to execute.
			if(!$stm->execute($array)) throw new Exception('Select query failed to execute at line: ' .__LINE__.' in file: '. __FILE__ );

      		// Return the last insert id of the row or FALSE on failure.
			return ($stm->rowCount()<=0) ? FALSE : $this->conn->lastInsertId();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	/**
	 * Close the class and end the DB connection.
	 */
	public function __destruct()
	{
		$this->conn = null;
	}

}
