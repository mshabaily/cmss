<? $subfield_count = $_GET['subfield_count'] ?? 2; ?>

<? for ($i = 0; $i < $subfield_count; $i++) { ?>
    <div class="field flex-column" data-fieldtype="<?= $sub_field['fieldtype']; ?> "
        data-fieldname="<?= $sub_field['fieldname']; ?>" data-fieldkey="<?= $sub_field['fieldkey']; ?>"
        data-subfield-count="<?= $subfield_count; ?>">
        <div class="name">
            <?= $sub_field['fieldname']; ?> (<?= $i + 1; ?>):
        </div>
        <? include __fieldtype($sub_field['fieldtype']); ?>
    </div>
<? } ?>