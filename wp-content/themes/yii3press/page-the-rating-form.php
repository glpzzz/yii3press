<?php

use Glpzzz\Yii3press\Forms\RatingForm;
use Yiisoft\FormModel\Field;
use Yiisoft\Html\Html;

/** @var RatingForm $form */
global $form;

?>


<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php the_content(); ?>

<?= Html::form()
	->post(esc_url(admin_url('admin-post.php')))
	->open()
?>

<?= Field::hidden($form, 'action')->name('action') ?>
<?= Field::text($form, 'name') ?>
<?= Field::email($form, 'email') ?>
<?= Field::range($form, 'rating') ?>
<?= Field::textarea($form, 'comment') ?>

<?= Html::submitButton('Send') ?>

<?= "</form>" ?>

<?php get_footer(); ?>
