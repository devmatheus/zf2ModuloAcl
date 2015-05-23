<?php

namespace Acl\Service;

use Doctrine\ORM\EntityManager;
use Base\Service\AbstractService;

class Grupo extends AbstractService
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = 'Acl\Entity\Grupo';
    }
    
    public function insert(array $data)
    {
        if ($data['parent']) {
            $data['parent'] = $this->em->getReference($this->entity, $data['parent']);
        } else {
            $data['parent'] = null;
        }
        return parent::insert($data);
    }

    public function update(array $data)
    {
        if ($data['parent']) {
            $data['parent'] = $this->em->getReference($this->entity, $data['parent']);
        } else {
            $data['parent'] = null;
        }
        return parent::update($data);
    }
}
