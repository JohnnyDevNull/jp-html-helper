<?php
/**
 * Holds the formular helper class of the framework.
 *
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 0.1
 * @license MIT - http://opensource.org/licenses/MIT
 */

if (!defined('_JPEXEC')) {
	die('RESTRICTED ACCESS');
}

/**
 * Holds some functions the generate html formulars.
 *
 * @package jpFramework
 */
class jpfwHtmlHelperForm extends jpfwHtmlHelperBase
{
	/**
	 * Controls the output type of the form.
	 *
	 * @var string
	 */
	protected $_formType = 'form';

	/**
	 * Holds the forms action link.
	 *
	 * @var string
	 */
	protected $_actionUrl = '#';

	/**
	 * Holds the forms submit method.
	 *
	 * @var string
	 */
	protected $_method = 'post';

	/**
	 * Holds the colwidth for the form group elements.
	 *
	 * @var int[]
	 */
	protected $_colWidth = array(2, 10);

	/**
	 * @var string
	 */
	protected $_scriptBuffer = '';

	/**
	 * @var string
	 */
	protected $_secureTokenActive = true;

	/**
	 * Holds the generated form token.
	 *
	 * @var string
	 */
	protected $_formToken;

	/**
	 * Holds the old generated form token.
	 *
	 * @var string
	 */
	protected $_lastFormToken;

	/**
	 * Returns a generated form.
	 *
	 * @param string $type
	 * @param string $html
	 * @return html
	 */
	public function getForm($html = '')
	{
		ob_start();

		?>
		<form class="<?php echo $this->_formType?>"
			  action="<?php echo $this->_actionUrl; ?>"
			  method="<?php echo $this->_method; ?>"
			  role="form" >
			<?php
			if($this->_secureTokenActive) {
				$this->outputToken();
			}

			if($this->_mode === 'buffer' && empty($html)) {
				echo $this->getBuffer(true);
			} else {
				echo $html;
			}
			?>
		</form>
		<?php
		if(!empty($this->_scriptBuffer)) {
			echo $this->_scriptBuffer;
		}

		return ob_get_clean();
	}

	/**
	 * Generates and returns a form group element by the giving parameters.
	 *
	 * @param string $label
	 * @param string $inputType
	 * @param string $inputNameID
	 * @param string $placeholder
	 */
	public function getFormGroup($label, $inputType, $inputName, $inputID = '', $placeholder = '')
	{
		ob_start();

		$labelClass = '';

		if($this->_formType == 'form-horizontal') {
			$colLeft = $this->_colWidth[0];
			$colRight = $this->_colWidth[1];
			$labelClass = 'class="col-sm-'.$colLeft.' control-label"';
		}

		?>
		<div class="form-group">
			<label for="<?php echo $inputID; ?>" <?php echo $labelClass ?>>
				<?php echo $label; ?>
			</label>
			<?php if($this->_formType == 'form-horizontal') : ?>
			<div class="col-sm-<?php echo $colRight ?>">
			<?php endif ?>
			<input type="<?php echo $inputType; ?>"
				   class="form-control"
				   <?php echo 'name="'.$inputName.'"'; ?>
				   <?php echo !empty($inputID) ? 'id="'.$inputID.'"' : ''; ?>
				   <?php echo !empty($placeholder) ? 'placeholder="'.$placeholder.'"' : ''; ?> />
			<?php if($this->_formType == 'form-horizontal') : ?>
			</div>
			<?php endif ?>
		</div>
		<?php

		if($this->_mode !== 'buffer') {
			return ob_get_clean();
		}

		$this->addBuffer(ob_get_clean());
	}

	/**
	 * Generates and returns a form group element by the giving parameters.
	 *
	 * @param string $offset
	 * @param string $inputType
	 * @param string $inputID
	 * @param string $placeholder
	 */
	public function getFormGroupWithOffset($offset, $inputType, $inputID = '', $placeholder = '')
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

		if($this->_mode !== 'buffer') {
			return ob_get_clean();
		}

		$this->addBuffer(ob_get_clean());
	}

	/**
	 * Returns a submit-button for the form.
	 */
	public function getButton($text, $tpye, $name, $type = 'default')
	{
		ob_start();

		?>
			<button type="<?php echo $tpye ?>"
					name="<?php echo $name; ?>"
					class="btn btn-<?php echo $type; ?>">
				<?php echo $text; ?>
			</button>
		<?php

		if($this->_mode !== 'buffer') {
			return ob_get_clean();
		}

		$this->addBuffer(ob_get_clean());
	}

	/**
	 * Generates the form token from the clients ip adress and appended with a long random string.
	 *
	 * @return string
	 */
	protected function _generateToken()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$uniqid = uniqid(mt_rand(), true);
		return md5($ip . $uniqid);
	}

	/**
	 * Generates the Html for the hidden form input element and returns it as a string.
	 *
	 * @return string
	 */
	public function outputToken()
	{
		$this->_formToken = $this->_generateToken();
		$_SESSION['form_token'] = $this->_formToken;
		echo "<input type='hidden' name='form_token' id='form_token' value='".$this->_formToken."' />";
	}

	/**
	 * Function that validated the form token POST data.
	 *
	 * @return bool
	 */
	public function validateToken()
	{
		if($_POST['form_token'] == $this->_lastFormToken) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Sets the css class of the output form to "form".
	 */
	public function setFormStyleDefault()
	{
		$this->_formType = 'form';
	}

	/**
	 * Sets the css class of the output form to "form-horizontal".
	 */
	public function setFormStyleHorizontal()
	{
		$this->_formType .= '-horizontal';
	}

	/**
	 * Sets the css class of the output form to "form-inline".
	 */
	public function setFormStyleInline()
	{
		$this->_formType .= '-inline';
	}

	/**
	 * Sets the column width for the form group elements as an array.
	 *
	 * @param int[] $colWidth
	 */
	public function setColWidth($colWidth)
	{
		$this->_colWidth = $colWidth;
	}

	/**
	 * Sets the action url for the form.
	 *
	 * @param string $url
	 */
	public function setActionUrl($url)
	{
		$this->_actionUrl = $url;
	}

	/**
	 * Sets the form script, which will be outputted with the form.
	 *
	 * @param string $script
	 */
	public function setFormScript($script)
	{
		$this->_scriptBuffer = $script;
	}

	/**
	 * Appen a script to the existing script buffer, which will be outputted with the form.
	 *
	 * @param string $script
	 */
	public function appenFormSript($script)
	{
		$this->_scriptBuffer .= $script;
	}

	/**
	 * Sets the forms submit method.
	 *
	 * @param string $val
	 * @throws InvalidArgumentException
	 */
	public function setSubmitMethode($val)
	{
		if(!in_array($val, array('post', 'get'))) {
			throw new InvalidArgumentException('The given form method is not supported: '.$val);
		}

		$this->_method = $val;
	}

	/**
	 * Activates the secure token handling of the form.
	 */
	public function setSecureTokenActive($value)
	{
		$this->_secureTokenActive = (bool)$value;
	}

	/**
	 * Sets the last token for validation.
	 *
	 * @param string $token
	 */
	public function setLastFormToken($token)
	{
		$this->_lastFormToken = $token;
	}
}
