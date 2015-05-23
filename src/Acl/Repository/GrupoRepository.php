<?php

namespace Acl\Repository;

use Base\Entity\BaseRepository;

class GrupoRepository extends BaseRepository
{

    public function fetchPairs()
    {
        $entities = $this->findBy([], ['nome' => 'ASC']);
        return array_reduce($entities, function ($result, $item)
        {
            $result[$item->getId()] = $item->getNome();
            return $result;
        });
    }

}
