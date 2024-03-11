<?php

namespace App\Validator;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FormValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws ValidationException
     */
    public function validateData(array $data): void
    {
        $constraints = new Assert\Collection([
            'name' => new Assert\NotBlank(),
            'agreeToTerms' => new Assert\NotBlank(),
            'sectors' => [new Assert\NotBlank(), new Assert\Type(['type' => 'array'])],
        ]);

        $violations = $this->validator->validate($data, $constraints);

        if ($violations->count() > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $propertyPath = trim($violation->getPropertyPath(), "[]");
                $errors[$propertyPath] = $violation->getMessage();
            }

            throw new ValidationException('Validation failed', $errors);
        }
    }
}