<?php
namespace Api;

/**
 * Class Messages
 * @package Api
 */
class Messages {
    /**
     * Send response
     * @param array $data
     * @param int $http_code
     */
    protected function sendResponse($data, $http_code = 200) {
        $data = array_merge($data, [ "code" => $http_code ]);
        http_response_code($http_code);
        echo json_encode($data);
    }
}