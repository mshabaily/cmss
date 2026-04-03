<? cmss_header(); ?>

<? use CMSS\Settings; ?>

<main class="pages">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="items records card">
                <div class="title flex-row">
                    <h3>All Pages</h3>
                    <a href="/cmss/new-page" class="button">
                        New Page
                    </a>
                </div>
                <div class="content flex-column">

                    <? $items = cmss_pages(); ?>

                    <? if (!$items) { ?>
                        <p class="no-content">No pages found, create a new page to get started!</p>
                    <? } else { ?>

                        <? include cmss_partial('pagination-before.php');

                        foreach ($current_page_items as $page) { ?>
                            <div class="record flex-row">
                                <div class="record-title flex-row">
                                    Title:
                                    <?= $page['title']; ?>
                                </div>
                                <div class="end flex-row">
                                    <? if (Settings::getInstance()->is_front($page['page_id'])) {
                                        $url = '';
                                    } else {
                                        $url = $page['url'];
                                    } ?>
                                    <a class="edit" href="<?= site_url() . '/' . $url ?>" target="_blank">
                                        View
                                    </a>
                                    <a class="edit" href="/cmss/edit-page?id=<?= $page['page_id']; ?>">
                                        Edit
                                    </a>
                                    <button class="delete-page" href="/cmss/delete-page?id=<?= $page['page_id']; ?>">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        <? } ?>
                        <? include cmss_partial('pagination-after.php'); ?>
                    <? } ?>
                </div>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>