<?php


namespace AppBundle\Config;

use Symfony\Component\Yaml\Yaml;

class PagesConfig
{

    /**
     * @var array;
     */
    private $config;

    public function __construct($file)
    {
        $this->config = Yaml::parse(file_get_contents($file));
    }

    /**
     * @param string $alias
     * @return PageConfigDTO|null
     */
    public function findPage($alias)
    {
        $config = $this->getConfig();

        return isset($config[$alias]) ? $config[$alias] : null;
    }

    /**
     * @return PageConfigDTO[]
     */
    private function getConfig()
    {
        $params = [];

        foreach ($this->config['pages'] as $alias => $value) {

            $params[$alias] = PageConfigDTO::fromArray($value);
        }

        return $params;
    }

}