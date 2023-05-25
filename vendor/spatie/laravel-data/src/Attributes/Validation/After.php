<?php

namespace Spatie\LaravelData\Attributes\Validation;

use Attribute;
use DateTimeInterface;
use Spatie\LaravelData\Support\Validation\References\FieldReference;

#[Attribute(Attribute::TARGET_PROPERTY)]
class After extends StringValidationAttribute
{
    public function __construct(protected string|DateTimeInterface|FieldReference $date)
    {
    }

    public static function keyword(): string
    {
        return 'after';
    }

    public function parameters(): array
    {
        return [$this->date];
    }

    public static function create(string ...$parameters): static
    {
        return parent::create(
            self::parseDateValue($parameters[0]),
        );
    }
}
