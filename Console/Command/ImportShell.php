<?php
class ImportShell extends AppShell {
    public $tasks = array('ImportEvent'); // Console/Command/Task/SoundTask.php に作成
    public function main() {
        $this->ImportEvent->execute();
    }
}