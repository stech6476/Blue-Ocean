<?php
namespace Framework;

class DatabaseTable                               //Instantiate a table from database using PDO library
{
	private $pdo;
	private $table;
	private $primaryKey;
	private $className;
	private $constructorArgs;
	
	
	public function __construct(\PDO $pdo, string $table,
	string $primaryKey, string $className = '\stdClass', array $constructorArgs = []) 
	{
		$this->pdo = $pdo;                                                     //Pass connection
		$this->table = $table;                                                 //Get what the table name is
		$this->primaryKey = $primaryKey;                                       //Get the primary key
		$this->className = $className;                              //Get any Entity class name if none its empty STD class
		$this->constructorArgs = $constructorArgs;                  //Get an array of arguments for entity class, if none its empty
	}
	
	private function query($sql, $parameters = []) {               //Main function, 
		$query = $this->pdo->prepare($sql);                        //First prepare SQL statement 
		 
		
		$query->execute($parameters);                              //Then execute SQL statement
	return $query; 
	}

	
	private function filter(&$value) {                             //Protect against SQL injection, used whenever a fetch to a databae is done
		
	$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');                    
	
	}
	
	public function getRecordsBetweenDates($column, $start, $end, $userid)
	{
	    $query = 'SELECT * FROM  `' . $this->table .'` WHERE `' . $column . '` >= :start AND `' . $column . '` <= :end AND userid = :userid';
	    	
	    $parameters = [
		'start' => $start,
		'end' => $end,
		'userid' => $userid
		];
		
		
		$result = $this->query($query, $parameters);
		
		
		array_walk_recursive($result, array($this, 'filter'));
		
		return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
	    		
	    		
	}

	public function total($field = null, $value = null) {                  //Find total entries in table   
	 
	$sql = 'SELECT COUNT(*) FROM `' . $this->table . '`';
	
	$parameters = [];
	
	if(!empty($field)){
		$sql .= ' WHERE `' . $field . '` = :value';
		$parameters = ['value' => $value];
	}
	
	$query = $this->query($sql, $parameters);
	
	$row = $query->fetch();
	
	return $row[0];
	
	}
	
	public function findById($value){                                //Find entry by ID
	 
	$query = 'SELECT * FROM `' . $this->table . '`
	WHERE `' . $this->primaryKey . '` = :value';
	
	$parameters = [                                          //Prepare value instead of directly inserting
		'value' => $value
	];
	$query = $this->query($query, $parameters);
		array_walk_recursive($query, array($this, 'filter'));
		
	
		return $query->fetchObject($this->className, $this->constructorArgs);     //What will be returned was usually a string, but the fetchObject function can return it as a class if there is an Entity class which there is in UsersTable, for PayRoll its an empty class, but the entry will still be there
		
			
		
	}
	
	
	public function viewDate($date) {                            //Helper time date function 
	
	$date  = new \DateTime(htmlspecialchars($date, ENT_QUOTES, 'UTF-8'), new \DateTimeZone('UTC') ); //Without backslash class name, PHP looks for class in current namespace which is Framework. Use backslash to reference global namespace
				$date->setTimezone(new \DateTimeZone('America/New_York'));
				$date = $date->format('jS F Y g:i A');   
				
				return $date;
	}             
	
	
	private function insert($fields) {                                 //Insert an array of $fields into a Table
		
		$query = ' INSERT INTO `' . $this->table . '` (';
		
		foreach($fields as $key => $value) {
			$query .= '`' . $key . '`,';
		}
		
		$query = rtrim($query, ',');
		
		$query .= ') VALUES (';
		
		foreach($fields as $key => $value) {
			$query .= ':' . $key . ',';
		}
		
		$query = rtrim($query, ',');
		
		$query .= ')';
		
		$fields = $this->processDates($fields);
		
		$this->query($query, $fields);
		
		return $this->pdo->lastInsertId();
	}
	
	private function update($fields)                              //Update a table with a $field array
	{
		$query = 'UPDATE `' . $this->table .'` SET ';
		
		foreach($fields as $key => $value) {
			$query .= '`' . $key . '` = :' . $key . ',';
		}
		
		$query = rtrim($query, ',');
		
		$query .= ' WHERE `' . $this->primaryKey . '` = 
			:primaryKey';
			
		$fields['primaryKey'] = $fields['id'];
		
		$fields = $this->processDates($fields);
		
		$this->query($query, $fields);
		
		
	}
	
	
	public function delete($id)                         //Delete an entry from a table with a specified $id
	{
		
		$parameters = [':id' => $id];
		
		$this->query('DELETE FROM  `' . $this->table .'` WHERE 
		`' . $this->primaryKey . '` = :id', $parameters);
	}
	
	
	public function deleteWhere($column, $value){                  //Specialized delete function
		
		
		$query = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' = :value';
		
		$parameters = [
		'value' => $value
		];
		
		$query = $this->query($query, $parameters);
	}
	
	
	public function findAll($orderBy = null, $limit = null, $offset = null)    //Find all or within a limit
	{
		$query = 'SELECT * FROM ' . $this->table;
		
			if($orderBy != null) {
				$query .= ' ORDER BY ' . $orderBy;
			}
			
			if($limit != null) {
				$query .= ' LIMIT ' . $limit;
			}
			
			if($offset != null) {
				$query .= ' OFFSET ' . $offset;
			}
		
		$result = $this->query($query);
		
	
			
		array_walk_recursive($result, array($this, 'filter'));
		
		return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);  //Fetch it all and make it into classes
		
		
	}
	
public function find($column, $value, $limit = null, $offset = null) {           //Specialized find function
		$query = 'SELECT * FROM ' . $this->table . ' WHERE ' .
			$column . ' = :value';
			
			$parameters = [
				'value' => $value
			];
			
			
			if($limit != null) {
				$query .= ' LIMIT ' . $limit;
			}
			
			if($offset != null) {
				$query .= ' OFFSET ' . $offset;
			}
			
			
			$query = $this->query($query, $parameters);
				array_walk_recursive($query, array($this, 'filter'));
			
			return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
}
	
	private function processDates($fields)                     //Time date helper function
	{
		
		foreach($fields as $key=>$value) {
			if($value instanceof \DateTime) {
				$fields[$key] = $value->format('Y-m-d');
			}
		}
		
		return $fields;
	}
	
	
	public function save($record)                            //Important function to insert record database
	{
		
		$entity = new $this->className(...$this->constructorArgs);    //For entity classes
	//	var_dump($record);
		
		try {
		 
			if($record[$this->primaryKey] == ' ') {            //If the primary key is null, 
				$record[$this->primaryKey] = null;
			}
			$insertId = $this->insert($record);               //The entry will be inserted, because a null primary key in SQL triggers autoincrement
			
		//	echo "inside try";
		
			$entity->{$this->primaryKey} = $insertId;        //For entity classes    
		}
		catch(\PDOException $e) {                             //If the primary key was not null, insert as before, however, if the primary key is a duplicate and there is a duplicate in the database as well, the PDOException will be triggered causing it to be updated instead
		//	echo "inside catch";
		
	      
			$this->update($record);
			
		}                                   //This is an easy way to insert/update in the same function at the same time
		
		
		foreach($record as $key => $value){               //For entity classes
			if(!empty($value)) {
			$entity->$key = $value;
			}
			
		}
		
		return $entity;           
	}
}