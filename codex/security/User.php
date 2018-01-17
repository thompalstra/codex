<?php
namespace codex\security;

class User extends \codex\base\Model implements \codex\security\IdentityInterface{
    public static $tableName = "user";
}
?>
