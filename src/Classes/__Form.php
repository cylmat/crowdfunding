<?php declare(strict_types = 1);

namespace Classes;

/**
 * Usage:
 * Form::create([
 *   'action'=>'#'
 *  'balises'=>[ 
 *      'input'=>['type'=>'text', 'placeholder'=>'']
 *  ]
 * ]);
 */

 /** 
  * Form
  */
class Form
{
    static function create(array $params): void
    {
        $form = '<form ';

        if(!isset($params['action']) || !is_string($params['action'])) {
            throw new \InvalidArgumentException('Action inexistante');
        }

        $form .= ' action="'.$params['action'].'"';
    } 

    static function balises(): string
    {

    }
}