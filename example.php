<?php session_start(); ?>
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
		/**
		 * Holds an example of generating a responsive grid form with secure token containing twitter bootstrap 3.
		 *
		 * @package jpFramework
		 * @author Philipp John <info@jplace.de>
		 * @version 0.1
		 * @license MIT - http://opensource.org/licenses/MIT
		 */

		define('_JPEXEC', 1);

		require_once './libraries/html/helper/base.php';
		require_once './libraries/html/helper.php';
		require_once './libraries/html/helper/form.php';

		$htmlHelper = new jpfwHtmlHelper();
		$formHelper = new jpfwHtmlHelperForm();

		if(isset($_SESSION['form_token'])) {
			$formHelper->setLastFormToken($_SESSION['form_token']);
		}

		if(isset($_POST['sbutton'])) {
			var_dump(
				$_POST,
				$formHelper->validateToken()
			);
		}

		/*
		 * Init some general form settings
		 */
		$formHelper->setMode('buffer');
		$formHelper->setActionUrl($_SERVER['PHP_SELF']);
		$formHelper->setSecureTokenActive(true);
		$formHelper->setFormStyleDefault();
		$formHelper->setColWidth(array(5, 7));

		/*
		 * add form groups to the forms output buffer
		 */
		$formHelper->getFormGroup (
			'Server-Address',
			'text',
			'db_server',
			'dbServer',
			'Server-Address'
		);

		$formHelper->getFormGroup (
			'Server-Port',
			'text',
			'db_port',
			'dbPort',
			'Server-Port'
		);

		$formHelper->getFormGroup (
			'DB-Name',
			'text',
			'db_name',
			'dbName',
			'Database-Name'
		);

		$formHelper->getFormGroup (
			'DB-Username (read only)',
			'text',
			'db_user',
			'dbUser',
			'Username'
		);

		$formHelper->getFormGroup (
			'DB-Password (read only)',
			'password',
			'db_passwd',
			'dbPasswd',
			'Password'
		);

		$formHelper->getFormGroup (
			'DB-Username (read/write)',
			'text',
			'db_user_master',
			'dbUserMaster',
			'Username'
		);

		$formHelper->getFormGroup (
			'DB-Password (read/write)',
			'password',
			'db_passwd_master',
			'dbPasswdMaster',
			'Password'
		);

		/*
		 * get the buffer with reset, to generate a new form elements group.
		 */
		$dbGroups = $formHelper->getBuffer(true);

		$formHelper->getFormGroup (
			'Username',
			'text',
			'user_name',
			'userName',
			'Username'
		);

		$formHelper->getFormGroup (
			'Password',
			'password',
			'user_passwd',
			'userPasswd',
			'Password'
		);

		$formHelper->getFormGroup (
			'E-mail',
			'email',
			'user_mail',
			'userMail',
			'E-mail address'
		);

		/*
		 * get the buffer with reset, to allow enclosuring the form elements groups with some grid boxes.
		 */
		$userGroups = $formHelper->getBuffer(true);


		/*
		 * now enclosure the above generated groups with grid boxes and put them together to one buffer.
		 */
		$cols = $htmlHelper->getGridCol('lg', 4, $htmlHelper->getPanel('Database', 'default', $dbGroups))
			  .$htmlHelper->getGridCol('lg', 4, $htmlHelper->getPanel('User', 'default', $userGroups))
			  .$htmlHelper->getGridCol('lg', 4, $htmlHelper->getPanel('Settings', 'default', '<p>In progress</p>'));

		$formHelper->resetMode();

		/*
		 * Set the form script, which will be outputted together with the form.
		 */
		$formHelper->setFormScript('<script>alert("Hello World")</script>');

		/*
		 * now enclosure the above generated grid boxes with the form, grid rows and the form buttons.
		 */
		$row = $formHelper->getForm (
			$htmlHelper->getGridRow($cols)
			.$htmlHelper->getGridRow (
				$htmlHelper->getGridCol (
				'lg',
				12,
				$formHelper->getButton('Absenden', 'submit', 'sbutton').
				$formHelper->getButton('Zurücksetzen', 'reset', 'reset')
				)
			)
		);

		/*
		 * put the form into a grid container to let the grid row boxes work.
		 */
		$container = $htmlHelper->getGridContainer (
			$htmlHelper->getPageHeader('Installation').$row
		);

		/*
		 * now its finished and we have a responsive form with grid row box panels.
		 */
		echo $container;
		?>
	</body>
</html>
<?php session_write_close(); ?>
