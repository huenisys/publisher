<?php

namespace huenisys\Publisher\Common;

interface InterfaceProcessor
{
    const DEFAULT_SCHEMA_NAMESPACE = "huenisys\\Publisher\\Schema\\";

    /**
     *
     * @return InterfaceSchema
     */
    public function getSchemaInstance();
}
