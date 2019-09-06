<?php

namespace Classes;

class App
{
    const DEFAULT_CTRL='Defaults';
    const DEFAULT_ACTION='index';
    const PREG_URL='/^(\w\&?)*/'; //format ctrl&action&id

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
    function run(): void
    {
        //get query request
        $this->setRequest();
        $response = $this->callController();
        $this->applyTemplate( $response );
    }

    function setRequest(): void
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
    function callController(): array
    {
        $classCtrl = 'Ctrl\\'.ucfirst($this->request['ctrl']);
        $action = $this->request['action'].'Action';
        $params = $this->request['params'];

        if(class_exists($classCtrl)) {
            $ctrl = new $classCtrl();
            if(method_exists($classCtrl, $action)) { echo 'u';
                $responseParams = $ctrl->$action( ...$params );
            } else {
                throw new InvalidArgumentException("L'action n'existe pas");
            }
            return $responseParams;
        } else {
            throw new InvalidArgumentException("Le controller n'existe pas");
        }
    }

    function applyTemplate( array $responseParams ): void
    {
        include VIEW.'layout.phtml';
    }
}