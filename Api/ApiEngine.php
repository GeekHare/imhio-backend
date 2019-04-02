<?php
namespace Api;
use Api\objects\AbstractObject;

/**
 * Class ApiEngine
 * @package Api
 */
class ApiEngine extends Messages{

    /**
     * All allowed routes
     * @var array
     */
    private $allowedRoutes;

    /**
     * Method type: POST, GET, PUT, DELETE, etc.
     * @var string
     */
    private $httpMethod;

    /**
     * Request URI
     * @var string
     */
    private $requestUri;

    /**
     * A body from request
     * @var string (JSON)
     */
    private $requestBody;

    /**
     * API object to work with
     * @var AbstractObject
     */
    private $apiObject;

    /**
     * Information for working with the API object
     * @var array
     */
    private $preparedEndpointInfo = [
        "object" => "",
        "method" => "",
        "args" => "",
    ];

    /**
     * ApiEngine constructor.
     * @param string $request_uri - request URI
     * @param string $http_method - Method type: POST, GET, PUT, DELETE
     * @param string $body - A body from request (JSON)
     * @param array $allowed_routes - array all routes that are allowed
     */
    function __construct($request_uri, $http_method, $body, $allowed_routes) {
        $this->requestUri       = $request_uri;
        $this->requestBody      = $body;
        $this->httpMethod       = $http_method;
        $this->allowedRoutes    = $allowed_routes;
    }

    /**
     * Processing API
     */
    public function run() {
        // Parse url
        if ($this->parseRequestUri()) {
            if ($this->existApiObject()) {
                $this->loadApiObject();
            } else {
                $this->sendResponse([
                    "error" => "Internal server error"
                ], 500); // Bad request
            }
        } else {
            $this->sendResponse([
                "error" => "Bad request"
            ], 400); // Bad request
        }
    }

    /**
     * Load API object
     */
    private function loadApiObject() {
        $class = "Api\objects\\".ucfirst($this->preparedEndpointInfo["object"]);
        $this->apiObject = new $class($this->httpMethod, $this->preparedEndpointInfo, $this->requestBody);
    }

    /**
     * Find object class in folder "objects"
     * @return bool
     */
    private function existApiObject() {
        return file_exists(__DIR__ . "/objects/" . ucfirst($this->preparedEndpointInfo["object"]) . ".php");
    }

    /**
     * Parse URI and prepare endpoint info for working with the API object
     * @return bool
     */
    private function parseRequestUri() {
        $data = array_values(array_filter(explode("/", $this->requestUri)));
        if (is_array($data) AND !empty($data) AND key_exists($data[0] . "/" . $data[1], $this->allowedRoutes)) {
            $this->preparedEndpointInfo["object"] = @$data[0];
            $this->preparedEndpointInfo["method"] = @$data[1];
            $this->preparedEndpointInfo["args"] = @$data[2];
            return TRUE;
        } else return FALSE;
    }
}