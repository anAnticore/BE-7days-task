<?php

declare(strict_types=1);

namespace App\Form;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class DateTimeTask
{
    /**
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    public string $date;

    /**
     * @Assert\NotBlank()
     * @Assert\Timezone()
     */
    public string $timezone;
}