<?php

namespace App\Libs\Zoop;

class Webhook implements \JsonSerializable
{
    protected $method;
    protected $url;
    protected $description;
    protected $event = [];
    protected $authorization;

    public function toJSON()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }

    public function jsonSerialize()
    {
        try {
            $obj = array(
                'method'        => $this->getMethod(),
                'url'           => $this->getUrl(),
                'description'   => $this->getDescription(),
                'event'         => $this->getEvent(),
                'authorization' => $this->getAuthorization(),
            );
            $vars_clear = array_filter($obj, function ($value) {
                if (is_array($value)) {
                    foreach ($value as $value2) {
                        return null !== $value2;
                    }
                } else {
                    return null !== $value;
                }
            });

            return $vars_clear;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     *
     * @return Webhook
     */
    public function setMethod($method)
    {
        $this->method = (string)$method;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     *
     * @return Webhook
     */
    public function setUrl($url)
    {
        $this->url = (string)$url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return Webhook
     */
    public function setDescription($description)
    {
        $this->description = (string)$description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     *
     * @return Webhook
     */
    public function setEvent($event)
    {
        $this->event = (array)$event;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param mixed $authorization
     *
     * @return Webhook
     */
    public function setAuthorization($authorization)
    {
        $this->authorization = (string)$authorization;

        return $this;
    }
}
