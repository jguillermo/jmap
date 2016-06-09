<?php
namespace Jmap\Model;

class Form {

	private $form = null;

	private $frmElements;

	public function __construct($formAttributes, $elements = array()) {
		$this->frmElements = $this->filterFormAttr($formAttributes->get(), $elements);

		//var_dump($this->frmElements);
	}

	public function getForm() {

		if (is_null($this->form)) {

			if (!\Zend\Validator\AbstractValidator::hasDefaultTranslator()) {

				$translator = new \Zend\Mvc\I18n\Translator(new \Zend\I18n\Translator\Translator());

				$translator->addTranslationFile('phpArray', __DIR__ . '/../../../../vendor/zendframework/zendframework/resources/languages/es/Zend_Validate.php', 'default', 'es_ES');

				//$translator->addTranslationFile('phpArray', __DIR__ . '/../../../../vendor/zendframework/zend-i18n-resources/languages/es/Zend_Validate.php', 'default', 'es_ES');

				//$translator->addTranslationFile('phpArray', __DIR__ . '/../../../../vendor/zendframework/zendframework/resources/languages/es/Zend_Captcha.php', 'default', 'es_ES');

				\Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
				// se tiene que modificar el php_ini la parte de php_intl.dll, hay que cambiar a es_ES
			}

			$this->form = new \Jmap\Form\FormGral($this->frmElements);
			$filter     = new \Jmap\Form\Filter($this->frmElements);
			$this->form->setInputFilter($filter->getInputFilter());
		}
		return $this->form;
	}

	private function filterFormAttr($formAttributes, $elements) {
		$data = array();

		if (!is_array($elements)) {
			throw new \Exception('los elementos deben estar contenidos dentro de un Array');

		}

		// si no hay ningun filtro, se debe pasar todo slos elemtos
		if (count($elements) == 0) {
			//$data = $formAttributes;
			foreach ($formAttributes['form'] as $columnName => $attr) {
				$data[$columnName]['form'] = $attr;
			}
			foreach ($formAttributes['filter'] as $columnName => $attr) {
				$data[$columnName]['filter'] = $attr;
			}
		} else {
			// filtrar los campos que se deseea ingresar al formnulario

			foreach ($elements as $elementName) {
				//if (!isset($formAttributes[$elementName])) {
				//    throw new \Exception("no existe el elemnto : $elementName");
				//}
				if (isset($formAttributes['form'][$elementName])) {
					$data[$elementName]['form'] = $formAttributes['form'][$elementName];
				}

				if (isset($formAttributes['filter'][$elementName])) {
					$data[$elementName]['filter'] = $formAttributes['filter'][$elementName];
				}

			}
		}

		return $data;
	}
}
