<!DOCTYPE html>
<html>
  <head>
    <title>Kohana Gearman Example</title>
	<style type="text/css">
		body { background-color: gray; }
		section { margin: 2em; padding: 1em; background-color: white; }
		input[type="email"], textarea { width: 300px; border: 1px solid gray; padding: 0.75em }
	</style>
  </head>
  <body>
	<?php
	if (isset($messages)) {
		?>
	  <section>
		  <h1>Messages</h1>
		  <ul>
		  <?php
		  foreach ($messages as $message) {
			  print '<li>' . $message . '</li>';
		  }
		  ?>
		  </ul>
	  </section>
		<?php
	}
	?>
	<section>
		<form method="post" action="<?php print url::site('welcome/send_email') ?>">
			<h1>Sending an email via SMTP</h1>
			<p>This form will send an email using SMTP and return afterwards.</p>
			<p><input name="email" type="email" value="<?php print $this->input->post('email') ?>" /></p>
			<p><textarea name="body"><?php print $this->input->post('body') ?></textarea></p>
			<p><input type="submit" value="Send" /></p>
		</form>
	</section>

	<section>
		<form method="post" action="<?php print url::site('welcome/send_email_gearman') ?>">
			<h1>Sending an email via SMTP with gearman</h1>
			<p>This form will queue an email to be sent and return afterwards.</p>
			<p><input name="email" type="email" value="<?php print $this->input->post('email') ?>" /></p>
			<p><textarea name="body"><?php print $this->input->post('body') ?></textarea></p>
			<p><input type="submit" value="Send" /></p>
		</form>
	</section>
  </body>
</html>