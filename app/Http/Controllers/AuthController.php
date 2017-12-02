<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use CSUNMetaLab\Authentication\Factories\HandlerLDAPFactory;
use CSUNMetaLab\Authentication\Factories\LDAPPasswordFactory;

class AuthController extends Controller
{
	public function getLogin() {
		return view('auth.login');
	}

	public function postLogin(Request $request) {
		$username = $request->input('username');
		$password = $request->input('password');

		if(Auth::attempt(['username' => $username, 'password' => $password])) {
			return redirect('/home');
		}
		else
		{
			return back()->withErrors(['Invalid username or password']);
		}
	}

	public function getLogout() {
		Auth::logout();
		return redirect('/');
	}

	public function getRegister() {
		return view('auth.register');
	}

	public function postRegister(Request $request) {
		$name = $request->input('name');
		$email = $request->input('email');
		$pw = $request->input('password');

		$pwhash = LDAPPasswordFactory::SSHA($pw); // SSHA hash
		$uid = 'ex_' . bin2hex(random_bytes(4)); // random UID

		// retrieve a new HandlerLDAP instance and connect to the configured
		// host
		$ldap = HandlerLDAPFactory::fromDefaults();
		$ldap->connect();

		// set up the attributes to be added to the new record
		$nameArr = explode(" ", $name);
		$attrs = [
			'objectClass' => 'inetOrgPerson',
			'uid' => $uid,
			'mail' => $email,
			'displayName' => $name,
			'cn' => $name,
			'sn' => (!empty($nameArr[1]) ? $nameArr[1] : "Example"),
			'givenName' => $nameArr[0],
			'userPassword' => $pwhash,
		];

		// add the object to the add subtree
		$success = $ldap->addObject($uid, $attrs);
		if($success) {
			return "Successfully registered account {$name}! UID: {$uid}";
		}

		return "Could not register {$name}. UID: {$uid}. Please try again";
	}

	public function getResetPW() {
		return view('auth.passwords.reset');
	}

	public function postResetPW(Request $request) {
		// this lets a logged-in user reset their own password due to the bind
		// as "self" as opposed to the LDAP_MODIFY_DN and LDAP_MODIFY_PW values
		// from the .env file
		$cur_pw = $request->input('current_password');

		$email = Auth::user()->email; // get current user email
		$new_pw = $request->input('password');

		// retrieve a new HandlerLDAP instance and connect to the configured
		// host
		$ldap = HandlerLDAPFactory::fromDefaults();
		$ldap->connect();

		// get the matching object for the logged-in user and resolve its DN
		$obj = $ldap->searchByAuth($email);
		$dn = $ldap->getAttributeFromResults($obj, 'dn');

		// modification method of "self": make sure the user has the correct
		// password by performing another bind; this will not be executed if
		// the admin modify DN and password are being used instead
		if(config('ldap.modify_method') == "self") {
			$ldap->connectByDN($dn, $cur_pw);
		}

		// we will be resetting the password, so use the convenience method to
		// generate a SSHA hash and save it automatically
		$success = $ldap->modifyObjectPassword($dn, $new_pw);
		if($success) {
			return "Successfully changed the password for {$email}! DN: {$dn}";
		}

		return "Could not change the password for {$email}. DN: {$dn}";
	}

}