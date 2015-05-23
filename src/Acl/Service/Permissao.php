<?php

namespace Acl\Service;

use Doctrine\ORM\EntityManager;
use Base\Service\AbstractService;

class Permissao extends AbstractService
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = 'Acl\Entity\Permissao';
    }

    public function insert(array $data)
    {
        $data['grupo']   = $this->em->getReference('Acl\Entity\Grupo', $data['grupo']);
        $data['recurso'] = $this->em->getReference('Acl\Entity\Recurso', $data['recurso']);
        
        if ($data['outro']) {
            $data['action'][array_search('outro', $data['action'])] = $data['outro'];
        }

        $actions = $data['action'];
        if (array_search('index', $actions) !== false) {
            $actions[] = 'json';
        }

        foreach($actions as $action) {
            $data['action'] = $action;
            $result = $result && parent::insert($data);
        }
        
        return $result;
    }
}
