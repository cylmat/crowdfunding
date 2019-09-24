<?php

function url(string $url, array $params=[]): string
{
    if(!preg_match('/\w+\w+/',$url)) {
        return '';
    } 
    return "?".str_replace('_','&',$url).($params?'&'.http_build_query($params):'');
}

function redirect($url)
{
    header('Status: 301 Moved Permanently', false, 301); 
    header('Location: '.$url);
    die();
}