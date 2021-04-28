<?php

namespace Src\Helpers;

class Utils
{
    /**
     * Get form Data.
     *
     * @param string $method
     * @return array
     */
    public static function getFormData(string $method): array
    {
        if ($method === 'GET') {
            $data = $_GET;
        } elseif ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
        } else { // PUT, PATCH or DELETE
            $data = [];
            $exploded = explode('&', file_get_contents('php://input'));

            foreach ($exploded as $pair) {
                $item = explode('=', $pair);
                if (count($item) === 2) {
                    $data[urldecode($item[0])] = urldecode($item[1]);
                }
            }
        }

        return $data;
    }

    /**
     * Throw Http Error.
     *
     * @param $code
     * @param $message
     */
    public static function throwHttpError($code, $message)
    {
        header('HTTP/1.0 400 Bad Request'); //will be dynamic
        header('Content-Type: application/json');

        echo json_encode(['code' => $code, 'message' => $message]);
        exit;
    }
}
