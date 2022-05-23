<?php declare(strict_types=1);

namespace App\Controller\ApiV2;

use App\Entity\PassportIssuerV2;
use App\Repository\PassportIssuerV2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PassportIssuerController extends AbstractController
{
    public function getIssuers(Request $request, PassportIssuerV2Repository $repository): JsonResponse
    {
        $issuers = $repository->fetchFromFilters($request->query->get('passportCode'));
        $issuersData = [];

        /** @var PassportIssuerV2 $issuer */
        foreach ($issuers as $issuer) {
            $issuersData[] = [
                'id' => $issuer->getId(),
                'code' => $issuer->getCode(),
                'name' => $issuer->getName(),
                'end_date' => $issuer->getEndDate() ? $issuer->getEndDate()->format('Y-m-d') : null,

            ];
        }

        return new JsonResponse([
            'issuers' => $issuersData
        ]);
    }
}
