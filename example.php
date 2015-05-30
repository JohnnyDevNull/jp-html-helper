<?php
/**
 * Holds an example of generating a responsive grid form with secure token containing twitter bootstrap 3.
 *
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.1
 * @license MIT - http://opensource.org/licenses/MIT
 */

session_start(); ?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.min.css" />
		<script src="./assets/js/jquery-1.10.2.min.js" type="text/javascript"></script>
		<script src="./assets/js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
		<script src="./assets/js/jquery.form.js" type="text/javascript"></script>
		<script src="./assets/js/bootstrap.min.js" type="text/javascript"></script>
	</head>
	<body>
		<?php
		define('_JPEXEC', 1);

		require_once './libraries/html/base.php';
		require_once './libraries/html/helper.php';
		require_once './libraries/html/container.php';
		require_once './libraries/html/row.php';
		require_once './libraries/html/col.php';
		require_once './libraries/html/form.php';

		$page = new jpHtmlHelper(); // Holds the parent (main buffer)
		$form = $page->getForm(); // Extra Buffer for the Form
		$container = $page->getContainer(); // Extra Buffer for the grid container
		$row = $page->getRow(); // Extra Buffer for the grid rows
		$col = $page->getCol(); // Extra Buffer for the grid cols

		/*
		 * Open a new grid container without fluiding and flush it to the parents buffer.
		 */
		$container->setFluid(false);
		$container->begin()->flush();

		/*
		 * Generate the first row with the page header. The grid buffers have to
		 * be flushed to the parents buffer holding by $page
		 */
		$row->begin()->flush();
			$col->begin('lg', 12);
				$page->addPageHeader('Installation');
			$col->commit();
		$row->commit();

		if(isset($_SESSION['form_token'])) {
			$form->setLastFormToken($_SESSION['form_token']);
		}

		if(isset($_POST['sbutton'])) {
			var_dump(
				$_POST,
				$form->validateToken()
			);
		}

		/*
		 * Begin the form and flush it directly, that the form buffer can be
		 * used to generate the form groups by itself.
		 */
		$form
			->setActionUrl($_SERVER['PHP_SELF'])
			->setSecureTokenActive(true)
			->setColWidth(array(5, 7))
			->setID('adminForm')
			->addClass('admin-form')
			->begin('otherAdminForm', 'admin-install-form')
			->flush();

		/*
		 * Generate the second grid row with the panels and form groups.
		 */
		$row->begin()->flush();

			/*
			 * Generate the form groups
			 */
			$form->addFormGroup (
				'Server-Address',
				'text',
				'db_server',
				'dbServer',
				'Server-Address'
			) ->addFormGroup (
				'Server-Port',
				'text',
				'db_port',
				'dbPort',
				'Server-Port'
			) ->addFormGroup (
				'DB-Name',
				'text',
				'db_name',
				'dbName',
				'Database-Name'
			) ->addFormGroup (
				'DB-Username (read only)',
				'text',
				'db_user',
				'dbUser',
				'Username'
			) ->addFormGroup (
				'DB-Password (read only)',
				'password',
				'db_passwd',
				'dbPasswd',
				'Password'
			) ->addFormGroup (
				'DB-Username (read/write)',
				'text',
				'db_user_master',
				'dbUserMaster',
				'Username'
			) ->addFormGroup (
				'DB-Password (read/write)',
				'password',
				'db_passwd_master',
				'dbPasswdMaster',
				'Password'
			);

			/*
			 * Get the buffer with reset, to allow putting the form groups into
			 * a panel and generate a new group of input elements.
			 */
			$dbGroups = $form->getBuffer(true);

			$form->addFormGroup (
				'Username',
				'text',
				'user_name',
				'userName',
				'Username'
			) ->addFormGroup (
				'Password',
				'password',
				'user_passwd',
				'userPasswd',
				'Password'
			) ->addFormGroup (
				'E-mail',
				'email',
				'user_mail',
				'userMail',
				'E-mail address'
			);

			/*
			 * Get the buffer with reset, to allow putting the form groups into a panel.
			 */
			$userGroups = $form->getBuffer(true);

			/*
			 * Now we have to generate the grid coloumns flush them to the parents
			 * buffer and add the panels with the generated form group elements.
			 */
			$col->begin('lg', 4)->flush();
				$page->addPanel('Database', $dbGroups);
			$col->commit()->begin('lg', 4)->flush();
				$page->addPanel('User', $userGroups);
			$col->commit()->begin('lg', 4)->flush();
				$page->addPanel('Settings', '<p>In progress</p>');
			$col->commit();

		$row->commit()->begin()->flush();

			/*
			 * Last but not least generating the grid row for the form buttons.
			 */
			$col->begin('lg', '12');
				$form
					->addButton('Absenden', 'submit', 'sbutton')
					->addBuffer('&nbsp;')
					->addButton('Zurücksetzen', 'reset', 'reset')
					->commit();
			$col->commit();

		$row->commit();

		/*
		 * Close the form, container and flushs the page buffer to the out stream.
		 */
		$form->commit();
		$container->commit();
		$page->flush();
		?>
	</body>
</html>
<?php session_write_close(); ?>
