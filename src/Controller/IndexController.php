<?php

namespace App\Controller;

use App\Lib\Coupon\CouponInterface;
use App\Lib\VATNumber\VATNumber;
use App\Process\CalculatePrice\CalculatePriceInterface;
use App\Process\CouponFinder\CouponFinderInterface;
use App\Process\PaymentProcessor\PaymentProcessorBuilderInterface;
use App\Process\ProductFinder\ProductFinderInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class IndexController extends AbstractController
{
    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(Request $request, ProductFinderInterface $productFinder, CouponFinderInterface $couponFinder, CalculatePriceInterface $calculatePrice): Response
    {
        try {
            $data = $request->toArray();
            $this->validateData($data);

            $price = $calculatePrice->calculate(
                $productFinder->find($data['product']),
                new VATNumber($data['taxNumber']),
                $this->detectCoupon($data, $couponFinder)
            );

            return new JsonResponse(['price' => $price]);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/purchase', methods: ['POST'])]
    public function purchase(Request $request, ProductFinderInterface $productFinder, CouponFinderInterface $couponFinder, CalculatePriceInterface $calculatePrice, PaymentProcessorBuilderInterface $paymentProcessorBuilder): Response
    {
        try {
            $data = $request->toArray();
            $this->validateData($data, ['purchase']);

            $price = $calculatePrice->calculate(
                $productFinder->find($data['product']),
                new VATNumber($data['taxNumber']),
                $this->detectCoupon($data, $couponFinder)
            );

            $paymentProcessorBuilder->buildByName($data['paymentProcessor'])->pay($price);

            return new JsonResponse(['price' => $price, 'pay' => 'ok']);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    private function detectCoupon(array $data, CouponFinderInterface $couponFinder): ?CouponInterface
    {
        if (isset($data['couponCode'])) {
            return $couponFinder->find($data['couponCode']);
        }

        return null;
    }

    private function validateData(array $data, array $validationGroup = ['price'])
    {
        $data = $data + [
                'product' => null,
                'taxNumber' => null,
                'paymentProcessor' => null
            ];

        $validator = Validation::createValidator();
        $groups = new Assert\GroupSequence($validationGroup);

        $constraint = new Assert\Collection([
            'product' => new Assert\Regex('/^\d+$/', groups: ['price', 'purchase']),
            'taxNumber' => new Assert\NotBlank(groups: ['price', 'purchase']),
            'couponCode' => new Assert\Optional([new Assert\NotBlank()], groups: ['price', 'purchase']),
            'paymentProcessor' => new Assert\NotBlank(groups: ['purchase'])
        ]);

        $violations = $validator->validate($data, $constraint, $groups);

        if ($violations->count()) {
            throw new Exception('Field: ' . $violations[0]->getPropertyPath() . ' Error: ' . $violations[0]->getMessage());
        }
    }
}
