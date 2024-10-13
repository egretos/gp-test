<?php

namespace Egretos\GamepointTestTask\Validators;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ViewTransactionsRequestValidator
{
	private ValidatorInterface $validator;
	
	public function __construct()
	{
		$this->validator = Validation::createValidator();
	}
	
	public function validate(array $data): array
	{
		$data['page'] = (string)$data['page'];
		
		foreach ($data as $key => $value) {
			if ($value === '') {
				$data[$key] = null;
			}
		}
		
		$constraint = new Assert\Collection([
			'page' => new Assert\Optional([
				new Assert\Type('digit'),
				new Assert\GreaterThan(0),
			]),
			'user_id' => new Assert\Optional([
				new Assert\Regex('/^[a-zA-Z0-9-]*$/'),
			]),
			'country_code' => new Assert\Optional([
				new Assert\Length(['min' => 2, 'max' => 2]),
				new Assert\Regex('/^[A-Z]{2}$/'),
			]),
			'currency_code' => new Assert\Optional([
				new Assert\Length(['min' => 3, 'max' => 3]),
				new Assert\Regex('/^[A-Z]{3}$/'),
			]),
			'date' => new Assert\Optional(new Assert\Date()),
		]);
		
		$violations = $this->validator->validate($data, $constraint);
		
		$errors = [];
		if (count($violations) > 0) {
			foreach ($violations as $violation) {
				$errors[] = $violation->getPropertyPath().': '.$violation->getMessage();
			}
		}
		
		return $errors;
	}
}