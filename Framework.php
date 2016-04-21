<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PHPixie\Micro;

/**
 * Description of Framework
 * A class to initialize microframeworks based on PHPixie.
 * An architecture is similar to other PHP microframeworks.
 * 
 * @author sobolevna
 */
class Framework extends \PHPixie\Framework {

    /**
     *
     * @var string Site root  
     */
    protected $dir;
    
    /**
     *
     * @var array 
     */
    protected $routes = array();

    public function __construct($dir) {
        $this->dir = isset($dir) && \is_dir($dir) ? $dir : $_SERVER['DOCUMENT_ROOT'];
        parent::__construct();
    }

    /**
     * @return Builder
     */
    protected function buildBuilder() {
        return new \PHPixie\Micro\Builder($this->dir);
    }

    /**
     * @param array $config Database connection configuration 
     * in standard PHPixie format
     * @return \PHPixie\Database
     */
    public function db($config = null) {
        try {
            $this->builder->configuration()->databaseConfig($config);
            return $this->builder->components()->database();
        } catch (\PHPixie\Database\Exception $e) {
            echo $e->getTraceAsString();
        }
    }

    /**
     * @param array $db 
     * @param array $orm ORM configuration in standard PHPixie format
     * @return \PHPixie\ORM
     */
    public function orm($db, $orm = null) {
        try {
            $this->builder->configuration()->databaseConfig($db);
            $this->builder->configuration()->ormConfig($orm);
            return $this->builder->components()->orm();
        } 
        catch (\PHPixie\Database\Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * @param string $route -- route description like 
     * '/staticAttr/<requiredAttr>(/<miscAttr>)'
     * @param function $action -- processing function. 
     * Should use PHPixie\HTTP\Request $request as a parameter.
     * Syntax inside the function is similar to PHPixie standards 
     * for HTTPProcessors actions
     */
    public function route($route, $action) {
        $this->routes[$route] = $action;
    }

    public function run() {
        $this->registerDebugHandlers();
        $this->processHttpSapiRequest();
    }

}
