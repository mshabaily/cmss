<? if (isset($field['value'])) {
    $value = $field['value'];
} ?>

<div class="textbox-field flex-column">
    <textarea name="<?= $field['fieldkey']; ?>"><?= $value; ?></textarea>
</div>