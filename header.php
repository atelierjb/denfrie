<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="<?php the_field('meta-description', 'option'); ?>">
	<meta property="og:type" content="<?php the_field('og-type', 'option'); ?>">
    <meta property="og:title" content="<?php the_field('og-title', 'option'); ?>">
    <meta property="og:description" content="<?php the_field('og-description', 'option'); ?>">
    <meta property="og:url" content="<?php echo get_permalink(); ?>">
    <meta property="og:image" content="<?php the_field('og-image', 'option'); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-df-light-grey text-text-df-black antialiased' ); ?> data-barba="wrapper">
<?php do_action( 'tailpress_site_before' ); ?>

	<!-- Loading screen: add it right here after <body> tag -->
	<div id="loading-screen" class="fixed inset-0 bg-df-light-grey flex items-center justify-center z-50">
        <img id="loading-image" src="/wp-content/uploads/2024/09/loading-image.png" class="w-[85vw] sm:w-[65vw] h-auto opacity-0">
    </div>

<div id="page" class="min-h-screen flex flex-col text-pretty">

	<?php do_action( 'tailpress_header' ); ?>

	<header class="px-sp3 py-sp5">
		<div id="nav-container" class="w-full fixed sm:static">
			<nav class="hidden w-full sm:grid sm:grid-cols-12 pb-sp5 list-none font-dfserif text-medium/[0.95]">
				<li class="sm:col-span-3">
					<?php 
					$exhibitions_page_id = pll_get_post(2); 
					$archive_page_id = pll_get_post(159); // Use the actual ID of the archive page
					?>
					<a href="<?php echo get_permalink($exhibitions_page_id); ?>"
					class="hover:text-df-red <?php 
					if (is_front_page() || 
						is_page($exhibitions_page_id) || 
						is_page($archive_page_id) || 
						(is_singular('exhibition') && get_post_type() == 'exhibition')) { 
						echo 'text-df-red underline underline-offset-2'; 
					} ?>">
						<?php echo pll__('Exhibitions', 'tailpress'); ?>
					</a>
				</li>
				<li class="pl-sp2 sm:pl-0 sm:col-span-3">
					<a href="<?php echo get_permalink(pll_get_post(5)); ?>"
					class="hover:text-df-red <?php echo is_page(pll_get_post(5)) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo pll__('Social', 'tailpress'); ?>
					</a>
				</li>
				<li class="pl-sp2 sm:pl-0 sm:col-span-3">
					<a href="<?php echo get_permalink(pll_get_post(3)); ?>"
					class="hover:text-df-red <?php echo is_page(pll_get_post(3)) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo pll__('About', 'tailpress'); ?>
					</a>
				</li>
				<li class="sm:col-auto">
					<a href="<?php echo get_permalink(pll_get_post(4)); ?>"
					class="hover:text-df-red <?php echo is_page(pll_get_post(4)) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo pll__('Visit', 'tailpress'); ?>
					</a>
				</li>


				<li class="sm:col-span-2 sm:place-self-end">
					<a href="<?php echo pll_the_languages(array('raw' => 1))['da']['url']; ?>" 
					class="hover:text-df-red <?php echo pll_current_language() === 'da' ? 'text-df-red underline underline-offset-2' : ''; ?>">DK</a>/<a href="<?php echo pll_the_languages(array('raw' => 1))['en']['url']; ?>" 
					class="hover:text-df-red <?php echo pll_current_language() === 'en' ? 'text-df-red underline underline-offset-2' : ''; ?>">EN</a>
				</li>
			</nav>

			<figure class="w-[calc(82.5%+6.5vw)] sm:w-[calc(80%+6.5vw)] pb-sp5">		
				<a href="<?php echo home_url(); ?>" class="block sm:hidden">
					<img src="/wp-content/uploads/2024/07/den-frie-logo-xl.svg" alt="Den Frie Udstillingsbygnings Logo">
				</a>
				<img src="/wp-content/uploads/2024/07/den-frie-logo-xl.svg" alt="Den Frie Udstillingsbygnings Logo" class="hidden sm:block">
			</figure>


			<div class="w-full columns-2 sm:flex font-superclarendon text-regular/regular sm:text-[calc(0.5em+1vw)]/[calc(110%+0.25vw)]">
				<p class="grow break-inside-avoid w-full sm:w-[calc(40%+6.5vw)]">
					<?php echo pll__('Oslo plads 1, 2100, Kbh Ø, DK', 'tailpress'); ?><br>
					<a href="mailto:<?php the_field('info-email', 'option'); ?>" class="hover:text-df-red"><?php the_field('info-email', 'option'); ?></a><br>
					<a href="tel:<?php the_field('info-phone', 'option'); ?>" class="hover:text-df-red"><?php the_field('info-phone', 'option'); ?></a>
				</p>
				<p class="grow break-inside-avoid w-full sm:w-[calc(40%+7vw)]">
					<?php echo pll__('Tues-Sun : 12 — 18', 'tailpress'); ?><br>
					<?php echo pll__('(Thurs : 12 — 21)', 'tailpress'); ?><br>
					<?php echo pll__('Mon : Closed', 'tailpress'); ?>
				</p>
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
			$archive_page_id = pll_get_post(159);
			?>
			<a href="<?php echo get_permalink($exhibitions_page_id); ?>" class="hover:text-df-red <?php echo (is_front_page() || is_page($exhibitions_page_id) || is_page($archive_page_id) || (is_singular('exhibition') && get_post_type() == 'exhibition')) ? 'text-df-red underline underline-offset-2' : ''; ?>">
				<?php echo pll__('Exhibitions', 'tailpress'); ?>
			</a>
		</li>
				<li class="sm:col-span-3">
					<a href="<?php echo get_permalink(pll_get_post(5)); ?>"
					class="hover:text-df-red <?php echo is_page(pll_get_post(5)) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo pll__('Social', 'tailpress'); ?>
					</a>
				</li>
				<li class="sm:col-span-3">
					<a href="<?php echo get_permalink(pll_get_post(3)); ?>"
					class="hover:text-df-red <?php echo is_page(pll_get_post(3)) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo pll__('About', 'tailpress'); ?>
					</a>
				</li>
				<li class="sm:col-auto">
					<a href="<?php echo get_permalink(pll_get_post(4)); ?>"
					class="hover:text-df-red <?php echo is_page(pll_get_post(4)) ? 'text-df-red underline underline-offset-2' : ''; ?>">
						<?php echo pll__('Visit', 'tailpress'); ?>
					</a>
				</li>

				<li class="">
					<a href="<?php echo pll_the_languages(array('raw' => 1))['da']['url']; ?>" class="hover:text-df-red <?php echo pll_current_language() === 'da' ? 'text-df-red underline underline-offset-2' : ''; ?>">DK</a>/<a href="<?php echo pll_the_languages(array('raw' => 1))['en']['url']; ?>" class="hover:text-df-red <?php echo pll_current_language() === 'en' ? 'text-df-red underline underline-offset-2' : ''; ?>">EN</a>
				</li>
			</nav>

	


		<?php if ( is_front_page() ) { ?>
			
		<?php } ?>

		<?php do_action( 'tailpress_content_start' ); ?>

	