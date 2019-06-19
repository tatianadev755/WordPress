<?php
class or_subscriber{
	
	public function switch_responder( $apikey, $action, $responder ){
		switch($responder){
			case 'ConstantContact':
				return $this->ConstantContact( $apikey, $action );
			break;
			case 'Mailchimp':
				return $this->Mailchimp( $apikey, $action );
			break;
			case 'SendReach':
				return $this->SendReach( $apikey, $action );
			break;
			case 'iContact':
				return $this->iContact( $apikey, $action );
			break;
			/*case 'Infusionsoft':
				return $this->Infusionsoft( $apikey, $action );
			break;
			case 'Hubspot':
				return $this->Hubspot( $apikey, $action );
			break;*/
			case 'Aweber':
				return $this->Aweber( $apikey, $action, $responder );
			break;
			case 'GetResponse':
				return $this->GetResponse( $apikey, $action );
			break;
			case 'CampaignMonitor':
				return $this->CampaignMonitor( $apikey, $action );
			break;
			case 'GoToWebinar':
				return $this->GoToWebinar( $apikey, $action );
			break;
			case 'ActiveCampaign':
				return $this->ActiveCampaign( $apikey, $action );
			break;
			case 'Sendlane':
				return $this->Sendlane( $apikey, $action );
			break;
			case 'Mailpoet':
				return $this->Mailpoet( $apikey, $action );
			break;
			case 'Sendy':
				return $this->Sendy( $apikey, $action );
			break;
			case 'Sendinblue':
				return $this->Sendinblue( $apikey, $action );
			break;
			case 'Verticalresponse':
				return $this->Verticalresponse( $apikey, $action );
			break;
		}
	}
	
	public function Verticalresponse( $apikey, $action ){
		
		if($action == 'getList'){
			$access_token = $apikey['accesstoken'];
			$params = array('access_token'=>$access_token);
			$ch = curl_init();
			$url ='';
			if ($params)
			{
				$url =  ( strpos( $url, '?' ) ? '&' : '?' ) . http_build_query($params, '', '&');
			}

			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, 'https://vrapi.verticalresponse.com/api/v1/lists' . $url);
			$headers = array('Authorization: Bearer ' . $access_token);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$data = curl_exec($ch);
			curl_close($ch);
			$retvals = json_decode($data, true);

			$lists = array();

			if ($retvals){
				if(isset($retvals['items'])) {
					if(count($retvals['items']) > 0) {
						$list = array();
						foreach($retvals['items'] as $retval){
							$list[$retval['attributes']['id']] = $retval['attributes']['name'];
						}
						$result['list'] = $list;
					}else {
						$result = array('error'=>'Error occur may be somethig wrong.');
					}
				}else {
					$result = array('error'=>'Error occur may be somethig wrong.');
				}

			} else {
				$result = array('error'=>'Error occur may be somethig wrong.');
			}
		}
		
		if($action == 'subsCribe'){
			$Verticalresponse_accesstoken = $apikey['accesstoken'];

			$email = $_POST['email'];

			if (!empty($_POST['name'])){
				$fname = $_POST['name'];
			}else {
				$fname = '';
			}
			$listID = $_POST['listid'];

			try{

			   $postData = '';
			   $params = array('email'=>$email);
			   //create name value pairs seperated by &
			   foreach($params as $k => $v)
			   {
				  $postData .= $k . '='.$v.'&';
			   }
			   $postData = rtrim($postData, '&');

				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,'https://vrapi.verticalresponse.com/api/v1/lists/'.$listID.'/contacts');
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$headers = array('Authorization: Bearer ' . $Verticalresponse_accesstoken);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$data = curl_exec($ch);
				curl_close($ch);
				$data = json_decode($data, true);
				//print_r($data);
				if(isset($data['success'])){
					$result = array('success'=>'Subscribe successfully.');	
				}else{
					$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
				}

			} catch (Exception $e){
				$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
			}
		}
		
		return $result;
	}
	
	public function Sendinblue( $apikey, $action ){
		require_once or_PATH . '/subscriber/Sendinblue/Mailin.php';
		if($action == 'getList'){
			$key = $apikey['api_key'];
			
			$mailin = new Mailin('https://api.sendinblue.com/v2.0',$key);

			$data = array(
			  "page" => 1,
			  "page_limit" => 50
			);
			$retvals = $mailin->get_lists($data);
			
			if( $retvals['code'] == 'success' ) {
				if( count($retvals['data']['lists']) > 0 ) {
					$list = array();
					foreach($retvals['data']['lists'] as $retval){
						$list[$retval['id']] = $retval['name'];
					}
					$result['list'] = $list;
				}else {
					$result = array('error'=>'Error occur may be somethig wrong.');
				}
			}else {
				$result = array('error'=>'Error occur may be somethig wrong.');
			}
		}
		
		if($action == 'subsCribe'){
			$key = $apikey['api_key'];
			$listID = $_POST['listid'];
			$email = $_POST['email'];
			if (!empty($_POST['name'])){
				$fname = $_POST['name'];
			}else {
				$fname = '';
			}

			try{
				$mailin = new Mailin('https://api.sendinblue.com/v2.0',$key);

				try {

					$data = array( "email" => $email,
						"attributes" => array("NAME"=>$fname, "SURNAME"=>''),
						"listid" => array($listID)
					);

					$res = $mailin->create_update_user($data);
					$result = array('success'=>'Subscribe successfully.');	
				} catch(Emma_Invalid_Response_Exception $e) {
					$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
				}

			} catch (Exception $e){
				$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
			}
		}
		
		return $result;
	}
	
	public function Sendy( $apikey, $action ){
		if($action == 'getList'){
			$result['list'] = array($apikey['list_id'] => $apikey['list_nm']);
		}
		
		if($action == 'subsCribe'){
			$sendyapi = $apikey['api_key'];
			$sendyurl = 'http://domainname.com/codeapis/success/';
			$email = $_POST['email'];
			$listID = $_POST['listid'];

			if (!empty($_POST['name'])){
				$fname = $_POST['name'];
			}else {
				$fname = '';
			}
			require_once or_PATH . '/subscriber/Sendy/SendyPHP.php';
			$config = array(
				'api_key' => $sendyapi, //your API key is available in Settings
				'installation_url' => $sendyurl,  //Your Sendy installation
				'list_id' => $listID
			);
			try{
				$sendy = new \SendyPHP\SendyPHP($config);
				$result = $sendy->subscribe(array(
					'name'=>$fname,
					'email' => $email
				));
			}catch(Exception $e){
				return $e;
			}
			
			$result = array('success'=>'Subscribe successfully.');
		}
		
		return $result;
	}
	
	public function Mailpoet( $apikey, $action ){
		if($action == 'getList' && class_exists('WYSIJA')){
			$lists = $result = array();
			//this will return an array of results with the name and list_id of each mailing list
			$model_list = WYSIJA::get('list','model');
			$mailpoet_lists = $model_list->get(array('name','list_id'),array('is_enabled'=>1));
			 
			//this loop will just echo the information selected for each list
			if(!empty($mailpoet_lists)){
				foreach($mailpoet_lists as $list){
					$lists[$list['list_id']] = $list['name'];
				}
				$result['list'] = $lists;
			}else{
				$result = array('error'=>'Error occur may be somethig wrong.');
			}			
		}
		
		if($action === 'subsCribe'  && class_exists('WYSIJA')){
			$my_email_variable = $_POST['email'];
			$my_list_id1 = $_POST['listid'];
			
			if (!empty($_POST['name'])){
				$fname = $_POST['name'];
			}else {
				$fname = '';
			}
		 
			//in this array firstname and lastname are optional
			$user_data = array(
				'email' => $my_email_variable,
				'firstname' => $fname
			);
		 
			$data_subscriber = array(
			  'user' => $user_data,
			  'user_list' => array('list_ids' => array($my_list_id1))
			);
		 
			$helper_user = WYSIJA::get('user','helper');
			$helper_user->addSubscriber($data_subscriber);
			$result = array('success'=>'Subscribe successfully.');
		}else{
			$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
		}
		
		return $result;
	}
	
	public function Sendlane( $apikey, $action ){
		
		if($action == 'getList'){
			$url = $apikey['user_url'];
			$api = $url . '/api/v1/lists';

			$post = array(
				'api'    => $apikey['api_key'],
				'hash'   => $apikey['hash_key']
			);

			$data = "";
			foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
			$data = rtrim($data, '& ');

			$request = curl_init($api);
			curl_setopt($request, CURLOPT_HEADER, 0);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($request, CURLOPT_POSTFIELDS, $data);
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

			$response = (string)curl_exec($request);
			curl_close($request);


			if( $response == '' ) {
				$result = array('error'=>'Error occur may be somethig wrong.');
			}else {
				$result = json_decode($response);
				if( isset ($result->error) ) {
					$result = array('error'=>'Error occur may be somethig wrong.');
				}else {
					if ( !isset($result[0]->list_id)) {
						$result = array('error'=>'Error occur may be somethig wrong.');
					}else {
						$list = array();
						foreach ($result as $solo_list){
							$list_key = $solo_list->list_id;
							$list_name = $solo_list->list_name;
							$list[$list_key] = $list_name;
						}
						$result['list'] = $list;
					}
				}
			}
		}
		
		if($action === 'subsCribe'){
			$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
		
			$url = $apikey['user_url'];
			$api = $url . '/api/v1/list-subscribers-add';

			$email = $_POST['email'];
			$listID = $_POST['listid'];

			if (!empty($_POST['name'])){
				$fname = $_POST['name'];
			}else {
				$fname = '';
			}

			$post = array(
				'api'    => $apikey['api_key'],
				'hash'   => $apikey['hash_key'],
				'email'   => $fname.'<'.$email.'>',
				'list_id' => $listID
			);

			$data = "";
			foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
			$data = rtrim($data, '& ');

			$request = curl_init($api);
			curl_setopt($request, CURLOPT_HEADER, 0);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($request, CURLOPT_POSTFIELDS, $data);
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

			$response = (string)curl_exec($request);
			curl_close($request);

			if ($response != ''){
				$result = array('success'=>'Subscribe successfully.');
			}
		}
		
		return $result;
	}
	
	public function ActiveCampaign( $apikey, $action ){
		if($action === 'getList'){
			$url = $apikey['api_url'];
			$api_key = $apikey['api_key'];

			$params = array(

				'api_key'      => $api_key,
				'api_action'   => 'list_paginator',
				'api_output'   => 'json',
				'somethingthatwillneverbeused' => '',
				'sort' => '',
				'offset' => 0,
				'limit' => 20,
				'filter' => 0,
				'public' => 0,

			);

			$query = "";
			foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
			$query = rtrim($query, '& ');
			$url = rtrim($url, '/ ');

			if ( !function_exists('curl_init') ) { $result = array('error'=>'Error occur may be somethig wrong.'); }

			if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
				$result = array('error'=>'Error occur may be somethig wrong.');
			}
			$api = $url . '/admin/api.php?' . $query;

			$request = curl_init($api);
			curl_setopt($request, CURLOPT_HEADER, 0);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
			$response = (string)curl_exec($request);
			curl_close($request);

			if ( !$response ) {
			   $result = array('error'=>'Error occur may be somethig wrong.');
			}

			$results = json_decode($response);

			if( $results->result_code == 0 ) {
				$result = array('error'=>'Error occur may be somethig wrong.');
			}else {
				if ( $results->cnt == 0 ) {
					$result = array('error'=>'There is no list in your account.');
				}
				else {

					foreach ($results->rows as $solo_list){
						$list_key = $solo_list->id;
						$list_name = $solo_list->name;
						$list[$list_key] = $list_name;
					}
					$result['list'] = $list;
				}
			}
		}
		
		if($action === 'subsCribe'){
			$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
			$url = $apikey['api_url'];
			$api_key = $apikey['api_key'];
			$listID = $_POST['listid'];

			$params = array(
				'api_key'      => $api_key,
				'api_action'   => 'contact_add',
				'api_output'   => 'json'
			);

			if (!empty($_POST['name']))
			{
				$fname = $_POST['name'];
			}
			else {
				$fname = '';
			}

			$post = array(
				'email'                    => $_POST['email'],
				'first_name'               => $fname,
				'tags'                     => 'api',
				'p[1]'                   => $listID,
				'status[1]'              => 1,
				'instantresponders[123]' => 1
			);

			$query = "";
			foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
			$query = rtrim($query, '& ');

			$data = "";
			foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
			$data = rtrim($data, '& ');

			$url = rtrim($url, '/ ');

			$api = $url . '/admin/api.php?' . $query;

			$request = curl_init($api);
			curl_setopt($request, CURLOPT_HEADER, 0);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($request, CURLOPT_POSTFIELDS, $data);
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
			$response = (string)curl_exec($request);
			curl_close($request);

			if ( $response ) {
				$results = json_decode($response);
				if( $results->result_code != 0) {
					$result = array('success'=>'Subscribe successfully.');
				}
			}
		}
		
		return $result;
	}
	
	public function GoToWebinar( $apikey, $action ){
		require_once or_PATH . '/subscriber/GoToWebinar/citrix.php';
		
		if($action === 'getList'){
			$citrix = new Citrix($apikey['consumer_key']);
			$params = array();
			$params['consumer_key'] = $apikey['consumer_key'];
			$params['consumer_secret'] = $apikey['consumer_secret'];
			$params['user_id'] = $apikey['user_id'];
			$params['password'] = $apikey['password'];
			$organizer_key = '';
			
			if(!$organizer_key){

				$url = 'https://api.citrixonline.com/oauth/access_token?grant_type=password&user_id='.$params['user_id'].'&password='.$params['password'].'&client_id='.$params['consumer_key'];
				$results = file_get_contents($url);
				if($results){
					$res = json_decode($results,true);

					$citrix->set_organizer_key($res['organizer_key']);
					$citrix->set_access_token($res['access_token']);

					$webinars = $citrix->citrixonline_get_list_of_webinars(1) ;

					$webinar_list = array();

					if(!isset($webinars['upcoming']['webinars']['errorCode'])){
						
						foreach($webinars['upcoming']['webinars'] as $webinar){
							$list[$webinar['webinarID']] = $webinar['subject'];
						}
						$result['list'] = $list;

					}else{
						$result = array('error'=>'There is no list in your account.');
					}

				}else{
					$result = array('error'=>'Error occur may be somethig wrong.');
				}
				
			}
		}
		
		if($action === 'subsCribe'){
			$citrix = new Citrix($apikey['consumer_key']);
			$params = array();
			$params['consumer_key'] = $apikey['consumer_key'];
			$params['consumer_secret'] = $apikey['consumer_secret'];
			$params['user_id'] = $apikey['user_id'];
			$params['password'] = $apikey['password'];
			
			try{
				$email = $_POST['email'];
				if (!empty($_POST['name']['fname'])){
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
				}else {
					$fname = '';
					$lname = '';
				}
				$listID = $_POST['listid'];
				$response = $citrix->citrixonline_create_registrant_of_webinar( $listID, array('first_name' => $fname, 'last_name' => $lname, 'email'=>$email));
				
				$result = array('success'=>'Subscribe successfully.');

			}catch (Exception $e) {
				$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
			}
		}
		
		return $result;
	}
	
	public function CampaignMonitor( $apikey, $action ){
		
		if($action === 'getList'){
			require_once or_PATH . '/subscriber/CampaignMonitor/csrest_clients.php';
			$list = array();

			$wrap = new CS_REST_Clients($apikey["client_id"], $apikey["api_key"]);
			$cm_res = $wrap->get_lists();

			if ($cm_res->http_status_code != '200'){
				$result = array('error'=>'Error occur may be somethig wrong.');
			}else{

				if( count($cm_res->response) != 0 ){

					foreach ($cm_res->response as $solo_list){
						$list[$solo_list->ListID] = $solo_list->Name;
					}
					$result['list'] = $list;
					
				}
				else {
					$result = array('error'=>'There is no list in your account.');
				}

			}
		}
		
		if($action == 'subsCribe'){
			require_once or_PATH . '/subscriber/CampaignMonitor/csrest_subscribers.php';
			$key = $apikey["api_key"];
			$listID = $_POST['listid'];

			if(!empty($listID)){
				$wrap = new CS_REST_Subscribers($listID, $key);
			}

			$args = array(
				'EmailAddress' => $_POST['email'],
				'Resubscribe' => true
			);

			if (!empty($_POST['name'])){
				$args['name'] = $_POST['name'];
			}

			$res = $wrap->add($args);
			
			$result = array('success'=>'Subscribe successfully.');
		}
		
		return $result;
	}
	
	public function GetResponse( $apikey, $action ){
		
		require_once or_PATH . '/subscriber/GetResponse/jsonRPCClient.php';
		
		if($action === 'getList'){
			$list = array();
			
			$api = new jsonRPCClient('http://api2.getresponse.com');
			try{
				$results = $api->get_campaigns($apikey["api_key"]);
				if( count($results) > 0 ) {

					foreach ($results as $k => $v){
						$list[$k] = $v['name'];
					}
					$result['list'] = $list;
				}else {
					$result = array('error'=>'There is no list in your account.'); // When no list found
				}
			}catch (Exception $e){
			   $result = array('error'=>'Error occur may be somethig wrong.'); // Invalid API key
			}
		}
		
		if($action == 'subsCribe'){
			$api = new jsonRPCClient('http://api2.getresponse.com');
			try{
				$listID = $_POST['listid'];
				if(!empty($listID)){
					$args = array(
						'campaign' => $listID,
						'email' => $_POST['email'],
						'cycle_day'=>0,
					);
				}

				if (!empty($_POST['name'])){
					$args['name'] = $_POST['name'];
				}

				$api->add_contact($apikey["api_key"], $args);
				
				$result = array('success'=>'Subscribe successfully.');

			}catch (Exception $e){ 
				//$result = $e;
				$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
			}
		}
		
		return $result;
		
	}
	
	public function Aweber( $apikey, $action, $responder ){
		
		require_once or_PATH . '/subscriber/Aweber/aweber_api.php';
		
		if(isset($apikey['access_secret'])){
			$consumer_key = $apikey['consumer_key'];
			$consumer_secret = $apikey['consumer_secret']; 
			$access_key = $apikey['access_key']; 
			$access_secret = $apikey['access_secret'];
		}
		
		if($action === 'getList'){
			$list = array();

			$descr = '';
			if(!isset($apikey['access_secret'])){
				try{
					list($consumer_key, $consumer_secret, $access_key, $access_secret) = AWeberAPI::getDataFromAweberID($apikey['aweber_code']);
				}catch (AWeberAPIException $exc){
					list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
					if(isset($exc->message))
					{
						$descr = $exc->message;
						$descr = preg_replace('/http.*$/i', '', $descr);	 # strip labs.aweber.com documentation url from error message
						$descr = preg_replace('/[\.\!:]+.*$/i', '', $descr); # strip anything following a . : or ! character
						$descr = '('.$descr.')';

					}
				}catch (AWeberOAuthDataMissing $exc){
					list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
				}catch (AWeberException $exc){
					list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
				}
			}

			if (!$access_secret){
				$result = array('error'=>'Error occur may be somethig wrong.');
			}else{
				$aweber = new AWeberAPI($consumer_key, $consumer_secret);
				$account = $aweber->getAccount($access_key, $access_secret);
				$aweber_result = $account->lists;
				if( $aweber_result->data['total_size'] != '' && $aweber_result->data['total_size'] != 0 ){
					foreach ($aweber_result->data['entries'] as $solo_list){
						$list[$solo_list['id']] = $solo_list['name'];
					}
					$result['list'] = $list;
				}else {
					$result = array('error'=>'There is no list in your account.');
				}
				
				if(!isset($apikey['access_secret'])){
					$data = get_option('or_subscriber_settings');
					$api = $data[$responder];
					
					$data[$responder] = array(
						'aweber_code' => $api['aweber_code'],
						'consumer_key' => $consumer_key,
						'consumer_secret' => $consumer_secret,
						'access_key' => $access_key,
						'access_secret' => $access_secret
					);
					
					update_option('or_subscriber_settings', $data);
				}
				
			}
		}
		
		if($action == 'subsCribe'){
			try{

				$email = $_POST['email'];
				$listID = $_POST['listid'];

				$aweber = new AWeberAPI($consumer_key, $consumer_secret);

				$account = $aweber->getAccount($access_key, $access_secret);

				$aweber_list = $listID;
				$list = $account->loadFromUrl('/accounts/' . $account->id . '/lists/' . $aweber_list);

				$subscriber = array(
					'email' => $email,
					'ip' => $_SERVER['REMOTE_ADDR']
				);

				if (!empty($_POST['name'])){
					$subscriber['name'] = $_POST['name'];
				}else {
					$fname = '';
				}

				$list->subscribers->create($subscriber);
				
				$result = array('success'=>'Subscribe successfully.');

			}catch (AWeberException $e){
				$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
			}
		}
		
		return $result;
	}
	
	public function iContact( $apikey, $action ){
		require_once  or_PATH . '/subscriber/iContact/iContactApi.php';
		
		$list = $result = array();
		
		if($action === 'getList'){
			iContactApi::getInstance()->setConfig(array(
				'appId' => $apikey['app_id'],
				'apiPassword' => $apikey['app_password'],
				'apiUsername' => $apikey['login_email']
			));
			$oiContact = iContactApi::getInstance();
			
			try{
				$icontact_res = $oiContact->getLists();

				if( count($icontact_res) > 0 ) {
					foreach ($icontact_res as $solo_list){
						$list[$solo_list->listId] = $solo_list->name;
					}
				}else{
					$result = array('error'=>'There is no list in your account.');
				}

			}catch (Exception $oException){
				$result = array('error'=>'Error occur may be somethig wrong.');
			}
			
			$result['list'] = $list;
		}
		
		if($action == 'subsCribe'){
			$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
			
			iContactApi::getInstance()->setConfig(array(
				'appId' => $apikey['app_id'],
				'apiPassword' => $apikey['app_password'],
				'apiUsername' => $apikey['login_email']
			));
			
			$email = $_POST['email'];
			$listID = $_POST['listid'];
			$oiContact = iContactApi::getInstance();

			if (!empty($_POST['name'])){
				$fname = $_POST['name'];
			}else {
				$fname = '';
			}

			$res1 = $oiContact->addContact($email, null, null, $fname , '' , null, null, null, null, null, null, null, null, null);
			if ($res1->contactId){
				if ($oiContact->subscribeContactToList($res1->contactId, $listID, 'normal')){
					$result = array('success'=>'Subscribe successfully.');
				}
			}
		}
		
		return $result;
	}
	
	public function SendReach( $apikey, $action ){
		$result = array();
		define('publicKey',$apikey['public_key']);
		define('privateKey',$apikey['private_key']);
		
		require_once  or_PATH.'/subscriber/SendReach/setup.php';
		
		if($action === 'getList'){
			$endpoint = new MailWizzApi_Endpoint_Lists();

			$response = $endpoint->getLists($pageNumber = 1, $perPage = 10);
			$body = $response->body;
			
			$list = array();
			$bool = false;

			foreach($body as $key=>$val) {
				if( $val != 'success' ) {
					if( $val['count'] > 0 ) {

						foreach( $val['records'] as $solo_rec ) {
							$list[$solo_rec['general']['list_uid']] = $solo_rec['general']['name'];
							$bool = true;
						}
						
					}
				}
			}
			
			if($bool == true){
				$result['list'] = $list;
			}else{
				$result = array('error'=>'There is no list in your account.');
			}			
		}
		
		if($action == 'subsCribe'){

			$email = $_POST['email'];
			$listID = $_POST['listid'];
			$fname = '';
			if (!empty($_POST['name'])){
				$fname = $_POST['name'];
			}
			$endpoint   = new MailWizzApi_Endpoint_ListSubscribers();
			$response   = $endpoint->create($listID, array(
				'EMAIL' => $email,
				'FNAME' => $fname,
				'LNAME' => '',
			));
			$response   = $response->body;

			if ($response->itemAt('status') == 'success') {
				$result = array('success'=>'Subscribe successfully.');
			}
		}
		
		return $result;
	}
	
	public function ConstantContact( $apikey, $action ){
		require_once  or_PATH.'/subscriber/ConstantContact/class.cc.php';
		
		if($action === 'getList'){
			$cc = new cc($apikey['username'], $apikey['password']);

            $resultofcc = $cc->get_lists('lists');

            if ($resultofcc){
				
				if( count($resultofcc) > 0  ){
					
					foreach($resultofcc as $v){
						$list[$v['id']] = $v['Name'];
					}
					
					$result['list'] = $list;
					
				}else{
					$result = array('error'=>'There is no list in your account.');
				}
				
			}else{
				$result = array('error'=>'Error occur may be somethig wrong.');
			}
			
			return $result;
		}
		
		if($action == 'subsCribe'){
			$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
			$cc = new cc($apikey['username'], $apikey['password']);
			
			$email = $_POST['email'];
			$listID = $_POST['listid'];

			$contact_list = $_POST['listid'];
			$extra_fields = array();
			if (!empty($_POST['name'])){
				$extra_fields['FirstName'] = $_POST['name'];
			}

			$contact = $cc->query_contacts($email);
			//print_r($_POST);			
			if (!$contact){
				//print_r($_POST);
				$new_id = $cc->create_contact($email, $contact_list, $extra_fields);
				if ($new_id){
					$result = array('success'=>'Subscribe successfully.');
				}
			}
			
			return $result;
		}
	}
	
	public function Mailchimp( $apikey, $action ){
		
		require_once  or_PATH.'/subscriber/Mailchimp/MCAPI.class.php';
		
		if($action === 'getList'){
			$key = $apikey['api_key'];
			
			$api = new MCAPI( $key );
			$retval = $api->lists();
			
			if (!$api->errorCode){
				if($retval['data'] != 0){
					foreach ($retval['data'] as $v){
						$list[$v['id']] = $v['name'];
					}
					
					$result['list'] = $list;
					
				}else{
					$result = array('error'=>'There is no list in your account.');
				}
			}else{
				$result = array('error'=>'Error occur may be somethig wrong.');
			}
			
			return $result;
		}
		
		if($action == 'subsCribe'){
			$key = $apikey['api_key'];
			
			$api = new MCAPI( $key );
			
			$listID = $_POST['listid'];
			
			//print_r($_POST);
			if($_POST['name']){
				$args = array('FNAME' => $_POST['name']);
			}else{
				$args = array();
			}
			
			if(!empty($listID)){
				$api->listSubscribe($listID, $_POST['email'], $args );
			}
			
			if ($api->errorCode == ''){
				$result = array('success'=>'Thank you, please check your email.');
			}elseif($api->errorCode == 214){
				$result = array('success'=>'This email already subscribe.');
			}else{
				$result = array('error'=>'Subscribe unsuccessfully, please contact administrator for more information.');
			}
			
			return $result;
			
		}
		
	}
}