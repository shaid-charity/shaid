// actions.js

var navMenuIsExpanded = false
var navbarIsSticky = false

var headerHeight = $('.header').outerHeight()
var navbarHeight = $('.navbar').outerHeight()

function setMenuState() {
	if( $(this).scrollTop() > headerHeight) {
		$(".navbar").addClass('sticky-top')
		$('#nav-padding').css('height', navbarHeight)
		navbarIsSticky = true
	} else {
		$('#nav-padding').css('height', '0')
		$(".navbar").removeClass('sticky-top')
		navbarIsSticky = false
	}
}

function recalculateHeights() {
	headerHeight = $('.header').outerHeight()
	navbarHeight = $('.navbar').outerHeight()
}

window.addEventListener('touchmove', setMenuState)
window.addEventListener('scroll', setMenuState)
window.addEventListener('resize', recalculateHeights)

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
