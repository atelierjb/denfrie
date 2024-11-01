


<?php do_action( 'tailpress_content_end' ); ?>

</div> <!-- id="page" ends -->


<?php do_action( 'tailpress_content_after' ); ?>

<ul class="w-full flex justify-between sm:grid sm:grid-cols-12 px-sp3 pt-sp6 pb-sp8 sm:pb-sp5 list-none font-dfserif text-medium/[0.95] animateOnView">
		<li class="sm:col-span-3">
			<a href="<?php echo get_permalink(pll_get_post(4)); ?>#newsletter" class="hover:text-df-red">
    			<?php echo pll__('Newsletter', 'tailpress'); ?>
			</a>
		</li>
		<li class="hidden sm:block sm:col-span-3">
			<a href="<?php echo get_permalink(pll_get_post(4)); ?>#annualpass" class="hover:text-df-red">
    			<?php echo pll__('Annual pass', 'tailpress'); ?>
			</a>
		</li>
		<?php
		$info_post = get_translated_info_post(); // Make sure this function is defined in functions.php
		if ($info_post) :
		?>
			<li class="sm:col-span-3">
				<a class="hover:text-df-red" target="_blank" href="<?php echo esc_url(get_field('info-instagram', $info_post->ID)); ?>">
					Instagram
				</a>
			</li>
			<li class="mt-0 sm:-ml-[2px] sm:col-auto">
				<a class="hover:text-df-red" target="_blank" href="<?php echo esc_url(get_field('info-facebook', $info_post->ID)); ?>">
					Facebook
				</a>
			</li>
		<?php endif; ?>

		<li class="sm:col-span-2 sm:place-self-end">
			<a class="hover:text-df-red" href="#" id="back-to-top">
				↑
			</a>
		</li>
</ul>



<?php wp_footer(); ?>

<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/7.1.0/ionicons/ionicons.esm.min.js"></script>
	<script nomodule src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/7.1.0/ionicons/ionicons.min.js"></script>


</body>
</html>
