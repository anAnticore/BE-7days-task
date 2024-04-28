<?php

declare(strict_types=1);

namespace App\Service;

use Throwable;
use DateTimeZone;
use DateTimeImmutable;

class DateTimeService
{
    public function getImmutable(string $date): ?DateTimeImmutable
    {
        $immutable = DateTimeImmutable::createFromFormat('Y-m-d', $date);

        return $immutable !== false ? $immutable : null;
    }

    public function getOffset(string $timezone): ?int
    {
        try {
            $now = (new DateTimeImmutable('now', new DateTimeZone('UTC')));

            return (new DateTimeZone($timezone))->getOffset($now) / 60;
        } catch (Throwable $e) {
            return null;
        }
    }

    public function getDaysInFebruaryByYear(string $year): ?int
    {
        $immutable = DateTimeImmutable::createFromFormat('Y-m-d', $year . '-02-01');

        return $immutable !== false ? (int)$immutable->format('t') : null;
    }
}