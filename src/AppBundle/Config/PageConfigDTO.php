<?php


namespace AppBundle\Config;


class PageConfigDTO
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $configurations;

    private function __construct($className, $url, $configurations)
    {
        $this->className = $className;
        $this->url = $url;
        $this->configurations = $configurations;

    }

    public static function fromArray($data)
    {
        return new self(
            $data['class'],
            $data['url'],
            $data['configurations']
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

    /**
     * @return array
     */
    public function getConfigurations()
    {
        return $this->configurations;
    }
}