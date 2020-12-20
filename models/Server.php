<?php
    include_once 'Request.php';
    include_once 'Response.php';
    include_once 'UserApi.php';

    class Server
    {
        protected $api;

        public function __construct(UserApi $api)
        {
            $this->api = $api;
        }

        public function listen()
        {
            $request = new Request();
            $response = new Response();
            $getPost = $_REQUEST ?? array();
            $jsonData = json_decode(
                file_get_contents('php://input'),true);
            $jsonData = $jsonData ?? array();
            $request->setData(array_merge($getPost,$jsonData));

            switch(strtoupper($request->getMethod())) 
            {
                case Request::METHOD_POST :
                    $this->api->post($request, $response);
                    break;
                case Request::METHOD_PUT :
                    $this->api->put($request, $response);
                    break;
                case Request::METHOD_DELETE :
                    $this->api->delete($request, $response);
                    break;
                case Request::METHOD_GET :
                    $this->api->get($request, $response);
                default:
                    

            }
            echo json_encode($response->getData());
        }
    }
?>