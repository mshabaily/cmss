<? cmss_header(); ?>

<main class="dashboard">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper grid">
            <div class="pages card">
                <div class="title flex-row">
                    <h3>Latest Pages</h3>
                </div>
                <div class="records content flex-column">
                    <? $pages = cmss_pages(5);

                    foreach ($pages as $page) { ?>
                        <div class="record flex-row">
                            <div class="record-title flex-row">
                                Title:
                                <?= $page['title']; ?>
                            </div>
                            <div class="end flex-row">
                                <a class="edit" href="<?= site_url() . '/' . $page['url']; ?>" target="_blank">
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

                    <? if (!$pages) { ?>
                        <p class="no-content">No pages found, create a new page to get started!</p>
                    <? } ?>
                </div>
            </div>
            <div class="updates card">
                <div class="title flex-row">
                    <h3>User Accounts</h3>
                </div>
                <div class="records content flex-column">
                    <? $pages = cmss_users(5);
                    foreach ($pages as $page) { ?>
                        <div class="record flex-row">
                            <div class="record-title flex-row">
                                Name:
                                <?= $page['firstname'] . ' ' . $page['surname']; ?>
                            </div>
                            <div class="end flex-row">
                                <? if (cmss_current_user()['role'] == 'developer' || $page['user_id'] == cmss_current_user()['user_id']) { ?>
                                    <a class="edit" href="/cmss/account?id=<?= $page['user_id']; ?>">
                                        Edit
                                    </a>
                                
                                    <? if (!$page['user_id'] == cmss_current_user()['user_id']) { ?>
                                        <button class="delete-account" href="/cmss/delete-account?id=<?= $page['user_id']; ?>">
                                            Delete
                                        </button>
                                    <? } ?>
                                
                                <? } ?>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="actions card">
                <div class="title flex-row">
                    <h3>Latest Templates</h3>
                </div>
                <div class="records content flex-column">
                    <? $pages = cmss_templates(5);
                    foreach ($pages as $page) { ?>
                        <div class="record flex-row">
                            <div class="record-title flex-row">
                                Title:
                                <?= $page['title']; ?>
                            </div>
                            <div class="end flex-row">
                                <a class="edit" href="/cmss/edit-page?id=<?= $page['page_id']; ?>">
                                    Edit
                                </a>
                                <button class="delete-page" href="/cmss/delete-page?id=<?= $page['page_id']; ?>">
                                    Delete
                                </button>
                            </div>
                        </div>
                    <? } ?>

                    <? if (!$pages) { ?>
                        <p class="no-content">No templates found, create a new page to get started!</p>
                    <? } ?>
                </div>
            </div>
            <div class="actions card">
                <div class="title flex-row">
                    <h3>Quick Actions</h3>
                </div>
                <div class="options">
                    <a class="button" href="/cmss/new-page">New Page</a>
                    <a class="button" href="/cmss/new-template">New Template</a>
                    <a class="button" href="/cmss/new-account">New Account</a>
                </div>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>