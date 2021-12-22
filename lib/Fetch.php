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
    private $Result = ['status' => true, 'client' => __CLASS__, 'message' => ''];

    public function get(string $Url)
    {
        
    }

    public function download(string $Url, string $DestinationSavePath, int $Timeout = 300)
    {
        $streamOption = [
            'http' => [
                'method'=> "GET",
                'user_agent'=> $_SERVER['HTTP_USER_AGENT']
            ]
        ];

        $context = stream_context_create($streamOption);

        try {
            $UrlAccess = fopen($Url, 'r', false, $context);

            if (!$UrlAccess)
            {
                throw new \Exception();
            }

            file_put_contents($DestinationSavePath, $UrlAccess);

            fclose($UrlAccess);
        } catch (\Exception $e) {
            $this->Result = ['status' => false, 'client' => __CLASS__, 'error' => $e->getMessage()];
        }

        return $this;
    }

    public function getResult()
    {
        zdd($this->Result);
    }
}