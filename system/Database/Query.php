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
//use \Luminova\Arrays\ArrayCountable;

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
    private string $databaseTable = '';

    /**
    *Table name to join query
    *@var string $databaseJoinTable 
    */
    private string $databaseJoinTable = '';

    /**
    *Table join query type
    *@var string $databaseJoinType 
    */
    private string $databaseJoinType = '';

    /**
    *Table join bind parameters
    *@var array $databaseJoinSelectors 
    */
    private array $databaseJoinSelectors = [];

    /**
    *Table query order limit offset and count query 
    *@var string $queryLimit 
    */
    private string $queryLimit = '';

    /**
    *Table query order rows 
    *@var string $queryOrder 
    */
    private string $queryOrder = '';

    /**
    *Table query group column by
    *@var string $queryGroup 
    */
    private string $queryGroup = '';

    /**
    *Table query where column
    *@var string $queryWhere 
    */
    private string $queryWhere = '';

    /**
    * Table query where column value
    *@var string $queryWhereValue 
    */
    private string $queryWhereValue = '';

    /**
    *Table query and query column
    *@var array $queryWhereConditions 
    */
    private array $queryWhereConditions = [];

    /**
    *Table query update set values
    *@var array $querySetValues 
    */
    private array $querySetValues = [];

    /**
    *Cache flag u
    *@var string $hasCache 
    */
    private string $hasCache = "NO_CACHE";

    /**
    *Cache class instance
    *@var FileSystemCache $cache 
    */
    private $cache = null;

    /**
    *Cache key
    *@var string $cacheKey 
    */
    private string $cacheKey = "default";

    /**
    * Table alias
    * @var string $tableAlias 
    */
    private string $tableAlias = '';

    /**
    * Join table alias
    * @var string $jointTableAlias 
    */
    private string $jointTableAlias = '';

    /**
    * Bind values 
    * @var array $bindValues 
    */
    private array $bindValues = [];


    /**
    * Class Constructor
    */
	public function __construct(){
		parent::__construct();
	}

     /**
     * Get properties
     * 
     * @param string $key
     * 
     * @return mixed 
    */
    public function __get(string $key): mixed 
    {
        return $this->{$key} ?? null;
    }

    /**
     * Check if property key is set
     * 
     * @param string $key
     * 
     * @return bool 
    */
    public function __isset(string $key): bool 
    {
        return isset($this->{$key});
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
     * Get database connection
     * 
     * @return object 
    */
    public function getConn(): object 
    {
        return $this->db;
    }

    /**
     * Close database connection
     * 
     * @return void 
    */
    public function closeConn(): void 
    {
       $this->db->close();
    }

    /**
    * Class Singleton
    * @return Query object $instance
    */
    public static function getInstance(): self 
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
     * @param string $as table alias
     * 
     * @return Query $this Class instance.
     */
    public function table(string $table, string $as = ''): self
    {
        $this->databaseTable = $table;
        if($as !== ''){
            $this->tableAlias = $as;
        }
        return $this;
    }

     /**
     * Sets join table name and method
     * @param string $table The table name
     * @param string $type The join type
     * @param string $as join table alias
     * 
     * @return Query $this Class instance.
     */
    public function join(string $table, string $type = "INNER", string $as = ''): Query
    {
        $this->databaseJoinType = $type;
        $this->databaseJoinTable = $table;
        if($as !== ''){
            $this->jointTableAlias = $as;
        }
        return $this;
    }

    /**
     * Sets join table on clause
     * 
     * @param array $selectors Join selectors ['key = table_key', 'u.key = u2.key']
     * 
     * @return Query $this Class instance.
     */
    public function on(array $selectors): Query
    {
        $this->databaseJoinSelectors = $selectors;
        return $this;
    }

    /**
     * Sets join table inner
     * 
     * @param string $table The table name
     * @param string $as join table alias
     * 
     * @return Query $this Class instance.
     */
    public function innerJoin(string $table, string $as = ''): Query
    {
        $this->join($table, "INNER", $as);
        return $this;
    }


    /**
     * Sets join table left
     * 
     * @param string $table The table name
     * @param string $as join table alias
     * 
     * @return Query $this Class instance.
     */
    public function leftJoin(string $table, string $as = ''): Query
    {
        $this->join($table, "LEFT", $as);
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
     * @param mixed $key column key value
     * @return Query class instance.
     */
    public function where(string $column, mixed $key): Query
    {
        $this->queryWhereValue = $key;
        $this->queryWhere = " WHERE {$column} = :where_column";
        return $this;
    }

    /**
     * Set query where and
     * @param string $column column name
     * @param mixed $key column key value
     * @return Query class instance.
     */
    public function and(string $column, mixed $key): Query
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
     * @param mixed $key column key value
     * @return Query class instance.
     */
    public function or(string $column, mixed $key): Query
    {
        $this->queryWhereConditions[] = ["type" => "OR", "column" => $column, "key" => $key];
        return $this;
    }
    
     /**
     * Set query AND (? OR ?)
     * @param string $column column name
     * @param mixed $key column key value
     * @param string $columnOr column name
     * @param mixed $keyOr column key value
     * @return Query class instance.
     */
    public function andOr(string $column, mixed $key, string $columnOr, mixed $keyOr): Query
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

            $this->queryWhereConditions[] = [
                "type" => "IN", 
                "column" => $column, 
                "values" => $values
            ];
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
        $this->queryWhereConditions[] = [
            "type" => "IN_SET", 
            "list" => $values, 
            "search" => $search, 
            "method" => $method
        ];
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
     * @param string $key The storage cache key
     * @param string $filename Private storage filename hash name (optional): but is recommended to void storing large data in one file.
     * @param int $expiry The cache expiry time in seconds (default: 7 days).
     * 
     * @return Query $this class instance.
     */
    public function cache(string $key, string $filename = null, int $expiry = 7 * 24 * 60 * 60): self
    {
        $filename = $filename === null ? 'database_' . $this->databaseTable : $filename;
        $this->cache = FileSystemCache::getInstance();
        $this->cache->setEnableCache(true);
        $this->cache->setExpire($expiry);
        $this->cache->setFilename($filename);
        $this->cache->setCacheLocation(self::getFilepath());
        $this->cache->create();
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
        if ($values === []) {
            return 0;
        }

        if (!$this->isNestedArray($values)) {
            $values = [$values];
        }
    
        $columns = array_keys($values[0]);
        try {
            if($bind){
                return $this->executeInsertPrepared($columns, $values);
            }
            return $this->executeInsertQuery($columns, $values);
        } catch (DatabaseException $e) {
            $e->handle();
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
        if($this->cache !== null && $this->hasCache == "HAS_CACHE"){
            $response = $this->cache->retrieveCache($this->cacheKey);
            $this->cacheKey = '';
            $this->resetDefaults();
            return $response;
        }

        $columns = implode(", ", $columns);
        $selectQuery = "SELECT {$columns} FROM {$this->databaseTable} {$this->tableAlias}";
        if ($this->databaseJoinTable !== '') {
            $selectQuery .= " {$this->databaseJoinType} JOIN {$this->databaseJoinTable} {$this->jointTableAlias}";
            if ($this->databaseJoinSelectors !== []) {
                $selectQuery .= " ON {$this->databaseJoinSelectors[0]}";
                if(count($this->databaseJoinSelectors) > 1){
                    for ($i = 1; $i < count($this->databaseJoinSelectors); $i++) {
                        $selectQuery .= " AND {$this->databaseJoinSelectors[$i]}";
                    }
                }
            } 
        }

        try {
            if($this->cache === null){
                return $this->returnSelect($selectQuery);
            }

            return $this->cache->onExpired($this->cacheKey, function() use($selectQuery) {
                return $this->returnSelect($selectQuery);
            });
        } catch (DatabaseException $e) {
            $e->handle();
        }
        
        return null;
    }

    /**
     * Return select result from table
     * 
     * @param string $selectQuery query
     * 
     * @return mixed
    */
    private function returnSelect(string &$selectQuery): mixed 
    {
        $isBided = false;
        if ($this->queryWhere === '') {
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
            if ($this->queryWhereConditions !== []) {
                foreach ($this->queryWhereConditions as $bindings) {
                    if (in_array($bindings['type'], ["AND", "OR"])) {
                        $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                    } elseif ($bindings['type'] === "AND_OR") {
                        $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                        $this->db->bind($this->trimPlaceholder($bindings['columnOr']), $bindings['keyOr']);
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
    }

    /**
     * Select on record from table,
     * @param string $buildQuery database query string
     * @param string $result query return type
     * @return mixed|null returns selected row.
     */
    public function builder(string $buildQuery, string $result = 'all'): mixed 
    {
        if (empty($buildQuery)) {
            throw new DatabaseException("Builder operation without a query condition is not allowed.");
        }

        if($this->cache !== null && $this->hasCache == "HAS_CACHE"){
            $response = $this->cache->retrieveCache($this->cacheKey);
            $this->cacheKey = '';
            $this->resetDefaults();
            return $response;
        }

        try {
            if($this->cache === null){
                return $this->returnBuilder($buildQuery, $result);
            }
            return $this->cache->onExpired($this->cacheKey, function() use($buildQuery, $result) {
                return $this->returnBuilder($buildQuery, $result);
            });
        } catch (DatabaseException $e) {
            $e->handle();
        }
        return null;
    }

    /**
     * Bind placeholder values to builder
     * 
     * @param array $values
     * 
     * @return self
    */
    public function binds(array $values): self 
    {
        $this->bindValues = $values;
        return $this;
    }

    /**
     * Return custom builder result from table
     * 
     * @param string $buildQuery query
     * @param string $result return result type
     * 
     * @return mixed
     * @throws DatabaseException
    */
    private function returnBuilder(string $buildQuery, string $result): mixed 
    {
        if($this->bindValues === []){
            $this->db->query($buildQuery);
        }else{
            $this->db->prepare($buildQuery);
            foreach ($this->bindValues as $key => $value) {
                if(!is_string($key) || $key === '?'){
                    throw new DatabaseException("Invalid bind placeholder {$key}, placeholder key must be same with your table mapped column key");
                }
                $this->db->bind($this->trimPlaceholder($key), $value);
            }
            $this->db->execute();
        }
        $response = match ($result) {
            'one' => $this->db->getOne(),
            'count' => $this->db->rowCount(),
            'total' => $this->db->getInt(),
            'object' => $this->db->getAllObject(),
            'lastId' => $this->db->getLastInsertId(),
            default => $this->db->getAll(),
        };
        $this->resetDefaults();
        return $response;
    }

    /**
     * Select on record from table,
     * @param array $rows select columns
     * @return object|null returns selected row.
     */
    public function find(array $columns = ["*"]): mixed 
    {
        if ($this->queryWhere === '') {
            throw new DatabaseException("Find operation without a WHERE condition is not allowed.");
        }

        if($this->cache !== null && $this->hasCache == "HAS_CACHE"){
            $response = $this->cache->retrieveCache($this->cacheKey);
            $this->cacheKey = '';
            $this->resetDefaults();
            return $response;
        }

        $columns = implode(", ", $columns);
        $findQuery = "SELECT {$columns} FROM {$this->databaseTable} {$this->tableAlias}";
        if ($this->databaseJoinTable !== '') {
            $findQuery .= " {$this->databaseJoinType} JOIN {$this->databaseJoinTable} {$this->jointTableAlias}";
            if ($this->databaseJoinSelectors !== []) {
                $findQuery .= " ON {$this->databaseJoinSelectors[0]}";
                //$countable = new ArrayCountable($this->databaseJoinSelectors);
                if(count($this->databaseJoinSelectors) > 1){
                    for ($i = 1; $i < count($this->databaseJoinSelectors); $i++) {
                        $findQuery .= " AND {$this->databaseJoinSelectors[$i]}";
                    }
                }
            } 
        }
        
        try {
            if($this->cache === null){
                return $this->returnFind($findQuery);
            }
            
            return $this->cache->onExpired($this->cacheKey, function() use($findQuery) {
                return $this->returnFind($findQuery);
            });
        } catch (DatabaseException $e) {
            $e->handle();
        }
        
        return null;
    }

    /**
     * Return single result from table
     * 
     * @param string $findQuery query
     * 
     * @return mixed
    */
    private function returnFind(string &$findQuery): mixed 
    {
        $findQuery .= $this->queryWhere;
        $this->buildWhereConditions($findQuery);
        $findQuery .= " LIMIT 1";
 
        $this->db->prepare($findQuery);
        $this->db->bind(":where_column", $this->queryWhereValue);
        if ($this->queryWhereConditions !== []) {
            foreach ($this->queryWhereConditions as $bindings) {
                if (in_array($bindings['type'], ["AND", "OR"])) {
                    $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                } elseif ($bindings['type'] === "AND_OR") {
                    $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                    $this->db->bind($this->trimPlaceholder($bindings['columnOr']), $bindings['keyOr']);
                }
            }
        }
        $this->db->execute();
        $return = $this->db->getOne();
        $this->resetDefaults();
        return $return;
    }


    /**
     * Select on record from table,
     * @param array $rows select columns
     * @return int returns selected row.
    */
    public function total(string $column = "*"): int 
    {
        if($this->cache !== null && $this->hasCache == "HAS_CACHE"){
            $response = $this->cache->retrieveCache($this->cacheKey);
            $this->cacheKey = '';
            $this->resetDefaults();
            return $response??0;
        }
           
        $totalQuery = "SELECT COUNT({$column}) FROM {$this->databaseTable} {$this->tableAlias}";
        
        if ($this->databaseJoinTable !== '') {
            $totalQuery .= " {$this->databaseJoinType} JOIN {$this->databaseJoinTable} {$this->jointTableAlias}";
            if ($this->databaseJoinSelectors !== []) {
                $totalQuery .= " ON {$this->databaseJoinSelectors[0]}";
                if(count($this->databaseJoinSelectors) > 1){
                    for ($i = 1; $i < count($this->databaseJoinSelectors); $i++) {
                        $totalQuery .= " AND {$this->databaseJoinSelectors[$i]}";
                    }
                }
            } 
        }
    
        try {
            if($this->cache === null){
                return $this->returnTotal($totalQuery);
            }

            return $this->cache->onExpired($this->cacheKey, function() use($totalQuery) {
                return $this->returnTotal($totalQuery);
            });
        } catch (DatabaseException $e) {
            $e->handle();
        }
        return 0;
    }

    /**
     * Return total number of rows in table
     * 
     * @param string $totalQuery query
     * 
     * @return int returns selected row.
    */
    private function returnTotal(string $totalQuery): int 
    {
        if ($this->queryWhere === '') {
            $this->db->query($totalQuery);
        }else{
            $totalQuery .= $this->queryWhere;
            $this->buildWhereConditions($totalQuery);
            $this->db->prepare($totalQuery);
            $this->db->bind(":where_column", $this->queryWhereValue);
            if ($this->queryWhereConditions !== []) {
                foreach ($this->queryWhereConditions as $bindings) {
                    if (in_array($bindings['type'], ["AND", "OR"])) {
                        $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                    } elseif ($bindings['type'] === "AND_OR") {
                        $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                        $this->db->bind($this->trimPlaceholder($bindings['columnOr']), $bindings['keyOr']);
                    }
                }
            }
            $this->db->execute();
        }
        $total = $this->db->getInt();
        $this->resetDefaults();
        return $total;
    }

    /**
     * Update table with columns and values
     * @param array $setValues associative array of columns and values to update
     * @param int $limit number of records to update 
     * 
     * @return int returns affected row counts.
     */
    public function update(?array $setValues = null, int $limit = 0): int 
    {
        if (empty($setValues) && $this->querySetValues === []) {
            self::error("Update operation without SET values is not allowed.");
        }
        if ($this->queryWhere === '') {
            self::error("Update operation without a WHERE condition is not allowed.");
        }else{
            $columns = !empty($setValues) ? $setValues : $this->querySetValues;
            $updateColumns = array_map(function ($column) {
                return "$column = :$column";
            }, array_keys($columns));

    
            $updateQuery = "UPDATE {$this->databaseTable} SET " . implode(", ", $updateColumns);
            $updateQuery .= $this->queryWhere;
            $this->buildWhereConditions($updateQuery);
            if($limit > 0){
                $updateQuery .= " LIMIT {$limit}";
            }
            try {
                $this->db->prepare($updateQuery);
                foreach ($columns as $key => $value) {
                    $this->db->bind($this->trimPlaceholder($key), $value);
                }
                $this->db->bind(":where_column", $this->queryWhereValue);
                if ($this->queryWhereConditions !== []) {
                    foreach ($this->queryWhereConditions as $bindings) {
                        if (in_array($bindings['type'], ["AND", "OR"])) {
                            $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                        } elseif ($bindings['type'] === "AND_OR") {
                            $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                            $this->db->bind($this->trimPlaceholder($bindings['columnOr']), $bindings['keyOr']);
                        }
                    }
                }
                
                $this->db->execute();
                $return = $this->db->rowCount();
                $this->resetDefaults();
                return $return;
            } catch (DatabaseException $e) {
                $e->handle();
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
         if ($this->queryWhere === '') {
            self::error("Delete operation without a WHERE condition is not allowed.");
         }else{
            $deleteQuery = "DELETE FROM {$this->databaseTable}";
            $deleteQuery .= $this->queryWhere;
            $this->buildWhereConditions($deleteQuery);

            if($limit > 0){
                $deleteQuery .= " LIMIT {$limit}";
            }

            try {
                $this->db->prepare($deleteQuery);
                $this->db->bind(":where_column", $this->queryWhereValue);
                if ($this->queryWhereConditions !== []) {
                    foreach ($this->queryWhereConditions as $bindings) {
                        if (in_array($bindings['type'], ["AND", "OR"])) {
                            $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                        } elseif ($bindings['type'] === "AND_OR") {
                            $this->db->bind($this->trimPlaceholder($bindings['column']), $bindings['key']);
                            $this->db->bind($this->trimPlaceholder($bindings['columnOr']), $bindings['keyOr']);
                        }
                    }
                }
                $this->db->execute();
                $rowCount = $this->db->rowCount();
                $this->resetDefaults();
                return $rowCount;
            } catch (DatabaseException $e) {
                $e->handle();
            }
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
            $e->handle();
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
            $e->handle(Configuration::isProduction());
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
            $e->handle(Configuration::isProduction());
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
            $e->handle();
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
                $this->db->bind($this->trimPlaceholder($key), $value);
            }
            $this->db->execute();
        }
        $return = $this->db->rowCount();
        $this->resetDefaults();
        return $return;
    } 

    /**
     * Trim placeholder
     *
     * @param string $input 
     * 
     * @return string $placeholder
    */
    private function trimPlaceholder(string $input): string 
    {
        $dotPosition = strpos($input, '.');
        $placeholder = ($dotPosition !== false) ? substr($input, $dotPosition + 1) : $input;
        return ":$placeholder";
    }
    
    /**
     * Build query conditions.
     *
     * @param string $query The SQL query string to which conditions are added.
    */
    protected function buildWhereConditions(string &$query): void
    {
        if ($this->queryWhereConditions !== []) {
            foreach ($this->queryWhereConditions as $condition) {
                $column = $condition['column'];
                $placeholder = $this->trimPlaceholder($column);

                $query .= match ($condition['type']) {
                    'AND' => " AND $column = $placeholder",
                    'OR' => " OR $column = $placeholder",
                    'AND_OR' => " AND ($column = $placeholder OR {$condition['columnOr']} = " . $this->trimPlaceholder($condition['columnOr']) . ")",
                    'IN' => " AND $column IN ({$condition['values']})",
                    'IN_SET' => ($condition['method'] === '>') ?
                        " AND FIND_IN_SET('{$condition['search']}', '{$condition['list']}') > 0" :
                        " AND FIND_IN_SET('{$condition['search']}', '{$condition['list']}')",
                    'LIKE' => " AND $column LIKE ?",
                    default => '',
                };
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
        if ($this->queryWhereConditions !== []) {
            $query .= " WHERE";
            $firstCondition = true;
            foreach ($this->queryWhereConditions as $condition) {
                if (!$firstCondition) {
                    $query .= " AND";
                }

                $query .= match ($condition['type']) {
                    'IN' => " {$condition['column']} IN ({$condition['values']})",
                    'IN_SET' => ($condition['method'] === '>') ?
                        " FIND_IN_SET('{$condition['search']}', '{$condition['list']}') > 0" :
                        " FIND_IN_SET('{$condition['search']}', '{$condition['list']}')",
                    default => '',
                };

                $firstCondition = false;
            }
        }
    }

    /**
     * Throw an exception 
     * @param string $message
     */
    private static function error(string $message) {
        DatabaseException::throwException($message);
    }

    /**
     * Check if array is a nested array
     * And its associative array
     * 
     * @param array $array
     * 
     * @return bool 
    */
    private function isNestedArray(array $array): bool 
    {
        if (count($array) === 0) {
            return false;
        }

        if (isset($array[0]) && is_array($array[0])){
            $key = array_key_first($array[0]);
            if(is_string($key)){
                return true;
            }
        }

        return false;
        //return count($array) > 0 && isset($array[0]) && is_array($array[0]) && array_values($array) !== $array;
    }
    
    /**
     * Reset query conditions
     * @return void 
    */
    private function resetDefaults(): void 
    {
        $this->databaseTable = ''; 
        $this->jointTableAlias = '';
        $this->tableAlias = '';
        $this->databaseJoinTable = '';
        $this->databaseJoinType = '';
        $this->databaseJoinSelectors = [];
        $this->queryLimit = '';
        $this->queryOrder = '';
        $this->queryGroup = '';
        $this->queryWhere = '';
        $this->queryWhereValue = '';
        $this->queryWhereConditions = [];
        $this->querySetValues = [];
        $this->hasCache = 'NO_CACHE';
        $this->cache = null;
        $this->bindValues = [];
        $this->db->free();
    }
}