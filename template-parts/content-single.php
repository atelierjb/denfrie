<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
       $exhibition_image = get_field('exhibition-image');
	   $exhibition_artists = get_field('exhibition-artists');
	   $exhibition_start_date = get_field('exhibition-start-date');
	   $exhibition_end_date = get_field('exhibition-end-date');
	   $exhibition_description = get_field('exhibition-description');
	   $exhibition_supporters = get_field('exhibition-supporters');
	   $exhibition_folder = get_field('exhibition-folder');
	   $exhibition_presskit = get_field('exhibition-presskit');
	?>

	<section class="pb-sp10 span-2">
        <figure class="mx-sp9 mb-sp1 overflow-hidden aspect-video">
            <img src="<?php echo esc_url($exhibition_image); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
        </figure>
            <div class="w-full">
                <h3 class="font-dfserif text-xxl/xxl">
                    	<?php the_title(); ?>
                </h3>
                <p class="font-superclarendon text-xl/xl">
                        <?php echo esc_html($exhibition_artists); ?>
                </p>
                <p class="font-superclarendon text-xl/xl">
                        <?php echo esc_html($exhibition_start_date); ?> — <?php echo esc_html($exhibition_end_date); ?>
                </p>
            </div>
    </section>

	<article class="columns-1 sm:columns-2 gap-sp1 pr-sp2">
		<section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <div class="font-superclarendon text-regular/regular indent-sp9 break-inside-avoid">
                    <?php echo($exhibition_description); ?>
					<p class="font-dfserif text-regular/regular">More</p>
                </div>		
        </section>
		<section class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                <div class="font-superclarendon text-regular/regular break-inside-avoid text-right">
					<a href="<?php echo esc_url($exhibition_folder); ?>" target="_blank" rel="noopener noreferrer" class="text-df-red hover:text-df-grey underline underline-offset-2">
						Read the exhibition folder here
					</a>
					<br>
					<a href="<?php echo ($exhibition_presskit); ?>" target="_blank" rel="noopener noreferrer" class="text-df-red hover:text-df-grey underline underline-offset-2">
						Go to presskit
					</a>
                </div>		
        </section>
			<figure class="w-full sm:w-[calc(90%+1vw)] pb-sp8">
                    <img src="<?php echo esc_url($exhibition_image); ?>" class="w-full h-auto" />
            </figure>
	</article>

	<section class="p-sp10 text-center">
		<h3 class="font-dfserif text-large/large">
			The exhibition is generously supported by
		</h3>
		<p class="font-superclarendon text-large/large">
			<?php echo($exhibition_supporters); ?>
		</p>
	</section>

</article>
