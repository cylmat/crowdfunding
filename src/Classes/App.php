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

    public function __construct()
    {
        $this->run();
    }

    /**
     * Run the application
     */
    public function run(): void
    {
        //get query request
        $this->setRequest();
        $response = $this->callController();
    }

    public function setRequest(): void
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
    public function callController(): void
    {
        $ctrlName = $this->request['ctrl'];
        $classCtrl = 'Ctrl\\'.ucfirst($ctrlName);
        $actionName = $this->request['action'];
        $action = $actionName.'Action';
        $params = $this->request['params'];

        if(class_exists($classCtrl)) {
            $ctrlObject = new $classCtrl();
            if(method_exists($classCtrl, $action)) { 
                $responseParams = $ctrlObject->$action( ...$params );
                $this->applyTemplate( $ctrlName, $actionName, $responseParams );
            } else {
                throw new \InvalidArgumentException("L'action $actionName n'existe pas");
            }
            //return $responseParams;
        } else {
            throw new \InvalidArgumentException("Le controller $ctrlName n'existe pas");
        }
    }

    public function applyTemplate( string $ctrl, string $action, array $responseParams ): void
    {
        extract($responseParams);
        
        ob_start();
        include VIEW. strtolower($ctrl) . '/' . $action . '.phtml';
        $content = ob_get_contents();
        ob_end_clean();

        include VIEW.'layout.phtml';
    }
}