<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\PassportIssuer;
use App\Repository\PassportIssuerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PassportIssuerController extends AbstractController
{
    public function getIssuers(Request $request, PassportIssuerRepository $repository): JsonResponse
    {
        $issuers = $repository->fetchFromFilters($request->query->get('passportCode'));
        $issuersData = [];

        /** @var PassportIssuer $issuer */
        foreach ($issuers as $issuer) {
            $issuersData[] = [
                'id' => $issuer->getId(),
                'issued_by' => $issuer->getIssuedBy(),
                'region_id' => $issuer->getRegionId(),
                'passport_code' => $issuer->getPassportCode(),
            ];
        }

        return new JsonResponse([
            'issuers' => $issuersData
        ]);
    }
}
