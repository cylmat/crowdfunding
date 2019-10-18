<?php declare(strict_types = 1);

namespace Classes;

use Ctrl\Layout;
use Classes\Router;

class App
{
    /**
     * Request value with controller
     * action and params if any
     * 
     * @var array
     */
    private $request;

    public function __construct()
    {
        $this->run();
    }

    /**
     * Run the application
     */
    public function run(): void
    {
        //get query request
        if(null === ($request = Router::getRequest())) {
            return;
        }
        
        $ctrlName = $request['ctrl'];
        $actionName = $request['action'];
        $params = $request['params'];

        $header = $this->callController('layout', 'header', $params);
        $banner = $this->callController('layout', 'banner', $params);
        $content = $this->callController($ctrlName, $actionName, $params);
        $footer = $this->callController('layout', 'footer', $params);
        
        $this->sendToLayout(['header'=>$header, 'content'=>$content, 'banner'=>$banner, 'footer'=>$footer]);
    }

    /**
     * Call controller and view
     */
    public function callController($ctrlName, $actionName, $params=[]): string
    {
        $classCtrl = 'Ctrl\\'.ucfirst($ctrlName).'Ctrl';
        $action = $actionName.'Action';
        
        if(class_exists($classCtrl)) {
            $ctrlObject = new $classCtrl();
            //ex: UpdateAction()
            if(method_exists($classCtrl, $action)) { 
                $return = $ctrlObject->$action($params);
                return $this->applyView($ctrlName, $actionName, $return??[]);
            } elseif(method_exists($classCtrl, $actionName)) { 
                //ex: update()
                $return = $ctrlObject->$actionName($params);
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

    public function applyView( string $ctrl, string $action, array $responseParams ): string
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

    public function sendToLayout($params)
    {
        extract($params);
        include VIEW.'layout/layout.phtml';
    }
}
