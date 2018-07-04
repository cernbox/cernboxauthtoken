/**
 * ownCloud - cernboxauthtoken
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Hugo Gonzalez Labrador <hugo.gonzalez.labrador@cern.ch>
 * @copyright Hugo Gonzalez Labrador 2018
 */

(function ($, OC) {

	$(document).ready(function () {
		var data = $("data[key='cernboxauthtoken']");
		var accessToken = data.attr('x-access-token');
		if(accessToken) {
			OC["X-Access-Token"] = accessToken;
			/*
			OC.Files.getClient()["_defaultHeaders"]["X-Access-Token"] = accessToken;

			$.ajaxSetup({
				    headers: { 'X-Access-Token': accessToken }
			});

			$(document).on('ajaxSend',function(elm, xhr, settings) {
				xhr.setRequestHeader('X-Access-Token', accessToken);
			});
			*/

			XMLHttpRequest.prototype.origOpen = XMLHttpRequest.prototype.open;
			XMLHttpRequest.prototype.open   = function () {
				this.origOpen.apply(this, arguments);
				this.setRequestHeader('X-Access-Token', accessToken);
			};

		}
	});

})(jQuery, OC);
