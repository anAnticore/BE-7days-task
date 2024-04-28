<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\DateTimeTask;
use App\Form\DateTimeType;
use App\Service\DateTimeService;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TimeZoneController extends AbstractController
{
    private DateTimeService $dateTimeService;

    public function __construct(DateTimeService $dateTimeService)
    {
        $this->dateTimeService = $dateTimeService;
    }

    /**
     * @Route("/form", name="app_time_zone_form")
     */
    public function process(Request $request): Response
    {
        $form = $this->createForm(DateTimeType::class);

        return $this->render(
            'date-time/form.html.twig',
            [
                'form' => $form->createView(),
                'result' => $this->handle($form, $request)
            ]
        );
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     * @return array<string, int|string>|null
     */
    private function handle(FormInterface $form, Request $request): ?array
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var DateTimeTask $data */
            $data = $form->getData();

            $immutable = $this->dateTimeService->getImmutable($data->date);
            $offset = $this->dateTimeService->getOffset($data->timezone);
            $daysInFebruary = $immutable !== null ?
                $this->dateTimeService->getDaysInFebruaryByYear($immutable->format('Y')) : null;

            if ($immutable === null || $offset === null || $daysInFebruary === null) {
                $form->addError(
                    new FormError(
                        sprintf(
                            'Unprocessable %s timezone and date %s',
                            $data->timezone,
                            $data->date
                        )
                    )
                );
            } else {
                $result = [
                    'timezone' => $data->timezone,
                    'offset' => $offset,
                    'month' => $immutable->format('F'),
                    'daysInMonth' => $immutable->format('t'),
                    'daysInFebruary' => $daysInFebruary,
                ];
            }
        }

        return $result ?? null;
    }
}
