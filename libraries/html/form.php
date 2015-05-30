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
class jpHtmlForm extends jpHtmlBase
{
	/**
	 * @var string
	 */
	protected $tag = 'form';

	/**
	 * @var string
	 */
	protected $formType = 'form';

	/**
	 * @var string
	 */
	protected $actionUrl = '#';

	/**
	 * @var string
	 */
	protected $method = 'post';

	/**
	 * @var int[]
	 */
	protected $colWidth = array(2, 10);

	/**
	 * @var string
	 */
	protected $secureTokenActive = true;

	/**
	 * @var string
	 */
	protected $formToken;

	/**
	 * @var string
	 */
	protected $lastFormToken;

	/**
	 * @param string $id [optinal] default null
	 * @param string $class [optinal] default null
	 * @return jpHtmlForm
	 */
	public function begin($id = null, $class = null)
	{
		if($class === null) {
			$class = $this->class;
		}

		if($id === null) {
			$id = $this->id;
		}

		$this->buffer .= '<'.$this->tag
					  . $this->getAttribute('class', 'form'.$class)
					  . $this->getAttribute('action', $this->actionUrl)
					  . $this->getAttribute('method', $this->method)
					  . $this->getAttribute('role', 'form')
					  . '>';

		if($this->secureTokenActive) {
			$this->formToken = $this->generateToken();
			$_SESSION['form_token'] = $this->formToken;
			$this->buffer .= '<input type="hidden" '
								. 'name="form_token" '
								. 'id="form_token" '
								. 'value="'.$this->formToken.'">';
		}

		$this->buffer = ob_get_clean();
		return $this;
	}

	/**
	 * @param string $label
	 * @param string $type
	 * @param string $inputNameID
	 * @param string $placeholder
	 * @return jpHtmlForm
	 */
	public function addFormGroup($label, $type, $name, $id = '', $placeholder = '')
	{
		$labelClass = '';

		if($this->formType == 'form-horizontal') {
			$colLeft = (int)array_shift($this->colWidth);
			$colRight = (int)array_shift($this->colWidth);
			$labelClass = 'class="col-sm-'.$colLeft.' control-label"';
		}

		$this->addBuffer (
			'<div class="form-group">'
				. '<label'
					. $this->getAttribute('for', $id)
					. $labelClass.'>'
						. $label
				. '</label>'
		);

		if($this->formType == 'form-horizontal') {
			$this->addBuffer('<div class="col-sm-'.$colRight.'">');
		}

		$this->addBuffer (
			'<input'
				. $this->getAttribute('type', $type)
				. $this->getAttribute('class', 'form-control')
				. $this->getAttribute('name', $name)
				. $this->getAttribute('id', $id)
				. $this->getAttribute('placeholder', $placeholder)
			.'>'
		);

		if($this->formType == 'form-horizontal') {
			$this->addBuffer('</div>');
		}

		$this->addBuffer('</div>');

		return $this;
	}

	/**
	 * @param string $offset
	 * @param string $type
	 * @param string $id
	 * @param string $placeholder
	 * @return jpHtmlForm
	 */
	public function addFormGroupWithOffset($offset, $type, $id = '', $placeholder = '')
	{
		$this->addBuffer (
			'<div'.$this->getAttribute('class', 'form-group').'>'
				. '<div'.$this->getAttribute('class', 'col-sm-offset-'.$offset.' col-sm-10').'>'
					. '<input'
						. $this->getAttribute('type', $type)
						. $this->getAttribute('class', 'form-control')
						. $this->getAttribute('id', $id)
						. $this->getAttribute('placeholder', $placeholder)
					. '>'
				. '</div>'
			. '</div>'
		);

		return $this;
	}

	/**
	 * @return jpHtmlForm
	 */
	public function addButton($text, $type, $name, $class = 'default')
	{
		$this->addBuffer (
			'<button'
				. $this->getAttribute('type', $type)
				. $this->getAttribute('name', $name)
				. $this->getAttribute('class', 'btn btn-'.$class)
				. '>'
					. $text
			. '</button>'
		);

		return $this;
	}

	/**
	 * @return string
	 */
	protected function generateToken()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$uniqid = uniqid(mt_rand(), true);
		return md5($ip . $uniqid);
	}

	/**
	 * @return bool
	 */
	public function validateToken()
	{
		if (
			isset($_POST['form_token'])
			&& $_POST['form_token'] == $this->lastFormToken
		) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param int[] $colWidth
	 * @return jpHtmlForm
	 */
	public function setColWidth(array $colWidth)
	{
		$this->colWidth = $colWidth;
		return $this;
	}

	/**
	 * @param string $url
	 * @return jpHtmlForm
	 */
	public function setActionUrl($url)
	{
		$this->actionUrl = $url;
		return $this;
	}

	/**
	 * @return jpHtmlForm
	 */
	public function setPostMethod()
	{
		$this->method = 'post';
		return $this;
	}

	/**
	 * @return jpHtmlForm
	 */
	public function setGetMethod()
	{
		$this->method = 'get';
		return $this;
	}

	/**
	 * @param bool $bool
	 * @return jpHtmlForm
	 */
	public function setSecureTokenActive($bool)
	{
		$this->secureTokenActive = (bool)$bool;
		return $this;
	}

	/**
	 * @param string $token
	 * @return jpHtmlForm
	 */
	public function setLastFormToken($token)
	{
		$this->lastFormToken = $token;
		return $this;
	}
}
