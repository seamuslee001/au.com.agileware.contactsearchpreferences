<?php

class CRM_Contactsearchpreferences_APIWrapperGetQuick implements API_Wrapper {
  /**
   * Alter the parameters of the api request
   */
  public function fromApiInput($apiRequest) {
    $formName = 'CRM_Contatct_Search_QuickForm';
    $wildcardForms = Civi::settings()->get('contactsearchpreferences_remove_automatic_wildcard');
    $emailForms = Civi::settings()->get('contactsearchpreferences_dont_include_email');

    if (in_array($formName, $wildcardForms)) {
      if (Civi::settings()->get('includeWildCardInName') != 0) {
        Civi::settings()->set('includeWildCardInName', "0");
        $apiRequest['updated_wildcard_setting'] = 1;
      }
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

    $formName = 'CRM_Contatct_Search_QuickForm';
    $wildcardForms = Civi::settings()->get('contactsearchpreferences_remove_automatic_wildcard');
    $emailForms = Civi::settings()->get('contactsearchpreferences_dont_include_email');

    if (in_array($formName, $wildcardForms) && isset($apiRequest['updated_wildcard_setting']) && $apiRequest['updated_wildcard_setting'] == 1) {
      Civi::settings()->set('includeWildCardInName', "1");
    }

    if (in_array($formName, $emailForms)) {
      $config = CRM_Core_Config::singleton();
      $settingsValue = Civi::settings()->get('includeEmailInName');
      $config->includeEmailInName = $settingsValue;
    }

    return $result;
  }

}
