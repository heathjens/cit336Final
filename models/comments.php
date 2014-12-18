<?php

function GetUserComment($userId) {
	$query = "SELECT * FROM comments WHERE userId=:Id";
	return DbSelect($query, array(':Id' => $userId));
}

function GetCommentsWithUsersForItem($itemId) {
	$query = "SELECT * FROM comments AS c
			  LEFT JOIN users AS u on u.Id = c.userId
			  WHERE c.itemId=:Id
			  ORDER by updated";
	return DbSelect($query, array(':Id' => $itemId));
}

function SaveComment($itemId, $userId, $comment)
{
	$query = "INSERT INTO comments(userId, itemId, comment) VALUES(:userId, :itemId, :comment)";
	return DbInsert($query, array(':userId' => $userId, ':itemId' => $itemId, ':comment' => $comment));

}
