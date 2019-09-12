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
        if(null === ($request = $this->getRequest())) {
            return;
        }
        
        $ctrlName = $request['ctrl'];
        $actionName = $request['action'];
        $params = $request['params'];

        $header = $this->callController('layout', 'header', $params);
        $content = $this->callController($ctrlName, $actionName, $params);
        $footer = $this->callController('layout', 'footer', $params);
        
        $this->sendToLayout(['header'=>$header, 'content'=>$content, 'footer'=>$footer]);
    }

    public function getRequest(): ?array
    {
        $request = $_REQUEST;

        if(!isset($_SERVER['QUERY_STRING'])) { 
            return null;
        }

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
    public function callController($ctrlName, $actionName, $params=[]): string
    {
        $classCtrl = 'Ctrl\\'.ucfirst($ctrlName);
        $action = $actionName.'Action';
        
        if(class_exists($classCtrl)) {
            $ctrlObject = new $classCtrl();
            if(method_exists($classCtrl, $action)) { 
                $return = $ctrlObject->$action($params);
                return $this->applyView($ctrlName, $actionName, $return??[]);
            } else {
                throw new \InvalidArgumentException("L'action $actionName n'existe pas");
            }
        } else {
            throw new \InvalidArgumentException("Le controller $ctrlName n'existe pas");
        }
    }

    public function applyView( string $ctrl, string $action, array $responseParams ): string
    {
        extract($responseParams);

        ob_start();
        $file = VIEW. strtolower($ctrl) . '/' . $action . '.phtml';
        if(!file_exists($file)) {
            throw new \InvalidArgumentException("Le fichier ".strtolower($ctrl) . '/' . $action . '.phtml'." n'existe pas");
            return '';
        }
        include $file;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function sendToLayout($params)
    {
        extract($params);
        include VIEW.'layout/layout.phtml';
    }
}
