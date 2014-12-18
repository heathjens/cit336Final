function DeleteItem(id) {
	var confirmed = confirm("Really delete?");
	
	if (confirmed) {
		window.location = '/?action=deleteitem&itemId=' + id;
	}
}
