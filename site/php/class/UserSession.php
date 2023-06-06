<?php
class UserSession
{
    const _session_key = 'seds505_project';
    private $_site_user;

    public function __construct($restart_if_expired = true)
    {
        header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
        session_start();
        $this->_initSession();

        // check session expiration - begin
        if (!isset($_SESSION[self::_session_key]['site_user'])){
            $this->setSiteUser(new SiteUser());
        }
        else{
            $this->_site_user = $_SESSION[self::_session_key]['site_user'];
        }
        if ($this->getSiteUser()->is_logged_in == true && isset($_SESSION[self::_session_key]['last_request_time']))
        {
            if ($_SESSION[self::_session_key]['last_request_time'] + SESSION_LIFETIME < time())
            {
                //invalid session
                if ($restart_if_expired == true){
                    @session_destroy();
                    $this->_initSession();
                }
            }
        }
        $_SESSION[self::_session_key]['last_request_time'] = time();
        // check session expiration - end

        if (!isset($_SESSION[self::_session_key]['site_user'])){
            $this->setSiteUser(new SiteUser());
        }
        else{
            $this->_site_user = $_SESSION[self::_session_key]['site_user'];
        }
    }

    private function _initSession(){
        if (!isset($_SESSION[self::_session_key])){
            $_SESSION[self::_session_key] = array();
        }
    }

    /**
     * @return SiteUser
     */
    public function getSiteUser()
    {
        return $this->_site_user;
    }

    /**
     * @param SiteUser $site_user
     */
    public function setSiteUser($site_user)
    {
        $this->_site_user = $site_user;
        $_SESSION[self::_session_key]['site_user'] = $site_user;
    }

    /**
     * @param bool $skipChecks
     *
     * @return bool
     */
    public function isSiteUserLoggedIn($skipChecks = false){
        $siteUser = $this->getSiteUser();
        if ($skipChecks === false && $siteUser->is_limited === true){
            return false;
        }
        return $siteUser->is_logged_in;
    }

    /**
     * @return bool
     */
    public function logoutSiteUser(){
        $this->setSiteUser(new SiteUser());
        return true;
    }


}