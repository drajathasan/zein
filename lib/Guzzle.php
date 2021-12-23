<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-12-21 15:00:20
 * @modify date 2021-12-21 15:00:20
 * @license GPLv3
 * @desc [description]
 */

namespace Zein;

class Guzzle extends \GuzzleHttp\Client
{
    private $Result = ['status' => true, 'client' => __CLASS__, 'error' => ''];
    private $Body = '';

    public function download(string $Url, string $DestinationSavePath, int $Timeout = 300)
    {
        try {
            $this->request('GET', $Url, ['sink' => $DestinationSavePath]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->Result = ['status' => false, 'client' => __CLASS__, 'error' => $e->getMessage()];
        }

        return $this;
    }

    public function pull($Url, array $Options = array())
    {
        try {
            $this->Body = $this->get($Url, $Options)->getBody();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->Result = ['status' => false, 'client' => __CLASS__, 'error' => $e->getMessage()];
        }

        return $this;
    }

    public function getContents()
    {
        return is_object($this->Body) ? $this->Body->getContents() : $this;
    }

    public function getResult(string $Index = '')
    {
        return $this->Result[$Index]??$this->Result;
    }

    public function close()
    {
        is_object($this->Body) ? $this->Body->close() : $this;
    }
}