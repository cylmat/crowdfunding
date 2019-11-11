<?php declare(strict_types = 1);

namespace Classes;

class Router
{
    const DEFAULT_CTRL='Home';
    const DEFAULT_ACTION='index';
    const PREG_URL='/^(\w\&?)*/'; //format ctrl&action&id

    public static function getRequest(): ?array
    {
        if(!isset($_SERVER['QUERY_STRING'])) { 
            return null;
        }
        
        $query = $_SERVER['QUERY_STRING'];
        if(!preg_match(self::PREG_URL, $query)) {
            return null;
        }
        
        $request = $_REQUEST;

        /*
         * Spécific ovh.net
         */
        if(array_key_exists('_ga',$request)) {
            unset($request['_ga']);
        }
        if(array_key_exists('PHPSESSID',$request)) {
            unset($request['PHPSESSID']);
        }
        //ovh
        
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
