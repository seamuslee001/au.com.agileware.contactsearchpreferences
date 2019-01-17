<?php

use CRM_Contactsearchpreferences_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Contactsearchpreferences_Form_Settings extends CRM_Core_Form {

  private $_settingFilter = array('group' => 'contactsearchpreferences');
  private $_settings = array();

  /**
   * Build the settings form
   */
  public function buildQuickForm() {
    $this->addFormElements();
    parent::buildQuickForm();
  }

  /**
   * Add form elements
   */
  public function addFormElements() {
    $settings = $this->getFormSettings();

    foreach ($settings as $name => $setting) {
      if (isset($setting['quick_form_type'])) {
        $add = 'add' . $setting['quick_form_type'];
        if ($add == 'addElement') {
          $this->$add($setting['html_type'], $name, $setting['title'], CRM_Utils_Array::value('html_attributes', $setting, array(), TRUE), TRUE);
        }
        elseif ($setting['html_type'] == 'Select') {
          $optionValues = array();
          if (!empty($setting['pseudoconstant']) && !empty($setting['pseudoconstant']['optionGroupName'])) {
            $optionValues = CRM_Core_OptionGroup::values($setting['pseudoconstant']['optionGroupName'], FALSE, FALSE, FALSE, NULL, 'name');
          }
          elseif (!empty($setting['pseudoconstant']) && !empty($setting['pseudoconstant']['callback'])) {
            $callBack = Civi\Core\Resolver::singleton()->get($setting['pseudoconstant']['callback']);
            $optionValues = call_user_func_array($callBack, $optionValues);
          }
          $this->add('select', $setting['name'], $setting['title'], $optionValues, FALSE, $setting['html_attributes']);
        }
        else {
          $this->$add($name, $setting['title'], array());
        }
      }
    }

    $this->assign('elementNames', $this->getRenderableElementNames());

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    $elementNames = array();
    foreach ($this->_elements as $element) {
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = array(
          "name"        => $element->getName(),
          "description" => (isset($this->_settings[$element->getName()]["description"])) ? $this->_settings[$element->getName()]["description"] : '',
        );
      }
    }
    return $elementNames;
  }

  /**
   * Get the settings we are going to allow to be set on this form.
   *
   * @return array
   */
  public function getFormSettings() {
    if (empty($this->_settings)) {
      $settings = civicrm_api3('setting', 'getfields', array('filters' => $this->_settingFilter));
      $settings = $settings['values'];
      $this->_settings = $settings;
    }
    return $this->_settings;
  }

  /**
   * Handles the form submission.
   */
  public function postProcess() {
    $this->_submittedValues = $this->exportValues();

    $this->saveSettings();
    CRM_Utils_System::redirect($_SERVER['REQUEST_URI']);

    parent::postProcess();
  }

  /**
   * Save the settings in database.
   *
   * @return array
   */
  public function saveSettings() {
    $settings = $this->getFormSettings();
    $values = array_intersect_key($this->_submittedValues, $settings);
    civicrm_api3('setting', 'create', $values);
    return $settings;
  }

  /**
   * Set defaults for form.
   *
   * @see CRM_Core_Form::setDefaultValues()
   */
  public function setDefaultValues() {
    $existing = civicrm_api3('setting', 'get', array('return' => array_keys($this->getFormSettings())));
    $defaults = array();
    $domainID = CRM_Core_Config::domainID();
    foreach ($existing['values'][$domainID] as $name => $value) {
      $defaults[$name] = $value;
    }
    return $defaults;
  }

  /**
   * Return the list of form on which setting can be overridden.
   *
   * @return array
   */
  public static function formsList() {
    return array(
      'CRM_Contact_Form_Relationship' => 'CRM_Contact_Form_Relationship',
      'CRM_Activity_Form_Activity'    => 'CRM_Activity_Form_Activity',
      'CRM_Contatct_Search_QuickForm' => 'CRM_Contatct_Search_QuickForm',
      'CRM_Case_Form_ActivityToCase'  => 'CRM_Case_Form_ActivityToCase',
      'CRM_Case_Form_AddToCaseAsRole' => 'CRM_Case_Form_AddToCaseAsRole',
      'CRM_Contribute_Form_Contribution' => 'CRM_Contribute_Form_Contribution',
      'CRM_Group_Form_Edit'           => 'CRM_Group_Form_Edit',
      'CRM_Case_Form_EditClient'      => 'CRM_Case_Form_EditClient',
      'CRM_Financial_Form_FinancialAccount' => 'CRM_Financial_Form_FinancialAccount',
      'CRM_Grant_Form_Grant'          => 'CRM_Grant_Form_Grant',
      'CRM_Member_Form_Membership'    => 'CRM_Member_Form_Membership',
      'CRM_Member_Form_MembershipRenewal' => 'CRM_Member_Form_MembershipRenewal',
      'CRM_Member_Form_MembershipType' => 'CRM_Member_Form_MembershipType',
      'CRM_Case_Form_Activity_OpenCase' => 'CRM_Case_Form_Activity_OpenCase',
      'CRM_Event_Form_Participant'    => 'CRM_Event_Form_Participant',
      'CRM_Pledge_Form_Pledge'        => 'CRM_Pledge_Form_Pledge',
      'CRM_Admin_Form_ScheduleReminders' => 'CRM_Admin_Form_ScheduleReminders',
      'CRM_Event_Form_SelfSvcTransfer' => 'CRM_Event_Form_SelfSvcTransfer',
      'CRM_Contribute_Form_SoftCredit' => 'CRM_Contribute_Form_SoftCredit',
    );
  }

}
