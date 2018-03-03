// actions.js

var navMenuIsExpanded = false

var header = document.getElementById('header')
var navBar = document.getElementById('navbar')
var navItems = document.getElementById('nav-items')

function setMenuState() {
	if($(this).scrollTop() > header.offsetHeight) {
		navbar.classList.add('sticky-top')
		document.getElementById('nav-padding').style.height = navbar.offsetHeight
	} else {
		document.getElementById('nav-padding').style.height = '0'
		navbar.classList.remove('sticky-top')
	}
}

window.addEventListener('touchmove', setMenuState)
window.addEventListener('scroll', setMenuState)

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
