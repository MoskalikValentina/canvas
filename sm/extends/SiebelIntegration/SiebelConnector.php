<?php
/**
 * Use for connect to Siebel
 */

class SiebelConnector
{
    protected $host;
    protected $request_data;
    protected $integration_id;
    protected $instance;
    protected $region_integration_id;
    protected $trend_integration_id;

    /**
     * Init connection to Siebel
     * @param $host String Host URL
     * @param array $request_data Data for generation requests ti Siebel
     */
    public function __construct($host, Array $request_data, $integration_id, $instance, $region_integration_id, $trend_integration_id)
    {
        $this->host = $host;
        $this->request_data = $request_data;

        $this->integration_id = $integration_id;
        $this->instance = $instance;
        $this->region_integration_id = $region_integration_id;
        $this->trend_integration_id = $trend_integration_id;
    }

    /**
     * Send customer data to Siebel
     * Used flow4
     * @param array $request_data Data for generate request to Siebel
     */
    public function customerDataSend(Array $request_data = array())
    {
        if(count($request_data) === 0){
            $request_data = $this->request_data;
        }

        $xml_request = $this->flow4Prepare($request_data);
        $xml_wrapper = $this->wrapperPrepear('SendContact', 'ClientData', $request_data['integration_id'] . '_' . $request_data['id']  . '0');
        $respons = $this->sendRequest($xml_request, $xml_wrapper);

		if($respons){
	        $xml_resp = new SimpleXMLElement($respons);

	        if (isset($xml_resp->RESULT)){
	        	$customer_id = (string)$xml_resp->RESULT->RESPONSE->DATA->SiebelMessage->ListOfContactImport->Contact->Id;
	        	if($customer_id != ''){
	        		$this->request_data['contact_id'] = $customer_id;
	        		return $customer_id;
	        	} else {
	        		return false;
	        	}
	        } else {
	        	return false;
	        }
	     } else {
	     	return false;
	     }
    }

    /**
     * Send request data to Siebel
     * Used flow10
     * @param array $request_data Data for generate request to Siebel
     */
    public function requestDataSend(Array $request_data = array())
    {
        if(count($request_data) === 0){
            $request_data = $this->request_data;
        }

        if(!isset($request_data['contact_id'])){
        	return false;
        }

        $xml_request = $this->flow10Prepare($request_data);
        $xml_wrapper = $this->wrapperPrepear('SendOpty', '', $request_data['integration_id'] . '_' . $request_data['id'] . '1');
        $respons = $this->sendRequest($xml_request, $xml_wrapper);

        if($respons){
        	$xml_resp = new SimpleXMLElement($respons);

	        if (isset($xml_resp->RESULT)){
	        	$request_id = (string)$xml_resp->RESULT->RESPONSE->DATA->SiebelMessage->ListOfOpportunityImport->Opportunity->Id;
	        	if($request_id != ''){
	        		return $request_id;
	        	} else {
	        		return false;
	        	}
	        } else {
	        	return false;
	        }
        } else{
        	return false;
        }

    }

    /**
     * Send request to Siebel
     * @param string $xml_request XML with request to Siebel
     * @param string $xml_wrapper XML with wrapper for Siebel request
     *
     * @return string
     */
    protected function sendRequest($xml_request, $xml_wrapper){
        $xml = new SimpleXMLElement($xml_wrapper);
        $xml->COMMAND->REQUEST->DATA = $xml_request;
        $req_data = $xml->asXML();

        //Send request
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $req_data,
            CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 0,
            // CURLOPT_HEADER => true, //debug
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml; charset=utf-8'
            )
        ));
        $response = curl_exec($curl);
        $err = curl_errno($curl);
        //$errmsg  = curl_error($curl); //debug
        curl_close($curl);

        if($err != 0){
        // 	echo $err . '<br>'; //debug
        // 	echo $errmsg . '<br>'; //debug
        	return false;
        } else {

        	//echo $response; //debug

        	$resp = new SimpleXMLElement($response);

        	if(isset($resp->EXCEPTION)){
        		$error_code = (string)$resp->EXCEPTION->ERROR->CODE; //debug
        		$error_text = (string)$resp->EXCEPTION->ERROR->TEXT; //debug
        		//echo $error_code . '<br>' . $error_text; //debug
        		return false;
        	} elseif (isset($resp->RESULT)) {
        		return $response;
        	} else {
        		return false;
        	}
        }

    }

    /**
     * Prepare request for send in Siebel flow4
     * @param array $data Data for generate request body
     * @return String with request
     */
    protected function flow4Prepare(Array $data)
    {
        //Prepare data
        //$integration_id = isset($data['integration_id']) ? $data['integration_id'] : 'SM_integration';
        $first_name = isset($data['first_name']) ? $data['first_name'] : '';
        $last_name = isset($data['last_name']) ? $data['last_name'] : '';
        $phone = isset($data['phone']) ? $data['phone'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $comment = isset($data['comment']) ? $data['comment'] : '';
        $id =  isset($data['id']) ? $data['integration_id'] . '_' . $data['id'] . '0' : $data['integration_id'] . '0';
        $curr_date = new DateTime();
        $date = $curr_date->format('m/d/Y H:i:s');
        $brand_dms = $this->instance;

        //Prepare request
        $xml_data = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<SiebelMessage MessageType="Integration Object" IntObjectName="Contact Import" IntObjectFormat="Siebel Hierarchical">
    <ListOfContactImport>
        <Contact>
            <Id></Id>
            <IntegrationId>$id</IntegrationId>
            <FirstName>$first_name</FirstName>
            <LastName>$last_name</LastName>
            <HomePhone>$phone</HomePhone>
            <EmailAddress>$email</EmailAddress>
            <Description>$comment</Description>
            <PersonalUseService>Y</PersonalUseService>
            <CleansingStatus>На очистку</CleansingStatus>
            <ListOfDmsInstance>
                <DmsInstance>
                    <Instance>$brand_dms</Instance>
                </DmsInstance>
            </ListOfDmsInstance>
            <IntegrationUpdatedDate>$date</IntegrationUpdatedDate>
        </Contact>
    </ListOfContactImport>
</SiebelMessage>
XML;
        return $xml_data;
    }


    /**
     * Prepare request for send in Siebel flow10
     * @param array $data Data for generate request body
     * @return String with request
     */
    protected function flow10Prepare(Array $data)
    {

        //Prepare data
        //$integration_id = isset($data['integration_id']) ? $data['integration_id'] : 'SM_integration';
        $brand = isset($data['brand']) ? $data['brand'] : '';
        $brand_dms = strtoupper($brand);
        $model = isset($data['model']) ? $data['model'] : '';
        $comment = isset($data['comment']) ? $data['comment'] : '';
        $test_drive = isset($data['test_drive']) ? 'Y' : 'N';
        $credit = isset($data['credit']) ? 'Y' : 'N';
        $contact_id = $data['contact_id'];
        $id = $data['integration_id'] . '_' . $data['id'] . '1'; //Need for unic request
        $curr_date = new DateTime();
        $date = $curr_date->format('m/d/Y H:i:s');

        $integration_id = $this->integration_id;
        $region_integration_id = $this->region_integration_id;
        $trend_integration_id = $this->trend_integration_id;

        //Prepare request
        $xml_data = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<SiebelMessage MessageType="Integration Object" IntObjectName="Opportunity Import" IntObjectFormat="Siebel Hierarchical">
    <ListOfOpportunityImport>
        <Opportunity>
                <IntegrationId>$id</IntegrationId>
                <SalesMethod>Новые ТС</SalesMethod>
				<DocName>РабочийЛист</DocName>
				<Id></Id>
				<Name>$id</Name>
				<ListOfOpportunityContact>
					<OpportunityContact>
						<ContactId>$contact_id</ContactId>
						<IsPrimaryMVG>Y</IsPrimaryMVG>
					</OpportunityContact>
				</ListOfOpportunityContact>
				<Channel>Internet</Channel>
				<SourceTypeDyn>Internet</SourceTypeDyn>
				<Make>$brand</Make>
				<Model>$model</Model>
				<SecureFlag>$credit</SecureFlag>
				<HospitalityTemplateFlag>$test_drive</HospitalityTemplateFlag>
				<Overview>$comment</Overview>
				<IntegrationUpdatedDate>$date</IntegrationUpdatedDate>
				<StartDate>$date</StartDate>;
            	<ListOfOperations></ListOfOperations>
				<ListOfOpportunityOrganization>
					<OpportunityOrganization IsPrimaryMVG="Y">
						<RegionIntegrationId>$region_integration_id</RegionIntegrationId>
						<TrendIntegrationId>$trend_integration_id</TrendIntegrationId>
						<IntegrationId>$integration_id</IntegrationId>
					</OpportunityOrganization>
				</ListOfOpportunityOrganization>
        </Opportunity>
    </ListOfOpportunityImport>
</SiebelMessage>
XML;
        return $xml_data;
    }

    /**
     * Prepare wrapper for message
     *
     * @param string $name request type in Siebel
     * @param string $dtd
     * @param string $id Massage ID in Sibel. May be generate by us.
     *
     * @return string
     */
    protected function wrapperPrepear($name, $dtd = '', $id = ''){
        $xml_wrapper = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<MESSAGE DTD="XMLMSG" VERSION="1.0">
	<COMMAND>
		<REQUEST NAME="$name" VERSION="1" DTD="$dtd" ID="$id">
			<DATA>
			</DATA>
		</REQUEST>
	</COMMAND>
</MESSAGE>
XML;
        return $xml_wrapper;
    }
}