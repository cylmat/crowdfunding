<?php

/**
 * url('controller_action')
 */
function url(string $url, array $params=[]): string
{
    if(!preg_match('/\w+\w+/',$url)) {
        return '/';
    } 
    return "?".str_replace('_','&',$url).($params?'&'.http_build_query($params):'');
}

/**
 * REdirection
 */
function redirect(string $url): void
{
    header('Status: 301 Moved Permanently', false, 301); 
    header('Location: '.$url);
    die();
}