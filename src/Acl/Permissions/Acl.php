<?php

namespace Acl\Permissions;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Permissions\Acl\Acl as AclZend;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Session\Container as SessionContainer;

class Acl extends AclZend
{
    protected $controllerName;
    protected $action;
    protected $routeMatch;
    protected $routeRedirect;
    protected $em;
    protected $mvcEvent;
    protected $grupos;
    protected $cache;
    
    protected $roles;
    protected $resources;
    protected $privileges;
    
    protected $usuario;

    public function __construct($cache, $em)
    {
        $this->routeRedirect = 'admin-auth';
        $this->cache         = $cache;
        $this->em            = $em;
    }

    public function setRouteRedirect($routeRedirect)
    {
        $this->routeRedirect = $routeRedirect;
        return $this;
    }

    public function setMvcEvent($mvcEvent)
    {
        $this->mvcEvent       = $mvcEvent;
        $this->routeMatch     = $this->mvcEvent->getRouteMatch();
        $this->controllerName = $this->routeMatch->getParam('controller');
        $this->action         = $this->routeMatch->getParam('action');
        return $this;
    }

    public function getAcl()
    {
        if (null === $this->acl) {
            $this->acl = new AclZend();
        }
        return $this->acl;
    }

    /**
     * @return EntityRepository
     */
    public function getRepo($entity = null)
    {
        if (null === $entity) {
            $entity = $this->entity;
        }
        return $this->em->getRepository($entity);
    }
    
    protected function loadRoles($role, $parent = null)
    {
        if (is_object($role)) {
            if ($role->getParent()) {
                $parent = $role->getParent()->getNome();
                $this->loadRoles($role->getParent());
            }
            
            if (!$this->hasRole($role->getNome())) {
                $this->addRole(new Role($role->getNome()), $parent);
            }
        }
    }

    protected function loadResources()
    {
        $this->resources = json_decode($this->cache->getItem('Auth_Resources'), true);
        if (count($this->resources) == 0) {
            foreach ($this->getRepo('Acl\Entity\Recurso')->findAll() as $resource)  {
                $this->addResource(new Resource($resource->getNome()));
                $resources[$resource->getId()] = $resource->getNome();
            }

            $this->cache->addItem('Auth_Resources', json_encode($resources));
        } else {
            foreach ($this->resources as $resource) {
                $this->addResource(new Resource($resource));
            }
        }
    }
    
    protected function loadPrivileges()
    {
        $this->privileges = json_decode($this->cache->getItem('Auth_Permissoes'), true);
        if (count($this->privileges) == 0) {
            foreach($this->getRepo('Acl\Entity\Permissao')->findAll() as $privilege)
            {
                if ($this->hasRole($privilege->getGrupo()->getNome())) {
                    $this->allow($privilege->getGrupo()->getNome(), $privilege->getRecurso()->getNome(), $privilege->getAction());
                    $privileges[$privilege->getId()] = [
                        'grupo'   => $privilege->getGrupo()->getNome(),
                        'recurso' => $privilege->getRecurso()->getNome(),
                        'action'  => $privilege->getAction()
                    ];
                }
            }
            
            $this->cache->addItem('Auth_Permissoes', json_encode($privileges));
        } else {
            foreach ($this->privileges as $privilege) {
                if ($this->hasRole($privilege['grupo'])) {
                    $this->allow($privilege['grupo'], $privilege['recurso'], $privilege['action']);
                }
            }
        }
    }

    public function hasPermission($recurso = false, $action = false, $redireciona = true)
    {
        if ($recurso) {
            $this->controllerName = $recurso;
        }
        if ($action) {
            $this->action = $action;
        }
        
        $this->controllerName = str_replace('api/', 'admin/', $this->controllerName);
        if (($recurso && $action) || (strpos($this->controllerName, 'admin') !== false && $this->controllerName != 'admin/auth') || $this->controllerName == 'home') {
            $auth = new AuthenticationService();
            $auth->setStorage(new SessionStorage('admin'));
            
            $sessionContainer = new SessionContainer('auth_config');
            
            if (!$auth->hasIdentity()) {
                $sessionContainer->urlAnterior = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                $redirect = $this->mvcEvent->getTarget()->redirect();
                $this->mvcEvent->stopPropagation();
                return $this->mvcEvent->setResult($redirect->toRoute('admin-auth'));
            }

            $this->usuario = $auth->getIdentity();
            if ($this->usuario['status'] == 0 && $this->controllerName != 'home') {
                $this->mvcEvent->getTarget()
                            ->getServiceLocator()
                            ->get('ControllerPluginManager')
                            ->get('flashMessenger')
                            ->setNamespace('admin-messages')
                            ->addMessage('Acesso negado para a ação. Usuário Inativo.');
                $redirect = $this->mvcEvent->getTarget()->redirect();
                $this->mvcEvent->stopPropagation();
                return $this->mvcEvent->setResult($redirect->toRoute('home-admin'));
            }
            
            $role = $this->getRepo('Acl\Entity\Grupo')->find($this->usuario['grupo']);
            $this->loadRoles($role);
            $this->loadResources();
            $this->loadPrivileges();
            
            $permitido = false;
            if ($this->hasResource($this->controllerName) && $this->hasRole($this->usuario['grupo_nome'])) { // se tem o recurso e o grupo na acl
                $permitido = $this->isAllowed($this->usuario['grupo_nome'], $this->controllerName, $this->action);
            }
            
            if ($permitido == false &&
                    $this->controllerName != 'home' &&
                    $this->action != 'redirect') { // se não é permitido e não está no home então redireciona pro home e mostra mensagem de alerta
                if ($redireciona && $this->mvcEvent) {
                    $this->mvcEvent->getTarget()
                            ->getServiceLocator()
                            ->get('ControllerPluginManager')
                            ->get('flashMessenger')
                            ->setNamespace('admin-messages')
                            ->addMessage('Acesso negado para a ação <strong>' . $this->action . '</strong> do recurso <strong>' . $this->controllerName . '</strong>.');
                    $redirect = $this->mvcEvent->getTarget()->redirect();
                    $this->mvcEvent->stopPropagation();
                    return $this->mvcEvent->setResult($redirect->toRoute('home-admin'));
                } else {
                    return false;
                }
            }
            return true;
        }
    }
}
