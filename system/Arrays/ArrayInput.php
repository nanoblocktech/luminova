<?php
namespace Luminova\Arrays;
class ArrayInput
{
    private $parameters = [];

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    public function getParameterOption($values, $default = false)
    {
        $values = (array) $values;

        foreach ($values as $value) {
            if (isset($this->parameters[$value])) {
                return $this->parameters[$value];
            }
        }

        return $default;
    }

    public function hasParameterOption($values)
    {
        $values = (array) $values;

        foreach ($values as $value) {
            if (isset($this->parameters[$value])) {
                return true;
            }
        }

        return false;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getArguments()
    {
        $arguments = [];
        foreach ($this->parameters as $name => $value) {
            if (!is_numeric($name)) {
                $arguments[$name] = $value;
            }
        }

        return $arguments;
    }

    public function getOptions()
    {
        $options = [];
        foreach ($this->parameters as $name => $value) {
            if (is_numeric($name)) {
                $options[$name] = $value;
            }
        }

        return $options;
    }
}
