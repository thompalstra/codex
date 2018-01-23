<?php
namespace codex\db;

// $subQuery = new \codex\db\Query();
// $subQuery->select('user.id')->from('user')
// ->where([
//     'and',
//     ['LIKE', 'username', '%thom%']
// ]);
//
// $query = User::find(); // or $query->select('user.*')->from('user')
// $query->leftJoin([
//     'uc' => 'user_account'
// ], 'uc.user_id = user.id')
// ->where([
//     'or',
//     [
//         'and',
//         ['user.id' => 1],
//         ['=', 'is_deleted', 1]
//     ],
//     [
//         'and',
//         ['is_enabled' => 1],
//         ['IN', 'user.id', $subQuery],
//     ],
//     [
//         'and',
//         ['LIKE', 'last_name', '%lstra%'],
//     ]
// ]);
// $query->orWhere([
//     'or',
//     [
//         'and',
//         [
//             'and',
//             [
//                 'is_enabled' => 1,
//                 'is_deleted' => 0
//             ],
//             ['is_deleted' => 0]
//         ]
//     ],
// ]);
// var_dump( $query->createCommand() );

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
        } else {
            $lines[] = $query;
        }
        return implode(' ', $lines);
    }

    public function createGroup( $query ){
        $glue = $query[0];
        array_shift($query);
        $lines = [];
        foreach( $query as $k => $group ){
            if( is_array( $group ) && isset( $group[0] ) && is_string( $group[0] ) && in_array( strtoupper( $group[0] ), ['OR', 'WHERE', 'AND' ] ) ){
                $lines[] = '(' . $this->createGroup( $group ) . ')';
            } else if( is_array( $group ) && count( $group ) == 3 ){
                $lines[] = $this->asMultiKey( $group );

            } else if( is_array( $group ) ) {
                foreach( $group as $c => $v ){
                    $lines[] = $this->asKeyValue( $c, $this->sanitize( $v ) );
                }
            } else {
                $lines[] = $this->asKeyValue( $k, $this->sanitize( $group ) );
            }
        }
        return implode(" $glue ", $lines);
    }

    public function asKeyValue( $k, $v ){
        return "$k = $v";
    }
    public function asMultiKey( $group ){
        $g = $group[0];
        $c = $group[1];
        $v = $group[2];
        $v = $this->sanitize( $v );
        return "$c $g $v";
    }

    public function sanitize( $value ){
        if( is_object( $value ) && get_class( $value ) == 'codex\db\Query' ){
            return "(" . $value->createCommand() . ")";
        } else if( is_string( $value ) ){
            return \Codex::$app->pdo->quote( $value );
        }
        return $value;
    }
}
