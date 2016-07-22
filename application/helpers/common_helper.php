<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Common functions helper
 * 
 * @author Sandi Anjar Maulana
 */

/*==-- Success message --==*/
if (!function_exists('success_message')) {
    function success_message($message, $redirect = NULL) {
        $msg = '<div class="alert alert-success bg-green-jungle" style="display: block;"><button data-dismiss="alert" class="close"><i class="icon-remove"></i></button>
                ' . $message . '
                </div>';
        if ($redirect != NULL) {
            $msg .= '<script>$("html, body").animate({ scrollTop: 0 }, 600); setTimeout("window.location=\'' . site_url($redirect) . '\'",1000)</script>';
        } else {
            $msg .= '<script>$("html, body").animate({ scrollTop: 0 }, 600);</script>';
        }
        return $msg;
    }
}

/*==-- Error message --==*/
if (!function_exists('error_message')) {
    function error_message($message) {
        $msg = '<div class="alert alert-danger" style="display: block;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
                <span class="alert-icon"><i class="fa fa-exclamation-circle red"></i></span>' . $message . '</div>';
        $msg .= '<script>$("html, body").animate({ scrollTop: 0 }, 600);</script>';
        return $msg;
    }
}

/*==-- Ajax redirect --==*/
if (!function_exists('ajax_redirect')) {
    function ajax_redirect($redirect = '', $timer = 0) {
        if ($timer == 0) {
            return '<script>window.location.href="' . site_url($redirect) . '";</script>';
        } else {
            return '<script>setTimeout("window.location.href=\'' . site_url($redirect) . '\'",' . $timer . ');</script>';
        }
    }
}
