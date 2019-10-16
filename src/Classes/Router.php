<?php declare(strict_types = 1);

namespace Classes;

class Router
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
}
