<?php
namespace codex\db;


class QueryBuilder{
    public function createCommand(){

        $this->lines[] = "SELECT $this->select";
        $this->lines[] = "FROM $this->from";

        foreach( $this->data as $col ){
            $this->lines[] = $this->create( $col['type'], $col['query'] );
        }
        return implode(' ', $this->lines);
    }

    public function create( $type, $query ){
        $lines = [];
        if( is_array( $query ) && isset( $query[0] ) && is_string( $query[0] ) && in_array( strtoupper( $query[0] ), ['OR', 'WHERE', 'AND' ] ) ){
            $lines[] = $type . ' (' . $this->createGroup( $query ) . ')';
        }
        return implode(' ', $lines);
    }

    public function createGroup( $query ){
        $glue = $query[0];
        array_shift($query);
        $lines = [];
        foreach( $query as $group ){
            if( is_array( $group ) && isset( $group[0] ) && is_string( $group[0] ) && in_array( strtoupper( $group[0] ), ['OR', 'WHERE', 'AND' ] ) ){
                $lines[] = '(' . $this->createGroup( $group ) . ')';
            } else if( is_array( $group ) && count( $group ) == 3 ){
                $g = $group[0];
                $c = $group[1];
                $v = $group[2];

                $v = $this->sanitize( $v );

                $lines[] = "$c $g $v";
            } else {
                foreach( $group as $c => $v ){
                    $v = $this->sanitize( $v );
                    $lines[] = "$c = $v";
                }
            }
        }
        return implode(" $glue ", $lines);
    }

    public function sanitize( $value ){
        if( is_object( $value ) && get_class( $value ) == 'codex\db\Query' ){
            return "(" . $value->createCommand() . ")";
        } else if( is_string( $value ) ){
            return \Codex::$app->pdo->quote( $value );
        }
        return $value;
    }



    // public function arrayToCommand( $glue, $query ){
    //     $lines = [];
    //     foreach( $query as $subQuery ){
    //         if( count($subQuery) == 1 ){
    //             $firstKey = array_keys($subQuery)[0];
    //             $firstValue = $subQuery[$firstKey];
    //             $lines[] = "$firstKey = $firstValue";
    //         } else if( count($subQuery) == 3 && !is_array( $subQuery[1] ) ) {
    //             $c = $subQuery[1];
    //             $v = $subQuery[2];
    //
    //             if( is_object( $v ) && get_class( $v ) == 'codex\db\Query' ){
    //                 $v = ' ( ' . $v->createCommand() . ' ) ';
    //             }
    //             $g = $subQuery[0];
    //             $lines[] = "$c $g $v";
    //         } else {
    //             $g = $subQuery[0];
    //             array_shift($subQuery);
    //             $lines[] = ' ( ' . $this->arrayToCommand( $g, $subQuery ) . ' ) ';
    //         }
    //     }
    //     return implode( " $glue ", $lines );
    // }
}
