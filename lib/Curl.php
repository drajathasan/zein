<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-21 14:12:17
 * @modify date 2021-12-21 14:12:17
 * @license GPLv3
 * @desc [description]
 */

namespace Zein;

class Curl
{
    private $Init = '';
    private $Result = [];
    private $Response = '';

    public function __construct()
    {
        $this->Init = curl_init();
    }

    public function setOption()
    {
        if (func_num_args() > 1)
        {
            curl_setopt($this->Init, func_get_args()[0], func_get_args()[1]);
        }
        else
        {
            curl_setopt_array($this->Init, func_get_args()[0]);
        }
        return $this;
    }

    public function getResult()
    {
        return $this->Result;
    }

    public function getHeader()
    {
        return substr($this->Response, 0, curl_getinfo($this->Init, CURLINFO_HEADER_SIZE));
        
    }

    public function getContents()
    {
        return substr($this->Response, curl_getinfo($this->Init, CURLINFO_HEADER_SIZE));
    }

    public function getStatusCode()
    {
        return curl_getinfo($this->Init, CURLINFO_HTTP_CODE);
    }

    public function getGet(string $Url)
    {
        $Option = [
            CURLOPT_URL => $Url,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT']
        ];

        $this->setOption($Option)->exec();

        return $this;
    }

    public function download(string $Url, string $DestinationSavePath, int $Timeout = 300)
    {
        $Source = fopen($DestinationSavePath, 'w');
        $Option = [
            CURLOPT_URL => $Url,
            CURLOPT_FAILONERROR => true,
            CURLOPT_HEADER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_TIMEOUT => $Timeout,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_FILE => $Source
        ];
        
        $this->setOption($Option)->exec();

        return $this;
    }

    public function exec()
    {
        $Prosess = curl_exec($this->Init);
        $Status = $Prosess ? true : false;
        $this->Result = ['status' => $Status, 'client' => __CLASS__, 'error' => curl_error($this->Init)];

        if ($Status)
        {
            $this->Response = $Prosess;
        }

        return $this;
    }

    public function close()
    {
        curl_close($this->Init);
    }
}