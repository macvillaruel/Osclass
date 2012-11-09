<?php

    /*
     *      OSCLass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2010 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    /**
    * Helper Locales
    * @package OSClass
    * @subpackage Helpers
    * @author OSClass
    */

    /**
     * Gets locale generic field
     *
     * @param $field
     * @param $locale
     * @return string
     */
    function osc_locale_field($field, $locale = '') {
        return osc_field(osc_locale(), $field, $locale) ;
    }

    /**
     * Gets locale object
     *
     * @return array
     */
    function osc_locale() {
        if (View::newInstance()->_exists('locales')) {
            $locale = View::newInstance()->_current('locales') ;
        } elseif (View::newInstance()->_exists('locale')) {
            $locale = View::newInstance()->_get('locale') ;
        } else {
            $locale = null ;
        }
        return($locale) ;
    }

    /**
     * Gets list of locales
     *
     * @return array
     */
    function osc_get_locales() {
        if (!View::newInstance()->_exists('locales')) {
            $locale = OSCLocale::newInstance()->listAllEnabled() ;
            View::newInstance()->_exportVariableToView("locales", $locale);
        } else {
            $locale = View::newInstance()->_get('locales');
        }
        return $locale;
    }

    /**
     * Private function to count locales
     *
     * @return boolean
     */
    function osc_priv_count_locales() {
        return View::newInstance()->_count('locales') ;
    }

    /**
     * Reset iterator of locales
     *
     * @return void
     */
    function osc_goto_first_locale() {
        View::newInstance()->_reset('locales') ;
    }

    /**
     * Gets number of enabled locales for website
     *
     * @return int
     */
    function osc_count_web_enabled_locales() {
        if ( !View::newInstance()->_exists('locales') ) {
            View::newInstance()->_exportVariableToView('locales', OSCLocale::newInstance()->listAllEnabled() ) ;
        }
        return osc_priv_count_locales() ;
    }

    /**
     * Iterator for enabled locales for website
     *
     * @return array
     */
    function osc_has_web_enabled_locales() {
        if ( !View::newInstance()->_exists('locales') ) {
            View::newInstance()->_exportVariableToView('locales', OSCLocale::newInstance()->listAllEnabled() ) ;
        }

        return View::newInstance()->_next('locales') ;
    }

    /**
     * Gets current locale's code
     *
     * @return string
     */
    function osc_locale_code() {
        return osc_locale_field("pk_c_code") ;
    }

    /**
     * Gets current locale's name
     *
     * @return string
     */
    function osc_locale_name() {
        return osc_locale_field("s_name") ;
    }

    /**
     * Gets current locale's currency format
     *
     * @return string
     */
    function osc_locale_currency_format() {
        $aLocales = osc_get_locales();
        $cLocale  = $aLocales[0];

        foreach($aLocales as $locale) {
            if($locale['pk_c_code'] == osc_current_user_locale()) {
                $cLocale = $locale;
                break;
            }
        }

        return $cLocale['s_currency_format'] ;
    }

    /**
     * Gets current locale's decimal point
     *
     * @return string
     */
    function osc_locale_dec_point() {
        $aLocales = osc_get_locales();
        $cLocale  = $aLocales[0];

        foreach($aLocales as $locale) {
            if($locale['pk_c_code'] == osc_current_user_locale()) {
                $cLocale = $locale;
                break;
            }
        }

        return $cLocale['s_dec_point'] ;
    }

    /**
     * Gets current locale's thousands separator
     *
     * @return string
     */
    function osc_locale_thousands_sep() {
        $aLocales = osc_get_locales();
        $cLocale  = $aLocales[0];

        foreach($aLocales as $locale) {
            if($locale['pk_c_code'] == osc_current_user_locale()) {
                $cLocale = $locale;
                break;
            }
        }

        return $cLocale['s_thousands_sep'] ;
    }

    /**
     * Gets current locale's number of decimals
     *
     * @return string
     */
    function osc_locale_num_dec() {
        $aLocales = osc_get_locales();
        $cLocale  = $aLocales[0];

        foreach($aLocales as $locale) {
            if($locale['pk_c_code'] == osc_current_user_locale()) {
                $cLocale = $locale;
                break;
            }
        }

        return $cLocale['i_num_dec'] ;
    }

    /**
     * Gets list of enabled locales
     *
     * @return array
     */
    function osc_all_enabled_locales_for_admin($indexed_by_pk = false) {
        return ( OSCLocale::newInstance()->listAllEnabled(true, $indexed_by_pk)) ;
    }

    /**
     * Gets current locale object
     *
     * @return array
     */
    function osc_get_current_user_locale() {
        View::newInstance()->_exportVariableToView('locale', OSCLocale::newInstance()->findByPrimaryKey(osc_current_user_locale()) ) ;
    }

    /**
     * Get the actual locale of the user.
     *
     * You get the right locale code. If an user is using the website in another language different of the default one, or
     * the user uses the default one, you'll get it.
     *
     * @return string Locale Code
     */
    function osc_current_user_locale( ) {
        if(Session::newInstance()->_get('userLocale') != '') {
            return Session::newInstance()->_get('userLocale') ;
        }

        return osc_language();
    }

    /**
     * Get the actual locale of the admin.
     *
     * You get the right locale code. If an admin is using the website in another language different of the default one, or
     * the admin uses the default one, you'll get it.
     *
     * @return string OSCLocale Code
     */
    function osc_current_admin_locale( ) {
        if(Session::newInstance()->_get('adminLocale') != '') {
            return Session::newInstance()->_get('adminLocale') ;
        }

        return osc_admin_language();
    }
?>