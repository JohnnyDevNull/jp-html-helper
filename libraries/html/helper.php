<?php
/**
 * Holds the html helper class of the framework.
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
 * Holds some functions the generate html.
 *
 * @package jpFramework
 */
class jpfwHtmlHelper extends jpfwHtmlHelperBase
{
	/**
	 * Holds the table head data.
	 *
	 * @var mixed[]
	 * @access protected
	 */
	protected $_head = array();

	/**
	 * Generates the HTML for a table.
	 *
	 * <table>
	 * <tr><th colspan="2" style="text-align:left;">Avaiable config indexes:</th></tr>
	 * <tr><td>'width'		</td><td>=> string		</td><td>The table width.</td>
	 * <tr><td>'class'		</td><td>=> string		</td><td>The css class of the table.</td>
	 * <tr><td>'cols'		</td><td>=> int			</td><td>Number of columns which will be outputted.</td>
	 * <tr><td>'col_width'	</td><td>=> string[]	</td><td>The width of each col as array.</td>
	 * </table>
	 * The config indexes can be set with the function $this->setConfig(array())
	 *
	 * @param bool $render Controls if the buffe should output directly or return the buffer as string.
	 * @return string Contains the html string with the table data.
	 */
	public function getTableHtml($render = true)
	{
		/*
		 * Set default config values, if no config is set.
		 */
		$width = '';
		$class = '';

		if(!empty($this->_config['width'])) {
			$width = ' width="'.$this->_config['width'].'"';
		}

		if(!empty($this->_config['class'])) {
			$class = $this->_config['class'];
		}

		if(!empty($this->_config['cols'])) {
			$cols = $this->_config['cols'];
		} else {
			$cols = count($this->_data[0]);
		}
		
		if(!empty($this->_config['col_width'])) {
			$colWidth = $this->_config['col_width'];
		} else {
			$colWidth = array();
			$widthValue = 100/(int)$cols;

			for($i = 0; $i < $cols; $i++) {
				$colWidth[$i] = number_format($widthValue, 2).'%';
			}
		}

		$buffer = '<table'.$width.' class="table '.$this->_mode.' '.$class.'">';
		$buffer .= '<colgroup>';

		for($i = 0; $i < $cols; $i++) {
			$buffer .= '<col';

			if($colWidth != 'none' && isset($colWidth[$i])) {
				$buffer .= ' style="width:'.$colWidth[$i].';"';
			}

			$buffer .= ' />';
		}

		$buffer .= '</colgroup>';

		if(!empty($this->_head)) {
			$buffer .= '<tr>';

			foreach($this->_head as $col) {
				$buffer .= '<th>'.$col.'</th>';
			}

			$buffer .= '</tr>';
		}

		foreach($this->_data as $row) {
			$buffer .= '<tr>';

			foreach($row as $col) {
				$buffer .= '<td>'.$col.'</td>';
			}

			$buffer .= '</tr>';
		}

		$buffer .= '</table>';

		if($render) {
			echo $buffer;
		} else {
			return $buffer;
		}
	}

	/**
	 * Generates the HTML for a list.
	 *
	 * <table>
	 * <tr><th colspan="2" style="text-align:left;">Avaiable config indexes:</th></tr>
	 * <tr><td>'class'		</td><td>=> string		</td><td>The main list css class.</td>
	 * <tr><td>'sub_class'	</td><td>=> string		</td><td>The sub lists css class.</td>
	 * <tr><td>'type'		</td><td>=> string		</td><td>The main list type. Can be a value of 'ul', 'ol'</td>
	 * <tr><td>'sub_type'	</td><td>=> string		</td><td>The sub lists type. Can be a value of 'ul', 'ol'</td>
	 * </table>
	 * The config indexes can be set with the function $this->setConfig(array())
	 *
	 * @return string Contains the html string with the table data.
	 */
	public function getListHtml($render = true)
	{
		$class = '';
		$subClass = '';
		$type = 'ul';
		$subType = 'ul';

		if(!empty($this->_config['class'])) {
			$class = $this->_config['class'];
		}

		if(!empty($this->_config['sub_class'])) {
			$subClass = $this->_config['sub_class'];
		}

		if(!empty($this->_config['type'])) {
			$type = $this->_config['type'];
		}

		if(!empty($this->_config['sub_type'])) {
			$subType = $this->_config['sub_type'];
		}

		$buffer = '<'.$type.' class="'.$this->_mode.' '.$class.'">';

		foreach($this->_data as $value) {
			$buffer .= '<li>';

			if(is_array($value)) {
				$buffer .= array_shift($value);
				$this->_getSubListHtml($subType, $subClass, $value, $buffer);
			} else {
				$buffer .= $value;
			}

			$buffer .= '</li>';
		}

		$buffer .= '</'.$type.'>';

		if($render){
			echo $buffer;
		} else {
			return $buffer;
		}
	}

	/**
	 * Generates the HTML for a sub list in a list.
	 *
	 * <b>Notice:</b> This is a rekursive function, which detect if a array
	 * exists in the data array and calls it self for each sub array.
	 *
	 * @param string $type Controls the list type. Possible values are "ul" / "ol"
	 * @param string $class Represent the css class of the list
	 * @param mixed[] $data Holds the data for the sublist
	 * @param string $buffer The buffer, which is passed by reference
	 * @access protected
	 */
	protected function _getSubListHtml($type, $class, $data, &$buffer)
	{
		if(!empty($class)) {
			$class = ' class="'.$class.'"';
		}

		$buffer .= '<'.$type.' '.$class.'>';

		foreach($data as $value) {
			$buffer .= '<li>';

			if(is_array($value)) {
				$buffer .= array_shift($value);
				$this->_getSubListHtml($type, $class, $value, $buffer);
			} else {
				$buffer .= $value;
			}

			$buffer .= '</li>';
		}

		$buffer .= '</'.$type.'>';
	}

	/**
	 * Set the head data.
	 *
	 * @param string[] $data
	 * @access public
	 */
	public function setHead($data)
	{
		$this->_head = $data;
	}

	/**
	 * Generates and returns a page header html box. 
	 *
	 * @param string $text
	 * @param int $size
	 * @param string $class
	 * @return html
	 */
	public function getPageHeader($text, $size = 1, $class = '')
	{
		ob_start();

		?>
		<div class="<?php echo 'page-header'.$class; ?>">
			<h<?php echo $size; ?>>
				<?php echo $text; ?>
			</h<?php echo $size; ?>>
		</div>
		<?php

		if($this->_mode !== 'buffer') {
			return ob_get_clean();
		}

		$this->addBuffer(ob_get_clean());	
	}

	/**
	 * Returns the given html enclosured with a twitter bootstrap grid container.
	 *
	 * @param string $html
	 * @param bool $fluid
	 * @param string $class
	 * @return string
	 */
	public function getGridContainer($html, $fluid = false, $class = '')
	{
		ob_start();

		$cssClass = 'container'.$class;

		if($fluid) {
			$cssClass = 'container-fluid'.$class;
		}

		?>
		<div class="<?php echo $cssClass; ?>">
			<?php

			if($this->_mode === 'buffer') {
				echo $this->getBuffer(true);
			} else {
				echo $html;
			}

			?>
		</div>
		<?php

		return ob_get_clean();
	}

	/**
	 * Returns the given html enclosured with a twitter bootstrap grid row.
	 *
	 * @param string $html
	 * @param bool $fluid
	 * @param string $class
	 * @return string
	 */
	public function getGridRow($html, $fluid = false, $class = '')
	{
		ob_start();

		$cssClass = 'row'.$class;

		if($fluid) {
			$cssClass = 'row-fluid'.$class;
		}

		?>
		<div class="<?php echo $cssClass; ?>">
			<?php

			if($this->_mode === 'buffer') {
				echo $this->getBuffer(true);
			} else {
				echo $html;
			}

			?>
		</div>
		<?php

		if($this->_mode !== 'buffer') {
			return ob_get_clean();
		}

		$this->addBuffer(ob_get_clean());
	}

	/**
	 * Returns the given html enclosured with a twitter bootstrap grid col by given type and width.
	 *
	 * @param string $type
	 * @param int $width
	 * @param string $html
	 * @param string $class
	 * @return string
	 */
	public function getGridCol($type = 'lg', $width = 12, $html = '', $class = '')
	{
		ob_start();

		?>
			<div class="col-<?php echo $type.'-'.$width.$class; ?>">
			<?php

			if($this->_mode === 'buffer') {
				echo $this->getBuffer(true);
			} else {
				echo $html;
			}

			?>
			</div>
		<?php

		if($this->_mode !== 'buffer') {
			return ob_get_clean();
		}

		$this->addBuffer(ob_get_clean());
	}

	/**
	 * Generates a twitter bootstrap panel box with type, title and given body html.
	 *
	 * @param string $title
	 * @param string $type
	 * @param html $html
	 * @param string $class
	 * @return html
	 */
	public function getPanel($title, $type = 'default', $html = '', $class = '')
	{
		ob_start();

		?>
		<div class="panel panel-<?php echo trim($type).$class; ?>">
			<div class="panel-heading">
				<h3 class="panel-title">
					<?php echo $title; ?>
				</h3>
			</div>
			<div class="panel-body">
				<?php echo $html; ?>
			</div>
		</div>
		<?php

		if($this->_mode !== 'buffer') {
			return ob_get_clean();
		}

		$this->addBuffer(ob_get_clean());
	}

	/**
	 * Generates a sidebar-module box.
	 *
	 * @param string $title
	 * @param html $html
	 * @param bool $inset
	 * @param string $class
	 * @return html
	 */
	public function getModule($title, $html = '', $inset = false, $class = '')
	{
		ob_start();

		$cssInset = '';

		if($inset) {
			$cssInset = 'sidebar-module-inset';
		}

		?>
			<div class="sidebar-module <?php echo $cssInset.' '.$class; ?>">
				<div class="module-heading">
					<h3 class="module-title">
						<?php echo $title; ?>
					</h3>
				</div>
				<div class="module-body">
					<?php echo $html; ?>
				</div>
			</div>
		<?php

		if($this->_mode !== 'buffer') {
			return ob_get_clean();
		}

		$this->addBuffer(ob_get_clean());
	}
}
