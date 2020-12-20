<?php
    include_once 'AbstractHttp.php';

    class Response extends AbstractHttp
    {
        public $status;

        public function __construct(
            Request $request = NULL,
            $status = NULL,
            $contentType = NULL
        )
        {
            if($request)
            {
                $this->uri = $request->getUri();
                $this->data = $request->getData();
                $this->method = $request->getMethod();
                $this->cookies = $request->getCookies();
                $this->setTransport();
            }
            if($status)
            {
                $this->setStatus($status);
            }
        }
        public function setStatus($status)
        {
            $this->status = $status;
        }

        public function getStatus()
        {
            return $this->status;
        }
    }
?>