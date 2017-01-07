<?php
class Person
{
    private $name;
    private $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    /**
    * Getter
    * @return the value of the property
    */
    public function getName()
    {
      return $this->name;
    }

    /**
    * Getter
    * @return the value of the property
    */
    public function getAge()
    {
      return $this->age;
    }
}
