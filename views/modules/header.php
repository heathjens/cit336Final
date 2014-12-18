<?php
$nav = GetPrimaryNavigationItems();
$subNav = GetSubNavigationItems();
?>

    <nav class="heading">
        <div class="logoContainer"><a href="/index.php"><img src="/images/inspired-logo2.png" alt="Inspired Web Design" class="logo"></a></div>


        <div>
            <ul class="nav">
                <?php foreach ($nav as $key => $link) { ?>
                    <li><a href="?action=<?php echo $key; ?>" title="<?php echo $link; ?>"><?php echo $link; ?></a>
                        <ul class="subNav">
                            <?php
                            foreach ($subNav as $sub) {
                                if ($sub[1] == $link) {
                                    ?>
                                    <li><a href="?action=<?php echo $sub[0]; ?>" title="<?php echo $sub[0]; ?>"><?php echo $sub[0]; ?></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
