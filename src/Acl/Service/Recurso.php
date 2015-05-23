<?php

namespace Acl\Service;

use Doctrine\ORM\EntityManager;
use Base\Service\AbstractService;

class Recurso extends AbstractService
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = 'Acl\Entity\Recurso';
    }
}
