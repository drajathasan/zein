<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-11-05 20:03:05
 * @modify date 2021-12-05 20:14:28
 * @desc [description]
 */

namespace Zein;

class Http
{
    private static $Instance = null;
    private $header;
    private $body;
    private $HttpQuery;
    private $error;

    private function __construct()
    {
    }
    
    public function getRequest()
    {
        $this->header = getallheaders();
        $this->body = json_decode(@file_get_contents('php://input'), true);
        $this->HttpQuery = $_GET;
    }

    public function getHeader(string $Key = '')
    {
        return (isset($this->header[$Key]) && !empty($Key)) ? $this->header[$Key] : $this->header ;
    }

    public function getBody(string $Key = '')
    {
        return (isset($this->body[$Key]) && !empty($Key)) ? $this->body[$Key] : $this->body ;
    }

    public function getQuery(string $Key = '')
    {
        return (isset($this->HttpQuery[$Key]) && !empty($Key)) ? $this->HttpQuery[$Key] : $this->HttpQuery ;
    }

    public function getPath($callback = '')
    {
        if (!isset($_SERVER['PATH_INFO'])) return NULL;

        $WebPath = explode('/', trim($_SERVER['PATH_INFO'], '/'));

        if (count($WebPath) > 0 && is_callable($callback)) $callback(array_slice($WebPath, 1)); exit;

        return $WebPath;
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function setHeader(string $content)
    {
        header($content);
    }

    public function isBodyError()
    {
        $JsonErrorMsg = json_last_error_msg();
        if (!empty($JsonErrorMsg) && $JsonErrorMsg !== 'No error')
        {
            $this->error = json_last_error_msg();
            return true;
        }

        return false;
    }

    public function getError()
    {
        return $this->error;
    }

    public static function responseJson($mixData, $exit = true)
    {
        self::setHeader('Content-Type: application/json');
        echo json_encode($mixData);
        if ($exit) exit;
    }

    public static function getInstance()
    {
        if (is_null(self::$Instance))
        {
            self::$Instance = new Http();
        }

        return self::$Instance;
    }
}