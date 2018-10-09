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
	}

	public function boot() {
		\OCP\Util::addScript('cernboxauthtoken', 'app');
		$user = \OC::$server->getUserSession()->getUser();
		if($user) {
			$identity = $user->getUID();
			header("X-Access-Token: $identity");
			$token = $this->forgeToken($user);
                        \OC::$server->getLogger()->error("IDENTITY $identity TOKEN $token");
			$data = ["key" => "cernboxauthtoken", "x-access-token" => $token];
			\OCP\Util::addHeader("data", $data);
		}
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
