<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div id="main-content">
	<?php 
		$exhibition_image_id = get_field('exhibition-image');
		$exhibition_start_date = get_field('exhibition-start-date');
		$exhibition_end_date = get_field('exhibition-end-date');
		$exhibition_description = get_field('exhibition-description');
		$exhibition_supporters = get_field('exhibition-supporters');
		$exhibition_folder = get_field('exhibition-folder');
		$exhibition_presskit = get_field('exhibition-presskit');
	?>

	<section class="w-full relative mb-sp2">
		<div class="swiper-container mx-sp5 sm:mx-sp9 overflow-hidden">
			<div class="swiper-wrapper">
				<?php 
				$images = get_field('exhibition-slider');
				if( $images ):
					foreach( $images as $image_id ):
						$image_caption = wp_get_attachment_caption( $image_id );
						?>
						<div class="swiper-slide">
							<figure class="w-full h-auto aspect-[12/8] sm:aspect-video">
								<?php echo wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-full object-cover']); ?>
								<?php if( $image_caption ): ?>
									<figcaption class="font-superclarendon text-xsmall/regular text-right mt-1">
										<?php echo esc_html($image_caption); ?>
									</figcaption>
								<?php endif; ?>
							</figure>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<!-- Custom Navigation Overlay -->
			<div class="absolute inset-y-0 left-0 w-1/2 cursor-pointer swiper-custom-prev z-20"></div>
			<div class="absolute inset-y-0 right-0 w-1/2 cursor-pointer swiper-custom-next z-20"></div>
		</div>

		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const swiper = new Swiper('.swiper-container', {
					loop: true,
					autoplay: {
						delay: 5000,
						disableOnInteraction: false,
					},
					speed: 1500,
					effect: 'slide',
				});

				// Custom navigation
				document.querySelectorAll('.swiper-custom-prev').forEach(element => {
					element.addEventListener('click', () => swiper.slidePrev());
				});

				document.querySelectorAll('.swiper-custom-next').forEach(element => {
					element.addEventListener('click', () => swiper.slideNext());
				});

				// Change cursor styles
				document.querySelectorAll('.swiper-custom-prev').forEach(element => {
					element.style.cursor = 'w-resize';
				});

				document.querySelectorAll('.swiper-custom-next').forEach(element => {
					element.style.cursor = 'e-resize';
				});
			});
		</script>
	</section>

	<section class="pb-sp5 sm:pb-sp8">
            <div class="w-fit">
                <h3 class="font-dfserif text-xxl/xxl">
                    <?php the_title(); ?>
                </h3>
                <p class="-ml-[1px] sm:-ml-[3px] font-superclarendon text-xxl/xxl mt-0 sm:-mt-2">
                    <?php echo esc_html($exhibition_start_date); ?> — <?php echo esc_html($exhibition_end_date); ?>
                </p>

            </div>

				
    </section>

	<article class="columns-1 sm:columns-2">
		<div class="flex flex-col gap-sp4">
			<?php $manyartists = get_field('exhibition-many-artists'); ?>
				<?php if( $manyartists ): // Check if the field is not empty ?>
					<div class="pb-sp2">
						<h4 class="font-dfserif text-xl/xl pb-sp1">
							<?php echo pll__('Participating artists', 'tailpress'); ?>
						</h4>
						<div class="wysiwyg-artists w-full sm:w-[calc(90%+1vw)]">
							<?php echo wp_kses_post($manyartists); ?>
						</div>
					</div>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/section-exhibition-description' ); ?>
			
			<?php if( have_rows('exhibition-flex-images') ): ?>
				<?php while( have_rows('exhibition-flex-images') ): the_row(); ?>
					<?php if( get_row_layout() == 'image-cols-1' ): ?>
						<?php
						// Get the image ID and description for image-cols-1-left
						$image_id = get_sub_field('image');
						$image_description = get_sub_field('image-description');
						?>
						<section class="mx-sp5 sm:mx-0 sm:w-full break-inside-avoid font-superclarendon">
							<figure class="w-full h-auto animate-image">
								<?php echo wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-auto object-cover']); ?>
								<?php if($image_description): ?>
									<figcaption class="text-xsmall text-right mt-1">
										<?php echo esc_html($image_description); ?>
									</figcaption>
								<?php endif; ?>
							</figure>
						</section>
					<?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</article>


	<!-- Loop through the images again and place image-cols-2 outside the columns -->
	<?php if( have_rows('exhibition-flex-images') ): ?>
		<?php while( have_rows('exhibition-flex-images') ): the_row(); ?>
			<?php if( get_row_layout() == 'image-cols-2' ): ?>
				<?php
				// Get the image ID and description for image-cols-2
				$image_id = get_sub_field('image');
				$image_description = get_sub_field('image-description');
				?>
				<section class="w-full py-sp4 sm:py-sp8 font-superclarendon">
					<figure class="mx-sp5 sm:mx-sp9 mb-sp1 aspect-video animate-image">
						<?php echo wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-auto object-cover']); ?>
						<?php if($image_description): ?>
							<figcaption class="text-xsmall text-right mt-1">
								<?php echo esc_html($image_description); ?>
							</figcaption>
						<?php endif; ?>
					</figure>
				</section>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>	

	<!-- <section class="p-sp5 sm:p-sp10 text-center">
		<h3 class="font-dfserif text-large/large">
			<?php echo pll__('The exhibition is generously supported by', 'tailpress'); ?>
		</h3>
		<p class="font-superclarendon text-large/large">
			<?php echo($exhibition_supporters); ?>
		</p>
	</section> -->

	<section class="grid grid-cols-1 sm:grid-cols-12 mt-sp4 text-center sm:text-left">
		<?php if (!empty($exhibition_supporters)): ?>
			<div class="flex flex-col col-span-1 sm:col-span-9">
				<h4 class="font-dfserif text-xl/xl">
					<?php echo pll__('The exhibition is generously supported by:', 'tailpress'); ?>
				</h4>
				<div class="w-full sm:w-[calc(90%+1vw)] mx-0 sm:mx-sp9 my-sp4 font-superclarendon text-xl/xl">
					<?php echo($exhibition_supporters); ?>
				</div>		
			</div>
		<?php endif; ?>

		<div class="col-span-1 sm:col-span-3">
			<?php $credits = get_field('exhibition-credits'); ?>
				<?php if( $credits ): // Check if the field is not empty ?>
					<div class="wysiwyg-credits w-full sm:w-[calc(90%+1vw)] my-sp8 sm:my-0">
						<?php echo wp_kses_post($credits); ?>
					</div>
				<?php endif; ?>
		</div>
	</section>

	
</div>
</article>
