<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-5">
                <h4 class="page-title">Usuarios</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar Usuario</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-7">
                <div class="text-right upgrade-btn">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->

            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-7 col-xlg-7 col-md-7">
                <div class="card">
                    <div class="card-body">

                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">Editar Usuario</h4>
                                <h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
                            </div>
                        </div>
                        <!-- title -->

                        <?php echo form_open(uri_string());?>

                        <?php echo form_hidden('id', $user->id);?>
                        <?php echo form_hidden($csrf); ?>
                        <div class="form-group">
                            <label class="col-md-12">Nombres</label>
                            <div class="col-md-12">
                                <?php echo form_input($first_name);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Apellidos</label>
                            <div class="col-md-12">
                                <?php echo form_input($last_name);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Correo</label>
                            <div class="col-md-12">
                                <?php echo form_input($email);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Compañia</label>
                            <div class="col-md-12">
                                <?php echo form_input($company);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Celular</label>
                            <div class="col-md-12">
                                <?php echo form_input($phone);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Contraseña</label>
                            <div class="col-md-12">
                                <?php echo form_input($password);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Confirmar contraseña</label>
                            <div class="col-md-12">
                                <?php echo form_input($password_confirm);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12"></label>
                            <div class="col-md-12">
                                <?php if ($this->ion_auth->is_admin()): ?>

                                <h3>Miembro de los grupos</h3>
                                <?php foreach ($groups as $group):?>
                                <label class="checkbox">
                                    <?php
                                    $gID=$group['id'];
                                    $checked = null;
                                    $item = null;
                                    foreach($currentGroups as $grp) {
                                        if ($gID == $grp->id) {
                                            $checked= ' checked="checked"';
                                        break;
                                        }
                                    }
                                    ?>
                                    <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"
                                        <?php echo $checked;?>>
                                    <?php 
                                    if($group['id'] == 1) {   
                                        echo htmlspecialchars("Administrador ");
                                    }else {
                                        echo htmlspecialchars(" Ventas");
                                    }
                                    
                                    //  echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                                </label>
                                <?php endforeach?>

                                <?php endif ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-success" type="submit">Guardar Cambios</button>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
    </div>