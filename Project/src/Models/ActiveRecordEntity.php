<?php 
    namespace Models;
    use Services\Db;
    abstract class ActiveRecordEntity {
        protected $id;
        public function getId() {
            return $this->id;
        }

        public static function getById(int $id)
        {
            $db = Db::getInstance();
            $entities = $db->query("SELECT * FROM ".static::getTableName()." WHERE id = :id", [':id' => $id], static::class);
            return $entities ? $entities[0]:null;
        }

        public function __set($name, $value) {
            $nameCamelCase = $this->underscoreToCamelCase($name);
            $this->$nameCamelCase = $value;
        }
        
        
        public static function findAll(): array {
            $db = Db::getInstance();
            return $db->query("SELECT * FROM `".static::getTableName()."`", [], static::class);
            
        }

        public static function findAllWhere($column, $value): array {
            $db = Db::getInstance();
            $sql = "SELECT * FROM `".static::getTableName()."` WHERE ";
            

            $sql .= "`$column` = :value1";
            return $db->query($sql, [":value1" => $value], static::class);
            
        }
        public function save()
        {
            $mappedProperties = $this->mapPropertiesToDbFormat();
            
            if( $this->id === null) return $this->insert($mappedProperties);
            else return $this->update($mappedProperties);
        }

        public function insert(array $mappedProperties) {
            $column = [];
            $params2values = [];
            $paramNames = [];
            $filterProperties = array_filter($mappedProperties);
            // var_dump($filterProperties);
            foreach($filterProperties as $column => $value) {
                $columns[] = ' '.$column.' ';
                $paramName = ':'.$column;
                $paramNames[] = $paramName;
                $params2values[$paramName] = $value;
            }   
            $sql = "INSERT INTO `".static::getTableName()."` (".implode(',', $columns).") VALUES (".implode(',', $paramNames).")";
            $db = Db::getInstance();
            $res = $db->query($sql, $params2values, static::class);
            
            if( $res !== null) {
                $this->id = $db->lastInsertId();
            } 
            return $res;


        }

        public function update(array $mappedProperties) {
            $columns2params = [];
            $params2values = [];

            $index = 1;
            foreach($mappedProperties as $column => $value) {
                
                $param = ':param'.$index; //column1
                $columns2params[] = $column.' = '.$param;
                $params2values[$param] = $value;

                $index++;
            }


            $sql = "UPDATE `".static::getTableName()."` SET ".implode(', ', $columns2params)." WHERE id = ".$this->id;
            $db = Db::getInstance();
            $res = $db->query($sql, $params2values, static::class);
            return $res;
        }

        public function destroy() {
            $sql = "DELETE FROM `".static::getTableName()."` WHERE id=:id";
            $db = Db::getInstance();
            $res = $db->query($sql, [':id' => $this->id], static::class);
            return $res;
        }

        abstract protected static function getTableName(): string;
        
        private function underscoreToCamelCase(string $source): string {
            return lcfirst(str_replace('_', '', ucwords($source, '_')));
        }
        private function camelCaseToUnderscore(string $source): string {
            return strtolower(preg_replace('/[A-Z]/', '_$0', $source));
        }
        private function mapPropertiesToDbFormat(): array {
            
            $reflector = new \ReflectionObject($this);
            $properties = $reflector->getProperties();
            $mappedProperties = [];
            foreach($properties as $property) {
                $propertyName = $property->getName();
                $propertyUnderscore = $this->camelCaseToUnderscore($propertyName);
                $mappedProperties[$propertyUnderscore] = $this->$propertyName;
            }
            return $mappedProperties;
        }

    }

?>