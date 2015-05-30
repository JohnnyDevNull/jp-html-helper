<?php
/**
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.1
 * @license MIT - http://opensource.org/licenses/MIT
 */

if (!defined('_JPEXEC')) {
	die ('RESTRICTED ACCESS');
}

/**
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.1
 * @license MIT - http://opensource.org/licenses/MIT
 */
class jpHtmlContainer extends jpHtmlBase
{
	/**
	 * @var bool
	 */
	protected $fluid = false;

	/**
	 * @param bool $bool
	 * @return jpHtmlContainer
	 */
	public function setFluid($bool)
	{
		$this->fluid = $bool;
		return $this;
	}

	/**
	 * @param string $id [optinal] default null
	 * @param string $class [optinal] default null
	 * @return jpHtmlContainer
	 */
	public function begin($id = null, $class = null, $fluid = false)
	{
		if($class === null) {
			$class = $this->class;
		}

		if($id === null) {
			$id = $this->id;
		}

		$fluid = '';

		if($fluid || $this->fluid) {
			$fluid = '-fluid';
		}

		if(!empty($class)) {
			$class = ' '.$class;
		}

		$this->buffer .= '<div class="container'.$fluid.$class.'"'
					  . $this->getAttribute('id', $this->id)
					  . '>';
		return $this;
	}
}
