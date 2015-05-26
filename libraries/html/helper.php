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
class jpHtmlHelper extends jpHtmlBase
{
	/**
	 * @return jpHtmlTable
	 */
	public function getTable()
	{
		return new jpHtmlTable();
	}

	/**
	 * @return jpHtmlList
	 */
	public function getList()
	{
		return new jpHtmlList();
	}

	/**
	 * @return jpHtmlNavlist
	 */
	public function getNavList()
	{
		return new jpHtmlNavlist();
	}

	/**
	 * @return jpHtmlForm
	 */
	public function getForm()
	{
		return new jpHtmlForm();
	}

	/**
	 * Generates and returns a page header html box. 
	 *
	 * @param string $title
	 * @param int $size
	 * @param string $class
	 * @return html
	 */
	public function renderPageHeader($title, $size = 1, $class = '')
	{
		ob_start();

		?>
		<div class="<?php echo 'page-header'.$class; ?>">
			<h<?php echo $size; ?>>
				<?php echo $title; ?>
			</h<?php echo $size; ?>>
		</div>
		<?php

		$buffer = ob_get_clean();

		if(!$this->getBufferMode()) {
			return $buffer;
		}

		$this->addBuffer($buffer);	
	}

	/**
	 * Returns the given html enclosured with a twitter bootstrap grid container.
	 *
	 * @param string $content
	 * @param bool $fluid
	 * @param string $class
	 * @return string
	 */
	public function renderGridContainer($content, $fluid = false, $class = '')
	{
		ob_start();

		$cssClass = 'container'.$class;

		if($fluid) {
			$cssClass = 'container-fluid'.$class;
		}

		?>
		<div class="<?php echo $cssClass; ?>">
			<?php echo $content; ?>
		</div>
		<?php

		$buffer = ob_get_clean();

		if(!$this->getBufferMode()) {
			return $buffer;
		}

		$this->addBuffer($buffer);
	}

	/**
	 * Returns the given html enclosured with a twitter bootstrap grid row.
	 *
	 * @param string $content
	 * @param bool $fluid
	 * @param string $class
	 * @return string
	 */
	public function renderGridRow($content, $fluid = false, $class = '')
	{
		ob_start();

		$cssClass = 'row'.$class;

		if($fluid) {
			$cssClass = 'row-fluid'.$class;
		}

		?>
		<div class="<?php echo $cssClass; ?>">
			<?php echo $content; ?>
		</div>
		<?php

		$buffer = ob_get_clean();

		if(!$this->getBufferMode()) {
			return $buffer;
		}

		$this->addBuffer($buffer);
	}

	/**
	 * Returns the given html enclosured with a twitter bootstrap grid col by given type and width.
	 *
	 * @param string $content
	 * @param string $type
	 * @param int $width
	 * @param string $class
	 * @return string
	 */
	public function renderGridCol($content, $type = 'lg', $width = 12, $class = '')
	{
		ob_start();

		?>
		<div class="col-<?php echo $type.'-'.$width.$class; ?>">
			<?php echo $content; ?>
		</div>
		<?php

		$buffer = ob_get_clean();

		if(!$this->getBufferMode()) {
			return $buffer;
		}

		$this->addBuffer($buffer);
	}

	/**
	 * Generates a twitter bootstrap panel box with type, title and given body html.
	 *
	 * @param string $title
	 * @param string $content
	 * @param string $type
	 * @param string $class
	 * @return html
	 */
	public function renderPanel($title, $content, $type = 'default', $class = '')
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
				<?php echo $content; ?>
			</div>
		</div>
		<?php

		$buffer = ob_get_clean();

		if(!$this->getBufferMode()) {
			return $buffer;
		}

		$this->addBuffer($buffer);
	}

	/**
	 * Generates a sidebar-module box.
	 *
	 * @param string $title
	 * @param html $content
	 * @param bool $inset
	 * @param string $class
	 * @return html
	 */
	public function renderModule($title, $content, $inset = false, $class = '')
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
				<?php echo $content; ?>
			</div>
		</div>
		<?php

		$buffer = ob_get_clean();

		if(!$this->getBufferMode()) {
			return $buffer;
		}

		$this->addBuffer($buffer);
	}
}
