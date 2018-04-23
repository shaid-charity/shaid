// donate.js

// THIS IS UNUSED AS PAYPAL DOES NOT SUPPORT PASSING CUSTOM AMOUNTS FOR DONATIONS


var globalDonateModal = {
	element: document.getElementById('global-donate-modal'),
	isVisible: false
}


function hideDonateModal() {
	globalDonateModal.element.style.visibility = 'hidden';
	globalDonateModal.element.style.opacity = '0.0';
	globalDonateModal.isVisible = false;
}


function showDonateModal() {
	globalDonateModal.element.style.visibility = 'visible';
	globalDonateModal.element.style.opacity = '1.0';
	globalDonateModal.isVisible = true;
}


window.onkeyup = function(e) {
	var key = e.keyCode ? e.keyCode : e.which;
	if (key === 27) {
		// Escape
		if (globalDonateModal.isVisible) {
			hideDonateModal();
		}
	}
}


$('#global-donate-button').click(function() {
	if (!globalDonateModal.isVisible) {
		showDonateModal();
	} else {
		hideDonateModal();
	}
});


$('#close-global-donate-modal-button').click(function() {
	if (globalDonateModal.isVisible) {
		hideDonateModal();
	}
});


$('#global-donate-modal').click(function() {
	if (globalDonateModal.isVisible) {
		hideDonateModal();
	}
});


$('#global-donate-modal-message').click(function (e) {
    // Stop propagation to global-donate-modal element
    // i.e. foreground click will not close modal
    e.stopPropagation();
})
