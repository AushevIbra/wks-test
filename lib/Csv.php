<?php 

class Csv {
    protected $users = [];
    protected $file;
    function __construct($file) {
        
        $this->file = $file;
        $this->import();
    }
    
    private function import()
    {
        $f = fopen($this->file, 'r');
        $i = 0;
        if($handle = fopen($this->file, 'r') !== false){
            for($i=0; $i < $data = fgetcsv($f, 1000, ';' ); $i++){
                $this->users[] = [
                    'first_name' => $data[0],
                    'last_name' => $data[1],
                    'login' => $data[2],
                    'email' => $data[3],
                    'password' => $data[4],
                    'role' => 0
                ];
                        
            }
        }
    }

    public function returnUsers() {
        return $this->users;
    }

    private function debug($data)
    {
        echo "<pre>";
            print_r($data);
        echo "</pre>";
        
    }



}