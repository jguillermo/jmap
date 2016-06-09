<?php
namespace Jmap\Util;

/**
 * clase para encriptar y desencriptar datos en formato url
 * tiene dos formas de encriptar
 * 1 endode, decode : con esta funcion siempre se va atener la misma respuesta al momento de encriptar
 * 2 Dynamic encode decode : con esta funcion siempre va a salir un string diferente al momento de encriptar
 */
class Crypt {

	private $encryption_key = '';

	/**
	 * encripta siempre una cadena dija
	 * @param  string $txt cadena aencriptar
	 * @param  string $key llava a usar
	 * @return string      cadena encriptada, siempre da el mismo resultado
	 */
	public function encode($txt, $key = '') {

		$key = $this->get_key($key);

		$result = '';
		for ($i = 0; $i < strlen($txt); $i++) {
			$char    = substr($txt, $i, 1);
			$keychar = substr($key, ($i % strlen($key)) - 1, 1);
			$char    = chr(ord($char) + ord($keychar));
			$result .= $char;
		}
		return $this->base64url_encode($result);
	}

	/**
	 * desencripta la cadena fija
	 * @param  string $txt cadena a desencriptar
	 * @param  string $key llave para desencriptar, si no se pone el key se optiene de la configiguracion
	 * @return string      cadena desencriptada
	 */
	public function decode($txt, $key = '') {

		$key    = $this->get_key($key);
		$result = '';
		$txt    = $this->base64url_decode($txt);
		for ($i = 0; $i < strlen($txt); $i++) {
			$char    = substr($txt, $i, 1);
			$keychar = substr($key, ($i % strlen($key)) - 1, 1);
			$char    = chr(ord($char) - ord($keychar));
			$result .= $char;
		}
		return $result;
	}

	/**
	 * encripta la cadena, simre salen cadena diferentes
	 * @param  string $txt cadena a encriptar
	 * @param  string $key key
	 * @return string      cadena encriptada siempre es distinta
	 */
	public function dynamicEncode($txt, $key = '') {

		return $this->encode($this->addStrRandom($txt), $key);
	}

	/**
	 * desencripta la cadena dinamica
	 * @param  string $txt cadena a desencriptar en forma dinamica
	 * @param  string $key key
	 * @return string      cadena sedencriptada
	 */
	public function dynamicDecode($txt, $key = '') {

		return $this->removeStrRandom($this->decode($txt, $key));
	}

	/**
	 * agrega una cadena aleatoria entre cada letra
	 * @param string $txt cadena mixta entre random y l ainformacion
	 */
	private function addStrRandom($txt) {
		$keyRandom    = md5(rand()) . md5(rand());
		$borderRandom = md5(rand());

		$lenTxt = strlen($txt);
		$txtExt = '';
		for ($i = 0, $j = 0; $i < $lenTxt; $i++, $j++) {
			if ($j >= 64) {
				$j = 0;
			}
			$txtExt .= $keyRandom[$j] . $txt[$i];
		}
		return substr($borderRandom, 0, 3) . $txtExt . substr($borderRandom, -3);
	}

	/**
	 * retira las letras random de la cadena
	 * @param  string $txt cadena de texto que esta incluido el random
	 * @return string      cadena limpia de random
	 */
	private function removeStrRandom($txt) {

		$txt = substr($txt, 3, -3);

		$lenTxt = strlen($txt);
		$txtExt = '';
		for ($i = 1; $i < $lenTxt; $i += 2) {
			$txtExt .= $txt[$i];
		}
		return $txtExt;
	}

	/**
	 * procesa el key pasado, si es "" busca el key definido en config
	 * @param  string $key cade que se dee usar para sesencriptar
	 * @return string      cadena a usar
	 */
	private function get_key($key = '') {
		if ($key === '') {
			if ($this->encryption_key !== '') {
				return $this->encryption_key;
			}
			$key                  = \Jmap\Config::crypt('tem');
			$this->encryption_key = md5($key);
		}

		return md5($key);
	}

	/**
	 * combierte el base64 en formato url
	 * @param  string $data cadena a transformar
	 * @return string       cadena procesada
	 */
	private function base64url_encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	/**
	 * combierte el string url a  base64
	 * @param  string $data cadena a transformar
	 * @return string       cadena procesada
	 */
	private function base64url_decode($data) {
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}

}
