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
			'admin' => array(
				'type'          => 'Literal',

				'options'       => array(
					'route'    => '/admin',
					'defaults' => array(
						'__NAMESPACE__' => 'Admin\Controller',
						'controller'    => 'Sis',
						'action'        => 'load',
					),
				),
				'may_terminate' => true,
				'child_routes'  => array(
					'html'    => array(
						'type'    => 'Segment',
						'options' => array(
							'route'       => '/html/[:controller[/:action]]',
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
					),
					'blank'   => array(
						'type'    => 'Segment',
						'options' => array(
							'route'       => '/blnk/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults'    => array(
							),
						),
					),
					'maqueta' => array(
						'type'    => 'Segment',
						'options' => array(
							'route'       => '/maqueta/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults'    => array(
							),
						),
					),
				),
			),
		),
	),
	'controllers'  => array(
		'invokables' => array(
			//'Admin\Controller\Account'    => 'Admin\Controller\AccountController',
			'Admin\Controller\Dashboard'    => 'Admin\Controller\DashboardController',
			'Admin\Controller\User'         => 'Admin\Controller\UserController',
			'Admin\Controller\Sis'          => 'Admin\Controller\SisController',
			'Admin\Controller\IdentityType' => 'Admin\Controller\IdentityTypeController',
			'Admin\Controller\PhoneType'    => 'Admin\Controller\PhoneTypeController',

		),
	),
	'view_helpers' => array(
		'invokables' => array(
			'viewHelperAdminMenu' => 'Admin\View\Helper\AdminMenu',
		),
	),
	'view_manager' => array(
		'template_map'        => array(
			'layout/admin'         => __DIR__ . '/../view/layout/layout.phtml',
			'layout/admin/empty'   => __DIR__ . '/../view/layout/layout-empty.phtml',
			'layout/admin/maqueta' => __DIR__ . '/../view/layout/layout-maqueta.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
		'strategies'          => array(
			'ViewJsonStrategy',
		),
	),
);
