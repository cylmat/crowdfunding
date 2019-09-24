<?php

namespace Model;

class User
{
    public static function getFormMessage($creation): string
    {
        $message = '';

        switch($creation){
            case 'already_exists': 
                $message = "L'utilisateur existe déjà"; 
                break;

            case true: 
                $message = "L'utilisateur à bien été créé"; 
                break;
        }
        return $message;
    }
}