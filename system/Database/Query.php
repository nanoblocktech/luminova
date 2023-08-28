<?php 
/**
 * This file is part of Luminova framework.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Luminova\DatabaseManager;
use \Luminova\Exceptions\DatabaseException;

class Query extends Conn {  
    /**
    *Class instance
    *@var object $instance 
    */
    private static $instance = null;

    /**
    *Table name to query
    *@var string $databaseTable 
    */
    protected $databaseTable;

    /**
    *Table query order limit offset and count query 
    *@var string $queryLimit 
    */
    private $queryLimit = "";

    /**
    *Table query order rows 
    *@var string $queryOrder 
    */
    private $queryOrder = "";

    /**
    *Table query group column by
    *@var string $queryGroup 
    */
    private $queryGroup = "";

    /**
    *Table query where column
    *@var string $queryWhere 
    */
    private $queryWhere = "";

    /**
    * Table query where column value
    *@var string $queryWhereValue 
    */
    private $queryWhereValue = "";

    /**
    *Table query and query column
    *@var string $queryWhereAnd 
    */
    private $queryWhereAnd = "";

    /**
    *Table query and value
    *@var string $queryWhereValueAnd 
    */
    private $queryWhereValueAnd = "";

    /*
        Class Constructor
    */
	public function __construct(){
		parent::__construct();
	}

    /**
    * Class Singleton
    * @return object $instance
    */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Sets table name
     *
     * @param string $table The table name
     * @return Query $this Class instance.
     */
    public function table(string $table){
        $this->databaseTable = $table;
        return $this;
    }

    /**
     * Set query limit
     * @param int $offset start offset query limit
     * @param string $count limit threshold
     * @return Query class instance.
     */
    public function limit(int $offset = 0, int $count = 50){
        //$limit = ($count - $offset + 1);
        //$this->queryLimit = " LIMIT {$offset}, {$limit}";
        $this->queryLimit = " LIMIT {$offset},{$count}";
        return $this;
    }

    /**
     * Set query order
     * @param string $order uid ASC, name DESC
     * @return Query class instance.
     */
    public function order(string $order){
        $this->queryOrder = " ORDER BY {$order}";
        return $this;
    }

    /**
     * Set query grouping
     * @param string $group group by column name
     * @return Query class instance.
     */
    public function group(string $group){
        $this->queryGroup = " GROUP BY {$group}";
        return $this;
    }

    /**
     * Set query where
     * @param string $column column name
     * @param string $key column key value
     * @return Query class instance.
     */
    public function where(string $column, $key){
        $this->queryWhereValue = $key;
        $this->queryWhere = " WHERE {$column} = :where_column";
        return $this;
    }

    /**
     * Set query where and
     * @param string $column column name
     * @param string $key column key value
     * @return Query class instance.
     */
    public function and(string $column, $key){
        $this->queryWhereAndValue = $key;
        $this->queryWhereAnd = " AND {$column} = :and_column";
        return $this;
    }

    /**
     * Insert into table
     * @param array $values array of values to insert into table
     * @param bool $bind Use bind values and prepare statement instead of query
     * @return init returns affected row counts.
     */
    public function insert(array $values, bool $bind = true) {
        if (empty($values)) {
            return 0;
        }

        if(!is_array( $values )){
            return 0;
        }

        if (!is_array($values[0] ?? null)) {
            $values = [$values];
        }
    
        $columns = array_keys($values[0]);
        try {
            if($bind){
                return $this->executePrepared($columns, $values);
            }
            return $this->executeInsertQuery($columns, $values);
        } catch (DatabaseException $e) {
            print($e->getMessage());
        }
        return 0;
    }

    /**
     * Select from table,
     * @param array $rows select columns
     * @return object|null returns selected rows.
     */
    public function select(array $columns = ["*"]) {
        try {
            $columns = implode(", ", $columns);
            $selectQuery = "SELECT {$columns} FROM {$this->databaseTable}";
            if (!empty($this->queryWhere)) {
                if (empty($this->queryWhereValue)) {
                    return null;
                }
                $selectQuery .= $this->queryWhere;
                if(!empty($this->queryWhereAnd)){
                    $selectQuery .= $this->queryWhereAnd;
                }
                $selectQuery .= $this->queryGroup;
                $selectQuery .= $this->queryOrder;
                $selectQuery .= $this->queryLimit;
                $this->db->prepare($selectQuery);
                $this->db->bind(":where_column", $this->queryWhereValue);
                if(!empty($this->queryWhereAndValue)){
                    $this->db->bind(":and_column", $this->queryWhereAndValue);
                }
            }else{
                $selectQuery .= $this->queryGroup;
                $selectQuery .= $this->queryOrder;
                $selectQuery .= $this->queryLimit;
                $this->db->prepare($selectQuery);
            }
            $this->db->execute();
            return $this->db->getAll();
        } catch (DatabaseException $e) {
            print($e->getMessage());
        }
        return null;
    }

    /**
     * Select on record from table,
     * @param array $rows select columns
     * @return object|null returns selected row.
     */
    public function find(array $columns = ["*"]) {
        try {
            $columns = implode(", ", $columns);
            $selectQuery = "SELECT {$columns} FROM {$this->databaseTable}";
            if (!empty($this->queryWhere)) {
                if (empty($this->queryWhereValue)) {
                    return null;
                }
                $selectQuery .= $this->queryWhere;
                if(!empty($this->queryWhereAnd)){
                    $selectQuery .= $this->queryWhereAnd;
                }
                $selectQuery .= " LIMIT 1";
                $this->db->prepare($selectQuery);
                $this->db->bind(":where_column", $this->queryWhereValue);
                if(!empty($this->queryWhereAndValue)){
                    $this->db->bind(":and_column", $this->queryWhereAndValue);
                }
                $this->db->execute();
                return $this->db->getOne();
            }
        } catch (DatabaseException $e) {
            print($e->getMessage());
        }
        return null;
    }

    /**
     * Update table with columns and values
     * @param array $columns associative array of columns and values to update
     * @return int returns affected row counts.
     */
    public function update(array $columns) {
        try {
            if (empty($columns)) {
                return 0;
            }
            $updateColumns = array_map(function ($column) {
                return "$column = :$column";
            }, array_keys($columns));
    
            $updateQuery = "UPDATE {$this->databaseTable} SET " . implode(", ", $updateColumns);
            if (!empty($this->queryWhere)) {
                if (empty($this->queryWhereValue)) {
                    return 0;
                }
                $updateQuery .= $this->queryWhere;
                if(!empty($this->queryWhereAnd)){
                    $updateQuery .= $this->queryWhereAnd;
                }
    
                $this->db->prepare($updateQuery);
                foreach ($columns as $key => $value) {
                    $this->db->bind(":$key", $value);
                }
                $this->db->bind(":where_column", $this->queryWhereValue);
                if(!empty($this->queryWhereAndValue)){
                    $this->db->bind(":and_column", $this->queryWhereAndValue);
                }
                $this->db->execute();
                return $this->db->rowCount();
            }
        } catch (DatabaseException $e) {
            print($e->getMessage());
        }
        return 0;
    }    

    /**
     * Delete from table, leaving parameters unset will result query deleting all records from table
     * And alter table auto increment to 1
     * @param int $limit row limit
     * @return init returns affected row counts.
     */
    public function delete(int $limit = 1) {
        try {
            $rowCount = 0;
            $deleteQuery = "DELETE FROM {$this->databaseTable}";
            if (!empty($this->queryWhere)) {
                if (empty($this->queryWhereValue)) {
                    return 0;
                }
                $deleteQuery .= $this->queryWhere;
                if(!empty($this->queryWhereAnd)){
                    $deleteQuery .= $this->queryWhereAnd;
                }
                $deleteQuery .= " LIMIT {$limit}";
                $this->db->prepare($deleteQuery);
                $this->db->bind(":where_column", $this->queryWhereValue);
                if(!empty($this->queryWhereAndValue)){
                    $this->db->bind(":and_column", $this->queryWhereAndValue);
                }
                $this->db->execute();
                $rowCount = $this->rowCount();
            }else{
                if($this->db->exec($deleteQuery)){
                    $rowCount = $this->db->exec("ALTER TABLE {$this->databaseTable} AUTO_INCREMENT = 1");
                }
            }
            return $rowCount;
        } catch (DatabaseException $e) {
            print($e->getMessage());
        }
        return 0;
    }

    /**
     * Drop table from database
     * @return init returns affected row counts.
     */
    public function drop() {
        try {
            return $this->db->exec("DROP TABLE IF EXISTS {$this->databaseTable}");
        } catch (DatabaseException $e) {
            print($e->getMessage());
        }
        return 0;
    }

    /**
     * Create a new table if it doesn't exist
     * @param array $columns table columns and options
     * @return init returns affected row counts.
     */
    public function createTable(array $columns) {
        try {
            return $this->db->exec("CREATE TABLE IF NOT EXISTS {$this->databaseTable} ($columns)");
        } catch (DatabaseException $e) {
            print($e->getMessage());
        }
        return 0;
    }

    /**
     * Get table column instance 
     * @param Columns $column table column instance
     * @return int affected row count
     */
    public function create(Columns $column) {
        try {
            $query = $column->generate();
            if(empty($query)){
                return 0;
            }
            return $this->exec($query);
        } catch (DatabaseException $e) {
            print($e->getMessage());
        }
        return 0;
    }

    /**
     * Get table column instance 
     * @return Columns column class instance
     */
    public function withColumns() : Columns{
        return new Columns($this->databaseTable);
    }

    /**
     * Execute insert query
     * @param array $columns column name to target insert
     * @param array $values array of values to insert
     * @return init returns affected row counts.
     */
    private function executeInsertQuery(array $columns, array $values){
        $insertQuery = [];
    
        foreach ($values as $row) {
            $quotedValues = array_map(function ($value) {
                return is_string($value) ? "'$value'" : $value;
            }, $row);
    
            $insertQuery[] = "(" . implode(", ", $quotedValues) . ")";
        }
    
        $insertQuery = "INSERT INTO {$this->databaseTable} (" . implode(", ", $columns) . ")
        VALUES " . implode(", ", $insertQuery);
    
        $this->db->query($insertQuery);
        return $this->db->rowCount();
    }

    /**
     * Execute insert query using prepared statement
     * @param array $columns column name to target insert
     * @param array $values array of values to insert
     * @return init returns affected row counts.
     */
    private function executePrepared(array $columns, array $values) {
  
        $placeholders = implode(', ', array_map(function ($col) {
            return ":$col";
        }, $columns));
    
        $insertQuery = "
            INSERT INTO {$this->databaseTable} (" . implode(", ", $columns) . ")
            VALUES ($placeholders)
        ";
    
        $this->prepare($insertQuery);
    
        foreach ($values as $row) {
            foreach ($row as $key => $value) {
                $this->db->bind(":$key", $value);
            }
            $this->db->execute();
        }
    
        return $this->db->rowCount();
    } 
}