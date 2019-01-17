<?php

class CRM_Contactsearchpreferences_APIWrapper implements API_Wrapper {
  /**
   * Alter the parameters of the api request
   */
  public function fromApiInput($apiRequest) {
    $formName = Civi::settings()->get('contactsearchpreferences_opened_form');
    $wildcardForms = Civi::settings()->get('contactsearchpreferences_remove_automatic_wildcard');
    $emailForms = Civi::settings()->get('contactsearchpreferences_dont_include_email');

    if (in_array($formName, $wildcardForms)) {
      $apiRequest['params']['add_wildcard'] = 0;
    }

    if (in_array($formName, $emailForms)) {
      $config = CRM_Core_Config::singleton();
      $config->includeEmailInName = FALSE;
    }

    $apiRequest['params']['description_field'] = array();
    return $apiRequest;
  }

  /**
   * Alter the result before returning it to the caller.
   */
  public function toApiOutput($apiRequest, $result) {

    $formName = Civi::settings()->get('contactsearchpreferences_opened_form');
    $emailForms = Civi::settings()->get('contactsearchpreferences_dont_include_email');

    if (in_array($formName, $emailForms)) {
      $config = CRM_Core_Config::singleton();
      $settingsValue = Civi::settings()->get('includeEmailInName');
      $config->includeEmailInName = $settingsValue;
    }

    return $result;
  }

}
