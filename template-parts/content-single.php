<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
		$exhibition_image_id = get_field('exhibition-image');
		$exhibition_start_date = get_field('exhibition-start-date');
		$exhibition_end_date = get_field('exhibition-end-date');
		$exhibition_description = get_field('exhibition-description');
		$exhibition_supporters = get_field('exhibition-supporters');
		$exhibition_folder = get_field('exhibition-folder');
		$exhibition_presskit = get_field('exhibition-presskit');
	?>

	<section class="w-full relative mb-sp2 animateOnView">
		<div class="swiper-container mx-sp5 sm:mx-sp9 overflow-hidden">
			<div class="swiper-wrapper">
			<?php 
                $images = get_field('exhibition-slider');
                if ($images):
                    foreach ($images as $image_id):
                        $image_caption = wp_get_attachment_caption($image_id);
                        $image_data = wp_get_attachment_image_src($image_id, 'exhibition-medium');
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        $srcset = wp_get_attachment_image_srcset($image_id, 'exhibition-medium');
                        $sizes = '(max-width: 640px) 100vw, (max-width: 1024px) 80vw, 1200px';
                        ?>
                        <div class="swiper-slide">
                            <figure class="w-full h-auto aspect-[11/8] sm:aspect-video">
                                <img src="<?php echo esc_url($image_data[0]); ?>"
                                     srcset="<?php echo esc_attr($srcset); ?>"
                                     sizes="<?php echo esc_attr($sizes); ?>"
                                     alt="<?php echo esc_attr($image_alt); ?>"
                                     class="w-full h-full object-cover"
                                     loading="lazy">
                                <?php if ($image_caption): ?>
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
            <div class="w-fit text-xxl/xxl sm:text-xxxl/xxl">
                <h3 class="font-dfserif animateOnView">
                    <?php the_title(); ?>
                </h3>
                <p class="-ml-[1px] sm:-ml-[3px] font-superclarendon mt-0 sm:-mt-2 animateOnView">
                    <?php echo esc_html($exhibition_start_date); ?> — <?php echo esc_html($exhibition_end_date); ?>
                </p>
            </div>		
    </section>

	<section class="columns-1 sm:columns-2 gap-4">
		<div class="break-inside-avoid break-after-column">
			<?php $manyartists = get_field('exhibition-many-artists'); ?>
				<?php if( $manyartists ): // Check if the field is not empty ?>
					<div class="pb-sp2">
						<div class="wysiwyg-artists w-full sm:w-[calc(90%+1vw)] animateOnView">
							<?php echo wp_kses_post($manyartists); ?>
						</div>
					</div>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/section-exhibition-description' ); ?>
			
			<?php if( have_rows('exhibition-flex-images') ): ?>
				<?php while( have_rows('exhibition-flex-images') ): the_row(); ?>
					<?php if (get_row_layout() == 'image-cols-1-left'):
                    $image_id = get_sub_field('image');
                    $image_description = get_sub_field('image-description');
                    $image_data = wp_get_attachment_image_src($image_id, 'exhibition-medium');
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    $srcset = wp_get_attachment_image_srcset($image_id, 'exhibition-medium');
                    $sizes = '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 600px';
                    ?>
                    <section class="mx-sp5 sm:mx-0 sm:w-full break-inside-avoid font-superclarendon">
                        <figure class="w-full h-auto mb-4 animateOnView">
                            <img src="<?php echo esc_url($image_data[0]); ?>"
                                 srcset="<?php echo esc_attr($srcset); ?>"
                                 sizes="<?php echo esc_attr($sizes); ?>"
                                 alt="<?php echo esc_attr($image_alt); ?>"
                                 class="w-full h-auto object-cover"
                                 loading="lazy">
                            <?php if ($image_description): ?>
                                <figcaption class="text-small sm:text-xsmall text-right mt-1 animateOnView">
                                    <?php echo esc_html($image_description); ?>
                                </figcaption>
                            <?php endif; ?>
                        </figure>
                    </section>
					<?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
		<div class="break-inside-avoid">
		<?php if( have_rows('exhibition-flex-images') ): ?>
				<?php while( have_rows('exhibition-flex-images') ): the_row(); ?>
					<?php if (get_row_layout() == 'image-cols-1-right'):
                    $image_id = get_sub_field('image');
                    $image_description = get_sub_field('image-description');
                    $image_data = wp_get_attachment_image_src($image_id, 'exhibition-medium');
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    $srcset = wp_get_attachment_image_srcset($image_id, 'exhibition-medium');
                    $sizes = '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 600px';
                    ?>
                    <section class="mx-sp5 sm:mx-0 sm:w-full break-inside-avoid font-superclarendon">
                        <figure class="w-full h-auto mb-4 animateOnView">
                            <img src="<?php echo esc_url($image_data[0]); ?>"
                                 srcset="<?php echo esc_attr($srcset); ?>"
                                 sizes="<?php echo esc_attr($sizes); ?>"
                                 alt="<?php echo esc_attr($image_alt); ?>"
                                 class="w-full h-auto object-cover"
                                 loading="lazy">
                            <?php if ($image_description): ?>
                                <figcaption class="text-small sm:text-xsmall text-right mt-1 animateOnView">
                                    <?php echo esc_html($image_description); ?>
                                </figcaption>
                            <?php endif; ?>
                        </figure>
                    </section>
					<?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- Loop through the images again and place image-cols-2 outside the columns -->
	<?php if( have_rows('exhibition-flex-images') ): ?>
		<?php while( have_rows('exhibition-flex-images') ): the_row(); ?>
			<?php if (get_row_layout() == 'image-cols-2'):
                $image_id = get_sub_field('image');
                $image_description = get_sub_field('image-description');
                $image_data = wp_get_attachment_image_src($image_id, 'exhibition-medium');
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                $srcset = wp_get_attachment_image_srcset($image_id, 'exhibition-medium');
                $sizes = '(max-width: 640px) 100vw, (max-width: 1024px) 80vw, 1200px';
                ?>
                <section class="w-full font-superclarendon">
                    <figure class="mx-sp5 sm:mx-sp9 my-0 sm:my-4 aspect-video animateOnView">
                        <img src="<?php echo esc_url($image_data[0]); ?>"
                             srcset="<?php echo esc_attr($srcset); ?>"
                             sizes="<?php echo esc_attr($sizes); ?>"
                             alt="<?php echo esc_attr($image_alt); ?>"
                             class="w-full h-auto object-cover"
                             loading="lazy">
                        <?php if ($image_description): ?>
                            <figcaption class="text-small sm:text-xsmall text-right mt-1 animateOnView">
                                <?php echo esc_html($image_description); ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                </section>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>	

	<section class="grid grid-cols-1 sm:grid-cols-12 mt-sp8 text-left align-baseline">
		<?php if (!empty($exhibition_supporters)): ?>
			<div class="wysiwyg-credits flex flex-col col-span-1 sm:col-span-6">
				<h4 class="animateOnView">
					<?php echo pll__('The exhibition is generously supported by', 'tailpress'); ?>
				</h4>
				<div class="w-full sm:w-[calc(90%+1vw)] animateOnView">
					<?php echo($exhibition_supporters); ?>
				</div>		
			</div>
		<?php endif; ?>

		<div class="col-span-1 sm:col-span-6 my-sp8 sm:my-0 animateOnView">
			<?php $credits = get_field('exhibition-credits'); ?>
				<?php if( $credits ): // Check if the field is not empty ?>
					<div class="wysiwyg-credits w-full sm:w-[calc(90%+1vw)]">
						<?php echo wp_kses_post($credits); ?>
					</div>
				<?php endif; ?>
		</div>
	</section>

</article>
