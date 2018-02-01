// actions.js

var navMenuIsExpanded = false
var navbarIsSticky = false

function setMenuState() {
	if( $(this).scrollTop() > $('.header').outerHeight() ) {
		$('#nav-padding').css('height', $('.navbar').outerHeight())
		$(".navbar").addClass('sticky-top')
		navbarIsSticky = true
	} else {
		$('#nav-padding').css('height', '0')
		$(".navbar").removeClass('sticky-top')
		navbarIsSticky = false
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
