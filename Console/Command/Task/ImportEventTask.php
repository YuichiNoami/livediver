<?php
class ImportEventTask extends Shell {
    public $uses = array('User');
    public function execute() {
        echo "Hello, I will import events.";
    }
}