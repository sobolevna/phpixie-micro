<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PHPixie\Micro;

use PHPixie\Filesystem\Root;

/**
 * Description of Assets
 *
 * @author sobolev
 */
class Assets extends \PHPixie\Framework\Assets {
    
    protected $root;

    public function __construct($components, $root) {
        $this->root = $root;
        parent::__construct($components);
    }
    
    /**
     * 
     * @return Root
     */
    public function root() {
        return $this->instance('root');
    }
    
    /**
     * 
     * @return Root
     */
    protected function buildRoot() {
        $directory = realpath($this->root);
        return $this->buildFilesystemRoot($directory);
    }
    
    
}
