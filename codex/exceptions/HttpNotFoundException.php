<?php
namespace codex\exceptions;

class HttpNotFoundException extends \Exception{
    public function __construct( $message, $code ){
        $this->message = $message;
        $this->code = $code;
    }
}
?>
