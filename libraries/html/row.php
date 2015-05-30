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
class jpHtmlRow extends jpHtmlBase
{
	/**
	 * @param string $id [optinal] default null
	 * @param string $class [optinal] default null
	 * @return jpHtmlRow
	 */
	public function begin($id = null, $class = null)
	{
		if($class === null) {
			$class = $this->class;
		}

		if($id === null) {
			$id = $this->id;
		}

		if(!empty($class)) {
			$class = ' '.$class;
		}

		$this->addBuffer (
			'<div class="row'.$class.'"'
				. $this->getAttribute('id', $id)
			. '>'
		);
		return $this;
	}
}
