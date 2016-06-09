<?php
namespace Jmap\Form;
use Zend\Form\Form;

class FormGral extends Form
{
    public function __construct($elements = array())
    {
        // we want to ignore the nameTable passed
        parent::__construct();

        
        //var_dump($elements);

        foreach ($elements as $name=>$element)
        {
            if(isset($element['form']))
            {
                $form=$element['form'];
                $form['name']=$name;

                $this->add($form);
            } 
        }
        

        
    }
}