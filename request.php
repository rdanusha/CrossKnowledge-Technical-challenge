<?php

/**
 * Interface CacheInterface
 */
interface CacheInterface
{
    public function setValue(string $key, $value, int $duration);

    public function getValue(string $key);
}

/**
 * Class RedisCache
 */
class RedisCache implements CacheInterface
{
    private static $instance = null;
    private $host = '127.0.0.1';
    private $port = 6379;
    private $redis;

    /**
     * RedisCache constructor.
     */
    public function __construct()
    {
        $this->redis = new Redis();

        try {
            $this->redis->connect($this->host, $this->port);
        } catch (Exception $e) {
            echo 'Redis cache connection error: ', $e->getMessage(), "\n";
        }
    }

    /**
     * @return RedisCache
     */
    public static function getInstance(): RedisCache
    {
        if (self::$instance == null) {
            self::$instance = new RedisCache();
        }

        return self::$instance;
    }

    /**
     * @param string $key
     * @param $value
     * @param int $duration
     * @return mixed
     */
    public function setValue(string $key, $value, int $duration = 3600)
    {
        return $this->redis->setEx($key, $duration, $value);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getValue(string $key)
    {
        return $this->redis->get($key);
    }
}

class SimpleJsonRequest
{
    private $cache;
    private static $instance = null;

    /**
     * SimpleJsonRequest constructor.
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array|null $parameters
     * @param array|null $data
     * @return false|string
     */
    private function makeRequest(string $method, string $url, array $parameters = null, array $data = null)
    {
        $response = [];
        $opts = [
            'http' => [
                'method' => $method,
                'header' => 'Content-type: application/json',
                'content' => $data ? json_encode($data) : null
            ]
        ];

        $url .= ($parameters ? '?' . http_build_query($parameters) : '');

        $cachedData = $this->getCachedData($url, $method);
        if ($cachedData) {
            return $cachedData;
        }

        //if the given url is not in the cache we send the request and fetch data.
        $response = file_get_contents($url, false, stream_context_create($opts));

        //If response success add data in to the cache for future use
        if ($response) {
            $this->setCache($url, $response, $method);
        }
        //Send fetched data
        return $response;
    }

    /**
     * Get cache data
     * @param $key
     * @param $method
     * @return false
     */
    private function getCachedData($key, $method)
    {
        if ($method != 'GET') {
            return false;
        }
        //If it is GET method we check given url data is in the cache
        return $this->cache->getValue($key);
    }

    /**
     * Set Cache Data
     * @param $key
     * @param $value
     * @param $method
     */
    private function setCache($key, $value, $method)
    {
        if ($method == 'GET') {
            $this->cache->setValue($key, $value, 3600);
        }
    }

    public function get(string $url, array $parameters = null)
    {
        return json_decode(self::makeRequest('GET', $url, $parameters));
    }

    public function post(string $url, array $parameters = null, array $data)
    {
        return json_decode(self::makeRequest('POST', $url, $parameters, $data));
    }

    public function put(string $url, array $parameters = null, array $data)
    {
        return json_decode(self::makeRequest('PUT', $url, $parameters, $data));
    }

    public function patch(string $url, array $parameters = null, array $data)
    {
        return json_decode(self::makeRequest('PATCH', $url, $parameters, $data));
    }

    public function delete(string $url, array $parameters = null, array $data = null)
    {
        return json_decode(self::makeRequest('DELETE', $url, $parameters, $data));
    }
}

//Example GET:
$SimpleJsonRequest = new SimpleJsonRequest(RedisCache::getInstance());
$url = 'https://jsonplaceholder.typicode.com/posts';
$args = ['id' => 22];
$result = $SimpleJsonRequest->get($url, $args);
var_dump($result);
