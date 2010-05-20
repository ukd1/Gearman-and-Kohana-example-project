<?php
/**
 * Gearman worker controller
 *
 * @author Russell Smith <russell.smith@ukd1.co.uk>
 * @copyright UKD1 Limited 2010
 */
class Welcome_Controller extends Template_Controller {

	const ALLOW_PRODUCTION = TRUE;

	// Set the name of the template to use
	public $template = 'welcome';

	public function index () {
	}

	private function validate_email_form () {
		$messages = array();

		if (valid::email($this->input->post('email')) == false) {
			$messages[] = 'The supplied email address does not appear valid';
		}
		
		if ($this->input->post('body') == '') {
			$messages[] = 'The body of your message should not be empty';
		}

		return $messages;
	}

	public function send_email () {
		$this->profiler = new Profiler;
		$messages = $this->validate_email_form();

		if (empty($messages)) {

			$to = array($this->input->post('email'), 'KO User');
			$from = array(Kohana::config('email.notifcation_email_address'), Kohana::config('email.notifcation_email_name'));

			if (email::send($to, $from, 'KO Email test', $this->input->post('body'), TRUE)) {
				$this->template->messages = array('Message sent');
			} else {
				$this->template->messages = array('Message send failed');
			}
		} else {
			$this->template->messages = $messages;
		}
	}
	
	public function send_email_gearman () {
		$this->profiler = new Profiler;
		$messages = $this->validate_email_form();

		if (empty($messages)) {
			$gearman = new Gearman();
			$gearman->send_notification_email($this->input->post('email'), 'KO User', 'KO Gearman Email test', $this->input->post('body'));
			$this->template->messages = array('Message queued');
		} else {
			$this->template->messages = $messages;
		}
	}
}