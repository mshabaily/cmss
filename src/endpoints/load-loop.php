<div class="loop flex-column">
    <p>Loop Fields:</p>
    <div class="sub-fields has-move flex-column">
        <? $subfields = $field['subfields'];
        foreach ($subfields as $field) {
            include cmss_endpoint('load-field.php');
        } ?>
    </div>
    <button class="button add-sub-field">Add Sub-Field</button>
</div>