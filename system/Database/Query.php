<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Database;
use Luminova\Exceptions\DatabaseException;
use \Luminova\Cache\FileSystemCache;
use \Luminova\Config\Configuration;
use \Luminova\Arrays\ArrayCountable;

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
    *Table name to join query
    *@var string $databaseJoinTable 
    */
    protected $databaseJoinTable;

    /**
    *Table join query type
    *@var string $databaseJoinType 
    */
    protected $databaseJoinType;

    /**
    *Table join bind parameters
    *@var array $databaseJoinSeed 
    */
    protected array $databaseJoinSeed = [];

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
    *@var array $queryWhereConditions 
    */
    private $queryWhereConditions = [];

    /**
    *Table query update set values
    *@var array $querySetValues 
    */
    private $querySetValues = [];

    /**
    *Cache flag u
    *@var string $hasCache 
    */
    private $hasCache = "NO_CACHE";

    /**
    *Cache class instance
    *@var FileSystemCache $cache 
    */
    private $cache = null;

    /**
    *Cache key
    *@var string $cacheKey 
    */
    private $cacheKey = "default";

    /**
    *Cache enable flag
    *@var bool $useCacheStorage 
    */
    private $useCacheStorage = false;


    /*
        Class Constructor
    */
	public function __construct(){
		parent::__construct();
         $this->cache = FileSystemCache::getInstance();
         $this->cache->setEnableCache(false);
	}

     /*
        Class cloning
    */
    private function __clone() {
        $this->resetDefaults();
    }
    
    /*
        Prevent unserialization of the singleton instance
    */
    public function __wakeup() {
        
    }

    /**
    * Class Singleton
    * @return Query object $instance
    */
    public static function getInstance(): Query 
    {
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
    public function table(string $table): Query
    {
        $this->databaseTable = $table;
        return $this;
    }

     /**
     * Sets join table name and method
     * @param string $table The table name
     * @param string $type The join type
     * @return Query $this Class instance.
     */
    public function join(string $table, string $type = "INNER"): Query
    {
        $this->databaseJoinType = $type;
        $this->databaseJoinTable = $table;
        return $this;
    }

    /**
     * Sets join table on clause
     * @param array $seeds Join seed
     * @return Query $this Class instance.
     */
    public function on(array $seeds): Query
    {
        $this->databaseJoinSeed = $seeds;
        return $this;
    }

    /**
     * Sets join table inner
     * @param string $table The table name
     * @return Query $this Class instance.
     */
    public function innerJoin(string $table): Query
    {
        $this->join($table, "INNER");
        return $this;
    }


    /**
     * Sets join table left
     * @param string $table The table name
     * @return Query $this Class instance.
     */
    public function leftJoin(string $table): Query
    {
        $this->join($table, "LEFT");
        return $this;
    }

    /**
     * Set query limit
     * @param int $offset start offset query limit
     * @param int $count limit threshold
     * @return Query class instance.
     */
    public function limit(int $offset = 0, int $count = 50): Query
    {
        $this->queryLimit = " LIMIT {$offset},{$count}";
        return $this;
    }

    /**
     * Set query order
     * @param string $order uid ASC, name DESC
     * @return Query class instance.
     */
    public function order(string $order): Query 
    {
        $this->queryOrder = " ORDER BY {$order}";
        return $this;
    }

    /**
     * Set query grouping
     * @param string $group group by column name
     * @return Query class instance.
     */
    public function group(string $group): Query 
    {
        $this->queryGroup = " GROUP BY {$group}";
        return $this;
    }

    /**
     * Set query where
     * @param string $column column name
     * @param string $key column key value
     * @return Query class instance.
     */
    public function where(string $column, string $key): Query
    {
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
    public function and(string $column, string $key): Query
    {
        $this->queryWhereConditions[] = ["type" => "AND", "column" => $column, "key" => $key];
        return $this;
    }

    /**
     * Set update columns and values
     * @param string $column column name
     * @param string|int $key column key value
     * @return Query class instance.
     */
    public function set(string $column, mixed $value): Query
    {
        $this->querySetValues[] = [ "column" => $column, "value" => $value];
        return $this;
    }

    /**
     * Set query where or | and or
     * @param string $column column name
     * @param string $key column key value
     * @return Query class instance.
     */
    public function or(string $column, string $key): Query
    {
        $this->queryWhereConditions[] = ["type" => "OR", "column" => $column, "key" => $key];
        return $this;
    }
    
     /**
     * Set query AND (? OR ?)
     * @param string $column column name
     * @param string $key column key value
     * @param string $columnOr column name
     * @param string $keyOr column key value
     * @return Query class instance.
     */
    public function andOr(string $column, string $key, string $columnOr, string $keyOr): Query
    {
        $this->queryWhereConditions[] = [
            "type" => "AND_OR", 
            "column" => $column, 
            "key" => $key,
            "columnOr" => $columnOr, 
            "keyOr" => $keyOr
        ];
        return $this;
    }

    /**
     * Convert an object to an array.
     *
     * @param mixed $input The object to convert to an array.
     * @return mixed The resulting array representation of the object.
     * @return array Finalized array representation of the object
     */

    public function toArray(mixed $input = null): array {
        if ($input === null) {
            return [];
        }
    
        if (is_object($input) || is_array($input)) {
            $array = [];
            foreach ($input as $key => $value) {
                if (is_object($value) || is_array($value)) {
                    $array[$key] = $this->toArray($value);
                }else{
                    $array[$key] = $value;
                }
            }
            return $array;
        }

        return [$input];
    }


    /**
     * Set query where IN () expression
     * @param string $column column name
     * @param array $list of values
     * @return Query class instance.
     */
    public function in(string $column, array $list): Query
    {
        if (!empty($list)) {
            $values = implode(', ', array_map(function($item) {
                return is_string($item) ? "'$item'" : $item;
            }, $list));

            $this->queryWhereConditions[] = ["type" => "IN", "column" => $column, "values" => $values];
        }

        return $this;
    }

     /**
     * Set query where FIND_IN_SET () expression
     * @param string $search search value
     * @param array $list of values
     * @param string $method allow specifying the method for matching (e.g., > or =)
     * @return Query class instance.
     */
    public function inset(string $search, array $list, string $method = '='): Query
    {
        $values = implode(',', $list);
        $this->queryWhereConditions[] = ["type" => "IN_SET", "list" => $values, "search" => $search, "method" => $method];
        return $this;
    }

     /**
     * Get the storage location and configuration.
     * @return string path
     */
    private function getFilepath(): string {
        return  Configuration::getRootDirectory(__DIR__) . DIRECTORY_SEPARATOR . "writeable" . DIRECTORY_SEPARATOR . "caches" . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR;
     }
 
     

    /**
     * Cache the query result using a specified storage.
     *
     * @param string $storage The name of the cache storage.
     * @param string $key The cache key (optional).
     * @param string $filename Private storage filename hash name (optional).
     * @param int $expiry The cache expiry time in seconds (default: 7 days).
     * @return $this  Query class instance.
     */
    public function cache(string $key, string $filename = 'database', int $expiry = 7 * 24 * 60 * 60): Query
    {
        $this->cache->setEnableCache(true);
        $this->cache->setExpire($expiry);
        $this->cache->setFilename($filename);
        $this->cache->setCacheLocation(self::getFilepath());
        $this->cache->create();
        $this->useCacheStorage = true;
        $this->cacheKey = md5($key);

        // Check if the cache exists and handle expiration
        if ($this->cache->hasCached($this->cacheKey)) {
            $this->hasCache = "HAS_CACHE";
            if ($this->cache->hasExpired($this->cacheKey)) {
                $this->cache->remove($this->cacheKey);
                $this->hasCache = "NO_CACHE";
            }
        }

        return $this;
    }

    /**
     * Insert into table
     * @param array $values array of values to insert into table
     * @param bool $bind Use bind values and prepare statement instead of query
     * @return int returns affected row counts.
     */
    public function insert(array $values, bool $bind = true): int 
    {
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
                return $this->executeInsertPrepared($columns, $values);
            }
            return $this->executeInsertQuery($columns, $values);
        } catch (DatabaseException $e) {
            $e->handle(parent::isProduction());
        }
        return 0;
    }

    /**
     * Select from table,
     * @param array $rows select columns
     * @return object|null returns selected rows.
     */
    public function select(array $columns = ["*"]): mixed 
    {
        if($this->useCacheStorage && $this->hasCache == "HAS_CACHE"){
            $this->resetDefaults();
            $response = $this->cache->retrieveCache($this->cacheKey);
            $this->cacheKey = '';
            return $response;
        }else{
            $columns = implode(", ", $columns);
            $selectQuery = "SELECT {$columns} FROM {$this->databaseTable}";
            if (!empty($this->databaseJoinTable)) {
                $selectQuery .= " {$this->databaseJoinType} JOIN {$this->databaseJoinTable}";
                if (!empty($this->databaseJoinSeed)) {
                    $selectQuery .= " ON {$this->databaseJoinSeed[0]}";
                    if(count($this->databaseJoinSeed) > 1){
                        for ($i = 1; $i < count($this->databaseJoinSeed); $i++) {
                            $selectQuery .= " AND {$this->databaseJoinSeed[$i]}";
                        }
                    }
                } 
            }

            try {
                return $this->cache->onExpired($this->cacheKey, function() use($selectQuery) {
                    $isBided = false;
                    if (empty($this->queryWhere) || empty($this->queryWhereValue)) {
                        $this->buildSearchConditions($selectQuery);
                    }else{
                        $isBided = true;
                        $selectQuery .= $this->queryWhere;
                        $this->buildWhereConditions($selectQuery);
                    }
                    $selectQuery .= $this->queryGroup;
                    $selectQuery .= $this->queryOrder;
                    $selectQuery .= $this->queryLimit;
                    if($isBided){
                        $this->db->prepare($selectQuery);
                        $this->db->bind(":where_column", $this->queryWhereValue);
                        if (!empty($this->queryWhereConditions)) {
                            foreach ($this->queryWhereConditions as $bindings) {
                                if (in_array($bindings['type'], ["AND", "OR"])) {
                                    $this->db->bind(":{$bindings['column']}", $bindings['key']);
                                } elseif ($bindings['type'] === "AND_OR") {
                                    $this->db->bind(":{$bindings['column']}", $bindings['key']);
                                    $this->db->bind(":{$bindings['columnOr']}", $bindings['keyOr']);
                                }
                            }
                        }
                        $this->db->execute();
                    }else{
                        $this->db->query($selectQuery);
                    }
                    $return = $this->db->getAll();
                    $this->resetDefaults();
                    return $return;
                });
            } catch (DatabaseException $e) {
                $e->handle(parent::isProduction());
            }
        }
        return null;
    }

    /**
     * Select on record from table,
     * @param array $rows select columns
     * @return object|null returns selected row.
     */
    public function find(array $columns = ["*"]): mixed 
    {
        if (empty($this->queryWhere) || empty($this->queryWhereValue)) {
            throw new DatabaseException("Find operation without a WHERE condition is not allowed.");
        }else{
            if($this->useCacheStorage && $this->hasCache == "HAS_CACHE"){
                $this->resetDefaults();
                $response = $this->cache->retrieveCache($this->cacheKey);
                $this->cacheKey = '';
                return $response;
            }else{
                $columns = implode(", ", $columns);
                $selectQuery = "SELECT {$columns} FROM {$this->databaseTable}";
                if (!empty($this->databaseJoinTable)) {
                    $selectQuery .= " {$this->databaseJoinType} JOIN {$this->databaseJoinTable}";
                    if (!empty($this->databaseJoinSeed)) {
                        $selectQuery .= " ON {$this->databaseJoinSeed[0]}";
                        //$countable = new ArrayCountable($this->databaseJoinSeed);
                        if(count($this->databaseJoinSeed) > 1){
                            for ($i = 1; $i < count($this->databaseJoinSeed); $i++) {
                                $selectQuery .= " AND {$this->databaseJoinSeed[$i]}";
                            }
                        }
                    } 
                }
               
                try {
                    return $this->cache->onExpired($this->cacheKey, function() use($selectQuery) {
                        $selectQuery .= $this->queryWhere;
                        $this->buildWhereConditions($selectQuery);
                        $selectQuery .= " LIMIT 1";
                        $this->db->prepare($selectQuery);
                        $this->db->bind(":where_column", $this->queryWhereValue);
                        if (!empty($this->queryWhereConditions)) {
                            foreach ($this->queryWhereConditions as $bindings) {
                                if (in_array($bindings['type'], ["AND", "OR"])) {
                                    $this->db->bind(":{$bindings['column']}", $bindings['key']);
                                } elseif ($bindings['type'] === "AND_OR") {
                                    $this->db->bind(":{$bindings['column']}", $bindings['key']);
                                    $this->db->bind(":{$bindings['columnOr']}", $bindings['keyOr']);
                                }
                            }
                        }
                        $this->db->execute();
                        $return = $this->db->getOne();
                        $this->resetDefaults();
                        return $return;
                    });
                } catch (DatabaseException $e) {
                    $e->handle(parent::isProduction());
                }
            }
        }
        return null;
    }


     /**
     * Select on record from table,
     * @param array $rows select columns
     * @return int returns selected row.
     */
    public function total(string $column = "*"): int 
    {
        if($this->useCacheStorage && $this->hasCache == "HAS_CACHE"){
            $this->resetDefaults();
            $response = $this->cache->retrieveCache($this->cacheKey);
            $this->cacheKey = '';
            return $response;
        }else{
            $selectQuery = "SELECT COUNT({$column}) FROM {$this->databaseTable}";
            if (!empty($this->databaseJoinTable)) {
                $selectQuery .= " {$this->databaseJoinType} JOIN {$this->databaseJoinTable}";
                if (!empty($this->databaseJoinSeed)) {
                    $selectQuery .= " ON {$this->databaseJoinSeed[0]}";
                    if(count($this->databaseJoinSeed) > 1){
                        for ($i = 1; $i < count($this->databaseJoinSeed); $i++) {
                            $selectQuery .= " AND {$this->databaseJoinSeed[$i]}";
                        }
                    }
                } 
            }
        
            try {
                return $this->cache->onExpired($this->cacheKey, function() use($selectQuery) {
                    if (empty($this->queryWhere) || empty($this->queryWhereValue)) {
                        $this->db->query($selectQuery);
                    }else{
                        $selectQuery .= $this->queryWhere;
                        $this->buildWhereConditions($selectQuery);
                        $this->db->prepare($selectQuery);
                        $this->db->bind(":where_column", $this->queryWhereValue);
                        if (!empty($this->queryWhereConditions)) {
                            foreach ($this->queryWhereConditions as $bindings) {
                                if (in_array($bindings['type'], ["AND", "OR"])) {
                                    $this->db->bind(":{$bindings['column']}", $bindings['key']);
                                } elseif ($bindings['type'] === "AND_OR") {
                                    $this->db->bind(":{$bindings['column']}", $bindings['key']);
                                    $this->db->bind(":{$bindings['columnOr']}", $bindings['keyOr']);
                                }
                            }
                        }
                        $this->db->execute();
                    }
                    $total = $this->db->getInt();
                    $this->resetDefaults();
                    return $total;
                });
            } catch (DatabaseException $e) {
                $e->handle(parent::isProduction());
            }
        }
        return 0;
    }

    /**
     * Update table with columns and values
     * @param array $setValues associative array of columns and values to update
     * @return int returns affected row counts.
     */
    public function update(?array $setValues = null): int 
    {
        if (empty($setValues) && empty($this->querySetValues)) {
            self::error("Update operation without SET values is not allowed.");
        }
        if (empty($this->queryWhere) || empty($this->queryWhereValue)) {
            self::error("Update operation without a WHERE condition is not allowed.");
        }else{
            $columns = !empty($setValues) ? $setValues : $this->querySetValues;
            $updateColumns = array_map(function ($column) {
                return "$column = :$column";
            }, array_keys($columns));

    
            $updateQuery = "UPDATE {$this->databaseTable} SET " . implode(", ", $updateColumns);
            $updateQuery .= $this->queryWhere;
            $this->buildWhereConditions($updateQuery);
            try {
                $this->db->prepare($updateQuery);
                foreach ($columns as $key => $value) {
                    $this->db->bind(":$key", $value);
                }
                $this->db->bind(":where_column", $this->queryWhereValue);
                if (!empty($this->queryWhereConditions)) {
                    foreach ($this->queryWhereConditions as $bindings) {
                        if (in_array($bindings['type'], ["AND", "OR"])) {
                            $this->db->bind(":{$bindings['column']}", $bindings['key']);
                        } elseif ($bindings['type'] === "AND_OR") {
                            $this->db->bind(":{$bindings['column']}", $bindings['key']);
                            $this->db->bind(":{$bindings['columnOr']}", $bindings['keyOr']);
                        }
                    }
                }
                
                $this->db->execute();
                $return = $this->db->rowCount();
                $this->resetDefaults();
                return $return;
            } catch (DatabaseException $e) {
                $e->handle(parent::isProduction());
            }
        }
        return 0;
    }

    /**
     * Delete from table
     * @param int $limit row limit
     * @return int returns affected row counts.
     */

    public function delete(int $limit = 0): int
    {
         if (!empty($this->queryWhere) && !empty($this->queryWhereValue)) {
            $deleteQuery = "DELETE FROM {$this->databaseTable}";
            $deleteQuery .= $this->queryWhere;
            $this->buildWhereConditions($deleteQuery);

            if($limit > 0){
                $deleteQuery .= " LIMIT {$limit}";
            }

            try {
                $this->db->prepare($deleteQuery);
                $this->db->bind(":where_column", $this->queryWhereValue);
                if (!empty($this->queryWhereConditions)) {
                    foreach ($this->queryWhereConditions as $bindings) {
                        if (in_array($bindings['type'], ["AND", "OR"])) {
                            $this->db->bind(":{$bindings['column']}", $bindings['key']);
                        } elseif ($bindings['type'] === "AND_OR") {
                            $this->db->bind(":{$bindings['column']}", $bindings['key']);
                            $this->db->bind(":{$bindings['columnOr']}", $bindings['keyOr']);
                        }
                    }
                }
                $this->db->execute();
                $rowCount = $this->db->rowCount();
                $this->resetDefaults();
                return $rowCount;
            } catch (DatabaseException $e) {
                $e->handle(parent::isProduction());
            }
        } else {
            self::error("Delete operation without a WHERE condition is not allowed.");
        }
        return 0;
    }


     /**
     * Delete all records in a table 
     * And alter table auto increment to 1
     * @param bool $transaction row limit
     * @return bool returns true if completed
     */

    public function truncate(bool $transaction = true): bool {
        try {
            if ($transaction) {
                $this->db->beginTransaction();
            }
            $deleteSuccess = $this->db->exec("DELETE FROM {$this->databaseTable}");
            $resetSuccess = $this->db->exec("ALTER TABLE {$this->databaseTable} AUTO_INCREMENT = 1");

            if ($transaction) {
                if ($deleteSuccess && $resetSuccess) {
                    $this->db->commit();
                    return true;
                } else {
                    $this->db->rollback();
                    return false;
                }
            } else {
                return $deleteSuccess && $resetSuccess;
            }
        } catch (DatabaseException $e) {
            $e->handle(parent::isProduction());
        }
    }

    /**
     * Drop table from database
     * @return int returns affected row counts.
     */
    public function drop(): int 
    {
        try {
            $return = $this->db->exec("DROP TABLE IF EXISTS {$this->databaseTable}");
            $this->resetDefaults();
            return $return;
        } catch (DatabaseException $e) {
            $e->handle(parent::isProduction());
        }
        return 0;
    }

    /**
     * Create a new table if it doesn't exist
     * @param array $columns table columns and options
     * @return int returns affected row counts.
     */
    public function createTable(array $columns): int 
    {
        try {
            $return = $this->db->exec("CREATE TABLE IF NOT EXISTS {$this->databaseTable} ($columns)");
            $this->resetDefaults();
            return $return;
        } catch (DatabaseException $e) {
            $e->handle(parent::isProduction());
        }
        return 0;
    }

    /**
     * Get table column instance 
     * @param Columns $column table column instance
     * @return int affected row count
     */
    public function create(Columns $column): int 
    {
        try {
            $query = $column->generate();
            if(empty($query)){
                return 0;
            }
            return $this->db->exec($query);
        } catch (DatabaseException $e) {
            $e->handle(parent::isProduction());
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
     * @return int returns affected row counts.
     */
    private function executeInsertQuery(array $columns, array $values): int 
    {
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
        $return = $this->db->rowCount();
        $this->resetDefaults();
        return $return;
    }

    /**
     * Execute insert query using prepared statement
     * @param array $columns column name to target insert
     * @param array $values array of values to insert
     * @return int returns affected row counts.
     */
    private function executeInsertPrepared(array $columns, array $values): int 
    {
  
        $placeholders = implode(', ', array_map(function ($col) {
            return ":$col";
        }, $columns));
    
        $insertQuery = "INSERT INTO {$this->databaseTable} (" . implode(", ", $columns) . ")
            VALUES ($placeholders)";
    
        $this->db->prepare($insertQuery);
    
        foreach ($values as $row) {
            foreach ($row as $key => $value) {
                $this->db->bind(":$key", $value);
            }
            $this->db->execute();
        }
        $return = $this->db->rowCount();
        $this->resetDefaults();
        return $return;
    } 

    /**
     * Build query conditions.
     *
     * @param string $query The SQL query string to which conditions are added.
     */
    protected function buildWhereConditions(string &$query): void
    {
        if (!empty($this->queryWhereConditions)) {
            foreach ($this->queryWhereConditions as $condition) {
                switch ($condition["type"]) {
                    case "AND":
                        $query .= " AND {$condition['column']} = :{$condition['column']}";
                        break;
                    case "OR":
                        $query .= " OR {$condition['column']} = :{$condition['column']}";
                        break;
                    case "AND_OR":
                        $query .= " AND ({$condition['column']} = :{$condition['column']} OR {$condition['columnOr']} = :{$condition['columnOr']})";
                        break;
                    case "IN":
                        $query .= " AND {$condition['column']} IN ({$condition['values']})";
                        break;
                    case "IN_SET":
                        if ($condition['method'] === '>') {
                            $query .= " AND FIND_IN_SET('{$condition['search']}', '{$condition['list']}') > 0";
                        } else {
                            $query .= " AND FIND_IN_SET('{$condition['search']}', '{$condition['list']}')";
                        }
                    case "LIKE":
                        $query .= " AND {$condition['column']} LIKE ?";
                        break;
                    default: 
                        $query .= "";
                    break;
                }
            }
        }
    }

   /**
     * Build query search conditions.
     *
     * @param string $query The SQL query string to which search conditions are added.
    */
    protected function buildSearchConditions(string &$query): void
    {
        if (!empty($this->queryWhereConditions)) {
            $query .= " WHERE";
            $firstCondition = true;
            foreach ($this->queryWhereConditions as $condition) {
                if (!$firstCondition) {
                    $query .= " AND";
                }
                switch ($condition["type"]) {
                    case "IN":
                        $query .= " {$condition['column']} IN ({$condition['values']})";
                        break;
                    case "IN_SET":
                        if ($condition['method'] === '>') {
                            $query .= " FIND_IN_SET('{$condition['search']}', '{$condition['list']}') > 0";
                        } else {
                            $query .= " FIND_IN_SET('{$condition['search']}', '{$condition['list']}')";
                        }
                    default: 
                        $query .= "";
                    break;
                }
                $firstCondition = false;
            }
        }
    }

    /**
     * Throw an exception 
     * @param string $message
     */
    private static function error(string $message) {
        DatabaseException::throwException($message, parent::isProduction());
    }

    /**
     * Reset query conditions
     */
    private function resetDefaults(): void {
        $this->databaseTable = null; 
        $this->databaseJoinTable = null;
        $this->databaseJoinType = null;
        $this->databaseJoinSeed = [];
        $this->queryLimit = "";
        $this->queryOrder = "";
        $this->queryGroup = "";
        $this->queryWhere = "";
        $this->queryWhereValue = "";
        $this->queryWhereConditions = [];
        $this->querySetValues = [];
        $this->hasCache = "NO_CACHE";
        $this->useCacheStorage = false;
        $this->db->free();
        //$this->db->close();
    }
}