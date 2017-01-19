<?php

/**
 * Api system
 */

require_once __DIR__ . '/../bootstrap.php';

class ApiEngine {

    protected $data;
    protected $config;
    protected $user;

    function __construct($data, $config) {
        $this->data = $data;
        $this->config = $config;
    }

    static function returnError($msg) {
        echo json_encode(array('result' => false, 'error' => $msg)); exit();
    }

    static function returnRedirect($msg = 'Require login', $redirect = '/login') {
        echo json_encode(array('redirect' => $redirect, 'msg' => $msg)); exit();
    }

    static function returnJson($data) {
        echo json_encode(array('result' => true, 'count' => count($data), 'data' => $data)); exit();
    }

    static function cleanRequest($className) {
        if (!preg_match('/([a-z0-9_]){1,10}/', $className, $math)) ApiEngine::returnError('Not correct request');
        if ($math[0] !== $className) ApiEngine::returnError('Not correct request');
    }

    static function checkAuth() {
        @session_start();
        if (array_key_exists('user', $_SESSION) && $_SESSION['user']) {
            return true;
        }
        self::returnRedirect();
    }

}

function __autoload($class_name) {
    preg_match_all('/[A-Z][^A-Z]*/', $class_name, $matches);
    $class = ''; foreach ($matches[0] as $key => $match) $class .= $key ? '_' . $match : $match;
    include __DIR__ . '/' . strtolower($class) . '.php';
}

$path = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$explodePath = explode('/', $path);

if ($explodePath[1] !== 'api') ApiEngine::returnError('Invalid request');
if (!array_key_exists(2, $explodePath)) ApiEngine::returnError('Invalid request');

$className = $explodePath[2];

ApiEngine::cleanRequest($className);

if (!file_exists(__DIR__ . '/' . $className . '.php')) ApiEngine::returnError('File ' . $className . ' not found');

$className = explode('_', $className);
$class = '';
foreach ($className as $namePath) {
    $class .= ucfirst($namePath);
}

if (!class_exists($class)) ApiEngine::returnError('Class ' . $class . ' not found');

$obj = new $class($data, $config);

$request = file_get_contents('php://input');
$data = json_decode($request);

$methodName = '_' . $method . '_' . str_replace(array('/api/', '/') , array('', '_'), $path);

if (!method_exists($obj, $methodName)) ApiEngine::returnError('Incorrect action ' . $methodName);

// TODO Refactoring this check actions
if ($methodName != '_POST_user_login' && $methodName != '_GET_user_logout') ApiEngine::checkAuth($methodName);

$obj->$methodName($data);
