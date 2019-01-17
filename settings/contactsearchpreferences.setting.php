<?php
use CRM_Contactsearchpreferences_ExtensionUtil as E;

return array(
  'contactsearchpreferences_remove_automatic_wildcard' => array(
    'group_name' => E::ts('Contact Search Preferences Settings'),
    'group' => 'contactsearchpreferences',
    'name' => 'contactsearchpreferences_remove_automatic_wildcard',
    'type' => 'Text',
    'add' => '4.7',
    'default' => '',
    'title' => E::ts('Remove Automatic Wildcard'),
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Select all the forms on which automatic wildcard should be disabled.'),
    'help_text' => E::ts('Select all the forms on which automatic wildcard should be disabled.'),
    'quick_form_type' => 'Select',
    'html_type' => 'Select',
    'html_attributes' => array(
      'class'       => 'crm-select2',
      'multiple'    => TRUE,
      'placeholder' => 'Select Forms',
    ),
    'pseudoconstant' => array(
      'callback' => 'CRM_Contactsearchpreferences_Form_Settings::formsList',
    ),
  ),
  'contactsearchpreferences_dont_include_email' => array(
    'group_name' => E::ts('Contact Search Preferences Settings'),
    'group' => 'contactsearchpreferences',
    'name' => 'contactsearchpreferences_dont_include_email',
    'type' => 'Text',
    'add' => '4.7',
    'default' => '',
    'title' => E::ts('Don\'t Include Email'),
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => E::ts('Select all the forms on which email address should not be displayed or used for contact search.'),
    'help_text' => E::ts('Select all the forms on which email address should not be displayed or used for contact search.'),
    'quick_form_type' => 'Select',
    'html_type' => 'Select',
    'html_attributes' => array(
      'class'    => 'crm-select2',
      'multiple' => TRUE,
      'placeholder' => 'Select Forms',
    ),
    'pseudoconstant' => array(
      'callback' => 'CRM_Contactsearchpreferences_Form_Settings::formsList',
    ),
  ),
  'contactsearchpreferences_opened_form' => array(
    'group_name' => E::ts('Contact Search Preferences Settings'),
    'group' => 'contactsearchpreferences',
    'name' => 'contactsearchpreferences_opened_form',
    'type' => 'Text',
    'add' => '4.7',
    'default' => '',
    'title' => E::ts('Opened Form'),
    'is_domain' => 1,
    'is_contact' => 0,
  ),
);
