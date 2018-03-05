<?php

/**
 * Class Router
 */
class Router
{
    /**
     * @var string
     */
    private $request;

    /**
     * Router constructor.
     *
     * @param string $request
     */
    public function __construct(string $request)
    {
        $this->request = $request;
    }

    /**
     * Routing.
     */
    public function get()
    {
        $uri = trim($this->request, "/");
        $uri = explode("/", $uri);
        $method = $_SERVER['REQUEST_METHOD'];
        $response = [];

        if ($uri[0] == 'addresses') {
            array_shift($uri);
            $url_array = explode('/', $_SERVER['REQUEST_URI']);
            array_shift($url_array);

            require_once 'src\Controller\MainController.php';

            $mc = new src\Controller\MainController();

            if ($method == 'GET') {
                if (!isset($url_array[1])) {

                    $data = $mc->getAll();

                    $response['status'] = 200;
                    $response['data'] = $data;
                } else {

                    $id = $url_array[1];
                    $data = $mc->getById((int) $id);

                    if (empty((array) $data)) {
                        $response['status'] = 404;
                        $response['data'] = array('error' => 'Entity not found');
                    } else {
                        $response['status'] = 200;
                        $response['data'] = $data;
                    }
                }
            } elseif ($method == 'POST') {
                $json = file_get_contents('php://input');
                $post = json_decode($json);

                if (!$post->label || !is_string($post->label)
                    || !$post->street || !is_string($post->street)
                    || !$post->houseNumber || !is_int($post->houseNumber)
                    || !$post->postalCode || !is_int($post->postalCode)
                    || !$post->city || !is_string($post->city)
                    || !$post->country || !is_string($post->country)
                ) {
                    $response['status'] = 400;
                    $response['data'] = array('error' => 'Something went wrong');
                } else {
                    $status = $mc->create();

                    if ($status == 1) {
                        $response['status'] = 201;
                        $response['data'] = array('success' => 'Success');
                    } else {
                        $response['status'] = 400;
                        $response['data'] = array('error' => 'Something went wrong');
                    }
                }
            } elseif ($method == 'PUT') {
                if (isset($url_array[1])) {
                    $id = $url_array[1];
                    $data = $mc->getById((int) $id);

                    if (empty((array) $data)) {
                        $response['status'] = 404;
                        $response['data'] = array('error' => 'Something went wrong');
                    } else {
                        $json = file_get_contents('php://input');
                        $post = json_decode($json);

                        if (!$post->label || !is_string($post->label)
                            || !$post->street || !is_string($post->street)
                            || !$post->houseNumber || !is_int($post->houseNumber)
                            || !$post->postalCode || !is_int($post->postalCode)
                            || !$post->city || !is_string($post->city)
                            || !$post->country || !is_string($post->country)
                        ) {
                            $response['status'] = 400;
                            $response['data'] = array('error' => 'Something went wrong');
                        } else {
                            $status = $mc->update((int) $id);

                            if ($status == 1) {
                                $response['status'] = 200;
                                $response['data'] = array('success' => 'Success');
                            } else {
                                $response['status'] = 400;
                                $response['data'] = array('error' => 'Something went wrong');
                            }
                        }
                    }
                }
            } elseif ($method == 'DELETE') {
                if (isset($url_array[1])) {
                    $id = $url_array[1];
                    $data = $mc->getById($id);

                    if (empty((array) $data)) {
                        $response['status'] = 404;
                        $response['data'] = array('error' => 'Something went wrong');
                    } else {
                        $status = $mc->delete($id);

                        if ($status == 1) {
                            $response['status'] = 200;
                            $response['data'] = array('success' => 'Success');
                        } else {
                            $response['status'] = 400;
                            $response['data'] = array('error' => 'Something went wrong');
                        }
                    }
                }
            }
        }

        self::returnResponse($response);
    }

    static function returnResponse($response)
    {
        $http_response_code = array(
            200 => 'OK',
            201 => 'Created',
            400 => 'Bad Request',
            404 => 'Not Found',
        );

        header('HTTP/1.1 ' . $response['status'] . ' ' . $http_response_code[$response['status']]);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($http_response_code[$response['status']]);
        exit;
    }
}