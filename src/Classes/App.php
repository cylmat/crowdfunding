<?php declare(strict_types = 1);

namespace Classes;

use Ctrl\Layout;
use Classes\Router;

/**
 * Class Application
 * 
 * Charge l'application, appel le routeur et redirige vers le bon controleur 
 * Affiche ensuite le template correspondant
 */
class App
{
    /**
     * 
     * @var array
     */
    private $request;

    public function __construct()
    {
        $this->run();
    }

    /**
     * Charge l'application
     */
    private function run(): void
    {
        //Requete Query
        if(null === ($request = Router::getRequest())) {
            return;
        }

        $ctrlName = $request['ctrl'];
        $actionName = $request['action'];
        $params = $request['params'];

        /**
         * Appel les controleurs correspondants
         */
        $header = $this->callController('layout', 'header', $params);
        $banner = $this->callController('layout', 'banner', $params);
        $content = $this->callController($ctrlName, $actionName, $params);
        $footer = $this->callController('layout', 'footer', $params);

        $this->sendToLayout(['header'=>$header, 'content'=>$content, 'banner'=>$banner, 'footer'=>$footer]);
    }

    /**
     * Appel le controleur et la vue
     */
    private function callController($ctrlName, $actionName, $params=[]): string
    {
        $classCtrl = 'Ctrl\\'.ucfirst($ctrlName).'Ctrl';
        $action = $actionName.'Action';

        if(class_exists($classCtrl)) {
            $ctrlObject = new $classCtrl();
            //ex: UpdateAction()
            if(method_exists($classCtrl, $action)) { 

                $return = $ctrlObject->$action($params);
                if(null === $return) return '';
                return $this->applyView($ctrlName, $actionName, $return??[]);
            } else {
                //throw new \InvalidArgumentException("L'action $actionName n'existe pas");
                redirect(url(''));
            }
        } else {

            //throw new \InvalidArgumentException("Le controller $ctrlName n'existe pas");
            redirect(url(''));
        }
    }

    /**
     * Charge la vue correspondante au controleur
     */
    private function applyView( string $ctrl, string $action, array $responseParams ): string
    {
        extract($responseParams);
        $post = $_POST;

        ob_start();
        $file = VIEW. strtolower($ctrl) . '/' . $action . '.phtml';
        if(!file_exists($file)) {
            throw new \InvalidArgumentException("Le fichier ".strtolower($ctrl) . '/' . $action . '.phtml'." n'existe pas");
            return '';
        }
        include $file;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * Inclus le layout
     */
    private function sendToLayout($params)
    {
        extract($params);
        include VIEW.'layout/layout.phtml';
    }
}
