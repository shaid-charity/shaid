// blogpost.js

var deletePostModal = {
	element: document.getElementById('delete-post-modal'),
	isVisible: false
}


function hidePostModal() {
	deletePostModal.element.style.visibility = 'hidden';
	deletePostModal.element.style.opacity = '0.0';
	deletePostModal.isVisible = false;
}


function showPostModal() {
	deletePostModal.element.style.visibility = 'visible';
	deletePostModal.element.style.opacity = '1.0';
	deletePostModal.isVisible = true;
}


window.onkeyup = function(e) {
	var key = e.keyCode ? e.keyCode : e.which;
	if (key === 27) {
		// Escape
		if (deletePostModal.isVisible) {
			hidePostModal();
		}
	}
}


$('#delete-post-button').click(function() {
	if (!deletePostModal.isVisible) {
		showPostModal();
	} else {
		hidePostModal();
	}
});


$('#delete-post-modal').click(function() {
	if (deletePostModal.isVisible) {
		hidePostModal();
	}
});

$('#delete-post-message').click(function (e) {
    // Stop propagation to delete-post-modal element
    // i.e. foreground click will not close modal
    e.stopPropagation();
})
