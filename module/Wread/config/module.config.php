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
			'wread' => array(
				'type'          => 'Literal',

				'options'       => array(
					'route'    => '/wread',
					'defaults' => array(
						'__NAMESPACE__' => 'Wread\Controller',
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
			'Wread\Controller\Dashboard'    => 'Wread\Controller\DashboardController',
			'Wread\Controller\App'    => 'Wread\Controller\AppController',
			'Wread\Controller\ReadWeb'    => 'Wread\Controller\ReadWebController',
			'Wread\Controller\Geocode'    => 'Wread\Controller\GeocodeController',
		),
	),
	'view_helpers' => array(
		'invokables' => array(
			//'viewHelperSkeltonModuleMenu' => 'SkeltonModule\View\Helper\SkeltonModuleMenu',
		),
	),
	'view_manager' => array(
		'template_map'        => array(
			'layout/wread'         => __DIR__ . '/../view/layout/layout.phtml',
			'layout/wread/empty'   => __DIR__ . '/../view/layout/layout-empty.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
		'strategies'          => array(
			'ViewJsonStrategy',
		),
	),
);
