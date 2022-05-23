<?php
namespace App\Controller;

use App\Entity\PassportIssuer;
use App\Repository\PassportIssuerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PassportIssuerController
{
    /**
     * @param Request $request
     * @param PassportIssuerRepository $repository
     *
     * @return JsonResponse
     */
    public function getIssuers(Request $request, PassportIssuerRepository $repository)
    {
        $issuers =  $repository->fetchFromFilters($request->query->get('passportCode'));
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
