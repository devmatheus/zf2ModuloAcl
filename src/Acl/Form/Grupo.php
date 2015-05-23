<?php

namespace Acl\Form;

use Zend\Form\Form;
use Zend\Form\Element as Element;

class Grupo extends Form
{

    /**
     * @param array $gruposPairs array $id => $nome dos grupos
     */
    public function __construct(array $gruposPairs)
    {
        parent::__construct('grupo');
        
        $this->setAttribute('method', 'post');
        $this->setInputFilter(new GrupoFilter());

        $id = new Element\Hidden('id');
        $this->add($id);

        $nome = new Element\Text('nome');
        $nome->setLabel('Nome')
                ->setAttributes([
                    'id'        => 'nome',
                    'maxlength' => 45
                ]);
        $this->add($nome);

        $parent = new Element\Select('parent');
        $parent->setLabel('Herda')
                ->setOptions([
                    'id'            => 'parent',
                    'value_options' => $gruposPairs,
                    'empty_option'  => 'Nenhum'
                ]);
        $this->add($parent);

        $submit = new Element\Submit('submit');
        $submit->setAttribute('class', 'btn btn-success')
                ->setValue('Salvar');
        $this->add($submit);
    }

}
