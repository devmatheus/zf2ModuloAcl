<?php

namespace Acl\Controller;

class GruposController extends \Base\Controller\CrudController
{
    public function __construct()
    {
        parent::init(__NAMESPACE__);
        $this->tituloModulo   = 'Controle de Usuários - Grupos';
        $this->form           = 'Acl\Form\Grupo';
        $this->entity         = 'Acl\Entity\Grupo';
        $this->service        = 'Acl\Service\Grupo';
        $this->route          = 'admin-acl-grupos';
        $this->controller     = 'acl-grupos';
        $this->grid['campos'] = [
            'id'     => ['label' => 'ID', 'style' => 'width: 60px'],
            'nome'   => ['label' => 'Nome'],
            'parent' => ['label' => 'Herda']
        ];
        $this->grid['relacoes'] = [
            'parent' => [
                'entity'     => 'Acl\Entity\Grupo',
                'campo'      => 'nome',
                'referencia' => 'id'
            ]
        ];
    }
}
