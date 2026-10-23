(function($) {
	
	"use strict";

	function mobileMenu() {
	const $mobileMenu = $('.mobile-menu');

	// Ensure mobile menu exists
	if (!$mobileMenu.length) return;

	// Avoid duplicating dropdown buttons
	$mobileMenu.find('li.menu-item-has-children, li.has-mega__menu').each(function () {
		if (!$(this).children('.dropdown-btn').length) {
			$(this).append('<div class="dropdown-btn"><span class="fa fa-angle-down"></span></div>');
		}
	});

	// Toggle submenu on dropdown button click
	$mobileMenu.off('click', '.dropdown-btn').on('click', '.dropdown-btn', function (e) {
		e.preventDefault();
		const $parentLi = $(this).parent('li');

		// Check for normal dropdown
		if ($parentLi.hasClass('menu-item-has-children')) {
			const $submenu = $parentLi.children('ul');

			if ($submenu.is(':visible')) {
				$parentLi.removeClass('open');
				$submenu.slideUp(300);
			} else {
				$parentLi.siblings('.menu-item-has-children').removeClass('open').children('ul').slideUp(300);
				$parentLi.toggleClass('open');
				$submenu.slideToggle(300);
			}
		}

		// Check for mega menu
		else if ($parentLi.hasClass('has-mega__menu')) {
			const $megaContent = $parentLi.children('.finspire-mega-menu-content');

			if ($megaContent.is(':visible')) {
				$parentLi.removeClass('open');
				$megaContent.slideUp(300);
			} else {
				// Close other open mega menus
				$parentLi.siblings('.has-mega__menu').removeClass('open').children('.finspire-mega-menu-content').slideUp(300);

				$parentLi.addClass('open');

				// Remove any inline display:none before sliding
				$megaContent.stop(true, true).css('display', 'none').slideDown(300);
			}
		}

	});


	// Disable parent link default behavior
	$mobileMenu.off('click', '.navigation li.menu-item-has-children > a')
		.on('click', '.navigation li.menu-item-has-children > a', function (e) {
			e.preventDefault();
	});

	// Disable parent link default behavior
	$mobileMenu.off('click', '.navigation li.has-mega__menu > a')
		.on('click', '.navigation li.has-mega__menu > a', function (e) {
			e.preventDefault();
	});

	// Mobile nav toggle open
	$('.mobile-nav-toggler').off('click').on('click', function () {
		$('body').addClass('mobile-menu-visible');
	});

	// Mobile nav toggle close
	$('.mobile-menu .menu-backdrop, .mobile-menu .close-btn').off('click').on('click', function () {
		closeMobileMenu();
	});

	// Close on ESC key
	$(document).off('keydown.mobileMenu').on('keydown.mobileMenu', function (e) {
		if (e.key === 'Escape' || e.keyCode === 27) {
			closeMobileMenu();
		}
	});

	function closeMobileMenu() {
		$('body').removeClass('mobile-menu-visible');
		$mobileMenu.find('li').removeClass('open');
		$mobileMenu.find('ul').removeAttr('style'); 
	}
}

/*--------------------------------------------------------------
      Document Ready
    --------------------------------------------------------------*/
    $(document).ready(function () {
		mobileMenu();
	});


	

})(window.jQuery);