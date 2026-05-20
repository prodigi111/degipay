<?php

class App {
    public function __construct(Array $init) {
        if($init !== '' || count($init) != 0) {
            foreach ($init as $class) {
                $realClass = $class;
                $class = $this->makePath($class);
                if(file_exists($class.'.php')) {
                    require $class.'.php';
                } else {
                    die('Class ['.$realClass.'] doesnt exists');
                }
            }
        }
    }

    private function makePath($class) {
        $class     = strtolower($class);
        $class     = ltrim($class, '/');
        $class     = DESKTOPPATH . $class;
        $class     = str_replace(['\\', '//'], '/', $class);
        return $class;
    }
}