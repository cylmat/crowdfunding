<?php declare(strict_types = 1);

namespace Classes;

/**
 * Usage:
 * Html::a(['href'=>'url/']); render <a href="url/">
 * Html::close_a(); render </a>
 * Html::input(['data'=>'id'], true); render <input data='id'/>
 * 
 * Html::link(['content', 'alpha'=>'display']); render <link alpha="display">content</link>
 */

 /** 
  * Html
  */
class Html
{
    static function __callStatic(string $balise, array $params): void
    {
        //invalid arguments
        if(count($params)>2) {
            throw new \InvalidArgumentException("Expected less than 3 arguments");
        }

        //balise name
        $balise = filter_var($balise, FILTER_SANITIZE_STRING);
        
        //close
        if(preg_match("/^close_(.+)/",$balise,$match)) {
            $render = '</'.$match[1].'>';
            echo $render;
            return;
        }

        $render = '<'.$balise;

        //attributs
        if(is_array($params[0])) {
            $attributs = $params[0];
        
            foreach($attributs as $att=>$val) {
                //skip content
                if(0===$att) continue;
    
                $render .= " $att=\"$val\" ";
            }    
        }

        //close
        if(isset($params[1]) && $params[1]===true) {
            $render .= '/';    
        }

        $render .= '>';

        //if content display and close
        if(isset($params[0][0]) && is_string($params[0][0])) {
            $render .= $params[0][0];
            $render .= '</' . $balise . '>';
        }

        echo $render;
    } 
}