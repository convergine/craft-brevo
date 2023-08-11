<?php
namespace convergine\brevo\transport;

use Craft;
use craft\behaviors\EnvAttributeParserBehavior;
use craft\helpers\App;
use craft\mail\transportadapters\BaseTransportAdapter;
use Symfony\Component\Mailer\Bridge\Sendinblue\Transport\SendinblueApiTransport;
use Symfony\Component\Mailer\Transport\AbstractTransport;

class BrevoAdapter extends BaseTransportAdapter {
    public static function displayName(): string {
        return 'Brevo';
    }

    public ?string $api_key = null;

    public function attributeLabels() {
        return [
            'api_key' => Craft::t('convergine-brevo', 'API Key')
        ];
    }

    public function behaviors(): array {
        $behaviors = parent::behaviors();
        $behaviors['parser'] = [
            'class' => EnvAttributeParserBehavior::class,
            'attributes' => [
                'api_key'
            ],
        ];
        return $behaviors;
    }

    protected function defineRules(): array {
        return [
            [['api_key'], 'required']
        ];
    }

    public function getSettingsHtml(): ?string {
        return Craft::$app->getView()->renderTemplate('convergine-brevo/settings', [
            'adapter' => $this
        ]);
    }

    public function defineTransport(): array|SendinblueApiTransport {
        $apiKey = App::parseEnv($this->api_key);
        return new SendinblueApiTransport($apiKey);
    }
}
