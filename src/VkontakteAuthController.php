<?php

namespace Dem13n\Auth\Vkontakte;

use Exception;
use Flarum\Forum\Auth\Registration;
use Flarum\Forum\Auth\ResponseFactory;
use Flarum\Http\UrlGenerator;
use Flarum\Settings\SettingsRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;
use J4k\OAuth2\Client\Provider\Vkontakte;
use J4k\OAuth2\Client\Provider\VkontakteResourceOwner;

class VkontakteAuthController implements RequestHandlerInterface
{
    protected $response;
    protected $settings;
    protected $url;

    public function __construct(ResponseFactory $response, SettingsRepositoryInterface $settings, UrlGenerator $url)
    {
        $this->response = $response;
        $this->settings = $settings;
        $this->url = $url;
    }

    public function handle(Request $request): ResponseInterface
    {
        $redirectUri = $this->url->to('forum')->route('auth.vkontakte');

        $provider = new Vkontakte([
            'clientId' => $this->settings->get('dem13n-auth-vkontakte.app_id'),
            'clientSecret' => $this->settings->get('dem13n-auth-vkontakte.app_key'),
            'redirectUri' => $redirectUri,
            'version' => '5.101'
        ]);

        $session = $request->getAttribute('session');
        $queryParams = $request->getQueryParams();

        $code = array_get($queryParams, 'code');

        if (!$code) {
            $authUrl = $provider->getAuthorizationUrl();
            $session->put('oauth2state', $provider->getState());

            return new RedirectResponse($authUrl . '&display=popup');
        }

        $state = array_get($queryParams, 'state');

        if (!$state || $state !== $session->get('oauth2state')) {
            $session->remove('oauth2state');

            throw new Exception('Invalid state');
        }

        $token = $provider->getAccessToken('authorization_code', compact('code'));

        $user = $provider->getResourceOwner($token);

        return $this->response->make(
            'vkontakte',
            $token->getResourceOwnerId(),
            function (Registration $registration) use ($user) {
                $reg =  $registration->provideAvatar(array_get($user->toArray(), 'photo_100'))->suggestUsername($user->getName());
                empty($user->getEmail()) ?  $reg->suggestEmail('') : $reg->provideTrustedEmail($user->getEmail());
                $reg->setPayload($user->toArray());
            }
        );
    }
}
