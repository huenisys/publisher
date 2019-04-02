<?php

namespace huenisys\Publisher\Common;

trait TraitProcessorConfigurables
{
    public static $altSchemaNamespace = "App\\Publisher\\Schema\\";

    public static $fallbackSchemaClass = Article::class;
}
