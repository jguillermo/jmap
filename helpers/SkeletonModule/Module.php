<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SkeletonModule;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {
	public function onBootstrap(MvcEvent $e) {
		$eventManager = $e->getApplication()->getEventManager();
		$eventManager->attach('dispatch', array($this, 'setConfigModule'), 4);
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			//'Zend\Loader\ClassMapAutoloader' => array( __DIR__ . '/autoload_classmap.php', ),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__=> __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function setConfigModule($e) {
		$matches    = $e->getRouteMatch();
		$controller = $matches->getParam('controller');
		if (false === strpos($controller, __NAMESPACE__)) {
			// not a controller from this module
			return;
		}




		$folderPublic = rtrim($_SERVER['SCRIPT_NAME'], '/index.php');
		$request      = $e->getRequest();
		$ruta         = $request->getRequestUri();
		$conf         = $e->getApplication()->getConfig();
		$baseurl      = $folderPublic . $conf['router']['routes']['skeleton-module']['options']['route'];
		$subru        = (strlen($ruta) > strlen($baseurl)) ? substr($ruta, strlen($baseurl) + 1, 4) : '';

		//var_dump($folderPublic);
		//var_dump($baseurl);
		//var_dump($ruta);
		//var_dump($subru);
		//var_dump($request->getBasePath());
		//exit();
		$viewModel = $e->getViewModel($subru);

		\SkeletonModule\Util\Route::set($subru);

		switch ($subru) {
		case 'ajax':
		case 'json':
			$viewModel->setTemplate('layout/skeleton-module/empty');
			break;
		default:
			$viewModel->setTemplate('layout/skeleton-module');
			break;
		}

		$viewModel->nAppBuild = "";
		if (ENVIRONMENT == 'development') {
			$request->setBasePath($folderPublic . '/f/skeleton-module-dev/');
		} else {
			$request->setBasePath($folderPublic . '/f/skeleton-module/');

			$data                 = require __DIR__ . '/file/nconcat/css.php';
			$viewModel->nAppBuild = $data['app'];

		}

	}

}
