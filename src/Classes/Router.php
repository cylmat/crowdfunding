<?php declare(strict_types = 1);

namespace Classes;

/**
 * Class de routage
 * 
 * Empêche toute requête qui n'est pas du texte alphanum 
 */
class Router
{
    const DEFAULT_CTRL='Home';
    const DEFAULT_ACTION='index';
    const PREG_URL='/^(\w\&?)*/'; //format ctrl&action&id

    /**
     * Recupère la requête
     */
    public static function getRequest(): ?array
    {
        if(!isset($_SERVER['QUERY_STRING'])) { 
            return null;
        }
        
        /**
         * Verifie la conformité
         */
        $query = $_SERVER['QUERY_STRING'];
        if(!preg_match(self::PREG_URL, $query)) {
            return null;
        }
        
        $request = $_REQUEST;

        /*
         * Spécific ovh.net issue
         * Enlève les requêtes incorrectes
         */
        if(array_key_exists('_ga',$request)) {
            unset($request['_ga']);
        }
        if(array_key_exists('PHPSESSID',$request)) {
            unset($request['PHPSESSID']);
        }
        //-ovh
        
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
        
        //params si il y en a
        if(key($request)) {
            $params = $request;
        }

        //set resutat
        $request = [
            'ctrl'=>$ctrl,
            'action'=>$action,
            'params'=>$params
        ];
        return $request;
    }
}
