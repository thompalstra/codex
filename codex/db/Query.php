<?php
namespace codex\db;


class Query extends \codex\db\QueryBuilder{

    public $select;
    public $from;
    public $data = [];

    public $className;

    public function __construct(){
        // $this->pdo = &\Codex::$app->pdo;
    }

    public function select( $query ){
        $this->select = $query;

        return $this;
    }
    public function from( $query ){
        $this->from = $query;

        return $this;
    }
    public function where( $query ){
        if( isset( $query[0] ) && !is_string( $query[0] ) ){
            array_unshift($query , 'AND');
        }

        $this->data[] = [
            'type' => 'WHERE',
            'query' => $query
        ];
        return $this;
    }
    public function andWhere( $query ){
        $this->data[] = [
            'type' => 'AND',
            'query' => $query
        ];
        return $this;
    }
    public function orWhere( $query ){
        $this->data[] = [
            'type' => 'OR',
            'query' => $query
        ];
        return $this;
    }

    public function leftJoin(){
        $args = func_get_args();

        $lines = [];
        $lines[] = "LEFT JOIN";


        if( count( $args ) == 2 ){
            $table = $args[0];
            $on = $args[1];

            if( is_array($table) ){
                $firstKey = array_keys( $table )[0];
                $firstValue = $table[$firstKey];

                $lines[] = "$firstValue AS $firstKey";
            }

            if( is_string( $on ) ){
                $lines[] = "ON $on";
            }
        }

        $this->data[] = [
            'type' => 'LEFT JOIN',
            'query' => implode(' ', $lines)
        ];

        return $this;
    }
    public function innerJoin(){

        return $this;
    }
    public function rightJoin(){

        return $this;
    }

    public function fetchClass( $className ){
        $this->className = $className;
        return $this;
    }

    public function one(){
        return $this->fetchOne( $this->createCommand() );
    }
    public function fetchOne( $command ){
        $sth = \Codex::$app->pdo->prepare( $command );
        $sth->execute();

        $className = $this->className;
        $subClassName = $className::subClassName();

        if( empty($this->className) ){
            return $sth->fetch();
        } else {
            $constructorParams = [
                'isNewRecord' => 0
            ];
            return $sth->fetchObject( $this->className, [ $constructorParams ] );
        }

        return $this;
    }
    public function all(){
        return $this->fetchAll( $this->createCommand(), $this->className );
    }

    public function asArray(){
        $this->className = null;
        return $this->fetchAll( $this->createCommand(), null );
    }

    public function fetchAll( $command, $className = null ){
        if( $className != null ){
            $sth = \Codex::$app->pdo->prepare( $command );
            $sth->execute();
            return $sth->fetchAll(\PDO::FETCH_CLASS, $className, [ [
                'isNewRecord' => 0
            ] ] );
        } else if( $className == null){
            $sth = \Codex::$app->pdo->prepare( $command );
            $sth->execute();
            return $sth->fetchAll();
        }
    }
}
?>
