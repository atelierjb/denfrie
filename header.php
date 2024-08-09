<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-df-light-grey text-text-df-black antialiased' ); ?>>

<?php do_action( 'tailpress_site_before' ); ?>

<div id="page" class="min-h-screen flex flex-col">

	<?php do_action( 'tailpress_header' ); ?>

	<header class="px-sp3 py-sp5">

	<nav class="w-full flex justify-between pb-sp5 list-none font-dfserif text-medium/[0.95]">
    <li>
        <a href="<?php echo get_permalink(2); ?>"
           class="hover:text-df-grey <?php echo (is_front_page() || is_page(2) || is_page('archive') || (is_singular('exhibition') && get_post_type() == 'exhibition')) ? 'text-df-red underline underline-offset-2' : ''; ?>">
           Exhibitions
        </a>
    </li>
    <li>
        <a href="<?php echo get_permalink(5); ?>"
           class="hover:text-df-grey <?php echo is_page(5) ? 'text-df-red underline underline-offset-2' : ''; ?>">
           Social
        </a>
    </li>
    <li>
        <a href="<?php echo get_permalink(3); ?>"
           class="hover:text-df-grey <?php echo is_page(3) ? 'text-df-red underline underline-offset-2' : ''; ?>">
           About
        </a>
    </li>
    <li>
        <a href="<?php echo get_permalink(4); ?>"
           class="hover:text-df-grey <?php echo is_page(4) ? 'text-df-red underline underline-offset-2' : ''; ?>">
           Visit
        </a>
    </li>
    <li>
        <a href="#" class="hover:text-df-grey">DK</a>/<a href="#" class="hover:text-df-grey">EN</a>
    </li>
</nav>

	<figure class="w-full sm:w-[calc(80%+6.5vw)] pb-sp5">
		<img src="/wp-content/uploads/2024/07/den-frie-logo-xl.svg" alt="Den Frie Udstillingsbygnings Logo">
	</figure>
	<div class="w-full flex font-superclarendon text-[calc(0.5em+1vw)]/[calc(110%+0.25vw)]">
		<p class="grow sm:w-[calc(40%+6.5vw)]">
			Oslo plads 1, 2100, Kbh Ø, DK<br>
			<a href="mailto:info@denfrie.dk" class="hover:text-df-grey">info@denfrie.dk</a><br>
			<a href="tel:+4533122803" class="hover:text-df-grey">+45 33 12 28 03</a>
		</p>
		<p class="grow sm:w-[calc(40%+7vw)]">
			Mon : Closed<br>
			Tues-Sun : 12 — 18<br>
			(Thurs : 12 — 21)
		</p>
	</div>
	</header>

	<div id="content" class="site-content flex-grow">

		<?php if ( is_front_page() ) { ?>
			
		<?php } ?>

		<?php do_action( 'tailpress_content_start' ); ?>

		<main>
