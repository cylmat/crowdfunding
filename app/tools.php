<?php

/**
 * Inclus une url en fonction du controlleur
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
 * Redirection vers une url
 */
function redirect(string $url): void
{
    header('Status: 301 Moved Permanently', false, 301); 
    header('Location: '.$url);
    die();
}

/**
 * Evite les failles xss
 */
function write(string $txt)
{
    return htmlspecialchars($txt);
}

/**
 * Verifie si un user est loggé
 */
function is_logged()
{
    $id_user = \Classes\Session::get('id_user');
    $user = null!==$id_user ? \Classes\Session::get('user_name') : false;
    $logged = null!==$id_user ? true : false;
    return $logged;
}

/**
 * Vérifie si un user est admin
 */
function is_admin()
{
    $id_user = \Classes\Session::get('id_user');
    $user = null!==$id_user ? \Classes\Session::get('user_name') : false;
    $logged = null!==$id_user ? true : false;
    $admin = $logged ? (\Classes\Session::get('id_admin')?true:false) : false;
    //var_dump(\Classes\Session::get('is_admin'));
    return $admin;
}