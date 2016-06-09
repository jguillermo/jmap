<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
	'router'       => array(
		'routes' => array(
			'skeleton-module' => array(
				'type'          => 'Literal',

				'options'       => array(
					'route'    => '/skeleton-module',
					'defaults' => array(
						'__NAMESPACE__' => 'SkeletonModule\Controller',
						'controller'    => 'Dashboard',
						'action'        => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes'  => array(
					'default'    => array(
						'type'    => 'Segment',
						'options' => array(
							'route'       => '/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults'    => array(
							),
						),
					),
					'ajax'    => array(
						'type'    => 'Segment',
						'options' => array(
							'route'       => '/ajax/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults'    => array(
							),
						),
					),
					'json'    => array(
						'type'    => 'Segment',
						'options' => array(
							'route'       => '/json/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults'    => array(
							),
						),
					)
				),
			),
		),
	),
	'controllers'  => array(
		'invokables' => array(
			'SkeletonModule\Controller\Dashboard'    => 'SkeletonModule\Controller\DashboardController',
			'SkeletonModule\Controller\App'    => 'SkeletonModule\Controller\AppController',
		),
	),
	'view_helpers' => array(
		'invokables' => array(
			//'viewHelperSkeltonModuleMenu' => 'SkeltonModule\View\Helper\SkeltonModuleMenu',
		),
	),
	'view_manager' => array(
		'template_map'        => array(
			'layout/skeleton-module'         => __DIR__ . '/../view/layout/layout.phtml',
			'layout/skeleton-module/empty'   => __DIR__ . '/../view/layout/layout-empty.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
		'strategies'          => array(
			'ViewJsonStrategy',
		),
	),
);
