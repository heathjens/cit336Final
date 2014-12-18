
function ChangeUserRole(id, role) {
	var confirmed = confirm("Change the user's role to: " + role);
	
	if (confirmed) {
		
		window.location = '/?action=changerole&userid=' + id + '&role=' + role;
	}
}

function DeleteUser(id) {
	var confirmed = confirm("Delete user?");
	
	if (confirmed) {
		
		window.location = '/?action=deleteuser&id=' + id;
	}	
}

function DeleteItem(id) {
	var confirmed = confirm("Really delete?");
	
	if (confirmed) {
		window.location = '/?action=deleteitem&itemId=' + id;
	}
}
