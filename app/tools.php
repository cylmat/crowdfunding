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
 * Redirection
 */
function redirect(string $url): void
{
    header('Status: 301 Moved Permanently', false, 301); 
    header('Location: '.$url);
    die();
}

function is_logged()
{
    $id_user = \Classes\Session::get('id_user');
    $user = null!==$id_user ? \Classes\Session::get('user_name') : false;
    $logged = null!==$id_user ? true : false;
    return $logged;
}

function is_admin()
{
    $id_user = \Classes\Session::get('id_user');
    $user = null!==$id_user ? \Classes\Session::get('user_name') : false;
    $logged = null!==$id_user ? true : false;
    $admin = $logged ? (\Classes\Session::get('id_admin')?true:false) : false;
    //var_dump(\Classes\Session::get('is_admin'));
    return $admin;
}