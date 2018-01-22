<?php
use codex\security\User;
echo 'dsadsa';

$subQuery = new \codex\db\Query();
$subQuery->select('user.id')->from('user')->where([
    'and',
    ['LIKE', 'username', '%thom%']
]);

$userQuery1 = User::find();
$userQuery1->select('user.*')->from('user');
$userQuery1->where([
    'or',
    [
        'and',
        ['user.id' => 1],
        ['=', 'is_deleted', 1]
    ],
    [
        'and',
        ['is_enabled' => 1],
        ['IN', 'user.id', $subQuery],
    ]
])->one();
?>
