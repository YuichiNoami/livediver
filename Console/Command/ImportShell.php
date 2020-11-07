<?php
class ImportShell extends AppShell {
    public $tasks = array('ImportEvent');
    public function main() {
        $this->ImportEvent->execute();
    }
}