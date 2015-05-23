<?php

namespace Acl\Controller;

class PermissoesController extends \Base\Controller\CrudController
{
    public function __construct()
    {
        parent::init(__NAMESPACE__);
        unset($this->grid['acoes']['links']['editar']);
        
        $this->tituloModulo   = 'Controle de Usuários - Permissões';
        $this->form           = 'Acl\Form\Permissao';
        $this->entity         = 'Acl\Entity\Permissao';
        $this->service        = 'Acl\Service\Permissao';
        $this->route          = 'admin-acl-permissoes';
        $this->controller     = 'acl-permissoes';
        $this->grid['campos'] = [
            'id'      => ['label' => 'ID', 'style' => 'width: 60px'],
            'action'  => ['label' => 'Ação'],
            'grupo'   => ['label' => 'Grupo'],
            'recurso' => ['label' => 'Recurso']
        ];
        $this->grid['relacoes'] = [
            'grupo' => [
                'entity'     => 'Acl\Entity\Grupo',
                'campo'      => 'nome',
                'referencia' => 'id'
            ],
            'recurso' => [
                'entity'     => 'Acl\Entity\Recurso',
                'campo'      => 'nome',
                'referencia' => 'id'
            ]
        ];
    }
}
