<? cmss_header(); ?>

<? use CMSS\Settings; ?>

<main class="settings">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="config card">
                <div class="title flex-row">
                    <h3>Site Settings</h3>
                    <div class="end flex-row">
                        <button class="button save-settings">
                            Save
                        </button>
                    </div>
                </div>
                <div class="fields flex-column">
                    <div class="inputs grid">
                        <div class="site-title flex-column">
                            <label for="title">Site Title</label>
                            <input name="title" class="userdata"
                                value="<?= Settings::getInstance()->get_site_title(); ?>">
                        </div>
                    </div>
                    <div class="field flex-column" data-fieldkey="favicon">
                        <div class="name">
                            Site Logo:
                        </div>
                        <div class="image-field flex-column" data-selected-media="-1" data-fieldkey="favicon">
                            <? if (Settings::getInstance()->get_favicon()) {
                                $media = cmss_media(Settings::getInstance()->get_favicon()); ?>
                                <? if ($media) { ?>
                                    <div class="image-item">
                                        <img src="<?= $media['url']; ?>" class="main-image">
                                    </div>
                                <? } ?>
                            <? } ?>
                            <button class="select-media button">Select Media</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>