<? cmss_header(); ?>

<? $account = cmss_user((int) $_GET['id']); ?>

<main class="account edit">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="account card">
                <div class="title flex-row">
                    <div class="start flex-row">
                        <h3>Details</h3>
                    </div>
                    <div class="end flex-row">
                        <button class="button save-account">
                            Save
                        </button>
                    </div>
                </div>

                <div class="fields flex-column">
                    <div class="inputs grid">
                        <div class="first-name flex-column">
                            <label for="firstname">First Name</label>
                            <input id="firstname" name="firstname" class="userdata"
                                value="<?= htmlspecialchars($account['firstname'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="surname flex-column">
                            <label for="surname">Surname</label>
                            <input id="surname" name="surname" class="userdata"
                                value="<?= htmlspecialchars($account['surname'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="email flex-column">
                            <label for="email">Email Address</label>
                            <input id="email" name="email" class="userdata"
                                value="<?= htmlspecialchars($account['email'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="role flex-column">
                            <label for="role">Role</label>
                            <select name="role" class="userdata">
                                <option value="developer" <?= $account['role'] === 'developer' ? 'selected' : '' ?>>Developer</option>
                                <option value="moderator" <?= $account['role'] === 'moderator' ? 'selected' : '' ?>>Moderator</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions card">
                <div class="title flex-row">
                    <div class="start flex-row">
                        <h3>Actions</h3>
                    </div>
                </div>
                <div class="options">
                    <button class="button reset-password">Reset Password</button>
                </div>
            </div>
        </div>
    </content>
    </div>
</main>

<? cmss_footer(); ?>