<?php

namespace Classes;

class App
{
    const DEFAULT_CTRL='Defaults';
    const DEFAULT_ACTION='index';
    const PREG_URL='/^(\w\&?)*/'; //format ctrl&action&id
    //const CTRL_PATH=__DIR__.'/../Ctrl';

    /**
     * @var array
     * Request value with controller
     * action and params if any
     */
    private $request;

    function __construct()
    {
        $this->run();
    }

    /**
     * Run the application
     */
    function run()
    {
        //get query request
        $this->setRequest();
        $this->callController();
    }

    function setRequest()
    {
        $request = $_REQUEST;

        $query = $_SERVER['QUERY_STRING'];
        if(!preg_match(self::PREG_URL, $query)) {
            return;
        }

        //default
        $ctrl = self::DEFAULT_CTRL;
        $action = self::DEFAULT_ACTION;
        $params = [];

        //ctrl
        if(key($request)) {
            $ctrl = key($request);
            array_shift($request);
        }
        
        //action
        if(key($request)) {
            $action = key($request);
            array_shift($request);
        }
        
        //params if any
        if(key($request)) {
            $params = $request;
        }

        //set
        $this->request = [
            'ctrl'=>$ctrl,
            'action'=>$action,
            'params'=>$params
        ];
    }

    /**
     * Call controller and view
     */
    function callController()
    {
        $classCtrl = 'Ctrl\\'.ucfirst($this->request['ctrl']);
        if(class_exists($classCtrl)) {
            $ctrl = new $classCtrl();
        } else {
            throw new InvalidArgumentException("Le controller n'existe pas");
        }
    }
}