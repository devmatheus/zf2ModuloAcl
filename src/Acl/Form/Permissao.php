<?php

namespace Acl\Form;

use Zend\Form\Form;
use Zend\Form\Element as Element;

class Permissao extends Form
{
    
    /**
     * @param array $gruposPairs array $id => $nome dos grupos
     * @param array $recursosPairs array $id => $nome dos recursos
     */
    public function __construct(array $gruposPairs, array $recursosPairs)
    {
        parent::__construct('permissao');
        $this->setAttribute('method', 'post');

        $id = new Element\Hidden('id');
        $this->add($id);

        $action = new Element\MultiCheckbox('action');
        $action->setLabel('Ações')
                ->setValueOptions([
                    [
                        'value' => 'index',
                        'label' => 'Visualizar',
                        'label_attributes' => [
                            'class' => 'btn btn-primary'
                        ]
                    ],
                    [
                        'value' => 'editar',
                        'label' => 'Editar',
                        'label_attributes' => [
                            'class' => 'btn btn-primary'
                        ]
                    ],
                    [
                        'value' => 'novo',
                        'label' => 'Adicionar',
                        'label_attributes' => [
                            'class' => 'btn btn-primary'
                        ]
                    ],
                    [
                        'value' => 'excluir',
                        'label' => 'Excluir',
                        'label_attributes' => [
                            'class' => 'btn btn-primary'
                        ]
                    ],
                    [
                        'value' => 'detalhes',
                        'label' => 'Detalhes',
                        'label_attributes' => [
                            'class' => 'btn btn-primary'
                        ]
                    ],
                    [
                        'value' => 'outro',
                        'label' => 'Outro',
                        'label_attributes' => [
                            'class' => 'btn btn-primary'
                        ]
                    ]
                ]);
        $this->add($action);
        
        $outro = new Element\Text('outro');
        $outro->setLabel('Outra ação')
                ->setAttributes([
                    'id'        => 'text-outro',
                    'maxlength' => 45
                ]);
        $this->add($outro);

        $role = new Element\Select('grupo');
        $role->setLabel('Grupo')
                ->setOptions(['value_options' => $gruposPairs]);
        $this->add($role);

        $resource = new Element\Select('recurso');
        $resource->setLabel('Recurso')
                ->setOptions(['value_options' => $recursosPairs]);
        $this->add($resource);

        $submit = new Element\Submit('submit');
        $submit->setAttribute('class', 'btn btn-success')
                ->setValue('Salvar');
        $this->add($submit);
    }
    
}
