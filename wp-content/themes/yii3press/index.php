<?php get_header() ?>

<?php if (have_posts()) : ?>

	<h1>The Blog Loop</h1>

	<ul>
		<?php while (have_posts()) : the_post(); ?>
			<li>
				<h2>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<time><?php the_date(); ?></time>
				<p>
					<?php the_excerpt(); ?>
				</p>
			</li>
		<?php endwhile; ?>
	</ul>

<?php else : ?>

	<p>Sorry, no posts found.</p>

<?php endif; ?>

<?php get_footer() ?>
