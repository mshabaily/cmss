<? $id = isset($_POST['template_id']) ? $_POST['template_id'] : -1;

$id = (int) $id;

if ($id != -1) {
    $template = cmss_template($id);
}

if ($template) {
    $fields = json_decode($template['fields'], true);
    foreach ($fields as $field) { ?>
        <? $current_field = $field; ?>
        <? $current_template_field = $field; ?>
        <div class="field flex-column" data-fieldtype="<?= $field['fieldtype']; ?>" data-fieldname="<?= $field['fieldname']; ?>"
            data-fieldkey="<?= $field['fieldkey']; ?>">
            <div class="name">
                <?= $field['fieldname']; ?>:
            </div>
            <? include __fieldtype($field['fieldtype']); ?>
        </div>
    <? }
} else {
    echo "template not found";
} ?>