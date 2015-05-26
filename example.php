<?php
/**
 * Holds an example of generating a responsive grid form with secure token containing twitter bootstrap 3.
 *
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.0
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
		require_once './libraries/html/form.php';

		$htmlHelper = new jpHtmlHelper();
		$formHelper = $htmlHelper->getForm();

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
		$formHelper->setBufferMode(true)
				   ->setActionUrl($_SERVER['PHP_SELF'])
				   ->setSecureTokenActive(true)
				   ->setFormStyleDefault()
				   ->setColWidth(array(5, 7));

		/*
		 * add form groups to the forms output buffer
		 */
		$formHelper->addFormGroup (
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
		 * get the buffer with reset, to generate a new form elements group.
		 */
		$dbGroups = $formHelper->getBuffer(true);

		$formHelper->addFormGroup (
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
		 * get the buffer with reset, to allow enclosuring the form elements groups with some grid boxes.
		 */
		$userGroups = $formHelper->getBuffer(true);


		/*
		 * now enclosure the above generated groups with grid boxes and put them together to one buffer.
		 */
		$cols = $htmlHelper->renderGridCol($htmlHelper->renderPanel('Database', $dbGroups, 'default'), 'lg', 4)
			  .$htmlHelper->renderGridCol($htmlHelper->renderPanel('User', $userGroups, 'default'), 'lg', 4)
			  .$htmlHelper->renderGridCol($htmlHelper->renderPanel('Settings', '<p>In progress</p>', 'default'), 'lg', 4);

		$formHelper->setBufferMode(false);

		/*
		 * now enclosure the above generated grid boxes with the form, grid rows and the form buttons.
		 */
		$formHelper->begin()->addBuffer (
			$htmlHelper->renderGridRow($cols)
			.$htmlHelper->renderGridRow (
				$htmlHelper->renderGridCol (
				$formHelper->addButton('Absenden', 'submit', 'sbutton')
					.$formHelper->addButton('Zurücksetzen', 'reset', 'reset'),
				'lg',
				12
				)
			)
		);
		$formHelper->commit();

		/*
		 * put the form into a grid container to let the grid row boxes work.
		 */
		$container = $htmlHelper->renderGridContainer (
			$htmlHelper->renderPageHeader('Installation').$formHelper->getBuffer(true)
		);

		/*
		 * now its finished and we have a responsive form with grid row box panels.
		 */
		echo $container;
		?>
	</body>
</html>
<?php session_write_close(); ?>
