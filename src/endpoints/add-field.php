<div class="field flex-column">
    <div class="options flex-row">
        <button class="move">Move</button>
        <button class="delete">Delete</button>
    </div>
    <div class="inputs flex-column">
        <div class="fieldtype flex-column">
            <label for="fieldtype">Field Type:</label>
            <select name="fieldtype">
                <? foreach (__get_field_types() as $fieldtype) { ?>
                    <option value="<?= $fieldtype['file']; ?>">
                        <?= $fieldtype['label']; ?>
                    </option>
                <? } ?>
            </select>
        </div>

        <div class="fieldname flex-column">
            <label for="fieldname">Field Name:</label>
            <input name="fieldname">
        </div>

        <div class="fieldkey flex-column">
            <label for="fieldkey">Field Key:</label>
            <input name="fieldkey">
        </div>
    </div>
</div>