<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php include("menu.php"); ?>

        <title><?php echo $_SESSION['nome_sistema']; ?> | Inicio</title>
        <br><br>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                                <i class="pe-7s-ball icon-gradient bg-mean-fruit">
                                </i>
                            </div>
                            <div>Bem Vindo ao Sistema!
                                <div class="page-title-subheading"><?php echo $_SESSION['nome_sistema']; 
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>