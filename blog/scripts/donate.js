// donate.js


var globalDonateModal = {
	element: document.getElementById('campaign-donate-modal'),
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


$('#campaign-donate-button').click(function() {
	if (!globalDonateModal.isVisible) {
		showDonateModal();
	} else {
		hideDonateModal();
	}
});


$('#close-campaign-donate-modal-button').click(function() {
	if (globalDonateModal.isVisible) {
		hideDonateModal();
	}
});


$('#campaign-donate-modal').click(function() {
	if (globalDonateModal.isVisible) {
		hideDonateModal();
	}
});


$('#campaign-donate-modal-message').click(function (e) {
    // Stop propagation to campaign-donate-modal element
    // i.e. foreground click will not close modal
    e.stopPropagation();
})
