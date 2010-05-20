<?php
/**
 * Gearman worker controller
 *
 * @author Russell Smith <russell.smith@ukd1.co.uk>
 * @copyright UKD1 Limited 2010
 */
class Gearman_Controller extends Controller {

	const ALLOW_PRODUCTION = TRUE;
	
	private $worker;
	private $client;

	public function __construct()
	{
		parent::__construct();
		
		// get a new gearman worker
		$this->worker = new GearmanWorker();
		
		// add the servers in the config
		foreach (Kohana::config('gearman.server_list') as $server) {
			$this->worker->addServer($server);
		}
		
		// add functions
		$this->worker->addFunction("send_notification_email", array($this, 'send_notification_email'));
	}
	
	public function workers () {
		while($this->worker->work())
		{
		    switch ($this->worker->returnCode())
		    {
		        case GEARMAN_SUCCESS:
		            echo "SUCESS RET: " . $this->worker->returnCode() . "\n";
		            break;
		        default:
		            echo "ERROR RET: " . $this->worker->returnCode() . "\n";
		            exit;
		    }
		}
	}

	public function send_notification_email ($job = null) {
		$p = unserialize($job->workload());

		fputs(STDOUT, print_r($p,true));

		fputs(STDOUT, "\nEmail\t".$p['to']);
		
		$to = array($p['to'], $p['to_name']);
		$from = array(Kohana::config('email.notifcation_email_address'), Kohana::config('email.notifcation_email_name'));
		
		$result = email::send($to, $from, $p['subject'], $p['body'], TRUE);

		fputs(STDOUT, "Result : $result\n\n");

	//	$result = email::send('russell.smith@ukd1.co.uk', Kohana::config('email.notifcation_email_address'), 'KO Email test', 'debug', TRUE);

	//	fputs(STDOUT, "Result : $result\n\n");

		return $result ? GEARMAN_SUCCESS : false;
	}
}