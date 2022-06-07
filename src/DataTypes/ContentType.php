<?php

namespace Actengage\Capture\DataTypes;

enum ContentType: string
{
    case JSON = 'application/json';
    case Plain = 'text/plain';
}