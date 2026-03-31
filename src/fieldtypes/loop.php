<div class="loop-field flex-column" data-item-count="1">
    <?php
    $page_rows = $current_field['value'] ?? [];
    $template_subfields = $current_template_field['subfields'] ?? [];

    $item_count = count($page_rows) ?: 1;
    ?>

    <div class="loop-items flex-column">
        <?php for ($i = 0; $i < $item_count; $i++) { ?>
            <?php $row_subfields = $page_rows[$i] ?? []; ?>

            <div class="loop-item flex-column">
                <?php foreach ($template_subfields as $template_subfield) {

                    $found = false;
                    $sub_field = $template_subfield;
                    $sub_field['value'] = null;

                    foreach ($row_subfields as $page_subfield) {
                        if (($template_subfield['fieldkey'] ?? null) == ($page_subfield['fieldkey'] ?? null)) {
                            $sub_field = $page_subfield;
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        $sub_field = $template_subfield;
                        $sub_field['value'] = null;
                    }

                    $current_field = $sub_field;
                    $current_template_field = $template_subfield;
                    ?>

                    <div class="field subfield flex-column" data-fieldtype="<?= $sub_field['fieldtype']; ?>"
                        data-fieldname="<?= $sub_field['fieldname']; ?>" data-fieldkey="<?= $sub_field['fieldkey']; ?>">
                        <div class="name">
                            <?= $sub_field['fieldname']; ?>
                        </div>
                        <? $field =  $sub_field; ?>
                        <?php include __fieldtype($sub_field['fieldtype']); ?>
                    </div>

                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <button type="button" class="button add-item">
        Add Item
    </button>
</div>