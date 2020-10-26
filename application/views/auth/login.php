<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>
	<link rel="icon" href="<?= base_url('app-assets/img/apple-touch-icon.png') ?>" sizes="32x32" type="image/png">
	<link rel="icon" href="<?= base_url('app-assets/img/apple-touch-icon.png') ?>" sizes="16x16" type="image/png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('app-assets/img/apple-touch-icon.png') ?>">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('app-assets/img/apple-touch-icon.png') ?>">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('app-assets/img/apple-touch-icon.png') ?>">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('app-assets/img/apple-touch-icon.png') ?>">
	<link rel="apple-touch-icon" href="<?= base_url('app-assets/img/apple-touch-icon.png" sizes="180x180') ?>">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url('app-assets/img/apple-touch-icon.png') ?>">
	<link rel="shortcut icon" type="image/png" href="<?= base_url('app-assets/img/apple-touch-icon.png') ?>">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport">

	<link rel="stylesheet" href="<?= base_url('app-assets/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('app-assets/css/atlantis.css') ?>">
</head>
<body class="login">
<div class="wrapper wrapper-login wrapper-login-full p-0">
	<div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-primary-gradient">
		<h1 class="title fw-bold text-white mb-3">Gestiona tu empresa con Escienza</h1>
		<p class="subtitle text-white op-7">Soluciones de software en la nube para tu negocio</p>
	</div>
	<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
		<div class="container container-login container-transparent animated fadeIn">
			<?php if( ! isset( $on_hold_message ) ) { ?>


				<?php echo form_open( 'auth/login', ['id' => 'login-form'] ); ?>

				<div class="login-form" id="form">
					<h3 class="text-center">Iniciar sesi&oacute;n</h3>
					<div class="form-group">
						<label for="username" class="placeholder"><b>Usuario / Correo Electr&oacute;nico</b></label>
						<input id="login_string" name="identity" type="text" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="password" class="placeholder"><b>Contrase&ntilde;a</b></label>
						<a href="#" class="link float-right">Recuperar Acceso</a>
						<div class="position-relative">
							<input
									id="login_pass"
									name="password"
									type="password"
									class="form-control"
									autocomplete="off"
									readonly="readonly"
									onfocus="this.removeAttribute('readonly');"
									<?php if( config_item('max_chars_for_password') > 0 ) echo 'maxlength="' . config_item('max_chars_for_password') . '"';?>
									required>

							<div class="show-password">
								<i class="icon-eye"></i>
							</div>
						</div>
					</div>

					<div class="form-group form-action-d-flex mb-3">
						<?php if( config_item('allow_remember_me') ){?>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="rememberme">
								<label class="custom-control-label m-0" for="rememberme">Recordar datos</label>
							</div>
						<?php }?>
						<input type="hidden" id="max_allowed_attempts" value="<?php echo config_item('max_allowed_attempts'); ?>"  id="contador"/>
						<input type="hidden" id="mins_on_hold" value="<?php echo ( config_item('seconds_on_hold') / 60 ); ?>" id="contador"/>
						<button type="submit" id="btn-login" class="btn btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Iniciar sesi&oacute;n</button>
					</div>

					<div class="login-account" hidden>
						<span class="msg">&iquest;A&uacute;n no tienes una cuenta?</span>
						<a href="#" id="show-signup" class="link">Reg&iacute;strate</a>
					</div>
				</div>
				</form>
			<?php }
			# EXCESSIVE LOGIN ATTEMPTS ERROR MESSAGE
			$error_display = ! isset( $on_hold_message )? 'display:none;': '';
			echo '<div class="login-form" id="on-hold-message" style=" '.$error_display. ' ">
		<h3 class="text-center">Inicios de sesi&oacute;n excesivos</h3>
		<p class="text-center">Su acceso a inicio de sesi&oacute;n y recuperaci&oacute;n de cuenta ha sido bloqueado por '. ( (int) config_item('seconds_on_hold') / 60 ) . ' minutos.</p>
		<p class="text-center">Cont&aacute;ctenos si necesita ayuda para acceder a su cuenta.</p>
		</div> ';
			?>

			<!--  -->

			<!--  -->
		</div>

		<div class="container container-signup container-transparent animated fadeIn" hidden>
			<h3 class="text-center">Reg&iacute;strate</h3>
			<div class="login-form">
				<div class="form-group">
					<label for="fullname" class="placeholder"><b>Nombre y Apellido</b></label>
					<input  id="fullname" name="fullname" type="text" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="email" class="placeholder"><b>Correo Electr&oacute;nico</b></label>
					<input  id="email" name="email" type="email" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="passwordsignin" class="placeholder"><b>Contrase&ntilde;a</b></label>
					<div class="position-relative">
						<input  id="passwordsignin" name="passwordsignin" type="password" class="form-control" required>
						<div class="show-password">
							<i class="icon-eye"></i>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="confirmpassword" class="placeholder"><b>Confirmar Contrase&ntilde;a</b></label>
					<div class="position-relative">
						<input  id="confirmpassword" name="confirmpassword" type="password" class="form-control" required>
						<div class="show-password">
							<i class="icon-eye"></i>
						</div>
					</div>
				</div>
				<div class="row form-sub m-0">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="agree" id="agree">
						<label class="custom-control-label" for="agree">Yo acepto los t&eacute;rminos y condiciones.</label>
					</div>
				</div>
				<div class="row form-action">
					<div class="col-md-6">
						<a href="#" id="show-signin" class="btn btn-danger btn-link w-100 fw-bold">Cancelar</a>
					</div>
					<div class="col-md-6">
						<a href="#" class="btn btn-secondary w-100 fw-bold">Reg&iacute;strate</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
