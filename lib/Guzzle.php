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

    public function getGet($Url, array $Options = array())
    {
        $this->Body = $this->get($Url, $Options)->getBody();
        return $this;
    }

    public function getContents()
    {
        return $this->Body->getContents();
    }

    public function getResult()
    {
        zdd($this->Result);
    }
}