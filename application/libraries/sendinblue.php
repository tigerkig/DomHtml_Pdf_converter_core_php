<?php
// @codeCoverageIgnoreStart
defined('BASEPATH') || exit('No direct script access allowed');
// @codeCoverageIgnoreEnd

/**
 * Codeigniter PHP framework library class for dealing with SendInBlue RESTFul API.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Email
 * @author      Joël Gaujard <j.gaujard@gmail.com>
 * @link        https://github.com/defro/codeigniter-sendinblue
 */
class SendInBlue
{
    /**
     * Initialize Codeigniter PHP framework and get configuration
     *
     * @codeCoverageIgnore
     * @param array $config Override default configuration
     */
    public function __construct(array $config = array())
    {
        log_message('info', 'SendInBlue Library Class Initialized');

        // Merge $config and config/sendinblue.php $config
        $config = array_merge(
            array(
                'sendinblue_api_key' => config_item('sendinblue_api_key')
            ),
            $config
        );

        // Update config values
        array_walk($config, function($item, $key, $CI) {
            $CI->config->set_item($key, $item);
        }, get_instance());

        // Configure API key authorization: api-key
        SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $config['sendinblue_api_key']);
    }

    private function _output($result)
    {
        $return = array();
        foreach ($result->getters() as $key => $getter) {
            $return[$key] = $result->$getter();
        }

        return $return;
    }

    public function getAccount()
    {
        $apiInstance = new SendinBlue\Client\Api\AccountApi();

        try {
            return $this->_output($apiInstance->getAccount());
        } catch (Exception $e) {
            throw new SendInBlue_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getContacts($limit = 50, $offset = 0)
    {
        $apiInstance = new SendinBlue\Client\Api\ContactsApi();

        try {
            return $this->_output($apiInstance->getContacts($limit, $offset));
        } catch (Exception $e) {
            throw new SendInBlue_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param \SendinBlue\Client\Model\CreateContact $contact
     * @return int
     * @throws SendInBlue_Exception
     */
    public function createContact(SendinBlue\Client\Model\CreateContact $contact)
    {
        $apiInstance = new SendinBlue\Client\Api\ContactsApi();

        try {
            $creation = $apiInstance->createContact($contact);
            return $creation->getId();
        } catch (Exception $e) {
            throw new SendInBlue_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getContactInfo($email)
    {
        $apiInstance = new SendinBlue\Client\Api\ContactsApi();

        try {
            return $this->_output($apiInstance->getContactInfo($email));
        } catch (Exception $e) {
            throw new SendInBlue_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getAttributes()
    {
        $apiInstance = new SendinBlue\Client\Api\AttributesApi();

        try {
            return $this->_output($apiInstance->getAttributes());
        } catch (Exception $e) {
            throw new SendInBlue_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getLists($limit = 10, $offset = 0)
    {
        $apiInstance = new SendinBlue\Client\Api\ListsApi();

        try {
            return $this->_output($apiInstance->getLists($limit, $offset));
        } catch (Exception $e) {
            throw new SendInBlue_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getFolders($limit = 10, $offset = 0)
    {
        $apiInstance = new SendinBlue\Client\Api\FoldersApi();

        try {
            return $this->_output($apiInstance->getFolders($limit, $offset));
        } catch (Exception $e) {
            throw new SendInBlue_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getSenders($ip = NULL, $domain = NULL)
    {
        $apiInstance = new SendinBlue\Client\Api\SendersApi();

        try {
            return $this->_output($apiInstance->getSenders($ip, $domain));
        } catch (Exception $e) {
            throw new SendInBlue_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getEmailCampaigns($type = NULL, $status = NULL, $limit = 500, $offset = 0)
    {
        $apiInstance = new SendinBlue\Client\Api\EmailCampaignsApi();

        try {
            return $this->_output($apiInstance->getEmailCampaigns($type, $status, $limit, $offset));
        } catch (Exception $e) {
            throw new SendInBlue_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
}

class SendInBlue_Exception extends Exception
{
    public function __construct($message, $code, Exception $previous)
    {
        parent::__construct($message, $code, $previous);
    }
}

/* End of file SendInBlue.php */
/* Location: ./application/libraries/sendinblue.php */