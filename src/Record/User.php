<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;

class User extends Record
{
    /*
     * Connection
     */
    protected $login, $password;

    /*
     * Informations légales
     */
    protected $civilite, $nom, $prenom;

    /*
     * Titre (Dr, employé, autoentrepreneur...)
     */
    protected $titre, $emploi;

    /*
     * Localisation
     */
    protected $ville;
}
