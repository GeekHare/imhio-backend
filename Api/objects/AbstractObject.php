<?php
namespace Api\objects;
use Api\Messages;

/**
 * Class AbstractObject
 * @package Api\objects
 */
abstract class AbstractObject extends Messages {

    /**
     * Method type: POST, GET, PUT, DELETE, etc.
     * @var string
     */
    private $httpMethod;

    /**
     * A body from request
     * @var string (JSON)
     */
    protected $requestBody;

    /**
     * Information for working with the API object
     * @var array
     */
    private $endpointInfo = [
        "object" => "",
        "method" => "",
        "args" => "",
    ];

    /**
     * AbstractObject constructor.
     * @param string $http_method
     * @param array $endpoint_info
     * @param string $request_body
     */
    function __construct($http_method, $endpoint_info, $request_body) {
        $this->httpMethod   = $http_method;
        $this->endpointInfo = $endpoint_info;
        $this->requestBody  = $request_body;

        // Preparing a method name for call
        $method = $endpoint_info["method"] . "_" . strtolower($this->httpMethod);

        // Set headers
        header('Content-type:application/json; charset=UTF-8');
        header('Access-Control-Allow-Origin: ' . ACAO);

        // Processing OPTIONS method
        if ($this->httpMethod === "OPTIONS") {
            $method_options = $endpoint_info["method"] . "_options";

            if (method_exists($this, $method_options)) {
                $this->$method_options();
            } else $this->default_options(); return;
        }

        // Call method of the API object
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            $this->sendResponse([
                "error" => "Bad request"
            ], 400);
        }
    }

    /**
     * @param string $string
     * @return bool
     */
    protected function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Default method if request method type "OPTIONS"
     */
    protected function default_options() {
        header('Access-Control-Allow-Origin: ' . ACAO);
        header('Access-Control-Allow-Headers: content-type');
        header('Access-Control-Allow-Methods: POST, GET');
    }
}