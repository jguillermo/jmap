<?php

namespace Jmap\Model;

class Adapter {
	private static $adapter;

	private static function setAdapter($db) {
		return new \Zend\Db\Adapter\Adapter(\Jmap\Config::db($db));
	}

	public static function getAdapter($db = 'default') {
		if (!isset(self::$adapter[$db])) {
			self::$adapter[$db] = self::setAdapter($db);
		}
		return self::$adapter[$db];
	}

}
