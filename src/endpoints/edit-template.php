<? cmss_header(); ?>

<? $template_id = $_GET['id'];

$template = cmss_template($template_id); ?>

<? $fields = json_decode($template['fields'], true); ?>

<main class="template record edit">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <? if (!$template) { ?>
                Invalid template
            </div>
        </content>
    </main>
    <? exit;
            } ?>
<div class="records card">
    <div class="title flex-row">
        <div class="start flex-row">
            <h3>New Template</h3>
            <input class="title-input" value="<?= $template['title']; ?>">
        </div>
        <div class="end flex-row">
            <button class="button add-field">
                Add Field
            </button>
            <button class="button save-template">
                Update
            </button>
        </div>
    </div>
    <div class="fields has-move flex-column">
        <p class="memo">Start adding fields to customise your template</p>
        <? foreach ($fields as $field) {
            include cmss_endpoint('load-field.php');
        } ?>
    </div>
</div>
</div>
</content>
</main>

<? cmss_footer(); ?>