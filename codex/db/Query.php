<?php
namespace codex\db;


class Query{

    public $select;
    public $from;
    public $data = [];

    public $className;

    public function __construct(){
        // $this->pdo = &\Codex::$app->pdo;
    }

    public function createCommand(){
        $lines = [];
        $lines[] = "SELECT $this->select";
        $lines[] = "FROM $this->from";

        foreach($this->data as $data){

            $line = [];
            $group = false;

            if( isset( $data['type'] ) && !empty( $data['type'] ) ){
                $line[] = $data['type'];
                $group = true;
                unset( $data['type'] );
            }

            $line[] = ( $group == true ) ? "(" : "";
            $line[] = implode(' and ', $data['data']);
            $line[] = ( $group == true ) ? ")" : "";

            $lines[] = implode(' ', $line);
        }

        return implode(' ', $lines);
    }

    public function appendWhere( $key, $query ){

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
        $where = [
            'type' => 'WHERE',
            'data' => []
        ];
        foreach( $query as $type => $params ){
            foreach( $params as $column => $value ){
                $where['data'][] = "$column $type $value";
            }
        }
        $this->data[] = $where;
        return $this;
    }
    public function andWhere( $query ){
        $where = [
            'type' => 'AND',
            'data' => []
        ];
        foreach( $query as $type => $params ){
            foreach( $params as $column => $value ){
                $where['data'][] = "$column $type $value";
            }
        }
        $this->data[] = $where;
        return $this;
    }
    public function orWhere( $query ){
        $where = [
            'type' => 'OR',
            'data' => []
        ];
        foreach( $query as $type => $params ){
            foreach( $params as $column => $value ){
                $where['data'][] = "$column $type $value";
            }
        }
        $this->data[] = $where;
        return $this;
    }

    public function leftJoin(){

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
        return $this->fetchAll( $this->createCommand() );
    }
    public function fetchAll( $command ){
        $sth = \Codex::$app->pdo->prepare( $command );
        $sth->execute();

        $className = $this->className;
        $subClassName = $className::subClassName();

        if( empty($this->className) ){
            return $sth->fetchAll();
        } else {
            $constructorParams = [
                'isNewRecord' => 0
            ];
            return $sth->fetchAll(\PDO::FETCH_CLASS, $this->className, [ $constructorParams ] );
        }

        return $this;
    }
}
?>
