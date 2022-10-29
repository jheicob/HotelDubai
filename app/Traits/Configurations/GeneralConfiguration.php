<?php

namespace App\Traits\Configurations;

use App\Models\Configuration;

trait GeneralConfiguration
{

    /**
     * get model Configuration
     *
     * @return Configuration
     */
    protected function getGeneralConfiguration()
    {
        $config = Configuration::first();

        if ($config == '') {
            throw new \Exception('No existen configuraciones');
        }
        return $config;
    }

    /**
     * get env for configuration model
     * @return string
     */
    public function getEnv(): string
    {
        return $this->getGeneralConfiguration()->env;
    }

    /**
     * get fiscal machine serial for configuration model
     * @return string
     */
    public function getFiscalMachineSerial()
    {
        return $this->getGeneralConfiguration()->fiscal_machine_serial;
    }
}
