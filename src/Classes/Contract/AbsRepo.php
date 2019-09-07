<?php

namespace Classes\Contract;

use Classes\Contract\AbsEntity;

abstract class AbsRepo extends Database
{
    /* herited */
    protected $db;

    public function __construct( AbsEntity $entity )
    {

    }

    public function create()
    {

    }
}