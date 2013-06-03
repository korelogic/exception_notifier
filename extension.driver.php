<?php

	/**
	 * Extension Driver
	 */
	 
	Class extension_exception_notifier extends Extension{

		/**
		 * Extension information
		 */
		public function about(){
			return array(
				'name'         => 'Exception Notifier',
				'version'      => '1.0',
				'release-date' => '2013-05-29',
				'author' => array(
					'name' => 'Michael Hay',
					'website' => 'https://korelogic.co.uk',
				)
			);
		}
		
		public function getSubscribedDelegates() {
			return array(
				array(
					'page'		=> '/system/preferences/',
					'delegate'	=> 'AddCustomPreferenceFieldsets',
					'callback'	=> '__appendPreferences'
				),
				array(
					'page'		=> '/system/preferences/',
					'delegate'	=> 'Save',
					'callback'	=> '__savePreferences'
				)
			);
		}

		public function uninstall(){
			/**
			 * preferences are defined in the email gateway class,
			 * but removing upon uninstallation must be handled here;
			 */
			Symphony::Configuration()->remove('exception_notifier');
			
			Administration::instance()->saveConfig();
			
			return true;
		}
		
		public function install(){
			/**
			 * preferences are defined in the email gateway class,
			 * but removing upon uninstallation must be handled here;
			 */
			Symphony::Configuration()->set('environment', "Production", 'exception_notifier');
			
			Administration::instance()->saveConfig();
			
			return true;
			
		}
		
		public function __appendPreferences($context) {
			$fieldset = new XMLElement('fieldset');
			$fieldset->setAttribute('class', 'settings');
			$fieldset->appendChild(new XMLElement('legend', __('Exception notifier')));

			$div = new XMLElement('div', NULL, array('class' => 'group'));

			$label = Widget::Label(__('API Key'));
			$label->appendChild(Widget::Input('settings[exception_notifier][key]', General::Sanitize(Symphony::Configuration()->get('key', 'exception_notifier')), 'password' ));
			$div->appendChild($label);
			
			$label = Widget::Label('Host');
			$label->appendChild(Widget::Input('settings[exception_notifier][host]', General::Sanitize(Symphony::Configuration()->get('host', 'exception_notifier')) ));
			$div->appendChild($label);
			
			$fieldset->appendChild($div);
			
			$div = new XMLElement('div', NULL, array('class' => 'group'));
			
			$environments = array("Development", "Integration", "Staging", "Production");

			$options = array(
				array(null, false, null)
			);

			foreach ($environments as $value) {
				$options[] = array($value, ($value == General::Sanitize(Symphony::Configuration()->get('environment', 'exception_notifier'))), $value);
			}

			$label = Widget::Label('Environment');
			$label->appendChild(Widget::Select('settings[exception_notifier][environment]', $options));
			
			$div->appendChild($label);
			
			$label = Widget::Label('Server Name');
			$label->appendChild(Widget::Input('settings[exception_notifier][server]', General::Sanitize(Symphony::Configuration()->get('server', 'exception_notifier')) ));
			$div->appendChild($label);
			
			$fieldset->appendChild($div);

			$context['wrapper']->appendChild($fieldset);
			
		}

		public function __savePreferences(array &$context){
			$settings = $context['settings'];

			Symphony::Configuration()->set('key', $settings['exception_notifier']['key'], 'exception_notifier');
			Symphony::Configuration()->set('host', $settings['exception_notifier']['host'], 'exception_notifier');
			Symphony::Configuration()->set('environment', $settings['exception_notifier']['environment'], 'exception_notifier');
			Symphony::Configuration()->set('server', $settings['exception_notifier']['server'], 'exception_notifier');
			
			Administration::instance()->saveConfig();
		}
		
	}
