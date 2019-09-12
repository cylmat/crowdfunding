<?php

function url(string $url, array $params=[]): string
{
    if(!preg_match('/\w+\w+/',$url)) {
        return '';
    } 
    return "?".str_replace('_','&',$url).($params?'&'.http_build_query($params):'');
}