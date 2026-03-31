<h1>
    <?= cmss_field('title'); ?>
</h1>

<p>
    <?= cmss_field('text'); ?>
</p>

<img src="<?= cmss_field('image')['url']; ?>">

<? foreach (cmss_field('loop-items') as $item) { ?>
    <h2> <?= $item['heading']; ?> </h2>
    <p><?= $item['description']; ?></p>
<? } ?>

<style>
    h1 {
        font-size: 25px;
    }

    h2 {
        font-size: 20px;
    }
</style>