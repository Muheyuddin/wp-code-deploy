<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkProAuth' ) ) {

	class NetlinkProAuth {
		
		private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
			add_filter ( 'theme_page_templates', array( $this, 'netlink_auth_template_attribute' ) );
			add_filter ( 'template_include', array( $this, 'netlink_registration_template' ) );

			$this->load_modules();
			$this->frontend();

			add_action('wp_ajax_netlink_pro_register_user_front_end', array( $this, 'netlink_pro_register_user_front_end', 0 ) );
			add_action('wp_ajax_nopriv_netlink_pro_register_user_front_end', array( $this, 'netlink_pro_register_user_front_end' ) );

			add_action('user_register', array( $this, 'netlink_pro_registration_mail' ) );
        }

		/**
		 * Add Custom Templates to page template array
		*/
		function netlink_auth_template_attribute($templates) {
			$templates = array_merge($templates, array(
				'tpl-registration.php' => esc_html__('Registration Page Template', 'netlink-pro') ,
			));
			return $templates;
		}

		/**
		 * Include Custom Templates page from plugin
		*/
		function netlink_registration_template($template){

			global $post;
			$id = $post->ID;
			$file = get_post_meta($post->ID, '_wp_page_template', true);
			if ('tpl-registration.php' == $file){
				$template = NETLINK_PRO_DIR_PATH . 'modules/auth/templates/tpl-registration.php';
			}
			return $template;

		}

		function load_modules() {
			include_once NETLINK_PRO_DIR_PATH.'modules/auth/customizer/index.php';
		}

		function frontend() {
			add_action( 'netlink_after_main_css', array( $this, 'enqueue_css_assets' ), 30 );
			add_action( 'netlink_before_enqueue_js', array( $this, 'enqueue_js_assets' ) );
		}

		function enqueue_css_assets() {
			wp_enqueue_style( 'netlink-pro-auth', NETLINK_PRO_DIR_URL . 'modules/auth/assets/css/style.css', false, NETLINK_PRO_VERSION, 'all');
		}

		function enqueue_js_assets() {
			wp_enqueue_script( 'netlink-pro-auth', NETLINK_PRO_DIR_URL . 'modules/auth/assets/js/script.js', array(), NETLINK_PRO_VERSION, true );
		}

		/**
		 * User Registration Save Data
		 */

		function netlink_pro_register_user_front_end() {

			$first_name = isset( $_POST['first_name'] ) ? netlink_sanitization($_POST['first_name']) : '';
			$last_name  = isset( $_POST['last_name'] )  ? netlink_sanitization($_POST['last_name'])  : '';
			$password   = isset( $_POST['password'] )   ? netlink_sanitization($_POST['password'] )  : '';
			$user_name  = isset( $_POST['user_name'] )  ? netlink_sanitization($_POST['user_name'])  : '';
			$user_email = isset( $_POST['user_email'] ) ? netlink_sanitization($_POST['user_email']) : '';

			$user = array(
				'user_login'  =>  $user_name,
				'user_email'  =>  $user_email,
				'user_pass'   =>  $password,
				'first_name'  =>  $first_name,
				'last_name'   =>  $last_name
			);

			$result = wp_insert_user( $user );
			if (!is_wp_error($result)) {
					echo 'We have Created an account for you.';
					netlink_pro_registration_mail($user_id);
			} else {
				if (isset($result->errors['empty_user_login']) &&  (isset($result->errors['empty_user_email']))){
					echo 'User Name and Email are required';
				} elseif (isset($result->errors['existing_user_login'])) {
					echo 'User name already exixts.';
				} else {
					echo 'Something Went Wrong.';
				}
			}

		}
		
		function netlink_pro_registration_mail($user_id , $user_name , $password ) {

			$netlink_pro_user = get_userdata($user_id);
			$netlink_pro_user_email = $netlink_pro_user->netlink_pro_user_email;

			// email will send registers
			$netlink_pro_to = $netlink_pro_user_email;
			$netlink_pro_subject = "Hi";
			$netlink_pro_body = '
						<p>
						We have successfully registered you as a Student.
						Username ='.$user_name.';
						Password ='.$password .';
						</p>
			';
			$netlink_pro_headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($netlink_pro_to, $netlink_pro_subject, $netlink_pro_body, $netlink_pro_headers);

		}

	}

	add_action( 'wp_ajax_netlink_pro_show_login_form_popup', 'netlink_pro_show_login_form_popup' );
	add_action( 'wp_ajax_nopriv_netlink_pro_show_login_form_popup', 'netlink_pro_show_login_form_popup' );
	function netlink_pro_show_login_form_popup() {
		echo netlink_pro_login_form();

		die();
	}

	// Login form
	if(!function_exists('netlink_pro_login_form')) {
		function netlink_pro_login_form() {

			$out = '<div class="netlink-pro-login-form-container">';

				$out .= '<div class="netlink-pro-login-form">';

					$out .= '<div class="netlink-pro-login-form-holder">';

					$my_login_args = apply_filters( 'login_form_defaults', array(
						'echo'           => false,
						'redirect'       => get_permalink( wc_get_page_id( 'myaccount' ) ),
						// 'redirect'       => site_url( $_SERVER['REQUEST_URI'] ), 
						'form_id'        => 'loginform',
						'label_username' => '',
						'label_password' => '',
						'label_remember' => esc_html__( 'Remember Me' ),
						'label_log_in'   => esc_html__( 'Sign In' ),
						'id_username'    => 'user_login',
						'id_password'    => 'user_pass',
						'id_remember'    => 'rememberme',
						'id_submit'      => 'wp-submit',
						'remember'       => true,
						'value_username' => NULL,
						'value_remember' => false
					) );
										
						$out .= '<div class="netlink-pro-title netlink-pro-login-title"><h2><span class="netlink-pro-login-title"><strong>'.esc_html__('Welcome Back', 'netlink-pro').'</strong></span></h2><span class="netlink-pro-login-description">'.esc_html__('Please enter your login credentials to access your account.', 'netlink-pro').'</span></div>';
						$out .= wp_login_form( $my_login_args );
						$out .= '<p class="tpl-forget-pwd"><a href="'.wp_lostpassword_url( get_permalink() ).'">'.esc_html__('Forgot password ?','netlink-pro').'</a></p>';

					$out .= '</div>';

					$social_logins = (netlink_customizer_settings( 'enable_social_logins' ) !== null) && !empty(netlink_customizer_settings( 'enable_social_logins' )) ? netlink_customizer_settings( 'enable_social_logins' ) : 0;
					$enable_facebook_login = (netlink_customizer_settings( 'enable_facebook_login' ) !== null) && !empty(netlink_customizer_settings( 'enable_facebook_login' )) ? netlink_customizer_settings( 'enable_facebook_login' ) : 0;
					$facebook_app_id = (netlink_customizer_settings( 'facebook_app_id' ) !== null) && !empty(netlink_customizer_settings( 'facebook_app_id' )) ? netlink_customizer_settings( 'facebook_app_id' ) : '';
					$facebook_app_secret = (netlink_customizer_settings( 'facebook_app_secret' ) !== null) && !empty(netlink_customizer_settings( 'facebook_app_secret' )) ? netlink_customizer_settings( 'facebook_app_secret' ) : '';
					$enable_google_login = (netlink_customizer_settings( 'enable_google_login' ) !== null) && !empty( netlink_customizer_settings( 'enable_google_login' ) ) ? netlink_customizer_settings( 'enable_google_login' ) : 0;

					if( $social_logins ) {
						if( $enable_facebook_login || $enable_google_login ) {
							$out .= '<div class="netlink-pro-social-logins-container">';
								$out .= '<div class="netlink-pro-social-logins-divider">'.esc_html__('Or Login With', 'netlink-pro').'</div>';
								if($enable_facebook_login) {
									if(!session_id()) {
										session_start();
									}

									include_once NETLINK_PRO_DIR_PATH.'modules/auth/apis/facebook/Facebook/autoload.php';

									$appId     = $facebook_app_id; //Facebook App ID
									$appSecret = $facebook_app_secret; // Facebook App Secret
	
									$fb = new Facebook\Facebook([
										'app_id' => $appId,
										'app_secret' => $appSecret,
										'default_graph_version' => 'v2.10',
									]);
	
									$helper = $fb->getRedirectLoginHelper();
									$permissions = ['email'];
									$loginUrl = $helper->getLoginUrl( site_url('wp-login.php') . '?dtLMSFacebookLogin=1', $permissions);
	
									$out .= '<a href="'.htmlspecialchars($loginUrl).'" class="netlink-pro-social-facebook-connect"><i class="fab fa-facebook-f"></i>'.esc_html__('Facebook', 'netlink-pro').'</a>';
								}
								if($enable_google_login) {
									$out .= '<a href="'.netlink_pro_google_login_url().'" class="netlink-pro-social-google-connect"><i class="fab fa-google"></i>'.esc_html__('Google', 'netlink-pro').'</a>';
								}
	
							$out .= '</div>';
	
						}
					}

				$out .= '</div>';

			$out .= '</div>';

			$out .= '<div class="netlink-pro-login-form-overlay"></div>';

			return $out;

		}
	}

	/* ---------------------------------------------------------------------------
	* Google login utils
	* --------------------------------------------------------------------------- */

	if( !function_exists( 'netlink_pro_google_login_url' ) ) {
		function netlink_pro_google_login_url() {
			return site_url('wp-login.php') . '?dtLMSGoogleLogin=1';
		}
	}

	function netlink_pro_google_login() {

		$dtLMSGoogleLogin = isset($_REQUEST['dtLMSGoogleLogin']) ? netlink_sanitization($_REQUEST['dtLMSGoogleLogin']) : '';
		if ($dtLMSGoogleLogin == '1') {
			netlink_pro_google_login_action();
		}
	
	}
	add_action('login_init', 'netlink_pro_google_login');

	if( !function_exists('netlink_pro_google_login_action') ) {
		function netlink_pro_google_login_action() {

			require_once NETLINK_PRO_DIR_URL.'modules/auth/apis/google/Google_Client.php';
			require_once NETLINK_PRO_DIR_URL.'modules/auth/apis/google/contrib/Google_Oauth2Service.php';
			
			$google_client_id = (netlink_customizer_settings( 'google_client_id' ) !== null) && !empty(netlink_customizer_settings( 'google_client_id' )) ? netlink_customizer_settings( 'google_client_id' ) : '';
			$google_client_secret = (netlink_customizer_settings( 'google_client_secret' ) !== null) && !empty(netlink_customizer_settings( 'google_client_secret' )) ? netlink_customizer_settings( 'google_client_secret' ) : '';

			$clientId     = $google_client_id; //Google CLIENT ID
			$clientSecret = $google_client_secret; //Google CLIENT SECRET
			$redirectUrl  = netlink_pro_google_login_url();  //return url (url to script)
		
			$gClient = new Google_Client();
			$gClient->setApplicationName(esc_html__('Login To Website', 'netlink-pro'));
			$gClient->setClientId($clientId);
			$gClient->setClientSecret($clientSecret);
			$gClient->setRedirectUri($redirectUrl);
		
			$google_oauthV2 = new Google_Oauth2Service($gClient);
		
			if(isset($google_oauthV2)){
		
				$gClient->authenticate();
				$_SESSION['token'] = $gClient->getAccessToken();
		
				if (isset($_SESSION['token'])) {
					$gClient->setAccessToken($_SESSION['token']);
				}
		
				$user_profile = $google_oauthV2->userinfo->get();
		
				$args = array(
					'meta_key'     => 'google_id',
					'meta_value'   => $user_profile['id'],
					'meta_compare' => '=',
				 );
				$users = get_users( $args );
		
				if(is_array($users) && !empty($users)) {
					$ID = $users[0]->data->ID;
				} else {
					$ID = NULL;
				}
		
				if ($ID == NULL) {
		
					if (!isset($user_profile['email'])) {
						$user_profile['email'] = $user_profile['id'] . '@gmail.com';
					}
		
					$random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
		
					$username = strtolower($user_profile['name']);
					$username = trim(str_replace(' ', '', $username));
		
					$sanitized_user_login = sanitize_user('google-'.$username);
		
					if (!validate_username($sanitized_user_login)) {
						$sanitized_user_login = sanitize_user('google-' . $user_profile['id']);
					}
		
					$defaul_user_name = $sanitized_user_login;
					$i = 1;
					while (username_exists($sanitized_user_login)) {
					  $sanitized_user_login = $defaul_user_name . $i;
					  $i++;
					}
		
					$ID = wp_create_user($sanitized_user_login, $random_password, $user_profile['email']);
		
					if (!is_wp_error($ID)) {
		
						wp_new_user_notification($ID, $random_password);
						$user_info = get_userdata($ID);
						wp_update_user(array(
							'ID' => $ID,
							'display_name' => $user_profile['name'],
							'first_name' => $user_profile['name'],
						));
		
						update_user_meta($ID, 'google_id', $user_profile['id']);
		
					}
		
				}
		
				// Login
				if ($ID) {
		
				  $secure_cookie = is_ssl();
				  $secure_cookie = apply_filters('secure_signon_cookie', $secure_cookie, array());
				  global $auth_secure_cookie;
		
				  $auth_secure_cookie = $secure_cookie;
				  wp_set_auth_cookie($ID, false, $secure_cookie);
				  $user_info = get_userdata($ID);
				  update_user_meta($ID, 'google_profile_picture', $user_profile['picture']);
				  do_action('wp_login', $user_info->user_login, $user_info, 10, 2);
				  update_user_meta($ID, 'google_user_access_token', $_SESSION['token']);
		
				//   wp_redirect(netlink_pro_get_login_redirect_url($user_info));
				wp_redirect(home_url());
		
				}
		
			} else {
		
				$authUrl = $gClient->createAuthUrl();
				header('Location: ' . $authUrl);
				exit;
		
			}
		
		}
	}

	/* if( !function_exists( 'netlink_pro_get_login_redirect_url' ) ) {
		function netlink_pro_get_login_redirect_url($user_info) {

			$dtlms_redirect_url = '';
			if(isset($user_info->data->ID)) {
				$current_user = $user_info;

			}

		}
	} */

}

NetlinkProAuth::instance();