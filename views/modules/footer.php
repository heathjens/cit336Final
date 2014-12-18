
<?php
$date = date("Y");
$footer = GetFooter();
?>

<footer> 
    <p> 
        <?php foreach ($footer as $key => $link) { ?>
            <a href="?action=<?php echo rawurlencode($key);?>" title="<?php echo $link;?>"><?php echo $link; ?></a>
        <?php } ?>

    </p>


    <p>
        &copy; <?php echo $date ?>  Heather Jensen</p> 
    <p>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img style="border:0;width:88px;height:31px"
                 src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
                 alt="Valid CSS!" />
        </a>
    </p>

</footer>
