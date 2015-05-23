<?php

namespace Acl\Controller;

class RecursosController extends \Base\Controller\CrudController
{
    public function __construct()
    {
        parent::init(__NAMESPACE__);
        $this->tituloModulo   = 'Controle de Usuários - Recursos';
        $this->entity         = 'Acl\Entity\Recurso';
        $this->service        = 'Acl\Service\Recurso';
        $this->form           = 'Acl\Form\Recurso';
        $this->route          = 'admin-acl-recursos';
        $this->controller     = 'acl-recursos';
        $this->grid['campos'] = [
            'id'   => ['label' => 'ID', 'style' => 'width: 60px'],
            'nome' => ['label' => 'Nome']
        ];
    }
}
