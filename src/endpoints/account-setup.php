<? cmss_header(); ?>

<main class="user-form database account setup">
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="templates card">
                <div class="title flex-row">
                    <div class="start flex-row">
                        <h3>Details</h3>
                    </div>
                </div>
                <div class="fields flex-column">
                    <div class="inputs flex-column">
                        <div class="email flex-column">
                            <label for="email">Email Address</label>
                            <input name="email" class="userdata">
                        </div>
                        <div class="firstname flex-column">
                            <label for="firstname">First Name</label>
                            <input name="firstname" class="userdata">
                        </div>
                        <div class="surname flex-column">
                            <label for="surname">Surname</label>
                            <input name="surname" class="userdata">
                        </div>
                        <div class="password flex-column">
                            <label for="password">Password</label>
                            <input name="password" class="userdata">
                        </div>
                        <div class="role flex-column" style="display: none;">
                            <label for="role">Role</label>
                            <select name="role" class="userdata">
                                <option value="developer" selected>Developer</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                    </div>
                    <button class="button submit save-account">
                        Create account
                    </button>
                </div>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>