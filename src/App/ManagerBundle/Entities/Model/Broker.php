<?php

namespace App\ManagerBundle\Entities\Model;

use App\SourceBundle\Base\Model;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * App\ManagerBundle\Entities\Model\Broker
 *
 * @ORM\Table(name="brokers")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\ManagerBundle\Entities\Repository\Broker")
 */
class Broker extends Model
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=80)
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=80)
	 */
	protected $display_name;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=200)
	 */
	protected $reg_url;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=200)
	 */
	protected $login_url;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=80)
	 */
	protected $redirect_param;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=200)
	 */
	protected $thanku_url;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=200)
	 */
	protected $deposit_url;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $regulated;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $captcha;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $limit_ip;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=200)
	 */
	protected $bottom_injects;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=1000)
	 */
	protected $comments;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=80)
	 */
	protected $api_username;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=80)
	 */
	protected $api_password;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100)
	 */
	protected $api_url;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100)
	 */
	protected $logo_link;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=150)
	 */
	protected $home_url;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100)
	 */
	protected $token;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=150)
	 */
	protected $trade_url;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $campaign_id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $active;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	protected $streamer_url;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	protected $spotoption_broker_name;

    /**
     * @var string
     *
     * @ORM\Column(name="regulated_status", type="string", length=100)
     */
    protected $regulated_status;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Broker
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set display_name
     *
     * @param string $displayName
     * @return Broker
     */
    public function setDisplayName($displayName)
    {
        $this->display_name = $displayName;

        return $this;
    }

    /**
     * Get display_name
     *
     * @return string 
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Set reg_url
     *
     * @param string $regUrl
     * @return Broker
     */
    public function setRegUrl($regUrl)
    {
        $this->reg_url = $regUrl;

        return $this;
    }

    /**
     * Get reg_url
     *
     * @return string 
     */
    public function getRegUrl()
    {
        return $this->reg_url;
    }

    /**
     * Set login_url
     *
     * @param string $loginUrl
     * @return Broker
     */
    public function setLoginUrl($loginUrl)
    {
        $this->login_url = $loginUrl;

        return $this;
    }

    /**
     * Get login_url
     *
     * @return string 
     */
    public function getLoginUrl()
    {
        return $this->login_url;
    }

    /**
     * Set redirect_param
     *
     * @param string $redirectParam
     * @return Broker
     */
    public function setRedirectParam($redirectParam)
    {
        $this->redirect_param = $redirectParam;

        return $this;
    }

    /**
     * Get redirect_param
     *
     * @return string 
     */
    public function getRedirectParam()
    {
        return $this->redirect_param;
    }

    /**
     * Set thanku_url
     *
     * @param string $thankuUrl
     * @return Broker
     */
    public function setThankuUrl($thankuUrl)
    {
        $this->thanku_url = $thankuUrl;

        return $this;
    }

    /**
     * Get thanku_url
     *
     * @return string 
     */
    public function getThankuUrl()
    {
        return $this->thanku_url;
    }

    /**
     * Set deposit_url
     *
     * @param string $depositUrl
     * @return Broker
     */
    public function setDepositUrl($depositUrl)
    {
        $this->deposit_url = $depositUrl;

        return $this;
    }

    /**
     * Get deposit_url
     *
     * @return string 
     */
    public function getDepositUrl()
    {
        return $this->deposit_url;
    }

    /**
     * Set regulated
     *
     * @param integer $regulated
     * @return Broker
     */
    public function setRegulated($regulated)
    {
        $this->regulated = $regulated;

        return $this;
    }

    /**
     * Get regulated
     *
     * @return integer 
     */
    public function getRegulated()
    {
        return $this->regulated;
    }

    /**
     * Set regulated
     *
     * @param integer $regulated
     * @return Broker
     */
    public function setRegulatedStatus($regulated_status)
    {
        $this->regulated_status = $regulated_status;

        return $this;
    }

    /**
     * Get regulated
     *
     * @return integer
     */
    public function getRegulatedStatus()
    {
        return $this->regulated_status;
    }


    /**
     * Set captcha
     *
     * @param integer $captcha
     * @return Broker
     */
    public function setCaptcha($captcha)
    {
        $this->captcha = $captcha;

        return $this;
    }

    /**
     * Get captcha
     *
     * @return integer 
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }

    /**
     * Set limit_ip
     *
     * @param integer $limitIp
     * @return Broker
     */
    public function setLimitIp($limitIp)
    {
        $this->limit_ip = $limitIp;

        return $this;
    }

    /**
     * Get limit_ip
     *
     * @return integer 
     */
    public function getLimitIp()
    {
        return $this->limit_ip;
    }

    /**
     * Set bottom_injects
     *
     * @param string $bottomInjects
     * @return Broker
     */
    public function setBottomInjects($bottomInjects)
    {
        $this->bottom_injects = $bottomInjects;

        return $this;
    }

    /**
     * Get bottom_injects
     *
     * @return string 
     */
    public function getBottomInjects()
    {
        return $this->bottom_injects;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return Broker
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set api_username
     *
     * @param string $apiUsername
     * @return Broker
     */
    public function setApiUsername($apiUsername)
    {
        $this->api_username = $apiUsername;

        return $this;
    }

    /**
     * Get api_username
     *
     * @return string 
     */
    public function getApiUsername()
    {
        return $this->api_username;
    }

    /**
     * Set api_password
     *
     * @param string $apiPassword
     * @return Broker
     */
    public function setApiPassword($apiPassword)
    {
        $this->api_password = $apiPassword;

        return $this;
    }

    /**
     * Get api_password
     *
     * @return string 
     */
    public function getApiPassword()
    {
        return $this->api_password;
    }

    /**
     * Set api_url
     *
     * @param string $apiUrl
     * @return Broker
     */
    public function setApiUrl($apiUrl)
    {
        $this->api_url = $apiUrl;

        return $this;
    }

    /**
     * Get api_url
     *
     * @return string 
     */
    public function getApiUrl()
    {
        return $this->api_url;
    }

    /**
     * Set logo_link
     *
     * @param string $logoLink
     * @return Broker
     */
    public function setLogoLink($logoLink)
    {
        $this->logo_link = $logoLink;

        return $this;
    }

    /**
     * Get logo_link
     *
     * @return string 
     */
    public function getLogoLink()
    {
        return $this->logo_link;
    }

    /**
     * Set home_url
     *
     * @param string $homeUrl
     * @return Broker
     */
    public function setHomeUrl($homeUrl)
    {
        $this->home_url = $homeUrl;

        return $this;
    }

    /**
     * Get home_url
     *
     * @return string 
     */
    public function getHomeUrl()
    {
        return $this->home_url;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Broker
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set trade_url
     *
     * @param string $tradeUrl
     * @return Broker
     */
    public function setTradeUrl($tradeUrl)
    {
        $this->trade_url = $tradeUrl;

        return $this;
    }

    /**
     * Get trade_url
     *
     * @return string 
     */
    public function getTradeUrl()
    {
        return $this->trade_url;
    }

    /**
     * Set campaign_id
     *
     * @param integer $campaignId
     * @return Broker
     */
    public function setCampaignId($campaignId)
    {
        $this->campaign_id = $campaignId;

        return $this;
    }

    /**
     * Get campaign_id
     *
     * @return integer 
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Broker
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set streamer_url
     *
     * @param string $streamerUrl
     * @return Broker
     */
    public function setStreamerUrl($streamerUrl)
    {
        $this->streamer_url = $streamerUrl;

        return $this;
    }

    /**
     * Get streamer_url
     *
     * @return string 
     */
    public function getStreamerUrl()
    {
        return $this->streamer_url;
    }

    /**
     * Set spotoption_broker_name
     *
     * @param string $spotoptionBrokerName
     * @return Broker
     */
    public function setSpotoptionBrokerName($spotoptionBrokerName)
    {
        $this->spotoption_broker_name = $spotoptionBrokerName;

        return $this;
    }

    /**
     * Get spotoption_broker_name
     *
     * @return string 
     */
    public function getSpotoptionBrokerName()
    {
        return $this->spotoption_broker_name;
    }
}
