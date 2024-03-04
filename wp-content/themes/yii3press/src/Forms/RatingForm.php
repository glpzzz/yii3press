<?php

namespace Glpzzz\Yii3press\Forms;

use Yiisoft\FormModel\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Integer;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

class RatingForm extends FormModel implements RulesProviderInterface
{

	private ?string $name = null;
	private ?string $email = null;
	private ?int $rating = null;
	private ?string $comment = null;
	private string $action = 'the_rating_form';

	public function getPropertyLabels(): array
	{
		return [
			'name' => 'Name',
			'email' => 'Email',
			'rating' => 'Rating',
			'comment' => 'Comment',
		];
	}

	public function getRules(): iterable
	{
		return [
			'name' => [
				new Required(),
			],
			'email' => [
				new Required(),
				new Email(),
			],
			'rating' => [
				new Required(),
				new Integer(min: 0, max: 5),
			],
			'comment' => [
				new Length(min: 100),
			],
		];
	}
}
