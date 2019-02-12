<?php

require_once 'contactsearchpreferences.civix.php';
use CRM_Contactsearchpreferences_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function contactsearchpreferences_civicrm_config(&$config) {
  _contactsearchpreferences_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function contactsearchpreferences_civicrm_xmlMenu(&$files) {
  _contactsearchpreferences_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function contactsearchpreferences_civicrm_install() {
  _contactsearchpreferences_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function contactsearchpreferences_civicrm_postInstall() {
  _contactsearchpreferences_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function contactsearchpreferences_civicrm_uninstall() {
  _contactsearchpreferences_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function contactsearchpreferences_civicrm_enable() {
  _contactsearchpreferences_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function contactsearchpreferences_civicrm_disable() {
  _contactsearchpreferences_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function contactsearchpreferences_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _contactsearchpreferences_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function contactsearchpreferences_civicrm_managed(&$entities) {
  _contactsearchpreferences_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function contactsearchpreferences_civicrm_caseTypes(&$caseTypes) {
  _contactsearchpreferences_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function contactsearchpreferences_civicrm_angularModules(&$angularModules) {
  _contactsearchpreferences_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function contactsearchpreferences_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _contactsearchpreferences_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function contactsearchpreferences_civicrm_entityTypes(&$entityTypes) {
  _contactsearchpreferences_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
 */
function contactsearchpreferences_civicrm_navigationMenu(&$menu) {
  _contactsearchpreferences_civix_insert_navigation_menu($menu, 'Administer', array(
    'label' => E::ts('Advanced Search Preferences'),
    'name' => 'AdvancedSearchPreferences',
    'url' => 'civicrm/searchpreferences/settings',
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _contactsearchpreferences_civix_navigationMenu($menu);
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
 */
function contactsearchpreferences_civicrm_buildForm($formName, &$form) {
  $formsList = CRM_Contactsearchpreferences_Form_Settings::formsList();

  if (in_array($formName, $formsList)) {
    Civi::settings()->set('contactsearchpreferences_opened_form', $formName);
  }
}

/**
 * Implements hook_civicrm_apiWrappers().
 */
function contactsearchpreferences_civicrm_apiWrappers(&$wrappers, $apiRequest) {
  if ($apiRequest['entity'] == 'Contact' && $apiRequest['action'] == 'getlist') {
    $wrappers[] = new CRM_Contactsearchpreferences_APIWrapper();
  }

  if ($apiRequest['entity'] == 'Contact' && $apiRequest['action'] == 'getquick') {
    $wrappers[] = new CRM_Contactsearchpreferences_APIWrapperGetQuick();
  }
}
