<?php

class SiebelIntegrationHelper {


    public function getIntegrationData($brand, $address){
        $w_brand = strtoupper(trim($brand));
        switch($w_brand){

            case 'FORD':
                $integration_id = 'IGC_FORD_MSK_PKRCHGN';
                $instance = 'FORD';
                $region_integration_id = 'IGC_FORD_MSK';
                $trend_integration_id = 'IGC_FORD';
                break;


            case 'JAGUAR':
                switch ($address){
                    case 'Ярославское шоссе, 27':
                        $integration_id = 'IGC_JAGUAR_MSK_YRSLVSK';
                        $instance = 'JAGUAR';
                        $region_integration_id = 'IGC_JAGUAR_MSK';
                        $trend_integration_id = 'IGC_JAGUAR';
                        break;

                    case 'Ленинградское шоссе, 71':
                        $integration_id = 'IGC_JAGUAR_MSK_PAG';
                        $instance = 'JAGUAR';
                        $region_integration_id = 'IGC_JAGUAR_MSK';
                        $trend_integration_id = 'IGC_JAGUAR';
                        break;

                    default:
                        return false;
                        break;
                }

                break;


            case 'LANDROVER' || 'LAND ROVER':
                switch ($address){
                    case 'Ярославское шоссе, 27':
                        $integration_id = 'IGC_LANDROVER_MSK_YRSLVSK';
                        $instance = 'LANDROVER';
                        $region_integration_id = 'IGC_LANDROVER_MSK';
                        $trend_integration_id = 'IGC_LANDROVER';
                        break;

                    case 'Ленинградское шоссе, 71':
                        $integration_id = 'IGC_LANDROVER_MSK_PAG';
                        $instance = 'LANDROVER';
                        $region_integration_id = 'IGC_LANDROVER_MSK';
                        $trend_integration_id = 'IGC_LANDROVER';
                        break;

                    default:
                        return false;
                        break;
                }
                break;

            case 'MAZDA':
                $integration_id = 'IGC_MAZDA_MSK_KSTKN';
                $instance = 'MAZDA';
                $region_integration_id = 'IGC_MAZDA_MSK';
                $trend_integration_id = 'IGC_MAZDA';
                break;

            case 'MITSUBISHI':
                $integration_id = 'IGC_MITSUBISHI_MSK_PKRVSK';
                $instance = 'MITSUBISHI';
                $region_integration_id = 'IGC_MITSUBISHI_MSK';
                $trend_integration_id = 'IGC_MITSUBISHI';
                break;

            case 'PEUGEOT':
                $integration_id = 'IGC_PEUGEOT_MSK_LENINGR29A';
                $instance = 'PEUGEOT';
                $region_integration_id = 'IGC_PEUGEOT_MSK';
                $trend_integration_id = 'IGC_PEUGEOT';
                break;

            case 'VOLVO':
                $integration_id = 'IGC_VOLVO_MSK_PAG';
                $instance = 'VOLVO';
                $region_integration_id = 'IGC_VOLVO_MSK';
                $trend_integration_id = 'IGC_VOLVO';
                break;

            case 'VW' || 'VOLKSWAGEN':
                $integration_id = 'IGC_VW_MSK_VW';
                $instance = 'VW';
                $region_integration_id = 'IGC_VW_MSK';
                $trend_integration_id = 'IGC_VW';
                break;

            case 'AUDI':
                $integration_id = 'IGC_AUDI_MSK_BRZHKVSK';
                $instance = 'AUDI';
                $region_integration_id = 'IGC_AUDI_MSK';
                $trend_integration_id = 'IGC_AUDI';
                break;

            default:
                return false;
        }

        return array(
            'integration_id' => $integration_id,
            'instance' => $instance,
            'region_integration_id' => $region_integration_id,
            'trend_integration_id' => $trend_integration_id,
        );
    }
} 