<?php

namespace Acl\Form;

use Zend\InputFilter\InputFilter;

class GrupoFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'nome',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'NotEmpty'],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 45,
                        'min' => 1
                    ]
                ]
            ]
        ]);
        
        $this->add([
            'name' => 'parent',
            'required' => false,
            'filters' => [
                ['name' => 'Digits']
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 11
                    ]
                ]
            ]
        ]);
    }
}
