<div class="sidebar flex-column">
    <div class="wrapper flex-column">
        <div class="account flex-column">
            <div class="name">
                <? $user = cmss_current_user(); ?>
                <?= $user['firstname']; ?> <?= $user['surname']; ?>
            </div>
            <div class="role">
                <?= cmss_user_role(); ?>
            </div>
            <a href="/cmss/account?id=<?= (int) $_SESSION['user_id']; ?>" class="edit">
                Edit Account
            </a>
            <a href="/cmss/sign-out" class="sign-out">
                Sign Out
            </a>
        </div>
        <ul class="menu flex-column">
            <?
            $items = [
                [
                    'title' => 'Dashboard',
                    'url' => '/cmss'
                ],
                [
                    'title' => 'Pages',
                    'url' => '/cmss/pages'
                ],
                [
                    'title' => 'Media',
                    'url' => '/cmss/media'
                ],
                [
                    'title' => 'Accounts',
                    'url' => '/cmss/accounts'
                ],
                [
                    'title' => 'Settings',
                    'url' => '/cmss/settings'
                ]
            ];

            if (cmss_user_role() == 'developer') {
                $items[] = [
                    'title' => 'Templates',
                    'url' => '/cmss/templates'
                ];
            }

            ?>

            <? foreach ($items as $item) { ?>
                <li class="item flex-column">
                    <a href="<?= $item['url'] ?>">
                        <?= $item['title'] ?>
                    </a>
                </li>
            <? } ?>
        </ul>

        <div class="links flex-column">
            <a href="/support" class="support">
                Support
            </a>
            <a href="/documentation" class="documentation">
                Documentation
            </a>
        </div>

    </div>
</div>