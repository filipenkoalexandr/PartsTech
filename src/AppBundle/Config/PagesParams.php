<?php


namespace AppBundle\Config;

use Symfony\Component\Yaml\Yaml;

class PagesParams
{

    const CONF_FILE = __DIR__ . '/stylus_pages_params.yml';

    /**
     * @var ParamsDTO[];
     */
    private $pages;

    public function __construct()
    {
        $this->pages = $this->getConfig();
    }

    /**
     * @param $alias
     * @return ParamsDTO|null
     */
    public function findPage($alias)
    {
        return isset($this->pages[$alias])?$this->pages[$alias]:null;
    }

    /**
     * @return ParamsDTO[]
     */
    private function getConfig()
    {
        $config = Yaml::parse(file_get_contents(self::CONF_FILE));
        $params = [];
        foreach ($config['pages'] as $alias => $value){
               $params[$alias] = ParamsDTO::fromArray($value);
        }

        return $params;
    }

}