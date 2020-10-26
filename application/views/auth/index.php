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
                            <li class="breadcrumb-item active" aria-current="page">Lista de Usuarios</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-7">
                <div class="text-right upgrade-btn" HIDDEN>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- column -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">Lista de Usuarios</h4>
                                <h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
                            </div>
                            <div class="ml-auto">
                                <div class="dl">
                                </div>
                            </div>
                        </div>
                        <!-- title -->
                    </div>
                    <div class="table-responsive">
                        <table class="table v-middle">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-top-0">Nombre</th>
                                    <th class="border-top-0">Apellido</th>
                                    <th class="border-top-0">Correo</th>
                                    <th class="border-top-0">Grupo</th>
                                    <th class="border-top-0">Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user){
                                
                            ?>
                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?>
                                    </td>
                                    <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                                    <td>
                                        <?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?>
                                    </td>
                                    <td>
                                        <?php foreach ($user->groups as $group){
                                            if($group->id == 1) {
                                                echo anchor("auth/edit_group/".$group->id, htmlspecialchars("Administrador",ENT_QUOTES,'UTF-8')) ;
                                            }else {
                                                echo anchor("auth/edit_group/".$group->id, htmlspecialchars("Ventas",ENT_QUOTES,'UTF-8')) ;
                                            }
                                         ?><br />
                                        <?php } ?>
                                    </td>
                                    <td><?php echo anchor("auth/edit_user/".$user->id, 'Editar') ;?></td>

                                </tr>
                                <?php 
                                }
                            ?>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <a class="btn btn-success text-white" href="<?= base_url('auth/create_user') ?>">Crear
                                    nuevo usuario</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>