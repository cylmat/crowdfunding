<?php declare(strict_types = 1);

namespace Classes;

use Ctrl\Layout;

class App
{
    const DEFAULT_CTRL='Defaults';
    const DEFAULT_ACTION='index';
    const PREG_URL='/^(\w\&?)*/'; //format ctrl&action&id

    /**
     * Request value with controller
     * action and params if any
     * 
     * @var array
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
        $request = $this->getRequest();
        
        $ctrlName = $request['ctrl'];
        $actionName = $request['action'];
        $params = $request['params'];

        $response = $this->callController($ctrlName, $actionName, $params);
        $content = $this->applyTemplate($ctrlName, $actionName, $response);

        $this->send($content);
    }

    public function getRequest(): ?array
    {
        $request = $_REQUEST;

        $query = $_SERVER['QUERY_STRING'];
        if(!preg_match(self::PREG_URL, $query)) {
            return null;
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
        $request = [
            'ctrl'=>$ctrl,
            'action'=>$action,
            'params'=>$params
        ];
        return $request;
    }

    /**
     * Call controller and view
     */
    public function callController($ctrlName, $actionName, $params=[]): array
    {
        $classCtrl = 'Ctrl\\'.ucfirst($ctrlName);
        $action = $actionName.'Action';
        
        if(class_exists($classCtrl)) {
            $ctrlObject = new $classCtrl();
            if(method_exists($classCtrl, $action)) { 
                return $ctrlObject->$action($params);
            } elseif(method_exists($classCtrl, $actionName)) { 
                return $ctrlObject->$actionName($params);
            } else {
                throw new \InvalidArgumentException("L'action $actionName n'existe pas");
            }
        } else {
            throw new \InvalidArgumentException("Le controller $ctrlName n'existe pas");
        }
    }

    public function applyTemplate( string $ctrl, string $action, array $responseParams ): string
    {
        extract($responseParams);

        ob_start();
        include VIEW. strtolower($ctrl) . '/' . $action . '.phtml';
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
        //include VIEW.'layout.phtml';
    }

    public function send($render)
    {
        echo $render;
    }
}
