


<?php do_action( 'tailpress_content_end' ); ?>

</div>

<?php do_action( 'tailpress_content_after' ); ?>

<footer class="w-full flex justify-between px-sp3 pt-sp6 pb-sp5 list-none font-dfserif text-medium/[0.95]">
		<li><a href="<?php echo get_permalink(pll_get_post(4)); ?>#newsletter" class="hover:text-df-red">
    		<?php echo pll__('Newsletter', 'tailpress'); ?>
		</a></li>
		<li><a href="<?php echo get_permalink(pll_get_post(4)); ?>#annualpass" class="hover:text-df-red">
    		<?php echo pll__('Annual pass', 'tailpress'); ?>
		</a></li>
		<li><a class="hover:text-df-red" target="_blank" href="<?php the_field('info-instagram', 'option'); ?>">Instagram</a></li>
		<li><a class="hover:text-df-red" target="_blank" href="<?php the_field('info-facebook', 'option'); ?>">Facebook</a></li>
		<li><a class="hover:text-df-red" href="#" id="back-to-top">↑</a></li>
</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
