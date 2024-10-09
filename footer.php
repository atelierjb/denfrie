


<?php do_action( 'tailpress_content_end' ); ?>

</div>

<?php do_action( 'tailpress_content_after' ); ?>

<footer class="w-full flex justify-between sm:grid sm:grid-cols-12 px-sp3 pt-sp6 pb-sp8 sm:pb-sp5 list-none font-dfserif text-medium/[0.95]">
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
		<li class="sm:col-span-3">
			<a class="hover:text-df-red" target="_blank" href="<?php the_field('info-instagram', 'option'); ?>">
				Instagram
			</a>
		</li>
		<li class="mt-0 sm:-ml-[2px] sm:col-auto">
			<a class="hover:text-df-red" target="_blank" href="<?php the_field('info-facebook', 'option'); ?>">
				Facebook
			</a>
		</li>
		<li class="sm:col-span-2 sm:place-self-end">
			<a class="hover:text-df-red" href="#" id="back-to-top">
				↑
			</a>
		</li>
</footer>



<?php wp_footer(); ?>

<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/7.1.0/ionicons/ionicons.esm.min.js"></script>
	<script nomodule src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/7.1.0/ionicons/ionicons.min.js"></script>

</body>
</html>
