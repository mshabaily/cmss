<? cmss_header(); ?>

<? use CMSS\Settings; ?>

<? $page_id = (int) $_GET['id'];

$page = cmss_page($page_id);

$page_template = cmss_template($page['template_id']); ?>

<main class="page new">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="templates card">
                <div class="title flex-row">
                    <div class="start flex-row">
                        <h3>New Page</h3>
                        <input class="title-input" value="<?= $page['title']; ?>">
                    </div>
                    <? if (Settings::getInstance()->is_front($page['page_id'])) {
                        $url = '';
                    } else {
                        $url = $page['url'];
                    } ?>
                    <div class="end flex-row">
                        <a href="<?= site_url() . '/' . $url; ?>" class="button view-page" target="_blank">
                            View Page
                        </a>
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
                        <input name="url" value="<?= $page['url']; ?>">
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
                                <option value="<?= $template['template_id']; ?>"
                                    <?= $template['template_id'] == $page['template_id'] ? 'selected' : '' ?>>
                                    <?= $template['title']; ?>
                                </option>
                            <? } ?>
                        </select>
                    </div>
                    <p>Fields:</p>
                    <div class="items flex-column">
                        <?php
                        $page_fields = json_decode($page['fields'], true) ?? [];
                        $template_fields = json_decode($page_template['fields'], true) ?? [];

                        foreach ($template_fields as $template_field) {
                            $field = $template_field;
                            $field['value'] = null;

                            foreach ($page_fields as $page_field) {
                                if ($template_field['fieldkey'] == $page_field['fieldkey']) {
                                    $field['value'] = $page_field['value'] ?? null;
                                    break;
                                }
                            }

                            $current_field = $field;
                            $current_template_field = $template_field;
                            ?>
                            <div class="field flex-column" data-fieldtype="<?= $current_field['fieldtype']; ?>"
                                data-fieldname="<?= $current_field['fieldname']; ?>"
                                data-fieldkey="<?= $current_field['fieldkey']; ?>">
                                <div class="name">
                                    <?= $current_field['fieldname']; ?>:
                                </div>
                                <?php include __fieldtype($template_field['fieldtype']); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>