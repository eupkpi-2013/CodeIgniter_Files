<h1>Tutorial: Simple Login Form</h1>

<?php if($this->session->flashdata('message')) : ?>
	<p><?=$this->session->flashdata('message')?></p>
<?php endif; ?>

<?=form_open('main/index/')?>
	<?=form_fieldset('Login Form')?>
	
		<div class="textfield">
			<?=form_label('username', 'user_name')?>
			<?=form_error('user_name')?>
			<?=form_input('user_name', set_value('user_name'))?>
		</div>
		
		<div class="textfield">
			<?=form_label('password', 'user_pass')?>
			<?=form_error('user_pass')?>
			<?=form_password('user_pass')?>
		</div>
		
		<div class="buttons">
			<?=form_submit('login', 'Login')?>
		</div>
		
	<?=form_fieldset_close()?>
<?=form_close();?>