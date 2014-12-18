<?php ?>

    <?php
   
	$url = $item['ImageURL'];
	$likes = $item['Likes'];
	$dislikes = $item['Dislikes'];
	$name = $item['Name'];
	$id = $item['ID'];
	$percent = $item['Percentages'] * 100;
?>

<script src="/js/itemdetails.js" ></script>

<main>
   	<figure>
		<img src="<?php echo $url;?>" alt="<?php echo $name;?>" />
                		<figcaption>
			<?php echo $name; ?><br />
			Likes: <?php echo $likes; ?>, Dislikes: <?php echo $dislikes; ?><br />
			<?php echo $percent; ?>% of Inspiration<br />
			<?php if (LoggedInUserIsAdmin()) : ?>
				<button id="removebutton" onclick="DeleteItem(<?php echo $id;?>);">Delete Item</button>
			<?php endif; ?>
		</figcaption>
	</figure>
	<a href="/?action=like&itemId=<?php echo $id; ?>&like=like">Likes</a>&nbsp;
	<a href="/?action=like&itemId=<?php echo $id; ?>&like=dislike">Dislikes</a>
	
	<?php foreach ($comments as $comment) : ?>
		<div id="commentdiv">
			<fieldset>
				<legend><?php echo $comment['firstName']; ?> : <?php echo $comment['updated']; ?></legend>
				<?php echo $comment['comment']; ?>	
			</fieldset>
		</div>
	<?php endforeach; ?>
	
	<?php if (CheckSession()) : ?>
		<p>
			Post a new comment:<br />
			<form id="commentform" method="POST" action="/?action=postcomment">
				<input type="hidden" name="itemId" value="<?php echo $id; ?>" />
				<textarea cols="40" rows="5" name="comment" id="commentarea"></textarea><br />
				<input type="submit" name="Submit" value="Submit" />
			</form>
		</p>
	<?php else : ?>
		<p>
			Please log in to post a comment.
		</p>
	<?php endif; ?>
</main>
