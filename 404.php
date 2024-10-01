<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>
<body class="antialiased">
	<div class="md:flex min-h-screen">
		<div class="w-full md:w-1/2 flex items-center justify-center">
			<div class="max-w-sm m-8 font-superclarendon">
				<div class="text-[8rem] sm:text-[10rem] text-df-black -ml-2 tracking-tighter">404</div>
				<p class="text-df-black text-xl/xl font-light mb-8 text-pretty"><?php _e( 'Sorry, the page you are looking for could not be found.', 'tailpress' ); ?> <a href="<?php echo get_bloginfo( 'url' ); ?>" class=" underline hover:text-df-red">
					<?php _e( 'Go back...', 'tailpress' ); ?>
				</a></p>
				<a href="<?php echo get_bloginfo( 'url' ); ?>" class="bg-primary px-4 py-2 rounded text-white">
					<?php _e( 'Go Home', 'tailpress' ); ?>
				</a>
			</div>
		</div>
	</div>
</body>
</html>
