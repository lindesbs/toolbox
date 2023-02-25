<?php

namespace lindesbs\contaotoolbox\Classes;

class DCA
{
    private Config $config;
    private array $list;
    private array $palettes;
    private array $subpalettes;

    private Fields $fields;

    public function __construct()
    {
        $this->setConfig(new Config());

        $this->getConfig()->setDataContainer(Config::DC_TABLE);
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function load(array $arrData)
    {
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param array $list
     */
    public function setList(array $list): void
    {
        $this->list = $list;
    }

    /**
     * @return array
     */
    public function getPalettes(): array
    {
        return $this->palettes;
    }

    /**
     * @param array $palettes
     */
    public function setPalettes(array $palettes): void
    {
        $this->palettes = $palettes;
    }

    /**
     * @return array
     */
    public function getSubpalettes(): array
    {
        return $this->subpalettes;
    }

    /**
     * @param array $subpalettes
     */
    public function setSubpalettes(array $subpalettes): void
    {
        $this->subpalettes = $subpalettes;
    }

    /**
     * @return Fields
     */
    public function getFields(): Fields
    {
        return $this->fields;
    }

    /**
     * @param Fields $fields
     */
    public function setFields(Fields $fields): void
    {
        $this->fields = $fields;
    }


}