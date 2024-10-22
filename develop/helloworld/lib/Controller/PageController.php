<?php

declare(strict_types=1);

namespace OCA\HelloWorld\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\FrontpageRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class PageController extends Controller
{
    public function __construct($appName, IRequest $request)
    {
        parent::__construct($appName, $request);
    }

    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'GET', url: '/')]
    public function index(?string $getParameter): TemplateResponse
    {
        if ($getParameter === null) {
            $getParameter = "";
        }

        // The TemplateResponse loads the 'index.php'
        // defined in our app's 'templates' folder.
        // We pass the $getParameter variable to the template
        // so that the value is accessible in the template.
        return new TemplateResponse(
            'helloworld',
            'index',
            ['myMessage' => $getParameter]
        );
    }
}