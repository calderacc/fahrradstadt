<?php declare(strict_types=1);

namespace AppBundle\UserProvider;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseClass
{
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response): void
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        $service = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($service);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';

        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        $user
            ->$setter_id($username)
            ->$setter_token($response->getAccessToken())
        ;

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response): UserInterface
    {
        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));

        if (null === $user) {
            $service = $response->getResourceOwner()->getName();

            $setter = 'set' . ucfirst($service);
            $setter_id = $setter . 'Id';
            $setter_token = $setter . 'AccessToken';

            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());

            $this->setUserData($user, $response);
        } else {
            $user = parent::loadUserByOAuthUserResponse($response);
            $serviceName = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

            $user->$setter($response->getAccessToken());
        }

        $this->updateProfilePicture($user, $response);

        $this->userManager->updateUser($user);

        return $user;
    }

    protected function setUserData(UserInterface $user, UserResponseInterface $response): UserInterface
    {
        $username = $response->getNickname() ? $response->getNickname() : $response->getUsername();
        $email = $response->getEmail() ? $response->getEmail() : $response->getUsername();
        $firstname = $response->getFirstName();
        $lastname = $response->getLastName();
        $realname = $response->getRealName();

        if (!$firstname && !$lastname && $realname) {
            $nameParts = explode(' ', $realname);

            $firstname = array_shift($nameParts);
            $lastname = array_pop($nameParts);
        }

        $user
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setUsername($username)
            ->setEmail($email)
            ->setPassword('')
            ->setEnabled(true)
        ;

        return $user;
    }

    protected function updateProfilePicture(UserInterface $user, UserResponseInterface $response): UserInterface
    {
        $user->setProfilePictureUrl($response->getProfilePicture());

        return $user;
    }
}
