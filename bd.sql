CREATE TABLE IF NOT EXISTS `acl_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `acl_permissao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acl_grupo_id` int(11) NOT NULL,
  `acl_recurso_id` int(11) NOT NULL,
  `action` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `acl_recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `acl_grupo` (`id`, `parent_id`, `nome`) VALUES
(1, NULL, 'Administrador'),
(2, 1, 'Developer');

INSERT INTO `acl_permissao` (`id`, `acl_grupo_id`, `acl_recurso_id`, `action`) VALUES
(1, 1, 1, 'index')
(2, 1, 1, 'grid-api'),
(3, 1, 1, 'editar'),
(4, 1, 1, 'excluir'),
(5, 1, 1, 'novo'),
(6, 1, 2, 'index'),
(7, 1, 2, 'grid-api'),
(8, 1, 2, 'editar'),
(9, 1, 2, 'excluir'),
(10, 1, 2, 'novo'),
(11, 1, 3, 'index'),
(12, 1, 3, 'grid-api'),
(13, 1, 3, 'excluir'),
(14, 1, 3, 'novo'),
(15, 1, 4, 'index'),
(16, 1, 4, 'grid-api'),
(17, 1, 4, 'editar'),
(19, 1, 4, 'novo'),
(20, 1, 5, 'index'),
(21, 1, 5, 'grid-api'),
(22, 1, 5, 'detalhes'),
(23, 1, 6, 'limpa-cache');

INSERT INTO `acl_recurso` (`id`, `nome`) VALUES
(1, 'admin/acl-grupos'),
(2, 'admin/acl-recursos'),
(3, 'admin/acl-permissoes'),
(4, 'admin/usuarios'),
(5, 'admin/log'),
(6, 'home');
