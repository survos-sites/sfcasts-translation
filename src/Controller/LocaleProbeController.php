<?php
declare(strict_types=1);

namespace App\Controller;

use Survos\BabelBundle\Service\LocaleContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class LocaleProbeController extends AbstractController
{
    #[Route(path: '/locale-test', name: 'app_locale_probe', requirements: ['_locale' => 'en|fr|es'])]
    public function __invoke(Request $request, LocaleContext $lc)
    {
        $data = [
            'route__locale'   => $request->attributes->get('_locale'),
            'request->locale' => $request->getLocale(),
            'query__locale'   => $request->query->get('_locale'),
            'ea_locale'       => $request->query->get('ea_locale'),
            'path_info'       => $request->getPathInfo(),
            'accept_language' => $request->headers->get('Accept-Language'),
            'LocaleContext'   => $lc->get(),             // should reflect route /fr
            'LocaleContext_default'  => $lc->getDefault(),
            'LocaleContext_enabled'  => $lc->getEnabled(),
        ];
        return $this->json($data);
    }
}
