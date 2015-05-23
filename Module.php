<?php

namespace Acl;

use Base\Validator\ObjectExists;

class Module
{
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return [
			'Zend\Loader\ClassMapAutoloader' => [
				__DIR__ . '/autoload_classmap.php'
			]
		];
	}

	public function getServiceConfig()
	{
		return [
			'factories' => [
				'Acl\Service\Permissao' => function ($service) {
					return new Service\Permissao($service->get('Doctrine\ORM\EntityManager'));
				},
				'Acl\Service\Grupo' => function ($service) {
					return new Service\Grupo($service->get('Doctrine\ORM\EntityManager'));
				},
				'Acl\Service\Recurso' => function ($service) {
					return new Service\Recurso($service->get('Doctrine\ORM\EntityManager'));
				},
				'Acl\Form\Recurso' => function () {
					return new Form\Recurso;
				},
				'Acl\Form\Permissao' => function ($service) {
					$em = $service->get('Doctrine\ORM\EntityManager');
					$config = $service->get('Config');

					$repoGrupo = $em->getRepository($config['entities']['Acl\Entity\Grupo']);
					$repoRecurso = $em->getRepository($config['entities']['Acl\Entity\Recurso']);

					$form = new Form\Permissao($repoGrupo->fetchPairs(), $repoRecurso->fetchPairs());

					$form->getInputFilter()
						->get('grupo')
						->getValidatorChain()
						->attach(new ObjectExists([
							'object_repository' => $repoGrupo,
							'fields'            => 'id'
						]));

					$form->getInputFilter()
						->get('recurso')
						->getValidatorChain()
						->attach(new ObjectExists([
							'object_repository' => $repoRecurso,
							'fields'            => 'id'
						]));

					return $form;
				},
				'Acl\Form\Grupo' => function ($service) {
					$em = $service->get('Doctrine\ORM\EntityManager');
					$config = $service->get('Config');

					$repo = $em->getRepository($config['entities']['Acl\Entity\Grupo']);

					$form = new Form\Grupo($repo->fetchPairs());
					$form->getInputFilter()
						->get('parent')
						->getValidatorChain()
						->attach(new ObjectExists([
							'object_repository' => $repo,
							'fields'            => 'id'
						]));

					return $form;
				},
				'Acl\Service\Acl' => function ($service) {
					return new Permissions\Acl($service->get('Cache'), $service->get('Doctrine\ORM\EntityManager'));
				}
			]
		];
	}
}
