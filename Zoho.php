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

    public $zohoApiParams = [];

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
            return ZohoRecord::createEntity(substr($name, 6), $this->prepareZohoParams($params));
        }
        if (strpos($name, 'load') === 0) {
            // Cut 'load' from $name and try to create such and entity. e.g. loadAccount => Account -> getRecordById
            return ZohoRecord::getEntity(substr($name, 4), $this->prepareZohoParams($params));
        }
        return parent::__call($name, $params);
    }

    protected function prepareZohoParams($params)
    {
        // Using first argument only for now. TODO: Make sure this is the appropriate way
        if (isset($params[0]) && is_array($params[0])) {
            $params = $params[0];
        } else {
            $params = [];
        }
        // Adding API default params if any.
        if (!isset($params['zohoParams'])) {
            $params['zohoParams'] = [];
        }
        $params['zohoParams'] += $this->zohoApiParams;
        // TODO: Consider checking if zohoClient provided first
        $params['zohoClient'] = $this->getClient();
        return $params;
    }

    public function getClient()
    {
        if (!$this->client) {
            $this->client = new ZohoClient($this->authToken, $this->baseUri);
        }
        return $this->client;
    }
}