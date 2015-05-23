<?php

namespace Acl\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="acl_grupo")
 * @ORM\Entity(repositoryClass="Acl\Repository\GrupoRepository")
 */
class Grupo
{
    
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false, length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Grupo", inversedBy="grupos")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     * @var string
     */
    private $nome;
    
    /**
     * @ORM\OneToMany(targetEntity="Acl\Entity\Grupo", mappedBy="parent", cascade={"persist", "remove"})
     */
    private $grupos;
    
    /**
     * @ORM\OneToMany(targetEntity="Usuarios\Entity\Usuario", mappedBy="grupo", cascade={"persist", "remove"})
     */
    private $usuarios;
    
    function getId()
    {
        return $this->id;
    }
    
    function getParent()
    {
        $parent = false;
        if (isset($this->parent)) {
            $parent = $this->parent;
        }
        return $parent;
    }

    function getNome()
    {
        return $this->nome;
    }

    function getGrupos()
    {
        return $this->grupos;
    }

    function getUsuarios()
    {
        return $this->usuarios;
    }
    
    function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    function setGrupos($grupos)
    {
        $this->grupos = $grupos;
        return $this;
    }

    function setUsuarios($usuarios)
    {
        $this->usuarios = $usuarios;
        return $this;
    }

    function __construct($options = null)
    {
        $hydrator = new Hydrator\ClassMethods;
        $hydrator->hydrate($options, $this);
        $this->grupos = new ArrayCollection();
        $this->usuarios = new ArrayCollection();
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
