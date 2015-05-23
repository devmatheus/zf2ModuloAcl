<?php

namespace Acl\Form;

use Zend\Form\Form;
use Zend\Form\Element as Element;

class Recurso extends Form
{

    public function __construct()
    {
        parent::__construct('recurso');
        
        $this->setAttribute('method', 'post');
        $this->setInputFilter(new RecursoFilter());

        $id = new Element\Hidden('id');
        $this->add($id);

        $nome = new Element\Text('nome');
        $nome->setLabel('Nome')
                ->setAttributes([
                    'id'        => 'nome',
                    'maxlength' => 45
                ]);
        $this->add($nome);

        $submit = new Element\Submit('submit');
        $submit->setAttribute('class', 'btn btn-success')
                ->setValue('Salvar');
        $this->add($submit);
    }

}
