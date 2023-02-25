<?php

namespace lindesbs\toolbox\Classes;

class Config
{

    public const DC_TABLE = "DC_Table";
    private string $dataContainer;
    private string $ptable;
    private array $ctable;

    private bool $switchToEdit;
    private bool $enableVersioning;
    private string $markAsCopy;

    /** @var array<CallbackArray> */
    private array $onload_callback;
    private array $sql;

    private array $ondelete_callback;

    /**
     * @return string
     */
    public function getDataContainer(): string
    {
        return $this->dataContainer;
    }

    /**
     * @param string $dataContainer
     */
    public function setDataContainer(string $dataContainer): void
    {
        $this->dataContainer = $dataContainer;
    }

    /**
     * @return string
     */
    public function getPtable(): string
    {
        return $this->ptable;
    }

    /**
     * @param string $ptable
     */
    public function setPtable(string $ptable): void
    {
        $this->ptable = $ptable;
    }

    /**
     * @return array
     */
    public function getCtable(): array
    {
        return $this->ctable;
    }

    /**
     * @param array $ctable
     */
    public function setCtable(array $ctable): void
    {
        $this->ctable = $ctable;
    }

    /**
     * @return bool
     */
    public function isSwitchToEdit(): bool
    {
        return $this->switchToEdit;
    }

    /**
     * @param bool $switchToEdit
     */
    public function setSwitchToEdit(bool $switchToEdit): void
    {
        $this->switchToEdit = $switchToEdit;
    }

    /**
     * @return bool
     */
    public function isEnableVersioning(): bool
    {
        return $this->enableVersioning;
    }

    /**
     * @param bool $enableVersioning
     */
    public function setEnableVersioning(bool $enableVersioning): void
    {
        $this->enableVersioning = $enableVersioning;
    }

    /**
     * @return string
     */
    public function getMarkAsCopy(): string
    {
        return $this->markAsCopy;
    }

    /**
     * @param string $markAsCopy
     */
    public function setMarkAsCopy(string $markAsCopy): void
    {
        $this->markAsCopy = $markAsCopy;
    }

    /**
     * @return array
     */
    public function getOnloadCallback(): array
    {
        return $this->onload_callback;
    }

    /**
     * @param array $onload_callback
     */
    public function setOnloadCallback(array $onload_callback): void
    {
        $this->onload_callback = $onload_callback;
    }

    /**
     * @return array
     */
    public function getSql(): array
    {
        return $this->sql;
    }

    /**
     * @param array $sql
     */
    public function setSql(array $sql): void
    {
        $this->sql = $sql;
    }

    /**
     * @return array
     */
    public function getOndeleteCallback(): array
    {
        return $this->ondelete_callback;
    }

    /**
     * @param array $ondelete_callback
     */
    public function setOndeleteCallback(array $ondelete_callback): void
    {
        $this->ondelete_callback = $ondelete_callback;
    }


}