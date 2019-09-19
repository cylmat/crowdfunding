<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;

class Project extends Record
{
    protected $title, $description, $fk_id_user;
}
