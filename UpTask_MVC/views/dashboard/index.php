<?php include_once __DIR__ . '/header-dashboard.php' ?>

    <?php if(count($proyectos) === 0){ ?>
        <p class="no-proyectos">No Hay Proyectos Aún <a href="/crear-proyecto">Comienza creando uno</a></p>
    <?php }else{ ?>
        <ul class="listado-proyectos">
            <?php foreach($proyectos AS $proyecto){ ?>
                <li class="proyecto">
                    <!-- G3n3r4r Un Pr0y3c70 -->
                    <a href="/proyecto?id=<?php echo $proyecto->Url; ?>">
                        <?php echo $proyecto->Proyecto; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
<?php include_once __DIR__ . '/footer-dashboard.php' ?>
  