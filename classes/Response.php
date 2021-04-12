<?php


namespace app\classes;


use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class Response {

    protected static $instance;

    public static function getInstance(){
        if (!isset($instance))  self::$instance = new Response();
        return self::$instance;
    }


    /**
     * Handle sending of response - json vs view
     * @param $url
     * @param array $data
     * @param int $status
     * @throws Exception
     */
    public function send($url, $data = [], $status = 200){
        $request = Request::getInstance();
        if ($request->isApi()) {
            $this->json($data, $status);
        } else {
            if (empty($url)) throw new Exception('Template not specified');
            $this->render($url, $data, $status);
        }
    }

    /**
     * @param string $template
     * @param array $data
     * @param int $status
     */
    public function render($template, $data = [], $status = 200) {
        $templateDir = __DIR__.'/../templates';
        $loader = new FilesystemLoader([$templateDir, $templateDir.'/admin']);
        $twig = new Environment($loader, ['debug' => true]);
        $twig->addGlobal('_get', $_GET);
        $twig->addExtension(new DebugExtension());
        echo $twig->render("$template.twig", $data);
    }

    /**
     * Redirect
     * @param string $url
     */
    public function redirect($url) {
        $request = Request::getInstance();
        if ($request->isApi()) {
            $this->json([], 302);
        } else {
            header("Location: " . $url);
            exit;
        }
    }

    /**
     * Send response as JSON
     * @param array $data
     * @param int $status
     */
    public function json($data, $status = 200) {
        header('Content-type: application/json', true, $status);
        echo json_encode($data);
        exit;
    }

    /**
     * Send error response
     * @param Exception $e
     */
    public function error($e) {
        $data = ['errors' => [
            'status' => $e->getCode(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]];
        $this->send('error', $data, $e->getCode());
    }

}
