<?php if(is_active_sidebar('widget-1') or is_active_sidebar('widget-2') or is_active_sidebar('widget-3')): ?>
<div class="footer-top">
	<div class="container">
		<div class="col-sm-4 ft-left-col">
			<?php dynamic_sidebar( 'widget-1' ); ?>
		</div>
		<div class="col-sm-4 ft-middle-col">
			<?php dynamic_sidebar( 'widget-2' ); ?>
		</div>
		<div class="col-sm-4 ft-right-col">
			<?php dynamic_sidebar( 'widget-3' ); ?>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="footer">
	<div class="container">
		<p class="copyright">&copy; <?php echo date('Y'); ?> - <a href="http://frenchtastic.eu">Design by Frenchtastic.eu</a></p>
		<p><a href="#"><i class="fa fa-angle-up"></i> <?php echo __('Back to top', 'montblanc'); ?><a></p>
	</div>
</div>
</div> <!-- wrap -->
<?php wp_footer(); ?>
</body>
</html>