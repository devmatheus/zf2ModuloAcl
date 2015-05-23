<?php

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="acl_permissao")
 * @ORM\Entity(repositoryClass="Base\Entity\BaseRepository")
 */
class Permissao
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false, length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Grupo")
     * @ORM\JoinColumn(name="acl_grupo_id", referencedColumnName="id", nullable=false)
     */
    private $grupo;

    /**
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Recurso", inversedBy="permissoes")
     * @ORM\JoinColumn(name="acl_recurso_id", referencedColumnName="id", nullable=false)
     */
    private $recurso;

    /**
     * @var string
     * @ORM\Column(name="action", type="string", length=45, nullable=false)
     */
    private $action;

    function getId()
    {
        return $this->id;
    }

    function getGrupo()
    {
        return $this->grupo;
    }

    function getRecurso()
    {
        return $this->recurso;
    }

    function getAction()
    {
        return $this->action;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    function setRecurso($recurso)
    {
        $this->recurso = $recurso;
    }

    function setAction($action)
    {
        $this->action = $action;
    }

    function __construct($options = array())
    {
        $hydrator = new Hydrator\ClassMethods;
        $hydrator->hydrate($options, $this);
    }
    
    function toArray()
    {
        $hydrator = new Hydrator\ClassMethods;
        $data = $hydrator->extract($this);
        
        $data['grupo']   = $this->grupo->getId();
        $data['recurso'] = $this->recurso->getId();

        return $data;
    }

    /**
     * @ORM\PostPersist
     */
    function excluirCache()
    {
        \Base\Controller\IndexController::delete(ROOT_PATH . '/data/cache');
    }
}
