<?php

namespace Acl\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="acl_recurso")
 * @ORM\Entity(repositoryClass="Acl\Repository\RecursoRepository")
 */
class Recurso
{

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false, length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;
    
    /**
     * @ORM\OneToMany(targetEntity="Acl\Entity\Permissao", mappedBy="recurso", cascade={"persist", "remove"})
     */
    private $permissoes;
    
    function getId()
    {
        return $this->id;
    }

    function getNome()
    {
        return $this->nome;
    }

    function getPermissoes()
    {
        return $this->permissoes;
    }

    function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    function __construct($options = null)
    {
        $hydrator = new Hydrator\ClassMethods;
        $hydrator->hydrate($options, $this);
        $this->permissoes = new ArrayCollection();
    }
    
    function __toString()
    {
        return $this->nome;
    }

    function toArray()
    {
        $hydrator = new Hydrator\ClassMethods;
        return $hydrator->extract($this);
    }
    
    /**
     * @ORM\PostPersist
     */
    function excluirCache()
    {
        \Base\Controller\IndexController::delete(ROOT_PATH . '/data/cache');
    }
}
