
<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_61521b9c19782',
    'title' => 'Felder für Benutzer (Kontingente)',
    'fields' => array(
        array(
            'key' => 'field_61521ba6b395d',
            'label' => 'hat Kontingent?',
            'name' => 'hasContigency',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => 'Gibt an, ob der Benutzer ein Kontingent an Inseraten zur verfügung hat',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
        array(
            'key' => 'field_615229aab2cda',
            'label' => 'Kontingent',
            'name' => 'ContigencyNumber',
            'type' => 'number',
            'instructions' => 'tatsächliches Kontingent',
            'required' => 1,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_61521ba6b395d',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'min' => '',
            'max' => '',
            'step' => '',
        ),
        array(
            'key' => 'field_615238248d0c7',
            'label' => 'Kontingent Ablaufdatum',
            'name' => 'contingency_expiration_date',
            'type' => 'date_picker',
            'instructions' => 'Dieses Feld steuert, bis wann ein Benutzer neue Inserate erfassen soll mittels Kontingent. Das Ablaufdatum des Inserates ist aber entscheidend für das Setzen vom Post Status = Pending.
Aktuell wird das Feld nur verwendet für die Versendung von Batch-Mails. Der Administrator soll anschliessend die Kontingente deaktivieren oder erneuern.',
            'required' => 1,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_61521ba6b395d',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'd/m/Y',
            'return_format' => 'd/m/Y',
            'first_day' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'user_role',
                'operator' => '==',
                'value' => 'all',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));

endif;      
?>