<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-22 08:05:43
 * @modify date 2021-12-22 08:05:43
 * @license GPLv3
 * @desc [description]
 */

namespace Zein;

class Fetch
{
    private $Result = ['status' => true, 'client' => __CLASS__, 'error' => ''];
    private $Contents = '';
    private $Header = '';
    private $StreamOptions = [];

    public function __construct()
    {
        $this->setStreamOptions();
    }

    public function setStreamOptions(array $Options = [])
    {
        $this->StreamOptions = [
            'http' => [
                'method'=> "GET",
                'timeoute' => 10,
                'user_agent'=> $_SERVER['HTTP_USER_AGENT']
            ]
        ];

        if (count($Options))
        {
            $this->StreamOptions = $Options;
        }

        return $this;
    }

    public function getContents()
    {
        return $this->Contents;
    }

    public function getHeader()
    {
        return $this->Header;
    }

    private function handleError()
    {
        set_error_handler(
            function ($severity, $message, $file, $line) {
                throw new \ErrorException(trim($message), $severity, $severity, $file, $line);
            }
        );
    }

    public function pull(string $Url)
    {
        $this->handleError();
        $context = stream_context_create($this->StreamOptions);

        try {
            $UrlAccess = file_get_contents($Url, false, $context);

            $this->Header = $http_response_header;
            $this->Contents = $UrlAccess;
        } catch (\Exception $e) {
            $this->Result = ['status' => false, 'client' => __CLASS__, 'error' => $e->getMessage()];
        }

        restore_error_handler();
        return $this;
    }

    public function download(string $Url, string $DestinationSavePath)
    {
        $this->handleError();
        $context = stream_context_create($this->StreamOptions);

        try {
            $UrlAccess = @file_get_contents($Url, false, $context);

            if (!$UrlAccess)
            {
                throw new \Exception($UrlAccess);
            }

            $this->Header = $http_response_header;
            $this->Contents = $UrlAccess;
            file_put_contents($DestinationSavePath, $UrlAccess);

        } catch (\Exception $e) {
            $this->Result = ['status' => false, 'client' => __CLASS__, 'error' => $e->getMessage()];
        }

        restore_error_handler();
        return $this;
    }

    public function getResult()
    {
        zdd($this->Result);
    }

    public function close()
    {}
}