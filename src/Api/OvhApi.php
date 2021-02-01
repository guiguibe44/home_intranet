<?php


namespace App\Api;


use App\Entity\Domain;
use Ovh\Api;

class OvhApi
{
    private $ovh_app_key;
    private $ovh_app_secret;
    private $ovh_consumerkey;
    private $ovh_nichandle = 'bg23862-ovh';

    public function __construct($ovh_app_key,$ovh_app_secret,$ovh_consumerkey)
    {
        $this->ovh_app_key = $ovh_app_key;
        $this->ovh_app_secret = $ovh_app_secret;
        $this->ovh_consumerkey = $ovh_consumerkey;
    }

    /*
     * Domains
     */

    function getAllDomains(){
        $domainInfos = array();
        $ovh = new Api( $this->ovh_app_key, $this->ovh_app_secret,'ovh-eu', $this->ovh_consumerkey);
        //get all domains
        $allDomainsInfos = array();
        $allDomains = $ovh->get('/hosting/web');
        foreach ($allDomains as $domain){
            $result = $ovh->get('/hosting/web/'.$domain.'/serviceInfos');
            $domainInfos['domain'] = $result['domain'];
            $domainInfos[$result['domain']]['expiration'] =$result['expiration'];
        }
        return $domainInfos;
    }
    function getAttachedDomain($serviceName){
        $ovh = new Api( $this->ovh_app_key,  // Application Key
            $this->ovh_app_secret,  // Application Secret
            'ovh-eu',      // Endpoint of API OVH Europe (List of available endpoints)
            $this->ovh_consumerkey); // Consumer Key
        //$domains = $ovh->get('/hosting/web');
        $result = $ovh->get('/hosting/web/attachedDomain', array(
            'domain' => $serviceName, // Domain used into web hosting attached Domains (type: string)
        ));
        return $result;

    }
    function getAttachedDomains($serviceName){
        $ovh = new Api( $this->ovh_app_key,  // Application Key
            $this->ovh_app_secret,  // Application Secret
            'ovh-eu',      // Endpoint of API OVH Europe (List of available endpoints)
            $this->ovh_consumerkey); // Consumer Key
        //$domains = $ovh->get('/hosting/web');
        $result = $ovh->get('/hosting/web/'.$serviceName.'/attachedDomain');
        /*$result = $ovh->get('/hosting/web/attachedDomain', array(
            'domain' => $serviceName, // Domain used into web hosting attached Domains (type: string)
        ));*/
        return $result;

    }
    function getInfoDomain($serviceName){
        $ovh = new Api( $this->ovh_app_key,$this->ovh_app_secret,'ovh-eu',$this->ovh_consumerkey);
        $infoDomain = $ovh->get('/hosting/web/' . $serviceName);
        return $infoDomain;
    }
    function getInfoDomainName($serviceName){
        $ovh = new Api( $this->ovh_app_key,$this->ovh_app_secret,'ovh-eu',$this->ovh_consumerkey);
        try {
            $infoDomain = $ovh->get('/domain/'.$serviceName.'/serviceInfos');
        } catch (\Exception $exception) {
            if($exception->getCode() == 404) {
                //echo 'Domaine inconnu';
                $infoDomain = false;
            }
        }
        return $infoDomain;
    }
    function updateDomainExpiration($domain){
        $ovh = new Api( $this->ovh_app_key,$this->ovh_app_secret,'ovh-eu',$this->ovh_consumerkey);
        $update = false;
        try {
            $infoDomain = $ovh->get('/domain/'.$domain->getName().'/serviceInfos');
            $expirationDate = $infoDomain['expiration'];
            //update expiration date
            if($expirationDate){
                $update = $expirationDate;
            }

        } catch (\Exception $exception) {
            if($exception->getCode() == 404) {
                //echo 'Domaine inconnu';
                $infoDomain = false;
            }
        }
        return $update;
    }
    function updateDomainInformation($entityManager){
        $ovh = new Api( $this->ovh_app_key,$this->ovh_app_secret,'ovh-eu',$this->ovh_consumerkey);
        //get all domains
        $domainRepository = $entityManager->getRepository(Domain::class);
        $domains = $domainRepository->findAll();
        foreach ($domains as $domain) {
            try {
                $infoDomain = $ovh->get('/domain/' . $domain->getName() . '/serviceInfos');
                $expirationDate = $infoDomain['expiration'];
                if($expirationDate!=false) {
                    $date = \DateTime::createFromFormat('Y-m-d', $expirationDate);
                    $domain->setExpireAt($date);
                    $entityManager->persist($domain);
                    $entityManager->flush();
                }
            } catch (\Exception $exception) {
                if ($exception->getCode() == 404) {
                    $infoDomain = false;
                }
            }
        }
    }
    function updateAllDomains($entityManager){
        $ovh = new Api( $this->ovh_app_key, $this->ovh_app_secret,'ovh-eu', $this->ovh_consumerkey);
        $domains = $ovh->get('/domain', array(
            'whoisOwner' => NULL, // Filter the value of whoisOwner property (=) (type: string)
        ));
        foreach ($domains as $domain){
            $date = \DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
            $dom = (new Domain())->setName($domain);
            //$dom->setMain(false);
            //$dom->setExpireAt($date);
            // do a lookup for existing domain matching some combination of fields
            $domainName = $entityManager->getRepository(Domain::class)->findOneBy([
                'name' => $dom->getName()
            ]);
            if ($domainName == null) {
                $dom->setMain(false);
                $entityManager->persist($dom);
                $entityManager->flush();
            }
        }

        //return $domains;
    }




}