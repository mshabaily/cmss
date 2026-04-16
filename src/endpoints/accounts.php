<? cmss_header(); ?>

<? use Symfony\Component\Security\Csrf\CsrfTokenManager; ?>

<main class="accounts">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="records accounts card">
                <div class="title flex-row">
                    <h3>All Accounts</h3>
                    <a href="/cmss/new-account" class="button">
                        New Account
                    </a>
                </div>
                <? $items = cmss_users();

                include cmss_partial('pagination-before.php');

                foreach ($current_page_items as $account) { ?>
                    <div class="account record flex-row">
                        <div class="record-title flex-row">
                            Email:
                            <?= $account['email']; ?>
                        </div>
                        <div class="end flex-row">
                            <? if (cmss_current_user()['role'] == 'developer' || $account['user_id'] == cmss_current_user()['user_id']) { ?>
                                <a class="edit" href="/cmss/account?id=<?= $account['user_id']; ?>">
                                    Edit
                                </a>

                                <? $csrfTokenManager = new CsrfTokenManager();
                                $token = $csrfTokenManager->getToken('delete-account')->getValue(); ?>

                                <? if (!($account['user_id'] == cmss_current_user()['user_id'])) { ?>
                                    <button class="delete-account" href="/cmss/delete-account?id=<?= $account['user_id']; ?>" data-csrf="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
                                        Delete
                                    </button>
                                <? } ?>

                            <? } ?>
                        </div>
                    </div>
                <? } ?>

                <? include cmss_partial('pagination-after.php'); ?>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>