<?php namespace professionalweb\models;

use professionalweb\contracts\PushNotificationResponse;

class PushResponse implements PushNotificationResponse, \JsonSerializable
{
    /**
     * Token
     *
     * @var string
     */
    private $token;

    /**
     * Status code
     *
     * @var string
     */
    private $statusCode;

    /**
     * Response message
     *
     * @var string
     */
    private $message;

    /**
     * Set token
     *
     * @param string $token
     * @return PushResponse
     */
    public function setToken(string $token) : PushResponse
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken() : string
    {
        return $this->token;
    }

    /**
     * Set status code
     *
     * @param string $code
     * @return PushResponse
     */
    public function setStatusCode(string $code): PushResponse
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * Get status code.
     *
     * @return string
     */
    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    /**
     * Set response message
     *
     * @param string $message
     * @return PushResponse
     */
    public function setMessage(string $message):PushResponse
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'token' => $this->getToken(),
            'statusCode' => $this->getStatusCode(),
            'message' => $this->getMessage()
        ];
    }
}