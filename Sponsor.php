<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Sponsor
 * @package App\Models
 * @version July 30, 2019, 1:53 am UTC
 *
 * @property string name
 * @property string home_page_link
 * @property string login_page_link
 * @property string username
 * @property string password
 * @property string affiliate_number
 * @property string api_url_campaign
 * @property string api_url_reporting
 * @property string api_key
 * @property string api_driver
 * @property string auto_login_driver
 * @property string description
 * @property string link_template
 * @property integer status
 */
class Sponsor extends Model
{

    public $table = 'sponsors';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'home_page_link',
        'login_page_link',
        'username',
        'password',
        'affiliate_number',
        'api_url_campaign',
        'api_url_reporting',
        'api_key',
        'api_driver',
        'auto_login_driver',
        'description',
        'link_template',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'home_page_link' => 'string',
        'login_page_link' => 'string',
        'username' => 'string',
        'password' => 'string',
        'api_url_campaign' => 'string',
        'api_url_reporting' => 'string',
        'api_key' => 'string',
        'api_driver' => 'string',
        'affiliate_number' => 'string',
        'auto_login_driver' => 'string',
        'description' => 'string',
        'link_template' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|min:5',
        'affiliate_number' => 'required|string',
        'status' => 'required|integer'
    ];
    
    
    public static $sponsors_templates = [
        [
            'id' => "1",
            'name' => "Cx3 ads",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://publisher.cx3ads.com/affiliates/api",
            'api_url_reporting' => "https://publisher.cx3ads.com/affiliates/api",
            'api_driver' => "cortex-cake",
            'login_page_link' => "https://publisher.cx3ads.com/",
            'home_page_link' => "https://publisher.cx3ads.com/",
            'auto_login_driver' => "cake",
            'link_template' => "[user]&s2=[offer]-[campaign]&s3=[list]-[email]-[interface]",
        ],
        [
            'id' => "3",
            'name' => "Lola leads",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://lolaleadsmarketing.com/affiliates/api",
            'api_url_reporting' => "https://lolaleadsmarketing.com/affiliates/api",
            'api_driver' => "cortex-cake",
            'login_page_link' => "https://lolaleadsmarketing.com/?ReturnUrl=%2flogin",
            'home_page_link' => "https://lolaleadsmarketing.com/?ReturnUrl=%2flogin",
            'auto_login_driver' => "cake",
            'link_template' => "[user]&s2=[offer]-[campaign]&s3=[list]-[email]-[interface]",
        ],
        [
            'id' => "4",
            'name' => "Global wide media",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://gwm2.api.hasoffers.com/Apiv3/json",
            'api_url_reporting' => "https://gwm2.api.hasoffers.com/Apiv3/json",
            'api_driver' => "cortex-hasoffers",
            'login_page_link' => "https://performance2.globalwidemedia.com/",
            'home_page_link' => "https://performance2.globalwidemedia.com/",
            'auto_login_driver' => "hasoffers",
            'link_template' => "&aff_sub=[user]&aff_sub2=[offer]-[campaign]&aff_sub3=[list]-[email]-[interface]",
        ],
        [
            'id' => "5",
            'name' => "Load smooth",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://partner.loadsmooth.com/api",
            'api_url_reporting' => "https://partner.loadsmooth.com/api",
            'api_driver' => "cortex-hitpath2",
            'login_page_link' => "https://partner.loadsmooth.com/login",
            'home_page_link' => "https://partner.loadsmooth.com/login",
            'auto_login_driver' => "hitpath",
            'link_template' => "/[user]/[offer]-[campaign]/[list]-[email]-[interface]",
        ],
        [
            'id' => "6",
            'name' => "W4",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://w4api.com/pub/",
            'api_url_reporting' => "https://w4api.com/pub/",
            'api_driver' => "cortex-w4",
            'login_page_link' => "#none",
            'home_page_link' => "#none",
            'auto_login_driver' => "none",
            'link_template' => "&sid1=[user]&sid2=[offer]-[campaign]&sid3=[list]-[email]-[interface]",
        ],
        [
            'id' => "7",
            'name' => "iDrive",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://partner.rembrow.com/api",
            'api_url_reporting' => "https://partner.rembrow.com/api",
            'api_driver' => "cortex-hitpath2",
            'login_page_link' => "https://partner.rembrow.com/login",
            'home_page_link' => "https://partner.rembrow.com/login",
            'auto_login_driver' => "hitpath",
            'link_template' => "/[user]/[offer]-[campaign]/[list]-[email]-[interface]",
        ],
        [
            'id' => "8",
            'name' => "Bizaglo",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://api.eflow.team/v1/affiliates/offers/",
            'api_url_reporting' => "https://api.eflow.team/v1/affiliates/reporting/",
            'api_driver' => "cortex-everflow",
            'login_page_link' => "https://platform.bizaglo.com/",
            'home_page_link' => "https://platform.bizaglo.com/",
            'auto_login_driver' => "everflow",
            'link_template' => "?sub1=[user]&sub2=[offer]-[campaign]&sub3=[list]-[email]-[interface]",
        ],
        [
            'id' => "9",
            'name' => "Madrivo",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://partner.midenity.com/api",
            'api_url_reporting' => "https://partner.midenity.com/api",
            'api_driver' => "cortex-hitpath2",
            'login_page_link' => "https://partner.midenity.com/login",
            'home_page_link' => "https://partner.midenity.com/login",
            'auto_login_driver' => "hitpath",
            'link_template' => "/[user]/[offer]-[campaign]/[list]-[email]-[interface]",
        ],
        [
            'id' => "10",
            'name' => "B2Direct",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://b2directpartners.com/affiliates/api",
            'api_url_reporting' => "https://b2directpartners.com/affiliates/api",
            'api_driver' => "cortex-cake",
            'login_page_link' => "https://b2direct.everflowclient.io/",
            'home_page_link' => "https://b2direct.everflowclient.io/",
            'auto_login_driver' => "cake",
            'link_template' => "[user]&s2=[offer]-[campaign]&s3=[list]-[email]-[interface]",
        ],
        [
            'id' => "11",
            'name' => "All Everflow Platforms",
            'auto_l_s' => "none",
            'api_url_campaign' => "https://api.eflow.team/v1/affiliates/offers/",
            'api_url_reporting' => "https://api.eflow.team/v1/affiliates/reporting/",
            'api_driver' => "cortex-everflow",
            'login_page_link' => "#none",
            'home_page_link' => "#none",
            'auto_login_driver' => "none",
            'link_template' => "?sub1=[user]&sub2=[offer]-[campaign]&sub3=[list]-[email]-[interface]",
        ],
        [
            'id' => "12",
            'name' => "AdSurf Network",
            'auto_l_s' => "yes",
            'api_url_campaign' => "https://partner.adsurfnetwork.com/api",
            'api_url_reporting' => "https://partner.adsurfnetwork.com/api",
            'api_driver' => "cortex-hitpath2",
            'login_page_link' => "https://partner.adsurfnetwork.com/login",
            'home_page_link' => "https://partner.adsurfnetwork.com/login",
            'auto_login_driver' => "hitpath",
            'link_template' => "/[user]/[offer]-[campaign]/[list]-[email]-[interface]",
        ],
        [
            'id' => "13",
            'name' => "Gasmobi",
            'auto_l_s' => "none",
            'api_url_campaign' => "http://api.gasmobi.com",
            'api_url_reporting' => "http://api.gasmobi.com",
            'api_driver' => "cortex-gasmobi",
            'login_page_link' => "#none",
            'home_page_link' => "#none",
            'auto_login_driver' => "none",
            'link_template' => "?Subid=[user]&sub_pubid=[offer]-[campaign]_[list]-[email]-[interface]",
        ],
        [
            'id' => "14",
            'name' => "ClickDealer",
            'auto_l_s' => "none",
            'api_url_campaign' => "https://partners.clickdealer.com",
            'api_url_reporting' => "https://partners.clickdealer.com",
            'api_driver' => "cortex-clickdealer",
            'login_page_link' => "#none",
            'home_page_link' => "#none",
            'auto_login_driver' => "none",
            'link_template' => "&s1=[user]&s2=[offer]-[campaign]&s3=[list]-[email]-[interface]",
        ],
        [
            'id' => "15",
            'name' => "LeadsDivision (Affise)",
            'auto_l_s' => "none",
            'api_url_campaign' => "https://api-leadsdivision.affise.com",
            'api_url_reporting' => "https://api-leadsdivision.affise.com",
            'api_driver' => "cortex-affise",
            'login_page_link' => "#none",
            'home_page_link' => "#none",
            'auto_login_driver' => "none",
            'link_template' => "&sub1=[user]&sub2=[offer]-[campaign]&sub3=[list]-[email]-[interface]",
        ],
        [
            'id' => "16",
            'name' => "ProfityAds",
            'auto_l_s' => "none",
            'api_url_campaign' => "https://dashboard.profityads.com/affiliates/api",
            'api_url_reporting' => "https://dashboard.profityads.com/affiliates/api",
            'api_driver' => "cortex-cake",
            'login_page_link' => "#none",
            'home_page_link' => "#none",
            'auto_login_driver' => "none",
            'link_template' => "[user]&s2=[offer]-[campaign]&s3=[list]-[email]-[interface]",
        ],
        [
            'id' => "17",
            'name' => "VipResponse",
            'auto_l_s' => "none",
            'api_url_campaign' => "https://api.viprsp.nl/api",
            'api_url_reporting' => "https://api.viprsp.nl/api",
            'api_driver' => "cortex-vipresponse",
            'login_page_link' => "#none",
            'home_page_link' => "#none",
            'auto_login_driver' => "none",
            'link_template' => "&sub_id1=[user]&sub_id2=[offer]-[campaign]&sub_id3=[list]-[email]-[interface]",
        ]
    ];   

    /**
     *
     */
    public function offers()
    {
        return $this->hasMany(\App\Models\Offer::class);
    }
    
    public function getSponsorsTemplates()
    {
        return self::$sponsors_templates;
    }
    
    public function getSponsorTemplate($id)
    {
        foreach(self::$sponsors_templates as $template){
            if($template['id'] == $id)
                return $template;
        }
        
        return null;
    }
    
}
