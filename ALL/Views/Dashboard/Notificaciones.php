<?php 
    encabezado();
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Notificaciones</h1>
        <!-- Content Row -->

        <!-- AQUI HABRA UN SWICHT -->
        <?php foreach ($data1 as $activas) { ?>
            <?php switch ($activas['relevancia']) {
                case 1:
                    echo "<div class='card mb-2 py-3 border-left-warning'>";
                    break;
                case 2:
                    echo "<div class='card mb-2 py-3 border-left-danger'>";
                    break;
                default:
                    echo "<div class='card mb-2 py-3 border-left-primary'>";
                    break;
            } ?>
                <div class="card-body">
                    <form action="<?= base_url(); ?>Dashboard/EliminarNoti?id=<?= $activas['id'];?>" method="post" class="elimnoti">
                        <button class="d-sm-inline-block float-right btn btn-light" type="submit"><i class="fas fa-times fa-sm"></i></button>
                    </form>
                    <div class="row">
                        <div class="col-auto">
                            <div class="mr-3">
                                <?php switch ($activas['relevancia']) {
                                    case 1:
                                        echo "<div class='icon-circle bg-warning'><i class='fas fa-exclamation-triangle text-white'></i></div>";
                                        break;
                                    case 2:
                                        echo "<div class='icon-circle bg-danger'><i class='fas fa-skull-crossbones text-white'></i></div>";
                                        break;
                                    default:
                                        echo "<div class='icon-circle bg-primary'><i class='fas fa-heart text-white'></i></div>";
                                        break;
                                } ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div>
                                <div class="small text-gray-500"><?= $activas['fecha'];?></div>
                                <?= $activas['descripcion'];?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- /.container-fluid -->

<?php 
    pie();
?>