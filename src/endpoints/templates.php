<? cmss_header(); ?>

<? use CMSS\Router; ?>

<? if (cmss_user_role() != 'developer') {
    Router::getInstance()->redirect('dashboard');
} ?>

<main class="templates">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="records card">
                <div class="title flex-row">
                    <h3>All Templates</h3>
                    <a href="/cmss/new-template" class="button">
                        New Template
                    </a>
                </div>
                <div class="content flex-column">
                    <? $items = cmss_templates();

                    if (!$items) { ?>
                        <p class="no-content">No templates found, create a new page to get started!</p>
                    <? } else { ?>

                        <? include cmss_partial('pagination-before.php');

                        foreach ($current_page_items as $template) { ?>
                            <div class="template record flex-row">
                                <div class="record-title flex-row">
                                    Title: <?= $template['title']; ?>
                                </div>
                                <div class="end flex-row">
                                    <a class="edit" href="/cmss/edit-template?id=<?= $template['template_id']; ?>">
                                        Edit
                                    </a>
                                    <button class="delete" href="/cmss/delete-template?id=<?= $template['template_id']; ?>">
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