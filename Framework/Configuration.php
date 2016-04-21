<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PHPixie\Micro;

/**
 * Description of Configuration
 *
 * @author sobolev
 */
class Configuration implements \PHPixie\Framework\Configuration {

    /**
     * @var Builder
     */
    protected $builder;
    
    /**
     * @var \PHPixie\Slice
     */
    protected $slice;
    /**
     * @var array
     */
    protected $instances = array();
    
    /**
     * @var Slice\Type\ArrayData
     */
    protected $databaseConfig = null;
    
    /**
     * @var Slice\Type\ArrayData
     */
    protected $ormConfig = null;
    
    /**
     * @var Slice\Type\ArrayData
     */
    protected $authConfig = null;
    
    /**
     * Constructor
     * @param Builder $builder
     */
    public function __construct($builder) {
        $this->builder = $builder;
        $this->slice = new \PHPixie\Slice();
    }

    /**
     * @param array $config
     */
    public function databaseConfig($config = null) {
        if ($config) {
            $this->databaseConfig = $this->slice->arrayData($config);          
        }
        if (!$this->databaseConfig) {
            throw new \PHPixie\Database\Exception('No database configuration loaded');
        }
        else {
            return $this->databaseConfig;        }
        
    }
        
    /**
     * @inheritdoc
     */
    public function templateConfig() {
        return array(
            'type'      => 'directory',
            'directory' => 'templates'
        );
    }
    
    /**
     * @inheritdoc
     */
    public function httpConfig() {
        return $this->instance('httpConfig');
    }

    /**
     * @inheritdoc
     */
    public function httpProcessor() {
        return $this->instance('httpProcessor');
    }

    /**
     * @inheritdoc
     */
    public function httpRouteResolver() {
        return $this->instance('httpRouteResolver');
    }

    /**
     * @inheritdoc
     */
    public function imageDefaultDriver() {
        return;
    }

    /**
     * @inheritdoc
     */
    public function templateLocator() {
        return;
    }

    /**
     * @inheritdoc
     */
    public function filesystemRoot() {
        return $this->builder->assets()->root();
    }

//    /**
//     * ORM configuration merger
//     * @return Configuration\ORM
//     */
//    public function orm() {
//        return $this->instance('orm');
//    }

    /**
     * @inheritdoc
     */
    public function ormConfig($config=null) {
        if ($config) {
            $this->ormConfig = $this->slice->arrayData($config);          
        }
        return $this->ormConfig;
    }

    /**
     * @inheritdoc
     */
    public function ormWrappers() {
        return;
    }

    /**
     * @param array $config
     */
    public function authConfig($config) {
        if ($config) {
            $this->authConfig = $this->slice->arrayData($config);       
        }
        if (!$this->authConfig) {
            throw new \Exception('No auth configuration loaded');
        }
        return $this->authConfig;
    }

    /**
     * @inheritdoc
     */
    public function authRepositories() {
        return;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function instance($name) {
        if (!array_key_exists($name, $this->instances)) {
            $method = 'build' . ucfirst($name);
            $this->instances[$name] = $this->$method();
        }

        return $this->instances[$name];
    }

    
}
