<?php
?>
<!-- search -->	
<div class="classify__search_form">
	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
		<div class="input-group">
			<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e( 'Enter keyword', 'classify' ); ?>">
			<div class="input-group-btn">
				<button class="btn btn-primary" type="submit">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</div>
	</form>
</div>

