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
