 
    <?php  foreach ($items as $item) : ?>

        <?php
        $url = $item['ImageURL'];
        $name = $item['Name'];
	$id = $item['ID'];
        $likes = $item['Likes'];
        $dislikes = $item['Dislikes'];
        $percent = $item['Percentages'] * 100;
        
        ?>

        <div class="item span_1">
            <a href="/?action=viewItem;itemId=<?php echo $item['ID']; ?>">
                <figure class="itemfigure">
                    <img src="<?php echo $item['ImageURL']; ?>" alt="<?php echo $item['Name']; ?>" >	
                    <figcaption>
                        <h2><?php echo $item['Name']; ?></h2>
                        Likes: <?php echo $item['Likes']; ?><br />
                        Dislikes: <?php echo $item['Dislikes']; ?><br />
                        <?php echo $percent; ?>% Inspiring
                    </figcaption>
                </figure>
            </a>
        </div>

    <?php endforeach; ?>
<main>

    <h1>Inspiration Gallery</h1>
    <p>This gallery is here to inspire you. If you <a href="/views/login.php">login</a> you can add
        you own inspiration or vote on your favorite inspiration. </p>

    <blockquote><em>&ldquo;Every great dream begins with a dreamer. Always remember, you have within you the strength,
            the patience, and the passion to reach for the stars to change the world.&ldquo;</em><strong> Harriet Tubman</strong></blockquote>

    <blockquote><em>"Genius is 1% inspiration and 99% perspiration."</em><strong> Thomas Edison</strong></blockquote>

    <blockquote><em>"You can't wait for inspiration, you have to go after it with a club."</em><strong> Jack London</strong></blockquote>




</main>
