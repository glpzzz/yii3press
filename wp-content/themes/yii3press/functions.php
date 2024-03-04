<?php

use Glpzzz\Yii3press\Forms\RatingForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\FormModel\ValidationRulesEnricher;
use Yiisoft\Hydrator\Hydrator;
use Yiisoft\Hydrator\TypeCaster\CompositeTypeCaster;
use Yiisoft\Hydrator\TypeCaster\HydratorTypeCaster;
use Yiisoft\Hydrator\TypeCaster\NullTypeCaster;
use Yiisoft\Hydrator\TypeCaster\PhpNativeTypeCaster;

require __DIR__ . '/vendor/autoload.php';

// hydrator to be used to create and fill the forms
$hydrator = new Hydrator(
	new CompositeTypeCaster(
//		new NullTypeCaster(emptyString: true),
		new PhpNativeTypeCaster(),
		new HydratorTypeCaster(),
	)
);

if (!defined('INSUREMART_VERSION')) {
	// Replace the version number of the theme on each release.
	define('INSUREMART_VERSION', '1.0.0');
}

add_action('after_setup_theme', function () {
	add_theme_support('title-tag');
	add_theme_support('html5');
});

add_action('init', function () {
	ThemeContainer::initialize(
		[
			'default' => [
				'enrichFromValidationRules' => true,
			]
		], 'default', new ValidationRulesEnricher()
	);
});

add_filter('template_redirect', function () use ($hydrator) {
	// Get the queried object
	$queried_object = get_queried_object();

	// Check if it's a page
	if ($queried_object instanceof WP_Post && is_page()) {
		if ($queried_object->post_name === 'the-rating-form') {
			/** @var FormModel $form */
			global $form;
			if ($form === null) {
				$form = $hydrator->create(RatingForm::class, $_REQUEST['data'] ?? []);
			}


			if (isset($_REQUEST['data'])) {
				(new Yiisoft\Validator\Validator())->validate($form);
			}
		}
	}
});

add_action('admin_post_the_rating_form', fn() => handleForms($hydrator));
add_action('admin_post_nopriv_the_rating_form', fn() => handleForms($hydrator));

function handleForms(Hydrator $hydrator): void
{
	global $form;
	$form = $hydrator->create(RatingForm::class, $_REQUEST['RatingForm']);
	$result = (new Yiisoft\Validator\Validator())->validate($form);

	if ($form->isValid()) {
		// handle the form
	}

	get_template_part('page-the-rating-form');
}
