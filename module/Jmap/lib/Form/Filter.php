<?php

namespace Jmap\Form;

// Add these import statements
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Filter implements InputFilterAwareInterface {

    protected $inputFilter;

    public function __construct($elements = array()) {
        $this->initialize($elements);
    }

    Private function initialize($elements) {
        $this->inputFilter = new InputFilter();

        //var_dump($formAttributes);
        //var_dump($elements);

        foreach ($elements as $name => $element) {
            if (isset($element['filter'])) {
                $filter = $element['filter'];
                $filter['name'] = $name;
                $this->inputFilter->add($filter);
            }
        }
    }

    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
