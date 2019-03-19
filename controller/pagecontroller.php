<?php
/**
 * ownCloud - cernboxauthtoken
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Hugo Gonzalez Labrador <hugo.gonzalez.labrador@cern.ch>
 * @copyright Hugo Gonzalez Labrador 2018
 */

namespace OCA\CernBoxAuthToken\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

class PageController extends Controller {


	private $userId;

	public function __construct($AppName, IRequest $request, $UserId){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
	}

       /**
        * @NoAdminRequired
        * @NoCSRFRequired
        */
	public function logout() {
		$ocUser = \OC::$server->getUserSession()->getUser();
		$ocUsername = null;
		$ssoUsername = null;
		if($ocUser !== null) {
			$ocUsername = $ocUser->getUID();			
		}

		if(isset($_SERVER['ADFS_LOGIN'])) {
			$ssoUsername = $_SERVER['ADFS_LOGIN'];
		}
			
		\OC::$server->getLogger()->error("logging out: OCUSERNAME=$ocUsername SSOUSERNAME=$ssoUsername");
		\OC::$server->getUserSession()->logout();
		// redirect user to SSO logout
		$ref = "https://login.cern.ch/adfs/ls/?wa=wsignout1.0";
		header("Location: $ref");
		exit();
	}

	public function doEcho($echo) {
		//return new DataResponse(['echo' => $echo]);
	}


}
