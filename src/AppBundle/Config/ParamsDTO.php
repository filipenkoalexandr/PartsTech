<?php


namespace AppBundle\Config;


class ParamsDTO
{
    protected $className;

    protected $url;

    private function __construct($className, $url)
    {
        $this->className = $className;
        $this->url = $url;
    }

    public static function fromArray($data)
    {
        return new self(
            $data['class'],
            $data['url']
        );
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}