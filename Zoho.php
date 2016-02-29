<?php

namespace WondersLabCorporation;

use yii\base\InvalidConfigException;
use Zoho\CRM\Common\ZohoRecord;
use Zoho\CRM\Entities\Account;
use Zoho\CRM\Exception\UnknownEntityException;
use Zoho\CRM\ZohoClient;

/**
 * Class Zoho - Yii2 component for ZohoCrm integration
 *
 * @method createAccount
 * @method createLead
 * @method createPotential
 * @method createQuote
 * @method createVendor
 *
 * @package WondersLabCorporation
 */
class Zoho extends \yii\base\Component
{
    public $authToken;
    public $baseUri = 'https://crm.zoho.com/crm/private';

    protected $client;

    public function __construct($config = [])
    {
        if (!isset($config['authToken'])) {
            throw new InvalidConfigException('Auth token param is required');
        }
        parent::__construct($config);
    }

    public function __call($name, $params)
    {
        if (strpos($name, 'create') === 0) {
            // Cut 'create' from $name and try to create such and entity. e.g. createAccount => new Account
            return ZohoRecord::createEntity(substr($name, 6), ['zohoClient' => $this->getClient()]);
        }
        return parent::__call($name, $params);
    }

    public function getClient()
    {
        if (!$this->client) {
            $this->client = new ZohoClient($this->authToken, $this->baseUri);
        }
        return $this->client;
    }
}