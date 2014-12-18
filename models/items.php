<?php
/// Deletes an item from the database.
function DeleteItem($itemId)
{
	if ($itemId)
	{
		$query = "DELETE FROM items WHERE ID=:id";
		$result = DbExecute($query, array(':id' => $itemId));
	}
}
/// Gets item from the database.
function GetItemById($id)
{
	$query = "SELECT * FROM items WHERE ID=:id";
	$result = DbSelect($query, array(':id' => $id));
	
	if (array_key_exists(0, $result))
	{
		return $result[0];
	}
	
	return false;
}
/// Retreives all items from the database
function GetOrderedItems() {
    $query = "SELECT * FROM items ORDER BY Percentages DESC, Likes DESC";
    $result = DbSelect($query);
   

    if (array_key_exists(0, $result))
    {
        return $result;
    }
    return false;
}
// Save a vote for an item.
function SaveItemVote($itemId, $direction)
{
	if ($item = GetItemById($itemId))
	{
		if ($direction == 1)
		{
			$fieldUpdate = 'Likes=Likes+1';
		}
		else
		{
			$fieldUpdate = 'Dislikes=Dislikes+1';
		}
		
		$query = "UPDATE items SET $fieldUpdate,Percentages=(Likes/(Likes+Dislikes)) WHERE ID=:id";
		DbExecute($query, array(':id' => $itemId));
	}
	else
	{
		
	}
}
// Saves new item
function SaveNewItem($name, $imageUrl)
{
	$query = "INSERT INTO items(Name, Likes, Dislikes, Percentages, ImageURL, CreatedBy) VALUES(:name, 0, 0, 0.0, :url, :userId)";
	$id = DbInsert($query, array(':name' => $name, ':url' => $imageUrl, ':userId' => GetLoggedInUserId()));
	return $id;
}
