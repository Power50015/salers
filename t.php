<?php 
    
    ob_start();
    
    session_start();

    include 'init.php';

    $pageTitle = 'Home';

    include $tempDir . 'header.php';

    include $tempDir . 'nav.php';

?>



<?php

    include $tempDir . 'footer.php';

    ob_end_flush();

?>