<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PHPixie\Micro;

/**
 * Description of Builder
 *
 * @author sobolev
 */
class Builder extends \PHPixie\Framework\Builder {
    
    public $root;


    public function __construct($root) {
        $this->root = $root;
    }
    
    /**
     * @return Assets
     */
    protected function buildAssets()
    {
        return new Assets(
            $this->components(),
            $this->root
        );
    }

    public function configuration() {
        return $this->instance('configuration');
    }

    /** 
     * @return \PHPixie\Micro\Configuration
     */
    protected function buildConfiguration() {
        return new Configuration($this);
    }

}
