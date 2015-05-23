<?php

namespace Acl\Form;

use Zend\InputFilter\InputFilter;

class PermissaoFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'action',
            'required' => true
        ]);
        
        $this->add([
            'name' => 'outro',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 45
                    ]
                ]
            ]
        ]);
        
        $this->add([
            'name' => 'grupo',
            'required' => true,
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
        
        $this->add([
            'name' => 'recurso',
            'required' => true,
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
