(function ($) {
    "use strict";
	
	// Scroll to a Specific Div
	if($('.scroll-to-target').length){
		$(".scroll-to-target").on('click', function() {
			let target = $(this).attr('data-target');
		   // animate
		   $('html, body').animate({
			   scrollTop: $(target).offset().top
			 }, 100);
	
		});
	}
	
	if ($('.one-page-menu').length) {
			$('.main-menu a[href^="#"], .scroll-to-target').on('click', function (e) {
				var target = this.hash;

				if (target.length > 1 || target !== "#") {
					e.preventDefault();

					var $target = $(target);
					if ($target.length) {
						var headerHeight = $('.main-header').outerHeight() || 100;
						$('html, body').animate({
							scrollTop: $target.offset().top - headerHeight
						}, 800);
					}
				}
			});
		}
	
	//Submenu Dropdown Toggle
	if($('.main-header li.dropdown ul').length){
		$('.main-header .navigation li.dropdown').append('<div class="dropdown-btn"><span class="flaticon-down"></span></div>');
		
	}
	
  function stickyHeader() {
    if($('.main-header').length){
		let windowpos = $(window).scrollTop();
		let siteHeader = $('.main-header');
		let scrollLink = $('.scroll-top');
		if (windowpos >= 110) {
			siteHeader.addClass('fixed-header');
			scrollLink.addClass('open');
		} else {
			siteHeader.removeClass('fixed-header');
			scrollLink.removeClass('open');
		}
	}
  }
	
  function scrollTopClass() {
		let scrollLink = $('.scroll-top');

		if ($('.stricky-fixed').length) {
			scrollLink.addClass('open');
		} else {
			scrollLink.removeClass('open');
		}
	  
	}
	
  function searchPopup() {
	  //Search Popup
		if($('#search-popup').length){

			//Show Popup
			$('.search-toggler').on('click', function() {
				$('#search-popup').addClass('popup-visible');
			});
			$(document).keydown(function(e){
				if(e.keyCode === 27) {
					$('#search-popup').removeClass('popup-visible');
				}
			});
			//Hide Popup
			$('.close-search,.search-popup .overlay-layer').on('click', function() {
				$('#search-popup').removeClass('popup-visible');
			});
		}
  }
	
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
	
  function handleWindowScroll() {
	  
	if ($(".stricked-menu").length) {
		var headerScrollPos = 130;
		var stricky = $(".stricked-menu");
		if ($(window).scrollTop() > headerScrollPos) {
			stricky.addClass("stricky-fixed");
		} else if ($(window).scrollTop() <= headerScrollPos) {
			stricky.removeClass("stricky-fixed");
		}
	}
  }
  
  function handlePreloader() {
    if($('.loader-wrap').length){
		$('.loader-wrap').delay(1000).fadeOut(500);
	}
  }
  
  (function preloaderCloseBind() {
    if ($(".preloader-close").length) {
        $(".preloader-close").on("click", function(){
            $('.loader-wrap').delay(200).fadeOut(500);
        })
    }
  })();
  
  (function wowInit() {
    if ($(".wow").length && typeof WOW !== "undefined") {
      var wow = new WOW({
        mobile: false,
      });
      wow.init();
    }
  })();
	
  function faqAccordian() {
	  if($('.accordion-box').length){
		$(".accordion-box").on('click', '.acc-btn', function() {
			
			let outerBox = $(this).parents('.accordion-box');
			let target = $(this).parents('.accordion');
			
			if($(this).hasClass('active')!==true){
				$(outerBox).find('.accordion .acc-btn').removeClass('active');
			}
			
			if ($(this).next('.acc-content').is(':visible')){
				return false;
			}else{
				$(this).addClass('active');
				$(outerBox).children('.accordion').removeClass('active-block');
				$(outerBox).find('.accordion').children('.acc-content').slideUp(300);
				target.addClass('active-block');
				$(this).next('.acc-content').slideDown(300);	
			}
		});	
	}
  }
	
  function countBoxActive($scope) {
    $scope = $scope || $(document);

    if ($scope.find('.count-box').length) {
        $scope.find('.count-box').appear(function () {

            let $t = $(this),
                $countText = $t.find(".count-text"),
                n = $countText.attr("data-stop"),
                r = parseInt($countText.attr("data-speed"), 10);

            if (!$t.hasClass("counted")) {
                $t.addClass("counted");

                $({ countNum: $countText.text() }).animate(
                    { countNum: n },
                    {
                        duration: r,
                        easing: "linear",
                        step: function () {
                            $countText.text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            $countText.text(this.countNum);
                        }
                    }
                );
            }

        }, { accY: 0 });
    }
}
	
	function lightboxActive($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.lightbox-image').length) {
			$scope.find('.lightbox-image').fancybox({
				openEffect  : 'fade',
				closeEffect : 'fade',
				helpers : {
					media : {}
				}
			});
		}
	}
	
	function tabsActive($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.tabs-box').length) {

			$scope.find('.tabs-box .tab-buttons .tab-btn').on('mouseenter', function (e) {
				e.preventDefault();

				let target = $($(this).attr('data-tab'));

				if ($(target).is(':visible')) {
					return false;
				} else {

					let $tabsBox = $(this).closest('.tabs-box');

					// Remove active state from all buttons
					$tabsBox.find('.tab-buttons .tab-btn').removeClass('active-btn');

					// Add active state to hovered button
					$(this).addClass('active-btn');

					// Hide all tabs
					$tabsBox.find('.tabs-content .tab')
						.removeClass('active-tab')
						.hide();

					// Show active tab
					$(target)
						.fadeIn(150)
						.addClass('active-tab');
				}
			});
		}
	}
	
	function tabsActiveTwo($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.tabs-box-2').length) {
			$scope.find('.tabs-box-2 .tab-buttons .tab-btn').on('click', function (e) {
				e.preventDefault();

				let target = $($(this).attr('data-tab'));

				if ($(target).is(':visible')) {
					return false;
				} else {
					let $tabsBox = $(this).closest('.tabs-box-2');

					$tabsBox.find('.tab-buttons .tab-btn').removeClass('active-btn');
					$(this).addClass('active-btn');

					$tabsBox.find('.tabs-content .tab')
						.fadeOut(0)
						.removeClass('active-tab');

					$(target)
						.fadeIn(100)
						.addClass('active-tab');
				}
			});
		}
	}


  
  function odometerActive($scope) {
    $scope = $scope || $(document);
    if ($scope.find(".odometer").length) {
      var odo = $scope.find(".odometer");
      odo.each(function () {
        $(this).appear(function () {
          var countNumber = $(this).attr("data-count");
          $(this).html(countNumber);
        });
      });
    }
  }
	
  function niceSelectInit($scope) {
    $scope = $scope || $(document);
    if ($scope.find("select:not(.ignore)").length && $.fn.niceSelect) {
      $scope.find("select:not(.ignore)").niceSelect();
    }
  }
  
  function initProgressBars($scope) {
    $scope = $scope || $(document);
    if ($scope.find(".count-bar").length) {
      $scope.find(".count-bar").appear(
        function () {
          var el = $(this);
          var percent = el.data("percent");
          $(el).css("width", percent).addClass("counted");
        },
        { accY: -50 }
      );
    }
  }
  
  function circleTypeInit($scope) {
    // Normalize $scope (Elementor/jQuery safe)
    if (!$scope) {
        $scope = document;
    } else if (typeof jQuery !== "undefined" && $scope instanceof jQuery) {
        $scope = $scope[0];
    } else if (!$scope.querySelectorAll) {
        $scope = document;
    }

    // Moving items activation
    const movingItems = $scope.querySelectorAll(".moving-item");

    if (movingItems.length > 0) {
        movingItems[0].classList.add("active");

        movingItems.forEach(item => {
            item.addEventListener("mouseenter", function () {
                movingItems.forEach(el => el.classList.remove("active"));
                this.classList.add("active");
            });
        });
    }

    // Safe CircleType init
    function initCurvedText(selector, options = {}) {
        try {
            const element = $scope.querySelector(`#${selector}`);
            if (!element || typeof CircleType === "undefined") return;

            const circle = new CircleType(element);

            if (options.radius !== undefined) circle.radius(options.radius);
            if (options.direction !== undefined) circle.dir(options.direction);

        } catch (e) {
            // silent
        }
    }

    initCurvedText('curve_text_1', { radius: 60 });
    initCurvedText('curve_text_2', { radius: 75 });
    initCurvedText('curve_text_3', { radius: 77 });

    // Pie chart
    const circles = $scope.querySelectorAll(".circle");

    if (circles.length > 0) {
        circles.forEach(circle => {
            const percent = parseFloat(circle.getAttribute("data-percent"));
            if (isNaN(percent)) return;

            const deg = (percent / 100) * 360;

            circle.style.background = `
                conic-gradient(
                    #e65a4f ${deg}deg,
                    #f2f2f2 ${deg}deg
                )
            `;
        });
    }
}

  
  function scrollToTargetInit($scope) {
    $scope = $scope || $(document);
    if ($scope.find(".scroll-to-target").length) {
      $scope.find(".scroll-to-target").off("click").on("click", function () {
        var target = $(this).attr("data-target");
        
        $("html, body").animate(
          {
            scrollTop: $(target).offset().top,
          },
          10
        );
      });
    }
  }
	
  function sidebarPopupInit() {
  
  if($('#sidebar-popup').length){
		
		//Show Popup
		$('.sidebar-toggler').on('click', function() {
			$('#sidebar-popup').addClass('popup-visible');
		});
		$(document).keydown(function(e){
	        if(e.keyCode === 27) {
	            $('#sidebar-popup').removeClass('popup-visible');
	        }
	    });
		//Hide Popup
		$('.close-popup,.sidebar-popup .overlay-layer').on('click', function() {
			$('#sidebar-popup').removeClass('popup-visible');
		});
	}
}
	
	function bannerCarouselActive($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.banner-carousel').length) {
			$scope.find('.banner-carousel').each(function () {

				new Swiper(this, {
					direction: 'horizontal',
					effect: "fade",
					slidesPerView: 1,
					spaceBetween: 30,
					speed: 2500,
					loop: true,
					autoplay: {
						delay: 5000,
					},
					pagination: {
						el: $(this).find('.banner-pagination')[0],
						clickable: true
					},
					navigation: {
						nextEl: $(this).find('.swiper-prev')[0],
						prevEl: $(this).find('.swiper-next')[0],
					},
					breakpoints: {
						1024: { slidesPerView: 1 },
						800:  { slidesPerView: 1 },
						600:  { slidesPerView: 1 },
						480:  { slidesPerView: 1 },
						320:  { slidesPerView: 1 }
					}
				});

			});
		}
	}
	
	function singleItemCarouselActive($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.single-item-carousel').length) {
			$scope.find('.single-item-carousel').each(function () {

				new Swiper(this, {
					slidesPerView: 1,
					spaceBetween: 30,
					mousewheel: false,
					speed: 500,
					watchSlidesVisibility: true,
					watchSlidesProgress: true,
					loop: true,
					autoplay: {
						delay: 5000,
					},
					pagination: {
						el: $(this).find('.single-column-pagination')[0],
						clickable: true
					},
					navigation: {
						nextEl: $(this).find('.swiper-next')[0],  // ? fixed
						prevEl: $(this).find('.swiper-prev')[0],  // ? fixed
					},
					breakpoints: {
						1900: { slidesPerView: 1, spaceBetween: 30 },
						1199: { slidesPerView: 1, spaceBetween: 30 },
						991:  { slidesPerView: 1, spaceBetween: 30 },
						767:  { slidesPerView: 1, spaceBetween: 30 },
						499:  { slidesPerView: 1, spaceBetween: 30 }
					}
				});

			});
		}
	}

	function twoItemCarouselActive($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.two-item-carousel').length) {
			$scope.find('.two-item-carousel').each(function () {

				new Swiper(this, {
					slidesPerView: 1,
					spaceBetween: 30,
					mousewheel: false,
					speed: 500,
					watchSlidesVisibility: true,
					watchSlidesProgress: true,
					loop: true,
					autoplay: {
						delay: 5000,
					},
					pagination: {
						el: $(this).find('.two-column-pagination')[0],
						clickable: true
					},
					navigation: {
						nextEl: $(this).find('.two-column-prev-btn')[0],
						prevEl: $(this).find('.two-column-next-btn')[0],
					},
					breakpoints: {
						1900: { slidesPerView: 2, spaceBetween: 30 },
						1199: { slidesPerView: 2, spaceBetween: 30 },
						991:  { slidesPerView: 1, spaceBetween: 30 },
						767:  { slidesPerView: 1, spaceBetween: 30 },
						499:  { slidesPerView: 1, spaceBetween: 30 }
					}
				});

			});
		}
	}

	function threeItemCarouselActive($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.three-item-carousel').length) {
			$scope.find('.three-item-carousel').each(function () {

				new Swiper(this, {
					slidesPerView: 1,
					spaceBetween: 30,
					mousewheel: false,
					speed: 500,
					watchSlidesVisibility: true,
					watchSlidesProgress: true,
					loop: true,
					autoplay: {
						delay: 5000,
					},
					pagination: {
						el: $(this).find('.three-item-pagination')[0],
						clickable: true
					},
					navigation: {
						nextEl: $(this).find('.three-item-prev-btn')[0],
						prevEl: $(this).find('.three-item-next-btn')[0],
					},
					breakpoints: {
						1900: { slidesPerView: 3, spaceBetween: 30 },
						1199: { slidesPerView: 3, spaceBetween: 30 },
						991:  { slidesPerView: 2, spaceBetween: 30 },
						767:  { slidesPerView: 2, spaceBetween: 30 },
						499:  { slidesPerView: 1, spaceBetween: 30 }
					}
				});

			});
		}
	}

	function fourItemCarouselActive($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.four-item-carousel').length) {
			$scope.find('.four-item-carousel').each(function () {

				new Swiper(this, {
					slidesPerView: 1,
					spaceBetween: 30,
					mousewheel: false,
					speed: 500,
					watchSlidesVisibility: true,
					watchSlidesProgress: true,
					loop: true,
					autoplay: {
						delay: 5000,
					},
					pagination: {
						el: $(this).find('.four-column-pagination')[0],
						clickable: true
					},
					navigation: {
						nextEl: $(this).find('.four-column-prev-btn')[0],
						prevEl: $(this).find('.four-column-next-btn')[0],
					},
					breakpoints: {
						1900: { slidesPerView: 4, spaceBetween: 30 },
						1199: { slidesPerView: 4, spaceBetween: 30 },
						991:  { slidesPerView: 3, spaceBetween: 30 },
						767:  { slidesPerView: 2, spaceBetween: 30 },
						499:  { slidesPerView: 1, spaceBetween: 30 }
					}
				});

			});
		}
	}
	
	function fiveItemCarouselActive($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.five-item-carousel').length) {
			$scope.find('.five-item-carousel').each(function () {

				new Swiper(this, {
					slidesPerView: 1,
					spaceBetween: 30,
					mousewheel: false,
					speed: 500,
					watchSlidesVisibility: true,
					watchSlidesProgress: true,
					loop: true,
					autoplay: {
						delay: 5000,
					},
					pagination: {
						el: $(this).find('.five-item-pagination')[0],
						clickable: true
					},
					navigation: {
						nextEl: $(this).find('.five-item-prev-btn')[0],
						prevEl: $(this).find('.five-item-next-btn')[0],
					},
					breakpoints: {
						1900: { slidesPerView: 5, spaceBetween: 30 },
						1199: { slidesPerView: 4, spaceBetween: 30 },
						991:  { slidesPerView: 3, spaceBetween: 30 },
						767:  { slidesPerView: 2, spaceBetween: 30 },
						499:  { slidesPerView: 1, spaceBetween: 30 }
					}
				});

			});
		}
	}
	
	function enableMasonry($scope) {
		$scope = $scope || $(document);

		if ($scope.find('.sortable-masonry').length) {

			let winDow = $(window);
			// Needed variables
			let $container = $scope.find('.sortable-masonry .items-container');
			let $filter = $scope.find('.filter-btns');

			$container.isotope({
				filter: '*',
				masonry: {
					columnWidth: '.masonry-item.small-column'
				},
				animationOptions: {
					duration: 500,
					easing: 'linear'
				}
			});

			// Isotope Filter 
			$filter.find('li').on('click', function () {
				let selector = $(this).attr('data-filter');

				try {
					$container.isotope({
						filter: selector,
						animationOptions: {
							duration: 500,
							easing: 'linear',
							queue: false
						}
					});
				} catch (err) {
					// Fail silently
				}
				return false;
			});

			// Window resize
			winDow.on('resize', function () {
				let selector = $filter.find('li.active').attr('data-filter');

				$container.isotope({
					filter: selector,
					animationOptions: {
						duration: 500,
						easing: 'linear',
						queue: false
					}
				});
			});

			// Active class toggle
			let filterItemA = $filter.find('li');

			filterItemA.on('click', function () {
				let $this = $(this);
				if (!$this.hasClass('active')) {
					filterItemA.removeClass('active');
					$this.addClass('active');
				}
			});
		}
	}
	
	// marquee-right-to-left
	if ($(".marquee_mode-rightToLeft").length) {
      $('.marquee_mode-rightToLeft').marquee({
        speed: 20,
        gap: 0,
        delayBeforeStart: 0,
        direction: 'left',
        duplicated: true,
        pauseOnHover: true,
        startVisible: true,
      });
    }
	
	let mediaMatch = gsap.matchMedia();
	function rtlValue(value) {
		const isRTL = document.documentElement.dir === "rtl";
		return isRTL ? -value : value;
	}
	
	function sidebarStickyController() {
	  const containers = document.querySelectorAll(".slidebar-stickiy-container");

	  containers.forEach(container => {
		const sidebar = container.querySelector(".slidebar-stickiy");

		if (!sidebar) return;

		ScrollTrigger.matchMedia({
		  "(min-width: 992px)": function () {

			gsap.to(sidebar, {
			  ease: "power1.out",
			  scrollTrigger: {
				trigger: container,
				start: "top",      // offset for header
				end: "bottom bottom-=50",  // smoother release
				pin: sidebar,
				pinSpacing: false,
				scrub: 0.5,               // 👈 smooth scrolling (key)
				anticipatePin: 1,         // 👈 removes jump at start
				invalidateOnRefresh: true
			  }
			});

		  }
		});
	  });
	}





	
	/*--------------------------------------------------------------
      Elementor Integration
    --------------------------------------------------------------*/
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope, $) {
            // Global features (singleton - run once)
			countBoxActive($scope);
			lightboxActive($scope);
			tabsActive($scope);
			tabsActiveTwo($scope);
            odometerActive($scope);
            initProgressBars($scope);
            scrollToTargetInit($scope);
			bannerCarouselActive($scope);
			singleItemCarouselActive($scope);
			twoItemCarouselActive($scope);
			threeItemCarouselActive($scope);
			fourItemCarouselActive($scope);
			fiveItemCarouselActive($scope);
			enableMasonry($scope);
            circleTypeInit($scope);
			sidebarPopupInit();
            stickyHeader(); 
			searchPopup();
			mobileMenu();
			niceSelectInit();
			
        });
		
    });

    /*--------------------------------------------------------------
      Document Ready
    --------------------------------------------------------------*/
    $(document).ready(function () {
        // Global initializations
		countBoxActive();
		lightboxActive();
		faqAccordian();
		niceSelectInit();
		searchPopup();
		mobileMenu();
		initProgressBars();
		odometerActive();
		scrollToTargetInit();
		sidebarPopupInit();
		tabsActive();
		circleTypeInit();
		sidebarStickyController();
        
    });

    /*--------------------------------------------------------------
      Window Load Event
    --------------------------------------------------------------*/
    $(window).on("load", function () {
		countBoxActive();
        handlePreloader();
		circleTypeInit();
		initProgressBars();
		odometerActive();
        
    });

    /*--------------------------------------------------------------
      Window Scroll Event
    --------------------------------------------------------------*/
    $(window).on("scroll", function () {
        handleWindowScroll();
		scrollTopClass();
    });
	
})(jQuery);