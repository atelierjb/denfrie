<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<?php
	$info_post = get_translated_info_post();
	if ($info_post) :
	?>
		<meta name="description" content="<?php echo esc_attr(get_field('meta-description', $info_post->ID)); ?>">
		<meta property="og:type" content="<?php echo esc_attr(get_field('og-type', $info_post->ID)); ?>">
		<meta property="og:title" content="<?php echo esc_attr(get_field('og-title', $info_post->ID)); ?>">
		<meta property="og:description" content="<?php echo esc_attr(get_field('og-description', $info_post->ID)); ?>">
		<meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
		<meta property="og:image" content="<?php echo esc_url(get_field('og-image', $info_post->ID)); ?>">
	<?php endif; ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="preload" href="<?php echo esc_url($upload_dir['baseurl'] . '/2024/09/loading-image.png'); ?>" as="image">
	<link rel="preconnect" href="https://use.typekit.net" crossorigin>
	<link rel="preconnect" href="https://p.typekit.net" crossorigin>
	<link rel="preload" href="<?php echo get_stylesheet_directory_uri(); ?>/css/app.css?ver=1.0" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/app.css?ver=1.0"></noscript>
	<script>
		!function(n){"use strict";n.loadCSS||(n.loadCSS=function(){});var o=loadCSS.relpreload={};if(o.support=function(){var e;try{e=n.document.createElement("link").relList.supports("preload")}catch(t){e=!1}return function(){return e}}(),o.bindMediaToggle=function(t){var e=t.media||"all";function a(){t.media=e}t.addEventListener?t.addEventListener("load",a):t.attachEvent&&t.attachEvent("onload",a),setTimeout(function(){t.rel="stylesheet",t.media="only x"}),setTimeout(a,3e3)},o.poly=function(){if(!o.support())for(var t=n.document.getElementsByTagName("link"),e=0;e<t.length;e++){var a=t[e];"preload"!==a.rel||"style"!==a.getAttribute("as")||a.getAttribute("data-loadcss")||(a.setAttribute("data-loadcss",!0),o.bindMediaToggle(a))}},!o.support()){o.poly();var t=n.setInterval(o.poly,500);n.addEventListener?n.addEventListener("load",function(){o.poly(),n.clearInterval(t)}):n.attachEvent&&n.attachEvent("onload",function(){o.poly(),n.clearInterval(t)})}"undefined"!=typeof exports?exports.loadCSS=loadCSS:n.loadCSS=loadCSS}("undefined"!=typeof global?global:this);
	</script>


	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-df-light-grey text-text-df-black antialiased' ); ?>>
<?php wp_body_open(); ?>
<?php do_action( 'tailpress_site_before' ); ?>

	<!-- Loading screen: add it right here after <body> tag -->
	<div id="loading-screen" class="fixed inset-0 bg-df-light-grey flex items-center justify-center z-50">
        <?php
        $upload_dir = wp_upload_dir();
        $image_url = $upload_dir['baseurl'] . '/2024/09/loading-image.png';
        $image_path = $upload_dir['basedir'] . '/2024/09/loading-image.png';
        
        if (file_exists($image_path)) {
            list($width, $height) = getimagesize($image_path);
            ?>
            <img id="loading-image" 
                 src="<?php echo esc_url($image_url); ?>" 
                 width="<?php echo $width; ?>"
                 height="<?php echo $height; ?>"
                 alt="Loading"
                 class="w-auto h-auto max-h-[90vw] sm:max-h-[90vh] max-w-[90vw] sm:max-w-[90vh] object-contain opacity-0">
        <?php
        }
        ?>
    </div>





<div id="page" class="min-h-screen flex flex-col text-pretty">

	<?php do_action( 'tailpress_header' ); ?>

	<header class="px-sp3 py-sp5">
		<div id="nav-container" class="w-full fixed sm:static">
			<menu class="nav hidden w-full sm:grid sm:grid-cols-12 pb-sp5 list-none font-dfserif text-medium/[0.95]">
				<li class="sm:col-span-3">
					<?php 
					$exhibitions_page_id = pll_get_post(2); 
					$archive_page_id = pll_get_post(159); // Use the actual ID of the archive page
					$exhibitions_title = get_the_title($exhibitions_page_id);
					?>
					<a href="<?php echo get_permalink($exhibitions_page_id); ?>"
					class="hover:text-df-red <?php 
					if (is_front_page() || 
						is_page($exhibitions_page_id) || 
						is_page($archive_page_id) || 
						(is_singular('exhibition') && get_post_type() == 'exhibition')) { 
						echo 'text-df-red underline underline-offset-2'; 
					} ?>">
						<?php echo $exhibitions_title; ?>
					</a>
				</li>
				<li class="pl-sp2 sm:pl-0 sm:col-span-3">
					<?php 
					$social_page_id = pll_get_post(5);
					$social_title = get_the_title($social_page_id);
					?>
					<a href="<?php echo get_permalink($social_page_id); ?>"
					class="hover:text-df-red <?php echo is_page($social_page_id) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo $social_title; ?>
					</a>
				</li>
				<li class="pl-sp2 sm:pl-0 sm:col-span-3">
					<?php 
					$about_page_id = pll_get_post(3);
					$about_title = get_the_title($about_page_id);
					?>
					<a href="<?php echo get_permalink($about_page_id); ?>"
					class="hover:text-df-red <?php echo is_page($about_page_id) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo $about_title; ?>
					</a>
				</li>
				<li class="sm:col-auto">
					<?php 
					$visit_page_id = pll_get_post(4);
					$visit_title = get_the_title($visit_page_id);
					?>
					<a href="<?php echo get_permalink($visit_page_id); ?>"
					class="hover:text-df-red <?php echo is_page($visit_page_id) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo $visit_title; ?>
					</a>
				</li>

				<li class="sm:col-span-2 sm:place-self-end">
					<a href="<?php echo pll_the_languages(array('raw' => 1))['da']['url']; ?>" 
					class="hover:text-df-red <?php echo pll_current_language() === 'da' ? 'text-df-red underline underline-offset-2' : ''; ?>">DK</a>/<a href="<?php echo pll_the_languages(array('raw' => 1))['en']['url']; ?>" 
					class="hover:text-df-red <?php echo pll_current_language() === 'en' ? 'text-df-red underline underline-offset-2' : ''; ?>">EN</a>
				</li>
			</menu>


			<figure class="w-[calc(82.5%+6.5vw)] sm:w-[calc(80%+6.5vw)] pb-sp5">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<svg class="w-full h-auto" viewBox="0 0 5000 992" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M0 957.345C39.2368 935.789 50.6281 881.264 50.6281 831.812V168.645C50.6281 119.192 39.2368 64.6682 0 43.1121V29.164H425.276C697.403 29.164 908.775 173.717 908.775 498.326C908.775 822.936 697.403 971.293 425.276 971.293H0V957.345ZM232.889 822.936H425.276C598.678 822.936 721.451 713.887 721.451 498.326C721.451 282.765 598.678 177.521 425.276 177.521H232.889L225.295 185.129V815.328L232.889 822.936Z" fill="black"/>
						<path d="M1322.81 253.602C1507.6 253.602 1625.32 357.578 1648.1 547.779C1648.1 551.583 1649.36 556.655 1649.36 561.727C1650.63 575.675 1651.89 590.891 1651.89 604.839C1653.16 625.128 1653.16 645.416 1653.16 661.9L1640.5 674.58H1153.21L1144.35 683.456C1167.13 777.288 1240.54 847.029 1349.39 852.101C1459.51 857.173 1541.78 810.256 1583.55 739.248H1601.27L1620.25 902.821C1530.39 966.221 1446.85 991.581 1349.39 991.581C1146.88 991.581 981.072 867.317 981.072 622.592C981.072 377.866 1120.3 253.602 1322.81 253.602ZM1153.21 547.779H1492.42L1501.28 538.903C1489.88 456.483 1453.18 394.35 1330.41 393.082C1211.43 391.814 1163.33 460.287 1145.61 540.171L1153.21 547.779Z" fill="black"/>
						<path d="M2183.49 957.345C2222.73 935.789 2234.12 881.265 2234.12 831.813V583.283C2234.12 467.895 2188.55 381.67 2070.84 381.67C1978.45 381.67 1906.3 427.319 1906.3 583.283V831.813C1906.3 881.265 1917.69 935.789 1956.93 957.345V971.293H1703.79V957.345C1743.02 935.789 1754.42 881.265 1754.42 831.813V413.371C1754.42 363.918 1743.02 309.394 1703.79 287.838V273.89H1894.91L1906.3 285.302V325.878H1920.22C1988.57 273.89 2040.47 253.602 2121.47 253.602C2289.81 253.602 2386 357.578 2386 523.687V831.813C2386 881.265 2397.39 935.789 2436.63 957.345V971.293H2183.49V957.345Z" fill="black"/>
						<path d="M2926.84 168.645C2926.84 119.193 2915.45 64.6683 2876.21 43.1121V29.1641H3415.4V272.621H3397.68C3385.03 234.581 3359.71 161.037 3229.34 161.037C3098.98 161.037 3082.52 262.477 3081.26 415.906L3093.91 434.926C3143.28 445.07 3219.22 437.462 3229.34 423.514H3243.27V575.675H3229.34C3219.22 561.727 3142.01 554.119 3093.91 564.263L3081.26 582.015C3082.52 881.264 3120.49 918.036 3188.84 954.809V971.293H2876.21V957.345C2915.45 935.789 2926.84 881.264 2926.84 831.812V168.645Z" fill="black"/>
						<path d="M3668.54 831.812C3668.54 881.264 3679.94 935.789 3719.17 957.345V971.293H3466.03V957.345C3505.27 935.789 3516.66 881.264 3516.66 831.812V413.37C3516.66 363.918 3505.27 309.394 3466.03 287.837V273.889H3657.15L3668.54 285.301V325.878H3682.47C3750.81 273.889 3802.71 253.601 3883.71 253.601C3916.62 253.601 3945.73 257.405 3973.58 265.013V441.266H3960.92C3945.73 409.566 3895.11 385.474 3836.88 385.474C3743.22 385.474 3668.54 450.142 3668.54 583.283V831.812Z" fill="black"/>
						<path d="M4024.21 957.345C4063.44 935.789 4074.83 881.264 4074.83 831.812V413.37C4074.83 363.918 4063.44 309.393 4024.21 287.837V273.889H4277.35V287.837C4238.11 309.393 4226.72 363.918 4226.72 413.37V831.812C4226.72 881.264 4238.11 935.789 4277.35 957.345V971.293H4024.21V957.345ZM4152.04 0C4212.8 0 4240.64 34.2362 4240.64 88.7604C4240.64 143.285 4212.8 177.521 4152.04 177.521C4091.29 177.521 4063.44 145.821 4063.44 88.7604C4063.44 31.7001 4090.02 0 4152.04 0Z" fill="black"/>
						<path d="M4669.65 253.601C4854.44 253.601 4972.15 357.578 4994.94 547.779C4994.94 551.583 4996.2 556.655 4996.2 561.727C4997.47 575.675 4998.73 590.891 4998.73 604.839C5000 625.127 5000 645.415 5000 661.899L4987.34 674.579H4500.05L4491.19 683.455C4513.97 777.288 4587.38 847.028 4696.23 852.1C4806.35 857.172 4888.62 810.256 4930.39 739.248H4948.11L4967.09 902.82C4877.23 966.221 4793.69 991.581 4696.23 991.581C4493.72 991.581 4327.91 867.316 4327.91 622.591C4327.91 377.866 4467.14 253.601 4669.65 253.601ZM4500.05 547.779H4839.26L4848.11 538.903C4836.72 456.482 4800.02 394.35 4677.25 393.082C4558.27 391.814 4510.17 460.286 4492.45 540.171L4500.05 547.779Z" fill="black"/>
						</svg>
				</a>
			</figure>


			<div class="w-full columns-2 sm:flex font-superclarendon text-regular/regular sm:text-[calc(0.5em+1vw)]/[calc(110%+0.25vw)]">
			<?php
				$info_post = get_translated_info_post(); // Make sure this function is defined in functions.php as mentioned in the previous answer
				if ($info_post) :
				?>
					<p class="grow break-inside-avoid w-full sm:w-[calc(40%+6.5vw)]">
						<?php echo esc_html(get_field('info-address1', $info_post->ID)); ?><br>
						<?php echo esc_html(get_field('info-address2', $info_post->ID)); ?><br>
						<a href="mailto:<?php echo esc_attr(get_field('info-email', $info_post->ID)); ?>" class="hover:text-df-red">
							<?php echo esc_html(get_field('info-email', $info_post->ID)); ?>
						</a><br>
						<a href="tel:<?php echo esc_attr(get_field('info-phone', $info_post->ID)); ?>" class="hover:text-df-red">
							<?php echo esc_html(get_field('info-phone', $info_post->ID)); ?>
						</a>
					</p>
				
					<p class="grow break-inside-avoid w-full sm:w-[calc(40%+7vw)]">
						<?php echo esc_html(get_field('info-hours1', $info_post->ID)); ?><br>
						<?php echo esc_html(get_field('info-hours2', $info_post->ID)); ?><br>
						<?php echo esc_html(get_field('info-hours3', $info_post->ID)); ?><br>
						<?php echo esc_html(get_field('info-hours4', $info_post->ID)); ?>
					</p>
				<?php endif; ?>	
			</div>
		</div>
	</header>

	<div class="fixed top-sp1 right-sp2 z-20 sm:hidden">
		<a href="#" aria-label="Toggle navigation" id="primary-menu-toggle">
			<ion-icon name="menu-sharp" size="large" class="text-df-black cursor-pointer" id="menu-icon"></ion-icon>
		</a>
	</div>

	<nav class="fixed right-0 p-sp5 px-sp3 z-10 bg-df-light-grey sm:hidden w-[55vw] h-[100vh] flex flex-col gap-sp3 list-none font-dfserif text-xxxl/xxl transform translate-x-full drop-shadow-sm" id="primary-menu">

		
				<li class="mt-sp7">
					<?php 
					$exhibitions_page_id = pll_get_post(2); 
					$archive_page_id = pll_get_post(159); // Use the actual ID of the archive page
					$exhibitions_title = get_the_title($exhibitions_page_id);
					?>
					<a href="<?php echo get_permalink($exhibitions_page_id); ?>"
					class="hover:text-df-red <?php 
					if (is_front_page() || 
						is_page($exhibitions_page_id) || 
						is_page($archive_page_id) || 
						(is_singular('exhibition') && get_post_type() == 'exhibition')) { 
						echo 'text-df-red underline underline-offset-2'; 
					} ?>">
						<?php echo $exhibitions_title; ?>
					</a>
				</li>
				<li class="sm:col-span-3">
					<?php 
					$social_page_id = pll_get_post(5);
					$social_title = get_the_title($social_page_id);
					?>
					<a href="<?php echo get_permalink($social_page_id); ?>"
					class="hover:text-df-red <?php echo is_page($social_page_id) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo $social_title; ?>
					</a>
				</li>
				<li class="sm:col-span-3">
					<?php 
					$about_page_id = pll_get_post(3);
					$about_title = get_the_title($about_page_id);
					?>
					<a href="<?php echo get_permalink($about_page_id); ?>"
					class="hover:text-df-red <?php echo is_page($about_page_id) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo $about_title; ?>
					</a>
				</li>
				<li class="sm:col-auto">
					<?php 
					$visit_page_id = pll_get_post(4);
					$visit_title = get_the_title($visit_page_id);
					?>
					<a href="<?php echo get_permalink($visit_page_id); ?>"
					class="hover:text-df-red <?php echo is_page($visit_page_id) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo $visit_title; ?>
					</a>
				</li>

				<li class="">
					<a href="<?php echo pll_the_languages(array('raw' => 1))['da']['url']; ?>" class="hover:text-df-red <?php echo pll_current_language() === 'da' ? 'text-df-red underline underline-offset-2' : ''; ?>">DK</a>/<a href="<?php echo pll_the_languages(array('raw' => 1))['en']['url']; ?>" class="hover:text-df-red <?php echo pll_current_language() === 'en' ? 'text-df-red underline underline-offset-2' : ''; ?>">EN</a>
				</li>
			</nav>

	


		<?php if ( is_front_page() ) { ?>
			
		<?php } ?>

		<?php do_action( 'tailpress_content_start' ); ?>
	