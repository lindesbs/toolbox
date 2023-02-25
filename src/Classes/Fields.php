<?php

namespace lindesbs\contaotoolbox\Classes;

use ArrayIterator;

class Fields extends ArrayIterator
{
    private bool $exclude;
    private string $inputType;
    private array $eval;
    private string $sql;
    private CallbackArray $label;

    /**
     * @return bool
     */
    public function isExclude(): bool
    {
        return $this->exclude;
    }

    /**
     * @param bool $exclude
     */
    public function setExclude(bool $exclude): void
    {
        $this->exclude = $exclude;
    }

    /**
     * @return string
     */
    public function getInputType(): string
    {
        return $this->inputType;
    }

    /**
     * @param string $inputType
     */
    public function setInputType(string $inputType): void
    {
        $this->inputType = $inputType;
    }

    /**
     * @return array
     */
    public function getEval(): array
    {
        return $this->eval;
    }

    /**
     * @param array $eval
     */
    public function setEval(array $eval): void
    {
        $this->eval = $eval;
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * @param string $sql
     */
    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }

    /**
     * @return CallbackArray
     */
    public function getLabel(): CallbackArray
    {
        return $this->label;
    }

    /**
     * @param CallbackArray $label
     */
    public function setLabel(CallbackArray $label): void
    {
        $this->label = $label;
    }


}