<? cmss_header(); ?>

<main class="page new">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="templates card">
                <div class="title flex-row">
                    <div class="start flex-row">
                        <h3>New Page</h3>
                        <input class="title-input" value="Untitled">
                    </div>
                    <div class="end flex-row">
                        <button class="button save-page">
                            Save
                        </button>
                    </div>
                </div>
                <div class="url flex-column">
                    <p>Page URL:</p>
                    <div class="input flex-row">
                        <div class="prefix">
                            <?= site_url(); ?>/
                        </div>
                        <input name="url">
                    </div>
                </div>
                <div class="fields flex-column">
                    <div class="options flex-column">
                        <p>Select a template to use for your page</p>
                        <select class="template-select">
                            <option selected disabled>
                                -- Select --
                            </option>
                            <? foreach (cmss_templates() as $template) { ?>
                                <option value="<?= $template['template_id']; ?>">
                                    <?= $template['title']; ?>
                                </option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="items flex-column"></div>
                </div>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>