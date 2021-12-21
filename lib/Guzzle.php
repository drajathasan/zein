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
    private $Result = ['status' => true, 'error' => ''];

    public function download(string $Url, string $DestinationSavePath, int $Timeout = 300)
    {
        try {
            $this->request('GET', $Url, ['sink' => $DestinationSavePath]);
        } catch (Guzzle\Http\Exception\BadResponseException $e) {
            $this->Result = ['status' => false, 'error' => $e->getMessage()];
        }

        return $this;
    }

    public function getResult()
    {
        zdd($this);
    }
}