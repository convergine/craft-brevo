<?php
namespace convergine\brevo;

use convergine\brevo\transport\BrevoAdapter;
use Craft;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\helpers\MailerHelper;
use yii\base\Event;

class BrevoPlugin extends Plugin {
	public static $plugin;

	public function init() {

        /* plugin initialization */
		$this->hasCpSection = false;
		$this->hasCpSettings = false;
		parent::init();

        /* register default translations */
        $this->defaultTranslations();
        self::$plugin = $this;

        Event::on(
            MailerHelper::class,
            MailerHelper::EVENT_REGISTER_MAILER_TRANSPORT_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = BrevoAdapter::class;
            }
        );
	}

    private function defaultTranslations() : void {
        /* register default translations */
        $translations = [
            'API Key' => 'API Key',
            'The Brevo API key.' => 'The Brevo API key.'
        ];

        Craft::$app->view->registerTranslations('convergine-brevo', $translations);
    }
}