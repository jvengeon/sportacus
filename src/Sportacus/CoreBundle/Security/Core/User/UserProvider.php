<?php

namespace Sportacus\CoreBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as FOSUBUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider extends FOSUBUserProvider {
	
	public function connect(UserInterface $user, UserResponseInterface $response)
	{
		$property = $this->getProperty($response);
		$username = $response->getUsername();
		//on connect - get the access token and the user ID
		$service = $response->getResourceOwner()->getName();
		$setter = 'set'.ucfirst($service);
		$setter_id = $setter.'Id';
		$setter_token = $setter.'AccessToken';
		//we "disconnect" previously connected users
		if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
			$previousUser->$setter_id(null);
			$previousUser->$setter_token(null);
			$this->userManager->updateUser($previousUser);
		}
		//we connect current user
		$user->$setter_id($username);
		$user->$setter_token($response->getAccessToken());
		$this->userManager->updateUser($user);
	}
	
	/**
	* {@inheritdoc}
	*/
	public function loadUserByOAuthUserResponse(UserResponseInterface $response)
	{
		$username = $response->getUsername();
		$useremail = $response->getEmail();	// get email id
		$user = $this->userManager->findUserByEmail($useremail);
		//$user = $this->userManager->findUserBy(array($this->getProperty($response) => $useremail));
		//when the user is registrating
		if (null === $user) {
			$service = $response->getResourceOwner()->getName();
			$setter = 'set'.ucfirst($service);
			$setter_id = $setter.'Id';
			$setter_token = $setter.'AccessToken';
			// create new user here
			$user = $this->userManager->createUser();
			$user->$setter_id($username);
			$user->$setter_token($response->getAccessToken());
			$user->setUsername($useremail);
			$user->setEmail($useremail);
			$user->setPassword($username);
			$user->setEnabled(true);
			$this->userManager->updateUser($user);
			return $user;
		}
		
		//$user = $this->userManager->findUserByEmail($useremail);
		$serviceName = $response->getResourceOwner()->getName();
		$setter = 'set' . ucfirst($serviceName) . 'AccessToken';
		//update access token
		$user->$setter($response->getAccessToken());
		return $user;
	}
}