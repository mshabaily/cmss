<?php

namespace CMSS;

class Response {
    private string $message;
    private int $code;

    public array $data = [];

    public function __construct($code, $message) {
        $this->message = $message;
        $this->code = $code;
    }

    public function get_code() : int {
        return $this->code;
    }

    public function get_message(): string
    {
        return $this->message;
    }
}