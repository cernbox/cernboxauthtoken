<?php
namespace OCA\CernBoxAuthToken\AppInfo;

use OCP\AppFramework\App;
use \Firebase\JWT\JWT;

class Application extends App {

	private $jwt_sign_secret = "";

	/**
	 * Application constructor.
	 *
	 * @param array $urlParams Variables extracted from the routes.
	 */
	public function __construct(array $urlParams = array()) {
		parent::__construct('cernboxauthtoken', $urlParams);
		$this->jwt_sign_secret = \OC::$server->getConfig()->getSystemValue('cernboxauthtoken.jwt_sign_secret', 'bar');

		// When we don't have state, the normal call to getUser (like in boot())
		// will return empty. Waiting for the login to be done solves the problem.
		$serverContainer = $this->getContainer()->query('ServerContainer');
		$userManager = $serverContainer->getUserManager();
		$userManager->listen('\OC\User', 'postLogin', function($user) {
			$this->setToken($user);
		});
	}

	public function boot() {
		$user = \OC::$server->getUserSession()->getUser();
		if($user) {
			$this->setToken($user);
		}
	}

	public function setToken($user) {
		$identity = $user->getUID();
		header("X-Access-Token: $identity");
		$token = $this->forgeToken($user);
		$data = ["key" => "cernboxauthtoken", "x-access-token" => $token];
		\OCP\Util::addHeader("data", $data);

	}

	public function forgeToken($user) {
		$token = [
			"account_id" => $user->getUID(),
			"groups" => [],
			"display_name" => $user->getDisplayName()
		];
		$jwt = JWT::encode($token, $this->jwt_sign_secret);
		return $jwt;
	}
}
