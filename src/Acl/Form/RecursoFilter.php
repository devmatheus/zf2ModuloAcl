<?php

namespace Acl\Form;

use Zend\InputFilter\InputFilter;

class RecursoFilter extends InputFilter
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

    }
}
