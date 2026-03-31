<div class="field flex-column" data-fieldtype="<?= $sub_field['fieldtype']; ?>"
    data-fieldname="<?= $sub_field['fieldname']; ?>" data-fieldkey="<?= $sub_field['fieldkey']; ?>">

    <div class="name">
        <?= $sub_field['fieldname']; ?> (
        <?= $i + 1; ?>):
    </div>

    <? include __fieldtype($sub_field['fieldtype']); ?>

</div>