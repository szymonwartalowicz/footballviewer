<?php

class AbstractHttp 
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const CONTENT_TYPE_HTML = 'text/html';
    const CONTENT_TYPE_JSON = 'application/json';
    const CONTENT_TYPE_FORM_URL_ENCODED =
    'application/x-www-form-urlencoded';
    const HEADER_CONTENT_TYPE = 'Content-Type';
    const TRANSPORT_HTTP = 'http';
    const TRANSPORT_HTTPS = 'https';
    const STATUS_200 = '200';
    const STATUS_401 = '401';
    const STATUS_500 = '500';
    
    protected $uri;
    protected $method;
    protected $headers;
    protected $cookies;
    protected $metaData;
    protected $transport; 
    protected $data = array();

    // setters
    public function setUri($uri, array $params = NULL)
    {
        $this->uri = $uri;
        $first = TRUE;
        if ($params) 
        {
            $this->uri .= '?' . http_build_query($params);
        }
    }

    public function setMethod($method) 
    {
        $this->method = $method;
    }

    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function setMetaData($metadata)
    {
        $this->metaData = $metadata;
    }

    public function setTransport($transport = NULL)
    {
        if ($transport) 
        {
            $this->transport = $transport;
        }
        else 
        {
            if (substr($this->uri, 0, 5) == self::TRANSPORT_HTTPS) 
            {
                $this->transport = self::TRANSPORT_HTTPS;
            } 
            else 
            {
                $this->transport = self::TRANSPORT_HTTP;
            }
        }
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    // getters 
    public function getUri()
    {
        return $this->uri ?? NULL;
    }

    public function getMethod()
    {
        return $this->method ?? self::METHOD_GET;
    }

    public function getHeaders()
    {
        return $this->headers ?? NULL;
    }

    public function getCookies()
    {
        return $this->cookies ?? NULL;
    }

    public function getMetaData()
    {
        return $this->metaData ?? NULL;
    }

    public function getTransport()
    {
        return $this->transport ?? self:: TRANSPORT_HTTP;
    }
    
    public function getData()
    {
        return $this->data ?? array();
    }

    public function getDataEncoded()
    {
        return http_build_query($this->getData());
    }
}
?>