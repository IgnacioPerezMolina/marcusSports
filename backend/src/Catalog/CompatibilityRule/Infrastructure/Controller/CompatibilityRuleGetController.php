<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\CompatibilityRule\Infrastructure\Controller;

use MarcusSports\Catalog\CompatibilityRule\Application\Get\CompatibilityRuleGetter;
use MarcusSports\Catalog\CompatibilityRule\Application\Get\GetCompatibilityRuleRequest;
use MarcusSports\Catalog\CompatibilityRule\Domain\Repository\CompatibilityRuleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CompatibilityRuleGetController
{
    public function __construct(
        private CompatibilityRuleGetter $compatibilityRuleGetter,
        private CompatibilityRuleRepository $repository
    )
    {
    }
    public function __invoke(Request $request)
    {
        $compatibilityRules = $this->compatibilityRuleGetter->__invoke(new GetCompatibilityRuleRequest($request), $this->repository);

        return new Response(
            json_encode($compatibilityRules),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }


}