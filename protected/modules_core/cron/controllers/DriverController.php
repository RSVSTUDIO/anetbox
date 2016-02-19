<?php

class DriverController extends Controller
{
    
    const SLEEP = 5;

    private $date_start;
    private $date_end;

    /**
     * Cron run
     * @example /index.php?r=cron/driver
     */
    public function actionIndex()
    {
        ini_set('max_execution_time', (60 * 60 * 3));

        //set date (yesterday)
        $this->date_start = $this->date_end = (new DateTime('NOW'))->modify('-1 day')->format('d.m.Y');

        $this->cronAdmitAd();
        $this->cronGoogleAdSense();
        $this->cronYandexHtmlParser();
        $this->cronTeaserNetHtmlParser();
        $this->cronActionTeaserHtmlParser();
        $this->cronDirectAdvert();
        $this->cronLitresHtmlParser();

        die('done!');
    }

    private function cronAdmitAd()
    {
        $driver = new DriverAdmitAd();
        $instrument = UserInstruments::model()->findByAttributes(['driver' => get_class($driver)]);

        if (isset($instrument->id)) {
            //get sites
            $usiArr = UserSiteInstruments::model()->getRows([
                'instrument_id' => $instrument->id,
                'cron' => UserSiteInstruments::cronActionYes
            ]);

            foreach ($usiArr as $usi) {
                if (isset($usi['usi_id']) && !empty($usi['login']) && !empty($usi['password'])) {
                    $driver
                        ->setUsiId($usi['usi_id'])
                        ->setApiID($usi['login'])
                        ->setApiKEY($usi['password']);

                    //get data
                    $res = $driver->get($this->date_start, $this->date_end, $usi['site_url']);

                    if (isset($res['views'])) {
                        //save data
                        $driver->save($usi['site_id'], $usi['instrument_id'], $res);
                    }
                    
                    sleep(self::SLEEP);
                                        
                    //get referral data
                    $res = $driver->getReferral($this->date_start, $this->date_end);
                    
                    if (is_array($res)) {
                        //save referral data
                        $driver->saveReferral($usi['site_id'], $usi['instrument_id'], $res);
                    }
                }
            }
        }
        
        sleep(self::SLEEP);
    }

    private function cronYandexMetrika()
    {
        $driver = new DriverYandexMetrika();
        $instrument = UserInstruments::model()->findByAttributes(['driver' => get_class($driver)]);

        if (isset($instrument->id)) {
            //get sites
            $usiArr = UserSiteInstruments::model()->getRows([
                'instrument_id' => $instrument->id,
                'cron' => UserSiteInstruments::cronActionYes
            ]);

            foreach ($usiArr as $usi) {
                if (isset($usi['usi_id']) && !empty($usi['login']) && !empty($usi['password'])) {
                    $driver
                        ->setUsiId($usi['usi_id'])
                        ->setlogin($usi['login'])
                        ->setToken($usi['password']);
                    
                    //TODO: стандартное API не выдает нужных данных
                    //get data
                    $res = $driver->get($this->date_start, $this->date_end, $usi['site_url']);

                    if (isset($res['totals'])) {
                        //save data
                        $driver->save($usi['site_id'], $usi['instrument_id'], $res['totals']);
                    }
                }
            }
        }
        
        sleep(self::SLEEP);
    }

    private function cronYandexHtmlParser()
    {
        $driver = new DriverYandexHtmlParser();
        $instrument = UserInstruments::model()->findByAttributes(['driver' => get_class($driver)]);

        if (isset($instrument->id)) {
            //get sites
            $usiArr = UserSiteInstruments::model()->getRows([
                'instrument_id' => $instrument->id,
                'cron' => UserSiteInstruments::cronActionYes
            ]);

            foreach ($usiArr as $usi) {
                if (isset($usi['usi_id']) && !empty($usi['login']) && !empty($usi['password'])) {
                    $driver
                        ->setUsiId($usi['usi_id'])
                        ->setlogin($usi['login'])
                        ->setToken($usi['password']);

                    //get data
                    $res = $driver->get($this->date_start, $this->date_end, $usi['site_url']);

                    if (is_array($res)) {                        
                        //save data
                        $driver->save($usi['site_id'], $usi['instrument_id'], $res);
                    }
                }
            }
        }
        
        sleep(self::SLEEP);
    }

    private function cronGoogleAdSense()
    {
        $driver = new DriverGoogleAdSense();
        $instrument = UserInstruments::model()->findByAttributes(['driver' => get_class($driver)]);

        if (isset($instrument->id)) {
            //get sites
            $usiArr = UserSiteInstruments::model()->getRows([
                'instrument_id' => $instrument->id,
                'cron' => UserSiteInstruments::cronActionYes
            ]);

            foreach ($usiArr as $usi) {
                if (isset($usi['usi_id']) && !empty($usi['login']) && !empty($usi['password'])) {
                    $driver
                        ->setUsiId($usi['usi_id'])
                        ->setlogin($usi['login'])
                        ->setCode($usi['password'])
                        ->setToken($usi['api_data']);

                    //get data
                    $res = $driver->get($this->date_start, $this->date_end, $usi['site_url']);
                    $res = reset($res);

                    if (!empty($res)) {                        
                        //save data
                        $driver->save($usi['site_id'], $usi['instrument_id'], $res);
                    }
                }
            }
        }
        
        sleep(self::SLEEP);
    }

    private function cronTeaserNetHtmlParser()
    {
        $driver = new DriverTeaserNET();
        $instrument = UserInstruments::model()->findByAttributes(['driver' => get_class($driver)]);

        if (isset($instrument->id)) {
            //get sites
            $usiArr = UserSiteInstruments::model()->getRows([
                'instrument_id' => $instrument->id,
                'cron' => UserSiteInstruments::cronActionYes
            ]);

            foreach ($usiArr as $usi) {
                if (isset($usi['usi_id']) && !empty($usi['login'])) {
                    $driver
                        ->setUsiId($usi['usi_id'])
                        ->setlogin($usi['login']);

                    //get data
                    $res = $driver->get($this->date_start, $this->date_end, $usi['site_url']);
                    
                    if (is_array($res)) {
                        //save data
                        $driver->save($usi['site_id'], $usi['instrument_id'], $res);
                    }
                    
                    sleep(self::SLEEP);
                                        
                    //get referral data
                    $res = $driver->getReferral($this->date_start, $this->date_end);
                    
                    if (is_array($res)) {
                        //save referral data
                        $driver->saveReferral($usi['site_id'], $usi['instrument_id'], $res);
                    }
                }
            }
        }
        
        sleep(self::SLEEP);
    }

    private function cronActionTeaser()
    {
        $driver = new DriverActionTeaser();
        $instrument = UserInstruments::model()->findByAttributes(['driver' => get_class($driver)]);

        if (isset($instrument->id)) {
            //get sites
            $usiArr = UserSiteInstruments::model()->getRows([
                'instrument_id' => $instrument->id,
                'cron' => UserSiteInstruments::cronActionYes
            ]);

            foreach ($usiArr as $usi) {
                if (isset($usi['usi_id']) && !empty($usi['login'])) {
                    $driver
                        ->setUsiId($usi['usi_id'])
                        ->setSiteId($usi['login'])
                        ->setApiKey($usi['password']);

                    //get data
                    $res = $driver->get($this->date_start, $this->date_end);
                    
                    if (is_array($res)) {
                        //save data
                        $driver->save($usi['site_id'], $usi['instrument_id'], $res);
                    }
                    
                    sleep(self::SLEEP);
                                        
                    //get referral data
                    $res = $driver->getReferral($this->date_start, $this->date_end);
                    
                    if (is_array($res)) {
                        //save referral data
                        $driver->saveReferral($usi['site_id'], $usi['instrument_id'], $res);
                    }
                }
            }
        }
        
        sleep(self::SLEEP);
    }

    private function cronActionTeaserHtmlParser()
    {
        $driver = new DriverActionTeaserHtmlParser();
        $instrument = UserInstruments::model()->findByAttributes(['driver' => get_class($driver)]);
        
        if (isset($instrument->id)) {
            //get sites
            $usiArr = UserSiteInstruments::model()->getRows([
                'instrument_id' => $instrument->id,
                'cron' => UserSiteInstruments::cronActionYes
            ]);

            foreach ($usiArr as $usi) {
                if (isset($usi['usi_id']) && !empty($usi['login'])) {
                    $driver
                        ->setUsiId($usi['usi_id'])
                        ->setLogin($usi['login']);

                    //get data
                    $res = $driver->get($this->date_start, $this->date_end, $usi['site_url']);
                    
                    if (is_array($res)) {
                        //save data
                        $driver->save($usi['site_id'], $usi['instrument_id'], $res);
                    }
                    
                    sleep(self::SLEEP);
                                        
                    //get referral data
                    $res = $driver->getReferral();
                    
                    if (is_array($res)) {
                        //save referral data
                        $driver->saveReferral($usi['site_id'], $usi['instrument_id'], $res);
                    }
                }
            }
        }
        
        sleep(self::SLEEP);
    }

    private function cronDirectAdvert()
    {
        $driver = new DriverDirectAdvert();
        $instrument = UserInstruments::model()->findByAttributes(['driver' => get_class($driver)]);

        if (isset($instrument->id)) {
            //get sites
            $usiArr = UserSiteInstruments::model()->getRows([
                'instrument_id' => $instrument->id,
                'cron' => UserSiteInstruments::cronActionYes
            ]);

            foreach ($usiArr as $usi) {
                if (isset($usi['usi_id']) && !empty($usi['login'])) {
                    $driver
                        ->setUsiId($usi['usi_id'])
                        ->setlogin($usi['login'])
                        ->setPassword($usi['password']);

                    //get data
                    $res = $driver->get($this->date_start, $this->date_end, $usi['site_url']);
                    
                    if (is_array($res)) {
                        //save data
                        $driver->save($usi['user_id'], $usi['site_id'], $usi['instrument_id'], $res);
                    }
                    
                    sleep(self::SLEEP);
                                        
                    //get referral data
                    $res = $driver->getReferral($this->date_start, $this->date_end);
                    
                    if (is_array($res)) {
                        //save referral data
                        $driver->saveReferral($usi['site_id'], $usi['instrument_id'], $res);
                    }
                }
            }
        }
        
        sleep(self::SLEEP);
    }

    private function cronLitresHtmlParser()
    {
        $driver = new DriverLitresHtmlParser();
        $instrument = UserInstruments::model()->findByAttributes(['driver' => get_class($driver)]);

        if (isset($instrument->id)) {
            //get sites
            $usiArr = UserSiteInstruments::model()->getRows([
                'instrument_id' => $instrument->id,
                'cron' => UserSiteInstruments::cronActionYes
            ]);

            foreach ($usiArr as $usi) {
                if (isset($usi['usi_id']) && !empty($usi['login'])) {
                    $driver
                        ->setUsiId($usi['usi_id'])
                        ->setlogin($usi['login']);

                    //get data
                    $res = $driver->get($this->date_start, $this->date_end);
                    
                    if (is_array($res)) {
                        //save data
                        $driver->save($usi['user_id'], $usi['site_id'], $usi['instrument_id'], $res);
                    }
                }
            }
        }
        
        sleep(self::SLEEP);
    }

}
