// actions.js

var navMenuIsExpanded = false

var navBar = document.getElementById('navbar')
var navPadding = document.getElementById('nav-padding')

function setMenuState() {
	if($(this).scrollTop() > $('#header').outerHeight()) {
		$('#nav-padding').css('height', $('#navbar').outerHeight())
		$("#navbar").addClass('sticky-top')

		//navPadding.style.height = navBar.offsetHeight
		//navBar.classList.add('sticky-top')

	} else {
		$('#nav-padding').css('height', '0')
		$("#navbar").removeClass('sticky-top')

		//navPadding.style.height = 0
		//navBar.classList.remove('sticky-top')

	}
}

window.addEventListener('touchmove', setMenuState, false)
window.addEventListener('scroll', setMenuState, false)

$('#nav-button').click(function() {
	if (navMenuIsExpanded === false) {
		$('#nav-button-icon').html('close')
		navMenuIsExpanded = true
	} else {
		$('#nav-button-icon').html('menu')
		$('#nav-padding').css('height', '0')
		navMenuIsExpanded = false
	}
	$('#nav-items').slideToggle()
})
