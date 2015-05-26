<?php
/**
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.0
 * @license MIT - http://opensource.org/licenses/MIT
 */

if (!defined('_JPEXEC')) {
	die ('RESTRICTED ACCESS');
}

/**
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.0
 * @license MIT - http://opensource.org/licenses/MIT
 */
class jpHtmlForm extends jpHtmlBase
{
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
	 * @return $this
	 */
	public function begin()
	{
		ob_start();
		?>
		<form class="<?php echo $this->formType?>"
			  action="<?php echo $this->actionUrl; ?>"
			  method="<?php echo $this->method; ?>"
			  role="form" >
			<?php
			if($this->secureTokenActive) {
				$this->addToken();
			}

		$this->buffer = ob_get_clean();
		return $this;
	}

	/**
	 * @return void
	 */
	public function commit()
	{
		$this->buffer .= '</form>';
	}

	/**
	 * @param string $label
	 * @param string $inputType
	 * @param string $inputNameID
	 * @param string $placeholder
	 * @return string|$this
	 */
	public function addFormGroup($label, $inputType, $inputName, $inputID = '', $placeholder = '')
	{
		ob_start();

		$labelClass = '';

		if($this->formType == 'form-horizontal') {
			$colLeft = $this->colWidth[0];
			$colRight = $this->colWidth[1];
			$labelClass = 'class="col-sm-'.$colLeft.' control-label"';
		}

		?>
		<div class="form-group">
			<label for="<?php echo $inputID; ?>" <?php echo $labelClass ?>>
				<?php echo $label; ?>
			</label>

			<?php if($this->formType == 'form-horizontal') : ?>
			<div class="col-sm-<?php echo $colRight ?>">
			<?php endif; ?>

			<input type="<?php echo $inputType; ?>"
				   class="form-control"
				   <?php echo 'name="'.$inputName.'"'; ?>
				   <?php echo !empty($inputID) ? 'id="'.$inputID.'"' : ''; ?>
				   <?php echo !empty($placeholder) ? 'placeholder="'.$placeholder.'"' : ''; ?> />

			<?php if($this->formType == 'form-horizontal') : ?>
			</div>
			<?php endif; ?>

		</div>
		<?php

		$buffer = ob_get_clean();

		if(!$this->getBufferMode()) {
			return $buffer;
		}

		$this->addBuffer($buffer);

		return $this;
	}

	/**
	 * @param string $offset
	 * @param string $inputType
	 * @param string $inputID
	 * @param string $placeholder
	 * @return string|$this
	 */
	public function addFormGroupWithOffset($offset, $inputType, $inputID = '', $placeholder = '')
	{
		ob_start();

		?>
		<div class="form-group">
			<div class="<?php echo $offset; ?> col-sm-10">
				<input type="<?php echo $inputType; ?>"
					   class="form-control"
					   <?php echo (!empty($inputID)) ? 'id="'.$inputID.'"' : '' ?>
					   <?php echo (!empty($placeholder)) ? 'placeholder="'.$placeholder.'"' : '' ?> />
			</div>
		</div>
		<?php

		$buffer = ob_get_clean();

		if(!$this->getBufferMode()) {
			return $buffer;
		}

		$this->addBuffer($buffer);

		return $this;
	}

	/**
	 * @return string|$this
	 */
	public function addButton($text, $tpye, $name, $type = 'default')
	{
		ob_start();

		?>
			<button type="<?php echo $tpye ?>"
					name="<?php echo $name; ?>"
					class="btn btn-<?php echo $type; ?>">
				<?php echo $text; ?>
			</button>
		<?php

		$buffer = ob_get_clean();

		if(!$this->getBufferMode()) {
			return $buffer;
		}

		$this->addBuffer($buffer);

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
	 * @return string
	 */
	protected function addToken()
	{
		$this->formToken = $this->generateToken();
		$_SESSION['form_token'] = $this->formToken;
		echo "<input type='hidden' name='form_token' id='form_token' value='".$this->formToken."' />";
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
	 * @return $this
	 */
	public function setFormStyleDefault()
	{
		$this->formType = 'form';
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setFormStyleHorizontal()
	{
		$this->formType = 'form-horizontal';
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setFormStyleInline()
	{
		$this->formType = 'form-inline';
		return $this;
	}

	/**
	 * @param int[] $colWidth
	 * @return $this
	 */
	public function setColWidth(array $colWidth)
	{
		$this->colWidth = $colWidth;
		return $this;
	}

	/**
	 * @param string $url
	 * @return $this
	 */
	public function setActionUrl($url)
	{
		$this->actionUrl = $url;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setPostMethod()
	{
		$this->method = 'post';
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setGetMethod()
	{
		$this->method = 'get';
		return $this;
	}

	/**
	 * @param bool $bool
	 * @return $this
	 */
	public function setSecureTokenActive($bool)
	{
		$this->secureTokenActive = (bool)$bool;
		return $this;
	}

	/**
	 * @param string $token
	 * @return $this
	 */
	public function setLastFormToken($token)
	{
		$this->lastFormToken = $token;
		return $this;
	}
}
