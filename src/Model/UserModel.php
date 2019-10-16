<?php

namespace Model;

class UserModel
{
    public static function getFormMessage($creation): string
    {
        $message = 'Une erreur est survenue pendant la création du compte';

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