<? cmss_header(); ?>

<main class="account new">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="templates card">
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
                            <input name="password" class="userdata" type="password">
                        </div>
                        <div class="email flex-column">
                            <label for="email">Email Address</label>
                            <input name="email" class="userdata">
                        </div>
                        <div class="role flex-column">
                            <label for="role">Role</label>
                            <select name="role" class="userdata">
                                <option>
                                    Developer
                                </option>
                                <option selected>
                                    Moderator
                                </option>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>